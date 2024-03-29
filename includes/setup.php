<?php
/*
 * Theme setup functions. Theme initialization, add_theme_support(), widgets, navigation
 *
 * @package QHFZBIO
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
add_action( 'after_setup_theme', 'QHFZBIO_content_width' ); // mostly for dashboard
add_action( 'template_redirect', 'QHFZBIO_content_width' );

/** Tell WordPress to run QHFZBIO_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'QHFZBIO_setup' );


/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function QHFZBIO_setup() {

	add_filter( 'QHFZBIO_theme_options_array', 'QHFZBIO_lpbox_width' );

	$options = MrGiraffe_get_option();

	// This theme styles the visual editor with editor-style.css to match the theme style.
	if ($options['theme_editorstyles']) add_editor_style( 'resources/styles/editor-style.css' );

	// Support title tag since WP 4.1
	add_theme_support( 'title-tag' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add HTML5 support
	add_theme_support( 'html5', array( 'script', 'style', 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	// Add post formats
	add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'audio', 'video' ) );

	// Make theme available for translation
	load_theme_textdomain( 'QHFZBIO', get_template_directory() . '/MrGiraffe/languages' );
	load_theme_textdomain( 'QHFZBIO', get_template_directory() . '/languages' );
	load_textdomain( 'MrGiraffe', '' );

	// This theme allows users to set a custom backgrounds
	add_theme_support( 'custom-background' );

	// This theme supports WordPress 4.5 logos
	add_theme_support( 'custom-logo', array( 'height' => (int) $options['theme_headerheight'], 'width' => 240, 'flex-height' => true, 'flex-width'  => true ) );
	add_filter( 'get_custom_logo', 'MrGiraffe_filter_wp_logo_img' );

	// This theme uses wp_nav_menu() in 3 locations.
	register_nav_menus( array(
		'primary'	=> __( 'Primary/Side Navigation', 'QHFZBIO' ),
		'top'		=> __( 'Header Navigation', 'QHFZBIO' ),
		'sidebar'	=> __( 'Left Sidebar', 'QHFZBIO' ),
		'footer'	=> __( 'Footer Navigation', 'QHFZBIO' ),
		'socials'	=> __( 'Social Icons', 'QHFZBIO' ),
	) );

	$fheight = $options['theme_fheight'];
	$falign = (bool)$options['theme_falign'];
	if (false===$falign) {
		$fheight = 0;
	} else {
		$falign = explode( ' ', $options['theme_falign'] );
		if (!is_array($falign) ) $falign = array( 'center', 'center' ); //failsafe
	}

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(
		// default Post Thumbnail dimensions
		apply_filters( 'QHFZBIO_thumbnail_image_width', QHFZBIO_featured_width() ),
		apply_filters( 'QHFZBIO_thumbnail_image_height', $options['theme_fheight'] ),
		false
	);
	// Custom image size for use with post thumbnails
	add_image_size( 'QHFZBIO-featured',
		apply_filters( 'QHFZBIO_featured_image_width', QHFZBIO_featured_width() ),
		apply_filters( 'QHFZBIO_featured_image_height', $fheight ),
		$falign
	);

	// Additional responsive image sizes
	add_image_size( 'QHFZBIO-featured-lp',
		apply_filters( 'QHFZBIO_featured_image_lp_width', ceil( $options['theme_sitewidth'] / apply_filters( 'QHFZBIO_lppostslayout_filter', $options['theme_magazinelayout'] ) ) ),
		apply_filters( 'QHFZBIO_featured_image_lp_height', $options['theme_fheight'] ),
		$falign
	);

	add_image_size( 'QHFZBIO-featured-half',
		apply_filters( 'QHFZBIO_featured_image_half_width', 800 ),
		apply_filters( 'QHFZBIO_featured_image_falf_height', $options['theme_fheight'] ),
		$falign
	);
	add_image_size( 'QHFZBIO-featured-third',
		apply_filters( 'QHFZBIO_featured_image_third_width', 512 ),
		apply_filters( 'QHFZBIO_featured_image_third_height', $options['theme_fheight'] ),
		$falign
	);

	// Boxes image sizes
	add_image_size( 'QHFZBIO-lpbox-1', $options['theme_lpboxwidth1'], $options['theme_lpboxheight1'], true );
	add_image_size( 'QHFZBIO-lpbox-2', $options['theme_lpboxwidth2'], $options['theme_lpboxheight2'], true );

	// Add support for flexible headers
	add_theme_support( 'custom-header', array(
		'flex-height' 	=> true,
		'height'		=> (int) $options['theme_headerheight'],
		'flex-width'	=> true,
		'width'			=> 1920,
		'default-image'	=> get_template_directory_uri() . '/resources/images/headers/mirrorlake.jpg',
		'video'         => true,
	));

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'mirrorlake' => array(
			'url' => '%s/resources/images/headers/mirrorlake.jpg',
			'thumbnail_url' => '%s/resources/images/headers/mirrorlake.jpg',
			'description' => __( 'Mirror lake', 'QHFZBIO' )
		)
	) );

	// Gutenberg
	// add_theme_support( 'wp-block-styles' ); // apply default block styles
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-color-palette', array(
		array(
			'name' => __( 'Accent #1', 'QHFZBIO' ),
			'slug' => 'accent-1',
			'color' => $options['theme_accent1'],
		),
		array(
			'name' => __( 'Accent #2', 'QHFZBIO' ),
			'slug' => 'accent-2',
			'color' => $options['theme_accent2'],
		),
		array(
			'name' => __( 'Content Headings', 'QHFZBIO' ),
			'slug' => 'headings',
			'color' => $options['theme_headingstext'],
		),
 		array(
			'name' => __( 'Site Text', 'QHFZBIO' ),
			'slug' => 'sitetext',
			'color' => $options['theme_sitetext'],
		),
		array(
			'name' => __( 'Content Background', 'QHFZBIO' ),
			'slug' => 'sitebg',
			'color' => $options['theme_contentbackground'],
		),
 	) );
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name' => __( 'small', 'MrGiraffe' ),
			'shortName' => __( 'S', 'MrGiraffe' ),
			'size' => intval( intval( $options['theme_fgeneralsize'] ) / 1.6 ),
			'slug' => 'small'
		),
		array(
			'name' => __( 'normal', 'MrGiraffe' ),
			'shortName' => __( 'M', 'MrGiraffe' ),
			'size' => intval( intval( $options['theme_fgeneralsize'] ) * 1.0 ),
			'slug' => 'normal'
		),
		array(
			'name' => __( 'large', 'MrGiraffe' ),
			'shortName' => __( 'L', 'MrGiraffe' ),
			'size' => intval( intval( $options['theme_fgeneralsize'] ) * 1.6 ),
			'slug' => 'large'
		),
		array(
			'name' => __( 'larger', 'MrGiraffe' ),
			'shortName' => __( 'XL', 'MrGiraffe' ),
			'size' => intval( intval( $options['theme_fgeneralsize'] ) * 2.56 ),
			'slug' => 'larger'
		)
	) );

	// WooCommerce compatibility
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

} // QHFZBIO_setup()

function QHFZBIO_gutenberg_editor_styles() {
	$editorstyles = MrGiraffe_get_option('theme_editorstyles');
	if ( ! $editorstyles ) return;
	wp_enqueue_style( 'QHFZBIO-gutenberg-editor-styles', get_theme_file_uri( '/resources/styles/gutenberg-editor.css' ), false, _MrGiraffe_THEME_VERSION, 'all' );
	wp_add_inline_style( 'QHFZBIO-gutenberg-editor-styles', preg_replace( "/[\n\r\t\s]+/", " ", QHFZBIO_editor_styles() ) );
}
add_action( 'enqueue_block_editor_assets', 'QHFZBIO_gutenberg_editor_styles' );

/*
 * Have two textdomains work with translation systems.
 * https://gist.github.com/justintadlock/7a605c29ae26c80878d0
 */
function QHFZBIO_override_load_textdomain( $override, $domain ) {
	// Check if the domain is our framework domain.
	if ( 'MrGiraffe' === $domain ) {
		global $l10n;
		// If the theme's textdomain is loaded, assign the theme's translations
		// to the framework's textdomain.
		if ( isset( $l10n[ 'QHFZBIO' ] ) )
			$l10n[ $domain ] = $l10n[ 'QHFZBIO' ];
		// Always override.  We only want the theme to handle translations.
		$override = true;
	}
	return $override;
}
add_filter( 'override_load_textdomain', 'QHFZBIO_override_load_textdomain', 10, 2 );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function QHFZBIO_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'QHFZBIO_page_menu_args' );

/**
 * Custom menu fallback, using wp_page_menu()
 * Created to make the fallback menu have the same HTML structure as the default
 */
function QHFZBIO_default_main_menu() {
    wp_page_menu($args = array(
		'menu_class'	=> 'side-menu side-section',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>',
		'before' 		=> '<ul id="mobile-nav">',
		'after' 		=> '</ul>'
	));
}

/**
 * Custom menu fallback, using wp_page_menu()
 * Created to make the fallback menu have the same HTML structure as the default
 */
function QHFZBIO_default_header_menu() {
    wp_page_menu($args = array(
		'menu_class'	=> '',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>',
		'before' 		=> '<ul id="top-nav" class="top-nav">',
		'after' 		=> '</ul>'
	));
}

/** Main/Side/Mobile menu */
function QHFZBIO_main_menu() {
	wp_nav_menu( array(
		'container'		=> '',
		'menu_id'		=> 'mobile-nav',
		'menu_class'	=> '',
		'theme_location'=> 'primary',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>',
		'items_wrap'	=> '<div class="side-menu side-section"><ul id="%s" class="%s">%s</ul></div>',
		'fallback_cb' 	=> 'QHFZBIO_default_main_menu'
	) );
} // QHFZBIO_main_menu()
add_action( 'MrGiraffe_mobilemenu_hook', 'QHFZBIO_main_menu' );

/** Header menu */
function QHFZBIO_header_menu() {
	wp_nav_menu( array(
		'container'		=> '',
		'menu_id'		=> 'top-nav',
		'menu_class'	=> '',
		'theme_location'=> 'top',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>',
		'items_wrap'	=> '<div><ul id="%s" class="%s">%s</ul></div>',
		'fallback_cb'    => 'QHFZBIO_default_header_menu'

	) );
} // QHFZBIO_header_menu()
add_action ( 'MrGiraffe_access_hook', 'QHFZBIO_header_menu' );

/** Left sidebar menu */
function QHFZBIO_sidebar_menu() {
	if ( has_nav_menu( 'sidebar' ) )
		wp_nav_menu( array(
			'container'			=> 'nav',
			'container_class'	=> 'sidebarmenu widget-container',
			'theme_location'	=> 'sidebar',
			'depth'				=> 1
		) );
} // QHFZBIO_sidebar_menu()
add_action ( 'MrGiraffe_before_primary_widgets_hook', 'QHFZBIO_sidebar_menu' , 10 );

/** Footer menu */
function QHFZBIO_footer_menu() {
	if ( has_nav_menu( 'footer' ) )
		wp_nav_menu( array(
			'container' 		=> 'nav',
			'container_class'	=> 'footermenu',
			'theme_location'	=> 'footer',
			'after'				=> '<span class="sep">/</span>',
			'depth'				=> 1
		) );
} // QHFZBIO_footer_menu()
add_action ( 'MrGiraffe_master_footerbottom_hook', 'QHFZBIO_footer_menu' , 10 );

/** SOCIALS MENU */
function QHFZBIO_socials_menu( $location ) {
	if ( has_nav_menu( 'socials' ) )
		echo strip_tags(
			wp_nav_menu( array(
				'container' => 'nav',
				'container_class' => 'socials',
				'container_id' => $location,
				'theme_location' => 'socials',
				'link_before' => '<span>',
				'link_after' => '</span>',
				'depth' => 0,
				'items_wrap' => '%3$s',
				'walker' => new MrGiraffe_Social_Menu_Walker(),
				'echo' => false,
			) ),
		'<a><div><span><nav>'
		);
} //QHFZBIO_socials_menu()
function QHFZBIO_socials_menu_header() { ?>
	<div class="side-socials side-section">
		<div class="widget-side-section-inner">
			<section class="side-section-element widget_MrGiraffe_socials">
				<div class="widget-socials">
					<?php QHFZBIO_socials_menu( 'sheader' ) ?>
				</div>
			</section>
		</div>
	</div><?php
} // QHFZBIO_socials_menu_header()
function QHFZBIO_socials_menu_footer() { QHFZBIO_socials_menu( 'sfooter' ); }
function QHFZBIO_socials_menu_left()   { QHFZBIO_socials_menu( 'sleft' );   }
function QHFZBIO_socials_menu_right()  { QHFZBIO_socials_menu( 'sright' );  }

/* Socials hooks moved to master hook in core.php */

/**
 * Register widgetized areas defined by theme options.
 */
function MrGiraffe_widgets_init() {
	$areas = MrGiraffe_get_theme_structure( 'widget-areas' );
	if ( ! empty( $areas ) ):
		foreach ( $areas as $aid => $area ):
			register_sidebar( array(
				'name' 			=> $area['name'],
				'id' 			=> $aid,
				'description' 	=> ( isset( $area['description'] ) ? $area['description'] : '' ),
				'before_widget' => $area['before_widget'],
				'after_widget' 	=> $area['after_widget'],
				'before_title' 	=> $area['before_title'],
				'after_title' 	=> $area['after_title'],
			) );
		endforeach;
	endif;
} // MrGiraffe_widgets_init()
add_action( 'widgets_init', 'MrGiraffe_widgets_init' );

/**
 * Creates different class names for footer widgets depending on their number.
 * This way they can fit the footer area.
 */
function QHFZBIO_footer_colophon_class() {
	$opts = MrGiraffe_get_option( array( 'theme_footercols', 'theme_footeralign' ) );
	$class = '';
	switch ( $opts['theme_footercols'] ) {
		case '0': 	$class = 'all';		break;
		case '1':	$class = 'one';		break;
		case '2':	$class = 'two';		break;
		case '3':	$class = 'three';	break;
		case '4':	$class = 'four';	break;
	}
	if ( !empty($class) ) echo 'class="footer-' . esc_attr( $class ) . ' ' . ( $opts['theme_footeralign'] ? 'footer-center' : '' ) . '"';
} // QHFZBIO_footer_colophon_class()

/**
 * Set up widget areas
 */
function QHFZBIO_widget_header() {
	$headerimage_on_lp = MrGiraffe_get_option( 'theme_lpslider' );
	if ( is_active_sidebar( 'widget-area-header' ) && ( !MrGiraffe_on_landingpage() || ( MrGiraffe_on_landingpage() && ($headerimage_on_lp == 3) ) ) ) { ?>
		<aside id="header-widget-area" <?php MrGiraffe_schema_microdata( 'sidebar' ); ?>>
			<?php dynamic_sidebar( 'widget-area-header' ); ?>
		</aside><?php
	}
} // QHFZBIO_widget_header()

function QHFZBIO_widget_before() {
	if ( is_active_sidebar( 'content-widget-area-before' ) ) { ?>
		<aside class="content-widget content-widget-before" <?php MrGiraffe_schema_microdata( 'sidebar' ); ?>>
			<?php dynamic_sidebar( 'content-widget-area-before' ); ?>
		</aside><!--content-widget--><?php
	}
} //QHFZBIO_widget_before()

function QHFZBIO_widget_after() {
	if ( is_active_sidebar( 'content-widget-area-after' ) ) { ?>
		<aside class="content-widget content-widget-after" <?php MrGiraffe_schema_microdata( 'sidebar' ); ?>>
			<?php dynamic_sidebar( 'content-widget-area-after' ); ?>
		</aside><!--content-widget--><?php
	}
} //QHFZBIO_widget_after()

function QHFZBIO_widget_side_section() {
	do_action('MrGiraffe_header_socials_hook');

	if ( is_active_sidebar( 'widget-area-side-section' ) ) { ?>
		<div class="side-section-widget side-section">
			<div class="widget-side-section-inner">
				<?php dynamic_sidebar( 'widget-area-side-section' ); ?>
			</div><!--content-widget-->
		</div><?php
	};
} //QHFZBIO_widget_side_section()

add_action( 'MrGiraffe_header_widget_hook',  'QHFZBIO_widget_header' );
add_action( 'MrGiraffe_before_content_hook', 'QHFZBIO_widget_before' );
add_action( 'MrGiraffe_after_content_hook',  'QHFZBIO_widget_after' );
add_action( 'MrGiraffe_side_section_hook',    'QHFZBIO_widget_side_section' );

/* FIN */
