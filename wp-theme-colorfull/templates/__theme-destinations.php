<?php get_header(); ?>
<div class="ctn__filters">
  <div class="ctn__filters__wrap wrapper__container">
    <div class="ctn__filters__items">
      <div class="filter__item btnFilter">
        <p class="filter__item__parraf"><?php _e('Region','colorfull') ?></p>
        <div class="filter__item__ctn list-none">
          <form id="filter__form__region" action="<?php echo get_permalink(); ?>" method="GET">
            <div class="filter__form__ctn">
              <h3><?php _e('Region','colorfull') ?></h3>
              <?php
                  $terms = get_terms(array(
                  	"taxonomy" => "region",
                  	"hide_empty" => false
                  ));
                  if ( $terms ) {
                    echo "<ul class='filter__item__list'>";
                    foreach( $terms as $term ) {
                      $selectedCategoria = '';
                      if( isset( $_GET['region'] )  ) { 
                        if( in_array( $term->slug, $_GET['region'] ) ) {
                          $selectedCategoria = ' checked="checked"';
                        }
                      } ?>
                      <li>
                        <input type="checkbox" value="<?php echo $term->slug ?>" name="region[]" <?php echo $selectedCategoria ?> class="checkbox__filters styled-checkbox" id="<?php echo $term->slug ?>">
                        <label class="label__cat__product" for="<?php echo $term->slug ?>">
                           <?php echo $term->name ?>
                        </label>
                      </li>
                      <?php }
                    echo "</ul>";
                  } ?>
                  <div class="btn__filter">
                    <input type="submit" value="<?php _e('Apply','colorfull') ?>" class="btnSubmit" />
                  </div>
            </div>
          </form>
        </div>
      </div>
      <div class="filter__item btnFilter">
        <p class="filter__item__parraf"><?php _e('Trip type','colorfull') ?></p>
        <div class="filter__item__ctn list-none">
          <form id="filter__form__trip" action="<?php echo get_permalink(); ?>" method="GET">
            <div class="filter__form__ctn">
              <h3><?php _e('Trip type','colorfull') ?></h3>
              <?php
                  $terms = get_terms(array(
                  	"taxonomy" => "trip_type",
                  	"hide_empty" => false
                  ));
                  if ( $terms ) {
                    echo "<ul class='filter__item__list'>";
                    foreach( $terms as $term ) {
                      $selectedCategoria = '';
                      if( isset( $_GET['trip_type'] )  ) { 
                        if( in_array( $term->slug, $_GET['trip_type'] ) ) {
                          $selectedCategoria = ' checked="checked"';
                        }
                      } ?>
                      <li>
                        <input type="checkbox" value="<?php echo $term->slug ?>" name="trip_type[]" <?php echo $selectedCategoria ?> class="checkbox__filters styled-checkbox" id="<?php echo $term->slug ?>">
                        <label class="label__cat__product" for="<?php echo $term->slug ?>">
                           <?php echo $term->name ?>
                        </label>
                      </li>
                      <?php }
                    echo "</ul>";
                  } ?>
                  <div class="btn__filter">
                    <input type="submit" value="<?php _e('Apply','colorfull') ?>" class="btnSubmit" />
                  </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="ctn__filters__search">
      <div class="filter__item btnMap">
        <p class="filter__item__parraf"><?php _e('Show map','colorfull') ?></p>
      </div>
    </div>
  </div>
</div>
<div class="ctn__items__gnral">
  <div class="ctn__items__gnral__wrap wrapper__container">
    <?php
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $args = array( 
      'post_type' => 'destination', 
      'posts_per_page' => -1,
      'paged' => $paged,
      'post_status' => 'publish');
      $wp_query = new WP_Query($args);
      if($wp_query->have_posts()) :  ?>
        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
          <div class="item__gnral">
            <a href="<?php the_permalink(); ?>" class="g__item__one">
              <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
              <figure style="background-image: url('<?php echo $backgroundImg[0];  ?>');"><span></span>
              </figure>
              <figcaption>
                <section>
                  <h3><?php the_title(); ?></h3>
                  <span><?php _e('find out more ->','colorfull') ?></span>
                </section>
              </figcaption>
            </a>
          </div>
        <?php endwhile;
      wp_reset_postdata(); ?>
    <?php endif; ?>
    <div class="destinos__map">
      <div id="map"></div>
      <?php
        $beaches = array();
           $loop = new WP_Query($args);
           if($loop->have_posts()) { ?>
              <?php echo "<ul class='listBeaches'>";
              while($loop->have_posts()) : $loop->the_post();
            $beaches[] = array(
              get_the_title(),
              get_post_meta(get_the_ID(), 'latitud_destination', true),
              get_post_meta(get_the_ID(), 'longitud_destination', true),
              get_permalink(),
            );
                  echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
              endwhile;
              echo "</ul>";
           }
        
      ?>

      <script>
        function initMap() {
          var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 5.3,
          center: {lat: -9.365198731604963, lng: -75.01951444999997} // Camciar por el de peru o la zona que se necesite
          });

          setMarkers(map);
        }

        var beaches = <?php echo json_encode($beaches); ?>

        function setMarkers(map) {
          var image = {
          size: new google.maps.Size(25, 34),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(0, 25)
          };

          var shape = {
          coords: [1, 1, 1, 20, 18, 20, 18, 1],
          type: 'poly'
          };
          for (var i = 0; i < beaches.length; i++) {
          var beach = beaches[i];
          var marker = new google.maps.Marker({
            position: {lat: parseFloat(beach[1]), lng: parseFloat(beach[2])},
            map: map,
            icon: image,
            shape: shape,
            title: beach[0]
          });
          marker.link = beach[3];
          marker.theTitle = beach[0];
          marker.addListener('click', function() {
            var infowindow = new google.maps.InfoWindow({
              content: "<label>" + this.theTitle + "</label><br>" + 
                  "<a href='" + this.link + "'>Mas Información</a>"
              });
            infowindow.open(map, this);
            });
          }
        }
      </script>
    </div>
  </div>
</div>

<div class="overlay__filter"></div>

<?php get_footer(); ?>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASeirqUKh5LwLSqOnV5_5ExH0yyHXL54w&signed_in=true&callback=initMap"></script>
