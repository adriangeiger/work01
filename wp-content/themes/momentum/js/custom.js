jQuery( function( $ ) {

	var $window      = $( window ),
		$body        = $( 'body' ),
		$splash      = $( 'section.splash' ),
		$contact     = $( '#section-contact' ),
		$contactForm = $( '.peThemeContactForm' );

	$( '#commentform' ).addClass( 'form form-blog' );

	if ( $contactForm.length ) {

		$contactForm.peThemeContactForm();

	}

	$( '.featured-post-slider' ).bxSlider({
		mode: 'fade',
		pager: true,
		controls: true,
		nextText: '<i class="bs-right fa fa-angle-right"></i>',
		prevText: '<i class="bs-left fa fa-angle-left"></i>',
		adaptiveHeight : true
	});

	$body.on( 'click', 'a', function( e ) {

		var $this = $( this );

		if ( window.location.href.replace( window.location.hash, '' ).replace( '#', '' ) === $this.attr( 'href' ) ) {

			$( 'html, body' ).animate({ scrollTop: 0 }, 900, 'swing' );

			e.preventDefault();

		}

	});

	if ( $splash.length ) { $body.addClass( 'has-splash' ); } else { $body.addClass( 'has-no-splash' ); }
	if ( $contact.length ) { $body.addClass( 'has-contact' ); } else { $body.addClass( 'has-no-contact' ); }

});