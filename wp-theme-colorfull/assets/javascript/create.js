$(".create__form__section--items li").click(function(e) {
  e.preventDefault();
  
  var _check = $(this).find("input");
  var checked = _check.is(":checked");

  if($(this).parent().parent().hasClass("create__form__time")) {
    $(".create__form__time input").each(function() {
      $(this).prop("checked", false);
    });

    if(!checked) _check.prop("checked", true);

    return;
  }

  if($(e.target).is("input")) return;

  if(checked) _check.prop("checked", false);
  else _check.prop("checked", true);
});

$("#create-my-journey").click(function(e) {
  e.preventDefault();

  var create_detalle;
  var create_region = "", create_trip = "", create_time = "";

  //Revisar las regiones
  $(".create__form__region li").each(function() {
    if($(this).find("input").is(":checked")) {
      if(create_region == "") create_region = "<h2>Region</h2>";
      create_region += ("<h3>♦ " + $(this).find(".create__form__item--datos h3").html() + "</h3>");
    }
  });

  //Revisar los tipos de viaje
  $(".create__form__trip li").each(function() {
    if($(this).find("input").is(":checked")) {
      if(create_trip == "") create_trip = "<h2>Type of Trip</h2>";
      create_trip += ("<h3>♦ " + $(this).find(".create__form__item--datos h3").html() + "</h3>");
    }
  });

  //Revisas el tiempo idk
  $(".create__form__time li").each(function() {
    if($(this).find("input").is(":checked")) {
      if(create_time == "") create_time = "<h2>Time</h2>";
      create_time += ("<h3>♦ " + $(this).find(".create__form__item--datos h3").html() + "</h3>");
    }
  });

  create_detalle = create_region + create_trip + create_time;

  $(".form-contenido-hid").val(create_detalle);
  $(".create__form--form form").submit();
});
