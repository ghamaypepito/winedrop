/* global fgf_admin_params, ajaxurl */

jQuery( function ( $ ) {
	'use strict' ;

	var FGF_Admin = {
		init : function ( ) {
			this.trigger_on_page_load() ;
			// manual gift tab
			$( document ).on( 'click' , '#fgf_manual_gift_manual_gift_btn' , this.manual_gift_btn ) ;
			//Settings Tab
			$( document ).on( 'change' , '#fgf_settings_enable_manual_gift_email' , this.toggle_manual_gift_email ) ;
			$( document ).on( 'change' , '#fgf_settings_gift_display_type' , this.toggle_gift_display_type ) ;
			$( document ).on( 'change' , '#fgf_settings_gift_display_table_pagination' , this.toggle_table_pagination ) ;
			$( document ).on( 'change' , '#fgf_settings_carousel_navigation' , this.toggle_carousel_navigation ) ;
			$( document ).on( 'change' , '#fgf_settings_carousel_auto_play' , this.toggle_carousel_auto_play ) ;
			$( document ).on( 'change' , '#fgf_settings_enable_checkout_free_gift_notice' , this.toggle_checkout_notice ) ;

			// masterlog tab
			$( document ).on( 'click' , '.fgf_master_log_info' , this.master_log_info ) ;
			$( document ).on( 'click' , '.fgf_popup_close' , this.toggle_master_log_popup_close ) ;

			// Prevent settings save in functionality.
			$( 'form#fgf_settings_form' ).on( 'submit' , this.prevent_settings_save ) ;
		} , trigger_on_page_load : function ( ) {
			//Settings Tab
			this.manual_gift_email( '#fgf_settings_enable_manual_gift_email' ) ;
			this.gift_display_type( '#fgf_settings_gift_display_type' ) ;
			this.enable_checkout_notice( '#fgf_settings_enable_checkout_free_gift_notice' ) ;
		} , toggle_gift_display_type : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.gift_display_type( $this ) ;
		} , toggle_table_pagination : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;

			FGF_Admin.table_pagination( $this ) ;
		} , toggle_carousel_navigation : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.carousel_navigation( $this ) ;
		} , toggle_carousel_auto_play : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.carousel_auto_play( $this ) ;
		} , toggle_manual_gift_email : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.manual_gift_email( $this ) ;
		} , toggle_checkout_notice : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.enable_checkout_notice( $this ) ;
		} , toggle_master_log_popup_close : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ;
			FGF_Admin.master_log_popup_close( $this ) ;
		} , prevent_settings_save : function ( event ) {

			if ( '2' == $( '#fgf_settings_gift_display_type' ).val() && $( '#fgf_settings_carousel_gift_per_page' ).val() > 3 ) {
				if ( !confirm( $( '#fgf_settings_carousel_gift_per_page' ).data( 'error' ) ) ) {
					event.preventDefault( ) ;
					return false ;
				}
			}

		} , gift_display_type : function ( $this ) {
			if ( $( $this ).val() === '1' ) {
				$( '.fgf_gift_dropdown_display_type' ).closest( 'tr' ).hide() ;
				$( '.fgf_gift_table_display_type' ).closest( 'tr' ).show() ;
				$( '.fgf_gift_carousel_display_type' ).closest( 'tr' ).hide() ;
				FGF_Admin.table_pagination( '#fgf_settings_gift_display_table_pagination' ) ;
			} else if ( $( $this ).val() === '3' ) {
				$( '.fgf_gift_table_display_type' ).closest( 'tr' ).hide() ;
				$( '.fgf_gift_carousel_display_type' ).closest( 'tr' ).hide() ;
				$( '.fgf_gift_dropdown_display_type' ).closest( 'tr' ).show() ;
			} else {
				$( '.fgf_gift_dropdown_display_type' ).closest( 'tr' ).hide() ;
				$( '.fgf_gift_table_display_type' ).closest( 'tr' ).hide() ;
				$( '.fgf_gift_carousel_display_type' ).closest( 'tr' ).show() ;
				FGF_Admin.carousel_auto_play( '#fgf_settings_carousel_auto_play' ) ;
				FGF_Admin.carousel_navigation( '#fgf_settings_carousel_navigation' ) ;
			}
		} , table_pagination : function ( $this ) {
			if ( '1' == $( $this ).val() ) {
				$( '#fgf_settings_free_gift_per_page_column_count' ).closest( 'tr' ).show() ;
			} else {
				$( '#fgf_settings_free_gift_per_page_column_count' ).closest( 'tr' ).hide() ;
			}
		} , carousel_navigation : function ( $this ) {
			if ( $( $this ).is( ":checked" ) ) {
				$( '.fgf_carousel_navigation_type' ).closest( 'tr' ).show() ;
			} else {
				$( '.fgf_carousel_navigation_type' ).closest( 'tr' ).hide() ;
			}
		} , carousel_auto_play : function ( $this ) {
			if ( $( $this ).is( ":checked" ) ) {
				$( '.fgf_carousel_auto_play' ).closest( 'tr' ).show() ;
			} else {
				$( '.fgf_carousel_auto_play' ).closest( 'tr' ).hide() ;
			}
		} , manual_gift_email : function ( $this ) {
			$( '.fgf_manual_gift_email' ).closest( 'tr' ).hide() ;
			if ( $( $this ).is( ":checked" ) ) {
				$( '.fgf_manual_gift_email' ).closest( 'tr' ).show() ;
			}
		} , enable_checkout_notice : function ( $this ) {
			$( '.fgf_checkout_free_gift_notice' ).closest( 'tr' ).hide() ;
			if ( $( $this ).is( ":checked" ) ) {
				$( '.fgf_checkout_free_gift_notice' ).closest( 'tr' ).show() ;
			}
		} , master_log_popup_close : function ( $this ) {
			$( $this ).closest( 'div.fgf_popup_wrapper' ).remove() ;
		} , master_log_popup_outside_click : function ( $this ) {
			if ( $( $this.target ).attr( 'class' ) == "fgf_popup_wrapper" ) {
				$( '.fgf_popup_content' ).parent().remove() ;
				$( '.fgf_master_log_info_popup_content' ).parent().remove() ;
			}
		} , manual_gift_btn : function ( event ) {
			event.preventDefault() ;

			FGF_Admin.block( 'div.fgf_tab_inner_content table' ) ;

			var data = ( {
				action : 'fgf_create_gift_order' ,
				user : $( '#fgf_manual_gift_selected_user' ).val( ) ,
				products : $( '#fgf_manual_gift_selected_products' ).val( ) ,
				status : $( '#fgf_manual_gift_order_status' ).val( ) ,
				fgf_security : fgf_admin_params.manual_gift_nonce ,
			} ) ;

			$.post( ajaxurl , data , function ( res ) {
				if ( true === res.success ) {
					alert( res.data.msg ) ;
					location.reload( true ) ;
				} else {
					alert( res.data.error ) ;
				}
				FGF_Admin.unblock( 'div.fgf_tab_inner_content table' ) ;
			}
			) ;
		} , master_log_info : function ( event ) {
			event.preventDefault() ;
			var $this = $( event.currentTarget ) ;

			var data = {
				action : 'fgf_master_log_info_popup' ,
				master_log_id : $( $this ).data( 'fgf_master_log_id' ) ,
				fgf_security : fgf_admin_params.fgf_master_log_info_nonce ,
			} ;

			$.post( ajaxurl , data , function ( res ) {
				if ( true === res.success ) {
					$( res.data.popup ).appendTo( 'body' ) ;
					$( document ).on( 'click' , 'body' , FGF_Admin.master_log_popup_outside_click ) ;
				} else {
					alert( res.data.error ) ;
				}
			}
			) ;
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
