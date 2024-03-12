<?php
/**
 * Core theme functions
 *
 * @package QHFZBIO
 */


 /**
  * Calculates the correct content_width value depending on site with and configured layout
  */
if ( ! function_exists( 'QHFZBIO_content_width' ) ) :
function QHFZBIO_content_width() {
	global $content_width;
	$deviation = 0.85;

	$options = MrGiraffe_get_option( array(
		'theme_sitelayout', 'theme_landingpage', 'theme_magazinelayout', 'theme_sitewidth', 'theme_primarysidebar', 'theme_secondarysidebar',
   ) );

	$content_width = 0.98 * (int)$options['theme_sitewidth'];

	if ( in_array( $options['theme_sitelayout'], array( '2cSl', '3cSl', '3cSr', '3cSs' ) ) ) {	// primary sidebar
		$content_width -= (int)$options['theme_primarysidebar'];
	};
	if ( in_array( $options['theme_sitelayout'], array( '2cSr', '3cSl', '3cSr', '3cSs' ) ) ) {	// secondary sidebar
		$content_width -= (int)$options['theme_secondarysidebar'];
	};

	if ( is_front_page() && $options['theme_landingpage'] ) {
		// landing page could be a special case;
		$width = ceil( (int)$content_width / apply_filters('QHFZBIO_lppostslayout_filter', (int)$options['theme_magazinelayout']) );
		$content_width = ceil($width);
		return;
	}

	if ( is_archive() ) {
		switch ( $options['theme_magazinelayout'] ):
			case 1: $content_width = floor($content_width*0.4); break; // magazine-one
			case 2: $content_width = floor($content_width*0.94/2); break; // magazine-two
			case 3: $content_width = floor($content_width*0.94/3); break; // magazine-three
		endswitch;
	};

	$content_width = floor($content_width*$deviation);

} // QHFZBIO_content_width()
endif;

 /**
  * Calculates the correct featured image width depending on site with and configured layout
  * Used by QHFZBIO_setup()
  */
if ( ! function_exists( 'QHFZBIO_featured_width' ) ) :
function QHFZBIO_featured_width() {

	$options = MrGiraffe_get_option( array(
		'theme_sitelayout', 'theme_landingpage', 'theme_magazinelayout', 'theme_sitewidth', 'theme_primarysidebar', 'theme_secondarysidebar',
		'theme_lplayout',
	) );

	// layout needs to be filtered thorougly
	$options['theme_sitelayout'] = MrGiraffe_get_layout( 'theme_sitelayout' );

	$width = (int)$options['theme_sitewidth'];

	$deviation = 0.02 * $width; // content to sidebar(s) margin

	if ( in_array( $options['theme_sitelayout'], array( '2cSl', '3cSl', '3cSr', '3cSs' ) ) ) {	// primary sidebar
		$width -= (int)$options['theme_primarysidebar'] + $deviation;
	};
	if ( in_array( $options['theme_sitelayout'], array( '2cSr', '3cSl', '3cSr', '3cSs' ) ) ) {	// secondary sidebar
		$width -= (int)$options['theme_secondarysidebar'] + $deviation;
	};

	if ( is_front_page() && $options['theme_landingpage'] ) {
		// landing page is a special case
		$width = ceil( (int)$options['theme_sitewidth'] / apply_filters('QHFZBIO_lppostslayout_filter', (int)$options['theme_magazinelayout'] ) );
		return ceil($width);
	}

	if ( ! is_singular() ) {
		switch ( $options['theme_magazinelayout'] ):
			case 1: $width = ceil($width*0.4); break; // magazine-one
			case 2: $width = ceil($width*0.94/2); break; // magazine-two
			case 3: $width = ceil($width*0.94/3); break; // magazine-three
		endswitch;
	};

	return ceil($width);
	// also used on images registration

} // QHFZBIO_featured_width()
endif;


 /**
  * Check if a header image is being used
  * Returns the URL of the image or FALSE
  */
if ( ! function_exists( 'QHFZBIO_header_image_url' ) ) :
function QHFZBIO_header_image_url() {
	$headerlimits = MrGiraffe_get_option( 'theme_headerlimits' );
	if ($headerlimits) $limit = 0.75; else $limit = 0;

	$theme_fheader = apply_filters( 'QHFZBIO_header_image', MrGiraffe_get_option( 'theme_fheader' ) );
	$theme_headerh = floor( MrGiraffe_get_option( 'theme_headerheight' ) * $limit );
	$theme_headerw = floor( MrGiraffe_get_option( 'theme_sitewidth' ) * $limit );

	// Check if this is a post or page, if it has a thumbnail, and if it's a big one
	$post_id = false;
	global $post;
	if ( !empty( $post->ID ) ) $post_id = $post->ID;

	// Check if static frontpage (but not landing page)
	if ( is_front_page() && ! is_home() && ! MrGiraffe_is_landingpage() ) {
		$front_id = get_option( 'page_on_front' );
		if ( !empty( $front_id ) ) $post_id = $front_id;
	}
	// Check if blog page
	if ( MrGiraffe_on_blog() ) {
		$blog_id = get_option( 'page_for_posts' );
		if ( !empty( $blog_id ) ) $post_id = $blog_id;
	}

	// WooCommerce gets separate handling for its non-page sections
	$woo = false;
	$woo_featured_in_header = apply_filters( 'QHFZBIO_featured_header_in_wc', true );
	if ( $woo_featured_in_header && function_exists ( "is_woocommerce" ) && is_woocommerce() && ! is_singular() ) {
		$shop_id = wc_get_page_id( 'shop' ); // myaccount, edit_address, shop, cart, checkout, pay, view_order, terms
		if ( !empty( $shop_id ) ) {
			$post_id = $shop_id;
			$woo = true;
		}
	}

	// default to general header image
	$header_image = FALSE;
	if ( get_header_image() != '' ) { $header_image = get_header_image(); }

	if ( ( is_singular() || $woo || MrGiraffe_on_blog() ) && has_post_thumbnail( $post_id ) && $theme_fheader &&
		( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'QHFZBIO-header' ) )
		 ) :
			if ( ( absint($image[1]) >= $theme_headerw ) && ( absint($image[2]) >= $theme_headerh ) ) {
				// 'header' image is large enough
				$header_image = $image[0];
			} else {
				// 'header' image too small, try 'full' image instead
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
				if ( ( absint($image[1]) >= $theme_headerw ) && ( absint($image[2]) >= $theme_headerh ) ) {
					// 'full' image is large enough
					$header_image = $image[0];
				}
				// else: even 'full' image is too small, don't return an image
			}
	endif;

	return apply_filters( 'QHFZBIO_header_image_url', $header_image );
} //QHFZBIO_header_image_url()
endif;

/**
 * Header image handler
 * Both as normal img and background image
 */
add_action ( 'MrGiraffe_headerimage_hook', 'QHFZBIO_header_image', 99 );
if ( ! function_exists( 'QHFZBIO_header_image' ) ) :
function QHFZBIO_header_image() {
	if ( MrGiraffe_on_landingpage() && MrGiraffe_get_option('theme_lpslider') != 3) return; // if on landing page and static slider not set to header image, exit.
	$header_image = QHFZBIO_header_image_url();
	if ( is_front_page() && function_exists( 'the_custom_header_markup' ) && has_header_video() ) {
		the_custom_header_markup();
	} elseif ( ! empty( $header_image ) ) { ?>
			<div id="header-overlay"></div>
			<div class="header-image" <?php MrGiraffe_echo_bgimage( esc_url( $header_image ) ) ?>></div>
			<img class="header-image" alt="<?php if ( is_single() ) the_title_attribute(); elseif ( is_archive() ) echo esc_attr( get_the_archive_title() ); else echo esc_attr( get_bloginfo( 'name' ) ) ?>" src="<?php echo esc_url( $header_image ) ?>" />
			<?php MrGiraffe_header_widget_hook(); ?>
	<?php }
} // QHFZBIO_header_image()
endif;

if ( ! function_exists( 'QHFZBIO_header_title_check' ) ) :
function QHFZBIO_header_title_check() {
	return true;
    $options = MrGiraffe_get_option( array( 'theme_headertitles_posts', 'theme_headertitles_pages', 'theme_headertitles_archives', 'theme_headertitles_home' ) );

	// woocommerce should never use header titles
	if (function_exists('is_woocommerce') && is_woocommerce()) return false;

	// theme's landing page
	if ( MrGiraffe_on_landingpage() && $options['theme_headertitles_home'] ) return true;

	// blog section
	if ( is_home() && $options['theme_headertitles_home'] ) return true;

	// other instances
	if ( ( is_single() && $options['theme_headertitles_posts'] ) ||
    ( is_page() && $options['theme_headertitles_pages'] && ! MrGiraffe_on_landingpage() ) ||
    ( ( is_archive() || is_search() || is_404() ) && $options['theme_headertitles_archives'] ) ||
    ( ( is_home() ) && $options['theme_headertitles_home'] ) ) {
        return true;
    }
	return false;
} // QHFZBIO_header_title_check()
endif;

/**
 * Header Title and meta
 */
add_action ( 'MrGiraffe_headerimage_hook', 'QHFZBIO_header_title', 100 );
if ( ! function_exists( 'QHFZBIO_header_title' ) ) :
function QHFZBIO_header_title() {
    if ( MrGiraffe_on_landingpage() && MrGiraffe_get_option('theme_lpslider') != 3) return; // if on landing page and static slider not set to header image, exit.

    if ( QHFZBIO_header_title_check() ) : ?>
    <div id="header-page-title">
        <div id="header-page-title-inside">
			<?php if ( is_author() ) {?>
				<div id="author-avatar" <?php MrGiraffe_schema_microdata( 'image' );?>>
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'QHFZBIO_author_bio_avatar_size', 80 ), '', '', array( 'extra_attr' => MrGiraffe_schema_microdata( 'url', 0) ) ); ?>
				</div><!-- #author-avatar -->
			<?php } ?>
			<div class="entry-meta pretitle-meta">
				<?php MrGiraffe_headertitle_topmeta_hook(); ?>
			</div><!-- .entry-meta -->
            <?php
			if ( is_front_page() ) {
				echo '<h2 class="entry-title" ' . MrGiraffe_schema_microdata('entry-title', 0) . '>' . esc_html( get_bloginfo( 'name', 'display' ) ) . '</h2><p class="byline">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
			} elseif ( is_singular() )  {
                the_title( '<div class="entry-title">', '</div>' );
            } else {
                    echo '<div class="entry-title">';
					if ( is_home() ) {
						single_post_title();
					}
					if ( function_exists( 'is_shop' ) && is_shop() ) {
						echo wp_kses( get_the_title( wc_get_page_id( 'shop' ) ), array() );
					} elseif ( is_archive() ) {
                        echo wp_kses(get_the_archive_title(), array());
                    }
                    if ( is_search() ) {
                        printf( __( 'Search Results for: %s', 'QHFZBIO' ), '' . get_search_query() . '' );
                    }
                    if ( is_404() ) {
                        _e( 'Not Found', 'QHFZBIO' );
                    }
                    echo '</div>';
            }
			?>
			<div class="entry-meta aftertitle-meta">
				<?php MrGiraffe_headertitle_bottommeta_hook(); ?>
				<?php MrGiraffe_breadcrumbs_hook();?>
			</div><!-- .entry-meta -->
			<div class="byline">
				<?php
				if ( is_singular( array('post', 'page') ) && has_excerpt() && MrGiraffe_get_option('theme_meta_single_byline')) {
					echo wp_kses_post( get_the_excerpt() );
				}
				// category description before content is handled on 'theme_meta_blog_byline' == 2 through body classes and CSS
				if ( ( ( is_archive() && !function_exists( 'is_shop' ) ) || ( is_archive() && !is_shop() ) ) && MrGiraffe_get_option('theme_meta_blog_byline') == 1 ) {
					echo wp_kses_post( get_the_archive_description() );
				}
				if ( is_search() ) {
					echo get_search_form();
				}
				?>
			</div>
        </div>
    </div> <?php endif;
} // QHFZBIO_header_title()
endif;

/**
 * Remove the labels from archive titles
 */
function QHFZBIO_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }

    return $title;
} // QHFZBIO_archive_title()

add_filter( 'get_the_archive_title', 'QHFZBIO_archive_title' );


/**
 * Adds title and description to header
 * Used in header.php
*/
if ( ! function_exists( 'QHFZBIO_title_and_description' ) ) :
function QHFZBIO_title_and_description() {

	$options = MrGiraffe_get_option( array( 'theme_logoupload', 'theme_siteheader' ) );

	if ( in_array( $options['theme_siteheader'], array( 'logo', 'both' ) ) ) {
		QHFZBIO_logo_helper( $options['theme_logoupload'] );
	}
	if ( in_array( $options['theme_siteheader'], array( 'title', 'both', 'logo', 'empty' ) ) ) {
		$heading_tag = ( is_front_page() || ( is_home() ) ) ? 'h1' : 'div';
		echo '<div id="site-text">';
		echo '<' . $heading_tag . MrGiraffe_schema_microdata( 'site-title', 0 ) . ' id="site-title">';
		echo '<span> <a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home">' . esc_attr( get_bloginfo( 'name' ) ) . '</a> </span>';
		echo '</' . $heading_tag . '>';
		echo '<span id="site-description" ' . MrGiraffe_schema_microdata( 'site-description', 0 ) . ' >' . esc_attr( get_bloginfo( 'description' ) ). '</span>';
		echo '</div>';
	}
} // QHFZBIO_title_and_description()
endif;
add_action ( 'MrGiraffe_branding_hook', 'QHFZBIO_title_and_description' );

function QHFZBIO_logo_helper( $theme_logo ) {
		$wp_logo = str_replace( 'class="custom-logo-link"', 'id="logo" class="custom-logo-link" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"', get_custom_logo() );
		if ( ! empty( $wp_logo ) ) {
			echo '<div class="identity">' . $wp_logo . '</div>';
		} else {
			echo '';
		}
} // QHFZBIO_logo_helper()

// MrGiraffe_schema_publisher() located in MrGiraffe/prototypes.php
add_action( 'MrGiraffe_after_inner_hook', 'MrGiraffe_schema_publisher' );
add_action( 'MrGiraffe_singular_after_inner_hook', 'MrGiraffe_schema_publisher' );

// MrGiraffe_schema_main() located in MrGiraffe/prototypes.php
add_action( 'MrGiraffe_after_inner_hook', 'MrGiraffe_schema_main' );
add_action( 'MrGiraffe_singular_after_inner_hook', 'MrGiraffe_schema_main' );

// MrGiraffe_skiplink() located in MrGiraffe/prototypes.php
add_action( 'wp_body_open', 'MrGiraffe_skiplink', 2 );

/**
 * Back to top button
*/
function QHFZBIO_back_top() {
	echo '<button id="toTop" aria-label="' . __('Back to Top', 'QHFZBIO') . '"><i class="icon-back2top"></i> </button>';
} // QHFZBIO_back_top()
add_action( 'MrGiraffe_master_topfooter_hook', 'QHFZBIO_back_top' );


/**
 * Creates pagination for blog pages.
 */
if ( ! function_exists( 'QHFZBIO_pagination' ) ) :
function QHFZBIO_pagination( $pages = '', $range = 2, $prefix ='' ) {
	$pagination = MrGiraffe_get_option( 'theme_pagination' );
	if ( $pagination && function_exists( 'the_posts_pagination' ) ):
		the_posts_pagination( array(
			'prev_text' => '<i class="icon-pagination-left"></i>',
			'next_text' => '<i class="icon-pagination-right"></i>',
			'mid_size' => $range
		) );
	else:
		//posts_nav_link();
		QHFZBIO_content_nav( 'nav-old-below' );
	endif;

} // QHFZBIO_pagination()
endif;

/**
 * Prev/Next page links
 */
if ( ! function_exists( 'QHFZBIO_nextpage_links' ) ) :
function QHFZBIO_nextpage_links( $defaults ) {
	$args = array(
		'link_before'      => '<em>',
		'link_after'       => '</em>',
	);
	$r = wp_parse_args( $args, $defaults );
	return $r;
} // QHFZBIO_nextpage_links()
endif;
add_filter( 'wp_link_pages_args', 'QHFZBIO_nextpage_links' );

/**
 * Fixed prev/next post links are defined in single.php for both cases
 */

/**
 * Footer Hook
 */
add_action( 'MrGiraffe_master_footerbottom_hook', 'QHFZBIO_master_footer' );
function QHFZBIO_master_footer() {
	$the_theme = wp_get_theme();
	do_action( 'MrGiraffe_footer_hook' );
	echo '<div style="display:block; margin: 0.5em auto;">' . __( "Powered by", "QHFZBIO" ) .
		'<a target="_blank" href="' . esc_html( $the_theme->get( 'ThemeURI' ) ) . '" title="';
	echo 'QHFZBIO WordPress Theme by ' . 'MrGiraffe Creations"> ' . 'QHFZBIO' .'</a> &amp; <a target="_blank" href="' . "http://wordpress.org/";
	echo '" title="' . esc_attr__( "Semantic Personal Publishing Platform", "QHFZBIO") . '"> ' . sprintf( " %s", "WordPress" ) . '</a>.</div>';
}

add_action( 'MrGiraffe_master_footer_hook', 'QHFZBIO_copyright' );
function QHFZBIO_copyright() {
    echo '<div id="site-copyright">' . do_shortcode( MrGiraffe_get_option( 'theme_copyright' ) ). '</div>';
}

/*
 * Sidebar handler
*/
if ( ! function_exists( 'QHFZBIO_get_sidebar' ) ) :
function QHFZBIO_get_sidebar() {

	$layout = MrGiraffe_get_layout();

	switch( $layout ) {
		case '2cSl':
			get_sidebar( 'left' );
		break;

		case '2cSr':
			get_sidebar( 'right' );
		break;

		case '3cSl' : case '3cSr' : case '3cSs' :
			get_sidebar( 'left' );
			get_sidebar( 'right' );
		break;

		default:
		break;
	}
} // QHFZBIO_get_sidebar()
endif;

/*
 * General layout class
 */
if ( ! function_exists( 'QHFZBIO_get_layout_class' ) ) :
function QHFZBIO_get_layout_class( $echo = true ) {

	$layout = MrGiraffe_get_layout();

	/*  If not, return the general layout */
	switch( $layout ) {
		case '2cSl': $class = "two-columns-left"; break;
		case '2cSr': $class = "two-columns-right"; break;
		case '3cSl': $class = "three-columns-left"; break;
		case '3cSr' : $class = "three-columns-right"; break;
		case '3cSs' : $class = "three-columns-sided"; break;
		case '1c':
		default: $class = "one-column"; break;
	}
	// allow the generated layout class to be filtered
	$output = esc_attr( apply_filters( 'QHFZBIO_general_layout_class', $class, $layout ) );

	if ( $echo ) {
		echo $output;
	} else {
		return $output;
	}
} // QHFZBIO_get_layout_class()
endif;

/**
* Checks the browser agent string for mobile ids and adds "mobile" class to body if true
*/
add_filter( 'body_class', 'MrGiraffe_mobile_body_class');


/**
* Creates breadcrumbs with page sublevels and category sublevels.
* Hooked in master hook
*/
if ( ! function_exists( 'QHFZBIO_breadcrumbs' ) ) :
function QHFZBIO_breadcrumbs() {
	MrGiraffe_breadcrumbs(
		'',														// $separator, usually <i class="icon-bread-arrow"></i>
		'<i class="icon-bread-home"></i>', 						// $home
		1,														// $showCurrent
		'<span class="current">', 								// $before
		'</span>', 												// $after
		'<div id="breadcrumbs-container" class="MrGiraffe %1$s"><div id="breadcrumbs-container-inside"><div id="breadcrumbs"> <nav id="breadcrumbs-nav" %2$s>', // $wrapper_pre
		'</nav></div></div></div><!-- breadcrumbs -->', 		// $wrapper_post
		QHFZBIO_get_layout_class(false),						// $layout_class
		__( 'Home', 'QHFZBIO' ),								// $text_home
		__( 'Archive for category "%s"', 'QHFZBIO' ),			// $text_archive
		__( 'Search results for "%s"', 'QHFZBIO' ), 			// $text_search
		__( 'Posts tagged', 'QHFZBIO' ), 						// $text_tag
		__( 'Articles posted by', 'QHFZBIO' ), 					// $text_author
		__( 'Not Found', 'QHFZBIO' ),							// $text_404
		__( 'Post format', 'QHFZBIO' ),							// $text_format
		__( 'Page', 'QHFZBIO' )									// $text_page
	);
} // QHFZBIO_breadcrumbs()
endif;


/**
 * Adds searchboxes to the appropriate menu location
 * Hooked in master hook
 */
if ( ! function_exists( 'MrGiraffe_search_menu' ) ) :
function MrGiraffe_search_menu( $items, $args ) {
$options = MrGiraffe_get_option( array( 'theme_searchboxmain', 'theme_searchboxfooter' ) );

	if( $args->theme_location == 'primary' && $options['theme_searchboxmain'] ) {
		$container_class = 'menu-main-search';
		$items = "<li class='" . $container_class . " menu-search-animated'>" . get_search_form( false ) . "</li>" . $items; // reverse order
	}
	if( $args->theme_location == 'footer' && $options['theme_searchboxfooter'] ) {
		$container_class = 'menu-footer-search';
		$items .= "<li class='" . $container_class . "'>" . get_search_form( false ) . "</li>";
	}
	return $items;
} // MrGiraffe_search_mainmenu()
endif;

/**
 * Adds burger icon to main menu for an extra menu
 * Hooked in master hook
 */
if ( ! function_exists( 'MrGiraffe_burger_menu' ) ) :
function MrGiraffe_burger_menu( $items, $args = array() ) {
	$button_html = "<li class=''>
	</li>";
	if (isset($args->theme_location)) {
		// filtering wp_nav_menu_items
		if( $args->theme_location == 'primary' ) {
			$items .= $button_html;
		}
	} elseif (isset($args['menu_id']) && ('prime_nav' == $args['menu_id'])) {
		// filtering wp_page_menu_args
		$items = preg_replace( '/<\/ul>/is', $button_html . '</ul>', $items );
	};
	return $items;
} // MrGiraffe_burger_menu()
endif;

/**
 * Normalizes tags widget font when needed
 */
if ( TRUE === MrGiraffe_get_option( 'theme_normalizetags' ) ) add_filter( 'wp_generate_tag_cloud', 'MrGiraffe_normalizetags' );

/**
 * Adds preloader
 */
function QHFZBIO_preloader() {
	$theme_preloader = MrGiraffe_get_option( 'theme_preloader' );
	if ( ( $theme_preloader == 1) || ( $theme_preloader == 2 && (is_front_page() || is_home()) ) ): ?>
		<div class="MrGiraffe-preloader">
			<div class="MrGiraffe-preloader-inside">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
			</div>
		</div>
	<?php endif;
}
add_action( 'MrGiraffe_body_hook', 'QHFZBIO_preloader' );

/**
 * Adds failsafe styling for preloader and lazyloading functionality
 */
function QHFZBIO_header_failsafes() {
	$options = MrGiraffe_get_option( array( 'theme_preloader', 'theme_lazyimages' ) );
	?><noscript><style><?php
		if ( $options['theme_preloader'] ) { ?>.MrGiraffe .MrGiraffe-preloader {display: none;}<?php }
		if ( $options['theme_lazyimages'] !=0 ) { ?>.MrGiraffe img[loading="lazy"] {opacity: 1;}<?php }
	?></style></noscript>
<?php
} // QHFZBIO_header_failsafes()
add_action( 'wp_head', 'QHFZBIO_header_failsafes', 11 );

/**
* Master hook to bypass customizer options
*/
if ( ! function_exists( 'QHFZBIO_master_hook' ) ) :
function QHFZBIO_master_hook() {
	$theme_interim_options = MrGiraffe_get_option( array(
		'theme_breadcrumbs',
		'theme_searchboxmain',
		'theme_searchboxfooter',
		'theme_comlabels')
	);

	if ( $theme_interim_options['theme_breadcrumbs'] )  add_action( 'MrGiraffe_breadcrumbs_hook', 'QHFZBIO_breadcrumbs' );
	if ( $theme_interim_options['theme_searchboxmain'] || $theme_interim_options['theme_searchboxfooter'] ) add_filter( 'wp_nav_menu_items', 'MrGiraffe_search_menu', 10, 2);
	//if ( has_nav_menu( 'top' ) ) add_filter( 'wp_nav_menu_items', 'MrGiraffe_burger_menu', 10, 2); // add burger menu icon to standard main navigation
	//if ( has_nav_menu( 'top' ) ) add_filter( 'wp_page_menu', 'MrGiraffe_burger_menu', 12, 2); // add burger menu icon to failsafe pages main navigation

	if ( $theme_interim_options['theme_comlabels'] == 1 || $theme_interim_options['theme_comlabels'] == 3) {
		add_filter( 'comment_form_default_fields', 'QHFZBIO_comments_form' );
		add_filter( 'comment_form_field_comment', 'QHFZBIO_comments_form_textarea' );
	}

	if ( MrGiraffe_get_option( 'theme_socials_header' ) ) 		add_action( 'MrGiraffe_header_socials_hook', 'QHFZBIO_socials_menu_header', 10 );
	if ( MrGiraffe_get_option( 'theme_socials_footer' ) ) 		add_action( 'MrGiraffe_master_footer_hook', 'QHFZBIO_socials_menu_footer', 5 );
	if ( MrGiraffe_get_option( 'theme_socials_left_sidebar' ) ) 	add_action( 'MrGiraffe_before_primary_widgets_hook', 'QHFZBIO_socials_menu_left', 5 );
	if ( MrGiraffe_get_option( 'theme_socials_right_sidebar' ) ) 	add_action( 'MrGiraffe_before_secondary_widgets_hook', 'QHFZBIO_socials_menu_right', 5 );
};
endif;
add_action( 'wp', 'QHFZBIO_master_hook' );


// Boxes image size
function QHFZBIO_lpbox_width( $options = array() ) {

	if ( $options['theme_lpboxlayout1'] == 1 ) {
		$totalwidth = 1920;
	} else {
		$totalwidth = $options['theme_sitewidth'];
	}
	$options['theme_lpboxwidth1'] = intval ( $totalwidth / $options['theme_lpboxrow1'] );

	if ( $options['theme_lpboxlayout2'] == 1 ) {
		$totalwidth = 1920;
	} else {
		$totalwidth = $options['theme_sitewidth'];
	}
	$options['theme_lpboxwidth2'] = intval ( $totalwidth / $options['theme_lpboxrow2'] );

	return $options;
} // QHFZBIO_lpbox_width()

// Used for the landing page blocks auto excerpts
function QHFZBIO_custom_excerpt( $text = '', $length = 35, $more = '...' ) {
	$raw_excerpt = $text;

	//handle the <!--more--> and <!--nextpage--> tags
	$moretag = false;
	if (strpos( $text, '<!--nextpage-->' )) $explodemore = explode('<!--nextpage-->', $text);
	if (strpos( $text, '<!--more-->' )) $explodemore = explode('<!--more-->', $text);
	if (!empty($explodemore[1])) {
		// tag was found
		$text = $explodemore[0];
		$moretag = true;
	}

	if ( '' != $text ) {
		$text = strip_shortcodes( $text );

		$text = str_replace(']]>', ']]&gt;', $text);

		// Filters the number of words in an excerpt. Default 35.
		$excerpt_length = apply_filters( 'QHFZBIO_custom_excerpt_length', $length );

		if ($excerpt_length == 0) return '';

		// Filters the string in the "more" link displayed after a trimmed excerpt.
		$excerpt_more = apply_filters( 'QHFZBIO_custom_excerpt_more', $more );
		if (!$moretag) {
			$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		}
	}
	return apply_filters( 'QHFZBIO_custom_excerpt', $text, $raw_excerpt );
} // QHFZBIO_custom_excerpt()

// ajax load more button alternative hook
add_action( 'template_redirect', 'MrGiraffe_ajax_init' );

//
function QHFZBIO_check_empty_menu( $menu_id ) {
	if (! has_nav_menu( $menu_id ) ) return true;

    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_id ] ) ) {
        $menu = wp_get_nav_menu_object( $locations[ $menu_id ] );
		$menu_items = wp_get_nav_menu_items( $menu->term_id );

		if( isset($menu_items) ) {
			return $menu_items;
		}

    }
	return false;
}

/* FIN */
