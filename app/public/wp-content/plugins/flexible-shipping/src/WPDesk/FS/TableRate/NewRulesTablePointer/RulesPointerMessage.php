<?php
/**
 * Rules pointer message.
 *
 * @package WPDesk\FS\TableRate\NewRulesTablePointer
 */

namespace WPDesk\FS\TableRate\NewRulesTablePointer;

use FSVendor\WPDesk\PluginBuilder\Plugin\Hookable;
use FSVendor\WPDesk\Pointer\PointerConditions;
use FSVendor\WPDesk\Pointer\PointerMessage;
use FSVendor\WPDesk\Pointer\PointerPosition;
use FSVendor\WPDesk\Pointer\PointersScripts;
use FSVendor\WPDesk\View\Renderer\SimplePhpRenderer;
use FSVendor\WPDesk\View\Resolver\DirResolver;
use WPDesk\FS\Helpers\ShippingMethod;

/**
 * Can display new rules pointer message.
 */
class RulesPointerMessage implements Hookable {

	const POINTER_ID = 'fs_new_rules_table';

	const NEW_RULES_TABLE_PARAMETER = 'new_rules_table';

	/**
	 * @var RulesPointerOption
	 */
	private $rules_pointer_option;

	/**
	 * RulesPointerMessage constructor.
	 *
	 * @param RulesPointerOption $rules_pointer_option Class object.
	 */
	public function __construct( RulesPointerOption $rules_pointer_option ) {
		$this->rules_pointer_option = $rules_pointer_option;
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'add_pointer_messages' ) );
	}

	/**
	 * Should show pointer.
	 */
	private function should_show_pointer() {
		if ( ! ( new \FSVendor\WPDesk_Tracker_Persistence_Consent() )->is_active()
			|| RulesPointerOption::is_option_set()
			|| wpdesk_is_plugin_active( 'flexible-shipping-pro/flexible-shipping-pro.php' )
			|| ! ShippingMethod::check_if_method_exists_in_zones( 'flexible_shipping' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Add pointer messages if it should be visible.
	 *
	 * @internal
	 */
	public function add_pointer_messages() {
		if ( ! $this->should_show_pointer() ) {
			return;
		}

		$this->create_pointer_message();
	}

	/**
	 * Creates pointer message.
	 */
	private function create_pointer_message() {
		$enable_new_rules_table_link = admin_url( 'admin.php' );
		foreach ( $_GET as $parameter => $value ) {
			$enable_new_rules_table_link = add_query_arg( $parameter, $value, $enable_new_rules_table_link );
		}
		$enable_new_rules_table_link = add_query_arg( self::NEW_RULES_TABLE_PARAMETER, '1', $enable_new_rules_table_link );

		$template_args = array(
			'enable_new_rules_table_link' => $enable_new_rules_table_link,
		);
		$renderer = new SimplePhpRenderer( new DirResolver( __DIR__ . '/views' ) );
		$content = $renderer->render( 'html-rule-pointer-message', $template_args );

		$pointer_conditions = new PointerConditions( 'woocommerce_page_wc-settings', 'manage_woocommerce' );
		$pointer_message    = new PointerMessage(
			self::POINTER_ID,
			'#woocommerce_flexible_shipping_method_rules_label',
			__( 'Any problems with configuration?', 'flexible-shipping' ),
			$content,
			new PointerPosition( PointerPosition::LEFT, PointerPosition::BOTTOM ),
			'wp-pointer',
			330,
			$pointer_conditions,
			array(
				'margin-left' => '10px',
				'font-weight' => 'initial',
			)
		);
	}

}
