<?php $t =& peTheme(); ?>
<?php if ( $t->comments->supported() ): ?>

<!--comment section-->
<div class="row-fluid grid-mb" id="comments">
	<div class="span12 commentsWrap">
		<div class="inner-spacer-right-lrg">

			<div class="row-fluid comments-title-bg">
				<div class="span12">

					<h3 id="comments-title">
						<?php _e("Comments",'Pixelentity Theme/Plugin'); ?> <span>( <?php $t->content->comments(); ?> )</span>
					</h3>

				</div>
			</div>

			<?php $t->comments->show(); ?>
					
			<div class="row-fluid">
				<div class="span12">
					<?php $t->comments->pager(); ?>
				</div>
			</div>

			<div class="commentform-bg">
					
				<?php $t->comments->form(); ?>

			</div>

		</div>			
	</div>
</div>
<!--end comments-->

<?php endif; ?>