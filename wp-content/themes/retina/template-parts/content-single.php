<?php
/**
 * Template part for displaying single posts.
 *
 * @package Retina
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header-wrapper">
		<div class="entry-meta entry-meta-header-before">
			<ul>
				<li><?php retina_posted_on(); ?></li>
				<li><?php retina_posted_by(); ?></li>
				<?php retina_post_format( '<li>', '</li>' ); ?>
			</ul>
		</div><!-- .entry-meta -->

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
	</div><!-- .entry-header-wrapper -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'retina' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta entry-meta-footer">
		<?php retina_entry_footer(); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
