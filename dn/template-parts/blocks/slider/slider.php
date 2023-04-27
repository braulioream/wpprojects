<div class="slider">

	<?php

		$args = array(
	    'post_type' => 'slide',
	    'post_status' => 'publish',
	    'posts_per_page' => -1
		);

		$posts = new WP_Query( $args );

	?> 

	<div class="swiper">
		<div class="swiper-wrapper">
			<?php foreach($posts->posts as $slide_key => $slide): ?>
				<?php $slide_id = $slide->ID ?>
				<div class="slide swiper-slide" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id($slide_id), 'thumbnail' ) ?>);">
					<div class="wrapper ">
						<div class="slide-content">
							<h4 class="slide-subtitle"><?php echo get_field('subtitle', $slide_id) ?></h4>
							<h2 class="slide-title"><?php echo $slide->post_title ?></h2>
							<a class="slide-button" href="<?php echo get_field('link', $slide_id) ?>">
								Learn more
							</a>
						</div>
						<div class="social-box">
							<?php if(get_field('facebook_url', 'option')): ?>
								<div class="social-box-icon">
									<a target="_blank" href="<?php echo get_field('facebook_url', 'option') ?>">
										<?php get_svg('facebook-icon') ?>
									</a>
								</div>
							<?php endif ?>

							<?php if(get_field('linkedin_url', 'option')): ?>
								<div class="social-box-icon">
									<a target="_blank" href="<?php echo get_field('linkedin_url', 'option') ?>" >
										<?php get_svg('linkedin-icon') ?>
									</a>
								</div>
							<?php endif ?>

							<?php if(get_field('twitter_url', 'option')): ?>
								<div class="social-box-icon">
									<a target="_blank" href="<?php echo get_field('twitter_url', 'option') ?>">
										<?php get_svg('twitter-icon') ?>
									</a>
								</div>
							<?php endif ?>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>

		<div class="slider-navigation slider-navigation-left">
			<svg width="16" height="31" viewBox="0 0 16 31" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M14.9517 25.9383L6.20168 15.0008L14.9517 4.06328C15.5099 3.36572 15.6536 2.42334 15.3286 1.59112C15.0036 0.758897 14.2593 0.163276 13.3761 0.0286171C12.4929 -0.106042 11.6049 0.240721 11.0467 0.938282L1.04668 13.4383C0.315426 14.3516 0.315426 15.65 1.04668 16.5633L11.0467 29.0633C11.9096 30.1416 13.4833 30.3162 14.5617 29.4533C15.64 28.5903 15.8146 27.0166 14.9517 25.9383Z" fill="white"/>
			</svg>
		</div>
		<div class="slider-navigation slider-navigation-right">
			<svg width="16" height="31" viewBox="0 0 16 31" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M1.04832 5.06172L9.79832 15.9992L1.04832 26.9367C0.490097 27.6343 0.346418 28.5767 0.671409 29.4089C0.996401 30.2411 1.74069 30.8367 2.62391 30.9714C3.50713 31.106 4.3951 30.7593 4.95332 30.0617L14.9533 17.5617C15.6846 16.6484 15.6846 15.35 14.9533 14.4367L4.95332 1.93672C4.09038 0.858379 2.51666 0.683769 1.43832 1.54671C0.359987 2.40966 0.185378 3.98338 1.04832 5.06172Z" fill="white"/>
			</svg>
		</div>
	</div>

</div>