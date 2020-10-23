<?php

/*
 * Post functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( ! function_exists( 'fgf_create_new_rule' ) ) {

	/**
	 * Create New Rule
	 *
	 * @return integer/string
	 */
	function fgf_create_new_rule( $meta_args, $post_args = array() ) {

		$object = new FGF_RULE() ;
		$id     = $object->create( $meta_args , $post_args ) ;

		return $id ;
	}

}

if ( ! function_exists( 'fgf_get_rule' ) ) {

	/**
	 * Get Rule object
	 *
	 * @return object
	 */
	function fgf_get_rule( $id ) {

		$object = new FGF_RULE( $id ) ;

		return $object ;
	}

}

if ( ! function_exists( 'fgf_update_rule' ) ) {

	/**
	 * Update Rule
	 *
	 * @return object
	 */
	function fgf_update_rule( $id, $meta_args, $post_args = array() ) {

		$object = new FGF_RULE( $id ) ;
		$object->update( $meta_args , $post_args ) ;

		return $object ;
	}

}

if ( ! function_exists( 'fgf_delete_rule' ) ) {

	/**
	 * Delete Rule
	 *
	 * @return bool
	 */
	function fgf_delete_rule( $id, $force = true ) {

		wp_delete_post( $id , $force ) ;

		return true ;
	}

}

if ( ! function_exists( 'fgf_create_new_master_log' ) ) {

	/**
	 * Create New Master Log
	 *
	 * @return Integer/String
	 */
	function fgf_create_new_master_log( $meta_args, $post_args = array() ) {

		$object = new FGF_Master_Log() ;
		$id     = $object->create( $meta_args , $post_args ) ;

		return $id ;
	}

}

if ( ! function_exists( 'fgf_get_master_log' ) ) {

	/**
	 * Get Master Log Object
	 *
	 * @return Object
	 */
	function fgf_get_master_log( $id ) {

		$object = new FGF_Master_Log( $id ) ;

		return $object ;
	}

}

if ( ! function_exists( 'fgf_update_master_log' ) ) {

	/**
	 * Update Master Log
	 *
	 * @return Object
	 */
	function fgf_update_master_log( $id, $meta_args, $post_args = array() ) {

		$object = new FGF_Master_Log( $id ) ;
		$object->update( $meta_args , $post_args ) ;

		return $object ;
	}

}

if ( ! function_exists( 'fgf_delete_master_log' ) ) {

	/**
	 * Delete Master Log
	 *
	 * @return bool
	 */
	function fgf_delete_master_log( $id, $force = true ) {

		wp_delete_post( $id , $force ) ;

		return true ;
	}

}

if ( ! function_exists( 'fgf_get_rule_statuses' ) ) {

	/**
	 * Get Rule statuses
	 *
	 * @return array
	 */
	function fgf_get_rule_statuses() {
		return apply_filters( 'fgf_rule_statuses' , array( 'fgf_active' , 'fgf_inactive' ) ) ;
	}

}

if ( ! function_exists( 'fgf_get_master_log_statuses' ) ) {

	/**
	 * Get Master log statuses
	 *
	 * @return array
	 */
	function fgf_get_master_log_statuses() {
		return apply_filters( 'fgf_master_log_statuses' , array( 'fgf_manual' , 'fgf_automatic' ) ) ;
	}

}

if ( ! function_exists( 'fgf_get_active_rule_ids' ) ) {

	/**
	 * Get active rule Ids
	 *
	 * @return array
	 */
	function fgf_get_active_rule_ids() {

		return fgf_get_rule_ids( 'fgf_active' ) ;
	}

}

if ( ! function_exists( 'fgf_get_rule_ids' ) ) {

	/**
	 * Get rule Ids
	 *
	 * @return array
	 */
	function fgf_get_rule_ids( $post_status = 'all' ) {
		if ( 'all' == $post_status ) {
			$post_status = fgf_get_rule_statuses() ;
		}

		$args = array(
			'post_type'      => FGF_Register_Post_Types::RULES_POSTTYPE ,
			'post_status'    => $post_status ,
			'posts_per_page' => '-1' ,
			'fields'         => 'ids' ,
			'orderby'        => 'menu_order' ,
			'order'          => 'ASC' ,
				) ;

		return get_posts( $args ) ;
	}

}

if ( ! function_exists( 'fgf_get_product_id_by_category' ) ) {

	/**
	 * Get Product IDs based on category
	 *
	 * @return array
	 */
	function fgf_get_product_id_by_category( $category_id ) {

		if ( ! $category_id ) {
			return array() ;
		}

		$args = array(
			'post_type'      => 'product' ,
			'posts_per_page' => '-1' ,
			'post_status'    => 'publish' ,
			'cache_results'  => false ,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_cat' ,
					'field'    => 'id' ,
					'terms'    => array( $category_id ) ,
					'operator' => 'IN' ,
				) ,
			) ,
			'fields'         => 'ids' ,
		) ;

		return get_posts( $args ) ;
	}

}
