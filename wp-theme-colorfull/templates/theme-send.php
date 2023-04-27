<?php
/* Template Name: Template - Enviado*/
get_header(); ?>
<?php 
if(have_posts()) : while(have_posts()) : the_post(); ?>
<section class="message__wrap">
	<div class="message__container wrapper__container">
		<div class="message__image">
			<img src="<?php the_post_thumbnail_url(); ?>" alt="">
		</div>
		<div class="message__title">
			<h1><?php the_title(); ?></h1>
		</div>
		<div class="message__text">
			<?php the_content(); ?>
		</div>
		<div class="message__button">
			<div class="title__general__button">
				<?php
					$currentlang = pll_current_language();
					if($currentlang=="en"): ?>
					<a href="<?php echo esc_url( home_url( '' ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Go to Home'); ?></span></a>
					<?php  elseif($currentlang=="es"): ?>
					<a href="<?php echo esc_url( home_url( '' ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Ir al Inicio','colorfull'); ?></span></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php 
endwhile; 
wp_reset_query();
endif;
?>
<?php get_footer(); ?>