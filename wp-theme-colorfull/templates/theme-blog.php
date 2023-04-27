<?php
/* Template Name: Template - Blog*/
get_header(); ?>
<?php echo do_shortcode('[slider__default__one post_type="post" title="' . get_the_title() .'"]'); ?>
<div class="ctn__filters filter__blog"  id="filter_box">
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
    </div>

    <div class="ctn__filters__search">
        <?php
        $currentlang = pll_current_language();
        if($currentlang=="en"): ?>
        <a href="<?php echo esc_url( home_url( 'create' ) ); ?>" class="btn__create"><?php _e('Create your own journey','colorfull') ?></a>
        <?php  elseif($currentlang=="es"): ?>
        <a href="<?php echo esc_url( home_url( '/es/crea-tu-propio-viaje/' ) ); ?>" class="btn__create"><?php _e('Crea tu propio viaje','colorfull'); ?></a>
      <?php endif; ?>
      </div>
  </div>
</div>

<div class="ctn__items__gnral ">
  <div class="ctn__items__gnral__wrap wrapper__container items__prin__blog">
      <?php if (false) {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array( 
        'post_type' => 'post', 
        'posts_per_page' => -1,
        'paged' => $paged,
        'post_status' => 'publish');
        $wp_query = new WP_Query($args);
        if(false or $wp_query->have_posts()) :  ?>
          <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            <div class="item__gnral">
              <a href="<?php the_permalink(); ?>" class="g__item__three" >
          <span></span>
          <div class="g__item__two__inside">
             <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
            <figure style="background-image: url('<?php echo $backgroundImg[0];  ?>');"></figure>
            <figcaption>
              <section>
                <h3><?php the_title(); ?></h3>
                <h4><?php the_author(); ?></h4>
                    <?php $date_day = ''.get_the_date('j').'';  ?>
                    <?php $date_month = ''.get_the_date('F').'';  ?>
                    <?php $date_year = ''.get_the_date('Y').'';  ?>
                    <h5><?php echo $date_day; ?> <?php echo $date_month; ?>, <?php echo $date_year; ?></h5>
                    <div>
                      <p><?php the_excerpt_max_charlength(100); ?></p>
                      <span><?php _e('More','colorfull')?></span>
                    </div>
                  </section>
                </figcaption>
              </div>
            </a>
            </div>
          <?php endwhile;
        wp_reset_postdata(); ?>
      <?php endif; }?>
  </div>
</div>

<div class="overlay__filter"></div>
<?php get_footer(); ?>
<script>
  jQuery(document).ready(function($){
    $('.slider__principal__title').addClass('slider__blog__title');
  });
</script>

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
  var busy = false;
  var n_total_posts = <?php echo pll_count_posts(pll_current_language(), ["post_type" => "post"]) ?>;
  var cont = 1;
  var n_post_request = 6;
  var hay_param = ("<?php echo $_SERVER['QUERY_STRING'] ?>" == "")? false : true;
  var global_param = "<?php echo $_SERVER['QUERY_STRING'] ?>";
  var contenedor = ".ctn__items__gnral__wrap";

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
        action: "posts",
        n_request: (hay_param? -1 : (n_post * aux)),
        paged: (hay_param? 1 : cont),
        params: global_param
      },
      success: function(msg) {
        // jQuery(".ctn__items__gnral__wrap__sec").append(msg);
        jQuery(contenedor + " script").remove();
        jQuery(".loading-results").remove();
        jQuery(contenedor).append(msg);
        cont += aux;
      }
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
</script>