<?php
/**
 * TGMPA init
 *
 * @package QHFZBIO
 */

/* TGM_Plugin_Activation class is included in the framework. */
add_action( 'tgmpa_register', 'MrGiraffe_register_addon_plugins' );

/*This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10. */
function MrGiraffe_register_addon_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'               => 'MrGiraffe Serious Slider', // The plugin name.
			'slug'               => 'MrGiraffe-serious-slider', // The plugin slug (typically the folder name).
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '0.6', // If set, the active plugin must be this version or higher. 
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		),
 		array(
			'name'               => 'Regenerate Thumbnails', 
			'slug'               => 'regenerate-thumbnails',
			'required'           => false, 
			//'version'            => '', 
			'force_activation'   => false, 
			'force_deactivation' => false, 
		),
		/* plugin is no longer maintained 
		array(
			'name'               => 'Force Regenerate Thumbnails', // The plugin name.
			'slug'               => 'force-regenerate-thumbnails', // The plugin slug (typically the folder name).
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '2.0.0', // If set, the active plugin must be this version or higher. 
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		), */

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'id'           => 'QHFZBIO',                // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'QHFZBIO-addons',		   // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table

		'strings'      => array(
			'page_title'                      => __( 'QHFZBIO Suggested Plugins', 'MrGiraffe' ),
			'menu_title'                      => __( 'QHFZBIO Addons', 'MrGiraffe' ),
			/* translators: %s: plugin name. */
			'installing'                      => __( 'Installing Plugin: %s', 'MrGiraffe' ),
			/* translators: %s: plugin name. */
			'updating'                        => __( 'Updating Plugin: %s', 'MrGiraffe' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'MrGiraffe' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). */
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'MrGiraffe'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). */
				'This theme suggests the following plugin: %1$s.',
				'This theme suggests the following plugins: %1$s.',
				'MrGiraffe'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). */
				'The following plugin should be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins should be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'MrGiraffe'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). */
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'MrGiraffe'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). */
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'MrGiraffe'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). */
				'The following suggested plugin is currently inactive: %1$s.',
				'The following suggested plugins are currently inactive: %1$s.',
				'MrGiraffe'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'MrGiraffe'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'MrGiraffe'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'MrGiraffe'
			),
			'return'                          => __( 'Return to Suggested Plugins Installer', 'MrGiraffe' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'MrGiraffe' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'MrGiraffe' ),
			/* translators: 1: plugin name. */
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'MrGiraffe' ),
			/* translators: 1: plugin name. */
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'MrGiraffe' ),
			/* translators: 1: dashboard link. */
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'MrGiraffe' ),
			'dismiss'                         => __( 'Dismiss this notice', 'MrGiraffe' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'MrGiraffe' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'MrGiraffe' ),

			'nag_type'                        => 'notice-info', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
			
	);

	tgmpa( $plugins, $config );
}

// FIN