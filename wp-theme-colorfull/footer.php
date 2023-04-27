<section class="foot__suscribe" style="background-image: url(<?php the_field('background_suscribete','options') ?>);">
  <div class="foot__suscribe__container wrapper__container">
    <div class="foot__suscribe__title">
      <h3><?php _e('SIGN UP TO RECEIVE OUR CURRENT NEWSLETTER','colorfull') ?></h3>
    </div>
    <?php
    //$currentlang = pll_current_language();
    $currentlang = pll_current_language();
    if($currentlang=="en"):
    echo do_shortcode('[contact-form-7 id="290" title="Subscribe"]');
    elseif($currentlang=="es"):
    echo do_shortcode('[contact-form-7 id="292" title="Suscribete"]');
    endif; ?>
    
  </div>
</section>
<footer class="footer">
  <div class="footer__container wrapper__container">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer__logo">
      <img class="" src="<?php the_field('logo_footer','options') ?>" alt=""/>
    </a>
    <nav class="footer__list__wrap">
      <?php wp_nav_menu(array(
        'theme_location' => 'footer',
        'menu_class' => 'footer__list',
        'container' => '',
        'container_class' => '',
      )); ?>
    </nav>
    <div class="footer__social">
      <?php if( have_rows('list_social_media','options') ): ?>
        <ul>
        <?php while( have_rows('list_social_media','options') ): the_row(); ?>
        <?php 
        $name_select_sub_field = (get_sub_field_object('tipo_social_media','options'));
        $name_sub_field = get_sub_field('tipo_social_media','options');
        $label_select = ($name_select_sub_field['choices'][$name_sub_field]);
        ?>
        
        <!-- -->
        <?php if( $name_sub_field == 'whatsapp' ) { ?>
          <li>
            <a  class="icon-<?php the_sub_field( 'tipo_social_media' ); ?>" target="_blank" href="https://api.whatsapp.com/send?phone=<?php the_sub_field( 'url_social_media', 'options' ); ?>&text=<?php the_sub_field( 'mensaje_whatsapp', 'options' ); ?>"></a>
          </li>
        <?php } elseif( $name_sub_field != 'whatsapp' ) {  ?>
        <?php if( get_sub_field('url_social_media', 'options') ) { ?>
          <li>
            <a class="icon-<?php the_sub_field( 'tipo_social_media' ); ?>" href="<?php the_sub_field('url_social_media', 'options'); ?>" target="_blank"> </a>
          </li>
        <?php } ?>
        <?php } ?>
        <!-- -->

        <?php endwhile; ?>
      </ul>
      <?php endif; ?>
    </div>
    <div class="footer__copyright">
      <p>© <?php echo date("Y") ?><?php _e(' Colourful Peru Travel Agency. All rights reserved. No part of this site may be reproduced without our written permission. Colourful.','colorfull'); ?></p>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script>
  jQuery(".header__top__currency a, .header__sidebar__top__currency a").click(function(e) {
    e.preventDefault();

    var seleccion = jQuery(this).html();

    jQuery.ajax({
      url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
      data: {
        action: "setcurrency",
        moneda: seleccion.toLowerCase(),
        pref: seleccion
      },
      success: function(msg) {
        location.reload();
      }
    });
  });
</script>
<div class="pop__up__y__wrap pop__up__y__thanks">
  <div class="pop__up__y__overlay"></div>
  <div class="pop__up__y">
    <div class="pop__up__y__close pop__up__y--close"></div>
    <div class="pop__up__y__container">
      <figure>
        <img class="" src="<?php the_field('logo_footer','options') ?>" alt=""/>
      </figure>
      <div class="pop__up__y__text">
        <h3><?php _e('Thanks for trust in us!','colorfull'); ?></h3>
        <p><?php _e('Our team will be contacting you as soon as possible.','colorfull'); ?> </p>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<script>
  jQuery(document).ready(function($) {
    document.addEventListener( 'wpcf7mailsent', function( event ) {
      $('.pop__up__y__thanks').addClass('active');
      $('body').addClass('active-overlay');
    }, false );

    $('.pop__up__y--close , .pop__up__y__overlay').click(function(event) {
      event.preventDefault();
      $('.pop__up__y__wrap').removeClass('active');
      $('body').removeClass('active-overlay');
    });
  });
</script>