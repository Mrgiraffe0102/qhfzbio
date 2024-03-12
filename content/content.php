<?php
/**
 * The default template for displaying content
 *
 * @package QHFZBIO
 */

$QHFZBIOs = MrGiraffe_get_option( array( 'theme_excerptarchive', 'theme_excerptsticky', 'theme_excerpthome' ) );

?><?php MrGiraffe_before_article_hook(); ?>

<article id="post-<?php the_ID(); ?>" <?php if ( is_sticky() )  post_class( array('hentry' , 'hentry-featured') ); else post_class( 'hentry' ); MrGiraffe_schema_microdata( 'blogpost' ); ?>>

	<div class="article-inner">
		<?php if ( false == get_post_format() ) { MrGiraffe_featured_hook(); } ?>


		<div class="entry-after-image">
			<?php MrGiraffe_post_title_hook(); ?>
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"' . MrGiraffe_schema_microdata( 'entry-title', 0 )  . '><a href="%s" ' . MrGiraffe_schema_microdata( 'mainEntityOfPage', 0 ) . ' rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				<div class="entry-meta aftertitle-meta">
					<?php MrGiraffe_post_meta_hook(); ?>
				</div><!-- .entry-meta -->
			</header><!-- .entry-header -->

			<?php MrGiraffe_before_inner_hook();

			$QHFZBIO_excerpt_mode = 'excerpt'; // default
			if ( $QHFZBIOs['theme_excerptarchive'] == "full" ) { $QHFZBIO_excerpt_mode = 'content'; }
			if ( is_sticky() && $QHFZBIOs['theme_excerptsticky'] == "full" ) { $QHFZBIO_excerpt_mode = 'content'; }
			if ( $QHFZBIOs['theme_excerpthome'] == "full" && ! is_archive() && ! is_search() ) { $QHFZBIO_excerpt_mode = 'content'; }
			if ( false != get_post_format() ) { $QHFZBIO_excerpt_mode = 'content'; }

			switch ( $QHFZBIO_excerpt_mode ) {
				case 'content': ?>

					<div class="entry-content" <?php MrGiraffe_schema_microdata( 'entry-content' ); ?>>
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'QHFZBIO' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->
					<div class="entry-meta entry-utility">
						<?php MrGiraffe_meta_format_hook(); ?>
						<?php MrGiraffe_post_utility_hook(); ?>
					</div><!-- .entry-utility -->

				<?php break;

				case 'excerpt':
				default: ?>

					<div class="entry-summary" <?php MrGiraffe_schema_microdata( 'entry-summary' ); ?>>
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
					<div class="entry-meta entry-utility">
						<?php MrGiraffe_meta_format_hook(); ?>
						<?php MrGiraffe_post_utility_hook(); ?>
					</div><!-- .entry-utility -->
					<footer class="post-continue-container">
						<?php MrGiraffe_post_excerpt_hook(); ?>
					</footer>

				<?php break;
			}; ?>

			<?php MrGiraffe_after_inner_hook();  ?>
		</div><!--.entry-after-image-->
	</div><!-- .article-inner -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php MrGiraffe_after_article_hook(); ?>
