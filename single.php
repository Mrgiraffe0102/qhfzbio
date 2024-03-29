<?php
/**
 * The Template for displaying all single posts.
 *
 * @package QHFZBIO
 */

get_header(); ?>

<div id="container" class="<?php QHFZBIO_get_layout_class(); ?>">
	<main id="main" class="main">
		<?php MrGiraffe_before_content_hook(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); MrGiraffe_schema_microdata( 'article' );?>>
				<div class="schema-image">
					<?php MrGiraffe_featured_hook(); ?>
				</div>

				<div class="article-inner">
					<header>
						<div class="entry-meta beforetitle-meta">
							<?php MrGiraffe_post_title_hook(); ?>
						</div><!-- .entry-meta -->
						<?php the_title( '<h1 class="entry-title singular-title" ' . MrGiraffe_schema_microdata('entry-title', 0) . '>', '</h1>' ); ?>

						<div class="entry-meta aftertitle-meta">
							<?php MrGiraffe_post_meta_hook(); ?>
						</div><!-- .entry-meta -->

					</header>

					<?php MrGiraffe_singular_before_inner_hook();  ?>

					<div class="entry-content" <?php MrGiraffe_schema_microdata('entry-content'); ?>>
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'QHFZBIO' ), 'after' => '</span></div>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta entry-utility">
						<?php MrGiraffe_post_utility_hook(); ?>
					</footer><!-- .entry-utility -->

				</div><!-- .article-inner -->
				<?php MrGiraffe_singular_after_inner_hook();  ?>
			</article><!-- #post-## -->

			<?php if ( get_the_author_meta( 'description' ) ) {
					// If a user has filled out their description, show a bio on their entries
					get_template_part( 'content/user-bio' );
			} ?>


			<?php MrGiraffe_singular_before_comments_hook();  ?>
			<?php comments_template( '', true ); ?>


		<?php endwhile; // end of the loop. ?>

		<?php MrGiraffe_after_content_hook(); ?>
	</main><!-- #main -->

	<?php QHFZBIO_get_sidebar(); ?>
</div><!-- #container -->
<?php if ( 1 == MrGiraffe_get_option ('theme_singlenav') ) { ?>
	<nav id="nav-below" class="navigation">
		<?php
			$QHFZBIO_prevpost = get_previous_post( true );
			$QHFZBIO_nextpost = get_next_post( true );
			$default = '<img src="' . esc_url( get_header_image() ) . '" alt="" loading="lazy" />';
			$QHFZBIO_prevthumb = (isset($QHFZBIO_prevpost->ID) && get_the_post_thumbnail( $QHFZBIO_prevpost->ID) )
				? wp_get_attachment_image( get_post_thumbnail_id( $QHFZBIO_prevpost->ID ), 'large' )
				: $QHFZBIO_prevthumb = $default;
			$QHFZBIO_nextthumb = (isset($QHFZBIO_nextpost->ID) && get_the_post_thumbnail( $QHFZBIO_nextpost->ID) )
				? wp_get_attachment_image( get_post_thumbnail_id( $QHFZBIO_nextpost->ID ), 'large' )
				: $QHFZBIO_nextthumb = $default;
		?>
		<div class="nav-previous">
			<?php previous_post_link( '%link',  '<em>' . __('Previous', 'QHFZBIO') . '</em>' . '<span>%title</span>', true ); ?>
			<?php echo $QHFZBIO_prevthumb; ?>
		</div>
		<div class="nav-next">
			<?php next_post_link( '%link',  '<em>' . __('Next', 'QHFZBIO') . '</em>' . '<span>%title</span>', true ); ?>
			<?php echo $QHFZBIO_nextthumb; ?>
		</div>
	</nav><!-- #nav-below -->
<?php } ?>
<?php if ( 2 == MrGiraffe_get_option( 'theme_singlenav' ) ) { ?>
	<nav id="nav-fixed">
		<div class="nav-previous"><?php previous_post_link( '%link', '<i class="icon-fixed-nav"></i>', true );  previous_post_link( '%link', '<span>%title</span>', true );  ?></div>
		<div class="nav-next"><?php next_post_link( '%link', '<i class="icon-fixed-nav"></i>', true ); next_post_link( '%link', '<span>%title</span>', true );  ?></div>
	</nav>
<?php } ?>

<?php get_footer();
