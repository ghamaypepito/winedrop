/* global fgf_enhanced_select_params */

jQuery( function ( $ ) {
	'use strict' ;

	try {
		$( document.body ).on( 'fgf-enhanced-init' , function () {
			if ( $( 'select.fgf_select2' ).length ) {
				//Select2 with customization
				$( 'select.fgf_select2' ).each( function () {
					var select2_args = {
						allowClear : $( this ).data( 'allow_clear' ) ? true : false ,
						placeholder : $( this ).data( 'placeholder' ) ,
						minimumResultsForSearch : 10 ,
					} ;
					$( this ).select2( select2_args ) ;
				} ) ;
			}
			if ( $( 'select.fgf_select2_search' ).length ) {
				//Multiple select with ajax search
				$( 'select.fgf_select2_search' ).each( function () {
					var select2_args = {
						allowClear : $( this ).data( 'allow_clear' ) ? true : false ,
						placeholder : $( this ).data( 'placeholder' ) ,
						minimumInputLength : $( this ).data( 'minimum_input_length' ) ? $( this ).data( 'minimum_input_length' ) : 3 ,
						escapeMarkup : function ( m ) {
							return m ;
						} ,
						ajax : {
							url : fgf_enhanced_select_params.ajaxurl ,
							dataType : 'json' ,
							delay : 250 ,
							data : function ( params ) {
								return {
									term : params.term ,
									action : $( this ).data( 'action' ) ? $( this ).data( 'action' ) : 'fgf_json_search_customers' ,
									exclude_global_variable : $( this ).data( 'exclude-global-variable' ) ? $( this ).data( 'exclude-global-variable' ) : 'no' ,
									fgf_security : $( this ).data( 'nonce' ) ? $( this ).data( 'nonce' ) : fgf_enhanced_select_params.search_nonce ,
								} ;
							} ,
							processResults : function ( data ) {
								var terms = [ ] ;
								if ( data ) {
									$.each( data , function ( id , term ) {
										terms.push( {
											id : id ,
											text : term
										} ) ;
									} ) ;
								}
								return {
									results : terms
								} ;
							} ,
							cache : true
						}
					} ;

					$( this ).select2( select2_args ) ;
				} ) ;
			}

			if ( $( '.fgf_datepicker' ).length ) {
				$( '.fgf_datepicker' ).on( 'change' , function ( ) {
					if ( $( this ).val() === '' ) {
						$( this ).next( ".fgf_alter_datepicker_value" ).val( '' ) ;
					}
				} ) ;

				$( '.fgf_datepicker' ).each( function ( ) {
					$( this ).datepicker( {
						altField : $( this ).next( ".fgf_alter_datepicker_value" ) ,
						altFormat : 'yy-mm-dd' ,
						changeMonth : true ,
						changeYear : true
					} ) ;
				} ) ;
			}

		} ) ;

		$( document.body ).trigger( 'fgf-enhanced-init' ) ;
	} catch ( err ) {
		window.console.log( err ) ;
	}

} ) ;
