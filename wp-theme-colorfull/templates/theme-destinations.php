<?php
/* Template Name: Template - Destinations*/
get_header(); ?>

<?php echo do_shortcode('[slider__default__one post_type="destination" title="' . get_the_title() .'"]'); ?>
<div class="ctn__filters filter__destinations"  id="filter_box">
  <div class="ctn__filters__wrap wrapper__container">
    <div class="ctn__filters__items">
      <div class="filter__item ">
        <?php $_class = (isset($_GET["region"]) && $_GET["region"] != "")? "colorsTwo" : ""; ?>
        <p class="filter__item__parraf btnFilter <?php echo $_class ?>"><?php _e('Region','colorfull') ?></p>
        <div class="filter__item__ctn list-none">
          <form id="filter__form__region" action="<?php echo get_permalink(); ?>" method="GET" data-taxo="region">
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
                      if( isset( $_GET["region"] )  ) { 
                        $arr = explode(",", $_GET["region"]);
                        if(in_array($term->slug, $arr)) {
                          $selectedCategoria = " checked=\"checked\"";
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
      <div class="filter__item ">
      <?php $_class = (isset($_GET["trip_type"]) && $_GET["trip_type"] != "")? "colorsTwo" : ""; ?>
        <p class="filter__item__parraf btnFilter <?php echo $_class ?>"><?php _e('Trip type','colorfull') ?></p>
        <div class="filter__item__ctn list-none">
          <form id="filter__form__trip" action="<?php echo get_permalink(); ?>" method="GET"  data-taxo="trip_type">
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
                      /*if( isset( $_GET['trip_type'] )  ) { 
                        if( in_array( $term->slug, $_GET['trip_type'] ) ) {
                          $selectedCategoria = ' checked="checked"';
                        }
                      }*/ 
                      if(isset($_GET["trip_type"])) {
                        $arr = explode(",", $_GET["trip_type"]);
                        if(in_array( $term->slug, $arr)) {
                          $selectedCategoria = " checked=\"checked\"";
                        }
                      }
                      ?>
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
<div class="ctn__items__gnral items__destination">
  <div class="ctn__items__gnral__wrap wrapper__container">
    <div class="ctn__items__gnral__wrap__sec">
    </div>

    <div class="destinos__map">
      <div id="map"></div>
      <?php
        $beaches = array();
           $loop = new WP_Query(array(
            "post_type" => "destination",
           ));
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
      <?php _d($beaches , 'playa')  ?>
      <script>
        var map;
        function initMap() {
          map = new google.maps.Map(document.getElementById('map'), {
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
          if(false) {
          for (var i = 0; i < beaches.length; i++) {
          var beach = beaches[i];
          var marker = new google.maps.Marker({
            position: {lat: parseFloat(beach[1]), lng: parseFloat(beach[2])},
            map: map,
            icon: image,
            shape: shape,
            title: beach[0]
          });
          marker.link = beach[15];
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
          
        }
      </script>
    </div>
  </div>
</div>

<div class="overlay__filter"></div>

<?php get_footer(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.sticky-kit.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASeirqUKh5LwLSqOnV5_5ExH0yyHXL54w&signed_in=true&callback=initMap"></script>

<script>
  var busy = false;
  var n_total_posts = <?php echo pll_count_posts(pll_current_language(), ["post_type" => "destination"]) ?>;
  var cont = 1;
  var n_post_request = 8;
  var hay_param = ("<?php echo $_SERVER['QUERY_STRING'] ?>" == "")? false : true;
  var global_param = "<?php echo $_SERVER['QUERY_STRING'] ?>";
  var contenedor = ".ctn__items__gnral__wrap__sec";

  /* Load posts */
  function append_posts(n_post, aux = 1) {
    if(n_total_posts <= n_post_request * (cont - 1)) return;
    if(busy) return;
    busy = true;

    jQuery.ajax({
      url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
      data: {
        action: "destination",
        n_request: (hay_param? -1 : (n_post * aux)),
        paged: (hay_param? 1 : cont),
        params: global_param
      },
      success: function(msg) {
        jQuery(".loading-results").remove();
        jQuery(contenedor).append(msg);
        // jQuery(".ctn__items__gnral__wrap").prepend(msg);
        //console.log("<" + msg + ">");
        cont += aux;
      }
    });
  }

  jQuery(document).ready(function() {
    var window_width = jQuery( window ).width();
    if (window_width < 1025) {
      jQuery(".destinos__map").trigger("sticky_kit:detach");
      
    } else {
      make_sticky();
    }
    jQuery( window ).resize(function() {
      window_width = jQuery( window ).width();
      if (window_width < 1025) {
        jQuery(".destinos__map").trigger("sticky_kit:detach");
        
      } else {
        make_sticky();
      }
    });
    function make_sticky() {
      jQuery(".destinos__map ").stick_in_parent({
        offset_top: 80
      });
    }
    append_posts(n_post_request, 2);

    jQuery("#add-items").click(function() {
      append_posts(n_post_request);
    });

    jQuery(window).scroll(function() {
      if(hay_param) return;
      var position = jQuery(window).scrollTop();
      var bottom = jQuery(document).height() - jQuery(window).height();


      if(bottom - position > 565 && bottom - position < 575) {
        console.log("Position: " + position + " vs Bottom: " + bottom + " = " + (bottom - position));
        append_posts(n_post_request);
      }
    });

    var marker;

    jQuery(document).on('mouseenter','.item__gnral', function (event) {
      var image = {
        size: new google.maps.Size(25, 34),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(0, 25)
      };

      var shape = {
        coords: [1, 1, 1, 20, 18, 20, 18, 1],
        type: 'poly'
      };

      var data_lat = jQuery(this).attr("data-lat");
      var data_long = jQuery(this).attr("data-long");
      marker = new google.maps.Marker({
        position: {lat: parseFloat(data_lat), lng: parseFloat(data_long)},
        map: map,
        icon: image,
        shape: shape,
        title: "Destination"
      });
      
      }).on('mouseleave','.item__gnral',  function(){
        marker.setMap(null);
      });
  });
</script>