<?php

/**
 * Shortcodes Tab
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( class_exists( 'FGF_Shortcodes_Tab' ) ) {
	return new FGF_Shortcodes_Tab() ;
}

/**
 * FGF_Shortcodes_Tab.
 */
class FGF_Shortcodes_Tab extends FGF_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id           = 'shortcodes' ;
		$this->show_buttons = false ;
		$this->label        = esc_html__( 'Shortcodes' , 'free-gifts-for-woocommerce' ) ;

		//Display the shortcode information.
		add_action( 'woocommerce_admin_field_fgf_shortcodes_information' , array( $this , 'shortcodes_information' ) ) ;

		parent::__construct() ;
	}

	/**
	 * Get settings for shortcodes section array.
	 */
	public function shortcodes_section_array() {
		$section_fields = array() ;

		// Shortcodes Section Start.
		$section_fields[] = array(
			'type'  => 'title' ,
			'title' => esc_html__( 'Shortcodes' , 'free-gifts-for-woocommerce' ) ,
			'id'    => 'fgf_shortcodes_options' ,
				) ;
		$section_fields[] = array(
			'type' => 'fgf_shortcodes_information' ,
				) ;
		$section_fields[] = array(
			'type' => 'sectionend' ,
			'id'   => 'fgf_shortcodes_options' ,
				) ;
		// Shortcodes Section End.

		return $section_fields ;
	}

	/**
	 * Display the shortcode information.
	 * */
	public function shortcodes_information() {
		include_once( FGF_ABSPATH . 'inc/admin/menu/views/html-shortcodes-info.php' ) ;
	}

}

return new FGF_Shortcodes_Tab() ;
