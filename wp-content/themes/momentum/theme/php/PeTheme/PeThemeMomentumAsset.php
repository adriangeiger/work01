<?php

class PeThemeMomentumAsset extends PeThemeAsset  {

	public function __construct(&$master) {

		$this->minifiedJS = 'theme/compressed/theme.min.js';
		$this->minifiedCSS = 'theme/compressed/theme.min.css';

		//define( 'PE_THEME_LOCAL_VIDEO_SUPPORT',true);

		parent::__construct($master);
		
	}

	public function registerAssets() {

		add_filter( 'pe_theme_js_init_file',array(&$this, 'pe_theme_js_init_file_filter' ));
		add_filter( 'pe_theme_js_init_deps',array(&$this, 'pe_theme_js_init_deps_filter' ));
		add_filter( 'pe_theme_minified_js_deps',array(&$this, 'pe_theme_minified_js_deps_filter' ));
		
		parent::registerAssets();

		if ($this->minifyCSS) {

			$deps = array(
				'pe_theme_compressed',
			);

		} else {

			// theme styles
			$this->addStyle( 'css/lib/font-awesome.min.css',array(), 'pe_theme_momentum-font_awesome' );
			$this->addStyle( 'css/lib/magnific-popup.css',array(), 'pe_theme_momentum-magnific_popup' );
			$this->addStyle( 'css/lib/bxslider.css',array(), 'pe_theme_momentum-bxslider' );
			$this->addStyle( 'css/lib/owl.carousel.css',array(), 'pe_theme_momentum-owl_carousel' );
			$this->addStyle( 'css/lib/owl.theme.css',array(), 'pe_theme_momentum-owl_theme' );
			$this->addStyle( 'css/lib/base.css',array(), 'pe_theme_momentum-base' );

			$this->addStyle( 'css/style.css',array(), 'pe_theme_momentum-style' );

			$this->addStyle( 'css/peblog.css',array(), 'pe_theme_momentum-peblog' );
			$this->addStyle( 'css/blog.css',array(), 'pe_theme_momentum-blog' );
			$this->addStyle( 'css/custom.css',array(), 'pe_theme_momentum-custom' );

			$deps = array(
				'pe_theme_momentum-font_awesome',
				'pe_theme_momentum-magnific_popup',
				'pe_theme_momentum-bxslider',
				'pe_theme_momentum-owl_carousel',
				'pe_theme_momentum-owl_theme',
				'pe_theme_momentum-base',
				'pe_theme_momentum-peblog',
				'pe_theme_momentum-style',
				'pe_theme_momentum-blog',
				'pe_theme_momentum-custom',
			);

		}

		$this->addStyle( 'style.css',$deps, 'pe_theme_init' );

		$this->addScript( 'theme/js/pe/pixelentity.controller.js', array(
			//'pe_theme_mobile',
			'pe_theme_utils_browser',
			'pe_theme_selectivizr',
			'pe_theme_lazyload',
			//'pe_theme_flare',
			'pe_theme_widgets_contact',
			'pe_theme_momentum-magnific_popup',
			'pe_theme_momentum-bxslider',
			'pe_theme_momentum-owl_carousel',
			'pe_theme_momentum-fitvids',
			'pe_theme_momentum-equal',
			'pe_theme_momentum-main',
			'pe_theme_momentum-custom',
		), 'pe_theme_controller' );

		$this->addScript( 'js/lib/jquery.magnific-popup.min.js',array(), 'pe_theme_momentum-magnific_popup' );
		$this->addScript( 'js/lib/jquery.bxslider.min.js',array(), 'pe_theme_momentum-bxslider' );
		$this->addScript( 'js/lib/owl.carousel.min.js',array(), 'pe_theme_momentum-owl_carousel' );
		$this->addScript( 'js/lib/jquery.fitvids.js',array(), 'pe_theme_momentum-fitvids' );
		$this->addScript( 'js/lib/jquery.equal.js',array(), 'pe_theme_momentum-equal' );

		$this->addScript( 'js/main.js',array(), 'pe_theme_momentum-main' );

		$this->addScript( 'js/custom.js',array(), 'pe_theme_momentum-custom' );
		
	}

	public function pe_theme_js_init_file_filter( $js ) {

		return $js;
		//return 'js/custom.js';

	}

	public function pe_theme_js_init_deps_filter( $deps ) {

		return $deps;
		/*
		  return array(
		  'jquery',
		  );
		*/
	}

	public function pe_theme_minified_js_deps_filter( $deps ) {

		return $deps;
		//return array( 'jquery' );

	}

	public function style() {

		bloginfo( 'stylesheet_url' ); 

	}

	public function enqueueAssets() {

		$this->registerAssets();

		$t =& peTheme();

		if ( $this->minifyJS && file_exists( PE_THEME_PATH . '/preview/init.js' ) ) {

			$this->addScript( 'preview/init.js', array( 'jquery' ), 'pe_theme_preview_init' );
			
			wp_localize_script( 'pe_theme_preview_init', 'o', array(
			//'dark' => PE_THEME_URL.'/css/dark_skin.css',
				'css' => $this->master->color->customCSS( true, 'color1' )
			) );

			wp_enqueue_script( 'pe_theme_preview_init' );

		}	

		wp_enqueue_style( 'pe_theme_init' );
		wp_enqueue_script( 'pe_theme_init' );

		wp_localize_script( 'pe_theme_init', '_momentum', array(
			'ajax-loading' => PE_THEME_URL . '/images/ajax-loader.gif',
			'home_url'     => home_url( '/' ),
		) );

		if ( $this->minifyJS && file_exists( PE_THEME_PATH . '/preview/preview.js' ) ) {

			$this->addScript( 'preview/preview.js',array( 'pe_theme_init' ), 'pe_theme_skin_chooser' );

			wp_localize_script( 'pe_theme_skin_chooser', 'pe_skin_chooser', array( 'url' => urlencode( PE_THEME_URL . '/' ) ) );
			wp_enqueue_script( 'pe_theme_skin_chooser' );

		}

		wp_enqueue_script( 'pe_theme_momentum-gmap', 'http://maps.googleapis.com/maps/api/js?sensor=false' );

	}


}