<?php


/* ======================================================================== *
 * 
 * Add Meta Box
 * 
 * ======================================================================== */
function nvxmfc_add_custom_box() {

	// Adding layout meta box for page
	add_meta_box( 'nvxmfc-page-layout', __( 'Select Layout', 'nvxmfc' ), 'nvxmfc_page_layout', 'page', 'side', 'default' );

	// Adding layout meta box for
	add_meta_box( 'nvxmfc-page-layout', __( 'Select Layout', 'nvxmfc' ), 'nvxmfc_page_layout', 'post', 'side', 'default' );

}

add_action( 'add_meta_boxes', 'nvxmfc_add_custom_box' );
/* ======================================================================== */


/* ======================================================================== */
function nvxmfc_get_default_page_layouts() {

	$page_layout = array(
		'default-layout' => array(
			'id'    => 'nvxmfc_page_layout',
			'value' => 'default',
			'label' => __( 'Default', 'nvxmfc' )
		),
		'rightbar'       => array(
			'id'    => 'nvxmfc_page_layout',
			'value' => 'rightbar',
			'label' => __( 'Rightbar', 'nvxmfc' )
		),
		'leftbar'        => array(
			'id'    => 'nvxmfc_page_layout',
			'value' => 'leftbar',
			'label' => __( 'Leftbar', 'nvxmfc' )
		),
		'full'           => array(
			'id'    => 'nvxmfc_page_layout',
			'value' => 'full',
			'label' => __( 'Fullwidth Content', 'nvxmfc' )
		),
		'center'         => array(
			'id'    => 'nvxmfc_page_layout',
			'value' => 'center',
			'label' => __( 'Centered Content', 'nvxmfc' )
		)
	);

	return $page_layout;

}

/* ======================================================================== */


/* ========================================================================
 *
 * Displays metabox to for select layout option
 *
 * ======================================================================== */
function nvxmfc_page_layout() {
	global $post;

	$page_layout = nvxmfc_get_default_page_layouts();

	// Use nonce for verification  
	wp_nonce_field( basename( __FILE__ ), 'nvxmfc_meta_box_nonce' );

	foreach ( $page_layout as $field ) {
		$layout_meta = get_post_meta( $post->ID, $field['id'], true );
		if ( empty( $layout_meta ) ) {
			$layout_meta = 'default';
		}
		?>
		<label class="nvxmfc-post-format-icon">
			<input class="nvxmfc-post-format" type="radio" name="<?php echo esc_html($field['id']); ?>" value="<?php echo esc_html($field['value']); ?>" <?php checked( $field['value'], $layout_meta ); ?>/>
			<?php echo esc_html($field['label']); ?></label><br />
		<?php
	}
}

/* ======================================================================== */


/* ========================================================================
 *
 * save the custom metabox data
 *
 * ======================================================================== */
function nvxmfc_save_custom_meta( $post_id ) {

	$page_layout = nvxmfc_get_default_page_layouts();

	// Verify the nonce before proceeding.
	if ( ! isset( $_POST['nvxmfc_meta_box_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['nvxmfc_meta_box_nonce'] ) ), basename( __FILE__ ) ) ) {
		return;
	}

	// Stop WP from clearing custom fields on autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	foreach ( $page_layout as $field ) {
		//Execute this saving function
		$old = get_post_meta( $post_id, $field['id'], true );
		$new = isset( $_POST[ $field['id'] ] ) ? sanitize_text_field( wp_unslash($_POST[ $field['id'] ] ) ) : 'default';
		if ( $new && $new != $old ) {
			update_post_meta( $post_id, $field['id'], $new );
		} elseif ( '' == $new && $old ) {
			delete_post_meta( $post_id, $field['id'], $old );
		}
	} // end foreach   
}

add_action( 'pre_post_update', 'nvxmfc_save_custom_meta' );
/* ======================================================================== */

