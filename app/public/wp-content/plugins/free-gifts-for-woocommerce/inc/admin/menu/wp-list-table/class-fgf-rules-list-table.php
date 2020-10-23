<?php

/**
 * Rules List Table
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' ) ;
}

if ( ! class_exists( 'FGF_Rules_List_Table' ) ) {

	/**
	 * FGF_Rules_List_Table Class.
	 * */
	class FGF_Rules_List_Table extends WP_List_Table {

		/**
		 * Total Count of Table
		 * */
		private $total_items ;

		/**
		 * Per page count
		 * */
		private $perpage ;

		/**
		 * Database
		 * */
		private $database ;

		/**
		 * Offset
		 * */
		private $offset ;

		/**
		 * Order BY
		 * */
		private $orderby = 'ORDER BY menu_order ASC,ID ASC' ;

		/**
		 * Post type
		 * */
		private $post_type = FGF_Register_Post_Types::RULES_POSTTYPE ;

		/**
		 * Base URL
		 * */
		private $base_url ;

		/**
		 * Current URL
		 * */
		private $current_url ;

		/**
		 * Prepare the table Data to display table based on pagination.
		 * */
		public function prepare_items() {
			global $wpdb ;
			$this->database = $wpdb ;

			$this->base_url = fgf_get_rule_page_url() ;

			add_filter( sanitize_key( $this->table_slug . '_query_where' ) , array( $this , 'custom_search' ) , 10 , 1 ) ;
			add_filter( sanitize_key( $this->table_slug . '_query_orderby' ) , array( $this , 'query_orderby' ) ) ;

			$this->prepare_current_url() ;
			$this->process_bulk_action() ;
			$this->get_perpage_count() ;
			$this->get_current_pagenum() ;
			$this->get_current_page_items() ;
			$this->prepare_pagination_args() ;
			$this->prepare_column_headers() ;
		}

		/**
		 * Get per page count
		 * */
		private function get_perpage_count() {

			$this->perpage = 10 ;
		}

		/**
		 * Prepare pagination
		 * */
		private function prepare_pagination_args() {

			$this->set_pagination_args(
					array(
						'total_items' => $this->total_items ,
						'per_page'    => $this->perpage ,
					)
			) ;
		}

		/**
		 * Get current page number
		 * */
		private function get_current_pagenum() {

			$this->offset = 10 * ( $this->get_pagenum() - 1 ) ;
		}

		/**
		 * Prepare header columns
		 * */
		private function prepare_column_headers() {
			$columns               = $this->get_columns() ;
			$hidden                = $this->get_hidden_columns() ;
			$sortable              = $this->get_sortable_columns() ;
			$this->_column_headers = array( $columns , $hidden , $sortable ) ;
		}

		/**
		 * Initialize the columns
		 * */
		public function get_columns() {
			$columns = array(
				'cb'               => '<input type="checkbox" />' , // Render a checkbox instead of text
				'rule_name'        => esc_html__( 'Rule Name' , 'free-gifts-for-woocommerce' ) ,
				'status'           => esc_html__( 'Status' , 'free-gifts-for-woocommerce' ) ,
				'validity'         => esc_html__( 'Validity' , 'free-gifts-for-woocommerce' ) ,
				'type'             => esc_html__( 'Type' , 'free-gifts-for-woocommerce' ) ,
				'product_category' => esc_html__( 'Product(s) / Categories' , 'free-gifts-for-woocommerce' ) ,
				'created_date'     => esc_html__( 'Created Date' , 'free-gifts-for-woocommerce' ) ,
				'modified_date'    => esc_html__( 'Last Modified Date' , 'free-gifts-for-woocommerce' ) ,
				'actions'          => esc_html__( 'Actions' , 'free-gifts-for-woocommerce' ) ,
					) ;

			if ( ! isset( $_REQUEST[ 'post_status' ] ) && ! isset( $_REQUEST[ 's' ] ) ) {
				$columns[ 'sort' ] = '<img src="' . esc_url( FGF_PLUGIN_URL . '/assets/images/drag-icon.png' ) . '" title="' . esc_html__( 'Sort' , 'free-gifts-for-woocommerce' ) . '"></img>' ;
			}

			return $columns ;
		}

		/**
		 * Initialize the hidden columns
		 * */
		public function get_hidden_columns() {
			return array() ;
		}

		/**
		 * Initialize the sortable columns
		 * */
		public function get_sortable_columns() {
			return array(
				'rule_name'     => array( 'rule_name' , false ) ,
				'status'        => array( 'status' , false ) ,
				'created_date'  => array( 'created' , false ) ,
				'modified_date' => array( 'modified' , false ) ,
					) ;
		}

		/**
		 * Get current url
		 * */
		private function prepare_current_url() {

			$pagenum         = $this->get_pagenum() ;
			$args[ 'paged' ] = $pagenum ;
			$url             = add_query_arg( $args , $this->base_url ) ;

			$this->current_url = $url ;
		}

		/**
		 * Initialize the bulk actions
		 * */
		protected function get_bulk_actions() {
			$action               = array() ;
			$action[ 'active' ]   = esc_html__( 'Activate' , 'free-gifts-for-woocommerce' ) ;
			$action[ 'inactive' ] = esc_html__( 'Deactivate' , 'free-gifts-for-woocommerce' ) ;
			$action[ 'delete' ]   = esc_html__( 'Delete' , 'free-gifts-for-woocommerce' ) ;

			return apply_filters( $this->plugin_slug . '_rule_bulk_actions' , $action ) ;
		}

		/**
		 * Display the list of views available on this table.
		 * */
		public function get_views() {
			$args        = array() ;
			$status_link = array() ;

			$status_link_array = array(
				'all'          => esc_html__( 'All' , 'free-gifts-for-woocommerce' ) ,
				'fgf_active'   => esc_html__( 'Active' , 'free-gifts-for-woocommerce' ) ,
				'fgf_inactive' => esc_html__( 'Inactive' , 'free-gifts-for-woocommerce' ) ,
					) ;

			foreach ( $status_link_array as $status_name => $status_label ) {
				$status_count = $this->get_total_item_for_status( $status_name ) ;

				if ( ! $status_count ) {
					continue ;
				}

				$args[ 'status' ] = $status_name ;

				$label = $status_label . ' (' . $status_count . ')' ;

				$class = array( strtolower( $status_name ) ) ;
				if ( isset( $_GET[ 'status' ] ) && ( sanitize_title( $_GET[ 'status' ] ) == $status_name ) ) { // @codingStandardsIgnoreLine.
					$class[] = 'current' ;
				}

				if ( ! isset( $_GET[ 'status' ] ) && 'all' == $status_name ) { // @codingStandardsIgnoreLine.
					$class[] = 'current' ;
				}

				$status_link[ $status_name ] = $this->get_edit_link( $args , $label , implode( ' ' , $class ) ) ;
			}

			return $status_link ;
		}

		/**
		 * Edit link for status
		 * */
		private function get_edit_link( $args, $label, $class = '' ) {
			$url        = add_query_arg( $args , $this->base_url ) ;
			$class_html = '' ;
			if ( ! empty( $class ) ) {
				$class_html = sprintf(
						' class="%s"' , esc_attr( $class )
						) ;
			}

			return sprintf(
					'<a href="%s"%s>%s</a>' , esc_url( $url ) , $class_html , $label
					) ;
		}

		/**
		 * Prepare cb column data
		 * */
		protected function column_cb( $item ) {
			return sprintf(
					'<input type="checkbox" name="id[]" value="%s" />' , $item->get_id()
					) ;
		}

		/**
		 * Bulk action functionality
		 * */
		public function process_bulk_action() {

			$ids = isset( $_REQUEST[ 'id' ] ) ? wc_clean( wp_unslash( ( $_REQUEST[ 'id' ] ) ) ) : array() ; // @codingStandardsIgnoreLine.
			$ids = ! is_array( $ids ) ? explode( ',' , $ids ) : $ids ;

			if ( ! fgf_check_is_array( $ids ) ) {
				return ;
			}

			if ( ! current_user_can( 'edit_posts' ) ) {
				wp_die( '<p class="error">' . esc_html__( 'Sorry, you are not allowed to edit this item.' , 'free-gifts-for-woocommerce' ) . '</p>' ) ;
			}

			$action = $this->current_action() ;

			foreach ( $ids as $id ) {
				if ( 'delete' === $action ) {
					wp_delete_post( $id , true ) ;
				} elseif ( 'active' === $action ) {
					fgf_update_rule( $id , array() , array( 'post_status' => 'fgf_active' ) ) ;
				} elseif ( 'inactive' === $action ) {
					fgf_update_rule( $id , array() , array( 'post_status' => 'fgf_inactive' ) ) ;
				}
			}

			wp_safe_redirect( $this->current_url ) ;
			exit() ;
		}

		/**
		 * Prepare each column data
		 * */
		protected function column_default( $item, $column_name ) {

			switch ( $column_name ) {

				case 'rule_name':
					return '<a href="' . esc_url(
									add_query_arg(
											array(
								'action' => 'edit' ,
								'id'     => $item->get_id() ,
											) , $this->base_url
									)
							) . '">' . esc_html( $item->get_name() ) . '</a>' ;
					break ;

				case 'status':
					return fgf_display_status( $item->get_status() ) ;

					break ;

				case 'type':
					return fgf_get_rule_type_name( $item->get_rule_type() ) ;

					break ;

				case 'validity':
					$from = ! empty( $item->get_rule_valid_from_date() ) ? $item->get_rule_valid_from_date() : '-' ;
					$to   = ! empty( $item->get_rule_valid_to_date() ) ? $item->get_rule_valid_to_date() : '-' ;

					if ( '-' === $from && '-' === $to ) {
						return esc_html__( 'Unlimited' , 'free-gifts-for-woocommerce' ) ;
					} elseif ( '-' === $to ) {
						$to = esc_html__( 'Unlimited' , 'free-gifts-for-woocommerce' ) ;
					}

					return esc_html__( 'From' , 'free-gifts-for-woocommerce' ) . '&nbsp:&nbsp&nbsp' . $from . '<br />' . esc_html__( 'To' , 'free-gifts-for-woocommerce' ) . '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp' . $to ;
					break ;

				case 'product_category':
					return $this->render_product_category( $item ) ;
					break ;

				case 'created_date':
					return $item->get_formatted_created_date() ;
					break ;

				case 'modified_date':
					return $item->get_formatted_modified_date() ;
					break ;

				case 'actions':
					$actions       = array() ;
					$status_action = ( $item->get_status() == 'fgf_inactive' ) ? 'active' : 'inactive' ;

					$actions[ 'edit' ]         = fgf_display_action( 'edit' , $item->get_id() , $this->current_url , true ) ;
					$actions[ $status_action ] = fgf_display_action( $status_action , $item->get_id() , $this->current_url ) ;
					$actions[ 'delete' ]       = fgf_display_action( 'delete' , $item->get_id() , $this->current_url ) ;

					end( $actions ) ;

					$last_key = key( $actions ) ;
					$views    = '' ;
					foreach ( $actions as $key => $action ) {
						$views .= $action ;

						if ( $last_key == $key ) {
							break ;
						}

						$views .= ' | ' ;
					}

					return $views ;

					break ;

				case 'sort':
					return '<div class = "fgf_post_sort_handle">'
							. '<img src = "' . esc_url( FGF_PLUGIN_URL . '/assets/images/drag-icon.png' ) . '" title="' . esc_html__( 'Sort' , 'free-gifts-for-woocommerce' ) . '"></img>'
							. '<input type = "hidden" class = "fgf_rules_sortable" value = "' . $item->get_id() . '" />'
							. '</div>' ;
					break ;
			}
		}

		/**
		 * Render product category.
		 */
		private function render_product_category( $item ) {

			if ( '3' == $item->get_rule_type() ) {

				$buy_products_label = esc_html__( 'Buy Product(s)' , 'free-gifts-for-woocommerce' ) ;
				if ( '2' == $item->get_buy_product_type() ) {
					$buy_products_link = $this->get_categories_link( $item->get_buy_categories() ) ;
					$buy_products_link = esc_html__( 'Product(s) of' , 'free-gifts-for-woocommerce' ) . ' ' . $buy_products_link ;
				} else {
					$buy_products_link = $this->get_products_link( $item->get_buy_product() ) ;
				}

				$bogo_products      = '<b><u>' . $buy_products_label . '</u></b><br />' . rtrim( $buy_products_link , ' , ' ) ;
				$get_products_label = esc_html__( 'Get Product(s)' , 'free-gifts-for-woocommerce' ) ;

				if ( '2' == $item->get_bogo_gift_type() ) {
					$get_products_link = $this->get_products_link( $item->get_products() ) ;
				} else {
					$get_products_link = $buy_products_link ;
				}

				$bogo_products .= '<br ><b><u>' . $get_products_label . '</u></b><br />' . rtrim( $get_products_link , ' , ' ) ;

				return $bogo_products ;
			} elseif ( '2' == $item->get_gift_type() && '2' != $item->get_rule_type() ) {

				$categories_link = $this->get_categories_link( $item->get_gift_categories() ) ;

				return '<b><u>' . esc_html__( 'Categories' , 'free-gifts-for-woocommerce' ) . '</u></b><br />' . rtrim( $categories_link , ' , ' ) ;
			} else {
				$products_link = $this->get_products_link( $item->get_gift_products() ) ;

				return '<b><u>' . esc_html__( 'Product(s)' , 'free-gifts-for-woocommerce' ) . '</u></b><br />' . rtrim( $products_link , ' , ' ) ;
			}
		}

		/**
		 * Products Link.
		 * */
		private function get_products_link( $product_ids ) {
			$products_link = '' ;

			foreach ( $product_ids as $product_id ) {
				$product = wc_get_product( $product_id ) ;

				//Return if the Product does not exist.
				if ( ! $product ) {
					continue ;
				}

				$products_link .= '<a href="' . esc_url(
								add_query_arg(
										array(
							'post'   => $product_id ,
							'action' => 'edit' ,
										) , admin_url( 'post.php' )
								)
						) . '" >' . $product->get_name() . '</a> , ' ;
			}

			return $products_link ;
		}

		/**
		 * Categories Link.
		 * */
		private function get_categories_link( $categories_ids ) {
			$categories_link = '' ;

			foreach ( $categories_ids as $category_id ) {
				$category = get_term_by( 'id' , $category_id , 'product_cat' ) ;
				if ( ! is_object( $category ) ) {
					continue ;
				}

				$categories_link .= '<a href="' . esc_url(
								add_query_arg(
										array(
							'product_cat' => $category->slug ,
							'post_type'   => 'product' ,
										) , admin_url( 'edit.php' )
								)
						) . '" >' . $category->name . '</a> , ' ;
			}

			return $categories_link ;
		}

		/**
		 * Initialize the columns
		 * */
		private function get_current_page_items() {

			$status = ( isset( $_GET[ 'status' ] ) && ( sanitize_title( $_GET[ 'status' ] ) != 'all' ) ) ? ' IN("' . sanitize_title( $_GET[ 'status' ] ) . '")' : ' NOT IN("trash")' ; // @codingStandardsIgnoreLine.

			if ( ! empty( $_REQUEST[ 's' ] ) || ! empty( $_REQUEST[ 'orderby' ] ) ) { // @codingStandardsIgnoreLine.
				$where = ' INNER JOIN ' . $this->database->postmeta . " pm ON ( pm.post_id = p.ID ) where post_type='" . $this->post_type . "' and post_status " . $status ;
			} else {
				$where = " where post_type='" . $this->post_type . "' and post_status" . $status ;
			}

			$where   = apply_filters( $this->table_slug . '_query_where' , $where ) ;
			$limit   = apply_filters( $this->table_slug . '_query_limit' , $this->perpage ) ;
			$offset  = apply_filters( $this->table_slug . '_query_offset' , $this->offset ) ;
			$orderby = apply_filters( $this->table_slug . '_query_orderby' , $this->orderby ) ;

			$count_items       = $this->database->get_results( 'SELECT DISTINCT ID FROM ' . $this->database->posts . " AS p $where $orderby" ) ;
			$this->total_items = count( $count_items ) ;

			$prepare_query = $this->database->prepare( 'SELECT DISTINCT ID FROM ' . $this->database->posts . " AS p $where $orderby LIMIT %d,%d" , $offset , $limit ) ;

			$items = $this->database->get_results( $prepare_query , ARRAY_A ) ;

			$this->prepare_item_object( $items ) ;
		}

		/**
		 * Prepare item Object
		 * */
		private function prepare_item_object( $items ) {
			$prepare_items = array() ;
			if ( fgf_check_is_array( $items ) ) {
				foreach ( $items as $item ) {
					$prepare_items[] = fgf_get_rule( $item[ 'ID' ] ) ;
				}
			}

			$this->items = $prepare_items ;
		}

		/**
		 * Get total item from status
		 * */
		private function get_total_item_for_status( $status = '' ) {

			$status = ( 'all' == $status ) ? "NOT IN('trash')" : "IN('" . $status . "')" ;

			$prepare_query = $this->database->prepare( 'SELECT ID FROM ' . $this->database->posts . " WHERE post_type=%s and post_status $status" , $this->post_type ) ;

			$data = $this->database->get_results( $prepare_query , ARRAY_A ) ;

			return count( $data ) ;
		}

		/**
		 * Sort
		 * */
		public function query_orderby( $orderby ) {

			if ( empty( $_REQUEST[ 'orderby' ] ) ) { // @codingStandardsIgnoreLine.
				return $orderby ;
			}

			$order = 'DESC' ;
			if ( ! empty( $_REQUEST[ 'order' ] ) && is_string( $_REQUEST[ 'order' ] ) ) { // @codingStandardsIgnoreLine.
				if ( 'ASC' === strtoupper( wc_clean( wp_unslash( $_REQUEST[ 'order' ] ) ) ) ) { // @codingStandardsIgnoreLine.
					$order = 'ASC' ;
				}
			}

			switch ( wc_clean( wp_unslash( $_REQUEST[ 'orderby' ] ) ) ) { // @codingStandardsIgnoreLine.
				case 'rule_name':
					$orderby = ' ORDER BY p.post_title ' . $order ;
					break ;
				case 'status':
					$orderby = ' ORDER BY p.post_status ' . $order ;
					break ;
				case 'created':
					$orderby = ' ORDER BY p.post_date ' . $order ;
					break ;
				case 'modified':
					$orderby = ' ORDER BY p.post_modified ' . $order ;
					break ;
			}
			return $orderby ;
		}

		/**
		 * Custom Search
		 * */
		public function custom_search( $where ) {
			if ( isset( $_REQUEST[ 's' ] ) ) { // @codingStandardsIgnoreLine.
				$rule_ids = array() ;
				$terms    = explode( ' , ' , wc_clean( wp_unslash( $_REQUEST[ 's' ] ) ) ) ; // @codingStandardsIgnoreLine.

				foreach ( $terms as $term ) {
					$term       = $this->database->esc_like( ( $term ) ) ;
					$post_query = new FGF_Query( $this->database->prefix . 'posts' , 'p' ) ;
					$post_query->select( 'DISTINCT `p`.ID' )
							->leftJoin( $this->database->prefix . 'postmeta' , 'pm' , '`p`.`ID` = `pm`.`post_id`' )
							->where( '`p`.post_type' , FGF_Register_Post_Types::RULES_POSTTYPE )
							->whereIn( '`p`.post_status' , fgf_get_rule_statuses() )
							->whereLike( '`p`.post_title' , '%' . $term . '%' ) ;

					$rule_ids = $post_query->fetchCol( 'ID' ) ;
				}

				$rule_ids = fgf_check_is_array( $rule_ids ) ? $rule_ids : array( 0 ) ;
				$where    .= ' AND (id IN (' . implode( ' , ' , $rule_ids ) . '))' ;
			}

			return $where ;
		}

	}

}
