<?php $t =& peTheme(); ?>
<?php list($data,$items,$bid) = $t->template->data(); ?>
<?php $style = ''; ?>
<?php if ( ! empty( $data->bgcolor ) ) $style .= 'background-color: ' . $data->bgcolor . ';'; ?>
<?php if ( ! empty( $data->bgimage ) ) $style .= 'background-image: url(\'' . $data->bgimage . '\');'; ?>
<?php if ( ! empty( $style ) ) $style = 'style="' . $style . '"'; ?>

<section class="padding-top-<?php echo $data->padding_top; ?> padding-bottom-<?php echo $data->padding_bottom; ?> <?php if ( 'light' === $data->typography ) echo 'text-color-light'; ?> bg-image-cover section-type-process" id="section-<?php echo empty($data->name) ? $bid : $data->name; ?>" <?php echo $style; ?>>

	<?php if ( ! empty( $data->title ) ) : ?>

		<div class="row title">
			<h2><?php echo $data->title; ?></h2>
			<hr>
		</div>

	<?php endif; ?>

	<?php if ( ! empty( $data->content ) ) : ?>

		<div class="row section-content">
			<div class="eight col center text-center">
				<div class="section-content-wrap"><?php echo $data->content; ?></div>
			</div>
		</div>

	<?php endif; ?>

	<?php $content =& $t->content; ?>

	<?php if ( ! empty( $items ) ) : ?>

		<div class="row equal">

			<?php foreach ( $items as $item ): ?>

				<?php

				$count = count( $items );

				switch ( $count ) :

					case ( 1 ) :
						$col = 'three small-six center';
						break;

					case ( 2 ) :
						$col = 'six';
						break;

					case ( 3 ) :
						$col = 'four';
						break;

					default :
						$col = 'three medium-six small-twelve';
						break;

				endswitch;

				?>

				<div class="col <?php echo $col; ?>">
					<div class="icon-circle">

						<?php if ( ! empty( $item->icon ) ) : ?>

							<i class="<?php echo $item->icon; ?>"></i>

						<?php endif; ?>

						<?php if ( ! empty( $item->title ) ) : ?>

							<h3 class="h5"><?php echo $item->title; ?></h3>

						<?php endif; ?>

						<?php if ( ! empty( $item->description ) ) : ?>

							<p><?php echo $item->description; ?></p>

						<?php endif; ?>

					</div>
				</div>

			<?php endforeach; ?>

		</div>

	<?php endif; ?>

</section>