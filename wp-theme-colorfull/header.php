<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="author" content="<?php bloginfo('name'); ?>">
	<meta name="robots" content="all, index, follow">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" >
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/main.css"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php the_post_thumbnail('full', array('class' => 'no_display')); ?>
<header class="header__wrap">
	
	<div class="header__top">
		<div class="header__top__container wrapper__container">
			<div class="header__top__left">

			<?php if (have_rows("telefonos", "options")): $cont = 0; ?>
				<?php while (have_rows("telefonos", "options")): the_row(); ++$cont;?>
					<article>
						<span>
							<?php
								if ($cont == 1):
									_e("Call Us: ", "colorfull");
								endif;
								the_sub_field("telefono_pais");
								// echo " - ";
							?>
						</span>
						<a href="tel:<?php the_sub_field("telefono_numero"); ?>"><?php the_sub_field("telefono_numero"); ?></a>
					</article>
				<?php endwhile ?>
			<?php endif ?>
				
			</div>
			<div class="header__top__right">
				<div class="header__top__currency">
					<span><?php _e('Currency: ','colorfull'); ?></span>

					<?php $price_pre = get_price_pre(); ?>
					<ul>
						<li <?php echo strpos($price_pre, "USD") === 0? "class='active'" : "" ?>>
							<a href=""><?php _e('USD ','colorfull'); ?></a>
						</li>
						<li <?php echo strpos($price_pre, "EUR") === 0? "class='active'" : "" ?>>
							<a href=""><?php _e('EUR ','colorfull'); ?></a>
						</li>
						<li <?php echo strpos($price_pre, "GBP") === 0? "class='active'" : "" ?>>
							<a href=""><?php _e('GBP ','colorfull'); ?></a>
						</li>
					</ul>
				</div>
				<div class="header__menu__languages__list">
					<span><?php _e('Language: ','colorfull'); ?></span>
					<?php if ( is_active_sidebar( 'language' ) ) : ?>
						<?php dynamic_sidebar( 'language' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="header__fixed">
		<div class="header__main">
			<div class="header__main__container wrapper__container">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo">
					<img src="<?php the_field('logo_header','options') ?>" alt="">
				</a>
				<nav class="header__main__nav">
					<?php wp_nav_menu(array(
						'theme_location' => 'header',
						'menu_class' => 'header__list',
						'container' => '',
						'container_class' => '',
					)); ?>
				</nav>
			</div>
		</div>
		<div class="borde-colourful"></div>
	</div>
	
</header>

<header class="header__sidebar">
	<span class="header__sidebar__close icon-close"></span>
	<div class="header__sidebar__top">
		<div class="header__sidebar__top__currency">
			<span><?php _e('Currency: ','colorfull'); ?></span>
			<?php $price_pre = get_price_pre(); ?>
			<ul>
				<li <?php echo strpos($price_pre, "USD") === 0? "class='active'" : "" ?>>
					<a href=""><?php _e('USD ','colorfull'); ?></a>
				</li>
				<li <?php echo strpos($price_pre, "EUR") === 0? "class='active'" : "" ?>>
					<a href=""><?php _e('EUR ','colorfull'); ?></a>
				</li>
				<li <?php echo strpos($price_pre, "GBP") === 0? "class='active'" : "" ?>>
					<a href=""><?php _e('GBP ','colorfull'); ?></a>
				</li>
			</ul>
		</div>
		<div class="header__sidebar__top__languages__list">
			<span><?php _e('Language: ','colorfull'); ?></span>
			<?php if ( is_active_sidebar( 'language' ) ) : ?>
				<?php dynamic_sidebar( 'language' ); ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="header__sidebar__bottom">
		<nav class="header__sidebar__nav">
			
		</nav>
		<div class="header__sidebar__tel">
			<ul>
				<?php if (get_field('telefono_espanol','options')): ?>
					<li>
						<a href="tel:<?php the_field('telefono_espanol','options') ?>">
							<span class=""></span>
							<h3>Peru</h3>
						</a>
					</li>
				<?php endif ?>
				<?php if (get_field('telefono_ingles','options')): ?>
				<li>
					<a href="tel:<?php the_field('telefono_ingles','options') ?>">
						<span class=""></span>
						<h3>UK</h3>
					</a>
				</li>
				<?php endif ?>
			</ul>
		</div>
	</div>
</header>

<div class="header__sidebar__menu"></div>


