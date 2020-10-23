<?php

/**
 * Template functions
 * */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( ! function_exists( 'fgf_get_gift_product_heading_label' ) ) {

	/**
	 * Get the label for gift product heading.
	 * l
	 *
	 * @return string.
	 * 
	 * */
	function fgf_get_gift_product_heading_label() {

		return apply_filters( 'fgf_gift_product_heading_label' , get_option( 'fgf_settings_free_gift_heading_label' ) ) ;
	}

}

if ( ! function_exists( 'fgf_get_gift_product_add_to_cart_button_label' ) ) {

	/**
	 * Get the label for gift product add to cart button.
	 * l
	 *
	 * @return string.
	 * 
	 * */
	function fgf_get_gift_product_add_to_cart_button_label() {

		return apply_filters( 'fgf_gift_product_add_to_cart_button_label' , get_option( 'fgf_settings_free_gift_add_to_cart_button_label' ) ) ;
	}

}

if ( ! function_exists( 'fgf_get_gift_product_dropdown_default_value_label' ) ) {

	/**
	 * Get the label for gift product dropdown default value.
	 * l
	 *
	 * @return string.
	 * 
	 * */
	function fgf_get_gift_product_dropdown_default_value_label() {

		return apply_filters( 'fgf_gift_product_dropdown_default_value_label' , get_option( 'fgf_settings_free_gift_dropdown_default_option_label' , 'Please select a Gift' ) ) ;
	}

}

if ( ! function_exists( 'fgf_get_dropdown_gift_product_name' ) ) {

	/**
	 * Get the dropdown gift product name.
	 * 
	 * @return string.
	 * 
	 * */
	function fgf_get_dropdown_gift_product_name( $product_id, $product = false ) {
		if ( ! is_object( $product ) ) {
			$product = wc_get_product( $product_id ) ;
		}

		return apply_filters( 'fgf_get_dropdown_gift_product_name' , $product->get_name() , $product ) ;
	}

}

if ( ! function_exists( 'fgf_show_dropdown_add_to_button' ) ) {

	/**
	 * Show the dropdown add to cart button.
	 * 
	 * @return bool.
	 * 
	 * */
	function fgf_show_dropdown_add_to_button() {

		return apply_filters( 'fgf_show_dropdown_add_to_button' , '2' != get_option( 'fgf_settings_dropdown_add_to_cart_behaviour' ) ) ;
	}

}
