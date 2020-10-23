/* global fgf_frontend_params */

jQuery( function ( $ ) {
	'use strict' ;

	var FGF_Frontend = {
		init : function ( ) {
			$( document ).on( 'click' , '.fgf_pagination' , this.manual_gift_pagination ) ;
			// Add the gift product via dropdown.
			$( document ).on( 'click' , '.fgf-add-gift-product' , this.add_manually_gift_product ) ;
			// Add the gift product via dropdown.
			$( document ).on( 'change' , '.fgf-gift-product-selection' , this.add_automatically_gift_product ) ;
			//Update the cart when updating shipping.
			$( document.body ).on( 'updated_shipping_method' , this.updated_shipping_method ) ;
		} , updated_shipping_method : function () {
			$( document.body ).trigger( 'wc_update_cart' ) ;
		} , add_manually_gift_product : function ( event ) {
			event.preventDefault( ) ;
			// Check the automatic add to cart is enabled. 
			if ( '2' == fgf_frontend_params.dropdown_add_to_cart_behaviour ) {
				return false ;
			}

			var $this = $( event.currentTarget ) ,
					url = fgf_frontend_params.add_to_cart_link ,
					wrapper = $this.closest( '.fgf-gift-product-wrapper' ) ,
					product_id = wrapper.find( '.fgf-gift-product-selection' ).val() ,
					rule_id = wrapper.find( '.fgf-gift-product-selection' ).find( ':selected' ).data( 'rule-id' ) ;

			if ( '' == product_id ) {
				alert( fgf_frontend_params.add_to_cart_alert_message ) ;
				return false ;
			}

			// Create a add to cart link.
			url = url.replace( '%s' , product_id ) ;
			url = url.replace( '%s' , rule_id ) ;

			// Add to cart the gift product.
			window.location.href = url ;
		} , add_automatically_gift_product : function ( event ) {
			event.preventDefault( ) ;
			// Check the automatic add to cart is enabled. 
			if ( '2' != fgf_frontend_params.dropdown_add_to_cart_behaviour ) {
				return false ;
			}

			var $this = $( event.currentTarget ) ,
					url = fgf_frontend_params.add_to_cart_link ,
					rule_id = $( $this ).find( ':selected' ).data( 'rule-id' ) ;

			if ( '' == $( $this ).val() ) {
				return false ;
			}

			// Create a add to cart link.
			url = url.replace( '%s' , $( $this ).val() ) ;
			url = url.replace( '%s' , rule_id ) ;

			// Add to cart the gift product.
			window.location.href = url ;
		} , manual_gift_pagination : function ( event ) {
			event.preventDefault( ) ;
			var $this = $( event.currentTarget ) ,
					table = $this.closest( 'table.fgf_gift_products_table' ) ,
					table_body = table.find( 'tbody' ) ,
					current_page = $this.data( 'page' ) ;

			FGF_Frontend.block( table_body ) ;

			var data = ( {
				action : 'fgf_gift_products_pagination' ,
				page_number : current_page ,
				page_url : fgf_frontend_params.current_page_url ,
				fgf_security : fgf_frontend_params.gift_products_pagination_nonce ,
			} ) ;
			$.post( fgf_frontend_params.ajaxurl , data , function ( res ) {

				if ( true === res.success ) {
					table_body.html( res.data.html ) ;

					table.find( '.fgf_pagination' ).removeClass( 'current' ) ;
					$( $this ).addClass( 'current' ) ;

					table.find( '.fgf_next_pagination' ).attr( 'data-page' , current_page + 1 ) ;
					table.find( '.fgf_prev_pagination' ).attr( 'data-page' , current_page - 1 ) ;
				} else {
					alert( res.data.error ) ;
				}

				FGF_Frontend.unblock( table_body ) ;
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
	FGF_Frontend.init( ) ;
} ) ;
