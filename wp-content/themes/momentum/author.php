<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $author = $wp_query->get_queried_object(); ?>
<?php $author = empty($author->user_nicename) ? '' : $author->user_nicename; ?>
<?php $t->layout->pageTitle = sprintf(__("Author: %s",'Pixelentity Theme/Plugin'),$author); ?>
<?php $meta =& $content->meta(); ?>
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