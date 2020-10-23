<?php

/*
 * Master Log
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'FGF_Master_Log' ) ) {

	/**
	 * FGF_Master_Log Class.
	 */
	class FGF_Master_Log extends FGF_Post {

		/**
		 * Post Type
		 */
		protected $post_type = FGF_Register_Post_Types::MASTER_LOG_POSTTYPE;

		/**
		 * Post Status
		 */
		protected $post_status = 'fgf_manual';

		/**
		 * User ID
		 */
		protected $user_id;

		/**
		 * Rule IDs
		 */
		protected $fgf_rule_ids;

		/**
		 * Product Details
		 */
		protected $fgf_product_details;

		/**
		 * User Name
		 */
		protected $fgf_user_name;

		/**
		 * User Email
		 */
		protected $fgf_user_email;

		/**
		 * Order ID
		 */
		protected $fgf_order_id;

		/**
		 * Type
		 */
		protected $fgf_type;

		/**
		 * Meta data keys
		 */
		protected $meta_data_keys = array(
			'fgf_rule_ids'        => '',
			'fgf_product_details' => '',
			'fgf_user_name'       => '',
			'fgf_user_email'      => '',
			'fgf_order_id'        => '',
			'fgf_type'            => '',
		);

		/**
		 * Prepare extra post data
		 */
		protected function load_extra_postdata() {
			$this->user_id      = $this->post->post_parent;
			$this->created_date = $this->post->post_date_gmt;
		}

		/**
		 * Get formatted created datetime
		 */
		public function get_formatted_created_date() {

			return FGF_Date_Time::get_date_object_format_datetime( $this->get_created_date() );
		}

		/**
		 * Setters and Getters
		 */

		/**
		 * Set Rule IDs
		 */
		public function set_rule_ids( $value ) {
			$this->fgf_rule_ids = $value;
		}

		/**
		 * Set User ID
		 */
		public function set_user_id( $value ) {
			$this->user_id = $value;
		}

		/**
		 * Set Order ID
		 */
		public function set_order_id( $value ) {
			$this->fgf_order_id = $value;
		}

		/**
		 * Set Product Details
		 */
		public function set_product_details( $value ) {
			$this->fgf_product_details = $value;
		}

		/**
		 * Set User Name
		 */
		public function set_user_name( $value ) {
			$this->fgf_user_name = $value;
		}

		/**
		 * Set User Email
		 */
		public function set_user_email( $value ) {
			$this->fgf_user_email = $value;
		}

		/**
		 * Set Type
		 */
		public function set_type( $value ) {
			$this->fgf_type = $value;
		}

		/**
		 * Set created date
		 */
		public function set_created_date( $value ) {
			$this->created_date = $value;
		}

		/**
		 * Get Rule IDs
		 */
		public function get_rule_ids() {

			return $this->fgf_rule_ids;
		}

		/**
		 * Get Order ID
		 */
		public function get_order_id() {

			return $this->fgf_order_id;
		}

		/**
		 * Get User ID
		 */
		public function get_user_id() {

			return $this->user_id;
		}

		/**
		 * Get Product Details
		 */
		public function get_product_details() {

			return $this->fgf_product_details;
		}

		/**
		 * Get User Name
		 */
		public function get_user_name() {

			return $this->fgf_user_name;
		}

		/**
		 * Get User Email
		 */
		public function get_user_email() {

			return $this->fgf_user_email;
		}

		/**
		 * Get Type
		 */
		public function get_type() {

			return $this->fgf_type;
		}

		/**
		 * Get created date
		 */
		public function get_created_date() {

			return $this->created_date;
		}

	}

}

