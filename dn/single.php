<?php get_header(); ?>



<?php if (have_posts() ) : ?>
<main id="primary" class="site-main">
	<section class="ii i7 wrapper gray-background">
		<div class="text">
			<div class="left-half valign-center">
				<div class="img">
					<img src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?php echo get_the_title() ?>">
				</div>
			</div>
			<div class="right-half valign-center">
				<h4 class="text__date"><?php echo get_the_date() ?></h4>
				<h3 class="text__title"><?php echo get_the_title() ?></h3>

				<div class="social-box">
					<?php if(get_field('facebook_url', 'option')): ?>
						<div class="social-box-icon">
							<a target="_blank"  href="http://www.facebook.com/sharer.php?s=100&p[url]=<?php echo get_permalink() ?>&p[title]=<?php echo get_the_title() ?>&p[images][0]=<?php echo get_the_post_thumbnail_url() ?>">
								<?php get_svg('facebook-icon', "#6D485C") ?>
							</a>
						</div>
					<?php endif ?>

					<?php if(get_field('linkedin_url', 'option')): ?>
						<div class="social-box-icon">
							<a target="_blank" href="https://www.linkedin.com/shareArticle?url=<?php echo get_permalink() ?>" >
								<?php get_svg('linkedin-icon', "#6D485C") ?>
							</a>
						</div>
					<?php endif ?>

					<?php if(get_field('twitter_url', 'option')): ?>
						<div class="social-box-icon">
							<a target="_blank" href="http://twitter.com/share?url=<?php echo get_permalink() ?>">
								<?php get_svg('twitter-icon', "#6D485C") ?>
							</a>
						</div>
					<?php endif ?>
				</div>

				<?php if(get_the_excerpt()): ?>
				<p>
					<?php echo get_the_excerpt() ?>
				</p>
				<?php endif ?>
			</div>
		</div>
	</section>
	<div class="post">
		<div class="paragraph text">
			<?php the_content() ?>
		</div>
	</div>
	<div class="related-posts">
		<div class="related-posts-top">
			<h2 class="title">Related Posts</h2>
			<div class="link blank">
				<a href="http://delitess.com/dndndn/grants/">
					<span>See all posts</span>
				</a>
			</div>
		</div>

		<?php $prev_post = get_adjacent_post(false, '', true) ?>
		<?php $next_post = get_adjacent_post(false, '', false) ?>

		<div class="related-posts-container  <?php echo (empty($prev_post) || empty($next_post) ) ? 'single' :  '' ?>">
			
			<?php if(!empty($prev_post)): ?>
				<div class="before" 
					style="background: linear-gradient(to right, #00000090, #00000090), url(<?php echo get_the_post_thumbnail_url($prev_post->ID) ?>);" >
					<p class="text__date"><?php echo get_the_date('', $prev_post->ID) ?></p>
					<h2 class="title">
						<span><?php echo $prev_post->post_title ?></span>
					</h2>
					<div class="link blank">
						<a href="<?php echo get_permalink($prev_post->ID) ?>">
							<span>PREVIOUS POST</span>
						</a>
					</div>
				</div>
			<?php endif ?>

			

			<?php if(!empty($next_post)): ?>
				<div class="after"
					style="background: linear-gradient(to right, #00000090, #00000090), url(<?php echo get_the_post_thumbnail_url($next_post->ID) ?>);">
					<p class="text__date"><?php echo get_the_date('', $next_post->ID) ?></p>
					<h2 class="title">
						<span><?php echo $next_post->post_title ?></span>
					</h2>
					<div class="link blank">
						<a href="<?php echo get_permalink($next_post->ID) ?>">
							<span>NEXT POST</span>
						</a>
					</div>
				</div>
			<?php endif ?>
		</div>
	</div>
</main>
<?php endif ?>

<?php get_footer(); ?>

