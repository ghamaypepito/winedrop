<?php

use HPY\CS\Settings\HPY_CS_Admin;

class HPY_CS {
	
	private static $referer;
	
	public static function init() {
		add_filter( 'woocommerce_continue_shopping_redirect', __CLASS__ . '::hpy_cs_custom_redirect_continue_shopping' );
		add_action( 'woocommerce_before_single_product',  __CLASS__ . '::hpy_cs_single_prod_load' );
		add_action( 'woocommerce_cart_is_empty',  __CLASS__ . '::hpy_cs_output_notice', 1 );
		add_action( 'woocommerce_cart_actions',  __CLASS__ . '::hpy_cs_output_permanent_button', 1 );
		add_filter( 'woocommerce_update_cart_action_cart_updated',  __CLASS__ . '::hpy_cs_woocommerce_update_cart_action_cart_updated' );
		add_action( 'woocommerce_after_cart_table', __CLASS__ . '::hpy_cs_output_hidden_variables' );
	}
	
	/**
	 * @return mixed|void
	 */
	public static function hpy_cs_custom_redirect_continue_shopping() {
		$cat_referer = get_transient( 'recent_cat' );
		$continue_destination = get_option( 'hpy_cs_destination' );
		$custom_link = get_option( 'hpy_cs_custom_link' );
		$siteurl = get_site_url();
		
		//Begin the switch to check which option has been selected in the admin area.
		switch( $continue_destination ) {
			
			case "shop" :
				$shop_id = get_option( 'woocommerce_shop_page_id' );
				$returnlink = get_permalink( $shop_id );
				break;
			
			case "recent_prod" :
				
				$cart_link = wc_get_cart_url();
				
				if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
					if( $_SERVER['HTTP_REFERER'] != $cart_link ) {
						self::$referer = $_SERVER['HTTP_REFERER'];
					}
				}
				
				if ( isset( self::$referer ) ) {
					$returnlink = self::$referer;
				} else {
					if ( !empty( $_POST['hpy_cs_referer'] ) ) {
						self::$referer = $_POST['hpy_cs_referer'];
						$returnlink = $_POST['hpy_cs_referer'];
					} else {
						$shop_id    = get_option( 'woocommerce_shop_page_id' );
						$returnlink = get_permalink( $shop_id );
					}
				}
				break;
			
			case "recent_cat" :
				//Start a session and update a session variable on each Category load (This will only be used if the back to recent category option is selected.
				if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
					$referringURL = $_SERVER[ "HTTP_REFERER" ];
				} else {
					$referringURL = '';
				}
				
				global $wp;
				$current_url = home_url(add_query_arg(array(), $wp->request));
				
				$permalink_structure = (array) get_option( 'woocommerce_permalinks', array() );
				
				if ( ( $referringURL != wc_get_cart_url() || $current_url == $referringURL ) && strpos( $referringURL, $permalink_structure['product_base'] ) == false ) {
					$returnlink = $referringURL;
				} else if ( !empty( $_POST['hpy_cs_referer'] ) ) {
					$returnlink = $_POST['hpy_cs_referer'];
				} else if ( !empty( $cat_referer ) ) {
					$returnlink = $cat_referer;
				} else {
					$shop_id = get_option( 'woocommerce_shop_page_id' );
					$returnlink = get_permalink( $shop_id );
				}
				
				break;
			
			case "custom" :
				if ( isset( $custom_link ) ) {
					$returnlink = $custom_link;
				} else {
					$shop_id = get_option( 'woocommerce_shop_page_id' );
					$returnlink = get_permalink( $shop_id );
				}
				break;
			
			default :
				$returnlink = $siteurl;
				break;
		}
		
		//Save Referer link to class variable.
		self::$referer = $returnlink;
		
		//return the link we grabbed above.
		return apply_filters( 'hpy_cs_return_continue_link', $returnlink );
	}
	
	public static function hpy_cs_single_prod_load() {
		
		//Start a session and update a session variable on each Category load (This will only be used if the back to recent category option is selected.
		if ( isset( $_SERVER["HTTP_REFERER"] ) ) {
			$referringURL = $_SERVER[ "HTTP_REFERER" ];
		} else {
			$referringURL = '';
		}
		
		if ( strpos( $referringURL, 'basket' ) == false && strpos( $referringURL, '/product/' ) == false ) {
			HPY_CS_Admin::hpy_save_recent_category( $referringURL );
		} else {
			return;
		}
		
	}
	
	public static function hpy_cs_output_notice() {
		
		$display_empty = get_option( 'hpy_cs_empty_cart_notice' );
		
		if ( $display_empty == 'yes' ) {
			$link = self::hpy_cs_custom_redirect_continue_shopping();
			
			$message = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', esc_url($link), esc_html__( HPY_CS_Admin::hpy_cs_get_continue_shopping_text() , 'continue-shopping-for-woocommerce'), esc_html( get_option( 'hpy_cs_empty_cart_text' ) ) );
			$message = apply_filters( 'hpy_cs_empty_cart_notice_html', $message, $link );
			
			wc_print_notice($message);
		}
		
	}
	
	public static function hpy_cs_output_permanent_button() {
		
		$display_constant = get_option( 'hpy_cs_permanent_cart_notice' );
		
		if ( $display_constant == 'yes' && empty( $constant_text ) ) {
			
			$link = self::hpy_cs_custom_redirect_continue_shopping();
			
			$button = sprintf( '<a href="%s" class="button" name="%s" value="%s">%s</a>', esc_url( $link ), 'hpy_cs_continue', esc_attr__( HPY_CS_Admin::hpy_cs_get_continue_shopping_text(), 'continue-shopping-for-woocommerce' ), esc_attr__( HPY_CS_Admin::hpy_cs_get_continue_shopping_text(), 'continue-shopping-for-woocommerce' ) );
			$button = apply_filters( 'hpy_cs_permanent_cart_button_html', $button );
			
			echo $button;
		}
	}
	
	public static function hpy_cs_woocommerce_update_cart_action_cart_updated( $cart_updated ) {
		
		$update_trigger = get_option( 'hpy_cs_trigger_on_update' );
		
		if ( $update_trigger == 'yes' ) {
			if ( $cart_updated ) {
				WC()->cart->calculate_totals();
			}
			
			if ( ! empty( $_POST['proceed'] ) ) {
				wp_safe_redirect( wc_get_checkout_url() );
				exit;
			} elseif ( $cart_updated ) {
				$message = sprintf( '<a href="%s" tabindex="1" class="button wc-forward">%s</a> %s', esc_url( self::hpy_cs_custom_redirect_continue_shopping() ), esc_html__( HPY_CS_Admin::hpy_cs_get_continue_shopping_text(), 'continue-shopping-for-woocommerce' ), __( 'Cart Updated', 'continue-shopping-for-woocommerce' ) );
				$message = apply_filters( 'wc_add_to_cart_message_html', $message );
				wc_add_notice( $message, apply_filters( 'woocommerce_cart_updated_notice_type', 'success' ) );
				$referer = remove_query_arg( array(
					'remove_coupon',
					'add-to-cart'
				), ( wp_get_referer() ? wp_get_referer() : wc_get_cart_url() ) );
				wp_safe_redirect( $referer );
				exit;
			}
			
			return false;
		}
		
		return $cart_updated;
		
	}
	
	public static function hpy_cs_output_hidden_variables() {
		
		$link = self::$referer;
		echo '<input type="hidden" name="hpy_cs_referer" value="' . $link . '" />';
		
	}
	
	public static function fixpath($p) {
		$p=str_replace('\\','/',trim($p));
		return (substr($p,-1)!='/') ? $p.='/' : $p;
	}
	
}

HPY_CS::init();