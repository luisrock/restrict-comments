<?php

function trrc_admin_menu() {
    global $trrc_settings_page;
    $trrc_settings_page = add_submenu_page(
                            'edit-comments.php',
                            'Restrict Comments',
                            'Restrict Comments',
                            'manage_options',
                            'restrict-comment',
                            'trrc_admin_page'
                        );
}
add_action( 'admin_menu', 'trrc_admin_menu' );

function trrc_register_plugin_settings() {
    //register our settings
    register_setting( 'trrc-settings-group', 'trrc_post_types' );
    register_setting( 'trrc-settings-group', 'trrc_roles_excepted' );
}
//call register settings function
add_action( 'admin_init', 'trrc_register_plugin_settings' );


function trrc_admin_page() {
?>

<div class="trrc-head-panel">
    <h1><?php esc_html_e( 'Restrict Comments', 'restrict-comments' ); ?></h1>
    <h3><?php esc_html_e( 'Let each user see only their own comments (and correspondent replies) on selected post types.', 'restrict-comments' ); ?></h3>
</div>

<div class="wrap trrc-wrap-grid">

    <form method="post" action="options.php">

        <?php settings_fields( 'trrc-settings-group' ); ?>
        <?php do_settings_sections( 'trrc-settings-group' ); ?>

        <div class="trrc-form-fields">


            <div class="trrc-settings-title">
                <?php esc_html_e( ' Restrict Comments - Settings', 'restrict-comments' ); ?>
            </div>

            <div class="trrc-form-fields-label">
                <?php esc_html_e( 'Select post types that WILL be affected by the plugin', 'restrict-comments' ); ?>
                <span>* <?php esc_html_e( 'you can select as many as you like, by Ctrl+Click (deselect also by Ctrl+Click).', 'restrict-comments' ); ?></span>
            </div>
            <div class="trrc-form-fields-group">
                <div class="trrc-form-div-select">
                    <label>
                        <select name="<?php echo esc_attr( 'trrc_post_types' ); ?>[]" multiple>
                            <?php foreach(trrc_get_public_post_types() as $pt) { ?>
                                <option value="<?php echo esc_attr($pt); ?>"
                                <?php 
                                    if(is_array(get_option('trrc_post_types')) && in_array($pt,get_option('trrc_post_types'))) { ?>
                                    selected
                                    <?php }
                                ?>>     
                                    <?php echo esc_html($pt); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </label>
                </div>
                <span>* <?php esc_html_e( 'Observe that the non-logged visitor won\'t see any comments on the post type(s) selected (which seems obvious, as the plugin won\'t be able to check if he/she is the comment author...)', 'restrict-comments' ); ?></span>
            </div>
            <hr>
            
            <div class="trrc-form-fields-label">
                <?php esc_html_e( 'Select user roles to NOT be affected by the plugin', 'restrict-comments' ); ?>
                <span>* <?php esc_html_e( 'you can select as many as you like, by Ctrl+Click (deselect also by Ctrl+Click).', 'restrict-comments' ); ?></span>
            </div>
            <div class="trrc-form-fields-group">
                <div class="trrc-form-div-select">
                    <label>
                        <select name="<?php echo esc_attr( 'trrc_roles_excepted' ); ?>[]" multiple>
                            <?php foreach(trrc_get_role_names() as $role) { ?>
                                <option value="<?php echo esc_attr($role); ?>"
                                <?php 
                                    if(is_array(get_option('trrc_roles_excepted')) && in_array($role,get_option('trrc_roles_excepted'))) { ?>
                                    selected
                                    <?php }
                                ?>>     
                                    <?php echo esc_html($role); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </label>
                </div>
                <span>* <?php esc_html_e( 'Administrators and users with roles that allow to edit posts or moderate comments are already excepted from the restriction.', 'restrict-comments' ); ?></span>
            </div>

            <?php submit_button(); ?>

            <div style="float:right; margin-bottom:20px">
              Contact Luis Rock, the author, at 
              <a href="mailto:lurockwp@gmail.com">
                lurockwp@gmail.com
              </a>
            </div>

        </div> <!-- end form fields -->
    </form>
</div> <!-- end trrc-wrap-grid -->
<?php } ?>