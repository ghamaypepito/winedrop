	jQuery(document).ready(function($){
			var btn = jQuery(".button-update-settings");
			var form = jQuery("#convert_plug_settings");
			btn.click(function() {
				var security = jQuery("#cplus_maxmind_nonce").val();
				var ser  = jQuery("[name]").serialize() + '&security_nonce='+ security;
				var data = ser;
				var action = 'cplus_maxmind';
					jQuery.ajax({
					url: ajaxurl,
					action: action,
					data: data,
					dataType: 'JSON',
					type: 'POST',
					success: function(result){
						if(result.message == "Settings Updated!"){
							swal({
								title: "Updated!",
								type: "success",
								text: result.message
							});
							setTimeout(function(){
								window.location = window.location;
							},500);
						} else {
							swal({
								title:"Error!",
								type: "error",
								text: result.message
							});
						}
					}
				});
			});
		});
