<?php
/* Template Name: Template - Suggested Journeys*/
get_header(); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php echo do_shortcode('[slider__default__one post_type="journey" title="' .  get_the_title() .'"]'); ?>
<div class="ctn__filters filter__suggested"  id="filter_box">
	<div class="ctn__filters__wrap wrapper__container">
		<div class="ctn__filters__items">
      <div class="filter__item ">
        <?php $_class = (isset($_GET["location"]) && $_GET["location"] != "")? "colorsTwo activeTwo" : ""; ?>
        <p class="filter__item__parraf btnFilter <?php echo $_class ?>"><?php _e('Location','colorfull') ?></p>
        <div class="filter__item__ctn list-none">
          <form id="filter__form__location" action="<?php echo get_permalink(); ?>" method="GET" data-taxo="location">
            <div class="filter__form__ctn">
              <h3><?php _e('Location','colorfull') ?></h3>
              <ul class="filter__item__list"> 
              <?php
                $args = array( 
                  'post_type' => 'destination', 
                  'post_status' => 'publish',
                  'posts_per_page' => -1,
                );
                $wp_query = new WP_Query($args); ?>
                <?php if($wp_query->have_posts()) : ?>
                <?php $arr = explode(",", $_GET["location"]); ?>
                <?php while ($wp_query->have_posts()) : $wp_query->the_post(); global $post;?>
                  <li>
                    <input type="checkbox" value="<?php echo $post->post_name; ?>" name="destination"  class="checkbox__filters styled-checkbox" id="<?php echo $post->post_name; ?>" <?php echo in_array($post->post_name, $arr)? "checked='checked'" : ""; ?>">
                    <label class="label__cat__product" for="<?php echo $post->post_name; ?>"><?php the_title(); ?></label>
                  </li>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
                <?php endif; ?>
              </ul>
              <div class="btn__filter">
                <input type="submit" value="<?php _e('Apply','colorfull') ?>" class="btnSubmit" />
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="filter__item ">
        <?php $_class = (isset($_GET["region"]) && $_GET["region"] != "")? "colorsTwo activeTwo" : ""; ?>
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
        <?php $_class = (isset($_GET["trip_type"]) && $_GET["trip_type"] != "")? "colorsTwo activeTwo" : ""; ?>
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
      <?php $_class = (isset($_GET["price"]) && $_GET["price"] != "")? "colorsTwo activeTwo" : ""; ?>
			<div class="filter__item  btn__price__filter">
       			<p id="select_price_filter" class="filter__item__parraf btnFilter <?php echo $_class ?>"><?php _e('Price','colorfull') ?></p>
       			<div class="filter__item__ctn list-none">
	          		<form id="filter__form__price" action="<?php echo get_permalink(); ?>" method="GET">
	            		<div class="filter__form__ctn">
	            			<h3><?php _e('Price','colorfull') ?></h3>
                    <p><?php _e('The average price is', 'colorfull') ?> <?php echo get_price_pre(); ?> <span class="span__average_price"></span></p>
	            			<div class="filter__price">
	            				<div class="filter__price__slider">
	            					<div id="slider-range"></div>
	            				</div>
	            				<div class="filter__price__info">
  									<input type="text" id="amount" readonly >
	            				</div>
	            			</div>
	            			<div class="btn__filter">
			                	<input type="submit" value="<?php _e('Apply','colorfull') ?>" class="btnSubmit" />
			                </div>
	            		</div>
	            	</form>
	            </div>
       		</div>
		</div>
		<div class="ctn__filters__search">
			<?php
				$currentlang = pll_current_language();
				if($currentlang=="en"): ?>
				<a class="detail_y__item_link" href="<?php echo esc_url( home_url( 'create' ) ); ?>" ><?php _e('Create your own journey','colorfull') ?></a>
				<?php  elseif($currentlang=="es"): ?>
				<a class="detail_y__item_link" href="<?php echo esc_url( home_url( '/es/crea-tu-propio-viaje/' ) ); ?>" ><?php _e('Crea tu propio viaje','colorfull'); ?></a>
			<?php endif; ?>
	    </div>
	</div>
</div>
<div class="ctn__items__gnral">
  <div class="ctn__items__gnral__wrap wrapper__container">
  </div>
</div>
<div class="overlay__filter"></div>

<?php get_footer(); ?>

<?php
  $range_prices = get_range_prices("j");
  $price_min = $range_prices[0];
  $price_max = $range_prices[1];

  if(isset($_GET["price"]) && $_GET["price"] != "") {
    $prices = explode(",", $_GET["price"]);
    $price_min = $prices[0];
    $price_max = $prices[1];
  }

  //_d($range_prices, "RANGE PRICES: ");
?>
<?php if (false): ?>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php endif ?>
<script type="text/javascript">
  var busy = false;
  var n_total_posts = <?php echo pll_count_posts(pll_current_language(), ["post_type" => "journey"]) ?>;
  // alert(n_total_posts);
  var cont = 1;
  var n_post_request = 8;
  var hay_param = ("<?php echo $_SERVER['QUERY_STRING'] ?>" == "")? false : true;
  var global_param = "<?php echo $_SERVER['QUERY_STRING'] ?>";
  var contenedor = ".ctn__items__gnral__wrap";

  /* Load posts */
  function append_posts(n_post, aux = 1) {
    if(n_total_posts <= n_post_request * (cont - 1)) return;
    if(busy) return;
    busy = true;

    jQuery.ajax({
      url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
      data: {
        action: "sugjourney",
        n_request: (hay_param? -1 : (n_post * aux)),
        paged: (hay_param? 1 : cont),
        params: global_param
      },
      success: function(msg) {
        // jQuery(".ctn__items__gnral__wrap__sec").append(msg);
        // alert(msg);
        jQuery(contenedor + " script").remove();
        jQuery(".loading-results").remove();
        jQuery(contenedor).append(msg);
        cont += aux;
      }
    });
  }
  jQuery( "#slider-range" ).slider({
    range: true,
    min: <?php echo $range_prices[0] ?>,
    max: <?php echo $range_prices[1] ?>,
    step: 10,
    values: [<?php echo $price_min ?>, <?php echo $price_max ?> ],
    slide: function( event, ui ) {
      jQuery( "#amount" ).val( "<?php price_pre() ?>" + ui.values[ 0 ] + " - <?php price_pre() ?>" + ui.values[ 1 ] );
    }
  });
  jQuery( "#amount" ).val( "<?php price_pre() ?>" + jQuery( "#slider-range" ).slider( "values", 0 ) +
    " - <?php price_pre() ?>" + jQuery( "#slider-range" ).slider( "values", 1 ) );

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
</script>