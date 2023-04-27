<div class="hmenu">
	<div class="hmenu-container">
		<div class="hl">
			<a href="<?php echo get_home_url() ?>">
				<img class="header-img header-img-classic" src="<?php echo get_stylesheet_directory_uri(), "/assets/img/hl.png" ?>" alt="dpub2.png">
				<img class="header-img header-img-sticky" src="<?php echo get_stylesheet_directory_uri(), "/assets/img/hl.png" ?>" alt="dpub2.png">
			</a>
		</div>

		<div class="menu-actions">
			<a class="button" href="<?php echo get_permalink( get_page_by_path( 'contact' ) ); ?>">
				Get in touch
			</a>
			<div class="menu-button" id="menu-button">
				<?php get_svg('menu-button', '#fff') ?>
			</div>
		</div>

		<div class="links">
			<?php
			wp_nav_menu([
				"menu" => "Menu",	
			]);
			?>
		</div>
	</div>

	<div class="hmenu-mobile">
		<?php
			wp_nav_menu([
				"menu" => "Menu",	
			]);
		?>
	</div>
</div>