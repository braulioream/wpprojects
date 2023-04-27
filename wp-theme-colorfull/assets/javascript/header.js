//clone div's desktop to menu responsive 
	$('.header__list').clone().appendTo('.header__sidebar__nav').addClass('header__list__responsive').removeClass('header__list');
	$('.header__logo').clone().prependTo('.header__sidebar__container').removeClass('header__logo').addClass('header__logo__responsive');


	$('.header__sidebar__menu').click(function(event) {
		$('.header__sidebar').addClass('active');
		$('body').addClass('active');
	});

	$('.header__sidebar__close').click(function(event) {
		$('.header__sidebar').removeClass('active');
		$('body').removeClass('active');
	});


	// header scroll
	var altoScroll = 0
	$(window).scroll(function() {
		var iCurScrollPos = $(this).scrollTop();
		if (iCurScrollPos > altoScroll) {
			$('.header__wrap').addClass('header--scrolling');
		}else{
			$('.header__wrap').removeClass('header--scrolling');
		}
		altoScroll = iCurScrollPos;
	});


if ($("body").hasClass("logged-in")){
	$('html').addClass('wp-admin-add')
}