<?php

/**
 * Settings Tab
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( class_exists( 'FGF_Settings_Tab' ) ) {
	return new FGF_Settings_Tab() ;
}

/**
 * FGF_Settings_Tab.
 */
class FGF_Settings_Tab extends FGF_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'settings' ;
		$this->label = esc_html__( 'Settings' , 'free-gifts-for-woocommerce' ) ;

		parent::__construct() ;
	}

	/**
	 * Get sections.
	 */
	public function get_sections() {
		$sections = array(
			'general'       => esc_html__( 'General' , 'free-gifts-for-woocommerce' ) ,
			'display'       => esc_html__( 'Display' , 'free-gifts-for-woocommerce' ) ,
			'advanced'      => esc_html__( 'Advanced' , 'free-gifts-for-woocommerce' ) ,
			'notifications' => esc_html__( 'Notifications' , 'free-gifts-for-woocommerce' ) ,
			'localizations' => esc_html__( 'Localization' , 'free-gifts-for-woocommerce' ) ,
			'messages'      => esc_html__( 'Messages' , 'free-gifts-for-woocommerce' ) ,
				) ;

		return apply_filters( $this->plugin_slug . '_get_sections_' . $this->id , $sections ) ;
	}

	/**
	 * Get settings for general section array.
	 */
	public function general_section_array() {
		$section_fields = array() ;

		// General Section Start
		$section_fields[] = array(
			'type'  => 'title' ,
			'title' => esc_html__( 'General Settings' , 'free-gifts-for-woocommerce' ) ,
			'id'    => 'fgf_general_options' ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Maximum Number of Gift Products in "Manual Rule Type" is decided based on' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'gifts_count_per_order_type' ) ,
			'type'     => 'select' ,
			'default'  => '1' ,
			'options'  => array(
				'1' => esc_html__( 'Global Settings' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'Rule Settings' , 'free-gifts-for-woocommerce' ) ,
			) ,
			'desc_tip' => true ,
			'desc'     => esc_html__( 'Global Settings - The Maximum Gifts Restriction applies for all rules. Rule Settings - The Maximum Gifts Restriction can be set on each rule.' , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'title'             => esc_html__( 'Maximum Gifts in an Order' , 'free-gifts-for-woocommerce' ) ,
			'type'              => 'number' ,
			'default'           => '5' ,
			'custom_attributes' => array( 'min' => '1' ) ,
			'desc_tip'          => true ,
			'desc'              => esc_html__( 'The Maximum number of gift products which can be chosen for each order.' , 'free-gifts-for-woocommerce' ) ,
			'id'                => $this->get_option_key( 'gifts_count_per_order' ) ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Allow Adding Multiple Quantities of Same Gift Product in an Order (Only for Manual Free Gifts)' , 'free-gifts-for-woocommerce' ) ,
			'type'     => 'checkbox' ,
			'default'  => 'no' ,
			'desc_tip' => true ,
			'desc'     => esc_html__( 'When enabled, a user can add the same product multiple times to the cart. Provided they are eligible to receive multiple gifts for a single purchase.' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'gifts_selection_per_user' ) ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Restrict Free Gift if WooCommerce Coupon is used' , 'free-gifts-for-woocommerce' ) ,
			'type'     => 'checkbox' ,
			'default'  => 'no' ,
			'desc_tip' => true ,
			'desc'     => esc_html__( 'When enabled, the user will not be eligible for a free gift if they have used a WooCommerce Coupon in the order.' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'gift_restriction_based_coupon' ) ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Hide Free Gift Products on Shop and Category Pages' , 'free-gifts-for-woocommerce' ) ,
			'type'     => 'checkbox' ,
			'default'  => 'no' ,
			'desc_tip' => true ,
			'desc'     => esc_html__( ' When enabled, the products which are configured to be given as Free Gifts will be hidden in Shop and Category Pages.' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'restrict_gift_product_display' ) ,
				) ;
		$section_fields[] = array(
			'type' => 'sectionend' ,
			'id'   => 'fgf_general_options' ,
				) ;
		// General Section End

		return $section_fields ;
	}

	/**
	 * Get settings for display section array.
	 */
	public function display_section_array() {
		$section_fields = array() ;

		// Gift Display Section Start
		$section_fields[] = array(
			'type'  => 'title' ,
			'title' => esc_html__( 'Gift Product Display Settings' , 'free-gifts-for-woocommerce' ) ,
			'id'    => 'fgf_gift_display_options' ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Free Gift(s) Eligibility Notice Will be Displayed On' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'display_cart_notices_type' ) ,
			'type'     => 'select' ,
			'default'  => '1' ,
			'options'  => array(
				'1' => esc_html__( 'Cart & Checkout' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'Cart' , 'free-gifts-for-woocommerce' ) ,
				'3' => esc_html__( 'Checkout' , 'free-gifts-for-woocommerce' ) ,
			) ,
			'desc_tip' => true ,
			'desc'     => esc_html__( 'Choose where you want to display the Free Gift(s) eligibility notice.' , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Free Gifts Notice Display Type' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'display_notice_mode' ) ,
			'type'     => 'select' ,
			'default'  => '1' ,
			'options'  => array(
				'1' => esc_html__( 'Standard WooCommerce Notice' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( "Plugin's Own Notice" , 'free-gifts-for-woocommerce' ) ,
			) ,
			'desc_tip' => true ,
			'desc'     => esc_html__( "By default, Free Gift messages will be displayed in WooCommerce Notices. You can switch to Plugin's Own Notice if your theme doesn't support WooCommerce Notices." , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Free Gift(s) Cart Table Display Method' , 'free-gifts-for-woocommerce' ) ,
			'id'      => $this->get_option_key( 'gift_product_cart_display_order' ) ,
			'type'    => 'select' ,
			'default' => '1' ,
			'options' => array(
				'1' => esc_html__( 'Order in which they get added' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'Group at Bottom of the Cart Table' , 'free-gifts-for-woocommerce' ) ,
			) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Price Display For Gift Products' , 'free-gifts-for-woocommerce' ) ,
			'id'      => $this->get_option_key( 'gift_product_price_display_type' ) ,
			'type'    => 'select' ,
			'default' => '1' ,
			'options' => array(
				'1' => esc_html__( "Don't display price" , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'Strike and display the Price' , 'free-gifts-for-woocommerce' ) ,
			) ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Allow Users to Choose Free Gifts in Checkout Page' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'gift_checkout_page_display' ) ,
			'type'     => 'select' ,
			'default'  => '1' ,
			'options'  => array(
				'1' => esc_html__( 'No' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'Yes' , 'free-gifts-for-woocommerce' ) ,
			) ,
			'desc_tip' => true ,
			'desc'     => esc_html__( 'Select whether to allow the Free Gifts selection in the checkout page' , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Free Gifts display mode in the Cart Page' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'gift_cart_page_display' ) ,
			'type'     => 'select' ,
			'default'  => '1' ,
			'options'  => array(
				'1' => esc_html__( 'Inline' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'Pop-Up' , 'free-gifts-for-woocommerce' ) ,
			) ,
			'desc_tip' => true ,
			'desc'     => esc_html__( 'Select Whether the Gift Products should be displayed Inline or Pop-up' , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Gift Display Type' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'gift_display_type' ) ,
			'type'     => 'select' ,
			'default'  => '1' ,
			'options'  => array(
				'1' => esc_html__( 'Table' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'Carousel' , 'free-gifts-for-woocommerce' ) ,
				'3' => esc_html__( 'Select Box(Dropdown)' , 'free-gifts-for-woocommerce' )
			) ,
			'desc_tip' => true ,
			'desc'     => esc_html__( 'Select whether the Gift Products should be displayed in a Table or Carousel or Select Box' , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Pagination Display' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'gift_display_table_pagination' ) ,
			'class'    => 'fgf_gift_table_display_type' ,
			'type'     => 'select' ,
			'default'  => '1' ,
			'options'  => array(
				'1' => esc_html__( 'Show' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'Hide' , 'free-gifts-for-woocommerce' ) ,
			) ,
			'desc_tip' => true ,
			'desc'     => esc_html__( 'Select whether to Display/Hide the Pagination' , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'title'             => esc_html__( 'Pagination to Display Gift Products' , 'free-gifts-for-woocommerce' ) ,
			'type'              => 'number' ,
			'default'           => '4' ,
			'class'             => 'fgf_gift_table_display_type' ,
			'custom_attributes' => array( 'min' => '1' ) ,
			'id'                => $this->get_option_key( 'free_gift_per_page_column_count' ) ,
				) ;
		$section_fields[] = array(
			'title'             => esc_html__( 'Gift Products Per Page' , 'free-gifts-for-woocommerce' ) ,
			'type'              => 'number' ,
			'default'           => '3' ,
			'class'             => 'fgf_gift_carousel_display_type' ,
			'custom_attributes' => array(
				'min'        => '1' ,
				'data-error' => esc_html__( ' Displaying more than 3 products per page in a Carousel can cause Display related issues. Do you want to save anyway?' , 'free-gifts-for-woocommerce' ) ,
			) ,
			'id'                => $this->get_option_key( 'carousel_gift_per_page' ) ,
			'desc'              => esc_html__( 'Note: More than 3 Gift Product(s) per page in the carousel may cause display conflict based on the Theme used in the site.' , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'title'             => esc_html__( 'Space Between Products in Carousel in Pixels' , 'free-gifts-for-woocommerce' ) ,
			'type'              => 'number' ,
			'default'           => '10' ,
			'class'             => 'fgf_gift_carousel_display_type' ,
			'custom_attributes' => array( 'min' => '1' ) ,
			'id'                => $this->get_option_key( 'carousel_item_margin' ) ,
				) ;
		$section_fields[] = array(
			'title'             => esc_html__( 'Number of Products to Slide During Navigation' , 'free-gifts-for-woocommerce' ) ,
			'type'              => 'number' ,
			'default'           => '1' ,
			'class'             => 'fgf_gift_carousel_display_type' ,
			'custom_attributes' => array( 'min' => '1' ) ,
			'id'                => $this->get_option_key( 'carousel_item_per_slide' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Display Pagination' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'checkbox' ,
			'default' => 'yes' ,
			'class'   => 'fgf_gift_carousel_display_type' ,
			'id'      => $this->get_option_key( 'carousel_pagination' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Display Controls' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'checkbox' ,
			'default' => 'yes' ,
			'class'   => 'fgf_gift_carousel_display_type' ,
			'id'      => $this->get_option_key( 'carousel_navigation' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Navigation Previous Text' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => '<' ,
			'class'   => 'fgf_gift_carousel_display_type fgf_carousel_navigation_type' ,
			'id'      => $this->get_option_key( 'carousel_navigation_prevoius_text' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Navigation Next Text' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => '>' ,
			'class'   => 'fgf_gift_carousel_display_type fgf_carousel_navigation_type' ,
			'id'      => $this->get_option_key( 'carousel_navigation_next_text' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Auto Play' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'checkbox' ,
			'default' => 'yes' ,
			'class'   => 'fgf_gift_carousel_display_type' ,
			'id'      => $this->get_option_key( 'carousel_auto_play' ) ,
				) ;
		$section_fields[] = array(
			'title'             => esc_html__( 'Slide Speed in Milliseconds' , 'free-gifts-for-woocommerce' ) ,
			'type'              => 'number' ,
			'default'           => '5000' ,
			'class'             => 'fgf_gift_carousel_display_type fgf_carousel_auto_play' ,
			'custom_attributes' => array( 'min' => '1' ) ,
			'id'                => $this->get_option_key( 'carousel_slide_speed' ) ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Gift Product Add to Cart Method' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'dropdown_add_to_cart_behaviour' ) ,
			'class'    => 'fgf_gift_dropdown_display_type' ,
			'type'     => 'select' ,
			'default'  => '1' ,
			'options'  => array(
				'1' => esc_html__( 'Manual' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'Automatic' , 'free-gifts-for-woocommerce' ) ,
			) ,
			'desc_tip' => true ,
			'desc'     => esc_html__( 'Automatic: Gift Product will be added to cart automatically once the Gift Product is selected in the dropdown(select box). Manually: The Addd to Cart Button has to be clicked for adding the product to the cart.' , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'type' => 'sectionend' ,
			'id'   => 'fgf_gift_display_options' ,
				) ;
		// Gift Display Section End.

		return $section_fields ;
	}

	/**
	 * Get settings for advanced section array.
	 */
	public function advanced_section_array() {
		$section_fields = array() ;

		// Trobuleshoot Section Start.
		$section_fields[] = array(
			'type'  => 'title' ,
			'title' => esc_html__( 'Trobuleshoot' , 'free-gifts-for-woocommerce' ) ,
			'id'    => 'fgf_trobuleshoot_options' ,
				) ;
		$section_fields[] = array(
			'title'    => esc_html__( 'Frontend Scripts Enqueued on' , 'free-gifts-for-woocommerce' ) ,
			'id'       => $this->get_option_key( 'frontend_enqueue_scripts_type' ) ,
			'type'     => 'select' ,
			'default'  => '1' ,
			'options'  => array(
				'1' => esc_html__( 'Header' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'Footer' , 'free-gifts-for-woocommerce' ) ,
			) ,
			'desc_tip' => true ,
			'desc'     => esc_html__( 'Choose whether the frontend scripts has to be loaded on Header/Footer' , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'type' => 'sectionend' ,
			'id'   => 'fgf_trobuleshoot_options' ,
				) ;
		// Custom CSS Section End.
		// Custom CSS Section Start.
		$section_fields[] = array(
			'type'  => 'title' ,
			'title' => esc_html__( 'Custom CSS' , 'free-gifts-for-woocommerce' ) ,
			'id'    => 'fgf_custom_css_options' ,
				) ;
		$section_fields[] = array(
			'title'             => esc_html__( 'Custom CSS' , 'free-gifts-for-woocommerce' ) ,
			'type'              => 'textarea' ,
			'default'           => '' ,
			'custom_attributes' => array( 'rows' => 10 ) ,
			'id'                => $this->get_option_key( 'custom_css' ) ,
				) ;
		$section_fields[] = array(
			'type' => 'sectionend' ,
			'id'   => 'fgf_custom_css_options' ,
				) ;
		// Custom CSS Section End.

		return $section_fields ;
	}

	/**
	 * Get settings for notifications section array.
	 */
	public function notifications_section_array() {
		$section_fields = array() ;

		// Email settings section start
		$section_fields[] = array(
			'type'  => 'title' ,
			'title' => esc_html__( 'Email Settings' , 'free-gifts-for-woocommerce' ) ,
			'id'    => 'fgf_email_options' ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Email Type' , 'free-gifts-for-woocommerce' ) ,
			'id'      => $this->get_option_key( 'email_template_type' ) ,
			'type'    => 'select' ,
			'default' => '1' ,
			'options' => array(
				'1' => esc_html__( 'HTML' , 'free-gifts-for-woocommerce' ) ,
				'2' => esc_html__( 'WooComerce Template' , 'free-gifts-for-woocommerce' ) ,
			) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'From Name' , 'free-gifts-for-woocommerce' ) ,
			'id'      => $this->get_option_key( 'email_from_name' ) ,
			'type'    => 'text' ,
			'default' => get_option( 'woocommerce_email_from_name' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'From Address' , 'free-gifts-for-woocommerce' ) ,
			'id'      => $this->get_option_key( 'email_from_address' ) ,
			'type'    => 'text' ,
			'default' => get_option( 'woocommerce_email_from_address' ) ,
				) ;
		$section_fields[] = array(
			'type' => 'sectionend' ,
			'id'   => 'fgf_email_options' ,
				) ;
		// Email settings section end
		// Manual Gift Email section start
		$section_fields[] = array(
			'type'  => 'title' ,
			'title' => esc_html__( 'Manual Gift Email' , 'free-gifts-for-woocommerce' ) ,
			'id'    => 'fgf_manual_gift_email_options' ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Enable/Disable' , 'free-gifts-for-woocommerce' ) ,
			'id'      => $this->get_option_key( 'enable_manual_gift_email' ) ,
			'type'    => 'checkbox' ,
			'default' => 'yes' ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Subject' , 'free-gifts-for-woocommerce' ) ,
			'id'      => $this->get_option_key( 'manual_gift_email_subject' ) ,
			'type'    => 'text' ,
			'class'   => 'fgf_manual_gift_email' ,
			'default' => '{site_name}  - Free Gift Received' ,
				) ;
		$section_fields[] = array(
			'title'     => esc_html__( 'Message' , 'free-gifts-for-woocommerce' ) ,
			'id'        => $this->get_option_key( 'manual_gift_email_message' ) ,
			'type'      => 'fgf_custom_fields' ,
			'fgf_field' => 'wpeditor' ,
			'class'     => 'fgf_manual_gift_email' ,
			'default'   => 'Hi {user_name},

You have received the following Product(s) as a Gift from the Site Admin.

{free_gifts}' ,
				) ;
		$section_fields[] = array(
			'type' => 'sectionend' ,
			'id'   => 'fgf_manual_gift_email_options' ,
				) ;
		// Manual Gift Email section end

		return $section_fields ;
	}

	/**
	 * Get settings for localizations section array.
	 */
	public function localizations_section_array() {
		$section_fields = array() ;

		// Gift Product Cart Page Section Start
		$section_fields[] = array(
			'type'  => 'title' ,
			'title' => esc_html__( 'Cart Page Localization' , 'free-gifts-for-woocommerce' ) ,
			'id'    => 'fgf_localizations_label_options' ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Gift Product Heading' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Choose Your Gift(s)' ,
			'id'      => $this->get_option_key( 'free_gift_heading_label' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Gift Product Add to Cart Button Label' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Add to Cart' ,
			'id'      => $this->get_option_key( 'free_gift_add_to_cart_button_label' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Gift Product Selection Label - Select Box(Dropdown)' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Please select a Gift' ,
			'id'      => $this->get_option_key( 'free_gift_dropdown_default_option_label' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Cart Gift Type Label' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Type' ,
			'id'      => $this->get_option_key( 'free_gift_cart_item_type_localization' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Cart Free Gift Label' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Free Product' ,
			'id'      => $this->get_option_key( 'free_gift_cart_item_type_value_localization' ) ,
				) ;
		$section_fields[] = array(
			'type' => 'sectionend' ,
			'id'   => 'fgf_localizations_label_options' ,
				) ;
		// Gift Product Cart Page Section End.

		return $section_fields ;
	}

	/**
	 * Get settings for messages section array.
	 */
	public function messages_section_array() {
		$section_fields = array() ;

		// message Section Start
		$section_fields[] = array(
			'type'  => 'title' ,
			'title' => esc_html__( 'Message Settings' , 'free-gifts-for-woocommerce' ) ,
			'id'    => 'fgf_messages_label_options' ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Free Gift Cart Page - Inline Notice' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Based on your Current Cart Contents, you are eligible for Free Gift(s). Choose your gift from the Table below.' ,
			'id'      => $this->get_option_key( 'free_gift_notice_message' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Free Gift Notice in Cart/Checkout - Pop-Up Notice' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Based on your Current Cart Contents, you are eligible for Free Gift(s). Choose your gift [popup_link].' ,
			'id'      => $this->get_option_key( 'free_gift_popup_notice_message' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Popup Link Shortcode Label' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Here' ,
			'id'      => $this->get_option_key( 'free_gift_popup_link_message' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Display Free Gifts Notice in Checkout Page' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'checkbox' ,
			'default' => 'no' ,
			'id'      => $this->get_option_key( 'enable_checkout_free_gift_notice' ) ,
			'desc'    => esc_html__( 'When enabled, a notice will be displayed in checkout page asking the users to choose their free gifts. This notice will hidden if the user has already chosen their free gifts on cart page.' , 'free-gifts-for-woocommerce' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Free Gift Checkout Page Notice' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'class'   => 'fgf_checkout_free_gift_notice' ,
			'default' => 'Based on your Current Cart Contents, you are eligible for Free Gift(s). Choose your gift on [cart_page].' ,
			'id'      => $this->get_option_key( 'checkout_free_gift_notice_message' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Cart Link Shortcode Notice' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Cart Page' ,
			'class'   => 'fgf_checkout_free_gift_notice' ,
			'id'      => $this->get_option_key( 'checkout_free_gift_notice_shortcode_message' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( "Message when the criteria don't match to Gift the Product / the cart is empty" , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'As of now no Gift Product(s) available based on your Cart Content' ,
			'id'      => $this->get_option_key( 'shortcode_free_gift_empty_message' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Gift Product not selected in Select Box(Dropdown) Display Type Error Message' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Please select a Gift' ,
			'id'      => $this->get_option_key( 'gift_product_dropdown_valid_message' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Success Message - Manual' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Gift product added successfully' ,
			'id'      => $this->get_option_key( 'free_gift_success_message' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Success Message - Automatic' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Gift product(s) has been added to your cart based on your cart contents.' ,
			'id'      => $this->get_option_key( 'free_gift_automatic_success_message' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Success Message - Buy X Get Y' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Gift product(s) has been added to your cart based on your cart contents.' ,
			'id'      => $this->get_option_key( 'free_gift_bogo_success_message' ) ,
				) ;
		$section_fields[] = array(
			'title'   => esc_html__( 'Error Message' , 'free-gifts-for-woocommerce' ) ,
			'type'    => 'text' ,
			'default' => 'Your Free Gift(s) were removed because your current cart contents is not eligible for a free gift' ,
			'id'      => $this->get_option_key( 'free_gift_error_message' ) ,
				) ;
		$section_fields[] = array(
			'type' => 'sectionend' ,
			'id'   => 'fgf_messages_label_options' ,
				) ;
		// Gift Product Cart Page Section End.

		return $section_fields ;
	}

}

return new FGF_Settings_Tab() ;
