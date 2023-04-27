<?php
get_header(); ?>

<?php echo do_shortcode('[slider__default__two]'); ?>

<div class="detail_y_top">
  <div class="detail_y_top_container wrapper__container">
    <div class="detail_y__items">
      <div class="detail_y__item detail_y_duration">
        <div class="detail_y__item__inside">
          <h3><?php _e('Duration','colorfull'); ?></h3>
          <div class="detail_y__item__in single__days__journey">
            <?php
              $title = get_field('journey_general_duration');
              $title_array = explode('/', $title);
              $first_word = $title_array[0];
              $second_word = $title_array[1];
            ?>
            <?php echo $first_word; ?> / <span><?php echo $second_word; ?></span>
          </div>
        </div>
      </div>
      <div class="detail_y__item detail_y_triptype">
        <div class="detail_y__item__inside">
          <h3><?php _e('Trip type','colorfull'); ?></h3>
          <div class="detaill__images__figure">
            <?php 
            $terms = get_field('journey_triptypelist');
            if( $terms ): ?>
              <div class="detail_y__images">
              <?php foreach( $terms as $term ): ?>
                <figure>
                  <img src="<?php the_field('activity_icono', $term); ?>" alt="<?php echo $term->name; ?>">
                  <h3><?php echo $term->name; ?></h3>
                </figure>
              <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <div class="detaill__punts">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
          <div class="detaill__box">
            <div class="detaill__box__ctn">
              
            </div>
          </div>
        </div>
      </div>
      <div class="detail_y__item detail_y_price">
        <div class="detail_y__item__inside">
          <h3><?php _e('Starting price','colorfull'); ?></h3>
          <span><?php echo get_price_pre() . " " . get_journey_price(get_the_ID());?></span>
          <span><?php _e('per person','colorfull'); ?></span>
        </div>
      </div>
      <div class="detail_y__item detail_y_links">
        <div class="detail_y__item__inside">
          <a href="#" class="g__button book_now g__button--uppercase g__button--book"><span><?php _e('Book now','colorfull'); ?></span></a>

          <?php
        $currentlang = pll_current_language();
        if($currentlang=="en"): ?>
          <a href="<?php echo esc_url( home_url( '/create-your-own-journey/' ) ); ?>" class="detail_y__item_link"><?php _e('Create your own journey','colorfull'); ?></a>
          
        <?php  elseif($currentlang=="es"): ?>
          <a href="<?php echo esc_url( home_url( '/es/crea-tu-propio-viaje/' ) ); ?>" class="detail_y__item_link"><?php _e('Create your own journey','colorfull'); ?></a>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="detail_y_info">
  <div class="detail_y_info__container wrapper__container">
    <div class="detail_y_info__title title__general title__general--center">
      <div class="title__general__title">
        <h2><?php the_excerpt(); ?></h2>
        <h3>
        <?php if( have_rows('journey_destinationlist') ): ?>
          <?php while( have_rows('journey_destinationlist') ): the_row(); ?>
            <?php
            $post_object = get_sub_field('journey_destination_item');
            if( $post_object ): 
              $post = $post_object;
              setup_postdata( $post );
              if($destinos == "") $destinos = $post->post_name;
              else $destinos .= "," . $post->post_name;
              ?>
              <a href="<?php the_permalink(); ?>"><?php the_title();  ?></a>
              <?php wp_reset_postdata(); ?>
            <?php endif; ?>
          <?php endwhile; ?>
        <?php endif;?>
        </h3>
      </div>
      <?php get_dest_array($post->ID, "journey"); ?>
      <div class="title__general__text content__styles__all">
        <?php the_content(); ?>
      </div>
      
    </div>
    <div class="detail_y__popups buttons__journeys">
      <a href="#" class="g__button book_now g__button--popup" id="1"><span><?php _e('Itinerary','colorfull'); ?></span></a>
      <a href="#" class="g__button book_now g__button--popup" id="2"><span><?php _e('Price','colorfull'); ?></span></a>
      <a href="#" class="g__button book_now g__button--popup" id="3"><span><?php _e('Tour inclusions','colorfull'); ?></span></a>
      <a href="#" class="g__button book_now g__button--popup" id="4"><span><?php _e('Regulations','colorfull'); ?></span></a>
      <a href="#" class="g__button book_now g__button--popup" id="5"><span><?php _e('Useful info','colorfull'); ?></span></a>
    </div>
  </div>
</div>

<div class="detail_y__live" style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
  <div class="detail_y__live__article">
    <div class="detail_y__live__article__inside">
      <h3><?php the_title(); ?></h3>
      <a href="#" class="g__button book_now_white g__button--uppercase g__button--book"><span><?php _e('Book now','colorfull'); ?></span></a>
      <div class="detail_y__live__item__link">

        <?php
        $currentlang = pll_current_language();
        if($currentlang=="en"): ?>
          <a href="<?php echo esc_url( home_url( '/create-your-own-journey/' ) ); ?>"><?php _e('Create your own journey','colorfull'); ?></a>
        <?php  elseif($currentlang=="es"): ?>
          <a href="<?php echo esc_url( home_url( '/es/crea-tu-propio-viaje/' ) ); ?>"><?php _e('Create your own journey','colorfull'); ?></a>
        <?php endif; ?>
        

      </div>
    </div>
  </div>
</div>

<div class="detail_y__experiencie">
  <div class="detail_y__experiencie__title title__general title__general--center">
    <div class="title__general__title">
      <h2><?php the_field('more_suggested_titulo') ?></h2>
      <h3><?php _e('Suggested journeys','colorfull'); ?></h3>
    </div>
    <div class="title__general__button">
      <?php
        $currentlang = pll_current_language();
        if($currentlang=="en"): ?>
          <a href="<?php echo esc_url( home_url( '/suggested-journeys' . ($destinos != ""? '?location=' . $destinos : "") ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
        <?php
        elseif($currentlang=="es"): ?>
          <a href="<?php echo esc_url( home_url( '/es/viajes-sugeridos' . ($destinos != ""? '?location=' . $destinos : "") ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
        <?php endif; ?>
      
    </div>
  </div>
  <?php get_suggested_journeys(4, $post->ID) ?>
</div>


<div class="detail_y__more">
  <div class="borde-colourful-gn"></div>
  <div class="detail_y__more__title title__general title__general--center">
    <div class="title__general__title">
      <h2><?php the_field('more_blog_titulo') ?></h2>
      <h3><?php _e('Blog','colorfull'); ?></h3>
    </div>
    <div class="title__general__button">
      <?php
        $currentlang = pll_current_language();
        if($currentlang=="en"): ?>
          <a href="<?php echo esc_url( home_url( '/blog' . ($destinos != ""? '?location=' . $destinos : "") ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
        <?php
        elseif($currentlang=="es"): ?>
          <a href="<?php echo esc_url( home_url( '/es/blog-2/' . ($destinos != ""? '?location=' . $destinos : "") ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
        <?php endif; ?>
      
    </div>
  </div>
  <?php get_blog_posts(3, $post->ID, "journey"); ?>
</div>

<div class="pop__up__y__wrap pop__up__y__tabs">
  <div class="pop__up__y__overlay"></div>
  <div class="pop__up__y">
    <div class="pop__up__y__close pop__up__y--close icon-close"></div>
    <div class="pop__up__y__container">
      <div class="pop__up__y__nav">
        <a href="#" class="pop__up__y__btn detail_y__btn1" data-id="1"><span><?php _e('Itinerary','colorfull'); ?></span></a>
        <a href="#" class="pop__up__y__btn detail_y__btn2" data-id="2"><span><?php _e('Price','colorfull'); ?></span></a>
        <?php $m=2; ?>
        <?php if( have_rows('anexo_tab') ): $m; ?>
          <?php while( have_rows('anexo_tab') ): the_row(); $m++; ?>
            <a href="#" class="pop__up__y__btn detail_y__btn3" data-id="<?php echo $m; ?>"><span><?php the_sub_field('anexo_tab_titulo') ?></span></a>

          <?php endwhile; ?>
        <?php endif; ?>
      </div>
      <div class="pop__up__y__content__all">
        <div class="pop__up__y__content" id="1">
          <div class="pop__up__y__content__in">
            <div class="pop__up__y__content__scroll">
              <div class="pop__up__y__mobile__title">
                <h3><?php _e('Itinerary','colorfull'); ?></h3>
              </div>
              <div class="pop__up__y__content__in__under">
                <div class="pop__up__y__content__in__under__scroll">
                <?php if( have_rows('journey_tabs_itinerary') ): ?>
                  <?php while( have_rows('journey_tabs_itinerary') ): the_row(); ?>
                    <article class="single_itinerary__list">
                      <hgroup>
                        <h4><?php _e('day','colorfull'); ?><?php the_sub_field('journey_tabs_itinerary_daynum') ?> :</h4>
                        <h3><?php the_sub_field('journey_tabs_itinerary_titulo') ?></h3>
                      </hgroup>
                      <section>
                        <?php the_sub_field('journey_tabs_itinerary_desc'); ?>
                      </section>
                    </article>
                  <?php endwhile; ?>
                <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="pop__up__y__content" id="2">
          <div class="pop__up__y__content__in">
            <div class="pop__up__y__content__scroll">
              <div class="pop__up__y__mobile__title">
                <h3><?php _e('Price','colorfull'); ?></h3>
              </div>
              <div class="pop__up__y__content__in__under">
                <div class="pop__up__y__content__in__under__scroll">
                  <div class="table__g__price__desktop">  
                  <div class="table__g table__g--responsive table__g--five--columns">
                  <?php
                  if(have_rows("journey_destinationlist")) {
                    $precios_dest = array();
                    $precios_cat = array();

                    while(have_rows("journey_destinationlist")) {
                      the_row();
                      $dest_items = get_sub_field("journey_destination_item");
                      if(empty($dest_items)) continue;

                      $accoms = array(
                        "tourist" => get_sub_field("journey_accom_tourist"),
                        "superior-tourist" => get_sub_field("journey_accom_sup_tourist"),
                        "superior" => get_sub_field("journey_accom_sup"),
                        "deluxe" => get_sub_field("journey_accom_deluxe")
                      );

                      $accoms_alt = array(
                        "tourist" => get_sub_field("journey_accom_tourist_alt"),
                        "superior-tourist" => get_sub_field("journey_accom_sup_tourist_alt"),
                        "superior" => get_sub_field("journey_accom_sup_alt"),
                        "deluxe" => get_sub_field("journey_accom_deluxe_alt")
                      );
                      
                      $destination_ID = $dest_items->ID;
                      $destination_nombre = $dest_items->post_title;

                      $precios_dest[$destination_nombre] = array();

                      foreach($accoms as $t => $accom) {
                        if($accoms_alt[$t]) $accom_nombre = $accoms_alt[$t];
                        else $accom_nombre = $accom->post_title;
                        $accom_tipo = get_term_by("slug", $t, "accomodation_category");

                        $precios_dest[$destination_nombre][] = array(
                          "nombre" => $accom_nombre,
                          "tipo" => $accom_tipo->name,
                        );

                        $precios_cat[$accom_tipo->name][] = array(
                          "destination" => $destination_nombre,
                          "nombre" => $accom_nombre,
                        );
                      }
                    }
                  }
                  ?>

                    <table>
                      <thead>
                        <tr>
                          <th><?php _e('Destination','colorfull'); ?></th>
                          <th><?php _e('Tourist','colorfull'); ?></th>
                          <th><?php _e('Superior tourist','colorfull'); ?></th>
                          <th><?php _e('Superior','colorfull'); ?></th>
                          <th><?php _e('Deluxe','colorfull'); ?></th>
                        </tr>
                      </thead>
                      <tbody>
                         
                      <?php foreach ($precios_dest as $dest => $arr): ?>
                        <tr>
                          <td>
                            <p><?php echo $dest ?></p>
                          </td>
                          <?php foreach ($arr as $val): ?>
                          <td>
                            <p><?php echo $val["nombre"] ?></p>
                          </td>
                          <?php endforeach ?>
                        </tr>
                      <?php endforeach ?>
                      </tbody>
                      <?php if ($precios = get_field("tour_prices")): ?>
                      <tfoot>
                        <tr>
                          <th><?php _e("Price per person: ", "colorfull"); price_pre(); ?></th>
                          <th><?php echo get_fixed_price($precios["journey_tourist_price"]? $precios["journey_tourist_price"] : "0") ?></th>
                          <th><?php echo get_fixed_price($precios["journey_suptourist_price"]? $precios["journey_suptourist_price"] : "0") ?></th>
                          <th><?php echo get_fixed_price($precios["journey_superior_price"]? $precios["journey_superior_price"] : "0") ?></th>
                          <th><?php echo get_fixed_price($precios["journey_deluxe_price"]? $precios["journey_deluxe_price"] : "0") ?></th>
                        </tr>
                      </tfoot>
                      <?php endif ?>
                    </table>
                    <div class="table__g__price__buttons">
                      <a href="#" data-tipo="1" class="g__button book_now g__button--uppercase book_now_colors"><span><?php _e('Book Tourist','colorfull'); ?></span></a>
                      <a href="#" data-tipo="2" class="g__button book_now g__button--uppercase book_now_colors"><span><?php _e('Book Superior tourist','colorfull'); ?></span></a>
                      <a href="#" data-tipo="3" class="g__button book_now g__button--uppercase book_now_colors"><span><?php _e('Book Superior','colorfull'); ?></span></a>
                      <a href="#" data-tipo="4" class="g__button book_now g__button--uppercase book_now_colors"><span><?php _e('Book Deluxe','colorfull'); ?></span></a>
                    </div>
                  </div>
                </div>
                <div class="table__g__price__mobile">
                  <?php
                    $_nom = array("journey_tourist_price", "journey_suptourist_price", "journey_superior_price", "journey_deluxe_price");
                    $_bot = array('Book Tourist', 'Book Superior tourist', 'Book Superior', 'Book Deluxe');
                    $cont = 0;
                    foreach ($precios_cat as $cat_nombre => $valores) {
                  ?>
                  <div class="table__g__price__item">
                    <h3><?php _e($cat_nombre,'colorfull'); ?></h3>
                    <table class="table__g--mobile">
                      <tbody>
                      <?php foreach ($valores as $val) { ?>
                        <tr>
                          <td>
                            <?php echo $val["destination"] ?>
                          </td>
                          <td>
                            <?php echo $val["nombre"] ?>
                          </td>
                        </tr>
                      <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th><?php _e("Price per person: ", "colorfull"); price_pre(); ?></th>
                          <th><?php echo get_fixed_price($precios[$_nom[$cont]]); ?></th>
                        </tr>
                      </tfoot>
                    </table>
                    <a href="#" data-tipo="<?php echo $cont + 1 ?>"  class="g__button book_now g__button--uppercase"><span><?php _e($_bot[$cont++],'colorfull'); ?></span></a>
                  </div>
                    <?php 
                    }
                  ?>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php $h=2; ?>
        <?php if( have_rows('anexo_tab') ): $h; ?>
          <?php while( have_rows('anexo_tab') ): the_row(); $h++; ?>
            <div class="pop__up__y__content" id="<?php echo $h; ?>">
              <div class="pop__up__y__content__in ">
                <div class="pop__up__y__content__scroll">
                  <div class="pop__up__y__mobile__title">
                    <h3><?php the_sub_field('anexo_tab_titulo') ?></h3>  
                  </div>
                  <div class="pop__up__y__content__in__under">
                    <div class="pop__up__y__content__in__under__scroll">
                      <div class="pop__up__y__content__in__edit">
                        <?php the_sub_field('anexo_tab_contenido') ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="pop__up__y__wrap pop__up__y__book">
  <div class="pop__up__y__overlay"></div>
  <div class="pop__up__y">
    <div class="pop__up__y__close pop__up__y--close popupicon-up"></div>
    <div class="pop__up__y__container">
      <div class="pop__up__y__book__in">
        <div class="pop__up__y__book__scroll">
        <div class="pop__up__y__close pop__up__y--close popupicon-on"></div>
        <div class="pop__up__y__form__book__title">
          <h3><i><?php _e('Booking','colorfull'); ?>:</i> <?php the_excerpt(); ?></h3>
        </div>
        <?php
        $currentlang = pll_current_language();
        if($currentlang=="en"): ?>
          <?php echo do_shortcode('[contact-form-7 id="364" title="Booking form"]') ?>
        <?php
        elseif($currentlang=="es"): ?>
          <?php echo do_shortcode('[contact-form-7 id="365" title="Booking form ES"]') ?>
        <?php endif; ?>
        
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();
?>


<script>
  jQuery(document).ready(function($){
    $('.g__button--book').click(function(event) {
      event.preventDefault();
      $('.pop__up__y__book').addClass('active');
      $('body').addClass('active-overlay');
    });

    $(".table__g__price__buttons a").click(function(e) {
      e.preventDefault();

      //Abrir el modal de Book...
      $('.pop__up__y__book').addClass('active');
      $('body').addClass('active-overlay');
      var data_tipo = $(this).attr("data-tipo");
      $('input[data-tipo=' + data_tipo + ']').prop("checked", "true");
    });

    $(".table__g__price__item a").click(function(e) { //Lo mismo que arriba
      e.preventDefault();

      //Abrir el modal de Book...
      $('.pop__up__y__book').addClass('active');
      $('body').addClass('active-overlay');
      var data_tipo = $(this).attr("data-tipo");
      $('input[data-tipo=' + data_tipo + ']').prop("checked", "true");
    });

    //tabs
    $('.pop__up__y__btn:nth-child(1)').addClass('active');
    $('.pop__up__y__content:nth-child(1)').addClass('active');

    $('.pop__up__y__btn').click(function(e){
      e.preventDefault();
      $('.pop__up__y__btn').removeClass('active');
      $(this).addClass('active');
      var data_id = $(this).attr('data-id');
      console.log(data_id);
      $('.pop__up__y__content').removeClass('active');
      $('.pop__up__y__content[id="'+ data_id+'"]').addClass('active');
     });


    //pop up
    $('.pop__up--pitcher--y').click(function(event) {
      event.preventDefault();
      $('.pop__up__y__tabs').addClass('active');
      $('body').addClass('active-overlay');
    });

    $('.pop__up__y--close , .pop__up__y__overlay').click(function(event) {
      event.preventDefault();
      $('.pop__up__y__wrap').removeClass('active');
      $('body').removeClass('active-overlay');
    });

    $('.g__button--popup').click(function(event) {
      event.preventDefault();
      $('.pop__up__y__tabs').addClass('active');
      $('body').addClass('active-overlay');
      var data_id = $(this).attr('id');
      $('.pop__up__y__content').removeClass('active');
      $('.pop__up__y__btn').removeClass('active');
      $('.pop__up__y__content[id="'+ data_id+'"]').addClass('active');
      $('.pop__up__y__btn[data-id="'+ data_id+'"]').addClass('active');
    });

    //tabs - info1 -  acordion
    $('.single_itinerary__list:nth-child(1) > hgroup').addClass('active');
    $('.single_itinerary__list:nth-child(1) > section').addClass('active');

    $('.single_itinerary__list > hgroup').click(function(e){
      e.preventDefault();
      if ($(this).hasClass('active')) {
        $(this).removeClass('active').parent().find('> section').stop().slideUp();
      }else{
        $('.single_itinerary__list > hgroup').removeClass('active');
        $('.single_itinerary__list > section').stop().slideUp();
        $(this).addClass('active').parent().find('> section').stop().slideToggle();
      };
     });




  });
</script>