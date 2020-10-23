<?php

/**
 * Rule Handler
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}
if ( ! class_exists( 'FGF_Rule_Handler' ) ) {

	/**
	 * Class
	 */
	class FGF_Rule_Handler {

		/**
		 * Gift Products.
		 * 
		 * @var array
		 * */
		protected static $gift_products ;

		/**
		 * Manual Gift Products.
		 * 
		 * @var array
		 * */
		protected static $manual_gift_products ;

		/**
		 * Automatic Gift Products.
		 * 
		 * @var array
		 */
		protected static $automatic_gift_products ;

		/**
		 * BOGO Gift Products.
		 * 
		 * @var array
		 */
		protected static $bogo_gift_products ;

		/**
		 * Cart Notices.
		 * 
		 * @var array
		 */
		protected static $cart_notices ;

		/**
		 * Rule IDs.
		 * */
		protected static $rule_ids ;

		/**
		 * Rule.
		 * */
		protected static $rule ;

		/**
		 * Active Rule IDs.
		 * 
		 * @var array
		 * */
		protected static $active_rule_ids ;

		/**
		 * Manual Rule Products.
		 * 
		 * @var array
		 */
		protected static $manual_rule_products ;

		/**
		 * Automatic Rule Products.
		 * 
		 * @var array
		 */
		protected static $automatic_rule_products ;

		/**
		 * BOGO Rule Products.
		 * 
		 * @var array
		 */
		protected static $bogo_rule_products ;

		/**
		 * Manual Gift Products In cart
		 * 
		 * @var array
		 */
		protected static $manual_gift_products_in_cart ;

		/**
		 * Automatic Gift Products In cart
		 * 
		 * @var array
		 */
		protected static $automatic_gift_products_in_cart ;

		/**
		 * Date filter.
		 * 
		 * @var bool
		 * */
		protected static $date_filter ;

		/**
		 * Criteria filter.
		 * 
		 * @var bool
		 * */
		protected static $criteria_filter ;

		/**
		 * Product filter.
		 * 
		 * @var bool
		 * */
		protected static $product_filter ;

		/**
		 * User filter.
		 * 
		 * @var bool
		 * */
		protected static $user_filter ;

		/**
		 * Prepare matched rule gift products.
		 */
		public static function prepare_matched_rule_gift_products() {
			$matched_rules = self::matched_rules() ;

			self::$manual_gift_products    = $matched_rules[ 'manual' ] ;
			self::$automatic_gift_products = $matched_rules[ 'automatic' ] ;
			self::$bogo_gift_products      = $matched_rules[ 'bogo' ] ;
			self::$cart_notices            = $matched_rules[ 'notices' ] ;
		}

		/**
		 * Get manual gift products
		 */
		public static function get_manual_gift_products() {

			if ( isset( self::$manual_gift_products ) ) {
				return self::$manual_gift_products ;
			}

			self::prepare_matched_rule_gift_products() ;

			return self::$manual_gift_products ;
		}

		/**
		 * Get automatic gift products.
		 */
		public static function get_automatic_gift_products() {

			if ( isset( self::$automatic_gift_products ) ) {
				return self::$automatic_gift_products ;
			}

			self::prepare_matched_rule_gift_products() ;

			return self::$automatic_gift_products ;
		}

		/**
		 * Get BOGO gift products.
		 */
		public static function get_bogo_gift_products() {

			if ( isset( self::$bogo_gift_products ) ) {
				return self::$bogo_gift_products ;
			}

			self::prepare_matched_rule_gift_products() ;

			return self::$bogo_gift_products ;
		}

		/**
		 * Get the cart notices.
		 */
		public static function get_cart_notices() {

			if ( isset( self::$cart_notices ) ) {
				return self::$cart_notices ;
			}

			self::prepare_matched_rule_gift_products() ;

			return self::$cart_notices ;
		}

		/**
		 * Get Manual Rule Products.
		 */
		public static function get_manual_rule_products() {

			if ( isset( self::$manual_rule_products ) ) {
				return self::$manual_rule_products ;
			}

			self::prepare_matched_rule_gift_products() ;

			return self::$manual_rule_products ;
		}

		/**
		 * Get Automatic Rule Products.
		 */
		public static function get_automatic_rule_products() {

			if ( isset( self::$automatic_rule_products ) ) {
				return self::$automatic_rule_products ;
			}

			self::prepare_matched_rule_gift_products() ;

			return self::$automatic_rule_products ;
		}

		/**
		 * Get BOGO Rule Products.
		 */
		public static function get_bogo_rule_products() {

			if ( isset( self::$bogo_rule_products ) ) {
				return self::$bogo_rule_products ;
			}

			self::prepare_matched_rule_gift_products() ;

			return self::$bogo_rule_products ;
		}

		/**
		 * Get Gift Products In cart.
		 */
		public static function get_manual_gift_products_in_cart() {

			if ( isset( self::$manual_gift_products_in_cart ) ) {
				return self::$manual_gift_products_in_cart ;
			}

			self::$manual_gift_products_in_cart = fgf_get_free_gift_products_in_cart() ;

			return self::$manual_gift_products_in_cart ;
		}

		/**
		 * Get automatic Gift Products In cart.
		 */
		public static function get_automatic_gift_products_in_cart() {

			if ( isset( self::$automatic_gift_products_in_cart ) ) {
				return self::$automatic_gift_products_in_cart ;
			}

			self::$automatic_gift_products_in_cart = fgf_get_free_gift_products_in_cart( false , true ) ;

			return self::$automatic_gift_products_in_cart ;
		}

		/**
		 * May be Gift Product in cart.
		 */
		public static function maybe_gift_product_in_cart( $product_id, $type, $rule_id ) {

			$gift_products_in_cart = ( '2' == $type ) ? self::get_automatic_gift_products_in_cart() : self::get_manual_gift_products_in_cart() ;

			if ( ! fgf_check_is_array( $gift_products_in_cart ) ) {
				return false ;
			}

			// Return if the product is not exists.
			if ( ! array_key_exists( $product_id , $gift_products_in_cart ) ) {
				return false ;
			}

			// Check if the rule is empty.
			if ( ! fgf_check_is_array( $gift_products_in_cart[ $product_id ] ) ) {
				return false ;
			}

			// Check if a rule is exists.
			if ( ! array_key_exists( $rule_id , $gift_products_in_cart[ $product_id ] ) ) {
				return false ;
			}

			return $gift_products_in_cart[ $product_id ][ $rule_id ] ;
		}

		/**
		 * Check Rule Product exists
		 */
		public static function rule_product_exists( $rule_id, $product_id, $automatic = false ) {

			$rule_products = ( $automatic ) ? self::get_automatic_rule_products() : self::get_manual_rule_products() ;

			if ( ! fgf_check_is_array( $rule_products ) ) {
				return false ;
			}

			if ( ! isset( $rule_products[ $rule_id ] ) ) {
				return false ;
			}

			if ( ! array_key_exists( $product_id , $rule_products[ $rule_id ] ) ) {
				return false ;
			}

			return $rule_products[ $rule_id ][ $product_id ][ 'qty' ] ;
		}

		/**
		 * Get BOGO Rule Product qty.
		 */
		public static function get_bogo_rule_product_qty( $gift_product ) {

			$rule_products = self::get_bogo_rule_products() ;

			if ( ! fgf_check_is_array( $rule_products ) ) {
				return false ;
			}

			if ( ! isset( $rule_products[ $gift_product[ 'rule_id' ] ] ) ) {
				return false ;
			}

			if ( ! isset( $rule_products[ $gift_product[ 'rule_id' ] ][ $gift_product[ 'buy_product_id' ] ] ) ) {
				return false ;
			}

			if ( ! in_array( $gift_product[ 'product_id' ] , $rule_products[ $gift_product[ 'rule_id' ] ][ $gift_product[ 'buy_product_id' ] ][ 'get_product_ids' ] ) ) {
				return false ;
			}

			return $rule_products[ $gift_product[ 'rule_id' ] ][ $gift_product[ 'buy_product_id' ] ][ 'qty' ] ;
		}

		/**
		 * Matched Rules
		 */
		public static function matched_rules() {
			$matched_rules = array( 'manual' => array() , 'automatic' => array() , 'bogo' => array() , 'notices' => array() ) ;
			// Restriction based on coupon applied in cart.
			if ( get_option( 'fgf_settings_gift_restriction_based_coupon' ) == 'yes' && ! empty( WC()->cart->get_applied_coupons() ) ) {
				return $matched_rules ;
			}

			$rule_ids = self::get_active_rule_ids() ;
			if ( ! fgf_check_is_array( $rule_ids ) ) {
				return $matched_rules ;
			}

			$manual_rule_products       = array() ;
			$manual_overall_products    = array() ;
			$automatic_rule_products    = array() ;
			$bogo_rule_products         = array() ;
			$automatic_overall_products = array() ;

			foreach ( $rule_ids as $rule_id ) {

				// Set the default filter. 
				self::set_default_filter() ;

				self::$rule = fgf_get_rule( $rule_id ) ;

				if ( self::is_valid_rule() ) {

					switch ( self::$rule->get_rule_type() ) {
						case '3':
							//BOGO rule matched products.
							$each_bogo_products = self::bogo_rule_products() ;

							$bogo_rule_products[ $rule_id ] = $each_bogo_products[ 'overall_rule_products' ] ;

							// Matched BOGO rule.
							$matched_rules[ 'bogo' ] = array_merge( $matched_rules[ 'bogo' ] , $each_bogo_products[ 'each_rule_products' ] ) ;

							break ;
						case '2':
							// Each all rule products.
							$products = self::get_products() ;

							// Each automatic rule matched products.
							$each_rule_automatic_products = self::rule_products( $products , $automatic_overall_products ) ;

							// All automatic rule products.
							$automatic_overall_products = array_merge( $automatic_overall_products , $products ) ;

							// All automatic each rule products.
							$automatic_rule_products[ $rule_id ] = $each_rule_automatic_products[ 'overall_rule_products' ] ;

							// If rule per order exists.
							if ( ! self::validate_rule_per_order_count() ) {
								break ;
							}

							// Matched automatic rule.
							$matched_rules[ 'automatic' ] = array_merge( $matched_rules[ 'automatic' ] , $each_rule_automatic_products[ 'each_rule_products' ] ) ;

							break ;

						default:
							// Each all rule products.
							$products = self::get_products() ;

							// Each rule matched products.
							$each_rule_manaul_products = self::rule_products( $products , $manual_overall_products ) ;

							// All manual rule products.
							$manual_overall_products = array_merge( $manual_overall_products , $products ) ;

							// All each rule products.
							$manual_rule_products[ $rule_id ] = $each_rule_manaul_products[ 'overall_rule_products' ] ;

							// If rule per order exists.
							if ( ! self::validate_rule_per_order_count() ) {
								break ;
							}

							// matched rule
							$matched_rules[ 'manual' ] = array_merge( $matched_rules[ 'manual' ] , $each_rule_manaul_products[ 'each_rule_products' ] ) ;

							break ;
					}
				} elseif ( self::is_valid_notice_rule() ) {
					// Prepare the eligible notices.
					$matched_rules[ 'notices' ][ $rule_id ] = self::get_rule_notice() ;
				}
			}

			self::$manual_rule_products    = $manual_rule_products ;
			self::$automatic_rule_products = $automatic_rule_products ;
			self::$bogo_rule_products      = $bogo_rule_products ;

			return $matched_rules ;
		}

		/**
		 * Get active rule IDs
		 */
		public static function get_active_rule_ids() {

			if ( self::$active_rule_ids ) {
				return self::$active_rule_ids ;
			}

			self::$active_rule_ids = fgf_get_active_rule_ids() ;

			return self::$active_rule_ids ;
		}

		/**
		 * Get rule IDs
		 */
		public static function get_rule_ids() {

			if ( self::$rule_ids ) {
				return self::$rule_ids ;
			}

			self::$rule_ids = fgf_get_rule_ids() ;

			return self::$rule_ids ;
		}

		/**
		 * Get gift products.
		 */
		public static function get_gift_products() {

			if ( self::$gift_products ) {
				return self::$gift_products ;
			}

			$products = array() ;

			$rule_ids = self::get_rule_ids() ;
			if ( fgf_check_is_array( $rule_ids ) ) {
				foreach ( $rule_ids as $rule_id ) {

					self::$rule = fgf_get_rule( $rule_id ) ;

					// Each all rule products.
					$products = array_merge( $products , self::get_products( true ) ) ;
				}
			}

			// reset the rule.
			self::$rule = null ;

			self::$gift_products = array_filter( array_unique( $products ) ) ;

			return self::$gift_products ;
		}

		/**
		 * Get Rule Products
		 */
		public static function rule_products( $products, $overall_products ) {
			$rule_products            = array( 'each_rule_products' => array() , 'overall_rule_products' => array() ) ;
			$gifts_selection_per_user = get_option( 'fgf_settings_gifts_selection_per_user' ) ;
			$usage_count_exists       = self::validate_rule_usage_count() ;

			// Return if rule usage count exists.
			if ( ! $usage_count_exists ) {
				return $rule_products ;
			}

			foreach ( $products as $product_id ) {
				// If the product is already exists.
				// If the rule type is 1.  
				if ( in_array( $product_id , $overall_products ) && '2' != self::$rule->get_rule_type() ) {
					continue ;
				}

				$hide_add_to_cart = true ;
				// Get each gift product quantity.
				$rule_quantity    = self::get_rule_quantity() ;
				// Get gift product quantity from the cart.
				$cart_qty         = ( float ) self::maybe_gift_product_in_cart( $product_id , self::$rule->get_rule_type() , self::$rule->get_id() ) ;

				$current_rule_quantity = $rule_quantity ;

				// Get the gift product quantity from the cart.
				if ( $cart_qty < $current_rule_quantity ) {
					$current_rule_quantity = $current_rule_quantity - $cart_qty ;
					$hide_add_to_cart      = false ;
				} elseif ( '1' == self::$rule->get_rule_type() && 'yes' == $gifts_selection_per_user && $cart_qty ) {
					$hide_add_to_cart = false ;
				}

				$qty = self::get_product_available_quantity( $current_rule_quantity , $product_id ) ;

				// Hide product if the product is out of stock.
				if ( ! $qty ) {
					$hide_add_to_cart = true ;
				}

				if ( $qty || '1' != self::$rule->get_rule_type() ) {
					$rule_products[ 'each_rule_products' ][] = array(
						'product_id'       => $product_id ,
						'rule_id'          => self::$rule->get_id() ,
						'qty'              => $qty ,
						'hide_add_to_cart' => $hide_add_to_cart ,
							) ;
				}


				$rule_products[ 'overall_rule_products' ][ $product_id ] = array(
					'product_id' => $product_id ,
					'rule_id'    => self::$rule->get_id() ,
					'qty'        => $rule_quantity ,
						) ;
			}

			return $rule_products ;
		}

		/**
		 * Get Rule Products
		 */
		public static function get_products( $include_parent = false ) {
			$products = array() ;
			if ( '2' == self::$rule->get_gift_type() && '2' != self::$rule->get_rule_type() ) {
				foreach ( self::$rule->get_gift_categories() as $category_id ) {
					$product_ids          = array() ;
					$category_product_ids = fgf_get_product_id_by_category( $category_id ) ;

					foreach ( $category_product_ids as $product_id ) {
						$product = wc_get_product( $product_id ) ;

						//Variable
						if ( $product->is_type( 'variable' ) ) {
							$product_ids = array_merge( $product_ids , $product->get_children() ) ;
						} else {
							$product_ids[] = $product_id ;
						}
					}

					$products = array_merge( $products , $product_ids ) ;
				}
			} else {
				$selected_products = self::$rule->get_gift_products() ;

				if ( fgf_check_is_array( $selected_products ) ) {
					foreach ( $selected_products as $product_id ) {
						$product_object = wc_get_product( $product_id ) ;

						//Return if the Product does not exist. 
						if ( ! $product_object || ! $product_object->is_purchasable() ) {
							continue ;
						}

						$products[] = $product_id ;

						if ( $include_parent && ! empty( $product_object->get_parent_id() ) ) {
							$products[] = $product_object->get_parent_id() ;
						}
					}
				}
			}

			return $products ;
		}

		/**
		 * Get BOGO Rule Products
		 */
		public static function bogo_rule_products() {
			$rule_products      = array( 'each_rule_products' => array() , 'overall_rule_products' => array() ) ;
			$usage_count_exists = self::validate_rule_usage_count() ;

			// Return if rule usage count exists.
			if ( ! $usage_count_exists ) {
				return $rule_products ;
			}

			//Get Selected buy products.
			$selected_buy_products = self::get_selected_buy_product() ;
			//Get Selected get products.
			$selected_get_products = self::get_selected_get_product() ;

			foreach ( $selected_buy_products as $buy_product ) {

				$buy_product_qty = self::get_bogo_buy_product_quantity( $buy_product[ 'product_count' ] ) ;
				//Continue if quantity does not exist. 
				if ( ! $buy_product_qty ) {
					continue ;
				}

				// Buy product if BOGO gift type is the same product.
				if ( '1' == self::$rule->get_bogo_gift_type() ) {
					$selected_get_products = array( $buy_product[ 'product_id' ] ) ;
				}

				$get_product_ids = array() ;

				foreach ( $selected_get_products as $get_product_id ) {
					$hide_add_to_cart = true ;
					$quantity         = $buy_product_qty ;

					// Get product count in cart.
					$get_product_cart_count = fgf_get_bogo_products_count_in_cart( $buy_product[ 'product_id' ] , $get_product_id , self::$rule->get_id() ) ;

					// Check if the get product count less than rule quantity count, 
					// subtract rule quantity count from get product count, 
					// otherwise hide product.
					if ( $get_product_cart_count < $buy_product_qty ) {
						$quantity         = $buy_product_qty - $get_product_cart_count ;
						$hide_add_to_cart = false ;
					}

					// Check the get product having a stock.
					$quantity = self::get_product_available_quantity( $quantity , $get_product_id ) ;

					if ( ! $quantity ) {
						$hide_add_to_cart = true ;
					}

					$rule_products[ 'each_rule_products' ][] = array(
						'product_id'       => $get_product_id ,
						'rule_id'          => self::$rule->get_id() ,
						'buy_product_id'   => $buy_product[ 'product_id' ] ,
						'qty'              => $quantity ,
						'hide_add_to_cart' => $hide_add_to_cart ,
							) ;

					$get_product_ids[] = $get_product_id ;
				}

				// Prepare the overall BOGO rule products.
				$rule_products[ 'overall_rule_products' ][ $buy_product[ 'product_id' ] ] = array(
					'get_product_ids' => $get_product_ids ,
					'qty'             => $buy_product_qty
						) ;
			}

			return $rule_products ;
		}

		/**
		 * Get rule quantity.
		 * 
		 * @return float/int.
		 */
		public static function get_rule_quantity() {

			// Check if the rule type is automatic
			// Automatic product qty is not empty.
			// Return Automatic qty.
			if ( '2' == self::$rule->get_rule_type() && ! empty( self::$rule->get_automatic_product_qty() ) ) {
				return self::$rule->get_automatic_product_qty() ;
			}

			return 1 ;
		}

		/**
		 * Get product available quantity.
		 */
		public static function get_product_available_quantity( $quantity, $product_id ) {

			$product = wc_get_product( $product_id ) ;

			//Return if stock is out of stock.
			if ( ! $product->is_in_stock() ) {
				return 0 ;
			}

			// Return if managing stock is not enabled.
			if ( ! $product->managing_stock() ) {
				return $quantity ;
			}

			// Get product count in cart
			$cart_quantity = fgf_get_product_count_in_cart( $product_id ) ;
			if ( $product->get_stock_quantity() <= $cart_quantity ) {
				return 0 ;
			}

			$overall_quantity = $cart_quantity + $quantity ;
			if ( $product->get_stock_quantity() < $overall_quantity ) {
				$quantity = $product->get_stock_quantity() - $cart_quantity ;
			}

			return $quantity ;
		}

		/**
		 * Get selected buy product.
		 */
		public static function get_selected_buy_product() {
			$products = array() ;

			if ( '2' == self::$rule->get_buy_product_type() ) {
				foreach ( self::$rule->get_buy_categories() as $category_id ) {
					$product_ids          = array() ;
					$category_cart_count  = 0 ;
					$category_product_ids = fgf_get_product_id_by_category( $category_id ) ;

					foreach ( $category_product_ids as $product_id ) {
						$product = wc_get_product( $product_id ) ;

						//Variable
						if ( $product->is_type( 'variable' ) ) {

							foreach ( $product->get_children() as $variation_id ) {
								$product_cart_count  = self::is_valid_buy_product( $variation_id ) ;
								$category_cart_count += ( float ) $product_cart_count ;

								if ( $product_cart_count && ( '1' == self::$rule->get_bogo_gift_type() || '2' != self::$rule->get_buy_category_type() ) ) {
									$product_ids[] = array(
										'product_id'    => $variation_id ,
										'product_count' => $product_cart_count
											) ;
									;
								}
							}
						} else {

							$product_cart_count  = self::is_valid_buy_product( $product_id ) ;
							$category_cart_count += ( float ) $product_cart_count ;
							if ( $product_cart_count && ( '1' == self::$rule->get_bogo_gift_type() || '2' != self::$rule->get_buy_category_type() ) ) {
								$products[] = array(
									'product_id'    => $product_id ,
									'product_count' => $product_cart_count
										) ;
							}
						}
					}

					//Consider the overall category product qty count.
					if ( $category_cart_count && '2' == self::$rule->get_bogo_gift_type() && '2' == self::$rule->get_buy_category_type() ) {
						$products[] = array(
							'product_id'    => $product_id ,
							'product_count' => $category_cart_count
								) ;
					}

					$products = array_merge( $products , $product_ids ) ;
				}
			} else {

				$selected_products = self::$rule->get_buy_product() ;

				if ( fgf_check_is_array( $selected_products ) ) {
					foreach ( $selected_products as $product_id ) {
						$product_cart_count = self::is_valid_buy_product( $product_id ) ;
						//Return if the Product is not valid buy product. 
						if ( ! $product_cart_count ) {
							continue ;
						}

						$products[] = array(
							'product_id'    => $product_id ,
							'product_count' => $product_cart_count
								) ;
					}
				}
			}

			return $products ;
		}

		/**
		 * Is valid buy product?.
		 * 
		 * @return bool
		 */
		public static function is_valid_buy_product( $product_id ) {
			$product_object = wc_get_product( $product_id ) ;

			//Return if the Product does not exist. 
			if ( ! $product_object || ! $product_object->is_purchasable() ) {
				return false ;
			}

			$buy_product_count = fgf_get_buy_product_count_in_cart( $product_id ) ;
			if ( ! $buy_product_count ) {
				return false ;
			}

			return $buy_product_count ;
		}

		/**
		 * Get selected get product.
		 */
		public static function get_selected_get_product() {
			$products = array() ;

			//Return buy product if BOGO gift type is the same product.
			if ( '1' == self::$rule->get_bogo_gift_type() ) {
				return array() ;
			}

			$selected_products = self::$rule->get_products() ;

			if ( fgf_check_is_array( $selected_products ) ) {
				foreach ( $selected_products as $product_id ) {
					$product_object = wc_get_product( $product_id ) ;

					//Return if the Product does not exist. 
					if ( ! $product_object || ! $product_object->is_purchasable() ) {
						continue ;
					}

					$products[] = $product_id ;
				}
			}

			return $products ;
		}

		/**
		 * Get BOGO product quantity.
		 */
		public static function get_bogo_buy_product_quantity( $buy_product_count ) {
			$quantity = 0 ;

			if ( '2' == self::$rule->get_bogo_gift_repeat() ) {
				$quantity = intval( $buy_product_count / self::$rule->get_buy_product_count() ) * self::$rule->get_product_count() ;
			} elseif ( self::$rule->get_buy_product_count() <= $buy_product_count ) {
				$quantity = self::$rule->get_product_count() ;
			}

			// Return same quantity ,if the repeat mode is unlimited,
			// Repeat limit is empty.
			if ( '2' != self::$rule->get_bogo_gift_repeat_mode() || empty( self::$rule->get_bogo_gift_repeat_limit() ) ) {
				return $quantity ;
			}

			$quantity_limit = floatval( self::$rule->get_bogo_gift_repeat_limit() ) * floatval( self::$rule->get_product_count() ) ;

			if ( $quantity_limit >= $quantity ) {
				return $quantity ;
			}

			return $quantity_limit ;
		}

		/**
		 * Check if gift products exists per order count.
		 * */
		public static function check_per_order_count_exists() {
			$free_gifts_products_count = floatval( get_option( 'fgf_settings_gifts_count_per_order' ) ) ;

			// Restriction based on per order count exists
			if ( $free_gifts_products_count && fgf_get_free_gift_products_count_in_cart( true ) >= $free_gifts_products_count ) {
				return true ;
			}

			return false ;
		}

		/**
		 * Check if rule is valid to display.
		 */
		public static function is_valid_rule() {
			self::$date_filter = self::validate_date() ;
			if ( ! self::$date_filter ) {
				return false ;
			}

			self::$user_filter = self::validate_users() ;
			if ( ! self::$user_filter ) {
				return false ;
			}

			self::$product_filter = self::validate_product_category() ;
			if ( ! self::$product_filter ) {
				return false ;
			}

			self::$criteria_filter = self::validate_rule_criteria() ;
			if ( ! self::$criteria_filter ) {
				return false ;
			}

			return apply_filters( 'fgf_validate_gift_products_rule' , true ) ;
		}

		/**
		 * Validate rule usage count
		 */
		public static function validate_rule_usage_count() {

			// Return if restriction count is empty
			if ( ! floatval( self::$rule->get_rule_restriction_count() ) ) {
				return true ;
			}

			if ( floatval( self::$rule->get_rule_restriction_count() ) <= floatval( self::$rule->get_rule_usage_count() ) ) {
				return false ;
			}

			return true ;
		}

		/**
		 * Validate rule per order count
		 */
		public static function validate_rule_per_order_count() {

			// Return if per order count is empty
			if ( ! floatval( self::$rule->get_rule_gifts_count_per_order() ) ) {
				return true ;
			}

			if ( floatval( self::$rule->get_rule_gifts_count_per_order() ) <= floatval( fgf_get_rule_products_count_in_cart( self::$rule->get_id() ) ) ) {
				return false ;
			}

			return true ;
		}

		/**
		 * Validate date.
		 * 
		 * @return bool
		 */
		public static function validate_date() {
			if ( ! self::validate_from_to_date() ) {
				return false ;
			}

			if ( ! self::validate_weekdays() ) {
				return false ;
			}

			return apply_filters( 'fgf_validate_rule_date_filter' , true , self::$rule ) ;
		}

		/**
		 * Validate from/to date
		 */
		public static function validate_from_to_date() {
			$return       = false ;
			$from_date    = true ;
			$to_date      = true ;
			$current_date = current_time( 'timestamp' ) ;

			// Validate from date
			if ( self::$rule->get_rule_valid_from_date() ) {
				$from_date_object = FGF_Date_Time::get_tz_date_time_object( self::$rule->get_rule_valid_from_date() ) ;

				if ( $from_date_object->getTimestamp() > $current_date ) {
					$from_date = false ;
				}
			}
			// Validate to date
			if ( self::$rule->get_rule_valid_to_date() ) {
				$to_date_object = FGF_Date_Time::get_tz_date_time_object( self::$rule->get_rule_valid_to_date() ) ;
				$to_date_object->modify( '+1 days' ) ;

				if ( $to_date_object->getTimestamp() < $current_date ) {
					$to_date = false ;
				}
			}

			if ( $from_date && $to_date ) {
				$return = true ;
			}

			return apply_filters( 'fgf_validate_rule_from_to_date' , $return , self::$rule ) ;
		}

		/**
		 * Validate the weekdays restriction.
		 * 
		 * @return bool
		 */
		public static function validate_weekdays() {
			$return = false ;
			$today  = gmdate( 'N' , current_time( 'timestamp' ) ) ;

			if ( ! fgf_check_is_array( self::$rule->get_rule_week_days_validation() ) || in_array( $today , self::$rule->get_rule_week_days_validation() ) ) {
				$return = true ;
			}

			return apply_filters( 'fgf_validate_rule_week_days' , $return , self::$rule ) ;
		}

		/**
		 * Validate rule criteria
		 */
		public static function validate_rule_criteria() {

			$cart_subtotal_criteria      = self::validate_cart_total_criteria() ;
			$cart_quantity_criteria      = self::validate_cart_quantity_criteria() ;
			$cart_product_count_criteria = self::validate_product_count_criteria() ;

			if ( ( self::$rule->get_condition_type() == '2' ) && ( ! ( $cart_subtotal_criteria || $cart_quantity_criteria || $cart_product_count_criteria ) ) ) {
				return false ;
			} elseif ( ( self::$rule->get_condition_type() == '1' ) && ( ! ( $cart_subtotal_criteria && $cart_quantity_criteria && $cart_product_count_criteria ) ) ) {
				return false ;
			}

			return apply_filters( 'fgf_validate_rule_criteria' , true , self::$rule ) ;
		}

		/**
		 * Validate cart total criteria
		 */
		public static function validate_cart_total_criteria() {
			$minimum_cart_subtotal = true ;
			$maximum_cart_subtotal = true ;

			switch ( self::$rule->get_total_type() ) {
				case '2':
					$total = fgf_get_wc_cart_total() ;
					break ;
				case '3':
					$total = fgf_get_wc_cart_category_subtotal( self::$rule->get_cart_categories() ) ;
					break ;
				default:
					$total = fgf_get_wc_cart_subtotal() ;
					break ;
			}

			// Validate minimum cart subtotal
			if ( self::$rule->get_cart_subtotal_minimum_value() && self::$rule->get_cart_subtotal_minimum_value() > $total ) {
				$minimum_cart_subtotal = false ;
			}
			// Validate maximum cart subtotal
			if ( self::$rule->get_cart_subtotal_maximum_value() && self::$rule->get_cart_subtotal_maximum_value() < $total ) {
				$maximum_cart_subtotal = false ;
			}

			if ( $minimum_cart_subtotal && $maximum_cart_subtotal ) {
				return true ;
			}

			return false ;
		}

		/**
		 * Validate Cart Quantity criteria
		 */
		public static function validate_cart_quantity_criteria() {
			$minimum_cart_quantity = true ;
			$maximum_cart_quantity = true ;
			$cart_quantity         = WC()->cart->get_cart_contents_count() - fgf_get_free_gift_products_count_in_cart() ;

			// Validate minimum cart quantity
			if ( self::$rule->get_quantity_minimum_value() && self::$rule->get_quantity_minimum_value() > $cart_quantity ) {
				$minimum_cart_quantity = false ;
			}
			// Validate maximum cart quantity
			if ( self::$rule->get_quantity_maximum_value() && self::$rule->get_quantity_maximum_value() < $cart_quantity ) {
				$maximum_cart_quantity = false ;
			}

			if ( $minimum_cart_quantity && $maximum_cart_quantity ) {
				return true ;
			}

			return false ;
		}

		/**
		 * Validate Cart Product count criteria.
		 */
		public static function validate_product_count_criteria() {
			$minimum_cart_item = true ;
			$maximum_cart_item = true ;
			$cart_item_count   = fgf_get_cart_item_count() ;

			// Validate minimum cart quantity
			if ( self::$rule->get_product_count_min_value() && self::$rule->get_product_count_min_value() > $cart_item_count ) {
				$minimum_cart_item = false ;
			}
			// Validate maximum cart quantity
			if ( self::$rule->get_product_count_max_value() && self::$rule->get_product_count_max_value() < $cart_item_count ) {
				$maximum_cart_item = false ;
			}

			if ( $minimum_cart_item && $maximum_cart_item ) {
				return true ;
			}

			return false ;
		}

		/**
		 * Validate Users
		 */
		public static function validate_users() {

			switch ( self::$rule->get_user_filter_type() ) {

				case '2':
					$user_id = get_current_user_id() ;
					if ( in_array( $user_id , self::$rule->get_include_users() ) ) {
						return true ;
					}

					break ;
				case '3':
					$user_id = get_current_user_id() ;
					if ( in_array( $user_id , self::$rule->get_exclude_users() ) ) {
						return false ;
					}

					return true ;
					break ;
				case '4':
					$user = wp_get_current_user() ;

					// Loggedin user restriction
					if ( fgf_check_is_array( $user->roles ) ) {
						foreach ( $user->roles as $role ) {
							if ( in_array( $role , self::$rule->get_include_user_roles() ) ) {
								return true ;
							}
						}
					} else {
						// Guest user restriction
						if ( in_array( 'guest' , self::$rule->get_include_user_roles() ) ) {
							return true ;
						}
					}

					break ;
				case '5':
					$user = wp_get_current_user() ;

					// Loggedin user restriction
					if ( fgf_check_is_array( $user->roles ) ) {
						foreach ( $user->roles as $role ) {
							if ( in_array( $role , self::$rule->get_exclude_user_roles() ) ) {
								return false ;
							}
						}
					} else {
						// Guest user restriction
						if ( in_array( 'guest' , self::$rule->get_exclude_user_roles() ) ) {
							return false ;
						}
					}

					return true ;
					break ;
				default:
					return true ;
			}

			return false ;
		}

		/**
		 * Validate Products/Categories
		 */
		public static function validate_product_category() {
			// return if selected as all products
			if ( self::$rule->get_product_filter_type() == '1' ) {
				return true ;
			}

			// Return if cart object is not initialized.
			if ( ! is_object( WC()->cart ) ) {
				return true ;
			}

			$cart_contents = WC()->cart->get_cart() ;

			if ( ! fgf_check_is_array( $cart_contents ) ) {
				return true ;
			}

			$return       = false ;
			$product_ids  = array() ;
			$category_ids = array() ;
			foreach ( $cart_contents as $cart_content ) {

				if ( isset( $cart_content[ 'fgf_gift_product' ] ) ) {
					continue ;
				}

				switch ( self::$rule->get_product_filter_type() ) {
					case '2':
						// return if any selected products in the cart
						if ( in_array( $cart_content[ 'product_id' ] , self::$rule->get_include_products() ) ) {
							if ( '1' == self::$rule->get_applicable_products_type() ) {
								return true ;
							}

							$product_ids[] = $cart_content[ 'product_id' ] ;
						} elseif ( in_array( $cart_content[ 'variation_id' ] , self::$rule->get_include_products() ) ) {
							if ( '1' == self::$rule->get_applicable_products_type() ) {
								return true ;
							}

							$product_ids[] = $cart_content[ 'variation_id' ] ;
						} else {
							$product_ids[] = $cart_content[ 'product_id' ] ;
						}

						break ;
					case '3':
						$return = true ;
						// excluded products.
						if ( in_array( $cart_content[ 'product_id' ] , self::$rule->get_exclude_products() ) || in_array( $cart_content[ 'variation_id' ] , self::$rule->get_exclude_products() ) ) {
							return false ;
						}
						break ;
					case '4':
						// All Categories.
						$product_categories = get_the_terms( $cart_content[ 'product_id' ] , 'product_cat' ) ;
						if ( fgf_check_is_array( $product_categories ) ) {
							return true ;
						}
						break ;
					case '5':
						//included categories.
						$product_categories = get_the_terms( $cart_content[ 'product_id' ] , 'product_cat' ) ;

						if ( fgf_check_is_array( $product_categories ) ) {
							foreach ( $product_categories as $product_category ) {
								$category_ids[] = $product_category->term_id ;
								// return if any selected categories products in the cart.
								if ( '1' == self::$rule->get_applicable_categories_type() && in_array( $product_category->term_id , self::$rule->get_include_categories() ) ) {
									return true ;
								}
							}
						}
						break ;
					case '6':
						// excluded categories.
						$return             = true ;
						$product_categories = get_the_terms( $cart_content[ 'product_id' ] , 'product_cat' ) ;
						if ( fgf_check_is_array( $product_categories ) ) {
							foreach ( $product_categories as $product_category ) {
								if ( in_array( $product_category->term_id , self::$rule->get_exclude_categories() ) ) {
									return false ;
								}
							}
						}
				}
			}

			//For include products filter.
			if ( '2' == self::$rule->get_product_filter_type() ) {
				if ( '4' == self::$rule->get_applicable_products_type() ) {
					$return = self::validate_applicable_product_count( self::$rule->get_include_product_count() , self::$rule->get_include_products() , $product_ids ) ;
				} else {
					$return = self::validate_applicable_product_category( self::$rule->get_applicable_products_type() , self::$rule->get_include_products() , $product_ids ) ;
				}
			} elseif ( '5' == self::$rule->get_product_filter_type() ) {
				//For include categories filter.
				$return = self::validate_applicable_product_category( self::$rule->get_applicable_categories_type() , self::$rule->get_include_categories() , $category_ids ) ;
			}

			return $return ;
		}

		/**
		 * Validate the applicable products or categories in the cart.
		 *
		 * @param string $applicable_type
		 * @param array $selected_data
		 * @param array $current_data
		 * @return boolean
		 */
		public static function validate_applicable_product_category( $applicable_type, $selected_data, $current_data ) {

			if ( '2' == $applicable_type ) {
				// return if all the selected products/categories in the cart.
				if ( empty( array_diff( $selected_data , $current_data ) ) ) {
					return true ;
				}
			} elseif ( '3' == $applicable_type ) {
				// return if only the selected products/categories in the cart.
				if ( empty( array_diff( $current_data , $selected_data ) ) && empty( array_diff( $selected_data , $current_data ) ) ) {
					return true ;
				}
			}

			return false ;
		}

		/**
		 * Validate the applicable product count in the cart.
		 *
		 * @param string $product_count
		 * @param array $include_product_ids
		 * @param array $cart_product_ids
		 * @return boolean
		 */
		public static function validate_applicable_product_count( $product_count, $include_product_ids, $cart_product_ids ) {

			return count( array_intersect( $cart_product_ids , $include_product_ids ) ) == $product_count ;
		}

		/**
		 * Check if the rule is valid to display notice.
		 */
		public static function is_valid_notice_rule() {
			if ( ! self::$date_filter || ! self::$user_filter || ! self::$product_filter ) {
				return false ;
			}

			if ( '2' != self::$rule->get_show_notice() ) {
				return false ;
			}

			if ( empty( self::$rule->get_notice() ) ) {
				return false ;
			}

			return apply_filters( 'fgf_validate_gift_products_notice_rule' , true ) ;
		}

		/**
		 * Get the rule notice.
		 */
		public static function get_rule_notice() {

			$cart_total    = self::get_rule_notice_total() ;
			$order_total   = self::get_rule_notice_total( true ) ;
			$cart_qty      = self::get_rule_notice_cart_quantity() ;
			$product_count = self::get_rule_notice_product_count() ;

			$shortcode_array = array( '[free_gift_min_sub_total]' , '[free_gift_min_order_total]' , '[free_gift_min_cart_qty]' , '[free_gift_min_product_count]' ) ;
			$replace_array   = array( fgf_price( $cart_total , false ) , fgf_price( $order_total , false ) , $cart_qty , $product_count ) ;

			$notice = fgf_get_rule_translated_string( 'fgf_rule_notice_' . self::$rule->get_id() , self::$rule->get_notice() ) ;

			return wpautop( wptexturize( str_replace( $shortcode_array , $replace_array , $notice ) ) ) ;
		}

		/**
		 * Get the Rule Notice total.
		 */
		public static function get_rule_notice_total( $order_total = false ) {

			if ( ( ! $order_total && '2' == self::$rule->get_total_type() ) || ( $order_total && '1' == self::$rule->get_total_type() ) ) {
				return 0 ;
			}

			$total = ( '2' == self::$rule->get_total_type() ) ? fgf_get_wc_cart_total() : fgf_get_wc_cart_subtotal() ;

			// Validate minimum cart subtotal
			if ( ! self::$rule->get_cart_subtotal_minimum_value() || self::$rule->get_cart_subtotal_minimum_value() <= $total ) {
				return 0 ;
			}

			return self::$rule->get_cart_subtotal_minimum_value() - $total ;
		}

		/**
		 * Get the Rule Notice Cart Quantity.
		 */
		public static function get_rule_notice_cart_quantity() {
			$cart_quantity = WC()->cart->get_cart_contents_count() - fgf_get_free_gift_products_count_in_cart() ;

			// Validate minimum cart quantity
			if ( ! self::$rule->get_quantity_minimum_value() || self::$rule->get_quantity_minimum_value() <= $cart_quantity ) {
				return 0 ;
			}

			return self::$rule->get_quantity_minimum_value() - $cart_quantity ;
		}

		/**
		 * Get the Rule Notice Product count.
		 */
		public static function get_rule_notice_product_count() {
			$cart_item_count = fgf_get_cart_item_count() ;

			// Validate minimum cart quantity
			if ( ! self::$rule->get_product_count_min_value() || self::$rule->get_product_count_min_value() <= $cart_item_count ) {
				return 0 ;
			}

			return self::$rule->get_product_count_min_value() - $cart_item_count ;
		}

		/**
		 * Reset
		 */
		public static function reset() {
			self::$gift_products                = null ;
			self::$manaul_gift_products         = null ;
			self::$automatic_gift_products      = null ;
			self::$bogo_gift_products           = null ;
			self::$active_rule_ids              = null ;
			self::$manual_gift_products_in_cart = null ;
			self::$manual_rule_products         = null ;
			self::$automatic_rule_products      = null ;
			self::$bogo_rule_products           = null ;
		}

		/**
		 * Set the default filter.
		 */
		public static function set_default_filter() {
			self::$rule            = false ;
			self::$date_filter     = false ;
			self::$criteria_filter = false ;
			self::$user_filter     = false ;
			self::$product_filter  = false ;
		}

	}

}
