<?php
/* Edit Rule Page */

if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

$categories = fgf_get_wc_categories() ;
?>
<div class="woocommerce fgf_rule_wrapper fgf_update_rule">
	<h2><?php esc_html_e( 'Edit Rule' , 'free-gifts-for-woocommerce' ) ; ?></h2>
	<table class="form-table">
		<tbody>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Rule Status' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span>
						<?php fgf_wc_help_tip( esc_html__( 'When set to Active, the products from this rule will be listed to the user. The user can choose their Free Gift from the available products.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<select name="fgf_rule[fgf_rule_status]">
						<option value="fgf_active" <?php selected( $rule_data[ 'fgf_rule_status' ] , 'fgf_active' ) ; ?>><?php esc_html_e( 'Active' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="fgf_inactive" <?php selected( $rule_data[ 'fgf_rule_status' ] , 'fgf_inactive' ) ; ?>><?php esc_html_e( 'In-active' , 'free-gifts-for-woocommerce' ) ; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Rule Name' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span></label>
				</th>
				<td>
					<input type="text" name="fgf_rule[fgf_rule_name]" value="<?php echo esc_attr( $rule_data[ 'fgf_rule_name' ] ) ; ?>"/>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Description' , 'free-gifts-for-woocommerce' ) ; ?></label>
				</th>
				<td>
					<textarea name="fgf_rule[fgf_rule_description]"><?php echo esc_html( $rule_data[ 'fgf_rule_description' ] ) ; ?></textarea>
				</td>
			</tr>

		</tbody>
	</table>
	<?php
	self::output_panel() ;
	?>
	<p class="submit">
		<input name='fgf_rule_id' type='hidden' value="<?php echo esc_attr( $rule_data[ 'id' ] ) ; ?>" />
		<input name='fgf_save' class='button-primary fgf_save_btn' type='submit' value="<?php esc_attr_e( 'Update Rule' , 'free-gifts-for-woocommerce' ) ; ?>" />
		<?php wp_nonce_field( 'fgf_update_rule' , '_fgf_nonce' , false , true ) ; ?>
	</p>
</div>
<?php
