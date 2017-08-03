<?php
/* 
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

// following block of code modeled after https://themefoundation.com/wordpress-meta-boxes-guide/

function prfx_custom_meta() {
    add_meta_box( 'prfx_meta', __('Run Details', 'prfx-textdomain'), 'prfx_meta_callback', 'glover_run', 'side', 'high', null);
}

add_action('add_meta_boxes', 'prfx_custom_meta');

function prfx_meta_callback($post) {
  wp_nonce_field( basename(__FILE__), 'prfx_nonce');
  $prfx_stored_meta = get_post_meta($post->ID);
  ?>
 
    <p>
        <label for="meta-box-text" class="prfx-row-title"><?php _e('Neighborhood', 'prfx-textdomain')?></label>
        <input type="text" name="meta-box-text" id="meta-box-text" value="<?php if (isset($prfx_stored_meta['meta-box-text'])) echo $prfx_stored_meta['meta-box-text'][0]; ?>" />
    </p>
 
    <?php
}

function prfx_meta_save($post_id) {
  $is_autosave = wp_is_post_autosave($post_id);
  $is_revision = wp_is_post_revision($post_id);
  $is_valid_nonce = (isset($_POST['prfx_nonce']) && wp_verify_nonce($_POST['prfx_nonce'], basename(__FILE__))) ? 'true' : 'false';
 
  if ($is_autosave || $is_revision || !$is_valid_nonce) {
      return;
  }
   
  if(isset($_POST['meta-box-text'])) {
      update_post_meta( $post_id, 'meta-box-text', sanitize_text_field($_POST['meta-box-text']));
  } 
}

add_action('save_post', 'prfx_meta_save');

?>