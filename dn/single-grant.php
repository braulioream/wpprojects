<?php get_header(); ?>

<?php if (have_posts() ) : ?>
<main id="primary" class="site-main grant-item">
	<section class="ii i7 wrapper gray-background grant-item-info">
		<div class="text">
			<div class="grant-item-header left-half valign-center">
				<h4 class="text__date"><?php echo get_the_date() ?></h4>
				<h3 class="text__title"><?php echo get_the_title() ?></h3>

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

				<?php if(get_the_excerpt()): ?>
				<p>
					<?php echo get_the_excerpt() ?>
				</p>
				<?php endif ?>

				<div class="read_more">
					<div class="link expanded pinky">
						<a href="#post-content">
							<span>Read more</span>
						</a>
					</div>
				</div>

			</div>
			<div class="right-half valign-center">
				<div class="img">
					<img src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?php echo get_the_title() ?>">
				</div>
			</div>
			
		</div>
	</section>
	<div class="post" id="post-content">
		<div class="paragraph text">
			<?php the_content() ?>
		</div>
	</div>

	<div class="single-bottom">
		<div class="link blank">
			<a href="<?php echo get_permalink( get_page_by_path( 'grants' ) ) ?>">
				<span><?php echo _e("See all posts", "dn3") ?></span>
			</a>
		</div>
	</div>

</main>
<?php endif ?>

<?php get_footer(); ?>

