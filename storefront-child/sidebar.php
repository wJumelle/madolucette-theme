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
?>

<div id="secondary" class="widget-area mel-sidebar" role="complementary">
	<?php 
		// On récupère les données du plugin YITH que l'on stocke dans une variable
		$raqSidebar = YITH_Request_Quote()->get_raq_return();
		//var_dump($raqSidebar);

		$nbProduitsDevis = count($raqSidebar);

		// Si le devis est vide, alors on affiche un message + potentiellement d'autre contenu ?
		// Sinon on affiche les éléments qui compose le devis
		if ( $nbProduitsDevis === 0 ) { ?>
			<p><?php esc_html_e( 'No products in list', 'yith-woocommerce-request-a-quote' ); ?></p>
		<?php } else { 
			// On prépare la variable à afficher
			$content = "<h3 class='mel-devis--title'>Composition de votre devis</h3>";
			$content .= ($nbProduitsDevis > 1) ? "<ul class='mel-devis--products-list'>" : "";

			foreach ( $raqSidebar as $key => $raq ) {
				// On récupère toutes les informations autour du produit
				$product_id = ( isset( $raq['variation_id'] ) && '' !== $raq['variation_id'] ) ? $raq['variation_id'] : $raq['product_id'];
				$_product = wc_get_product( $product_id );
				if ( ! isset( $_product ) || ! is_object( $_product ) ) {
					continue;
				}

				// On encapsule dans une <li> ou une <div> en fonction du nombre de produits dans le devis
				$content .= ($nbProduitsDevis > 1) ? "<li data-productId=" . $product_id . " class='mel-devis--product'>" : "<div data-productId=" . $product_id . " class='mel-devis--product'>";

				// On récupère l'image et le nom du produit
				$thumbnail = $_product->get_image();
				$product_title = $_product->get_title();
				if ( $_product->get_sku() !== '' && get_option( 'ywraq_show_sku' ) === 'yes' ) {
					$product_title .= ' ' . apply_filters( 'ywraq_sku_label', __( ' SKU:', 'yith-woocommerce-request-a-quote' ) ) . $_product->get_sku();
				}
				$content .= "<a href=" . esc_url( $_product->get_permalink() ) . ">" . $thumbnail . "<p><span class='mel-devis--product-title'>" . wp_kses_post( $product_title ) . "</span></p></a>";
				
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
				$content .= "<span class='mel-devis--product-quantity'> Qté : " . $product_quantity . "</span>";

				$content .= ($nbProduitsDevis > 1) ? "</li>" : "</div>";
			}

			// On ferme l'élément liste
			$content .= ($nbProduitsDevis > 1) ? "</ul>" : "";

			// On affiche le contenu
			echo $content;
		}
	?>
</div><!-- #secondary -->
