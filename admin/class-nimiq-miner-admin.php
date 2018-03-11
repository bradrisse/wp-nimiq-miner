<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/bradrisse/wp-nimiq-miner
 * @since      1.0.0
 *
 * @package    Nimiq_Miner
 * @subpackage Nimiq_Miner/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nimiq_Miner
 * @subpackage Nimiq_Miner/admin
 * @author     Brad Risse <bradrisse@gmail.com>
 */
class Nimiq_Miner_Admin {

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
		 * defined in Nimiq_Miner_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nimiq_Miner_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nimiq-miner-admin.css', array(), $this->version, 'all' );

         wp_enqueue_style( 'wp-color-picker' ); 

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
		 * defined in Nimiq_Miner_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nimiq_Miner_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nimiq-miner-admin.js', array( 'jquery', 'wp-color-picker' ), '0.0.2', false );

	}


}

add_action('admin_menu', 'add_new_menu_items');

function add_new_menu_items() {
    add_menu_page(
        "Nimiq Miner",
        "Nimiq Miner",
        "manage_options",
        "nimiq-miner",
        "nimiq_miner_options_page",
        "", 
        99
    );

}

add_action( 'admin_init', function() {
    register_setting( 'nimiq-miner', 'nim_address' );
    register_setting( 'nimiq-miner', 'nim_thread_percent' );
    register_setting( 'nimiq-miner', 'nim_display_disclaimer' );
});

// function test_plugin_setup_menu(){
//         add_menu_page( 'Nimiq Miner', 'Nimiq Miner', 'manage_options', 'nimiq-miner', 'nimiq_miner_init' );
// }

function nimiq_miner_options_page()
    {
        ?>
            <div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <h1>Nimiq Miner</h1>
            

            <?php
                $active_tab = "general-settings";
                if(isset($_GET["tab"])) {
                    if($_GET["tab"] == "general-settings") {
                        $active_tab = "general-settings";
                    } else {
                        $active_tab = "statistics";
                    }
                }
            ?>
            
            <!-- wordpress provides the styling for tabs. -->
            <h2 class="nav-tab-wrapper">
                <!-- when tab buttons are clicked we jump back to the same page but with a new parameter that represents the clicked tab. accordingly we make it active -->
                <a href="?page=nimiq-miner&tab=general-settings" class="nav-tab <?php if($active_tab == 'general-settings'){echo 'nav-tab-active';} ?> "><?php _e('General Settings', 'nimiq-miner'); ?></a>
                <a href="?page=nimiq-miner&tab=statistics" class="nav-tab <?php if($active_tab == 'statistics'){echo 'nav-tab-active';} ?>"><?php _e('Statistics', 'nimiq-miner'); ?></a>
            </h2>

            <form method="post" action="options.php">
                <?php
                
                    settings_fields("general_settings_section");
                    
                    do_settings_sections("nimiq-miner");
                
                    submit_button(); 
                    
                ?>          
            </form>
        </div>
        <?php
    }

    add_action("admin_menu", "add_new_menu_items");

    function display_options() {

        //here we display the sections and options in the settings page based on the active tab
        if(isset($_GET["tab"])) {
            if($_GET["tab"] == "general-settings" || !$_GET["tab"]) {

            	display_settings_content();
            } else {
                register_setting("general_settings_section", "nim_address");
            }
        } else {
        	display_settings_content();
        }
        
    }

    function display_settings_content() {
    	add_settings_section("general_settings_section", "General Settings", "display_general_settings_content", "nimiq-miner");

        add_settings_field("nim_address", "NIM Address", "display_nim_address_form_element", "nimiq-miner", "general_settings_section");
    	register_setting("general_settings_section", "nim_address");

    	add_settings_field("nim_thread_percent", "Thread Percent", "display_nim_thread_percent_form_element", "nimiq-miner", "general_settings_section");
    	register_setting("general_settings_section", "nim_thread_percent");

    	add_settings_field("nim_thread_percent", "Thread Percent", "display_nim_thread_percent_form_element", "nimiq-miner", "general_settings_section");
    	register_setting("general_settings_section", "nim_thread_percent");

        add_settings_field("nim_disclaimer_bg", "Disclaimer Background", "display_nim_disclaimer_bg_form_element", "nimiq-miner", "general_settings_section");
        register_setting("general_settings_section", "nim_disclaimer_bg");

        add_settings_field("nim_disclaimer_text_color", "Disclaimer Text Color", "display_nim_disclaimer_text_color_form_element", "nimiq-miner", "general_settings_section");
        register_setting("general_settings_section", "nim_disclaimer_text_color");

        add_settings_field("nim_disclaimer_text", "Disclaimer Text", "display_nim_disclaimer_text_form_element", "nimiq-miner", "general_settings_section");
        register_setting("general_settings_section", "nim_disclaimer_text");
    }

    function display_general_settings_content(){echo "The general settings for visitor mining";}

    function display_nim_address_form_element() {
        ?>
            <input type="text" placeholder="NIM ADDRESS" name="nim_address" value="<?php echo esc_attr( get_option('nim_address') ); ?>" size="50" /><br>
                	<span>The address you want the mining rewards to be sent to.</span>
        <?php
    }

    function display_nim_thread_percent_form_element() {
        ?>
            <select name="nim_thread_percent">
                        <option value="">&mdash; select &mdash;</option>
                        <option value="1" <?php echo esc_attr( get_option('nim_thread_percent') ) == '1' ? 'selected="selected"' : ''; ?>>1</option>
                        <option value="5" <?php echo esc_attr( get_option('nim_thread_percent') ) == '5' ? 'selected="selected"' : ''; ?>>5</option>
                        <option value="10" <?php echo esc_attr( get_option('nim_thread_percent') ) == '10' ? 'selected="selected"' : ''; ?>>10</option>
                        <option value="15" <?php echo esc_attr( get_option('nim_thread_percent') ) == '15' ? 'selected="selected"' : ''; ?>>15</option>
                        <option value="20" <?php echo esc_attr( get_option('nim_thread_percent') ) == '20' ? 'selected="selected"' : ''; ?>>20</option>
                        <option value="25" <?php echo esc_attr( get_option('nim_thread_percent') ) == '25' ? 'selected="selected"' : ''; ?>>25</option>
                        <option value="30" <?php echo esc_attr( get_option('nim_thread_percent') ) == '30' ? 'selected="selected"' : ''; ?>>30</option>
                        <option value="35" <?php echo esc_attr( get_option('nim_thread_percent') ) == '35' ? 'selected="selected"' : ''; ?>>35</option>
                        <option value="40" <?php echo esc_attr( get_option('nim_thread_percent') ) == '40' ? 'selected="selected"' : ''; ?>>40</option>
                        <option value="45" <?php echo esc_attr( get_option('nim_thread_percent') ) == '45' ? 'selected="selected"' : ''; ?>>45</option>
                        <option value="50" <?php echo esc_attr( get_option('nim_thread_percent') ) == '50' ? 'selected="selected"' : ''; ?>>50</option>
                    </select><br>
                    <span>The percentage of threads of the visitors CPU that will mine. The larger the percent, the more reward, but will also slow down visitors computer.</span>
        <?php
    }

    function display_nim_disclaimer_bg_form_element() {
        ?>
            <input type="text" placeholder="Disclaimer Background" name="nim_disclaimer_bg" value="<?php echo esc_attr( get_option('nim_disclaimer_bg') ); ?>" size="50" class="cpa-color-picker"/><br>
                    <span>The background color of the disclaimer</span>
        <?php
    }

    function display_nim_disclaimer_text_color_form_element() {
        ?>
            <input type="text" placeholder="Disclaimer Text Color" name="nim_disclaimer_text_color" value="<?php echo esc_attr( get_option('nim_disclaimer_text_color') ); ?>" size="50" class="cpa-color-picker"/><br>
                    <span>The text color of the disclaimer</span>
        <?php
    }

    function display_nim_disclaimer_text_form_element() {
        ?>
            <input type="text" placeholder="Disclaimer Text" name="nim_disclaimer_text" value="<?php echo esc_attr( get_option('nim_disclaimer_text') ); ?>" size="50"/><br>
                    <span>The text for the disclaimer</span>
        <?php
    }

add_action("admin_init", "display_options");
