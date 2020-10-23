<?php
/**
 *  Rule notices data.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}
?>
<div id="fgf_rule_data_notices" class="fgf-rule-options-wrapper">
	<div class="fgf-options-group">
		<table class="form-table">
			<tbody>

				<?php do_action( 'fgf_before_rule_notices_settings' , $rule_data ) ; ?>

				<tr>
					<th scope='row'>
						<label><?php esc_html_e( 'Display Free Gift Eligibility Notice in Cart for this Rule' , 'free-gifts-for-woocommerce' ) ; ?>
							<?php fgf_wc_help_tip( esc_html__( 'When set to "Show", a notice will be displayed to user in cart and checkout if they are eligible for receiving free gifts.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
						</label>
					</th>
					<td>
						<select name="fgf_rule[fgf_show_notice]" class="fgf_rule_show_notice">
							<option value="1" <?php selected( $rule_data[ 'fgf_show_notice' ] , '1' ) ; ?>><?php esc_html_e( 'Hide' , 'free-gifts-for-woocommerce' ) ; ?></option>
							<option value="2" <?php selected( $rule_data[ 'fgf_show_notice' ] , '2' ) ; ?>><?php esc_html_e( 'Show' , 'free-gifts-for-woocommerce' ) ; ?></option>
						</select>
					</td>
				</tr>

				<tr>
					<th scope='row'>
						<label><?php esc_html_e( 'Free Gifts Eligibility Notice' , 'free-gifts-for-woocommerce' ) ; ?></label>
					</th>
					<td>
						<textarea name="fgf_rule[fgf_notice]" cols="20" rows="5" class="fgf_rule_notice"><?php echo esc_textarea( $rule_data[ 'fgf_notice' ] ) ; ?></textarea>
					</td>
				</tr>

				<?php do_action( 'fgf_after_rule_notices_settings' , $rule_data ) ; ?>

			</tbody>
		</table>
	</div>
	<div class="fgf-options-group">
			<h3><?php esc_html_e( 'Shortcodes' , 'free-gifts-for-woocommerce' ) ; ?></h3>
			<table class="fgf-shortcode-table">
				<tr>
					<th>[free_gift_min_order_total]</th>
					<td><?php esc_html_e( 'The minimum order total required to receive free gift(s)' , 'free-gifts-for-woocommerce' ) ; ?></td>
				</tr>
				<tr>
					<th>[free_gift_min_sub_total]</th>
					<td><?php esc_html_e( 'The minimum cart subtotal required to receive free gift(s)' , 'free-gifts-for-woocommerce' ) ; ?></td>
				</tr>
				<tr>
					<th>[free_gift_min_cart_qty]</th>
					<td><?php esc_html_e( 'The minimum cart quantity required to receive free gift(s)' , 'free-gifts-for-woocommerce' ) ; ?></td>
				</tr>
				<tr>
					<th>[free_gift_min_product_count]</th>
					<td><?php esc_html_e( 'The minimum no.of products which has to be purchased to receive free gift(s)' , 'free-gifts-for-woocommerce' ) ; ?></td>
				</tr>
			</table>
		</div>
</div>
<?php
