<?php
/* http://www.wpbeginner.com/beginners-guide/what-why-and-how-tos-of-creating-a-site-specific-wordpress-plugin/
Plugin Name: Custom Post Run Plugin for www.therunningglover.com
Description: Custom Post Type for "The Running (G)lover" Website
Version: 1.0
Author: Jaclyn Glover
Author URI: http://www.therunningglover.com
Text domain: therunningglover-run-post-plugin
*/

// below portion of code based on WordPress codex at https://codex.wordpress.org/Post_Types and Andrew Spittle's reading list at https://github.com/andrewspittle/reading-list/blob/master/index.php

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'glover_run',
    array(
      'labels' => array(
        'name' => __( 'Run'),
        'singular_name' => __( 'Run'),
        'search_items' => __( 'Search Runs'),
        'all_items' => __( 'All Runs'),
        'edit_item' => __( 'Edit Run'),
        'update_item' => __( 'Update Run'),
        'add_new_item' => __( 'Add New Run'),
        'menu_name' => __( 'Run'),
      ),
      'public' => true,
      'menu_position' => 5,
      'has_archive' => true,
      'taxonomies' => array('category', 'post_tag'),
      'supports' => array('title', 'thumbnail', 'editor', ' author', 'comments'),
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
      <label for="neighborhood_box_text">Neighborhood</label>
      <input name="neighborhood_box_text" type="text" value="<?php echo get_post_meta($object->ID, "neighborhood-box-text", true); ?>">

      <br>

      <label for="date_box_text">Date</label>
      <input name="date_box_text" type="text" value="<?php echo get_post_meta($object->ID, "date-box-text", true); ?>">

      <br>

      <label for="time_box_text">Time</label>
      <input name="time_box_text" type="text" value="<?php echo get_post_meta($object->ID, "time-box-text", true); ?>">
    </div>
  <?php    

function save_custom_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "post";
    if($slug != $post->glover_run)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["neighborhood-box-text"]))
    {
        $meta_box_text_value = $_POST["neighborhood-box-text"];
    }   
    update_post_meta($post_id, "neighborhood-box-text", $meta_box_text_value);
}

add_action("save_post", "save_custom_meta_box", 10, 3);
}

?>