<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=edge" /><![endif]-->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div class="wrapper cleafix">

	<?php do_action( 'nvxmfc_before_header' ); ?>
	<!-- BEGIN header -->
	<header id="header" class="<?php echo esc_html(apply_filters( 'nvxmfc_header_class', 'clearfix' ) ); ?>">

		<?php do_action( 'nvxmfc_before_sitetitle' ); ?>
		<div class="<?php echo esc_html(apply_filters( 'nvxmfc_header_sitetitle_class', 'sitetitle maxwidth grid ' . nvxmfc_get_theme_option( 'title_position' ) ) ); ?>">

			<div class="<?php echo esc_html(apply_filters( 'nvxmfc_logo_class', 'logo' ) ); ?>">

				<?php do_action( 'nvxmfc_before_sitelogo' );
				echo ( is_home() ) ? '<h1>' : ''; ?>

				<a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="blog-name">
				<?php $nvxmfc_default_logo = nvxmfc_get_theme_option( 'show_default_logo' );
					$nvxmfc_show_default_logo  = ( false === $nvxmfc_default_logo || ! empty( $nvxmfc_default_logo )  );
					if ( $nvxmfc_show_default_logo ) { ?>
				<img src="<?php echo esc_url(get_template_directory_uri())?>/img/logotip.png" alt="Moi Dokumenty" class="custom-logo custom-logo-left" id="nvxmfc-logo">
				<?php }
					do_action( 'nvxmfc_before_blogname_in_logo' );
					// bloginfo( 'name' );
					do_action( 'nvxmfc_after_blogname_in_logo' );
				?>
				</a>

				<?php echo ( is_home() ) ? '</h1>' : '';
				do_action( 'nvxmfc_after_sitelogo' ); ?>

				<?php $nvxmfc_description = nvxmfc_get_theme_option( 'showsitedesc' );
				$nvxmfc_show_description  = ( false === $nvxmfc_description || ! empty( $nvxmfc_description ) || is_customize_preview() );
				if ( $nvxmfc_show_description ) { ?>
					<p class="sitedescription"><?php bloginfo( 'description' ); ?></p>
				<?php }
				do_action( 'nvxmfc_after_sitedescription' ); ?>

			</div>
			<?php do_action( 'nvxmfc_after_sitetitle' ); ?>

		</div>

		<?php do_action( 'nvxmfc_before_topnav' ); ?>
		<div class="<?php echo esc_html( apply_filters( 'nvxmfc_header_topnav_class', 'topnav grid' ) ); ?>">

			<div id="mobile-menu" class="mm-active"><?php esc_html_e( 'Menu', 'nvxmfc' ); ?></div>

			<nav>
				<?php if ( has_nav_menu( 'top' ) ) :
					wp_nav_menu( array(
						'theme_location' => 'top',
						'menu_id'        => 'navpages',
						'container'      => false,
						'items_wrap'     => '<ul class="top-menu maxwidth clearfix">%3$s</ul>'
					) );
				else : ?>
					<ul class="top-menu maxwidth clearfix">
						<?php if ( is_front_page() ) { ?>
							<li class="page_item current_page_item"><span><?php esc_html_e( 'Home', 'nvxmfc' ); ?></span></li>
						<?php } else { ?>
							<li class="page_item">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'nvxmfc' ); ?></a>
							</li>
						<?php }
						wp_list_pages( 'title_li=&depth=2' ); ?>
					</ul>
				<?php endif; ?>
			</nav>

		</div>
		<?php do_action( 'nvxmfc_after_topnav' ); ?>

	</header>
	<!-- END header -->

	<?php do_action( 'nvxmfc_after_header' ); ?>


	<div id="main" class="maxwidth clearfix">

		<!-- BEGIN content -->
	
