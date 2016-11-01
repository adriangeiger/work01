<?php $t =& peTheme(); ?>
<?php list($data,$items,$bid) = $t->template->data(); ?>
<?php $style = ''; ?>
<?php if ( ! empty( $data->bgcolor ) ) $style .= 'background-color: ' . $data->bgcolor . ';'; ?>
<?php if ( ! empty( $data->bgimage ) ) $style .= 'background-image: url(\'' . $data->bgimage . '\');'; ?>
<?php if ( ! empty( $style ) ) $style = 'style="' . $style . '"'; ?>

<section class="padding-top-<?php echo $data->padding_top; ?> padding-bottom-<?php echo $data->padding_bottom; ?> <?php if ( 'light' === $data->typography ) echo 'text-color-light'; ?> bg-image-cover section-type-services" id="section-<?php echo empty($data->name) ? $bid : $data->name; ?>" <?php echo $style; ?>>

	<?php if ( ! empty( $data->title ) ) : ?>

		<div class="row title">
			<h2><?php echo $data->title; ?></h2>
			<hr>
		</div>

	<?php endif; ?>

	<?php if ( ! empty( $data->content ) ) : ?>

		<div class="row section-content">
			<div class="eight col center text-center">
				<div class="section-content-wrap"><?php echo $data->content; ?></div>
			</div>
		</div>

	<?php endif; ?>

	<?php $content =& $t->content; ?>

	<?php if ( ! empty( $items ) ) : ?>

		<div class="row relative">
			<div class="owlcarousel services-slider">

				<?php foreach ( $items as $item ): ?>

					<div class="grid-ms">
						<div class="service-item">

							<?php if ( ! empty( $item->icon ) ) : ?>

								<i class="<?php echo $item->icon; ?>"></i>

							<?php endif; ?>

							<?php if ( ! empty( $item->title ) ) : ?>

								<h3 class="h7"><?php echo $item->title; ?></h3>

							<?php endif; ?>
							
							<!--

							<?php if ( ! empty( $item->subtitle ) ) : ?>

								<p class="subline"><?php echo $item->subtitle; ?></p>

							<?php endif; ?>

							<hr> -->

							<?php if ( ! empty( $item->features ) ) : ?>

								<ul>

									<?php foreach ( $item->features as $feature ): ?>

										<li><?php echo $feature['text']; ?></li>

									<?php endforeach; ?>

								</ul>

							<?php endif; ?>

							<?php if ( ! empty( $item->price ) ) : ?>

								<p class="serif mb0"><?php echo $item->price; ?></p>

							<?php endif; ?>

							<?php if ( ! empty( $item->link_text ) ) : ?>

								<?php $target = ( ! isset( $item->link_target ) ) ? 'yes' : $item->link_target; ?>
								<?php $target = ( 'yes' === $target ) ? 'target="_blank"' : 'target="_self"'; ?>

								<a class="arrow-link" href="<?php echo esc_url( $item->link_url ); ?>" <?php echo $target; ?>><?php echo $item->link_text; ?></a>

							<?php endif; ?>

						</div>
					</div>

				<?php endforeach; ?>

			</div>

			<a class="serv-prev oc-left"><i class="arrow-control fa fa-angle-left"></i></a>
			<a class="serv-next oc-right"><i class="arrow-control fa fa-angle-right"></i></a>

		</div>

	<?php endif; ?>

</section>