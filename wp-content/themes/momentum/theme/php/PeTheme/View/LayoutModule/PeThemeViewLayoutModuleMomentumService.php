<?php

class PeThemeViewLayoutModuleMomentumService extends PeThemeViewLayoutModuleText {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Service",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		return
			array(
				"icon" => array(
					"label"       => __("Icon",'Pixelentity Theme/Plugin'),
					"type"        => "Icon",
					"description" => __("Service Icon.",'Pixelentity Theme/Plugin'),
					"default"     => "",
				),
				"title" => array(
					"label"       => __("Title",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Service title.",'Pixelentity Theme/Plugin'),
					"default"     => __("Branding",'Pixelentity Theme/Plugin'),
				),
				"subtitle" => array(
					"label"       => __("Subtitle",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Service subtitle.",'Pixelentity Theme/Plugin'),
					"default"     => __("Image is everything",'Pixelentity Theme/Plugin'),
				),
				"features" => array(
					"label"        => __("Features",'Pixelentity Theme/Plugin'),
					"type"         => "Items",
					"description"  => __("Add one or more feature describing this service.",'Pixelentity Theme/Plugin'),
					"button_label" => __("Add Feature",'Pixelentity Theme/Plugin'),
					"sortable"     => true,
					"auto"         => __("From logo to billboard",'Pixelentity Theme/Plugin'),
					"unique"       => false,
					"editable"     => false,
					"legend"       => false,
					"fields"       => array(
						array(
							"label"   => "Text",
							"name"    => "text",
							"type"    => "text",
							"width"   => 500, 
							"default" => __("From logo to billboard",'Pixelentity Theme/Plugin'),
						),
					),
				),
				"price" => array(
					"label"       => __("Price",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Optional text displayed above the link.",'Pixelentity Theme/Plugin'),
					"default"     => __("Starting at $799",'Pixelentity Theme/Plugin'),
				),
				"link_text" => array(
					"label"       => __("Link text",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Text of the link displayed at the bottom of the service.",'Pixelentity Theme/Plugin'),
					"default"     => __("Get in touch",'Pixelentity Theme/Plugin'),
				),
				"link_url" => array(
					"label"       => __("Link url",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Url for the link.",'Pixelentity Theme/Plugin'),
					"default"     => '#',
				),
				'link_target' => array(
					'label'       => __( 'Open in new window' ,'Pixelentity Theme/Plugin'),
					'type'        => 'Select',
					'description' => __( 'Should the url be opened in new window?' ,'Pixelentity Theme/Plugin'),
					'options'   => array(
						__( 'Yes' ,'Pixelentity Theme/Plugin') => 'yes',
						__( 'No' ,'Pixelentity Theme/Plugin')  => 'no',
					),
					'default'     => 'no',
				),
			);
		
	}

	public function name() {
		return __("Service",'Pixelentity Theme/Plugin');
	}

	public function group() {
		return "service";
	}

	public function render() {
		// do nothing here since the rendering happens in the parent template
	}

	public function tooltip() {
		return __("Use this block to add a new service.",'Pixelentity Theme/Plugin');
	}

}