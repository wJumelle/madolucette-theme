<?php
/**
 * The template for displaying product search form
 *
 * Surcharge pour MeL
 * Effectuée par Wilfried JUMELLE
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form role="search" method="get" class="woocommerce-product-search mel-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>">Chercher un produit...</label>
	<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="Chercher un produit..." value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" value="Rechercher" class="<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ); ?>">Rechercher</button>
	<input type="hidden" name="post_type" value="product" />
</form>
