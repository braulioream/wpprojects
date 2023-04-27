<?php



function register_my_session() {
  if( !session_id() ) session_start();

  // if(!isset($_SESSION["cambio_pre"])) $_SESSION["cambio_pre"] = "USD";
  // if(!isset($_SESSION["cambio"])) $_SESSION["cambio"] = 1;
}

add_action('init', 'register_my_session');

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
  'page_title'    => 'Configuración General',
  'menu_title'    => 'Configuraciones',
  'menu_slug'     => 'theme-general-settings',
  'capability'    => 'edit_posts',
  'redirect'      => false,
  'position'      => '2.1',
  'icon_url'      => 'dashicons-admin-settings',
  ));
}


add_image_size( 'size-default', '800', '800', array( "1", "") );

// Register menu
register_nav_menus(array(
  "header" => __("Menu Header", ""),
  "footer" => __("Menu Footer", ""),
));

function get_price_pre() {
  return isset($_SESSION["cambio_pre"])? $_SESSION["cambio_pre"] : "USD";
}

function price_pre() {
  echo get_price_pre();
}

function get_journey_price($id) {
  $price = 0;

  if(($a = get_field("tour_prices", $id)) &&
           is_numeric($a["journey_tourist_price"]) &&
           is_numeric($a["journey_suptourist_price"]) &&
           is_numeric($a["journey_superior_price"]) &&
           is_numeric($a["journey_deluxe_price"])) {
    $price = min($a["journey_tourist_price"], 
                 $a["journey_suptourist_price"],
                 $a["journey_superior_price"],
                 $a["journey_deluxe_price"]);
  } else $price = 0;

  $cambio = isset($_SESSION["cambio"])? floatval($_SESSION["cambio"]) : 1;

  // _d($price. ", " . $cambio);

  return ceil($price * $cambio);
}

function get_fixed_price($n) {
  $cambio = isset($_SESSION["cambio"])? floatval($_SESSION["cambio"]) : 1;

  return ceil($n * $cambio);
}

function get_accom_price($id) {
  $precio_min = 100000;

  if(have_rows("acom_rooms", $id)) {
    while(have_rows("acom_rooms", $id)) {
      the_row();
      // echo "<script>console.log('" . get_sub_field("acom_room_precio") . "');</script>";
      $precio_min = min($precio_min, get_sub_field("acom_room_precio"));
    }
  }

  $cambio = isset($_SESSION["cambio"])? floatval($_SESSION["cambio"]) : 1;

  return ceil($precio_min * $cambio);
}

function get_suggested_journeys($items, $general_id = -1, $tipo = "journey") {
  /*
   * $dest es el arreglo de destinations con los que debe coincidir 
   */

  $dest = array();

  if($general_id != -1 && $tipo != "home") $dest = get_dest_array($general_id, $tipo);

  if(empty($dest)) {
    if($tipo == "home") {
      if(have_rows("inicio_suggested_lista", $general_id)) {
      echo "<nav>";
      while(have_rows("inicio_suggested_lista", $general_id)) {
        the_row();

        global $post;
        $post = get_sub_field("inicio_suggested_item");
        setup_postdata($post);
      ?>
        <a href="<?php echo get_the_permalink() ?>" class="g__item__one detail_y__experiencie__item">
        <figure style="background-image:url('<?php the_post_thumbnail_url('size-default'); ?>')"><span></span></figure>
        <figcaption>
          <section>
          <?php the_title("<h3>", "</h3>") ?>
          <span><?php _e("starting at ", "colorfull"); echo get_price_pre() . " " . get_journey_price(get_the_ID()) ?></span>
          <span><?php _e('find out more','colorfull'); ?> -></span>
          </section>
        </figcaption>
        </a>
      <?php 
      }
      echo "</nav>";
      }

      return;
    }

    $args = array(
      "post_type" => "journey",
      "posts_per_page" => $items
    );
    if($general_id != -1) {
      $args["orderby"] = "rand";
      $args["post__not_in"] = [$general_id];
    }
    
    $q = new WP_Query($args);
    
    if($q->have_posts()) {
    echo $general_id != -1? '<div class="detail_y__experiencie__items wrapper__container">' : "<nav>";
    while($q->have_posts()) {
      $q->the_post();
    ?>
      <a href="<?php echo get_the_permalink() ?>" class="g__item__one detail_y__experiencie__item">
      <figure style="background-image:url('<?php the_post_thumbnail_url('size-default'); ?>')"><span></span></figure>
      <figcaption>
        <section>
        <?php the_title("<h3>", "</h3>") ?>
        <span><?php _e("starting at ", "colorfull"); echo get_price_pre() . " " . get_journey_price(get_the_ID()) ?></span>
        <span><?php _e('find out more','colorfull'); ?> -></span>
        </section>
      </figcaption>
      </a>
    <?php 
    }
    echo $general_id != -1? "</div>" : "</nav>";
    }
  } else { //Es uno interno
    $args = array("post_type" => "journey", "fields" => "ids", "orderby" => "rand", "posts_per_page" => -1); //Sacará todos
    $q = new WP_Query($args);
    $posts = array();
    $rand = array();

    // _d($dest, "Destinations:");

    if($q->have_posts()) {
      $cont = 0;
      while($q->have_posts() && $cont < $items) {
        $q->the_post();
        global $post;

        $comp = array_intersect($dest, get_dest_array($post, "journey"));
        if($general_id != $post) {
          if(!empty($comp)) {
            $posts[] = $post;
            ++$cont;
          } else {
            $rand[] = $post;
          }
        }
      }
    }

    for($i = 0; $i < $items - $cont; ++$i) $posts[] = $rand[$i];

    // _d($posts);

    if(!empty($posts)): ?>
    <div class="detail_y__experiencie__items wrapper__container">
      <?php foreach($posts as $index => $id): global $post; $post = get_post($id); setup_postdata( $post ); ?>
        <a href="<?php the_permalink(); ?>" class="g__item__one detail_y__experiencie__item">
          <figure style="background-image: url('<?php the_post_thumbnail_url(); ?>');"><span></span></figure>
          <figcaption>
            <section>
              <h3><?php the_title(); ?></h3>
              <span><?php _e("starting at ", "colorfull"); echo get_price_pre() . " " .  get_journey_price(get_the_ID()) ?></span>
              <span><?php _e('find out more','colorfull'); ?> -></span>
            </section>
          </figcaption>
        </a>
      <?php endforeach; ?>
    </div>
    <?php endif;
  }
  wp_reset_query();
}

function get_destinations($general_id = -1) {  
  if(have_rows("inicio_dest_lista", $general_id)) {
  echo "<ul>";
  while(have_rows("inicio_dest_lista", $general_id)) {
    the_row();
    global $post;
    $post = get_sub_field("inicio_dest_item");
    setup_postdata($post);
  ?>
    <li>
      <a href="<?php echo get_the_permalink(); ?>">
          <div class="destination__item__bckgrnd" style="background-image:url('<?php the_post_thumbnail_url('size-default'); ?>')">
          </div>
          <div class="destination__item__data">
            <h1><?php the_title(); ?></h1>
          </div>
      </a>
    </li>

  <?php 
  }
  echo "</ul>";
  }
  // wp_reset_query();
}

function get_accom($items, $general_id = -1, $tipo = "accom") {
  $dest = array();
  if($general_id != -1 && $tipo != "home") $dest = get_dest_array($general_id, $tipo);

  if(empty($dest)) {
    if($tipo == "home") {
      if(have_rows("inicio_accom_lista", $general_id)) {
      echo "<nav>";
      while(have_rows("inicio_accom_lista", $general_id)) {
        the_row();
        global $post;
        $post = get_sub_field("inicio_accom_item");
        setup_postdata( $post );
      ?>
        <a href="<?php echo get_the_permalink() ?>" class="g__item__two ?>">
        <span></span>
        <div class="g__item__two__inside">
          <figure class="accom__item__bckgrnd" style="background:url('<?php the_post_thumbnail_url('size-default'); ?>')">
          </figure>
          <figcaption>
          <section>
            <?php the_title("<h3>", "</h3>") ?>
            <h4><?php echo get_post_field("post_title", get_field("tag_destination")[0]); ?></h4>
            <p><?php _e("starting at ", "colorfull"); echo get_price_pre() . " " . get_accom_price(get_the_ID()) ?></p>
          </section>
          </figcaption>
        </div>
        </a>
      <?php 
      }
      echo "</nav>";
      }
      return;
    }


    $args = array(
    "post_type" => "acommodation",
    "posts_per_page" => $items
    );

    if($general_id != -1) {
      $args["orderby"] = "rand";
      $args["post__not_in"] = [$general_id];
    }
    
    $q = new WP_Query($args);
    
    if($q->have_posts()) {
    echo $general_id != -1? '<div class="detail_y__acommodations__items">' : "<nav>";
    while($q->have_posts()) {
      $q->the_post();
    ?>
      <a href="<?php echo get_the_permalink() ?>" class="g__item__two <?php echo $general_id != -1? 'detail_y__acommodations__item' : '' ?>">
      <span></span>
      <div class="g__item__two__inside">
        <figure class="accom__item__bckgrnd" style="background:url('<?php the_post_thumbnail_url('size-default'); ?>')">
        </figure>
        <figcaption>
        <section>
          <?php the_title("<h3>", "</h3>") ?>
          <h4><?php echo get_post_field("post_title", get_field("tag_destination")[0]); ?></h4>
          <p><?php _e("starting at ", "colorfull"); echo get_price_pre() . " " . get_accom_price(get_the_ID()) ?></p>
        </section>
        </figcaption>
      </div>
      </a>
    <?php 
    }
    echo $general_id != -1? '</div>' : "</nav>";
    }
  } else { //Es uno interno
    $args = array("post_type" => "acommodation", "fields" => "ids", "orderby" => "rand", "posts_per_page" => -1); //Sacará todos
    $q = new WP_Query($args);
    $posts = array();
    $rand = array();

    if($q->have_posts()) {
      $cont = 0;
      while($q->have_posts() && $cont < $items) {
        $q->the_post();
        global $post;

        $comp = array_intersect($dest, get_dest_array($post, "accom"));
        //_d($general_id, "GENERAL ID: ");
        if($general_id != $post) {
          if(!empty($comp)) {
            $posts[] = $post;
            ++$cont;
          } else {
            $rand[] = $post;
          }
        }
      }
    }

    //if($cont == 0) for($i = 0; $i < $items - $cont; ++$i) $posts[] = $rand[$i];
    for($i = 0; $i < $items - $cont; ++$i) $posts[] = $rand[$i];

    if(!empty($posts)): ?>
      <div class="detail_y__acommodations__items">
        <?php foreach($posts as $index => $id): global $post; $post = get_post($id); setup_postdata( $post ); ?>
        <a href="<?php the_permalink(); ?>" class="detail_y__acommodations__item g__item__two">
          <span></span>
          <div class="g__item__two__inside">
            <figure style="background-image: url('<?php the_post_thumbnail_url(); ?>');"></figure>
            <figcaption>
              <section>
                <h3><?php the_title(); ?></h3>
                <h4><?php echo get_post_field("post_title", get_field("tag_destination")[0]); ?></h4>
                <p><?php _e("starting at ", "collorful"); echo get_price_pre() . " " . get_accom_price(get_the_ID()) ?></p>
              </section>
            </figcaption>
          </div>
        </a>
        <?php endforeach; ?>
        <?php wp_reset_query(); ?>
      </div>
    <?php endif;
  }
  wp_reset_query();
}

function get_blog_posts($items, $general_id = -1, $tipo = "post") {
  if($tipo == "home") {
    if(have_rows("inicio_post_lista", $general_id)) {
    echo "<nav>";
    while(have_rows("inicio_post_lista", $general_id)) {
      the_row();
      global $post;
      $post = get_sub_field("inicio_post_item");
      setup_postdata( $post );
    ?>
      <a href="<?php echo get_the_permalink() ?>" class="g__item__three">
      <span></span>
      <div class="g__item__two__inside">
        <figure class="accom__item__bckgrnd" style="background-image:url('<?php the_post_thumbnail_url('size-default'); ?>')">
        </figure>        
        <figcaption>
        <section>
          <?php the_title("<h3>", "</h3>") ?>
          <h4><?php echo get_the_author() ?></h4>
          <h5><?php echo get_the_date() ?></h5>
          <div><?php echo get_the_excerpt() ?>
          <span><?php _e('More','colorfull')?></span></div>
        </section>
        </figcaption>
      </div>
      </a>
    <?php 
    }
    echo "</nav>";
    }
    return;
  }
  $dest = array();
  if($general_id != -1) $dest = get_dest_array($general_id, $tipo);

  if(empty($dest)) {
    $args = array(
    "post_type" => "post",
    "posts_per_page" => $items
    );

    if($general_id != -1) {
      $args["orderby"] = "rand";
      $args["post__not_in"] = [$general_id];
    }
    
    $q = new WP_Query($args);
    
    if($q->have_posts()) {
    echo $general_id != -1? '<div class="detail_y__more__items wrapper__container">' : "<nav>";
    while($q->have_posts()) {
      $q->the_post();
    ?>
      <a href="<?php echo get_the_permalink() ?>" class="g__item__three <?php echo $general_id != -1? 'detail_y__more__item' : '' ?>">
      <span></span>
      <div class="g__item__two__inside">
        <figure class="accom__item__bckgrnd" style="background-image:url('<?php the_post_thumbnail_url('size-default'); ?>')">
        </figure>        
        <figcaption>
        <section>
          <?php the_title("<h3>", "</h3>") ?>
          <h4><?php echo get_the_author() ?></h4>
          <h5><?php echo get_the_date() ?></h5>
          <div><?php echo get_the_excerpt() ?>
          <span><?php _e('More','colorfull')?></span></div>
        </section>
        </figcaption>
      </div>
      </a>
    <?php 
    }
    echo $general_id != -1? '</div>' :  "</nav>";
    }
  } else {
    $args = array("post_type" => "post", "fields" => "ids", "orderby" => "rand", "posts_per_page" => -1);
    $q = new WP_Query($args);
    $posts = array();
    $rand = array();

    if($q->have_posts()) {
      $cont = 0;
      while($q->have_posts() && $cont < $items) {
        $q->the_post();
        global $post;

        $comp = array_intersect($dest, get_dest_array($post, "post"));
        if($general_id != $post) {
          if(!empty($comp)) {
            $posts[] = $post;
            ++$cont;
          } else {
            $rand[] = $post;
          }
        }
      }
    }

    for($i = 0; $i < $items - $cont; ++$i) $posts[] = $rand[$i];

    if(!empty($posts)): ?>
    <div class="detail_y__more__items wrapper__container">
      <?php foreach($posts as $index => $id): global $post; $post = get_post($id); setup_postdata( $post ); ?>
      <a href="<?php the_permalink(); ?>" class="g__item__three detail_y__more__item">
        <span></span>
        <div class="g__item__two__inside">
          <figure style="background-image: url('<?php the_post_thumbnail_url(); ?>');"><span></span></figure>
          <figcaption>
            <section>
              <h3><?php the_title(); ?></h3>
              <h4><?php echo get_the_author() ?></h4>
              <h5><?php echo get_the_date() ?></h5>
              <div>
                <?php the_excerpt_max_charlength(100) ?>
                <span><?php _e('More','colorfull')?></span>
              </div>
            </section>
          </figcaption>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif;
  }
  wp_reset_query();
}


// social media
function wp_custom_social_media($content = null) {
  ob_start(); ?>
  <?php if( have_rows('list_social_media', 'options') ): ?>
		  <ul>
			<?php while( have_rows('list_social_media', 'options') ): the_row(); ?>
			  <?php 
				$name_select_sub_field = (get_sub_field_object('tipo_social_media'));
				$name_sub_field = get_sub_field('tipo_social_media');
				$label_select = ($name_select_sub_field['choices'][$name_sub_field]);
			  ?>
			   <?php if( $name_sub_field == 'whatsapp' ) { ?>
	  		<li>
			<a  class="icon-<?php the_sub_field( 'tipo_social_media' ); ?>" target="_blank" href="https://api.whatsapp.com/send?phone=<?php the_field( 'celular', 'options' ); ?>&text=<?php _e('Conversa con Concyssa','concyssa') ?>">
						
					</a>
			</li>
		<?php } elseif( $name_sub_field != 'whatsapp' ) {  ?>
				<?php if( get_sub_field('url_social_media', 'options') ) { ?>
				<li>
				  <a class="icon-<?php the_sub_field( 'tipo_social_media' ); ?>" href="<?php the_sub_field('url_social_media', 'options'); ?>" target="_blank"> </a>
				</li>
	  <?php } ?>
		<?php } ?>

		
	<?php endwhile; ?>
		  </ul>
		<?php endif;
  $content = ob_get_contents();
  ob_end_clean();
  return $content;  
}

add_shortcode('social_media_list', 'wp_custom_social_media');

add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
  wp_enqueue_style( 'dashicons' );
}

add_action( 'wp_enqueue_scripts', 'sd__custom__style__script' );
function sd__custom__style__script(){
  wp_enqueue_script('jquery');
  wp_enqueue_script("jquery-ui-slider");

  // main
  wp_register_script( 'main-js', get_stylesheet_directory_uri() . '/assets/js/main.js');
  wp_enqueue_script('main-js');

  //wp_register_script( 'touch-punch', get_stylesheet_directory_uri() . '/assets/js/jquery.ui.touch-punch.min.js');
  //wp_enqueue_script('touch-punch');

  // slick
  wp_enqueue_style( 'slick-css', get_stylesheet_directory_uri() . '/assets/js/slick/slick.css');
  wp_register_script( 'slick-js', get_stylesheet_directory_uri() . '/assets/js/slick/slick.min.js');
  wp_enqueue_style('slick-css');
  wp_enqueue_script('slick-js');

  // aos
  wp_enqueue_style( 'aos-css', get_stylesheet_directory_uri() . '/assets/js/aos/aos.css');
  wp_register_script( 'aos-js', get_stylesheet_directory_uri() . '/assets/js/aos/aos.js');
  wp_enqueue_style('aos-css');
  wp_enqueue_script('aos-js');

  // ligthgallery
  wp_enqueue_style( 'lightgallery-css', get_stylesheet_directory_uri() . '/assets/js/lightgallery/fancy-full/lightgallery.css');
  wp_enqueue_style( 'lightgallery-comment', get_stylesheet_directory_uri() . '/assets/js/lightgallery/fancy-full/lg-fb-comment-box.css');
  wp_enqueue_style( 'lightgallery-transition', get_stylesheet_directory_uri() . '/assets/js/lightgallery/fancy-full/lg-transitions.css');
  wp_register_script( 'ligthgallery', get_stylesheet_directory_uri() . '/assets/js/lightgallery/fancy-full/lightgallery.js');
  wp_register_script( 'ligthgallery-fullscreen', get_stylesheet_directory_uri() . '/assets/js/lightgallery/fancy-full/lg-fullscreen.js');
  wp_register_script( 'ligthgallery-thumbnail', get_stylesheet_directory_uri() . '/assets/js/lightgallery/fancy-full/lg-thumbnail.js');
  wp_register_script( 'ligthgallery-zoom', get_stylesheet_directory_uri() . '/assets/js/lightgallery/fancy-full/lg-zoom.js');
  wp_register_script( 'ligthgallery-video', get_stylesheet_directory_uri() . '/assets/js/lightgallery/fancy-full/lg-video.js');
  wp_register_script( 'ligthgallery-autoplay', get_stylesheet_directory_uri() . '/assets/js/lightgallery/fancy-full/lg-autoplay.js');


  wp_enqueue_style('lightgallery-css');
  wp_enqueue_style('lightgallery-comment');
  wp_enqueue_style('lightgallery-transition');
  wp_enqueue_script('ligthgallery');
  wp_enqueue_script('ligthgallery-fullscreen');
  wp_enqueue_script('ligthgallery-thumbnail');
  wp_enqueue_script('ligthgallery-zoom');
  wp_enqueue_script('ligthgallery-video');
  wp_enqueue_script('ligthgallery-autoplay');
  }


  // Register sidebar - widgets

function register_widgets_array() {
  $sidebars = array (
    'language'      => 'Idioma',
  );  
  foreach ( $sidebars as $id => $sidebar) {
  register_sidebar(
    array (
      'name'          => __( $sidebar, 'colorfull' ),
      'id'            => $id,
      'before_widget' => '<div class="widget" id="%1$s"><div id="margin-custom">',
      'after_widget'  => '</div></div>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
    ));
  }
}

add_action( 'widgets_init', 'register_widgets_array' );

add_filter('show_admin_bar', '__return_false');

add_action('after_setup_theme', 'language_theme_setup');
 
function language_theme_setup(){
    load_theme_textdomain('colorfull', get_template_directory() . '/languages');
}

// Support Titulos
add_theme_support( 'title-tag' );

/*-----------------------------------
Shortcode [default one]
-----------------------------------*/

function wp_slider__default__one($atts, $content = null) {
  $a = shortcode_atts( array(
  'post_type' => 'default',
  'title' => ''
  ), $atts );
  ob_start();
  $args = array(
    'post_type' => $atts['post_type'],
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_query' => array(
      array(
        'key' => 'add_slider_check', 
        'value' => '"Add"',
        'compare' => 'LIKE'
      )
    ) 
  );

  $wp_query = new WP_Query($args);
  ?>
  <?php if($wp_query->have_posts()) : ?>
    <section class="inicio__slide">
      <section class="slider__principal">
      <div class="slider__principal__info">
        <h2><?php echo $atts['title'] ?></h2>
      </div>
      <ul class="slider__principal__list slider__principal--pitcher">
      <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
        <li class="slider__principal__item">

        <a href="<?php the_permalink(); ?>" class="slider__principal__item__image" style="background-image: url('<?php the_post_thumbnail_url(); ?>'">
        </a>
        <div class="slider__principal__title">  
          <h3>
          <?php
            the_title();
            if($atts["post_type"] == "acommodation") echo " - " . get_post_field("post_title", get_field("tag_destination")[0]);
          ?>
          </h3>
          <?php 
            if($atts['post_type'] == 'journey'){
              $price = get_journey_price(get_the_ID()); ?>
              <p><?php _e('from','colorfull')?> <?php echo get_price_pre() . " " . $price ?>     </p>
            <?php
          }
            
            elseif ($atts['post_type'] == 'acommodation') {
              $price = get_accom_price(get_the_ID()); ?>
              <p><?php _e('from','colorfull')?> <?php echo get_price_pre() . " " . $price ?>     </p>
              <?php
            }
           ?>
          
          <?php $date_day = ''.get_the_date('j').'';  ?>
          <?php $date_month = ''.get_the_date('F').'';  ?>
          <?php $date_year = ''.get_the_date('Y').'';  ?>
          <h4><?php echo $date_day; ?> <?php echo $date_month; ?>, <?php echo $date_year; ?></h4>
        </div>
        </li>
      <?php endwhile; ?>
      <?php wp_reset_query(); ?>
      </ul>
      </section>
    </section>
  <?php endif; ?>
  <?php  
  $content = ob_get_contents();
  ob_end_clean();
  return $content;  
}

add_shortcode('slider__default__one', 'wp_slider__default__one');


/*-----------------------------------
Shortcode [default two]
-----------------------------------*/

function wp_slider__default__two($content = null) { 
  if(have_posts()) : while(have_posts()) : the_post(); ?>
  <section class="inicio__slide">
    <section class="slider__principal">
    <ul class="slider__principal__list slider__principal--pitcher">
      <?php if ( has_post_thumbnail() ) { ?>
      <li class="slider__principal__item">
      <div class="slider__principal__item__image" style="background-image: url('<?php the_post_thumbnail_url(); ?>">
      </div>
      <div class="slider__principal__container">
        <div class="slider__principal__info">
        <div class="slider__principal__info__title">
          <h3><?php the_title(); ?></h3>
        </div>
        </div>
      </div>
      </li>
       <?php 
        }
      ?>
    <?php 
      $images = get_field('galeria_post');
      $size = 'thumbnail-galeria-post';
      $i = 1;
      if( $images ): ?>
      <?php foreach( $images as $image ): $i++ ?>
        <li class="slider__principal__item">
        <div class="slider__principal__item__image" style="background-image: url('<?php echo $image['url']?>">
        </div>
        <div class="slider__principal__container">
          <div class="slider__principal__info">
          <div class="slider__principal__info__title">
            <h3><?php the_title(); ?></h3>
          </div>
          </div>
        </div>
        </li>
        <?php endforeach; ?>
      <?php endif;
    ?>
    </ul>
    </section>
  </section>
  
  <?php 
  endwhile; 
  wp_reset_query(); ?>
  <?php endif; ?>
  <?php  
  $content = ob_get_contents();
  ob_end_clean();
  return $content;  
}

add_shortcode('slider__default__two', 'wp_slider__default__two');


/*-----------------------------------
  Create Your Own Journey - F O R M
  Añadir el campo especial
-----------------------------------*/

add_filter( 'wpcf7_special_mail_tags', 'sd_cf7_special_mail_tag', 10, 3 );
function sd_cf7_special_mail_tag( $output, $name, $html ) {
  $submission = WPCF7_Submission::get_instance();
  if ( ! $submission ) {
    return $output;
  }
  if ( 'form-contenido' == $name ) {
    $new_value = $submission->get_posted_data( 'form-contenido-hid' );
      $t = "<div>" . $new_value . "</div>";
      return $t;
  }
  return $output;
}

  /* Load Ajax Callback to "wp_ajax_*" Action Hook */
add_action( 'wp_ajax_destination', 'ajax_get_destinations' );
add_action( 'wp_ajax_nopriv_destination', 'ajax_get_destinations' );

function ajax_get_destinations() {
  // Parsear parámetros del Query
  $tax_queries = array();
  if(isset($_GET["params"]) && $_GET["params"] != "") {
  $params = $_GET["params"];
  $tax_queries["relation"] = "AND";

  $cats = explode("&", $params);
  foreach($cats as $cat) {
    $aux = explode("=", $cat);
    $cat_name = $aux[0];
    $cat_each = explode(",", $aux[1]);

    $tax_queries[] = array(
    "taxonomy" => $cat_name,
    "field"    => "slug",
    "terms"    => $cat_each
    );
  }
  }

  $args = array(
    'post_type' => 'destination', 
    'posts_per_page' => $_GET["n_request"],
    'paged' => $_GET["paged"],
    'post_status' => 'publish',
    "tax_query" => $tax_queries
  );


  $wp_query = new WP_Query($args);
   ?>
   <?php 
  if($wp_query->have_posts()) :  ?>
  <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
    <div class="item__gnral" data-lat="<?php the_field('latitud_destination');  ?>" data-long="<?php the_field('longitud_destination');  ?>">
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
  // wp_reset_postdata();
  endif;

  echo "<script>busy=false;</script>";
  wp_reset_query();
  wp_die(); // required. to end AJAX request.
}


add_action( 'wp_ajax_sugjourney', 'ajax_get_suggested_journeys' );
add_action( 'wp_ajax_nopriv_sugjourney', 'ajax_get_suggested_journeys' );

function ajax_get_suggested_journeys() {
  // Parsear parámetros del Query
  $tax_queries = array();
  $revisar_precios = false;
  if(isset($_GET["params"]) && $_GET["params"] != "") {
    $params = $_GET["params"];
    $tax_queries["relation"] = "AND";
    $revisar_precios = false;
    $slider_new_precio_min = 10000000;
    $slider_new_precio_max = -1;
    $average_price = 0;
    $cantidad_precios = 0;
    $precio_min = 0;
    $precio_max = 5000;
    $dest = array();

    $cats = explode("&", $params);
    foreach($cats as $cat) {
      $aux = explode("=", $cat);
      $cat_name = $aux[0];
      if($cat_name == "price") {
        $revisar_precios = true;
        $precios = explode(",", $aux[1]);

        $precio_min = $precios[0];
        $precio_max = $precios[1];

        continue;
      }
      $cat_each = explode(",", $aux[1]);

      if($cat_name != "location") {
        $tax_queries[] = array(
          "taxonomy" => $cat_name,
          "field"    => "slug",
          "terms"    => $cat_each
        );
      } else {
        foreach($cat_each as $c) {
          //$dest[] = $c;
          $dest[] = get_page_by_path($c, OBJECT, "destination")->ID;
        }
      }
    }
  }
  //_d($dest, "tax queries: ");
  //echo "<script>console.log(" . print_r($tax_queries) . ")</script>";

  $args = array(
    'post_type' => 'journey', 
    'posts_per_page' => $_GET["n_request"],
    'paged' => $_GET["paged"],
    'post_status' => 'publish',
    "tax_query" => $tax_queries
  );

  $wp_query = new WP_Query($args);

  if($wp_query->have_posts()) :
  while ($wp_query->have_posts()) : $wp_query->the_post();
    global $post;
    $journey_price = get_journey_price(get_the_ID());
    // echo $journey_price;
    $sigue = false;

    if($revisar_precios && $precio_min <= $journey_price && $journey_price <= $precio_max) $sigue = true;
    $comp = array_intersect($dest, get_dest_array($post->ID, "journey"));
    if(!empty($dest) && empty($comp)) continue;

    //_d($comp, "destinations: ");

    if($sigue || !$revisar_precios) {
      $slider_new_precio_min = min($slider_new_precio_min, $journey_price);
      $slider_new_precio_max = max($slider_new_precio_max, $journey_price);
      $average_price += $journey_price;
      ++$cantidad_precios;
  ?>
    <div class="item__gnral" data-lat="<?php the_field('latitud_destination');  ?>" data-long="<?php the_field('longitud_destination');  ?>">
    <a href="<?php the_permalink(); ?>" class="g__item__one">
      <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
      <figure style="background-image: url('<?php echo $backgroundImg[0];  ?>');"><span></span>
      </figure>
      <figcaption>
      <section>
        <h3><?php the_title(); ?></h3>
        <span><?php _e("starting at ", "colorfull"); echo get_price_pre() . " " .  $journey_price; ?></span>
        <span><?php _e('find out more ->','colorfull') ?></span>
      </section>
      </figcaption>
    </a>
    </div>
  <?php
    }
    endwhile;
  // wp_reset_postdata();
  endif;

  if($cantidad_precios == 0):
  ?>
    <div class="no_results">
      <h2><?php _e("No journeys were found matching your selection", "colorfull"); ?></h2>
      <a href="#"><?php _e("Return to list", "colorfull"); ?></a>
    </div>
    <script>
      jQuery(".span__average_price").html(" - ");
    </script>
  <?php

  else:
  $average_price = intval($average_price/$cantidad_precios);
  $slider_new_precio_max = ((intval($slider_new_precio_max/100)) + 1)*100;
  $slider_new_precio_min = max(((intval($slider_new_precio_min/100)))*100, 0);

  $val_min = (!$revisar_precios? $slider_new_precio_min : $precio_min);
  $val_max = (!$revisar_precios? $slider_new_precio_max : $precio_max);
  ?><script>
    <?php if (!$revisar_precios): ?>
      jQuery("#slider-range").slider("option", "max", <?php echo $slider_new_precio_max ?>);
      jQuery("#slider-range").slider("option", "min", <?php echo $slider_new_precio_min ?>);
    <?php endif ?>

    jQuery("#slider-range").slider("option", "values", [<?php echo $val_min ?>, <?php echo $val_max ?>]);
    jQuery("#amount").val('<?php echo get_price_pre() . $val_min . " - " . get_price_pre() . $val_max ?>');

    jQuery(".span__average_price").html(<?php echo $average_price ?>);

      var values = jQuery("#slider-range").slider("option", "values");
      var precio_mayor = values[1];
      var precio_menor = values[0];

      var curr_precio_mayor = jQuery("#slider-range").slider("option", "max");
      var curr_precio_menor = jQuery("#slider-range").slider("option", "min");

      // alert("[" + curr_precio_menor + "|" + precio_menor + ":" + precio_mayor + "|" + curr_precio_mayor + "]");
  </script>
  <?php
  endif;
  echo "<script>busy=false;</script>";
  wp_reset_query();
  wp_show_message_result_cpt();
  wp_die(); // required. to end AJAX request.
}

add_action( 'wp_ajax_search_results', 'get_search_results' );
add_action( 'wp_ajax_nopriv_search_results', 'get_search_results' );

function get_search_results() {
  if(isset($_GET["search"]) && $_GET["search"] != ""): ?>
  <div class="search_results--box">
    <h1><?php _e("Search results for: ", "colorfull"); echo "\"" . $_GET['search'] . "\"";?></h1>
    <a href="#"><?php _e("Return to list", "colorfull"); ?></a>
  </div>
<?php
  endif;
  wp_die(); // required. to end AJAX request.
}

add_action( 'wp_ajax_accom', 'ajax_get_accom' );
add_action( 'wp_ajax_nopriv_accom', 'ajax_get_accom' );

function ajax_get_accom() {
  if((isset($_GET["search"]) && $_GET["search"] != "") || (!isset($_GET["params"]) || $_GET["params"] == "")) {
    $args = array(
      'post_type' => 'acommodation', 
      'posts_per_page' => $_GET["n_request"],
      'paged' => $_GET["paged"],
      'post_status' => 'publish',
    );

    if(isset($_GET["search"]) && $_GET["search"] != "") $args["s"] = $_GET["search"];

    // _d($args);
    $slider_new_precio_min = 10000000;
    $slider_new_precio_max = -1;
    $average_price = 0;
    $cantidad_precios = 0;

    $wp_query = new WP_Query($args);
     ?>
     <?php 
      if($wp_query->have_posts()) :  ?>

          <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
          <?php
            $accom_price = get_accom_price(get_the_ID());

            $slider_new_precio_min = min($slider_new_precio_min, $accom_price);
            $slider_new_precio_max = max($slider_new_precio_max, $accom_price);
            $average_price += $accom_price;
            ++$cantidad_precios;
          ?>
            <div class="item__gnral">
              <a href="<?php the_permalink(); ?>" class="g__item__two" >
          <span></span>
          <div class="g__item__two__inside">
             <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
            <figure style="background-image: url('<?php echo $backgroundImg[0];  ?>');"></figure>
            <figcaption>
              <section>
                <h3><?php the_title(); ?></h3>
                <h4><?php echo get_post_field("post_title", get_field("tag_destination")[0]); ?></h4>
                <p><?php _e("starting at ", "colorfull"); echo get_price_pre() . " " . $accom_price ?></p>
              </section>
            </figcaption>
          </div>
        </a>
      </div>
          <?php endwhile;
        wp_reset_postdata();
      endif;

    if($cantidad_precios == 0):
    ?>
      <div class="no_results">
        <h2><?php _e("No accommodations were found matching your selection", "colorfull"); ?></h2>
        <a href="#"><?php _e("Return to list", "colorfull"); ?></a>
      </div>
    <?php
    endif;

    $average_price = intval($average_price/$cantidad_precios);
    $slider_new_precio_max = ((intval($slider_new_precio_max/100)) + 1)*100;
    $slider_new_precio_min = max(((intval($slider_new_precio_min/100)))*100, 0);

    //_d($param["price"], "PARAM PRICE lmao");

    $val_min = (isset($param["price"])? $param["price"][0] : $slider_new_precio_min);
    $val_max = (isset($param["price"])? $param["price"][1] : $slider_new_precio_max);
    ?><script>
    jQuery("#slider-range").slider("option", "max", <?php echo $slider_new_precio_max ?>);
    jQuery("#slider-range").slider("option", "min", <?php echo $slider_new_precio_min ?>);
      jQuery(".span__average_price").html(<?php echo $average_price ?>);
      jQuery("#slider-range").slider("option", "values", [<?php echo $val_min ?>, <?php echo $val_max ?>]);
      jQuery("#amount").val('<?php echo get_price_pre() . $val_min . " - " . get_price_pre() . $val_max ?>');
    </script>
    <?php
  }

  else {
    $accoms = array();
    $p = explode("&", $_GET["params"]);

    $param = array();
    foreach($p as $_p) {
      $aux = explode("=", $_p);

      $param[$aux[0]] = explode(",", $aux[1]);
    }?>
    <!-- <pre><?php //print_r($param) ?></pre> -->
  <?php

    $q = new WP_Query(array(
      "post_type" => "acommodation",
      "post_status" => "publish",
      "posts_per_page" => -1
    ));

    if($q->have_posts()) {
      while($q->have_posts()) {
        $q->the_post();
        global $post;

        $destination = get_post_field("post_name", get_field("tag_destination")[0]);

        if(isset($param["location"]) && !in_array($destination, $param["location"])) continue;

        $_cat = get_the_terms($post, "accomodation_category");
        $cat = $_cat[0];

        if(isset($param["category"]) && !in_array($cat->slug, $param["category"])) continue;
        $curr = $post;

        //Verificar el precio y la categoría del bedroom (?)
        if(isset($param["price"])) {
          $entra = false;

          if(have_rows("acom_rooms", $curr->ID)) {
            while(have_rows("acom_rooms", $curr->ID)) {
              the_row();
              $precio = get_sub_field("acom_room_precio");
              // echo "<pre>" . $precio . "\n</pre>";
              if($param["price"][0] <= $precio && $precio <= $param["price"][1]) $entra = true;
            }
          }

          if(!$entra) continue;
        }

        if(isset($param["room"])) {
          $entra = false;
          $terms = $param["room"];

          foreach($terms as $term) if(has_term($term, "bedroom", $curr)) $entra = true;

          if(!$entra) continue;
        }

        $accoms[] = $curr;
        $locaciones[$curr->ID] = $locacion;
      }
    }

    /* Ya tengo todos los hoteles a buscar (?) */
    // echo "<pre>";print_r($accoms); echo "</pre>";
    $ac_done = array();
    $slider_new_precio_min = 10000000;
    $slider_new_precio_max = -1;
    $average_price = 0;
    $cantidad_precios = 0;
    foreach($accoms as $ac) {
      if(in_array($ac->ID, $ac_done)) continue;
      else $ac_done[] = $ac->ID;

      global $post;
      $post = $ac;
      setup_postdata($post);

      $accom_price = get_accom_price(get_the_ID());

      $slider_new_precio_min = min($slider_new_precio_min, $accom_price);
      $slider_new_precio_max = max($slider_new_precio_max, $accom_price);
      $average_price += $accom_price;
      ++$cantidad_precios;
      // the_title("<pre>", "</pre>");
    ?>
      <div class="item__gnral">
        <a href="<?php the_permalink(); ?>" class="g__item__two" >
          <span></span>
          <div class="g__item__two__inside">
            <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
            <figure style="background-image: url('<?php echo $backgroundImg[0];  ?>');"></figure>
            <figcaption>
              <section>
                <h3><?php the_title(); ?></h3>
                <h4><?php echo get_post_field("post_title", get_field("tag_destination")[0]); ?></h4>
                <p><?php _e("starting at ", "colorfull");  echo get_price_pre() . " " . $accom_price ?></p>
              </section>
            </figcaption>
          </div>
        </a>
      </div>
    <?php
      wp_reset_postdata();
    }
    if($cantidad_precios == 0):
    ?>
      <div class="no_results">
        <h2><?php _e("No accommodations were found matching your selection", "colorfull"); ?></h2>
        <a href="#"><?php _e("Return to list", "colorfull"); ?></a>
      </div>
      <script>
        jQuery(".span__average_price").html(" - ");
      </script>
    <?php
    else:
    $average_price = intval($average_price/$cantidad_precios);
    $slider_new_precio_max = ((intval($slider_new_precio_max/100)) + 1)*100;
    $slider_new_precio_min = max(((intval($slider_new_precio_min/100)))*100, 0);

    //_d($param["price"], "PARAM PRICE lmao");

    $val_min = (isset($param["price"])? $param["price"][0] : $slider_new_precio_min);
    $val_max = (isset($param["price"])? $param["price"][1] : $slider_new_precio_max);
    ?><script>
    <?php if (!isset($param["price"])): ?>
      jQuery("#slider-range").slider("option", "max", <?php echo $slider_new_precio_max ?>);
      jQuery("#slider-range").slider("option", "min", <?php echo $slider_new_precio_min ?>);
    <?php endif ?>
      jQuery(".span__average_price").html(<?php echo $average_price ?>);
      jQuery("#slider-range").slider("option", "values", [<?php echo $val_min ?>, <?php echo $val_max ?>]);
      jQuery("#amount").val('<?php echo get_price_pre() . $val_min . " - " . get_price_pre() . $val_max ?>');
    </script>
    <?php
    endif;
  }

  echo "<script>busy=false;</script>";

  wp_reset_query();
  wp_show_message_result_cpt();
  wp_die(); // required. to end AJAX request.
}

add_action( 'wp_ajax_posts', 'ajax_get_blog_posts' );
add_action( 'wp_ajax_nopriv_posts', 'ajax_get_blog_posts' );

function ajax_get_blog_posts() {
  if(!isset($_GET["params"]) || $_GET["params"] == "") {
    $args = array(
      'post_type' => 'post', 
      'posts_per_page' => $_GET["n_request"],
      'paged' => $_GET["paged"],
      'post_status' => 'publish',
      "posts_per_page" => -1
    );

    $wp_query = new WP_Query($args);
     ?>
     <?php 
      if($wp_query->have_posts()) :  ?>
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
        wp_reset_postdata();
      endif;
  }

  else {
    $accoms = array();
    $p = explode("&", $_GET["params"]);

    $param = array();
    foreach($p as $_p) {
      $aux = explode("=", $_p);

      $param[$aux[0]] = explode(",", $aux[1]);
    }?>
   
  <?php
    $args = array(
      "post_type" => "post",
      "post_status" => "publish",
      "posts_per_page" => -1
    );

    if(isset($param["trip_type"])) {
      $args["tax_query"] = [[
        "taxonomy" => "trip_type",
        "field" => "slug",
        "terms" => $param["trip_type"]
      ]];
    }
    // _d($args,"argumentos");

    $q = new WP_Query($args);

    if($q->have_posts()) {
      while($q->have_posts()) {
        $q->the_post();
        global $post;

        $post_destinos = get_field("tag_destination");

        $entra = false;
        $sigue = false;
        foreach ($post_destinos as $destino) {
          $destination = get_post_field("post_name", $destino);
          if(isset($param["region"]) && !$sigue) {
            $sigue = (has_term($param["region"], "region", $destino)? true : false);
            // echo $destination . ": " . ($sigue? " sigue" : " no sigue");
          }
          // echo "LLega acá";
          if(isset($param["location"]) && in_array($destination, $param["location"])) $entra = true;
          // if($entra) echo "ahora acá";
        }

        if(isset($param["region"]) && !$sigue) continue;
        if(isset($param["location"]) && !$entra) continue;

        $accoms[] = $post;
        $locaciones[$curr->ID] = $locacion;
      }
    }

    /* Ya tengo todos los hoteles a buscar (?) */
    // echo "<pre>";print_r($accoms); echo "</pre>";
    $ac_done = array();
    $cont = 0;
    foreach($accoms as $ac) {
      if(in_array($ac->ID, $ac_done)) continue;
      else $ac_done[] = $ac->ID;

      ++$cont;

      global $post;
      $post = $ac;
      setup_postdata($post);
      // the_title("<pre>", "</pre>");
    ?>
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
    <?php
      //wp_reset_postdata();
    }
  }
  if($cantidad_precios == 0):
  ?>
    <div class="no_results">
      <h2><?php _e("No posts were found matching your selection", "colorfull"); ?></h2>
      <a href="#"><?php _e("Return to list", "colorfull"); ?></a>
    </div>
  <?php
  endif;
  echo "<script>busy=false;</script>";
  wp_reset_query();
  wp_show_message_result_cpt();
  wp_die(); // required. to end AJAX request.
}

// Custom excerpt
function the_excerpt_max_charlength($charlength) {
  $excerpt = get_the_excerpt();
  $charlength++;

  if ( mb_strlen( $excerpt ) > $charlength ) {
  $subex = mb_substr( $excerpt, 0, $charlength - 5 );
  $exwords = explode( ' ', $subex );
  $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
  if ( $excut < 0 ) {
    echo mb_substr( $subex, 0, $excut );
  } else {
    echo $subex;
  }
  echo '...';
  } else {
  echo $excerpt;
  }
}

// Redirect page CF7

function add_this_script_footer(){ ?>
  <?php
    $currentlang = pll_current_language();
    if($currentlang=="en"): ?>

    <?php 
    $CurrentLanguage = 'error-en'; ?>
    <script>
    document.addEventListener( 'wpcf7mailsent', function( event ) {
    //location = '<?php  echo esc_url( home_url( '' ) ); ?>/message-sent';
    }, false );
  </script> 

    <?php 
    elseif($currentlang=="es"): ?>
  <script>
    document.addEventListener( 'wpcf7mailsent', function( event ) {
    //location = '<?php  echo esc_url( home_url( '' ) ); ?>/mensaje-enviado';
    }, false );
  </script> 
    <?php 
    $CurrentLanguage = 'error-es'; ?>  
    <?php 
    endif; ?>  
<?php 
}  
add_action('wp_footer', 'add_this_script_footer'); 


add_action( 'wpcf7_init', 'radio__tax__form__tag' );

function radio__tax__form__tag() {
   wpcf7_add_form_tag( array( 'radio_tax', 'radio_tax*' ), 'radio__tax__form__tag__handler', true );
}

function radio__tax__form__tag__handler( $tag ) {
   $tag = new WPCF7_FormTag( $tag );
   if ( empty( $tag->name ) ) {
     return '';
   }

   $tipo = array(
    "tourist" => 1,
    "superior-tourist" => 2,
    "superior" => 3,
    "deluxe" => 4
  );

$list__taxonomias = 'accomodation_category';
$args = get_terms( $list__taxonomias );

   $list__taxonomias = '<span class="wpcf7-form-control-wrap radio">';
   foreach ( $args as & $arg ) {
     $list__taxonomias .= '<article>';
  $list__taxonomias .='<div class="input__g input__g--check--radio input__g--radio">';
  $list__taxonomias .= '<div class="input__g__inside">';
  $list__taxonomias .= '<input data-tipo="' . $tipo[$arg->slug] . '" type="radio" name="radio[]" id="' . $arg->name . '" value="' . $arg->name . '"/>';
  $list__taxonomias .= '<label class="input__g--check--radio--label" for="' . $arg->name . '">';

  $list__taxonomias .= '<div class="input__g__inside__container">';
  $list__taxonomias .= '<div class="input__g__figure"></div>';
  $list__taxonomias .= '<div class="input__g__text">' . $arg->name . '</div>';
  $list__taxonomias .= '</div>';

  $list__taxonomias .= '</label>';
  $list__taxonomias .= '</div>';
  $list__taxonomias .= '</div>';
  $list__taxonomias .= '</article>';
   }
   return $list__taxonomias;

   $list__taxonomias .= '</span>';
   return $list__taxonomias;
}


//--------------------------------

add_action( 'wpcf7_init', 'check__interes__form__tag' );

function check__interes__form__tag() {
wpcf7_add_form_tag( array( 'checkbox__interes', 'checkbox__interes*' ), 'check__interes__form__tag__handler', true );
}

function check__interes__form__tag__handler( $tag ) {
$tag = new WPCF7_FormTag( $tag );
if ( empty( $tag->name ) ) {
return '';
}
$list__interes = '';
$list__interes = '<span class="wpcf7-form-control-wrap radio">';
if( have_rows('acom_rooms') ):
while( have_rows('acom_rooms') ): the_row();
$post_title = get_sub_field('acom_room_titulo');
$list__interes .= '<article>';
$list__interes .='<div class="input__g input__g--check--radio input__g--radio">';
$list__interes .= '<div class="input__g__inside">';
$list__interes .= '<input type="radio" name="radio[]" id="' . $post_title . '" value="' . $post_title . '"/>';
$list__interes .= '<label class="input__g--check--radio--label" for="' . $post_title . '">';

$list__interes .= '<div class="input__g__inside__container">';
$list__interes .= '<div class="input__g__figure"></div>';
$list__interes .= '<div class="input__g__text">' . $post_title . '</div>';
$list__interes .= '</div>';

$list__interes .= '</label>';
$list__interes .= '</div>';
$list__interes .= '</div>';
$list__interes .= '</article>';
endwhile;
endif;
$list__interes .= '</span>';
return $list__interes;
}

add_action( 'wp_ajax_setcurrency', 'ajax_set_curr' );
add_action( 'wp_ajax_nopriv_setcurrency', 'ajax_set_curr' );

function ajax_set_curr() {
  $moneda = get_field("cf_currency_" . $_GET["moneda"], "option"); 
  $_SESSION["cambio"] = floatval($moneda);
  $_SESSION["cambio_pre"] = $_GET["pref"];
  wp_die(); // required. to end AJAX request.
}

function _d($o, $titulo = "") {
  if(isset($titulo)) echo "<h1>" . $titulo . "</h1>";
  echo "<pre>";
  print_r($o);
  echo "</pre>";
}

//Para abrir linxxx (?)
ini_set("allow_url_fopen", 1);

function __n($n) {
  return number_format((float)$n, 2, '.', '');
}


function get_weather_actual($datos, &$presion) {
  // _d($presion, "PRESION: ");
  //echo $datos["lat"] . " " . $datos["lon"];
  $lat = $datos["lat"];
  $lon = $datos["lon"];
  $url = "http://api.openweathermap.org/data/2.5/forecast?lat=" . $lat . "&lon=" . $lon . "&appid=bb288d14bb131006c09f943a540cdf15";
  // $url = "http://api.openweathermap.org/data/2.5/weather?lat=" . $lat . "&lon=" . $lon . "&appid=bb288d14bb131006c09f943a540cdf15";
  $json = file_get_contents($url);
  $obj = json_decode($json);

  // _d($obj);

  // echo $url;
  if(false) {
    $temp_k = $obj->main->temp;
    $temp_k_max = $obj->main->temp_max;
    $temp_k_min = $obj->main->temp_min;
    $icon = $obj->weather[0]->icon;
  } else {
    $temp_k = $obj->list[0]->main->temp;
    $icon = $obj->list[0]->weather[0]->icon;
    $presion = $obj->list[0]->main->pressure;

    $n = 8;
    $temp_k_max = 0;
    $temp_k_min = 1000;

    for($i = 0; $i < $n; ++$i) {
      $temp_k_max = max($obj->list[$i]->main->temp_max, $temp_k_max);
      $temp_k_min = min($obj->list[$i]->main->temp_min, $temp_k_min);
    }
  }

  $src =  get_template_directory_uri() . "/assets/images/weather/" . $icon . ".png";

  $temp_c = $temp_k - 273.15;
  $temp_c_max = $temp_k_max - 273.15;
  $temp_c_min = $temp_k_min - 273.15;

  $temp_f = ($temp_c * 9/5) + 32;
  $temp_f_max = ($temp_c_max * 9/5) + 32;
  $temp_f_min = ($temp_c_min * 9/5) + 32;
?>
<div class="detail_y__item__in" style="display: flex; justify-content: center; flex-wrap: wrap">
  <span class="grados__temperatura"><img src='<?php echo $src ?>' alt="icon"><?php echo __n($temp_f) . "°F | " . __n($temp_c) . "°C" ?></span>
  <span class="max__temperatura"><?php _e("Max: ",'colorfull'); echo __n($temp_f_max) . "°F | " . __n($temp_c_max) . "°C" ?></span>
  <span class="min__temperatura"><?php _e("Min: ",'colorfull'); echo __n($temp_f_min) . "°F | " . __n($temp_c_min) . "°C" ?></span>
</div>
<?php

  //_d($obj);
}

function get_dest_array($id, $tipo) {
  $dest = array();
  if($tipo == "destination") $dest[] = $id;
  else if($tipo == "journey") {
    while(have_rows("journey_destinationlist", $id)) {
      the_row();
      $dest[] = get_sub_field("journey_destination_item")->ID;
    }
  } else { //accomm or blog_post
    if($tags = get_field("tag_destination", $id)) $dest = $tags;
  }
  return $dest;
}

function get_range_prices($t) {
  $min = 1000000000000000;
  $max = -1;

  $q = new WP_Query([
    "post_type" => ($t == "j"? "journey" : "acommodation"),
    "fields" => "ids",
    "posts_per_page" => -1
  ]);

  while($q->have_posts()) {
    $q->the_post();
    global $post;
    $precio = ($t == "j"? get_journey_price($post->ID) : get_accom_price($post->ID));

    $min = min($min, $precio);
    $max = max($max, $precio);
  }

  $min = intval($min/100)*100;
  $max = (intval($max/100) + 1)*100;

  return [$min, $max];
}


function custom_columns_head($defaults) {
  $defaults['id_column']  = 'Slider';
  return $defaults;
}
function custom_columns_content($column_name, $post_ID) {
  if ($column_name == 'id_column') {
      $post_object = get_post_meta($post_ID, 'add_slider_check', true);
      if( $post_object ): $post = $post_object; 
          echo "Show in slider";
      else:{ 
          echo "";
      } 
  endif;
  }
}

add_filter('manage_destination_posts_columns', 'custom_columns_head');
add_action('manage_destination_posts_custom_column', 'custom_columns_content', 10, 3);

add_filter('manage_acommodation_posts_columns', 'custom_columns_head');
add_action('manage_acommodation_posts_custom_column', 'custom_columns_content', 10, 3);

add_filter('manage_journey_posts_columns', 'custom_columns_head');
add_action('manage_journey_posts_custom_column', 'custom_columns_content', 10, 3);

add_action( 'admin_print_styles-edit.php', function(){        
    echo '<style> .column-id_column { width: 90px; }</style>';
});
 
/* functions hiden result post */

function wp_show_message_result_cpt(){
  ?>
  <script>
    jQuery(document).ready(function($) {
      var count = $(".items__prin__blog .item__gnral").length;
      //console.log(count);
      if ( $(count).length === 0 ){
        $( ".no_results" ).addClass( "show_message_no_result" );
      } 
      else {
        $( ".no_results" ).addClass( "" ); 
      }
    });
  </script>
  <?php
}

// String Languages

//require ( 'inc/language.php' );

add_filter('acf/fields/post_object/result', 'custom_post_object_result', 10, 4);
function custom_post_object_result( $result, $object, $field, $post ) {
  global $polylang;
  $language = $polylang->model->get_post_language($object->ID);
  $result .= ' (' . $language->slug . ')';
  return $result;
}
