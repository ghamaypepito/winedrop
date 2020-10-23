<?php
/**
 *  Master Log Post Table
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' ) ;
}

if ( ! class_exists( 'FGF_Master_Log_List_Table' ) ) {

	/**
	 * FGF_Master_Log_List_Table Class.
	 * */
	class FGF_Master_Log_List_Table extends WP_List_Table {

		/**
		 * Total Count of Table
		 * */
		private $total_items ;

		/**
		 * Per page count
		 * */
		private $perpage ;

		/**
		 * Offset
		 * */
		private $offset ;

		/**
		 * Database
		 * */
		private $database ;

		/**
		 * Order BY
		 * */
		private $orderby = 'ORDER BY ID DESC' ;

		/**
		 * Post type
		 * */
		private $post_type = FGF_Register_Post_Types::MASTER_LOG_POSTTYPE ;

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
			$this->base_url = fgf_get_master_log_page_url() ;

			add_filter( sanitize_key( $this->table_slug . '_query_where' ) , array( $this , 'custom_search' ) , 10 , 1 ) ;
			add_filter( sanitize_key( $this->table_slug . '_query_orderby' ) , array( $this , 'query_orderby' ) ) ;

			$this->prepare_current_url() ;
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
				'order_id'     => esc_html__( 'Order Id' , 'free-gifts-for-woocommerce' ) ,
				'user_details' => esc_html__( 'User Details' , 'free-gifts-for-woocommerce' ) ,
				'status'       => esc_html__( 'Status' , 'free-gifts-for-woocommerce' ) ,
				'date'         => esc_html__( 'Created Date' , 'free-gifts-for-woocommerce' ) ,
				'actions'      => esc_html__( 'Preview' , 'free-gifts-for-woocommerce' ) ,
					) ;

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
				'order_id'     => array( 'order_id' , false ) ,
				'user_details' => array( 'user_details' , false ) ,
				'status'       => array( 'status' , false ) ,
				'date'         => array( 'date' , false ) ,
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
		 * Display the list of views available on this table.
		 * */
		public function get_views() {
			$args        = array() ;
			$status_link = array() ;

			$status_link_array = array(
				'all'           => esc_html__( 'All' , 'free-gifts-for-woocommerce' ) ,
				'fgf_automatic' => esc_html__( 'Automatic' , 'free-gifts-for-woocommerce' ) ,
				'fgf_manual'    => esc_html__( 'Manual' , 'free-gifts-for-woocommerce' ) ,
					) ;

			foreach ( $status_link_array as $status_name => $status_label ) {
				$status_count = $this->get_total_item_for_status( $status_name ) ;

				if ( ! $status_count ) {
					continue ;
				}

				$args[ 'status' ] = $status_name ;
				$label            = $status_label . ' (' . $status_count . ')' ;

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
		 * Prepare each column data
		 * */
		protected function column_default( $item, $column_name ) {

			switch ( $column_name ) {
				case 'order_id':
					return '<a href="' . esc_url(
									add_query_arg(
											array(
								'post'   => $item->get_order_id() ,
								'action' => 'edit' ,
											) , admin_url( 'post.php' )
									)
							) . '" >#' . $item->get_order_id() . '</a>' ;
					break ;
				case 'user_details':
					return $item->get_user_name() . ' (' . $item->get_user_email() . ')' ;
					break ;
				case 'status':
					return fgf_display_status( $item->get_status() ) ;
					break ;
				case 'date':
					return $item->get_formatted_created_date() ;
					break ;
				case 'actions':
					return $this->view_more( $item->get_id() ) ;
					break ;
			}
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

			$count_items       = $this->database->get_results( 'SELECT DISTINCT ID FROM ' . $this->database->posts . " AS p {$where} {$orderby}" ) ;
			$this->total_items = count( $count_items ) ;

			$items = $this->database->get_results( $this->database->prepare( 'SELECT DISTINCT ID FROM ' . $this->database->posts . " AS p {$where} {$orderby} LIMIT %d,%d" , $offset , $limit ) , ARRAY_A ) ;

			$this->prepare_item_object( $items ) ;
		}

		/**
		 * Prepare item Object
		 * */
		private function prepare_item_object( $items ) {
			$prepare_items = array() ;
			if ( fgf_check_is_array( $items ) ) {
				foreach ( $items as $item ) {
					$prepare_items[] = fgf_get_master_log( $item[ 'ID' ] ) ;
				}
			}

			$this->items = $prepare_items ;
		}

		/**
		 * View more
		 * */
		private function view_more( $log_id ) {
			?>
			<a href="#" class="button fgf_master_log_info" data-fgf_master_log_id="<?php echo esc_attr( $log_id ) ; ?>" title="<?php esc_html_e( 'Preview' , 'free-gifts-for-woocommerce' ) ; ?>">
				<img src="<?php echo esc_url( FGF_PLUGIN_URL . '/assets/images/view.png' ) ; ?>">
			</a>
			<?php
		}

		/**
		 * Get total item from status
		 * */
		private function get_total_item_for_status( $status = '' ) {

			$status = ( 'all' == $status ) ? "NOT IN('trash')" : "IN('" . $status . "')" ;

			$data = $this->database->get_results( $this->database->prepare( 'SELECT ID FROM ' . $this->database->posts . " WHERE post_type=%s and post_status $status" , $this->post_type ) , ARRAY_A ) ;

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

			switch ( wc_clean( wp_unslash( ( $_REQUEST[ 'orderby' ] ) ) ) ) { // @codingStandardsIgnoreLine.
				case 'order_id':
					$orderby = " AND pm.meta_key='fgf_order_id' ORDER BY pm.meta_value " . $order ;
					break ;
				case 'user_details':
					$orderby = " AND pm.meta_key='fgf_user_name' ORDER BY pm.meta_value  " . $order ;
					break ;
				case 'status':
					$orderby = ' ORDER BY p.post_status ' . $order ;
					break ;
				case 'date':
					$orderby = ' ORDER BY p.post_date ' . $order ;
					break ;
			}

			return $orderby ;
		}

		/**
		 * Custom Search
		 * */
		public function custom_search( $where ) {

			if ( isset( $_REQUEST[ 's' ] ) ) {

				$master_log_ids = array() ;
				$terms          = explode( ',' , wc_clean( wp_unslash( $_REQUEST[ 's' ] ) ) ) ; // @codingStandardsIgnoreLine.

				foreach ( $terms as $term ) {

					$term       = $this->database->esc_like( ( $term ) ) ;
					$post_query = new FGF_Query( $this->database->prefix . 'posts' , 'p' ) ;
					$post_query->select( 'DISTINCT `p`.ID' )
							->leftJoin( $this->database->prefix . 'postmeta' , 'pm' , '`p`.`ID` = `pm`.`post_id`' )
							->where( '`p`.post_type' , FGF_Register_Post_Types::MASTER_LOG_POSTTYPE )
							->whereIn( '`p`.post_status' , fgf_get_master_log_statuses() )
							->whereIn( '`pm`.meta_key' , array( 'fgf_user_name' , 'fgf_user_email' , 'fgf_order_id' ) )
							->whereLike( '`pm`.meta_value' , '%' . $term . '%' ) ;

					$master_log_ids = $post_query->fetchCol( 'ID' ) ;
				}
				$master_log_ids = fgf_check_is_array( $master_log_ids ) ? $master_log_ids : array( 0 ) ;
				$where          .= ' AND (id IN (' . implode( ',' , $master_log_ids ) . '))' ;
			}

			return $where ;
		}

	}

}
