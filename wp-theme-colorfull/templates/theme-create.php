<?php
/* Template Name: Template - Create Your Own Journey*/
get_header();

if(have_posts()) : the_post();
?>

<section class="create__cover inicio__slide">
  <div class="slider__principal">
    <ul class="slider__principal__list slider__principal--pitcher">
      <li class="slider__principal__item">
        <div class="slider__principal__item__image" style="background-image: url('<?php echo get_the_post_thumbnail_url() ?> ')">
        </div>
        <div class="slider__principal__container">
          <div class="slider__principal__info">
            <div class="slider__principal__info__title">  
              <h3><?php echo get_the_title() ?></h3>
            </div>
            <div class="slider__principal__info__button">
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</section>

<section class="create__desc">
  <div class="title__general title__general--center">
    <div class="title__general__title">
      <h2><?php echo get_field("create_subtitle") ?></h2>
      <h3><?php echo get_the_title() ?></h3>
    </div>
    <div class="title__general__text content__styles__all">
      <?php echo get_field("create_texto") ?>
    </div>
  </div>
</div>
</section>

<div class="separador"></div>

<section class="create__form">
  <div class="create__form--wrapper">
    <div class="create__form--title">
      <h3><?php _e('Mark your interests','colorfull') ?></h3>
    </div>

    <div class="create__form__section">
      <div class="create__form__section--title">
        <h3><?php _e('Region','colorfull') ?></h3>
      </div>
      <div class="create__form__section--items create__form__region">
        <?php $q = get_terms(array(
          "taxonomy" => "region",
          "hide_empty" => false
        ));?>
        <ul>
          <?php foreach($q as $r) {?>
          <li>
            <div class="create__form__item--portada" style="background: url('<?php echo get_field("taxonomy_imagen_asignada", "region_" . $r->term_id) ?>')"></div>
            <div class="create__form__item--datos">
              <h3><?php echo $r->name ?></h3>
              <label for="inp"></label>
              <input type="checkbox" name="inp">
            </div>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>

    <div class="separador-2"></div>

    <div class="create__form__section">
      <div class="create__form__section--title">
        <h3><?php _e('Type of Trip','colorfull') ?></h3>
      </div>
      <div class="create__form__section--items create__form__trip">
        <?php $q = get_terms(array(
          "taxonomy" => "trip_type",
          "hide_empty" => false
        ));?>
        <ul>
          <?php foreach($q as $r) {?>
          <li>
            <div class="create__form__item--portada" style="background: url('<?php echo get_field("taxonomy_imagen_asignada", "region_" . $r->term_id) ?>')"></div>
            <div class="create__form__item--datos">
              <h3><?php echo $r->name ?></h3>
              <label for="inp"></label>
              <input type="checkbox" name="inp">
            </div>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="separador-2"></div>

    <div class="create__form__section">
      <div class="create__form__section--title">
        <h3><?php _e('Time','colorfull') ?></h3>
      </div>
      <div class="create__form__section--items create__form__time">
        <ul>
          <?php while(have_rows("create_section_days")) { the_row();?>
          <li>
            <div class="create__form__item--portada" style="background: url('<?php echo get_sub_field("create_section_days_imagen") ?>')"></div>
            <div class="create__form__item--datos">
              <h3><?php echo get_sub_field("create_section_days_texto") ?></h3>
              <label for="inp"></label>
              <input type="checkbox" name="inp">
            </div>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="separador-2"></div>

  </div>

  <div class="create__form--form">
    <?php the_content(); ?>
  </div>
</section>

<?php
endif;
get_footer();
?>