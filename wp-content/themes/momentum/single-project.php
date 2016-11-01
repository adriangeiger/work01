<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php get_header(); ?>

<?php while ($content->looping() ) : ?>

	<div class="blog is-project">

		<div class="row">
			<div class="eight col center">

				<div class="pe-container pe-block" >
					
					<div class="grid-mb">

						<div class="blog-post">

								<div class="post-media">

									<?php $format = get_post_format(); ?>

									<?php switch( $format ) :

										case( false ) : ?>

											<div class="project-image portfolio-single-image img-responsive">

												<?php $content->img( 800, 0 ); ?>

											</div>

										<?php break; ?>

										<?php case( 'gallery' ) : ?>

											<?php $t->media->w( 720 ); ?>
											<?php $t->media->h( 405 ); ?>
											<?php $t->gallery->output( $meta->gallery->id, 'GalleryImages' ); ?>

										<?php break; ?>

										<?php case( 'video' ) : ?>

											<div class="project-video">

												<?php $videoID = $t->content->meta()->video->id; ?>
												<?php if ( $video = $t->video->getInfo( $videoID ) ): ?>

													<div class="vendor responsive-video">
														<?php switch( $video->type ): case "youtube": ?>

															<iframe width="720" height="405" src="//www.youtube.com/embed/<?php echo $video->id; ?>?autohide=1&modestbranding=1&showinfo=0" class="fullwidth-video" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
														
														<?php break; case "vimeo": ?>

															<iframe src="//player.vimeo.com/video/<?php echo $video->id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" class="fullwidth-video" width="720" height="405" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
														
														<?php endswitch; ?>	
													</div>

												<?php endif; ?>

											</div>

										<?php break; ?>

									<?php endswitch; ?>

								</div>
								
							
							<div class="post-bg">

								<div class="post-title">

									<h1 class="h3 text-center"><?php $content->title(); ?></h1>

								</div>
								
								<div class="post-body pe-wp-default">
									<?php $content->content(); ?>
								</div>

							</div>
						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

<?php endwhile; ?>

<?php get_footer(); ?>