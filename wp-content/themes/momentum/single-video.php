<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php get_header(); ?>

<div class="blog">

	<div class="row title">
		<h2><?php $content->title(); ?></h2>
		<hr>
	</div>

	<div class="row">
		<div class="eight col offset-by-two">

			<?php if ( ! post_password_required( $post->ID ) ) : ?>

				<?php $t->video->output( $post->ID ); ?>

			<?php else : ?>

				<?php echo get_the_password_form(); ?>

			<?php endif; ?>

		</div>
	</div>

</div>

<?php get_footer(); ?>