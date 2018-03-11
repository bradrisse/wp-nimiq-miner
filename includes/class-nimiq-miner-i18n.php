<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/bradrisse/wp-nimiq-miner
 * @since      1.0.0
 *
 * @package    Nimiq_Miner
 * @subpackage Nimiq_Miner/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Nimiq_Miner
 * @subpackage Nimiq_Miner/includes
 * @author     Brad Risse <bradrisse@gmail.com>
 */
class Nimiq_Miner_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'nimiq-miner',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
