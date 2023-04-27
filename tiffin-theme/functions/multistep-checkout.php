<?php


add_filter("arg-mc-init-options", "tiffin_arg_options_filter");

function tiffin_arg_options_filter($options) {
	$new_steps = [];

	// _d($options["steps"], "Steps: ");

	$icons = [
		"schedule" => "uil-clock-three",
 		// "coupon" => "uil-star",
		"billing" => "uil-usd-circle",
		"shipping" => "uil-truck",
		"order_payment" => "uil-atm-card",
		// "order_review" => "uil-file-check-alt",
	];

	// _d($options);

	$options["steps"]["schedule"] = [
		"text" => "Schedule",
		"class" => "argmc-schedule-step",
		"data" => "schedule-step",
	];

	foreach($icons as $step => $icon_name) {
		if(isset($options["steps"][$step]) && !empty($options["steps"][$step])) {
			$options["steps"][$step]["icon"] = $icon_name;
			$new_steps[$step] = $options["steps"][$step];
		}
	}

	$options["steps"] = $new_steps;

	// _d($options["steps"], "OPTIONS: ");

	return $options;
}


function argmc_schedule_step($step, &$i) {
?>
<div data-step="<?php echo $step["data"]; ?>" class="argmc-form-steps argmc-form-step-<?php echo $i; ?><?php echo $i == 1 ? " first current" : ""; ?> <?php echo !empty($step["class"]) ? " " . $step["class"] : "" ?>">
	<h3><?php echo $step["text"]; ?></h3>

	<div class="schedule__option">
		<h3 id="schedule-for-later">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="schedule-for-later-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" type="checkbox" name="schedule_for_later" value="0"/> <span><?php esc_html_e( "Schedule for another time?", "woocommerce" ); ?></span>
			</label>
		</h3>
	</div>

	<div class="schedule" style="display: none">
		<div class="form-row form-row-first">
			<label>Date</label>
			<span class="woocommerce-input-wrapper">
				<input type="text" placeholder="Choose the date" id="schedule_date">
			</span>
		</div>

		<div class="form-row form-row-last">
			<label>Time</label>
			<span class="woocommerce-input-wrapper">
				<input type="text" placeholder="Choose the time" id="schedule_time">
			</span>
		</div>
	</div>
</div>
<?php
}

add_filter("woocommerce_checkout_fields", "add_schedule");

function add_schedule($fields) {
	// _d($fields);

	$fields["shipping"]["schedule"] = [
		"type" => "text",
		"label" => "Scheduled?",
		"enabled" => "1",
		"required" => false,
		"validate" => [
			"required"
		],
	];

	return $fields;
}

add_action("woocommerce_checkout_update_order_meta", "save_schedule");

function save_schedule($order_id) {
	if(isset($_POST["schedule"]) && !empty($_POST["schedule"])) {
		$schedule = $_POST["schedule"];

		update_post_meta($order_id, "schedule", $schedule);
	}
}
