<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php get_header(); ?>

<div class="blog">

	<div class="row title">
		<h2><?php _e( 'Blog' ,'Pixelentity Theme/Plugin'); ?></h2>
		<hr>
	</div>

	<div class="row">
		<div class="eight col">

			<?php $t->content->loop(); ?>

		</div>
		<div class="four col">
			<?php get_sidebar(); ?>
		</div>
	</div>

</div>

<?php get_footer(); ?>