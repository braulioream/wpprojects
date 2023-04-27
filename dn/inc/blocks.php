<?php

add_action("acf/init", "dn_init_block_types");
function dn_init_block_types() {
	if( function_exists("acf_register_block_type") ) {


		/* Home Blocks */

		acf_register_block_type([
			"name" => "home-slide",
			"title" => "Home Slide",
			"description" => "Slides for the home page",
			"render_template" => "template-parts/blocks/home/slide.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);

		acf_register_block_type([
			"name" => "home-intro",
			"title" => "Home Intro",
			"description" => "Intro for the home page",
			"render_template" => "template-parts/blocks/home/home-intro.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);

		acf_register_block_type([
			"name" => "home-news",
			"title" => "Home News",
			"description" => "News for the home page",
			"render_template" => "template-parts/blocks/home/home-news.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);

		acf_register_block_type([
			"name" => "home-publications",
			"title" => "Home Publications",
			"description" => "Publications for the home page",
			"render_template" => "template-parts/blocks/home/home-publications.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		/* About Blocks */

		acf_register_block_type([
			"name" => "about-1",
			"title" => "About 1",
			"description" => "About 1 for the about page",
			"render_template" => "template-parts/blocks/about/about-1.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		acf_register_block_type([
			"name" => "about-2",
			"title" => "About 2",
			"description" => "About 2 for the about page",
			"render_template" => "template-parts/blocks/about/about-2.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		acf_register_block_type([
			"name" => "about-3",
			"title" => "About 3",
			"description" => "About 3 for the about page",
			"render_template" => "template-parts/blocks/about/about-3.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		acf_register_block_type([
			"name" => "about-4",
			"title" => "About 4",
			"description" => "About 4 for the about page",
			"render_template" => "template-parts/blocks/about/about-4.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		acf_register_block_type([
			"name" => "about-5",
			"title" => "About 5",
			"description" => "About 5 for the about page",
			"render_template" => "template-parts/blocks/about/about-5.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		/* Publications & Posters */


		acf_register_block_type([
			"name" => "pp-publications",
			"title" => "Publications & Posters - Publications",
			"description" => "Publications for the Publications & Posters page",
			"render_template" => "template-parts/blocks/publications-posters/pp-publications.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		acf_register_block_type([
			"name" => "pp-posters",
			"title" => "Publications & Posters - Posters",
			"description" => "Posters for the Publications & Posters page",
			"render_template" => "template-parts/blocks/publications-posters/pp-posters.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);

		/* Research */

		acf_register_block_type([
			"name" => "research-featured",
			"title" => "Research - Featured",
			"description" => "Featured research for the Research page",
			"render_template" => "template-parts/blocks/research/research-featured.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		acf_register_block_type([
			"name" => "research-loop",
			"title" => "Research - Loop",
			"description" => "Research Loop for the Research page",
			"render_template" => "template-parts/blocks/research/research-loop.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		/* Grants */

		acf_register_block_type([
			"name" => "grants-loop",
			"title" => "Grants - Loop",
			"description" => "Grants Loop for the Grants page",
			"render_template" => "template-parts/blocks/grants/grants-loop.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		/* Outreach */

		acf_register_block_type([
			"name" => "outreach-videos",
			"title" => "Outreach - Videos",
			"description" => "Outreach Videos for the Outreach page",
			"render_template" => "template-parts/blocks/outreach/outreach-videos.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		acf_register_block_type([
			"name" => "outreach-accordeon",
			"title" => "Outreach - Accordeon",
			"description" => "Outreach Accordeon for the Outreach page",
			"render_template" => "template-parts/blocks/outreach/outreach-accordeon.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		/* Blog */

		acf_register_block_type([
			"name" => "blog-loop",
			"title" => "Blog - Loop",
			"description" => "Blog Loop for the Blog page",
			"render_template" => "template-parts/blocks/blog/blog-loop.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		/* Contact */ 

		acf_register_block_type([
			"name" => "contact",
			"title" => "Contact",
			"description" => "Contact block for the contact page",
			"render_template" => "template-parts/blocks/contact/contact.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


		/* Slider */ 

		acf_register_block_type([
			"name" => "Slider",
			"title" => "Slider",
			"description" => "Slider block",
			"render_template" => "template-parts/blocks/slider/slider.php",
			"category" => "formatting",
			"icon" => "admin-comments",
		]);


	}
}
