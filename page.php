<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package QHFZBIO
 */

get_header(); ?>

	<div id="container" class="<?php QHFZBIO_get_layout_class(); ?>">

		<main id="main" class="main">
			<?php MrGiraffe_before_content_hook(); ?>

			<?php get_template_part( 'content/content', 'page' ); ?>

			<?php MrGiraffe_after_content_hook(); ?>
		</main><!-- #main -->

		<?php QHFZBIO_get_sidebar(); ?>

	</div><!-- #container -->

<?php get_footer();
