<?php 

		$args = array(
	    'post_type' => 'publication',
	    'post_status' => 'publish',
	    'posts_per_page' => 2
		);

		$posts = new WP_Query( $args );

		debug($posts->posts);

?>

<section class="home__publications wrapper gray-background">
	<div class="text title">
		<h3><?php echo get_field("title") ?></h3>
	</div>

	<div class="home__publications--list">

		<?php foreach($posts->posts as $key => $publication): ?>

		<div class="item">
			<figure>
				<div class="img">
					<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($publication->ID), 'thumbnail' ) ?>" alt="">
				</div>
				<figcaption>
					<a href="<?php echo get_permalink($publication->ID) ?>" class="item-text">
						<div class="date"><?php echo get_the_date('', $publication->ID) ?></div>
						<div class="title"><?php echo $publication->post_title ?></div>

						<div class="link blank">
							<span>
								Read More
							</span>
						</div>
					</a>
				</figcaption>
			</figure>
		</div>

		<?php endforeach ?>
	</div>

	<div class="read_more">
		<div class="link expanded pinky">
			<a href="<?php echo get_field("read_more_link") ?>">
				<span>Read more</span>
			</a>
		</div>
	</div>
</section>