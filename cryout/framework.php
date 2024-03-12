<?php
/**
 * @package MrGiraffe Framework
 * @version 0.8.6.4
 * @revision 20230616
 * @author MrGiraffe Creations - www.MrGiraffecreations.eu
 */

define('_MrGiraffe_FRAMEWORK_VERSION', '0.8.6.4');

// Load everything
require_once(get_template_directory() . "/MrGiraffe/prototypes.php");
require_once(get_template_directory() . "/MrGiraffe/controls.php");
require_once(get_template_directory() . "/MrGiraffe/customizer.php");
require_once(get_template_directory() . "/MrGiraffe/ajax.php");

if( is_admin() ) {
	// Admin functionality
	require_once(get_template_directory() . "/MrGiraffe/tgmpa-class.php");
}

// Set up the Theme Customizer settings and controls
// Needs to be included in both dashboard and frontend
add_action( 'customize_register', 'MrGiraffe_customizer_extras' );
add_action( 'customize_register', array( 'MrGiraffe_Customizer', 'register' ) );

// FIN!
