<?php
function my_theme_enqueue_styles() {

    $parent_style = 'child-style'; // This is 'retina-style' for the Retina theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

function add_my_post_types_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array( 'post', 'glover_run' ) );
  return $query;
}

// Google Fonts enqueue code below is from https://www.tipsandtricks-hq.com/how-to-easily-add-google-web-fonts-to-your-wordpress-theme-4915

function load_google_fonts() {
wp_register_style('googleWebFonts', 'http://fonts.googleapis.com/css?family=Heebo|Cardo|BenchNine');
wp_enqueue_style('googleWebFonts');
}

add_action('wp_print_styles', 'load_google_fonts');

?>