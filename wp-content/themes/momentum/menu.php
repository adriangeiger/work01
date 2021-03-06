<?php $t =& peTheme();?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>

<?php $template = is_page() ? $t->content->pageTemplate() : false; ?>

<?php $logo = $t->options->get( 'logo' ); ?>
<?php $site_title = $t->options->get( 'site_title' ); ?>

<?php if ( ! empty( $logo ) || ! empty( $site_title ) ) : ?>

	<div class="tb-logo">

		<?php if ( ! empty( $site_title ) ) : ?>

			<h1><a href="<?php echo home_url( '/' ); ?>"><?php echo $site_title; ?></a></h1>

		<?php endif; ?>

		<?php if ( ! empty( $logo ) ) : ?>

			<a href="<?php echo home_url( '/' ); ?>"><img src="<?php echo $logo; ?>" alt="logo"></a>

		<?php endif; ?>

	</div>

	<div class="tb-logo_small">

		<?php if ( ! empty( $logo ) ) : ?>

			<a href="<?php echo home_url( '/' ); ?>"><img src="<?php echo $logo; ?>" alt="logo"></a>

		<?php endif; ?>

	</div>

<?php endif; ?>

<div class="header-row">
	<div class="header-search"><?php get_search_form(); ?></div>
	<input type="checkbox" id="toggle" />
	<label for="toggle" class="toggle"></label>
	<nav class="menu">
		<?php $t->menu->show("main"); ?>
	</nav>
</div>
