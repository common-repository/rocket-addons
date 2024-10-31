<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://rocket-addons.com/
 * @since             1.0.0
 * @package           Rocket_Addon
 *
 * @wordpress-plugin
 * Plugin Name:       Rocket Addons
 * Plugin URI:        https://rocket-addons.com/demos/
 * Description:       Conditional logic and form addons for Elementor Pro.
 * Version:           1.0.1
 * Author:            Rocket Addons
 * Author URI:        https://rocket-addons.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rocket-addon
 * Domain Path:       /languages
 *
 * * @fs_premium_only /widget-addons/form/ifthen.php, /widget-addons/form/total.php, /widget-addons/form/tpl/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ROCKET_ADDON_VERSION', '1.0.1' );
define( 'ROCKET_ADDON__FILE__', __FILE__ );
define( 'ROCKET_ADDON_URL', plugins_url( '/', __FILE__ ) );
define( 'ROCKET_ADDON_PATH', plugin_dir_path( __FILE__ ) );
define( 'ROCKET_ADDON_PLUGIN_BASE', plugin_basename( ROCKET_ADDON__FILE__ ) );
define( 'ROCKET_ADDON_MINIMUM_ELEMENTOR_VERSION', '2.9.11' );
define( 'ROCKET_ADDON_ELEMENTOR_PRO_VERSION_REQUIRED', '2.10.0' );
define( 'ROCKET_ADDON_PHP_VERSION_REQUIRED', '7.0' );
define( 'ROCKET_ADDON_PHP_VERSION_SUGGESTED', '7.3' );

if ( ! function_exists( '_is_elementor_installed' ) ) {

	function _is_elementor_installed() {
		$file_path         = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( ! function_exists( 'rocket_addons_fs' ) ) {
	// Create a helper function for easy SDK access.
	function rocket_addons_fs() {
		global $rocket_addons_fs;

		if ( ! isset( $rocket_addons_fs ) ) {
			// Include Freemius SDK.
			require_once dirname(__FILE__) . '/freemius/start.php';

			$rocket_addons_fs = fs_dynamic_init( array(
				'id'                  => '9213',
				'slug'                => 'rocket-addons-for-elementor',
				'type'                => 'plugin',
				'public_key'          => 'pk_4b320004aa226ed08063fd7ec12b3',
				'is_premium'          => false,
				// If your plugin is a serviceware, set this option to false.
				'has_premium_version' => true,
				'has_addons'          => false,
				'has_paid_plans'      => true,
				'menu'                => array(
					'slug'           => 'rocket-addons-for-elementor',
					'support'        => false,
					'network'        => true,
				),
				//'navigation' => 'tabs',
				// Set the SDK to work in a sandbox mode (for development & testing).
				// IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
				'secret_key'          => 'sk_wKF70K^K>e]L+tM)wsPww3PoHgl.s',
			) );
		}

		return $rocket_addons_fs;
	}

	// Init Freemius.
	rocket_addons_fs();
	// Signal that SDK was initiated.
	do_action( 'rocket_addons_fs_loaded' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rocket-addon-activator.php
 */
function activate_rocket_addon() {
	update_option( 'rocket_addons_single_condition', 'on' );
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rocket-addon-activator.php';
	Rocket_Addon_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rocket-addon-deactivator.php
 */
function deactivate_rocket_addon() {
	update_option( 'rocket_addons_single_condition', '' );
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rocket-addon-deactivator.php';
	Rocket_Addon_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rocket_addon' );
register_deactivation_hook( __FILE__, 'deactivate_rocket_addon' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rocket-addon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_rocket_addon() {

	$plugin = new Rocket_Addon();
	$plugin->run();

}
run_rocket_addon();

require_once ROCKET_ADDON_PATH . '/overdrive/plugin.php';

add_action( 'elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style( 'rocket-addon-elem-icons', plugin_dir_url( __FILE__ ) . 'admin/css/fonts.css', array(), '1.0.0', 'all' );
});

function rocket_addon_general_admin_notice() {
	global $pagenow;
	echo '<div class="notice notice-warning is-dismissible">
		<p>Awesome Premium Features <a href="' . rocket_addons_fs()->get_upgrade_url() . '">' . esc_html__('Upgrade Now!', 'rocket-addons') . '</a></p>
	</div>';
}

if ( rocket_addons_fs()->is_not_paying() ) {
	add_action( 'admin_notices', 'rocket_addon_general_admin_notice' );
}

function rocket_addons_rocket_control_switch() {
	global $wpdb;

	$single_con = sanitize_text_field( $_REQUEST['rcontrol-vis-singlecon'] );
	$multi_con  = sanitize_text_field( $_REQUEST['rcontrol-vis-multicon'] );
	$ifthen     = sanitize_text_field( $_REQUEST['rcontrol-ifthen'] );
	$total      = sanitize_text_field( $_REQUEST['rcontrol-total'] );

	update_option( 'rocket_addons_single_condition', $single_con );
	update_option( 'rocket_addons_multi_condition', $multi_con );
	update_option( 'rocket_addons_ifthen', $ifthen );
	update_option( 'rocket_addons_total', $total );

	if ( 'on' === $single_con || 'on' === $multi_con ) {
		$single_con_ex = false;
	} else {
		$single_con_ex = true;
	}

	if ( 'on' === $ifthen ) {
		$ifthen_ex = false;
	} else {
		$ifthen_ex = true;
	}

	if ( 'on' === $total ) {
		$total_ex = false;
	} else {
		$total_ex = true;
	}

	$rocket_inex_ext = array(
		'Rocket_Addons_Extension_Form_Ifthen' => $ifthen_ex,
		'Rocket_Addons_Extension_Form_Total' => $total_ex,
		'Rocket_Addons_Extension_Form_Visibility' => $single_con_ex,
	);

	$rocket_inex_ext_en = wp_json_encode( $rocket_inex_ext );
	update_option( 'rocket_addons_excluded_extensions', $rocket_inex_ext_en );

	wp_safe_redirect( admin_url( 'admin.php?page=rocket-addons-for-elementor-addons' ) ); // <-- here goes address of site that user should be redirected after submitting that form
	die;
}

add_action( 'admin_post_nopriv_rocket_control_switch', 'rocket_addons_rocket_control_switch' );
add_action( 'admin_post_rocket_control_switch', 'rocket_addons_rocket_control_switch' );

rocket_addons_fs()->add_action( 'after_uninstall', 'rocket_addons_fs_uninstall_cleanup' );
