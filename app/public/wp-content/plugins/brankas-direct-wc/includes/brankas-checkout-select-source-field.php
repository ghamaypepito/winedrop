<?php

add_filter( 'woocommerce_gateway_description', 'brankas_source_field', 20, 2 );
function brankas_source_field( $description, $payment_id ) {
    
    if ( 'brankas' !== $payment_id ) {
        return $description;
    }
    
    $settings = apply_filters('brankas_get_config_settings', null);
    $placeholder = $settings['select_placeholder'];
    $selectFieldLabel = $settings['select_field_label'];

    ob_start();

    $sources = null;
    if(has_filter('brankas_get_payment_sources')) {
		$sources = apply_filters('brankas_get_payment_sources', null);
    }

    echo '<div style="display: block; width:300px; height:auto;">';
    
    // For WC HTML options array
    $options = '<option value="" selected="selected">' . __( $placeholder, 'brankas-direct-wc' ) . '</option>';
    foreach($sources as $key => $value) {
        $disabled = ($value['status'] == 'Online') ? '' : 'disabled';
        $options .= '<option value="' . $value['code'] . '" ' . $disabled . '>' . __( $value['name'], 'brankas-direct-wc' ) . '</option>';
    }

    echo 
        "<p class='form-row form-row form-row-wide validate-required woocommerce-invalid woocommerce-invalid-required-field' id='payment_source_field' data-priority='>
            <label for='payment_source' style='font-weight: bold;'>" . __( $selectFieldLabel, 'brankas-direct-wc' ) . "&nbsp;<abbr class='required' title='required'>*</abbr></label>
            <span class='woocommerce-input-wrapper'>
                <select name='payment_source' id='payment_source' class='select' data-allow_clear='true' data-placeholder='" . __( $placeholder, 'brankas-direct-wc' ) . "'>"
                . $options .
                "</select>
            </span>
        </p>";
    
    echo
        "<script type='text/javascript'>
            jQuery('#payment_source').select2({
                placeholder: '" . __( $placeholder, 'brankas-direct-wc' ) . "',
                minimumResultsForSearch: Infinity,
                width: '100%'
            });
        </script>";
    echo "</div>";

    $description .= ob_get_clean();

    return $description;
}

add_action( 'woocommerce_checkout_process', 'brankas_source_field_validation' );
function brankas_source_field_validation() {
    if( 'brankas' === $_POST['payment_method'] && ! isset( $_POST['payment_source'] )  || empty( $_POST['payment_source'] ) ) {
        $settings = apply_filters('brankas_get_config_settings', null);
        wc_add_notice( $settings['select_invalid_msg'], 'error' );
    }
}

add_action( 'woocommerce_checkout_update_order_meta', 'brankas_checkout_update_order_meta', 10, 1 );
function brankas_checkout_update_order_meta( $order_id ) {
    if( isset( $_POST['payment_source'] ) || ! empty( $_POST['payment_source'] ) ) {
       update_post_meta( $order_id, 'payment_source', $_POST['payment_source'] );
    }
}

// Used on Order Details page
add_action( 'woocommerce_admin_order_data_after_billing_address', 'brankas_order_data_after_billing_address', 10, 1 );
function brankas_order_data_after_billing_address( $order ) {
    $settings = apply_filters('brankas_get_config_settings', null);
    echo '<p><strong>' . __( $settings['payment_field_label'], 'brankas-direct-wc' ) . '</strong><br>' . get_post_meta( $order->get_id(), 'payment_source', true ) . '</p>';
}

// TODO: I'm not sure what these are needed for yet?
add_action( 'woocommerce_order_item_meta_end', 'brankas_order_item_meta_end', 10, 3 );
function brankas_order_item_meta_end( $item_id, $item, $order ) {
    $settings = apply_filters('brankas_get_config_settings', null);
    echo '<p><strong>' . __( $settings['payment_field_label'], 'brankas-direct-wc' ) . '</strong><br>' . get_post_meta( $order->get_id(), 'payment_source', true ) . '</p>';
}

