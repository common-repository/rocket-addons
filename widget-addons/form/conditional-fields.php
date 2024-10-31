<?php

namespace RocketElementorForm\Vicextender;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
if (!\defined('ABSPATH')) {
	exit;
}
// Exit if accessed directly
class Rocket_Addons_Extension_Form_Visibility extends \RocketElementorForm\Vicextender\ROCKET_Extension_Extender
{
	public function __construct() {
		parent::__construct();
		add_action( 'elementor/widget/render_content', array( $this, 'rocket_render_template' ), 10, 2 );
	}
	public function get_name()
	{
		return 'rocket_form_visibility';
	}
	public function get_label()
	{
		return esc_html__( 'Field Condition', 'rocket-addons' );
	}

	public static function rocket_add_ext_to_form(Controls_Stack $element, $control_id, $control_data, $options = [])
	{

		if ( $element->get_name() == 'form' && $control_id == 'form_fields' ) {
			$control_data['fields']['rocket_visibility_form_tab'] = array(
				'type' => 'tab',
				'tab' => 'visibility',
				'label' => '<i class="batavia icon-gears-setting" aria-hidden="true"></i>',
				'tabs_wrapper' => 'form_fields_tabs',
				'name' => 'rocket_visibility_form_tab'
			);
			$control_data['fields']['rocket_field_visibility_mode'] = array(
				'label' => esc_html__('Visibility', 'rocket-addons'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'visible' => [
						'title' => esc_html__('Always Visible', 'rocket-addons'),
						'icon' => 'fa fa-check-square-o'
					], 'show' => [
						'title' => esc_html__('Show IF', 'rocket-addons'),
						'icon' => 'fa fa-eye'
					], 'hide' => [
						'title' => esc_html__('Hide IF', 'rocket-addons'),
						'icon' => 'fa fa-eye-slash'
					]
				],
				'toggle' => false,
				'default' => 'visible',
				'tab' => 'visibility',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'rocket_visibility_form_tab',
				'name' => 'rocket_field_visibility_mode'
			);
			$control_data['fields']['rocket_field_visibility_field'] = array(
				'type' => Controls_Manager::TEXT,
				'tab' => 'visibility',
				'label' => esc_html__('Field ID', 'rocket-addons'),
				'placeholder' => esc_html__('name', 'rocket-addons'),
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'rocket_visibility_form_tab',
				'name' => 'rocket_field_visibility_field',
				'condition' => array(
					'rocket_field_visibility_mode!' => 'visible',
				)
			);
			$control_data['fields']['rocket_field_visibility_operator'] = array(
				'label' => esc_html__('Operator', 'rocket-addons'),
				'type' => Controls_Manager::SELECT,
				'options' => array(
					'empty' => 'empty',
					'not_empty' => 'not empty',
					'equal' => 'equals',
					'not_equal' => 'not equals',
					'greater' => 'greater than',
					'greaterequal' => 'greater than or equal',
					'less' => 'less than',
					'lessequal' => 'less than or equal',
					'contain' => 'contains',
					'not_contain' => 'not contains',
					'is_checked' => 'is checked',
					'not_checked' => 'not checked'
				),
				'default' => 'equal',
				'tab' => 'visibility',
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'rocket_visibility_form_tab',
				'name' => 'rocket_field_visibility_operator',
				'condition' => array('rocket_field_visibility_mode!' => 'visible')
			);
			$control_data['fields']['rocket_field_visibility_value'] = array(
				'type' => Controls_Manager::TEXT,
				'tab' => 'visibility',
				'label' => esc_html__('Value', 'rocket-addons'),
				'tabs_wrapper' => 'form_fields_tabs',
				'inner_tab' => 'rocket_visibility_form_tab',
				'name' => 'rocket_field_visibility_value',
				'condition' => array(
					'rocket_field_visibility_mode!' => 'visible',
					'rocket_field_visibility_operator' => array(
						'equal',
						'not_equal',
						'greater',
						'less',
						'greaterequal',
						'lessequal',
						'not_contain',
						'contain',
						'is_checked',
						'not_checked'
					)
				)
			);
		}
		return $control_data;
	}

	public function rocket_render_template( $content, $widget )
	{
		$form_script_recall = '';
		$random_selector = rand();
		$elementor_widget_id = $widget->get_id();
		$elementor_widget_name = $widget->get_name();
		$elementor_el_cl = '.elementor-element-';
		$rocket_script_id = 'rocket_visibility_' . $random_selector . '_' . $elementor_widget_id;
		$list_form_fields = array();
		if ( 'form' === $elementor_widget_name ) :
			$instance = $widget->get_settings_for_display();
			$list_form_fields = $instance['form_fields'] ;
			if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) :
				if ( ! empty( $list_form_fields ) ) :
					foreach ( $list_form_fields as $field ) :
						$js_conditional = '';
						$field_name = $field['custom_id'];
						$field_type = $field['field_type'];
						$selector_parent_class = $elementor_el_cl . $elementor_widget_id . ' .elementor-field-group-' . $field_name;
						$conditional_field_target = $elementor_el_cl . $elementor_widget_id . ' #form-field-' . $field_name;

						$condition_val = $field['rocket_field_visibility_value'];
						$condition_op = $field['rocket_field_visibility_operator'];

						$disabled_end = $field['rocket_field_visibility_mode'];
						$disabled_init = $field['rocket_field_visibility_mode'];
						$display_class = $field['rocket_field_visibility_mode'];

						if ( 'show' === $disabled_end ) {
							$form_disable_stat2 = 'false';
						} else {
							$form_disable_stat2 = 'true';
						}
						if ( 'show' === $disabled_init ) {
							$form_disable_stat1 = 'true';
						} else {
							$form_disable_stat1 = 'false';
						}
						if ( 'show' === $display_class ) {
							$form_visibility_class = 'hide';
						} else {
							$form_visibility_class = 'show';
						}

						if ( $field['rocket_field_visibility_mode'] != 'visible' ) {
							if ( ! empty( $field['rocket_field_visibility_field'] ) ) {
								$selector_val = $elementor_el_cl . $elementor_widget_id . ' #form-field-' . $field['rocket_field_visibility_field'];
								$script_val = 'jQuery("' . $selector_val . '").val()';
								$script_checker = 'jQuery("' . $selector_val . '").length';
								$js_conditional = $this->rocket_conditional_visibility( $condition_op, $script_checker, $script_val, $condition_val );
							}
							if ( ! $js_conditional ) {
								continue;
							}
							?>
							<script id="<?php echo esc_html( $rocket_script_id ); ?>">
								(function ($) {
									var <?php echo esc_html( $rocket_script_id ); ?> = function ($scope, $) {
										if ($scope.hasClass("elementor-element-<?php echo esc_html( $elementor_widget_id ); ?>")) {
											$('<?php echo esc_html( $selector_val ); ?>').on('change', function () {
												if (<?php echo wp_specialchars_decode( $js_conditional ); ?>) {
													$('<?php echo esc_html( $selector_parent_class ); ?>').addClass('rocket-display-' + '<?php echo esc_html( $field['rocket_field_visibility_mode'] ); ?>');
													$('<?php echo esc_html( $selector_parent_class ); ?>').removeClass('rocket-display-' + '<?php echo esc_html( $form_visibility_class ); ?>');
													$('<?php echo esc_html( $conditional_field_target ); ?>').prop('disabled', <?php echo esc_html( $form_disable_stat2 ); ?>);
												} else {
													$('<?php echo esc_html( $selector_parent_class ); ?>').removeClass('rocket-display-' + '<?php echo esc_html( $field['rocket_field_visibility_mode'] ); ?>');
													$('<?php echo esc_html( $selector_parent_class ); ?>').addClass('rocket-display-' + '<?php echo esc_html( $form_visibility_class ); ?>');
													$('<?php echo esc_html( $conditional_field_target ); ?>').prop('disabled', <?php echo esc_html( $form_disable_stat1 ); ?>);
												}
											});
											$('<?php echo esc_html( $selector_val ); ?>').each(function () {
												$(this).change();
											});
										}
									};
									$(window).on('elementor/frontend/init', function () {
										elementorFrontend.hooks.addAction('frontend/element_ready/form.default', <?php echo esc_html( $rocket_script_id ); ?>);
									});
								})(jQuery, window);
							</script>
							<?php
						}
					endforeach;
				endif;
			endif;
		endif;
		return $content;
	}
}
