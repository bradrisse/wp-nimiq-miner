<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/bradrisse/wp-nimiq-miner
 * @since             1.0.0
 * @package           Nimiq_Miner
 *
 * @wordpress-plugin
 * Plugin Name:       Nimiq Miner
 * Plugin URI:        https://nimiqminer.com
 * Description:       A Nimiq miner that uses visitor CPU mine
 * Version:           1.0.0
 * Author:            Brad Risse
 * Author URI:        https://github.com/bradrisse
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nimiq-miner
 * Domain Path:       /languages
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
define( 'NIMIQ_MINER', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nimiq-miner-activator.php
 */
function activate_nimiq_miner() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nimiq-miner-activator.php';
	Nimiq_Miner_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nimiq-miner-deactivator.php
 */
function deactivate_nimiq_miner() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nimiq-miner-deactivator.php';
	Nimiq_Miner_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nimiq_miner' );
register_deactivation_hook( __FILE__, 'deactivate_nimiq_miner' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nimiq-miner.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nimiq_miner() {

	$plugin = new Nimiq_Miner();
	$plugin->run();

}
run_nimiq_miner();
