<?php get_header(); ?>

<?php 
if(have_posts()) : while(have_posts()) : the_post(); ?>

<?php the_content(); ?>
<?php the_post_thumbnail(); ?>
<?php the_title(); ?>

<?php 

endwhile; 
wp_reset_query();
endif;
?>

<?php get_footer(); ?>