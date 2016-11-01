<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php $t->layout->pageTitle = sprintf(__("Tag: %s",'Pixelentity Theme/Plugin'),single_tag_title("",false)); ?>
<?php get_header(); ?>

<section class="blog">

	<div class="row title">
		<h2><?php echo $t->layout->pageTitle; ?></h2>
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

</section>

<?php get_footer(); ?>