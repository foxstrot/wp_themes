<?php

/**
 *
 * @since  1.1.7
 *
 */
if ( ! function_exists( 'nvxmfc_the_more_link' ) ):
	function nvxmfc_the_more_link() {

		do_action( 'nvxmfc_before_more_link' );
		?>
		<p class="more-link-box">
			<a class="more-link" href="<?php the_permalink() ?>#more-<?php the_ID(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e( 'Read more', 'nvxmfc' ); ?></a>
		</p>
		<?php
		do_action( 'nvxmfc_after_more_link' );

	}
endif;
add_action( 'nvxmfc_after_post_excerpt', 'nvxmfc_the_more_link' );


/**
 *
 * @since  1.1.6
 *
 */
if ( ! function_exists( 'nvxmfc_the_custom_logo' ) ):
	function nvxmfc_the_custom_logo() {

		$logo_pos = get_theme_mod( 'display_logo_and_title' );

		if ( function_exists( 'the_custom_logo' ) ) {
			$logo = get_custom_logo();

			$logo = preg_replace( '%<a[^>]+>(.*?)<\/a>%i', '$1', $logo );
			$logo = str_replace( 'custom-logo', 'custom-logo custom-logo-' . $logo_pos, $logo );
			echo wp_kses($logo,'post');
		}

	}
endif;

/**
 * add actions for logo show
 *
 */
$logo_pos = get_theme_mod( 'display_logo_and_title' );

if ( 'image' == $logo_pos ) {
	add_action( 'nvxmfc_before_blogname_in_logo', 'nvxmfc_custom_logo_open_hideclass', 20 );
	add_action( 'nvxmfc_after_blogname_in_logo', 'nvxmfc_custom_logo_close_hideclass', 20 );
}
if ( 'bottom' == $logo_pos ) {
	add_action( 'nvxmfc_after_blogname_in_logo', 'nvxmfc_the_custom_logo' );
} else {
	add_action( 'nvxmfc_before_blogname_in_logo', 'nvxmfc_the_custom_logo' );
}

/**
 * hide sitetitle
 *
 */
function nvxmfc_custom_logo_open_hideclass() {
	ob_start();
}

function nvxmfc_custom_logo_close_hideclass() {
	ob_clean();
}


/**
 * echo post meta information
 *  filter `nvxmfc_post_meta_list` accept values:  'date', 'category', 'comments', 'author'
 *
 * @since  1.1.6
 */
if ( ! function_exists( 'nvxmfc_get_postmeta' ) ):
	function nvxmfc_get_postmeta() {

		$default_meta_list = get_theme_mod( 'postmeta_list', array( 'date', 'category', 'comments' ) );
		$default_meta_list = ! is_array( $default_meta_list ) ? explode( '_', $default_meta_list ) : $default_meta_list;

		$meta_list           = apply_filters( 'nvxmfc_post_meta_list', $default_meta_list );
		$displayed_meta_list = $meta_list;

		if ( is_customize_preview() ) {
			$all       = array_merge( $meta_list, array( 'date', 'category', 'comments', 'tags', 'author' ) );
			$meta_list = array_unique( $all );
		}

		if ( empty( $meta_list ) ) {
			return;
		}

		$meta_html = array();

		foreach ( $meta_list as $meta ) {
			$preview = ( ! in_array( $meta, $displayed_meta_list ) ) ? ' hide' : '';
			switch ( $meta ) {
				case 'date':
					$meta_html[ $meta ] = '<span class="date' . $preview . '">' . get_the_time( get_option( 'date_format' ) ) . '</span>';
					break;
				case 'author':
					$meta_html[ $meta ] = '<span class="author' . $preview . '">' . get_the_author() . '</span>';
					break;
				case 'category':
					$meta_html[ $meta ] = '<span class="category' . $preview . '">' . get_the_category_list( ', ' ) . '</span>';
					break;
				case 'comments':
					$meta_html[ $meta ] = '<span class="comments' . $preview . '"><a href="' . get_comments_link() . '">' . __( 'Comments', 'nvxmfc' ) . ': ' . get_comments_number() . '</a></span>';
					break;
				case 'tags':
					$meta_html[ $meta ] = '<span class="tags' . $preview . '">' . get_the_tag_list( __( 'Tags: ', 'nvxmfc' ), ', ' ) . '</span>';
					break;
			}
		}
		$meta_html = apply_filters( 'nvxmfc_post_meta_list_html', $meta_html );


		$html = '';
		foreach ( $meta_list as $meta ) {
			$html .= $meta_html[ $meta ];
		}

		$html = apply_filters( 'nvxmfc_post_meta_html', $html );

		echo '<aside class="meta">';
		do_action( 'nvxmfc_post_meta_before_first' );

		echo wp_kses($html,'post');

		do_action( 'nvxmfc_post_meta_after_last' );
		echo '</aside>';
	}
endif;
add_action( 'nvxmfc_after_post_title', 'nvxmfc_get_postmeta', 10 );