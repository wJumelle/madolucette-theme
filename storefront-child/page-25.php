<?php
/**
 * The template for displaying thanksfull message after completing the form.
 *
 * @package storefront-child
 */

get_header('remerciements'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main mel-template-remerciements" role="main">

			<?php
			while ( have_posts() ) :
				the_post();

				do_action( 'storefront_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
