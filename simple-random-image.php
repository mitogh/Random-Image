<?php
/**
 * Plugin Name: Simple Random Image
 * Plugin URI: https://github.com/mitogh/Simple-Random-Image
 * Description: Generate a random image from the attachements file.
 * Version: 0.1
 * Author: Crisoforo.
 * Author URI: http://www.crisoforo.com
 * License: MIT
 */

add_action('admin_menu', 'simple_random_image');

function simple_random_image() {
    add_menu_page(__('Simple Random Image','Simple Random Image'), __('Simple Random Image','statics'), 'manage_options', 'sexy-options', 'simple_random_image_options' );
    add_submenu_page("sexy-options", "Configuration", "Configuration", 0, "sexy-configuration", "configuration");
}

function simple_random_image_options(){
    if( !current_user_can('manage_options') ){
        wp_die(__('You do not have sufficient permission to access this page'));
    }
?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div><h2>Simple Random Image</h2>
    </div>
<?php
}// Options
function simple_random_image_configuration(){
}
