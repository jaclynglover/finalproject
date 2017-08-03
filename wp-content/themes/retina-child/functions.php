<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
 
    $parent_style = 'parent-style'; // This is 'child-style' for the Retina theme.
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

// following block of code modeled after https://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts

add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

function add_my_post_types_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array( 'post', 'glover_run' ) );
  return $query;
}

// code below from https://developer.wordpress.org/themes/template-files-section/custom-post-type-template-files/

function search_filter( $query ) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ( $query->is_search ) {
      $query->set( 'post_type', array( 'post', 'page', 'glover_run' ) );
    }
  }
}
 
add_action( 'pre_get_posts','search_filter' );

// following code modified from http://www.wpbeginner.com/wp-tutorials/how-to-add-categories-to-a-custom-post-type-in-wordpress/

add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if( is_category() ) {
    $post_type = get_query_var('post_type');
    if($post_type)
        $post_type = $post_type;
    else
        $post_type = array('nav_menu_item', 'post', 'glover_run'); 
    $query->set('post_type',$post_type);
    return $query;
    }
}

// Google Fonts enqueue code below is from https://www.tipsandtricks-hq.com/how-to-easily-add-google-web-fonts-to-your-wordpress-theme-4915

function load_google_fonts() {
wp_register_style('googleWebFonts', 'http://fonts.googleapis.com/css?family=Bentham|Lato|Cardo|Heebo');
wp_enqueue_style('googleWebFonts');
}

add_action('wp_print_styles', 'load_google_fonts');

?>