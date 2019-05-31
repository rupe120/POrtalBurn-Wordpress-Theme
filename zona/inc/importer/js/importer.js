/* When DOM is fully loaded */ 
jQuery(document).ready(function($) {


	// Show message after imported
	var check_interval = setInterval(function(){ check_result() }, 500);

	function check_result() {
	 	var result = $( '#muttley-importer-message' ).text();
	 	if ( result.indexOf('IMPORT FINISH') >= 0 ) {
	 		clearTimer();
	 		$( '#muttley-importer-success' ).fadeIn();
	 		$( '.muttley-importer-loading-msg' ).fadeOut();
	 	}

	}

	function clearTimer() {
	    clearInterval(check_interval);
	}

	// Select styles
	$( '.demo .muttley-import-start' ).on( 'click', function(){
		
		$( '.demos, .muttley-importer-info' ).slideUp();
		$( '.muttley-importer-loading-msg' ).slideDown();

		var id = $( this ).attr('data-id');

		$( '#selected_demo_content' ).val(id);
	});

});