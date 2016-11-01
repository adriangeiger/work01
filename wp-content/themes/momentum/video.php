<?php $t =& peTheme(); ?>
<?php list( $video ) = $t->template->data(); ?>

<?php if ( ! empty( $video ) ): ?>

	<div class="vendor responsive-video">

		<?php switch( $video->type ): case "youtube": ?>

			<iframe width="720" height="405" src="//www.youtube.com/embed/<?php echo $video->id; ?>?autohide=1&modestbranding=1&showinfo=0" class="fullwidth-video" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
		
		<?php break; case "vimeo": ?>

			<iframe src="//player.vimeo.com/video/<?php echo $video->id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" class="fullwidth-video" width="720" height="405" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
		
		<?php endswitch; ?>

	</div>
		
<?php endif; ?>