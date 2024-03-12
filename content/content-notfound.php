<?php
/**
 * The default template for the not found section
 *
 * @package QHFZBIO
 */
?>
<header class="content-search pad-container no-results" <?php MrGiraffe_schema_microdata( 'element' ); ?>>

	<h1 class="entry-title" <?php MrGiraffe_schema_microdata( 'entry-title' ); ?>><?php _e( 'Nothing Found', 'QHFZBIO' ); ?></h1>
	<div class="no-results-div">
		<p <?php MrGiraffe_schema_microdata( 'text' ); ?>><?php printf( __( 'No search results for: <em>%s</em>', 'QHFZBIO' ), '<span>' . get_search_query() . '</span>' ); ?></p>
		<?php get_search_form(); ?>
	</div>

</header><!-- not-found -->
