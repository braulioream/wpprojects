<?php
/*
 * Template Name: On Demand - Build Your Own Template
 */

get_header();
?>

<main>
	<?php
	//Default Values
	$bool_main_dish = false;
	$base_price = 0;
	$page_title = get_the_title();
	$options_selected = "";
	?>
	<?php if (($main_dish_id = get_field("main_dish_product")) && true): ?>
	<?php
		$bool_main_dish = true;
		$page_title = get_the_title($main_dish_id);
	?>
	<section class="tiffin__section tiffin__product">
		<div class="tiffin__wrapper">
			<div class="tiffin__product--info">
				<div class="tiffin__product--desc">
					<h2><?php _e("Build Your", "salient") ?></h2>

					<?php
					$main_dish = wc_get_product($main_dish_id);
					setup_postdata($main_dish_id);
					?>

					<h1 class="maindish" data-maindish="<?php echo $main_dish_id ?>"><?php echo get_the_title($main_dish_id); ?></h1>
					<p><?php echo get_the_content(); ?></p>
				</div>

				<div class="tiffin__product--buttons">
					<div class="btn btn--red">
						<a href="#">
							<span>Order Now</span>
						</a>
					</div>

					<div class="btn btn--white tiffin__add_to_fav">
						<a href="#">
							<i></i>
							<span>Add to Favorites</span>
						</a>
					</div>

					<div class="tiffin__product--price">
						<span id="base_price" data-price="<?php echo $main_dish->get_price(); ?>">$<?php echo ($base_price = $main_dish->get_price()); ?></span>
					</div>
				</div>
			</div>

			<div class="tiffin__product--picture">
				<figure>
					<img src="<?php echo get_the_post_thumbnail_url($main_dish_id); ?>" alt="<?php echo get_the_title(); ?>">
				</figure>
			</div>
		</div>
	</section>
	<?php endif ?>

	<?php // Section: Build Your Own ?>
	<section class="tiffin__section tiffin__build">
		<div class="tiffin__extra">
			<div class="tiffin__menu">
				<div class="tiffi__wrapper">
					<h3>Menu</h3>

					<div class="tiffin__menu--items">
						<?php
						wp_nav_menu([
							"menu" => "On Demand Menu",
						]);
						?>
					</div>
				</div>
			</div>

			<div class="tiffin__wrapper">
				<div class="tiffin__buildoptions">
					<?php /* Proteins Section */ ?>

					<?php

					$max_letters = [
						"1" => "Choose one",
						"2" => "Choose up to two",
						"3" => "Choose up to three",
						"4" => "Choose up to four",
						"5" => "Choose up to five",
					];

					while(have_rows("options")): the_row();
					?>
					<?php
					$section_name = get_sub_field("option_name");
					$section_id = "section_" . str_replace(" ", "-", strtolower($section_name));

					$for_header[$section_id] = $section_name;
					$max_current = get_sub_field("option_max")? get_sub_field("option_max") : "0";
					// $max_current = get_field($section_data[1])? get_field($section_data[1]) : "0";
					if(have_rows("choose_options")):
					?>
					<div class="tiffin__buildoptions--section" data-extraname="<?php echo $section_id ?>" data-extrasectionname="<?php echo $section_name ?>">
						<div class="tiffin__title">
							<h2><?php echo $section_name ?></h2>
							<?php
							if($max_current != "0"):
								echo "<span> " . $max_letters[$max_current] . ".</span>";
							endif;
							?>
						</div>

						<ul data-maxitems="<?php echo $max_current; ?>">
							<?php
							while(have_rows("choose_options")):
							the_row();
							$product_obj = get_sub_field("options_products");
							// _d($product_obj);
							$sel_default = get_sub_field("options_products_default")? " selected" : "";

							if($sel_default == " selected") {
								if($options_selected != "") $options_selected .= ", ";
								$options_selected .= get_the_title($product_obj);
							}
							?>
							<li class="<?php echo $sel_default ?>" data-itemid="<?php echo $product_obj->ID; ?>">
								<figure>
									<?php
									$img_url = get_the_post_thumbnail_url($product_obj);
									if($img_url == "") $img_url = get_stylesheet_directory_uri() . "/assets/images/dummy.png";

									$_product = wc_get_product($product_obj);
									?>

									<div class="tiffin__buildoptions__figure--wrapper">
										<img src="<?php echo $img_url ?>" alt="<?php echo get_the_title($product_obj) ?>">
										<div class="tiffin__figure--hover">
											<?php if ($cal = get_field("product_calories", $product_obj->ID)): ?>
												<span class="indicator--calory"><?php echo $cal ?> Cal</span>
											<?php endif ?>
										</div>
									</div>

									<figcaption>
										<?php $price = $_product->get_price()? $_product->get_price() : "0" ?>
										<?php $price_class = ($price == "0")? " hidden" : "" ?>
										<h3><?php echo get_the_title($product_obj) ?></h3>
										<span class="indicator--price <?php echo $price_class ?>" data-price="<?php echo $price ?>">$ <?php echo $price; ?></span>
									</figcaption>
								</figure>

								<?php if (!$bool_main_dish): ?>
								<div class="btn btn--red">
									<a href="#">
										<span>Build Your Own</span>
									</a>
								</div>
								<?php endif ?>
							</li>
							<?php endwhile; ?>
						</ul>
					</div>
					<?php endif; ?>
					<?php endwhile; ?>

					<?php if ($bool_main_dish && sizeof($for_header) > 0): ?>
					<div class="tiffin__buildoptions--header">
						<ul>
							<?php foreach ($for_header as $k => $v): ?>
							<li>
								<span class="scrollto" data-optionis="<?php echo $k ?>"><?php echo $v ?></span>
							</li>
							<?php endforeach ?>
						</ul>
					</div>
					<?php endif ?>
				</div>
			</div>
		</div>

		<div class="tiffin__build--header">
			<div class="tiffin__wrapper">
				<div class="tiffin__build--desc">
					<h2><?php echo $page_title ?></h2>
					<?php if (true): ?>
					<span><?php echo $options_selected ?></span>
					<?php endif ?>
				</div>

				<div class="tiffin__build--addtoorder">
					<div class="tiffin__product--price" id="added_tiffin__product--price">
						<span>$<?php echo $base_price ?></span>
					</div>

					<div class="btn" id="ondemand_addtocart">
						<a href="#">
							<span>Add to Order</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php if (false): ?>
	<section class="tiffin__section tiffin__product--extra">
		<div class="tiffin__wrapper">
			<ul>
				<li>
					<figure>
						<img src="" alt="Delivery">
						<figcaption>
							<span>Delivery</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						</figcaption>
					</figure>
				</li>
				<li>
					<figure>
						<img src="" alt="Support">
						<figcaption>
							<span>Support</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						</figcaption>
					</figure>
				</li>
				<li>
					<figure>
						<img src="" alt="Follow my Order">
						<figcaption>
							<span>Follow my Order</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						</figcaption>
					</figure>
				</li>
			</ul>
		</div>
	</section>
	<?php endif ?>
</main>

<?php //get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>