<?php

/**
 * Admin Assets
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}
if ( ! class_exists( 'FGF_Admin_Assets' ) ) {

	/**
	 * Class.
	 */
	class FGF_Admin_Assets {

		/**
		 * Class Initialization.
		 */
		public static function init() {

			add_action( 'admin_enqueue_scripts' , array( __CLASS__ , 'external_js_files' ) ) ;
			add_action( 'admin_enqueue_scripts' , array( __CLASS__ , 'external_css_files' ) ) ;
		}

		/**
		 * Enqueue external JS files
		 */
		public static function external_css_files() {
			$screen_ids   = fgf_page_screen_ids() ;
			$newscreenids = get_current_screen() ;
			$screenid     = str_replace( 'edit-' , '' , $newscreenids->id ) ;

			if ( ! in_array( $screenid , $screen_ids ) ) {
				return ;
			}

			wp_enqueue_style( 'fgf-admin' , FGF_PLUGIN_URL . '/assets/css/admin.css' , array() , FGF_VERSION ) ;
		}

		/**
		 * Enqueue external JS files
		 */
		public static function external_js_files() {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' ;

			$screen_ids   = fgf_page_screen_ids() ;
			$newscreenids = get_current_screen() ;
			$screenid     = str_replace( 'edit-' , '' , $newscreenids->id ) ;

			$enqueue_array = array(
				'fgf-admin'   => array(
					'callable' => array( 'FGF_Admin_Assets' , 'admin' ) ,
					'restrict' => in_array( $screenid , $screen_ids ) ,
				) ,
				'fgf-select2' => array(
					'callable' => array( 'FGF_Admin_Assets' , 'select2' ) ,
					'restrict' => in_array( $screenid , $screen_ids ) ,
				) ,
					) ;

			$enqueue_array = apply_filters( 'fgf_admin_assets' , $enqueue_array ) ;
			if ( ! fgf_check_is_array( $enqueue_array ) ) {
				return ;
			}

			foreach ( $enqueue_array as $key => $enqueue ) {
				if ( ! fgf_check_is_array( $enqueue ) ) {
					continue ;
				}

				if ( $enqueue[ 'restrict' ] ) {
					call_user_func_array( $enqueue[ 'callable' ] , array( $suffix ) ) ;
				}
			}
		}

		/**
		 * Enqueue Admin end required JS files
		 */
		public static function admin( $suffix ) {
			// Admin
			wp_enqueue_script( 'fgf-admin' , FGF_PLUGIN_URL . '/assets/js/admin.js' , array( 'jquery' , 'jquery-blockui' ) , FGF_VERSION ) ;
			wp_localize_script(
					'fgf-admin' , 'fgf_admin_params' , array(
				'manual_gift_nonce'         => wp_create_nonce( 'fgf-manual-gift-nonce' ) ,
				'fgf_master_log_info_nonce' => wp_create_nonce( 'fgf-master-log-info-nonce' ) ,
					)
			) ;

			// Rule.
			wp_enqueue_script( 'fgf-rule' , FGF_PLUGIN_URL . '/assets/js/rule.js' , array( 'jquery' , 'jquery-blockui' ) , FGF_VERSION ) ;
			wp_localize_script(
					'fgf-rule' , 'fgf_rule_params' , array(
				'fgf_rules_nonce'      => wp_create_nonce( 'fgf-rules-nonce' ) ,
				'fgf_rules_drag_nonce' => wp_create_nonce( 'fgf-rules-drag-nonce' ) ,
					)
			) ;
		}

		/**
		 * Enqueue select2 scripts and CSS
		 */
		public static function select2( $suffix ) {

			wp_enqueue_script( 'fgf-enhanced' , FGF_PLUGIN_URL . '/assets/js/fgf-enhanced.js' , array( 'jquery' , 'select2' , 'jquery-ui-datepicker' ) , FGF_VERSION ) ;
			wp_localize_script(
					'fgf-enhanced' , 'fgf_enhanced_select_params' , array(
				'search_nonce' => wp_create_nonce( 'fgf-search-nonce' ) ,
				'ajaxurl'      => FGF_ADMIN_AJAX_URL ,
					)
			) ;
		}

	}

	FGF_Admin_Assets::init() ;
}
