<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php 

if ( is_day() ) {
        $date = get_the_date();
} elseif ( is_month() ) {
        $date = get_the_date('F Y');
} elseif ( is_year() ) {
        $date = get_the_date('Y');
} else {
        $date = __("Archives",'Pixelentity Theme/Plugin');
}

?>
<?php $t->layout->pageTitle = $date; ?>
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