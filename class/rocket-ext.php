<?php

namespace RocketElementorForm;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class Vicextender {
	public static $rocketextnamespace = '\\RocketElementorForm\\Vicextender\\';
	public function __construct() {
		// class function init
	}

	public static function rocket_form_ext_arr() {
		$rocket_addons_form_ext = array(
			'Rocket_Addons_Extension_Form_Visibility' => array(
				'name' => 'rocket_extension_form_visibility',
				'title' => esc_html__( 'Conditional logic view for Elementor Pro Form', 'rocket-addon' ),
				'description' => esc_html__( 'Display fields based on form field operator', 'rocket-addon' ),
			)
		);
		return $rocket_addons_form_ext;
	}
}
