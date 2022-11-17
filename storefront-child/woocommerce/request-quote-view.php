<?php
/**
 * Table view to Request A Quote
 *
 * @package YITH WooCommerce Request A Quote
 * @since   1.0.0
 * @version 1.5.3
 * @author  YITH
 *
 * @var $raq_content array
 */

$product_column_colspan = apply_filters( 'ywraq_item_thumbnail', ! wp_is_mobile() ) ? 2 : 1;
$hide_price             = 'yes' === get_option( 'ywraq_hide_price', 'no' );
$melTotalQuote = 0;

if ( isset( $_REQUEST['sent'] ) ) {
	echo "<script>document.location.href='/votre-devis-a-bien-ete-envoye/';</script>";
	exit();
}

if ( count( $raq_content ) === 0 ) :
	?>
	<p><?php esc_html_e( 'No products in list', 'yith-woocommerce-request-a-quote' ); ?></p>
<?php else : ?>
	<form id="yith-ywraq-form" name="yith-ywraq-form"
		action="<?php echo esc_url( YITH_Request_Quote()->get_raq_page_url( 'update' ) ); ?>" method="post">
		<table class="shop_table cart shop_table_responsive" id="yith-ywrq-table-list" cellspacing="0">
			<thead>
			<tr>
				<th class="product-name"><?php esc_html_e( 'Product', 'yith-woocommerce-request-a-quote' ); ?></th>
				<th class="product-quantity">Ajouter / Supprimer</th>
				<?php if ( ! $hide_price ) : ?>
					<th class="product-subtotal">Total (TTC)</th>
				<?php endif; ?>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ( $raq_content as $key => $raq ) :
				$product_id = ( isset( $raq['variation_id'] ) && '' !== $raq['variation_id'] ) ? $raq['variation_id'] : $raq['product_id'];
				$_product   = wc_get_product( $product_id );
				if ( ! isset( $_product ) || ! is_object( $_product ) ) {
					continue;
				}
				?>
				<tr class="cart_item">

					<td class="product-thumbnail product-name" data-title="Product">
						<?php
						$thumbnail = $_product->get_image();

						if ( ! $_product->is_visible() ) {
							echo $thumbnail; //phpcs:ignore
						} else {
							printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail ); //phpcs:ignore
						}
						?>

						<?php
						$product_title = $_product->get_title();
						if ( $_product->get_sku() !== '' && get_option( 'ywraq_show_sku' ) === 'yes' ) {
							$product_title .= ' ' . apply_filters( 'ywraq_sku_label', __( ' SKU:', 'yith-woocommerce-request-a-quote' ) ) . $_product->get_sku();
						}
						?>
						<a href="<?php echo esc_url( $_product->get_permalink() ); ?>"><?php echo wp_kses_post( $product_title ); ?></a>
						<?php
						// Meta data.

						$item_data = array();

						// Variation data.

						if ( ! empty( $raq['variation_id'] ) && is_array( $raq['variations'] ) ) {

							foreach ( $raq['variations'] as $name => $value ) {
								$label = '';

								if ( '' === $value ) {
									continue;
								}

								$attr_taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

								// If this is a term slug, get the term's nice name.
								if ( taxonomy_exists( $attr_taxonomy ) ) {
									$attr_term = get_term_by( 'slug', $value, $attr_taxonomy );
									if ( ! is_wp_error( $attr_term ) && $attr_term && $attr_term->name ) {
										$value = $attr_term->name;
									}
									$label = wc_attribute_label( $attr_taxonomy );

								} else {

									if ( strpos( $name, 'attribute_' ) !== false ) {
										$custom_att = str_replace( 'attribute_', '', $name );

										if ( '' !== $custom_att ) {
											$label = wc_attribute_label( $custom_att );
										} else {
											$label = $name;
										}
									}
								}

								$item_data[] = array(
									'key'   => $label,
									'value' => $value,
								);
							}
						}

						$item_data = apply_filters( 'ywraq_request_quote_view_item_data', $item_data, $raq, $_product );


						// Output flat or in list format.
						if ( count( $item_data ) > 0 ) {
							foreach ( $item_data as $data ) {
								echo esc_html( $data['key'] ) . ': ' . wp_kses_post( $data['value'] ) . "\n";
							}
						}


						?>
					</td>

					<td class="product-quantity" data-title="Quantity">
						<div class="mel-devis-page--quantity-container">
							<?php
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

							echo $product_quantity; //phpcs:ignore
							?>

							<?php
							echo apply_filters( 'yith_ywraq_item_remove_link', sprintf( '<a href="#"  data-remove-item="%s" data-wp_nonce="%s"  data-product_id="%d" class="yith-ywraq-item-remove remove" title="%s">&times;</a>', esc_attr( $key ), esc_attr( wp_create_nonce( 'remove-request-quote-' . $product_id ) ), esc_attr( $product_id ), esc_attr__( 'Remove this item', 'yith-woocommerce-request-a-quote' ) ), $key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>
					</td>
					
					<?php if ( ! $hide_price && WC()->cart ) : ?>
					<td class="product-subtotal">
						<?php
						$melTotalQuote += $_product->get_price() * $raq['quantity'];
						echo wp_kses_post( apply_filters( 'yith_ywraq_hide_price_template', wp_kses_post( WC()->cart->get_product_subtotal( $_product, $raq['quantity'] ) ), $product_id ) );
						?>
					</td>
					<?php endif; ?>
				</tr>

			<?php endforeach ?>
			</tbody>
		</table>
		<?php
			if ( get_option( 'ywraq_show_update_list' ) === 'yes' ) : ?>
			<div class="mel-devis-page--actions">
				<p>Prix total TTC : <span><?php echo number_format($melTotalQuote, 2, ',', ' ') . " " . get_woocommerce_currency_symbol(); ?></span></p>
				<button class="mel-devis--submit" name="update_raq">Actualiser le devis</button>
				<!-- <input type="submit" class="button" name="update_raq"
					value="<?php /*echo esc_attr( get_option( 'ywraq_update_list_label', __( 'Update List', 'yith-woocommerce-request-a-quote' ) ) ); */ ?>"> -->
				<input type="hidden" id="update_raq_wpnonce" name="update_raq_wpnonce"
					value="<?php echo esc_attr( wp_create_nonce( 'update-request-quote-quantity' ) ); ?>">
			</div>
		<?php endif ?>
	</form>
<?php endif ?>
