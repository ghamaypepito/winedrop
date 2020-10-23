<?php
/*
 * Layout functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}

if ( ! function_exists( 'fgf_select2_html' ) ) {

	/**
	 * Return or display Select2 HTML
	 *
	 * @return string
	 */
	function fgf_select2_html( $args, $echo = true ) {
		$args = wp_parse_args(
				$args , array(
			'class'                   => '' ,
			'id'                      => '' ,
			'name'                    => '' ,
			'list_type'               => '' ,
			'action'                  => '' ,
			'placeholder'             => '' ,
			'exclude_global_variable' => 'no' ,
			'custom_attributes'       => array() ,
			'multiple'                => true ,
			'allow_clear'             => true ,
			'selected'                => true ,
			'options'                 => array() ,
				)
				) ;

		$multiple = $args[ 'multiple' ] ? 'multiple="multiple"' : '' ;
		$name     = esc_attr( '' !== $args[ 'name' ] ? $args[ 'name' ] : $args[ 'id' ] ) . '[]' ;
		$options  = array_filter( fgf_check_is_array( $args[ 'options' ] ) ? $args[ 'options' ] : array() ) ;

		$allowed_html = array(
			'select' => array(
				'id'                           => array() ,
				'class'                        => array() ,
				'data-placeholder'             => array() ,
				'data-allow_clear'             => array() ,
				'data-exclude-global-variable' => array() ,
				'data-action'                  => array() ,
				'data-nonce'                   => array() ,
				'multiple'                     => array() ,
				'name'                         => array() ,
			) ,
			'option' => array(
				'value'    => array() ,
				'selected' => array()
			)
				) ;

		// Custom attribute handling.
		$custom_attributes = fgf_format_custom_attributes( $args ) ;
		$data_nonce        = ( 'products' == $args[ 'list_type' ] ) ? 'data-nonce="' . wp_create_nonce( 'search-products' ) . '"' : '' ;

		ob_start() ;
		?><select <?php echo esc_attr( $multiple ) ; ?> 
			name="<?php echo esc_attr( $name ) ; ?>" 
			id="<?php echo esc_attr( $args[ 'id' ] ) ; ?>" 
			data-action="<?php echo esc_attr( $args[ 'action' ] ) ; ?>" 
			data-exclude-global-variable="<?php echo esc_attr( $args[ 'exclude_global_variable' ] ) ; ?>" 
			class="fgf_select2_search <?php echo esc_attr( $args[ 'class' ] ) ; ?>" 
			data-placeholder="<?php echo esc_attr( $args[ 'placeholder' ] ) ; ?>" 
			<?php echo wp_kses( implode( ' ' , $custom_attributes ) , $allowed_html ) ; ?>
			<?php echo wp_kses( $data_nonce , $allowed_html ) ; ?>
			<?php echo $args[ 'allow_clear' ] ? 'data-allow_clear="true"' : '' ; ?> >
				<?php
				if ( is_array( $args[ 'options' ] ) ) {
					foreach ( $args[ 'options' ] as $option_id ) {
						$option_value = '' ;
						switch ( $args[ 'list_type' ] ) {
							case 'post':
								$option_value = get_the_title( $option_id ) ;
								break ;
							case 'products':
								$product      = wc_get_product( $option_id ) ;
								if ( $product ) {
									$option_value = $product->get_name() . ' (#' . absint( $option_id ) . ')' ;
								}
								break ;
							case 'customers':
								$user = get_user_by( 'id' , $option_id ) ;
								if ( $user ) {
									$option_value = $user->display_name . '(#' . absint( $user->ID ) . ' &ndash; ' . $user->user_email . ')' ;
								}
								break ;
						}

						if ( $option_value ) {
							?>
						<option value="<?php echo esc_attr( $option_id ) ; ?>" <?php echo $args[ 'selected' ] ? 'selected="selected"' : '' ; // WPCS: XSS ok. ?>><?php echo esc_html( $option_value ) ; ?></option>
							<?php
						}
					}
				}
				?>
		</select>
		<?php
		$html = ob_get_clean() ;

		if ( $echo ) {
			echo wp_kses( $html , $allowed_html ) ;
		}

		return $html ;
	}

}

if ( ! function_exists( 'fgf_format_custom_attributes' ) ) {

	/**
	 * Format Custom Attributes
	 *
	 * @return array
	 */
	function fgf_format_custom_attributes( $value ) {
		$custom_attributes = array() ;

		if ( ! empty( $value[ 'custom_attributes' ] ) && is_array( $value[ 'custom_attributes' ] ) ) {
			foreach ( $value[ 'custom_attributes' ] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '=' . esc_attr( $attribute_value ) . '' ;
			}
		}

		return $custom_attributes ;
	}

}

if ( ! function_exists( 'fgf_get_datepicker_html' ) ) {

	/**
	 * Return or display Datepicker HTML
	 *
	 * @return string
	 */
	function fgf_get_datepicker_html( $args, $echo = true ) {
		$args = wp_parse_args(
				$args , array(
			'class'             => '' ,
			'id'                => '' ,
			'name'              => '' ,
			'placeholder'       => '' ,
			'custom_attributes' => array() ,
			'value'             => '' ,
			'wp_zone'           => true ,
				)
				) ;

		$name = ( '' !== $args[ 'name' ] ) ? $args[ 'name' ] : $args[ 'id' ] ;

		$allowed_html = array(
			'input' => array(
				'id'          => array() ,
				'type'        => array() ,
				'placeholder' => array() ,
				'class'       => array() ,
				'value'       => array() ,
				'name'        => array() ,
				'min'         => array() ,
				'max'         => array() ,
				'style'       => array() ,
			) ,
				) ;

		// Custom attribute handling.
		$custom_attributes = fgf_format_custom_attributes( $args ) ;
		$value             = ! empty( $args[ 'value' ] ) ? FGF_Date_Time::get_date_object_format_datetime( $args[ 'value' ] , 'date' , $args[ 'wp_zone' ] ) : '' ;
		ob_start() ;
		?>
		<input type = "text" 
			   id="<?php echo esc_attr( $args[ 'id' ] ) ; ?>"
			   value = "<?php echo esc_attr( $value ) ; ?>"
			   class="fgf_datepicker <?php echo esc_attr( $args[ 'class' ] ) ; ?>" 
			   placeholder="<?php echo esc_attr( $args[ 'placeholder' ] ) ; ?>" 
			   <?php echo wp_kses( implode( ' ' , $custom_attributes ) , $allowed_html ) ; ?>
			   />

		<input type = "hidden" 
			   class="fgf_alter_datepicker_value" 
			   name="<?php echo esc_attr( $name ) ; ?>"
			   value = "<?php echo esc_attr( $args[ 'value' ] ) ; ?>"
			   /> 
		<?php
		$html              = ob_get_clean() ;

		if ( $echo ) {
			echo wp_kses( $html , $allowed_html ) ;
		}

		return $html ;
	}

}

if ( ! function_exists( 'fgf_display_action' ) ) {

	/**
	 * Display Action
	 *
	 * @return string
	 */
	function fgf_display_action( $status, $id, $current_url, $action = false ) {
		switch ( $status ) {
			case 'edit':
				$status_name = esc_html__( 'Edit' , 'free-gifts-for-woocommerce' ) ;
				break ;
			case 'active':
				$status_name = esc_html__( 'Activate' , 'free-gifts-for-woocommerce' ) ;
				break ;
			case 'inactive':
				$status_name = esc_html__( 'Deactivate' , 'free-gifts-for-woocommerce' ) ;
				break ;
			default:
				$status_name = esc_html__( 'Delete Permanently' , 'free-gifts-for-woocommerce' ) ;
				break ;
		}

		$section_name = 'section' ;
		if ( $action ) {
			$section_name = 'action' ;
		}

		if ( 'edit' == $status ) {
			return '<a href="' . esc_url(
							add_query_arg(
									array(
						$section_name => $status ,
						'id'          => $id ,
									) , $current_url
							)
					) . '">' . $status_name . '</a>' ;
		} elseif ( 'delete' == $status ) {
			return '<a class="fgf_delete_data" href="' . esc_url(
							add_query_arg(
									array(
						'action' => $status ,
						'id'     => $id ,
									) , $current_url
							)
					) . '">' . $status_name . '</a>' ;
		} else {
			return '<a href="' . esc_url(
							add_query_arg(
									array(
						'action' => $status ,
						'id'     => $id ,
									) , $current_url
							)
					) . '">' . $status_name . '</a>' ;
		}
	}

}

if ( ! function_exists( 'fgf_display_status' ) ) {

	/**
	 * Display formatted status
	 *
	 * @return string
	 */
	function fgf_display_status( $status, $html = true ) {

		$status_object = get_post_status_object( $status ) ;

		if ( ! isset( $status_object ) ) {
			return '' ;
		}

		return $html ? '<mark class="fgf_status_label ' . esc_attr( $status ) . '_status"><span >' . esc_html( $status_object->label ) . '</span></mark>' : esc_html( $status_object->label ) ;
	}

}

if ( ! function_exists( 'fgf_get_template' ) ) {

	/**
	 *  Get other templates from themes
	 */
	function fgf_get_template( $template_name, $args = array() ) {

		wc_get_template( $template_name , $args , 'free-gifts-for-woocommerce/' , FGF()->templates() ) ;
	}

}

if ( ! function_exists( 'fgf_get_template_html' ) ) {

	/**
	 *  Like fgf_get_template, but returns the HTML instead of outputting.
	 *
	 *  @return string
	 */
	function fgf_get_template_html( $template_name, $args = array() ) {

		ob_start() ;
		fgf_get_template( $template_name , $args ) ;
		return ob_get_clean() ;
	}

}

if ( ! function_exists( 'fgf_wc_help_tip' ) ) {

	/**
	 *  Display tool help based on WC help tip
	 *
	 *  @return string
	 */
	function fgf_wc_help_tip( $tip, $allow_html = false, $echo = true ) {

		$formatted_tip = wc_help_tip( $tip , $allow_html ) ;

		if ( $echo ) {
			echo wp_kses_post( $formatted_tip ) ;
		}

		return $formatted_tip ;
	}

}

if ( ! function_exists( 'fgf_render_product_image' ) ) {

	/**
	 *  Display Product image
	 *
	 *  @return string
	 */
	function fgf_render_product_image( $product, $echo = true ) {

		if ( $echo ) {
			echo wp_kses_post( $product->get_image() ) ;
		}

		return $product->get_image() ;
	}

}


if ( ! function_exists( 'fgf_price' ) ) {

	/**
	 *  Display Price based wc_price function
	 *
	 *  @return string
	 */
	function fgf_price( $price, $echo = true ) {

		if ( $echo ) {
			echo wp_kses_post( wc_price( $price ) ) ;
		}

		return wc_price( $price ) ;
	}

}

if ( ! function_exists( 'fgf_get_rule_type_name' ) ) {

	/**
	 *  Get rule type Name
	 *
	 *  @return string
	 */
	function fgf_get_rule_type_name( $type ) {

		$types = array(
			'1' => esc_html__( 'Manual' , 'free-gifts-for-woocommerce' ) ,
			'2' => esc_html__( 'Automatic' , 'free-gifts-for-woocommerce' ) ,
			'3' => esc_html__( 'Buy X Get Y' , 'free-gifts-for-woocommerce' )
				) ;

		if ( ! isset( $types[ $type ] ) ) {
			return '' ;
		}

		return $types[ $type ] ;
	}

}

if ( ! function_exists( 'fgf_get_rule_week_days_options' ) ) {

	/**
	 * Get the rule weekdays options.
	 *
	 * @return array
	 * */
	function fgf_get_rule_week_days_options() {
		return array(
			'1' => esc_html__( 'Monday' , 'free-gifts-for-woocommerce' ) ,
			'2' => esc_html__( 'Tuesday' , 'free-gifts-for-woocommerce' ) ,
			'3' => esc_html__( 'Wednesday' , 'free-gifts-for-woocommerce' ) ,
			'4' => esc_html__( 'Thursday' , 'free-gifts-for-woocommerce' ) ,
			'5' => esc_html__( 'Friday' , 'free-gifts-for-woocommerce' ) ,
			'6' => esc_html__( 'Saturday' , 'free-gifts-for-woocommerce' ) ,
			'7' => esc_html__( 'Sunday' , 'free-gifts-for-woocommerce' )
				) ;
	}

}

