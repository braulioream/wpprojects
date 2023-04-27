// code main
AOS.init({
	duration: 300,
	easing: 'ease-in-sine',
	delay: 50
});
$('.navScroll').click(function() {
	if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')&& location.hostname == this.hostname) {
		var $target = $(this.hash);
		$target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
		if ($target.length) {
		var targetOffset = $target.offset().top -80;
		$('html,body').animate({scrollTop: targetOffset}, 1000);
		return false;
		}
	}
});
function medidas(){ 
	$('.js-bg').each(function(index, el) {
		var urlimg = $(this).attr('data-img');
		var img = urlimg.split(';');

		var screen = $(window).width();
		var bgi = 'background-image:url(';
		var cierre = ')';

		if (screen > 1024) {
			$(el).attr('style', bgi+img[0]+cierre);
		};

		if (screen <= 1024) {
			$(el).attr('style', bgi+img[1]+cierre);
		};

		if (screen <= 767) {
			$(el).attr('style', bgi+img[2]+cierre);
		};
	});
};
medidas();
$(window).resize(function(event) {
	medidas();
});
