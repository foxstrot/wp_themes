<?php

if ( ! defined( 'nvxmfc_APP_NAME' ) ) {
	$theme_name = sanitize_key( '' . wp_get_theme() );
	define( 'nvxmfc_APP_NAME', $theme_name );
}

define( 'nvxmfc_OPTION_NAME', 'nvxmfc_theme_options_' . nvxmfc_APP_NAME );


/* ==========================================================================
* 	customize get_option for theme options
* ========================================================================== */
if ( ! function_exists( 'nvxmfc_get_theme_option' ) ) :
	function nvxmfc_get_theme_option( $key ) {

		$cache = wp_cache_get( nvxmfc_OPTION_NAME );
		if ( $cache ) {
			return ( isset( $cache[ $key ] ) ) ? $cache[ $key ] : false;
		}

		$opt = get_option( nvxmfc_OPTION_NAME );

		wp_cache_add( nvxmfc_OPTION_NAME, $opt );

		return ( isset( $opt[ $key ] ) ) ? $opt[ $key ] : false;
	}
endif;
/* ============================================================================= */


/* ==========================================================================
* 	customize get_option for theme options
* ========================================================================== */
function nvxmfc_backward_compatible_theme_option_name() {

	$old_option_name = 'theme_options_' . get_template();
	$old_option      = get_option( $old_option_name );

	if ( false == $old_option ) {
		return;
	}

	delete_option( nvxmfc_OPTION_NAME );
	update_option( nvxmfc_OPTION_NAME, $old_option );

	delete_option( $old_option_name );

}

add_action( 'init', 'nvxmfc_backward_compatible_theme_option_name' );
/* ============================================================================= */

