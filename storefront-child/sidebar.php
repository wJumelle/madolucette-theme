<?php
/**
 * The sidebar containing the main widget area.
 * Le contenu de la sidebar est configurable dans le backend via Apparence > Widgets
 * Le contenu de la sidebar a été conçu via le code du fichier /wp-content/plugins/yith-woocommerce-request-a-quote/templates/request-quote-view.php
 *
 * @package storefront
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

// On affiche une sidebar vide si aucun élément n'est présent dans le devis
?>



<div id="secondary" class="widget-area mel-sidebar" role="complementary">
	<?php 
		// On récupère les données du plugin YITH que l'on stocke dans une variable
		$raqSidebar = YITH_Request_Quote()->get_raq_return();
		//var_dump($raqSidebar);

		// Si le devis est vide, alors on affiche un message + potentiellement d'autre contenu ?
		// Sinon on affiche les éléments qui compose le devis
		if ( count( $raqSidebar ) === 0 ) { ?>
			<p><?php esc_html_e( 'No products in list', 'yith-woocommerce-request-a-quote' ); ?></p>
		<?php } else { 
			foreach ( $raqSidebar as $key => $raq ) {
				// On récupère toutes les informations autour du produit
				$product_id = ( isset( $raq['variation_id'] ) && '' !== $raq['variation_id'] ) ? $raq['variation_id'] : $raq['product_id'];
				$_product = wc_get_product( $product_id );
				if ( ! isset( $_product ) || ! is_object( $_product ) ) {
					continue;
				}

				// On récupère l'image du produit 
				$thumbnail = $_product->get_image();
				if ( ! $_product->is_visible() ) {
					echo $thumbnail; //phpcs:ignore
				} else {
					printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail ); //phpcs:ignore
				}

				// On récupère le nom du produit
				$product_title = $_product->get_title();
				if ( $_product->get_sku() !== '' && get_option( 'ywraq_show_sku' ) === 'yes' ) {
					$product_title .= ' ' . apply_filters( 'ywraq_sku_label', __( ' SKU:', 'yith-woocommerce-request-a-quote' ) ) . $_product->get_sku();
				}
				echo $product_title;

				// On récupère la quantité
				// Si jamais on veut que la sidebar puisse mettre à jour le devis
				// $product_quantity = woocommerce_quantity_input(
				// 	array(
				// 		'input_name'  => "raq[{$key}][qty]",
				// 		'input_value' => apply_filters( 'ywraq_quantity_input_value', $raq['quantity'] ),
				// 		'max_value'   => apply_filters( 'ywraq_quantity_max_value', $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(), $_product ),
				// 		'min_value'   => apply_filters( 'ywraq_quantity_min_value', 0, $_product ),
				// 		'step'        => apply_filters( 'ywraq_quantity_step_value', 1, $_product ),
				// 	),
				// 	$_product,
				// 	false
				// );
				//Sinon plus simplement on peut juste echo la quantité du produit
				$product_quantity = $raq['quantity'];

				echo $product_quantity;
			}
		}
	?>
</div><!-- #secondary -->
