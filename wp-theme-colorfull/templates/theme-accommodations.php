<?php
/* Template Name: Template - Accommodations*/
get_header(); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php echo do_shortcode('[slider__default__one post_type="acommodation" title="' . get_the_title() .'"]'); ?>
<div class="ctn__filters filter__accomodations" id="filter_box">
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
	                        <label class="label__cat__product" for="<?php echo $post->post_name; ?>">
	                           <?php the_title(); ?>
	                        </label>
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
        <?php $_class = (isset($_GET["category"]) && $_GET["category"] != "")? "colorsTwo activeTwo" : ""; ?>
        <p class="filter__item__parraf btnFilter <?php echo $_class ?>"><?php _e('Type','colorfull') ?></p>
        <div class="filter__item__ctn list-none">
          <form id="filter__form__type" action="<?php echo get_permalink(); ?>" method="GET" data-taxo="category">
            <div class="filter__form__ctn">
              <h3><?php _e('Type','colorfull') ?></h3>
              <?php
                  $terms = get_terms(array(
                  	"taxonomy" => "accomodation_category",
                  	"hide_empty" => false
                  ));
                  if ( $terms ) {
                    echo "<ul class='filter__item__list'>";
                    foreach( $terms as $term ) {
                      $selectedCategoria = '';
                      if( isset( $_GET['category'] )  ) { 
                        $arr = explode(",", $_GET["category"]);
                        if( in_array( $term->slug, $arr ) ) {
                          $selectedCategoria = ' checked="checked"';
                        }
                      } ?>
                      <li>
                        <input type="checkbox" value="<?php echo $term->slug ?>" name="accomodation_category[]" <?php echo $selectedCategoria ?> class="checkbox__filters styled-checkbox" id="<?php echo $term->slug ?>">
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
			<p  id="select_price_filter" class="filter__item__parraf btnFilter <?php echo $_class ?>"><?php _e('Price','colorfull') ?></p>
			<div class="filter__item__ctn list-none">
				<form id="filter__form__price" action="<?php echo get_permalink(); ?>" method="GET" >
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
	    <div class="filter__item  btn__price__filter">
        <?php $_class = (isset($_GET["room"]) && $_GET["room"] != "")? "colorsTwo activeTwo" : ""; ?>
   			<p class="filter__item__parraf btnFilter <?php echo $_class ?>"><?php _e('Bedroom','colorfull') ?></p>
   			<div class="filter__item__ctn list-none">
          		<form id="filter__form__bedroom" action="<?php echo get_permalink(); ?>" method="GET" data-taxo="room">
	        		<div class="filter__form__ctn">
	        			<h3><?php _e('Price','colorfull') ?></h3>
	        			<?php
		                  $terms = get_terms(array(
		                  	"taxonomy" => "bedroom",
		                  	"hide_empty" => false
		                  ));
		                  if ( $terms ) {
		                    echo "<ul class='filter__item__list'>";
		                    foreach( $terms as $term ) {
		                      $selectedCategoria = '';
		                      if( isset( $_GET['room'] )  ) {
                            $arr = explode(",", $_GET["room"]);
		                        if( in_array( $term->slug, $arr ) ) {
		                          $selectedCategoria = ' checked="checked"';
		                        }
		                      } ?>
		                      <li>
		                        <input type="checkbox" value="<?php echo $term->slug ?>" name="bedroom[]" <?php echo $selectedCategoria ?> class="checkbox__filters styled-checkbox" id="<?php echo $term->slug ?>">
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

		<div class="ctn__search">
			<button class="ctn__search__button"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-search.png" alt=""/></button>
			<input type="search" placeholder="<?php _e('Search', 'colorfull'); ?>" name="search">
		</div>
    </div>
    <div class="search__mobile">
		<span class="icon-cross"></span>
		<img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-search.png" alt=""/>
	</div>
  </div>
</div>
<div class="ctn__items__gnral ">
    <?php
    if(isset($_GET["search"]) && $_GET["search"] != ""): ?>
    <div class="search_results--box">
      <h1><?php _e("Search results for: ", "colorfull"); echo "\"" . $_GET['search'] . "\"";?></h1>
      <a href="#"><?php _e("Return to list", "colorfull"); ?></a>
    </div>
    <?php
    endif;
    ?>
  <div class="ctn__items__gnral__wrap wrapper__container items__prin__accommodations">
    <!--  -->
  </div>
</div>

<div class="overlay__filter"></div>

<?php get_footer(); ?>

<?php
  $range_prices = get_range_prices("a");
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
  function search_results(query) {
    jQuery.ajax({
      url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
      data: {
        action: "search_results",
        search: query
      },
      success: function(msg) {
        jQuery(".search_results--box").remove();
        jQuery(".ctn__items__gnral").prepend(msg);
      }
    });
  }

  var n_total_posts = <?php echo pll_count_posts(pll_current_language(), ["post_type" => "acommodation"]) ?>;
  var cont = 1;
  var n_post_request = 12;
  var hay_param = ("<?php echo $_SERVER['QUERY_STRING'] ?>" == "")? false : true;
  var global_param = "<?php echo $_SERVER['QUERY_STRING'] ?>";
  var contenedor = ".ctn__items__gnral__wrap";
  var search_term = "<?php echo $_GET['search']; ?>";

  jQuery('.search__mobile').click(function(event) {
    jQuery(this).toggleClass('active');
    jQuery('.ctn__filters__items').toggleClass('active__mobile');
    jQuery('.ctn__filters__search').toggleClass('active__mobile');
    jQuery('.ctn__search').toggleClass('active__mobile');
  });
  /* Load posts */
  function append_posts(n_post, aux = 1) {
    if(n_total_posts <= n_post_request * (cont - 1)) return;
    if(busy) return;
    busy = true;

    jQuery.ajax({
      url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
      data: {
        action: "accom",
        n_request: (hay_param? -1 : (n_post * aux)),
        paged: (hay_param? 1 : cont),
        params: global_param,
        search: search_term
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
    // values: [ 0, 5000 ],
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
      // console.log("Position: " + position + " vs Bottom: " + bottom + " = " + (bottom - position));
      console.log(n_post_request * (cont - 1));
      append_posts(n_post_request);
    }
  });
</script>