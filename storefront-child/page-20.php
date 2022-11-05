<?php
/**
 * The template for displaying thanksfull message after completing the form.
 *
 * @package storefront-child
 */

get_header(''); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main mel-template-catalogue" role="main">
			<header class="woocommerce-products-header mel-header--archive-product">
				<h1 class="woocommerce-products-header__title page-title"><?php wp_title('', true, ''); ?></h1>
			</header>

			<?php
				// On sécurise la suite du code
				if(!function_exists('wc_get_products')) {
					return;
				}

				// On récupère l'ensemble des produits publié
				// On désire afficher 8 produits / pages
				$nb_limit = 9;
				$actual_page = 1;
				$args = array(
					'status' => 'publish',
					'limit' => '-1',
				);
				$results = wc_get_products( $args );

				$nbProducts = count($results);
				$nbPages = ceil($nbProducts / $nb_limit);

				$content = '';
				$pagination = '<ul class="mel-catalogue--navigation">';

				for($j = 0; $j < $nbPages; $j++) {
					($j === 0) ? 
						$isCurrentClass = 'is-current' : 
						$isCurrentClass = 'is-not-current';
					$content .= '<ul class="products mel-category--products-list grid ' . $isCurrentClass . '" data-page="' . ($j + 1) . '">';
					$pagination .= '<li><button class="mel-catalogue--navigation-button ' . $isCurrentClass . '" data-targetedpage="' . ($j + 1) . '">' . ($j + 1) . '</button></li>';
					for($i = 0; $i < $nb_limit; $i++) {
						$index = ($j === 0) ? $i * $actual_page : ($j * $nb_limit + $i);
						if($index < $nbProducts) {
							$product_id = $results[$index]->get_id();
							$product_name = $results[$index]->get_name();
							$product_thumb = $results[$index]->get_image();
							$product_link = $results[$index]->get_permalink();
							$product_price = $results[$index]->get_price_html();
			
							$content .= '<li class="product"><a href="' . $product_link . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
							$content .= $product_thumb;
							$content .= '<div class="woocommerce-loop-product__text-container"><div class="woocommerce-loop-product__text-inner-container"><h2 class="woocommerce-loop-product__title">' . $product_name . '</h2>';
							$content .= '<span class="price">' . $product_price . '</span></div></div>';
							$content .= '</a></li>';
						}
					}
					$content .= '</ul>';
					if($j == ($nbPages - 1)) $pagination .= '</ul>';

					$actual_page++;
				}
				echo $content;
				echo $pagination;
			?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
