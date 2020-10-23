<?php

namespace HPY\CS\Settings;

/**
 * The admin-options of the plugin.
 *
 * @link       http://happykite.co.uk
 * @since      1.0
 *
 * @package    HPY_CS
 * @subpackage HPY_CS/classes
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    HPY_CS
 * @subpackage HPY_CS/classes
 * @author     HappyKite <mike@happykite.co.uk>
 */

class HPY_CS_Admin {

	public static function init() {
		//Add a new section to the Products settings page then add out required fields.
		add_filter( 'woocommerce_get_sections_products', __CLASS__ . '::add_settings_tab' );
		add_filter( 'woocommerce_get_settings_products', __CLASS__ . '::get_settings', 10, 2 );
		add_filter( 'wc_add_to_cart_message_html', __CLASS__ . '::modify_cs_text' );
	}

	/**
	 * Add a new settings tab to the WooCommerce settings tabs array.
	 *
	 * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
	 * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
	 */
	public static function add_settings_tab( $sections ) {
		$sections['hpy_cs'] = __( 'Continue Shopping', 'continue-shopping-for-woocommerce' );
		return $sections;
	}

	/**
	 * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
	 *
	 * @return array Array of settings for @see woocommerce_admin_fields() function.
	 */
	public static function get_settings( $settings, $current_section ) {
		$redirect_to_cart = get_option( 'woocommerce_cart_redirect_after_add' );
		$continue_destination = get_option( 'hpy_cs_destination' );
		$custom_link = get_option( 'hpy_cs_custom_link' );

		//Check for the current section, if it is our newly created section add our new fields, otherwise continue with the WooCommerce settings.
		if ( $current_section == 'hpy_cs' ) {

			$settings_cs = array();

			if ( $redirect_to_cart == 'yes' ) {
				$settings_cs[] = array(
					'title' => __( 'Continue Shopping Settings', 'continue-shopping-for-woocommerce' ),
					'type'  => 'title',
					'id'    => 'hpy_cs_title'
				);
			}else {
				$settings_cs[] = array(
					'title' => __( 'Continue Shopping Settings', 'continue-shopping-for-woocommerce' ),
					'type'  => 'title',
					'desc'  => '<div class="hpy-cs-error"><p><strong>Please Note</strong>: Continue Shopping only appears when WooCommerce is set to Redirect to the cart page after successful addition. This option can be changed <a href="' . get_site_url() . '/wp-admin/admin.php?page=wc-settings&tab=products&section=display">here</a></p></div>',
					'id'    => 'hpy_cs_title'
				);
			}

			$settings_cs[] = array(
				'title'           => __( 'Continue Shopping Destination', 'continue-shopping-for-woocommerce' ),
				'id'              => 'hpy_cs_destination',
				'default'         => 'home',
				'type'            => 'radio',
				'options'         => array(
					'home'        => __( 'Back to the Home Page', 'continue-shopping-for-woocommerce' ),
					'shop'        => __( 'Back to the Shop', 'continue-shopping-for-woocommerce' ),
					'recent_prod' => __( 'Jump back to the most recently viewed Product', 'continue-shopping-for-woocommerce' ),
					'recent_cat'  => __( 'Jump back to the most recently viewed Category', 'continue-shopping-for-woocommerce' ),
					'custom'      => __( 'Choose your own link (Best used to redirect to a landing page)', 'continue-shopping-for-woocommerce' ),
				),
				'autoload'        => false,
				'desc_tip'        => true,
				'show_if_checked' => 'option',
			);

			if ( $continue_destination == 'custom' ) {
				$settings_cs[] = array(
					'title'       => __( 'Custom Link', 'continue-shopping-for-woocommerce' ),
					'id'          => 'hpy_cs_custom_link',
					'desc_tip'    => true,
					'desc'        => 'Please enter the link you want to redirect to',
					'type'        => 'text',
				);
			}

			if ( $continue_destination == 'custom' && ( empty( $custom_link ) || !isset( $custom_link ) ) ) {
				$settings_cs[] = array(
					'type'        => 'title',
					'desc'        => '<div class="error"><p>You have Custom Link chosen however you have not set a Custom Link. Please enter it below.</p></div>',
					'id'          => 'hpy_cs_empty_link'
				);
			}
			
			$settings_cs[] = array(
				'title'       => __( 'Continue Shopping Text', 'continue-shopping-for-woocommerce' ),
				'id'          => 'hpy_cs_custom_text',
				'desc_tip'    => true,
				'desc'        => 'Change the default text for every \'Continue Shopping\' button',
				'type'        => 'text',
				'default'     => 'Continue Shopping',
				'placeholder' => 'Continue Shopping'
			);
			
			$settings_cs[] = array(
				'title'       => __( 'Display notice', 'continue-shopping-for-woocommerce' ),
				'label'		  => __( 'Always show on Empty Cart?', 'continue-shopping-for-woocommerce' ),
				'id'          => 'hpy_cs_empty_cart_notice',
				'desc_tip'    => true,
				'desc'        => 'This will display if the Cart is empty. It will prompt the user to head to the selected option above.',
				'type'        => 'checkbox',
			);

			$settings_cs[] = array(
				'title'       => __( 'Empty Cart Text', 'continue-shopping-for-woocommerce' ),
				'id'          => 'hpy_cs_empty_cart_text',
				'desc_tip'    => true,
				'desc'        => 'This will display if the Cart is empty. It will prompt the user to head to the selected option above.',
				'type'        => 'text',
			);
			
			$settings_cs[] = array(
				'title'       => __( 'Cart Button', 'continue-shopping-for-woocommerce' ),
				'label'		  => __( 'Always show a Continue Shopping Link?', 'continue-shopping-for-woocommerce' ),
				'id'          => 'hpy_cs_permanent_cart_notice',
				'desc_tip'    => true,
				'desc'        => 'Add a Continue Shopping button next to the Update Cart button. This button will link the customer to the selected option above',
				'type'        => 'checkbox',
			);
			
			$settings_cs[] = array(
				'title'       => __( 'Replace Cart Update', 'continue-shopping-for-woocommerce' ),
				'label'		  => __( 'Always show a Continue Shopping Link?', 'continue-shopping-for-woocommerce' ),
				'id'          => 'hpy_cs_trigger_on_update',
				'desc_tip'    => true,
				'desc'        => 'Replace the default Cart Updated banner with the Continue Shopping notice.',
				'type'        => 'checkbox',
			);

			$settings_cs[] = array( 'type' => 'sectionend', 'id' => 'shipping_options' );

			return $settings_cs;
		} else {
			return $settings;
		}
	}

	public static function hpy_save_recent_category( $referrer ) {
		delete_transient( 'recent_cat' );
		set_transient( 'recent_cat', $referrer, 60*60*12 );

		return;
	}
	
	public static function modify_cs_text( $message ) {
		
		if ( strpos( $message, 'Continue shopping' ) !== false ) {
			$message = str_replace("Continue shopping", self::hpy_cs_get_continue_shopping_text(), $message);
		}
		return $message;
		
	}
	
	public static function hpy_cs_get_continue_shopping_text() {
		$label = get_option( 'hpy_cs_custom_text' );
		$label = (!empty( $label )) ? $label : 'Continue Shopping';
		
		return apply_filters( 'hpy_cs_get_continue_shopping_text', $label );
	}

}

HPY_CS_Admin::init();