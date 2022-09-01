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

$melTotalSidebarQuote = 0;
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
			<h3 class='mel-devis--title'>Votre devis</h3>
			<p>Ho-ho il n’y a rien pour l’instant ☹</p>
		<?php } else { 
			// On prépare la variable à afficher
			$content = "<h3 class='mel-devis--title'>Votre devis</h3>";

			// On encapsule à l'intérieur d'un formulaire pour pouvoir update les produits
			$content .= "<form id='yith-ywraq-form' name='yith-ywraq-form' action='" . esc_url( YITH_Request_Quote()->get_raq_page_url( 'update' ) ) . " method='post'>";

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

				// ----------------- Affichage du produit --- début
				// On récupère l'image et le nom du produit
				$thumbnail = $_product->get_image();
				$product_title = $_product->get_title();
				if ( $_product->get_sku() !== '' && get_option( 'ywraq_show_sku' ) === 'yes' ) {
					$product_title .= ' ' . apply_filters( 'ywraq_sku_label', __( ' SKU:', 'yith-woocommerce-request-a-quote' ) ) . $_product->get_sku();
				}
				$content .= "<a href=" . esc_url( $_product->get_permalink() ) . ">" . $thumbnail . "</a><div><h4 class='mel-devis--product-title'><a href=" . esc_url( $_product->get_permalink() ) . ">" . wp_kses_post( $product_title ) . "</a></h4>";
				// ----------------- Affichage du produit --- fin
				
				// ----------------- Mise à jour du produit --- début
				// On affiche les éléments de mise à jour du produit dans le devis
				// On récupère la quantité
				$product_quantity = woocommerce_quantity_input(
					array(
						'input_name'  => "raq[{$key}][qty]",
						'input_value' => apply_filters( 'ywraq_quantity_input_value', $raq['quantity'] ),
						'max_value'   => apply_filters( 'ywraq_quantity_max_value', $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(), $_product ),
						'min_value'   => apply_filters( 'ywraq_quantity_min_value', 0, $_product ),
						'step'        => apply_filters( 'ywraq_quantity_step_value', 1, $_product ),
					),
					$_product,
					false
				);
				//Sinon plus simplement on peut juste echo la quantité du produit
				//$product_quantity = $raq['quantity'];
				$content .= "<div class='mel-devis--product-update'><span class='mel-devis--product-quantity'>" . $product_quantity . "</span>";
				// Bouton de suppression du produit du devis
				$content .= apply_filters( 'yith_ywraq_item_remove_link', sprintf( '<a href="#" data-buttonType="removeProductionFrom" data-remove-item="%s" data-wp_nonce="%s" data-product_id="%d" class="yith-ywraq-item-remove remove mel-devis--remove-product" title="%s">' . esc_attr__( 'Remove this item', 'yith-woocommerce-request-a-quote' ) . '</a>', esc_attr( $key ), esc_attr( wp_create_nonce( 'remove-request-quote-' . $product_id ) ), esc_attr( $product_id ), esc_attr__( 'Remove this item', 'yith-woocommerce-request-a-quote' ) ), $key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$content .= "</div>";
				// ----------------- Mise à jour du produit --- fin

				// ----------------- Calcul du total du panier --- début
				$melTotalSidebarQuote += $_product->get_price() * $raq['quantity'];
				// ----------------- Calcul du total du panier --- fin

				// On ferme la balise div qui encadre la partie droite du récap
				$content .= "</div>";

				$content .= ($nbProduitsDevis > 1) ? "</li>" : "</div>";
			}

			// On ferme l'élément liste
			$content .= ($nbProduitsDevis > 1) ? "</ul>" : "";

			// On affiche le prix total du devis
			$total = number_format($melTotalSidebarQuote, 2, ',', ' ') . " " . get_woocommerce_currency_symbol();
			$content .= "<p class='mel-devis--total'>Prix total : <span>" . $total . "</span></p>";

			// On affiche le bouton de mise à jour du devis
			$content .= "<div class='mel-devis--functions'>";
			$content .= "<button class='mel-devis--submit' name='update_raq'>Actualiser le devis</button>";
			//$content .= "<input type='submit' class='button mel-devis--submit' name='update_raq' value='" . esc_attr( get_option( 'ywraq_update_list_label', __( 'Update List', 'yith-woocommerce-request-a-quote' ) ) ) . "'><input type='hidden' id='update_raq_wpnonce' name='update_raq_wpnonce' value='" . esc_attr( wp_create_nonce( 'update-request-quote-quantity' ) ) . "'>";
			$content .= "<a href='https://gwendoline-jumelle.ovh/wp/devis/' class='mel-link-button'>Voir le devis</a>";
			$content .= "</div>";

			// On ferme le formulaire 
			$content .= "</form>";

			// On affiche le contenu
			echo $content;
		}
	?>
</div><!-- #secondary -->
