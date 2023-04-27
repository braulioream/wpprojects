<?php
get_header(); ?>

<?php echo do_shortcode('[slider__default__two]'); ?>

<div class="detail_y_top detail_y_top--acomodation">
	<div class="detail_y_top_container wrapper__container">
		<div class="detail_y__items">
			<div class="detail_y__item detail_y_duration">
				<div class="detail_y__item__inside">


					<h3><?php the_field('destination_weather_titulo') ?></h3>

					<?php if (($lat = get_field("latitud_destination"))  && ($long = get_field("longitud_destination"))): ?>
						<?php $presion = get_field('destination_elevation_pressure') ?>
						<?php get_weather_actual(array("lat" => $lat, "lon" => $long), $presion); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="detail_y__item detail_y_triptype">
				<div class="detail_y__item__inside">
					<h3><?php the_field('destination_activity_titulo') ?></h3>
					<div class="detaill__images__figure">
						<?php 
						$terms = get_field('destination_activity_list');
						if( $terms ): ?>
							<div class="detail_y__images">
							<?php foreach( $terms as $term ): ?>
								<figure>
									<img src="<?php the_field('activity_icono', $term); ?>" alt="<?php echo $term->name; ?>">
									<h3><?php echo $term->name; ?></h3>
								</figure>
							<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<div class="detaill__punts">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</div>
					<div class="detaill__box">
						<div class="detaill__box__ctn">
							
						</div>
					</div>
					
				</div>
			</div>
			<div class="detail_y__item detail_y_price">
				<div class="detail_y__item__inside">
					<h3><?php the_field('destination_elevation_titulo') ?></h3>
					<span><?php the_field('destination_elevation_elevation') ?> m<br>
						<?php echo $presion; ?> hpa</span>
				</div>
			</div>
			<div class="detail_y__item detail_y_links">
				<div class="detail_y__item__inside">
					<?php
					$currentlang = pll_current_language();
					if($currentlang=="en"): ?>
						<a href="<?php echo esc_url( home_url( '/suggested-journeys?location=' . $post->post_name ) ); ?>" class="g__button book_now g__button--uppercase"><span><?php _e('Suggested Journeys','colorfull'); ?></span></a>
					<?php  elseif($currentlang=="es"): ?>
						<a href="<?php echo esc_url( home_url( '/es/viajes-sugeridos?location=' . $post->post_name  ) ); ?>" class="g__button book_now g__button--uppercase"><span><?php _e('Suggested Journeys','colorfull'); ?></span></a>
					<?php endif; ?>
					<?php
					if($currentlang=="en"): ?>
						<a href="<?php echo esc_url( home_url( '/create-your-own-journey/' ) ); ?>" class="detail_y__item_link"><?php _e('Create your own journey','colorfull'); ?></a>
						
					<?php  elseif($currentlang=="es"): ?>
						<a href="<?php echo esc_url( home_url( '/es/crea-tu-propio-viaje/' ) ); ?>" class="detail_y__item_link"><?php _e('Create your own journey','colorfull'); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="detail_y_info">
	<div class="detail_y_info__container wrapper__container">
		<div class="detail_y_info__title title__general title__general--center">
			<div class="title__general__title">
				<?php if (get_field('ubication_general')): ?>
					<h2>
						<?php the_field('ubication_general') ?>
					</h2>
				<?php endif ?>
				<h3><?php the_title(); ?></h3>
				
				
			</div>
			<div class="title__general__text content__styles__all">
				<?php the_content(); ?>
			</div>
			
		</div>
		<div class="detail_y__popups">
			<?php $h=0; ?>
			<?php if( have_rows('anexo_tab') ): $h; ?>
				<?php while( have_rows('anexo_tab') ): the_row(); $h++; ?>
					<a href="#" class="g__button book_now g__button--popup" id="<?php echo $h; ?>"><span><?php the_sub_field('anexo_tab_titulo') ?></span></a>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<div class="detail_y__experiencie">
	<div class="detail_y__experiencie__title title__general title__general--center">
		<div class="title__general__title">
			<h2><?php the_field('more_suggested_titulo') ?></h2>
			<h3><?php _e('Suggested journeys','colorfull'); ?></h3>
		</div>
		<div class="title__general__button">
			<?php
				$currentlang = pll_current_language();
				if($currentlang=="en"): ?>
					<a href="<?php echo esc_url( home_url( '/suggested-journeys?location=' . $post->post_name  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
				<?php
				elseif($currentlang=="es"): ?>
					<a href="<?php echo esc_url( home_url( '/es/viajes-sugeridos?location=' . $post->post_name  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
				<?php endif; ?>
			
		</div>
	</div>
	<?php get_suggested_journeys(4, $post->ID, "destination"); ?>
</div>

<div class="detail_y__acommodations">
	<div class="detail_y__acommodations__container">
		<div class="detail_y__acommodations__title title__general title__general--center">
			<div class="title__general__title">
				<h2><?php the_field('more_acommodations_titulo') ?></h2>
				<h3><?php _e('Top ranked Accommodation','colorfull'); ?></h3>
			</div>
			<div class="title__general__button">
				<?php
				$currentlang = pll_current_language();
				if($currentlang=="en"): ?>
					<a href="<?php echo esc_url( home_url( '/accommodations?location=' . $post->post_name  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
				<?php
				elseif($currentlang=="es"): ?>
					<a href="<?php echo esc_url( home_url( '/es/alojamientos?location=' . $post->post_name  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php get_accom(6, $post->ID, "destination"); ?>
</div>

<div class="detail_y__more">
	<div class="borde-colourful-gn"></div>
	<div class="detail_y__more__title title__general title__general--center">
		<div class="title__general__title">
			<h2><?php the_field('more_blog_titulo') ?></h2>
			<h3><?php _e('Blog','colorfull'); ?></h3>
		</div>
		<div class="title__general__button">
			<?php
			$currentlang = pll_current_language();
			if($currentlang=="en"): ?>
				<a href="<?php echo esc_url( home_url( '/blog?location=' . $post->post_name  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
			<?php
			elseif($currentlang=="es"): ?>
				<a href="<?php echo esc_url( home_url( '/es/blog-2?location=' . $post->post_name  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
			<?php endif; ?>
		</div>
	</div>
	<?php get_blog_posts(3, $post->ID, "destination"); ?>
</div>

<div class="pop__up__y__wrap pop__up__y__tabs">
	<div class="pop__up__y__overlay"></div>
	<div class="pop__up__y">
		<div class="pop__up__y__close pop__up__y--close icon-close"></div>
		<div class="pop__up__y__container">
			<div class="pop__up__y__nav">
				<?php $m=0; ?>
				<?php if( have_rows('anexo_tab') ): $m; ?>
					<?php while( have_rows('anexo_tab') ): the_row(); $m++; ?>
						<a href="#" class="pop__up__y__btn detail_y__btn3" data-id="<?php echo $m; ?>"><span><?php the_sub_field('anexo_tab_titulo') ?></span></a>

					<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<div class="pop__up__y__content__all">
				<?php $h=0; ?>
				<?php if( have_rows('anexo_tab') ): $h; ?>
					<?php while( have_rows('anexo_tab') ): the_row(); $h++; ?>
						<div class="pop__up__y__content" id="<?php echo $h; ?>">
							<div class="pop__up__y__content__in ">
								<div class="pop__up__y__content__scroll">
									<div class="pop__up__y__mobile__title">
										<h3><?php the_sub_field('anexo_tab_titulo') ?></h3>	
									</div>
									<div class="pop__up__y__content__in__under">
										<div class="pop__up__y__content__in__under__scroll">
											<div class="pop__up__y__content__in__edit">
												<?php the_sub_field('anexo_tab_contenido') ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>


<?php
get_footer();
?>

<script>
	jQuery(document).ready(function($){

		//tabs
		$('.pop__up__y__btn:nth-child(1)').addClass('active');
		$('.pop__up__y__content:nth-child(1)').addClass('active');

		$('.pop__up__y__btn').click(function(e){
			e.preventDefault();
			$('.pop__up__y__btn').removeClass('active');
			$(this).addClass('active');
			var data_id = $(this).attr('data-id');
			console.log(data_id);
			$('.pop__up__y__content').removeClass('active');
			$('.pop__up__y__content[id="'+ data_id+'"]').addClass('active');
		 });


		//pop up
		$('.pop__up--pitcher--y').click(function(event) {
			event.preventDefault();
			$('.pop__up__y__tabs').addClass('active');
			$('body').addClass('active-overlay');
		});

		$('.pop__up__y--close , .pop__up__y__overlay').click(function(event) {
			event.preventDefault();
			$('.pop__up__y__wrap').removeClass('active');
			$('body').removeClass('active-overlay');
		});

		$('.g__button--popup').click(function(event) {
			event.preventDefault();
			$('.pop__up__y__tabs').addClass('active');
			$('body').addClass('active-overlay');
			var data_id = $(this).attr('id');
			$('.pop__up__y__content').removeClass('active');
			$('.pop__up__y__btn').removeClass('active');
			$('.pop__up__y__content[id="'+ data_id+'"]').addClass('active');
			$('.pop__up__y__btn[data-id="'+ data_id+'"]').addClass('active');
		});

	});
</script>