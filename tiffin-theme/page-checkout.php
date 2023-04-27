<?php
get_header();

wp_localize_script("ajax-script", "tiffin_js", [
	"ajax_url" => admin_url("admin-ajax.php"),
]);

while (have_posts()) : the_post();
?>

<main>

<div class="tiffin__checkout">
	<div class="tiffin__wrapper">
		<div class="tiffin__checkout--steps">
			<div class="tiffin__checkout--title">
				<h1><?php _e("Checkout", "woocommerce") ?></h1>
			</div>
			<?php the_content($post); ?>
		</div>
		<div class="tiffin__checkout--order_review">
			<div class="tiffin__checkout--title">
				<h2><?php _e("Your Items", "woocommerce") ?></h2>
			</div>
			<?php do_action('woocommerce_order_review'); ?>
		</div>
	</div>
</div>

</main>
<?php
endwhile;

if(!isset($_SESSION["selected_address"]) && ! is_user_logged_in() && !isset($_SESSION["pickup_selected"])) {
?>
<script>
setTimeout(function() {
	jQuery("#tiffin__deliverymap--open").click();
}, 500);
</script>
<?php
}

get_footer();
?>