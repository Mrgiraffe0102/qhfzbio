<?php
/**
 * Functions used in the main loop
 *
 * @package QHFZBIO
 */

/**
 * Sets the post excerpt length to the number of words set in the theme settings
 */
function QHFZBIO_excerpt_length_words( $length ) {
	if ( is_admin() ) {
		return $length;
	}

	return absint( MrGiraffe_get_option( 'theme_excerptlength' ) );
}
add_filter( 'excerpt_length', 'QHFZBIO_excerpt_length_words' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 */
function QHFZBIO_custom_excerpt_more() {
	if ( ! is_attachment() ) {
		 echo wp_kses_post( QHFZBIO_continue_reading_link() );
	}
}
add_action( 'MrGiraffe_post_excerpt_hook', 'QHFZBIO_custom_excerpt_more', 10 );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function QHFZBIO_continue_reading_link() {
	$theme_excerptcont = MrGiraffe_get_option( 'theme_excerptcont' );
	return '<a class="continue-reading-link" href="'. esc_url( get_permalink() ) . '"><span>' . wp_kses_post( $theme_excerptcont ). '</span><i class="icon-continue-reading"></i><em class="screen-reader-text">"' . get_the_title() . '"</em></a>';
}
add_filter( 'the_content_more_link', 'QHFZBIO_continue_reading_link' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and QHFZBIO_continue_reading_link().
 */
function QHFZBIO_auto_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	if ( MrGiraffe_get_option( 'theme_excerptdots' ) ) {
		return wp_kses_post( MrGiraffe_get_option( 'theme_excerptdots' ) );
	} else {
		return '<span class="excerpt-fade"></span>';
	}
}
add_filter( 'excerpt_more', 'QHFZBIO_auto_excerpt_more' );

/**
 * Adds a "Continue Reading" link to post excerpts created using the <!--more--> tag.
 */
function QHFZBIO_more_link( $more_link, $more_link_text ) {
	$theme_excerptcont = MrGiraffe_get_option( 'theme_excerptcont' );
	$new_link_text = $theme_excerptcont;
	if ( preg_match( "/custom=(.*)/", $more_link_text, $m ) ) {
		$new_link_text = $m[1];
	}
	$more_link = str_replace( $more_link_text, $new_link_text, $more_link );
	$more_link = str_replace( 'more-link', 'continue-reading-link', $more_link );
	return $more_link;
}
add_filter( 'the_content_more_link', 'QHFZBIO_more_link', 10, 2 );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 * Galleries are styled by the theme in style.css.
 */
function QHFZBIO_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'QHFZBIO_remove_gallery_css' );

/**
 * Posted in category
 */
if ( ! function_exists( 'QHFZBIO_posted_category' ) ) :
function QHFZBIO_posted_category() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_category = MrGiraffe_get_option( 'theme_meta_blog_category' );

	if ( is_single() ) {
		$theme_meta_category = MrGiraffe_get_option( 'theme_meta_single_category' );
	}

	if ( $theme_meta_category && get_the_category_list() ) {
		echo '<span class="bl_categ"' . MrGiraffe_schema_microdata( 'category', 0 ) . '>' .
					'<i class="icon-category icon-metas" title="' . esc_attr__( "Categories", "QHFZBIO" ) . '"></i>' .
					'<span class="category-metas"> '
					 . get_the_category_list( ' <span class="sep"></span> ' ) .
				'</span></span>';
	}
} // QHFZBIO_posted_category()
endif;

/**
 * Posted by author
 */
if ( ! function_exists( 'QHFZBIO_posted_author' )) :
function QHFZBIO_posted_author() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_blog_author = MrGiraffe_get_option( 'theme_meta_blog_author' );

	if ( $theme_meta_blog_author ) {
		echo sprintf(
			'<span class="author vcard"' . MrGiraffe_schema_microdata( 'author', 0 ) . '>
				<i class="icon-author icon-metas" title="' . esc_attr__( "Author", "QHFZBIO" ) . '"></i>
				<a class="url fn n" rel="author" href="%1$s" title="%2$s"' . MrGiraffe_schema_microdata( 'author-url', 0 ) . '>
					<em' .  MrGiraffe_schema_microdata( 'author-name', 0 ) . '>%3$s</em></a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'QHFZBIO' ), get_the_author() ),
			get_the_author()
		);
	}
} // QHFZBIO_posted_author
endif;

/**
 * Posted by author for single posts
 */
if ( ! function_exists( 'QHFZBIO_posted_author_single' )) :
function QHFZBIO_posted_author_single() {
	$theme_meta_single_author = MrGiraffe_get_option( 'theme_meta_single_author' );
	global $post;
	$author_id = $post->post_author;

	if ( $theme_meta_single_author ) {
		echo sprintf(
			'<div class="author-container">' .
			'<span class="author vcard"' . MrGiraffe_schema_microdata( 'author', 0 ) . '>' .
				'<a class="url fn n" rel="author" href="%1$s" title="%2$s"' . MrGiraffe_schema_microdata( 'author-url', 0 ) . '>
					<span class="author-avatar" >' . get_avatar( $author_id ) . '</span>
					<em' .  MrGiraffe_schema_microdata( 'author-name', 0 ) . '>%3$s</em></a>' .
			'</span></div>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID', 	$author_id ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'QHFZBIO' ), wp_kses( get_the_author_meta( 'display_name', $author_id) , array() ) ),
			wp_kses( get_the_author_meta( 'display_name', $author_id), array() )
		);
	}
} // QHFZBIO_posted_author_single
endif;

/**
 * Posted date/time, tags
 */
if ( ! function_exists( 'QHFZBIO_posted_date' ) ) :
function QHFZBIO_posted_date() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_date = MrGiraffe_get_option( 'theme_meta_blog_date' );
	$theme_meta_time = MrGiraffe_get_option( 'theme_meta_blog_time' );

	if ( is_single() ) {
		$theme_meta_date = MrGiraffe_get_option( 'theme_meta_single_date' );
		$theme_meta_time = MrGiraffe_get_option( 'theme_meta_single_time' );
	}

	// Post date/time
	if ( $theme_meta_date || $theme_meta_time ) {
		$date = ''; $time = '';
		if ( $theme_meta_date ) { $date = esc_html( get_the_date() ); }
		if ( $theme_meta_time ) { $time = esc_html( get_the_time() ); }
		?>

		<span class="onDate date" >
				<i class="icon-date icon-metas" title="<?php esc_attr_e( "Date", "QHFZBIO" ) ?>"></i>
				<time class="published" datetime="<?php echo esc_attr( get_the_time( 'c' ) ) ?>" <?php MrGiraffe_schema_microdata( 'time' ) ?>>
					<?php echo $date . ( ( $theme_meta_date && $theme_meta_time ) ? ', ' : '' ) . $time ?>
				</time>
				<time class="updated" datetime="<?php echo esc_attr( get_the_modified_time( 'c' ) ) ?>" <?php MrGiraffe_schema_microdata( 'time-modified' ) ?>><?php echo esc_html( get_the_modified_date() );?></time>
		</span>
		<?php
	}

}; // QHFZBIO_posted_date()
endif;

/**
 * Posted tags
 */
if ( ! function_exists( 'QHFZBIO_posted_tags' ) ) :
function QHFZBIO_posted_tags() {
	if ( 'post' !== get_post_type() ) return;
	$theme_meta_tag  = MrGiraffe_get_option( 'theme_meta_blog_tag' );

	if ( is_single() ) {
		$theme_meta_tag = MrGiraffe_get_option( 'theme_meta_single_tag' );
	}

	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '<span class="sep">#</span>', ' <span class="sep">#</span>' );
	if ( $theme_meta_tag && $tag_list ) { ?>
		<span class="tags" <?php MrGiraffe_schema_microdata( 'tags' ) ?>>
				<i class="icon-tag icon-metas" title="<?php esc_attr_e( 'Tagged', 'QHFZBIO' ) ?>"></i>&nbsp;<?php echo $tag_list ?>
		</span>
		<?php
	}
}//QHFZBIO_posted_tags()
endif;

/**
 * Post edit link for editors
 */
if ( ! function_exists( 'QHFZBIO_posted_edit' ) ) :
function QHFZBIO_posted_edit() {
	edit_post_link( sprintf( __( 'Edit %s', 'QHFZBIO' ), '<em class="screen-reader-text">"' . get_the_title() . '"</em>' ), '<span class="edit-link"><i class="icon-edit icon-metas"></i> ', '</span>' );
}; // QHFZBIO_posted_edit()
endif;

/**
 * Post format meta
 */
if ( ! function_exists( 'QHFZBIO_meta_format' ) ) :
function QHFZBIO_meta_format() {
	if ( 'post' !== get_post_type() ) return;
	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format"><a href="%1$s"><i class="icon-%2$s" title="%3$s"></i> %2$s</a></span>',
			esc_url( get_post_format_link( $format ) ),
			esc_attr( $format ),
			esc_attr( get_post_format_string( $format ) )
		);
	}
} //QHFZBIO_meta_format()
endif;

/**
 * Post format meta
 */
if ( ! function_exists( 'QHFZBIO_meta_sticky' ) ) :
function QHFZBIO_meta_sticky() {
	if ( is_sticky() ) echo '<span class="entry-sticky">' . __('Featured', 'QHFZBIO') . '</span>';
} //QHFZBIO_meta_sticky()
endif;


/**
 * Header animated arrow
 */
if ( ! function_exists( 'QHFZBIO_meta_arrow' ) ) :
function QHFZBIO_meta_arrow() { ?>
	<a href="#main" class="meta-arrow" tabindex="-1">
			<i class="icon-arrow" title="<?php esc_attr_e( 'Read more', 'QHFZBIO' ) ?>"></i>
	</a>
<?php } //QHFZBIO_meta_arrow()
endif;
add_action('MrGiraffe_headerimage_hook', 'QHFZBIO_meta_arrow');

/**
 * Post metas locations
 */
function QHFZBIO_meta_infos() {

	//add_action( 'MrGiraffe_featured_hook', 'QHFZBIO_posted_edit', 50 ); // Edit button

	if ( is_single() ) { // If single, metas are shown after the title

		add_action( 'MrGiraffe_post_meta_hook',	'QHFZBIO_posted_author_single', 10 );
		add_action( 'MrGiraffe_post_meta_hook',	'QHFZBIO_posted_date', 30 );
		add_action( 'MrGiraffe_post_title_hook',	'QHFZBIO_posted_category', 20 );
		add_action( 'MrGiraffe_post_utility_hook',	'QHFZBIO_posted_edit', 60 ); // Edit button
		add_action( 'MrGiraffe_post_utility_hook',	'QHFZBIO_posted_tags', 40 );

		if ( QHFZBIO_header_title_check() ) {
			add_action( 'MrGiraffe_headertitle_topmeta_hook',	'QHFZBIO_posted_category', 20 );
			add_action( 'MrGiraffe_headertitle_bottommeta_hook',	'QHFZBIO_posted_date', 20 );
			add_action( 'MrGiraffe_headertitle_bottommeta_hook',	'QHFZBIO_posted_author_single', 30 );
			//add_action( 'MrGiraffe_headertitle_bottommeta_hook',	'QHFZBIO_posted_edit', 50 ); // Edit button
		}

	} else { // if blog page, metas are shown at the top of the article

		add_action( 'MrGiraffe_post_thumbnail_hook', 'QHFZBIO_comments_on', 50 ); // Comments
		add_action( 'MrGiraffe_post_thumbnail_hook', 'QHFZBIO_posted_category', 20 );
		add_action( 'MrGiraffe_post_meta_hook', 'QHFZBIO_posted_author', 15 );
		add_action( 'MrGiraffe_post_meta_hook', 'QHFZBIO_posted_date', 40 );
		add_action( 'MrGiraffe_post_utility_hook',	'QHFZBIO_posted_tags', 30 );

	}

	add_action( 'MrGiraffe_singular_utility_hook',	'QHFZBIO_posted_edit', 40 ); // Edit button
	add_action( 'MrGiraffe_meta_format_hook', 'QHFZBIO_meta_format', 10 ); // Post format
	add_action( 'MrGiraffe_post_title_hook', 'QHFZBIO_meta_sticky', 9 ); // Sticky posts

} //QHFZBIO_meta_infos()
add_action( 'wp_head', 'QHFZBIO_meta_infos' );

/**
 * Backup navigation
 */
if ( ! function_exists( 'QHFZBIO_content_nav' ) ) :
function QHFZBIO_content_nav( $nav_id ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) : ?>

		<nav id="<?php echo esc_attr( $nav_id ); ?>" class="navigation">

			<span class="nav-previous">
				 <?php next_posts_link( '<i class="icon-angle-left"></i>' . __( 'Older posts', 'QHFZBIO' ) ); ?>
			</span>

			<span class="nav-next">
				<?php previous_posts_link( __( 'Newer posts', 'QHFZBIO' ) . '<i class="icon-angle-right"></i>' ); ?>
			</span>

		</nav><!-- #<?php echo $nav_id; ?> -->

	<?php endif;
}; // QHFZBIO_content_nav()
endif;

/**
 * Adds a post thumbnail and if one doesn't exist the first post image is returned
 * @uses MrGiraffe_get_first_image( $postID )
 */
if ( ! function_exists( 'QHFZBIO_set_featured_srcset_picture' ) ) :
function QHFZBIO_set_featured_srcset_picture() {

	global $post;
	$options = MrGiraffe_get_option( array( 'theme_fpost', 'theme_fauto', 'theme_falign', 'theme_magazinelayout', 'theme_landingpage' ) );

	switch ( apply_filters( 'QHFZBIO_lppostslayout_filter', $options['theme_magazinelayout'] ) ) {
		case 3: $featured = 'QHFZBIO-featured-third'; break;
		case 2: $featured = 'QHFZBIO-featured-half'; break;
		case 1: default: $featured = 'QHFZBIO-featured'; break;
	}

	// filter to disable srcset if so desired
	$use_srcset = apply_filters( 'QHFZBIO_featured_srcset', true );

	if ( function_exists('has_post_thumbnail') && has_post_thumbnail() && $options['theme_fpost']) {
		// has featured image
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'QHFZBIO-featured' );
		$fimage_id = get_post_thumbnail_id( $post->ID );
	} elseif ( $options['theme_fpost'] && $options['theme_fauto'] && empty($featured_image) ) {
		// get the first image from post
		$featured_image = MrGiraffe_post_first_image( $post->ID, 'QHFZBIO-featured' );
		$fimage_id = $featured_image['id'];
	} else {
		// featured image not enabled or not obtainable
		$featured_image[0] = apply_filters('QHFZBIO_preview_img_src', '');
		$featured_image[1] = apply_filters('QHFZBIO_preview_img_w', '');
		$featured_image[2] = apply_filters('QHFZBIO_preview_img_h', '');
		$fimage_id = FALSE;
	};

	if ( ! empty( $featured_image[0] ) ) {

		$featured_width = QHFZBIO_featured_width();
		?>
		<div class="post-thumbnail-container" <?php MrGiraffe_schema_microdata( 'image' ); ?>>
			<div class="entry-meta">
				<?php do_action('MrGiraffe_post_thumbnail_hook'); ?>
			</div>
			<a class="post-featured-image" href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>" title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ) ?>" <?php MrGiraffe_echo_bgimage( $featured_image[0] ) ?> tabindex="-1">
			</a>
			<picture class="responsive-featured-image">
				<source media="(max-width: 1152px)" sizes="<?php echo esc_attr( MrGiraffe_gen_featured_sizes( $featured_width, $options['theme_magazinelayout'], $options['theme_landingpage'] ) ) ?>" srcset="<?php echo esc_url( MrGiraffe_get_picture_src( $fimage_id, 'QHFZBIO-featured-third' ) ); ?> 512w">
				<source media="(max-width: 800px)" sizes="<?php echo esc_attr( MrGiraffe_gen_featured_sizes( $featured_width, $options['theme_magazinelayout'], $options['theme_landingpage'] ) ) ?>" srcset="<?php echo esc_url( MrGiraffe_get_picture_src( $fimage_id, 'QHFZBIO-featured-half' ) ); ?> 800w">
				<?php if ( MrGiraffe_on_landingpage() ) { ?><source sizes="<?php echo esc_attr( MrGiraffe_gen_featured_sizes( $featured_width, $options['theme_magazinelayout'], $options['theme_landingpage'] ) ) ?>" srcset="<?php echo esc_url( MrGiraffe_get_picture_src( $fimage_id, 'QHFZBIO-featured-lp' ) ); ?> <?php printf( '%sw', absint( $featured_width ) ) ?>">
				<?php } ?>
				<img alt="<?php the_title_attribute();?>" <?php MrGiraffe_schema_microdata( 'url' ); ?> src="<?php echo esc_url( MrGiraffe_get_picture_src( $fimage_id, 'QHFZBIO-featured' ) ); ?>" width="<?php echo absint( $featured_image[1] ) ?>" height="<?php echo absint( $featured_image[2] ) ?>">
			</picture>
			<meta itemprop="width" content="<?php echo absint( $featured_image[1] ) ?>">
			<meta itemprop="height" content="<?php echo absint( $featured_image[2] ) ?>">
			<div class="featured-image-overlay">
				<a class="featured-image-link" href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>" title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ) ?>" tabindex="-1"></a>
			</div>
		</div>
	<?php } else { ?>
		<div class="entry-meta">
			<?php do_action('MrGiraffe_post_thumbnail_hook'); ?>
		</div>
		<?php // return false;
	}
} // QHFZBIO_set_featured_srcset_picture()
endif;
if ( MrGiraffe_get_option( 'theme_fpost' ) ) add_action( 'MrGiraffe_featured_hook', 'QHFZBIO_set_featured_srcset_picture' );

/* FIN */
