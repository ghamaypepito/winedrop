<?php
/**
 * Rules banner dont like option.
 *
 * @package WPDesk\FS\TableRate\NewRulesTableBanner
 */

namespace WPDesk\FS\TableRate\NewRulesTableBanner;

use FSVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use WPDesk\FS\TableRate\NewRulesTablePointer\ShippingMethodNewRuleTableSetting;

/**
 * Can update option when dont like is clicked.
 */
class RulesBannerDontLikeOption {

	const OPTION_NAME = 'flexible_shipping_new_rules_dont_like';

	/**
	 * Checks if option is set.
	 *
	 * @return bool Option status.
	 */
	public static function is_option_set() {
		return 1 === intval( get_option( self::OPTION_NAME, '0' ) );
	}

	/**
	 * Set option.
	 */
	public static function set_option() {
		update_option( self::OPTION_NAME, '1' );
	}

}
