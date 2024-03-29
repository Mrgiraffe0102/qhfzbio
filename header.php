<?php
/**
 * The Header
 *
 * Displays all of the <head> section and everything up till <main>
 *
 * @package QHFZBIO
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php MrGiraffe_meta_hook(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<?php
	MrGiraffe_header_hook();
	wp_head();
?>
</head>

<body <?php body_class(); MrGiraffe_schema_microdata( 'body' );?>>
	<?php do_action( 'wp_body_open' ); ?>
	<?php MrGiraffe_body_hook(); ?>
	<div id="site-wrapper">

	<header id="masthead" class="MrGiraffe" <?php MrGiraffe_schema_microdata( 'header' ) ?>>

		<div id="site-header-main">

			<div class="site-header-top">

				<div class="site-header-inside">

					<div id="header-menu" <?php MrGiraffe_schema_microdata( 'menu' ); ?>>
						<?php MrGiraffe_topmenu_hook(); ?>
					</div><!-- #header-menu -->

				</div><!-- #site-header-inside -->

			</div><!--.site-header-top-->

			<?php if ( has_nav_menu( 'primary' ) || ( true == MrGiraffe_get_option('theme_pagesmenu') ) ) { ?>
			<nav id="mobile-menu" tabindex="-1">
				<?php MrGiraffe_mobilemenu_hook(); ?>
				<?php do_action( 'MrGiraffe_side_section_hook' ); ?>
			</nav> <!-- #mobile-menu -->
			<?php } ?>

			<div class="site-header-bottom">

				<div class="site-header-bottom-fixed">

					<div class="site-header-inside">

						<div id="branding">
							<?php MrGiraffe_branding_hook(); ?>
						</div><!-- #branding -->

						<?php if ( QHFZBIO_check_empty_menu( 'primary' ) && ( has_nav_menu( 'primary' ) || ( true == MrGiraffe_get_option('theme_pagesmenu') ) ) ) { ?>
						<div class='menu-burger'>
							<button class='hamburger' type='button' aria-label="<?php esc_attr_e( 'Main menu', 'QHFZBIO' ) ?>">
									<span></span>
									<span></span>
									<span></span>
							</button>
						</div>
						<?php } ?>

						<?php if ( QHFZBIO_check_empty_menu( 'top' ) && ( has_nav_menu( 'top' ) || ( true == MrGiraffe_get_option('theme_pagesmenu') ) ) ) { ?>
						<nav id="access" aria-label="<?php esc_attr_e( 'Top Menu', 'QHFZBIO' ) ?>" <?php MrGiraffe_schema_microdata( 'menu' ); ?>>
							<?php MrGiraffe_access_hook(); ?>
						</nav><!-- #access -->
						<?php } ?>

					</div><!-- #site-header-inside -->

				</div><!-- #site-header-bottom-fixed -->

			</div><!--.site-header-bottom-->

		</div><!-- #site-header-main -->

		<div id="header-image-main">
			<div id="header-image-main-inside">
				<?php MrGiraffe_headerimage_hook(); ?>
			</div><!-- #header-image-main-inside -->
		</div><!-- #header-image-main -->

	</header><!-- #masthead -->

	<?php MrGiraffe_absolute_top_hook(); ?>

	<div id="content" class="MrGiraffe">
		<?php MrGiraffe_main_hook(); ?>
