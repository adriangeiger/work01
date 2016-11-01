<?php $t =& peTheme(); ?>
<?php list($data,$bid) = $t->template->data(); ?>
<?php $style = ''; ?>
<?php if ( ! empty( $data->bgcolor ) ) $style .= 'background-color: ' . $data->bgcolor . ';'; ?>
<?php if ( ! empty( $data->bgimage ) ) $style .= 'background-image: url(\'' . $data->bgimage . '\');'; ?>
<?php if ( ! empty( $style ) ) $style = 'style="' . $style . '"'; ?>

<section class="padding-top-<?php echo $data->padding_top; ?> padding-bottom-<?php echo $data->padding_bottom; ?> <?php if ( 'light' === $data->typography ) echo 'text-color-light'; ?> bg-image-cover bg-img fixed section-type-calltoaction" id="section-<?php echo empty($data->name) ? $bid : $data->name; ?>" <?php echo $style; ?>>

	<div class="row">
		<div class="twelve col text-center">

			<?php if ( ! empty( $data->text ) ) : ?>

				<div class="calltoaction-content"><?php echo $data->text; ?></div>

			<?php endif; ?>

			<?php if ( ! empty( $data->button_text ) || ! empty( $data->button_icon ) ) : ?>

				<?php $color = ( ! isset( $data->button_color ) ) ? 'outline light' : $data->button_color; ?>
				<?php $target = ( ! isset( $data->button_target ) ) ? 'yes' : $data->button_target; ?>
				<?php $target = ( 'yes' === $target ) ? 'target="_blank"' : 'target="_self"'; ?>

				<a class="btn <?php echo $color; ?>" href="<?php echo $data->button_url; ?>" <?php echo $target; ?>><?php if ( ! empty( $data->button_icon ) ) echo '<i class="' . $data->button_icon . '"></i> ';?><?php echo $data->button_text; ?></a>

			<?php endif; ?>

		</div>
	</div>

</section>