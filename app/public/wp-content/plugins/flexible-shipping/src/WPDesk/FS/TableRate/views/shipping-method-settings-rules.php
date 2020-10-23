<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$options_based_on = array(
	'none' 		=> __( 'Always', 'flexible-shipping' ),
	'value'  	=> sprintf( __( 'Price [%1$s]', 'flexible-shipping' ), __( get_woocommerce_currency_symbol( get_option( 'woocommerce_currency' ) ) ) ),
	'weight'  	=> sprintf( __( 'Weight [%1$s]', 'flexible-shipping' ), __( get_option( 'woocommerce_weight_unit' ) ) ),
);


$key = 'method_rules[xxx][based_on]';
$args_based_on = array(
	'label'     => __( 'When:', 'flexible-shipping' ),
	'type' 		=> 'select',
	'options' 	=> $options_based_on,
	'input_class'       => array( 'hs-beacon-search', 'condition_field' ),
	'custom_attributes' => array(
		'data-beacon_search' => __( 'Based on', 'flexible-shipping' ),
	),
	'return' 	=> true,
);
$value = 'none';
$field_based_on = woocommerce_form_field( $key, $args_based_on, $value );

$key = 'method_rules[xxx][min]';
$args_min = array(
	'label'     => __( 'is from:', 'flexible-shipping' ),
	'type' 		 	=> 'text',
	'return' 	 	=> true,
	'input_class'	=> array( 'wc_input_price', 'hs-beacon-search', 'parameter_min' ),
	'custom_attributes' => array(
		'data-beacon_search' => __( 'Min', 'flexible-shipping' ),
	),
);
$value = '';
$field_min = woocommerce_form_field( $key, $args_min, wc_format_localized_price( $value ) );

$key = 'method_rules[xxx][max]';
$args_max = array(
	'label'     => __( 'to:', 'flexible-shipping' ),
	'type' 		=> 'text',
	'return' 	=> true,
	'input_class'	=> array( 'wc_input_price', 'hs-beacon-search', 'parameter_max' ),
	'custom_attributes' => array(
		'data-beacon_search' => __( 'Max', 'flexible-shipping' ),
	),
);
$value = '';
$field_max = woocommerce_form_field( $key, $args_max, wc_format_localized_price( $value ) );

$key = 'method_rules[xxx][cost_per_order]';
$args_cost_per_order  = array(
    'label'     => __( 'Rule cost:', 'flexible-shipping' ),
	'description' => __( get_woocommerce_currency_symbol( get_option( 'woocommerce_currency' ) ) ),
	'type' 		=> 'text',
	'return' 	=> true,
	'input_class'	=> array( 'wc_input_price', 'hs-beacon-search' ),
	'custom_attributes' => array(
		'data-beacon_search' => __( 'Cost per order', 'flexible-shipping' ),
	),
);
$value                = '';
$field_cost_per_order = woocommerce_form_field( $key, $args_cost_per_order, wc_format_localized_price( $value ) );

$count_rules = 0;
?>

<tr valign="top" class="flexible_shipping_method_rules">
	<th class="forminp" colspan="2">
		<label for="<?php echo esc_attr( $field_key ); ?>"><span id="<?php echo esc_attr( $field_key . '_label' ); ?>"><?php echo $data['title']; ?></span></label>
		<?php
		$fs_pro_link = get_locale() === 'pl_PL' ? 'https://www.wpdesk.pl/sklep/flexible-shipping-pro-woocommerce/' : 'https://flexibleshipping.com/table-rate/';

		if ( ! wpdesk_is_plugin_active( 'flexible-shipping-pro/flexible-shipping-pro.php' ) ):
			?>
			<p><?php printf( __( 'Check %sFlexible Shipping PRO &rarr;%s to add advanced rules based on shipment classes, product/item count or additional handling fees/insurance.', 'flexible-shipping' ), '<a href="' . $fs_pro_link . '?utm_campaign=flexible-shipping&utm_source=user-site&utm_medium=link&utm_term=flexible-shipping-pro&utm_content=fs-shippingzone-addnew-rules" target="_blank">', '</a>' ); ?></p>
		<?php endif; ?>
<!--
        <p><?php echo sprintf(
                __( 'You are currently using the new rules table interface. You can always change it back on the %1$ssettings page%2$s.', 'flexible-shipping' ),
                '<a href="' . esc_attr( admin_url( 'admin.php?page=wc-settings&tab=shipping&section=flexible_shipping_info#woocommerce_flexible_shipping_info_enable_new_rules_table' ) ) . '">',
                '</a>'
            ); ?></p>
-->
	</th>
</tr>
<tr valign="top" class="flexible_shipping_method_rules">
	<td colspan="2" style="padding:0;">
		<table id="<?php echo esc_attr( $field_key ); ?>" class="flexible_shipping_rules wc_input_table sortable widefat fs_new_interface">
			<thead>
			<tr>
				<th class="sort">&nbsp;</th>
                <th class="cb"><input type="checkbox" class="cb"></th>
                <th class="rule_costs">
					<?php _e( 'Costs', 'flexible-shipping' ); ?>
                    <span class="woocommerce-help-tip" data-tip="<?php _e( 'Enter shipment cost for this rule.', 'flexible-shipping' ); ?>"></span>
                </th>
				<th class="rule_conditions">
					<?php _e( 'Conditions', 'flexible-shipping' ); ?>
					<span class="woocommerce-help-tip" data-tip="<?php _e( 'Shipping cost will be calculated when condition is met.', 'flexible-shipping' ); ?>"></span>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php if ( isset( $data['default'] ) ) : ?>
				<?php foreach ( $data['default'] as $key => $rule ) : $count_rules++; ?>
					<tr>
						<td class="sort"></td>
                        <td class="cb"><input type="checkbox" class="cb rule_cb"></td>
                        <td class="cost_per_order">
							<?php
							$key = 'method_rules[' . $count_rules . '][cost_per_order]';
							$value = '';
							if ( isset( $rule['cost_per_order'] ) ) {
								$value = $rule['cost_per_order'];
							}
							echo woocommerce_form_field( $key, $args_cost_per_order, wc_format_localized_price( $value ) );
							?>
                        </td>
						<td class="rule_conditions">
                            <div class="rule_conditions">
                                <div class="single_rule_condition">
                                    <?php
                                    $key = 'method_rules[' . $count_rules . '][based_on]';
                                    $value = '';
                                    if ( isset( $rule['based_on'] ) ) {
                                        $value = $rule['based_on'];
                                    }
                                    echo woocommerce_form_field( $key, $args_based_on, $value );
                                    ?>
                                    <?php
                                    $key = 'method_rules[' . $count_rules . '][min]';
                                    $value = '';
                                    if ( isset( $rule['min'] ) ) {
                                        $value = $rule['min'];
                                    }
                                    echo woocommerce_form_field( $key, $args_min, wc_format_localized_price( $value ) );
                                    ?>
                                    <?php
                                    $key = 'method_rules[' . $count_rules . '][max]';
                                    $value = '';
                                    if ( isset( $rule['max'] ) ) {
                                        $value = $rule['max'];
                                    }
                                    echo woocommerce_form_field( $key, $args_max, wc_format_localized_price( $value ) );
                                    ?>
                                </div>
                            </div>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			</tbody>

			<tfoot>
			<tr>
				<th colspan="99">
					<button id="insert_rule" href="#" class="button plus insert"><?php _e( 'Insert rule', 'flexible-shipping' ); ?></button>
					<button id="remove_rules" href="#" class="button minus" disabled="disabled"><?php _e( 'Delete selected rules', 'flexible-shipping' ); ?></button>
				</th>
			</tr>
			</tfoot>
		</table>

		<script type="text/javascript">
            function append_row( id ) {
                var code = '<tr class="new">\
            					<td class="sort"></td>\
            					<td class="cb"><input type="checkbox" class="cb"></td> \
            					<td class="rule_costs">\
            					   <?php echo str_replace( "'", '"', str_replace( "\r", "", str_replace( "\n", "", $field_cost_per_order ) ) ); ?> \
            					</td>\
            					<td class="rule_conditions">\
       	                            <div class="rule_conditions">\
                                        <div class="single_rule_condition">\
                                            <?php echo str_replace( "'", '"', str_replace( "\r", "", str_replace( "\n", "", $field_based_on ) ) ); ?> \
                                            <?php echo str_replace( "'", '"', str_replace( "\r", "", str_replace( "\n", "", $field_min ) ) ); ?> \
                                            <?php echo str_replace( "'", '"', str_replace( "\r", "", str_replace( "\n", "", $field_max ) ) ); ?> \
                                        </div>\
                                    </div>\
                                </td>\
                        </tr>';
                var code2 = code.replace(/xxx/g, id );
                var $tbody = jQuery('#<?php echo esc_attr( $field_key ); ?>').find('tbody');
                $tbody.append( code2 );
                jQuery('.condition_field').trigger('change');
            }
            jQuery(document).ready(function() {
                var tbody = jQuery('#<?php echo esc_attr( $field_key ); ?>').find('tbody');
                var append_id = <?php echo $count_rules ?>;
                var size = tbody.find('tr').length;

                if ( size === 0 ) {
                    append_id = append_id+1;
                    append_row(append_id);
                    jQuery('#insert_rule').trigger( 'insert_rule' , [append_id] );
                }

                jQuery('#insert_rule').click(function() {
                    append_id = append_id+1;
                    append_row(append_id);
                    jQuery('#rules_'+append_id+'_min').focus();
                    jQuery('#insert_rule').trigger( 'insert_rule' , [append_id] );
                    return false;
                });

                jQuery('#remove_rules').click(function() {
                    jQuery('td input.cb').each(function(){
                        if (jQuery(this).is(':checked')) {
                            jQuery(this).closest('tr').remove();
                        }
                    });
                    jQuery('td input.cb').trigger('change');
                    return false;
                });

                jQuery(document).on('click', '.delete_rule',  function() {
                    if (confirm('<?php _e( 'Are you sure?' , 'flexible-shipping' ); ?>')) {
                        jQuery(this).closest('tr').remove();
                    }
                    return false;
                });

                jQuery(document).on('click', 'th input.cb', function(){
                    if (jQuery(this).is(':checked')) {
                        jQuery('td input.cb').attr('checked', 'checked');
                    } else {
                        jQuery('td input.cb').removeAttr('checked');
                    }
                });

                jQuery(document).on('change', 'input.cb', function(){
                    jQuery('#remove_rules').attr('disabled', 'disabled');
                    jQuery('td input.cb').each(function(){
                        if (jQuery(this).is(':checked')) {
                            jQuery('#remove_rules').removeAttr('disabled');
                        }
                    });
                });

                jQuery(document).on('click', 'td input.cb.rule_cb', function(){
                    jQuery('th input.cb').removeAttr('checked');
                });

                jQuery(document).on('change', 'select.condition_field', function(){
                    let toggle = jQuery(this).val() !== 'none';
                    jQuery(this).closest('.single_rule_condition').find('.parameter_min').closest('p.form-row').toggle(toggle);
                    jQuery(this).closest('.single_rule_condition').find('.parameter_max').closest('p.form-row').toggle(toggle);
                });

                jQuery('select.condition_field').each(function(){
                    jQuery(this).trigger('change');
                });

                jQuery('#mainform').attr('action', '<?php echo remove_query_arg( 'added', add_query_arg( 'added', '1' ) ); ?>' );

                jQuery( '.wc_input_table' ).on( 'focus click', 'input', function( e ) {
                    var $this_table = jQuery( this ).closest( 'table, tbody' );
                    jQuery( 'tr', $this_table ).removeClass( 'current' ).removeClass( 'last_selected' );
                })
            });
		</script>
		<script type="text/javascript">
            <?php
            $zone            = WC_Shipping_Zones::get_zone_by( 'instance_id', sanitize_key( $_GET['instance_id'] ) );
            $shipping_method_woo = WC_Shipping_Zones::get_shipping_method( sanitize_key( $_GET['instance_id'] ) );
            $content = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=shipping' ) . '">' . __( 'Shipping Zones', 'woocommerce' ) . '</a> &gt ';
            $content .= '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=shipping&zone_id=' . absint( $zone->get_id() ) ) . '">' . esc_html( $zone->get_zone_name() ) . '</a> &gt ';
            $content .= '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=shipping&instance_id=' . sanitize_key( $_GET['instance_id'] ) ) . '">' . esc_html( $shipping_method_woo->get_title() ) . '</a>';
            if ( isset( $data['method_title'] ) && $data['method_title'] != '' ) {
                $content .= ' &gt ';
                $content .= esc_html( $data['method_title'] );
            }
            else {
                $content .= ' &gt ';
                $content .= __( 'Add New', 'flexible-shipping' );
            }
            ?>
            jQuery('#mainform h2').first().replaceWith( '<h2>' + '<?php echo $content; ?>' + '</h2>' );
        </script>
	</td>
</tr>
