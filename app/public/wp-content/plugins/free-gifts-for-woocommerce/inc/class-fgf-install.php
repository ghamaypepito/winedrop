<?php

/**
 * Initialize the Plugin.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'FGF_Install' ) ) {

	/**
	 * Class.
	 */
	class FGF_Install {

		/**
		 *  Class initialization.
		 */
		public static function init() {
			add_filter( 'plugin_action_links_' . FGF_PLUGIN_SLUG, array( __CLASS__, 'settings_link' ) );
		}

		/**
		 * Install
		 */
		public static function install() {
			self::set_default_values(); // default values
			self::update_version();
		}

		/**
		 * Update current version.
		 */
		private static function update_version() {
			update_option( 'fgf_version', FGF_VERSION );
		}

		/**
		 *  Settings link.
		 */
		public static function settings_link( $links ) {
			$setting_page_link = '<a href="' . fgf_get_settings_page_url() . '">' . esc_html__( 'Settings', 'free-gifts-for-woocommerce' ) . '</a>';

			array_unshift( $links, $setting_page_link );

			return $links;
		}

		/**
		 *  Set settings default values
		 */
		public static function set_default_values() {
			if ( ! class_exists( 'FGF_Settings' ) ) {
				include_once( FGF_PLUGIN_PATH . '/inc/admin/menu/class-fgf-settings.php' );
			}

			// default for settings
			$settings = FGF_Settings::get_settings_pages();

			foreach ( $settings as $setting ) {
				$sections = $setting->get_sections();
				if ( ! fgf_check_is_array( $sections ) ) {
					continue;
				}

				foreach ( $sections as $section_key => $section ) {
					$settings_array = $setting->get_settings( $section_key );
					foreach ( $settings_array as $value ) {
						if ( isset( $value['default'] ) && isset( $value['id'] ) ) {
							if ( get_option( $value['id'] ) === false ) {
								add_option( $value['id'], $value['default'] );
							}
						}
					}
				}
			}
		}

	}

	FGF_Install::init();
}
