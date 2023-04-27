jQuery(document).ready(function($) {


	$(".menu-item-has-children").click(function(){

		let currentSubMenu = $(this).find(".sub-menu");
		


		if(currentSubMenu.hasClass("active")){
			currentSubMenu.removeClass("active")
			currentSubMenu.slideUp()
			return
		} else {
			$(".sub-menu").hide()
		}

		$(".sub-menu").removeClass("active")

		currentSubMenu.addClass("active")
		currentSubMenu.slideDown();

	})


	$("#menu-button").click(function(e){
		$(".hmenu-mobile").slideToggle()
	})

	$(".open-filters").click(function(e){
		$(this).parents('.tags').find('nav').slideToggle()
	})

	$(window).scroll(function() {   

		let header = $(".hmenu") 
	    let scroll = $(window).scrollTop();

	    if (scroll >= 200) {
	    	header.addClass("header-sticky");
	    } else {
	    	header.removeClass("header-sticky");
	    }

	});

	new Swiper('.slider .swiper', {
	  loop: true,
		navigation: {
	    nextEl: '.slider-navigation-right',
	    prevEl: '.slider-navigation-left',
	  },
	});

	const videos_swiper = new Swiper('.videos .swiper', {
	  loop: true,
		navigation: {
	  	nextEl: '.controls-right',
	  	prevEl: '.controls-left'
	  },
	});

	videos_swiper.on('slideChange', function () {
	  changeCurrentPlaylistItem()
	});
	
	$(".playlist-item").click(function(e){
		videos_swiper.slideTo(parseInt($(this).data('playlist-video-id')) + 1)
		changeCurrentPlaylistItem()
	})

	function changeCurrentPlaylistItem(){

		$(".playlist-item").removeClass('active')
		$(".playlist-item").eq(videos_swiper.activeIndex - 1).addClass('active')
	}
	

	new Swiper('.posters .swiper', {
	  loop: true,
	  navigation: {
	  	nextEl: '.controls-right',
	  	prevEl: '.controls-left'
	  },
	  slidesPerView: 1,
	  breakpoints: {
	  	720: { 
	  		slidesPerView: 2,
	  	}
	  },
	  spaceBetween: 40

	});

	$(".minisection-accordeon-tab").click(function(e){
		$(".minisection-accordeon-tab-content").slideUp()
		$(".minisection-accordeon-tab-content").parents(".minisection").removeClass('open')
		//
		$("#minisection-accordeon-tab-content-" + $(this).data('accordeon-id')).slideToggle()
		$("#minisection-accordeon-tab-content-" + $(this).data('accordeon-id')).parents(".minisection").addClass('open')
	});
	
	if(false) {
		$("figcaption .text *, .project__desc .text *").each(function() {
			let color_box = "<div class='colorbox'>";
			color_box += "<div class='color color1' data-color='#000'></div>";
			color_box += "<div class='color color2' data-color='white'></div>";
			color_box += "<div class='color color3' data-color='#6D485C'></div>";
			color_box += "<div class='color color4' data-color='#DB2A8A'></div>";
			color_box += "<div class='color color5' data-color='#200212'></div>";

			color_box += "</div>";

			$(this).addClass("modificable");
			$(this).append(color_box);
		});

		$(".text").on("click", ".color", function() {
			let color = $(this).data("color");
			console.log(color);
			$(this).closest(".modificable").css("color", color);
		});
	}
});