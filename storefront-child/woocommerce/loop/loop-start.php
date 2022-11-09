<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// On effectue la query pour récupérer l'ensemble des catégories
$product_categories = get_terms( 'product_cat', array( 'orderby' => 'name', 'order' => 'asc', 'hide_empty' => true ) );

// On affiche les catégories qui ne possèdent pas de catégorie parent
$currCategory = get_queried_object();
$currCategory_id = $currCategory->term_id;

$categories_content = '<ul class="mel-categories--list">';
if( !empty($product_categories) ){
	foreach ($product_categories as $key => $category) {
		if($category->parent == '0') {
			$categories_content .= '<li class="mel-category">';
			if($currCategory_id == $category->term_id) {
				$categories_content .= '<span class="mel-category--link mel-category--link-current">' . $category->name . '</span>';
			} else {
				$categories_content .= '<a class="mel-category--link" href="'.get_term_link($category).'" >' . $category->name . '</a>';
			}
			$categories_content .= '</li>';
		}
		
	}
	$categories_content .= '</ul>';
}
echo $categories_content;

?>

<ul class="products mel-category--products-list grid">
