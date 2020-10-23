<?php
/**
 * This template displays gift products table pagination
 *
 * This template can be overridden by copying it to yourtheme/free-gifts-for-woocommerce/pagination.php
 *
 * To maintain compatibility, Free Gifts for WooCommerce will update the template files and you have to copy the updated files to your theme
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<nav class="pagination pagination-centered woocommerce-pagination">
	<ul>
		<li><span class="fgf_pagination fgf_first_pagination" data-page="1"><<</span>
		<li><span class="fgf_pagination fgf_next_pagination" data-page="2"><</span></li>
		<?php
		for ( $i = 1; $i <= $page_count; $i ++ ) {
			$display = false;
			$classes = array( 'fgf_pagination' );
			if ( $current_page <= $page_count && $i <= $page_count ) {
				$page_no = $i;
				$display = true;
			} else if ( $current_page > $page_count ) {

				$overall_count = $current_page - $page_count + $i;

				if ( $overall_count <= $current_page ) {
					$page_no = $overall_count;
					$display = true;
				}
			}

			if ( $current_page == $i ) {
				$classes[] = 'current';
			}

			if ( $display ) {
				?>
				<li><span data-page="<?php echo esc_attr( $page_no ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"><?php echo esc_html( $page_no ); ?></span></li>
				<?php
			}
		}
		?>
		<li><span class="fgf_pagination fgf_prev_pagination" data-page="<?php echo esc_attr( $next_page_count ); ?>">></span></li>
		<li><span class="fgf_pagination fgf_last_pagination" data-page="<?php echo esc_attr( $page_count ); ?>">>></span></li>
	</ul>
</nav>
<?php
