<?php
/* http://www.wpbeginner.com/beginners-guide/what-why-and-how-tos-of-creating-a-site-specific-wordpress-plugin/
Plugin Name: Custom Post Run Plugin for www.therunningglover.com
Description: Custom Post Type for "The Running (G)lover" Website
Author: Jaclyn Glover
Author URI: www.therunningglover.com
*/

// below portion of code based on WordPress codex at https://codex.wordpress.org/Post_Types
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'glover_run',
    array(
      'labels' => array(
        'name' => __( 'Run' ),
        'singular_name' => __( 'Run' ),
      ),
      'public' => true,
      'show_in_menu' => true,
      'has_archive' => true,
      'taxonomies' => array('category', 'post_tag'),
      'rewrite' => array('slug' => 'run'),
    )
  );
}

// below portion of code based on example from https://www.sitepoint.com/adding-custom-meta-boxes-to-wordpress/

function custom_meta_box_markup()
{
    
}

function add_custom_meta_box()
{
    add_meta_box("run-meta-box", "Run Details", "custom_meta_box_markup", "glover_run", "side", "high", null);
}

add_action("add_meta_boxes", "add_custom_meta_box");

?>


