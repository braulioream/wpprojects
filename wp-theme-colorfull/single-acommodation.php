<?php
get_header(); ?>

<?php echo do_shortcode('[slider__default__two]'); ?>
<?php $destino = get_post_field("post_name", get_field("tag_destination")[0]); ?>
<div class="detail_y_top detail_y_top--acomodation">
	<div class="detail_y_top_container wrapper__container">
		<div class="detail_y__items">
			<div class="detail_y__item detail_y_duration">
				<div class="detail_y__item__inside">
					<h3><?php _e('Check in/ Check out','colorfull'); ?></h3>
					<div class="detail_y__item__in">
						<?php $checkin = get_field('acom_general_checkin') ?>
						<?php foreach(explode("/", $checkin) as $d) echo $d . "<br>" ?>
					</div>
				</div>
			</div>
			<div class="detail_y__item detail_y_triptype">
				<div class="detail_y__item__inside">
					<h3><?php _e('Facilities','colorfull'); ?></h3>
					<div class="detaill__images__figure">
						<?php 
						$terms = get_field('acom_general_facilities');
						if( $terms ): ?>
							<div class="detail_y__images">
							<?php foreach( $terms as $term ): ?>
								<figure>
									<img src="<?php the_field('facility_icono', $term); ?>" alt="<?php echo $term->name; ?>">
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
					<h3><?php _e('Starting price','colorfull'); ?></h3>
					<span>
						<?php $price = get_journey_price(get_the_ID()); ?>
						<?php echo get_price_pre();  ?> 
						<?php echo get_accom_price(get_the_ID()) ?>
					</span>
					<span>per room</span>
				</div>
			</div>
			<div class="detail_y__item detail_y_links">
				<div class="detail_y__item__inside">
					<a href="#" class="g__button book_now g__button--uppercase g__button--book"><span><?php _e('Book the Accommodation','colorfull'); ?></span></a>

					<?php
				$currentlang = pll_current_language();
				if($currentlang=="en"): ?>
					<a href="<?php echo esc_url( home_url( '/create-your-own-journey' . ($destinos != ""? '?location=' . $destinos : "") ) ); ?>" class="detail_y__item_link"><?php _e('Create your own journey','colorfull'); ?></a>
					
				<?php  elseif($currentlang=="es"): ?>
					<a href="<?php echo esc_url( home_url( '/es/crea-tu-propio-viaje/' . ($destinos != ""? '?location=' . $destinos : "")  ) ); ?>" class="detail_y__item_link"><?php _e('Create your own journey','colorfull'); ?></a>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="detail_y_info detail_y_info--acomodation">
	<div class="detail_y_info__container wrapper__container">
		<div class="detail_y_info__title title__general title__general--center">
			<div class="title__general__title">
				<h2><?php the_title(); ?></h2>
				<h3>
				<?php echo get_post_field("post_title", get_field("tag_destination")[0]); ?>
				</h3>
			</div>
			<div class="title__general__text content__styles__all">
				<?php the_content(); ?>
			</div>
			
		</div>
		<div class="detail_y__popups">
			<a href="#" class="g__button book_now g__button--popup" id="1"><span><?php _e('Rooms','colorfull'); ?></span></a>
			<a href="#" class="g__button book_now g__button--popup" id="2"><span><?php _e('Fact Sheet','colorfull'); ?></span></a>
			<a href="#" class="g__button book_now g__button--popup" id="3"><span><?php _e('Policies','colorfull'); ?></span></a>
			<a href="#" class="g__button book_now g__button--popup" id="4"><span><?php _e('Map','colorfull'); ?></span></a>
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
					<a href="<?php echo esc_url( home_url( '/suggested-journeys' . ($destinos != ""? '?location=' . $destinos : "")  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
				<?php
				elseif($currentlang=="es"): ?>
					<a href="<?php echo esc_url( home_url( '/es/viajes-sugeridos/' . ($destinos != ""? '?location=' . $destinos : "")  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
				<?php endif; ?>
			
		</div>
	</div>
	<?php get_suggested_journeys(4, $post->ID, "accom"); ?>
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
					<a href="<?php echo esc_url( home_url( '/accommodations' . ($destinos != ""? '?location=' . $destinos : "")  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
				<?php
				elseif($currentlang=="es"): ?>
					<a href="<?php echo esc_url( home_url( '/es/alojamientos/' . ($destinos != ""? '?location=' . $destinos : "")  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="wrapper__container container__single__accomodattion">
		<?php get_accom(6, $post->ID, "accom"); ?>
	</div>
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
				<a href="<?php echo esc_url( home_url( '/blog' . ($destinos != ""? '?location=' . $destinos : "")  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
			<?php
			elseif($currentlang=="es"): ?>
				<a href="<?php echo esc_url( home_url( '/es/blog-2/' . ($destinos != ""? '?location=' . $destinos : "")  ) ); ?>" class="g__button find_out_more g__button--uppercase"><span><?php _e('Find out more','colorfull'); ?></span></a>
			<?php endif; ?>
		</div>
	</div>

	<?php get_blog_posts(3, $post->ID, "accom"); ?>
</div>

<div class="pop__up__y__wrap pop__up__y__tabs">
	<div class="pop__up__y__overlay"></div>
	<div class="pop__up__y">
		<div class="pop__up__y__close pop__up__y--close icon-close"></div>
		<div class="pop__up__y__container">
			<div class="pop__up__y__nav">
				<a href="#" class="pop__up__y__btn detail_y__btn1" data-id="1"><span><?php _e('Rooms','colorfull'); ?></span></a>
				<?php $m=1; ?>
				<?php if( have_rows('anexo_tab') ): $m; ?>
					<?php while( have_rows('anexo_tab') ): the_row(); $m++; ?>
						<a href="#" class="pop__up__y__btn detail_y__btn3" data-id="<?php echo $m; ?>"><span><?php the_sub_field('anexo_tab_titulo') ?></span></a>

					<?php endwhile; ?>
				<?php endif; ?>
				<a href="#" class="pop__up__y__btn detail_y__btn1" data-id="5"><span><?php _e('Book now','colorfull'); ?></span></a>
			</div>
			<div class="pop__up__y__content__all">
				<div class="pop__up__y__content" id="1">
					<div class="pop__up__y__content__in">
						<div class="pop__up__y__content__scroll">
							<div class="pop__up__y__mobile__title">
								<h3><?php _e('Rooms','colorfull'); ?></h3>
							</div>
							<div class="pop__up__y__content__in__under">
								<div class="pop__up__y__content__in__under__scroll">
									<div class="pop__up__y__content__rooms">
										<?php if( have_rows('acom_rooms') ): $cont = 1 ?>
										<?php while( have_rows('acom_rooms') ): the_row(); ?>
										<div class="pop__up__y__content__room">
											<div class="popup__content__room__slider">
												<ul>
													<?php 
														$images = get_sub_field('acom_room_gallery');
														$size = 'thumbnail-room-rpt';
														$i = 1;
														if( $images ): ?>
															<?php foreach( $images as $image ): $i++ ?>
																<li>
																	<figure style="background-image: url(<?php echo $image['url'] ?>);">
																		
																	</figure>
																</li>
																<?php endforeach; ?>
														<?php endif;
													?>
													
												</ul>
											</div>
											<figcaption class="popup__content__room__info">
												<h3><?php the_sub_field('acom_room_titulo'); ?> 
												<?php if (get_sub_field('acom_room_num')): ?>
													<i>(<?php the_sub_field('acom_room_num'); ?> <?php _e('persons','colorfull'); ?>)</i>
												<?php endif ?>
												</h3>
												<div class="popup__content__room__content">
													<section class="popup__content__room__more content__styles__all" data-text="<?php _e('more','colorfull') ?> " data-text-less="<?php _e('Less','colorfull') ?>">
														<?php the_sub_field('acom_room_desc'); ?>
													</section>
												</div>
											</figcaption>
											<div class="popup__content__room__btnprice">
												<h3><?php the_sub_field('acom_room_titulo'); ?></h3>
												<a href="#" data-id="<?php echo $cont++ ?>" class="g__button book_now g__button--uppercase btnBookacco"><span><?php _e('Book now','colorfull') ?></span></a>
												<div class="popup__content__room__price">
													<span><?php echo get_price_pre() . " " . get_fixed_price(get_sub_field('acom_room_precio')); ?> <br> <?php _e('per room','colorfull') ?></span>
												</div>
											</div>
										</div>
										<?php endwhile; ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $h=1; ?>
				<?php if( have_rows('anexo_tab') ): $h; ?>
					<?php while( have_rows('anexo_tab') ): the_row(); $h++; ?>
						<div class="pop__up__y__content" id="<?php echo $h; ?>">
							<div class="pop__up__y__content__in <?php the_sub_field('anexo_tab_titulo'); ?>">
								<div class="pop__up__y__content__scroll">
									<div class="pop__up__y__mobile__title">
										<h3><?php the_sub_field('anexo_tab_titulo') ?></h3>	
									</div>
									<div class="pop__up__y__content__in__under ">
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
				<div class="pop__up__y__content" id="5">
					<div class="pop__up__y__content__in ">
						<div class="pop__up__y__content__scroll">
							<div class="pop__up__y__mobile__title">
								<h3><?php _e('Booking:','colorfull') ?><?php the_title(); ?></h3>
							</div>
							<div class="pop__up__y__content__in__under">
								<div class="pop__up__y__content__in__under__scroll">
									<?php
									$currentlang = pll_current_language();
									if($currentlang=="en"): ?>
										<?php echo do_shortcode('[contact-form-7 id="388" title="Booking form acommodation"]') ?>
									<?php
									elseif($currentlang=="es"): ?>
										<?php echo do_shortcode('[contact-form-7 id="390" title="Booking form acommodation ES"]') ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if (false): ?>
<div class="pop__up__y__wrap pop__up__y__book">
	<div class="pop__up__y__overlay"></div>
	<div class="pop__up__y">
		<div class="pop__up__y__close pop__up__y--close popupicon-up"></div>
		<div class="pop__up__y__container">
			<div class="pop__up__y__book__in">
				<div class="pop__up__y__book__scroll">
				<div class="pop__up__y__close pop__up__y--close popupicon-on"></div>
				<div class="pop__up__y__form__book__title">
					<h3><i><?php _e('Booking','colorfull'); ?>:</i> <?php the_excerpt(); ?></h3>
				</div>
				<?php
				$currentlang = pll_current_language();
				if($currentlang=="en"): ?>
					<?php echo do_shortcode('[contact-form-7 id="364" title="Booking form"]') ?>
				<?php
				elseif($currentlang=="es"): ?>
					<?php echo do_shortcode('[contact-form-7 id="365" title="Booking form ES"]') ?>
				<?php endif; ?>
				
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif ?>

<?php
get_footer();
?>


<script>
	jQuery(document).ready(function($){

		$('.g__button--book').click(function(event) {
			event.preventDefault();
			$('.pop__up__y__tabs').addClass('active');
			$('.pop__up__y__content').removeClass('active');
			$('.pop__up__y__btn').removeClass('active');
			$('.pop__up__y__content[id="5"]').addClass('active');
			$('.pop__up__y__btn[data-id="5"]').addClass('active');
		});

		$('.btnBookacco').click(function(event) {
			/*event.preventDefault();
			$('.pop__up__y__tabs ').removeClass('active');
			$('.pop__up__y__book ').addClass('active');*/

			event.preventDefault();
			$('.pop__up__y__tabs').addClass('active');
			$('.pop__up__y__content').removeClass('active');
			$('.pop__up__y__btn').removeClass('active');
			$('.pop__up__y__content[id="5"]').addClass('active');
			$('.pop__up__y__btn[data-id="5"]').addClass('active');

			var data_id = parseInt($(this).attr("data-id"));
			var cont = 1;

			$(".input__g--check--radio input").each(function() {
				if(cont++ == data_id) $(this).prop("checked", true);
			});
		});


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

		//slider rooms
		$('.popup__content__room__slider ul').slick({
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots: false,
		});

		//text more/less
		var showChar = 230;
		var ellipsestext = "...";

		$(".popup__content__room__more").each(function() {
		  var content = $(this).html();
		  if (content.length > showChar) {
			var c = content.substr(0, showChar);
			var h = content;
			var html =
			  '<div class="popup__content__room__more--text" style="display:block">' +
			  c +
			  '<span class="moreellipses">' +
			  ellipsestext +
			  '&nbsp;&nbsp;<a href="" class="pop__up--more more">'+  $(this).data('text') + '</a></span></span></div><div class="popup__content__room__more--text" style="display:none">' +
			  h +
			  '<a href="" class="pop__up--more less">' +  $(this).data('text-less') + '</a></span></div>';

			$(this).html(html);
		  }
		});

		$(".pop__up--more").click(function() {
		  var thisEl = $(this);
		  var cT = thisEl.closest(".popup__content__room__more--text");
		  var tX = ".popup__content__room__more--text";

		  if (thisEl.hasClass("less")) {
			cT.prev(tX).toggle();
			cT.slideToggle();
		  } else {
			cT.toggle();
			cT.next(tX).fadeToggle();
		  }
		  return false;
		});

	});
</script>