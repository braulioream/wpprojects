<section class="outreach wrapper gray-background">
	<?php

	$outreach_categories = get_terms( array(
	    'taxonomy' => 'outreach_category',
	    'hide_empty' => true,
	) );

	?>

	<?php foreach ($outreach_categories as $key => $category): ?>
	<div class="minisection <?php echo $key == 0 ? 'open' : ''  ?>">
		<div class="header minisection-accordeon-tab" data-accordeon-id="<?php echo $key ?>">
			<div class="title"><?php echo $category->name ?></div>
			<?php get_svg("arrow-bottom", "#6D485C") ?>
		</div>
		<div class="content minisection-accordeon-tab-content " id="minisection-accordeon-tab-content-<?php echo $key ?>">
			<?php  
				$outreach_args = array(
          'post_type' => 'outreach',
          'order' => 'ASC',
          'tax_query' => array(
              array(
                  'taxonomy' => 'outreach_category',
                  'field' => 'slug',
                  'terms' => $category->slug,
              )
          ),
          'posts_per_page' => 1
        );

        $outreaches = new WP_Query( $outreach_args );
			?>

			<?php foreach($outreaches->posts as $outreach_key => $outreach): ?>
				<div class="item">
					<figure>
						<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($outreach->ID), 'thumbnail' ) ?>" alt="">
						<figcaption>
							<div class="item-text">
								<div class="date"><?php echo get_the_date('', $outreach->ID) ?></div>
								<div class="title">
									<a target="_blank" href="<?php echo get_field('external_link', $outreach->ID) ?>"><?php echo $outreach->post_title ?></a>
								</div>
								<div class="subtitle"><?php echo $outreach->post_content ?></div>
							</div>
						</figcaption>
					</figure>
				</div>
			<?php endforeach ?>
		</div>
	</div>
	<?php endforeach ?>
</section>