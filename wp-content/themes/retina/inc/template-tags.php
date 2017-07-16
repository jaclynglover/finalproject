<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Retina
 */

if ( ! function_exists( 'retina_the_posts_pagination' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function retina_the_posts_pagination() {

	// Previous/next posts navigation @since 4.1.0
	the_posts_pagination( array(
		'prev_text'          => '<span class="screen-reader-text">' . esc_html__( 'Previous Page', 'retina' ) . '</span>',
		'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next Page', 'retina' ) . '</span>',
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'retina' ) . ' </span>',
	) );

}
endif;

if ( ! function_exists( 'retina_the_post_pagination' ) ) :
/**
 * Previous/next post navigation.
 *
 * @return void
 */
function retina_the_post_pagination() {

	// Previous/next post navigation @since 4.1.0.
	the_post_navigation( array(
		'next_text' => '<span class="meta-nav">' . esc_html__( 'Next', 'retina' ) . '</span> ' . '<span class="post-title">%title</span>',
		'prev_text' => '<span class="meta-nav">' . esc_html__( 'Prev', 'retina' ) . '</span> ' . '<span class="post-title">%title</span>',
	) );

}
endif;

if ( ! function_exists( 'retina_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function retina_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf( '<span class="screen-reader-text">%1$s</span><a href="%2$s" rel="bookmark"> %3$s</a>',
		esc_html_x( 'Posted on', 'post date', 'retina' ),
		esc_url( get_permalink() ),
		$time_string
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'retina_posted_by' ) ) :
/**
 * Prints author.
 */
function retina_posted_by() {

	// Global Post
	global $post;

	// We need to get author meta data from both inside/outside the loop.
	$post_author_id = get_post_field( 'post_author', $post->ID );

	// Byline
	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'retina' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID', $post_author_id ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $post_author_id ) ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'retina_post_formats' ) ) :
/*
 * Return the post format, linked to the post format archive
 *
 * @param string $before Optional. Display before post format link.
 * @param string $after  Optional. Display after post format link.
 */
function retina_post_format( $before = '', $after = '' ) {
	$post_format  = get_post_format();
	$post_formats = get_theme_support( 'post-formats' );

	if ( 'post' === get_post_type() && $post_format && in_array( $post_format, $post_formats[0] ) ) :

		$post_format_string = '<span class="post-format-label post-format-label-%1$s"><a class="post-format-link" href="%2$s" title="%3$s"><span class="screen-reader-text">%4$s</span></a></span>';
		$post_format_string = sprintf( $post_format_string,
			esc_attr( strtolower( get_post_format_string( $post_format ) ) ),
			esc_url( get_post_format_link( $post_format ) ),
			esc_attr( sprintf( __( 'All %s posts', 'retina'  ), get_post_format_string( $post_format ) ) ),
			esc_attr( get_post_format_string( $post_format ) )
		);
		echo $before . $post_format_string . $after; // WPCS: XSS OK.

	endif;
}
endif;

if ( ! function_exists( 'retina_first_category' ) ) :
/**
 * Prints first category for the current post.
 *
 * @return void
*/
function retina_first_category() {

	// Show the First Category Name Only
	$category = get_the_category();
	if ( $category[0] ) :
	?>

	<span class="first-category">
		<a href="<?php echo esc_url( get_category_link( $category[0]->term_id ) ); ?>"><?php echo esc_html( $category[0]->cat_name ); ?></a>
	</span>

	<?php
	endif;
}
endif;

if ( ! function_exists( 'retina_get_link_url' ) ) :
/**
 * Returns the URL from the post.
 *
 * @uses get_the_link() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @return string URL
 */
function retina_get_link_url() {

	// The first link found in the post content
	$has_url = get_url_in_content( get_the_content() );
	return ( $has_url && has_post_format( 'link' ) ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );

}
endif;

if ( ! function_exists( 'retina_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function retina_entry_footer() {

	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'retina' ) );
		if ( $categories_list && retina_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'retina' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'retina' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'retina' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'retina' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function retina_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'retina_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array (
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'retina_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so retina_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so retina_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in retina_categorized_blog.
 */
function retina_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'retina_categories' );
}
add_action( 'edit_category', 'retina_category_transient_flusher' );
add_action( 'save_post',     'retina_category_transient_flusher' );

/**
 * A helper conditional function.
 * Whether there is a post thumbnail and post is not password protected.
 *
 * @return bool
 */
function retina_has_post_thumbnail() {

	// Post password and Post thumbnail check
	if ( post_password_required() || ! has_post_thumbnail() ) {
		return false;
	}

    return true;

}

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @return void
*/
function retina_post_thumbnail() {

	// Post password and Post thumbnail check
	if ( ! retina_has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<figure class="post-thumbnail post-thumbnail-single">
		<?php the_post_thumbnail( 'retina-featured', array( 'class' => 'img-featured img-responsive' ) ); ?>
	</figure><!-- .post-thumbnail -->

	<?php else : ?>

	<figure class="post-thumbnail">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'retina-featured', array( 'class' => 'img-featured img-responsive' ) ); ?>
		</a>
	</figure><!-- .post-thumbnail -->

	<?php endif; // End is_singular()
}

if ( ! function_exists( 'retina_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 */
function retina_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

/**
 * A helper conditional function.
 * Theme has Excerpt or Not
 *
 * https://codex.wordpress.org/Function_Reference/get_the_excerpt
 * This function must be used within The Loop.
 *
 * @return bool
 */
function retina_has_excerpt() {

	// Post Excerpt
	$post_excerpt = get_the_excerpt();

	/**
	 * Excerpt Filter
	 * @return bool
	 */
	return apply_filters( 'retina_has_excerpt', ! empty ( $post_excerpt ) );

}

/**
 * A helper conditional function.
 * Theme has Sidebar or Not
 *
 * @return bool
 */
function retina_has_sidebar() {

	/**
	 * Sidebar Filter
	 * @return bool
	 */
	return apply_filters( 'retina_has_sidebar', is_active_sidebar( 'sidebar-1' ) );

}

/**
 * Display the layout classes.
 *
 * @param string $section - Name of the section to retrieve the classes
 * @return void
 */
function retina_layout_class( $section = 'content' ) {

	// Sidebar Position
	$sidebar_position = retina_mod( 'retina_sidebar_position' );
	if ( ! retina_has_sidebar() ) {
		$sidebar_position = 'no';
	}

	// Layout Skeleton
	$layout_skeleton = array(
		'content' => array(
			'content' => 'col-xl-12',
		),

		'content-sidebar' => array(
			'content' => 'col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8',
			'sidebar' => 'col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4',
		),

		'sidebar-content' => array(
			'content' => 'col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 col-lg-push-4 col-xl-push-4',
			'sidebar' => 'col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-lg-pull-8 col-xl-pull-8',
		),
	);

	// Layout Classes
	switch( $sidebar_position ) {

		case 'no':
		$layout_classes = $layout_skeleton['content']['content'];
		break;

		case 'left':
		$layout_classes = ( 'sidebar' === $section )? $layout_skeleton['sidebar-content']['sidebar'] : $layout_skeleton['sidebar-content']['content'];
		break;

		case 'right':
		default:
		$layout_classes = ( 'sidebar' === $section )? $layout_skeleton['content-sidebar']['sidebar'] : $layout_skeleton['content-sidebar']['content'];

	}

	echo esc_attr( $layout_classes );

}
