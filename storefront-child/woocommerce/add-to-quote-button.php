<?php
/**
 * Add to Quote button template
 *
 * @package YITH WooCommerce Request A Quote
 * @since   1.0.0
 * @version 1.5.3
 * @author  YITH
 *
 * @var integer $product_id
 * @var string $wpnonce
 * @var string $class
 */

?>

<a href="#" class="<?php echo esc_attr( $class ); ?>" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-wp_nonce="<?php echo esc_attr( $wpnonce ); ?>">
	<?php echo wp_kses_post( $label ); ?>
</a>
<span class="ajax-loading mel-loader" style="visibility:hidden" aria-label="en cours de chargement"></span>