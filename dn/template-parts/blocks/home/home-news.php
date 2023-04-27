<?php 

		$args = array(
	    'post_type' => 'post',
	    'post_status' => 'publish',
	    'posts_per_page' => 4
		);

		$posts = new WP_Query( $args );

?>

<div class="home__news">
	<div class="text title">
		<h3><?php echo get_field("title") ?></h3>
	</div>

	<div class="news">

		<?php foreach ($posts->posts as $key => $post) : ?>
		
		<div class="home__new new<?php echo $key + 1 ?>">
			<figure>
				<div class="img">
					<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ) ?>" alt="">
				</div>

				<figcaption>
					<a href="<?php echo get_permalink($post->ID) ?>" class="new__text">
						<div class="top">
							<h4><?php echo get_the_date('', $post->ID) ?> </h4>
							<h3><?php echo $post->post_title ?></h3>
						</div>
						<div class="bottom">
							<div class="link blank-white">
								<span>Read more</span>
							</div>
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
</div>