<?php

/**
 *  Handles the notices.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}
if ( ! class_exists( 'FGF_Notices_Handler' ) ) {

	/**
	 * Class
	 */
	class FGF_Notices_Handler {

		/**
		 * Class Initialization.
		 */
		public static function init() {

			if ( '2' == get_option( 'fgf_settings_display_notice_mode' ) ) {
				// May be show the gift products notices in cart.
				add_action( 'woocommerce_before_cart' , array( __CLASS__ , 'maybe_show_cart_notices' ) ) ;
				// May be show the gift products notices in checkout.
				add_action( 'woocommerce_before_checkout_form' , array( __CLASS__ , 'maybe_show_checkout_notices' ) ) ;
				// May be display the eligible gift products notice in the cart.
				add_action( 'woocommerce_before_cart' , array( __CLASS__ , 'maybe_show_cart_gift_products_eligible_notice' ) ) ;
				// May be display the eligible gift products notice in the checkout.
				add_action( 'woocommerce_before_checkout_form' , array( __CLASS__ , 'maybe_show_checkout_gift_products_eligible_notice' ) ) ;
			} else {
				// May be show the gift products notices in cart/checkout.
				add_action( 'wp' , array( __CLASS__ , 'maybe_show_gift_notices' ) ) ;
				// May be show the gift products notices in cart via ajax.
				add_action( 'woocommerce_before_cart' , array( __CLASS__ , 'maybe_show_gift_notices_ajax' ) ) ;
				// May be show the gift products notices in checkout via ajax.
				add_action( 'woocommerce_review_order_before_cart_contents' , array( __CLASS__ , 'maybe_show_gift_notices_ajax' ) ) ;
			}
		}

		/**
		 * May be show the gift products notices in cart/checkout.
		 * 
		 * @return void
		 * 
		 * */
		public static function maybe_show_gift_notices() {

			if ( isset( $_REQUEST[ 'payment_method' ] ) || isset( $_REQUEST[ 'woocommerce-cart-nonce' ] ) ) {
				return ;
			}

			if ( is_cart() ) {
				// May be show the gift products notices in cart.
				self::maybe_show_cart_notices() ;

				// May be display the eligible gift products notice in the cart.
				self::maybe_show_cart_gift_products_eligible_notice() ;
			}

			if ( is_checkout() ) {
				// May be show the gift products notices in checkout.
				self::maybe_show_checkout_notices() ;

				// May be display the eligible gift products notice in the checkout.
				self::maybe_show_checkout_gift_products_eligible_notice() ;
			}
		}

		/**
		 * May be show the gift products notices in cart/checkout via ajax.
		 * 
		 * @return void
		 * 
		 * */
		public static function maybe_show_gift_notices_ajax() {

			if ( ! isset( $_REQUEST[ 'payment_method' ] ) && ! isset( $_REQUEST[ 'woocommerce-cart-nonce' ] ) ) {
				return ;
			}

			if ( is_cart() ) {
				// May be show the gift products notices in cart.
				self::maybe_show_cart_notices() ;

				// May be display the eligible gift products notice in the cart.
				self::maybe_show_cart_gift_products_eligible_notice() ;
			}

			if ( is_checkout() ) {
				// May be show the gift products notices in checkout.
				self::maybe_show_checkout_notices() ;

				// May be display the eligible gift products notice in the checkout.
				self::maybe_show_checkout_gift_products_eligible_notice() ;
			}
		}

		/**
		 * Is valid to show the notice?.
		 * 
		 * @return bool.
		 * */
		public static function is_valid_show_notice() {
			// Return if the cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return false ;
			}

			// Return if the cart is empty.
			if ( WC()->cart->get_cart_contents_count() == 0 ) {
				return false ;
			}

			// Return if the gift products order count exists. 
			if ( FGF_Rule_Handler::check_per_order_count_exists() ) {
				return false ;
			}

			$gift_products = FGF_Rule_Handler::get_manual_gift_products() ;
			if ( ! fgf_check_is_array( $gift_products ) ) {
				return false ;
			}

			return apply_filters( 'fgf_is_valid_notice' , true ) ;
		}

		/**
		 * May be show the gift products notices in cart.
		 * 
		 * @return void
		 * */
		public static function maybe_show_cart_notices() {
			// Check is valid to show the cart notices.
			if ( ! apply_filters( 'fgf_is_valid_show_cart_notice' , self::is_valid_show_notice() ) ) {
				return ;
			}

			// Popup Notice.
			if ( '2' == get_option( 'fgf_settings_gift_cart_page_display' ) ) {
				$popup_link = '<a href="#" class="fgf-popup-gift-products">' . get_option( 'fgf_settings_free_gift_popup_link_message' ) . '</a>' ;
				$notice     = str_replace( '[popup_link]' , $popup_link , get_option( 'fgf_settings_free_gift_popup_notice_message' ) ) ;

				self::show_notice( $notice ) ;
			} else {
				// Display the cart page gift products notice.
				self::show_notice( get_option( 'fgf_settings_free_gift_notice_message' ) ) ;
			}
		}

		/**
		 * May be show the gift products notices in checkout.
		 * 
		 * @return void.
		 * */
		public static function maybe_show_checkout_notices() {
			// Check is valid to show the checkout notices.
			if ( ! apply_filters( 'fgf_is_valid_show_checkout_notice' , self::is_valid_show_notice() ) ) {
				return ;
			}

			// Checkout Notice.
			if ( 'yes' == get_option( 'fgf_settings_enable_checkout_free_gift_notice' ) && fgf_get_free_gift_products_count_in_cart() <= 0 ) {
				$cart_page_url = sprintf( '<a class="fgf_forward_link" href="%s">%s</a>' , wc_get_cart_url() , get_option( 'fgf_settings_checkout_free_gift_notice_shortcode_message' ) ) ;
				$notice        = str_replace( '[cart_page]' , $cart_page_url , get_option( 'fgf_settings_checkout_free_gift_notice_message' ) ) ;

				// Show the checkout page gift products notice.
				self::show_notice( $notice ) ;
			}

			// Popup Notice.
			if ( '2' == get_option( 'fgf_settings_gift_checkout_page_display' ) ) {
				$popup_link = '<a href="#" class="fgf-popup-gift-products">' . get_option( 'fgf_settings_free_gift_popup_link_message' ) . '</a>' ;
				$notice     = str_replace( '[popup_link]' , $popup_link , get_option( 'fgf_settings_free_gift_popup_notice_message' ) ) ;

				self::show_notice( $notice ) ;
			}
		}

		/**
		 * Is valid to show the eligible notice?.
		 * 
		 * @return bool.
		 * */
		public static function is_valid_show_eligible_notice() {
			// Return if the cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return false ;
			}

			// Return if the cart is empty.
			if ( WC()->cart->get_cart_contents_count() == 0 ) {
				return false ;
			}

			// Return if the gift products order count exists. 
			if ( FGF_Rule_Handler::check_per_order_count_exists() ) {
				return false ;
			}

			$cart_notices = FGF_Rule_Handler::get_cart_notices() ;
			if ( ! fgf_check_is_array( $cart_notices ) ) {
				return false ;
			}

			return apply_filters( 'fgf_is_valid_eligible_notice' , true ) ;
		}

		/**
		 * Maybe display the eligible gift products notice in the cart.
		 * 
		 * @return void
		 * */
		public static function maybe_show_cart_gift_products_eligible_notice() {

			$display_type = get_option( 'fgf_settings_display_cart_notices_type' ) ;

			if ( '3' == $display_type ) {
				return ;
			}

			// Check if the valid to show the cart eligible notices.
			if ( ! apply_filters( 'fgf_is_valid_show_cart_eligible_notice' , self::is_valid_show_eligible_notice() ) ) {
				return ;
			}

			$cart_notices = FGF_Rule_Handler::get_cart_notices() ;

			foreach ( $cart_notices as $cart_notice ) {
				// Display the eligible gift product notice.
				self::show_notice( $cart_notice , 'notice' ) ;
			}
		}

		/**
		 * Maybe display the eligible gift products notice in the checkout.
		 * 
		 * @return void
		 * */
		public static function maybe_show_checkout_gift_products_eligible_notice() {

			$display_type = get_option( 'fgf_settings_display_cart_notices_type' ) ;

			if ( '2' == $display_type ) {
				return ;
			}

			// Check if the valid to show the checkout eligible notices.
			if ( ! apply_filters( 'fgf_is_valid_show_checkout_eligible_notice' , self::is_valid_show_eligible_notice() ) ) {
				return ;
			}

			$cart_notices = FGF_Rule_Handler::get_cart_notices() ;

			foreach ( $cart_notices as $cart_notice ) {
				// Display the eligible gift product notice.
				self::show_notice( $cart_notice , 'notice' ) ;
			}
		}

		/**
		 * Show the notice.
		 * 
		 * @return void
		 * */
		public static function show_notice( $notice, $type = 'success' ) {
			if ( '2' == get_option( 'fgf_settings_display_notice_mode' ) ) {
				$notices = array( 'notice' =>
					array(
						'notice' => $notice ,
						'data'   => array()
					)
						) ;

				fgf_get_template( 'notices/' . $type . '.php' , $notices ) ;
			} else {
				wc_add_notice( $notice ) ;
			}
		}

	}

	FGF_Notices_Handler::init() ;
}
