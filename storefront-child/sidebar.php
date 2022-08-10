<?php
/**
 * The sidebar containing the main widget area.
 * Le contenu de la sidebar est configurable dans le backend via Apparence > Widgets
 *
 * @package storefront
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area mel-sidebar" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
