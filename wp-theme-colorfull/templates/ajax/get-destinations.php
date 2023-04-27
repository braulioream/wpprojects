<?php
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $args = array( 
    'post_type' => 'destination', 
    'posts_per_page' => -1,
    'paged' => $paged,
    'post_status' => 'publish'
  );
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
    wp_reset_postdata();
  endif;
?>