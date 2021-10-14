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
class Product {

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
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Add Sejowoo LearnPress Options Product tab
	 * Hooked via action woocommerce_product_data_tabs
	 * @since 	1.0.0
	 * @return 	void
	 */
    public function add_sejowoo_learnpress_product_data_tab( $original_tabs ) {

		$new_tab['sejowoolearnpress'] = array(
			'label'		=> __( 'Sejowoo LearnPress', 'sejowoo-learnpress' ),
			'target'	=> 'sejowoolearnpress_options',
			'class'		=> array( 'show_if_sejowoo_learnpress' ),
			//'priority'	=> 55, // Not yet
		);

		// Code to reposition
		$insert_at_position = 2; // This can be changed
		$tabs = array_slice( $original_tabs, 0, $insert_at_position, true ); // First part of original tabs
		$tabs = array_merge( $tabs, $new_tab ); // Add new
		$tabs = array_merge( $tabs, array_slice( $original_tabs, $insert_at_position, null, true ) ); // Glue the second part of original
		
		return $tabs;

	}

	/**
	 * Contents of The Sejowoo LearnPress Options Product Tab
	 * Hooked via action woocommerce_product_data_panels
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function add_sejowoo_learnpress_product_data_fields() {
		global $post;
?>
		<div id='sejowoolearnpress_options' class='panel woocommerce_options_panel'>
			<div class='options_group'>
<?php		
				$args = array(
				    'post_type' => 'lp_course',
				    'order'     => 'DESC'
				);              

				$options[''] = __( 'Select a Course', 'sejowoo-learnpress'); // default value
				$value[]     = '';

				$the_query = new \WP_Query( $args );
				if($the_query->have_posts() ) : 
				    while ( $the_query->have_posts() ) : 
				       $the_query->the_post(); 
				       $get_postName = get_the_title();
				       $get_postID   = get_the_ID();
				       $get_postLink = get_the_permalink();

				       $options[$get_postID] = $get_postName;
				       $value[$get_postID]   = $get_postID;
				    endwhile; 
				    wp_reset_postdata(); 
				endif;

				woocommerce_wp_select( array(
			        'id'      	  => '_select_course',
			        'label'   	  => __( 'LearnPress Course', 'sejowoo-learnpress' ),
			        'desc_tip'	  => 'true',
					'description' => __( 'Select LearnPress Course.', 'sejowoo-learnpress' ),
			        'options' 	  => $options, //this is where I am having trouble
			        'value'   	  => $value,
			    ) );
?>
			</div>
		</div>
<?php
	}

	/**
	 * Save Sejowoo LearnPress Product Data Fields
	 * Hooked via action woocommerce_process_product_meta_simple & woocommerce_process_product_meta_variable
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function save_sejowoo_learnpress_option_fields( $post_id ) {

		if ( isset( $_POST['_select_course'] ) ) :
			update_post_meta( $post_id, '_select_course', absint( $_POST['_select_course'] ) );
		endif;

		$is_sejowoo_learnpress = isset( $_POST['_sejowoo_learnpress'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_sejowoo_learnpress', $is_sejowoo_learnpress );

	}

	/**
	 * Add 'Sejowoo LearnPress' Product Option
	 * Hooked via action product_type_options
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function add_sejowoo_learnpress_product_option( $product_type_options ) {

		$product_type_options['sejowoo_learnpress'] = array(
			'id'            => '_sejowoo_learnpress',
			'wrapper_class' => 'show_if_simple show_if_variable',
			'label'         => __( 'Sejowoo LearnPress', 'sejowoo-learnpress' ),
			'description'   => __( 'Sejowoo LearnPress allow users to create product type LearnPress course.', 'sejowoo-learnpress' ),
			'default'       => 'no'
		);

		return $product_type_options;

	}

}
