<?php

add_action("wp_enqueue_scripts", "load_assets");

function load_assets() {
	wp_enqueue_script("jquery");
	wp_enqueue_script("main", get_stylesheet_directory_uri() . "/assets/js/main.js", [ "jquery" ], "", true);

	wp_enqueue_style("base", get_stylesheet_directory_uri() . "/assets/css/base.css");
	wp_enqueue_style("main", get_stylesheet_directory_uri() . "/assets/css/main.css");
	wp_enqueue_style("fonts", "https://fonts.googleapis.com/css2?family=Cormorant:wght@400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap");

	//Swiper
	wp_enqueue_style("swiper", "https://unpkg.com/swiper@7/swiper-bundle.min.css");
	wp_enqueue_script("swiper", "https://unpkg.com/swiper@7/swiper-bundle.min.js");
}


function admin_style() {
  // wp_enqueue_style("main", get_stylesheet_directory_uri() . "/assets/css/main.css");
}
add_action('admin_enqueue_scripts', 'admin_style');


require_once("inc/blocks.php");
require_once("helpers.php");

add_action("acf/init", "custom_options_pages");
function custom_options_pages() {
	if(function_exists("acf_add_options_page"))	{
		$option_page = acf_add_options_page([
			"page_title" => __("Site Settings"),
			"menu_title" => __("Settings"),
			"menu_slug" => "site-settings",
			"capability" => "edit_posts",
			"redirect" => false,
			"icon_url" => "dashicons-awards",
		]);
	}
}

add_action("init", "init_function");
function init_function() {
	add_theme_support( "post-thumbnails" );
}

