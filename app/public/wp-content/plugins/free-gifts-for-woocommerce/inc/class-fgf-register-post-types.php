<?php
/**
 * Custom Post Type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'FGF_Register_Post_Types' ) ) {

	/**
	 * FGF_Register_Post_Types Class.
	 */
	class FGF_Register_Post_Types {
		/*
		 * Rules Post Type.
		 */

		const RULES_POSTTYPE = 'fgf_rules';

		/*
		 * Master Log Post Type.
		 */
		const MASTER_LOG_POSTTYPE = 'fgf_master_log';

		/**
		 * FGF_Register_Post_Types Class initialization.
		 */
		public static function init() {

			add_action( 'init', array( __CLASS__, 'register_custom_post_types' ) );
		}

		/**
		 * Register Custom Post types.
		 */
		public static function register_custom_post_types() {
			if ( ! is_blog_installed() ) {
				return;
			}

			$custom_post_types = array(
				self::RULES_POSTTYPE      => array( 'FGF_Register_Post_Types', 'rules_post_type_args' ),
				self::MASTER_LOG_POSTTYPE => array( 'FGF_Register_Post_Types', 'master_log_post_type_args' ),
			);

			$custom_post_types = apply_filters( 'fgf_add_custom_post_types', $custom_post_types );

			// return if no post type to register.
			if ( ! fgf_check_is_array( $custom_post_types ) ) {
				return;
			}

			foreach ( $custom_post_types as $post_type => $args_function ) {

				$args = array();
				if ( $args_function ) {
					$args = call_user_func_array( $args_function, $args );
				}

				// Register custom post type.
				register_post_type( $post_type, $args );
			}
		}

		/**
		 * Prepare Rules Post type arguments.
		 */
		public static function rules_post_type_args() {

			return apply_filters(
				'fgf_rules_post_type_args',
				array(
					'label'           => esc_html__( 'Rules', 'free-gifts-for-woocommerce' ),
					'public'          => false,
					'hierarchical'    => false,
					'supports'        => false,
					'capability_type' => 'post',
					'rewrite'         => false,
				)
			);
		}

		/**
		 * Prepare Master Log Post type arguments.
		 */
		public static function master_log_post_type_args() {

			return apply_filters(
				'fgf_master_log_post_type_args',
				array(
					'label'           => esc_html__( 'Master Log', 'free-gifts-for-woocommerce' ),
					'public'          => false,
					'hierarchical'    => false,
					'supports'        => false,
					'capability_type' => 'post',
					'rewrite'         => false,
				)
			);
		}

	}

	FGF_Register_Post_Types::init();
}
