<?php

class PeThemeViewLayoutModuleMomentumIntroItem extends PeThemeViewLayoutModuleText {

	public function messages() {
		return
			array(
				  "title" => "",
				  "type" => __("Intro Item",'Pixelentity Theme/Plugin')
				  );
	}

	public function fields() {
		return
			array(
				"icon" => array(
					"label"       => __("Icon",'Pixelentity Theme/Plugin'),
					"type"        => "Icon",
					"description" => __("Item Icon.",'Pixelentity Theme/Plugin'),
					"default"     => "",
				),
				"title" => array(
					"label"       => __("Title",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Item title.",'Pixelentity Theme/Plugin'),
					"default"     => __("Our Work",'Pixelentity Theme/Plugin'),
				),
				"content" => array(
					"label"       => __("Description",'Pixelentity Theme/Plugin'),
					"type"        => "TextArea",
					"noscript"    => true,
					"description" => __("Item description",'Pixelentity Theme/Plugin'),
					"default"     => "",
				),
				"link" => array(
					"label"       => __("Link",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"noscript"    => true,
					"description" => __("Optional link",'Pixelentity Theme/Plugin'),
					"default"     => "",
				),
			);
		
	}

	public function name() {
		return __("Intro Item",'Pixelentity Theme/Plugin');
	}

	public function group() {
		return "introitem";
	}

	public function render() {
		// do nothing here since the rendering happens in the parent template
	}

	public function tooltip() {
		return __("Use this block to add a new intro item.",'Pixelentity Theme/Plugin');
	}

}

?>