<?php $t =& peTheme();?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>

<?php if ( ! empty( $meta->splash->gallery ) ) : ?>

	<?php if ( $loop = $t->gallery->getSliderLoop( $meta->splash->gallery ) ) : ?>

		<?php if ( empty( $meta->splash->image_type ) || 'multiple' === $meta->splash->image_type ) : ?>

			<section id="<?php $content->slug(); ?>-splash" class="home splash">

				<ul class="home-bgc-slider">

					<?php while ($slide =& $loop->next()): ?>

						<li>
							<div class="header large bg-img" style="background-image: url( '<?php echo $slide->img; ?>' );">
								<div class="header-inner">

									<?php if ( ! empty( $slide->ititle ) ) : ?>
								
										<h2 class="bigtext text-white mb0"><?php echo $slide->ititle; ?></h2>

									<?php endif; ?>

									<?php if ( ! empty( $slide->caption ) ) : ?>

										<h6 class="serif bigtext text-white"><?php echo $slide->caption; ?></h6>

									<?php endif; ?>

									<?php if ( ! empty( $slide->button_1_text ) || ! empty( $slide->button_1_icon ) ) : ?>

										<?php $color = ( ! isset( $slide->button_1_color ) ) ? 'outline light' : $slide->button_1_color; ?>

										<a class="btn <?php echo $color; ?> grid-mt grid-ms" href="<?php echo $slide->button_1_url; ?>"><?php if ( ! empty( $slide->button_1_icon ) ) echo '<i class="' . $slide->button_1_icon . '"></i> ';?><?php echo $slide->button_1_text; ?></a>

									<?php endif; ?>

									<?php if ( ! empty( $slide->button_2_text ) || ! empty( $slide->button_2_icon ) ) : ?>

										<?php $color = ( ! isset( $slide->button_2_color ) ) ? 'outline light' : $slide->button_2_color; ?>

										<a class="btn <?php echo $color; ?> grid-mt grid-ms" href="<?php echo $slide->button_2_url; ?>"><?php if ( ! empty( $slide->button_2_icon ) ) echo '<i class="' . $slide->button_2_icon . '"></i> ';?><?php echo $slide->button_2_text; ?></a>

									<?php endif; ?>

								</div>
							</div>
						</li>

					<?php endwhile; ?>

				</ul>

			</section>

		<?php else : ?>

			<section id="<?php $content->slug(); ?>-splash" class="home splash">
				<div class="header large">

					<!-- Content -->
					<div class="header-inner">
						
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

					<ul class="home-bg-slider">

						<?php while ($slide =& $loop->next()): ?>

							<li><div class="header large bg-img" style="background-image: url( '<?php echo $slide->img; ?>' );"></div></li>

						<?php endwhile; ?>

					</ul>

				</div>
			</section>

		<?php endif; ?>

	<?php endif; ?>

<?php endif; ?>