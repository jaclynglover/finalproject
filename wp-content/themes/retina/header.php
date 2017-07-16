<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Retina
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site-wrapper site">

	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">

					<div class="site-header-inside">

						<div class="site-branding-wrapper">
							<?php
							// Site Logo
							retina_the_custom_logo();
							?>

							<div class="site-branding">
								<h2 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
								<?php
								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) :
								?>
								<h3 class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></h3>
								<?php endif; ?>
							</div>
						</div><!-- .site-branding-wrapper -->

						<div class="toggle-menu-wrapper">
							<a href="#main-navigation-responsive" title="<?php esc_attr_e( 'Menu', 'retina' ); ?>" class="toggle-menu-control">
								<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'retina' ); ?></span>
							</a>
						</div>

					</div><!-- .site-header-inside -->

				</div><!-- .col-xl-12 -->
			</div><!-- .row -->
		</div><!-- .container -->
	</header><!-- #masthead -->

	<nav id="site-navigation" class="main-navigation" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">

					<div class="main-navigation-inside">

						<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'retina' ); ?></a>

						<?php
						wp_nav_menu( apply_filters( 'retina_primary_menu_args', array(
							'container'       => 'div',
							'container_class' => 'site-primary-menu',
							'theme_location'  => 'primary',
							'menu_class'      => 'primary-menu sf-menu',
							'depth'           => 3,
						) ) );
						?>

					</div><!-- .main-navigation-inside -->

				</div><!-- .col-xl-12 -->
			</div><!-- .row -->
		</div><!-- .container -->
	</nav><!-- .main-navigation -->

	<div id="content" class="site-content">
