"use strict";

// @TODO use ESNext instead w/ grunt babel.

var mainNav = document.querySelector( 'nav#main' );
var hamburger = document.querySelector( '#burger-nav' );

hamburger.addEventListener( 'click', function() {
    hamburger.classList.toggle( "open" );
    mainNav.classList.toggle( "hide" );
} );
