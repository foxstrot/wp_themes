<?php get_header(); ?>
	<main id="content">

<?php if (have_posts()) :

	$post = $posts[0];
	$not_paged = get_query_var('paged');
	$not_paged = ( empty($not_paged) ) ? true : false;

	?>
	
	<header class="inform">
	<h1><?php echo esc_html(the_archive_title()); ?> </h1>
	</header>

	<?php while (have_posts()) : the_post(); 

		get_template_part( 'content' ); 

	endwhile;

	the_posts_pagination( apply_filters( 'nvxmfc_archive_posts_pagination_args', array(
		'mid_size' => 2,
		'prev_text' => __( '&laquo; Prev', 'nvxmfc'),
		'next_text' => __( 'Next &raquo;', 'nvxmfc'),
	)) );


else: ?>
		
	<div class="post">
		<h1><?php esc_html_e( 'Posts not found', 'nvxmfc' ); ?></h1>
		<?php get_search_form(); ?>
	 </div>
		
<?php endif; ?>

	</main> <!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>