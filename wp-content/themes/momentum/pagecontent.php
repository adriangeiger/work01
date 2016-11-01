<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>

<section id="<?php $content->slug(); ?>" class="regularpage">
	<div class="row">
		<div class="twelve columns">

			<!-- The title -->
			<div class="title">
				<h1><?php $content->title(); ?></h1>
				<hr>
			</div>
			
			<div class="page-body pe-wp-default">
				<?php $content->content(); ?>
			</div>

		</div>
	</div>
</section>