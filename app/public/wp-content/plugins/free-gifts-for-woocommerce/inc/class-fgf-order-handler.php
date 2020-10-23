<?php

/**
 * Handles the Order.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly
}

if ( ! class_exists( 'FGF_Order_Handler' ) ) {
	/*
	 * Class
	 */

	class FGF_Order_Handler {

		/**
		 * Class Initialization.
		 */
		public static function init() {
			// update order meta.
			add_action( 'woocommerce_checkout_create_order_line_item' , array( __CLASS__ , 'adjust_order_item' ) , 10 , 4 ) ;
			// create master logs.
			add_action( 'woocommerce_checkout_update_order_meta' , array( __CLASS__ , 'create_master_logs' ) , 1 ) ;
			// Remove Order Item Meta key.
			add_action( 'woocommerce_hidden_order_itemmeta' , array( __CLASS__ , 'hide_order_item_meta_key' ) , 10 , 2 ) ;
		}

		/*
		 * Adjust order item meta
		 */

		public static function adjust_order_item( $item, $cart_item_key, $values, $order ) {
			if ( ! isset( $values[ 'fgf_gift_product' ] ) ) {
				return ;
			}

			// Update order item meta.
			$item->add_meta_data( '_fgf_gift_product' , 'yes' ) ;
			$item->add_meta_data( '_fgf_gift_rule_id' , $values[ 'fgf_gift_product' ][ 'rule_id' ] ) ;
			$item->add_meta_data( '_fgf_gift_rule_mode' , $values[ 'fgf_gift_product' ][ 'mode' ] ) ;

			$type       = get_option( 'fgf_settings_free_gift_cart_item_type_localization' , esc_html__( 'Type' , 'free-gifts-for-woocommerce' ) ) ;
			$type_value = get_option( 'fgf_settings_free_gift_cart_item_type_value_localization' , esc_html__( 'Free Product' , 'free-gifts-for-woocommerce' ) ) ;

			$item->add_meta_data( $type , $type_value ) ;
		}

		/**
		 * Create Master Logs.
		 * */
		public static function create_master_logs( $order_id ) {
			$order           = wc_get_order( $order_id ) ;
			$rule_ids        = array() ;
			$product_details = array() ;

			foreach ( $order->get_items() as $key => $value ) {

				if ( ! isset( $value[ 'fgf_gift_product' ] ) ) {
					continue ;
				}

				$product_id = ! empty( $value[ 'variation_id' ] ) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
				$product    = wc_get_product( $product_id ) ;
				$rule_ids[] = $value[ 'fgf_gift_rule_id' ] ;

				// Prepare product details
				$product_details[] = array(
					'product_id'    => $product_id ,
					'product_name'  => $product->get_name() ,
					'product_price' => $product->get_price() ,
					'quantity'      => $value[ 'quantity' ] ,
					'rule_id'       => $value[ 'fgf_gift_rule_id' ] ,
					'mode'          => $value[ 'fgf_gift_rule_mode' ]
						) ;

				// Update rule usage count
				$rule_usage_count = floatval( get_post_meta( $value[ 'fgf_gift_rule_id' ] , 'fgf_rule_usage_count' , true ) ) ;
				update_post_meta( $value[ 'fgf_gift_rule_id' ] , 'fgf_rule_usage_count' , ++ $rule_usage_count ) ;
			}

			if ( ! fgf_check_is_array( $rule_ids ) ) {
				return ;
			}

			$meta_data = array(
				'fgf_product_details' => $product_details ,
				'fgf_rule_ids'        => $rule_ids ,
				'fgf_user_name'       => $order->get_formatted_billing_full_name() ,
				'fgf_user_email'      => $order->get_billing_email() ,
				'fgf_order_id'        => $order_id ,
					) ;

			// create a master log
			$master_log_id = fgf_create_new_master_log(
					$meta_data , array(
				'post_parent' => $order->get_customer_id() ,
				'post_status' => 'fgf_automatic' ,
					)
					) ;

			add_post_meta( $order_id , 'fgf_automatic_gift_product' , $master_log_id ) ;

			return $master_log_id ;
		}

		/**
		 * Hidden Custom Order item meta.
		 * */
		public static function hide_order_item_meta_key( $hidden_order_itemmeta ) {

			$custom_order_itemmeta = array( '_fgf_gift_product' , '_fgf_gift_rule_id' , '_fgf_gift_rule_mode' ) ;

			return array_merge( $hidden_order_itemmeta , $custom_order_itemmeta ) ;
		}

	}

	FGF_Order_Handler::init() ;
}
