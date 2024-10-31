<?php

namespace RocketElementorForm;

/**
 * Main Plugin Class
 *
 * @since 0.0.1
 */
class Plugin
{
	private static $instance;
	public $vicextender;
	/**
	 * Constructor
	 *
	 * @since 0.0.1
	 *
	 * @access public
	 */
	public function __construct()
	{
		$this->init();
	}
	public static function instance()
	{
		if (\is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function init()
	{
		// Instance classes
		// fire actions
		add_action('elementor/init', [$this, 'add_rocket_to_elementor'], 0);

		$this->load_dependencies_wid();
		$this->instances();
	}
	public function instances()
	{
		$this->vicextender = new \RocketElementorForm\Vicextender();
		// Init hook
		do_action( 'rocket_form_extender/init' );
	}
	/**
	 * Add Actions
	 *
	 * @since 0.0.1
	 *
	 * @access private
	 */
	public function add_rocket_to_elementor()
	{
		/**
		 * Overwrite and push custom widgets to Elementor.
		 */
		require_once ROCKET_ADDON_PATH . '/overdrive/rocket-controls-manager.php';
		// Controls Manager
		\Elementor\Plugin::$instance->controls_manager = new \RocketElementorForm\ROCKET_Controls_Manager(\Elementor\Plugin::$instance->controls_manager);
		// Vicextender
		$ext_excluded_opts = json_decode( get_option( 'rocket_addons_excluded_extensions' ), true );
		$ext_excluded_array = array_filter($ext_excluded_opts, function ($key) {
			return $key;
		});
		$rocket_the_extensions = $this->vicextender->rocket_form_ext_arr();
		$excluded_extensions = $ext_excluded_array;
		foreach ( $rocket_the_extensions as $extclass => $extclassname ) {
			if ( ! isset( $excluded_extensions[$extclass] ) ) {
				$rclass = \RocketElementorForm\Vicextender::$rocketextnamespace . $extclass;
				$filtered_ext = new $rclass($extclassname);
			}
		}
		add_action('elementor_pro/init', function () {
			do_action('rocket/register_form_actions');
		});
	}

	public function load_dependencies_wid() {

		if ( _is_elementor_installed() ) {

			/**
			 * Elementor widget addons extender elements.
			 */
			require_once ROCKET_ADDON_PATH . '/class/rocket-ext.php';

			/**
			 * Elementor widget extend elements.
			 */
			require_once ROCKET_ADDON_PATH . '/widget-addons/extender.php';

			/**
			 * Elementor widget form elements.
			 */
			require_once ROCKET_ADDON_PATH . '/widget-addons/form/conditional-fields.php';
		}

	}
}
\RocketElementorForm\Plugin::instance();
