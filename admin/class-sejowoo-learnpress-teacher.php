<?php
namespace Sejowoo_Learnpress\Admin;

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
class Teacher {

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
	 * @param   string    $plugin_name       The name of the plugin.
	 * @param   string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Modify teacher capability
	 * Hooked via action init, priority 999
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function modify_capability() {

		$teacher = get_role( LP_TEACHER_ROLE );
		$teacher->add_cap( 'sejowoo_user_can_access_admin' );
	
	}
}
