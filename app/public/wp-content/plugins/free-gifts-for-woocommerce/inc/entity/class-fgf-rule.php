<?php

/*
 * Rule
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( ! class_exists( 'FGF_Rule' ) ) {

	/**
	 * FGF_Rule Class.
	 */
	class FGF_Rule extends FGF_Post {

		/**
		 * Post Type
		 */
		protected $post_type = FGF_Register_Post_Types::RULES_POSTTYPE ;

		/**
		 * Post Status
		 */
		protected $post_status = 'fgf_active' ;

		/**
		 * Name
		 */
		protected $name ;

		/**
		 * Description
		 */
		protected $description ;

		/**
		 * Created Date
		 */
		protected $created_date ;

		/**
		 * Modified Date
		 */
		protected $modified_date ;

		/**
		 * Rule Type
		 */
		protected $fgf_rule_type ;

		/**
		 * Gift Type
		 */
		protected $fgf_gift_type ;

		/**
		 * Gift Products
		 */
		protected $fgf_gift_products ;

		/**
		 * Gift Categories
		 */
		protected $fgf_gift_categories ;

		/**
		 * BOGO Gift Type.
		 */
		protected $fgf_bogo_gift_type ;

		/**
		 * Buy Product Type.
		 */
		protected $fgf_buy_product_type ;

		/**
		 * Buy Products.
		 */
		protected $fgf_buy_product ;

		/**
		 * Buy Categories.
		 */
		protected $fgf_buy_categories ;

		/**
		 * Buy Category Type.
		 */
		protected $fgf_buy_category_type ;

		/**
		 * Get Products.
		 */
		protected $fgf_get_products ;

		/**
		 * Buy product count.
		 */
		protected $fgf_buy_product_count ;

		/**
		 * Get product count.
		 */
		protected $fgf_get_product_count ;

		/**
		 * BOGO Gift Repeat.
		 */
		protected $fgf_bogo_gift_repeat ;

		/**
		 * BOGO Gift repeat mode.
		 */
		protected $fgf_bogo_gift_repeat_mode ;

		/**
		 * BOGO Gift repeat limit.
		 */
		protected $fgf_bogo_gift_repeat_limit ;

		/**
		 * Rule valid from date
		 */
		protected $fgf_rule_valid_from_date ;

		/**
		 * Rule valid To date
		 */
		protected $fgf_rule_valid_to_date ;

		/**
		 * Rule week days validation.
		 */
		protected $fgf_rule_week_days_validation ;

		/**
		 * Automatic prdouct Qty.
		 */
		protected $fgf_automatic_product_qty ;

		/**
		 * Rule Gifts Count Per Order
		 */
		protected $fgf_rule_gifts_count_per_order ;

		/**
		 * Rule Restriction Count
		 */
		protected $fgf_rule_restriction_count ;

		/**
		 * Rule Usage Count
		 */
		protected $fgf_rule_usage_count ;

		/**
		 * Condition Type
		 */
		protected $fgf_condition_type ;

		/**
		 * Total Type
		 */
		protected $fgf_total_type ;

		/**
		 * Cart Categories.
		 */
		protected $fgf_cart_categories ;

		/**
		 * Cart Subtotal Minimum Value
		 */
		protected $fgf_cart_subtotal_min_value ;

		/**
		 * Cart Subtotal Maximum Value
		 */
		protected $fgf_cart_subtotal_max_value ;

		/**
		 * Quantity Minimum Value
		 */
		protected $fgf_quantity_min_value ;

		/**
		 * Quantity Maximum Value
		 */
		protected $fgf_quantity_max_value ;

		/**
		 * Product Count Minimum Value.
		 */
		protected $fgf_product_count_min_value ;

		/**
		 * Product Count Maximum Value
		 */
		protected $fgf_product_count_max_value ;

		/**
		 * Show Notice.
		 */
		protected $fgf_show_notice ;

		/**
		 * Notice.
		 */
		protected $fgf_notice ;

		/**
		 * User Filter Type
		 */
		protected $fgf_user_filter_type ;

		/**
		 * Include Users
		 */
		protected $fgf_include_users ;

		/**
		 * Exclude Users
		 */
		protected $fgf_exclude_users ;

		/**
		 * Include User roles
		 */
		protected $fgf_include_user_roles ;

		/**
		 * Exclude User roles
		 */
		protected $fgf_exclude_user_roles ;

		/**
		 * Product Filter Type
		 */
		protected $fgf_product_filter_type ;

		/**
		 * Include Products
		 */
		protected $fgf_include_products ;

		/**
		 * Products Count
		 */
		protected $fgf_include_product_count ;

		/**
		 * Exclude Products
		 */
		protected $fgf_exclude_products ;

		/**
		 * Applicable Products type.
		 */
		protected $fgf_applicable_products_type ;

		/**
		 * Applicable categories type.
		 */
		protected $fgf_applicable_categories_type ;

		/**
		 * Include Categories
		 */
		protected $fgf_include_categories ;

		/**
		 * Exclude Categories
		 */
		protected $fgf_exclude_categories ;

		/**
		 * Meta data keys
		 */
		protected $meta_data_keys = array(
			'fgf_rule_type'                  => '' ,
			'fgf_gift_type'                  => '' ,
			'fgf_gift_products'              => array() ,
			'fgf_gift_categories'            => array() ,
			'fgf_bogo_gift_type'             => '' ,
			'fgf_buy_product_type'           => '' ,
			'fgf_buy_product'                => array() ,
			'fgf_buy_categories'             => array() ,
			'fgf_buy_category_type'          => '1' ,
			'fgf_get_products'               => array() ,
			'fgf_buy_product_count'          => '' ,
			'fgf_get_product_count'          => '' ,
			'fgf_bogo_gift_repeat'           => '' ,
			'fgf_bogo_gift_repeat_mode'      => '1' ,
			'fgf_bogo_gift_repeat_limit'     => '' ,
			'fgf_rule_valid_from_date'       => '' ,
			'fgf_rule_valid_to_date'         => '' ,
			'fgf_rule_week_days_validation'  => array() ,
			'fgf_automatic_product_qty'      => '' ,
			'fgf_rule_gifts_count_per_order' => '' ,
			'fgf_rule_usage_count'           => '' ,
			'fgf_rule_restriction_count'     => '' ,
			'fgf_condition_type'             => '' ,
			'fgf_total_type'                 => '' ,
			'fgf_cart_categories'            => array() ,
			'fgf_cart_subtotal_min_value'    => '' ,
			'fgf_cart_subtotal_max_value'    => '' ,
			'fgf_quantity_min_value'         => '' ,
			'fgf_quantity_max_value'         => '' ,
			'fgf_product_count_min_value'    => '' ,
			'fgf_product_count_max_value'    => '' ,
			'fgf_show_notice'                => '' ,
			'fgf_notice'                     => '' ,
			'fgf_user_filter_type'           => '' ,
			'fgf_include_users'              => array() ,
			'fgf_exclude_users'              => array() ,
			'fgf_include_user_roles'         => array() ,
			'fgf_exclude_user_roles'         => array() ,
			'fgf_product_filter_type'        => '' ,
			'fgf_include_products'           => array() ,
			'fgf_include_product_count'      => '' ,
			'fgf_exclude_products'           => array() ,
			'fgf_applicable_products_type'   => '' ,
			'fgf_applicable_categories_type' => '' ,
			'fgf_include_categories'         => array() ,
			'fgf_exclude_categories'         => array() ,
				) ;

		/**
		 * Prepare extra post data
		 */
		protected function load_extra_postdata() {
			$this->name          = $this->post->post_title ;
			$this->description   = $this->post->post_content ;
			$this->created_date  = $this->post->post_date_gmt ;
			$this->modified_date = $this->post->post_modified_gmt ;
		}

		/**
		 * Get formatted created datetime
		 */
		public function get_formatted_created_date() {

			return FGF_Date_Time::get_date_object_format_datetime( $this->get_created_date() ) ;
		}

		/**
		 * Get formatted modified datetime
		 */
		public function get_formatted_modified_date() {

			return FGF_Date_Time::get_date_object_format_datetime( $this->get_modified_date() ) ;
		}

		/**
		 * Setters and Getters
		 */

		/**
		 * Set Name
		 */
		public function set_name( $value ) {
			$this->name = $value ;
		}

		/**
		 * Set Description
		 */
		public function set_description( $value ) {
			$this->description = $value ;
		}

		/**
		 * Set Created Date
		 */
		public function set_created_date( $value ) {
			$this->created_date = $value ;
		}

		/**
		 * Set Modified Date
		 */
		public function set_modified_date( $value ) {
			$this->modified_date = $value ;
		}

		/**
		 * Set Rule Type
		 */
		public function set_rule_type( $value ) {
			$this->fgf_rule_type = $value ;
		}

		/**
		 * Set Gift Type
		 */
		public function set_gift_type( $value ) {
			$this->fgf_gift_type = $value ;
		}

		/**
		 * Set Gift Products
		 */
		public function set_gift_products( $value ) {
			$this->fgf_gift_products = $value ;
		}

		/**
		 * Set Gift Categories
		 */
		public function set_gift_categories( $value ) {
			$this->fgf_gift_categories = $value ;
		}

		/**
		 * Set BOGO gift type.
		 */
		public function set_bogo_gift_type( $value ) {
			$this->fgf_bogo_gift_type = $value ;
		}

		/**
		 * Set Buy Product type.
		 */
		public function set_buy_product_type( $value ) {
			$this->fgf_buy_product_type = $value ;
		}

		/**
		 * Set buy product.
		 */
		public function set_buy_product( $value ) {
			$this->fgf_buy_product = $value ;
		}

		/**
		 * Set buy categories.
		 */
		public function set_buy_categories( $value ) {
			$this->fgf_buy_categories = $value ;
		}

		/**
		 * Set Buy Category type.
		 */
		public function set_buy_category_type( $value ) {
			$this->fgf_buy_category_type = $value ;
		}

		/**
		 * Set get products.
		 */
		public function set_get_products( $value ) {
			$this->fgf_get_products = $value ;
		}

		/**
		 * Set buy product count.
		 */
		public function set_buy_product_count( $value ) {
			$this->fgf_buy_product_count = $value ;
		}

		/**
		 * Set get product count.
		 */
		public function set_get_product_count( $value ) {
			$this->fgf_get_product_count = $value ;
		}

		/**
		 * Set BOGO gift repeat.
		 */
		public function set_bogo_gift_repeat( $value ) {
			$this->fgf_bogo_gift_repeat = $value ;
		}

		/**
		 * Set BOGO gift repeat mode.
		 */
		public function set_bogo_gift_repeat_mode( $value ) {
			$this->fgf_bogo_gift_repeat_mode = $value ;
		}

		/**
		 * Set BOGO gift repeat limit.
		 */
		public function set_bogo_gift_repeat_limit( $value ) {
			$this->fgf_bogo_gift_repeat_limit = $value ;
		}

		/**
		 * Set Rule Valid From Date
		 */
		public function set_rule_valid_from_date( $value ) {
			$this->fgf_rule_valid_from_date = $value ;
		}

		/**
		 * Set Rule Valid To Date
		 */
		public function set_rule_valid_to_date( $value ) {
			$this->fgf_rule_valid_to_date = $value ;
		}

		/**
		 * Set Rule Week Days Validation.
		 */
		public function set_rule_week_days_validation( $value ) {
			$this->fgf_rule_week_days_validation = $value ;
		}

		/**
		 * Set Automatic product Qty.
		 */
		public function set_automatic_product_qty( $value ) {
			$this->fgf_automatic_product_qty = $value ;
		}

		/**
		 * Set rule gifts count per order
		 */
		public function set_rule_gifts_count_per_order( $value ) {
			$this->fgf_rule_gifts_count_per_order = $value ;
		}

		/**
		 * Set rule restriction count
		 */
		public function set_rule_restriction_count( $value ) {
			$this->fgf_rule_restriction_count = $value ;
		}

		/**
		 * Set rule usage count
		 */
		public function set_rule_usage_count( $value ) {
			$this->fgf_rule_usage_count = $value ;
		}

		/**
		 * Set Condition Type
		 */
		public function set_condition_type( $value ) {
			$this->fgf_condition_type = $value ;
		}

		/**
		 * Set Total Type
		 */
		public function set_total_type( $value ) {
			$this->fgf_total_type = $value ;
		}

		/**
		 * Set Cart Categories.
		 */
		public function set_cart_categories( $value ) {
			$this->fgf_cart_categories = $value ;
		}

		/**
		 * Set Cart Subtotal Minimum Value
		 */
		public function set_cart_subtotal_minimum_value( $value ) {
			$this->fgf_cart_subtotal_min_value = $value ;
		}

		/**
		 * Set Cart Subtotal Maximum Value
		 */
		public function set_cart_subtotal_maximum_value( $value ) {
			$this->fgf_cart_subtotal_max_value = $value ;
		}

		/**
		 * Set Quantity Minimum Value
		 */
		public function set_quantity_minimum_value( $value ) {
			$this->fgf_quantity_min_value = $value ;
		}

		/**
		 * Set Quantity Maximum Value
		 */
		public function set_quantity_maximum_value( $value ) {
			$this->fgf_quantity_min_value = $value ;
		}

		/**
		 * Set Product Count Minimum Value.
		 */
		public function set_product_count_min_value( $value ) {
			$this->fgf_product_count_min_value = $value ;
		}

		/**
		 * Set Product Count Maximum Value.
		 */
		public function set_product_count_max_value( $value ) {
			$this->fgf_product_count_max_value = $value ;
		}

		/**
		 * Set Show Notice.
		 */
		public function set_show_notice( $value ) {
			$this->fgf_show_notice = $value ;
		}

		/**
		 * Set Notice.
		 */
		public function set_notice( $value ) {
			$this->fgf_notice = $value ;
		}

		/**
		 * Set User Filter Type
		 */
		public function set_user_filter_type( $value ) {

			$this->fgf_user_filter_type = $value ;
		}

		/**
		 * Set Include Users
		 */
		public function set_include_users( $value ) {
			$this->fgf_include_users = $value ;
		}

		/**
		 * Set Exclude Users
		 */
		public function set_exclude_users( $value ) {
			$this->fgf_exclude_users = $value ;
		}

		/**
		 * Set Include User Roles
		 */
		public function set_include_user_roles( $value ) {
			$this->fgf_include_user_roles = $value ;
		}

		/**
		 * Set Exclude User Roles
		 */
		public function set_exclude_user_roles( $value ) {
			$this->fgf_exclude_user_roles = $value ;
		}

		/**
		 * Set Product Filter Type
		 */
		public function set_product_filter_type( $value ) {
			$this->fgf_product_filter_type = $value ;
		}

		/**
		 * Set Include Products
		 */
		public function set_include_products( $value ) {
			$this->fgf_include_products = $value ;
		}

		/**
		 * Set Exclude Products
		 */
		public function set_exclude_products( $value ) {
			$this->fgf_exclude_products = $value ;
		}

		/**
		 * Set Applicable Products type
		 */
		public function set_applicable_products_type( $value ) {
			$this->fgf_applicable_products_type = $value ;
		}

		/**
		 * Set include Product Count.
		 */
		public function set_include_product_count( $value ) {

			$this->fgf_include_product_count = $value ;
		}

		/**
		 * Set Applicable Categories type
		 */
		public function set_applicable_categories_type( $value ) {
			$this->fgf_applicable_categories_type = $value ;
		}

		/**
		 * Set Include Categories
		 */
		public function set_include_categories( $value ) {
			$this->fgf_include_categories = $value ;
		}

		/**
		 * Set Exclude Categories
		 */
		public function set_exclude_categories( $value ) {
			$this->fgf_exclude_categories = $value ;
		}

		/**
		 * Get Name
		 */
		public function get_name() {

			return $this->name ;
		}

		/**
		 * Get Description
		 */
		public function get_description() {

			return $this->description ;
		}

		/**
		 * Get Created Date
		 */
		public function get_created_date() {

			return $this->created_date ;
		}

		/**
		 * Get Modified Date
		 */
		public function get_modified_date() {

			return $this->modified_date ;
		}

		/**
		 * Get Rule Type
		 */
		public function get_rule_type() {

			return $this->fgf_rule_type ;
		}

		/**
		 * Get Gift Type
		 */
		public function get_gift_type() {

			return $this->fgf_gift_type ;
		}

		/**
		 * Get Gift Products
		 */
		public function get_gift_products() {

			return $this->fgf_gift_products ;
		}

		/**
		 * Get Gift Categories
		 */
		public function get_gift_categories() {

			return $this->fgf_gift_categories ;
		}

		/**
		 * Get BOGO gift type.
		 */
		public function get_bogo_gift_type() {
			return $this->fgf_bogo_gift_type ;
		}

		/**
		 * Get Buy Product type.
		 */
		public function get_buy_product_type() {
			return $this->fgf_buy_product_type ;
		}

		/**
		 * Get buy product.
		 */
		public function get_buy_product() {
			return $this->fgf_buy_product ;
		}

		/**
		 * Get buy categories.
		 */
		public function get_buy_categories() {
			return $this->fgf_buy_categories ;
		}

		/**
		 * Get Buy Category type.
		 */
		public function get_buy_category_type() {
			return $this->fgf_buy_category_type ;
		}

		/**
		 * Get products.
		 */
		public function get_products() {
			return $this->fgf_get_products ;
		}

		/**
		 * Get buy product count.
		 */
		public function get_buy_product_count() {
			return $this->fgf_buy_product_count ;
		}

		/**
		 * Get product count.
		 */
		public function get_product_count() {
			return $this->fgf_get_product_count ;
		}

		/**
		 * Get BOGO gift repeat.
		 */
		public function get_bogo_gift_repeat() {
			return $this->fgf_bogo_gift_repeat ;
		}

		/**
		 * Get BOGO gift repeat mode.
		 */
		public function get_bogo_gift_repeat_mode() {
			return $this->fgf_bogo_gift_repeat_mode ;
		}

		/**
		 * Get BOGO gift repeat limit.
		 */
		public function get_bogo_gift_repeat_limit() {
			return $this->fgf_bogo_gift_repeat_limit ;
		}

		/**
		 * Get Rule Valid From Date
		 */
		public function get_rule_valid_from_date() {

			return $this->fgf_rule_valid_from_date ;
		}

		/**
		 * Get Rule Valid To Date
		 */
		public function get_rule_valid_to_date() {

			return $this->fgf_rule_valid_to_date ;
		}

		/**
		 * Get Rule Week Days Validation.
		 */
		public function get_rule_week_days_validation() {
			return $this->fgf_rule_week_days_validation ;
		}

		/**
		 * Get Automatic product Qty.
		 */
		public function get_automatic_product_qty() {
			return $this->fgf_automatic_product_qty ;
		}

		/**
		 * Get rule gifts count per order
		 */
		public function get_rule_gifts_count_per_order() {
			return $this->fgf_rule_gifts_count_per_order ;
		}

		/**
		 * Get rule restriction count
		 */
		public function get_rule_restriction_count() {

			return $this->fgf_rule_restriction_count ;
		}

		/**
		 * Get rule usage count
		 */
		public function get_rule_usage_count() {

			return $this->fgf_rule_usage_count ;
		}

		/**
		 * Get Condition Type
		 */
		public function get_condition_type() {

			return $this->fgf_condition_type ;
		}

		/**
		 * Get Total Type.
		 * */
		public function get_total_type() {
			return $this->fgf_total_type ;
		}

		/**
		 * Get Cart Categories.
		 */
		public function get_cart_categories() {
			return $this->fgf_cart_categories ;
		}

		/**
		 * Get Cart Subtotal Minimum Value
		 */
		public function get_cart_subtotal_minimum_value() {

			return $this->fgf_cart_subtotal_min_value ;
		}

		/**
		 * Get Cart Subtotal Maximum Value
		 */
		public function get_cart_subtotal_maximum_value() {

			return $this->fgf_cart_subtotal_max_value ;
		}

		/**
		 * Get Quantity Minimum Value
		 */
		public function get_quantity_minimum_value() {

			return $this->fgf_quantity_min_value ;
		}

		/**
		 * Get Quantity Maximum Value
		 */
		public function get_quantity_maximum_value() {

			return $this->fgf_quantity_max_value ;
		}

		/**
		 * Get Product Count Minimum Value.
		 */
		public function get_product_count_min_value() {
			return $this->fgf_product_count_min_value ;
		}

		/**
		 * Get Product Count Maximum Value.
		 */
		public function get_product_count_max_value() {
			return $this->fgf_product_count_max_value ;
		}

		/**
		 * Get Show Notice.
		 */
		public function get_show_notice() {
			return $this->fgf_show_notice ;
		}

		/**
		 * Get Notice.
		 */
		public function get_notice() {
			return $this->fgf_notice ;
		}

		/**
		 * Get User Filter Type
		 */
		public function get_user_filter_type() {

			return $this->fgf_user_filter_type ;
		}

		/**
		 * Get Include Users
		 */
		public function get_include_users() {

			return $this->fgf_include_users ;
		}

		/**
		 * Get Exclude Users
		 */
		public function get_exclude_users() {

			return $this->fgf_exclude_users ;
		}

		/**
		 * Get Include User Roles
		 */
		public function get_include_user_roles() {

			return $this->fgf_include_user_roles ;
		}

		/**
		 * Get Exclude User Roles
		 */
		public function get_exclude_user_roles() {

			return $this->fgf_exclude_user_roles ;
		}

		/**
		 * Get Product Filter Type
		 */
		public function get_product_filter_type() {

			return $this->fgf_product_filter_type ;
		}

		/**
		 * Get Include Products
		 */
		public function get_include_products() {

			return $this->fgf_include_products ;
		}

		/**
		 * Get Products Count
		 */
		public function get_include_product_count() {

			return $this->fgf_include_product_count ;
		}

		/**
		 * Get Exclude Products
		 */
		public function get_exclude_products() {

			return $this->fgf_exclude_products ;
		}

		/**
		 * Get Applicable Products type
		 */
		public function get_applicable_products_type() {
			return $this->fgf_applicable_products_type ;
		}

		/**
		 * Get Applicable Categories type
		 */
		public function get_applicable_categories_type() {
			return $this->fgf_applicable_categories_type ;
		}

		/**
		 * Get Include Categories
		 */
		public function get_include_categories() {

			return $this->fgf_include_categories ;
		}

		/**
		 * Get Exclude Categories
		 */
		public function get_exclude_categories() {

			return $this->fgf_exclude_categories ;
		}

	}

}
