<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */
/* add_action( 'wp_footer', 'meks_which_template_is_loaded' ); */
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);


/**
 * Surcharge de la fonction permettant d'afficher le panier 
 * dans le header du thème.
 * Chemin de la fonction : /wordpress/wp-content/themes/storefront/inc/woocommerce/storefront-woocommerce-template-functions.php
 */

/**
 * Display Header Cart
 *
 * @since  1.0.0
 * @uses  storefront_is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
function storefront_header_cart() {
    // Nothing to show here
}

/**
 * Surcharge de la fonction permettant d'afficher la sticky bar
 * Chemin de la fonction : /wordpress/wp-content/themes/storefront/inc/woocommerce/storefront-woocommerce-template-functions.php
 */

/**
 * Sticky Add to Cart
 *
 * @since 2.3.0
 */
function storefront_sticky_single_add_to_cart() {
    global $product;

    if ( class_exists( 'Storefront_Sticky_Add_to_Cart' ) || true !== get_theme_mod( 'storefront_sticky_add_to_cart' ) ) {
        return;
    }

    if ( ! $product || ! is_product() ) {
        return;
    }

    $show = false;

    if ( $product->is_purchasable() && $product->is_in_stock() ) {
        $show = true;
    } elseif ( $product->is_type( 'external' ) ) {
        $show = true;
    }

    if ( ! $show ) {
        return;
    }

    $params = apply_filters(
        'storefront_sticky_add_to_cart_params',
        array(
            'trigger_class' => 'entry-summary',
        )
    );

    wp_localize_script( 'storefront-sticky-add-to-cart', 'storefront_sticky_add_to_cart_params', $params );

    wp_enqueue_script( 'storefront-sticky-add-to-cart' );
    ?>
        <section class="storefront-sticky-add-to-cart">
            <div class="col-full">
                <div class="storefront-sticky-add-to-cart__content">
                    <?php echo wp_kses_post( woocommerce_get_product_thumbnail() ); ?>
                    <div class="storefront-sticky-add-to-cart__content-product-info">
                        <span class="storefront-sticky-add-to-cart__content-title"><?php esc_html_e( 'You\'re viewing:', 'storefront' ); ?> <strong><?php the_title(); ?></strong></span>
                        <span class="storefront-sticky-add-to-cart__content-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
                        <?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating() ) ); ?>
                    </div>
                </div>
            </div>
        </section><!-- .storefront-sticky-add-to-cart -->
    <?php
}