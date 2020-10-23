<?php

/**
 * Brankas Direct Payments Gateway.
 *
 * Provides a Brankas Direct Payment Gateway.
 *
 * @class       WC_Gateway_Brankas
 * @extends     WC_Payment_Gateway
 * @version     1.0.8
 * @package     WooCommerce/Classes/Payment
 */
class WC_Gateway_Brankas extends WC_Payment_Gateway {

	/**
	 * Constructor for the gateway.
	 */
	public function __construct() {
		// Setup general properties.
		$this->setup_properties();

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Get settings.
		$this->title                = $this->get_option( 'title' );
		$this->description          = $this->get_option( 'description' );
		$this->api_key              = $this->get_option( 'api_key' );
		$this->instructions         = $this->get_option( 'instructions' );
		$this->sandbox_mode         = 'yes' === $this->get_option( 'sandbox_mode', 'no' );
		$this->sandbox_api_endpoint = $this->get_option( 'sandbox_api_endpoint' );
		$this->live_api_endpoint    = $this->get_option( 'live_api_endpoint' );
		$this->init_endpoint    	= '/v1/init';
		$this->sources_endpoint    	= '/v1/payment_sources';
		$this->select_placeholder   = $this->get_option( 'select_placeholder' );
		$this->select_field_label   = $this->get_option( 'select_field_label' );
		$this->select_invalid_msg   = $this->get_option( 'select_invalid_msg' );
		$this->payment_field_label   = $this->get_option( 'payment_field_label' );

		if ( $this->sandbox_mode ) {
			/* translators: %s: Link to Brankas Direct sandbox testing guide page */
			$this->description .= ' ' . sprintf( __( '<br /><br />WARNING: SANDBOX ENABLED<br /><br />You can use sandbox testing accounts only. See the <a href="%s">Brankas Direct Payment Sandbox Testing Guide</a> for more details.', 'brankas-direct-wc' ), 'https://brank.as/direct' );
			$this->description  = trim( $this->description );
		}

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
		add_filter( 'woocommerce_payment_complete_order_status', array( $this, 'change_payment_complete_order_status' ), 10, 3 );

		// Customer Emails.
		add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );

		add_action( 'woocommerce_api_wc_gateway_brankas', array( $this, 'check_response' ) );
		add_action( 'valid-brankas-direct-request', array( $this, 'valid_response' ) );
		
		add_filter('brankas_get_payment_sources', array( $this, 'get_payment_sources' ));
		add_filter('brankas_get_config_settings', array( $this, 'get_config_settings' ));
	}

	/**
	 * Setup general properties for the gateway.
	 */
	protected function setup_properties() {
		$this->id                 = 'brankas';
		$this->icon               = apply_filters( 'woocommerce_brankas_icon', plugins_url('../assets/brankas-logo-mark-circle-dark.svg', __FILE__ ) );
		$this->method_title       = __( 'Brankas Direct Payments', 'brankas-direct-wc' );
		$this->api_key            = __( 'Add API Key', 'brankas-direct-wc' );
		$this->method_description = __( 'Let your customers pay with Brankas Direct Payments.', 'brankas-direct-wc' );
		$this->has_fields         = false;
	}

	/**
	 * Initialise Gateway Settings Form Fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled'            => array(
				'title'       => __( 'Enable/Disable', 'brankas-direct-wc' ),
				'label'       => __( 'Enable Brankas Direct Payments', 'brankas-direct-wc' ),
				'type'        => 'checkbox',
				'description' => '',
				'default'     => 'no',
			),
			'sandbox_mode'              => array(
				'title'       => __( 'Enable/Disable Sandbox', 'brankas-direct-wc' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable Brankas Direct Payments Sandbox environment', 'brankas-direct-wc' ),
				'default'     => 'no',
				'description' => __( 'Brankas Direct Payment Sandbox can be used to test payments with a dummy bank account' , 'brankas-direct-wc' ),
				'desc_tip'    => true,
			),			
			'api_key'             => array(
				'title'       => __( 'API Key', 'brankas-direct-wc' ),
				'type'        => 'text',
				'description' => __( 'Add your API key that has been given to you by Brankas', 'brankas-direct-wc' ),
				'desc_tip'    => true,
			),
			'live_api_endpoint' => array(
				'title'       => __( 'Live API endpoint', 'brankas-direct-wc' ),
				'type'        => 'text',
				'description' => __( 'Live endpoint to use to perform an actual payment. Default value is "https://api.wc-direct.bnk.to/v1/init"', 'brankas-direct-wc' ),
				'default'     => 'https://api.wc-direct.bnk.to/v1/init',
				'desc_tip'    => true,
			),
			'sandbox_api_endpoint' => array(
				'title'       => __( 'Sandbox API Endpoint', 'brankas-direct-wc' ),
				'type'        => 'text',
				'description' => __( 'Sandbox endpoint to verify test payments. Default value is "https://api.wc-direct.staging.bnk.to/v1/init"', 'brankas-direct-wc' ),
				'default'     => 'https://api.wc-direct.staging.bnk.to/v1/init',
				'desc_tip'    => true,
			),
			'title'              => array(
				'title'       => __( 'Checkout Title', 'brankas-direct-wc' ),
				'type'        => 'text',
				'description' => __( 'Brankas Direct Payment method description that the customer will see on your checkout.', 'brankas-direct-wc' ),
				'default'     => __( 'Brankas Direct Payment', 'brankas-direct-wc' ),
				'desc_tip'    => true,
			),
			'description'        => array(
				'title'       => __( 'Checkout Description', 'brankas-direct-wc' ),
				'type'        => 'textarea',
				'description' => __( 'Brankas Direct Payment method description that the customer will see on checkout.', 'brankas-direct-wc' ),
				'default'     => __( 'Pay using Brankas Direct - secure, simplified bank transfers with no fees.', 'brankas-direct-wc' ),
				'desc_tip'    => true,
			),
			'instructions'       => array(
				'title'       => __( 'Order Instructions', 'brankas-direct-wc' ),
				'type'        => 'textarea',
				'description' => __( 'Instructions that will be added to the Order Received thank you page.', 'brankas-direct-wc' ),
				'default'     => __( 'Thank you for using Brankas Direct Payments', 'brankas-direct-wc' ),
				'desc_tip'    => true,
			),
			'select_placeholder'	  => array(
				'title'       => __( 'Dropdown Placeholder', 'brankas-direct-wc' ),
				'type'        => 'text',
				'description' => __( 'The placeholder text on the bank selection dropdown', 'brankas-direct-wc' ),
				'default'     => __( 'Choose Bank', 'brankas-direct-wc' ),
				'desc_tip'    => true,
			),
			'select_field_label'	  => array(
				'title'       => __( 'Dropdown Field Label', 'brankas-direct-wc' ),
				'type'        => 'text',
				'description' => __( 'The label that appears above the bank selection dropdown', 'brankas-direct-wc' ),
				'default'     => __( 'Select a bank to transfer from', 'brankas-direct-wc' ),
				'desc_tip'    => true,
			),
			'select_invalid_msg'	  => array(
				'title'       => __( 'Dropdown Validation Error Text', 'brankas-direct-wc' ),
				'type'        => 'text',
				'description' => __( 'The error notice that appears when a bank selection has not been made', 'brankas-direct-wc' ),
				'default'     => __( 'Please select a Bank to start your Brankas Direct Payment', 'brankas-direct-wc' ),
				'desc_tip'    => true,
			),
			'payment_field_label'	  => array(
				'title'       => __( 'Payment Field Label', 'brankas-direct-wc' ),
				'type'        => 'text',
				'description' => __( 'The label that on the billing and order details', 'brankas-direct-wc' ),
				'default'     => __( 'Selected Payment Bank', 'brankas-direct-wc' ),
				'desc_tip'    => true,
			),
		);
	}

	/**
	 * Return a set of plugin config settings
	 *
	 * @return array
	 */
	public function get_config_settings() {
		return [
			'select_placeholder' => $this->select_placeholder,
			'select_field_label' => $this->select_field_label,
			'select_invalid_msg' => $this->select_invalid_msg,
			'payment_field_label' => $this->payment_field_label
		];
	}

	/**
	 * Check for Brankas Direct Response.
	 */
	public function check_response() {
		if ( ! empty( $_POST ) ) { // WPCS: CSRF ok.
			$posted = wp_unslash( $_POST ); // WPCS: CSRF ok, input var ok.

			// phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
			do_action( 'valid-brankas-direct-request', $posted );
			
			exit;
		}

		wp_die( 'Brankas Direct Request Failure', 'Brankas Direct', array( 'response' => 500 ) );
	}

	/**
	 * There was a valid response.
	 *
	 * @param  array $posted Post data after wp_unslash.
	 */
	public function valid_response( $posted ) {
		$order = ! empty( $posted['order_id'] ) ? wc_get_order( $posted['order_id'] ) : false;

		if ( $order ) {
			$posted['payment_status'] = strtolower( $posted['payment_status'] );

			if ( method_exists( $this, 'payment_status_' . $posted['payment_status'] ) ) {
				call_user_func( array( $this, 'payment_status_' . $posted['payment_status'] ), $order, $posted );
			}
		}
	}
	/**
	 * Handle a pending payment.
	 *
	 * @param WC_Order $order  Order object.
	 * @param array    $posted Posted data.
	 */
	protected function payment_status_pending( $order, $posted ) {
		$this->payment_status_completed( $order, $posted );
	}

	/**
	 * Handle a failed payment.
	 *
	 * @param WC_Order $order  Order object.
	 * @param array    $posted Posted data.
	 */
	protected function payment_status_failed( $order, $posted ) {
		/* translators: %s: payment status. */
		$order->update_status( 'failed', sprintf( __( 'Payment %s via Brankas Direct.', 'brankas-direct-wc' ), wc_clean( $posted['payment_status'] ) ) );
	}

	/**
	 * Handle a denied payment.
	 *
	 * @param WC_Order $order  Order object.
	 * @param array    $posted Posted data.
	 */
	protected function payment_status_denied( $order, $posted ) {
		$this->payment_status_failed( $order, $posted );
	}

	/**
	 * Handle an expired payment.
	 *
	 * @param WC_Order $order  Order object.
	 * @param array    $posted Posted data.
	 */
	protected function payment_status_expired( $order, $posted ) {
		$this->payment_status_failed( $order, $posted );
	}

	/**
	 * Handle an cancelled payment.
	 *
	 * @param WC_Order $order  Order object.
	 * @param array    $posted Posted data.
	 */
	protected function payment_status_cancelled( $order, $posted ) {
		$this->payment_status_pending( $order, $posted );
	}

	/**
	 * Handle a completed payment.
	 *
	 * @param WC_Order $order  Order object.
	 * @param array    $posted Posted data.
	 */
	protected function payment_status_completed( $order, $posted ) {
		if ( $order->has_status( wc_get_is_paid_statuses() ) ) {
			exit;
		}

		$this->validate_currency( $order, $posted['currency'] );
		$this->validate_amount( $order, $posted['amount'] );
		$this->save_brankas_direct_meta_data( $order, $posted );

		if ( 'completed' === $posted['payment_status'] ) {

			$this->payment_complete( $order, ( ! empty( $posted['txn_id'] ) ? wc_clean( $posted['txn_id'] ) : '' ), __( 'Brankas Direct payment completed', 'brankas-direct-wc' ) );
		} else {
				/* translators: %s: pending reason. */
				$this->payment_on_hold( $order, sprintf( __( 'Payment pending (%s).', 'brankas-direct-wc' ), $posted['payment_status'] ) );
		}
	}

	/**
	 * Check currency from Brankas Direct matches the order.
	 *
	 * @param WC_Order $order    Order object.
	 * @param string   $currency Currency code.
	 */
	protected function validate_currency( $order, $currency ) {
		if ( $order->get_currency() !== $currency ) {
			
			/* translators: %s: currency code. */
			$order->update_status( 'on-hold', sprintf( __( 'Validation error: Brankas Direct currencies do not match (code %s).', 'brankas-direct-wc' ), $currency ) );
			exit;
		}
	}

	/**
	 * Check payment amount from Brankas Direct matches the order.
	 *
	 * @param WC_Order $order  Order object.
	 * @param int      $amount Amount to validate.
	 */
	protected function validate_amount( $order, $amount ) {
		if ( number_format( $order->get_total(), 2, '.', '' ) !== number_format( ($amount / 100), 2, '.', '' ) ) {

			/* translators: %s: Amount. */
			$order->update_status( 'on-hold', sprintf( __( 'Validation error: Brankas Direct amounts do not match (gross %s).', 'brankas-direct-wc' ), $amount ) );
			exit;
		}
	}

	/**
	 * Save important data from the Brankas Direct to the order.
	 *
	 * @param WC_Order $order  Order object.
	 * @param array    $posted Posted data.
	 */
	protected function save_brankas_direct_meta_data( $order, $posted ) {
		if ( ! empty( $posted['txn_id'] ) ) {
			update_post_meta( $order->get_id(), '_transaction_id', wc_clean( $posted['txn_id'] ) );
		}
		if ( ! empty( $posted['payment_status'] ) ) {
			update_post_meta( $order->get_id(), '_brankas_direct_status', wc_clean( $posted['payment_status'] ) );
		}
	}


	/**
	 * Complete order, add transaction ID and note.
	 *
	 * @param  WC_Order $order Order object.
	 * @param  string   $txn_id Transaction ID.
	 * @param  string   $note Payment note.
	 */
	protected function payment_complete( $order, $txn_id = '', $note = '' ) {
		if ( ! $order->has_status( array( 'processing', 'completed' ) ) ) {
			$order->add_order_note( $note );
			$order->payment_complete( $txn_id );
			WC()->cart->empty_cart();
		}
	}

	/**
	 * Hold order and add note.
	 *
	 * @param  WC_Order $order Order object.
	 * @param  string   $reason Reason why the payment is on hold.
	 */
	protected function payment_on_hold( $order, $reason = '' ) {
		$order->update_status( 'on-hold', $reason );
		WC()->cart->empty_cart();
	}

	/**
	 * Process the payment and return the result.
	 *
	 * @param int $order_id Order ID.
	 * @return array
	 */
	public function process_payment( $order_id ) {
		include_once dirname( __FILE__ ) . '/class-wc-gateway-brankas-direct-request.php';

		$order          = wc_get_order( $order_id );
		$brankas_request = new WC_Gateway_Brankas_Request( $this );
		$endpoint    = $this->sandbox_mode ? $this->sandbox_api_endpoint : $this->live_api_endpoint;

		return array(
			'result'   => 'success',
			'redirect' => $brankas_request->post_request_init_url( $order, $endpoint . $this->init_endpoint, $this->api_key, $this->sandbox_mode ),
		);
	}

	/**
	 * Process the payment and return the result.
	 *
	 * @param int $order_id Order ID.
	 * @return array
	 */
	public function get_payment_sources() {
		$sourcesTransientId = 'brankas_payment_sources_transient';

		if ( false === ( $data = get_transient( $sourcesTransientId ) ) ) {
			include_once dirname( __FILE__ ) . '/class-wc-gateway-brankas-direct-request.php';
			$brankas_request = new WC_Gateway_Brankas_Request( $this );
			$endpoint    = $this->sandbox_mode ? $this->sandbox_api_endpoint : $this->live_api_endpoint;

			$data = $brankas_request->post_request_payment_sources( $endpoint . $this->sources_endpoint, $this->api_key, $this->sandbox_mode );

			if (! empty ( $data )) {
				set_transient( $sourcesTransientId, $data, 5 * MINUTE_IN_SECONDS );
			}
		}

		return $data;
	}

	/**
	 * Output for the order received page.
	 */
	public function thankyou_page() {
		if ( $this->instructions ) {
			echo wp_kses_post( wpautop( wptexturize( $this->instructions ) ) );
		}
	}

	/**
	 * Change payment complete order status to completed for brankas orders.
	 *
	 * @since  3.1.0
	 * @param  string         $status Current order status.
	 * @param  int            $order_id Order ID.
	 * @param  WC_Order|false $order Order object.
	 * @return string
	 */
	public function change_payment_complete_order_status( $status, $order_id = 0, $order = false ) {
		if ( $order && 'brankas' === $order->get_payment_method() ) {
			$status = 'completed';
		}
		return $status;
	}

	/**
	 * Add content to the WC emails.
	 *
	 * @param WC_Order $order Order object.
	 * @param bool     $sent_to_admin  Sent to admin.
	 * @param bool     $plain_text Email format: plain text or HTML.
	 */
	public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
		if ( $this->instructions && ! $sent_to_admin && $this->id === $order->get_payment_method() ) {
			echo wp_kses_post( wpautop( wptexturize( $this->instructions ) ) . PHP_EOL );
		}
	}
}