<?php $research = get_field('research') ?>

<section id="projects" class="container-fluid">
	<div class="project">
		<div class="project__img">
			<figure>
				<div class="img">
					<img src="<?php echo get_field("background_image") ?>">
				</div>

				<figcaption>
					<div class="text">
						<h4 class="text__subtitle">
							Current research project
						</h4>
						<h3 class="text__title">
							<?php echo $research->post_title ?>
						</h3>

						<p class="project--introduction">
							<?php echo $research->post_excerpt ?>
						</p>
					</div>
				</figcaption>
			</figure>
		</div>

		<div class="project__desc">
			<div class="text">
				<p><?php echo $research->post_content ?></p>
			</div>
		</div>
	</div>
</section>