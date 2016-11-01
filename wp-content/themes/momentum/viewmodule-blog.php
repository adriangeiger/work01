<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php list($data,$bid) = $t->template->data(); ?>
<?php $style = ''; ?>
<?php if ( ! empty( $data->bgcolor ) ) $style .= 'background-color: ' . $data->bgcolor . ';'; ?>
<?php if ( ! empty( $data->bgimage ) ) $style .= 'background-image: url(\'' . $data->bgimage . '\');'; ?>
<?php if ( ! empty( $style ) ) $style = 'style="' . $style . '"'; ?>

<section class="padding-top-<?php echo $data->padding_top; ?> padding-bottom-<?php echo $data->padding_bottom; ?> bg-image-cover section-type-blog" id="section-<?php echo empty($data->name) ? $bid : $data->name; ?>" <?php echo $style; ?>>
	
	<?php if ( ! empty( $data->title ) ) : ?>

		<div class="row title">
			<h2><?php echo $data->title; ?></h2>
			<hr>
		</div>

	<?php endif; ?>

	<?php $t->template->data( $data ); ?>

	<div class="row">
		<div class="eight col">

			<?php $t->get_template_part("loop"); ?>

		</div>
		<div class="four col">
			<?php get_sidebar(); ?>
		</div>
	</div>

</section>