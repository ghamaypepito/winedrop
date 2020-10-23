<?php

/*
 * Menu Management
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( ! class_exists( 'FGF_Menu_Management' ) ) {

	include_once( 'class-fgf-settings.php' ) ;

	/**
	 * FGF_Menu_Management Class.
	 */
	class FGF_Menu_Management {

		/**
		 * Plugin slug.
		 */
		protected static $plugin_slug = 'fgf' ;

		/**
		 * Menu slug.
		 */
		protected static $menu_slug = 'woocommerce' ;

		/**
		 * Settings slug.
		 */
		protected static $settings_slug = 'fgf_settings' ;

		/**
		 * Class initialization.
		 */
		public static function init() {
			add_action( 'admin_menu' , array( __CLASS__ , 'add_menu_pages' ) ) ;
			add_filter( 'woocommerce_screen_ids' , array( __CLASS__ , 'add_custom_wc_screen_ids' ) , 9 , 1 ) ;
		}

		/**
		 * Add Custom Screen IDs in WooCommerce
		 */
		public static function add_custom_wc_screen_ids( $wc_screen_ids ) {
			$screen_ids = fgf_page_screen_ids() ;

			$newscreenids = get_current_screen() ;
			$screenid     = str_replace( 'edit-' , '' , $newscreenids->id ) ;

			// return if current page is not free products page
			if ( ! in_array( $screenid , $screen_ids ) ) {
				return $wc_screen_ids ;
			}

			$wc_screen_ids[] = $screenid ;

			return $wc_screen_ids ;
		}

		/**
		 * Add menu pages
		 */
		public static function add_menu_pages() {
			// Settings Submenu
			$settings_page = add_submenu_page( self::$menu_slug , esc_html__( 'Free Gifts' , 'free-gifts-for-woocommerce' ) , esc_html__( 'Free Gifts' , 'free-gifts-for-woocommerce' ) , 'manage_woocommerce' , self::$settings_slug , array( __CLASS__ , 'settings_page' ) ) ;

			add_action( 'load-' . $settings_page , array( __CLASS__ , 'settings_page_init' ) ) ;
		}

		/**
		 * Settings page init
		 */
		public static function settings_page_init() {
			global $current_tab , $current_section , $current_sub_section , $current_action ;

			// Include settings pages.
			$settings = FGF_Settings::get_settings_pages() ;

			$tabs = fgf_get_allowed_setting_tabs() ;

			// Get current tab/section.
			$current_tab = key( $tabs ) ;
			if ( ! empty( $_GET[ 'tab' ] ) ) {
				$sanitize_current_tab = sanitize_title( wp_unslash( $_GET[ 'tab' ] ) ) ; // @codingStandardsIgnoreLine.
				if ( array_key_exists( $sanitize_current_tab , $tabs ) ) {
					$current_tab = $sanitize_current_tab ;
				}
			}

			$section = isset( $settings[ $current_tab ] ) ? $settings[ $current_tab ]->get_sections() : array() ;

			$current_section     = empty( $_REQUEST[ 'section' ] ) ? key( $section ) : sanitize_title( wp_unslash( $_REQUEST[ 'section' ] ) ) ; // @codingStandardsIgnoreLine.
			$current_section     = empty( $current_section ) ? $current_tab : $current_section ;
			$current_sub_section = empty( $_REQUEST[ 'subsection' ] ) ? '' : sanitize_title( wp_unslash( $_REQUEST[ 'subsection' ] ) ) ; // @codingStandardsIgnoreLine.
			$current_action      = empty( $_REQUEST[ 'action' ] ) ? '' : sanitize_title( wp_unslash( $_REQUEST[ 'action' ] ) ) ; // @codingStandardsIgnoreLine.

			do_action( sanitize_key( self::$plugin_slug . '_settings_save_' . $current_tab ) , $current_section ) ;
			do_action( sanitize_key( self::$plugin_slug . '_settings_reset_' . $current_tab ) , $current_section ) ;

			add_action( 'woocommerce_admin_field_fgf_custom_fields' , array( __CLASS__ , 'custom_fields_output' ) ) ;
			add_filter( 'woocommerce_admin_settings_sanitize_option_fgf_custom_fields' , array( __CLASS__ , 'save_custom_fields' ) , 10 , 3 ) ;
		}

		/**
		 * Settings page output
		 */
		public static function settings_page() {
			FGF_Settings::output() ;
		}

		/**
		 * Output the custom field settings.
		 */
		public static function custom_fields_output( $options ) {

			FGF_Settings::output_fields( $options ) ;
		}

		/**
		 * Save Custom Field settings.
		 */
		public static function save_custom_fields( $value, $option, $raw_value ) {

			FGF_Settings::save_fields( $value , $option , $raw_value ) ;
		}

	}

	FGF_Menu_Management::init() ;
}
