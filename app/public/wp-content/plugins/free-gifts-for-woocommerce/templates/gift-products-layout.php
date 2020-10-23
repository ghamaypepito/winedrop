<?php
/**
 * This template displays gift products layout in cart page
 *
 * This template can be overridden by copying it to yourtheme/free-gifts-for-woocommerce/gift-products-layout.php
 *
 * To maintain compatibility, Free Gifts for WooCommerce will update the template files and you have to copy the updated files to your theme
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$_columns = array(
	'product_name'  => esc_html__( 'Product Name', 'free-gifts-for-woocommerce' ),
	'product_image' => esc_html__( 'Product Image', 'free-gifts-for-woocommerce' ),
	'add_to_cart'   => esc_html__( 'Add to cart', 'free-gifts-for-woocommerce' ),
);
?>
<div class="fgf_gift_products_wrapper">
	<?php
	/*
	 * Hook: fgf_before_gift_products_content
	 */

	do_action( 'fgf_before_gift_products_content' );
	?>
	<h3><?php echo esc_html( get_option( 'fgf_settings_free_gift_heading_label' ) ); ?></h3>
	<table class="shop_table shop_table_responsive fgf_gift_products_table">

		<thead>
			<tr>
				<?php foreach ( $_columns as $column_name ) : ?>
					<th><?php echo esc_html( $column_name ); ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php
			fgf_get_template(
				'gift-products.php',
				array(
					'gift_products' => $gift_products,
					'permalink' => get_permalink(),
				)
			);
			?>
		</tbody>

		<?php if ( $pagination['page_count'] > 1 ) : ?>
			<tfoot>
				<tr>
					<td colspan="<?php echo esc_attr( count( $_columns ) ); ?>" class="footable-visible actions">
						<?php fgf_get_template( 'pagination.php', $pagination ); ?>
					</td>
				</tr>
			</tfoot>
		<?php endif; ?>

	</table>
	<?php
	/*
	 * Hook: fgf_after_gift_products_content
	 */

	do_action( 'fgf_after_gift_products_content' );
	?>

</div>
<?php
