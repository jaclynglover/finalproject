<?php
/* http://www.wpbeginner.com/beginners-guide/what-why-and-how-tos-of-creating-a-site-specific-wordpress-plugin/
Plugin Name: Run Log Custom Post Plugin for www.therunningglover.com
Description: Custom Post Type for "The Running (G)lover" Website
Version: 1.0
Author: Jaclyn Glover
Author URI: http://www.therunningglover.com
Text domain: trg-run-post-plugin
*/

// following block of code modeled after https://github.com/andrewspittle/reading-list/blob/master/index.php#L23
add_action( 'init', 'trgrun_create_post_type' );
function trgrun_create_post_type() {
	$labels = array(
		'name' 			=> __( 'Run' ),
		'singular_name' => __( 'Run' ),
		'search_items'	=> __( 'Search Runs' ),
		'all_items'		=> __( 'All Runs' ),
		'edit_item'		=> __( 'Edit Run' ),
		'update_item' 	=> __( 'Update Run' ),
		'add_new_item' 	=> __( 'Add New Run' ),
		'new_item_name' => __( 'New Run' ),
		'menu_name' 	=> __( 'Run' ),
	);

	$args = array (
		'labels' 		=> $labels,
		'public' 		=> true,
		'menu_position' => 20,
		'has_archive' 	=> true,
		'rewrite'		=> array( 'slug' => 'run' ),
		'supports' 		=> array( 'title', 'thumbnail', 'editor' )
	);

	register_post_type( 'trg_run', $args );
}

// following block of code from https://code.tutsplus.com/articles/three-practical-uses-for-custom-meta-boxes--wp-20581

add_action( 'add_meta_boxes', 'trg_add_details_meta' );
function trg_add_details_meta()
{
    add_meta_box( 'details-meta', 'Run Details', 'trg_details_meta_cb', 'trg_run', 'side', 'high' );
}

function trg_details_meta_cb($post)
{
    $neighborhood = get_post_meta( $post->ID, 'trg_details_neighborhood', true );
    $date = get_post_meta( $post->ID, 'trg_details_date', true );
    $time = get_post_meta( $post->ID, 'trg_details_time', true );
     
    wp_nonce_field( 'save_details_meta', 'details_nonce' );
    ?>
    <p>
        <label for="details-neighborhood">Neighborhood</label>
        <input type="text" id="details-neighborhood" name="trg_details_neighborhood" value="<?php echo $neighborhood; ?>" />
    </p>
    <p>
        <label for="details-date">Date</label>
        <input type="text" id="details-date" name="trg_details_date" value="<?php echo $date; ?>" />
    </p>
    <p>
        <label for="details-time">Time</label>
        <input type="text" id="details-time" name="trg_details_time" value="<?php echo $time; ?>" />
    </p>
    <?php    
}

add_action( 'save_post', 'trg_details_meta_save' );
function trg_details_meta_save( $id )
{
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    if( !isset( $_POST['details_nonce'] ) || !wp_verify_nonce( $_POST['details_nonce'], 'save_details_meta' ) ) return;
     
    if( !current_user_can( 'edit_post' ) ) return;
     
    $allowed = array(
        'p' => array()
    );
     
    if( isset( $_POST['trg_details_neighborhood'] ) )
        update_post_meta( $id, 'trg_details_neighborhood', wp_kses( $_POST['trg_details_neighborhood'], $allowed ) );
     
    if( isset( $_POST['trg_details_date'] ) )
        update_post_meta( $id, 'trg_details_date', esc_attr( strip_tags( $_POST['trg_details_date'] ) ) );
         
    if( isset( $_POST['trg_details_time'] ) )
        update_post_meta( $id, 'trg_details_time', esc_attr( strip_tags( $_POST['trg_details_time'] ) ) );   
}

add_filter( 'the_content', 'trg_display_neighborhood' );
function trg_display_neighborhood( $content )
{
    // We only want this on single posts, bail if we're not in a single post
    if( !is_single() ) return $content;
}

add_filter( 'the_content', 'trg_display_neighborhood' );
function cd_display_neighborhood( $content )
{   
    // We only want this on single posts, bail if we're not in a single post
    if( !is_single() ) return $content;
     
    // We're in the loop, so we can grab the $post variable
    global $post;
     
    $neighborhood = get_post_meta( $post->ID, 'trg_details_neighborhood', true );
     
    // Bail if we don't have a quote;
    if( empty( $quote ) ) return $content;

    $date = get_post_meta( $post->ID, 'trg_details_date', true );
    $time = get_post_meta( $post->ID, 'trg_details_time', true );
     
    $out = '<blockquote>' . $neighborhood;
    if( !empty( $date ) )
    {
        $out .= '<p class="details-date">-' . $date;
     
        if( !empty( $time ) )
            $out .= ' (' . $time . ')';
         
        $out .= '</p>';       
    }
     
    $out .= '</blockquote>';

     return $out . $content;
}

?>