/**
 * Use hamburger icon for main navigation menu for mobile
 */
( function( window, $, undefined ) {
	'use strict';
 
		$( '.nav-primary' ).before( '<button class="menu-toggle" role="button" aria-pressed="false"></button>' ); // Add toggles to menus
		$( '.nav-header' ).before( '<button class="menu-toggle" role="button" aria-pressed="false"></button>' );
		/*$( '.nav-secondary' ).before( '<button class="menu-toggle" role="button" aria-pressed="false"></button>' );*/
 
	// Show/hide the navigation
	$( '.menu-toggle' ).on( 'click', function() {
		var $this = $( this );
			$this.attr( 'aria-pressed', function( index, value ) {
		return 'false' === value ? 'true' : 'false';
	});
 
	$this.toggleClass( 'activated' );
	$this.next( '.nav-primary' ).slideToggle( 'fast' );
	$this.next( '.nav-header' ).slideToggle( 'fast' );
	/*$this.next( '.nav-secondary' ).slideToggle( 'fast' );*/
 
});
 
})( this, jQuery );