<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/bradrisse/wp-nimiq-miner
 * @since      1.0.0
 *
 * @package    Nimiq_Miner
 * @subpackage Nimiq_Miner/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Nimiq_Miner
 * @subpackage Nimiq_Miner/public
 * @author     Brad Risse <bradrisse@gmail.com>
 */
class Nimiq_Miner_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nimiq_Miner_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nimiq_Miner_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nimiq-miner-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nimiq_Miner_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nimiq_Miner_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'nimiq-core', 'http://cdn.nimiq.com/core/nimiq.js');
		wp_enqueue_script( 'nimiq-web', 'http://cdn.nimiq.com/core/web.js');
		wp_enqueue_script( 'nimiq-wasm', 'http://cdn.nimiq.com/core/worker-wasm.js');

		wp_register_script( 'nimiq-miner', plugin_dir_url( __FILE__ ) . 'js/nimiq-miner-public.js', array( 'jquery' ), 4, false );

		$localize = array(
		    'nim_address' => get_option('nim_address'),
		    'nim_thread_percent' => get_option('nim_thread_percent'),
		    'nim_display_disclaimer' => get_option('nim_display_disclaimer'),
		    'nim_disclaimer_bg' => get_option('nim_disclaimer_bg'),
		    'nim_disclaimer_text_color' => get_option('nim_disclaimer_text_color'),
		    'nim_disclaimer_text' => get_option('nim_disclaimer_text')
		);

		wp_localize_script( 'nimiq-miner', 'php_vars', $localize );

		wp_enqueue_script( 'nimiq-miner' );

	}

}
