<?php
add_action('admin_init', 'byconsolewooodt_location_settings_fields', 99);

function byconsolewooodt_location_settings_fields()
{
add_settings_section("wooodtlocationsetting", "wooodt Location  Settings", null, "byconsolewooodt_wooodt_location_settings_options");

add_settings_field("byconsolewooodt_multiple_pickup_location_lebel", "Multiple Pickup Location:", "byconsolewooodt_multiple_pickup_location_lebel", "byconsolewooodt_wooodt_location_settings_options", "wooodtlocationsetting");

add_settings_field("byconsolewooodt_pickup_location", "Pickup Location:<br/><span style='color:#a0a5aa;font-size:12px;'>( To disable the pickup location <br/>please check the check box )</span>", "byconsolewooodt_pickup_location", "byconsolewooodt_wooodt_location_settings_options", "wooodtlocationsetting");

//		print_r(get_option('byconsolewooodt_pickup_location'));
//		print_r(get_option('byconsolewooodt_delivery_location'));

register_setting("wooodtlocationsetting", "byconsolewooodt_pickup_location");

//register_setting("wooodtlocationsetting", "byconsolewooodt_delivery_location");
register_setting("wooodtlocationsetting", "byconsolewooodt_multiple_pickup_location");

//register_setting("wooodtlocationsetting", "byconsolewooodt_multiple_delivery_location");
}

function byconsolewooodt_multiple_pickup_location_lebel()
{
?>
<input type="checkbox" name="byconsolewooodt_multiple_pickup_location" id="byconsolewooodt_multiple_pickup_location" style="float: none;width: auto;" class="byconsolewooodt_admin_element_field checkbox" value="YES" <?php if( get_option('byconsolewooodt_multiple_pickup_location')=='YES'){?> checked="checked"<?php }?> />

<?php echo __('Enable multiple pickup location.','ByConsoleWooODTExtended');
}

function byconsolewooodt_pickup_location()
{
		if ( is_plugin_active( 'ByConsoleWooODTExtendedMapAddon/ByConsoleWooODTExtendedMapAddon.php' ) ) {	} 
	else 
	{ 
	?>
    <style>
	.byconsolewooodt_pickup_location_address_latitude{display:none;}
	.byconsolewooodt_pickup_location_address_longitude{display:none;} 
	.location_lable{width:16% !important;}
	#location_field{width:30% !important;}
	.email_field{width:26% !important;}
	.latitude_lable{display:none;}
	.longitude_lable{display:none;}
	</style>
	<?php }

$byconsolwooodtgetallpickuplocation=get_option('byconsolewooodt_pickup_location');
//print_r($byconsolwooodtgetallpickuplocation);
if (!empty($byconsolwooodtgetallpickuplocation))
{ 
foreach ($byconsolwooodtgetallpickuplocation as $byconsolwooodtgetallpickuplocation_key => $byconsolwooodtgetallpickuplocation_val)
{
$byconsolwooodtgetallpickuplocation_key_value[]=$byconsolwooodtgetallpickuplocation_key;
//print_r($byconsolwooodtgetallpickuplocation_key_value);
}	
}
else
{
//echo 'Location Is Empty.<br/>';
}	
?>
<script type="text/javascript">
jQuery(document).ready(function() {	
//byconsolewooodt_pickup_location_count=<?php //echo count(get_option('byconsolewooodt_pickup_location'));?>;
byconsolewooodt_pickup_location_count= 
<?php  if (empty($byconsolwooodtgetallpickuplocation_key_value)){ echo '0' ;} else { echo end($byconsolwooodtgetallpickuplocation_key_value); }?>
//alert(byconsolewooodt_pickup_location_count);
jQuery('#btn_pickup_add_another').click(function(){			 
// byconsolewooodt_pickup_location_count++;
byconsolewooodt_pickup_location_count+=1;
//alert(byconsolewooodt_pickup_location_count);
jQuery('.pickup_options').append('<fieldset class="fldst pickup_location'+byconsolewooodt_pickup_location_count+'"><input type="checkbox" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][location_disable]" id="byconsolewooodt_pickup_location" value="disable"  style="float: left;margin-top: 10px;width: 5px;" class="pro_only" /><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][location]" id="byconsolewooodt_pickup_location" class="byconsolewooodt_pickup_location'+byconsolewooodt_pickup_location_count+'" placeholder="Pickup Location" value="" onchange="location_finder(this)" style="width:20%; padding:7px;" /><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][address_latitude]" id="byconsolewooodt_pickup_location" class="byconsolewooodt_pickup_location_address_latitude" placeholder="Latitude" value="" readonly="readonly" style="width:10%; padding:7px;" /><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][address_longitude]" id="byconsolewooodt_pickup_location" class="byconsolewooodt_pickup_location_address_longitude" placeholder="Longitude" value="" readonly="readonly" style="width:10%; padding:7px;" /><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][start_time]" id="byconsolewooodt_pickup_location" value="" style="width:10%; padding:7px;" class="pro_only" /><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][end_time]" id="byconsolewooodt_pickup_location" value="" style="width:10%; padding:7px;" class="pro_only" /><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][min_cart_value]" id="byconsolewooodt_pickup_location" placeholder="Pickup Price" value="" style="width:8%; padding:7px;" class="pro_only" /><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][shipping_cost]" id="byconsolewooodt_pickup_location" placeholder="Shipping Cost" value="" style="width:8%; padding:7px;" class="pro_only" /><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][email_id_on_each_location]" id="byconsolewooodt_pickup_location" placeholder="Enter Email Id" class="email_field pro_only" value="" style="width:14%; padding:7px;" /><span id="del_pickup" class="pickup_location'+byconsolewooodt_pickup_location_count+'" style="cursor:pointer;">X</span><br /><div style="float: left;"><input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][sun][service]" value="yes" style="margin-top: 10px;width: 5px;float:left;" class="pro_only"><p style="margin-top: 8px;">Sun</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][sun][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][sun][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><div style="background-color:#ffa500;padding:2px;"><p style="margin-top: 6px;text-align: center; color: #000;font-weight:bold;font-size: 10px;margin-bottom: 6px;">Break Time</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][sun][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][sun][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /></div></div>&nbsp;<div style="float: left;margin-left: 5px;"><input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][mon][service]" value="yes" checked="checked" style="margin-top: 10px;width: 5px;float:left;" class="pro_only"><p style="margin-top: 8px;">Mon</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][mon][start_time]" id="byconsolewooodt_pickup_location" value="10:00" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][mon][end_time]" id="byconsolewooodt_pickup_location" value="20:00" style="width: 95%;" class="pro_only" /><div style="background-color:#ffa500;padding:2px;"><p style="margin-top: 6px;text-align: center; color: #000;font-weight:bold;font-size: 10px;margin-bottom: 6px;">Break Time</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][mon][break_start_time]" id="byconsolewooodt_pickup_location" value="14:30" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][mon][break_end_time]" id="byconsolewooodt_pickup_location" value="15:15" style="width: 95%;" class="pro_only" /></div></div>&nbsp;<div style="float: left;margin-left: 5px;"><input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][tue][service]" value="yes" style="margin-top: 10px;width: 5px;float:left;" class="pro_only"><p style="margin-top: 8px;">Tue</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][tue][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][tue][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><div style="background-color:#ffa500;padding:2px;"><p style="margin-top: 6px;text-align: center; color: #000;font-weight:bold;font-size: 10px;margin-bottom: 6px;">Break Time</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][tue][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][tue][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /></div></div>&nbsp;<div style="float: left;margin-left: 5px;"><input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][wed][service]" value="yes" checked="checked" style="margin-top: 10px;width: 5px;float:left;" class="pro_only"><p style="margin-top: 8px;">Wed</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][wed][start_time]" id="byconsolewooodt_pickup_location" value="09:00" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][wed][end_time]" id="byconsolewooodt_pickup_location" value="18:00" style="width: 95%;" class="pro_only" /><div style="background-color:#ffa500;padding:2px;"><p style="margin-top: 6px;text-align: center; color: #000;font-weight:bold;font-size: 10px;margin-bottom: 6px;">Break Time</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][wed][break_start_time]" id="byconsolewooodt_pickup_location" value="14:00" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][wed][break_end_time]" id="byconsolewooodt_pickup_location" value="15:00" style="width: 95%;" class="pro_only" /></div></div>&nbsp;<div style="float: left;margin-left: 5px;"><input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][thu][service]" value="yes" style="margin-top: 10px;width: 5px;float:left;" class="pro_only"><p style="margin-top: 8px;">Thu</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][thu][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][thu][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><div style="background-color:#ffa500;padding:2px;"><p style="margin-top: 6px;text-align: center; color: #000;font-weight:bold;font-size: 10px;margin-bottom: 6px;">Break Time</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][thu][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][thu][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /></div></div>&nbsp;<div style="float: left;margin-left: 5px;"><input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][fri][service]" value="yes" checked="checked" style="margin-top: 10px;width: 5px;float:left;" class="pro_only"><p style="margin-top: 8px;">Fri</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][fri][start_time]" id="byconsolewooodt_pickup_location" value="09:30" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][fri][end_time]" id="byconsolewooodt_pickup_location" value="19:30" style="width: 95%;" class="pro_only" /><div style="background-color:#ffa500;padding:2px;"><p style="margin-top: 6px;text-align: center; color: #000;font-weight:bold;font-size: 10px;margin-bottom: 6px;">Break Time</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][fri][break_start_time]" id="byconsolewooodt_pickup_location" value="13:30" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][fri][break_end_time]" id="byconsolewooodt_pickup_location" value="14:15" style="width: 95%;" class="pro_only" /></div></div>&nbsp;<div style="float: left;margin-left: 5px;"><input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][sat][service]" value="yes" style="margin-top: 10px;width: 5px;float:left;" class="pro_only" /><p style="margin-top: 8px;">Sat</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][sat][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][sat][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><div style="background-color:#ffa500;padding:2px;"><p style="margin-top: 6px;text-align: center; color: #000;font-weight:bold;font-size: 10px;margin-bottom: 6px;">Break Time</p><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][sat][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/><input type="time" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][sat][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /></div></div><p style="clear: both;background-color: #0000005c;color: #fff;width: 87%;font-weight: 600;padding: 5px 7px;font-size: 13px;text-align: center;">Please note - break time will be between start time and end time. If no break time then use same time i.e 2:00 P.M - 2:00 P.M</p><div style="float: left; clear:both; width:12%;display:none; "><p style="margin-top: 8px; text-transform:capitalize; margin-bottom: 8px;font-size: 10px;text-align: center; color: #2231ff;">Hours Limit</p><label style="float:left; padding:7px;">Limit</label><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][threshold_hours]" id="byconsolewooodt_pickup_location" value="" style="width: 50%;" class="pro_only" /></div><div style="float: left; width:12%;display:none;"><p style="margin-top: 8px; text-transform:capitalize; margin-bottom: 8px;font-size: 10px;text-align: center; color: #2231ff;">Minutes Limit</p><label style="float:left; padding:6px;">Limit</label><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][threshold_minutes]" id="byconsolewooodt_pickup_location" value="" style="width:50%; padding:7px;" class="pro_only" /></div><div style="float: left; width:32%;display:none;"><p style="margin-top: 8px; margin-bottom: 8px;font-size: 10px;text-align: center; color: #2231ff;">Orders Limit</p><label style="float:left; padding:7px;">order(s)</label><input type="text" name="byconsolewooodt_pickup_location['+byconsolewooodt_pickup_location_count+'][max_order_by_threshold_hours]" id="byconsolewooodt_pickup_location" value="" style="width: 50%;" class="pro_only" /><label style="padding:7px;"></label></div></div><div style="float: left; width:38%; padding-top:25px;display:none;"><p style="margin-top: 8px; text-transform:capitalize; margin-bottom: 8px;font-size: 10px;text-align: center; color: #2231ff;">In order to make this function work, please make sure "Limit [X] number of orders per [Y] hour(s)" has been checked on WooODT Features Settings page and <b style="color:#FF5722;">"Display time format as" is select as Fixed Time on ODT Management page.</b></p></div></fieldset><br />');
});
});
</script>
<?php 
//$byconsolewooodt_pickup_loacation= unserialize(get_option('byconsolewooodt_pickup_location'));
$byconsolewooodt_pickup_loacation_array= get_option('byconsolewooodt_pickup_location');
//print_r( $byconsolewooodt_pickup_loacation_array);
?>
<div style="width:100%;">
<div style="width: 8%;float: left;"><b>Disable</b></div>
<div class="location_lable" style="width: 16%;float: left;"><b>Location</b></div>
<div class="latitude_lable" style="width: 10%;float: left;"><b>Latitude</b></div>
<div class="longitude_lable" style="width: 11%;float: left;"><b>Longitude</b></div>
<div style="width: 11%;float: left;"><b>Start Time</b></div>
<div style="width: 10%;float: left;"><b>End Time</b></div>
<div style="width: 9%;float: left;"><b>Min Cart Price</b></div>
<div style="width: 8%;float: left;"><b>Shipping Cost</b></div>
<div><b>Email Id</b></div>
</div><br />
<?php
if(!empty($byconsolewooodt_pickup_loacation_array)){
$pickup_i=0;
$week_day_name_array = array("sun", "mon", "tue", "wed", "thu", "fri", "sat");
//echo '<pre>';
//print_r($byconsolewooodt_pickup_loacation_array);
//echo '</pre>';
	foreach ($byconsolewooodt_pickup_loacation_array as $pickup_loacation_single_array_key => $pickup_loacation_single_array_value)
	{
	//print_r($byconsolewooodt_pickup_loacation_single_array);	
//	print_r($pickup_loacation_single_array_key);
//	echo '<br />';
//	print_r($pickup_loacation_single_array_value);
//	echo '<hr />';
	//foreach($pickup_location_array_value as $pickup_location_single_array_key => $pickup_location_single_array_value)
	//{
	//print_r($pickup_location_single_array_value);
	foreach($pickup_loacation_single_array_value as $pickup_loacation_single_array_value_key_1 => $pickup_loacation_single_array_value_val_1)
	{
		//print_r($pickup_loacation_single_array_value_key_1);
		//echo '<hr />';
		//print_r($pickup_loacation_single_array_value_val_1);
	}


	if(!empty($pickup_loacation_single_array_value['week_day']))
	{
		$byconsolewoodt_weekday_name_array = $pickup_loacation_single_array_value['week_day'];
	}

	if(!empty($pickup_loacation_single_array_value['week_day_start_time']))
	{
		$byconsolewoodt_week_day_start_time_array = $pickup_loacation_single_array_value['week_day_start_time'];
	}

	if(!empty($pickup_loacation_single_array_value['week_day_end_time']))
	{
		$byconsolewoodt_week_day_end_time_array = $pickup_loacation_single_array_value['week_day_end_time'];
	}

	//print_r($byconsolewoodt_weekday_name_array);
	//print_r($byconsolewoodt_week_day_start_time_array);
	//print_r($byconsolewoodt_week_day_end_time_array);
	if(!empty($byconsolewoodt_week_day_start_time_array))
	{
		foreach($byconsolewoodt_week_day_start_time_array as $byconsolewoodt_week_day_start_time_single_array)
		{
			$byconsolewoodt_week_day_start_time_single_array; 
		}
	}
	?>

	<fieldset class="fldst pickup_location<?php echo $pickup_i;?>">
	<input type="checkbox" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][location_disable]" id="byconsolewooodt_pickup_location" class="pro_only" 
	<?php if(!empty($pickup_loacation_single_array_value['location_disable']))
		  {
				if($pickup_loacation_single_array_value['location_disable']=='on') {?> checked="checked" <?php } 
		  }
	?>  style="float: left;margin-top: 10px;width: 5px;" />

	<input type="text" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][location]" id="byconsolewooodt_pickup_location" class="byconsolewooodt_pickup_location<?php echo $pickup_i;?>" value="<?php echo $pickup_loacation_single_array_value['location'];?>" style="width:20%; padding:7px;" onchange="location_finder(this)"/>

     <input type="text" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][address_latitude]" id="byconsolewooodt_pickup_location" class="byconsolewooodt_pickup_location_address_latitude" value="" readonly="readonly" style="width:10%; padding:7px;" />

    <input type="text" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][address_longitude]" id="byconsolewooodt_pickup_location" class="byconsolewooodt_pickup_location_address_longitude" value=""  readonly="readonly" style="width:10%; padding:7px;" />

	<input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][start_time]" id="byconsolewooodt_pickup_location" value="" style="width:10%; padding:7px;" class="pro_only" />

	<input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][end_time]" id="byconsolewooodt_pickup_location" value="" style="width:10%; padding:7px;" class="pro_only" />

	<input type="text" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][min_cart_value]" id="byconsolewooodt_pickup_location" value="" style="width:8%; padding:7px;" class="pro_only" />

    <input type="text" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][shipping_cost]" id="byconsolewooodt_pickup_location" value="" style="width:8%; padding:7px;" class="pro_only" />

     <input type="text" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][email_id_on_each_location]" id="byconsolewooodt_pickup_location" class="email_field pro_only" value="" style="width:14%; padding:7px;" />

    <span  id="del_pickup" class="pickup_location<?php echo $pickup_i; ?>">X</span>
	<br />

			<div style="float: left;">
    <input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][sun][service]" value="" style="margin-top: 10px;width: 5px;float:left;" class="pro_only" />
         <p style="margin-top: 8px; text-transform:capitalize;">Sun</p>
            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][sun][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>
            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][sun][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />
	<div style="background-color:#ffa500;padding:2px;">
             <p style="margin-top: 8px; text-transform:capitalize; margin-bottom: 8px;font-size: 10px;text-align: center; color: #000; font-weight:bold;">Break Time</p>
            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][sun][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>
            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][sun][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />
	</div>
            </div>

		<div style="float: left;">
    <input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][mon][service]" value="" style="margin-top: 10px;width: 5px;float:left;" class="pro_only" />

         <p style="margin-top: 8px; text-transform:capitalize;">Mon</p>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][mon][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>
            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][mon][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />
          
<div style="background-color:#ffa500;padding:2px;">

            <p style="margin-top: 8px; text-transform:capitalize; margin-bottom: 8px;font-size: 10px;text-align: center; color: #000; font-weight:bold;">Break Time</p>





            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][mon][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>





            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][mon][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />

</div>



            





            </div>



		<div style="float: left;">

    <input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][tue][service]" value="" style="margin-top: 10px;width: 5px;float:left;" class="pro_only" />


         <p style="margin-top: 8px; text-transform:capitalize;">Tue</p>


            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][tue][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][tue][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />





            



<div style="background-color:#ffa500;padding:2px;">

            <p style="margin-top: 8px; text-transform:capitalize; margin-bottom: 8px;font-size: 10px;text-align: center; color: #000; font-weight:bold;">Break Time</p>





            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][tue][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>





            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][tue][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />

</div>




            </div>



    <div style="float: left;">

    <input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][wed][service]" value="" style="margin-top: 10px;width: 5px;float:left;" class="pro_only" />

         <p style="margin-top: 8px; text-transform:capitalize;">Wed</p>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][wed][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][wed][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />


<div style="background-color:#ffa500;padding:2px;">

            <p style="margin-top: 8px; text-transform:capitalize; margin-bottom: 8px;font-size: 10px;text-align: center; color: #000; font-weight:bold;">Break Time</p>





            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][wed][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>





            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][wed][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />

</div>



            





         </div>






	<div style="float: left;">

    <input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][thu][service]" value="" style="margin-top: 10px;width: 5px;float:left;" class="pro_only" />

         <p style="margin-top: 8px; text-transform:capitalize;">Thu</p>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][thu][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][thu][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />


<div style="background-color:#ffa500;padding:2px;">

            <p style="margin-top: 8px; text-transform:capitalize; margin-bottom: 8px;font-size: 10px;text-align: center; color: #000; font-weight:bold;">Break Time</p>





            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][thu][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>





            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][thu][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />

</div>



            





            





           </div>






    	<div style="float: left;">	

    <input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][fri][service]" value="" style="margin-top: 10px;width: 5px;float:left;" class="pro_only" />

         <p style="margin-top: 8px; text-transform:capitalize;">Fri</p>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][fri][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][fri][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />

        



<div style="background-color:#ffa500;padding:2px;">

            <p style="margin-top: 8px; text-transform:capitalize; margin-bottom: 8px;font-size: 10px;text-align: center; color: #000; font-weight:bold;">Break Time</p>





            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][fri][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][fri][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />

</div>

            </div>





    <div style="float: left;">

		 <input type="checkbox" id="byconsolewooodt_pickup_location" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][sat][service]" value="" style="margin-top: 10px;width: 5px;float:left;" class="pro_only" />

         <p style="margin-top: 8px; text-transform:capitalize;">Sat</p>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][sat][start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][sat][end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />

<div style="background-color:#ffa500;padding:2px;">

            <p style="margin-top: 8px; text-transform:capitalize; margin-bottom: 8px;font-size: 10px;text-align: center; color: #000; font-weight:bold;">Break Time</p>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][sat][break_start_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" /><br/>

            <input type="time" name="byconsolewooodt_pickup_location[<?php echo $pickup_loacation_single_array_key;?>][sat][break_end_time]" id="byconsolewooodt_pickup_location" value="" style="width: 95%;" class="pro_only" />

</div>
            </div>

	<p style="clear: both;background-color: #0000005c;color: #fff;width: 84%;font-weight: 600;padding: 5px 7px;font-size: 13px;text-align: center;">Please note - break time will be between start time and end time. If no break time then use same time i.e 2:00 P.M - 2:00 P.M</p>

    <div style="float: left; clear:both; width:12%;display:none;">

</div>

<div style="float: left; width:12%;display:none;">

</div>


<div style="float: left; width:32%;display:none;">

</div>

<div style="float: left; width:38%; padding-top:25px;display:none;">
</div>

	</fieldset><br />

	<?php 

	$pickup_i++;

	echo '<div class="after_location_field" style="border: 1px dotted #ccc;margin-bottom: 30px; margin-top: 15px;width: 90%;"></div>';
	}

}
?>

<div class="pickup_options">
</div>  
<fieldset class="fldst">
<input type="button" id="btn_pickup_add_another" value="Add another" class="" />
</fieldset>
<?php
}
?>