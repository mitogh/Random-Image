<?php
/**
 * Plugin Name: Simple Random Image
 * Plugin URI: https://github.com/mitogh/Simple-Random-Image
 * Description: Generate a random image from the attachements file.
 * Version: 0.1
 * Author: Crisoforo.
 * Author URI: http://www.crisoforo.com
 * License: Apache 2.0
 */
include_once(plugin_dir_path(__FILE__).'/class-simple-random-image.php');
include_once(plugin_dir_path(__FILE__).'/simple-random-image-shortcodes.php');

add_action('admin_menu', 'simple_random_image');

function simple_random_image() {
    add_menu_page(__('Simple Random Image','Simple Random Image'), __('Simple Random Image','simple_random_image'), 'manage_options', 'simple-random-image', 'simple_random_image_options' );
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
