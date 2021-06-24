<?php
/**
 * Plugin Name:  Restrict Comments
 * Plugin URI: https://wptrat.com/restrict-comments /
 * Description:  Restrict Comments is the best way to let each user see only their own comments (and correspondent replies) on chosen post types or across the entire site.
 * Author: Luis Rock
 * Author URI: https://wptrat.com/
 * Version: 1.0.0
 * Text Domain: restrict-comments
 * Domain Path: /languages
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package   Restrict Comments
 */


if ( ! defined( 'ABSPATH' ) ) exit;
		
// //Solicitando outros arquivos do plugin
require_once('admin/trrc-settings.php');
require_once('includes/functions.php');

//Admin CSS
function trrc_enqueue_admin_script( $hook ) {
    global $trrc_settings_page;
    if( $hook != $trrc_settings_page ) {
        return;
    }
    wp_enqueue_style('trrc_admin_style', plugins_url('assets/css/trrc_admin.css',__FILE__ ));
}
add_action( 'admin_enqueue_scripts', 'trrc_enqueue_admin_script' );


define("TRRC_POST_TYPES", get_option('trrc_post_types'));
define("TRRC_ROLES_EXCEPTED", get_option('trrc_roles_excepted'));


//Count array and store number in the cache. Retrieve with "wp_cache_get( $key = "comments-$user_id-$post_id", $group = "trrc-comments-count" )"
add_filter('comments_array', 'trrc_filter_comments_array', 999, 2);
//Filter query (where)
add_filter( 'comments_clauses', 'trrc_comments_clauses', 999 );
//Filter number of comments to be displayed
add_filter( 'get_comments_number', 'trrc_comments_number', 999, 2 );
