jQuery(document).ready(function() {

jQuery(document).on("click", "#add_customer_to_register", function() {
	setTimeout(function() {
		jQuery('#customer_details .woocommerce-shipping-fields .validate-required input, ' +
					'#customer_details .woocommerce-shipping-fields .validate-required select, ' +
					'#custom-shipping-shippingaddress .validate-required input, ' + 
					'#custom-shipping-shippingaddress .validate-required select').each(function() {
			jQuery(this).addClass("select2-offscreen");
		});
		console.log("done");
	}, 2000);
});

});