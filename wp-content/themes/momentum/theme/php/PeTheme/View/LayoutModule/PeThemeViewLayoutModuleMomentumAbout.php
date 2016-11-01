<?php

class PeThemeViewLayoutModuleMomentumAbout extends PeThemeViewLayoutModuleContainer {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("About",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		return
			array(
				"title" => array(
					"label"       => __("Title",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Section title.",'Pixelentity Theme/Plugin'),
					"default"     => __("Our Team",'Pixelentity Theme/Plugin'),
				),
				"name" => array(
					"label"       => __("Link Name",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Used when linking to the section in a page (eg, from the menu).",'Pixelentity Theme/Plugin'),
					"default"     => "",
				),
				"bgcolor" => array(
					"label"       => __("Background color",'Pixelentity Theme/Plugin'),
					"type"        => "Color",
					"description" => __("Background color of the section.",'Pixelentity Theme/Plugin'),
					"default"     => "#fff",
				),
				"bgimage" => array(
					"label"       => __("Background image",'Pixelentity Theme/Plugin'),
					"type"        => "Upload",
					"description" => __("Background image of the section.",'Pixelentity Theme/Plugin'),
					"default"     => '',
				),
				"typography" => array(
					"label"       => __("Typography color",'Pixelentity Theme/Plugin'),
					"type"        => "RadioUI",
					"description" => __("Choose between light and dark type. You will want to adjust this based on your background and overlay.",'Pixelentity Theme/Plugin'),
					"options"     => array(
						__( 'Dark' ,'Pixelentity Theme/Plugin')   => 'dark',
						__( 'Light' ,'Pixelentity Theme/Plugin')  => 'light',
					),
					"default"     => 'dark',
				),
				"padding_top" => array(
					"label"       => __("Section top padding",'Pixelentity Theme/Plugin'),
					"type"        => "RadioUI",
					"description" => __("Specify what form of top padding should the section use.",'Pixelentity Theme/Plugin'),
					"options"     => array(
						__( 'Normal' ,'Pixelentity Theme/Plugin') => 'normal',
						__( 'Large' ,'Pixelentity Theme/Plugin')  => 'large',
						__( 'None' ,'Pixelentity Theme/Plugin')   => 'none',
					),
					"default"     => 'large',
				),
				"padding_bottom" => array(
					"label"       => __("Section bottom padding",'Pixelentity Theme/Plugin'),
					"type"        => "RadioUI",
					"description" => __("Specify what form of bottom padding should the section use.",'Pixelentity Theme/Plugin'),
					"options"     => array(
						__( 'Normal' ,'Pixelentity Theme/Plugin') => 'normal',
						__( 'Large' ,'Pixelentity Theme/Plugin')  => 'large',
						__( 'None' ,'Pixelentity Theme/Plugin')   => 'none',
					),
					"default"     => 'large',
				),
				"image" => array(
					"label"       => __("Image",'Pixelentity Theme/Plugin'),
					"type"        => "Upload",
					"description" => __("Section image.",'Pixelentity Theme/Plugin'),
					"default"     => "",
				),
				"subtitle" => array(
					"label"       => __("Subitle",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Subtitle displayed next to the content.",'Pixelentity Theme/Plugin'),
					"default"     => __("We're just like the rest, only different",'Pixelentity Theme/Plugin'),
				),
				"content" => array(
					"label"       => "Content",
					"type"        => "Editor",
					"noscript"    => true,
					"description" => __("Content",'Pixelentity Theme/Plugin'),
					"default"     => ""
				),
				"testimonials" => array(
					"label"        => __("Testimonials",'Pixelentity Theme/Plugin'),
					"type"         => "Items",
					"description"  => __("Add one or more testimonial.",'Pixelentity Theme/Plugin'),
					"button_label" => __("Add Testimonial",'Pixelentity Theme/Plugin'),
					"sortable"     => true,
					"auto"         => '',
					"unique"       => false,
					"editable"     => false,
					"legend"       => false,
					"fields"       => array(
						array(
							"name"    => "text",
							"type"    => "textarea",
							"default" => 'Testimonial text',
							"width"   => 500,
						),
						array(
							"name"    => "author",
							"type"    => "text",
							"width"   => 300,
							"default" => 'George Grant - <em>CEO</em>',
						),
					),
				),
			);
	}

	public function name() {
		return __("About",'Pixelentity Theme/Plugin');
	}

	public function type() {
		return __("Section",'Pixelentity Theme/Plugin');
	}

	public function create() {
		return "MomentumTeamMember";
	}

	public function force() {
		return "MomentumTeamMember";
	}
	
	public function allowed() {
		return "teammember";
	}

	public function group() {
		return "section";
	}

	public function setTemplateData() {
		// override setTemplateData so to also pass the item array to the template file
		// this way the markup for the child blocks can also be generated in the container/parent template
		// We're not interested in builder related settings so we rebuild the array
		// to only include the data we going to use.
		
		$items = array();
		if (!empty($this->conf->items)) {
			foreach($this->conf->items as $item) {
				$item = (object) shortcode_atts(
												array(
													  'image'   => '',
													  'name'    => '',
													  'role'    => '',
													  'links'   => array(),
													  ),
												$item["data"]
												);
				
				$items[] = $item;
			}
		}

		peTheme()->template->data($this->data,$items,$this->conf->bid);
	}

	public function template() {
		peTheme()->get_template_part("viewmodule",empty($this->data->layout) ? "about" : $this->data->layout);
	}

	public function tooltip() {
		return __("Use this block to add an About section.",'Pixelentity Theme/Plugin');
	}

}