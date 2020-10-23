<?php
/**
 *  Rule restrictions data.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

?>
<div id="fgf_rule_data_restrictions" class="fgf-rule-options-wrapper">
	<table class="form-table">
		<tbody>

			<?php do_action( 'fgf_before_rule_restrictions_settings' , $rule_data ) ; ?>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Rule Validity' , 'free-gifts-for-woocommerce' ) ; ?>
						<?php fgf_wc_help_tip( esc_html__( 'If left empty, the rule will be valid on all days.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<?php esc_html_e( 'From' , 'free-gifts-for-woocommerce' ) ; ?>
					<?php
					$rule_valid_from_date_args = array(
						'name'        => 'fgf_rule[fgf_rule_valid_from_date]' ,
						'value'       => $rule_data[ 'fgf_rule_valid_from_date' ] ,
						'wp_zone'     => false ,
						'placeholder' => FGF_Date_Time::get_wp_date_format() ,
							) ;
					fgf_get_datepicker_html( $rule_valid_from_date_args ) ;
					?>
				</td>
				<td>
					<?php esc_html_e( 'To' , 'free-gifts-for-woocommerce' ) ; ?>
					<?php
					$rule_valid_to_date_args   = array(
						'name'        => 'fgf_rule[fgf_rule_valid_to_date]' ,
						'value'       => $rule_data[ 'fgf_rule_valid_to_date' ] ,
						'wp_zone'     => false ,
						'placeholder' => FGF_Date_Time::get_wp_date_format() ,
							) ;
					fgf_get_datepicker_html( $rule_valid_to_date_args ) ;
					?>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Week Day(s) Restrictions' , 'free-gifts-for-woocommerce' ) ; ?>
						<?php fgf_wc_help_tip( esc_html__( 'The rule will be valid for the selected Days. If left empty, the rule will be valid for all days of the week.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>

				<td>
					<select class="fgf-rule-week-days-validation fgf_select2" multiple="multiple" name="fgf_rule[fgf_rule_week_days_validation][]">
						<?php foreach ( fgf_get_rule_week_days_options() as $week_days_id => $week_days_name ) : ?>
							<option value="<?php echo esc_attr( $week_days_id ) ; ?>" <?php echo in_array( $week_days_id , $rule_data[ 'fgf_rule_week_days_validation' ] ) ? 'selected="selected"' : '' ; ?>><?php echo esc_html( $week_days_name ) ; ?></option>
						<?php endforeach ; ?>
					</select>
				</td>
			</tr>

			<?php if ( '2' == get_option( 'fgf_settings_gifts_count_per_order_type' , '2' ) ) : ?>
				<tr>
					<th scope='row'>
						<label><?php esc_html_e( 'Maximum Gifts in an Order from this Rule' , 'free-gifts-for-woocommerce' ) ; ?>
							<?php fgf_wc_help_tip( esc_html__( 'If left empty / when the rule value is more the Global Restriction, the Global Restriction will apply.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
						</label>
					</th>
					<td>
						<input type="number" class="fgf_rule_type fgf_manual_rule_type" name="fgf_rule[fgf_rule_gifts_count_per_order]" min="1" value="<?php echo esc_attr( $rule_data[ 'fgf_rule_gifts_count_per_order' ] ) ; ?>"/>
					</td>				
				</tr>
			<?php endif ; ?>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Order Restrictions' , 'free-gifts-for-woocommerce' ) ; ?>
						<?php fgf_wc_help_tip( esc_html__( 'If left empty, the rule will be valid for unlimited orders' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<input type="number" name="fgf_rule[fgf_rule_restriction_count]" min="1" value="<?php echo esc_attr( $rule_data[ 'fgf_rule_restriction_count' ] ) ; ?>"/>
				</td>
				<?php if ( $rule_data[ 'fgf_rule_restriction_count' ] ) : ?>
					<td>    
						<?php
						$remaining_count = max( floatval( $rule_data[ 'fgf_rule_restriction_count' ] - $rule_data[ 'fgf_rule_usage_count' ] ) , 0 ) ;
						/* translators: %s: number of orders and rule usage count */
						echo wp_kses_post( sprintf( esc_html__( 'Orders (%1$s used %2$d remaining)' , 'free-gifts-for-woocommerce' ) , floatval( $rule_data[ 'fgf_rule_usage_count' ] ) , $remaining_count ) ) ;
						?>
						<input type="button" class="fgf_reset_rule_usage_count button-primary" data-rule-id="<?php echo esc_attr( $rule_data[ 'id' ] ) ; ?>" value="<?php esc_attr_e( 'Reset used count' , 'free-gifts-for-woocommerce' ) ; ?>"/>
					</td>
				<?php endif ; ?>
			</tr>

			<?php do_action( 'fgf_after_rule_restrictions_settings' , $rule_data ) ; ?>
		</tbody>
	</table>
</div>
<?php
