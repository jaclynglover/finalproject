<?php
/**
 * The default template for displaying content
 *
 * @package Retina
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( retina_has_post_thumbnail() ) : ?>
	<div class="entry-image-wrapper">
		<?php retina_post_thumbnail(); ?>
	</div><!-- .entry-image-wrapper -->
	<?php endif; ?>

	<div class="entry-header-wrapper entry-header-wrapper-archive">
		<?php if ( 'post' == get_post_type() ) : // For Posts ?>
		<div class="entry-meta entry-meta-header-before">
			<ul>
				<li><?php retina_first_category(); ?></li>
				<?php retina_post_format( '<li>', '</li>' ); ?>
				<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<li>
					<span class="post-label post-label-featured">
						<span class="screen-reader-text"><?php esc_html_e( 'Featured', 'retina' ); ?></span>
					</span>
				</li>
				<?php endif; ?>
			</ul>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( retina_get_link_url() ) . '" rel="bookmark">', '</a></h1>' ); ?>
		</header><!-- .entry-header -->

		<?php if ( 'post' == get_post_type() ) : // For Posts ?>
		<div class="entry-meta entry-meta-header-after">
			<ul>
				<li><?php retina_posted_on(); ?></li>
				<li><?php retina_posted_by(); ?></li>
			</ul>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</div><!-- .entry-header-wrapper -->

	<?php if ( retina_has_excerpt() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php endif; ?>

	<div class="more-link-wrapper">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="more-link"><?php esc_html_e( 'Read More', 'retina' ); ?></a>
	</div><!-- .more-link-wrapper -->
</article><!-- #post-## -->
