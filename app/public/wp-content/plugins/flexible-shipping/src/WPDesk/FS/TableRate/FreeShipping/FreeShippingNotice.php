<?php
/**
 * Free Shipping Notice.
 *
 * @package WPDesk\FS\TableRate\FreeShipping
 */

namespace WPDesk\FS\TableRate\FreeShipping;

use FSVendor\WPDesk\PluginBuilder\Plugin\Hookable;

/**
 * Can display free shipping notice.
 */
class FreeShippingNotice implements Hookable {

	const FLEXIBLE_SHIPPING_FREE_SHIPPING_NOTICE = 'flexible_shipping_free_shipping_notice';
	const NOTICE_TYPE_SUCCESS = 'success';

	/**
	 * @var \WC_Session
	 */
	private $session;

	/**
	 * FreeShippingNotice constructor.
	 *
	 * @param \WC_Session $session .
	 */
	public function __construct( \WC_Session $session ) {
		$this->session = $session;
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'wp_head', array( $this, 'add_notice_if_present' ) );
		add_action( 'woocommerce_after_calculate_totals', array( $this, 'add_notice_if_present' ) );
	}

	/**
	 * Add notice if present.
	 */
	public function add_notice_if_present() {
		$this->remove_previous_notices_if_added();
		if ( is_cart() || is_checkout() || wp_doing_ajax() ) {
			$message_text = $this->session->get( FreeShippingNoticeGenerator::SESSION_VARIABLE, '' );
			if ( ! empty( $message_text ) ) {
				wc_add_notice( $message_text, self::NOTICE_TYPE_SUCCESS, array( self::FLEXIBLE_SHIPPING_FREE_SHIPPING_NOTICE => 'yes' ) );
			}
		}
	}

	/**
	 * Remove previously added notices if present.
	 */
	private function remove_previous_notices_if_added() {
		$all_notices = wc_get_notices();
		foreach ( $all_notices as $notice_type => $notices_for_type ) {
			foreach ( $notices_for_type as $key => $notice ) {
				if ( isset( $notice['data'] ) && isset( $notice['data'][ self::FLEXIBLE_SHIPPING_FREE_SHIPPING_NOTICE ] ) ) {
					unset( $all_notices[ $notice_type ][ $key ] );
					wc_set_notices( $all_notices );
				}
			}
		}
	}

}
