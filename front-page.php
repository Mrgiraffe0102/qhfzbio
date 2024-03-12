<?php
/**
 * The template for displaying the landing page/blog posts
 * The functions used here can be found in includes/landing-page.php
 *
 * @package QHFZBIO
 */

$QHFZBIO_landingpage = MrGiraffe_get_option( 'theme_landingpage' );

if ( is_page() && ! $QHFZBIO_landingpage ) {
	load_template( get_page_template() );
	return true;
}

if ( 'posts' == get_option( 'show_on_front' ) ) {
	include( get_home_template() );
} else {

	get_header();
	?>

	<div id="container" class="QHFZBIO-landing-page one-column">
		<main id="main" class="main">
		<?php
		//MrGiraffe_before_content_hook();

		if ( $QHFZBIO_landingpage ) {
			get_template_part( apply_filters('QHFZBIO_landingpage_main_template', 'content/landing-page' ) );
		} else {
			QHFZBIO_lpindex();
		}

		//MrGiraffe_after_content_hook();
		?>
		</main><!-- #main -->
		<?php if ( ! $QHFZBIO_landingpage ) { QHFZBIO_get_sidebar(); } ?>
	</div><!-- #container -->

	<?php get_footer();

} //else !posts
