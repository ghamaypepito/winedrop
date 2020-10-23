<?php

use WPDesk\FS\TableRate\NewRulesTablePointer\ShippingMethodNewRuleTableSetting;

/**
 * Mainly read only info about FS + debug mode.
 */
class WPDesk_Flexible_Shipping_Settings extends WC_Shipping_Method {

	const METHOD_ID = 'flexible_shipping_info';

	const WOOCOMMERCE_PAGE_WC_SETTINGS = 'wc-settings';

	const WOOCOMMERCE_SETTINGS_SHIPPING_URL = 'admin.php?page=wc-settings&tab=shipping';

	/**
	 * Logger settings.
	 *
	 * @var WPDesk_Flexible_Shipping_Logger_Settings
	 */
	private $logger_settings;

	/**
	 * @var ShippingMethodNewRuleTableSetting
	 */
	private $new_rules_table_settings;

	/**
	 * WPDesk_Flexible_Shipping_Connect constructor.
	 *
	 * @param int $instance_id Instance id.
	 */
	public function __construct(
		$instance_id = 0

	) {
		parent::__construct( $instance_id );
		$this->id           = self::METHOD_ID;
		$this->enabled      = 'no';
		$this->method_title = __( 'Flexible Shipping', 'flexible-shipping' );

		$this->supports = array(
			'settings',
		);

		$this->logger_settings = new WPDesk_Flexible_Shipping_Logger_Settings( $this );

		$this->new_rules_table_settings = new ShippingMethodNewRuleTableSetting();

		$this->init_form_fields();

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	 * Update debug mode.
	 */
	private function update_debug_mode() {
		$this->logger_settings->update_option_from_saas_settings( $this );
	}

	/**
	 * Process admin options.
	 */
	public function process_admin_options() {
		$this->new_rules_table_settings->watch_settings_change();
		parent::process_admin_options();
		$this->update_debug_mode();

		$url = admin_url( self::WOOCOMMERCE_SETTINGS_SHIPPING_URL );
		$url = add_query_arg( 'section', $this->id, $url );
		wp_safe_redirect( $url );
		exit;
	}

	/**
	 * In settings screen?
	 *
	 * @return bool
	 */
	public function is_in_settings() {
		if ( is_admin() && isset( $_GET['page'] ) && isset( $_GET['section'] ) ) {
			$page    = sanitize_key( $_GET['page'] );
			$section = sanitize_key( $_GET['section'] );
			if ( self::WOOCOMMERCE_PAGE_WC_SETTINGS === $page && self::METHOD_ID === $section ) {
				return true;
			}
		}

		return false;
	}


	/**
	 * Initialise Settings Form Fields.
	 */
	public function init_form_fields() {
		$this->form_fields   = array(
			'flexible_shipping' => array(
				'type' => 'flexible_shipping',
			),
		);
		$this->form_fields[] = array(
			'type'  => 'title',
			'title' => __( 'Advanced settings', 'flexible-shipping' )
		);
		$this->form_fields = $this->logger_settings->add_fields_to_settings( $this->form_fields );

		$this->form_fields = $this->new_rules_table_settings->add_fields_to_settings( $this->form_fields );

	}

	/**
	 * Generate FC connect box
	 *
	 * @param string $key Key.
	 * @param array $data Data.
	 *
	 * @return string
	 */
	public function generate_flexible_shipping_html( $key, $data ) {
		ob_start();
		include 'views/html-shipping-settings-info-description.php';
		$notice_content = ob_get_contents();
		ob_end_clean();

		return $notice_content;
	}

	public function generate_settings_html( $form_fields = array(), $echo = \true ) {
		$html = parent::generate_settings_html( $form_fields, $echo );
		ob_start();
		$this->new_rules_table_settings->settings_script();
		$html .= ob_get_clean();
		if ( $echo ) {
			echo $html;
		} else {
			return $html;
		}
	}

}
