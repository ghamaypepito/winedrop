<?php
/**
 * Shipping method settings.
 *
 * @package Flexible Shipping.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings for flexible shipment, shipment method
 */

$shipping_classes      = array();
$shipping_classes['0'] = __( 'Select shipment class', 'flexible-shipping' );
foreach ( WC()->shipping->get_shipping_classes() as $shipping_class ) {
	$shipping_classes[ $shipping_class->term_id ] = $shipping_class->name;
}

$base_location = wc_get_base_location();

$integrations = '';
$integrations_tip = false;
$integrations_options = apply_filters( 'flexible_shipping_integration_options', array( '' => __( 'None', 'flexible-shipping' ) ) );

if ( ! isset( $shipping_method['method_free_shipping_label'] ) ) {
	$shipping_method['method_free_shipping_label'] = __( 'Free', 'flexible-shipping' );
}

$this->settings['method_free_shipping'] = $shipping_method['method_free_shipping'];

if ( empty( $shipping_method['method_integration'] ) ) {
	$shipping_method['method_integration'] = '';
}

$method_free_shipping = '';
if ( isset( $shipping_method['method_free_shipping'] ) && '' !== $shipping_method['method_free_shipping'] ) {
	$method_free_shipping = floatval( $shipping_method['method_free_shipping'] );
}

$settings = array(
	'method_enabled'             => array(
		'title'   => __( 'Enable/Disable', 'flexible-shipping' ),
		'type'    => 'checkbox',
		'default' => $shipping_method['method_enabled'],
		'label'   => __( 'Enable this shipment method', 'flexible-shipping' ),
	),
	'method_title'               => array(
		'title'             => __( 'Method Title', 'flexible-shipping' ),
		'type'              => 'text',
		'description'       => __( 'This controls the title which the user sees during checkout.', 'flexible-shipping' ),
		'desc_tip'          => true,
		'default'           => $shipping_method['method_title'],
		'custom_attributes' => array( 'required' => true ),
	),
	'method_description'         => array(
		'title'       => __( 'Method Description', 'flexible-shipping' ),
		'type'        => 'text',
		'description' => __( 'This controls method description which the user sees during checkout.', 'flexible-shipping' ),
		'desc_tip'    => true,
		'default'     => $shipping_method['method_description'],
	),
	array(
		'title'       => '',
		'type'        => 'title',
		'description' => '',
	),
	'method_free_shipping'       => array(
		'title'       => __( 'Free Shipping', 'flexible-shipping' ),
		'type'        => 'price',
		'default'     => $method_free_shipping,
		'description' => __( 'Enter a minimum order amount for free shipment. This will override the costs configured below.', 'flexible-shipping' ),
		'desc_tip'    => true,
	),
	'method_free_shipping_label' => array(
		'title'       => __( 'Free Shipping Label', 'flexible-shipping' ),
		'type'        => 'text',
		'default'     => $shipping_method['method_free_shipping_label'],
		'description' => __( 'Enter additional label for shipment when free shipment available.', 'flexible-shipping' ),
		'desc_tip'    => true,
	),
	WPDesk_Flexible_Shipping::SETTING_METHOD_FREE_SHIPPING_NOTICE => array(
		'title'       => __( '\'Left to free shipping\' notice', 'flexible-shipping' ),
		'type'        => 'checkbox',
		'default'     => isset( $shipping_method[ WPDesk_Flexible_Shipping::SETTING_METHOD_FREE_SHIPPING_NOTICE ] ) ? $shipping_method[ WPDesk_Flexible_Shipping::SETTING_METHOD_FREE_SHIPPING_NOTICE ] : 'no',
		'label'       => __( 'Display the notice with the amount of price left to free shipping', 'flexible-shipping' ),
		'description' => __( 'Tick this option to display the notice in the cart and on the checkout page.', 'flexible-shipping' ),
		'desc_tip'    => true,
	),
	array(
		'title'       => '',
		'type'        => 'title',
		'description' => '',
	),
	'method_calculation_method'  => array(
		'title'       => __( 'Rules Calculation', 'flexible-shipping' ),
		'type'        => 'select',
		'description' => __( 'Select how rules will be calculated. If you choose "sum" the rules order is important.', 'flexible-shipping' ),
		'default'     => $shipping_method['method_calculation_method'],
		'desc_tip'    => true,
		'options'     => array( 'sum' => __( 'Sum', 'flexible-shipping' ) ),
	),
	'method_visibility'          => array(
		'title'   => __( 'Visibility', 'flexible-shipping' ),
		'type'    => 'checkbox',
		'default' => $shipping_method['method_visibility'],
		'label'   => __( 'Show only for logged in users', 'flexible-shipping' ),
	),
	'method_default'             => array(
		'title'   => __( 'Default', 'flexible-shipping' ),
		'type'    => 'checkbox',
		'default' => $shipping_method['method_default'],
		'label'   => __( 'Check the box to set this option as the default selected choice on the cart page.', 'flexible-shipping' ),
	),
);

if ( 1 < count( $integrations_options ) ) {
	$settings['method_integration'] = array(
		'title'       => __( 'Integration', 'flexible-shipping' ),
		'type'        => 'select',
		'desc_tip'    => $integrations_tip,
		'default'     => $shipping_method['method_integration'],
		'options'     => $integrations_options,
	);
}

$settings = apply_filters( 'flexible_shipping_method_settings', $settings, $shipping_method );

if ( isset( $settings['method_max_cost'] ) ) {
	$this->settings['method_max_cost'] = $settings['method_max_cost']['default'];
}

$settings['method_rules'] = array(
	'title'        => __( 'Rules', 'flexible-shipping' ),
	'type'         => 'shipping_rules',
	'default'      => isset( $shipping_method['method_rules'] ) ? $shipping_method['method_rules'] : array(),
	'method_title' => $shipping_method['method_title'],
);

if ( version_compare( WC()->version, '2.6' ) < 0 ) {
	unset( $settings['method_free_shipping_label'] );
}

$docs_link = get_locale() === 'pl_PL' ? 'https://www.wpdesk.pl/docs/flexible-shipping-pro-woocommerce-docs/' : 'https://docs.flexibleshipping.com/article/29-shipping-methods/';

$docs_link .= '?utm_campaign=flexible-shipping&utm_source=user-site&utm_medium=link&utm_term=configure-shipment-methods&utm_content=fs-shippingzone-addnew-seehow';

// Translators: link.
echo '<p>' . sprintf( __( 'See how to %1$sconfigure shipment methods%2$s.', 'flexible-shipping' ), '<a href="' . $docs_link . '" target="_blank">', '</a>' ) . '</p>'; // WPCS: XSS ok.

return $settings;
