<?php 

		$posters_args = array(
	    'post_type' => 'poster',
	    'post_status' => 'publish',
	    'posts_per_page' => 4
		);

		$posters = new WP_Query( $posters_args );
?>


<section class="posters wrapper gray-background">
	<div class="posters-header text">
		<h3 class="title"><?php echo get_field('title') ?></h3>

		<div class="controls">
			<div class="controls-navigation controls-left">
				<?php get_svg("arrow-left") ?>
			</div>
			<div class="controls-navigation controls-right">
				<?php get_svg("arrow-right") ?>
			</div>
		</div>
	</div>


		<div class="swiper">
			<div class="swiper-wrapper">
				<?php foreach ($posters->posts as $key => $poster): ?>
					<div class="swiper-slide">
						<div class="poster-item item">
							<figure>
								<div class="img">
									<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($poster->ID), 'thumbnail' ) ?>" alt="">
								</div>
								<figcaption>
									<a href="#" class="item-text">
										<div class="date"><?php echo get_the_date('', $poster->ID)?></div>
										<div class="title"><?php echo $poster->post_title ?></div>
										<p class="content">
											<?php echo $poster->post_content ?>
										</p>
										<div class="link blank">
											<span>
												Read More
											</span>
										</div>
									</a>
								</figcaption>
							</figure>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	
	
	
</section>