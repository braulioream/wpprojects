<?php 

		$researches_args = array(
	    'post_type' => 'research',
	    'post_status' => 'publish',
	    'posts_per_page' => -1
		);

		$researches = new WP_Query( $researches_args );
?>


<?php foreach($researches->posts as $research_key => $research): ?>
<section class="projects ii i6 i6r wrapper">
	<div class="background gray-background <?php echo $research_key % 2 == 1 ? 'right' : 'left' ?>">
	</div>
	<div class="<?php echo $research_key % 2 == 1 ? 'right' : 'left' ?> text">
		<div class="valign-center">
			<h4 class="text__subtitle">Current research project</h4>
			<h3 class="text__title">Paleogenomic annotation of historical Cinchona bark samples across time and space.</h3>

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Congue quam bibendum duis quisque pellentesque scelerisque egestas laoreet. Elit, massa tellus vel vitae nisi pellentesque. Nisi nunc rutrum amet, dignissim nullam nulla mauris. In sed sodales pellentesque eget et neque, tortor, libero magna. Eu in eget quam dictum id. Eros ac sagittis diam at.</p>
		</div>
		<div class="valign-center">
			<div class="img">
				<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($research->ID), 'thumbnail' ) ?>">
			</div>
		</div>
	</div>
</section>
<?php endforeach ?>
