<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main mel-template-error-page" role="main">

			<div class="error-404 not-found">

				<div class="page-content">
					<h1>Error 404</h1>
					<p>Page non trouvée</p>
					<div class="helper--disp-ib">
						<a href="/wp/" class="mel-link-button">Retour à l'accueil</a>
					</div>
				</div><!-- .page-content -->
			</div><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
