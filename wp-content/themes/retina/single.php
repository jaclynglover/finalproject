<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Retina
 */

get_header(); ?>

	<div class="container">
		<div class="row">

			<div id="primary" class="content-area <?php retina_layout_class( 'content' ); ?>">
				<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

					<?php
					if ( '' !== get_the_author_meta( 'description' ) ) {
						get_template_part( 'template-parts/biography' );
					}
					?>

					<?php retina_the_post_pagination(); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!-- .row -->
	</div><!-- .container -->

<?php get_footer(); ?>
