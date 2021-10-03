<?php
namespace Sejowoo_Learnpress\Front;

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
class Member {

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
     * Check if current method is already called
     * @since   1.1.2.1
     * @var     boolean
     */
    protected $is_called = false;

    /**
     * Hide class menu
     * @since   1.1.2.2
     * @var     boolean
     */
    protected $is_menu_hidden = true;

    /**
     * Custom endpoint name.
     *
     * @var string
     */
    public static $endpoint = 'class';

    /**
     * Course menu position
     * @since   1.0.0
     * @var     integer
     */
    protected $menu_position = 3;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name       The name of the plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

    /**
     * Register new endpoint to use inside My Account page.
     *
     * @see https://developer.wordpress.org/reference/functions/add_rewrite_endpoint/
     */
    public function add_endpoints() {
        
        add_rewrite_endpoint( self::$endpoint, EP_ROOT | EP_PAGES );
    
    }

    /**
     * Add new query var.
     *
     * @param array $vars
     * @return array
     */
    public function add_query_vars( $vars ) {
    
        $vars[] = self::$endpoint;

        return $vars;
    
    }

    /**
     * Register my-account endpont
     * Hooked via filter sejowoo/my-account-endpoint/vars, priority 16
     * @since   1.0.0
     * @since   1.1.2       Add condition to hide link
     * @since   1.1.2.2
     * @param   array       $query_vars
     * @return  array
     */
    public function register_my_account_endpoint( $query_vars ) {

        if(
            false === $this->is_called
        ) :

            $query_vars['all-class'] = 'class';
            $this->is_menu_hidden    = false;
            $this->is_called         = true;

        endif;

        return $query_vars;
    
    }

    /**
     *  Add custom woocommerce my account links
     *  Hooked via filter sejowoo/myaccount/links, priority 30
     *  @since  1.0.0
     *  @since  1.1.2       Change hook point
     *  @since  1.1.2.2     Change on how to hide the menu
     *  @param  array       $menu_links
     *  @return array
     */
    public function add_my_account_links( array $links ){

        if(
            true !== $this->is_menu_hidden
        ) :

            $links['class'] = __('Kelas', 'sejowoo-learnpress' );

        endif;

        return $links;

    }

    /**
     * Set my-account page title
     * Hooked via filter woocommerce_endpoint_all-class_title, priority 133
     * @since   1.0.0
     * @param   string  $title
     * @return  string
     */
    public function set_my_account_title( $title ) {
    
        return __('Kelas', 'sejowoo-learnpress');
    
    }

    /**
     * Set my-account page content
     * Hooked via action woocommerce_account_all-class_endpoint, priority 1
     * @since   1.0.0
     * @return  void
     */
    public function set_my_account_content( ) {

        wc_get_template(
            'course-list.php',
            array(),
            SEJOWOO_LEARNPRESS_DIR . 'template/',
            SEJOWOO_LEARNPRESS_DIR . 'template/'
        );

    }

}
