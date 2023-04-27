<?php
/* Template Name: Template - Contacto*/
get_header(); ?>
<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
<div class="inicio__slide">
	<div class="banner__post" style="background-image: url('<?php echo $backgroundImg[0];  ?>');">
		<div class="banner__post__ctn wrapper__container">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
</div>

<div class="contact">
	<div class="contact__ctn wrapper__container">
		<div class="title__general__title">
			<h2><?php the_field('about_title'); ?></h2>
			<h3><?php the_field('about_subtitle'); ?></h3>
		</div>
		<div class="contact__form">
			<div class="contact__form__info">
				<div class="contact__form__item">
					<?php
					//$currentlang = pll_current_language();
					$currentlang = pll_current_language();
					if($currentlang=="en"): ?>
						<h3><?php _e('Phone','colorfull') ?>:</h3>
					<?php  elseif($currentlang=="es"): ?>
						<h3><?php _e('TELÉFONO','colorfull') ?>:</h3>
					<?php endif; ?>
					<div class="contact__form__parraf">
						<p><?php _e('Peru','colorfull') ?>: <?php the_field('telefono_espanol','options'); ?></p>
						<p><?php _e('UK','colorfull') ?>: <?php the_field('telefono_ingles','options'); ?></p>
					</div>
					
				</div>
				<div class="contact__form__item">
					<?php
					//$currentlang = pll_current_language();
					$currentlang = pll_current_language();
					if($currentlang=="en"): ?>
						<h3><?php _e('Email','colorfull') ?>:</h3>
					<?php  elseif($currentlang=="es"): ?>
						<h3><?php _e('Correo','colorfull') ?>:</h3>
					<?php endif; ?>
					<div class="contact__form__parraf">
						<p> <a href="mailto:<?php the_field('email_colorfull','options'); ?>;"><?php the_field('email_colorfull','options'); ?></a></p>
					</div>
					
				</div>

				<div class="contact__form__item ">
					<?php if( have_rows('list_social_media','options') ): ?>
						<?php
						//$currentlang = pll_current_language();
						$currentlang = pll_current_language();
						if($currentlang=="en"): ?>
							<h3><?php _e('Follow us','colorfull') ?>:</h3>
						<?php  elseif($currentlang=="es"): ?>
							<h3><?php _e('Síguenos','colorfull') ?>:</h3>
						<?php endif; ?>
						<div class="contact__form__parraf parraf__socials">
							<?php while( have_rows('list_social_media','options') ): the_row(); ?>
							<?php 
							$name_select_sub_field = (get_sub_field_object('tipo_social_media','options'));
							$name_sub_field = get_sub_field('tipo_social_media','options');
							$label_select = ($name_select_sub_field['choices'][$name_sub_field]);
							?>
							
								<?php if( get_sub_field('url_social_media', 'options') ) { ?>
								<p class="icon-<?php the_sub_field( 'tipo_social_media' ); ?>">
									<a href="<?php the_sub_field('url_social_media', 'options'); ?>" target="_blank"> <?php the_sub_field( 'tipo_social_media' ); ?> </a>
								</p>
							
							<?php } ?>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="contact__form__prin">
				<?php
				//$currentlang = pll_current_language();
				$currentlang = pll_current_language();
				if($currentlang=="en"): ?>
				<?php echo do_shortcode('[contact-form-7 id="8" title="Formulario de Contacto En"]');  ?>
				<?php  elseif($currentlang=="es"): ?>
				<?php echo do_shortcode('[contact-form-7 id="368" title="Formulario de Contacto Es"]');  ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>

