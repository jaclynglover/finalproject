<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Retina
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<div class="site-info">
			<div class="site-info-inside">

				<div class="container">
					<div class="row">
						<div class="col-xl-12">

							<div class="credits">
								<?php do_action( 'retina_credits' ); ?>
							</div><!-- .credits -->

						</div><!-- .col -->
					</div><!-- .row -->
				</div><!-- .container -->

			</div><!-- .site-info-inside -->
		</div><!-- .site-info -->

	</footer><!-- #colophon -->

</div><!-- #page .site-wrapper -->

<?php wp_footer(); ?>
</body>
</html>
