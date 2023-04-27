<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<title>
	  <?php
       	if(is_front_page()){
       		echo 'Home';
       	} else {
       		wp_title('');
       	}
        echo ' | ';
        bloginfo('name');
      ?>
    </title>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

<header>
	
	<?php get_template_part('template-parts/general-menu') ?>

	<?php if(!get_field('disable_page_header')): ?>
		
		<?php get_template_part('template-parts/header/header-title') ?>

	<?php endif ?>
</header>


