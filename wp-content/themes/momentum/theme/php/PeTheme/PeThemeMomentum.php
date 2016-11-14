<?php

class PeThemeMomentum extends PeThemeController {

	public $preview = array();

	public function __construct() {

		// custom post types
		add_action("pe_theme_custom_post_type",array(&$this,"pe_theme_custom_post_type"));

		// wp_head stuff
		add_action("pe_theme_wp_head",array(&$this,"pe_theme_wp_head"));

		// google fonts
		add_filter("pe_theme_font_variants",array(&$this,"pe_theme_font_variants_filter"),10,2);

		// menu
		add_filter("wp_nav_menu_objects",array(&$this,"wp_nav_menu_objects_filter"),10,2);
		add_filter("pe_theme_menu_item_after",array(&$this,"pe_theme_menu_item_after_filter"),10,3);

		// custom menu fields
		add_filter("pe_theme_menu_custom_fields",array(&$this,"pe_theme_menu_custom_fields_filter"),10,3);

		// social links
		add_filter("pe_theme_social_icons",array(&$this,"pe_theme_social_icons_filter"));
		add_filter("pe_theme_content_get_social_link",array(&$this,"pe_theme_content_get_social_link_filter"),10,4);

		// comment submit button class
		add_filter("pe_theme_comment_submit_class",array(&$this,"pe_theme_comment_submit_class_filter"));

		// use prio 30 so gets executed after standard theme filter
		add_filter("the_content_more_link",array(&$this,"the_content_more_link_filter"),30);

		// remove junk from project screen
		add_action('pe_theme_metabox_config_project',array(&$this,'pe_theme_momentum_metabox_config_project'),200);

		// add featured image to testimonial
		add_action('init',array(&$this,'pe_theme_momentum_testimonial_supports'),200);

		// shortcodes
		add_filter("pe_theme_shortcode_columns_mapping",array(&$this,"pe_theme_shortcode_columns_mapping_filter"));
		add_filter("pe_theme_shortcode_columns_options",array(&$this,"pe_theme_shortcode_columns_options_filter"));
		add_filter("pe_theme_shortcode_columns_container",array(&$this,"pe_theme_shortcode_columns_container_filter"),10,2);

		// portfolio
		add_filter("pe_theme_filter_item",array(&$this,"pe_theme_project_filter_item_filter"),10,4);

		// remove staff meta
		add_action('pe_theme_metabox_config_staff',array(&$this,'pe_theme_metabox_config_staff_action'),11);

		// alter services meta
		add_action('pe_theme_metabox_config_service',array(&$this,'pe_theme_metabox_config_service_action'),11);

		// custom meta for gallery images
		add_filter( 'pe_theme_gallery_image_fields', array( $this, 'pe_theme_gallery_image_fields_filter' ) );

		// custom homepage meta js
		add_action( 'admin_enqueue_scripts', array( $this, 'pe_theme_momentum_custom_meta_js' ) );

		// font awesome admin picker
		add_action( 'admin_enqueue_scripts', array( $this, 'pe_theme_font_awesome_icons' ) );

		// custom video metabox
		add_action('pe_theme_metabox_config_video',array(&$this,'pe_theme_metabox_config_video'),99);

		// builder
		add_filter('pe_theme_view_layout_open',array(&$this,'pe_theme_view_layout_no_parent'));
		add_filter('pe_theme_view_layout_close',array(&$this,'pe_theme_view_layout_no_parent'));
		add_filter('pe_theme_layoutmodule_open',array(&$this,'pe_theme_view_layout_no_parent'));
		add_filter('pe_theme_layoutmodule_close',array(&$this,'pe_theme_view_layout_no_parent'));

		// menu wrapper
		add_filter( 'pe_theme_menu_items_wrap', array( $this, 'pe_theme_menu_items_wrap_filter' ) );

	}

	public function pe_theme_menu_items_wrap_filter( $html ) {

		return '<ul class="nav navbar-right navbar-nav">%3$s</ul>';

	}

	public function pe_theme_view_layout_no_parent($markup) {
		return "";
	}

	public function pe_theme_momentum_custom_meta_js() {

		PeThemeAsset::addScript("js/momentum-homepage-meta.js",array('jquery'),"pe_theme_momentum_homepage_meta");

		$screen = get_current_screen();

		if ( is_admin() && ( 'page' === $screen->post_type || 'post' === $screen->post_type ) ) {
			wp_enqueue_script("pe_theme_momentum_homepage_meta");
		}

	}

	public function pe_theme_font_awesome_icons() {

		PeThemeAsset::addStyle("css/lib/font-awesome.min.css",array(),"pe_theme_fontawesome");

		$screen = get_current_screen();

		if ( is_admin() && ( 'page' === $screen->post_type || 'post' === $screen->post_type || 'project' === $screen->post_type ) ) {

			wp_enqueue_style( 'pe_theme_fontawesome' );

		}

	}

	public function the_content_more_link_filter($link) {
		return sprintf('<div class="had-read-more"><a class="read-more-link blog-post-more arrow-link" href="%s">%s</a></div>',get_permalink(),__("Read more",'Pixelentity Theme/Plugin'));
	}

	public function pe_theme_project_filter_item_filter( $html, $aclass, $slug, $name ) {
		return sprintf( '<li class="filter" data-filter="%s"><a href="#">%s</a></li>', '' === $slug ? 'all' : "filter-$slug", $name );
	}

	public function pe_theme_wp_head() {
		$this->font->apply();
		$this->color->apply();

		// custom CSS field
		if ($customCSS = $this->options->get("customCSS")) {
			printf('<style type="text/css">%s</style>',stripslashes($customCSS));
		}

		// custom JS field
		if ($customJS = $this->options->get("customJS")) {
			printf('<script type="text/javascript">%s</script>',stripslashes($customJS));
		}

	}

	public function pe_theme_font_variants_filter( $variants, $font ) {

		if ($font === "Open Sans") {
			$variants="$font:400italic,300,400,700,800,100";
		}
		else if ($font === "Lato") {
			$variants="$font:100,200,300,700";
		}
		else if ($font === "Montserrat") {
			$variants="$font:400,700";
		}
		else if ($font === "Volkhov") {
			$variants="$font:400italic,700italic,400,700";
		}
		else if ($font === "Roboto") {
			$variants="$font:400,300,700,400italic,700italic,300italic,100";
		}
		else if ($font === 'Bitter') {
			$variants="$font:regular:italic:bold";
		}
		else if ($font === 'Raleway') {
			$variants="$font:400,100,300,700";
		}

		return $variants;
	}

	public function wp_nav_menu_objects_filter( $items, $args ) {
		if ( is_array( $items ) && ! empty( $args->theme_location ) ) {
			$home = false;

			if (is_page()) {
				if ($this->content->pageTemplate() === "page_home.php") {
					$home = get_page_link(get_the_id());
				}
			}

			foreach ($items as $id => $item) {

				if (!empty($item->post_parent)) {
					if ($item->object === "page") {
						$page = get_page($item->object_id);
						if (!empty($page->post_name)) {
							$parent = get_page_link($item->post_parent);
							$slug = $page->post_name;
							$items[$id]->url = $home ? $parent . "#{$slug}" : $parent . "#{$slug}";
							//$item->classes[] = $home ? "smoothscroll" : "";
						}
					}
				} else if ($item->url === $home) {
					if ($item->object === "page") {

						$page = get_page($item->object_id);
						$items[$id]->url = $home ? "#" . $page->post_name : $items[$id]->url . "#" . $page->post_name;
						//$item->classes[] = $home ? "smoothscroll" : "";

					}
				}

			}
		}
		return $items;
	}

	public function pe_theme_menu_custom_fields_filter($options,$depth = false,$item = false) {

		if (!empty($item->object) && $item->object != "page") {
			// if menu item is not a page, no custom option
			return $options;
		}

		$options =
			array(
				  "name" => 
				  array(
						"label"=>__("Section",'Pixelentity Theme/Plugin'),
						"type"=>"Text",
						"description" => __("Optional section link name.",'Pixelentity Theme/Plugin'),
						"default"=> ""
						)
				  );

		return $options;

	}

	public function pe_theme_menu_item_after_filter($after,$item,$depth) {
		if ($item->object == 'page' && !empty($item->pe_meta->name)) {
			$section = strtr($item->pe_meta->name,array('#' => ''));
			$item->url .= "#$section";
		}
		return $after;
	}

	public function pe_theme_social_icons_filter($icons = null) {
		return 
			array(
				  // label => icon | tooltip text
				  __("Dribbble",'Pixelentity Theme/Plugin') => "fa fa-dribbble|Dribbble",
				  __("Dropbox",'Pixelentity Theme/Plugin') => "fa fa-dropbox|Dropbox",
				  __("Facebook",'Pixelentity Theme/Plugin') => "fa fa-facebook|Facebook",
				  __("Flickr",'Pixelentity Theme/Plugin') => "fa fa-flickr|Flickr",
				  __("Github",'Pixelentity Theme/Plugin') => "fa fa-github|Github",
				  __("Google+",'Pixelentity Theme/Plugin') => "fa fa-google-plus|Google+",
				  __("Instagram",'Pixelentity Theme/Plugin') => "fa fa-instagram|Instagram",
				  __("Linkedin",'Pixelentity Theme/Plugin') => "fa fa-linkedin|Linkedin",
				  __("Pinterest",'Pixelentity Theme/Plugin') => "fa fa-pinterest|Pinterest",
				  __("Skype",'Pixelentity Theme/Plugin') => "fa fa-skype|Skype",
				  __("Twitter",'Pixelentity Theme/Plugin') => "fa fa-twitter|Twitter",
				  __("Vimeo",'Pixelentity Theme/Plugin') => "fa fa-vimeo-square|Vimeo",
				  __("VK",'Pixelentity Theme/Plugin') => "fa fa-vk|VK",
				  __("YouTube",'Pixelentity Theme/Plugin') => "fa fa-youtube|YouTube",
				  );
	}

	public function pe_theme_content_get_social_link_filter( $html, $link, $tooltip, $icon ) {
		return sprintf( '<a href="%s" target="_blank"><i class="%s"></i></a>', $link, $icon );
	}

	public function pe_theme_comment_submit_class_filter() {
		return "contour-btn red";
	}

	public function init() {
		parent::init();

		if (PE_THEME_PLUGIN_MODE) {
			return;
		}
		
		if ($this->options->get("retina") === "yes") {
			add_filter("pe_theme_resized_img",array(&$this,"pe_theme_resized_retina_filter"),10,5);
		} else if ($this->options->get("lazyImages") === "yes") {
			add_filter("pe_theme_resized_img",array(&$this,"pe_theme_resized_img_filter"),10,4);
		}
	}

	public function pe_theme_custom_post_type() {
		$this->gallery->cpt();
		$this->video->cpt();
		$this->project->cpt();
		//$this->ptable->cpt();
		//$this->staff->cpt();
		//$this->service->cpt();
		//$this->testimonial->cpt();
		//$this->logo->cpt();
		//$this->slide->cpt();
		//$this->view->cpt();

	}

	public function pe_theme_shortcode_columns_mapping_filter($array) {
			return array(
				'1/1' => 'twelve col',
				"1/3" => "four col",
				"1/2" => "six col",
				"1/4" => "three col",
				"2/3" => "eight col",
				"1/6" => "two col",
				"last" => '',
			);
		}

	public function pe_theme_shortcode_columns_options_filter($array) {
		unset($array['2 Column layouts']['5/6 1/6']);
		unset($array['2 Column layouts']['1/6 5/6']);
		unset($array['2 Column layouts']['1/4 3/4']);
		unset($array['2 Column layouts']['3/4 1/4']);
		unset($array['3 Column layouts']['1/4 1/4 2/4']);
		unset($array['3 Column layouts']['2/4 1/4 1/4']);

		$single['Single column layout']['1/1'] = '1/1';

		$array = 
			array_merge(
						$single,
						$array
						);
		//unset($array['4 Column layouts']);
		//unset($array['6 Column layouts']);

		return $array;
	}

	public function pe_theme_shortcode_columns_container_filter( $template, $content ) {

		return sprintf('<div class="row">%s</div>',$content);

	}


	public function boot() {
		parent::boot();

		
		PeGlobal::$config["content-width"] = 990;
		PeGlobal::$config["post-formats"] = array("video","gallery");
		PeGlobal::$config["post-formats-project"] = array("video","gallery");

		PeGlobal::$config["image-sizes"]["thumbnail"] = array(120,90,true);
		PeGlobal::$config["image-sizes"]["post-thumbnail"] = array(260,200,false);
		

		// blog layouts
		PeGlobal::$config["blog"] =
			array(
				  __("Default",'Pixelentity Theme/Plugin') => "",
				  __("Search",'Pixelentity Theme/Plugin') => "search",
				  __("Alternate",'Pixelentity Theme/Plugin') => "project"
				  );

		PeGlobal::$config["shortcodes"] = 
			array(
				'MomentumButton',
				'BS_Columns',
				'BS_Video',
			);

			PeGlobal::$config["views"] = array(
				"LayoutModuleMomentumAbout",
				"LayoutModuleMomentumBlog",
				"LayoutModuleMomentumNews",
				"LayoutModuleMomentumCalltoaction",
				"LayoutModuleMomentumColumns",
				"LayoutModuleMomentumIntro",
				"LayoutModuleMomentumIntroItem",
				"LayoutModuleMomentumProcess",
				"LayoutModuleMomentumProcessItem",
				"LayoutModuleMomentumRecentWork",
				"LayoutModuleMomentumService",
				"LayoutModuleMomentumServices",
				"LayoutModuleMomentumTeamMember",
				"LayoutModuleMomentumText",
			);

		PeGlobal::$config["sidebars"] =
			array(
				  "default" => __("Default post/page",'Pixelentity Theme/Plugin'),
				  //"footer" => __("Footer Widgets",'Pixelentity Theme/Plugin')
				  );

		PeGlobal::$config["colors"] = array(
			"color1" => array(
				"label"     => __("Primary Color",'Pixelentity Theme/Plugin'),
				"selectors" => array(
					".text-color" => "color",
					".btn.outline.color" => "color",
					"a.arrow-link:hover" => "color",
					"a.arrow-link:hover:before" => "color",
					".service-item:hover > i" => "color",
					".service-item:hover > a.arrow-link:before" => "color",
					".c-details a:hover" => "color",
					".c-details a:hover i" => "color",

					"a.btn:hover" => "background-color",
					"button:hover" => "background-color",
					"input[type='submit']:hover" => "background-color",
					"a .icon:hover" => "background-color",
					".icon-nav a:hover > i" => "background-color",
					"a > .back-top" => "background-color",
					"a >.back-top" => "background-color:0.9",

					"a.btn.outline:hover" => "background-color",
					"button.outline:hover" => "background-color",
					"input[type='submit'].outline:hover" => "background-color",
					".btn.color" => "background-color",
					"* .btn.outline.color" => "background-color",

					"* a.btn.outline:hover" => "border-color",
					"* button.outline:hover" => "border-color",
					"* input[type='submit'].outline:hover" => "border-color",
				),
				"default" => "#ff4800",
			),
		);
		

		PeGlobal::$config["fonts"] = array(
			"fontBody" => array(
				"label"     => __("General Font",'Pixelentity Theme/Plugin'),
				"selectors" => array(
					'body',
					'blockquote small',
					'.o-hover em',
				),
				"default" => "Open Sans",
			),
			"fontHeadings" => array(
				"label"     => __("Serif Font",'Pixelentity Theme/Plugin'),
				"selectors" => array(
					'h1',
					'h2',
					'h3',
					'h4',
					'h5',
					'h6',
					'.h1',
					'.h2',
					'.h3',
					'.h4',
					'.h5',
					'.h6',
					'.uber',
					'.btn',
					'button',
					'input[type="submit"]',
					'a.arrow-link',
					'.o-hover span',
					'.menu',
					'.icon-nav b',
					'.menu',
				),
				"default" => "Raleway",
			),
		);		

		$options = array();

		$galleries = $this->gallery->option();

		$none = array( __("None",'Pixelentity Theme/Plugin') => '-1' );

		$galleries = array_merge( $none, $galleries );

		$options = array_merge( $options, array(
			'import_demo' => $this->defaultOptions['import_demo'],
			'logo' => array(
				'label'       => __( 'Logo' ,'Pixelentity Theme/Plugin'),
				'type'        => 'Upload',
				'section'     => __( 'General' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'This is the main site logo image. The image should be a .png file.' ,'Pixelentity Theme/Plugin'),
				'default'     => PE_THEME_URL . '/images/logo.png',
			),
			'site_title' => array(
				'wpml'        => true,
				'label'       => __( 'Header Title' ,'Pixelentity Theme/Plugin'),
				'type'        => 'Text',
				'section'     => __( 'General' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Displayed alongide the logo.' ,'Pixelentity Theme/Plugin'),
				'default'     => 'Momentum',
			),
			'favicon' => array(
				'label'       => __( 'Favicon' ,'Pixelentity Theme/Plugin'),
				'type'        => 'Upload',
				'section'     => __( 'General' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'This is the favicon for your site. The image can be a .jpg, .ico or .png with dimensions of 16x16px ' ,'Pixelentity Theme/Plugin'),
				'default'     => PE_THEME_URL.'/favicon.png',
			),
			'customCSS' => $this->defaultOptions['customCSS'],
			'customJS'  => $this->defaultOptions['customJS'],
			'colors'    => array(
				'label'       => __( 'Custom Colors' ,'Pixelentity Theme/Plugin'),
				'type'        => 'Help',
				'section'     => __( 'Colors' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'In this page you can set alternative colors for the main colored elements in this theme. One color options has been provided. To change the color used on these elements simply write a new hex color reference number into the fields below or use the color picker which appears when each field obtains focus. Once you have selected your desired colors make sure to save them by clicking the <b>Save All Changes</b> button at the bottom of the page. Then just refresh your page to see the changes.<br/><br/><b>Please Note:</b> Some of the elements in this theme are made from images (Eg. Icons) and these items may have a color. It is not possible to change these elements via this page, instead such elements will need to be changed manually by opening the images/icons in an image editing program and manually changing their colors to match your theme\'s custom color scheme. <br/><br/>To return all colors to their default values at any time just hit the <b>Restore Default</b> link beneath each field.' ,'Pixelentity Theme/Plugin'),
			),
			'googleFonts' => array(
				'label'       => __( 'Custom Fonts' ,'Pixelentity Theme/Plugin'),
				'type'        => 'Help',
				'section'     => __( 'Fonts' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'In this page you can set the typefaces to be used throughout the theme. For each elements listed below you can choose any front from the Google Web Font library. Once you have chosen a font from the list, you will see a preview of this font immediately beneath the list box. The icons on the right hand side of the font preview, indicate what weights are available for that typeface.<br/><br/><strong>R</strong> -- Regular,<br/><strong>B</strong> -- Bold,<br/><strong>I</strong> -- Italics,<br/><strong>BI</strong> -- Bold Italics<br/><br/>When decideing what font to use, ensure that the chosen font contains the font weight required by the element. For example, main headings are bold, so you need to select a new font for these elements which supports a bold font weight. If you select a font which does not have a bold icon, the font will not be applied. <br/><br/>Browse the online <a href="http://www.google.com/webfonts">Google Font Library</a><br/><br/><b>Custom fonts</b> (Advanced Users):<br/> Other then those available from Google fonts, custom fonts may also be applied to the elements listed below. To do this an additional field is provided below the google fonts list. Here you may enter the details of a font family, size, line-height etc. for a custom font. This information is entered in the form of the shorthand \'font:\' CSS declaration, for example:<br/><br/><b>bold italic small-caps 1em/1.5em arial,sans-serif</b><br/><br/>If a font is specified in this field then the font listed in the Google font drop menu above will not be applied to the element in question. If you wish to use the Google font specified in the drop down list and just specify a new font size or line height, you can do so in this field also, however the name of the Google font <b>MUST</b> also be entered into this field. You may need to visit the Google fonts web page to find the exact CSS name for the font you have chosen.' ,'Pixelentity Theme/Plugin'),
			),
			'contactEmail' => $this->defaultOptions['contactEmail'],
			'contactSubject' => $this->defaultOptions['contactSubject'],
			'contactSectionTitle' => array(
				'label'       => __( 'Contact section title' ,'Pixelentity Theme/Plugin'),
				'wpml'        =>  true,
				'type'        => 'Text',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Title of the contact section.' ,'Pixelentity Theme/Plugin'),
				'default'     => __( 'Contact' ,'Pixelentity Theme/Plugin'),
			),
			'contactSectionTitle' => array(
				'label'       => __( 'Contact section title' ,'Pixelentity Theme/Plugin'),
				'wpml'        =>  true,
				'type'        => 'Text',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Title of the contact section.' ,'Pixelentity Theme/Plugin'),
				'default'     => __( 'Contact' ,'Pixelentity Theme/Plugin'),
			),
			'contactSectionText' => array(
				'label'       => __( 'Contact section text' ,'Pixelentity Theme/Plugin'),
				'wpml'        =>  true,
				'type'        => 'TextArea',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Text displayed next to the contact form.' ,'Pixelentity Theme/Plugin'),
				'default' => '<h5>Let\'s get in touch</h5>
				<p>Want to discus your ideas for a new project or just want to say hi? It\'s all good, we\'d love to connect with you. Just fill out the form aside or contact us via the details below.</p> 


				<h5>Contact details</h5>
				<address class="c-details">
					<a href="http://www.google.com/maps/@40.7501825,-73.9912312,17z" target="new">
						<i class="fa fa-map-marker"></i>
						<span>412 7th Ave, New York<br>
						NY 10018, United States</span>
					</a>
					<br>
					<a href="mailto:hello@yourdomain.com">
						<i class="fa fa-envelope-o"></i>
						<span>hello@yourdomain.com</span>
					</a>
					<br>
					<a href="tel:+12125551234">
						<i class="fa fa-phone"></i>
						<span>+1 212 555 1234</span>
					</a>
				</address>',
			),
			'msgOK' => array(
				'wpml'        => true,
				'label'       => __( 'Mail Sent Message' ,'Pixelentity Theme/Plugin'),
				'type'        => 'TextArea',
				'section'     => __( 'Contact Form' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Message shown when form message has been sent without errors' ,'Pixelentity Theme/Plugin'),
				'default'     =>'<strong>Yay!</strong> Message sent.'
			),
			'msgKO' => array(
				'wpml'        => true,
				'label'       => __( 'Form Error Message' ,'Pixelentity Theme/Plugin'),
				'type'        => 'TextArea',
				'section'     => __( 'Contact Form' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'Message shown when form message encountered errors' ,'Pixelentity Theme/Plugin'),
				'default'     => '<strong>Error!</strong> Please validate your fields.'
			),
			'footerCopyright' => array(
				'label'       => __( 'Copyright' ,'Pixelentity Theme/Plugin'),
				'wpml'        =>  true,
				'type'        => 'TextArea',
				'section'     => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description' => __( 'This is the footer copyright message.' ,'Pixelentity Theme/Plugin'),
				'default'     => '&copy; 2014 - We\'ve consumed 374 cups of <i class="fa fa-coffee"></i> while building Momentum',
			),
			'footerSocialLinks' => array(
				'label'        => __( 'Social Profile Links' ,'Pixelentity Theme/Plugin'),
				'type'         => 'Items',
				'section'      => __( 'Footer' ,'Pixelentity Theme/Plugin'),
				'description'  => __( 'Add one or more links to social networks.' ,'Pixelentity Theme/Plugin'),
				'button_label' => __( 'Add Social Link' ,'Pixelentity Theme/Plugin'),
				'sortable'     => true,
				'auto'         => __( 'Layer' ,'Pixelentity Theme/Plugin'),
				'unique'       => false,
				'editable'     => false,
				'legend'       => false,
				'fields'       => array(
					array(
						'label'   => __( 'Social Network' ,'Pixelentity Theme/Plugin'),
						'name'    => 'icon',
						'type'    => 'select',
						'options' => apply_filters( 'pe_theme_social_icons', array() ),
						'width'   => 185,
						'default' => '',
					),
					array(
						'name'    => 'url',
						'type'    => 'text',
						'width'   => 300,
						'default' => '#',
						)
					),
				'default' => ''
			),
		));

		foreach( PeGlobal::$const->gmap->metabox["content"] as $key => $value ) {

			PeGlobal::$const->gmap->metabox["content"][ $key ]["section"] = __("Footer",'Pixelentity Theme/Plugin');

		}

		unset( PeGlobal::$const->gmap->metabox["content"]["title"] );
		unset( PeGlobal::$const->gmap->metabox["content"]["description"] );
		
		//$options = array_merge($options, PeGlobal::$const->gmap->metabox["content"]);

		$options = array_merge($options,$this->font->options());
		$options = array_merge($options,$this->color->options());

		//$options["retina"] =& $this->defaultOptions["retina"];
		//$options["lazyImages"] =& $this->defaultOptions["lazyImages"];
		$options["minifyJS"] =& $this->defaultOptions["minifyJS"];
		$options["minifyCSS"] =& $this->defaultOptions["minifyCSS"];

		$options["minifyJS"]['default'] = 'yes';

		$options["adminThumbs"] =& $this->defaultOptions["adminThumbs"];
		if (!empty($this->defaultOptions["mediaQuick"])) {
			$options["mediaQuick"] =& $this->defaultOptions["mediaQuick"];
			$options["mediaQuickDefault"] =& $this->defaultOptions["mediaQuickDefault"];
		}

		$options["adminLogo"] =& $this->defaultOptions["adminLogo"];
		$options["adminUrl"] =& $this->defaultOptions["adminUrl"];

		
		PeGlobal::$config["options"] = apply_filters("pe_theme_options",$options);

	}

	public function splash() {

		$splash = array(
			'type'     => '',
			'title'    => __( 'Splash' ,'Pixelentity Theme/Plugin'),
			'priority' => 'core',
			'where'    => array(
				'post' => 'all',
			),
			'content' => array(),
		);

		$splash['content']['type'] = array(
			'label'       => __( 'Type' ,'Pixelentity Theme/Plugin'),
			'type'        => 'RadioUI',
			'description' => __( 'Choose between two different splash types.' ,'Pixelentity Theme/Plugin'),
			'options'     => array(
				__( 'None' ,'Pixelentity Theme/Plugin')    => 'none',
				__( 'Image' ,'Pixelentity Theme/Plugin')   => 'image',
				__( 'Gallery' ,'Pixelentity Theme/Plugin') => 'gallery',
			),
			'default' => 'none',
		);

		$splash['content']['image_type'] = array(
			'label'       => __( 'Layout type' ,'Pixelentity Theme/Plugin'),
			'type'        => 'RadioUI',
			'description' => __( 'Choose between two different image splash types.' ,'Pixelentity Theme/Plugin'),
			'options'     => array(
				__( 'Single tagline' ,'Pixelentity Theme/Plugin')    => 'single',
				__( 'Multiple taglines' ,'Pixelentity Theme/Plugin') => 'multiple',
			),
			'default' => 'single',
		);

		$splash['content']['background'] = array(
			'label'       => __( 'Background Image' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Upload',
			'description' => __( 'Upload image displayed in the background of the splash area.' ,'Pixelentity Theme/Plugin'),
			'default'     => '',
		);

		$splash['content']['gallery'] = array(
			'label'       => __( 'Gallery' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Select',
			'description' => __( 'Gallery used for splash area. Captions can be added when editing that gallery.' ,'Pixelentity Theme/Plugin'),
			'options'     => $this->gallery->option(),
			'default'     => '',
		);

		$splash['content']['title'] = array(
			'label'       => __( 'Title' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Text used as a splash title.' ,'Pixelentity Theme/Plugin'),
			'default'     => '',
		);

		$splash['content']['description'] = array(
			'label'       => __( 'Description' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Text used as a splash subtitle.' ,'Pixelentity Theme/Plugin'),
			'default'     => '',
		);

		$splash['content']['logo'] = array(
			'label'       => __( 'Image logo' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Upload',
			'description' => __( 'Displayed at the center of the splash area.' ,'Pixelentity Theme/Plugin'),
			'default'     => '',
		);

		$splash['content']['button_1_text'] = array(
			'label'       => __( 'Button 1 text' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Text of the button.' ,'Pixelentity Theme/Plugin'),
			'default'     => '',
		);

		$splash['content']['button_1_url'] = array(
			'label'       => __( 'Button 1 url' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Link for the button.' ,'Pixelentity Theme/Plugin'),
			'default'     => '#',
		);

		$splash['content']['button_1_color'] = array(
			'label'       => __( 'Button 1 color' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Select',
			'description' => __( 'Color of the button.' ,'Pixelentity Theme/Plugin'),
			'options' => array(
				__( 'Empty white' ,'Pixelentity Theme/Plugin') => 'outline light',
				__( 'White' ,'Pixelentity Theme/Plugin') => 'white',
				__( 'Empty dark' ,'Pixelentity Theme/Plugin') => 'outline',
				__( 'Dark' ,'Pixelentity Theme/Plugin') => '',
			),
			'default' => 'outline light',
		);

		$splash['content']['button_1_icon'] = array(
			'label'       => __( 'Button 1 icon' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Select',
			'description' => __( 'Icon displayed in the button.' ,'Pixelentity Theme/Plugin'),
			'options' => pe_theme_font_awesome_icons(),
			'default' => '',
		);

		$splash['content']['button_2_text'] = array(
			'label'       => __( 'Button 2 text' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Text of the button.' ,'Pixelentity Theme/Plugin'),
			'default'     => '',
		);

		$splash['content']['button_2_url'] = array(
			'label'       => __( 'Button 2 url' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Link for the button.' ,'Pixelentity Theme/Plugin'),
			'default'     => '#',
		);

		$splash['content']['button_2_color'] = array(
			'label'       => __( 'Button 2 color' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Select',
			'description' => __( 'Color of the button.' ,'Pixelentity Theme/Plugin'),
			'options' => array(
				__( 'Empty white' ,'Pixelentity Theme/Plugin') => 'outline light',
				__( 'White' ,'Pixelentity Theme/Plugin') => 'white',
				__( 'Empty dark' ,'Pixelentity Theme/Plugin') => 'outline',
				__( 'Dark' ,'Pixelentity Theme/Plugin') => '',
			),
			'default' => 'outline light',
		);

		$splash['content']['button_2_icon'] = array(
			'label'       => __( 'Button 2 icon' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Select',
			'description' => __( 'Icon displayed in the button.' ,'Pixelentity Theme/Plugin'),
			'options' => pe_theme_font_awesome_icons(),
			'default' => '',
		);

		$splash['content']['headlines'] = array(
			'label'        => __('Headlines','Pixelentity Theme/Plugin'),
			'type'         => 'Items',
			'description'  => __('Add one or headlines displayed on top of the splash image.','Pixelentity Theme/Plugin'),
			'button_label' => __('Add Headline','Pixelentity Theme/Plugin'),
			'sortable'     => true,
			'auto'         => __('Headline','Pixelentity Theme/Plugin'),
			'unique'       => false,
			'editable'     => false,
			'legend'       => false,
			'fields'       => array(
				array(
					'label'   => __('Title','Pixelentity Theme/Plugin'),
					'name'    => 'title',
					'type'    => 'text',
					'width'   => 250,
					'default' => __('Title','Pixelentity Theme/Plugin'),
				),
				array(
					'label'   => __('Description','Pixelentity Theme/Plugin'),
					'name'    => 'description',
					'type'    => 'text',
					'width'   => 250,
					'default' => __('Description','Pixelentity Theme/Plugin'),
				),
				array(
					'label'   => __('Button text','Pixelentity Theme/Plugin'),
					'name'    => 'button_text',
					'type'    => 'text',
					'width'   => 150,
					'default' => __('Button text','Pixelentity Theme/Plugin'),
				),
				array(
					'label'   => __('Button url','Pixelentity Theme/Plugin'),
					'name'    => 'button_url',
					'type'    => 'text',
					'width'   => 150,
					'default' => __('Button url','Pixelentity Theme/Plugin'),
				),
				array(
					'label'   => __('Button color','Pixelentity Theme/Plugin'),
					'name'    => 'button_color',
					'type'    => 'select',
					'width'   => 100,
					'options' => array(
						__( 'Empty white' ,'Pixelentity Theme/Plugin') => 'outline light',
						__( 'White' ,'Pixelentity Theme/Plugin') => 'white',
						__( 'Empty dark' ,'Pixelentity Theme/Plugin') => 'outline',
						__( 'Dark' ,'Pixelentity Theme/Plugin') => '',
					),
					'default' => 'outline light',
				),
				array(
					'label'   => __('Button icon','Pixelentity Theme/Plugin'),
					'name'    => 'button_icon',
					'type'    => 'select',
					'width'   => 100,
					'options' => pe_theme_font_awesome_icons(),
					'default' => '',
				),
			),
			'default' => '',
		);

		return $splash;
	}


	public function pe_theme_metabox_config_video() {
		unset( PeGlobal::$config["metaboxes-video"]['video']['content']['fullscreen'] );
		unset( PeGlobal::$config["metaboxes-video"]['video']['content']['width'] );
	}

	public function pe_theme_metabox_config_post() {
		parent::pe_theme_metabox_config_post();

		unset( PeGlobal::$config["metaboxes-post"]['gallery']['content']['type'] );

	}

	public function pe_theme_metabox_config_page() {
		parent::pe_theme_metabox_config_page();

		$builder = isset(PeGlobal::$config["metaboxes-page"]["builder"]) ? PeGlobal::$config["metaboxes-page"]["builder"] : false;
		$builder = $builder ? array("builder"=> $builder) : array();

		if (PE_THEME_MODE && $builder) {
			// top level builder element can only member of the "section" group
			$builder["builder"]["content"]["builder"]["allowed"] = "section";
		}

		/*

		$sidebar = array(
			'type'     => '',
			'title'    => __( 'Sidebar' ,'Pixelentity Theme/Plugin'),
			'priority' => 'core',
			'where'    => array(
				'post' => 'default',
			),
			'content' => array(
				'sidebar' => array(
					'label'       => __( 'Show sidebar' ,'Pixelentity Theme/Plugin'),
					'type'        => 'RadioUI',
					'description' => __( 'Choose whether sidebar should be displayed or not.' ,'Pixelentity Theme/Plugin'),
					'options'     => array(
						__( 'Yes' ,'Pixelentity Theme/Plugin') => 'yes',
						__( 'No' ,'Pixelentity Theme/Plugin')  => 'no',
					),
					'default' => 'no',
				),
			),
			'context' => 'side',
		);

		*/
	
		$menu = array(
			'type'     => '',
			'title'    => __( 'Header' ,'Pixelentity Theme/Plugin'),
			'priority' => 'core',
			'where'    => array(
				'post' => 'all',
			),
			'content' => array(
				'transparent' => array(
					'label'       => __( 'Transparent' ,'Pixelentity Theme/Plugin'),
					'type'        => 'RadioUI',
					'description' => __( 'Choose whether header should be transparent on this page or not.' ,'Pixelentity Theme/Plugin'),
					'options'     => array(
						__( 'Yes' ,'Pixelentity Theme/Plugin') => 'yes',
						__( 'No' ,'Pixelentity Theme/Plugin')  => 'no',
					),
					'default' => 'no',
				),
			),
			'context' => 'side',
		);

		$contact = array(
			'type'     => '',
			'title'    => __( 'Contact Form' ,'Pixelentity Theme/Plugin'),
			'priority' => 'core',
			'where'    => array(
				'post' => 'all',
			),
			'content' => array(
				'show' => array(
					'label'       => __( 'Display' ,'Pixelentity Theme/Plugin'),
					'type'        => 'RadioUI',
					'description' => __( 'Choose whether contact form should be displayed at the bottom of this page.' ,'Pixelentity Theme/Plugin'),
					'options'     => array(
						__( 'Yes' ,'Pixelentity Theme/Plugin') => 'yes',
						__( 'No' ,'Pixelentity Theme/Plugin')  => 'no',
					),
					'default' => 'no',
				),
			),
			'context' => 'side',
		);

		PeGlobal::$config["metaboxes-page"] = array_merge(
			$builder,
			array(
				'splash'  => $this->splash(),
				//'sidebar' => $sidebar,
				'menu'    => $menu,
				'contact' => $contact,
			)
		);


	}

	public function pe_theme_metabox_config_project() {
		parent::pe_theme_metabox_config_project();

		$galleryMbox = array(
			"title"    => __("Slider",'Pixelentity Theme/Plugin'),
			"type"     => "GalleryPost",
			"priority" => "core",
			"where"    => array(
				"post" => "gallery"
			),
			"content" => array(
				"id" => PeGlobal::$const->gallery->id,
			),
		);

		PeGlobal::$config["metaboxes-project"] =  array(
			"gallery" => $galleryMbox,
			"video"   => PeGlobal::$const->video->metaboxPost,
		);

	}

	public function pe_theme_momentum_testimonial_supports() {

		//add_post_type_support( 'service', 'thumbnail' );
		//add_post_type_support( 'testimonial', 'thumbnail' );

	}

	public function pe_theme_momentum_metabox_config_project() {

		unset( PeGlobal::$config["metaboxes-project"]['portfolio'] );
		unset( PeGlobal::$config["metaboxes-project"]['info'] );

	}

	public function pe_theme_metabox_config_staff_action() {

		

	}

	public function pe_theme_metabox_config_service_action() {

		

	}

	public function pe_theme_gallery_image_fields_filter( $fields ) {

		unset( $fields['video'] );

		$link = $fields['link'];
		$save = $fields['save'];
		$ititle = $fields['ititle'];
		$caption = $fields['caption'];

		unset( $fields['link'] );
		unset( $fields['save'] );
		unset( $fields['ititle'] );
		unset( $fields['caption'] );

		$fields['ititle'] = array(
			'label'       => __( 'Title' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Text used as a splash title.' ,'Pixelentity Theme/Plugin'),
			'default'     => '',
			'section'     => 'main',
		);

		$fields['caption'] = array(
			'label'       => __( 'Description' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Text used as a splash subtitle.' ,'Pixelentity Theme/Plugin'),
			'default'     => '',
			'section'     => 'main',
		);

		$fields['button_1_text'] = array(
			'label'       => __( 'Button 1 text' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Text of the button.' ,'Pixelentity Theme/Plugin'),
			'default'     => '',
			'section'     => 'main',
		);

		$fields['button_1_url'] = array(
			'label'       => __( 'Button 1 url' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Link for the button.' ,'Pixelentity Theme/Plugin'),
			'default'     => '#',
			'section'     => 'main',
		);

		$fields['button_1_color'] = array(
			'label'       => __( 'Button 1 color' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Select',
			'description' => __( 'Color of the button.' ,'Pixelentity Theme/Plugin'),
			'options' => array(
				__( 'Empty white' ,'Pixelentity Theme/Plugin') => 'outline light',
				__( 'White' ,'Pixelentity Theme/Plugin') => 'white',
				__( 'Empty dark' ,'Pixelentity Theme/Plugin') => 'outline',
				__( 'Dark' ,'Pixelentity Theme/Plugin') => '',
			),
			'default' => 'outline light',
			'section' => 'main',
		);

		$fields['button_1_icon'] = array(
			'label'       => __( 'Button 1 icon' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Select',
			'description' => __( 'Icon displayed in the button.' ,'Pixelentity Theme/Plugin'),
			'options' => pe_theme_font_awesome_icons(),
			'default' => '',
			'section' => 'main',
		);

		$fields['button_2_text'] = array(
			'label'       => __( 'Button 2 text' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Text of the button.' ,'Pixelentity Theme/Plugin'),
			'default'     => '',
			'section'     => 'main',
		);

		$fields['button_2_url'] = array(
			'label'       => __( 'Button 2 url' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Text',
			'description' => __( 'Link for the button.' ,'Pixelentity Theme/Plugin'),
			'default'     => '#',
			'section'     => 'main',
		);

		$fields['button_2_color'] = array(
			'label'       => __( 'Button 2 color' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Select',
			'description' => __( 'Color of the button.' ,'Pixelentity Theme/Plugin'),
			'options' => array(
				__( 'Empty white' ,'Pixelentity Theme/Plugin') => 'outline light',
				__( 'White' ,'Pixelentity Theme/Plugin') => 'white',
				__( 'Empty dark' ,'Pixelentity Theme/Plugin') => 'outline',
				__( 'Dark' ,'Pixelentity Theme/Plugin') => '',
			),
			'default' => 'outline light',
			'section' => 'main',
		);

		$fields['button_2_icon'] = array(
			'label'       => __( 'Button 2 icon' ,'Pixelentity Theme/Plugin'),
			'type'        => 'Select',
			'description' => __( 'Icon displayed in the button.' ,'Pixelentity Theme/Plugin'),
			'options' => pe_theme_font_awesome_icons(),
			'default' => '',
			'section' => 'main',
		);

		$fields['save'] = $save;

		return $fields;

	}

	protected function init_asset() {
		return new PeThemeMomentumAsset($this);
	}

	protected function init_template() {
		return new PeThemeMomentumTemplate($this);
	}

}

function pe_theme_font_awesome_icons() {

	$font_awesome_icons = array(
		"none" => '',
		"adjust" => "fa fa-adjust",
		"adn" => "fa fa-adn",
		"align-center" => "fa fa-align-center",
		"align-justify" => "fa fa-align-justify",
		"align-left" => "fa fa-align-left",
		"align-right" => "fa fa-align-right",
		"ambulance" => "fa fa-ambulance",
		"anchor" => "fa fa-anchor",
		"android" => "fa fa-android",
		"angle-double-down" => "fa fa-angle-double-down",
		"angle-double-left" => "fa fa-angle-double-left",
		"angle-double-right" => "fa fa-angle-double-right",
		"angle-double-up" => "fa fa-angle-double-up",
		"angle-down" => "fa fa-angle-down",
		"angle-left" => "fa fa-angle-left",
		"angle-right" => "fa fa-angle-right",
		"angle-up" => "fa fa-angle-up",
		"apple" => "fa fa-apple",
		"archive" => "fa fa-archive",
		"arrow-circle-down" => "fa fa-arrow-circle-down",
		"arrow-circle-left" => "fa fa-arrow-circle-left",
		"arrow-circle-o-down" => "fa fa-arrow-circle-o-down",
		"arrow-circle-o-left" => "fa fa-arrow-circle-o-left",
		"arrow-circle-o-left" => "fa fa-arrow-circle-o-left",
		"arrow-circle-o-right" => "fa fa-arrow-circle-o-right",
		"arrow-circle-o-right" => "fa fa-arrow-circle-o-right",
		"arrow-circle-o-up" => "fa fa-arrow-circle-o-up",
		"arrow-circle-right" => "fa fa-arrow-circle-right",
		"arrow-circle-up" => "fa fa-arrow-circle-up",
		"arrow-down" => "fa fa-arrow-down",
		"arrow-left" => "fa fa-arrow-left",
		"arrow-right" => "fa fa-arrow-right",
		"arrow-up" => "fa fa-arrow-up",
		"arrows" => "fa fa-arrows",
		"arrows" => "fa fa-arrows",
		"arrows-alt" => "fa fa-arrows-alt",
		"arrows-alt" => "fa fa-arrows-alt",
		"arrows-h" => "fa fa-arrows-h",
		"arrows-h" => "fa fa-arrows-h",
		"arrows-v" => "fa fa-arrows-v",
		"arrows-v" => "fa fa-arrows-v",
		"asterisk" => "fa fa-asterisk",
		"backward" => "fa fa-backward",
		"ban" => "fa fa-ban",
		"bar-chart-o" => "fa fa-bar-chart-o",
		"barcode" => "fa fa-barcode",
		"bars" => "fa fa-bars",
		"beer" => "fa fa-beer",
		"bell" => "fa fa-bell",
		"bell-o" => "fa fa-bell-o",
		"bitbucket" => "fa fa-bitbucket",
		"bitbucket-square" => "fa fa-bitbucket-square",
		"bitcoin" => "fa fa-bitcoin",
		"bitcoin" => "fa fa-bitcoin",
		"bold" => "fa fa-bold",
		"bolt" => "fa fa-bolt",
		"book" => "fa fa-book",
		"bookmark" => "fa fa-bookmark",
		"bookmark-o" => "fa fa-bookmark-o",
		"briefcase" => "fa fa-briefcase",
		"btc" => "fa fa-btc",
		"btc" => "fa fa-btc",
		"bug" => "fa fa-bug",
		"building-o" => "fa fa-building-o",
		"bullhorn" => "fa fa-bullhorn",
		"bullseye" => "fa fa-bullseye",
		"calendar" => "fa fa-calendar",
		"calendar-o" => "fa fa-calendar-o",
		"camera" => "fa fa-camera",
		"camera-retro" => "fa fa-camera-retro",
		"caret-down" => "fa fa-caret-down",
		"caret-left" => "fa fa-caret-left",
		"caret-right" => "fa fa-caret-right",
		"caret-square-o-down" => "fa fa-caret-square-o-down",
		"caret-square-o-down" => "fa fa-caret-square-o-down",
		"caret-square-o-left" => "fa fa-caret-square-o-left",
		"caret-square-o-left" => "fa fa-caret-square-o-left",
		"caret-square-o-left" => "fa fa-caret-square-o-left",
		"caret-square-o-right" => "fa fa-caret-square-o-right",
		"caret-square-o-right" => "fa fa-caret-square-o-right",
		"caret-square-o-up" => "fa fa-caret-square-o-up",
		"caret-square-o-up" => "fa fa-caret-square-o-up",
		"caret-up" => "fa fa-caret-up",
		"certificate" => "fa fa-certificate",
		"chain" => "fa fa-chain",
		"chain-broken" => "fa fa-chain-broken",
		"check" => "fa fa-check",
		"check-circle" => "fa fa-check-circle",
		"check-circle-o" => "fa fa-check-circle-o",
		"check-square" => "fa fa-check-square",
		"check-square" => "fa fa-check-square",
		"check-square-o" => "fa fa-check-square-o",
		"check-square-o" => "fa fa-check-square-o",
		"chevron-circle-down" => "fa fa-chevron-circle-down",
		"chevron-circle-left" => "fa fa-chevron-circle-left",
		"chevron-circle-right" => "fa fa-chevron-circle-right",
		"chevron-circle-up" => "fa fa-chevron-circle-up",
		"chevron-down" => "fa fa-chevron-down",
		"chevron-left" => "fa fa-chevron-left",
		"chevron-right" => "fa fa-chevron-right",
		"chevron-up" => "fa fa-chevron-up",
		"circle" => "fa fa-circle",
		"circle" => "fa fa-circle",
		"circle-o" => "fa fa-circle-o",
		"circle-o" => "fa fa-circle-o",
		"clipboard" => "fa fa-clipboard",
		"clock-o" => "fa fa-clock-o",
		"cloud" => "fa fa-cloud",
		"cloud-download" => "fa fa-cloud-download",
		"cloud-upload" => "fa fa-cloud-upload",
		"cny" => "fa fa-cny",
		"code" => "fa fa-code",
		"code-fork" => "fa fa-code-fork",
		"coffee" => "fa fa-coffee",
		"cog" => "fa fa-cog",
		"cogs" => "fa fa-cogs",
		"columns" => "fa fa-columns",
		"comment" => "fa fa-comment",
		"comment-o" => "fa fa-comment-o",
		"comments" => "fa fa-comments",
		"comments-o" => "fa fa-comments-o",
		"compass" => "fa fa-compass",
		"compress" => "fa fa-compress",
		"copy" => "fa fa-copy",
		"credit-card" => "fa fa-credit-card",
		"crop" => "fa fa-crop",
		"crosshairs" => "fa fa-crosshairs",
		"css3" => "fa fa-css3",
		"cut" => "fa fa-cut",
		"cutlery" => "fa fa-cutlery",
		"dashboard" => "fa fa-dashboard",
		"dedent" => "fa fa-dedent",
		"desktop" => "fa fa-desktop",
		"dollar" => "fa fa-dollar",
		"dot-circle-o" => "fa fa-dot-circle-o",
		"dot-circle-o" => "fa fa-dot-circle-o",
		"dot-circle-o" => "fa fa-dot-circle-o",
		"download" => "fa fa-download",
		"dribbble" => "fa fa-dribbble",
		"dropbox" => "fa fa-dropbox",
		"edit" => "fa fa-edit",
		"eject" => "fa fa-eject",
		"ellipsis-h" => "fa fa-ellipsis-h",
		"ellipsis-v" => "fa fa-ellipsis-v",
		"envelope" => "fa fa-envelope",
		"envelope-o" => "fa fa-envelope-o",
		"eraser" => "fa fa-eraser",
		"eraser" => "fa fa-eraser",
		"eur" => "fa fa-eur",
		"euro" => "fa fa-euro",
		"exchange" => "fa fa-exchange",
		"exclamation" => "fa fa-exclamation",
		"exclamation-circle" => "fa fa-exclamation-circle",
		"exclamation-triangle" => "fa fa-exclamation-triangle",
		"expand" => "fa fa-expand",
		"external-link" => "fa fa-external-link",
		"external-link-square" => "fa fa-external-link-square",
		"eye" => "fa fa-eye",
		"eye-slash" => "fa fa-eye-slash",
		"facebook" => "fa fa-facebook",
		"facebook-square" => "fa fa-facebook-square",
		"fast-backward" => "fa fa-fast-backward",
		"fast-forward" => "fa fa-fast-forward",
		"female" => "fa fa-female",
		"fighter-jet" => "fa fa-fighter-jet",
		"file" => "fa fa-file",
		"file-o" => "fa fa-file-o",
		"file-text" => "fa fa-file-text",
		"file-text-o" => "fa fa-file-text-o",
		"files-o" => "fa fa-files-o",
		"film" => "fa fa-film",
		"filter" => "fa fa-filter",
		"fire" => "fa fa-fire",
		"fire-extinguisher" => "fa fa-fire-extinguisher",
		"flag" => "fa fa-flag",
		"flag-checkered" => "fa fa-flag-checkered",
		"flag-o" => "fa fa-flag-o",
		"flash" => "fa fa-flash",
		"flask" => "fa fa-flask",
		"flickr" => "fa fa-flickr",
		"floppy-o" => "fa fa-floppy-o",
		"folder" => "fa fa-folder",
		"folder-o" => "fa fa-folder-o",
		"folder-open" => "fa fa-folder-open",
		"folder-open-o" => "fa fa-folder-open-o",
		"font" => "fa fa-font",
		"forward" => "fa fa-forward",
		"foursquare" => "fa fa-foursquare",
		"frown-o" => "fa fa-frown-o",
		"gamepad" => "fa fa-gamepad",
		"gavel" => "fa fa-gavel",
		"gbp" => "fa fa-gbp",
		"gear" => "fa fa-gear",
		"gears" => "fa fa-gears",
		"gift" => "fa fa-gift",
		"github" => "fa fa-github",
		"github-alt" => "fa fa-github-alt",
		"github-square" => "fa fa-github-square",
		"gittip" => "fa fa-gittip",
		"glass" => "fa fa-glass",
		"globe" => "fa fa-globe",
		"google-plus" => "fa fa-google-plus",
		"google-plus-square" => "fa fa-google-plus-square",
		"group" => "fa fa-group",
		"h-square" => "fa fa-h-square",
		"hand-o-down" => "fa fa-hand-o-down",
		"hand-o-left" => "fa fa-hand-o-left",
		"hand-o-right" => "fa fa-hand-o-right",
		"hand-o-up" => "fa fa-hand-o-up",
		"hdd-o" => "fa fa-hdd-o",
		"headphones" => "fa fa-headphones",
		"heart" => "fa fa-heart",
		"heart-o" => "fa fa-heart-o",
		"home" => "fa fa-home",
		"hospital-o" => "fa fa-hospital-o",
		"html5" => "fa fa-html5",
		"inbox" => "fa fa-inbox",
		"indent" => "fa fa-indent",
		"info" => "fa fa-info",
		"info-circle" => "fa fa-info-circle",
		"inr" => "fa fa-inr",
		"instagram" => "fa fa-instagram",
		"italic" => "fa fa-italic",
		"jpy" => "fa fa-jpy",
		"key" => "fa fa-key",
		"keyboard-o" => "fa fa-keyboard-o",
		"krw" => "fa fa-krw",
		"laptop" => "fa fa-laptop",
		"leaf" => "fa fa-leaf",
		"legal" => "fa fa-legal",
		"lemon-o" => "fa fa-lemon-o",
		"level-down" => "fa fa-level-down",
		"level-up" => "fa fa-level-up",
		"lightbulb-o" => "fa fa-lightbulb-o",
		"link" => "fa fa-link",
		"linkedin" => "fa fa-linkedin",
		"linkedin-square" => "fa fa-linkedin-square",
		"linux" => "fa fa-linux",
		"list" => "fa fa-list",
		"list-alt" => "fa fa-list-alt",
		"list-ol" => "fa fa-list-ol",
		"list-ul" => "fa fa-list-ul",
		"location-arrow" => "fa fa-location-arrow",
		"lock" => "fa fa-lock",
		"long-arrow-down" => "fa fa-long-arrow-down",
		"long-arrow-left" => "fa fa-long-arrow-left",
		"long-arrow-right" => "fa fa-long-arrow-right",
		"long-arrow-up" => "fa fa-long-arrow-up",
		"magic" => "fa fa-magic",
		"magnet" => "fa fa-magnet",
		"mail-forward" => "fa fa-mail-forward",
		"mail-reply" => "fa fa-mail-reply",
		"mail-reply-all" => "fa fa-mail-reply-all",
		"male" => "fa fa-male",
		"map-marker" => "fa fa-map-marker",
		"maxcdn" => "fa fa-maxcdn",
		"medkit" => "fa fa-medkit",
		"meh-o" => "fa fa-meh-o",
		"microphone" => "fa fa-microphone",
		"microphone-slash" => "fa fa-microphone-slash",
		"minus" => "fa fa-minus",
		"minus-circle" => "fa fa-minus-circle",
		"minus-square" => "fa fa-minus-square",
		"minus-square" => "fa fa-minus-square",
		"minus-square-o" => "fa fa-minus-square-o",
		"minus-square-o" => "fa fa-minus-square-o",
		"mobile" => "fa fa-mobile",
		"mobile-phone" => "fa fa-mobile-phone",
		"money" => "fa fa-money",
		"money" => "fa fa-money",
		"moon-o" => "fa fa-moon-o",
		"music" => "fa fa-music",
		"outdent" => "fa fa-outdent",
		"pagelines" => "fa fa-pagelines",
		"pagelines" => "fa fa-pagelines",
		"paperclip" => "fa fa-paperclip",
		"paste" => "fa fa-paste",
		"pause" => "fa fa-pause",
		"pencil" => "fa fa-pencil",
		"pencil-square" => "fa fa-pencil-square",
		"pencil-square-o" => "fa fa-pencil-square-o",
		"phone" => "fa fa-phone",
		"phone-square" => "fa fa-phone-square",
		"picture-o" => "fa fa-picture-o",
		"pinterest" => "fa fa-pinterest",
		"pinterest-square" => "fa fa-pinterest-square",
		"plane" => "fa fa-plane",
		"play" => "fa fa-play",
		"play-circle" => "fa fa-play-circle",
		"play-circle-o" => "fa fa-play-circle-o",
		"plus" => "fa fa-plus",
		"plus-circle" => "fa fa-plus-circle",
		"plus-square" => "fa fa-plus-square",
		"plus-square" => "fa fa-plus-square",
		"plus-square" => "fa fa-plus-square",
		"plus-square-o" => "fa fa-plus-square-o",
		"plus-square-o" => "fa fa-plus-square-o",
		"plus-square-o" => "fa fa-plus-square-o",
		"power-off" => "fa fa-power-off",
		"print" => "fa fa-print",
		"puzzle-piece" => "fa fa-puzzle-piece",
		"qrcode" => "fa fa-qrcode",
		"question" => "fa fa-question",
		"question-circle" => "fa fa-question-circle",
		"quote-left" => "fa fa-quote-left",
		"quote-right" => "fa fa-quote-right",
		"random" => "fa fa-random",
		"refresh" => "fa fa-refresh",
		"renren" => "fa fa-renren",
		"repeat" => "fa fa-repeat",
		"reply" => "fa fa-reply",
		"reply-all" => "fa fa-reply-all",
		"retweet" => "fa fa-retweet",
		"rmb" => "fa fa-rmb",
		"road" => "fa fa-road",
		"rocket" => "fa fa-rocket",
		"rotate-left" => "fa fa-rotate-left",
		"rotate-right" => "fa fa-rotate-right",
		"rouble" => "fa fa-rouble",
		"rouble" => "fa fa-rouble",
		"rss" => "fa fa-rss",
		"rss-square" => "fa fa-rss-square",
		"rub" => "fa fa-rub",
		"rub" => "fa fa-rub",
		"ruble" => "fa fa-ruble",
		"ruble" => "fa fa-ruble",
		"rupee" => "fa fa-rupee",
		"save" => "fa fa-save",
		"scissors" => "fa fa-scissors",
		"search" => "fa fa-search",
		"search-minus" => "fa fa-search-minus",
		"search-plus" => "fa fa-search-plus",
		"share" => "fa fa-share",
		"share-square" => "fa fa-share-square",
		"share-square-o" => "fa fa-share-square-o",
		"shield" => "fa fa-shield",
		"shopping-cart" => "fa fa-shopping-cart",
		"sign-in" => "fa fa-sign-in",
		"sign-out" => "fa fa-sign-out",
		"signal" => "fa fa-signal",
		"sitemap" => "fa fa-sitemap",
		"skype" => "fa fa-skype",
		"smile-o" => "fa fa-smile-o",
		"sort" => "fa fa-sort",
		"sort-alpha-asc" => "fa fa-sort-alpha-asc",
		"sort-alpha-desc" => "fa fa-sort-alpha-desc",
		"sort-amount-asc" => "fa fa-sort-amount-asc",
		"sort-amount-desc" => "fa fa-sort-amount-desc",
		"sort-asc" => "fa fa-sort-asc",
		"sort-desc" => "fa fa-sort-desc",
		"sort-down" => "fa fa-sort-down",
		"sort-numeric-asc" => "fa fa-sort-numeric-asc",
		"sort-numeric-desc" => "fa fa-sort-numeric-desc",
		"sort-up" => "fa fa-sort-up",
		"spinner" => "fa fa-spinner",
		"square" => "fa fa-square",
		"square" => "fa fa-square",
		"square-o" => "fa fa-square-o",
		"square-o" => "fa fa-square-o",
		"stack-exchange" => "fa fa-stack-exchange",
		"stack-exchange" => "fa fa-stack-exchange",
		"stack-overflow" => "fa fa-stack-overflow",
		"star" => "fa fa-star",
		"star-half" => "fa fa-star-half",
		"star-half-empty" => "fa fa-star-half-empty",
		"star-half-full" => "fa fa-star-half-full",
		"star-half-o" => "fa fa-star-half-o",
		"star-o" => "fa fa-star-o",
		"step-backward" => "fa fa-step-backward",
		"step-forward" => "fa fa-step-forward",
		"stethoscope" => "fa fa-stethoscope",
		"stop" => "fa fa-stop",
		"strikethrough" => "fa fa-strikethrough",
		"subscript" => "fa fa-subscript",
		"suitcase" => "fa fa-suitcase",
		"sun-o" => "fa fa-sun-o",
		"superscript" => "fa fa-superscript",
		"table" => "fa fa-table",
		"tablet" => "fa fa-tablet",
		"tachometer" => "fa fa-tachometer",
		"tag" => "fa fa-tag",
		"tags" => "fa fa-tags",
		"tasks" => "fa fa-tasks",
		"terminal" => "fa fa-terminal",
		"text-height" => "fa fa-text-height",
		"text-width" => "fa fa-text-width",
		"th" => "fa fa-th",
		"th-large" => "fa fa-th-large",
		"th-list" => "fa fa-th-list",
		"thumb-tack" => "fa fa-thumb-tack",
		"thumbs-down" => "fa fa-thumbs-down",
		"thumbs-o-down" => "fa fa-thumbs-o-down",
		"thumbs-o-up" => "fa fa-thumbs-o-up",
		"thumbs-up" => "fa fa-thumbs-up",
		"ticket" => "fa fa-ticket",
		"times" => "fa fa-times",
		"times-circle" => "fa fa-times-circle",
		"times-circle-o" => "fa fa-times-circle-o",
		"tint" => "fa fa-tint",
		"toggle-down" => "fa fa-toggle-down",
		"toggle-down" => "fa fa-toggle-down",
		"toggle-left" => "fa fa-toggle-left",
		"toggle-left" => "fa fa-toggle-left",
		"toggle-left" => "fa fa-toggle-left",
		"toggle-right" => "fa fa-toggle-right",
		"toggle-right" => "fa fa-toggle-right",
		"toggle-up" => "fa fa-toggle-up",
		"toggle-up" => "fa fa-toggle-up",
		"trash-o" => "fa fa-trash-o",
		"trello" => "fa fa-trello",
		"trophy" => "fa fa-trophy",
		"truck" => "fa fa-truck",
		"try" => "fa fa-try",
		"try" => "fa fa-try",
		"tumblr" => "fa fa-tumblr",
		"tumblr-square" => "fa fa-tumblr-square",
		"turkish-lira" => "fa fa-turkish-lira",
		"turkish-lira" => "fa fa-turkish-lira",
		"twitter" => "fa fa-twitter",
		"twitter-square" => "fa fa-twitter-square",
		"umbrella" => "fa fa-umbrella",
		"underline" => "fa fa-underline",
		"undo" => "fa fa-undo",
		"unlink" => "fa fa-unlink",
		"unlock" => "fa fa-unlock",
		"unlock-alt" => "fa fa-unlock-alt",
		"unsorted" => "fa fa-unsorted",
		"upload" => "fa fa-upload",
		"usd" => "fa fa-usd",
		"user" => "fa fa-user",
		"user-md" => "fa fa-user-md",
		"users" => "fa fa-users",
		"video-camera" => "fa fa-video-camera",
		"vimeo-square" => "fa fa-vimeo-square",
		"vimeo-square" => "fa fa-vimeo-square",
		"vk" => "fa fa-vk",
		"volume-down" => "fa fa-volume-down",
		"volume-off" => "fa fa-volume-off",
		"volume-up" => "fa fa-volume-up",
		"warning" => "fa fa-warning",
		"weibo" => "fa fa-weibo",
		"wheelchair" => "fa fa-wheelchair",
		"wheelchair" => "fa fa-wheelchair",
		"wheelchair" => "fa fa-wheelchair",
		"windows" => "fa fa-windows",
		"won" => "fa fa-won",
		"wrench" => "fa fa-wrench",
		"xing" => "fa fa-xing",
		"xing-square" => "fa fa-xing-square",
		"yen" => "fa fa-yen",
		"youtube" => "fa fa-youtube",
		"youtube-play" => "fa fa-youtube-play",
		"youtube-play" => "fa fa-youtube-play",
		"youtube-square" => "fa fa-youtube-square",
	);

	return $font_awesome_icons;

}