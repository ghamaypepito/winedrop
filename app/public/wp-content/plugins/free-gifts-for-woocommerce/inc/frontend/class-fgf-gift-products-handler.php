<?php

/**
 *  Handles Free Gift Products
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}
if ( ! class_exists( 'FGF_Gift_Products_Handler' ) ) {

	/**
	 * Class
	 */
	class FGF_Gift_Products_Handler {

		/**
		 * Class Initialization.
		 */
		public static function init() {
			// Free automatic gift products add to cart.
			add_action( 'wp' , array( __CLASS__ , 'add_to_cart_automatic_gift_product' ) ) ;
			// BOGO gift products add to cart.
			add_action( 'wp' , array( __CLASS__ , 'add_to_cart_bogo_gift_product' ) ) ;
			// Free gift products add to cart
			add_action( 'wp' , array( __CLASS__ , 'add_to_cart_manual_gift_product' ) ) ;
			// remove gift products from cart
			add_action( 'wp' , array( __CLASS__ , 'remove_gift_product_from_cart' ) ) ;
			// Free gift products add to cart via cart ajax.
			add_action( 'woocommerce_before_cart' , array( __CLASS__ , 'add_to_cart_automatic_gift_product_ajax' ) ) ;
			// BOGO gift products add to cart via cart ajax.
			add_action( 'woocommerce_before_cart' , array( __CLASS__ , 'add_to_cart_bogo_gift_product_ajax' ) ) ;
			// Free gift products add to cart via cart ajax.
			add_action( 'woocommerce_before_cart' , array( __CLASS__ , 'remove_gift_product_from_cart_ajax' ) ) ;
			// Free gift products add to cart via checkout ajax.
			add_action( 'woocommerce_review_order_before_cart_contents' , array( __CLASS__ , 'add_to_cart_automatic_gift_product_ajax' ) ) ;
			// BOGO gift products add to cart via checkout ajax.
			add_action( 'woocommerce_review_order_before_cart_contents' , array( __CLASS__ , 'add_to_cart_bogo_gift_product_ajax' ) ) ;
			// Free gift products add to cart via checkout ajax.
			add_action( 'woocommerce_review_order_before_cart_contents' , array( __CLASS__ , 'remove_gift_product_from_cart_ajax' ) ) ;
			// Display gifts products in checkout page.
			add_action( 'woocommerce_checkout_order_review' , array( __CLASS__ , 'display_gift_products' ) ) ;
			// Display gifts products in cart table
			add_action( 'woocommerce_after_cart_table' , array( __CLASS__ , 'display_gift_products' ) ) ;
			// Display cart item data
			add_action( 'woocommerce_get_item_data' , array( __CLASS__ , 'maybe_add_custom_item_data' ) , 10 , 2 ) ;
			// remove gift products from cart when cart is empty
			add_action( 'woocommerce_cart_item_removed' , array( __CLASS__ , 'remove_gift_product_cart_empty' ) , 10 , 2 ) ;
			// set price for gift product
			add_action( 'woocommerce_before_calculate_totals' , array( __CLASS__ , 'set_price' ) , 9999 , 1 ) ;
			// Remove the Shipping for gift product.
			add_filter( 'woocommerce_cart_shipping_packages' , array( __CLASS__ , 'alter_shipping_packages' ) , 10 , 1 ) ;
			// Handles the cart item remove link.
			add_filter( 'woocommerce_cart_item_remove_link' , array( __CLASS__ , 'handles_cart_item_remove_link' ) , 10 , 2 ) ;
			// Set cart item price
			add_filter( 'woocommerce_cart_item_price' , array( __CLASS__ , 'set_cart_item_price' ) , 10 , 3 ) ;
			// set cart quantity in cart page when product is gift product
			add_filter( 'woocommerce_cart_item_quantity' , array( __CLASS__ , 'set_cart_item_quantity' ) , 10 , 2 ) ;
			// Set cart item subtotal
			add_filter( 'woocommerce_cart_item_subtotal' , array( __CLASS__ , 'set_cart_item_subtotal' ) , 10 , 3 ) ;
			// Alter the cart contents order.
			add_filter( 'woocommerce_cart_contents_changed' , array( __CLASS__ , 'alter_cart_contents_order' ) , 10 , 1 ) ;
		}

		/**
		 * Remove Gift products from cart.
		 * 
		 * @return mixed
		 * */
		public static function remove_gift_product_from_cart() {
			if ( isset( $_REQUEST[ 'payment_method' ] ) || isset( $_REQUEST[ 'woocommerce-cart-nonce' ] ) ) {
				return ;
			}

			self::remove_gift_products() ;
		}

		/**
		 * Remove Gift products from cart via ajax.
		 * 
		 * @return mixed
		 * */
		public static function remove_gift_product_from_cart_ajax() {
			if ( ! isset( $_REQUEST[ 'payment_method' ] ) && ! isset( $_REQUEST[ 'woocommerce-cart-nonce' ] ) ) {
				return ;
			}

			self::remove_gift_products() ;
		}

		/**
		 * Add to automatic gift product in cart via ajax.
		 * 
		 * @return mixed
		 * */
		public static function add_to_cart_automatic_gift_product_ajax() {

			if ( ! isset( $_REQUEST[ 'payment_method' ] ) && ! isset( $_REQUEST[ 'woocommerce-cart-nonce' ] ) ) {
				return ;
			}

			self::automatic_gift_product( false ) ;
		}

		/**
		 * Add to automatic gift product in cart.
		 * 
		 * @return mixed
		 * */
		public static function add_to_cart_automatic_gift_product() {

			if ( isset( $_REQUEST[ 'payment_method' ] ) || isset( $_REQUEST[ 'woocommerce-cart-nonce' ] ) ) {
				return ;
			}

			self::automatic_gift_product() ;
		}

		/**
		 * Add to BOGO product in cart via ajax.
		 * 
		 * @return mixed
		 * */
		public static function add_to_cart_bogo_gift_product_ajax() {

			if ( ! isset( $_REQUEST[ 'payment_method' ] ) && ! isset( $_REQUEST[ 'woocommerce-cart-nonce' ] ) ) {
				return ;
			}

			self::bogo_gift_product( false ) ;
		}

		/**
		 * Add to BOGO product in cart.
		 * 
		 * @return mixed
		 * */
		public static function add_to_cart_bogo_gift_product() {

			if ( isset( $_REQUEST[ 'payment_method' ] ) || isset( $_REQUEST[ 'woocommerce-cart-nonce' ] ) ) {
				return ;
			}

			self::bogo_gift_product() ;
		}

		/*
		 * Display Gift Products in after cart table
		 */

		public static function display_gift_products() {
			// Hide table if gift products per order count exists
			if ( FGF_Rule_Handler::check_per_order_count_exists() ) {
				return ;
			}

			// Return if data args does not exists.
			$data_args = self::get_gift_product_data() ;
			if ( ! $data_args ) {
				return ;
			}

			if ( is_checkout() || '2' == get_option( 'fgf_settings_gift_cart_page_display' ) ) {
				// Display Gift Products popup layout.
				fgf_get_template( 'popup-layout.php' , array( 'data_args' => $data_args ) ) ;
			} else {
				// Display Gift Products layout
				fgf_get_template( $data_args[ 'template' ] , $data_args ) ;
			}
		}

		/**
		 *  Get Gift Product Data
		 */
		public static function get_gift_product_data() {
			$gift_products = FGF_Rule_Handler::get_manual_gift_products() ;
			if ( ! fgf_check_is_array( $gift_products ) ) {
				return false ;
			}

			$display_type = get_option( 'fgf_settings_gift_display_type' ) ;

			switch ( $display_type ) {
				case '3':
					$data_args = array(
						'template'      => 'dropdown-layout.php' ,
						'gift_products' => $gift_products ,
							) ;
					break ;

				case '2':
					$data_args = array(
						'template'      => 'carousel-layout.php' ,
						'gift_products' => $gift_products ,
							) ;
					break ;

				default:
					$per_page     = fgf_get_free_gifts_per_page_column_count() ;
					$current_page = 1 ;

					/* Calculate Page Count */
					$default_args[ 'posts_per_page' ] = $per_page ;
					$default_args[ 'offset' ]         = ( $current_page - 1 ) * $per_page ;
					$page_count                       = ceil( count( $gift_products ) / $per_page ) ;

					$data_args = array(
						'template'      => 'gift-products-layout.php' ,
						'gift_products' => array_slice( $gift_products , $default_args[ 'offset' ] , $per_page ) ,
						'pagination'    => array(
							'page_count'      => $page_count ,
							'current_page'    => $current_page ,
							'next_page_count' => ( ( $current_page + 1 ) > ( $page_count - 1 ) ) ? ( $current_page ) : ( $current_page + 1 ) ,
						) ,
							) ;
					break ;
			}

			return $data_args ;
		}

		/**
		 *  Maybe add custom item data
		 */
		public static function maybe_add_custom_item_data( $item_data, $cart_item ) {
			if ( ! isset( $cart_item[ 'fgf_gift_product' ] ) || ! fgf_check_is_array( $cart_item[ 'fgf_gift_product' ] ) ) {
				return $item_data ;
			}

			$type_label    = get_option( 'fgf_settings_free_gift_cart_item_type_localization' , esc_html__( 'Type' , 'free-gifts-for-woocommerce' ) ) ;
			$display_label = get_option( 'fgf_settings_free_gift_cart_item_type_value_localization' , esc_html__( 'Free Product' , 'free-gifts-for-woocommerce' ) ) ;

			if ( empty( $type_label ) && empty( $display_label ) ) {
				return $item_data ;
			}

			$item_data[] = array(
				'name'    => $type_label ,
				'display' => $display_label ,
					) ;

			return $item_data ;
		}

		/**
		 * Add to gift product in cart.
		 */
		public static function add_to_cart_manual_gift_product() {

			if ( ! isset( $_GET[ 'fgf_gift_product' ] ) || ! isset( $_GET[ 'fgf_rule_id' ] ) ) {
				return ;
			}

			// Return if cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return ;
			}

			// return if cart is empty
			if ( WC()->cart->get_cart_contents_count() == 0 ) {
				return ;
			}

			// Restrict Adding gift product if gift products per order count exists
			if ( FGF_Rule_Handler::check_per_order_count_exists() ) {
				return ;
			}

			$product_id = absint( $_GET[ 'fgf_gift_product' ] ) ;
			$rule_id    = absint( $_GET[ 'fgf_rule_id' ] ) ;

			// Check is valid rule
			if ( ! FGF_Rule_Handler::rule_product_exists( $rule_id , $product_id ) ) {
				return ;
			}

			$rule    = fgf_get_rule( $rule_id ) ;
			$product = wc_get_product( $product_id ) ;

			// return if product id is not proper product
			if ( ! $product ) {
				return ;
			}

			// return if rule id is not proper rule
			if ( ! $rule->exists() ) {
				return ;
			}

			$cart_item_data = array(
				'fgf_gift_product' => array(
					'mode'       => 'manual' ,
					'rule_id'    => $rule_id ,
					'product_id' => $product_id ,
					'price'      => 0 ,
				) ,
					) ;

			// Add to Gift product in cart
			WC()->cart->add_to_cart( $product_id , '1' , 0 , array() , $cart_item_data ) ;

			// Success Notice
			wc_add_notice( get_option( 'fgf_settings_free_gift_success_message' ) ) ;

			// Safe Redirect
			wp_safe_redirect( get_permalink() ) ;
			exit() ;
		}

		/**
		 * Add to automatic gift product in cart.
		 * 
		 * @return mixed
		 * */
		public static function automatic_gift_product( $redirect = true ) {
			// Return if cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return ;
			}

			// Return if cart is empty.
			if ( WC()->cart->get_cart_contents_count() == 0 ) {
				return ;
			}

			// Restrict Adding gift product if gift products per order count exists.
			if ( FGF_Rule_Handler::check_per_order_count_exists() ) {
				return ;
			}

			$automatic_gift_products = FGF_Rule_Handler::get_automatic_gift_products() ;
			if ( ! fgf_check_is_array( $automatic_gift_products ) ) {
				return ;
			}

			$products_added                  = false ;
			$free_products_cart_count        = fgf_get_free_gift_products_count_in_cart( true ) ;
			$free_gifts_products_order_count = floatval( get_option( 'fgf_settings_gifts_count_per_order' ) ) ;

			foreach ( $automatic_gift_products as $key => $automatic_gift_product ) {

				// Return if order count exists.
				if ( $free_gifts_products_order_count && $free_products_cart_count >= $free_gifts_products_order_count ) {
					break ;
				}

				// Check is valid rule.
				if ( ! FGF_Rule_Handler::rule_product_exists( $automatic_gift_product[ 'rule_id' ] , $automatic_gift_product[ 'product_id' ] , true ) ) {
					continue ;
				}

				// Return If already added this product in cart.
				if ( $automatic_gift_product[ 'hide_add_to_cart' ] ) {
					continue ;
				}

				$rule    = fgf_get_rule( $automatic_gift_product[ 'rule_id' ] ) ;
				$product = wc_get_product( $automatic_gift_product[ 'product_id' ] ) ;

				// Return if product id is not proper product.
				if ( ! $product ) {
					return ;
				}

				// Return if rule id is not proper rule.
				if ( ! $rule->exists() ) {
					return ;
				}

				$cart_item_data = array(
					'fgf_gift_product' => array(
						'mode'       => 'automatic' ,
						'rule_id'    => $automatic_gift_product[ 'rule_id' ] ,
						'product_id' => $automatic_gift_product[ 'product_id' ] ,
						'price'      => 0 ,
						'qty'        => $automatic_gift_product[ 'qty' ] ,
					) ,
						) ;

				$products_added = true ;

				$free_products_cart_count ++ ;

				// Add to Gift product in cart
				WC()->cart->add_to_cart( $automatic_gift_product[ 'product_id' ] , $automatic_gift_product[ 'qty' ] , 0 , array() , $cart_item_data ) ;
			}

			if ( $products_added ) {
				// Success Notice.
				wc_add_notice( get_option( 'fgf_settings_free_gift_automatic_success_message' ) ) ;

				if ( $redirect ) {
					// Safe Redirect.
					wp_safe_redirect( get_permalink() ) ;
					exit() ;
				}
			}
		}

		/**
		 * Add to BOGO gift product in cart.
		 * 
		 * @return mixed
		 * */
		public static function bogo_gift_product( $redirect = true ) {

			// Return if cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return ;
			}

			// Return if cart is empty.
			if ( WC()->cart->get_cart_contents_count() == 0 ) {
				return ;
			}

			$bogo_gift_products = FGF_Rule_Handler::get_bogo_gift_products() ;

			if ( ! fgf_check_is_array( $bogo_gift_products ) ) {
				return ;
			}

			$products_added = false ;

			foreach ( $bogo_gift_products as $key => $bogo_gift_product ) {

				// Return if already added this product in the cart.
				if ( $bogo_gift_product[ 'hide_add_to_cart' ] ) {
					continue ;
				}

				$rule    = fgf_get_rule( $bogo_gift_product[ 'rule_id' ] ) ;
				$product = wc_get_product( $bogo_gift_product[ 'product_id' ] ) ;

				// Return if product id is not a proper product.
				if ( ! $product ) {
					return ;
				}

				// Return if rule id is not proper rule.
				if ( ! $rule->exists() ) {
					return ;
				}

				$cart_item_data = array(
					'fgf_gift_product' => array(
						'mode'           => 'bogo' ,
						'rule_id'        => $bogo_gift_product[ 'rule_id' ] ,
						'product_id'     => $bogo_gift_product[ 'product_id' ] ,
						'buy_product_id' => $bogo_gift_product[ 'buy_product_id' ] ,
						'price'          => 0 ,
					) ,
						) ;

				$products_added = true ;

				// Add to Gift product in cart.
				WC()->cart->add_to_cart( $bogo_gift_product[ 'product_id' ] , $bogo_gift_product[ 'qty' ] , 0 , array() , $cart_item_data ) ;
			}

			if ( $products_added ) {
				// Success Notice.
				wc_add_notice( get_option( 'fgf_settings_free_gift_bogo_success_message' ) ) ;

				if ( $redirect ) {
					// Safe Redirect.
					wp_safe_redirect( get_permalink() ) ;
					exit() ;
				}
			}
		}

		/**
		 * Remove Gift products from cart.
		 * */
		public static function remove_gift_products() {
			// Return if cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return ;
			}

			$products_removed = false ;

			foreach ( WC()->cart->get_cart() as $key => $value ) {

				if ( ! isset( $value[ 'fgf_gift_product' ] ) ) {
					continue ;
				}

				switch ( $value[ 'fgf_gift_product' ][ 'mode' ] ) {
					case 'manual':
						$rule_qty = FGF_Rule_Handler::rule_product_exists( $value[ 'fgf_gift_product' ][ 'rule_id' ] , $value[ 'fgf_gift_product' ][ 'product_id' ] ) ;
						if ( ! $rule_qty ) {
							$products_removed = true ;

							// Remove gift products if not matched.
							WC()->cart->remove_cart_item( $key ) ;
						}
						break ;

					case 'automatic':
						$rule_qty = FGF_Rule_Handler::rule_product_exists( $value[ 'fgf_gift_product' ][ 'rule_id' ] , $value[ 'fgf_gift_product' ][ 'product_id' ] , true ) ;
						if ( ! $rule_qty ) {
							$products_removed = true ;

							// Remove gift products if not matched.
							WC()->cart->remove_cart_item( $key ) ;
						} elseif ( $rule_qty < $value[ 'quantity' ] ) {
							$products_removed = true ;

							// Update gift products quantity.
							WC()->cart->set_quantity( $key , $rule_qty ) ;
						}

						break ;

					case 'bogo':
						$rule_qty = FGF_Rule_Handler::get_bogo_rule_product_qty( $value[ 'fgf_gift_product' ] ) ;

						if ( ! $rule_qty ) {
							$products_removed = true ;

							// Remove gift products if not matched.
							WC()->cart->remove_cart_item( $key ) ;
						} elseif ( $rule_qty < $value[ 'quantity' ] ) {
							$products_removed = true ;

							// Update gift products quantity.
							WC()->cart->set_quantity( $key , $rule_qty ) ;
						}

						break ;
				}
			}

			// Error Notice
			if ( $products_removed ) {
				wc_add_notice( get_option( 'fgf_settings_free_gift_error_message' ) , 'notice' ) ;
			}
		}

		/**
		 * Remove Gift products from cart when cart is empty.
		 * */
		public static function remove_gift_product_cart_empty( $removed_cart_item_key, $cart ) {
			// Return if cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return ;
			}

			// return if cart is empty
			if ( WC()->cart->get_cart_contents_count() == 0 ) {
				return ;
			}

			$free_products_count = fgf_get_free_gift_products_count_in_cart() ;
			$cart_items_count    = WC()->cart->get_cart_contents_count() - $free_products_count ;

			// Return if products is exists
			if ( $cart_items_count ) {
				return ;
			}

			// Remove all gift products from cart.
			WC()->cart->empty_cart() ;

			// Error Notice.
			wc_add_notice( get_option( 'fgf_settings_free_gift_error_message' ) , 'notice' ) ;
		}

		/*
		 * Set custom price for Gift product
		 */

		public static function set_price( $cart_object ) {
			// Return if cart object is not initialized.
			if ( ! is_object( $cart_object ) ) {
				return ;
			}

			foreach ( $cart_object->cart_contents as $key => $value ) {
				if ( ! isset( $value[ 'fgf_gift_product' ] ) ) {
					continue ;
				}

				$value[ 'data' ]->set_price( $value[ 'fgf_gift_product' ][ 'price' ] ) ;
			}
		}

		/**
		 * Handles the cart item remove link.
		 */
		public static function handles_cart_item_remove_link( $remove_link, $cart_item_key ) {
			// Return if cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return $remove_link ;
			}

			$cart_items = WC()->cart->get_cart() ;

			// Check if the product is a gift product.
			if ( ! isset( $cart_items[ $cart_item_key ][ 'fgf_gift_product' ][ 'mode' ] ) ) {
				return $remove_link ;
			}

			// Return link if the product is a manual gift product.
			if ( 'manual' == $cart_items[ $cart_item_key ][ 'fgf_gift_product' ][ 'mode' ] ) {
				return $remove_link ;
			}

			return '' ;
		}

		/*
		 * Set cart item price
		 */

		public static function set_cart_item_price( $price, $cart_item, $cart_item_key ) {

			// check if product is a gift product
			if ( ! isset( $cart_item[ 'fgf_gift_product' ] ) ) {
				return $price ;
			}

			return self::get_gift_product_price( $price , $cart_item ) ;
		}

		/**
		 * Filter items needing shipping callback.
		 *
		 * @return bool
		 */
		public static function filter_items_needing_shipping( $item ) {
			// Return true,if the cart item is gift product.
			if ( ! isset( $item[ 'fgf_gift_product' ] ) ) {
				return true ;
			}

			return false ;
		}

		/**
		 * Get only items that need shipping.
		 *
		 * @return array
		 */
		public static function get_items_needing_shipping( $contents ) {
			return array_filter( $contents , array( __CLASS__ , 'filter_items_needing_shipping' ) ) ;
		}

		/**
		 * Remove the shipping for Gift product.
		 * 
		 * @return array
		 */
		public static function alter_shipping_packages( $packages ) {
			// Return if the cart packages is empty.
			if ( ! fgf_check_is_array( $packages ) ) {
				return $packages ;
			}

			foreach ( $packages as $package_key => $package ) {
				if ( ! isset( $package[ 'contents' ] ) || ! isset( $package[ 'contents_cost' ] ) ) {
					continue ;
				}

				// Get items needing shipping.
				$items_needing_shipping = self::get_items_needing_shipping( $packages[ $package_key ][ 'contents' ] ) ;

				// Alter shipping package. 
				$packages[ $package_key ][ 'contents' ]      = $items_needing_shipping ;
				$packages[ $package_key ][ 'contents_cost' ] = array_sum( wp_list_pluck( $items_needing_shipping , 'line_total' ) ) ;
			}

			return $packages ;
		}

		/*
		 * Set cart quantity as non editable in cart page
		 */

		public static function set_cart_item_quantity( $quantity, $cart_item_key ) {
			// Return if cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return $quantity ;
			}

			$cart_items = WC()->cart->get_cart() ;

			// check if product is a gift product
			if ( ! isset( $cart_items[ $cart_item_key ][ 'fgf_gift_product' ] ) ) {
				return $quantity ;
			}

			return $cart_items[ $cart_item_key ][ 'quantity' ] ;
		}

		/*
		 * Set cart item subtotal
		 */

		public static function set_cart_item_subtotal( $price, $cart_item, $cart_item_key ) {

			// check if product is a gift product
			if ( ! isset( $cart_item[ 'fgf_gift_product' ] ) ) {
				return $price ;
			}

			return self::get_gift_product_price( $price , $cart_item , true ) ;
		}

		/**
		 * Get the gift product price.
		 * 
		 * @return String
		 * */
		public static function get_gift_product_price( $price, $cart_item, $multiply_qty = false ) {

			// Check if the cart item is a gift product.
			if ( ! isset( $cart_item[ 'fgf_gift_product' ] ) ) {
				return $price ;
			}

			$product_id = ! empty( $cart_item[ 'variation_id' ] ) ? $cart_item[ 'variation_id' ] : $cart_item[ 'product_id' ] ;
			$product    = wc_get_product( $product_id ) ;
			if ( ! is_object( $product ) ) {
				return $price ;
			}

			$product_price = ( $multiply_qty ) ? ( float ) $cart_item[ 'quantity' ] * ( float ) $product->get_price() : $product->get_price() ;

			$price_display_type = get_option( 'fgf_settings_gift_product_price_display_type' ) ;
			if ( '2' == $price_display_type ) {
				$display_price = '<del>' . fgf_price( $product_price , false ) . '</del> <ins>' . fgf_price( 0 , false ) . '</ins>' ;
			} else {
				$display_price = esc_html__( 'Free' , 'free-gifts-for-woocommerce' ) ;
			}

			return $display_price ;
		}

		/**
		 * Alter the Cart contents order.
		 * 
		 * */
		public static function alter_cart_contents_order( $cart_contents ) {
			// Return the same cart content if contents is empty.
			if ( ! fgf_check_is_array( $cart_contents ) ) {
				return $cart_contents ;
			}

			// Return the same cart content if display cart order is disabled.
			if ( '2' != get_option( 'fgf_settings_gift_product_cart_display_order' ) ) {
				return $cart_contents ;
			}

			$other_cart_contents     = array() ;
			$free_gift_cart_contents = array() ;

			foreach ( $cart_contents as $key => $values ) {
				if ( isset( $values[ 'fgf_gift_product' ] ) ) {
					$free_gift_cart_contents[ $key ] = $values ;
				} else {
					$other_cart_contents[ $key ] = $values ;
				}
			}

			return array_merge( $other_cart_contents , $free_gift_cart_contents ) ;
		}

	}

	FGF_Gift_Products_Handler::init() ;
}
