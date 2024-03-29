<?php
/**
 *
 * The template for displaying pages
 *
 * Used in page.php and page templates
 *
 * @package QHFZBIO
 */
?>
<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="schema-image">
			<?php MrGiraffe_featured_hook(); ?>
		</div>
		<div class="article-inner">
			<header>
				<?php
					$theme_heading_tag = ( is_front_page() ) ? 'h2' : 'h1';
					the_title( '<' . $theme_heading_tag . ' class="entry-title singular-title" ' . MrGiraffe_schema_microdata( 'entry-title', 0 ) . '>', '</' . $theme_heading_tag . '>' );
				?>
			</header>

			<?php MrGiraffe_singular_before_inner_hook();  ?>

			<div class="entry-content" <?php MrGiraffe_schema_microdata( 'text' ); ?>>
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'QHFZBIO' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->

			<span class="entry-meta">
				<?php do_action( 'MrGiraffe_singular_utility_hook' ); ?>
			</span>

		</div><!-- .article-inner -->
		<?php MrGiraffe_singular_after_inner_hook();  ?>
	</article><!-- #post-## -->
	<?php comments_template( '', true ); ?>

<?php endwhile; ?>
