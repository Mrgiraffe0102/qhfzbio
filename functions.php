<?php
/**
 * Functions file - Calls all other required files
 *
 * PLEASE DO NOT EDIT THEME FILES DIRECTLY
 * unless you are prepared to lose all changes on the next update
 *
 * @package QHFZBIO
 */

// theme identification and options management - do NOT edit unless you know what you are doing
define ( "_MrGiraffe_THEME_NAME", "QHFZBIO" );
define ( "_MrGiraffe_THEME_VERSION", "1.1.1" );

// prefixes for theme options and functions
define ( '_MrGiraffe_THEME_SLUG', 'QHFZBIO' );
define ( '_MrGiraffe_THEME_PREFIX', 'theme' );

require_once( get_template_directory() . "/MrGiraffe/framework.php" );		// Framework
require_once( get_template_directory() . "/admin/defaults.php" );		// Options Defaults
require_once( get_template_directory() . "/admin/main.php" );			// Admin side

// Frontend side
require_once( get_template_directory() . "/includes/setup.php" );       	// Setup and init theme
require_once( get_template_directory() . "/includes/styles.php" );      	// Register and enqeue css styles and scripts
require_once( get_template_directory() . "/includes/loop.php" );        	// Loop functions
require_once( get_template_directory() . "/includes/comments.php" );    	// Comment functions
require_once( get_template_directory() . "/includes/core.php" );        	// Core functions
require_once( get_template_directory() . "/includes/hooks.php" );       	// Hooks
require_once( get_template_directory() . "/includes/meta.php" );        	// Custom Post Metas
require_once( get_template_directory() . "/includes/landing-page.php" );	// Landing Page outputs
if ( class_exists( 'WooCommerce' ) ) {
	require_once( get_template_directory() . "/includes/woocommerce.php" );	// WooCommerce overrides
}

// FIN
