$('.input__g__inside input, .input__g__inside textarea, .input__g__inside select, .input__g__inside label').focusin(function() {
	$(this).parent().parent().addClass('active');
});

$('.input__g__inside input, .input__g__inside textarea, .input__g__inside select, .input__g__inside label').focusout(function() {
	if ($(this).val() === "") {
		$(this).parent().parent().removeClass('active');
	};
});

$('.input__g__inside input, .input__g__inside textarea, .input__g__inside select, .input__g__inside label').each(function() {
	if ($(this).val() != "") {
		$(this).parent().parent().addClass('active');
	};
});