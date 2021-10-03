<?php
namespace Sejowoo_Learnpress;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sejoli.co.id
 * @since      1.0.0
 *
 * @package    Sejowoo_Learnpress
 * @subpackage Sejowoo_Learnpress/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sejowoo_Learnpress
 * @subpackage Sejowoo_Learnpress/admin
 * @author     Sejoli Team <admin@sejoli.co.id>
 */
class Admin {

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

	private $is_sejoli_woocommerce_active = true;

	private $is_learnpress_active = true;

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
	 * Check if needed plugins are active
	 * @uses 	plugins_loaded, priority 999
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function check_needed_plugins() {

		if( !class_exists( 'LearnPress' ) ) :
			$this->is_learnpress_active = false;
		endif;

		if( !defined('SEJOWOO_VERSION') ) :
			$this->is_sejoli_woocommerce_active = false;
		endif;

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
		 * defined in SejoliLP_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The SejoliLP_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sejowoo-learnpress-admin.css', array(), $this->version, 'all' );

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
		 * defined in SejoliLP_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The SejoliLP_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sejowoo-learnpress-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Display notice if LearnPress not activated
	 * @uses 	admin_notices, (action), 10
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function display_notice_if_learnpress_not_activated() {

		if( false === $this->is_learnpress_active ) :

	    	?><div class='notice notice-error'>
	    		<p><?php _e('Anda belum menginstall atau mengaktifkan Plugin LearnPress terlebih dahulu.', 'sejowoo-learnpress'); ?></p>
			</div>
<?php

	    endif;

	}

	/**
	 * Display notice if sejoli not activated
	 * @uses 	admin_notices, (action), 10
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function display_notice_if_sejowoo_not_activated() {

		if( false === $this->is_sejoli_woocommerce_active ) :

	    	?><div class='notice notice-error'>
	    		<p><?php _e('Anda belum menginstall atau mengaktifkan Sejoli terlebih dahulu.', 'sejowoo-learnpress'); ?></p>
			</div>
<?php

	    endif;

	}

}
