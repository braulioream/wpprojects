<?php
get_header();

while (have_posts()) : the_post();

$bck = get_the_post_thumbnail_url();
?>

<main>
	<section class="thankyou tiffin__section" style="background-image: url('<?php echo $bck ?>')">
		<div class="tiffin__burntred">
			
		</div>


		<div class="tiffin__wrapper">
			<div class="thankyou__text">
				<h1><?php _e("Thank You", "woocommerce") ?></h1>
				<?php the_content() ?>
			</div>

			<div class="thankyou__btns">
				<div class="btn btn--white">
					<a href="<?php echo get_site_url() ?>">
						<span><?php _e("Home", "woocommerce") ?></span>
					</a>
				</div>

				<div class="btn btn--red">
					<?php $order_url = get_last_order_from_user(); ?>
					<a href="<?php $order_url ?>">
						<span><?php _e("View Your Order", "woocommerce") ?></span>
					</a>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
endwhile;
?>
<script>
	setTimeout(function() {
		window.location.href = "<?php echo $order_url ?>";
	}, 1000);
</script>

<?php
get_footer();
?>