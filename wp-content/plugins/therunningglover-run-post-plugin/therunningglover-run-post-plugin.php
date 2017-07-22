<?php
/* http://www.wpbeginner.com/beginners-guide/what-why-and-how-tos-of-creating-a-site-specific-wordpress-plugin/
Plugin Name: Custom Post Run Plugin for www.therunningglover.com
Description: Custom Post Type for "The Running (G)lover" Website
Author: Jaclyn Glover
Author URI: www.therunningglover.com
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// custom post type function

function create_posttype() {

	register_post_type( 'runs',
		array(
			'labels' => array(
				'name' => ( 'Runs' ),
				'singular_name' => ( 'Run' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'runs'),
		)
	);

add_action( 'init', 'create_posttype' );

add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

}

function add_my_post_types_to_query( $query ) {
	if ( is_home() && $query->is_main_query() )
		$query->set( 'post_type', array( 'post', 'runs' ) 
);
	return $query;
} 

?>
