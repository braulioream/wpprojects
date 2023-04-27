// $(document).on('click','body .btnFilter',function(){
//   $([document.documentElement, document.body]).animate({
//     scrollTop: $("#filter_box").offset().top
//   }, 2000);

// 	$('body').toggleClass('active');
// 	$('.overlay__filter').toggleClass('active');
// 	$(this).find('.filter__item__ctn').toggleClass('active');
// 	$('.ctn__filters__items .filter__item__parraf').toggleClass('active');
// 	$(this).toggleClass('colors');
// });

// $('.overlay__filter').click(function(event) {
// 	$('body').removeClass('active');
// 	$(this).removeClass('active');
// 	$('.filter__item__ctn').removeClass('active');
// 	$('.ctn__filters__items .filter__item__parraf').removeClass('active');
// 	$('.btnTrip').removeClass('colors');
// });

// $('.btnMap').click(function(event) {
// 	$(this).toggleClass('colors');
// 	$('.destinos__map').toggleClass('active');
// 	if ( $(this).hasClass( "colors" ) ) {
//     	$(this).find('.filter__item__parraf').text( "Hide Map" );
//   	} else {
//     	$(this).find('.filter__item__parraf').text( "Show Map" );
//   	}	
// });