
<?php 

		$publications_args = array(
	    'post_type' => 'publication',
	    'post_status' => 'publish',
	    'posts_per_page' => 4
		);

		$publications = new WP_Query( $publications_args );
?>


<section class="publications wrapper">

	<div class="text">
		<h3><?php echo get_field('title') ?></h3>
	</div>

	<?php foreach ($publications->posts as $key => $publication): ?>
		<div class="publication-item iii text">
			<div class="left-1">
				<div class="img">
					<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($publication->ID), 'thumbnail' ) ?>">
				</div>
			</div>

			<div class="right-2 item-text">
				<div class="date"><?php echo get_the_date('', $publication->ID) ?></div>
				<div class="title"><?php echo $publication->post_title ?></div>
				<p class="content">
					<?php echo $publication->post_content ?>
				</p>
				<div class="publication-item-bottom">
					<div class="link blank">
						<a href="#">
							<span>Check it out</span>
						</a>
					</div>
					<div class="share-social-box">
						<div class="share-social-icon">
							<a href="#">
								<?php get_svg('facebook-icon', "#6D485C") ?>
							</a>
						</div>
						<div class="share-social-icon">
							<a href="#">
								<?php get_svg('linkedin-icon', "#6D485C") ?>
							</a>
						</div>
						<div class="share-social-icon">
							<a href="#">
								<?php get_svg('twitter-icon', "#6D485C") ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach ?>
	
</section>