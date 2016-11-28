/*

	Main.js

	01. Menu toggle
	02. Top bar height effect
	03. Home content slider
	04. Home background slider
	05. Home background and content slider
	06. Quote slider
	07. Image slider
	08. Services slider
	09. Employee slider
	10. Work slider
	11. Footer promo
	12. Contact form
	13. Scrollto
	14. Magnific popup
	15. Equal height
	16. fitVids

*/


(function($){
	"use strict";

	/* ==================== 01. Menu toggle ==================== */
	$(function(){
		$('#toggle').click(function (e){
			e.stopPropagation();
		});
		$('html').click(function (e){
			if (!$('.toggle').is($(e.target))){
				$('#toggle').prop("checked", false);
			}
		});
	});

	/* ==================== 02. Top bar height effect ==================== */
	$(window).bind("scroll", function() {
		if ($(this).scrollTop() > 100) {
			$(".top-bar").removeClass("tb-large").addClass("tb-small");
		} else {
			$(".top-bar").removeClass("tb-small").addClass("tb-large");
		}
	});

	/* ==================== 03. Home content slider ==================== */
	$('.home-c-slider').bxSlider({
		mode: 'horizontal',
		pager: false,
		controls: true,
		nextText: '<i class="bs-right fa fa-angle-right"></i>',
		prevText: '<i class="bs-left fa fa-angle-left"></i>'
	});

	/* ==================== 04. Home background slider ==================== */
	$('.home-bg-slider').bxSlider({
		mode: 'fade',
		auto: true,
		speed: 1000,
		pager: false,
		controls: false,
		nextText: '<i class="bs-right fa fa-angle-right"></i>',
		prevText: '<i class="bs-left fa fa-angle-left"></i>'
	});

	/* ==================== 05. Home background and content slider ==================== */
	$('.home-bgc-slider').bxSlider({
		mode: 'fade',
		pager: true,
		controls: true,
		nextText: '<i class="bs-right fa fa-angle-right"></i>',
		prevText: '<i class="bs-left fa fa-angle-left"></i>'
	});

	/* ==================== 06. Quote slider ==================== */
	$('.quote-slider').bxSlider({
		mode: 'horizontal',
		controls: false,
		adaptiveHeight: true
	});

	/* ==================== 07. Image slider ==================== */
	$('.img-slider').bxSlider({
		mode: 'fade',
		pager: false,
		controls: true,
		nextText: '<i class="bs-right fa fa-angle-right"></i>',
		prevText: '<i class="bs-left fa fa-angle-left"></i>'
	});

	/* ==================== 08. Services slider ==================== */
	$(function() {
	 
		var owl = $(".services-slider");

		owl.each( function() {

			var $this = $( this );

			$this.owlCarousel({
				pagination: false,
				navigation: false,
				items: 6,
				itemsDesktop: [1000,3],
				itemsTablet: [600,2],
				itemsMobile: [321,1],
				itemsScaleUp: true,
				autoPlay: true,
				stopOnHover: true
				
			});

			$this.siblings(".serv-next").click(function(){
				$this.trigger('owl.next');
			});

			$this.siblings(".serv-prev").click(function(){
				$this.trigger('owl.prev');
			});

		});
	 
	});

	/* ==================== 09. Employee slider ==================== */
	$(function() {
	 
		var owl = $(".employee-slider");

		owl.each( function() {

			var $this = $( this );

			$this.owlCarousel({
				pagination: false,
				navigation: false,
				items: 4,
				itemsDesktop: [1000,3],
				itemsTablet: [600,2],
				itemsMobile: [321,1],
				itemsScaleUp: true
			});

			$this.siblings(".emp-next").click(function(){
				$this.trigger('owl.next');
			});

			$this.siblings(".emp-prev").click(function(){
				$this.trigger('owl.prev');
			});

		});
	 
	});

	/* ==================== 10. Work slider ==================== */
	$(function() {

		var owl = $(".work-slider");

		owl.each( function() {

			var $this = $( this );

			$this.owlCarousel({
				pagination: false,
				navigation: false,
				items: 3,
				itemsDesktop: [1000,3],
				itemsTablet: [800,2],
				itemsMobile: [520,1]
			});

			$this.siblings(".work-next").click(function(){
				$this.trigger('owl.next');
			});

			$this.siblings(".work-prev").click(function(){
				$this.trigger('owl.prev');
			});

		});
	 
	});

	/* ==================== 11. Footer promo ==================== */
	$('.promo-control').click(function () {
		$('.footer-promo').slideToggle(500);
		if($('.footer-promo').is(':visible')){
			$('html, body').animate({
				scrollTop: $('.footer-promo').offset().top
			}, 500);
		}
	});

	/* ==================== 12. Contact form ==================== */

	/* ==================== 13. Scrollto ==================== */
	$(function(){
		$('.scrollto').bind('click.scrollto',function (e){
			e.preventDefault();

			var target = this.hash,
			$target = $(target);

			$('html, body').stop().animate({
				'scrollTop': $target.offset().top-0
			}, 900, 'swing', function () {
				window.location.hash = target;
			});
		});
	});

	var $body       = $( 'body' ),
		$window     = $( window ),
		$scrollThis = $( 'body, html' ),
		loggedIn    = $( '.admin-bar' ).length;

	//Navigation Scrolling
	$body.on( 'click', 'a[href*="#"]', function( e ) {

		var $this = $( this );

		if ( location.pathname.replace( /^\// , '' ) == this.pathname.replace( /^\//, '' ) && location.hostname == this.hostname ) {

			var target = $body.find( '#section-' + this.hash.slice(1) );

			target = target.length ? target : $body.find( '[name="section-' + this.hash.slice(1) + '"]' );

			if ( target.length ) {

				var $tobBarLarge = $( '.top-bar.tb-large' ),
					$tobBarSmall = $( '.top-bar.tb-small' );

				var offset = ( $tobBarLarge.length ) ? $tobBarLarge.outerHeight() - 50 : $tobBarSmall.outerHeight();

				e.preventDefault();

				$scrollThis.animate({
					scrollTop: ( loggedIn ) ? target.offset().top - offset - 32 : target.offset().top - offset
				}, 900, 'swing', function () {
					window.location.hash = $this.prop( 'hash' );
				});

			}

		}

	});

	$window.on( 'load', function() {

		setTimeout( function() {

			if ( '' === window.location.hash ) return;

			var target = $body.find( '#section-' + window.location.hash.slice(1) );

			target = target.length ? target : $body.find( '[name="section-' + window.location.hash.slice(1) + '"]' );

			if ( target.length ) {

				var $tobBarLarge = $( '.top-bar.tb-large' ),
					$tobBarSmall = $( '.top-bar.tb-small' );

				var offset = ( $tobBarLarge.length ) ? $tobBarLarge.outerHeight() - 50 : $tobBarSmall.outerHeight();

				$scrollThis.animate({
					scrollTop: ( loggedIn ) ? target.offset().top - offset - 32 : target.offset().top - offset
				}, 900, 'swing' );

			}

		}, 50 );

	});

	/* ==================== 14. Magnific popup ==================== */
	// Image popup
	$('.popup').magnificPopup({ 
		type: 'image',
		fixedContentPos: false,
		fixedBgPos: false,
		removalDelay: 300,
		mainClass: 'mfp-fade'
	});

	// YouTube, Vimeo and Google Maps popup
	$('.popup-youtube, .popup-vimeo, .popup-gmaps, .popup-video, a[href*="youtube.com/watch"]').magnificPopup({
		disableOn: 700,
		type: 'iframe',
		fixedContentPos: false,
		fixedBgPos: false,
		removalDelay: 300,
		mainClass: 'mfp-fade',
		preloader: false
	});

	jQuery( 'a[href*="vimeo.com"]' ).each( function() {

		var $this = $( this );

		if ( $this.attr( 'href' ).match(/(vimeo)\.(com)\/(\d+)/) ) {

			$this.magnificPopup({
				disableOn: 700,
				type: 'iframe',
				fixedContentPos: false,
				fixedBgPos: false,
				removalDelay: 300,
				mainClass: 'mfp-fade',
				preloader: false
			});

		}

	});

	// Gallery popup
	$('.popup-gallery').each( function() {
		$( this ).magnificPopup({
			delegate: 'a',
			type: 'image',
			gallery:{
				enabled:true
			},
			fixedContentPos: false,
			fixedBgPos: false,
			removalDelay: 300,
			mainClass: 'mfp-fade'
		});
	});

	/* ==================== 15. Equal height ==================== */
	/* Use the .equal class on a row if you want the columns to be equal in height */
	$('.equal').children('.col').equalizeHeight();
	$( window ).resize( function() {
		$( '.equal' ).children( '.col' ).equalizeHeight();
		setTimeout( function() {
			$( '.equal' ).children( '.col' ).equalizeHeight();
		}, 100 );
		setTimeout( function() {
			$( '.equal' ).children( '.col' ).equalizeHeight();
		}, 400 );
		setTimeout( function() {
			$( '.equal' ).children( '.col' ).equalizeHeight();
		}, 1400 );
		setTimeout( function() {
			$( '.equal' ).children( '.col' ).equalizeHeight();
		}, 2400 );
	});
	setTimeout( function() {
			$( window ).trigger( 'resize scroll' );
	}, 1000 );
	setTimeout( function() {
			$( window ).trigger( 'resize scroll' );
	}, 3000 );
	$( window ).load( function() {
		$( '.equal' ).children( '.col' ).equalizeHeight();
		$( window ).trigger( 'resize scroll' );
		setTimeout( function() {
			$( '.equal' ).children( '.col' ).equalizeHeight();
		}, 1000 );
		setTimeout( function() {
			$( '.equal' ).children( '.col' ).equalizeHeight();
		}, 1300 );
	});

	/* ==================== 16. fitVids ==================== */
	$(".responsive-video").fitVids();


})(jQuery);