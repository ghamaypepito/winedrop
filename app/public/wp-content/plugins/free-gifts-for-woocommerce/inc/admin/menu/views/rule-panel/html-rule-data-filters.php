<?php
/**
 *  Rule filters data.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

$categories        = fgf_get_wc_categories() ;
?>
<div id="fgf_rule_data_filters" class="fgf-rule-options-wrapper">
	<table class="form-table">

		<?php do_action( 'fgf_before_rule_filters_settings' , $rule_data ) ; ?>

		<tbody>
			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'User Filter' , 'free-gifts-for-woocommerce' ) ; ?>
						<?php fgf_wc_help_tip( esc_html__( 'The selected users will be eligible for free gifts' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<select class="fgf_user_filter_type" name="fgf_rule[fgf_user_filter_type]">
						<option value="1" <?php selected( $rule_data[ 'fgf_user_filter_type' ] , '1' ) ; ?>><?php esc_html_e( 'All User(s)' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="2" <?php selected( $rule_data[ 'fgf_user_filter_type' ] , '2' ) ; ?>><?php esc_html_e( 'Include User(s)' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="3" <?php selected( $rule_data[ 'fgf_user_filter_type' ] , '3' ) ; ?>><?php esc_html_e( 'Exclude User(s)' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="4" <?php selected( $rule_data[ 'fgf_user_filter_type' ] , '4' ) ; ?>><?php esc_html_e( 'Include User Role(s)' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="5" <?php selected( $rule_data[ 'fgf_user_filter_type' ] , '5' ) ; ?>><?php esc_html_e( 'Exclude User Role(s)' , 'free-gifts-for-woocommerce' ) ; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Select User(s)' , 'free-gifts-for-woocommerce' ) ; ?></label>
				</th>
				<td>
					<?php
					$include_user_args = array(
						'class'       => 'fgf_include_users fgf_user_filter' ,
						'name'        => 'fgf_rule[fgf_include_users]' ,
						'list_type'   => 'customers' ,
						'action'      => 'fgf_json_search_customers' ,
						'placeholder' => esc_html__( 'Search a User' , 'free-gifts-for-woocommerce' ) ,
						'options'     => $rule_data[ 'fgf_include_users' ] ,
							) ;
					fgf_select2_html( $include_user_args ) ;
					?>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Select User(s)' , 'free-gifts-for-woocommerce' ) ; ?></label>
				</th>
				<td>
					<?php
					$exclude_user_args = array(
						'class'       => 'fgf_exclude_users fgf_user_filter' ,
						'name'        => 'fgf_rule[fgf_exclude_users]' ,
						'list_type'   => 'customers' ,
						'action'      => 'fgf_json_search_customers' ,
						'placeholder' => esc_html__( 'Search a User' , 'free-gifts-for-woocommerce' ) ,
						'options'     => $rule_data[ 'fgf_exclude_users' ] ,
							) ;
					fgf_select2_html( $exclude_user_args ) ;
					?>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Select User Role(s)' , 'free-gifts-for-woocommerce' ) ; ?> </label>
				</th>
				<td>
					<select class="fgf_include_user_roles fgf_user_filter fgf_select2" name="fgf_rule[fgf_include_user_roles][]" multiple="multiple">
						<?php
						foreach ( fgf_get_user_roles() as $user_role_id => $user_role_name ) :
							$selected = ( in_array( $user_role_id , $rule_data[ 'fgf_include_user_roles' ] ) ) ? ' selected="selected"' : '' ;
							?>
							<option value="<?php echo esc_attr( $user_role_id ) ; ?>"<?php echo esc_attr( $selected ) ; ?>><?php echo esc_html( $user_role_name ) ; ?></option>
						<?php endforeach ; ?>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Select User Role(s)' , 'free-gifts-for-woocommerce' ) ; ?></label>
				</th>
				<td>
					<select class="fgf_exclude_user_roles fgf_user_filter fgf_select2" name="fgf_rule[fgf_exclude_user_roles][]" multiple="multiple">
						<?php
						foreach ( fgf_get_user_roles() as $user_role_id => $user_role_name ) :
							$selected = ( in_array( $user_role_id , $rule_data[ 'fgf_exclude_user_roles' ] ) ) ? ' selected="selected"' : '' ;
							?>
							<option value="<?php echo esc_attr( $user_role_id ) ; ?>"<?php echo esc_attr( $selected ) ; ?>><?php echo esc_html( $user_role_name ) ; ?></option>
						<?php endforeach ; ?>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Product Filter' , 'free-gifts-for-woocommerce' ) ; ?>
						<?php fgf_wc_help_tip( esc_html__( 'The users will be eligible for free products when they purchase any of the products selected in this option.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<select class="fgf_product_filter_type" name="fgf_rule[fgf_product_filter_type]">
						<option value="1" <?php selected( $rule_data[ 'fgf_product_filter_type' ] , '1' ) ; ?>><?php esc_html_e( 'All Product(s)' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="2" <?php selected( $rule_data[ 'fgf_product_filter_type' ] , '2' ) ; ?>><?php esc_html_e( 'Include Product(s)' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="3" <?php selected( $rule_data[ 'fgf_product_filter_type' ] , '3' ) ; ?>><?php esc_html_e( 'Exclude Product(s)' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="4" <?php selected( $rule_data[ 'fgf_product_filter_type' ] , '4' ) ; ?>><?php esc_html_e( 'All Categories' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="5" <?php selected( $rule_data[ 'fgf_product_filter_type' ] , '5' ) ; ?>><?php esc_html_e( 'Include Categories' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="6" <?php selected( $rule_data[ 'fgf_product_filter_type' ] , '6' ) ; ?>><?php esc_html_e( 'Exclude Categories' , 'free-gifts-for-woocommerce' ) ; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Applicable when' , 'free-gifts-for-woocommerce' ) ; ?>
						<?php fgf_wc_help_tip( esc_html__( ' This option provides additional control on when to award the Free Gifts.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<select name="fgf_rule[fgf_applicable_products_type]" class="fgf_product_filter fgf_applicable_products_type">
						<option value="1" <?php selected( $rule_data[ 'fgf_applicable_products_type' ] , '1' ) ; ?>><?php esc_html_e( 'Any one of the selected Product(s) must be in cart' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="2" <?php selected( $rule_data[ 'fgf_applicable_products_type' ] , '2' ) ; ?>><?php esc_html_e( 'All the selected Product(s) must be in cart' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="3" <?php selected( $rule_data[ 'fgf_applicable_products_type' ] , '3' ) ; ?>><?php esc_html_e( 'Only the selected Product(s) must be in cart' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="4" <?php selected( $rule_data[ 'fgf_applicable_products_type' ] , '4' ) ; ?>><?php esc_html_e( 'User purchases the Specified Number of Products' , 'free-gifts-for-woocommerce' ) ; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Select Product(s)' , 'free-gifts-for-woocommerce' ) ; ?></label>
				</th>
				<td>
					<?php
					$include_product_args = array(
						'class'       => 'fgf_include_products fgf_product_filter' ,
						'name'        => 'fgf_rule[fgf_include_products]' ,
						'list_type'   => 'products' ,
						'action'      => 'fgf_json_search_products_and_variations' ,
						'placeholder' => esc_html__( 'Search a Product' , 'free-gifts-for-woocommerce' ) ,
						'options'     => $rule_data[ 'fgf_include_products' ] ,
							) ;
					fgf_select2_html( $include_product_args ) ;
					?>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Select Product(s)' , 'free-gifts-for-woocommerce' ) ; ?></label>
				</th>
				<td>
					<?php
					$exclude_product_args = array(
						'class'       => 'fgf_exclude_products fgf_product_filter' ,
						'name'        => 'fgf_rule[fgf_exclude_products]' ,
						'list_type'   => 'products' ,
						'action'      => 'fgf_json_search_products_and_variations' ,
						'placeholder' => esc_html__( 'Search a Product' , 'free-gifts-for-woocommerce' ) ,
						'options'     => $rule_data[ 'fgf_exclude_products' ] ,
							) ;
					fgf_select2_html( $exclude_product_args ) ;
					?>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Product Count' , 'free-gifts-for-woocommerce' ) ; ?>
						<?php fgf_wc_help_tip( esc_html__( 'The user must add the number of products mentioned in this option to their cart in order for them to be eligibile for a Free Gift.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<input type="number" class="fgf_product_filter fgf_include_product_count" name="fgf_rule[fgf_include_product_count]" min="1" value="<?php echo esc_attr( $rule_data[ 'fgf_include_product_count' ] ) ; ?>"/>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Applicable when' , 'free-gifts-for-woocommerce' ) ; ?>
						<?php fgf_wc_help_tip( esc_html__( 'This option provides additional control on when to award the Free Gifts.' , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
					</label>
				</th>
				<td>
					<select name="fgf_rule[fgf_applicable_categories_type]" class="fgf_product_filter fgf_applicable_categories_type">
						<option value="1" <?php selected( $rule_data[ 'fgf_applicable_categories_type' ] , '1' ) ; ?>><?php esc_html_e( 'Any one of the product(s) should be from the selected category' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="2" <?php selected( $rule_data[ 'fgf_applicable_categories_type' ] , '2' ) ; ?>><?php esc_html_e( 'One product from each category must be in cart' , 'free-gifts-for-woocommerce' ) ; ?></option>
						<option value="3" <?php selected( $rule_data[ 'fgf_applicable_categories_type' ] , '3' ) ; ?>><?php esc_html_e( 'Only products from the selected category should be in cart' , 'free-gifts-for-woocommerce' ) ; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Select Categories' , 'free-gifts-for-woocommerce' ) ; ?></label>
				</th>
				<td>
					<select class="fgf_include_categories fgf_product_filter fgf_select2" name="fgf_rule[fgf_include_categories][]" multiple="multiple">
						<?php
						foreach ( $categories as $category_id => $category_name ) :
							$selected = ( in_array( $category_id , $rule_data[ 'fgf_include_categories' ] ) ) ? ' selected="selected"' : '' ;
							?>
							<option value="<?php echo esc_attr( $category_id ) ; ?>"<?php echo esc_attr( $selected ) ; ?>><?php echo esc_html( $category_name ) ; ?></option>
						<?php endforeach ; ?>
					</select>
				</td>
			</tr>

			<tr>
				<th scope='row'>
					<label><?php esc_html_e( 'Select Categories' , 'free-gifts-for-woocommerce' ) ; ?></label>
				</th>
				<td>
					<select class="fgf_exclude_categories fgf_product_filter fgf_select2" name="fgf_rule[fgf_exclude_categories][]" multiple="multiple">
						<?php
						foreach ( $categories as $category_id => $category_name ) :
							$selected = ( in_array( $category_id , $rule_data[ 'fgf_exclude_categories' ] ) ) ? ' selected="selected"' : '' ;
							?>
							<option value="<?php echo esc_attr( $category_id ) ; ?>"<?php echo esc_attr( $selected ) ; ?>><?php echo esc_html( $category_name ) ; ?></option>
						<?php endforeach ; ?>
					</select>
				</td>
			</tr>

			<?php do_action( 'fgf_after_rule_filters_settings' , $rule_data ) ; ?>
		</tbody>
	</table>
</div>
<?php
