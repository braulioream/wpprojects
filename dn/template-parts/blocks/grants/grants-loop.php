<?php 

		$grants_args = array(
	    'post_type' => 'grant',
	    'post_status' => 'publish',
	    'posts_per_page' => 4
		);

		$grants = new WP_Query( $grants_args );
?>


<div class="grants wrapper">

	<?php foreach ($grants->posts as $grant_key => $grant): ?>
		<div class="tile tile-<?php echo $grant_key % 2 == 1 ? 'right' : 'left' ?>">
			<div class="item">
				<div class="year">2020</div>

				<div class="img">
					<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($grant->ID), 'thumbnail' ) ?>" >
				</div>

				<a href="<?php echo get_permalink($grant->ID) ?>" class="item-text">
					<div class="title"><?php echo $grant->post_title ?></div>
					<p>For a three months stay at Royal Botanic Gardens, Kew .</p>
					<span class="ext-link">Read More <i>→</i></span>
				</a>
				
			</div>
		</div>

		<?php if(count($grants->posts) > $grant_key + 1): ?>
			<div class="connection<?php echo $grant_key % 2 == 1 ? '2' : '' ?> valign-center halign-center">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/connection.svg' ?>" alt="">
			</div>
		<?php endif ?>

	<?php endforeach ?>

	<div class="read_more">
		<div class="link expanded pinky">
			<a href="<?php echo get_permalink( get_page_by_path( 'contact' ) ); ?>">
				<span>Get in touch now</span>
			</a>
		</div>
	</div>

</div>