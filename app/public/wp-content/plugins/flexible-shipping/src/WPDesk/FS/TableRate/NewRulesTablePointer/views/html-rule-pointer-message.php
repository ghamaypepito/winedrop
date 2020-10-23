<?php
/**
 * @var string $enable_new_rules_table_link
 */
?>
<p><?php echo sprintf(
		__('We\'ve designed a completely %snew table interface%s to make the whole configuration easier and more user friendly.', 'flexible-shipping'),
		'<strong>',
		'</strong>'
	); ?></p>
<div style="float: right; margin-right: 20px;">
	<a class="button-primary" href="<?php echo esc_attr( $enable_new_rules_table_link );?>"><?php echo esc_html( __( 'Try new interface!', 'flexible-shipping' ) ); ?></a>
</div>
