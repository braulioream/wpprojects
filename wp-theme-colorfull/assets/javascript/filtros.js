$(".btn__filter .btnSubmit").click(function(e) {
  e.preventDefault();

  var params = "";

  var precios = "";

  $(".filter__item__ctn form").each(function() {
    var param = "";
    var taxo_name = $(this).attr("data-taxo");
    // console.log("Taxonomy name: " + taxo_name);

    $(this).find("input").each(function() {
      if($(this).is(":checked")) {
        // console.log($(this).prop("outerHTML"));
        if(param == "") param = (taxo_name + "=");
        else param += ",";

        param += $(this).val();
      }
    });

    if(param != "") {
      if(params == "") params = "?";
      else params += "&";

      params += param;
      $(this).parent().siblings("p").addClass('colorsTwo activeTwo');
    } else {
      $(this).parent().siblings("p").removeClass('colorsTwo activeTwo');
    }
  });

  if(params == "" || true) {
    if($("#slider-range").length) {
      /*var cad = $(".ui-slider-range").attr("style");
      var reg = /[0-9\.]+(?=%)/g;
      var coinc = cad.match(reg);
      var precio_menor =  parseInt(parseFloat(coinc[0]) * 50), precio_mayor = parseInt((parseFloat(coinc[0]) + parseFloat(coinc[1])) * 50);*/
      var values = $("#slider-range").slider("option", "values");
      var precio_mayor = values[1];
      var precio_menor = values[0];

      var curr_precio_mayor = $("#slider-range").slider("option", "max");
      var curr_precio_menor = $("#slider-range").slider("option", "min");

      // alert("[" + curr_precio_menor + "|" + precio_menor + ":" + precio_mayor + "|" + curr_precio_mayor + "]");

      if(precio_mayor != curr_precio_mayor || precio_menor != curr_precio_menor) {
        precios = "price=" + precio_menor + "," + precio_mayor;
        // alert(precios);
        $("#select_price_filter").addClass('colorsTwo activeTwo');
      }
      else jQuery("#select_price_filter").removeClass("colorsTwo activeTwo");
    }
  }

  if(precios != "") {
    if(params == "") params = "?";
    else params += "&";
    params += precios;
  }

  if(params != "") {
    var url = window.location.href.split('?')[0] + params;
    //window.location.href = url;
    history.pushState("test", "", url);
  } else {
    //window.location.href = window.location.href.split('?')[0];
    history.pushState("test", "", window.location.href.split('?')[0]);
  }

  $("body").removeClass("active");
  $(".overlay__filter").removeClass("active");
  $(".filter__item__ctn").removeClass("active");
  $(".ctn__filters__items .filter__item__parraf").removeClass("active colors");
  //$(this).closest('.filter__item').find('.filter__item__parraf').addClass('colorsTwo activeTwo');
  //Limpiar el campo idk jeje
  $(window.contenedor).html("");
  $(contenedor).append('<div class="loading-results"><span class="dashicons dashicons-image-rotate"></span></div>');
  // $(contenedor).append('<div class="no_results"><span class="loading--rotate"><img src="http://cf.staffdigitalw.com/wp-content/themes/wp-theme-colorfull/assets/images/loading.png" alt="" /></span></div>');
  //Set variables
  hay_param = (params == "")? false : true;
  global_param = (params == "")? "" : params.substring(1);
  search_term = "";
  cont = 1;

  jQuery(".search_results--box").remove();

  var __aux = hay_param? 1 : 2;

  append_posts(n_post_request, __aux);
});

$('.filter__item__list label').click(function() {
  if($('.filter__item__list input').is(':checked')) {
    $(this).closest('.filter__item').find('.filter__item__parraf').removeClass('colorsTwo');
  }
});

$(".ctn__search input").on('keyup', function (e) {
  if (e.keyCode == 13) {
    var busqueda = $(this).val();
    if(busqueda == "") return;

    $(".filter__item__ctn form input").each(function() {
      $(this).prop("checked", false);
    });

    var url = window.location.href.split('?')[0] + "?search=" + busqueda;
    history.pushState("test", "", url);

    //Limpiar el campo idk jeje
    $(window.contenedor).html("");
    //Set variables
    hay_param = false;
    global_param = "";
    search_term = busqueda;
    cont = 1;

    append_posts(n_post_request);

    $(".filter__item__parraf").removeClass('colorsTwo activeTwo');
    search_results(busqueda);
  }
});

$(".ctn__search__button").click(function() {
  var busqueda = $(this).siblings("input").val();
  if(busqueda == "") return;

  $(".filter__item__ctn form input").each(function() {
    $(this).prop("checked", false);
  });


  var url = window.location.href.split('?')[0] + "?search=" + busqueda;
  history.pushState("test", "", url);

  //Limpiar el campo idk jeje
  $(window.contenedor).html("");
  //Set variables
  hay_param = false;
  global_param = "";
  search_term = busqueda;
  cont = 1;

  $(".filter__item__parraf").removeClass('colorsTwo activeTwo');
  append_posts(n_post_request);
  search_results(busqueda);
});

$(".ctn__items__gnral").on("click", ".search_results--box a, .no_results a", function(e) {
  e.preventDefault();

  hay_param = false;
  global_param = "";
  search_term = "";
  cont = 1;
  $(".ctn__search input").val("");

  var url = window.location.href.split('?')[0];
  history.pushState("test", "", url);

  $(".filter__item__parraf").removeClass('colorsTwo activeTwo');
  $(window.contenedor).html("");
  append_posts(n_post_request, 2);
  jQuery(".search_results--box").remove();
});
