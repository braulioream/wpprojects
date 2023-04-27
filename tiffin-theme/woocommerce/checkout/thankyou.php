<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

// while (have_posts()) : the_post();

$bck = get_the_post_thumbnail_url();
?>

<main>
	<section class="thankyou tiffin__section" style="background-image: url('<?php echo $bck ?>')">
		<div class="tiffin__burntred">
			
		</div>


		<div class="tiffin__wrapper">
			<div class="thankyou__text">
				<h1><?php _e("Thank You", "woocommerce") ?></h1>
				<?php
				if (false) {
					the_content();
				}
				?>
				<p><?php _e("Thanks for dining with us!", "salient") ?></p>
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
// endwhile;
?>