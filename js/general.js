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
}); // end ready