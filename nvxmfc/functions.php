<?php


/* ==========================================================================
 *  Theme settings
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_setup' ) ) :
	function nvxmfc_setup() {

		if ( ! isset( $content_width ) ) {
			$content_width = 725;
		}

		load_theme_textdomain( 'nvxmfc', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );


		add_theme_support( 'custom-background', apply_filters( 'nvxmfc_custom_background_args', array( 'default-color' => 'ffffff' ) ) );
		add_theme_support( 'custom-header', array(
			'width'       => 1080,
			'height'      => 190,
			'flex-height' => true,
		) );

		register_nav_menus( array(
			'top'    => __( 'Main Menu', 'nvxmfc' ),
			'bottom' => __( 'Footer Menu', 'nvxmfc' )
		) );


		// logo
		$args = array();
		// $args = array(
			// 'width'         => 300,
			// 'height'        => 122,
			// 'default-image' => get_template_directory_uri() . '/img/logotip.png',
		// );
		$lpos = get_theme_mod( 'display_logo_and_title' );
		if ( false === $lpos || 'image' == $lpos ) {
					// $args = array(
				// 'width'         => 300,
				// 'height'        => 122,
				// 'default-image' => get_template_directory_uri() . '/img/logotip.png',
				// 'header-text' 	=> 'blog-name'
				// );
			$args['header-text'] = array( 'blog-name' );
		}
		add_theme_support( 'custom-logo', $args );

	}
endif;
add_action( 'after_setup_theme', 'nvxmfc_setup' );
/* ========================================================================== */


/* ==========================================================================
 *  Load scripts and styles
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_enqueue_style_and_script' ) ) :
	function nvxmfc_enqueue_style_and_script() {

		global $post, $wp_query;

		// STYLES
		wp_enqueue_style( 'nvxmfc-fonts', '//fonts.googleapis.com/css?family=PT+Serif:400,700|Open+Sans:400,400italic,700,700italic&amp;subset=latin,cyrillic', array(), true );
		wp_enqueue_style( 'nvxmfc-style', get_stylesheet_uri(), array(), true );

		// SCRIPTS
		wp_enqueue_script( 'nvxmfc-html5shiv', get_template_directory_uri() . '/js/html5shiv.js', array(), '3.7.3', true );
		wp_script_add_data( 'nvxmfc-html5shiv', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'nvxmfc-scripts', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), true, true );

		if ( is_singular() ) {
			$socbtns = nvxmfc_get_theme_option( 'social_share' );

			if ( 'yandex' == $socbtns ) {
				wp_enqueue_script( 'nvxmfc-yandexshare', '//yastatic.net/share2/share.js', array(), true, true );
			}

			if ( comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply', false, true, true );
			}
		}

	}
endif;
add_action( 'wp_enqueue_scripts', 'nvxmfc_enqueue_style_and_script' );
/* ========================================================================== */


/* ==========================================================================
 *  admin area
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_editor_styles' ) ) :
	function nvxmfc_editor_styles() {
		add_editor_style( 'editor-style.css' );
	}
endif;
add_action( 'admin_init', 'nvxmfc_editor_styles' );
/* ========================================================================== */


/* ==========================================================================
 *  Register widget area
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_widgets_init' ) ) :
	function nvxmfc_widgets_init() {

		register_sidebar( array(
			'name'          => __( 'Sidebar', 'nvxmfc' ),
			'id'            => 'sidebar',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'nvxmfc' ),
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<p class="wtitle">',
			'after_title'   => '</p>',
		) );

	}
endif;
add_action( 'widgets_init', 'nvxmfc_widgets_init' );


/* ==========================================================================
 *  Add Open Graph meta for singular pages
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_add_social' ) ) :
	function nvxmfc_add_social( $content ) {
		global $post;

		if ( is_singular() && nvxmfc_get_theme_option( 'add_social_meta' ) ) {

			$aiod  = get_post_meta( $post->ID, '_aioseop_description', true );
			$descr = ( isset( $aiod ) ) ? esc_html( $aiod ) : $post->post_excerpt;

			$title    = get_the_title();
			$url      = get_the_permalink();
			$blogname = get_bloginfo( 'name' );
			$img      = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail', false );

			echo esc_html('
		
<!-- BEGIN social meta -->
<meta property="og:type" content="article"/>
<meta property="og:title" content="$title"/>
<meta property="og:description" content="$descr" />
<meta property="og:image" content="$img[0]"/>
<meta property="og:url" content="$url"/>
<meta property="og:site_name" content="$blogname"/>
<link rel="image_src" href="$img[0]" />
<!-- END social meta -->

');
		}
	}
endif;
add_action( 'wp_head', 'nvxmfc_add_social' );
/* ========================================================================== */


/* ========================================================================== *
 * default COMMENT callback
 * ========================================================================== */
if ( ! function_exists( 'nvxmfc_html5_comment' ) ) :
	function nvxmfc_html5_comment( $comment, $args, $depth ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo esc_html($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">

			<footer class="comment-meta">
				<div class="comment-author">
					<?php if ( 0 != $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					} ?>
					<b class="fn"><?php comment_author_link(); ?></b>
				</div>

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( esc_html__( '%1$s at %2$s', 'nvxmfc' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( esc_html__( 'Edit', 'nvxmfc' ), '<span class="edit-link">', '</span>' ); ?>
				</div>

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'nvxmfc' ); ?></p>
				<?php endif; ?>
			</footer>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth']
					)
				) ); ?>
			</div>

		</div>

		<?php

	}
endif;
/* ========================================================================== */


/* ==========================================================================
 *  Include libs
 * ========================================================================== */

// functions what display some page parts
require_once( get_template_directory() . '/inc/html-blocks.php' );

// layout functions and filters
require_once( get_template_directory() . '/inc/layout.php' );

// hooks
require_once( get_template_directory() . '/inc/hooks.php' );

// Schema.org markup
require_once( get_template_directory() . '/inc/schemaorg.php' );

// theme options with Customizer API
require_once( get_template_directory() . '/inc/admin/options.php' );
require_once( get_template_directory() . '/inc/customizer/customizer-controls.php' );
require_once( get_template_directory() . '/inc/customizer/customizer-settings.php' );
require_once( get_template_directory() . '/inc/customizer/customizer.php' );


if ( is_admin() ) :

	// meta-box for layout control
	require_once( get_template_directory() . '/inc/admin/meta-boxes.php' );

endif;
/* ========================================================================== */


/* ==========================================================================
 *  admin bar remove
 * ========================================================================== */
/*if ( ! function_exists( 'remove_admin_bar' ) ) :
 function remove_admin_bar() {
  if (current_user_can('editor') || current_user_can('author') || current_user_can('administrator') || is_admin()) {
    show_admin_bar(true);
  } else {
	show_admin_bar(false);
  }
 }
endif;
add_action('after_setup_theme', 'remove_admin_bar');*/
/* ========================================================================== */


/* ==========================================================================
 *  add style for safari registration form
 * ========================================================================== */
 function safari_styles_method() {
	global $is_safari;
	if($is_safari){
		wp_enqueue_style('custom-style', get_template_directory_uri() . '/style.css');
		$custom_css = ".mu_register #user_email,.mu_register #user_name{ height: 35px; }
		input[type=text], 
		input[type=password], 
		input[type=email], 
		input[type=url], 
		input[type=tel], 
		input[type=date], 
		input[type=datetime], 
		input[type=datetime-local], 
		input[type=time],
		input[type=month], 
		input[type=week], 
		input[type=number], 
		input[type=search] {height: 40px;}";
		wp_add_inline_style( 'custom-style', $custom_css );
		
	}
}
add_action( 'wp_enqueue_scripts', 'safari_styles_method' );
/* ========================================================================== */


/* ==========================================================================
 *  removes the "Category", "Tag", etc. archive header
 * ========================================================================== */

add_filter('get_the_archive_title', function( $title ){
	return preg_replace('~^[^:]+: ~', '', $title );
});
/* ========================================================================== */