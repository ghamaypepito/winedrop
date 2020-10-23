/* global fgf_rule_params, ajaxurl */

jQuery( function ( $ ) {
	'use strict' ;

	var FGF_Admin = {
		init : function ( ) {
			this.trigger_on_page_load() ;
			// rules tab
			$( document ).on( 'change' , '.fgf_rule_types' , this.toggle_rule_type ) ;
			$( document ).on( 'change' , '.fgf_gift_type' , this.toggle_gift_type ) ;
			$( document ).on( 'change' , '.fgf_bogo_gift_type' , this.toggle_bogo_gift_type ) ;
			$( document ).on( 'change' , '.fgf_buy_product_type' , this.toggle_buy_product_type ) ;
			$( document ).on( 'change' , '.fgf_bogo_gift_repeat' , this.toggle_bogo_gift_repeat ) ;
			$( document ).on( 'change' , '.fgf_bogo_gift_repeat_mode' , this.toggle_bogo_gift_repeat_mode ) ;
			$( document ).on( 'change' , '.fgf_rule_show_notice' , this.toggle_notice ) ;
			$( document ).on( 'change' , '.fgf_user_filter_type' , this.toggle_user_filter_type ) ;
			$( document ).on( 'change' , '.fgf_product_filter_type' , this.toggle_product_filter_type ) ;
			$( document ).on( 'change' , '.fgf_applicable_products_type' , this.toggle_applicable_products_type ) ;
			$( document ).on( 'click' , '.fgf_reset_rule_usage_count' , this.reset_rule_usage_count ) ;
			$( document ).on( 'change' , '.fgf-rule-total-type' , this.toggle_rule_total_type ) ;

			//Tabbed rule panel.
			$( document ).on( 'fgf-init-tabbed-panels' , this.tabbed_rule_panels ).trigger( 'fgf-init-tabbed-panels' ) ;

		} , trigger_on_page_load : function ( ) {
			// rules tab
			this.rule_type( '.fgf_rule_types' ) ;
			this.notice( '.fgf_rule_show_notice' ) ;
			this.user_filter_type( '.fgf_user_filter_type' ) ;
			this.product_filter_type( '.fgf_product_filter_type' ) ;
			this.rule_total_type( '.fgf-rule-total-type' ) ;
			this.sortable_default_fields() ;

		} , toggle_rule_type : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.rule_type( $this ) ;
		} , toggle_gift_type : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.gift_type( $this ) ;
		} , toggle_bogo_gift_type : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.bogo_gift_type( $this ) ;
		} , toggle_buy_product_type : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.buy_product_type( $this ) ;
		} , toggle_bogo_gift_repeat : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;

			FGF_Admin.bogo_gift_repeat( $this ) ;
		} , toggle_bogo_gift_repeat_mode : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;

			FGF_Admin.bogo_gift_repeat_mode( $this ) ;
		} , toggle_notice : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;

			FGF_Admin.notice( $this ) ;
		} , toggle_user_filter_type : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.user_filter_type( $this ) ;
		} , toggle_product_filter_type : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.product_filter_type( $this ) ;
		} , toggle_applicable_products_type : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.applicable_products_type( $this ) ;
		} , toggle_rule_total_type : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;

			FGF_Admin.rule_total_type( $this ) ;
		} , rule_type : function ( $this ) {

			if ( $( $this ).val() === '1' ) {
				$( '.fgf_rule_type' ).closest( 'tr' ).hide() ;
				$( '.fgf_manual_rule_type' ).closest( 'tr' ).show() ;
				FGF_Admin.gift_type( '.fgf_gift_type' ) ;
			} else if ( $( $this ).val() === '3' ) {
				$( '.fgf_rule_type' ).closest( 'tr' ).hide() ;
				$( '.fgf_bogo_rule_type' ).closest( 'tr' ).show() ;
				FGF_Admin.buy_product_type( '.fgf_buy_product_type' ) ;
				FGF_Admin.bogo_gift_type( '.fgf_bogo_gift_type' ) ;
				FGF_Admin.bogo_gift_repeat( '.fgf_bogo_gift_repeat' ) ;
			} else {
				$( '.fgf_rule_type' ).closest( 'tr' ).hide() ;
				$( '.fgf_gift_products' ).closest( 'tr' ).show() ;
				$( '.fgf_automatic_rule_type' ).closest( 'tr' ).show() ;
			}
		} , gift_type : function ( $this ) {
			if ( $( $this ).val() === '1' ) {
				$( '.fgf_gift_products' ).closest( 'tr' ).show() ;
				$( '.fgf_gift_categories' ).closest( 'tr' ).hide() ;
			} else {
				$( '.fgf_gift_products' ).closest( 'tr' ).hide() ;
				$( '.fgf_gift_categories' ).closest( 'tr' ).show() ;
			}
		} , buy_product_type : function ( $this ) {
			if ( $( $this ).val() === '1' ) {
				$( '.fgf_buy_product' ).closest( 'tr' ).show() ;
				$( '.fgf_buy_categories' ).closest( 'tr' ).hide() ;
			} else {
				$( '.fgf_buy_product' ).closest( 'tr' ).hide() ;
				$( '.fgf_buy_categories' ).closest( 'tr' ).show() ;

				if ( $( '.fgf_buy_product_type' ).val() === '1' ) {
					$( '.fgf_buy_category_type' ).closest( 'tr' ).hide() ;
				}
			}
		} , bogo_gift_repeat : function ( $this ) {
			if ( $( $this ).is( ":checked" ) ) {
				$( '.fgf_bogo_gift_repeat_field' ).closest( 'tr' ).show() ;
				FGF_Admin.bogo_gift_repeat_mode( '.fgf_bogo_gift_repeat_mode' ) ;
			} else {
				$( '.fgf_bogo_gift_repeat_field' ).closest( 'tr' ).hide() ;
			}
		} , bogo_gift_repeat_mode : function ( $this ) {
			if ( $( $this ).val() === '1' ) {
				$( '.fgf_bogo_gift_repeat_limit' ).closest( 'tr' ).hide() ;
			} else {
				$( '.fgf_bogo_gift_repeat_limit' ).closest( 'tr' ).show() ;
			}
		} , bogo_gift_type : function ( $this ) {
			if ( $( $this ).val() === '1' ) {
				$( '.fgf_get_products' ).closest( 'tr' ).hide() ;
			} else {
				$( '.fgf_get_products' ).closest( 'tr' ).show() ;

				if ( $( '.fgf_buy_product_type' ).val() === '1' ) {
					$( '.fgf_buy_category_type' ).closest( 'tr' ).hide() ;
				}
			}
		} , notice : function ( $this ) {
			if ( $( $this ).val() === '2' ) {
				$( '.fgf_rule_notice' ).closest( 'tr' ).show() ;
			} else {
				$( '.fgf_rule_notice' ).closest( 'tr' ).hide() ;
			}
		} , user_filter_type : function ( $this ) {
			$( '.fgf_user_filter' ).closest( 'tr' ).hide() ;
			if ( $( $this ).val() === '2' ) {
				$( '.fgf_include_users' ).closest( 'tr' ).show() ;
			} else if ( $( $this ).val() === '3' ) {
				$( '.fgf_exclude_users' ).closest( 'tr' ).show() ;
			} else if ( $( $this ).val() === '4' ) {
				$( '.fgf_include_user_roles' ).closest( 'tr' ).show() ;
			} else if ( $( $this ).val() === '5' ) {
				$( '.fgf_exclude_user_roles' ).closest( 'tr' ).show() ;
			}
		} , product_filter_type : function ( $this ) {
			$( '.fgf_product_filter' ).closest( 'tr' ).hide() ;
			if ( $( $this ).val() === '2' ) {
				$( '.fgf_include_products' ).closest( 'tr' ).show() ;
				$( '.fgf_applicable_products_type' ).closest( 'tr' ).show() ;
				FGF_Admin.applicable_products_type( '.fgf_applicable_products_type' ) ;
			} else if ( $( $this ).val() === '3' ) {
				$( '.fgf_exclude_products' ).closest( 'tr' ).show() ;
			} else if ( $( $this ).val() === '5' ) {
				$( '.fgf_include_categories' ).closest( 'tr' ).show() ;
				$( '.fgf_applicable_categories_type' ).closest( 'tr' ).show() ;
			} else if ( $( $this ).val() === '6' ) {
				$( '.fgf_exclude_categories' ).closest( 'tr' ).show() ;
			}
		} , applicable_products_type : function ( $this ) {
			$( '.fgf_include_product_count' ).closest( 'tr' ).hide() ;
			if ( $( $this ).val() === '4' ) {
				$( '.fgf_include_product_count' ).closest( 'tr' ).show() ;
			}
		} , rule_total_type : function ( $this ) {

			if ( $( $this ).val() === '3' ) {
				$( '.fgf-rule-cart-categories' ).closest( 'tr' ).show() ;
			} else {
				$( '.fgf-rule-cart-categories' ).closest( 'tr' ).hide() ;
			}
		} , sortable_default_fields : function () {
			var listtable = $( 'table.woocommerce_page_fgf_settings #the-list' ).closest( 'table' ) ;

			listtable.sortable( {
				items : 'tr' ,
				handle : '.fgf_post_sort_handle' ,
				axis : 'y' ,
				containment : listtable ,
				update : function ( event , ui ) {
					var sort_order = [ ] ;

					listtable.find( '.fgf_rules_sortable' ).each( function ( e ) {
						sort_order.push( $( this ).val( ) ) ;
					} ) ;

					$.post( ajaxurl , {
						action : 'fgf_drag_rules_list' ,
						sort_order : sort_order ,
						fgf_security : fgf_rule_params.fgf_rules_drag_nonce
					} ) ;
				}
			} ) ;
		} , reset_rule_usage_count : function ( event ) {
			event.preventDefault() ;
			var $this = $( event.currentTarget ) ;

			FGF_Admin.block( $this ) ;

			var data = {
				action : 'fgf_reset_rule_usage_count' ,
				rule_id : $( $this ).data( 'rule-id' ) ,
				fgf_security : fgf_rule_params.fgf_rules_nonce ,
			} ;

			$.post( ajaxurl , data , function ( res ) {

				if ( true === res.success ) {
					alert( res.data.msg ) ;
					location.reload( true ) ;
				} else {
					alert( res.data.error ) ;
				}

				FGF_Admin.unblock( $this ) ;
			}
			) ;
		} , tabbed_rule_panels : function ( ) {

			// trigger the clicked link.
			$( '.fgf-rule-data-tab-link' ).on( 'click' , function ( event ) {
				event.preventDefault() ;
				var $this = $( event.currentTarget ) ,
						panel_content = $( $this ).closest( '.fgf-rule-data-panel-content' ) ;

				$( '.fgf-rule-data-tab' , panel_content ).removeClass( 'active' ) ;
				$( $this ).parent().addClass( 'active' ) ;

				$( 'div.fgf-rule-options-wrapper' , panel_content ).hide() ;
				$( $( $this ).attr( 'href' ) ).show() ;
			} ) ;

			// Trigger the first link.
			$( 'div.fgf-rule-data-panel-content' ).each( function () {
				$( this ).find( '.fgf-rule-data-tab' ).eq( 0 ).find( 'a' ).click() ;
			} ) ;
		} , block : function ( id ) {
			$( id ).block( {
				message : null ,
				overlayCSS : {
					background : '#fff' ,
					opacity : 0.7
				}
			} ) ;
		} , unblock : function ( id ) {
			$( id ).unblock() ;
		} ,
	} ;
	FGF_Admin.init( ) ;
} ) ;
