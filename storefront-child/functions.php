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
 * Surcharge des fonctions du header
 * Chemin des fonctions : /wordpress/wp-content/themes/storefront/inc/woocommerce/storefront-woocommerce-template-functions.php et 
 * /wordpress/wp-content/themes/storefront/inc/storefront-template-functions.php
 */
function storefront_product_search() {}
function storefront_header_cart() {}
function storefront_header_container() {
    echo '<div class="col-full flex flex-row flex-align-center flex-justify-spaceBetween">';
}
function storefront_header_container_close() {}
function storefront_primary_navigation_wrapper() {
    echo '<div class="storefront-primary-navigation">';
}
function storefront_primary_navigation_wrapper_close() {
    echo '</div>';
}
function storefront_primary_navigation() {
    ?>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'storefront' ); ?>">
		<button id="site-navigation-menu-toggle" class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_html( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?></span></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container_class' => 'primary-navigation',
				)
			);
			?>
		</nav><!-- #site-navigation -->
		<?php
}
// On ajoute le menu de contact
add_action('init', 'add_action_storefront_header');
function add_action_storefront_header() {
    add_action( 'storefront_header', 'mel_primary_navigation', 69);
}
if( ! function_exists( 'mel_primary_navigation' )) {
    /**
	 * Output the description tab content.
	 */
	function mel_primary_navigation() {
        ?>
        <div class='mel-secondary-navigation'>
            <nav aria-label='Navigation secondaire'>
                <ul>
                    <li><a href='tel:06-28-07-09-96' class='mel-secondary-navigation--tel' aria-label='Nous appeler'></a></li>
                    <li><a href='mailto:madeleineetlucette@gmail.com' class='mel-secondary-navigation--mail' aria-label='Nous écrire'></a></li>
                    <li><a target='_blank' href='https://www.instagram.com/madeleineetlucette/' class='mel-secondary-navigation--instagram' aria-label='Nous rejoindre sur Instagram'></a></li>
                    <li><a target='_blank' href='https://www.facebook.com/madeleineetlucette/' class='mel-secondary-navigation--facebook' aria-label='Nous rejoindre sur Facebook'></a></li>
                </ul>
            </nav>
        </div> <?php
	}
}



/**
 * Surcharge des fonctions de la homepage
 */
function storefront_homepage_header() {
    edit_post_link( __( 'Edit this section', 'storefront' ), '', '', '', 'button storefront-hero__button-edit' );
}
add_action( 'init', 'remove_actions_from_storefront_homepage');
function remove_actions_from_storefront_homepage() {
    // Retire les sections non voulues de la homepage
    remove_action( 'homepage', 'storefront_product_categories', 20 );
    remove_action( 'homepage', 'storefront_recent_products', 30 );
    remove_action( 'homepage', 'storefront_featured_products', 40 );
    remove_action( 'homepage', 'storefront_popular_products', 50 );
    remove_action( 'homepage', 'storefront_on_sale_products', 60 );
    remove_action( 'homepage', 'storefront_best_selling_products', 70 );
}



/**
 * Surcharge des fonctions Storefront
 */
function storefront_before_content() {
    ?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main mel-template-others" role="main">
		<?php
}



/**
 * Sidebar
 */
function storefront_get_sidebar() {
    get_sidebar('shop');
}



/**
 * Surcharge pour la page catégorie
 */
add_action( 'init', 'remove_actions_from_storefront_categories');
function remove_actions_from_storefront_categories() {
    // Retire le filtrage du haut + résultats
    remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper', 9 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
    remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper_close', 31 );
    // Retire le filtrage du bas + résultats
    remove_action( 'woocommerce_after_shop_loop','woocommerce_catalog_ordering', 10);
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
}



/**
 * Surcharge pour la page produit
 * woocommerce\templates\content-single-product.php
 */
add_action( 'init', 'remove_actions_from_storefront_product');
function remove_actions_from_storefront_product() {
    // Réorganisation pour l'affichage des données du produit
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_stock', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_product_description_tab', 20 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart_before', 29 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart_after', 39 );

    // Réorganisation pour l'affichage des données additionnels au produit
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    remove_action( 'woocommerce_after_single_product_summary', 'storefront_upsell_display', 15 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

    // Suppression de la navigation storefront entre les produits 
    remove_action( 'woocommerce_after_single_product_summary', 'storefront_single_product_pagination', 30 );
}
if( ! function_exists( 'woocommerce_product_description_tab' )) {
    /**
	 * Output the description tab content.
	 */
	function woocommerce_product_description_tab() {
        echo '<div class="mel-product--description">';
		wc_get_template( 'single-product/tabs/description.php' );
        echo '</div>';
	}
}
if ( ! function_exists( 'woocommerce_template_single_stock' ) ) {
    /**
     * Output the stock
     */
    function woocommerce_template_single_stock() {
        global $product;
        $htmlAvailability = wc_get_stock_html($product);
        echo '<div class="mel-product--availabilty">' . $htmlAvailability . '</div>';
    }
}
if ( ! function_exists( 'woocommerce_template_single_add_to_cart_before' ) ) {
    function woocommerce_template_single_add_to_cart_before() {
        echo '<div class="mel-product--quantity-container">';
    }
}
if ( ! function_exists( 'woocommerce_template_single_add_to_cart_after' ) ) {
    function woocommerce_template_single_add_to_cart_after() {
        echo '</div>';
    }
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