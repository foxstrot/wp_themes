<?php 

$no_sidebar = in_array( nvxmfc_get_layout(), array('full','center') );

$class = ( nvxmfc_get_theme_option('show_sidebar') ) ? 'block' : '';
$class = ( $no_sidebar && is_customize_preview() ) ? $class .' hide' : $class;

?>

<!-- BEGIN #sidebar -->
<aside id="sidebar" class="<?php echo esc_html($class); ?>">
	<ul id="widgetlist">

    <?php if ( is_active_sidebar( 'sidebar' ) ) :
        dynamic_sidebar( 'sidebar' );
    else : ?>

		<li class="widget widget_search">
			<?php get_search_form(); ?>
		</li>

		<?php wp_list_categories('use_desc_for_title=0&title_li=<p class="wtitle">'. __("Categories", 'nvxmfc') .'</p>');  ?>

	<?php endif; ?>

	</ul>
</aside>
<!-- END #sidebar -->

