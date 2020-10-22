<?php function byconsolewooodt_free_admin_holiday_form(){?>

	<style>

		.byconsolewooodt_pickup_holidays span{padding-right: 15px;}

		.byconsolewooodt_delivery_holidays span{padding-right: 15px;}

	</style>

	

	<div class="wrap">

        <h1>Holiday management</h1>

        <form method="post" class="form_byconsolewooodt_free_plugin_settings" action="options.php">

				<?php

                settings_fields("holidaymanagement");

                do_settings_sections("byconsolewooodt_free_holidaymanagement_options");  

                submit_button();

                ?> 

		</form>

    </div>

	<?php

}





function byconsolewooodt_free_pickup_holiday_management(){

	$byconsolewooodt_pickup_holidays = get_option('byconsolewooodt_pickup_holidays');

	if(empty($byconsolewooodt_pickup_holidays)){

		$byconsolewooodt_pickup_holidays=array();

		}		

	

	

	echo '<div class="byconsolewooodt_pickup_holidays">';

	if(in_array('0',$byconsolewooodt_pickup_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="0" checked><span>Sunday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="0"><span>Sunday</span>';

		}

		

	if(in_array('1',$byconsolewooodt_pickup_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="1" checked><span>Monday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="1"><span>Monday</span>';

		}

		

	if(in_array('2',$byconsolewooodt_pickup_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="2" checked><span>Tuesday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="2"><span>Tuesday</span>';

		}

		

	if(in_array('3',$byconsolewooodt_pickup_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="3" checked><span>Wednesday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="3"><span>Wednesday</span>';

		}

		

	if(in_array('4',$byconsolewooodt_pickup_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="4" checked><span>Thursday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="4"><span>Thuurday</span>';

		}

		

	if(in_array('5',$byconsolewooodt_pickup_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="5" checked><span>Friday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="5"><span>Friday</span>';

		}

		

	if(in_array('6',$byconsolewooodt_pickup_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="6" checked><span>Saturday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_pickup_holidays[]" id="byconsolewooodt_pickup_holidays" value="6"><span>Saturday</span>';

		}

	     

   echo '</div>';

	

}





function byconsolewooodt_free_delivery_holiday_management(){

	

	$byconsolewooodt_delivery_holidays = get_option('byconsolewooodt_delivery_holidays');

	if(empty($byconsolewooodt_delivery_holidays)){

		$byconsolewooodt_delivery_holidays=array();

		}

	

	echo '<div class="byconsolewooodt_delivery_holidays">';

	if(in_array('0',$byconsolewooodt_delivery_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="0" checked><span>Sunday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="0"><span>Sunday</span>';

		}

		

	if(in_array('1',$byconsolewooodt_delivery_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="1" checked><span>Monday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="1"><span>Monday</span>';

		}

		

	if(in_array('2',$byconsolewooodt_delivery_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="2" checked><span>Tuesday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="2"><span>Tuesday</span>';

		}

		

	if(in_array('3',$byconsolewooodt_delivery_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="3" checked><span>Wednesday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="3"><span>Wednesday</span>';

		}

		

	if(in_array('4',$byconsolewooodt_delivery_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="4" checked><span>Thursday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="4"><span>Thuurday</span>';

		}

		

	if(in_array('5',$byconsolewooodt_delivery_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="5" checked><span>Friday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="5"><span>Friday</span>';

		}

		

	if(in_array('6',$byconsolewooodt_delivery_holidays)){

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="6" checked><span>Saturday</span>';	}else{

		echo '<input type="checkbox" name="byconsolewooodt_delivery_holidays[]" id="byconsolewooodt_delivery_holidays" value="6"><span>Saturday</span>';

		}

	     

   echo '</div>';

}


function byconsolewooodt_free_delivery_pickup_holiday1_management(){
?>
<script>

var dateToday = new Date();
jQuery(function(){
    jQuery("#byconsolewooodt_free_delivery_pickup_holiday1").datepicker({
		showButtonPanel: true,
		dateFormat: 'mm/dd/yy',
		minDate: dateToday
	});
});

</script>
<input type="text" id="byconsolewooodt_free_delivery_pickup_holiday1" name="byconsolewooodt_free_delivery_pickup_holiday1" class="bycwooodt_admin_fields_design" readonly="readonly" value="<?php printf(get_option('byconsolewooodt_free_delivery_pickup_holiday1')); ?>"><span class="calendar_opentext">Click On Text Box To Open Calendar </span> 
<?php }

function byconsolewooodt_free_delivery_pickup_holiday2_management(){
?>
<script>

var dateToday = new Date();
jQuery(function(){
    jQuery("#byconsolewooodt_free_delivery_pickup_holiday2").datepicker({
		showButtonPanel: true,
		dateFormat: 'mm/dd/yy',
		minDate: dateToday
	});
});

</script>
<input type="text" id="byconsolewooodt_free_delivery_pickup_holiday2" name="byconsolewooodt_free_delivery_pickup_holiday2" class="bycwooodt_admin_fields_design" readonly="readonly" value="<?php printf(get_option('byconsolewooodt_free_delivery_pickup_holiday2')); ?>"><span class="calendar_opentext">Click On Text Box To Open Calendar </span> 
<?php }


add_action('admin_init', 'byconsolewooodt_free_plugin_holiday_manage_settings_fields');



function byconsolewooodt_free_plugin_holiday_manage_settings_fields(){



	add_settings_section("holidaymanagement", "", null, "byconsolewooodt_free_holidaymanagement_options");



	add_settings_field("byconsolewooodt_pickup_holidays", __('Pickup Holidays (Weekly):','byconsole-woo-order-delivery-time'), "byconsolewooodt_free_pickup_holiday_management", "byconsolewooodt_free_holidaymanagement_options", "holidaymanagement");



	add_settings_field("byconsolewooodt_delivery_holidays", __('Delivery Holidays (Weekly):','byconsole-woo-order-delivery-time'), "byconsolewooodt_free_delivery_holiday_management", "byconsolewooodt_free_holidaymanagement_options", "holidaymanagement");


	add_settings_field("byconsolewooodt_free_delivery_pickup_holiday1", __('Holiday 1:','byconsole-woo-order-delivery-time'), "byconsolewooodt_free_delivery_pickup_holiday1_management", "byconsolewooodt_free_holidaymanagement_options", "holidaymanagement");
	
	add_settings_field("byconsolewooodt_free_delivery_pickup_holiday2", __('Holiday 2:','byconsole-woo-order-delivery-time'), "byconsolewooodt_free_delivery_pickup_holiday2_management", "byconsolewooodt_free_holidaymanagement_options", "holidaymanagement");



	register_setting("holidaymanagement", "byconsolewooodt_pickup_holidays");

	register_setting("holidaymanagement", "byconsolewooodt_delivery_holidays");
	
	register_setting("holidaymanagement", "byconsolewooodt_free_delivery_pickup_holiday1");
	
	register_setting("holidaymanagement", "byconsolewooodt_free_delivery_pickup_holiday2");




	}

?>