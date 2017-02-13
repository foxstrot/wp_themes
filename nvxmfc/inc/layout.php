<?php


/* set custom body classes
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_set_body_class' ) ) :
	function nvxmfc_set_body_class( $classes ) {

		// page layout
		$classes[] = 'layout-' . nvxmfc_get_layout();

		return $classes;
	}
endif;
add_filter( 'body_class', 'nvxmfc_set_body_class' );
/* ========================================================================== */


/* set page layout
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_get_layout' ) ) :
	function nvxmfc_get_layout() {
		global $post;

		$layout = 'rightbar';

		$layout_def  = nvxmfc_get_theme_option( 'layout_default' );
		$layout_home = nvxmfc_get_theme_option( 'layout_home' );
		$layout_post = nvxmfc_get_theme_option( 'layout_post' );
		$layout_page = nvxmfc_get_theme_option( 'layout_page' );
		$layout_page = ( !empty($layout_page) ) ? $layout_page : 'center';

		// get custom page layout
		if ( is_singular() ) {
			$custom = get_post_meta( $post->ID, 'nvxmfc_page_layout', true );
			if ( '' == $custom || 'default' == $custom ) {
				unset( $custom );
			}
		}

		// get settings for 'post' layout
		if ( is_single() && isset( $layout_post ) ) {
			$layout = ( isset( $custom ) )
				? $custom
				: $layout_post;
		} // get settings for 'page' layout
		elseif ( is_page() && isset( $layout_page )  ) {
			$layout = ( isset( $custom ) )
				? $custom
				: $layout_page;
		} // get home layout settings
		elseif ( is_home() && $layout_home ) {
			$layout = $layout_home;
		} // get default layout settings
		elseif ( $layout_def ) {
			$layout = $layout_def;
			if ( is_search() ) {
				$layout = 'center';
			}
		}

		return $layout;
	}
endif;
/* ========================================================================== */


/* set custom posts classes
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_set_post_class' ) ) :
	function nvxmfc_set_post_class( $pc ) {
		global $post;

		$classes[] = 'post post-' . $post->ID;

		if ( ! is_singular() ) {
			$classes[] = 'anons';
		}

		if ( is_search() ) {
			$classes[] = 'serp';
		}

		if ( in_array( 'sticky', $pc ) ) {
			$classes[] = 'sticky';
		}

		return $classes;
	}
endif;
add_filter( 'post_class', 'nvxmfc_set_post_class' );
/* ========================================================================== */


/* clear nav menu classes
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_set_nav_menu_class' ) ) :
	function nvxmfc_set_nav_menu_class( $classes ) {

		$custom_classes = array();

		foreach ( $classes as $class ) {
			if ( $class == 'menu-item' || 'current-menu-item' == $class ) {
				$custom_classes[] = $class;
			}
			if ( 'menu-item-has-children' == $class ) {
				$custom_classes[] = $class;
			}
		}

		return $custom_classes;
	}
endif;
add_filter( 'nav_menu_css_class', 'nvxmfc_set_nav_menu_class' );
/* ========================================================================== */


/* exclude link to current page IN CATEGORIES list
 * ========================================================================== */
function nvxmfc_no_link_current_category( $output ) {
	return preg_replace( '%((current-cat)[^<]+)[^>]+>([^<]+)</a>%', '$1<span>$3</span>', $output, 1 );
}

add_filter( 'wp_list_categories', 'nvxmfc_no_link_current_category' );


/* exclude link to current page IN MENU
 * ========================================================================== */
function nvxmfc_no_link_current_page( $output ) {
	return preg_replace( '%((current_page_item|current-menu-item)[^<]+)[^>]+>([^<]+)</a>%', '$1<span>$3</span>', $output, 1 );
}

add_filter( 'wp_nav_menu', 'nvxmfc_no_link_current_page' );
/* ========================================================================== */





/* set default setting for galleries
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_set_gallery_defaults' ) ) :
	function nvxmfc_set_gallery_defaults( $attr ) {

		$attr['itemtag']    = 'div';
		$attr['icontag']    = 'div';
		$attr['captiontag'] = 'p';

		return $attr;
	}
endif;
add_filter( 'shortcode_atts_gallery', 'nvxmfc_set_gallery_defaults' );
/* ========================================================================== */
