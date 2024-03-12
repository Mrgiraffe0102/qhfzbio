<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package QHFZBIO
 */

get_header(); ?>

	<div id="container" class="<?php QHFZBIO_get_layout_class(); ?>">
		<main id="main" class="main">
			<?php MrGiraffe_before_content_hook(); ?>

			<header id="post-0" class="pad-container error404 not-found" <?php MrGiraffe_schema_microdata( 'element' ); ?>>
				<h1 class="entry-title" <?php MrGiraffe_schema_microdata( 'entry-title' ); ?>><?php _e( 'Not Found', 'QHFZBIO' ); ?></h1>
					<p <?php MrGiraffe_schema_microdata( 'text' ); ?>><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'QHFZBIO' ); ?></p>
					<?php get_search_form(); ?>
			</header>

			<?php MrGiraffe_empty_page_hook(); ?>

			<?php MrGiraffe_after_content_hook(); ?>
		</main><!-- #main -->

		<?php QHFZBIO_get_sidebar(); ?>
	</div><!-- #container -->

<?php get_footer(); ?>
