<?php
/**
 * User feedback.
 *
 * @package WPDesk\FS\TableRate
 */

namespace WPDesk\FS\TableRate;

use FSVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FSVendor\WPDesk\Tracker\UserFeedback\AjaxUserFeedbackDataHandler;
use FSVendor\WPDesk\Tracker\UserFeedback\Tracker;
use FSVendor\WPDesk\Tracker\UserFeedback\TrackerFactory;
use FSVendor\WPDesk\Tracker\UserFeedback\UserFeedbackData;
use FSVendor\WPDesk\Tracker\UserFeedback\UserFeedbackOption;
use WPDesk\FS\TableRate\NewRulesTableBanner\RulesBannerDontLikeOption;
use WPDesk\FS\TableRate\NewRulesTableBanner\RulesBannerLikeOption;
use WPDesk\FS\TableRate\NewRulesTablePointer\RulesPointerOption;
use WPDesk\FS\TableRate\NewRulesTablePointer\ShippingMethodNewRuleTableSetting;

/**
 * Can display and handle user feedback when disabling new rules settings table.
 */
class UserFeedback implements Hookable {

	const THICKBOX_ID = 'new-rules-table-feedback';
	const USER_FEEDBACK_OPTION = 'flexible_shipping_new_rules_feedback';

	/**
	 * Hooks.
	 */
	public function hooks() {
		if ( ! RulesBannerLikeOption::is_option_set() ) {
			$user_feedback = $this->prepare_user_feedback_tracker();
			$user_feedback->hooks();
		}
		add_action( 'wpdesk_tracker_user_feedback_data_handled', array( $this, 'save_user_feedback' ) );
	}

	/**
	 * Prepares tracker for save user feedback.
	 *
	 * @return Tracker
	 */
	private function prepare_user_feedback_tracker() {
		$user_feedback_data = new UserFeedbackData(
			self::THICKBOX_ID,
			__( 'You don\'t like new interface?', 'flexible-shipping' ),
			'',
			__( 'What should we do to improve your experience?', 'flexible-shipping' ),
			'woocommerce_page_wc-settings'
		);
		$user_feedback_data->add_feedback_option(
			new UserFeedbackOption(
				'have_comment',
				'',
				true,
				__( 'Comment', 'flexible-shipping' )
			)
		);

		return TrackerFactory::create_custom_tracker_with_null_sender( $user_feedback_data );
	}

	/**
	 * Saves user feedback for lated sending by Tracker.
	 *
	 * @param array $payload Tracker request data.
	 */
	public function save_user_feedback( $payload ) {
		if ( is_array( $payload ) && isset( $payload[ AjaxUserFeedbackDataHandler::FEEDBACK_ID ] ) && self::THICKBOX_ID === $payload[ AjaxUserFeedbackDataHandler::FEEDBACK_ID ] ) {
			update_option( self::USER_FEEDBACK_OPTION, $payload );
		}
		RulesBannerDontLikeOption::set_option();
	}

}
