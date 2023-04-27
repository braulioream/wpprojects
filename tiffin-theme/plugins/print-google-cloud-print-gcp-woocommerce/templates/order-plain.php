<?php namespace Zprint;
/* @var $order \WC_Order */
/* @var $location_data */
?>
<?= Document::centerLine(get_appearance_setting('Check Header')); ?>
<?= Document::emptyLine(); ?>
<?= Document::symbolsAlign(__('Order Number', 'Print-Google-Cloud-Print-GCP-WooCommerce'), $order->get_id()); ?>
<?= Document::symbolsAlign(__('Date', 'Print-Google-Cloud-Print-GCP-WooCommerce'), date_i18n(\get_option('date_format', 'm/d/Y'), $order->get_date_created())); ?>
<?= Document::symbolsAlign(__('Time Ordered', 'Print-Google-Cloud-Print-GCP-WooCommerce'), date_i18n(\get_option('time_format', 'H:i'), $order->get_date_created())); ?>

<?php

$schedule = get_post_meta( $order->get_id(), "schedule", 1);

if(isset($schedule) && !empty($schedule) && $schedule != "no"): ?>
<?= Document::symbolsAlign( "Scheduled for: ", $schedule); ?>
<?php else: ?>
<?= Document::symbolsAlign( "Scheduled for: ", "Now"); ?>
<?php endif; ?>

<?= Document::symbolsAlign("Order Type", $order->get_shipping_method())?>

<?php if ($location_data['shipping']['delivery_pickup_type']) { ?>
		<?= Document::centerLine(get_shipping_details($order)); ?>
<?php } ?>
<?= Document::emptyLine(); ?>
<?php foreach ($order->get_items() as $item) {
	$tiffin_type = "none";

	if($item->meta_exists("tiffin_type")) {
		$tiffin_type = $item->get_meta("tiffin_type");
	}

	if($tiffin_type == "extra") continue;
	$desc = "";

	if($item->meta_exists("desc")) {
		$desc = $item->get_meta("desc");
	}

	$lines_desc = explode("|", $desc);

	/* @var $item \WC_Order_item */
	$meta = $item['item_meta'];
	$meta = array_filter($meta, function ($key) {
		return !in_array($key, array_merge(["Additional"], Order::getHiddenKeys()));
	}, ARRAY_FILTER_USE_KEY);
	?>
	
	<?= Document::symbolsAlign($item['name'], $item['qty']); ?>
	<?php foreach ($lines_desc as $line): ?>
		<?php if (!empty($line)): ?>
			<?= Document::line("- " . $line); ?>
		<?php endif ?>
	<?php endforeach ?>

	<?php if (false): ?>
	<?php $meta = array_map(function ($meta, $key) {
		return Document::symbolsAlign(' ' . $key, $meta . ' ');
	}, $meta, array_keys($meta));
	echo implode('', $meta);
	?>
	<?php endif ?>
<?php } ?>

<?php $tip = get_post_meta($order->get_id(), "order_tip", 1) ?>
<?php if (isset($tip) && !empty($tip)): ?>
	<?= Document::symbolsAlign("Tip", $tip); ?>
<?php endif ?>

<?php if (false): ?>
<?php foreach ($order->get_fees() as $fee) { ?>
		<?= Document::line($fee->get_name()); ?>
<?php } ?>
<?php endif ?>
<?= Document::emptyLine(); ?>
<?php if ($location_data['shipping']['billing_shipping_details']) { ?>
	<?= Document::centerLine(__('Customer Details', 'Print-Google-Cloud-Print-GCP-WooCommerce')); ?>
	<?= Document::emptyLine(); ?>
	<?= Document::centerLine(__('Billing address', 'Print-Google-Cloud-Print-GCP-WooCommerce')); ?>
	<?php if ($address = $order->get_formatted_billing_address()) {
		$address = explode('<br/>', $address);
		foreach ($address as $line) echo Document::line($line);
	} else {
		echo Document::line(__('N/A', 'Print-Google-Cloud-Print-GCP-WooCommerce'));
	} ?>
	<?php if ($order->get_billing_phone()) : ?>
		<?= Document::line(esc_html($order->get_billing_phone())); ?>
	<?php endif; ?>
	<?php if ($order->get_billing_email()) : ?>
		<?= Document::line(esc_html($order->get_billing_email())); ?>
	<?php endif; ?>
<?php } ?>
<?php if ($location_data['shipping']['method'] && $shipping_method = $order->get_shipping_method()) { ?>
	<?= Document::centerLine(__('Shipping method', 'Print-Google-Cloud-Print-GCP-WooCommerce')); ?>
	<?= Document::line($shipping_method); ?>
<?php } ?>
<?php if ($location_data['shipping']['billing_shipping_details'] && !wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ($shipping = $order->get_formatted_shipping_address())) : ?>
	<?= Document::centerLine(__('Shipping address', 'Print-Google-Cloud-Print-GCP-WooCommerce')); ?>
	<?php
	$shipping = explode('<br/>', $shipping);
	foreach ($shipping as $line) echo Document::line($line);
	Document::emptyLine();
	?>
<?php endif; ?>
<?php if (!empty($order->get_customer_note())): ?>
	<?= Document::centerLine(__('Order Notes', 'Print-Google-Cloud-Print-GCP-WooCommerce')); ?>
	<?= Document::line($order->get_customer_note()); ?>
<?php endif; ?>
