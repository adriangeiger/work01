<?php
/*
 * Template Name: Content Builder
 * Description: A Page Template which uses the drag and drop builder to compose content
 *
 * @package WordPress
 * @subpackage Theme
 * @since 1.0
 */
?>
<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php get_header(); ?>

<?php if ( ! empty( $meta->splash->type ) ) : ?>

	<?php if ( 'image' === $meta->splash->type ) : ?>

		<?php get_template_part( 'splash', 'image' ); ?>

	<?php elseif ( 'gallery' === $meta->splash->type ) : ?>

		<?php get_template_part( 'splash', 'gallery' ); ?>

	<?php endif; ?>

<?php endif; ?>

<div id="<?php $content->slug(); ?>" class="pagebuilder-content"><?php $content->builder(); ?></div>

<?php get_footer(); ?>