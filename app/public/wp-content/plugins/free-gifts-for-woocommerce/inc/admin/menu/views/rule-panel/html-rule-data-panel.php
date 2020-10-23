<?php
/**
 * Rule Panel.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ;
}
?>
<div id="fgf-rule-data-panel-wrapper">
	<div class="fgf-rule-data-panel-header">

		<p class="form-field">
			<label><?php esc_html_e( 'Free Gift Type' , 'free-gifts-for-woocommerce' ) ; ?><span class="required">* </span>
				<?php fgf_wc_help_tip( esc_html__( "When set to Manual Gifts, the users can choose their gift product(s). When set to Automatic Gifts, the gift product(s) set in this rule will be automatically added to the user's cart. When set to Buy X Get Y,  the user will get the specified quantities of the product for free if they purchase the specified quantities of the product." , 'free-gifts-for-woocommerce' ) ) ; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
			</label>

			<select name="fgf_rule[fgf_rule_type]" class="fgf_rule_types">
				<option value="1" <?php selected( $rule_data[ 'fgf_rule_type' ] , '1' ) ; ?>><?php esc_html_e( 'Manual Gifts' , 'free-gifts-for-woocommerce' ) ; ?></option>
				<option value="2" <?php selected( $rule_data[ 'fgf_rule_type' ] , '2' ) ; ?>><?php esc_html_e( 'Automatic Gifts' , 'free-gifts-for-woocommerce' ) ; ?></option>
				<option value="3" <?php selected( $rule_data[ 'fgf_rule_type' ] , '3' ) ; ?>><?php esc_html_e( 'Buy X Get Y(Buy One Get One)' , 'free-gifts-for-woocommerce' ) ; ?></option>
			</select>
		</p>
	</div>

	<div class="fgf-rule-data-panel-content">

		<ul class="fgf-rule-data-tabs">
			<?php foreach ( self::get_rule_data_tabs() as $key => $panel_tab ) : ?>
				<li class="fgf-rule-data-tab <?php echo esc_attr( $key ) ; ?>_tab <?php echo esc_attr( isset( $panel_tab[ 'class' ] ) ? implode( ' ' , ( array ) $panel_tab[ 'class' ] ) : ''  ) ; ?>">
					<a href="#<?php echo esc_attr( $panel_tab[ 'target' ] ) ; ?>" class="fgf-rule-data-tab-link"><span><?php echo esc_html( $panel_tab[ 'label' ] ) ; ?></span></a>
				</li>
			<?php endforeach ; ?>
		</ul>

		<?php
		self::output_tabs() ;
		do_action( 'fgf_rule_data_panels' ) ;
		?>
		<div class="clear"></div>
	</div>
</div>
<?php
