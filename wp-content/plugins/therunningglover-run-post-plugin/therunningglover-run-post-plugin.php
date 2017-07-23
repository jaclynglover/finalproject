<?php
/* http://www.wpbeginner.com/beginners-guide/what-why-and-how-tos-of-creating-a-site-specific-wordpress-plugin/
Plugin Name: Custom Post Run Plugin for www.therunningglover.com
Description: Custom Post Type for "The Running (G)lover" Website
Author: Jaclyn Glover
Author URI: www.therunningglover.com
*/

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'glover_runs',
    array(
      'labels' => array(
        'name' => __( 'Runs' ),
        'singular_name' => __( 'Run' )
      ),
      'public' => true,
      'show_in_menu' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'runs'),
    )
  );
}

?>
