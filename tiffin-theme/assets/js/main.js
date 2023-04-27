var _MAP;
var _MAP_AUTO;
var _MAP_MARKERS = {}, _MARKER_COUNT = 0;

jQuery(document).ready(function($) {
	/* header */
	var deliverymap = document.getElementById("tiffin--deliverymap");

	if(deliverymap) {
		_MAP = new google.maps.Map(deliverymap, {
			center: {lat: 49.2066305, lng: -123.0999047},
			zoom: 17,
		});
	}

	$(document).on("click", ".tiffin__deliverymap--header h2", function() {
		var type = $(this).data("type");

		if(type == "deliver") {
			$(".tiffin__deliverymap--pickup").hide();
			$(".tiffin__deliverymap--addresses").show();
		} else if(type == "pickup") {
			$(".tiffin__deliverymap--addresses").hide();
			$(".tiffin__deliverymap--pickup").show();
		}

		$(".tiffin__deliverymap--header h2").removeClass("active");
		$(this).addClass("active");
	});

	$(".tiffin__build__close").click(function() {
		// alert("jeje");
		$(".tiffin__build--header").addClass("closed");

		setTimeout(function() {
			$(".tiffin__build--header").remove();
		}, 750);
	});

	/* end header */

	var base_price;

	if($("#base_price").length > 0) {
		base_price = parseFloat($("#base_price").data("price"));
	} else base_price = 0.0;

	// Add to cart action
	$(document).on("click", ".ondemand_addtocart", function(e) {
		e.preventDefault();

		$(this).find("a").html(tiffin_loading());

		var aux = $(this).data("modalid");
		var $this_modal = $("#" + aux);

		var data = {};
		var options_error = false;

		data["secret"] = tiffin_js.tiffin_wp_nonce;
		data["quantity"] = $this_modal.find(".tiffin__modal--qty input").val();

		if($this_modal.find("h2.maindish").length > 0) {
			data["main_dish"] = $this_modal.find("h2.maindish").data("maindish");
		} else data["main_dish"] = "";

		//Get all IDs
		if(false) {
			$(".tiffin__buildoptions--section").each(function() {
				var section_id = $(this).data("extraname");
				var section_name = $(this).data("extrasectionname");
				var section_selected = [];

				var maxitems = parseInt($(this).find("ul").data("maxitems"));

				$(this).find("li.selected").each(function() {
					var itemid = $(this).data("itemid");

					section_selected.push(itemid);
				});

				if(section_selected.length == 0) {
					if(maxitems == 1 && !options_error) {
						options_error = true;
						alert("Please select all the required options.");
					}
				} else if(section_selected.length > 0) {
					data[section_id] = {
						"section_name": section_name,
						"items": section_selected,
					};
				}
			});
		}

		$this_modal.find(".tiffin__modal--section").each(function() {
			var section_id = $(this).data("extraname");
			var section_name = $(this).data("extrasectionname");
			var section_selected = [];

			$(this).find(".tiffin__modal__item").each(function() {
				var item_id = $(this).data("itemid");
				var item_name = $(this).find(".tiffin__modal__item--name").html();

				if($(this).find(".tiffin__modal__options").length > 0) { //No variations
					//Was it selected?
					var item_value = $(this).find(".tiffin__ctrl--check.selected");
					if(item_value.length > 0) {
						section_selected.push({
							"item_id": item_id,
							"variation_id": "0",
						});
					}
				} else { //With Variations
					var variation_id = $(this).find(".tiffin__modal__qty--options .selected").data("variation");
					section_selected.push({
						"item_id": item_id,
						"variation_id": variation_id,
					});
				}
			});

			if(Array.isArray(section_selected) && section_selected.length > 0) {
				data[section_id] = {
					"section_name": section_name,
					"items": section_selected,
				};
			}
		});

		console.log(data);return;

		$.ajax({
			"url": tiffin_js.ajax_url,
			"data": {
				"action": "new_ondemand_order",
				"items": data,
			}, success: function(msg) {
				// console.log(msg);
				// alert(tiffin_js.tiffin_cart);
				if(msg.trim() == "OK") {
					// location.reload();
					window.location = window.location.href
					// window.location.href = tiffin_js.tiffin_cart;
				}
			}
		});
	});

	// Smooth Scroll
	$("span.scrollto").click(function(event) {
		var target_id = $(this).data("optionis");
		var target = $("div[data-extraname='" + target_id + "']");

		$("html, body").animate({
			scrollTop: target.offset().top - 80
		}, 1000);
	});

	//Food Categories filter

	$(document).on("click", ".food_categories--option", function() {
		var slug = $(this).data("fcslug");

		if($(this).hasClass("active")) {
			$(this).removeClass("active");
			$(".dish").show();
		} else {
			$(".food_categories--option").removeClass("active");
			$(this).addClass("active");
			$(".dish").hide();
			$(".dish.fc-" + slug).show();
		}
	});

	// checkout
	$(document).on("click", ".tip_to_click", function() {
		var tip_value = jQuery(this).data("tipvalue");

		if($(this).hasClass("selected")) tip_value = 0;

		$(".fee .amount").html(tiffin_loading());
		$(".order__customtip--wrapper").addClass("_hidden");

		$.ajax({
			"url": tiffin_js.ajax_url,
			"data": {
				"action": "tiffin_updatecustomtip",
				"tip_value": tip_value,
				"tip_type": "percentage",
			}, success: function(msg) {
				// console.log(msg);
				if(msg == "OK") {
					setTimeout(function() {
						$("body").trigger("update_checkout");
					}, 1000);
				}
			}
		});
	});

	$(document).on("click", ".order__customtip", function() {
		var $el = $(".fee .amount");
		if($el.hasClass("tipform")) return;

		$(".order__customtip--wrapper").addClass("_hidden");

		// $el.addClass("tipform");
		$el.find("span").remove();
		var price = parseFloat($el.html());

		var ntf = "<form id='newtipform'>"; //New Tip Form
		ntf += "<input name='tip_value' value='" + price + "' />";
		ntf += "<select name='tip_type'>";
		ntf += "<option value='dollar' selected>$</option>";
		ntf += "<option value='percentage'>%</option>";
		ntf += "</select>";
		ntf += "<input type='submit' value='OK'>";
		ntf += "</form>";

		$el.parent().append(ntf);
		$el.addClass("_hidden");
	});

	$(document).on("submit", "#newtipform", function(e) {
		e.preventDefault();


		var tip_value = $(this).find("[name='tip_value']").val();
		var tip_type = $(this).find("[name='tip_type'] :selected").val();
		$("#newtipform").html(tiffin_loading());

		if(tip_value === "") tip_value = 0;

		$.ajax({
			"url": tiffin_js.ajax_url,
			"data": {
				"action": "tiffin_updatecustomtip",
				"tip_value": tip_value,
				"tip_type": tip_type,
			}, success: function(msg) {
				// console.log(msg);
				if(msg == "OK") {
					setTimeout(function() {
						$("body").trigger("update_checkout");
					}, 1000);
				}
			}
		});
	});

	$("body").on("updated_checkout", function() {
		$(".order__customtip--wrapper").removeClass("_hidden");
		$(".fee .amount").removeClass("_hidden");
		$("#newtipform").remove();
	});

	// $(".tiffin__product .tiffin__wrapper").popmake("open");
	$(".popup-with-zoom-anim").magnificPopup({
		type: "inline",
		
		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: "auto",

		closeBtnInside: true,
		preloader: false,

		midClick: true,
		removalDelay: 300,
		mainClass: "my-mfp-zoom-in",
		callbacks: {
			open: function() {
				setTimeout(function() {
					new SimpleBar($(".tiffin__modal--lists")[0], {
						// autoHide: false,
						timeout: 1000,
					});
				}, 500);
			}
		}
	});

	/* Map pop up */
	$(".map-open").magnificPopup({
		type: "inline",
		
		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: "auto",

		closeBtnInside: true,
		preloader: false,

		midClick: true,
		removalDelay: 300,
		mainClass: "my-mfp-zoom-in",
		callbacks: {
			open: function() {
				setTimeout(function() {
					var input = document.getElementById("address_search");
					var options = {
						types: ["address"],
						componentRestrictions: {
							country: "ca"
						}
					};
					_MAP_AUTO = new google.maps.places.Autocomplete(input, options);

					_MAP_AUTO.setFields([
						"address_component",
						"geometry"
					]);

					_MAP_AUTO.addListener("place_changed", alertMapUpdated);
				}, 500);
			}
		}
	});
	
	$(".tiffin__modal__item--price").each(function() {
		var price = $(this).data("pricetohide");

		if(parseFloat(price) == 0) {
			$(this).find(".amount").html("");
		}
	});

	$(document).on("click", ".tiffin__modal--ctrl", function() {
		var ctrl = $(this).data("control");
		var $parent = $(this).parent();
		var modalid = $parent.data("modalid");

		if(ctrl == "minus") {
			var $option_selected = $parent.find("li.selected");
			var option_number = $option_selected.data("number");
			var total_option_number = $parent.find("li").length;

			if(1 < option_number) {
				$option_selected.removeClass("selected");

				var new_option_number = option_number - 1;
				$parent.find("li[data-number='" + new_option_number + "']").addClass("selected");
			}
		} else if(ctrl == "plus") {
			var $option_selected = $parent.find("li.selected");
			var option_number = $option_selected.data("number");
			var total_option_number = $parent.find("li").length;

			if(option_number < total_option_number) {
				$option_selected.removeClass("selected");

				var new_option_number = option_number + 1;
				$parent.find("li[data-number='" + new_option_number + "']").addClass("selected");
			}
			//
		} else if(ctrl == "check") {
			//
		}

		var new_price = $parent.find(".selected").data("price");

		if(parseFloat(new_price) > 0) {
			$(this).parents(".tiffin__modal__item").find(".tiffin__modal__item--price .amount").html("+$" + new_price.toFixed(2));
		} else {
			$(this).parents(".tiffin__modal__item").find(".tiffin__modal__item--price .amount").html("");
		}

		updatePrice(modalid);
		// updateDescription();
	});

	$(document).on("click", ".tiffin__modal--option", function(e) {
		e.preventDefault();
		var $parent = $(this).parent();
		var modalid = $parent.data("modalid");

		if($(this).find("span").hasClass("selected")) {
			$(this).find("span").removeClass("selected");
		} else {
			//$parent.find("span").removeClass("selected"); //remove class from all
			$(this).find("span").addClass("selected");
		}

		if(false) {		
		var new_price = $parent.find(".selected").data("price");
			if(parseFloat(new_price) > 0) {
				$(this).parents(".tiffin__modal__item").find(".tiffin__modal__item--price .amount").html("$" + new_price.toFixed(2));
			} else {
				$(this).parents(".tiffin__modal__item").find(".tiffin__modal__item--price .amount").html("");
			}
		}

		updatePrice(modalid);
	});

	$(document).on("change", ".tiffin__modal--qty input", function() {
		var modalid = $(this).data("modalid");

		updatePrice(modalid);
	});

	$(".tiffin__menu--items a").each(function() {
		var ref = $(this).attr("href");
		var url = window.location.href;

		ref = ref.replace("www.", "");
		url = url.replace("www.", "");

		if(ref.indexOf(url) != -1 || url.indexOf(ref) != -1 ) {
			$(this).parent().addClass("current-menu-item");
		}
	});

	$(document).on("click", ".tiffin__menu--items a", function(e) {
		e.preventDefault();

		$(".tiffin__menu--items a").each(function() {
			$(this).parent().removeClass("current-menu-item");
		});

		$(this).parent().addClass("current-menu-item");

		var url = $(this).attr("href");
		var url2 = url.split("/");
		var slug = url2[url2.length - 1];

		//fix url
		var curr = window.location.href;

		if(curr.indexOf("wwww") == -1) {
			url = url.replace("www.", "");
		}

		var name = $(this).html();

		$(".tiffin__build--loading").addClass("active");

		$.ajax({
			"url": tiffin_js.ajax_url,
			"data": {
				"action": "get_ondemand_menu",
				"slug": slug,
			}, success: function(msg) {
				//change url
				window.history.replaceState("Object", "Title", url);
				document.title = name + " - Tiffin2Go";

				$(".tiffin__buildoptions").html(msg);

				$(".tiffin__build--loading").removeClass("active");

				$(".tiffin__modal__item--price").each(function() {
					var price = $(this).data("pricetohide");

					if(parseFloat(price) == 0) {
						$(this).find(".amount").html("");
					}
				});

				//pop up
				$(".popup-with-zoom-anim").magnificPopup({
					type: "inline",
					
					fixedContentPos: false,
					fixedBgPos: true,

					overflowY: "auto",

					closeBtnInside: true,
					preloader: false,

					midClick: true,
					removalDelay: 300,
					mainClass: "my-mfp-zoom-in",
					callbacks: {
						open: function() {
							setTimeout(function() {
								new SimpleBar($(".tiffin__modal--lists")[0], {
									// autoHide: false,
									timeout: 1000,
								});
							}, 500);
						}
					}
				});
			}
		});
	});

	$(document).on("change", ".woocommerce-shipping-totals input", function(e) {
		$("body").trigger("update_checkout");
	});

	$("#address_search--form").on("submit", function(e) {
		e.preventDefault();

		// $("#tiffin__saveaddress").addClass("active");

		var data;

		if(! this.checkValidity()) this.reportValidity();
		else {
			//get data from MAP
			var $address = $(this).find("#address_search").val();

			data = get_general_map_data($address);

			$.ajax({
				"url": tiffin_js.ajax_url,
				"data": {
					"action": "new_address",
					"data": data,
				}, success: function(msg) {
					// console.log(msg);
					if(msg.trim() == "OK") {
						// location.reload();
						window.location = window.location.href;
					}
				}
			});
		}

		/*
		var option = $(this).data("option");

		if(option == "address_save") {

		} else if(option == "address_select") {
		}*/
	});

	$("#tiffin__saveaddress .btn--action").click(function(e) {
		e.preventDefault();

		$("#tiffin__saveaddress form").submit();
	});

	$("#tiffin__saveaddress form").on("submit", function(e) {
		e.preventDefault();

		if(! this.checkValidity()) this.reportValidity();
		else {
			alert("proceed");
		}
	});

	$("#argmc-next, .argmc-tab-item").click(function() {
		if (false) {
			var fields = {
				"shipping_email": "billing_email",
				"shipping_first_name": "billing_first_name",
				"shipping_last_name": "billing_last_name",
				"shipping_address_1": "billing_address_1",
				"shipping_address_2": "billing_address_2",
				"shipping_city": "billing_city",
				"shipping_postcode": "billing_postcode",
				"shipping_phone": "billing_phone",
			};

			var $checked = $("#bill_different_address-checkbox").prop("checked");

			if(! $checked) {
				for(var key in fields) {
					if(fields.hasOwnProperty(key)) {
						var new_val = $("#" + key).val();
						$("#" + fields[key]).val(new_val);
					}
				}
			}
		}

		//For Scheduling

		var $checked = $("#schedule-for-later-checkbox").prop("checked");

		if($checked) {
			var date = $("#schedule_date").val();
			var time = $("#schedule_time").val();
			var $val = date + " " + time + ":00";

			$("#schedule").val($val);
		} else {
			$("#schedule").val("no");
		}
	});

	$("#bill_different_address-checkbox").on("change", function(e) {
		e.preventDefault();

		var $checked = $(this).prop("checked");

		var fields = {
			"shipping_email": "billing_email",
			"shipping_first_name": "billing_first_name",
			"shipping_last_name": "billing_last_name",
			"shipping_address_1": "billing_address_1",
			"shipping_address_2": "billing_address_2",
			"shipping_city": "billing_city",
			"shipping_postcode": "billing_postcode",
			"shipping_phone": "billing_phone",
		};

		if($checked) {
			$(".billing_address").slideDown();
			//copy fields
			for(var key in fields) {
				if(fields.hasOwnProperty(key) && fields[key] != key) {
					var old_val = $("#" + fields[key]).data("last");
					$("#" + fields[key]).val(old_val);
				}
			}
		} else {
			$(".billing_address").hide();

			for(var key in fields) {
				if(fields.hasOwnProperty(key) && fields[key] != key) {
					var old_val = $("#" + fields[key]).val();
					$("#" + fields[key]).data("last", old_val);

					var new_val = $("#" + key).val();
					$("#" + fields[key]).val(new_val);
				}
			}
		}
	});

	$("#schedule-for-later-checkbox").on("change", function() {
		var $checked = $(this).prop("checked");

		if($checked) {
			$(".schedule").show();

			$(".schedule input").prop("required", true);
		} else {
			$(".schedule").hide();

			$(".schedule input").prop("required", false);
		}
	});

	$("#schedule_date").datetimepicker({
		timepicker: false,
		format: "Y-m-d",
		minDate: 0,
		disabledWeekDays: [0],
		value: Date.now(),
	});

	$("#schedule_time").datetimepicker({
		datepicker: false,
		format: "H:i",
		allowTimes: [
			"11:00", "12:00", "13:00", "14:00", 
			"15:00", "16:00", "17:00", "18:00",
		],
		value: Date.now(),
	});
});

function alertMapUpdated() {
	var _place = _MAP_AUTO.getPlace();

	if(_place.geometry) {
		var _lat = _place.geometry.location.lat();
		var _lng = _place.geometry.location.lng();

		_MAP.setCenter({
			lat: _lat,
			lng: _lng
		});

		_MAP_MARKERS[_MARKER_COUNT] = new google.maps.Marker({
			position: new google.maps.LatLng(_lat, _lng),
		});

		_MAP_MARKERS[_MARKER_COUNT].setMap(_MAP);

		_MARKER_COUNT++;
	}
}

function get_general_map_data($address) {
	var place = _MAP_AUTO.getPlace();
	var data = {};

	if(place.address_components) {
		var obj = place.address_components;

		var locationdata = {};

		// _d(obj);

		obj.forEach(function callback(value, index, arr){
			locationdata[value.types[0]] = {
				long: value.long_name,
				short: value.short_name,
			}
		});

		// _d(locationdata);

		data["address"] = $address;
		data["country"] = locationdata["country"].short;
		data["state"] = locationdata["administrative_area_level_1"].short;
		data["city"] = locationdata["locality"].long;

		if(locationdata["postal_code"]) {
			data["zipcode"] = locationdata["postal_code"].long;
		} else data["zipcode"] = "-";
		
		// _d(data);

		return data;
	}
}

function _d($a) {
	alert(JSON.stringify($a));
}


function updatePrice(modalid) {
	var $modal = jQuery("#" + modalid);
	var _base_price = $modal.data("price");
	var total_price = 0;

	$modal.find(".selected").each(function() {
		var itemprice = jQuery(this).data("price");

		total_price += parseFloat(itemprice);
	});

	total_price += parseFloat(_base_price);

	var qty = $modal.find(".tiffin__modal--qty input").val();

	total_price *= parseInt(qty);

	// alert(total_price);

	$modal.find(".tiffin__modal--subtotal .amount").html("$" + total_price.toFixed(2));
}

function updateDescription() {
	var options_selected = "";
	jQuery(".tiffin__buildoptions--section").each(function() {
		jQuery(this).find("li.selected").each(function() {
			var itemtitle = jQuery(this).find("figcaption h3").html();

			if(options_selected != "") options_selected += ", ";
			options_selected += itemtitle;
		});
	});

	jQuery(".tiffin__build--desc span").html(options_selected);
}

function tiffin_loading() {
	var loading = "";
	loading += "<div class='lds-ellipsis'>";
	loading += "<div></div>";
	loading += "<div></div>";
	loading += "<div></div>";
	loading += "<div></div>";
	loading += "</div>";
	return loading;
}