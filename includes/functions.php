<?php

function trrc_get_public_post_types() {
	$args = array(
		'public'   => true,
	 );
	return get_post_types($args); 
}

function trrc_get_role_names() {
	global $wp_roles;
	if (!isset( $wp_roles)) {
		$wp_roles = new WP_Roles();
	}
	$roles = [];
	foreach ($wp_roles->roles as $k => $r) {
		$caps = $r['capabilities'];
		if( ( isset($caps['edit_posts']) && $caps['edit_posts'] ) || ( isset($caps['moderate_comments']) && $caps['moderate_comments'] ) ) {
			continue;
		}
		$roles[] = $k;
	}
	return $roles;
}


function trrc_comments_clauses( $clauses ){

	remove_filter( 'comments_clauses', 'trrc_comments_clauses' );

	$post_type = get_post_type( get_the_ID() );

	if(TRRC_POST_TYPES && is_array(TRRC_POST_TYPES) && !in_array($post_type,TRRC_POST_TYPES)) {
        return $clauses;
    }

	$user = wp_get_current_user();
    if(!$user) {
		//no soup...comments for you, visitor!
        return;
    }
	$user_id = $user->ID;

    if(current_user_can( 'edit_posts' ) && current_user_can( 'moderate_comments' )) {
        return $clauses;
    }

	$user_roles = (array) $user->roles;

	if ( TRRC_ROLES_EXCEPTED && is_array(TRRC_ROLES_EXCEPTED) && count(array_intersect($user_roles, TRRC_ROLES_EXCEPTED ) ) ) {
		return $clauses;
	}

	$substring = "AND comment_parent = 0";
	if (strpos($clauses['where'], $substring) === false) {
		//seeking for replies...return fast
		return $clauses;
	}

	//Query for the comments on the first level. Time to do the magic...
	$clauses['where'] = str_replace("comment_approved = '1'", "user_id = $user_id AND comment_approved = '1'", $clauses['where']);
	
	// var_dump($clauses['where']);

	return $clauses;
}
//callback for add_filter( 'comments_clauses', 'trrc_comments_clauses', 999 );

function trrc_filter_comments_array($array, $post_id) {
	$user = wp_get_current_user();
    if(!$user) {
		//return fast
        return $array;
    }
	$user_id = $user->ID;

	$count = count($array);
	$key = "comments-$user_id-$post_id";
	$group = "trrc-comments-count";
	wp_cache_set( $key, $count, $group );
	return $array;
}
//callback for add_filter('comments_array', 'trrc_filter_comments_array', 999, 2);

function trrc_comments_number( $count, $post_id ) {
    $user = wp_get_current_user();
    if(!$user) {
		//return fast
        return $count;
    }
	$user_id = $user->ID;
    $key = "comments-$user_id-$post_id";
    $group = "trrc-comments-count";
    $n = wp_cache_get( $key, $group );
    if(!$n) {
        return $count;
    }
    return $n;
}
//callback for add_filter( 'get_comments_number', 'trrc_comments_number', 999, 2 );