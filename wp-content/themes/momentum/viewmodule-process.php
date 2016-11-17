<?php $t =& peTheme(); ?>
<?php list($data, $items, $bid) = $t->template->data(); ?>
<?php $style = ''; ?>
<?php if (!empty($data->bgcolor)) $style .= 'background-color: ' . $data->bgcolor . ';'; ?>
<?php if (!empty($data->bgimage)) $style .= 'background-image: url(\'' . $data->bgimage . '\');'; ?>
<?php if (!empty($style)) $style = 'style="' . $style . '"'; ?>

<section
	class="padding-top-<?php echo $data->padding_top; ?> padding-bottom-<?php echo $data->padding_bottom; ?> <?php if ('light' === $data->typography) echo 'text-color-light'; ?> bg-image-cover section-type-process"
	id="section-<?php echo empty($data->name) ? $bid : $data->name; ?>" <?php echo $style; ?>>

	<?php if (!empty($data->title)) : ?>

		<div class="row title">
			<h2><?php echo $data->title; ?></h2>
			<hr>
		</div>

	<?php endif; ?>

	<?php if (!empty($data->content)) : ?>

		<div class="row section-content">
			<div class="eight col center text-center">
				<div class="section-content-wrap"><?php echo $data->content; ?></div>
			</div>
		</div>

	<?php endif; ?>

	<?php $content =& $t->content; ?>
	<?php if (!empty($items)) : ?>

		<div class="row equal">
			<div class="container">
				<!--<section class="block-of-text">
					<h2>Block of text</h2>
					<p>
						I'm a block of text!
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. At quia doloremque tempora placeat officia ex obcaecati tenetur deserunt repudiandae praesentium.</p>
				</section>-->
				<? if ($data->type == "insights"): ?>
					<? $cnt = 1 ?>
					<?php foreach ($items as $item): ?>

						<div class="item-container">
							<div class="circle">
								<div class="item-content">
									<div class="item-title"><?php echo $item->title; ?></div>
									<div class="item-description"><?php echo $item->description; ?></div>
								</div>
							</div>
						</div>
						<? $cnt++ ?>
					<?php endforeach; ?>
				<? elseif ($data->type == "about"): ?>
					<? $cnt = 1 ?>
					<?php foreach ($items as $item): ?>
						<div class="item-container">
							<!--<input id="about-<?/*= $cnt; */?>" type="checkbox">
                            <label for="about-<?/*= $cnt; */?>" class="switcher">-->
							<div class="square">
								<div class="item-content">
									<div class="item-title"><?php echo $item->title; ?> </div>
									<div class="item-description"><?php echo $item->description; ?></div>
								</div>
							</div>
							<!--</label>-->
						</div>
						<? $cnt++ ?>
					<?php endforeach; ?>
				<? endif; ?>

			</div>

		</div>

	<?php endif; ?>

</section>

<script>
	$('.item-container').click(function(evt){
		$(evt.currentTarget).toggleClass('more-info');
		console.log(evt)
	})
</script>