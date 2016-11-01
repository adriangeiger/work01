<?php $t =& peTheme(); ?>
<?php list($data,$items,$bid) = $t->template->data(); ?>
<?php $style = ''; ?>
<?php if ( ! empty( $data->bgcolor ) ) $style .= 'background-color: ' . $data->bgcolor . ';'; ?>
<?php if ( ! empty( $data->bgimage ) ) $style .= 'background-image: url(\'' . $data->bgimage . '\');'; ?>
<?php if ( ! empty( $style ) ) $style = 'style="' . $style . '"'; ?>

<section class="padding-top-<?php echo $data->padding_top; ?> padding-bottom-<?php echo $data->padding_bottom; ?> <?php if ( 'light' === $data->typography ) echo 'text-color-light'; ?> bg-image-cover section-type-intro" id="section-<?php echo empty($data->name) ? $bid : $data->name; ?>" <?php echo $style; ?>>

	<?php if ( ! empty( $data->title ) ) : ?>

		<div class="row title">
			<h2><?php echo $data->title; ?></h2>
			<hr>
		</div>

	<?php endif; ?>

	<?php if ( ! empty( $data->content ) ) : ?>

		<div class="row section-content">
			<div class="eight col center text-center">
				<div class="intro-section-content section-content-wrap"><?php echo $data->content; ?></div>
			</div>
		</div>

	<?php endif; ?>

	<?php if ( ! empty( $items ) ) : ?>

		<div class="row equal">

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
					$col = 'three medium-three small-six';
					break;

			endswitch;

			?>

			<?php foreach ( $items as $item ): ?>

				<div class="col <?php echo $col; ?>">
					<div class="icon-nav">

						<?php if ( ! empty( $item->link ) ) : ?>

							<a href="<?php echo $item->link; ?>">

						<?php endif; ?>

							<?php if ( ! empty( $item->icon ) ) : ?>

								<i class="<?php echo $item->icon; ?>"></i>

							<?php endif; ?>

							<?php if ( ! empty( $item->title ) ) : ?>

								<b><?php echo $item->title; ?></b>

							<?php endif; ?> </a>

							<?php if ( ! empty( $item->content ) ) : ?>

								<em><?php echo $item->content; ?></em>

							<?php endif; ?>

						<?php if ( ! empty( $item->link ) ) : ?>

							

						<?php endif; ?>

					</div>
				</div>

			<?php endforeach; ?>

		</div>

	<?php endif; ?>

</section>