<?php

/**
 * Shortcodes.
 * */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}
if ( ! class_exists( 'FGF_Shortcodes' ) ) {

	/**
	 * Class.
	 */
	class FGF_Shortcodes {

		/**
		 * Plugin slug.
		 * */
		private static $plugin_slug = 'fgf' ;

		/**
		 * Class Initialization.
		 * */
		public static function init() {
			$shortcodes = apply_filters( 'fgf_load_shortcodes' , array(
				'fgf_gift_products' ,
					) ) ;

			foreach ( $shortcodes as $shortcode_name ) {

				add_shortcode( $shortcode_name , array( __CLASS__ , 'process_shortcode' ) ) ;
			}
		}

		/**
		 * Process Shortcode.
		 * */
		public static function process_shortcode( $atts, $content, $tag ) {

			$shortcode_name = str_replace( 'fgf_' , '' , $tag ) ;

			$function = 'shortcode_' . $shortcode_name ;

			switch ( $shortcode_name ) {
				case 'gift_products':
					ob_start() ;
					self::$function( $atts , $content ) ; // output for shortcode.
					$content = ob_get_contents() ;
					ob_end_clean() ;
					break ;

				default:
					ob_start() ;
					do_action( "fgf_shortcode_{$shortcode_name}_content" ) ;
					$content = ob_get_contents() ;
					ob_end_clean() ;
					break ;
			}

			return $content ;
		}

		/**
		 * Shortcode for the gift products.
		 * */
		public static function shortcode_gift_products( $atts, $content ) {

			$atts = shortcode_atts( array(
				'per_page' => fgf_get_free_gifts_per_page_column_count() ,
				'mode'     => 'inline' ,
				'type'     => 'table' ,
					) , $atts , 'fgf_gift_products' ) ;

			$atts[ 'data_args' ] = self::get_gift_product_data( $atts ) ;

			$popup_link = '<a href="#" class="fgf-popup-gift-products">' . get_option( 'fgf_settings_free_gift_popup_link_message' ) . '</a>' ;

			$atts[ 'popup_message' ] = str_replace( '[popup_link]' , $popup_link , get_option( 'fgf_settings_free_gift_popup_notice_message' ) ) ;

			// Display the Gift Products shortcode layout.
			fgf_get_template( 'shortcode-layout.php' , $atts ) ;
		}

		/**
		 *  Get Gift Product Data
		 */
		public static function get_gift_product_data( $atts ) {
			// Return if cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return false ;
			}

			// return if cart is empty
			if ( WC()->cart->get_cart_contents_count() == 0 ) {
				return false ;
			}

			// Hide table if gift products per order count exists
			if ( FGF_Rule_Handler::check_per_order_count_exists() ) {
				return false ;
			}

			$gift_products = FGF_Rule_Handler::get_manual_gift_products() ;

			if ( ! fgf_check_is_array( $gift_products ) ) {
				return false ;
			}

			switch ( $atts[ 'type' ] ) {
				case 'selectbox':
					$data_args = array(
					'template'      => 'dropdown-layout.php' ,
					'gift_products' => $gift_products ,
					) ;
					break ;
										
				case 'carousel':
					$data_args = array(
						'template'      => 'carousel-layout.php' ,
						'gift_products' => $gift_products ,
							) ;
					break ;

				default:
					$per_page     = $atts[ 'per_page' ] ;
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

	}

	FGF_Shortcodes::init() ;
}
