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
     * Modify teacher registration fields
     * Hooked via filter learn_press_become_teacher_form_fields, priority 1
     * @since   1.0.0
     * @param   array  $fields  Array of registration fields
     * @return  array  Modified registration fields
     */
    public function modify_register_fields( array $fields ) {

        $current_user = sejowoo_get_user( get_current_user_id() );

        $fields['bat_phone']['saved'] = $current_user->meta->phone;

        return $fields;

    }

}
