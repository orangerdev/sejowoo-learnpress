(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery( document ).ready( function( $ ) {

		$( 'input#_sejowoo_learnpress' ).change( function() {
			var is_sejowoo_learnpress = $( 'input#_sejowoo_learnpress:checked' ).size();
			console.log( is_sejowoo_learnpress );
			$( '.show_if_sejowoo_learnpress' ).hide();
			$( '.hide_if_sejowoo_learnpress' ).hide();

			if ( is_sejowoo_learnpress ) {
				$( '.hide_if_sejowoo_learnpress' ).hide();
			}
			if ( is_sejowoo_learnpress ) {
				$( '.show_if_sejowoo_learnpress' ).show();
			}
		});
		$( 'input#_sejowoo_learnpress' ).trigger( 'change' );

	});

})( jQuery );
