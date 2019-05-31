
// When DOM is fully loaded
jQuery(document).ready(function($) {


	/* Enable Strict Mode
	 ---------------------------------------------------------------------- */
	"use strict";


	/* Main Settings
	 ---------------------------------------------------------------------- */

	// Detect Touch Devices
	var isTouch = ( ( 'ontouchstart' in window ) || ( navigator.msMaxTouchPoints > 0 ) );

	if ( isTouch ) {

		$( 'body' ).addClass( 'touch-device' );

	}


	/* Navigation
	 ---------------------------------------------------------------------- */
	(function() {


		/* Top navigation
	 	 ------------------------- */

	 	if ( $( '#nav li' ).length ) {
			
			// Create top navigation
			$( document ).on( 'mouseenter', '#nav ul li', function() {
				var 
					$this = $( this ),
					$sub  = $this.children( 'ul' );
				if ( $sub.length ) {
					$this.addClass('active');
		            var elm = $('ul:first', this);
		            var off = elm.offset();
		            var l = off.left;
		            var w = elm.width();
		            var docH = $('body').height();
		            var docW = $('body').width();

		            var isEntirelyVisible = (l + w <= docW);

		            if (!isEntirelyVisible) {
		                $sub.addClass('edge');
		            } else {
		                $sub.removeClass('edge');
		            }
		        }
				$sub.stop( true, true ).addClass( 'show-list' );
			}).on( 'mouseleave', '#nav ul li', function() {
				$( this ).removeClass( 'active' ).children( 'ul' ).stop( true, true ).removeClass( 'show-list edge' );
			});

		}

		/* Responsive navigation
	 	 ------------------------- */

	 	if ( $( '#layer--nav-wrapper').length && $( '#layer--nav-wrapper').children().length ) {
		 	// Scroll
			var responsive_scroll = new IScroll( '#layer--nav-wrapper', {
			    mouseWheel: true,
			    interactiveScrollbars: true,
			    scrollbars: 'custom',
			    click: true
			});

			// Navigation list
			$( '#responsive-nav .menu-item-has-children > a' ).each(function(){
				$( this ).after('<i class="submenu-trigger icon icon-angle-down"></i>' );
			});

			$( '#responsive-nav > ul > li' ).addClass( 'first-child' );
			$( '#responsive-nav .submenu-trigger, #responsive-nav .menu-item-has-children > a[href="#"]' ).on( 'click', function(e){
				e.preventDefault();
				var li = $( this ).closest('li'),
					main_index = $( this ).parents( '.first-child' ).index(),
					open_li = $( '#responsive-nav > ul > li:not(:eq('+main_index+'))'),
					main_parent;

				if ( $( this ).parent().hasClass( 'first-child' ) ) {
					main_parent = $( this ).parent().children();
					main_parent.find('.is-visible').removeClass( 'is-visible' );
					main_parent.find( 'ul:visible' ).slideUp(0);
				}
				open_li.removeClass( 'is-visible' );
				li.toggleClass( 'is-visible' );

				open_li.find( 'ul:visible' ).slideUp();
				li.find( ' > ul' ).slideToggle(400);
				setTimeout( function(){ responsive_scroll.refresh() }, 400  );
			});

			/* Layer */
		 	 $( '.nav--responsive-trigger' ).on( 'click', function(){
		 		$( '.layer--nav' ).addClass( 'is-active is-nav' ).css( 'visibility', 'visible' );
		 		responsive_scroll.refresh();
		 	});
		 	$( '.layer--nav .layer--close' ).on( 'click', function(){
		 		$( '.layer--nav' ).removeClass( 'is-active is-nav' ).css( 'visibility', 'visible' );
		 		setTimeout( function(){
		 			$( '.layer--nav' ).css( 'visibility', 'hidden' );
		 			$( '#responsive-nav .is-visible' ).removeClass( 'is-visible' ).find( 'ul:visible' ).slideUp();
		 		}, 300);
		 	});
		 	$( document ).on( 'click', '#responsive-nav a:not([href="#"])' , function(){
		 		setTimeout( function(){
		 			$( '.layer--nav' ).css( 'visibility', 'hidden' ).removeClass( 'is-active is-nav' );
		 			$( '#responsive-nav .is-visible' ).removeClass( 'is-visible' ).find( 'ul:visible' ).slideUp();
		 		}, 800);

			});
	 	}


		/* Hash Links
	 	 ------------------------- */
	 	if ( controls_vars.ajaxed == 0 ) {

	 		$( document ).on( 'click', 'a[href=#], a[href*=replytocom]', function(e){
				e.preventDefault();

	 		} );
	 		
		}


	})();

	
	/* Loader
	 ---------------------------------------------------------------------- */
	(function() {

		if ( window.location.href.indexOf( 'customize.php' ) > -1 ) {
			return false;
		}

		if ( $( '.wpal-loading-layer' ).length <= 0 ) {
			return false;
		}

		$( '#site' ).imagesLoaded( { background: true }, function() {
			$( '.wpal-loading-layer' ).addClass( 'hide-layer' );
			setTimeout( function(){ $( '.wpal-loading-layer' ).css( 'visibility', 'hidden' ).removeClass( 'hide-layer show-layer' ); }, 1400);
		});

	})();


	/* Small Functions
	 ---------------------------------------------------------------------- */
	(function() {


		/* Recent Events
	 	 ------------------------- */

	 	if ( $( '#layer--events-wrapper').length && $( '#layer--events-wrapper').children().length ) {

		 	// Scroll
			var layer_events_scroll = new IScroll( '#layer--events-wrapper', {
			    mouseWheel: true,
			    interactiveScrollbars: true,
			    scrollbars: 'custom',
			    click: true
			});

		 	$( 'a[href="#show-events"]' ).on( 'click', function(){
		 		$( '.layer--events' ).addClass( 'is-active is-events' ).css( 'visibility', 'visible' );
		 		layer_events_scroll.refresh();
		 		return false;
		 	});
		 	$( '.layer--events .layer--close' ).on( 'click', function(){
		 		$( '.layer--events' ).removeClass( 'is-active is-events' ).css( 'visibility', 'visible' );
		 		setTimeout( function(){
		 			layer_events_scroll.refresh();
		 			$( '.layer--events' ).css( 'visibility', 'hidden' );
		 		}, 300);
		 	});
		 	$( '.layer--events .layer--events-list a:not([href="#"]), .layer--events-button-wrapper a:not([href="#"])' ).on( 'click', function(){
		 		setTimeout( function(){
		 			$( '.layer--events' ).css( 'visibility', 'hidden' ).removeClass( 'is-active is-events' );
		 		}, 800);
			});
	 	}

	})();



	/* Ajax Filters
	 ---------------------------------------------------------------------- */
 	(function() {


		// List click action
		var loading = false;

		$( document ).on( 'click', '.filter-simple ul a', function(event) {

			event.preventDefault();

			if ( loading ) return;

			var 
				$filter = $( this ).parents( '.filter' ),
				$grid = $filter.attr( 'data-grid' ),
				obj = $.parseJSON( $filter.attr('data-obj') ),
				selected_filter = $filter.attr( 'data-filter-name' ),
				grid_min_height = $( '.' + $grid ).attr('data-min-height'),
				grid_height = $( '.' + $grid ).outerHeight();

			obj['filter_name'] = $( this ).attr( 'data-filter-name' );
			
			if ( obj.filter_name != selected_filter ) {

				// Clear filters
				$filter.find('ul li a.is-active' ).removeClass( 'is-active' );

				// Add active Class 
				$( this ).addClass( 'is-active' );

				// Classes
				$filter.addClass( 'loading active' );
				$( '.load-more' ).removeClass( 'loaded loading' );

				// Pagenum
				obj['pagenum'] = 1;
				$( '.load-more' ).attr( 'data-pagenum', 2 );

				// Hide messages
				$( '.ajax-messages .message' ).hide();

				// Get grid height
				$( '.' + $grid ).css( 'min-height', grid_height );

				$( '.' + $grid ).find( '.grid--item' ).removeClass( 'is-ready' );

				loading = true;
	
				setTimeout( function() { 
					// Ajax
					$.ajax({
						url: ajax_action.ajaxurl,
						type: 'post',
						data: {
							action: obj['action'],
							ajax_nonce : ajax_action.ajax_nonce,
							obj: obj
						},
						success: function( result ) {

							if ( result == 'Busted!' ) {
								location.reload();
								return false;
							}
					
							var 
								$result = $( result ),
								$container = $( '.' + $grid );
								$container.find( '.grid--item' ).remove();

							if ( result == 'no_results' ) {
								$( '.' + $grid ).css( 'min-height', grid_min_height + 'px' );
								$( '.load-more-wrap' ).addClass( 'hidden' );
								loading = false;
								return;
							}

							$result.imagesLoaded( { background: true }, function() {
								$filter.removeClass( 'loading' );
								$container.append( $( $result ).addClass( 'grid--new-item' ) );
								$( '.' + $grid ).css( 'min-height', grid_min_height + 'px' );
								setTimeout(function() { $container.find( '.grid--new-item' ).addClass( 'is-ready' ); loading = false; },100);
								if ( $container.find( '.end-posts' ).length ) {
									// Hide loader
									$( '.load-more-wrap' ).addClass( 'hidden' );
								} else {
									$( '.load-more-wrap' ).removeClass( 'hidden' );
								}
						
							});
						},
						error: function( request, status, error ) {
							var 
								$container = $( '.' + $grid );
							$filter.removeClass( 'loading' );
							$( '.load-more-wrap' ).addClass( 'hidden' );
							$( '.message.ajax-error' ).fadeIn(400);
							loading = false;
						}
					});
				}, 500);
			}
			
		} );


		// Load more post
		$( document ).on( 'click', '.load-more', function(event) {

			event.preventDefault();

			if ( ! $( '.filter' ).length ) return;

			var 
				$this = $( this ),
				$filter,
				$grid,
				obj;

			// Check active filter (if exists)

			$filter = $( '.filter' );
			obj = $.parseJSON( $filter.attr('data-obj') );
			obj['filter_name'] = $filter.find( '.is-active' ).attr( 'data-filter-name' );
			
			// Grid
			$grid = $filter.attr( 'data-grid' );

			// Pagenum
			obj['pagenum'] = parseInt( $this.attr( 'data-pagenum' ) );

			// Hide messages
			$( '.ajax-messages .message' ).hide();

			// Classes
			$this.addClass( 'loading' );
			// Ajax
			$.ajax({
				url: ajax_action.ajaxurl,
				type: 'post',
				data: {
					action: obj['action'],
					ajax_nonce : ajax_action.ajax_nonce,
					obj: obj
				},
				success: function( result ) {


					if ( result == 'Busted!' ) {
						location.reload();
						return false;
					}

					var 
						$result = $( result ),
						$container = $( '.' + $grid );

					if ( result == 'no_results' ) {
						$this.removeClass( 'loading' );
						$this.addClass( 'loaded' );
						$( '.load-more-wrap' ).addClass( 'hidden' );
						return;
					}

					$result.imagesLoaded( { background: true }, function() {
						$container.removeClass( 'new-masonry-item' );
						obj['pagenum'] = obj['pagenum'] + 1;
						$this.attr( 'data-pagenum', obj['pagenum'] );
						$this.removeClass( 'loading' );
						$container.append( $( $result ).addClass( 'grid--new-item' ) );
						setTimeout(function() { $container.find( '.grid--new-item' ).addClass( 'is-ready' ) },100);
						if ( $container.find( '.end-posts' ).length ) {
							// Hide loader
							$this.parent().addClass( 'hidden' );
						} else {
							$this.parent().removeClass( 'hidden' );
						}
					});
				},
				error: function( request, status, error ) {
					var 
						$container = $( '.' + $grid );

					$this.attr( 'data-pagenum', '2' );
					$this.removeClass( 'loading' );
					$( '.message.ajax-error' ).fadeIn(400);
					$( '.load-more-wrap' ).addClass( 'hidden' );
				}
			});
			
		} );

		
	})();



	/* WP Ajax Loader
	 ---------------------------------------------------------------------- */
	(function() {

		if ( controls_vars.ajaxed == 0 || window.location.href.indexOf( 'customize.php' ) > -1 ) return false;

		$.WPAjaxLoader({
   			home_url : controls_vars.home_url,
			theme_uri : controls_vars.theme_uri,
			dir : controls_vars.dir,
			reload_containers : controls_vars.ajax_reload_containers,
			permalinks : controls_vars.permalinks,
			ajax_async : controls_vars.ajax_async,
			ajax_cache : controls_vars.ajax_cache,
			ajax_events : controls_vars.ajax_events,
			ajax_elements : controls_vars.ajax_elements,
			excludes_links : controls_vars.ajax_exclude_links,
			reload_scripts : controls_vars.ajax_reload_scripts,
			search_forms : '#searchform,.layer--searchform',
			loading_animation_time_start : 600,
			loading_animation_time_end : 600,
			loadStart : function() {

				// Close playlist 
				if ( $( '#scamp_player.sp-show-list' ).length ) {
					$( '#scamp_player' ).removeClass( 'sp-show-list' );
				}
				
				// Remove HTML classes
				$( 'html' ).attr( 'class', '' );

			},
			loadEnd : function(){

				/* Custom Post Navigation */
				if ( $('.custom-post-nav' ).length ) {
					$('.custom-post-nav.is-active' ).remove();
					$('.custom-post-nav' ).detach().appendTo( 'body' );
					$('.custom-post-nav' ).addClass( 'is-active' );
				}

				$( 'body' ).addClass( 'wp-ajax-loader' );

			}
		});

		$.WPAjaxLoader.init(function(){});
		
	})();

});