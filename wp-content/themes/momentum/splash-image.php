<?php $t =& peTheme();?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>
<?php $background = empty( $meta->splash->background ) ? '' : 'style="background-image: url(\'' . esc_attr( $meta->splash->background ) . '\');"'; ?>

<?php if ( empty( $meta->splash->image_type ) || 'multiple' === $meta->splash->image_type ) : ?>

	<section id="<?php $content->slug(); ?>-splash" class="home splash">
		<div class="header large bg-img fixed" <?php echo $background; ?>>

			<?php if ( ! empty( $meta->splash->headlines ) ) : ?>

				<ul class="home-c-slider">

					<?php foreach ( $meta->splash->headlines as $headline ) : ?>

						<li class="header large">
							<div class="header-inner">

								<?php if ( ! empty( $headline['title'] ) ) : ?>

									<h2 class="bigtext text-white mb0"><?php echo $headline['title']; ?></h2>

								<?php endif; ?>

								<?php if ( ! empty( $headline['description'] ) ) : ?>

									<h6 class="serif bigtext text-white"><?php echo $headline['description']; ?></h6>

								<?php endif; ?>

								<?php if ( ! empty( $headline['button_text'] ) || ! empty( $headline['button_icon'] ) ) : ?>

									<?php $color = ( ! isset( $headline['button_color'] ) ) ? 'outline light' : $headline['button_color']; ?>

									<a class="btn <?php echo $color; ?> grid-mt grid-ms" href="<?php echo $headline['button_url']; ?>"><?php if ( ! empty( $headline['button_icon'] ) ) echo '<i class="' . $headline['button_icon'] . '"></i> ';?><?php echo $headline['button_text']; ?></a>

								<?php endif; ?>

							</div>
						</li>

					<?php endforeach; ?>

				</ul>

			<?php endif; ?>

		</div>
	</section>

<?php else : ?>

	<section id="<?php $content->slug(); ?>-splash" class="home splash">
		<div class="header large bg-img fixed" <?php echo $background; ?>>
			<div class="header-inner">

				<?php if ( ! empty( $meta->splash->logo ) ) : ?>

					<p class="grid-m grid-mb"><img src="<?php echo $meta->splash->logo; ?>" alt="logo" class="responsive-img"></p>

				<?php endif; ?>

				<?php if ( ! empty( $meta->splash->title ) ) : ?>
					
					<h2 class="bigtext text-white mb0"><?php echo $meta->splash->title; ?></h2>

				<?php endif; ?>

				<?php if ( ! empty( $meta->splash->description ) ) : ?>

					<h6 class="serif bigtext text-white"><?php echo $meta->splash->description; ?></h6>

				<?php endif; ?>

				<?php if ( ! empty( $meta->splash->button_1_text ) || ! empty( $meta->splash->button_1_icon ) ) : ?>

					<?php $color = ( ! isset( $meta->splash->button_1_color ) ) ? 'outline light' : $meta->splash->button_1_color; ?>

					<a class="btn <?php echo $color; ?> grid-mt grid-ms" href="<?php echo $meta->splash->button_1_url; ?>"><?php if ( ! empty( $meta->splash->button_1_icon ) ) echo '<i class="' . $meta->splash->button_1_icon . '"></i> ';?><?php echo $meta->splash->button_1_text; ?></a>

				<?php endif; ?>

				<?php if ( ! empty( $meta->splash->button_2_text ) || ! empty( $meta->splash->button_2_icon ) ) : ?>

					<?php $color = ( ! isset( $meta->splash->button_2_color ) ) ? 'outline light' : $meta->splash->button_2_color; ?>

					<a class="btn <?php echo $color; ?> grid-mt grid-ms" href="<?php echo $meta->splash->button_2_url; ?>"><?php if ( ! empty( $meta->splash->button_2_icon ) ) echo '<i class="' . $meta->splash->button_2_icon . '"></i> ';?><?php echo $meta->splash->button_2_text; ?></a>

				<?php endif; ?>

			</div>
		</div>
	</section>

<?php endif; ?>