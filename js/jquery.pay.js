jQuery( document ).ready(function() {

    	enable();
    	auth_check_typeofpay();
    	auth_check_recurring();
    	front_recurring_check();

	    jQuery('#cardNo1').keyup(function() {
		  var foo = jQuery(this).val().split(" ").join("");
		  if (foo.length > 0) {
		    foo = foo.match(new RegExp('.{1,4}', 'g')).join(" ");
		  }
		  jQuery(this).val(foo);
		});

		jQuery('#cardNo2').keyup(function() {
		  var foo = jQuery(this).val().split(" ").join("");
		  if (foo.length > 0) {
		    foo = foo.match(new RegExp('.{1,4}', 'g')).join(" ");
		  }
		  jQuery(this).val(foo);
		});

		jQuery(".auth_renew_length").keyup(function() {
          	var min = 7;
          	if(Math.floor(jQuery(this).val()) == jQuery(this).val() && jQuery.isNumeric(jQuery(this).val()))
          	{
	          	if (jQuery(this).val() < min)
	          	{
	              	jQuery(this).val(min);
	              	return false;
	          	} 
	        }
	        else{
	        	jQuery(this).val(min);
	            return false;
	        }      
        }); 
			
});
function auth_check_typeofpay(){
	var typeofpay = jQuery("#auth_typeofpay").val();
	var auth_renewlength_set_by = jQuery("#auth_renewlength_set_by").val();

	if(typeofpay != 'onetime' && auth_renewlength_set_by == 'admin'){
		jQuery("#auth_recurring_settings").show();
	}
	else{
		jQuery("#auth_recurring_settings").hide();
	}
}

function auth_check_recurring(){
	var typeofpay = jQuery("#auth_typeofpay").val();

	if(typeofpay != 'onetime'){
		jQuery("#auth_renewlength_set").show();
	}
	else{
		jQuery("#auth_renewlength_set").hide();
	}
	auth_check_typeofpay();
}
function front_recurring_check(){
	var type_of_pay = jQuery("#type_of_pay").val();
	if(type_of_pay != 'one_time'){
		jQuery("#auth_recurring_details").show();
		jQuery("#auth_onetime_details").hide();
	}
	else{
		jQuery("#auth_recurring_details").hide();
		jQuery("#auth_onetime_details").show();
	}
}

function enable()
{
	jQuery("#paypal").hide();
	jQuery("#authorize").hide();
	var yourSelect = jQuery( "#choosePayment" );
	var selectItem = jQuery("#choosePayment").val();
	jQuery("#"+selectItem).show();
}






