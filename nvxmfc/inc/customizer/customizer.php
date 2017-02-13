<?php


/** =============================================================================
 * CUSTOM STYLES
 * ============================================================================= */
function nvxmfc_customizer_css() {

	$style = '';


// ---- header -----
	$bgimg     = get_header_image();
	$bg_repeat = nvxmfc_get_theme_option( 'header_image_repeat' );

	if ( ! empty( $bgimg ) ) {
		$style .= "#header{background-image:url('$bgimg')}";
		$style .= "#header{background-repeat:$bg_repeat}";
	}

	$header_h   = get_custom_header()->height;
	$fit_height = nvxmfc_get_theme_option( 'fix_header_height' );
	if ( ! empty( $fit_height ) && ! empty( $header_h ) ) {
		$style .= "@media screen and (min-width:1024px){.sitetitle{height:{$header_h}px}}";
	}


	$header_textcolor = get_theme_mod( 'header_textcolor', false );
	if ( ! empty( $header_textcolor ) ) {
		$style .= apply_filters( 'nvxmfc_customizer_header_textcolor_css', "a#logo{color:#$header_textcolor}" );
	}

	$main_color = nvxmfc_get_theme_option( 'maincolor' );
	if ( ! empty( $main_color ) && '#e04e39' != $main_color ) {

		$main_color_css = "a:hover,#logo,.bx-controls a:hover .fa{color:$main_color}";
		$main_color_css .= "a:hover{color:$main_color}";
		$main_color_css .= "blockquote,q,input:focus,textarea:focus{border-color:$main_color}";
		$main_color_css .= "input[type=submit],input[type=button],.submit,.button,#mobile-menu:hover,.top-menu,.top-menu .sub-menu,.top-menu .children,.more-link,.nav-links a:hover,.nav-links .current,#footer{background-color:$main_color}";

		$style .= apply_filters( 'nvxmfc_customizer_main_color_css', $main_color_css );
	}

	$style = apply_filters( 'nvxmfc_customizer_css', $style );

	echo $style
		? wp_kses("<!-- BEGIN Customizer CSS -->\n<style type='text/css' id='nvxmfc-customizer-css'>$style</style>\n<!-- END Customizer CSS -->\n" ,'entities')
		: "" ;
}

add_action( 'wp_head', 'nvxmfc_customizer_css' );
/* ======================================================================== */


/* ======================================================================== *
 * Customizer functions
 * ======================================================================== */

// ------------------------
//function nvxmfc_sanitize_checkbox( $value ) {
//	$value = sanitize_key( $value );
//	if ( $value == 1 ) {
//		$value = 1;
//	} else {
//		$value = 0;
//	}
//	return sanitize_text_field( $value );
//}

// ------------------------
function nvxmfc_sanitize_text( $value ) {
	return sanitize_text_field( $value );
}


// ------------------------
function nvxmfc_sanitize_html( $value ) {
	return sanitize_html_class( $value );
}


// ------------------------
function nvxmfc_is_single() {
	return is_single();
}

// ------------------------
function nvxmfc_is_page() {
	return is_page();
}

// ------------------------
function nvxmfc_is_singular() {
	return is_singular();
}

// ------------------------
function nvxmfc_is_default_layout() {
	return ! is_singular() && ! is_page() && ! is_home();
}


// ------------------------
// if ( class_exists( 'WP_Customize_Control' ) ) {
	// class nvxmfc_Group_Title_Control extends WP_Customize_Control {
		// public function render_content() {
			// echo ( ! empty( $this->label ) ) ? '<h2 style="margin:20px 0 3px">' . esc_html( $this->label ) . '</h2>' : '';
			// echo ( ! empty( $this->description ) ) ? '<p class="description">' . esc_html( $this->description ) . '</p>' : '';
			// echo '<hr />';
		// }
	// }
// }
/* ======================================================================== */


/* ========================================================================
 *            script & styles for CUSTOMIZER 
 * ======================================================================== */
if ( ! function_exists( 'nvxmfc_customizer_live' ) ):
	function nvxmfc_customizer_live() {

		wp_enqueue_script(
			'nvxmfc-customizer-js',
			get_template_directory_uri() . '/inc/customizer/assets/customizer-preview.js', // URL
			array( 'jquery', 'customize-preview' ), null, true
		);
		wp_localize_script( 'nvxmfc-customizer-js', 'optname', nvxmfc_OPTION_NAME );

	}
endif;
add_action( 'customize_preview_init', 'nvxmfc_customizer_live' );
/* ======================================================================== */

