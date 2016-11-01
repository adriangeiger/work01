<?php

class PeThemeMomentumTemplate extends PeThemeTemplate  {

	public function __construct(&$master) {
		parent::__construct($master);
	}

	public function paginate_links($loop) {
		if (!$loop) return "";
		
		$classes = "row-fluid post-pagination";
		$all = "";

		if (apply_filters('pe_theme_pager_load_more',false)) {
			$classes .= ' pe-load-more';
			$all = empty($loop->main->all) ? false : $loop->main->all;
			$all = $all ? sprintf('data-all="%s"',esc_attr(json_encode($all))) : "";
		}
?>

	<div class="grid-mb">
		<div class="pagination">

			<a href="<?php echo ( empty( $loop->main->prev->link ) ) ? '#' : $loop->main->prev->link; ?>">&laquo;</a>

			<?php while ( $page =& $loop->next() ): ?>

				<?php if ( 'active' !== $page->class ) : ?>

					<a href="<?php echo $page->link; ?>"><?php echo $page->num; ?></a>

				<?php else : ?>

					<span class="current"><?php echo $page->num; ?></span>

				<?php endif; ?>

			<?php endwhile; ?>

			<a href="<?php echo ( empty( $loop->main->next->link ) ) ? '#' : $loop->main->next->link; ?>">&raquo;</a>

		</div>
	</div>

<?php
	}


}

?>