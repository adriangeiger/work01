<?php

class PeThemeViewLayoutModuleMomentumProcessItem extends PeThemeViewLayoutModuleText {

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
					"default"     => __("1. Connect",'Pixelentity Theme/Plugin'),
				),
				"description" => array(
					"label"       => __("Description",'Pixelentity Theme/Plugin'),
					"type"        => "Text",
					"description" => __("Process item description.",'Pixelentity Theme/Plugin'),
					"default"     => '',
				),
			);
		
	}

	public function name() {
		return __("ProcessItem",'Pixelentity Theme/Plugin');
	}

	public function group() {
		return "processitem";
	}

	public function render() {
		// do nothing here since the rendering happens in the parent template
	}

	public function tooltip() {
		return __("Use this block to add a new process item.",'Pixelentity Theme/Plugin');
	}

}