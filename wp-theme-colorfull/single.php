<?php get_header(); ?>
<?php $destino = get_post_field("post_name", get_field("tag_destination")[0]); ?>

<?php 
if(have_posts()) : while(have_posts()) : the_post();?>
 <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
<div class="inicio__slide">
	<div class="banner__post" style="background-image: url('<?php echo $backgroundImg[0];  ?>');">
		<div class="banner__post__ctn wrapper__container">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
</div>
<div class="post__wrap">
	<div class="post__ctn wrapper__container">
		<div class="post__header">
			<div class="post__header__info">
				<h3><?php the_author();  ?></h3>
				<?php $date_day = ''.get_the_date('j').'';  ?>
				<?php $date_month = ''.get_the_date('F').'';  ?>
				<?php $date_year = ''.get_the_date('Y').'';  ?>
				<p><?php echo $date_day; ?> <?php echo $date_month; ?>, <?php echo $date_year; ?></p>
			</div>
			<div class="post__header__share list-none">
				<h3><?php _e('Share', 'colorfull') ?>:</h3>
				
				<ul>
					
						<li>
						<a  href="javascript: void(0);" class="icon-facebook" target="_blank" onclick="shareSocial(this, 'facebook','<?php the_permalink() ?>')"></a>
						</li>

					
						<li>
						<a href="javascript: void(0);" target="_blank" class="icon-twitter" onclick="shareSocial(this, 'twitter', '<?php the_permalink() ?>')"></a>
						</li>

					
						<li>
						<a href="javascript: void(0);" target="_blank" class="icon-linkedin" onclick="shareSocial(this, 'linkedin', '<?php the_permalink() ?>')"></a>
						</li>
					
						<li>
						<a target="_NEW" class="icon-whatsapp" href="https://api.whatsapp.com/send?text=<?php _e('Hola','my-travel'); ?>%20,%20<?php _e('te','my-travel'); ?>%20<?php _e('comparto','my-travel'); ?>%20<?php the_permalink() ?>" data-action="share/whatsapp/share"></i></a>
						</li>
					
				</ul>
				
			</div>
		</div>
    <?php get_dest_array($post->ID, "post"); ?>
		<div class="post__wrap__ctn content__styles__all">
			<?php the_content(); ?>
		</div>
	</div>
</div>
<div class="post__related">
	<div class="post__related__ctn wrapper__container">
		<div class="title__general__title">
			<h2><?php _e('READ OTHER AMAZING STORIES','colorfull') ?></h2>
			<h3><?php _e('BLOG','colorfull') ?></h3>
		</div>
		<div class="title__general__button">
			<?php
				$currentlang = pll_current_language();
				if($currentlang=="en"): ?>
				<a href="<?php echo esc_url( home_url( 'blog' . ($destinos != ""? '?location=' . $destinos : "") ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
				<?php  elseif($currentlang=="es"): ?>
				<a href="<?php echo esc_url( home_url( '/es/blog/' . ($destinos != ""? '?location=' . $destinos : "") ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Ver Más','colorfull'); ?></span></a>
			<?php endif; ?>
		</div>
		<div class="post__related__tags">
			<?php get_blog_posts(3, $post->ID, "blog-post"); ?>
		</div>
		<div class="post__related__suggested">
			<div class="title__general__title">
				<h2><?php the_field('more_suggested_titulo'); ?></h2>
				<h3><?php _e('SUGGESTED JOURNEYS','colorfull') ?></h3>
			</div>
			<div class="title__general__button">
				<?php
					$currentlang = pll_current_language();
					if($currentlang=="en"): ?>
					<a href="<?php echo esc_url( home_url( 'suggested' . ($destinos != ""? '?location=' . $destinos : "") ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
					<?php  elseif($currentlang=="es"): ?>
					<a href="<?php echo esc_url( home_url( '/es/viajes-sugeridos/' . ($destinos != ""? '?location=' . $destinos : "") ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Ver Más','colorfull'); ?></span></a>
				<?php endif; ?>
			</div>
			<div class="post__related__suggested__cn">
				<?php //get_suggested_journeys(4); ?>
        <?php get_suggested_journeys(4, $post->ID, "blog-post"); ?>
			</div>
		</div>
	</div>
	
</div>
<?php 

endwhile; 
wp_reset_query();
endif;
?>

<?php get_footer(); ?>
<script>
	function shareSocial(t, type, url){
	    // var url = encodeURIComponent(document.location.href),
	    var w = 600,h = 450,
	    // appID = $('meta[property="fb:app_id"]').attr('content'),
	    pos_x, pos_y,
	    pos_x=(screen.width/2)-(w/2),
	    pos_y=(screen.height/2)-(h/2);
	    switch(type) {
	    	case 'facebook':
	    	window.open('http://www.facebook.com/sharer.php?u='+url+'','mywindow', 'toolbar=0, status=0, left='+pos_x+', top='+pos_y+', width='+w+', height='+h);
	    	break;
	    	case 'twitter':
	    	window.open('https://twitter.com/intent/tweet?text=&url='+url+'&via=MY_TRAVEL','mywindow', 'toolbar=0, status=0, left='+pos_x+', top='+pos_y+', width='+w+', height='+h);
	    	break;
	    	case 'pinterest':
	    	window.open('https://pinterest.com/pin/create/button/?media='+url+'','mywindow', 'toolbar=0, status=0, left='+pos_x+', top='+pos_y+', width='+w+', height='+h);
	    	break;
	    	case 'googlemas':
	    	window.open('https://plus.google.com/share?url='+url+'','mywindow', 'toolbar=0, status=0, left='+pos_x+', top='+pos_y+', width='+w+', height='+h);
	    	break;
	    	case 'linkedin':
	    	window.open('http://www.linkedin.com/shareArticle?url='+url+'','mywindow', 'toolbar=0, status=0, left='+pos_x+', top='+pos_y+', width='+w+', height='+h);
	    	break;
	    }
	}
</script>