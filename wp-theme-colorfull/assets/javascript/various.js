$(document).on("click","body .btnFilter",function(){
  $([document.documentElement, document.body]).animate({
    scrollTop: $("#filter_box").offset().top - 90
  }, 1000);

  $(this).parent().siblings().find('p.btnFilter').removeClass('colors');
  $(this).toggleClass("colors");
  $(".filter__item__ctn").removeClass('active');
  $(this).next('.filter__item__ctn').toggleClass("active");
  if ( $(this).hasClass( "colors" ) ) {
    $(".overlay__filter").addClass("active");
    $(".ctn__filters__items .filter__item__parraf").addClass("active");
    $("body").addClass("active");
  }
  else{
    $(".overlay__filter").removeClass("active");
    $(".ctn__filters__items .filter__item__parraf").removeClass("active");
    $("body").removeClass("active");
    $(".filter__item__ctn").removeClass('active');
  }
});

$(".overlay__filter").click(function(event) {
  $("body").removeClass("active");
  $(this).removeClass("active");
  $(".filter__item__ctn").removeClass("active");
  $(".ctn__filters__items .filter__item__parraf").removeClass("active");
  $(".btnFilter").removeClass("colors");

  $(".btn__filter .btnSubmit")[0].click();
});

$(".btnMap").click(function(event) {
  $(this).toggleClass("colors");
  $(".destinos__map").toggleClass("active");
  $('.ctn__items__gnral__wrap__sec').toggleClass('active');
  $('.ctn__items__gnral__wrap').addClass('active');
  if ( $(this).hasClass( "colors" ) ) {
      $(this).find(".filter__item__parraf").text( "Hide Map" );
    } else {
      $(this).find(".filter__item__parraf").text( "Show Map" );
    } 
});

if (!jQuery(".filter__item__list li input").is(":checked")) {
    
}
else{
   $(this).closest('.filter__item').find('.filter__item__parraf').removeClass('colorsTwo activeTwo');
}

$(".npeople input").focus(function() {
  $(this).attr("placeholder", "");
});

$(".npeople input").focusout(function() {
  $(this).attr("placeholder", "# of adults");
});

$(".nchildren input").focus(function() {
  $(this).attr("placeholder", "");
});

$(".nchildren input").focusout(function() {
  $(this).attr("placeholder", "# of children");
});
