<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php /* do_action( 'storefront_before_footer' ); */ ?>

	<footer id="colophon" class="site-footer mel-footer" role="contentinfo">
		<div class="col-full grid">
			<div class="grid-4 mel-footer--social-media-links">
				<h3>SUIVRE NOS AVENTURES&nbsp;?</h3>
				<p>
					C’est sur instagram&nbsp;!<br/>
					On t’y attends avec impatience<br/>
					<a href="https://www.instagram.com/madeleineetlucette/" target="_blank" title="@madeleineetlucette (nouvelle fenêtre)">@madeleineetlucette</a>
				</p>
			</div>
			<div class="grid-4 mel-footer--more-about">
				<h3>+ d’informations&nbsp;?</h3>
				<ul>
					<li><a href="#">A faire - Les mentions légales</a></li>
					<li><a href="#">A faire - La politique de confidentialité</a></li>
				</ul>
			</div>
			<div class="grid-4 grid-empty" aria-hidden="true"></div>
			<div class="grid-4 mel-footer--contact-us">
				<h3>NOUS CONTACTER&nbsp;?</h3>
				<ul>
					<li><a href="mailto:madeleineetlucette@gmail.com">madeleineetlucette(at)gmail.com</a></li>
					<li><a href="tel:06-28-07-09-96">06 28 07 09 96</a></li>
				</ul>
			</div>
			<div class="grid-4 mel-footer--copyright">
				© 2022 Madeleine & Lucette - by the Jum’s
			</div>
		</div>
	</footer>

	<?php /* do_action( 'storefront_after_footer' ); */ ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
