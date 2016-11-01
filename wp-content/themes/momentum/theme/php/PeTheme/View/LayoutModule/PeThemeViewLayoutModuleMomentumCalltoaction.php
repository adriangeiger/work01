<?php

class PeThemeViewLayoutModuleMomentumCalltoaction extends PeThemeViewLayoutModule {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Call To Action",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		return
			array(
				"name" => array(
					"label"       => __("Link Name",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Used when linking to the section in a page (eg, from the menu).",'Pixelentity Theme/Plugin'),
					"default"     => "",
				),
				'text' => array(
					'label'       => __( 'Call To Action text' ,'Pixelentity Theme/Plugin'),
					'description' => __( 'Text displayed in Call To Action block.' ,'Pixelentity Theme/Plugin'),
					'type'        => 'TextArea',
					'default'     => '<h2><span class="serif">Do you like</span> our work <span class="serif">so far?</span><br>
				<span class="serif">Let\'s talk about</span> your project<span class="serif">!</span></h2>',
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
				'button_text' => array(
					'label'       => __( 'Button text' ,'Pixelentity Theme/Plugin'),
					'description' => __( 'Text for optional button. Leave empty to not use teh button.' ,'Pixelentity Theme/Plugin'),
					'type'        => 'Text',
					'default'     => '',
				),
				'button_url' => array(
					'label'       => __( 'Button url' ,'Pixelentity Theme/Plugin'),
					'description' => __( 'Url button will link to.' ,'Pixelentity Theme/Plugin'),
					'type'        => 'Text',
					'default'     => '',
				),
				'button_target' => array(
					'label'       => __( 'Open in new window' ,'Pixelentity Theme/Plugin'),
					'type'        => 'Select',
					'description' => __( 'Should the url be opened in new window?' ,'Pixelentity Theme/Plugin'),
					'options'   => array(
						__( 'Yes' ,'Pixelentity Theme/Plugin') => 'yes',
						__( 'No' ,'Pixelentity Theme/Plugin')  => 'no',
					),
					'default'     => 'no',
				),
				'button_color' => array(
					'label'       => __( 'Button color' ,'Pixelentity Theme/Plugin'),
					'type'        => 'Select',
					'description' => __( 'Color of the button.' ,'Pixelentity Theme/Plugin'),
					'options' => array(
						__( 'Empty white' ,'Pixelentity Theme/Plugin') => 'outline light',
						__( 'White' ,'Pixelentity Theme/Plugin') => 'light',
						__( 'Empty dark' ,'Pixelentity Theme/Plugin') => 'outline',
						__( 'Dark' ,'Pixelentity Theme/Plugin') => '',
					),
					'default' => 'outline light',
				),
				'button_icon' => array(
					'label'       => __( 'Button icon' ,'Pixelentity Theme/Plugin'),
					'type'        => 'Select',
					'description' => __( 'Icon displayed in the button.' ,'Pixelentity Theme/Plugin'),
					'options' => pe_theme_font_awesome_icons(),
					'default' => '',
				),
			);
	}

	public function name() {
		return __("Call To Action",'Pixelentity Theme/Plugin');
	}

	public function type() {
		return __("Section",'Pixelentity Theme/Plugin');
	}

	public function templateName() {
		return "calltoaction";
	}

	public function group() {
		return "section";
	}

	public function setTemplateData() {
		$t =& peTheme();
		peTheme()->template->data($this->data,$this->conf->bid);
	}

	public function template() {
		peTheme()->get_template_part("viewmodule",$this->templateName());
	}

	public function tooltip() {
		return __("Add a Call To Action section.",'Pixelentity Theme/Plugin');
	}

}

?>