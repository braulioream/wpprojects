<?php 

		$outreach_videos_args = array(
	    'post_type' => 'outreach_video',
	    'post_status' => 'publish',
	    'posts_per_page' => -1
		);

		$outreach_videos = new WP_Query( $outreach_videos_args );

?>

<div class="videos">
	<div class="videol text">
		<div class="videos-header text title">
			<h3 class="title">Videos</h3>

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
				<?php foreach($outreach_videos->posts as $video_key => $video): ?>
				<div class="swiper-slide">
					<div class="video--embed valign-center halign-center">
						<iframe width="560" height="315" src="<?php echo get_field('youtube_url', $video->ID) ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<div class="caption valign-center halign-center serif">
						<?php echo $video->post_title ?>
					</div>
				</div>
				<?php endforeach ?>	
				<!-- -->
			</div>
		</div>

		
	</div>
	<div class="videor gray-background">
		<div class="text title">
			<h3>More Videos</h3>
		</div>

		<div class="playlist">
			<?php foreach($outreach_videos->posts as $video_key => $video): ?> 
				<div class="item playlist-item <?php echo $video_key == 0 ? 'active' : '' ?>" data-playlist-video-id="<?php echo $video_key ?>">
					<figure>
						<div class="img">
							<img src="assets/img/thumb.png" class="thumb">
							<div class="play">
								<img src="assets/img/play.svg" alt="">
							</div>
						</div>

						<figcaption class="valign-center">
							<div class="title">
								<?php echo $video->post_title ?>
							</div>
						</figcaption>
					</figure>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>