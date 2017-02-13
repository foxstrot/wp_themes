</div> 
<!-- #main -->

<?php do_action( 'nvxmfc_before_footer' ); ?>

<footer id="footer" class="<?php echo esc_html(apply_filters( 'nvxmfc_footer_class', '' ) );?>">

	<?php do_action( 'nvxmfc_before_footer_menu' ); ?>

	<?php if (has_nav_menu('bottom')) : ?>
	<div class="<?php echo esc_html(apply_filters( 'nvxmfc_footer_menu_class', 'footer-menu maxwidth' ) );?>">
		<?php 
		wp_nav_menu( array(
				'theme_location' => 'bottom',
				'menu_id' => 'footer-menu',
				'depth' => 1,
				'container' => false,
				'items_wrap' => '<ul class="footmenu clearfix">%3$s</ul>'
			)); 
		?>
	</div>
	<?php endif; ?>

	<?php do_action( 'nvxmfc_before_footer_copyrights' ); ?>

	<div class="<?php echo esc_html(apply_filters( 'nvxmfc_footer_copyrights_class', 'copyrights maxwidth grid' ) );?>">
		<div class="<?php echo esc_html(apply_filters( 'nvxmfc_footer_copytext_class', 'copytext col6' ) );?>">
			<p id="copy">
				<?php echo esc_html_e("Developed on the platform", 'nvxmfc') ?> <!--noindex--><a href="<?php echo esc_url("http://www.redoc.ru/"); ?>" rel="nofollow">Re:Doc</a><!--/noindex--> <?php echo esc_html('v2017.02.06') ?>
				<br/>
				<span class="copyright-text"><?php echo esc_html(nvxmfc_get_theme_option('copyright_text')); ?></span>
			</p>
		</div>

		<div class="<?php echo esc_html(apply_filters( 'nvxmfc_footer_themeby_class', 'themeby col6 tr' ) );?>">
		</div>
	</div>

	<?php do_action( 'nvxmfc_after_footer_copyrights' ); ?>

</footer>
<?php do_action( 'nvxmfc_after_footer' ); ?>


</div> 
<!-- .wrapper -->

<a id="toTop">&#10148;</a>

<?php wp_footer(); ?>

</body>
</html>