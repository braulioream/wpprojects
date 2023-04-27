<?php get_header(); ?>

<main id="primary" class="site-main">
<?php if ( have_posts() ) : ?>

<?php the_content() ?>


<?php endif; ?>
</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
