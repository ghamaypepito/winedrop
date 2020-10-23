<?php

/*
 * Common functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

include_once( 'fgf-layout-functions.php' ) ;
include_once( 'fgf-post-functions.php' ) ;
include_once( 'fgf-formatting-functions.php' ) ;
include_once( 'fgf-template-functions.php' ) ;

if ( ! function_exists( 'fgf_check_is_array' ) ) {

	/**
	 * Check if resource is array
	 *
	 * @return bool
	 */
	function fgf_check_is_array( $data ) {
		return ( is_array( $data ) && ! empty( $data ) ) ;
	}

}

if ( ! function_exists( 'fgf_page_screen_ids' ) ) {

	/**
	 * Get page screen IDs
	 *
	 * @return array
	 */
	function fgf_page_screen_ids() {

		$wc_screen_id = sanitize_title( esc_html__( 'WooCommerce' , 'woocommerce' ) ) ;

		return apply_filters(
				'fgf_page_screen_ids' , array(
			$wc_screen_id . '_page_fgf_settings' ,
				)
				) ;
	}

}

if ( ! function_exists( 'fgf_get_allowed_setting_tabs' ) ) {

	/**
	 * Get setting tabs
	 *
	 * @return array
	 */
	function fgf_get_allowed_setting_tabs() {

		return apply_filters( 'fgf_settings_tabs_array' , array() ) ;
	}

}

if ( ! function_exists( 'fgf_get_wc_order_statuses' ) ) {

	/**
	 * Get WC Order statuses
	 *
	 * @return array
	 */
	function fgf_get_wc_order_statuses() {

		$order_statuses_keys   = array_keys( wc_get_order_statuses() ) ;
		$order_statuses_keys   = str_replace( 'wc-' , '' , $order_statuses_keys ) ;
		$order_statuses_values = array_values( wc_get_order_statuses() ) ;

		return array_combine( $order_statuses_keys , $order_statuses_values ) ;
	}

}

if ( ! function_exists( 'fgf_get_paid_order_statuses' ) ) {

	/**
	 * Get WC Paid Order statuses
	 *
	 * @return array
	 */
	function fgf_get_paid_order_statuses() {

		$statuses = array(
			'processing' => esc_html__( 'Processing' , 'free-gifts-for-woocommerce' ) ,
			'completed'  => esc_html__( 'Completed' , 'free-gifts-for-woocommerce' ) ,
				) ;

		return apply_filters( 'fgf_paid_order_statuses' , $statuses ) ;
	}

}

if ( ! function_exists( 'fgf_get_wc_cart_subtotal' ) ) {

	/**
	 * Get WC cart Subtotal
	 *
	 * @return string/float
	 */
	function fgf_get_wc_cart_subtotal() {

		if ( method_exists( WC()->cart , 'get_subtotal' ) ) {
			$subtotal = ( 'incl' == get_option( 'woocommerce_tax_display_cart' ) ) ? WC()->cart->get_subtotal() + WC()->cart->get_subtotal_tax() : WC()->cart->get_subtotal() ;
		} else {
			$subtotal = ( 'incl' == get_option( 'woocommerce_tax_display_cart' ) ) ? WC()->cart->subtotal + WC()->cart->subtotal_tax : WC()->cart->subtotal ;
		}

		return $subtotal ;
	}

}

if ( ! function_exists( 'fgf_get_wc_cart_total' ) ) {

	/**
	 * Get WC cart total.
	 *
	 * @return string/float
	 */
	function fgf_get_wc_cart_total() {

		if ( version_compare( WC()->version , '3.2.0' , '>=' ) ) {
			$total = WC()->cart->get_total( true ) ;
		} else {
			$total = WC()->cart->total ;
		}

		return $total ;
	}

}

if ( ! function_exists( 'fgf_get_wc_categories' ) ) {

	/**
	 * Get WC Categories
	 *
	 * @return array
	 */
	function fgf_get_wc_categories() {
		$categories    = array() ;
		$wc_categories = get_terms( 'product_cat' ) ;

		if ( ! fgf_check_is_array( $wc_categories ) ) {
			return $categories ;
		}

		foreach ( $wc_categories as $category ) {
			$categories[ $category->term_id ] = $category->name ;
		}

		return $categories ;
	}

}

if ( ! function_exists( 'fgf_get_wp_user_roles' ) ) {

	/**
	 * Get WordPress User Roles
	 *
	 * @return array
	 */
	function fgf_get_wp_user_roles() {
		global $wp_roles ;
		$user_roles = array() ;

		if ( ! isset( $wp_roles->roles ) || ! fgf_check_is_array( $wp_roles->roles ) ) {
			return $user_roles ;
		}

		foreach ( $wp_roles->roles as $slug => $role ) {
			$user_roles[ $slug ] = $role[ 'name' ] ;
		}

		return $user_roles ;
	}

}

if ( ! function_exists( 'fgf_get_user_roles' ) ) {

	/**
	 * Get User Roles
	 *
	 * @return array
	 */
	function fgf_get_user_roles( $extra_options = array() ) {
		$user_roles = fgf_get_wp_user_roles() ;

		$user_roles[ 'guest' ] = esc_html__( 'Guest' , 'free-gifts-for-woocommerce' ) ;

		$user_roles = array_merge( $user_roles , $extra_options ) ;

		return $user_roles ;
	}

}

if ( ! function_exists( 'fgf_get_settings_page_url' ) ) {

	/**
	 * Get Settings page URL
	 *
	 * @return array
	 */
	function fgf_get_settings_page_url( $args = array() ) {

		$url = add_query_arg( array( 'page' => 'fgf_settings' ) , admin_url( 'admin.php' ) ) ;

		if ( fgf_check_is_array( $args ) ) {
			$url = add_query_arg( $args , $url ) ;
		}

		return $url ;
	}

}

if ( ! function_exists( 'fgf_get_rule_page_url' ) ) {

	/**
	 * Get Rule page URL
	 *
	 * @return string
	 */
	function fgf_get_rule_page_url( $args = array() ) {

		$url = add_query_arg(
				array(
			'page' => 'fgf_settings' ,
			'tab'  => 'rules' ,
				) , admin_url( 'admin.php' )
				) ;

		if ( fgf_check_is_array( $args ) ) {
			$url = add_query_arg( $args , $url ) ;
		}

		return $url ;
	}

}

if ( ! function_exists( 'fgf_filter_readable_products' ) ) {

	/**
	 * Filter the readable products.
	 *
	 * @return array
	 */
	function fgf_filter_readable_products( $product_ids ) {

		if ( ! fgf_check_is_array( $product_ids ) ) {
			return array() ;
		}

		if ( function_exists( 'wc_products_array_filter_readable' ) ) {
			return array_filter( array_map( 'wc_get_product' , $product_ids ) , 'wc_products_array_filter_readable' ) ;
		} else {
			return array_filter( array_map( 'wc_get_product' , $product_ids ) , 'fgf_products_array_filter_readable' ) ;
		}
	}

}
if ( ! function_exists( 'fgf_products_array_filter_readable' ) ) {

	/**
	 * Filter the readable product.
	 *
	 * @return array
	 */
	function fgf_products_array_filter_readable( $product ) {
		return $product && is_a( $product , 'WC_Product' ) && current_user_can( 'read_product' , $product->get_id() ) ;
	}

}

if ( ! function_exists( 'fgf_get_master_log_page_url' ) ) {

	/**
	 * Get Master Log page URL
	 *
	 * @return string
	 */
	function fgf_get_master_log_page_url( $args = array() ) {

		$url = add_query_arg(
				array(
			'page' => 'fgf_settings' ,
			'tab'  => 'master-log' ,
				) , admin_url( 'admin.php' )
				) ;

		if ( fgf_check_is_array( $args ) ) {
			$url = add_query_arg( $args , $url ) ;
		}

		return $url ;
	}

}

if ( ! function_exists( 'fgf_get_free_gift_products_in_cart' ) ) {

	/**
	 * Get Free Gift Products in Cart
	 *
	 * @return array
	 */
	function fgf_get_free_gift_products_in_cart( $count = false, $automatic = false ) {
		$free_gift_products       = array() ;
		$free_gift_products_count = 0 ;

		foreach ( WC()->cart->get_cart() as $key => $value ) {
			if ( ! isset( $value[ 'fgf_gift_product' ] ) ) {
				continue ;
			}

			if ( $automatic && 'automatic' == $value[ 'fgf_gift_product' ][ 'mode' ] ) {
				$value[ 'fgf_gift_product' ][ 'quantity' ] = $value[ 'quantity' ] ;
				$free_gift_products_count                  += $value[ 'quantity' ] ;

				if ( isset( $free_gift_products[ $value[ 'fgf_gift_product' ][ 'product_id' ] ] ) ) {

					$free_gift_products[ $value[ 'fgf_gift_product' ][ 'product_id' ] ][ $value[ 'fgf_gift_product' ][ 'rule_id' ] ] = $value[ 'quantity' ] ;
				} else {
					$free_gift_products[ $value[ 'fgf_gift_product' ][ 'product_id' ] ] = array( $value[ 'fgf_gift_product' ][ 'rule_id' ] => $value[ 'quantity' ] ) ;
				}
			} elseif ( ! $automatic && 'manual' == $value[ 'fgf_gift_product' ][ 'mode' ] ) {
				$value[ 'fgf_gift_product' ][ 'quantity' ] = $value[ 'quantity' ] ;
				$free_gift_products_count                  += $value[ 'quantity' ] ;

				if ( isset( $free_gift_products[ $value[ 'fgf_gift_product' ][ 'product_id' ] ] ) ) {

					$free_gift_products[ $value[ 'fgf_gift_product' ][ 'product_id' ] ][ $value[ 'fgf_gift_product' ][ 'rule_id' ] ] = $value[ 'quantity' ] ;
				} else {
					$free_gift_products[ $value[ 'fgf_gift_product' ][ 'product_id' ] ] = array( $value[ 'fgf_gift_product' ][ 'rule_id' ] => $value[ 'quantity' ] ) ;
				}
			}
		}

		if ( $count ) {
			return $free_gift_products_count ;
		}

		return $free_gift_products ;
	}

}


if ( ! function_exists( 'fgf_get_bogo_products_count_in_cart' ) ) {

	/**
	 * Get BOGO Products count in Cart.
	 *
	 * @return bool
	 */
	function fgf_get_bogo_products_count_in_cart( $buy_product_id, $get_product_id, $rule_id ) {
		$bogo_products = array() ;
		$quantity      = 0 ;
		foreach ( WC()->cart->get_cart() as $key => $value ) {
			if ( ! isset( $value[ 'fgf_gift_product' ][ 'mode' ] ) || 'bogo' != $value[ 'fgf_gift_product' ][ 'mode' ] ) {
				continue ;
			}

			if ( $rule_id != $value[ 'fgf_gift_product' ][ 'rule_id' ] ) {
				continue ;
			}

			if ( $buy_product_id != $value[ 'fgf_gift_product' ][ 'buy_product_id' ] ) {
				continue ;
			}

			if ( $get_product_id != $value[ 'fgf_gift_product' ][ 'product_id' ] ) {
				continue ;
			}

			$quantity += $value[ 'quantity' ] ;
		}

		return $quantity ;
	}

}

if ( ! function_exists( 'fgf_get_buy_product_count_in_cart' ) ) {

	/**
	 * Get buy product count in Cart
	 *
	 * @return integer/bool
	 */
	function fgf_get_buy_product_count_in_cart( $buy_product_id ) {
		$buy_product_count = 0 ;

		foreach ( WC()->cart->get_cart() as $key => $value ) {
			if ( isset( $value[ 'fgf_gift_product' ] ) ) {
				continue ;
			}

			$product_id = ! empty( $value[ 'variation_id' ] ) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;

			if ( $product_id != $buy_product_id ) {
				continue ;
			}

			$buy_product_count += $value[ 'quantity' ] ;
		}

		return $buy_product_count ;
	}

}

if ( ! function_exists( 'fgf_get_free_gift_products_count_in_cart' ) ) {

	/**
	 * Get Free Gift Products Count in Cart
	 *
	 * @return integer
	 */
	function fgf_get_free_gift_products_count_in_cart( $exclude_bogo = false ) {
		$free_gift_products_count = 0 ;

		foreach ( WC()->cart->get_cart() as $key => $value ) {
			if ( ! isset( $value[ 'fgf_gift_product' ] ) ) {
				continue ;
			}

			if ( $exclude_bogo && ( ! isset( $value[ 'fgf_gift_product' ][ 'mode' ] ) || 'bogo' == $value[ 'fgf_gift_product' ][ 'mode' ] ) ) {
				continue ;
			}

			$value[ 'fgf_gift_product' ][ 'quantity' ] = $value[ 'quantity' ] ;
			$free_gift_products_count                  += $value[ 'quantity' ] ;
		}

		return $free_gift_products_count ;
	}

}

if ( ! function_exists( 'fgf_get_rule_products_count_in_cart' ) ) {

	/**
	 * Get rule products count in Cart
	 *
	 * @return array
	 */
	function fgf_get_rule_products_count_in_cart( $rule_id ) {
		$count = 0 ;

		foreach ( WC()->cart->get_cart() as $key => $value ) {
			if ( ! isset( $value[ 'fgf_gift_product' ] ) ) {
				continue ;
			}

			if ( $value[ 'fgf_gift_product' ][ 'rule_id' ] != $rule_id ) {
				continue ;
			}

			$count += $value[ 'quantity' ] ;
		}

		return $count ;
	}

}

if ( ! function_exists( 'fgf_get_cart_item_count' ) ) {

	/**
	 * Get the cart item count from the cart.
	 *
	 * @return array
	 */
	function fgf_get_cart_item_count( $exclude_gift = true ) {
		$count = 0 ;

		foreach ( WC()->cart->get_cart() as $key => $value ) {
			if ( isset( $value[ 'fgf_gift_product' ] ) && $exclude_gift ) {
				continue ;
			}

			$count ++ ;
		}

		return $count ;
	}

}

if ( ! function_exists( 'fgf_get_wc_cart_category_subtotal' ) ) {

	/**
	 * Get the category subtotal from the cart.
	 *
	 * @return integer/bool
	 */
	function fgf_get_wc_cart_category_subtotal( $category_ids ) {

		$cart_total = 0 ;

		if ( ! fgf_check_is_array( $category_ids ) ) {
			return $cart_total ;
		}

		$tax_display_cart = get_option( 'woocommerce_tax_display_cart' ) ;

		foreach ( WC()->cart->get_cart() as $key => $value ) {

			if ( isset( $value[ 'fgf_gift_product' ] ) ) {
				continue ;
			}

			$product_categories = get_the_terms( $value[ 'product_id' ] , 'product_cat' ) ;
			if ( ! fgf_check_is_array( $product_categories ) ) {
				continue ;
			}

			foreach ( $product_categories as $product_category ) {
				if ( in_array( $product_category->term_id , $category_ids ) ) {
					$cart_total += ( 'incl' == $tax_display_cart ) ? $value[ 'line_subtotal' ] + $value[ 'line_subtotal_tax' ] : $value[ 'line_subtotal' ] ;
					break ;
				}
			}
		}

		return $cart_total ;
	}

}

if ( ! function_exists( 'fgf_get_product_count_in_cart' ) ) {

	/**
	 * Get product count in Cart
	 *
	 * @return integer/bool
	 */
	function fgf_get_product_count_in_cart( $product_id ) {
		$product_count = 0 ;

		foreach ( WC()->cart->get_cart() as $key => $value ) {

			$cart_product_id = ! empty( $value[ 'variation_id' ] ) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;

			if ( $cart_product_id != $product_id ) {
				continue ;
			}

			$product_count += $value[ 'quantity' ] ;
		}

		return $product_count ;
	}

}

if ( ! function_exists( 'fgf_get_address_metas' ) ) {

	/**
	 * Get User Address meta(s)
	 *
	 * @return array
	 */
	function fgf_get_address_metas( $flag ) {

		$address_metas = array(
			'first_name' ,
			'last_name' ,
			'company' ,
			'address_1' ,
			'address_2' ,
			'city' ,
			'country' ,
			'postcode' ,
			'state' ,
				) ;

		return 'billing' == $flag ? array_merge( $address_metas , array( 'email' , 'phone' ) ) : $address_metas ;
	}

}

if ( ! function_exists( 'fgf_get_address' ) ) {

	/**
	 * Get User Address
	 *
	 * @return array
	 */
	function fgf_get_address( $user_id, $flag ) {
		$billing_metas = fgf_get_address_metas( $flag ) ;

		foreach ( $billing_metas as $each_meta ) {
			$billing_address[ $each_meta ] = get_user_meta( $user_id , $flag . '_' . $each_meta , true ) ;
		}

		return $billing_address ;
	}

}

if ( ! function_exists( 'fgf_get_free_gifts_per_page_column_count' ) ) {

	/**
	 * Get Free Gifts Per Page Column Count
	 *
	 * @return number
	 */
	function fgf_get_free_gifts_per_page_column_count() {
		// To avoid pagination if the table pagination is disabled.
		$display_table_pagination = get_option( 'fgf_settings_gift_display_table_pagination' ) ;
		if ( '2' == $display_table_pagination ) {
			return 10000 ;
		}

		$per_page = get_option( 'fgf_settings_free_gift_per_page_column_count' , 4 ) ;

		if ( ! $per_page ) {
			return 4 ;
		}

		return $per_page ;
	}

}

if ( ! function_exists( 'fgf_get_carousel_options' ) ) {

	/**
	 * Get carousel options.
	 *
	 * @return array
	 */
	function fgf_get_carousel_options() {

		// Declare values.
		$nav            = ( 'yes' == get_option( 'fgf_settings_carousel_navigation' ) ) ? true : false ;
		$auto_play      = ( 'yes' == get_option( 'fgf_settings_carousel_auto_play' ) ) ? true : false ;
		$pagination     = ( 'yes' == get_option( 'fgf_settings_carousel_pagination' ) ) ? true : false ;
		$nav_prev_text  = get_option( 'fgf_settings_carousel_navigation_prevoius_text' ) ;
		$nav_next_text  = get_option( 'fgf_settings_carousel_navigation_next_text' ) ;
		$per_page       = get_option( 'fgf_settings_carousel_gift_per_page' , 3 ) ;
		$item_margin    = get_option( 'fgf_settings_carousel_item_margin' ) ;
		$item_per_slide = get_option( 'fgf_settings_carousel_item_per_slide' ) ;
		$slide_speed    = get_option( 'fgf_settings_carousel_slide_speed' ) ;

		$nav_prev_text  = ( empty( $nav_prev_text ) ) ? '<' : $nav_prev_text ;
		$nav_next_text  = ( empty( $nav_next_text ) ) ? '<' : $nav_next_text ;
		$per_page       = ( empty( $per_page ) ) ? '3' : $per_page ;
		$item_margin    = ( empty( $item_margin ) ) ? '10' : $item_margin ;
		$item_per_slide = ( empty( $item_per_slide ) ) ? '1' : $item_per_slide ;
		$slide_speed    = ( empty( $slide_speed ) ) ? '5000' : $slide_speed ;

		return array(
			'per_page'       => $per_page ,
			'item_margin'    => $item_margin ,
			'nav'            => json_encode( $nav ) ,
			'nav_prev_text'  => $nav_prev_text ,
			'nav_next_text'  => $nav_next_text ,
			'pagination'     => json_encode( $pagination ) ,
			'item_per_slide' => $item_per_slide ,
			'slide_speed'    => $slide_speed ,
			'auto_play'      => json_encode( $auto_play ) ,
				) ;
	}

}

if ( ! function_exists( 'fgf_get_rule_translated_string' ) ) {

	/**
	 * Get the rule translated string.
	 *
	 * @return array
	 */
	function fgf_get_rule_translated_string( $option_name, $value, $language = null ) {

		return apply_filters( 'fgf_rule_translate_string' , $value , $option_name , $language ) ;
	}

}
