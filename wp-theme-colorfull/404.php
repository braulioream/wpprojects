<?php get_header(); ?>
<?php
      $currentlang = pll_current_language();
      if($currentlang=="en"):
      $CurrentLanguage = 'error-en';
      elseif($currentlang=="es"):
      $CurrentLanguage = 'error-es';
      endif; ?>
    <?php
      $args = array( 
         'post_type' => 'page',
         'name'  => $CurrentLanguage,
         'post_status'   => 'publish',
         'posts_per_page'    => 1,
      );
 $wp_query = new WP_Query($args);
 if($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();  ?>
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
<?php endwhile; wp_reset_postdata(); endif; ?>
<?php get_footer(); ?>