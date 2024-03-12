/**
 * Ajax frontend
 *
 * @package QHFZBIO
 */

 jQuery( document ).ready( function($) {
	/* The number of the next page to load (/page/x/). */
	var page_number_next = parseInt( MrGiraffe_ajax_more.page_number_next );

	/* The maximum number of pages the current query can return. */
	var page_number_max = parseInt( MrGiraffe_ajax_more.page_number_max );

	/* The link of the next page of posts. */
	var page_link_model = MrGiraffe_ajax_more.page_link_model;
	/**
	 * Replace the traditional navigation with our own,
	 * but only if there is at least one page of new posts to load.
	 */
	if( page_number_next <= page_number_max ) {
		/* Insert the "More Posts" link. */
		$( MrGiraffe_ajax_more.content_css_selector )
			.append( '<div id="MrGiraffe_ajax_more_trigger"><span>{loadmore}</span></div>'.replace('{loadmore}', MrGiraffe_ajax_more.load_more_str ) );

		/* Remove the traditional navigation. */
		$( MrGiraffe_ajax_more.pagination_css_selector ).remove();
	}

	/**
	 * Load new posts when the link is clicked.
	 */
	$( '#MrGiraffe_ajax_more_trigger' ).on( 'click', function() {
	    /* Loading gif */
		$( this ).addClass( 'MrGiraffe_click_loading' );

		if( page_number_next <= page_number_max ) {

			/* Get the link for the next page to load */
			var next_link = page_link_model.replace(/9999999/, page_number_next);

			/* Load the next page - only .post class */
            $( '<div>' ).load( next_link + ' .post',
                function() {
                    $data = $( this ).find( 'article.post' );

                    /* Add articles one by one */
    			    $data.each( function() {
                        $( this ).css( 'opacity', '0' ).appendTo( '#content-masonry' ); /* always string */
                    });

                     // If masonry enabled and magazine layout active
                    if ( ( MrGiraffe_theme_settings.masonry == 1 ) && ( MrGiraffe_theme_settings.magazine != 1 ) ) {
                        /* Add articles one by one */
        			    $data.each( function() {
                            $( this ).css( 'opacity', '0' ).appendTo( '#content-masonry' ); /* always string */
                        });

                        /* Load fitvids, masonry and animate scroll only after images have loaded  */
                        $( '#content-masonry' ).imagesLoaded( function() {
                            if ( MrGiraffe_theme_settings.fitvids == 1 ) { $( '#content-masonry' ).fitVids().masonry( 'appended', $data ); }
                                else { $( '#content-masonry' ).masonry( 'appended', $data ); }

                            /* If an article animation is set, animate the new articles */
                            if ( MrGiraffe_theme_settings.articleanimation ) { animateScroll( $data ) };

                            /* Removal of loading gif */
                            $( '#MrGiraffe_ajax_more_trigger' ).removeClass( 'MrGiraffe_click_loading' );
                        });
                    }

                    else { // if not masonry
                        $data.each( function() {
                            $( this ).css( {'opacity': '1', 'transform': 'none', '-webkit-transform': 'none'} ).appendTo( '#content-masonry' ); /* always strings */
                        });
                        if ( MrGiraffe_theme_settings.fitvids == 1 ) { $( this ).fitVids(); }
                        if ( MrGiraffe_theme_settings.articleanimation ) { animateScroll( $data ) };
                        $( '#MrGiraffe_ajax_more_trigger' ).removeClass( 'MrGiraffe_click_loading' );
                    }
					/* Update page number and next_link. */
					page_number_next++;

                    /* Hide more posts button if there are no more pages to load */
					if( page_number_next > page_number_max ) {
						$( '#MrGiraffe_ajax_more_trigger' ).remove();
					}
				}
			);

		}
		return false;
	});
});
