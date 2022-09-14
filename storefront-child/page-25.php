<?php
/**
 * The template for displaying thanksfull message after completing the form.
 *
 * @package storefront-child
 */

get_header(''); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main mel-template-catalogue" role="main">

			<?php
			// On sécurise la suite du code
			if(!function_exists('wc_get_products')) {
				return;
			}

			// On récupère l'ensemble des produits publié
			// On désire afficher 8 produits / pages
			// avec paginate on obtient 1 objects avec 3 propriétés : products / total / max_num_pages
			// Doc : https://github.com/woocommerce/woocommerce/wiki/wc_get_products-and-WC_Product_Query#general
			$nb_limit = 8;
			$actual_page = 1;
			$args = array(
				'status' => 'publish',
				'limit' => '8',
				'paginate' => true,
			);
			$results = wc_get_products( $args );

			echo 'Actuellement je cherche comment récupérer les produits de la nième page (après la première)<br/>';

			echo $results->total . ' produits trouvés '. "<br/>";

			var_dump($results->products);

			for($j = 0; $j < $results->max_num_pages; $j++) {
				for($i = 0; $i < $nb_limit; $i++) {
					$index = ($j === 0) ? $i * $actual_page : ($j * $nb_limit);
					echo 'Index : ' . $index . '<br/>';
					$product_id   = $results->products[$index]->get_id();
					$product_name = $results->products[$index]->get_name();
	
					// Output product ID and name
					echo 'Product ID: ' . $product_id . ' is "' . $product_name . '"<br>';
				}
				
				echo '----<br/>';

				$actual_page++;
			}

			echo 'Page 1 sur ' . $results->max_num_pages . "<br/>";

			// foreach( $products as $product ) {

			// 	// Collect product variables
			// 	$product_id   = $product->get_id();
			// 	$product_name = $product->get_name();
			
			// 	// Output product ID and name
			// 	echo 'Product ID: ' . $product_id . ' is "' . $product_name . '"<br>';
			// }
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
