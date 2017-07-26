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
      'supports' => array('title','editor','author','excerpt','comments','revisions'),
      'rewrite' => array('slug' => 'run'),
    )
  );
}

// below portion of code based on example from https://www.sitepoint.com/adding-custom-meta-boxes-to-wordpress/

function add_custom_meta_box()
{
  add_meta_box("run-meta-box", "Run Details", "custom_meta_box_markup", "glover_run", "side", "high", null);
}

add_action("add_meta_boxes", "add_custom_meta_box");

function custom_meta_box_markup($object)
{
  wp_nonce_field(basename(__FILE__), "meta-box-nonce");
  
  ?>
    <div>
      <label for="neighborhood_meta_box_text">Neighborhood</label>
      <input name="neighborhood_meta_box_text" type="text" value="<?php echo get_post_meta($object->ID, "neighborhood-box-text", true); ?>">

      <br>

      <label for="date_meta_box_text">Date</label>
      <input name="date_meta_box_text" type="text" value="<?php echo get_post_meta($object->ID, "date-box-text", true); ?>">

      <br>

      <label for="time_meta_box_text">Time</label>
      <input name="time_meta_box_text" type="text" value="<?php echo get_post_meta($object->ID, "time-box-text", true); ?>">
    </div>
  <?php    
}
?>