<?php
	$color = "#fff";
	if(isset($args["color"]) && $args["color"] != "null") {
		$color = $args["color"];
	}
?>


<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path fill-rule="evenodd" clip-rule="evenodd" d="M3 14H0V5H3V14Z" fill="<?php echo $color ?>"/>
	<path fill-rule="evenodd" clip-rule="evenodd" d="M1.49108 3H1.47404C0.578773 3 0 2.33303 0 1.49948C0 0.648306 0.5964 0 1.50865 0C2.42091 0 2.98269 0.648306 3 1.49948C3 2.33303 2.42091 3 1.49108 3Z" fill="<?php echo $color ?>"/>
	<path fill-rule="evenodd" clip-rule="evenodd" d="M13.9999 13.9998H11.0519V9.29535C11.0519 8.11371 10.6253 7.30738 9.55814 7.30738C8.74368 7.30738 8.25855 7.85096 8.04549 8.37598C7.96754 8.56414 7.94841 8.8263 7.94841 9.08911V14H5C5 14 5.03886 6.03183 5 5.20672H7.94841V6.45221C8.33968 5.85348 9.04046 5 10.6057 5C12.5456 5 14 6.25705 14 8.95797L13.9999 13.9998Z" fill="<?php echo $color ?>"/>
</svg>