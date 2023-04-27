<?php 

require_once("functions/multistep-checkout.php");

add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100);

function salient_child_enqueue_styles() {
		
		$nectar_theme_version = nectar_get_theme_version();
		wp_enqueue_style( 'salient-child-style', get_stylesheet_directory_uri() . '/style.css', '', $nectar_theme_version );
		
		if ( is_rtl() ) {
			wp_enqueue_style(  'salient-rtl',  get_template_directory_uri(). '/rtl.css', array(), '1', 'screen' );
		}
}

/* Codetactic Customizations
 * Author: hinafu
*/

/* REWRITE RULES SECTION */


add_action("init", "tiffin_add_rewrite");

function tiffin_add_rewrite() {
	if (session_status() == PHP_SESSION_NONE) {
		session_start();

		if(!isset($_SESSION["map"])) {
			$_SESSION["map"] = [];
		}
	}

	$_SESSION["tiffin_tip"] = [];

	if(false) {
		add_rewrite_rule(
			// "^p/(d+)/?$",
			// "^on-demand/([^/]+)(?:/([0-9]+))?/?$",
			// "^on-demand/([a-zA-Z-/]+)/?$",
			"^on-demand/([a-zA-Z-/]+)/?$",
			//str_replace("/", "-", $matches[1]
			"index.php?tiffin_dish=on-demand-\$matches[1]&on_demand=1",
			"top"
		);
	}

	if (true) {
	add_rewrite_rule(
		"^checkout/thank-you(/.*)*$",
		"index.php?pagename=thank-you",
		"top"
	);
	}

	add_rewrite_rule(
		"^order-now/([a-zA-Z-/]+)/?$",
		"index.php?menu_section=\$matches[1]",
		"top"
	);

	add_rewrite_rule(
		"^order-now/*$",
		"index.php?menu_section=kathi-rolls",
		"top"
	);
}

/*
add_filter("query_vars", "tiffin_add_query_vars");

function tiffin_add_query_vars($vars) {
	$vars[] = "on_demand";
	return $vars;
}

add_action("pre_get_posts", "tiffin_template_redirects");

function tiffin_template_redirects($q) {
	if($q->is_main_query() && $on_demand = $q->get("on_demand")) {
		$pagename = $q->get("tiffin_dish");
		$q->set("tiffin_dish", str_replace("/", "-", $pagename));
	}
}
*/

add_action("wp_enqueue_scripts", "child_scripts");

add_action("admin_enqueue_scripts", "admin_child_scripts", 105);

function child_scripts() {
	wp_enqueue_script("tiffin_script", get_stylesheet_directory_uri() . "/assets/js/main.js", [], "1", true);
	wp_enqueue_style( "tiffin_css", get_stylesheet_directory_uri() . "/assets/css/main.css", "", 1);

	wp_enqueue_style( "icomoon", get_stylesheet_directory_uri() . "/assets/icomoon/style.css", "", 1);

	//other scripts
	//Magnific Popup
	wp_enqueue_script("magnific-popup_script", get_stylesheet_directory_uri() . "/assets/js/jquery.magnific-popup.js", [], "1", true);
	wp_enqueue_style( "magnific-popup_css", get_stylesheet_directory_uri() . "/assets/css/magnific-popup.css", "", 1);

	//Simplebar
	wp_enqueue_script("simplebar_script", get_stylesheet_directory_uri() . "/assets/js/simplebar.min.js", [], "1", true);
	wp_enqueue_style( "simplebar_css", get_stylesheet_directory_uri() . "/assets/css/simplebar.css", "", 1);

	//DateTimePicker
	wp_enqueue_script("datetimepicker_js", get_stylesheet_directory_uri() . "/assets/js/datepicker/jquery.datetimepicker.full.min.js");
	wp_enqueue_style( "datetimepicker_css", get_stylesheet_directory_uri() . "/assets/js/datepicker/jquery.datetimepicker.min.css");

	wp_enqueue_script("iconify", "https://code.iconify.design/1/1.0.4/iconify.min.js", [], 1);

	if(current_user_can("administrator")) {
		wp_enqueue_script("tiffin_admin_script", get_stylesheet_directory_uri() . "/assets/js/admin_script.js" );
	}
}

function admin_child_scripts() {
	wp_deregister_script("woocommerce_product_addons");

	wp_enqueue_script("tiffin_woocommerce_product_addons", get_stylesheet_directory_uri() . "/woocommerce-product-addons/assets/js/admin.js", ["jquery"], "1");
}

// Point of Sale Scripts

add_filter("wc_pos_enqueue_scripts", "tiffin_pos_scripts" );

function tiffin_pos_scripts($scripts) {
	$scripts["tiffin_admin_script"] = get_stylesheet_directory_uri() . "/assets/js/admin_script.js";

	return $scripts;
}

function _d($s, $t = "") {
	if($t != "") echo "<h2>${t}</h2>";
	echo "<pre>";
	print_r($s);
	echo "</pre>";
}

function get_location_from_short_url($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	//_d($result, "result: ");
	if (preg_match("#Location: (.*)#", $result, $match)) {
		//_d($match, "Match: ");
		$location = trim($match[1]);
	}

	return $location;
}

add_shortcode("insert", "insert_content");

function insert_content($atts) {
	$atts = shortcode_atts( array(
		"slug" => "",
	), $atts, "insert" );

	$slug = $atts["slug"];

	if($slug = "") return "";

	$page = get_posts([
		"name" => "slug",
		"post_type" => "page",
	]);

	if($page) return $page[0]->post_content;
}

add_action("wp_enqueue_scripts", function() {
	$tiffin_wp_nonce = wp_create_nonce("createondemandorderfor_" . $post->ID . "_" . time());

	wp_enqueue_script("ajax-script", get_stylesheet_directory_uri() . "/assets/js/ajax-script.js", [], 1, true);

	wp_localize_script("ajax-script", "tiffin_js", [
		"ajax_url" => admin_url("admin-ajax.php"),
		"tiffin_wp_nonce" => $tiffin_wp_nonce,
		"tiffin_cart" => wc_get_cart_url(),
	]);
});

add_action("wp_ajax_new_ondemand_order", "ondemand_addtocart");
add_action("wp_ajax_nopriv_new_ondemand_order", "ondemand_addtocart");

function ondemand_addtocart() {
	$items = $_GET["items"];

	global $woocommerce;

	//$woocommerce->cart->empty_cart();

	// _d($items, "items: ");wp_die();

	$secret = $items["secret"];
	$main_dish = $items["main_dish"];
	$quantity = $items["quantity"];

	$general_tiffin_type = ($main_dish == "")? "standalone" : "extra";

	$item_description = "";

	foreach($items as $k => $v) {
		if($k == "secret" || $k == "main_dish" || $k == "quantity") continue;

		// $item_description .= "<strong>" . $v["section_name"] . "</strong>: ";
		$item_list = "";

		foreach($v["items"] as $product_id) {
			$extra_type = $general_tiffin_type;

			if(has_term("beverages", "product_cat", $product_id["item_id"])) {
				$extra_type = "standalone";
			}

			$woocommerce->cart->add_to_cart($product_id["item_id"], $quantity, $product_id["variation_id"], "", [
				"secret" => $secret,
				"tiffin_type" => $extra_type,
			]);

			// if($item_list != "") $item_list .= ", ";

			$vv = ($product_id["variation_id"] == "0")? $product_id["item_id"] : $product_id["variation_id"];

			$current_variation = wc_get_product($vv);
			$title = $current_variation->get_formatted_name();

			// $item_list .= get_the_title($product_id["item_id"]);
			if($extra_type != "standalone") $item_list .= $title . "|";
		}

		// $item_description .= $item_list . "|";
		$item_description .= $item_list;
	}

	//add_to_cart(main_dish);

	$woocommerce->cart->add_to_cart($main_dish, $quantity, "", "", [
		"secret" => $secret,
		"tiffin_type" => "main_dish",
		"desc" => $item_description,
	]);

	echo "OK";

	wp_die();
}

add_action( "woocommerce_checkout_create_order_line_item", "tiffin_save_extra_item_data", 20, 4 );

function tiffin_save_extra_item_data( $item, $cart_item_key, $values, $order ) {
	$arr = [
		"secret",
		"tiffin_type",
		"desc",
	];

	foreach ($arr as $custom_data) {
		if( isset( $values[$custom_data] ) ) {
			$item->update_meta_data( $custom_data, $values[$custom_data] );
		}
	}
}


add_action("wp_ajax_tiffin_updatetip", "tiffin_updatetip_function");
add_action("wp_ajax_nopriv_tiffin_updatetip", "tiffin_updatetip_function");

function tiffin_updatetip_function() {
	$new_val = $_GET["tip_new"];

	WC()->session->set("tip_percentage", $new_val);

	if(WC()->session->get("tip_percentage") == $new_val) {
		echo "OK";
	}

	wp_die();
}

add_action("wp_ajax_tiffin_updatecustomtip", "tiffin_updatecustomtip_function");
add_action("wp_ajax_nopriv_tiffin_updatecustomtip", "tiffin_updatecustomtip_function");

function tiffin_updatecustomtip_function() {
	$new_val = $_GET["tip_value"];
	$tip_type = $_GET["tip_type"];

	$aux = intval($new_val);

	if($aux <= 0) $new_val = 0;

	WC()->session->set("tip_percentage", $new_val);
	WC()->session->set("tip_type", $tip_type);

	if(WC()->session->get("tip_percentage") == $new_val && WC()->session->get("tip_type") == $tip_type) {
		echo "OK";
	}

	wp_die();
}


add_action("wp_ajax_get_ondemand_menu", "get_ondemand_menu_function");
add_action("wp_ajax_nopriv_get_ondemand_menu", "get_ondemand_menu_function");

function get_ondemand_menu_function() {
	$slug = $_GET["slug"];
	$tax = get_term_by("slug", $slug, "menu_section");

	$args = [
		"post_type" => "tiffin_dish",
		"posts_per_page" => "-1",
		"tax_query" => [[
			"taxonomy" => "menu_section",
			"field" => "slug",
			"terms" => $slug,
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
							<?php if ($cal = get_field("product_calories", $post->ID)): ?>
								<span class="indicator--calory"><?php echo $cal ?> Cal</span>
							<?php endif ?>
							<?php //Food Category show ?>
							<?php if($fc): ?>
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
			</li>
			<?php endif ?>
			<?php endwhile; ?>
		</ul>
	</div>

<?php
	wp_die();
}

/* When removing items from the cart */

add_action( "woocommerce_remove_cart_item", "tiffin_at_remove_product", 10, 2 );

function tiffin_at_remove_product($removed_cart_item_key, $cart) {
	//Get type and secret from removed item
	$_cart = $cart->get_cart_contents();

	$type = isset($_cart[$removed_cart_item_key]["tiffin_type"])? $_cart[$removed_cart_item_key]["tiffin_type"] : "none";

	if($type != "main_dish") return;

	$toremove = [];

	// $_cart = WC()->cart->get_cart();
	// $_cart = $cart;

	$secret = $_cart[$removed_cart_item_key]["secret"];

	foreach ($_cart as $cart_item_key => $cart_item) {
		$tiffin_type = isset($cart_item["tiffin_type"])? $cart_item["tiffin_type"] : "none";

		if($tiffin_type == "extra" && $cart_item["secret"] == $secret) array_push($toremove, $cart_item_key);
	}

	foreach($toremove as $item_toremove) {
		WC()->cart->remove_cart_item($item_toremove);
	}
}

add_action("woocommerce_after_cart_item_quantity_update", "tiffin_at_update_quantity_product", 10, 4); 

function tiffin_at_update_quantity_product($cart_item_key, $quantity, $old_quantity, $cart) { 
	//Get type and secret from removed item
	$_cart = $cart->get_cart_contents();

	$type = isset($_cart[$cart_item_key]["tiffin_type"])? $_cart[$cart_item_key]["tiffin_type"] : "none";

	if($type != "main_dish") return;

	$toupdatequantity = [];

	$secret = $_cart[$cart_item_key]["secret"];

	foreach ($_cart as $_cart_item_key => $cart_item) {
		$tiffin_type = isset($cart_item["tiffin_type"])? $cart_item["tiffin_type"] : "none";

		if($tiffin_type == "extra" && $cart_item["secret"] == $secret) array_push($toupdatequantity, $_cart_item_key);
	}

	foreach($toupdatequantity as $item_toupdate) {
		// WC()->cart->remove_cart_item($item_toremove);
		WC()->cart->set_quantity($item_toupdate, $quantity);
	}
}; 
         
// add the action 

$debug_tags = array();
add_action( 'all', function ( $tag ) {
    global $debug_tags;
    return;
    if ( in_array( $tag, $debug_tags ) ) {
        return;
    }
    echo "<pre>" . $tag . "</pre>";
    $debug_tags[] = $tag;
} );

add_filter("acf/settings/remove_wp_meta_box", "__return_false");

function parse_tiffin_ondemand_product_desc($s) {
	$lines = explode("|", $s);
	$ss = "";
	foreach($lines as $line) {
		$ss .= "<span>" . $line . "</span>";
	}
	return $ss;
}


function tiffin_cart_contents_count() {
	global $woocommerce;

	$cart = $woocommerce->cart->get_cart_contents();
	$cont = 0;

	foreach($cart as $k => $v) {
		if($v["tiffin_type"] != "extra") {
			$cont += intval($v["quantity"]);
		}
	}

	return $cont;
}

function tiffin_cart_contents_total() {
	global $woocommerce;

	$cart = $woocommerce->cart->get_cart_contents();
	$cont = 0;

	foreach($cart as $k => $v) {
		// _d($v, "Producto (?): ");
		$cont += (floatval($v["line_total"]) * intval($v["quantity"]));
	}

	return $cont;
}

function tiffin_cart_contents_review() {
	global $woocommerce;

	$cart = $woocommerce->cart->get_cart_contents();
	$names = "";

	foreach($cart as $k => $v) {
		if($v["tiffin_type"] != "extra") {
			$names .= "<li>" . $v["data"]->get_name() . "</li>";
		}
	}

	return $names;
}

function remove_fragments_filters() {
	remove_filter("woocommerce_add_to_cart_fragments", "nectar_woocommerce_header_add_to_cart_fragment");
	remove_filter("woocommerce_add_to_cart_fragments", "nectar_mobile_woocommerce_header_add_to_cart_fragment");
	remove_filter("add_to_cart_fragments", "nectar_woocommerce_header_add_to_cart_fragment");

	add_filter("woocommerce_add_to_cart_fragments", "tiffin_cart_contents_count_filter");
}

add_action("after_setup_theme", "remove_fragments_filters");

function tiffin_cart_contents_count_filter($fragments) {
	global $woocommerce;

	ob_start(); ?>

	<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>"><div class="cart-icon-wrap"><i class="icon-salient-cart"></i> <div class="cart-wrap"><span><?php echo esc_html( tiffin_cart_contents_count() ); ?> </span></div> </div></a>
	<?php

	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}

// add_action("woocommerce_cart_calculate_fees", "tiffin_add_tip");

function tiffin_add_tip() {
	$subtotal = tiffin_cart_contents_total();

	if(WC()->session->get("tip_percentage") != "") {
		$fee_percentage = floatval(WC()->session->get("tip_percentage"));
	} else $fee_percentage = 15;

	$fee = ($subtotal * $fee_percentage) / 100;

	WC()->cart->add_fee("Tip", $fee);
}

add_action("woocommerce_cart_calculate_fees", "tiffin_add_custom_tip");

function tiffin_add_custom_tip() {
	$tip_val = WC()->session->get("tip_percentage");
	$tip_type = WC()->session->get("tip_type");
	$subtotal = tiffin_cart_contents_total();

	if($tip_type) {
		if($tip_type == "dollar") {
			$fee = floatval($tip_val);
		} else { // $tip_type == "percentage"
			$fee_percentage = floatval($tip_val);
			$fee = ($subtotal * $fee_percentage) / 100;
		}
	} else {
		$fee = ($subtotal * 10) / 100;
	}

	WC()->cart->add_fee("Tip", $fee);
}

add_action("woocommerce_review_order_after_shipping", "tiffon_add_tip_options");

function tiffon_add_tip_options() {
	$tiffin_tip_values = (isset(get_option("tiffin_store_options")["tiffin_tip_values"]))? get_option("tiffin_store_options")["tiffin_tip_values"] : "";
	if($tiffin_tip_values == "") return;
?>
<tr class="order__tip">
	<th>
		<div class="order__tip--wrapper">
			<span></span>
			<div class="order__tip--values">
				<?php
				$tip_values = explode(",", $tiffin_tip_values);

				$session_tip_set = false;
				if(WC()->session->get("tip_percentage") != "" || WC()->session->get("tip_percentage") == "0") {
					$session_tip_set = true;
				}
				// echo "<h2>[" . WC()->session->get("tip_percentage") . "]</h2>";

				foreach($tip_values as $value) {
					$selected = "";
					if(substr($value, -1) == "!") {
						$value = substr($value, 0, -1);

						if(!$session_tip_set) $selected = "selected";
					}

					if($session_tip_set && WC()->session->get("tip_percentage") == $value) $selected = "selected";

					echo "<span class='tip_to_click $selected' data-tipvalue='$value'>$value%</span>";
				}
				?>
			</div>
		</div>
	</th>
	<td class="order__customtip--wrapper">
		<div class="order__tip--wrapper">
			<span></span>
			<div class="order__tip--values order__customtip">
				<span><?php _e("Custom", "woocommerce") ?></span>
			</div>
		</div>
	</td>
</tr>
<?php
}

add_action("tiffin_header_menu_action", "tiffin_header_menu", 10);


function is_other_domain() {
	// return false;
	$domain = $_SERVER["HTTP_HOST"];

	// _d($domain, "DOMAIN: ");

	if((strpos($domain, "order.tiffin2go") === false) && (strpos($domain, "localhost") === false)) return true;

	return false;
}

function tiffin_header_menu() {
	if(is_other_domain()) return;
?>
<div id="tiffin__header">
	<div class="tiffin__wrapper--mini">
		<div class="tiffin__header--item tiffin__pickup_menu">
			<a href="#tiffin__deliverymap" class="map-open" id="tiffin__deliverymap--open">
				<div class="header--icon tiffin__pickup--icon">
					<span class="iconify" data-icon="uil-map-marker"></span>
				</div>

				<div class="tiffin__header--inneritem tiffin__pickup--address">
					<span><?php _e("Deliver to", "woocommerce") ?></span>
					<?php if (isset($_SESSION["selected_address"]) && !empty($_SESSION["selected_address"])): ?>
						<p><?php echo $_SESSION["selected_address"]["name"] ?></p>
					<?php endif ?>
				</div>
			</a>
		</div>

		<?php if (is_user_logged_in()): ?>
		<div class="tiffin__header--item tiffin__user_menu">
			<div class="header--icon tiffin__pickup--icon">
				<span class="iconify" data-icon="uil-user-circle"></span>
			</div>

			<div class="tiffin__header--inneritem tiffin__user--address">
				<span><?php _e("Welcome", "salient") ?></span>
				<?php
				$current_user = wp_get_current_user();
				$name = $current_user->user_firstname;
				?>
				<p><?php echo $name ?></p>

				<div class="tiffin__header--submenu">
					<?php
					wp_nav_menu([
						"menu" => "User Menu",
					]);
					?>
				</div>
			</div>
		</div>
		<?php endif ?>
	</div>
</div>
<?php
}

add_filter("wp_footer", "tiffin_delivery_map");

function tiffin_delivery_map() {
	if(is_other_domain()) return;
?>
<div class="tiffin__modal zoom-anim-dialog mfp-hide" id="tiffin__deliverymap">
	<div class="tiffin__deliverymap--wrapper">
		<section class="tiffin__deliverymap--data">
			<div class="tiffin__deliverymap--header">
				<div class="devmap__wrapper">
					<h2 class="active" data-type="deliver"><?php _e("Delivery", "woocommerce"); ?></h2>

					<h2 data-type="pickup"><?php _e("Pickup", "woocommerce"); ?></h2>
				</div>
			</div>

			<div class="tiffin__deliverymap--addresses">
				<h3><?php _e("Deliver to", "woocommerce") ?></h3>
				<?php
				if(is_user_logged_in()) {
					$option = "address_save";
					$option_name = "Save";
				} else {
					$option = "address_select";
					$option_name = "Select";
				}
				?>
				<form id="address_search--form" data-option="<?php echo $option ?>" >
					<input type="text" id="address_search" placeholder="Type your address" required>
					<input type="submit" value="<?php echo $option_name ?>"/>
				</form>

				<?php if (is_user_logged_in()): ?>
				<div class="tiffin__savedadd">
					<h3><?php _e("Delivery Addresses", "woocommerce") ?></h3>

					<?php if (false): ?>
					<?php $addresses = ["1", "2", "3"] ?>
					<ul>
						<?php foreach ($addresses as $address): ?>
						<li>
							<i>Bus icon</i>
							<div class="tiffin__address--data">
								<strong class="tiffin__address--slug"><?php echo "Work" ?></strong>
								<span class="tiffin__address--longname"><?php echo "123" ?></span>
							</div>

						</li>
						<?php endforeach ?>
					</ul>
					<?php endif ?>
				</div>
				<?php endif ?>
			</div>

			<div class="tiffin__deliverymap--pickup">
				<div class="">
					<p>You've chose pickup</p>

					<form id="pickup--form" method="POST">
						<input type="hidden" name="pickup_selected" value="true">
						<input type="submit" value="Save"/>
					</form>
				</div>
			</div>

		</section>
		<section class="tiffin__deliverymap--map">
			<div id="tiffin--deliverymap">
			</div>
		</section>
	</div>
	<?php if(is_user_logged_in()): ?>
	<div class="tiffin--outer" id="tiffin__saveaddress">
		<div class="tiffin__wrapper">
			<div class="tiffin__box--title">
				<span><?php _e("Name your new address", "salient") ?></span>
			</div>
			<form action="">
				<input type="text" id="address_slug" name="address_slug" required>

				<div class="btn btn--red btn--action">
					<a href="#">
						<span>Save</span>
					</a>
				</div>
			</form>
		</div>
	</div>
	<?php endif ?>
</div>
<?php
}

//GONZALO: CHANGE FROM SHIPPING TO DELIVERY

add_filter('woocommerce_shipping_package_name', 'change_shipping_text_to_delivery', 20, 3 );
function change_shipping_text_to_delivery( $sprintf, $i, $package ) {
    $sprintf = sprintf( _nx( 'Delivery', 'Delivery %d', ( $i + 1 ), 'delivery packages', 'woocommerce' ), ( $i + 1 ) );
    return $sprintf;
}

//retrieve addresses from user if logged ir, else store it in the session variable

add_action("wp_ajax_new_address", "new_address_function_not_logged");
add_action("wp_ajax_nopriv_new_address", "new_address_function_not_logged");

function new_address_function() {
	$data = $_GET["data"];

	if(is_user_logged_in() && false) {
	} else {
		if(isset($_SESSION["map"])) {
			$name = $data["name"];

			$_SESSION["map"][$name] = [
				"address" => $data["address"],
				"country" => $data["country"],
				"city" => $data["address"],
				"state" => "",
				"zipcode" => "",
			];

			$_SESSION["map"]["_selected"] = $name;
		}
	}

	echo "OK";
	wp_die();
}

function new_address_function_not_logged() {
	$data = $_GET["data"];

	// _d($data, "DATA: ");

	if(!isset($_SESSION["selected_address"])) $_SESSION["selected_address"] = [];

	$_SESSION["selected_address"] = [
		"name" => explode(",", $data["address"])[0],
		"address" => $data["address"],
		"country" => $data["country"],
		"state" => $data["state"],
		"city" => $data["city"],
		"zipcode" => $data["zipcode"],
	];

	// _d($_SESSION["selected_address"], "Selected address: ");
	echo "OK";
	wp_die();
}

add_filter("woocommerce_checkout_fields", "tiffin_checkout_fields", 1100);

function tiffin_checkout_fields($fields) {
	// _d($fields, "Fields: ");
	$eq = [
		"shipping_address_1" => "address",
		"shipping_country" => "country",
		"shipping_state" => "state",
		"shipping_city" => "city",
		"shipping_postcode" => "zipcode",
	];

	if (isset($_SESSION["selected_address"]) && !empty($_SESSION["selected_address"])) {
		// $_SESSION["selected_address"]["name"];
		foreach ($eq as $wc_field => $f) {
			if(isset($_SESSION["selected_address"][$f]) && !empty($_SESSION["selected_address"][$f])) {
				$fields["shipping"][$wc_field]["default"] = $_SESSION["selected_address"][$f];
			}
		}
	}

	return $fields;
}

function print_filters_for( $hook = '' ) {
	global $wp_filter;
	if( empty( $hook ) || !isset( $wp_filter[$hook] ) ) return;

	print '<pre>';
	print_r( $wp_filter[$hook] );
	print '</pre>';
}

function get_last_order_from_user() {
	$current_user = wp_get_current_user();

	$args = [
		"customer_id" => $current_user->ID,
		"limit" => 1,
	];

	$orders = wc_get_orders($args);
	$url = get_site_url();

	if(empty($orders)) return $url;

	$order = [
		"id" => $orders[0]->get_order_number(),
		"key" => $orders[0]->get_order_key(),
	];


	if(isset($_GET["key"]) && !empty($_GET["key"]) && $_GET["key"] == $order["key"]) {
		$url = $url . "/my-account/view-order/" . $order["id"];
	}

	return $url;
}

add_action("nectar_hook_after_body_open", "set_pickup_method");

function set_pickup_method() {
	if(isset($_POST) && isset($_POST["pickup_selected"])) {
		// _d("TRUE");
		$_SESSION["pickup_selected"] = true;

		WC()->session->set("chosen_shipping_methods", ["pickup"]);
	}
}

add_filter("woocommerce_shipping_chosen_method", "set_pickup_method_filter", 10, 3);

function set_pickup_method_filter($default, $package_rates, $chosen_method) {
	if($_SESSION["pickup_selected"]) {
		return "local_pickup:26";
	}
	return $default;
}
