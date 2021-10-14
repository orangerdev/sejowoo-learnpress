<?php
namespace Sejowoo_Learnpress\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

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
class Order {

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
     * Buyer ID
     *
     * @since   1.0.0
     * @access  protected
     * @var     integer
     */
    protected $buyer_id = 0;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

    /**
     * Set learnpress buyer order ID
     * Hooked via filter learn-press/checkcout/default-user, priority
     * @since   1.0.0
     * @param   integer $buyer_id
     */
    public function set_buyer_id( $buyer_id ) {

        if( 0 !== $this->buyer_id ) :
            return $this->buyer_id;
        endif;

        return $buyer_id;
    
    }

    /**
     * Create learnpress order when sejoli order completed
     * Hooked via sejoli/order/set-status/completed, prioirty 200
     * @since   1.0.0
     * @param   array  $order_data
     * @return  void
     */
    public function create_learnpress_order( $order_data ) {

        $order            = wc_get_order( $order_data );
        $user_id          = $order->get_user_id(); // Get the costumer ID
        $learnpress_order = get_post_meta( $order_data, 'learnpress_order', true );
        
        if( $learnpress_order === '' ):

            foreach ( $order->get_items() as $item_key => $item ):

                $product_id          = $item->get_product_id(); // the Product id
                $getLearnpress[]     = get_post_meta( $product_id, '_select_course', true );
                $product             = sejowoo_get_product( $product_id );
                $product->learnpress = $getLearnpress;
                $this->buyer_id      = $user_id;
                $courses             = $product->learnpress;

                if( !is_object(LP()->cart ) || !method_exists( LP()->cart, 'add_to_cart' ) || false === LP()->cart )  :
                    LP()->cart = new \LP_Cart(); // Call the class directly
                endif;

                LP()->cart->empty_cart(); // empty cart

                foreach( (array) $courses as $course_id ) :
                    LP()->cart->add_to_cart( $course_id );
                endforeach;

                $learnpress_order_id       = LP()->checkout()->create_order();
                $product->learnpress_order = $learnpress_order_id;

                add_post_meta( $order_data, 'learnpress_order', $product->learnpress_order );

                if ( $learnpress_order = learn_press_get_order( $learnpress_order_id ) ) :
                    $learnpress_order->update_status( 'completed' );
                    $learnpress_order->save();
                endif;

            endforeach;

        else:

            $learnpress_order_id = intval( $learnpress_order );

            if ( $learnpress_order = learn_press_get_order( $learnpress_order_id ) ) :
                $learnpress_order->update_status( 'completed' );
                $learnpress_order->save();
            endif;

        endif;

    }

    /**
     * Cancel learnpress order
     * @since   1.0.0
     * @param   array  $order_data [description]
     * @return  void
     */
    public function cancel_learnpress_order( $order_data ) {

        $learnpress_order    = get_post_meta( $order_data, 'learnpress_order', true );
        $learnpress_order_id = intval( $learnpress_order );

        if ( $learnpress_order = learn_press_get_order( $learnpress_order_id ) ) :
            $learnpress_order->update_status( 'pending' );
            $learnpress_order->save();
        endif;

    }

}