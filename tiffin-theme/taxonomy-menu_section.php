<?php
/*
 * Template Name: On Demand - Build Your Own Template
 */

get_header();

$tax = get_queried_object();

// _d($tax, "TAX: ");

// _d(get_fields(), "Post: ");
// global $post;

?>

<main>
	<?php
	//Default Values
	$bool_main_dish = false;
	$base_price = 0;
	$page_title = get_the_title();
	$options_selected = "";
	?>
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
							"echo" => true,
						]);
						?>
					</div>
				</div>
			</div>

			<div class="tiffin__wrapper">
				<div class="tiffin__buildoptions">
					<?php
					$args = [
						"post_type" => "tiffin_dish",
						"posts_per_page" => "-1",
						"tax_query" => [[
							"taxonomy" => $tax->taxonomy,
							"field" => "slug",
							"terms" => $tax->slug,
						]],
					];
					$q = new WP_Query($args);
					?>
					<div class="tiffin__buildoptions--section" data-extraname="<?php echo $section_id ?>" data-extrasectionname="<?php echo $section_name ?>">
						<div class="tiffin__title">
							<div class="tiffin__title--wrapper">
								<h2><?php echo $tax->name ?></h2>
								<span><?php echo $tax->description ?></span>
							</div>

							<div class="food_categories">
								<?php
								$food_categories = [
									"Vegan" => [
										"slug" => "vegan",
										"img" => get_stylesheet_directory_uri() . "/assets/images/icons/vegan-grey.png",
										"icon" => "<span class='icon-icon-vegan-gray'><span class='path1'></span><span class='path2'></span><span class='path3'></span></span>",
									],
									"Vegetarian" => [
										"slug" => "vegetarian",
										"img" => get_stylesheet_directory_uri() . "/assets/images/icons/vegetarian-grey.png",
										"icon" => "<span class='icon-vegetarian-grey'></span>",
									],
									"Gluten Free" => [
										"slug" => "gluten-free",
										"img" => get_stylesheet_directory_uri() . "/assets/images/icons/gf-grey.png",
										"icon" => "<span class='icon-g'></span>",
									],
								];
								?>
								<?php foreach ($food_categories as $fc_name => $fc_arr): ?>
								<div class="food_categories--option" data-fcslug="<?php echo $fc_arr["slug"] ?>">
									<div class="img_wrapper">
										<?php echo $fc_arr["icon"] ?>
										<?php if (false): ?>
										<img src="<?php echo $fc_arr["img"] ?>" alt="<?php echo $fc_name ?>">
										<?php endif ?>
									</div>
									<span><?php echo $fc_name ?></span>
								</div>
								<?php endforeach ?>
							</div>
						</div>

						<ul>
							<?php while($q->have_posts()): $q->the_post(); global $post; $product_id = hash("crc32", $post->ID . time()); ?>
							<?php if (get_field("main_dish_product")):
							$fc = get_the_terms($post, "food_category");

							$fc_img = [
								"vegan" => get_stylesheet_directory_uri() . "/assets/images/icons/vegan-white.png",
								"vegetarian" => get_stylesheet_directory_uri() . "/assets/images/icons/vegetarian-white.png",
								"gluten-free" => get_stylesheet_directory_uri() . "/assets/images/icons/gf-white.png",
							];

							$string_cat = "";
							if($fc):
								foreach ($fc as $cat):
									$string_cat .= "fc-" . $cat->slug . " ";
								endforeach;
							endif;
							?>

							<li data-itemid="<?php echo $post->ID; ?>" class="dish <?php echo $string_cat ?>">
								<a class="popup-with-zoom-anim" href="#<?php echo $product_id ?>" data-step="2">
								<figure>
									<?php
									$img_url = get_the_post_thumbnail_url();
									if($img_url == "") $img_url = get_stylesheet_directory_uri() . "/assets/images/dummy.png";

									$_main_dish = get_field("main_dish_product");
									$_product = wc_get_product($_main_dish);
									?>

									<div class="tiffin__buildoptions__figure--wrapper">
										<img src="<?php echo $img_url ?>" alt="<?php echo get_the_title($post) ?>">
										<div class="tiffin__figure--hover">
											<?php //Calories show ?>
											<?php if ($cal = get_field("product_calories", $post->ID)): ?>
												<span class="indicator--calory"><?php echo $cal ?> Cal</span>
											<?php endif ?>
											<?php //Food Category show ?>
											<?php

											if($fc):
											?>
											<div class="food_category_indicator">
												<?php foreach ($fc as $cat): ?>
												<div class="img_wrapper">
													<img src="<?php echo $fc_img[$cat->slug] ?>" alt="<?php echo $cat->name ?>">
												</div>
												<?php endforeach ?>
											</div>
											<?php endif; ?>
										</div>
									</div>

									<figcaption>
										<?php $price = $_product->get_price()? $_product->get_price() : "0" ?>
										<?php //$price = 2; ?>
										<?php $price_class = ($price == "0")? " hidden" : "" ?>
										<h3><?php echo get_the_title($post) ?></h3>
										<p><?php echo get_the_excerpt() ?></p>
										<div class="indicator--price <?php echo $price_class ?>" data-price="<?php echo $price ?>">
											<?php echo wc_price($price); ?>

											<p><?php _e("Customize", "woocommerce") ?></p>

										</div>
									</figcaption>
								</figure>
								</a>

								<?php
								$base_price = 0;
								$main_dish_id = get_field("main_dish_product");
								$product_title = get_the_title($main_dish_id);

								$options_selected = "";

								$main_dish = wc_get_product($main_dish_id);
								setup_postdata($main_dish_id);

								$base_price = $main_dish->get_price();
								$total_price = $base_price;
								?>
								<div class="tiffin__modal zoom-anim-dialog mfp-hide" id="<?php echo $product_id ?>" data-price="<?php echo $base_price ?>">
									<div class="tiffin__innerwrapper">
										<div class="tiffin__modal--header" style="background-image: url('<?php echo $img_url ?>')">
											<div class="tiffin__modal--blackback"></div>
											<div class="tiffin__modal--text">
												<h3>Build your</h3>
												<h2 class="maindish" data-maindish="<?php echo $main_dish_id ?>"><?php echo $product_title ?></h2>
											</div>
										</div>

										<div class="tiffin__modal--lists" data-simplebar>
											<?php
											while(have_rows("options")): the_row();
												$section_name = get_sub_field("option_name");
												$section_id = "section_" . str_replace(" ", "-", strtolower($section_name));

												$for_header[$section_id] = $section_name;
												$max_current = get_sub_field("option_max")? get_sub_field("option_max") : "0";
											?>
											<div class="tiffin__modal--section" data-extraname="<?php echo $section_id ?>" data-extrasectionname="<?php echo $section_name ?>">
												<?php if ($section_name != ""): ?>
												<div class="tiffin__modal--text">
													<h4><?php echo $section_name ?></h4>
												</div>
												<?php endif ?>

												<div class="tiffin__modal--list">
													<?php
													while(have_rows("choose_options")):
													the_row();
													if(get_sub_field("options_products")):
													$product_obj = get_sub_field("options_products");
													$_wc_product = wc_get_product($product_obj);

													$sel_default = get_sub_field("options_products_default")? true : false;
													?>
													<div class="tiffin__modal__item" data-itemid="<?php echo $product_obj->ID; ?>">
														<?php $price = $_wc_product->get_price()? $_wc_product->get_price() : "0" ?>
														<?php $plus = ($price == 0)? "" : "+"?>
														<span class="tiffin__modal__item--name"><?php echo get_the_title($product_obj) ?></span>
														<span class="tiffin__modal__item--price" data-pricetohide="<?php echo $price ?>"><?php echo $plus . wc_price($price) ?></span>

														<?php if ($_wc_product->is_type( "variable" )): $_wc_prod_variations = $_wc_product->get_available_variations(); ?>
														<div class="tiffin__modal__qty" data-modalid="<?php echo $product_id ?>">
															<?php $cont = 1; ?>
															<span class="tiffin__modal--ctrl tiffin__ctrl--minus enabled" data-control="minus">-</span>
															<ul class="tiffin__modal__qty--options">
																<?php foreach ($_wc_prod_variations as $k => $v): $var_name = $v["attributes"]; $var_name = reset($var_name); ?>
																<li class="<?php echo ($v["variation_id"] == get_sub_field("options_products_variation"))? "selected" : "" ?>" data-variation="<?php echo $v["variation_id"] ?>" data-number="<?php echo $cont++; ?>" data-price="<?php echo $v["display_regular_price"] ?>"><?php echo $var_name ?></li>

																<?php if($v["variation_id"] == get_sub_field("options_products_variation")) $total_price += $v["display_regular_price"]; ?>
																<?php endforeach; ?>
															</ul>
															<span class="tiffin__modal--ctrl tiffin__ctrl--plus enabled" data-control="plus">+</span>
														</div>
														<?php else: // YES or NO ?>
														<div class="tiffin__modal__options" data-modalid="<?php echo $product_id ?>">

															<div class="tiffin__modal--option">
																<?php $price = $_wc_product->get_price()? $_wc_product->get_price() : "0" ?>
																<span class="tiffin__ctrl--check <?php echo $sel_default? "selected" : "" ?>" data-price="<?php echo $price ?>"></span>
															</div>
															<?php if (false): ?>
															<div class="tiffin__modal--option">
																<span class="tiffin__ctrl--check <?php echo $sel_default? "" : "selected" ?>" data-price="0">No</span>
															</div>
															<?php endif ?>

															<?php if($sel_default) $total_price += $price; ?>
														</div>
														<?php endif; ?>
													</div>
													<?php endif; ?>
													<?php endwhile; ?>
												</div>
											</div>
											<?php endwhile; ?>
										</div>

										<div class="tiffin__modal--low-bar">
											<div class="tiffin__modal--qty">
												<input type="number" value="1" min="1" data-modalid="<?php echo $product_id ?>"/>
											</div>
											<div class="tiffin__modal--subtotal">
												<strong><?php echo wc_price($total_price) ?></strong>
											</div>

											<div class="tiffin__modal--addtocart btn btn--white ondemand_addtocart" data-modalid="<?php echo $product_id ?>">
												<a href="#">
													<span><?php _e("Add to Order", "woocommerce") ?></span>
												</a>
											</div>
										</div>
									</div>
								</div>

								<?php if (!$bool_main_dish && false): ?>
								<div class="btn btn--red">
									<a href="#">
										<span>Build Your Own</span>
									</a>
								</div>
								<?php endif ?>
							</li>
							<?php endif ?>
							<?php endwhile; ?>
						</ul>
					</div>

					<?php if (false && $bool_main_dish && sizeof($for_header) > 0): ?>
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
				<div class="tiffin__build--loading">
					<div class="lds-ellipsis">
						<div></div>
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>
			</div>
		</div>

		<?php
		$item_count = tiffin_cart_contents_count();
		if($item_count > 0):
		?>
		<div class="tiffin__build--header">
			<div class="tiffin__wrapper">
				<div class="extra">
					<h2>
						<i class="icon-salient-cart"></i>
						<?php echo $item_count . " items" ?>
					</h2>
					
					<div class="tiffin__build__close">
						&times;
					</div>
				</div>
				
				<div class="tiffin__build--addtoorder">
					<div class="tiffin__product--price" id="added_tiffin__product--price">
						<label><?php _e("Subtotal", "woocommerce") ?></label>
						<span><?php echo wc_price(tiffin_cart_contents_total()); ?></span>
					</div>

					<div class="btn btn--white">
						<a href="<?php echo site_url("cart"); ?>">
							<span><?php _e("Cart & Checkout", "woocommerce"); ?></span>
						</a>
					</div>
				</div>

				<div class="tiffin__build--desc">
					<div>
						<ul>
							<?php echo tiffin_cart_contents_review(); ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	</section>
</main>

<?php //get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>