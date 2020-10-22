<?php
/**
 * Plugin Name: Brankas Direct Payments Gateway
 * Plugin URI: https://brank.as
 * Author: Brankas
 * Author URI: https://brank.as
 * Description: Make secure bank transfer payments using Brankas Direct
 * Version: 1.0.8
 * License: GPL2
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: brankas-direct-wc
 * 
 * Class WC_Gateway_Brankas file.
 *
 * @package WooCommerce\Brankas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;

add_action( 'plugins_loaded', 'brankas_payment_init', 11 );
add_filter( 'woocommerce_currencies', 'brankas_add_currencies' );
add_filter( 'woocommerce_currency_symbol', 'brankas_add_currencies_symbol', 10, 2 );
add_filter( 'woocommerce_payment_gateways', 'add_to_woo_brankas_payment_gateway');

function brankas_payment_init() {
    if( class_exists( 'WC_Payment_Gateway' ) ) {
		require_once plugin_dir_path( __FILE__ ) . '/includes/class-wc-payment-gateway-brankas.php';
		require_once plugin_dir_path( __FILE__ ) . '/includes/brankas-checkout-validation.php';
		require_once plugin_dir_path( __FILE__ ) . '/includes/brankas-checkout-select-source-field.php';
	}
}

function add_to_woo_brankas_payment_gateway( $gateways ) {
    $gateways[] = 'WC_Gateway_Brankas';
    return $gateways;
}

function brankas_add_currencies( $currencies ) {
	// $currencies['IDR'] = __( 'Indonesian Rupiah', 'brankas-direct-wc' );
	$currencies['PHP'] = __( 'Philippine Peso', 'brankas-direct-wc' );
	return $currencies;
}

function brankas_add_currencies_symbol( $currency_symbol, $currency ) {
	switch ( $currency ) {
		// case 'IDR': 
		// 	$currency_symbol = 'IDR'; 
		case 'PHP': 
			$currency_symbol = 'PHP'; 
		break;
	}
	return $currency_symbol;
}