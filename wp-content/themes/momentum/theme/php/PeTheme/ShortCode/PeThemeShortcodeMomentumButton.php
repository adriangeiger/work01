<?php

class PeThemeShortcodeMomentumButton extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "pbutton";
		$this->group = __("UI",'Pixelentity Theme/Plugin');
		$this->name = __("Button",'Pixelentity Theme/Plugin');
		$this->description = __("Add a button",'Pixelentity Theme/Plugin');
		$this->fields = array(
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

	public function output( $atts, $content = null, $code = '' ) {

		extract( $atts );

		$button_text = ( isset( $button_text ) ) ? $button_text : '';

		$button_url = ( isset( $button_url ) ) ? $button_url : '#';

		$target = isset( $button_target ) && 'yes' === $button_target ? '_blank' : '_self';

		$color = isset( $button_color ) ? $button_color : '';

		$icon = isset( $button_icon ) ? $button_icon : '';

		if ( empty( $icon ) ) :

		$html = <<< EOT
<a href="$button_url" class="btn $color" target="$target">$button_text</a>
EOT;

		else :

		$html = <<< EOT
<a href="$button_url" class="btn $color" target="$target"><i class="$icon"></i> $button_text</a>
EOT;

		endif;

        return trim( $html );

	}


}