/**
 * Admin-side JS
 *
 * @package QHFZBIO
 */

jQuery(document).ready(function() {

	/* Confirm modal window on reset to defaults */
	jQuery('#MrGiraffe_reset_defaults').on('click', function() {
		if (!confirm(MrGiraffe_admin_settings.reset_confirmation)) { return false; }
	});

});/* document.ready */

/* FIN */
