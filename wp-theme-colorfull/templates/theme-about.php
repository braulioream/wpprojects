<?php
/* Template Name: Template - About*/
get_header(); ?>
<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

<div class="inicio__slide">
	<div class="banner__post" style="background-image: url('<?php echo $backgroundImg[0];  ?>');">
		<div class="banner__post__ctn wrapper__container">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
</div>

<div class="about__wrap ">
	<div class="about__ctn wrapper__container">
		<div class="title__general__title">
			<h2><?php the_field('about_title'); ?></h2>
			<h3><?php the_field('about_subtitle'); ?></h3>
		</div>
		<div class="about__ctn__prin">
			<?php while ( have_posts() ) : the_post();
				the_content();
			endwhile;?>
		</div>
	</div>
</div>
<?php get_footer(); ?>