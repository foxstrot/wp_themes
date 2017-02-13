<?php


/* ==========================================================================
 *  customizer settings init
 * ========================================================================== */
/**
 * @param $wp_customize WP_Customize_Manager
 */
function nvxmfc_customizer_init( $wp_customize ) {

	$transport = 'postMessage';


	/* --------------  S I T E   T I T L E   ---------------- */

	// rename title setting
	$wp_customize->get_section( 'title_tagline' )->title = __( 'Site title', 'nvxmfc' );
	// $wp_customize->remove_control( 'display_header_text' );


	// ----

	$wp_customize->add_setting( 'display_logo_and_title',
		array(
			'default'           => 'image',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'display_logo_and_title_control',
		array(
			'settings' => 'display_logo_and_title',
			'label'    => __( "Display logo image with site title", 'nvxmfc' ),
			'section'  => 'title_tagline',
			'type'     => 'select',
			'choices'  => array(
				'image'  => __( 'Only image, without text', 'nvxmfc' ),
				'top'    => __( 'Picture above the text', 'nvxmfc' ),
				'left'   => __( 'Picture to the left of text', 'nvxmfc' ),
				'right'  => __( 'Picture to the right of text', 'nvxmfc' ),
				'bottom' => __( 'Picture under the text', 'nvxmfc' ),
			)
		)
	);

	// ----
	
	$wp_customize->add_setting( nvxmfc_OPTION_NAME . '[show_default_logo]', array(
		'type'              => 'option',
		'default'           => '1',
		'sanitize_callback' => 'sanitize_key',
		'transport'  =>  $transport
	) );

	$wp_customize->add_control( 'show_default_logo_control',
	array(
		'settings' => nvxmfc_OPTION_NAME . '[show_default_logo]',
		'section'   => 'title_tagline',
		'label'     => __('Show an additional default logo', 'nvxmfc' ),
		'type'      => 'checkbox'
		 )
	 );

	// ----

	if ( class_exists( 'nvxmfc_Group_Title_Control' ) ) {


	// ----

		$wp_customize->add_setting( nvxmfc_OPTION_NAME . '[group_site_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key'
		) );
		$wp_customize->add_control( new nvxmfc_Group_Title_Control( $wp_customize, 'nvxmfc_group_site_title', array(
			'label'    => __( 'Site title', 'nvxmfc' ),
			'section'  => 'title_tagline',
			'priority' => 10,
			'settings' => nvxmfc_OPTION_NAME . '[group_site_title]',
		) ) );
	}

	// change title setting transport
	$wp_customize->get_setting( 'blogname' )->transport = $transport;
	$wp_customize->get_control( 'blogname' )->priority  = 11;

	$wp_customize->get_setting( 'header_textcolor' )->transport = $transport;
	$wp_customize->get_control( 'header_textcolor' )->section   = 'title_tagline';
	$wp_customize->get_control( 'header_textcolor' )->priority  = 11;

	// ----

	if ( class_exists( 'nvxmfc_Group_Title_Control' ) ) {
		$wp_customize->add_setting( nvxmfc_OPTION_NAME . '[group_description_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new nvxmfc_Group_Title_Control( $wp_customize, 'nvxmfc_group_description_title', array(
			'label'    => __( 'Description', 'nvxmfc' ),
			'section'  => 'title_tagline',
			'priority' => 12,
			'settings' => nvxmfc_OPTION_NAME . '[group_description_title]',
		) ) );
	}

	$wp_customize->get_setting( 'blogdescription' )->transport = $transport;
	$wp_customize->get_control( 'blogdescription' )->section   = 'title_tagline';
	$wp_customize->get_control( 'blogdescription' )->priority  = 13;

	// ---

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[title_position]',
		array(
			'type'              => 'option',
			'default'           => 'left',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'title_position_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[title_position]',
			'label'    => __( "Title position", 'nvxmfc' ),
			'section'  => 'title_tagline',
			'type'     => 'select',
			'choices'  => array(
				'left'   => __( "Left", 'nvxmfc' ),
				'right'  => __( "Right", 'nvxmfc' ),
				'center' => __( "Center", 'nvxmfc' )
			),
			'priority' => 11,
		)
	);

	// ---

	// site descriptions
	$wp_customize->add_setting( nvxmfc_OPTION_NAME . '[showsitedesc]', array(
		'type'              => 'option',
		'default'           => '1',
		'sanitize_callback' => 'sanitize_key',
//		'sanitize_callback' => 'nvxmfc_sanitize_checkbox',
		'transport'         => $transport
	) );
	$wp_customize->add_control( 'showsitedesc_control',
		array(
			'label'    => __( 'Show site description', 'nvxmfc' ),
			'settings' => nvxmfc_OPTION_NAME . '[showsitedesc]',
			'section'  => 'title_tagline',
			'type'     => 'checkbox',
			'priority' => 21,
		)
	);

	// ----

	if ( class_exists( 'nvxmfc_Group_Title_Control' ) ) {
		$wp_customize->add_setting( nvxmfc_OPTION_NAME . '[group_other_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new nvxmfc_Group_Title_Control( $wp_customize, 'nvxmfc_group_other_title', array(
			'label'    => __( 'Other', 'nvxmfc' ),
			'section'  => 'title_tagline',
			'priority' => 22,
			'settings' => nvxmfc_OPTION_NAME . '[group_other_title]',
		) ) );
	}


	/*----------  H E A D E R    I M A G E   ----------*/

//	$wp_customize->get_section( 'header_image' )->title    = __( 'Header', 'nvxmfc' );
	$wp_customize->get_section( 'header_image' )->priority = 30;

	// ---

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[fix_header_height]',
		array(
			'type'              => 'option',
			'default'           => 0,
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'fix_header_height_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[fix_header_height]',
			'label'    => __( "Set header height as background image size", 'nvxmfc' ),
			'section'  => 'header_image',
			'type'     => 'checkbox',
		)
	);
	// ---

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[header_image_repeat]',
		array(
			'type'              => 'option',
			'default'           => 'no-repeat',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'header_image_repeat_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[header_image_repeat]',
			'label'    => __( "Image repeat", 'nvxmfc' ),
			'section'  => 'header_image',
			'type'     => 'radio',
			'choices'  => array(
				'no-repeat' => __( "No repeat", 'nvxmfc' ),
				'repeat-x'  => __( "Repeat", 'nvxmfc' ),
			),
		)
	);


	/*----------  C O L O R S   &&   B A C K G R O U N D  ----------*/

	$wp_customize->get_section( 'background_image' )->title = __( 'Background', 'nvxmfc' );

	$wp_customize->get_control( 'background_color' )->priority = 30;
	$wp_customize->get_control( 'background_image' )->priority = 30;

	$wp_customize->get_control( 'background_color' )->section = 'background_image';
	$wp_customize->remove_section( 'colors' );


	/*----------  L A Y O U T   ----------*/

	// content custom section
	$wp_customize->add_section(
		'layout',
		array(
			'title'       => __( 'Design', 'nvxmfc' ),
			'priority'    => 80,
			'description' => __( 'Main theme options', 'nvxmfc' )
		)
	);

	// ----
	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[maincolor]',
		array(
			'type'              => 'option',
			'default'           => '#e04e39',
			'priority'          => 10,
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		nvxmfc_OPTION_NAME . '[maincolor]',
		array(
			'label'       => __( "Main color", 'nvxmfc' ),
			'description' => __( "Choose main color", 'nvxmfc' ),
			'section'     => 'layout',
			'settings'    => nvxmfc_OPTION_NAME . '[maincolor]',
		)
	) );

	// ----

	if ( class_exists( 'nvxmfc_Group_Title_Control' ) ) {
		$wp_customize->add_setting( nvxmfc_OPTION_NAME . '[group_layout_title]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key',
		) );
		$wp_customize->add_control( new nvxmfc_Group_Title_Control( $wp_customize, 'nvxmfc_group_layout_title', array(
			'label'       => __( 'Layout', 'nvxmfc' ),
			'description' => __( 'Set up layout for site pages', 'nvxmfc' ),
			'section'     => 'layout',
			'settings'    => nvxmfc_OPTION_NAME . '[group_layout_title]',
		) ) );
	}

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[show_sidebar]',
		array(
			'type'              => 'option',
			'default'           => '0',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'show_sidebar_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[show_sidebar]',
			'label'    => __( "Show sidebar on mobile", 'nvxmfc' ),
			'section'  => 'layout',
			'type'     => 'checkbox',
		)
	);

	// ----

	$wp_customize->add_setting( 'show_mobile_thumb',
		array(
			'default'           => 0,
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'show_mobile_thumb_control',
		array(
			'settings' => 'show_mobile_thumb',
			'label'    => __( "Show featured images on mobile", 'nvxmfc' ),
			'section'  => 'layout',
			'type'     => 'checkbox',
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[layout_home]',
		array(
			'type'              => 'option',
			'default'           => 'rightbar',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_home_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[layout_home]',
			'label'    => __( "Layout on Home", 'nvxmfc' ),
			'section'  => 'layout',
//			'active_callback' => 'is_home',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'nvxmfc' ),
				'leftbar'  => __( "Leftbar", 'nvxmfc' ),
				'full'     => __( "Fullwidth Content", 'nvxmfc' ),
				'center'   => __( "Centered Content", 'nvxmfc' )
			),
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[layout_post]',
		array(
			'type'              => 'option',
			'default'           => 'rightbar',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_post_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[layout_post]',
			'label'    => __( "Layout on Post", 'nvxmfc' ),
			'section'  => 'layout',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'nvxmfc' ),
				'leftbar'  => __( "Leftbar", 'nvxmfc' ),
				'full'     => __( "Fullwidth Content", 'nvxmfc' ),
				'center'   => __( "Centered Content", 'nvxmfc' )
			),
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[layout_page]',
		array(
			'type'              => 'option',
			'default'           => 'center',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_page_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[layout_page]',
			'label'    => __( "Layout on Page", 'nvxmfc' ),
			'section'  => 'layout',
//			'active_callback' => 'nvxmfc_is_page',
			'type'     => 'select',
			'choices'  => array(
				'rightbar' => __( "Rightbar", 'nvxmfc' ),
				'leftbar'  => __( "Leftbar", 'nvxmfc' ),
				'full'     => __( "Fullwidth Content", 'nvxmfc' ),
				'center'   => __( "Centered Content", 'nvxmfc' )
			),
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[layout_default]',
		array(
			'type'              => 'option',
			'default'           => 'rightbar',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'layout_default_control',
		array(
			'settings'    => nvxmfc_OPTION_NAME . '[layout_default]',
			'label'       => __( "Global layout", 'nvxmfc' ),
			'description' => __( "It is used when individual page layout is not set", 'nvxmfc' ),
			'section'     => 'layout',
			'type'        => 'select',
			'choices'     => array(
				'rightbar' => __( "Rightbar", 'nvxmfc' ),
				'leftbar'  => __( "Leftbar", 'nvxmfc' ),
				'full'     => __( "Fullwidth Content", 'nvxmfc' ),
				'center'   => __( "Centered Content", 'nvxmfc' )
			),
		)
	);


	// ----

	if ( class_exists( 'nvxmfc_Group_Title_Control' ) ) {
		$wp_customize->add_setting( nvxmfc_OPTION_NAME . '[group_other_layout]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_key'
		) );
		$wp_customize->add_control( new nvxmfc_Group_Title_Control( $wp_customize, 'nvxmfc_group_other_layout', array(
			'label'    => __( 'Other options', 'nvxmfc' ),
			'section'  => 'layout',
			'settings' => nvxmfc_OPTION_NAME . '[group_other_layout]',
		) ) );
	}

	// ----

	$wp_customize->add_setting( 'postmeta_list',
		array(
			'default'           => 'date_category_comments',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control(
		new nvxmfc_Sortable_Checkboxes_WPCC(
			$wp_customize,
			'fx_share_services', /* control id */
			array(
				'settings'    => 'postmeta_list',
				'label'       => __( "Post meta", 'nvxmfc' ),
				'description' => __( "What meta information to display for posts", 'nvxmfc' ),
				'section'     => 'layout',
				'choices'     => array(
					'date'     => __( "Publication date", 'nvxmfc' ),
					'author'   => __( "Post author", 'nvxmfc' ),
					'category' => __( "Post categories", 'nvxmfc' ),
					'comments' => __( "Comments count", 'nvxmfc' ),
					'tags'     => __( "Post tags", 'nvxmfc' )
				),
			)
		)
	);

	// --------------------------------------------------------------------------------------

	/**
	 * @since 1.1.7 two sections (social and markup) moved to panel Single post options
	 *
	 */
	$wp_customize->add_panel( 'nvxmfc_single_options',
		array(
			'title'       => __( "Post", 'nvxmfc' ),
			'description' => __( "Set your custom options to displaying posts", 'nvxmfc' ),
			'priority'    => 81
		)
	);

	// -------  S O C I A L ------------------------------------------------------------------

	$wp_customize->add_section( 'social',
		array(
			'title'       => __( 'Social', 'nvxmfc' ),
			'description' => __( 'Social buttons', 'nvxmfc' ),
			'priority'    => 81,
			'panel'       => 'nvxmfc_single_options',
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[add_social_meta]',
		array(
			'type'              => 'option',
			'default'           => '0',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'add_social_meta_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[add_social_meta]',
			'label'    => __( "Add Open Graph tags to &lt;head&gt;", 'nvxmfc' ),
			'section'  => 'social',
			'type'     => 'checkbox',
		)
	);


	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[social_share]',
		array(
			'type'              => 'option',
			'default'           => 'custom',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'refresh'//$transport
		)
	);
	$wp_customize->add_control( 'social_share_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[social_share]',
			'label'    => __( "Social share buttons after post", 'nvxmfc' ),
			'section'  => 'social',
			'type'     => 'select',
			'choices'  => array(
				'hide'   => __( "Hide", 'nvxmfc' ),
				'custom' => __( "Custom theme buttons", 'nvxmfc' ),
				'yandex' => __( "Yandex Buttons", 'nvxmfc' ),
			),
		)
	);


	// -----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[title_before_socshare]',
		array(
			'type'              => 'option',
			'default'           => '',
			'sanitize_callback' => 'nvxmfc_sanitize_text',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'title_before_socshare_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[title_before_socshare]',
			'label'    => __( "Custom text before share buttons", 'nvxmfc' ),
			'section'  => 'social',
			'type'     => 'text',
		)
	);


	// --------  S T U C T U R E D   D A T A   --------------------------------------------------

	$wp_customize->add_section(
		'nvxmfc_structured_data',
		array(
			'title'    => __( 'Structured Data', 'nvxmfc' ),
			'priority' => 82,
			'panel'    => 'nvxmfc_single_options',
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[schema_mark]',
		array(
			'type'              => 'option',
			'default'           => '1',
			'sanitize_callback' => 'sanitize_key',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'schema_mark_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[schema_mark]',
			'label'    => __( "Enable Schema.org mark up according CreativeWork->Article and Comment", 'nvxmfc' ),
			'section'  => 'nvxmfc_structured_data',
			'type'     => 'checkbox',
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[markup_telephone]',
		array(
			'type'              => 'option',
			'default'           => '(000) 000-000-00',
			'sanitize_callback' => 'nvxmfc_sanitize_text',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'markup_telephone_control',
		array(
			'settings'    => nvxmfc_OPTION_NAME . '[markup_telephone]',
			'label'       => __( "Phone", 'nvxmfc' ),
			'description' => __( "use in https://schema.org/Organization", 'nvxmfc' ),
			'section'     => 'nvxmfc_structured_data',
			'type'        => 'text',
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[markup_adress]',
		array(
			'type'              => 'option',
			'default'           => __( 'Russia', 'nvxmfc' ),
			'sanitize_callback' => 'nvxmfc_sanitize_text',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'markup_adress_control',
		array(
			'settings'    => nvxmfc_OPTION_NAME . '[markup_adress]',
			'label'       => __( "Address", 'nvxmfc' ),
			'description' => __( "use in https://schema.org/Organization", 'nvxmfc' ),
			'section'     => 'nvxmfc_structured_data',
			'type'        => 'text',
		)
	);


	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[markup_logo]',
		array(
			'type'              => 'option',
			'default'           => get_template_directory_uri() . '/img/logo.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'markup_logo_control',
		array(
			'settings'    => nvxmfc_OPTION_NAME . '[markup_logo]',
			'label'       => __( 'Publisher logo', 'nvxmfc' ),
			'description' => __( "use in https://schema.org/Organization", 'nvxmfc' ),
			'section'     => 'nvxmfc_structured_data',
		)
	) );


	// --------  Advertisement   C O D E S  --------------------------------------------------

	$wp_customize->add_section( 'nvxmfc_advertisement',
		array(
			'title'       => __( 'Advertisement', 'nvxmfc' ),
			'description' => __( 'Setup advertisement before and after post content', 'nvxmfc' ),
			'panel'       => 'nvxmfc_single_options',
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[before_content]',
		array(
			'type'              => 'option',
			'default'           => "<!-- " . __( "Code before single post content", "nvxmfc" ) . " -->",
			'sanitize_callback' => 'nvxmfc_sanitize_html',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'before_content_control',
		array(
			'settings'    => nvxmfc_OPTION_NAME . '[before_content]',
			'label'       => __( "Before content", 'nvxmfc' ),
			'description' => __( "Code before single post content", 'nvxmfc' ),
			'section'     => 'nvxmfc_advertisement',
			'type'        => 'textarea',
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[after_content]',
		array(
			'type'              => 'option',
			'default'           => "<!-- " . __( "Code after single post content", "nvxmfc" ) . " -->",
			'sanitize_callback' => 'nvxmfc_sanitize_html',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'after_content_control',
		array(
			'settings'    => nvxmfc_OPTION_NAME . '[after_content]',
			'label'       => __( "After content", 'nvxmfc' ),
			'description' => __( "Code after single post content", 'nvxmfc' ),
			'section'     => 'nvxmfc_advertisement',
			'type'        => 'textarea',
		)
	);


	// ----------  F O O T E R  ----------


	$wp_customize->add_section(
		'nvxmfc_footer_text',
		array(
			'title'       => __( 'Footer', 'nvxmfc' ),
			'description' => __( 'Customize footer', 'nvxmfc' ),
			'priority'    => 92,
		)
	);

	// ----

	$wp_customize->add_setting(
		nvxmfc_OPTION_NAME . '[copyright_text]',
		array(
			'type'              => 'option',
			'default'           => __( ' ', 'nvxmfc' ),
			'sanitize_callback' => 'nvxmfc_sanitize_text',
			'transport'         => $transport
		)
	);
	$wp_customize->add_control( 'copyright_text_control',
		array(
			'settings' => nvxmfc_OPTION_NAME . '[copyright_text]',
			'label'    => __( "Copyright text", 'nvxmfc' ),
			'section'  => 'nvxmfc_footer_text',
			'type'     => 'text',
		)
	);


}

add_action( 'customize_register', 'nvxmfc_customizer_init' );
