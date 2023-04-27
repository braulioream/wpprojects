</div>


<a href="<?php echo get_permalink( get_page_by_path( 'contact' ) ); ?>" class="sticky-call-to-action">
	<?php get_svg('email-icon') ?>
</a>

<footer class="footer" >
	<div class="ii wrapper">
		<div class="text">
			<div class="left-half">
				<div class="w-70">
					<h3 class="footer-title">
						<?php echo get_field('title', 'option') ?>
					</h3>
					<p class="footer-address">
						<?php echo get_field('subtitle', 'option') ?>
					</p>
				</div>
				<div class="footer-brand-logos">
					
					<?php get_svg("google-school") ?>

					<?php get_svg("research-gate") ?>

				</div>
			</div>
			<div class="right-half">
				<div class="footer-social social-box">
					<?php if(get_field('facebook_url', 'option')): ?>
						<div class="social-box-icon">
							<a target="_blank" href="<?php echo get_field('facebook_url', 'option') ?>">
								<?php get_svg('facebook-icon') ?>
							</a>
						</div>
					<?php endif ?>

					<?php if(get_field('linkedin_url', 'option')): ?>
						<div class="social-box-icon">
							<a target="_blank" href="<?php echo get_field('linkedin_url', 'option') ?>" >
								<?php get_svg('linkedin-icon') ?>
							</a>
						</div>
					<?php endif ?>

					<?php if(get_field('twitter_url', 'option')): ?>
						<div class="social-box-icon">
							<a target="_blank" href="<?php echo get_field('twitter_url', 'option') ?>">
								<?php get_svg('twitter-icon') ?>
							</a>
						</div>
					<?php endif ?>
				</div>
				<div>
					Twiiter
				</div>
			</div>
		</div>
		<div class="footer-bar">
			<div class="left">
				<img class="footer-logo" src="<?php echo get_stylesheet_directory_uri(), "/assets/img/hl.png" ?>" alt="dpub2.png">
			</div>
			<div class="right">
				<p class="copyright">
					<?php echo get_field('copy', 'option') ?>
				</p>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
