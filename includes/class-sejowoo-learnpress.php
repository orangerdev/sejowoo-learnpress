<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://sejoli.co.id
 * @since      1.0.0
 *
 * @package    Sejowoo_Learnpress
 * @subpackage Sejowoo_Learnpress/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sejowoo_Learnpress
 * @subpackage Sejowoo_Learnpress/includes
 * @author     Sejoli Team <admin@sejoli.co.id>
 */
class Sejowoo_Learnpress {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sejowoo_Learnpress_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'SEJOWOO_LEARNPRESS_VERSION' ) ) {
			$this->version = SEJOWOO_LEARNPRESS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'sejowoo-learnpress';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sejowoo_Learnpress_Loader. Orchestrates the hooks of the plugin.
	 * - Sejowoo_Learnpress_i18n. Defines internationalization functionality.
	 * - Sejowoo_Learnpress_Admin. Defines all hooks for the admin area.
	 * - Sejowoo_Learnpress_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sejowoo-learnpress-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sejowoo-learnpress-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sejowoo-learnpress-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sejowoo-learnpress-product.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sejowoo-learnpress-order.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sejowoo-learnpress-teacher.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sejowoo-learnpress-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sejowoo-learnpress-member.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sejowoo-learnpress-course.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sejowoo-learnpress-teacher.php';

		/**
		 * Routine functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'functions/user.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'functions/course.php';

		$this->loader = new Sejowoo_Learnpress_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sejowoo_Learnpress_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sejowoo_Learnpress_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$admin = new Sejowoo_Learnpress\Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );
		$this->loader->add_action( 'plugins_loaded', $admin, 'check_needed_plugins', 999);
		$this->loader->add_action( 'admin_notices',	$admin, 'display_notice_if_sejowoo_not_activated', 10);
		$this->loader->add_action( 'admin_notices',	$admin, 'display_notice_if_learnpress_not_activated', 10);

		// LearnPress WooCOmmerce Product Data
		$product = new Sejowoo_Learnpress\Admin\Product( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'woocommerce_product_data_tabs', $product, 'add_sejowoo_learnpress_product_data_tab' );
		$this->loader->add_action( 'woocommerce_product_data_panels', $product, 'add_sejowoo_learnpress_product_data_fields' );
		$this->loader->add_action( 'woocommerce_process_product_meta_simple', $product, 'save_sejowoo_learnpress_option_fields' );
		$this->loader->add_action( 'woocommerce_process_product_meta_variable', $product, 'save_sejowoo_learnpress_option_fields' );
		$this->loader->add_filter( 'product_type_options', $product, 'add_sejowoo_learnpress_product_option' );

		$order = new Sejowoo_Learnpress\Admin\Order( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'learn-press/checkout/default-user', $order, 'set_buyer_id', 1);
		$this->loader->add_filter( 'woocommerce_order_status_completed', $order, 'create_learnpress_order' );
		$this->loader->add_filter( 'woocommerce_order_status_on-hold', $order, 'cancel_learnpress_order' );
		$this->loader->add_filter( 'woocommerce_order_status_failed', $order, 'cancel_learnpress_order' );
		$this->loader->add_filter( 'woocommerce_order_status_cancelled', $order, 'cancel_learnpress_order' );

		$teacher = new Sejowoo_Learnpress\Admin\Teacher( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $teacher, 'modify_capability', 999);

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$public = new Sejowoo_Learnpress\Front( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_scripts' );

		$member = new Sejowoo_Learnpress\Front\Member( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'sejowoo/my-account-endpoint/vars', $member, 'register_my_account_endpoint', 16 );
		$this->loader->add_filter( 'sejowoo/myaccount/links', $member, 'add_my_account_links', 30 );
		$this->loader->add_filter( 'woocommerce_endpoint_class_title', $member, 'set_my_account_title', 1);
		$this->loader->add_action( 'woocommerce_account_class_endpoint', $member, 'set_my_account_content', 1);

		// Actions used to insert a new endpoint in the WordPress.
		$this->loader->add_action( 'init', $member, 'add_endpoints' );
		$this->loader->add_filter( 'query_vars', $member, 'add_query_vars', 0 );

		$course = new Sejowoo_Learnpress\Front\Course( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'plugins_loaded', $course, 'remove_unneeded_hooks', 1);
		$this->loader->add_action( 'learn-press/content-landing-summary', $course, 'display_product_button', 25);
		$this->loader->add_action( 'learn-press/course-buttons', $course, 'display_purchase_button', 10);
		$this->loader->add_filter( 'learn_press_get_template', $course, 'set_template_for_block_part', 999, 2);
		$this->loader->add_filter( 'learn_press_content_item_protected_message', $course, 'change_block_button', 999);
		$this->loader->add_filter( 'learn-press/user-course-status', $course, 'check_course_status', 99, 3);

		$teacher = new Sejowoo_Learnpress\Front\Teacher( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'learn_press_become_teacher_form_fields', $teacher, 'modify_register_fields', 1);

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		
		$this->loader->run();
	
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
	
		return $this->plugin_name;
	
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sejowoo_Learnpress_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
	
		return $this->loader;
	
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
	
		return $this->version;
	
	}

}