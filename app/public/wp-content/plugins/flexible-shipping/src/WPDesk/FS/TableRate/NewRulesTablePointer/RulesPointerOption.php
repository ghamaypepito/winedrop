<?php
/**
 * Rules pointer option.
 *
 * @package WPDesk\FS\TableRate\NewRulesTablePointer
 */

namespace WPDesk\FS\TableRate\NewRulesTablePointer;

use FSVendor\WPDesk\PluginBuilder\Plugin\Hookable;

/**
 * Can update option when pointer is clicked.
 */
class RulesPointerOption implements Hookable {

	const OPTION_NAME = 'flexible_shipping_new_rules_pointer_clicked';

	const SHIPPING_METHOD_SETTINGS_OPTION = 'woocommerce_flexible_shipping_info_settings';
	const PRIORITY_FIRST = 1;

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'update_option_on_enabling_new_rules_table' ), self::PRIORITY_FIRST );
		add_action( 'update_user_meta', array( $this, 'update_option_on_pointer_dismiss' ), 10, 4 );
		add_action( 'added_user_meta', array( $this, 'update_option_on_pointer_dismiss' ), 10, 4 );
	}

	/**
	 * Update option when enabling new rules table.
	 */
	public function update_option_on_enabling_new_rules_table() {
		if ( current_user_can( 'manage_woocommerce' )
			&& isset( $_GET[ RulesPointerMessage::NEW_RULES_TABLE_PARAMETER ] )
			&& ! self::is_option_set()
		) {
			update_option( self::OPTION_NAME, '1' );
			$this->update_shipping_method_settings();
		}
	}

	/**
	 * Update shipping method settings.
	 */
	private function update_shipping_method_settings() {
		$shipping_method_settings                                                     = get_option( self::SHIPPING_METHOD_SETTINGS_OPTION, array() );
		$shipping_method_settings[ShippingMethodNewRuleTableSetting::SETTINGS_OPTION] = 'yes';
		update_option( self::SHIPPING_METHOD_SETTINGS_OPTION, $shipping_method_settings );
	}

	/**
	 * Update option when pointer is dismissed.
	 *
	 * @param int    $meta_id     ID of updated metadata entry.
	 * @param int    $object_id   ID of the object metadata is for.
	 * @param string $meta_key    Metadata key.
	 * @param mixed  $_meta_value Metadata value. Serialized if non-scalar.
	 */
	public function update_option_on_pointer_dismiss( $meta_id, $object_id, $meta_key, $_meta_value ) {
		if ( 'dismissed_wp_pointers' === $meta_key && ! self::is_option_set() ) {
			$dismissed = explode( ',', (string) $_meta_value );
			if ( in_array( RulesPointerMessage::POINTER_ID, $dismissed ) ) {
				update_option( self::OPTION_NAME, '1' );
			}
		}
	}

	/**
	 * Checks if pointer is active.
	 *
	 * @return bool Option status.
	 */
	public static function is_option_set() {
		return 1 === intval( get_option( self::OPTION_NAME, '0' ) );
	}

}
