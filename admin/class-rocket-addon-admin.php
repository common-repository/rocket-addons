<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rocket-addons.com/
 * @since      1.0.0
 *
 * @package    Rocket_Addon
 * @subpackage Rocket_Addon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rocket_Addon
 * @subpackage Rocket_Addon/admin
 * @author     RocketAddons <admin@themesawesome.com>
 */
class Rocket_Addon_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'admin_menu', array( $this, 'addPluginAdminMenu' ), 9 );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rocket_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rocket_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rocket-addons-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-elem-icons', plugin_dir_url( __FILE__ ) . 'css/fonts.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rocket_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rocket_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rocket-addons-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'rocket_ajax_object', array( 'adminurl' => admin_url() ) );

	}

	public function addPluginAdminMenu() {
		add_menu_page( 'Rocket Addons', 'Rocket Addons', 'administrator', 'rocket-addons-for-elementor', array( $this, 'displayPluginAdminSettings'), ROCKET_ADDON_URL . 'assets/rocket-icon.svg', 59 );
		add_submenu_page( 'rocket-addons-for-elementor', 'Addons', 'Addons', 'administrator', 'rocket-addons-for-elementor-addons', array( $this, 'rocketAddonsPage' ) );
	}

	public function displayPluginAdminSettings() {
		require_once 'partials/' . $this->plugin_name . '-admin-display.php';
	}

	public function rocketAddonsPage() {
		require_once 'partials/rocket-addons-for-elementor-addons.php';
	}

}
