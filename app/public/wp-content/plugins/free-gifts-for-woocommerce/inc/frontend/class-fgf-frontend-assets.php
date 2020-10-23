<?php

/**
 * Frontend Assets
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}
if ( ! class_exists( 'HRW_Fronend_Assets' ) ) {

	/**
	 * Class.
	 */
	class HRW_Fronend_Assets {

		/**
		 * Suffix.
		 */
		private static $suffix ;

		/**
		 * In Footer.
		 */
		private static $in_footer = false ;

		/**
		 * Class Initialization.
		 */
		public static function init() {

			self::$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' ;

			// Enqueue script in footer.
			if ( '2' == get_option( 'fgf_settings_frontend_enqueue_scripts_type' ) ) {
				self::$in_footer = true ;
			}

			add_action( 'wp_enqueue_scripts' , array( __CLASS__ , 'external_js_files' ) ) ;
			add_action( 'wp_enqueue_scripts' , array( __CLASS__ , 'external_css_files' ) ) ;
		}

		/**
		 * Enqueue external JS files
		 */
		public static function external_js_files() {

			// Frontend
			$permalink        = get_permalink() ;
			$add_to_cart_link = esc_url( add_query_arg( array( 'fgf_gift_product' => '%s' , 'fgf_rule_id' => '%s' , ) , $permalink ) ) ;

			wp_enqueue_script( 'fgf-frontend' , FGF_PLUGIN_URL . '/assets/js/frontend.js' , array( 'jquery' , 'jquery-blockui' ) , FGF_VERSION , self::$in_footer ) ;
			wp_localize_script(
					'fgf-frontend' , 'fgf_frontend_params' , array(
				'gift_products_pagination_nonce' => wp_create_nonce( 'fgf-gift-products-pagination' ) ,
				'ajaxurl'                        => FGF_ADMIN_AJAX_URL ,
				'current_page_url'               => $permalink ,
				'add_to_cart_link'               => $add_to_cart_link ,
				'dropdown_add_to_cart_behaviour' => get_option( 'fgf_settings_dropdown_add_to_cart_behaviour' ) ,
				'add_to_cart_alert_message'      => get_option( 'fgf_settings_gift_product_dropdown_valid_message' , 'Please select a Gift' )
					)
			) ;

			//Enqueue Carousel.
			self::enqueue_carousel() ;
			//Enqueue Lightcase.
			self::enqueue_lightcase() ;
		}

		public static function external_css_files() {
			wp_register_style( 'fgf-inline-style' , false , array() , FGF_VERSION ) ; // phpcs:ignore
			wp_enqueue_style( 'fgf-inline-style' ) ;

			//Add inline style.
			self::add_inline_style() ;

			// Frontend.
			wp_enqueue_style( 'fgf-frontend-css' , FGF_PLUGIN_URL . '/assets/css/frontend.css' , array() , FGF_VERSION ) ;
		}

		/**
		 * Add Inline style
		 */
		public static function add_inline_style() {
			$contents = get_option( 'fgf_settings_custom_css' , '' ) ;

			if ( ! $contents ) {
				return ;
			}

			//Add custom css as inline style.
			wp_add_inline_style( 'fgf-inline-style' , $contents ) ;
		}

		/**
		 * Enqueue Carousel.
		 */
		public static function enqueue_carousel() {

			// Owl carousel JS.
			wp_register_script( 'owl-carousel' , FGF_PLUGIN_URL . '/assets/js/owl.carousel' . self::$suffix . '.js' , array( 'jquery' ) , FGF_VERSION , self::$in_footer ) ;
			wp_enqueue_script( 'fgf-owl-carousel' , FGF_PLUGIN_URL . '/assets/js/owl-carousel-enhanced.js' , array( 'jquery' , 'owl-carousel' ) , FGF_VERSION , self::$in_footer ) ;
			wp_localize_script( 'fgf-owl-carousel' , 'fgf_carousel_params' , fgf_get_carousel_options() ) ;

			// Owl carousel CSS.
			wp_enqueue_style( 'owl-carousel' , FGF_PLUGIN_URL . '/assets/css/owl.carousel' . self::$suffix . '.css' , array() , FGF_VERSION ) ;
			wp_enqueue_style( 'fgf-owl-carousel' , FGF_PLUGIN_URL . '/assets/css/owl-carousel-enhanced.css' , array() , FGF_VERSION ) ;
		}

		/**
		 * Enqueue Lightcase.
		 */
		public static function enqueue_lightcase() {

			// Lightcase.
			wp_register_script( 'lightcase' , FGF_PLUGIN_URL . '/assets/js/lightcase' . self::$suffix . '.js' , array( 'jquery' ) , FGF_VERSION , self::$in_footer ) ;

			// Enhanced lightcase.
			wp_enqueue_script( 'fgf-lightcase' , FGF_PLUGIN_URL . '/assets/js/fgf-lightcase-enhanced.js' , array( 'jquery' , 'jquery-blockui' , 'lightcase' ) , FGF_VERSION , self::$in_footer ) ;

			// Lightcase CSS.
			wp_enqueue_style( 'lightcase' , FGF_PLUGIN_URL . '/assets/css/lightcase' . self::$suffix . '.css' , array() , FGF_VERSION ) ;
		}

	}

	HRW_Fronend_Assets::init() ;
}
