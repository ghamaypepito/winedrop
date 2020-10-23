<?php
/**
 * @var $trigger string
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><script type="text/javascript">
	jQuery(document).ready(function(){

		var trigger = '<?php echo esc_attr( $trigger ); ?>';
		var proceed = false;

		jQuery(".woocommerce-save-button").on('click', function(e){
			if (!proceed && !jQuery('#woocommerce_flexible_shipping_info_enable_new_rules_table').is(':checked') ) {
				e.preventDefault();
				jQuery(document).trigger(trigger);
			}
		});
		jQuery(document).on(trigger + '_proceed', function(){
			proceed = true;
			jQuery(".woocommerce-save-button").trigger('click');
		});
		if ( window.location.hash === '#woocommerce_flexible_shipping_info_enable_new_rules_table' ) {
			jQuery('#woocommerce_flexible_shipping_info_enable_new_rules_table').closest('tr').css('background-color', '#ccc');
		}

	});
</script>
