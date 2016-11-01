jQuery( window ).load( function() {

	var showWhenImage   = jQuery( '#pe_theme_meta_splash__logo_, #pe_theme_meta_splash__image_type__buttonset, #pe_theme_meta_splash__background_' ).closest( '.option' ),
		showWhenGallery = jQuery( '#pe_theme_meta_splash__image_type__buttonset, #pe_theme_meta_splash__gallery_' ).closest( '.option' );

	var showWhenSingleTagline    = jQuery( '#pe_theme_meta_splash__title_, #pe_theme_meta_splash__description_, #pe_theme_meta_splash__button_1_text_, #pe_theme_meta_splash__button_1_url_, #pe_theme_meta_splash__button_1_color_, #pe_theme_meta_splash__button_1_icon_, #pe_theme_meta_splash__button_2_text_, #pe_theme_meta_splash__button_2_url_, #pe_theme_meta_splash__button_2_color_, #pe_theme_meta_splash__button_2_icon_' ).closest( '.option' ),
		showWhenMultipleTaglines = jQuery( '#pe_theme_meta_splash__headlines_' ).closest( '.option' );

	if ( jQuery( 'label[for="pe_theme_meta_splash__type__1"]' ).hasClass( 'ui-state-active') ) { // image home

		showWhenGallery.hide();
		showWhenImage.show();

		if ( jQuery( 'label[for="pe_theme_meta_splash__image_type__0"]' ).hasClass( 'ui-state-active' ) ) { // simple tagline

			showWhenMultipleTaglines.hide();
			showWhenSingleTagline.show();

		} else { // multiple taglines

			showWhenSingleTagline.hide();
			showWhenMultipleTaglines.show();

		}

	} else if ( jQuery( 'label[for="pe_theme_meta_splash__type__2"]' ).hasClass( 'ui-state-active') ) { // gallery home

		showWhenImage.hide();
		showWhenGallery.show();

		if ( jQuery( 'label[for="pe_theme_meta_splash__image_type__0"]' ).hasClass( 'ui-state-active' ) ) { // simple tagline

			showWhenMultipleTaglines.hide();
			showWhenSingleTagline.show();

		} else { // multiple taglines

			showWhenSingleTagline.hide();
			showWhenMultipleTaglines.hide();

		}
		
	} else {

		showWhenImage.hide();
		showWhenGallery.hide();
		showWhenSingleTagline.hide();
		showWhenMultipleTaglines.hide();

	}

	jQuery( 'label[for="pe_theme_meta_splash__type__0"], label[for="pe_theme_meta_splash__type__1"], label[for="pe_theme_meta_splash__type__2"], label[for="pe_theme_meta_splash__image_type__0"], label[for="pe_theme_meta_splash__image_type__1"]' ).on( 'click', function(e) {

		if ( jQuery( 'label[for="pe_theme_meta_splash__type__1"]' ).hasClass( 'ui-state-active') ) { // image home

			showWhenGallery.hide();
			showWhenImage.show();

			if ( jQuery( 'label[for="pe_theme_meta_splash__image_type__0"]' ).hasClass( 'ui-state-active' ) ) { // simple tagline

				showWhenMultipleTaglines.hide();
				showWhenSingleTagline.show();

			} else { // multiple taglines

				showWhenSingleTagline.hide();
				showWhenMultipleTaglines.show();

			}

		} else if ( jQuery( 'label[for="pe_theme_meta_splash__type__2"]' ).hasClass( 'ui-state-active') ) { // gallery home

			showWhenImage.hide();
			showWhenGallery.show();

			if ( jQuery( 'label[for="pe_theme_meta_splash__image_type__0"]' ).hasClass( 'ui-state-active' ) ) { // simple tagline

				showWhenMultipleTaglines.hide();
				showWhenSingleTagline.show();

			} else { // multiple taglines

				showWhenSingleTagline.hide();
				showWhenMultipleTaglines.hide();

			}
			
		} else {

			showWhenImage.hide();
			showWhenGallery.hide();

		}

	});

});