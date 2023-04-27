<?php get_header(); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php echo do_shortcode('[slider__default__one post_type="journey" title="' .  get_the_title() .'"]'); ?>
<div class="ctn__filters filter__suggested">
	<div class="ctn__filters__wrap wrapper__container">
		<div class="ctn__filters__items">
      <div class="filter__item ">
        <p class="filter__item__parraf btnFilter"><?php _e('Region','colorfull') ?></p>
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
        <p class="filter__item__parraf btnFilter"><?php _e('Trip type','colorfull') ?></p>
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
			<div class="filter__item  btn__price__filter">
       			<p class="filter__item__parraf btnFilter"><?php _e('Price','colorfull') ?></p>
       			<div class="filter__item__ctn list-none">
	          		<form id="filter__form__region" action="<?php echo get_permalink(); ?>" method="GET">
	            		<div class="filter__form__ctn">
	            			<h3><?php _e('Price','colorfull') ?></h3>
	            			<p><?php _e('The average price is US$ ','colorfull') ?> <?php _e('1250','colorfull') ?></p>
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
	    	<a href="<?php echo esc_url( home_url( 'create' ) ); ?>" class="btn__create"><?php _e('Create your own journey','colorfull') ?></a>
	    </div>
	</div>
</div>
<div class="ctn__items__gnral">
  <div class="ctn__items__gnral__wrap wrapper__container">
    <!--  -->
  </div>
</div>
<div class="overlay__filter"></div>

<?php get_footer(); ?>

<?php
  $price_min = 0;
  $price_max = 5000;
  if(isset($_GET["price"]) && $_GET["price"] != "") {
    $prices = explode(",", $_GET["price"]);
    $price_min = $prices[0];
    $price_max = $prices[1];
  }

?>

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function($){
    var n_total_posts = <?php echo wp_count_posts("destination")->publish; ?>;
    var cont = 1;
    var n_post_request = 8;
    var hay_param = ("<?php echo $_SERVER['QUERY_STRING'] ?>" == "")? false : true;

    /* Load posts */
    function append_posts(n_post, aux = 1) {
      if(n_total_posts <= n_post_request * (cont - 1)) return;

      jQuery.ajax({
        url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
        data: {
          action: "sugjourney",
          n_request: (hay_param? -1 : (n_post * aux)),
          paged: (hay_param? 1 : cont),
          params: "<?php echo $_SERVER['QUERY_STRING'] ?>"
        },
        success: function(msg) {
          // jQuery(".ctn__items__gnral__wrap__sec").append(msg);
          jQuery(".ctn__items__gnral__wrap").append(msg);
          cont += aux;
        }
      });
    }
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 5000,
      // values: [ 0, 5000 ],
      values: [<?php echo $price_min ?>, <?php echo $price_max ?> ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "US$" + ui.values[ 0 ] + " - US$" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "US$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - US$" + $( "#slider-range" ).slider( "values", 1 ) );

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
  });
</script>