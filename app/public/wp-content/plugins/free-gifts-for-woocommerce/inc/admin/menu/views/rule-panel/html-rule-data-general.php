<?php
/**
 *  Rule General data.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

$categories        = fgf_get_wc_categories() ;
?>
<div id="fgf_rule_data_general" class="fgf-rule-options-wrapper">
	<table class="form-table">

		<?php do_action( 'fgf_before_rule_general_settings' , $rule_data ) ; ?>

		<tbody>
			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Gift Product Selection Type' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span></label>
				</th>
				<td>
					<select name="fgf_rule[fgf_gift_type]" class = "fgf_gift_type fgf_rule_type fgf_manual_rule_type">
						<option value="1" <?php selected( $rule_data[ 'fgf_gift_type' ] , '1' ) ; ?>><?php esc_html_e( 'Selected Product(s)' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="2" <?php selected( $rule_data[ 'fgf_gift_type' ] , '2' ) ; ?>><?php esc_html_e( 'Products from Selected Categories' , 'free-gifts-for-woocommerce' ) ; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Select Product(s)' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span>
						<?php fgf_wc_help_tip( esc_html__( 'The selected products will be displayed to the user' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<?php
					$gift_product_args = array(
						'class'                   => 'fgf_gift_products fgf_rule_type' ,
						'name'                    => 'fgf_rule[fgf_gift_products]' ,
						'list_type'               => 'products' ,
						'action'                  => 'fgf_json_search_products_and_variations' ,
						'exclude_global_variable' => 'yes' ,
						'placeholder'             => esc_html__( 'Search a Product' , 'free-gifts-for-woocommerce' ) ,
						'options'                 => $rule_data[ 'fgf_gift_products' ] ,
							) ;
					fgf_select2_html( $gift_product_args ) ;
					?>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Select Categories' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span>
						<?php fgf_wc_help_tip( esc_html__( 'The products from the selected categories will be displayed to the user' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<select class="fgf_gift_categories fgf_select2 fgf_rule_type" name="fgf_rule[fgf_gift_categories][]" multiple="multiple">
						<?php
						foreach ( $categories as $category_id => $category_name ) :
							$selected = ( in_array( $category_id , $rule_data[ 'fgf_gift_categories' ] ) ) ? ' selected="selected"' : '' ;
							?>
							<option value="<?php echo esc_attr( $category_id ) ; ?>"<?php echo esc_attr( $selected ) ; ?>><?php echo esc_html( $category_name ) ; ?></option>
						<?php endforeach ; ?>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Quantity for Selected Free Gift Product(s)' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span></label>
				</th>
				<td>
					<input type="number" class="fgf_rule_type fgf_automatic_rule_type" name="fgf_rule[fgf_automatic_product_qty]" min="1" value="<?php echo esc_attr( $rule_data[ 'fgf_automatic_product_qty' ] ) ; ?>"/>
				</td>				
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Gift Product Type' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span>
						<?php fgf_wc_help_tip( esc_html__( 'When set to Same Product, the user will receive the specified quantities of the same product for free. When set to Different products, the user will receive the specified quantities of another product  for free.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<select name="fgf_rule[fgf_bogo_gift_type]" class = "fgf_bogo_gift_type fgf_rule_type fgf_bogo_rule_type">
						<option value="1" <?php selected( $rule_data[ 'fgf_bogo_gift_type' ] , '1' ) ; ?>><?php esc_html_e( 'Same Product' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="2" <?php selected( $rule_data[ 'fgf_bogo_gift_type' ] , '2' ) ; ?>><?php esc_html_e( 'Different Products' , 'free-gifts-for-woocommerce' ) ; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Buy Product Type' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span>
						<?php fgf_wc_help_tip( esc_html__( 'Products: The user will receive a Free Gift if they purchase the selected product. Categories: The user will receive a Free Gift if they purchase any one product from the selected category.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<select name="fgf_rule[fgf_buy_product_type]" class = "fgf_buy_product_type fgf_bogo_rule_type fgf_rule_type">
						<option value="1" <?php selected( $rule_data[ 'fgf_buy_product_type' ] , '1' ) ; ?>><?php esc_html_e( 'Product' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="2" <?php selected( $rule_data[ 'fgf_buy_product_type' ] , '2' ) ; ?>><?php esc_html_e( 'Category' , 'free-gifts-for-woocommerce' ) ; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Buy Product' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span></label>
				</th>
				<td>
					<?php
					$buy_product_args = array(
						'class'                   => 'fgf_buy_product fgf_rule_type fgf_bogo_rule_type' ,
						'name'                    => 'fgf_rule[fgf_buy_product]' ,
						'list_type'               => 'products' ,
						'action'                  => 'fgf_json_search_products_and_variations' ,
						'exclude_global_variable' => 'yes' ,
						'multiple'                => false ,
						'placeholder'             => esc_html__( 'Search a Product' , 'free-gifts-for-woocommerce' ) ,
						'options'                 => $rule_data[ 'fgf_buy_product' ] ,
							) ;
					fgf_select2_html( $buy_product_args ) ;
					?>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Buy Quantity Calculated Based on' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span>
						<?php fgf_wc_help_tip( esc_html__( "Same Product's Quantity: Quantity must match for each product to receive a free gift. Total Quantity of the Selected Category's Products: Quantity must match either for each product or quantity of products which belong to the selected category should match to receive a free gift." , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<select name="fgf_rule[fgf_buy_category_type]" class = "fgf_buy_category_type fgf_buy_categories fgf_bogo_rule_type fgf_rule_type fgf_get_products">
						<option value="1" <?php selected( $rule_data[ 'fgf_buy_category_type' ] , '1' ) ; ?>><?php esc_html_e( "Same Product's Quantity" , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="2" <?php selected( $rule_data[ 'fgf_buy_category_type' ] , '2' ) ; ?>><?php esc_html_e( "Total Quantity of the Selected Category's Products" , 'free-gifts-for-woocommerce' ) ; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Buy Category' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span></label>
				</th>
				<td>
					<select class="fgf_buy_categories fgf_select2 fgf_bogo_rule_type fgf_rule_type" name="fgf_rule[fgf_buy_categories][]">
						<?php
						foreach ( $categories as $category_id => $category_name ) :
							$selected = ( in_array( $category_id , $rule_data[ 'fgf_buy_categories' ] ) ) ? ' selected="selected"' : '' ;
							?>
							<option value="<?php echo esc_attr( $category_id ) ; ?>"<?php echo esc_attr( $selected ) ; ?>><?php echo esc_html( $category_name ) ; ?></option>
						<?php endforeach ; ?>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Get Product(s)' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span></label>
				</th>
				<td>
					<?php
					$get_product_args = array(
						'class'                   => 'fgf_get_products fgf_rule_type' ,
						'name'                    => 'fgf_rule[fgf_get_products]' ,
						'list_type'               => 'products' ,
						'action'                  => 'fgf_json_search_products_and_variations' ,
						'exclude_global_variable' => 'yes' ,
						'placeholder'             => esc_html__( 'Search a Product' , 'free-gifts-for-woocommerce' ) ,
						'options'                 => $rule_data[ 'fgf_get_products' ] ,
							) ;
					fgf_select2_html( $get_product_args ) ;
					?>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Buy Quantity' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span></label>
				</th>
				<td>
					<input type="number" class="fgf_rule_type fgf_bogo_rule_type" name="fgf_rule[fgf_buy_product_count]" min="1" value="<?php echo esc_attr( $rule_data[ 'fgf_buy_product_count' ] ) ; ?>"/>
				</td>				
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Get Quantity' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span></label>
				</th>
				<td>
					<input type="number" class="fgf_rule_type fgf_bogo_rule_type" name="fgf_rule[fgf_get_product_count]" min="1" value="<?php echo esc_attr( $rule_data[ 'fgf_get_product_count' ] ) ; ?>"/>
				</td>				
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Repeat Gift' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span>
						<?php fgf_wc_help_tip( esc_html__( 'When enabled, the user will keep receiving free gifts every time they add the multiples of the required quantity to the cart.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<input type="checkbox" name="fgf_rule[fgf_bogo_gift_repeat]" class = "fgf_bogo_gift_repeat fgf_rule_type fgf_bogo_rule_type" value="2" <?php checked( '2' , $rule_data[ 'fgf_bogo_gift_repeat' ] ) ; ?>/>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Repeat Gift Mode' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span>
						<?php fgf_wc_help_tip( esc_html__( 'Unlimited: No restriction on receiving Free Gifts. Limited: Free Gift can be received till the Repeat Limit is reached.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<select name="fgf_rule[fgf_bogo_gift_repeat_mode]" class = "fgf_bogo_gift_repeat_mode fgf_bogo_gift_repeat_field fgf_rule_type fgf_bogo_rule_type">
						<option value="1" <?php selected( $rule_data[ 'fgf_bogo_gift_repeat_mode' ] , '1' ) ; ?>><?php esc_html_e( 'Unlimited' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="2" <?php selected( $rule_data[ 'fgf_bogo_gift_repeat_mode' ] , '2' ) ; ?>><?php esc_html_e( 'Limited' , 'free-gifts-for-woocommerce' ) ; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Repeat Limit' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">*</span></label>
				</th>
				<td>
					<input type="number" class="fgf_bogo_gift_repeat_limit fgf_bogo_gift_repeat_field fgf_rule_type fgf_bogo_rule_type" name="fgf_rule[fgf_bogo_gift_repeat_limit]" min="1" value="<?php echo esc_attr( $rule_data[ 'fgf_bogo_gift_repeat_limit' ] ) ; ?>"/>
				</td>				
			</tr>

			<?php do_action( 'fgf_after_rule_general_settings' , $rule_data ) ; ?>

		</tbody>
	</table>
</div>
<?php
