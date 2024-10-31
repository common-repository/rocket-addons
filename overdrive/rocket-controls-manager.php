<?php

namespace RocketElementorForm;

use Elementor\Controls_Manager;
class ROCKET_Controls_Manager extends Controls_Manager
{
	public static $rocket_token_types = [Controls_Manager::TEXT => \true, Controls_Manager::TEXTAREA => \true, Controls_Manager::WYSIWYG => \true, Controls_Manager::NUMBER => \true, Controls_Manager::URL => \true, Controls_Manager::COLOR => \true, Controls_Manager::SLIDER => \true, Controls_Manager::MEDIA => \true, Controls_Manager::GALLERY => \true];
	private $active_form_extensions_with_add_to_form;

	public function initialize_active_form_extensions_with_add_to_form()
	{
		// compability to run with other plugins
		$this->active_form_extensions_with_add_to_form = [];

		$rocket_form_exts = array();
		$rocket_addons_extensions_array = \RocketElementorForm\Vicextender::rocket_form_ext_arr();
		foreach ( $rocket_addons_extensions_array as $extclass => $extclassname ) {
			$rocket_form_exts[$extclass] = $extclassname;
		}

		$rocket_the_extensions = $rocket_form_exts;
		$rocket_ract_ext = array();
		foreach ( $rocket_the_extensions as $extclass => $extclassname ) {
			$rocket_ract_ext[$extclass] = $extclassname;
		}

		$active_form_extensions_v = $rocket_ract_ext;

		if ( class_exists( 'DynamicContentForElementor\DCE_Controls_Manager' ) ) {
			$active_form_extensions = \DynamicContentForElementor\Extensions::get_active_form_extensions();
		}

		$active_form_extensions_dce = array();
		if ( class_exists( 'DynamicContentForElementor\DCE_Controls_Manager' ) ) {
			foreach ($active_form_extensions as $extension_class => $extension_info) {
				$a_form_ext_class = \DynamicContentForElementor\Extensions::$namespace . $extension_class;
				if (method_exists($a_form_ext_class, '_add_to_form')) {
					$active_form_extensions_dce[] = $a_form_ext_class;
				}
			}
		}

		$active_form_extensions_v1 = array();
		foreach ($active_form_extensions_v as $extension_class2 => $extension_info) {
			$rocket_form_ext_class = \RocketElementorForm\Vicextender::$rocketextnamespace . $extension_class2;
			if (method_exists($rocket_form_ext_class, 'rocket_add_ext_to_form')) {
				$active_form_extensions_v1[] = $rocket_form_ext_class;
			}
		}

		$this->active_form_extensions_with_add_to_form = array_merge($active_form_extensions_dce, $active_form_extensions_v1);
	}
	public function __construct()
	{
		add_action( 'elementor_pro/init', [$this, 'initialize_active_form_extensions_with_add_to_form'] );
	}
	/**
	 * Add control to stack.
	 *
	 * This method adds a new control to the stack.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param Controls_Stack $element      Element stack.
	 * @param string         $control_id   Control ID.
	 * @param array          $control_data Control data.
	 * @param array          $options      Optional. Control additional options.
	 *                                     Default is an empty array.
	 *
	 * @return bool True if control added, False otherwise.
	 */
	public function add_control_to_stack(\Elementor\Controls_Stack $element, $control_id, $control_data, $options = [])
	{
		$element_name = $element->get_name();
		if ($element_name === 'form') {
			foreach ($this->active_form_extensions_with_add_to_form as $ext) {
				$control_data = $ext::rocket_add_ext_to_form($element, $control_id, $control_data, $options);
			}
		}
		return parent::add_control_to_stack($element, $control_id, $control_data, $options);
	}
}
