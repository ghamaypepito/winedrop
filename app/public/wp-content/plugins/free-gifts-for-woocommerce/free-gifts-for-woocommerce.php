<?php

/**
 * Plugin Name: Free Gifts for WooCommerce
 * Description: Offer Free Gifts to your customers for making purchases in your WooCommerce Shop.
 * Version: 5.6
 * Author: FantasticPlugins
 * Author URI: http://fantasticplugins.com
 * Text Domain: free-gifts-for-woocommerce
 * Domain Path: /languages
 * Woo: 4891274:b2b37ad71ffc9fa2a8bdc2eb14df650f
 * Tested up to: 5.5.1
 * WC tested up to: 4.5.1
 * WC requires at least: 3.0
 * Copyright: © 2019 FantasticPlugins
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Include once will help to avoid fatal error by load the files when you call init hook */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Function to check whether WooCommerce is active or not
 */
function fgf_maybe_woocommerce_active() {

	if ( is_multisite() ) {
		// This Condition is for Multi Site WooCommerce Installation
		if ( ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) && ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
			if ( is_admin() ) {
				add_action( 'init', 'fgf_display_warning_message' );
			}
			return false;
		}
	} else {
		// This Condition is for Single Site WooCommerce Installation
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			if ( is_admin() ) {
				add_action( 'init', 'fgf_display_warning_message' );
			}
			return false;
		}
	}
	return true;
}

/**
 * Display Warning message
 */
function fgf_display_warning_message() {
	echo "<div class='error'><p> Free Gifts for WooCommerce Plugin will not work until WooCommerce Plugin is Activated. Please Activate the WooCommerce Plugin. </p></div>";
}

// retrun if WooCommerce is not active
if ( ! fgf_maybe_woocommerce_active() ) {
	return;
}

// Define constant
if ( ! defined( 'FGF_PLUGIN_FILE' ) ) {
	define( 'FGF_PLUGIN_FILE', __FILE__ );
}

// Include main class file
if ( ! class_exists( 'FP_Free_Gift' ) ) {
	include_once( 'inc/class-free-gift.php' );
}

// return Free Gift class object
if ( ! function_exists( 'FGF' ) ) {

	function FGF() {
		return FP_Free_Gift::instance();
	}
}

// initialize the plugin.
FGF();

