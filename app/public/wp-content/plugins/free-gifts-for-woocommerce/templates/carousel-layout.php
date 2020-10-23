<?php
/**
 * This template displays contents inside carousel layout
 *
 * This template can be overridden by copying it to yourtheme/free-gifts-for-woocommerce/gift-products.php
 *
 * To maintain compatibility, Free Gifts for WooCommerce will update the template files and you have to copy the updated files to your theme
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}
?>
<div class="fgf_gift_products_wrapper">
	<?php
	/**
	 * Hook: fgf_before_gift_products_content
	 */
	do_action( 'fgf_before_gift_products_content' ) ;
	?>
	<h3><?php echo esc_html( get_option( 'fgf_settings_free_gift_heading_label' ) ) ; ?></h3>
	<div class="fgf-owl-carousel-items owl-carousel">

		<?php
		foreach ( $gift_products as $key => $gift_product ) :

			$link_classes = array( 'fgf_add_to_cart_link' ) ;
			if ( $gift_product[ 'hide_add_to_cart' ] ) {
				$link_classes[] = 'fgf_disable_links' ;
			}

			$_product = wc_get_product( $gift_product[ 'product_id' ] ) ;
			?>

			<div class="fgf-owl-carousel-item fgf-owl-carousel-item<?php echo esc_attr( $key ) ; ?>">

				<?php fgf_render_product_image( $_product ) ; ?>
				<h5><?php echo esc_html( $_product->get_name() ) ; ?></h5>
				<span class="<?php echo esc_attr( implode( ' ' , $link_classes ) ) ; ?>">
					<a class="button" href="
					   <?php
						echo esc_url(
							   add_query_arg(
									   array(
						   'fgf_gift_product' => $gift_product[ 'product_id' ] ,
						   'fgf_rule_id'      => $gift_product[ 'rule_id' ] ,
									   ) , get_permalink()
							   )
					   ) ;
						?>
					   ">
						   <?php echo esc_html( get_option( 'fgf_settings_free_gift_add_to_cart_button_label' ) ) ; ?>
					</a>
				</span>
			</div>
		<?php endforeach ; ?> 
	</div>
	<?php
	/*
	 * Hook: fgf_after_gift_products_content
	 */

	do_action( 'fgf_after_gift_products_content' ) ;
	?>
</div>
<?php

