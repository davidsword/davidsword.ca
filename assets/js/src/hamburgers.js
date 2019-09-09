"use strict";

// @TODO use ESNext instead w/ grunt babel.

var hamburger = document.querySelector( '#burger-nav' );

hamburger.addEventListener( 'click', function() {
    hamburger.classList.toggle( "open" );
} );
