<?php


function _d($s, $t = "") {
	// return false;
	if($t != "") echo "<h2>${t}</h2>";
	echo "<pre style='color: blue; font-weight: bold'>";
	print_r($s);
	echo "</pre>";
}


function debug($array_to_debug = []){
	$file = get_stylesheet_directory() . '/custom_debug.txt';
	file_put_contents($file, "Debugging: " . print_r($array_to_debug, true) . "\n\n", FILE_APPEND);
}

function get_svg($name, $color = "null") {
    get_template_part("assets/svg/" . $name, "", ["color" => $color]);
}


function get_formatted_date($date){

	/* To do */
	return $date;
}