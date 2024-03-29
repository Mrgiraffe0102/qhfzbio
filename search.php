<?php
/**
 * The template for displaying Search results pages.
 *
 * @package QHFZBIO
 */

get_header(); ?>

	<div id="container" class="<?php QHFZBIO_get_layout_class(); ?>">
		<main id="main" class="main">
			<?php MrGiraffe_before_content_hook(); ?>

			<?php if ( have_posts() ) : ?>

				<header class="page-header content-search pad-container" <?php MrGiraffe_schema_microdata( 'element' ); ?>>
					<h1 class="page-title" <?php MrGiraffe_schema_microdata( 'entry-title' ); ?>>
						<?php printf( __( 'Search Results for: %s', 'QHFZBIO' ), '<strong>' . get_search_query() . '</strong>' ); ?>
					</h1><br>
					<?php get_search_form(); ?>
				</header>

				<div id="content-masonry" class="content-masonry" <?php MrGiraffe_schema_microdata( 'blog' ); ?>>
					<?php /* Start the Loop */
					while ( have_posts() ) : the_post();
						get_template_part( 'content/content', get_post_format() );
					endwhile;
					?>
				</div><!--content-masonry-->
				<?php

				QHFZBIO_pagination();

			else :

				get_template_part( 'content/content', 'notfound' );
				?> <div id="content-masonry"></div> <?php

				MrGiraffe_empty_page_hook();

			endif; ?>

			<?php MrGiraffe_after_content_hook(); ?>
		</main><!-- #main -->

		<?php QHFZBIO_get_sidebar(); ?>
	</div><!-- #primary -->

<?php get_footer(); ?>
