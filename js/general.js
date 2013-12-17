$(document).ready(function() {
	$("input[name='address_same_as_billing'").click(function() {
		if ($('#address_same_as_billing').is(":checked"))
		{
			$("#shipping_address").hide(500);
		}
		else
		{
			$("#shipping_address").show(500);
		}
	});
	$("#form_submit").validate({
	  rules: {
	    first_name: "required",
	    last_name: "required",
	    address: "required",
	    city: "required",
	    state: {
	    	required: true,
	    	maxlength: 2
	    },
	    zip: {
	    	required: true,
	    	maxlength: 5
	    },
	    phone: {
	    	required: true,
	    	maxlength: 10
	    },
	    email: {
	      required: true,
	      email: true
	    },
	    shipping_first_name: "required",
	    shipping_last_name: "required",
	    shipping_address: "required",
	    shipping_city: "required",
	    shipping_state: {
	    	required: true,
	    	maxlength: 2
	    },
	    shipping_zip: {
	    	required: true,
	    	maxlength: 5
	    },
	    shipping_phone: {
	    	required: true,
	    	maxlength: 10
	    },
	    shipping_email: {
	      required: true,
	      email: true
	    }
	  },
	  messages: {
	    first_name: "What is your first name?",
	    last_name: "What is your last name?",
	    address: "What is your address?",
	    city: "What city do you live in?",
	    state: {
	      required: "What is your 2 digit state code?",
	      maxlength: "The maximum length for this code is 2."
	    },
	    zip: {
	      required: "What is your zip code?",
	      maxlength: "The maximum length for this code is 5."
	    },
	    phone: {
	      required: "What is your phone number?",
	      maxlength: "The maximum length for this code is 10."
	    },
	    email: {
	      required: "We need your email address to contact you",
	      email: "Your email address must be in the format of name@domain.com"
	    },
	    shipping_first_name: "What is your first name?",
	    shipping_last_name: "What is your last name?",
	    shipping_address: "What is your address?",
	    shipping_city: "What city do you live in?",
	    shipping_state: {
	      required: "What is your 2 digit state code?",
	      maxlength: "The maximum length for this code is 2."
	    },
	    shipping_zip: {
	      required: "What is your zip code?",
	      maxlength: "The maximum length for this code is 5."
	    },
	    shipping_phone: {
	      required: "What is your phone number?",
	      maxlength: "The maximum length for this code is 10."
	    },
	    shipping_email: {
	      required: "We need your email address to contact you",
	      email: "Your email address must be in the format of name@domain.com"
	    }
	  }
	});
}); // end ready