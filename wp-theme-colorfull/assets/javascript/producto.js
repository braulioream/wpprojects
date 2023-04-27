var len = $('.detail_y__images figure').length;
var i = 0;
var items_per_line = 7;
var div = 10;

if (window.matchMedia("(max-width: 1024px)").matches) {
	var wwidth = jQuery(window).width();

	items_per_line = Math.floor((wwidth - 50) / 56);
	div = 7;
}

var postlen = len - items_per_line;
var n_row = parseInt(Math.ceil(postlen / div));

if(len > items_per_line){
	$('.detail_y__images').addClass('active');
	$('.detail_y__images').find('figure').each(function(){
		$('.detail_y__images figure').slice(items_per_line).appendTo('.detaill__box__ctn');
		$('.detaill__punts').addClass('active');
	});

	if(false)
	$(".detaill__box__ctn").slick({
	  speed: 2000,
	  slidesToShow: 5,
	  slidesToScroll: 1,
	  margin: 0,
	  arrows: false,
	  autoplay: true,
	  autoplaySpeed: 1300,
	  dots: false
	});
}
$('.detaill__punts').click(function(event) {
	$('.detaill__box').toggleClass('active');
});

$("input[name=date-from]").change(function() {
  var t = $(this).val();
  //++t;
  $("input[name=date-to]").val(t);
  //.stepUp(1)
  document.getElementsByName("date-to")[0].stepUp(1);
});

$(".detaill__box").css("bottom", (-50 * n_row) + "px");
$(".detaill__box__ctn").css("height", (50 * n_row) + "px");
