<?php
/**
 * This template displays contents inside gift products table
 *
 * This template can be overridden by copying it to yourtheme/free-gifts-for-woocommerce/gift-products.php
 *
 * To maintain compatibility, Free Gifts for WooCommerce will update the template files and you have to copy the updated files to your theme
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

foreach ( $gift_products as $gift_product ) :

	$link_classes = array( 'fgf_add_to_cart_link' ) ;
	if ( $gift_product[ 'hide_add_to_cart' ] ) {
		$link_classes[] = 'fgf_disable_links' ;
	}
	?>
	<tr>
		<?php $_product = wc_get_product( $gift_product[ 'product_id' ] ) ; ?>

		<td data-title="<?php esc_attr_e( 'Product Name' , 'free-gifts-for-woocommerce' ) ; ?>"><?php echo esc_html( $_product->get_name() ) ; ?></td>
		<td data-title="<?php esc_attr_e( 'Product Image' , 'free-gifts-for-woocommerce' ) ; ?>"><?php fgf_render_product_image( $_product ) ; ?></td>
		<td data-title="<?php esc_attr_e( 'Add to cart' , 'free-gifts-for-woocommerce' ) ; ?>">
			<span class="<?php echo esc_attr( implode( ' ' , $link_classes ) ) ; ?>">
				<a class="button" href="
				   <?php
					echo esc_url(
						   add_query_arg(
								   array(
					   'fgf_gift_product' => $gift_product[ 'product_id' ] ,
					   'fgf_rule_id'      => $gift_product[ 'rule_id' ] ,
								   ) , $permalink
						   )
				   ) ;
					?>
				   ">
					   <?php echo esc_html( get_option( 'fgf_settings_free_gift_add_to_cart_button_label' ) ) ; ?>
				</a>
			</span>
		</td>
	</tr>
	<?php
endforeach ;

