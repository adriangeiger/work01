<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php list($data,$bid) = $t->template->data(); ?>
<?php $style = ''; ?>
<?php if ( ! empty( $data->bgcolor ) ) $style .= 'background-color: ' . $data->bgcolor . ';'; ?>
<?php if ( ! empty( $data->bgimage ) ) $style .= 'background-image: url(\'' . $data->bgimage . '\');'; ?>
<?php if ( ! empty( $style ) ) $style = 'style="' . $style . '"'; ?>

<section class="padding-top-<?php echo $data->padding_top; ?> padding-bottom-<?php echo $data->padding_bottom; ?> <?php if ( 'light' === $data->typography ) echo 'text-color-light'; ?> bg-image-cover section-type-recentwork uses-lightbox-<?php echo var_export( $use_lightbox, false ); ?>" id="section-<?php echo empty($data->name) ? $bid : $data->name; ?>" <?php echo $style; ?>>

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

	<?php if ( empty( $data->display ) || 'carousel' === $data->display ) : ?>

		<div class="row relative">
			<div class="owlcarousel work-slider">

				<?php while ( $content->looping() ) : ?>

					<?php $meta =& $content->meta(); ?>

					<?php $format = get_post_format(); ?>

					<?php switch( $format ) :

						case( false ) : ?>

							<?php $link = ( $use_lightbox ) ? wp_get_attachment_url( get_post_thumbnail_id() ) : get_permalink(); ?>

							<div class="grid-ms project-type-image">
								<div class="e-info">
									<h3><?php $content->title(); ?></h3>
									<p><?php $content->content(); ?></p>
								</div>
							</div>

						<?php break; ?>

						<?php case( 'gallery' ) : ?>

							<div class="grid-ms project-type-gallery">
								<div class="overlay-item <?php echo ( $use_lightbox ) ? 'popup-gallery' : ''; ?>">

									<?php if ( $use_lightbox ) : ?>

										<?php $loop = $t->gallery->getSliderLoop( $meta->gallery->id ); ?>

										<?php if ( $loop ): ?>

											<?php while ($item =& $loop->next()): ?>

												<a href="<?php echo $t->image->resizedImgUrl( $item->img, 9999, 9999 ); ?>"></a>

											<?php endwhile; ?>

										<?php endif; ?>

									<?php else : ?>

										<a href="<?php echo get_permalink(); ?>"></a>

									<?php endif; ?>

									<span class="o-hover">
										<span>
											<i class="fa fa-image fa-2x"></i>
										</span>
									</span>
									<?php $content->img( 380, 253 ); ?>
								</div>
								<div class="e-info">
									<h3><?php $content->title(); ?></h3>
									<p><?php 

									$terms = get_the_terms( get_the_id(), 'prj-category' );
									$output = '';

									if ( $terms && ! is_wp_error( $terms ) ) :

										foreach ( $terms as $term ) {
											$output .= $term->name . ' / ';
										}

										$output = substr( $output, 0, -3 );

										echo $output;

									endif;

									?></p>
								</div>
							</div>

						<?php break; ?>

						<?php case( 'video' ) : ?>

							<?php $videoID = $t->content->meta()->video->id; ?>
							<?php $video = $t->video->getInfo( $videoID );?>

							<?php $link = ( $use_lightbox ) ? $video->url : get_permalink(); ?>

							<div class="grid-ms project-type-video">
								<div class="overlay-item">
									<a <?php echo ( $use_lightbox ) ? 'class="popup-youtube"' : ''; ?> href="<?php echo $link; ?>">
										<span class="o-hover">
											<span>
												<i class="fa fa-film fa-2x"></i>
											</span>
										</span>
										<?php $content->img( 380, 253 ); ?>
									</a>
								</div>
								<div class="e-info">
									<h3><?php $content->title(); ?></h3>
									<p><?php 

									$terms = get_the_terms( get_the_id(), 'prj-category' );
									$output = '';

									if ( $terms && ! is_wp_error( $terms ) ) :

										foreach ( $terms as $term ) {
											$output .= $term->name . ' / ';
										}

										$output = substr( $output, 0, -3 );

										echo $output;

									endif;

									?></p>
								</div>
							</div>

						<?php break; ?>

					<?php endswitch; ?>


				<?php endwhile; ?>

			</div>

			<a class="work-prev oc-left"><i class="fa fa-angle-left"></i></a>
			<a class="work-next oc-right"><i class="fa fa-angle-right"></i></a>

		</div>

	<?php else : ?>

		<div class="row equal">

			<?php while ( $content->looping() ) : ?>

				<?php $meta =& $content->meta(); ?>

				<?php $format = get_post_format(); ?>

				<?php switch( $format ) :

					case( false ) : ?>

						<?php $link = ( $use_lightbox ) ? wp_get_attachment_url( get_post_thumbnail_id() ) : get_permalink(); ?>

						<div class="four col medium-six col x-small-twelve col grid-mb project-type-image">
							<div class="overlay-item">
								<a <?php echo ( $use_lightbox ) ? 'class="popup"' : ''; ?> href="<?php echo $link; ?>">
									<span class="o-hover">
										<span>
											<i class="fa fa-search fa-2x"></i>
										</span>
									</span>
									<?php $content->img( 380, 253 ); ?>
								</a>
							</div>
							<div class="e-info">
								<h3><?php $content->title(); ?></h3>
								<p><?php 

								$terms = get_the_terms( get_the_id(), 'prj-category' );
								$output = '';

								if ( $terms && ! is_wp_error( $terms ) ) :

									foreach ( $terms as $term ) {
										$output .= $term->name . ' / ';
									}

									$output = substr( $output, 0, -3 );

									echo $output;

								endif;

								?></p>
							</div>
						</div>

					<?php break; ?>

					<?php case( 'gallery' ) : ?>

						<div class="four col medium-six col x-small-twelve col grid-mb project-type-gallery">
							<div class="overlay-item <?php echo ( $use_lightbox ) ? 'popup-gallery' : ''; ?>">

								<?php if ( $use_lightbox ) : ?>

									<?php $loop = $t->gallery->getSliderLoop( $meta->gallery->id ); ?>

									<?php if ( $loop ): ?>

										<?php while ($item =& $loop->next()): ?>

											<a href="<?php echo $t->image->resizedImgUrl( $item->img, 9999, 9999 ); ?>"></a>

										<?php endwhile; ?>

									<?php endif; ?>

								<?php else : ?>

									<a href="<?php echo get_permalink(); ?>"></a>

								<?php endif; ?>

								<span class="o-hover">
									<span>
										<i class="fa fa-image fa-2x"></i>
									</span>
								</span>
								<?php $content->img( 380, 253 ); ?>
							</div>
							<div class="e-info">
								<h3><?php $content->title(); ?></h3>
								<p><?php 

								$terms = get_the_terms( get_the_id(), 'prj-category' );
								$output = '';

								if ( $terms && ! is_wp_error( $terms ) ) :

									foreach ( $terms as $term ) {
										$output .= $term->name . ' / ';
									}

									$output = substr( $output, 0, -3 );

									echo $output;

								endif;

								?></p>
							</div>
						</div>

					<?php break; ?>

					<?php case( 'video' ) : ?>

						<?php $videoID = $t->content->meta()->video->id; ?>
						<?php $video = $t->video->getInfo( $videoID );?>

						<?php $link = ( $use_lightbox ) ? $video->url : get_permalink(); ?>

						<div class="four col medium-six col x-small-twelve col grid-mb project-type-video">
							<div class="overlay-item">
								<a <?php echo ( $use_lightbox ) ? 'class="popup-youtube"' : ''; ?> href="<?php echo $link; ?>">
									<span class="o-hover">
										<span>
											<i class="fa fa-film fa-2x"></i>
										</span>
									</span>
									<?php $content->img( 380, 253 ); ?>
								</a>
							</div>
							<div class="e-info">
								<h3><?php $content->title(); ?></h3>
								<p><?php 

								$terms = get_the_terms( get_the_id(), 'prj-category' );
								$output = '';

								if ( $terms && ! is_wp_error( $terms ) ) :

									foreach ( $terms as $term ) {
										$output .= $term->name . ' / ';
									}

									$output = substr( $output, 0, -3 );

									echo $output;

								endif;

								?></p>
							</div>
						</div>

					<?php break; ?>

				<?php endswitch; ?>


			<?php endwhile; ?>

		</div>

	<?php endif; ?>

</section>