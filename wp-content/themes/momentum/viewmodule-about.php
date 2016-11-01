<?php $t =& peTheme(); ?>
<?php list($data,$items,$bid) = $t->template->data(); ?>
<?php $style = ''; ?>
<?php if ( ! empty( $data->bgcolor ) ) $style .= 'background-color: ' . $data->bgcolor . ';'; ?>
<?php if ( ! empty( $data->bgimage ) ) $style .= 'background-image: url(\'' . $data->bgimage . '\');'; ?>
<?php if ( ! empty( $style ) ) $style = 'style="' . $style . '"'; ?>

<section class="padding-top-<?php echo $data->padding_top; ?> padding-bottom-<?php echo $data->padding_bottom; ?> <?php if ( 'light' === $data->typography ) echo 'text-color-light'; ?> bg-image-cover section-type-about" id="section-<?php echo empty($data->name) ? $bid : $data->name; ?>" <?php echo $style; ?>>

	<?php if ( ! empty( $data->title ) ) : ?>

		<div class="row title">
			<h2><?php echo $data->title; ?></h2>
			<hr>
		</div>

	<?php endif; ?>

	<?php if ( ! empty( $data->content ) || ! empty( $data->subtitle ) || ! empty( $data->image ) ) : ?>

		<div class="row">
			<div class="twelve col text-left">

				<?php if ( ! empty( $data->image ) ) : ?>

					<img src="<?php echo $data->image; ?>" alt="header-about" class="responsive-img">

				<?php endif; ?>

				<?php if ( ! empty( $data->content ) || ! empty( $data->subtitle ) ) : ?>

					<?php $col1 = empty( $data->content ) ? 'eight col offset-by-two' : 'three col offset-by-two'; ?>
					<?php $col2 = empty( $data->subtitle ) ? 'eight col offset-by-two' : 'five col'; ?>

					<div class="bg-white bg-padding">
						<div class="row">

							<?php if ( ! empty( $data->subtitle ) ) : ?>

								<div class="<?php echo $col1; ?>">
									<h2><?php echo $data->subtitle; ?></h2>
								</div>

							<?php endif; ?>

							<?php if ( ! empty( $data->content ) ) : ?>

								<div class="<?php echo $col2; ?>"><?php echo $data->content; ?></div>

							<?php endif; ?>

						</div>
					</div>

				<?php endif; ?>

			</div>
		</div>

	<?php endif; ?>

	<?php if ( ! empty( $data->testimonials ) ) : ?>

		<div class="row">
			<div class="twelve col text-center qs-wrap">
				<div class="bg-white bg-padding">
					<div class="row">
						<div class="eight col offset-by-two">
							<ul class="quote-slider">

							<?php foreach ( $data->testimonials as $testimonial ) : ?>

								<li>

									<?php if ( ! empty( $testimonial['text'] ) ) : ?>

										<h6 class="h2"><?php echo $testimonial['text']; ?></h6>

									<?php endif; ?>

									<?php if ( ! empty( $testimonial['author'] ) ) : ?>

										<p><?php echo $testimonial['author']; ?></p>

									<?php endif; ?>

								</li>

							<?php endforeach; ?>

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php endif; ?>

	<?php if ( ! empty( $items ) ) : ?>

		<div class="row relative">
			<div class="owlcarousel employee-slider grid-mt">

				<?php foreach ( $items as $item ) : ?>

					<div class="grid-ms">
						<div class="overlay-item">
							<span class="o-hover">
								<span>

									<?php if ( ! empty( $item->links ) ) : ?>

										<?php foreach ( $item->links as $link ) : ?>

											<a href="<?php echo $link['url']; ?>" target="_blank"><i class="<?php echo $link['icon']; ?>"></i></a>

										<?php endforeach; ?>

									<?php endif; ?>

								</span>
							</span>
							<img src="<?php echo $item->image; ?>" alt="employee-image" class="responsive-img">
						</div>
						<div class="e-info">

							<?php if ( ! empty( $item->name ) ) : ?>

								<h3><?php echo $item->name; ?></h3>

							<?php endif; ?>

							<?php if ( ! empty( $item->role ) ) : ?>

								<p><?php echo $item->role; ?></p>

							<?php endif; ?>

						</div>
					</div>

				<?php endforeach; ?>

			</div>

			<a class="emp-prev oc-left"><i class="arrow-control fa fa-angle-left"></i></a>
			<a class="emp-next oc-right"><i class="arrow-control fa fa-angle-right"></i></a>

		</div>

	<?php endif; ?>

</section>