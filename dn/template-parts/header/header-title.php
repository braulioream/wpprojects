<div class="header__background">
	<div class="img">
		<?php 

			$header_background = get_field('page_header_background');

			if(is_single()){
				$header_background = get_stylesheet_directory_uri() . "/assets/img/cdd.png";
			}

		?>
		<img src="<?php echo $header_background ?>" alt="page-header-background">
	</div>
	<div class="overlay">
		<div class="header__background--text">
			<div class="title">
				<h1><?php echo get_the_title() ?></h1>
			</div>
		</div>
	</div>
</div>