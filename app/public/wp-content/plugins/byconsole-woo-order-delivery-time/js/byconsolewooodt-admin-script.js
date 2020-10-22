function locationDelete(str){
	alert(str);
	jQuery('fieldset.'+str).remove();
	}

jQuery(document).on('click','#del_pickup_custom_slot',function(e){

 var alert_confirmation = confirm("Do you want to remove it.");

	if (alert_confirmation == true) {

		var custom_slot_to_remove=jQuery(this).parent().prop('className');

		//alert(custom_slot_to_remove);

		jQuery("div."+custom_slot_to_remove).remove();

	} else {	

	}

});


jQuery(document).on('click','#del_pickup',function(e){

 var alert_confirmation = confirm("If any order was placed for this location in past, may not be able to show location any more for that particular order.");

	if (alert_confirmation == true) {
		var plickup_location_to_remove=jQuery(this).attr("class");
		jQuery('fieldset.'+plickup_location_to_remove).remove();
	} else {		
	}
	})	
	
jQuery(document).on('focusout','.pro_only',function(e){
jQuery(this).val('');
if(jQuery(this).is(':checked')){
	jQuery(this).prop('checked',false);
	}
	})

jQuery(document).on('click','.pro_only',function(e){

 var alert_confirmation = confirm("This functionality is available in pro version only. Click OK to check pro version & CANCEL to dismis");

	if (alert_confirmation == true) {
		window.open('https://www.plugins.byconsole.com/product/byconsole-wooodt-extended/', '_blank');
	} else {		
	}
	})