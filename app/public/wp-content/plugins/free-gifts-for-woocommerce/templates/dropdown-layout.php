<?php
/**
 * This template displays gift products dropdown layout.
 *
 * This template can be overridden by copying it to yourtheme/free-gifts-for-woocommerce/dropdown-layout.php
 *
 * To maintain compatibility, Free Gifts for WooCommerce will update the template files and you have to copy the updated files to your theme
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}
?>
<div class="fgf_gift_products_wrapper">
	<?php
	/*
	 * Hook: fgf_before_gift_products_content
	 */

	do_action( 'fgf_before_gift_products_content' ) ;
	?>
	<h3><?php echo esc_html( fgf_get_gift_product_heading_label() ) ; ?></h3>

	<div class="fgf-gift-product-wrapper">
		<select class="fgf-gift-product-selection">
			<option value=""><?php echo esc_html( fgf_get_gift_product_dropdown_default_value_label() ) ; ?></option>
			<?php
			foreach ( $gift_products as $gift_product ) :

				if ( $gift_product[ 'hide_add_to_cart' ] ) {
					continue ;
				}
				?>
				<option value="<?php echo esc_attr( $gift_product[ 'product_id' ] ) ; ?>" data-rule-id="<?php echo esc_attr( $gift_product[ 'rule_id' ] ) ; ?>"><?php echo wp_kses_post( fgf_get_dropdown_gift_product_name( $gift_product[ 'product_id' ] ) ) ; ?></option>
			<?php endforeach ; ?>
		</select>

		<?php if ( fgf_show_dropdown_add_to_button() ) : ?>
			<button class="fgf-add-gift-product"><?php echo esc_html( fgf_get_gift_product_add_to_cart_button_label() ) ; ?></button>
		<?php endif ; ?>
	</div>
	<?php
	/*
	 * Hook: fgf_after_gift_products_content
	 */

	do_action( 'fgf_after_gift_products_content' ) ;
	?>
</div>
<?php
