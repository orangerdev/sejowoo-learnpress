<?php
namespace Sejowoo_Learnpress;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sejoli.co.id
 * @since      1.0.0
 *
 * @package    Sejowoo_Learnpress
 * @subpackage Sejowoo_Learnpress/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sejowoo_Learnpress
 * @subpackage Sejowoo_Learnpress/public
 * @author     Sejoli Team <admin@sejoli.co.id>
 */
class Front {

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
		 * defined in Sejowoo_Learnpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sejowoo_Learnpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_register_style( 'semantic-ui', 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css', [], '2.4.1', 'all' );
		wp_enqueue_style( 'semantic-ui');

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sejowoo-learnpress-public.css', array(), $this->version, 'all' );

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
		 * defined in Sejowoo_Learnpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sejowoo_Learnpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_register_script( 'semantic-ui', 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js', array( 'jquery' ), '2.4.1', true );
		wp_enqueue_script( 'semantic-ui');

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sejowoo-learnpress-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Redirect if current page is learnpress page and user is not logged in
	 * Hooked via action template_redirect, priority 10
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function redirect_for_regular_pages() {

		// redirect from checkout page to course list
		if(learn_press_is_checkout()) :
			wp_redirect( get_post_type_archive_link( LP_COURSE_CPT ) );
			exit;
		endif;

		if(learn_press_is_profile()) :
			wp_redirect( site_url( 'member-area/profile' ) );
			exit;
		endif;

	}

}
