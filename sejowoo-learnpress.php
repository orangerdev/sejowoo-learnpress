<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sejoli.co.id
 * @since             1.0.0
 * @package           Sejowoo_Learnpress
 *
 * @wordpress-plugin
 * Plugin Name:       Sejowoo LearnPress
 * Plugin URI:        https://sejoli.co.id
 * Description:       Integrates LearnPress, an courses plugin with Sejoli WooCommerce, a premium WordPress membership plugin.
 * Version:           1.0.0
 * Author:            Sejoli Team
 * Author URI:        https://sejoli.co.id
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sejowoo-learnpress
 * Domain Path:       /languages
 */

global $sejolp;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SEJOWOO_LEARNPRESS_VERSION', '1.0.0' );
define( 'SEJOWOO_LEARNPRESS_DIR', plugin_dir_path(__FILE__));
define( 'SEJOWOO_LEARNPRESS_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sejowoo-learnpress-activator.php
 */
function activate_sejowoo_learnpress() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sejowoo-learnpress-activator.php';
	Sejowoo_Learnpress_Activator::activate();

}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sejowoo-learnpress-deactivator.php
 */
function deactivate_sejowoo_learnpress() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sejowoo-learnpress-deactivator.php';
	Sejowoo_Learnpress_Deactivator::deactivate();

}

register_activation_hook( __FILE__, 'activate_sejowoo_learnpress' );
register_deactivation_hook( __FILE__, 'deactivate_sejowoo_learnpress' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sejowoo-learnpress.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sejowoo_learnpress() {

	$plugin = new Sejowoo_Learnpress();
	$plugin->run();

}

require_once(SEJOWOO_LEARNPRESS_DIR . 'third-parties/yahnis-elsts/plugin-update-checker/plugin-update-checker.php');

$update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/orangerdev/sejowoo-learnpress',
	__FILE__,
	'sejowoo-learnpress'
);

$update_checker->setBranch('master');

run_sejowoo_learnpress();
