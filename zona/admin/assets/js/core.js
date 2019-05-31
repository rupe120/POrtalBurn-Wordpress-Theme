
/* When DOM is fully loaded */ 
jQuery(document).ready(function($) {


	/* UI
	------------------------------------------------------------------------*/

	// GENERIC JQUERY UI SETUP
	$( '._button' ).button();


	/* Navigation
	 ------------------------------------------------------------------------*/

	// Store variables
    var 
    	menu_head = $( '.muttleypanel-menu > li > a' ),
        menu_body = $( '.muttleypanel-menu li > .muttleypanel-sub-menu' );

    // Create breadcrumbs
    $( '.muttleypanel-menu li a' ).each( function(i) {
    	var
    		id = $( this ).data( 'tab_id' ),
    		sub = $( this ).next(),
    		ul = null;

    	if ( sub.length > 0 ) {

    		ul = $( this ).parent().find( 'ul' ).clone();
    		ul.find( 'a' ).contents().unwrap().attr( 'id', '' );
    		ul = '<ul>' + ul.html() + '</ul>';
    		$( '#' + id ).find( '.muttleypanel-breadcrumb div:last-child' ).append( ul );
    	}

    });

    //  Breadcrumb animation
    function breadcrumb( el, eq ) {

    	var
    		offset = - ( eq * 20 );

    	el.animate( {
    		top: offset
    	});
    }

    // Open the first tab on load
	menu_head.first()
		.addClass( 'active' )
		.next()
		.slideDown( 'normal' )
		.find( 'a:first' )
		.addClass( 'active' );

	/* Display first tab */
	$( '.muttleypanel-tab:first' ).css( 'display', 'block' );
	if ( $( '.muttleypanel-tab:first' ).find( '.muttleypanel-tab' ).length > 0 ) {
		$( '.muttleypanel-tab:first .muttleypanel-tab:first' ).css( 'display', 'block' );
	}

	// Click function
    menu_head.on( 'click', function( event ) {
			
			var 
				sub = $( this ).next(),
				id = $( this ).data( 'tab_id' ),
				tab = $( '#' + id );


        // Disable header links
        event.preventDefault();

        // Show and hide the tabs on click
        if ( !$(this).hasClass( 'active' ) ) {

        	// Hide all tabs
			$( '.muttleypanel-tab' ).css( 'display', 'none' );

			// Show main tab
			tab.fadeIn( 500 );
            menu_body.slideUp( 'normal' );
            $( this ).next().stop( true, true ).slideToggle( 'normal' );
            menu_head.removeClass( 'active' );
            menu_body.find( 'a' ).removeClass( 'active' );
            $( this ).addClass( 'active' );
            $( this ).next().find( 'li:first a' ).addClass( 'active' );
            $( '.muttleypanel-tab:visible .muttleypanel-tab:first' ).css( 'display', 'block' );

            // Breadcrumbs
            breadcrumb( $( '.muttleypanel-breadcrumb ul', tab ), 0 );
			
        }

    });

    // Click function
    menu_body.find( 'li > a' ).on( 'click', function( event ) {

			var
				id = $( this ).data( 'tab_id' ),
				tab = $( '#' + id ),
				main_tab = null,
				eq = null;

			if ( !$( this ).hasClass( 'active' ) ) {
				menu_body.find( 'a' ).removeClass( 'active' );
				$( this ).addClass( 'active' );
				$( '.muttleypanel-tab:visible .muttleypanel-tab' ).css( 'display', 'none' );
				main_tab = $( '.muttleypanel-tab:visible > .muttleypanel-breadcrumb ul' );
				tab.fadeIn( 500 );

				// Breadcrumbs
				eq = $( this ).parent().index();
				breadcrumb( main_tab, eq );
				
			}
        event.preventDefault();
    });

    /* Respnsive menu */
    $( '#show-res-nav' ).on( 'click', function( event ){
    	if ( $( '#muttleypanel-sidebar' ).hasClass( 'mobile-nav' ) ) {
			$( '#muttleypanel-sidebar' ).removeClass( 'mobile-nav' );
    	} else {
    		$( '#muttleypanel-sidebar' ).addClass( 'mobile-nav' );
    	}
    	event.preventDefault();
    });


	/* Save Settings
 	------------------------------------------------------------------------*/

	$( '#_save, #_save_mobile' ).on( 'click', function() {
		
		/* Show progress bar */ 
		NProgress.start();
		 
		/* Update editor content */
        $( '.custom-tiny-editor' ).each( function() {
											   
			/* Only for visual editor */
			if ( $( this ).children().hasClass( 'tmce-active' ) ) {
				var editor_id = $( this ).data( 'id' );
				editor_id = '#' + editor_id;
				var editor_content = $( editor_id + '_ifr', this ).contents().find( 'body' ).html();
				if ( editor_content ) {
				   if ( editor_content == '' || editor_content == '<p><br></p>' || editor_content == '<p><br data-mce-bogus="1"></p>' ) {
				   		editor_content = '';
				   	}
				   $( 'textarea' + editor_id, this ).val( editor_content );
				}
			}
		});

		var 
			data = {
				action: 'panel_save',
				data: $( '#muttleypanel_form' ).find(':input:not(.no-save)').serializePost()
	    	};

        $.ajax({
			url: ajaxurl,
			data: data,
			type: 'POST',
			success: function( response ) {
				
				if ( response == 'import_error' ) {

					/* Show notice */
					$( '#muttleypanel-notices' ).notify( 'create' , {
						title: 'Error!',
						text: 'Import error.'
					});

					NProgress.done();
					
					return false;
				}

				/* Parse JSON object */
				response = JSON.parse( response );
				var is_import = false;
				
				/* If import */
				if ( $( '#data-import-wrap :input' ).length > 0 && $( '#data-import-wrap :input' ).val() != '' ) is_import = true;
				
				$( '#muttleypanel_form :input' ).each( function ( i ) {
															 
					var input_name = $( this ).attr( 'name' );
					var input_val = $( this ).val();
					var response_val = response[ input_name ];
					
					/* Inputs */
					if ( response_val != undefined & response_val != input_val ) {
						$( this ).val( response[input_name] );
					}
				
				});

				/* Default colorpicker value */
				if ( $.inArray( 'color',  muttleypanel_vars.used_plugins ) !== -1 ) {
  
					$( '.colorpicker-input' ).each( function() {
					    if ( $( this ).val() != '' ) {
							var hex = $( this ).val();
							$( this ).next().css( 'background-color', hex );
						}
					});
				}
				
				/* TinyMCE update content */
				$( '.custom-tiny-editor' ).each( function() {
					var editor_id = $( this ).data( 'id' );
					editor_id = '#' + editor_id;
					var saved_content = $( 'textarea' + editor_id, this ).val();
					$( editor_id + '_ifr', this ).contents().find( 'body' ).html( saved_content );
				});
				
				/* Hide progress bar */ 
				NProgress.done();

				/* If import */
				if ( is_import ) {

					/* Show notice */
					$( '#muttleypanel-notices' ).notify( 'create' , {
						title: 'Success!',
						text: 'New settings are imported.'
					});

					setTimeout(function(){
						location.reload();
					}, 2000);

					return false;
				}

				/* Show notice */
				$( '#muttleypanel-notices' ).notify( 'create' , {
					title: 'Success!',
					text: 'Settings are saved.'
				});
	    	}
		});
		return false;
	});
	
	/* Autosave */
	if ( $( '#muttleypanel' ).data('autosave') == true ) {
		$( '#_save' ).trigger('click');
	}


	/* Import Data
	------------------------------------------------------------------------*/	
	$( '.data-import' ).toggle( function () {
		$textarea = '<textarea name="import" style="height:200px;overflow:auto" cols="" rows=""></textarea>';									        
		$( '#data-import-wrap .input-wrap' ).append($textarea);
		$( '#data-import-wrap' ).slideDown(400);
	    return false;
											  
	}, function () {
		$( '#data-import-wrap' ).slideUp( function() {
			$( '#data-import-wrap .input-wrap :input' ).remove();
		});
	    return false;
		
	});


    /* Notices
	------------------------------------------------------------------------*/
	$( '#muttleypanel-notices' ).notify();

});


/*------------------------------------------------------------------------

 Small Plugins

------------------------------------------------------------------------*/	


/* Serialize Post
------------------------------------------------------------------------*/
;(function($) {

    $.fn.serializePost = function() {  
        var data = {};  
        var formData = this.serializeArray();  
        for ( var i = formData.length; i--; ) {  
            var name = formData[i].name;  
            var value = formData[i].value;  
            var index = name.indexOf( '[]' );  
            if ( index > -1 ) {  
                name = name.substring( 0, index );  
                if ( !( name in data ) ) {  
                    data[name] = [];  
                }  
                data[name].push(value);  
            }  
            else  
                data[name] = value;  
        }  
        return data;  
    };

})(jQuery);