<?php

/**
 * Master Log Tab
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( class_exists( 'FGF_Master_Log_Tab' ) ) {
	return new FGF_Master_Log_Tab() ;
}

/**
 * FGF_Master_Log_Tab.
 */
class FGF_Master_Log_Tab extends FGF_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id           = 'master-log' ;
		$this->show_buttons = false ;
		$this->label        = esc_html__( 'Master Log' , 'free-gifts-for-woocommerce' ) ;

		parent::__construct() ;
	}

	/**
	 * Output the Rules WP List Table
	 */
	public function output_extra_fields() {
		if ( ! class_exists( 'FGF_Master_Log_List_Table' ) ) {
			require_once( FGF_PLUGIN_PATH . '/inc/admin/menu/wp-list-table/class-fgf-master-log-list-table.php' ) ;
		}

		$post_table = new FGF_Master_Log_List_Table() ;
		$post_table->prepare_items() ;

		echo '<div class="fgf_table_wrap">' ;
		echo '<h2 class="wp-heading-inline">' . esc_html__( 'Master Log' , 'free-gifts-for-woocommerce' ) . '</h2>' ;

		if ( isset( $_REQUEST[ 's' ] ) && strlen( wc_clean( wp_unslash( $_REQUEST[ 's' ] ) ) ) ) { // @codingStandardsIgnoreLine.

			/* translators: %s: search keywords */
			echo wp_kses_post( sprintf( '<span class="subtitle">' . esc_html__( 'Search results for &#8220;%s&#8221;' , 'free-gifts-for-woocommerce' ) . '</span>' , wc_clean( wp_unslash( $_REQUEST[ 's' ] ) ) ) ) ;
		}

		$post_table->views() ;
		$post_table->search_box( esc_html__( 'Search Master Log' , 'free-gifts-for-woocommerce' ) , 'fgf_search' ) ;
		$post_table->display() ;
		echo '</div>' ;
	}

}

return new FGF_Master_Log_Tab() ;
