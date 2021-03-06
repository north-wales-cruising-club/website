
	<?php do_action('smartline_before_footer'); ?>

	<footer id="footer" class="clearfix" role="contentinfo">

		<?php // Display Footer Navigation
		if ( has_nav_menu( 'footer' ) ) : ?>

		<nav id="footernav" class="clearfix" role="navigation">
			<?php wp_nav_menu(	array(
				'theme_location' => 'footer',
				'container' => false,
				'menu_id' => 'footernav-menu',
				'fallback_cb' => '',
				'depth' => 1)
			);
			?>
			<h5 id="footernav-icon"><?php esc_html_e( 'Menu', 'smartline-lite' ); ?></h5>
		</nav>

		<?php else: ?>

		<div id="footernav">
		<p>NORTH WALES CRUISING CLUB Ltd</p>
		<p>Registered Office: Lower High St, Conwy LL32 8AL</p>
		<p>Company No: 03186074 (England & Wales)</p>
		</div>

		<?php endif; ?>

		<div id="footer-text">
			<span class="credit-link">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/RYA-Affiliated-55.png">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/RYA-Training-Centre-55.png">
      </span>

			<?php /* do_action('smartline_footer_text'); */ ?>

		</div>

	</footer>

</div><!-- end #wrapper -->

<?php wp_footer(); ?>
</body>
</html>