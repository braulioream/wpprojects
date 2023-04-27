jQuery(document).ready(function($){
  $('.slider__principal--pitcher').on('init', function(e, slick) {
    $('.slick-slide').addClass('active')
  });
  $('.slider__principal--pitcher').on('beforeChange', function(e, slick, currentSlide, nextSlide) {
    // console.log('hola')
  });
  if(true) {
  $('.slider__principal--pitcher').slick({
    infinite: true,
    speed: 1000,
    fade: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    margin: 0,
    arrows: true,
    autoplay: true,
    autoplaySpeed: 1300,
    dots: false
  });
  }

  $(".servicio__destination ul").slick({
    centerMode: true,
    slidesToShow: 1,
    centerPadding: '200px',
    lazyLoad: "progressive",
    responsive: [
    {
      breakpoint: 1025,
      settings: "unslick"
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
    ]
  });
  $(".servicio__test--testimonials ul").slick({
    autoplay: true,
    autoplaySpeed: 2500,
    pauseOnHover: true
  });
});
$('.servicio__destination ul').on('click', '.slick-slide', function (e) {
    e.stopPropagation();
    var index = $(this).data("slick-index");
    if ($('.servicio__destination ul').slick('slickCurrentSlide') !== index) {
      $('.servicio__destination ul').slick('slickGoTo', index);
    }
  });