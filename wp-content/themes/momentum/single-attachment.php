<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php get_header(); ?>

<div class="blog">

	<div class="row title">
		<h2><?php $content->title(); ?></h2>
		<hr>
	</div>

	<div class="row">
		<div class="eight col offset-by-two">

			<?php if ( wp_attachment_is_image( $post->id ) ) : ?>

				<?php $img = wp_get_attachment_image_src( $post->id, 'full' ); ?>
				<?php $content->img( 720, 0, $img[0] ); ?>

			<?php endif; ?>

		</div>
	</div>

</div>

<?php get_footer(); ?>