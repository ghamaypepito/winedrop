<?php

/**
 * Free Gifts for WooCommerce Main Class
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( ! class_exists( 'FP_Free_Gift' ) ) {

	/**
	 * Main FP_Free_Gift Class.
	 * */
	final class FP_Free_Gift {

		/**
		 * Version.
		 * */
		private $version = '5.6' ;

		/**
		 * Notifications.
		 * */
		protected $notifications ;

		/**
		 * The single instance of the class.
		 * */
		protected static $_instance = null ;

		/**
		 * Load FP_Free_Gift Class in Single Instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self() ;
			}

			return self::$_instance ;
		}

		/* Cloning has been forbidden */

		public function __clone() {
			_doing_it_wrong( __FUNCTION__ , 'You are not allowed to perform this action!!!' , '1.0' ) ;
		}

		/**
		 * Unserialize the class data has been forbidden.
		 * */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__ , 'You are not allowed to perform this action!!!' , '1.0' ) ;
		}

		/**
		 * Constructor.
		 * */
		public function __construct() {

			/* Include once will help to avoid fatal error by load the files when you call init hook */
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' ) ;

			$this->header_already_sent_problem() ;
			$this->define_constants() ;
			$this->include_files() ;
			$this->init_hooks() ;
		}

		/**
		 * Function to prevent header error that says you have already sent the header.
		 */
		private function header_already_sent_problem() {
			ob_start() ;
		}

		/**
		 * Load plugin the translate files.
		 * */
		private function load_plugin_textdomain() {
			if ( function_exists( 'determine_locale' ) ) {
				$locale = determine_locale() ;
			} else {
				// @todo Remove when start supporting WP 5.0 or later.
				$locale = is_admin() ? get_user_locale() : get_locale() ;
			}

			$locale = apply_filters( 'plugin_locale' , $locale , 'free-gifts-for-woocommerce' ) ;

			unload_textdomain( 'free-gifts-for-woocommerce' ) ;
			load_textdomain( 'free-gifts-for-woocommerce' , WP_LANG_DIR . '/free-gifts-for-woocommerce/free-gifts-for-woocommerce-' . $locale . '.mo' ) ;
			load_plugin_textdomain( 'free-gifts-for-woocommerce' , false , dirname( plugin_basename( FGF_PLUGIN_FILE ) ) . '/languages' ) ;
		}

		/**
		 * Prepare the constants value array.
		 * */
		private function define_constants() {

			$constant_array = array(
				'FGF_VERSION'        => $this->version ,
				'FGF_LOCALE'         => 'free-gifts-for-woocommerce' ,
				'FGF_FOLDER_NAME'    => 'free-gifts-for-woocommerce' ,
				'FGF_ABSPATH'        => dirname( FGF_PLUGIN_FILE ) . '/' ,
				'FGF_ADMIN_URL'      => admin_url( 'admin.php' ) ,
				'FGF_ADMIN_AJAX_URL' => admin_url( 'admin-ajax.php' ) ,
				'FGF_PLUGIN_SLUG'    => plugin_basename( FGF_PLUGIN_FILE ) ,
				'FGF_PLUGIN_PATH'    => untrailingslashit( plugin_dir_path( FGF_PLUGIN_FILE ) ) ,
				'FGF_PLUGIN_URL'     => untrailingslashit( plugins_url( '/' , FGF_PLUGIN_FILE ) ) ,
					) ;

			$constant_array = apply_filters( 'fgf_define_constants' , $constant_array ) ;

			if ( is_array( $constant_array ) && ! empty( $constant_array ) ) {
				foreach ( $constant_array as $name => $value ) {
					$this->define_constant( $name , $value ) ;
				}
			}
		}

		/**
		 * Define the Constants value.
		 * */
		private function define_constant( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name , $value ) ;
			}
		}

		/**
		 * Include required files.
		 * */
		private function include_files() {

			// Function.
			include_once( FGF_ABSPATH . 'inc/fgf-common-functions.php' ) ;

			// Abstract classes.
			include_once( FGF_ABSPATH . 'inc/abstracts/class-fgf-post.php' ) ;
			// Classes.
			include_once( FGF_ABSPATH . 'inc/notifications/class-fgf-notification-instances.php' ) ;
			include_once( FGF_ABSPATH . 'inc/compatibility/class-fgf-compatibility-instances.php' ) ;

			include_once( FGF_ABSPATH . 'inc/class-fgf-register-post-types.php' ) ;
			include_once( FGF_ABSPATH . 'inc/class-fgf-register-post-status.php' ) ;

			include_once( FGF_ABSPATH . 'inc/class-fgf-install.php' ) ;
			include_once( FGF_ABSPATH . 'inc/class-fgf-date-time.php' ) ;
			include_once( FGF_ABSPATH . 'inc/privacy/class-fgf-privacy.php' ) ;

			// Query.
			include_once( FGF_ABSPATH . 'inc/class-fgf-query.php' ) ;

			include_once( FGF_ABSPATH . 'inc/class-fgf-order-handler.php' ) ;

			// Entity.
			include_once( FGF_ABSPATH . 'inc/entity/class-fgf-rule.php' ) ;
			include_once( FGF_ABSPATH . 'inc/entity/class-fgf-master-log.php' ) ;

			if ( is_admin() ) {
				$this->include_admin_files() ;
			}

			if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {
				$this->include_frontend_files() ;
			}
		}

		/**
		 * Include admin files.
		 * */
		private function include_admin_files() {
			include_once( FGF_ABSPATH . 'inc/admin/class-fgf-admin-assets.php' ) ;
			include_once( FGF_ABSPATH . 'inc/admin/class-fgf-admin-ajax.php' ) ;
			include_once( FGF_ABSPATH . 'inc/admin/menu/class-fgf-menu-management.php' ) ;
			include_once( FGF_ABSPATH . 'inc/class-fgf-manual-gift-order-handler.php' ) ;
		}

		/**
		 * Include frontend files.
		 * */
		private function include_frontend_files() {
			include_once( FGF_ABSPATH . 'inc/frontend/class-fgf-frontend-assets.php' ) ;
			include_once( FGF_ABSPATH . 'inc/frontend/class-fgf-frontend.php' ) ;
			include_once( FGF_ABSPATH . 'inc/frontend/class-fgf-shortcodes.php' ) ;
			include_once( FGF_ABSPATH . 'inc/frontend/class-fgf-gift-products-handler.php' ) ;
			include_once( FGF_ABSPATH . 'inc/frontend/class-fgf-notices-handler.php' ) ;
			include_once( FGF_ABSPATH . 'inc/frontend/class-fgf-rule-handler.php' ) ;
		}

		/**
		 * Define the hooks.
		 * */
		private function init_hooks() {

			// Init the plugin.
			add_action( 'init' , array( $this , 'init' ) ) ;

			add_action( 'plugins_loaded' , array( $this , 'plugins_loaded' ) ) ;
			// Register the plugin.
			register_activation_hook( FGF_PLUGIN_FILE , array( 'FGF_Install' , 'install' ) ) ;
		}

		/**
		 * Init.
		 * */
		public function init() {

			$this->load_plugin_textdomain() ;
		}

		/**
		 * Plugins Loaded.
		 * */
		public function plugins_loaded() {
			do_action( 'fgf_before_plugin_loaded' ) ;

			$this->notifications = FGF_Notification_Instances::get_notifications() ;

			FGF_Compatibility_Instances::instance() ;

			do_action( 'fgf_after_plugin_loaded' ) ;
		}

		/**
		 * Templates.
		 * */
		public function templates() {
			return FGF_PLUGIN_PATH . '/templates/' ;
		}

		/**
		 * Notifications instances.
		 * */
		public function notifications() {
			return $this->notifications ;
		}

		/**
		 * Compatibility instances.
		 * */
		public function compatibility() {
			return FGF_Compatibility_Instances::instance() ;
		}

	}

}

