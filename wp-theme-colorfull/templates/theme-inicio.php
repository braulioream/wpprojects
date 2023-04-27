<?php
/* Template Name: Template - Inicio*/
get_header();

if(have_posts()) : the_post();
  global $post;
  $home_id = $post->ID;
?>

<section class="inicio__slide">
  <div class="inicio__slide--wrap slider__principal">
    <ul class="inicio__slide--slides slider__principal__list slider__principal--pitcher">
      
      <?php if( have_rows('slider_principal') ): ?>
      <?php while( have_rows('slider_principal') ): the_row(); ?>
        <li class="slider__principal__item">
          <div class="inicio__slide slider__principal__item__image js-bg" data-img="<?php the_sub_field( 'imagen_slider' ); ?>;<?php the_sub_field( 'imagen_slider_tablet' ); ?>;<?php the_sub_field( 'imagen_slider_mobile' ); ?>" style="background-image: url('') ?>);"></div>
        </li>
      <?php endwhile; ?>
      <?php endif; ?>
    </ul>

    <div class="inicio__slide--logo">
      <img src="<?php the_field("logo_main", "options") ?>" alt="">
    </div>

    <div class="inicio__slide--botones">
      <?php 
        if(have_rows("inicio_slides_botones")) {
          echo "<nav>";
          while(have_rows("inicio_slides_botones")) {
            the_row();
            echo "<a href='" . get_sub_field("inicio_slide_boton_enlace") . "'>" . get_sub_field("inicio_slide_boton") . "</a>";
          }
          echo "</nav>";
        }
      ?>
    </div>
  </diV>
</section>

<section class="inicio__info title__general title__general--center">
  <div class="inicio__content title__general__text content__styles__all">
    <?php the_content(); ?>
  </div>
</section>

<div class="separador"></div>

<!-- section.inicio__ -->

<section class="servicio__block servicio_suggested">
  <div class="servicio__block__titulo title__general__title">
    <h2><?php the_field("inicio_suggested_titulo") ?></h2>
    <h3><?php _e("Suggested Journeys", "colorfull") ?></h3>
  </div>

  <div class="servicio__block__more title__general__button">
  <?php
    $currentlang = pll_current_language();
    if($currentlang=="en"): ?>
      <a href="<?php echo esc_url( home_url( '/suggested-journeys' ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
    <?php
    elseif($currentlang=="es"): ?>
      <a href="<?php echo esc_url( home_url( '/es/viajes-sugeridos/' ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
    <?php endif; ?>
  </div>

  <div class="servicio__block__items">
  <?php get_suggested_journeys(8, $home_id, "home"); ?>
  </div>
</section>

<div class="separador"></div>

<section class="servicio__block servicio__destination">
  <div class="servicio__block__titulo title__general__title">
    <?php wp_reset_query(); ?>
    <h2><?php the_field("inicio_destinations_titulo") ?></h2>
    <h3><?php _e('Destinations', "colorfull") ?></h3>
  </div>
  <div class="servicio__block__more title__general__button">
  <?php
    $currentlang = pll_current_language();
    if($currentlang=="en"): ?>
      <a href="<?php echo esc_url( home_url( '/destinations' ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
    <?php
    elseif($currentlang=="es"): ?>
      <a href="<?php echo esc_url( home_url( '/es/destinos/' ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
    <?php endif; ?>
  </div>

  <div class="servicio__block__items">
  <?php get_destinations($home_id); ?>
  </div>
</section>

<div class="separador"></div>

<section class="servicio__block servicio__accom">
  <div class="servicio__block__titulo title__general__title">
    <?php wp_reset_query(); ?>
    <h2><?php the_field("inicio_acommodations_titulo") ?></h2>
    <h3><?php _e("Top Ranked Accommodations", "colorfull") ?></h3>
  </div>
  <div class="servicio__block__more title__general__button">
  <?php
    $currentlang = pll_current_language();
    if($currentlang=="en"): ?>
      <a href="<?php echo esc_url( home_url( '/accommodations' ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
    <?php
    elseif($currentlang=="es"): ?>
      <a href="<?php echo esc_url( home_url( '/es/alojamientos/' ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
    <?php endif; ?>
  </div>

  <div class="servicio__block__items">
  <?php get_accom(6, $home_id, "home"); ?>
  </div>
</section>

<div class="separador"></div>

<section class="servicio__block servicio__blog">
  <div class="servicio__block__titulo title__general__title">
    <?php wp_reset_query(); ?>
    <h2><?php the_field("inicio_blog_titulo") ?></h2>
    <h3>Blog</h3>
  </div>
  <div class="servicio__block__more title__general__button">
  <?php
    $currentlang = pll_current_language();
    if($currentlang=="en"): ?>
      <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
    <?php
    elseif($currentlang=="es"): ?>
      <a href="<?php echo esc_url( home_url( '/es/blog-2/' ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
    <?php endif; ?>
  </div>

  <div class="servicio__block__items">
  <?php get_blog_posts(3, $home_id, "home"); ?>
  </div>
</section>

<?php if(have_rows("inicio_testimonial")) { ?>

<div class="separador"></div>

<section class="servicio__block servicio__test">
  <div class="servicio__block__titulo title__general__title">
    <h2><?php the_field("inicio_test_titulo") ?></h2>
    <h3>Testimonials</h3>
  </div>

  <div class="servicio__test--testimonials">
    <ul>
    <?php while(have_rows("inicio_testimonial")) : the_row();?>
      <li>
        <p class="testimonial--quote">
          <?php echo get_sub_field("inicio_testimonial_texto") ?>
        </p>
        <span class="testimonial--data"><?php echo get_sub_field("inicio_testimonial_datos") ?></span>
      </li>
    <?php endwhile; ?>
    </ul>
  </div>
</section>

<?php } ?>

<?php
endif;
get_footer();
?>