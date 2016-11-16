<?php

class PeThemeViewLayoutModuleMomentumNews extends PeThemeViewLayoutModule {

	public function messages() {
		return
			array(
				"title" => "",
				"type" => __("News",'Pixelentity Theme/Plugin')
			);
	}

	public function fields() {

		$fields = peTheme()->data->customPostTypeMbox('post');
		$fields = $fields["content"];

		$fields = array_merge(
			array(
				"title" => array(
					"label"       => __("Title",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Section title.",'Pixelentity Theme/Plugin'),
					"default"     => '',
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
				"content" => array(
					"label"       => "Content",
					"type"        => "Editor",
					"noscript"    => true,
					"description" => __("Content",'Pixelentity Theme/Plugin'),
					"default"     => ""
				),
				'display' => array(
					"label"       => __("Display mode",'Pixelentity Theme/Plugin'),
					"type"        => "RadioUI",
					"description" => __("In what mode should projects be displayed.",'Pixelentity Theme/Plugin'),
					"options"     => array(
						__( 'Carousel' ,'Pixelentity Theme/Plugin') => 'carousel',
						__( 'Grid' ,'Pixelentity Theme/Plugin')  => 'grid',
					),
					"default"     => 'carousel',
				),
				'lightbox' => array(
					"label"       => __("Lightbox",'Pixelentity Theme/Plugin'),
					"type"        => "RadioUI",
					"description" => __("Specify whether projects should be opened in lightbox or displayed as a single-project pages instead.",'Pixelentity Theme/Plugin'),
					"options"     => array(
						__( 'On' ,'Pixelentity Theme/Plugin')  => 'on',
						__( 'Off' ,'Pixelentity Theme/Plugin') => 'off',
					),
					"default"     => 'on',
				),
			),
			$fields
		);

		unset( $fields['pager'] );

		return $fields;

	}

	public function name() {
		return __("News",'Pixelentity Theme/Plugin');
	}

	public function type() {
		return __("Section",'Pixelentity Theme/Plugin');
	}

	public function templateName() {
		return "news";
	}

	public function group() {
		return "section";
	}

	public function setTemplateData() {

	}

	public function template() {
		$t =& peTheme();
		if ($loop = $t->data->customLoop($this->data)) {
			$t->template->data($this->data,$this->conf->bid);
			$t->get_template_part("viewmodule",$this->templateName());
			$t->content->resetLoop();
		}
	}

	public function tooltip() {
		return __("Add a News block.",'Pixelentity Theme/Plugin');
	}

}

?>