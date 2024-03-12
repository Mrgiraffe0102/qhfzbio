/**
 * Customizer JS
 *
 * @package MrGiraffe Framework
 */

var _MrGiraffe_label_max = 'Maximize';
var _MrGiraffe_label_min = 'Restore';

var _MrGiraffe_innerHTML = '<button class="button MrGiraffe-expand-sidebar button-secondary" aria-expanded="true" aria-label="' + _MrGiraffe_label_max + '" title="' + _MrGiraffe_label_max + '" href="#">\
        <span class="collapse-sidebar-label">' + _MrGiraffe_label_max + '</span>\
		<span class="collapse-sidebar-arrow" title="' + _MrGiraffe_label_max + '"></span>\
</button> ';


jQuery( document ).ready(function( jQuery ) {

	jQuery('#customize-theme-controls .customize-control-description:not(.MrGiraffe-nomove)').each(function() {
			jQuery(this).insertAfter(jQuery(this).parent().children('.customize-control-content, select, input:not(input[type=checkbox]), textarea, .buttonset'));
	});

	if (jQuery('#customize-footer-actions .devices').length>0) {
	/* wp 4.5 or newer */
		jQuery('#customize-footer-actions .devices').prepend(_MrGiraffe_innerHTML);
	} else {
		jQuery('#customize-footer-actions').append(_MrGiraffe_innerHTML);
	}

	/* wp hide/show customizer button extender */
	jQuery('.collapse-sidebar:not(.MrGiraffe-expand-sidebar)').on( 'click', function( event ) {
			if ( jQuery('.wp-full-overlay').hasClass('MrGiraffe-maximized') ) {
				jQuery('.wp-full-overlay').removeClass( 'MrGiraffe-maximized' );
				jQuery('a.MrGiraffe-expand-sidebar span.collapse-sidebar-label').html(_MrGiraffe_label_max);
				jQuery('a.MrGiraffe-expand-sidebar').attr('title',_MrGiraffe_label_max);
			}

	});
	
	/* maximize/restore button */
	jQuery('.MrGiraffe-expand-sidebar').on( 'click', function( event ) {
			var label = jQuery('.MrGiraffe-expand-sidebar span.collapse-sidebar-label');
			var lebutton = jQuery('.MrGiraffe-expand-sidebar');
			if (jQuery(label).html() == _MrGiraffe_label_max) {
					jQuery(label).html(_MrGiraffe_label_min);
					jQuery(lebutton).attr('title',_MrGiraffe_label_min);
					jQuery('.wp-full-overlay').removeClass( 'collapsed' ).addClass( 'expanded' ).addClass( 'MrGiraffe-maximized' );
			} else {
					jQuery(label).html(_MrGiraffe_label_max);
					jQuery(lebutton).attr('title',_MrGiraffe_label_max);
					jQuery('.wp-full-overlay').removeClass( 'collapsed' ).addClass( 'expanded' ).removeClass( 'MrGiraffe-maximized' );
			}
			event.preventDefault();
	});
	
	/* customizer focus to panel/section/setting */
	jQuery('body').on('click','.MrGiraffe-customizer-focus', function() {
			var type = jQuery(this).attr('data-type');
			var id = jQuery(this).attr('data-id');
			if ( ! id || ! type ) {
				return;
			}

			wp.customize[ type ]( id, function( instance ) {
				instance.deferred.embedded.done( function() {
					wp.customize.previewer.deferred.active.done( function() {
						instance.focus();
					});
				});
			});
		
	});

});
