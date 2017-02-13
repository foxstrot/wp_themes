<?php get_header(); ?>
	<main id="content">
	<?php do_action( 'nvxmfc_main_content_inner_begin' ); ?>


<?php if (have_posts()) :
	while (have_posts()) : the_post(); 

		get_template_part( 'content' ); 

	endwhile; ?>

	<?php

	the_posts_pagination( apply_filters( 'nvxmfc_posts_pagination_args', array(
		'mid_size' => 2,
		'prev_text' => __( '&laquo; Prev', 'nvxmfc'),
		'next_text' => __( 'Next &raquo;', 'nvxmfc'),
	) ) );


else: ?>

	<div class="post clearfix">		
	    <h2><?php esc_html_e( 'Posts not found', 'nvxmfc' ); ?></h2>
	    <?php get_search_form(); ?>
	</div>
		
<?php endif; ?>

	<?php do_action( 'nvxmfc_main_content_inner_end' ); ?>
	</main> 
	<!-- END #content -->
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>