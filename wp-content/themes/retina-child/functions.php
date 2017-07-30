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

// Google Fonts enqueue code below is from https://www.tipsandtricks-hq.com/how-to-easily-add-google-web-fonts-to-your-wordpress-theme-4915

function load_google_fonts() {
wp_register_style('googleWebFonts', 'http://fonts.googleapis.com/css?family=Bentham|Lato|Cardo|Heebo');
wp_enqueue_style('googleWebFonts');
}

add_action('wp_print_styles', 'load_google_fonts');

?>