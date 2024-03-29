<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of #main and all content
 * after. Calls sidebar-footer.php for bottom widgets.
 *
 * @package QHFZBIO
 */

?>
		<?php MrGiraffe_absolute_bottom_hook(); ?>

		<aside id="colophon" <?php MrGiraffe_schema_microdata( 'sidebar' );?>>
			<div id="colophon-inside" <?php QHFZBIO_footer_colophon_class();?>>
				<?php get_sidebar( 'footer' );?>
			</div>
		</aside><!-- #colophon -->

	</div><!-- #main -->

	<footer id="footer" class="MrGiraffe" <?php MrGiraffe_schema_microdata( 'footer' );?>>
		<?php MrGiraffe_master_topfooter_hook(); ?>
		<div id="footer-top">
			<div class="footer-inside">
				<?php MrGiraffe_master_footer_hook(); ?>
			</div><!-- #footer-inside -->
		</div><!-- #footer-top -->
		<div id="footer-bottom">
			<div class="footer-inside">
				<?php MrGiraffe_master_footerbottom_hook(); ?>
			</div> <!-- #footer-inside -->
		</div><!-- #footer-bottom -->
	</footer>
</div><!-- site-wrapper -->
	<?php wp_footer(); ?>
</body>
</html>
