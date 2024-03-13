<?php
add_action( 'wp_enqueue_scripts', 'eikra_child_styles', 18 );
function eikra_child_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_uri() );

	wp_enqueue_style( 'magnific-popup' );
	wp_enqueue_script( 'magnific-popup' );
}

add_action( 'wp_footer', function () {
	?>
    <script>
        jQuery(document).ready(function () {
            if (typeof jQuery.fn.magnificPopup == 'function') {
                jQuery('.eikra-child-popup').magnificPopup({
                    type: 'image',
                    gallery: {enabled: false}
                });
            }

            //  jQuery('.eikra-child-popup').magnificPopup({type:'image'});
        });
    </script>
	<?php
}, 99999 );

add_action( 'after_setup_theme', 'eikra_child_theme_setup' );
function eikra_child_theme_setup() {
	load_child_theme_textdomain( 'eikra', get_stylesheet_directory() . '/languages' );
}

add_filter( 'eikra_menu_category_args', function ( $args ) {
	$args['orderby'] = 'name';

	return $args;
} );


/**
 * To validate WooCommerce registration form custom fields.
 */
add_action( 'woocommerce_register_post', 'eikra_child_validate_fields', 10, 3 );

function eikra_child_validate_fields( $username, $email, $errors ) {

	if ( empty( $_POST['first_name'] ) ) {
		$errors->add( 'first_name_error', 'Name is required!' );
	}
	if ( empty( $_POST['home_address'] ) ) {
		$errors->add( 'home_address_error', 'Home Address is required!' );
	}
	if ( empty( $_POST['phone_number'] ) ) {
		$errors->add( 'phone_number_error', 'Name is required!' );
	}
	if ( empty( $_POST['date_of_birth'] ) ) {
		$errors->add( 'date_of_birth_error', 'Name is required!' );
	}
	if ( empty( $_POST['bank_account'] ) ) {
		$errors->add( 'bank_account_error', 'Name is required!' );
	}

	if ( isset( $_POST['identity_document'] ) && empty( $_POST['identity_document'] ) ) {
		$errors->add( 'identity_document_error', __( 'Please provide a valid document', 'woocommerce' ) );
	}

}

/**
 * To save WooCommerce registration form custom fields.
 */
add_action( 'woocommerce_created_customer', 'eikra_child_save_register_fields' );
add_action( 'woocommerce_save_account_details', 'eikra_child_save_register_fields' );
add_action( 'personal_options_update', 'eikra_child_save_register_fields' );
add_action( 'edit_user_profile_update', 'eikra_child_save_register_fields' );

function eikra_child_save_register_fields( $customer_id ) {
	//First name field
	if ( isset( $_POST['first_name'] ) ) {
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['first_name'] ) );
	}
	if ( isset( $_POST['last_name'] ) ) {
		update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['last_name'] ) );
	}
	if ( isset( $_POST['home_address'] ) ) {
		update_user_meta( $customer_id, 'home_address', sanitize_text_field( $_POST['home_address'] ) );
	}
	if ( isset( $_POST['phone_number'] ) ) {
		update_user_meta( $customer_id, 'phone_number', sanitize_text_field( $_POST['phone_number'] ) );
	}
	if ( isset( $_POST['date_of_birth'] ) ) {
		update_user_meta( $customer_id, 'date_of_birth', sanitize_text_field( $_POST['date_of_birth'] ) );
	}
	if ( isset( $_POST['bank_account'] ) ) {
		update_user_meta( $customer_id, 'bank_account', sanitize_text_field( $_POST['bank_account'] ) );
	}

	if ( isset( $_FILES['identity_document'] ) || isset( $_FILES['passport'] ) ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );

		if ( ! empty( $_FILES['identity_document']['name'] ) ) {
			$attachment_id = media_handle_upload( 'identity_document', 0 );
			if ( is_wp_error( $attachment_id ) ) {
				update_user_meta( $customer_id, 'identity_document', $_FILES['identity_document'] . ": " . $attachment_id->get_error_message() );
			} else {
				update_user_meta( $customer_id, 'identity_document', $attachment_id );
			}
		}

		if ( ! empty( $_FILES['passport']['name'] ) ) {
			$attachment_id = media_handle_upload( 'passport', 0 );
			if ( is_wp_error( $attachment_id ) ) {
				update_user_meta( $customer_id, 'passport', $_FILES['passport'] . ": " . $attachment_id->get_error_message() );
			} else {
				update_user_meta( $customer_id, 'passport', $attachment_id );
			}
		}
	}

}

add_action( 'woocommerce_register_form_tag', 'eikra_core_enctype_custom_registration_forms' );
add_action( 'woocommerce_edit_account_form_tag', 'eikra_core_enctype_custom_registration_forms' );
add_action( 'user_edit_form_tag', 'eikra_core_enctype_custom_registration_forms' );

function eikra_core_enctype_custom_registration_forms() {
	echo 'enctype="multipart/form-data"';
}

//TODO: Account details page
//add_action( 'woocommerce_save_account_details', 'cssigniter_save_account_details' );
function cssigniter_save_account_details( $user_id ) {

	if ( isset( $_POST['home_address'] ) ) {
		update_user_meta( $user_id, 'home_address', sanitize_text_field( $_POST['home_address'] ) );
	}

	if ( isset( $_POST['phone_number'] ) ) {
		update_user_meta( $user_id, 'phone_number', sanitize_text_field( $_POST['phone_number'] ) );
	}

}


//TODO: User Edit Page

add_action( 'admin_footer', function () {
	?>
    <style>
        .eikra-extra-fields .form-row-wide {
            display: flex;

        }

        .eikra-extra-fields .form-row-wide label {
            flex: 0 0 210px;
            font-weight: bold;
            font-size: 14px;
            line-height: 40px;
        }
        .eikra-upload-area {
            display: flex;
            flex-direction: column;
        }
    </style>
	<?php
} );

function custom_user_profile_fields( $user ) {
	$home_address      = get_user_meta( $user->ID, 'home_address', true );
	$phone_number      = get_user_meta( $user->ID, 'phone_number', true );
	$date_of_birth     = get_user_meta( $user->ID, 'date_of_birth', true );
	$bank_account      = get_user_meta( $user->ID, 'bank_account', true );
	$identity_document = get_user_meta( $user->ID, 'identity_document', true );
	$passport          = get_user_meta( $user->ID, 'passport', true );

	?>
    <div class="eikra-extra-fields" style="max-width: 1200px;">
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="home_address"><?php esc_html_e( 'Home Address', 'woocommerce' ); ?>&nbsp;<span
                        class="required">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="home_address"
                   id="home_address" autocomplete="home_address"
                   value="<?php echo esc_attr( $home_address ) ?>"/><?php // @codingStandardsIgnoreLine ?>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="phone_number"><?php esc_html_e( 'Phone Number', 'woocommerce' ); ?>&nbsp;<span
                        class="required">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="phone_number"
                   id="phone_number" autocomplete="phone_number"
                   value="<?php echo esc_attr( $phone_number ) ?>"/><?php // @codingStandardsIgnoreLine ?>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="date_of_birth"><?php esc_html_e( 'Date of birth', 'woocommerce' ); ?>&nbsp;<span
                        class="required">*</span></label>
            <input type="date" class="woocommerce-Input woocommerce-Input--text input-text" name="date_of_birth"
                   id="date_of_birth" autocomplete="date_of_birth"
                   value="<?php echo esc_attr( $date_of_birth ) ?>"/><?php // @codingStandardsIgnoreLine ?>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="bank_account"><?php esc_html_e( 'Bank Account', 'woocommerce' ); ?>&nbsp;<span
                        class="required">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="bank_account"
                   id="bank_account" autocomplete="bank_account"
                   value="<?php echo esc_attr( $bank_account ) ?>"/><?php // @codingStandardsIgnoreLine ?>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">


            <label class="d-block" for="identity_document"><?php esc_html_e( 'Identity document', 'woocommerce' ); ?>
                &nbsp;<span
                        class="required">*</span></label>
            <span class="eikra-upload-area">

			<?php
			if ( $identity_document ) :
				$mime_type = get_post_mime_type( $identity_document );
				if ( strpos( $mime_type, 'image' ) !== false ) { ?>
                    <a class="eikra-child-popup"
                       href="<?php echo esc_url( wp_get_attachment_url( $identity_document ) ) ?>">
						<?php echo wp_get_attachment_image( $identity_document ); ?>
                    </a>
					<?php
				} elseif ( $mime_type === 'application/pdf' ) {
					$pdf_url = wp_get_attachment_url( $identity_document );
					echo '<iframe src="' . esc_url( $pdf_url ) . '" width="100%" height="600px"></iframe>';
				}
			endif;
			?>
            <input type="file" accept='image/*,.pdf' class="woocommerce-Input woocommerce-Input--text input-text"
                   name="identity_document" id="identity_document" autocomplete="identity_document"
                   value="<?php echo ( ! empty( $_POST['identity_document'] ) ) ? esc_attr( wp_unslash( $_POST['identity_document'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>

        </span>

        </p>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label class="d-block" for="passport"><?php esc_html_e( 'Upload passport', 'woocommerce' ); ?>&nbsp;<span
                        class="required">*</span></label><br>

                <span class="eikra-upload-area">
                    <?php
                    if ( $passport ) :
                        $mime_type = get_post_mime_type( $passport );
                        if ( strpos( $mime_type, 'image' ) !== false ) { ?>
                        <a class="eikra-child-popup" href="<?php echo esc_url( wp_get_attachment_url( $passport ) ) ?>">
                            <?php echo wp_get_attachment_image( $passport ); ?>
                            </a><?php
                        } elseif ( $mime_type === 'application/pdf' ) {
                            $pdf_url = wp_get_attachment_url( $passport );
                            echo '<iframe src="' . esc_url( $pdf_url ) . '" width="100%" height="600px"></iframe>';
                        }
                    endif;
                    ?>
                    <input type="file" accept='image/*,.pdf' class="woocommerce-Input woocommerce-Input--text input-text"
                           name="passport" id="passport" autocomplete="passport"
                           value="<?php echo ( ! empty( $_POST['passport'] ) ) ? esc_attr( wp_unslash( $_POST['passport'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                </span>
        </p>
    </div>
<?php }

add_action( 'show_user_profile', 'custom_user_profile_fields' );
add_action( 'edit_user_profile', 'custom_user_profile_fields' );

// Save custom meta fields data
function save_custom_user_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
	// Save the file field value
	if ( isset( $_POST['user_file_field'] ) ) {
		update_user_meta( $user_id, 'user_file_field', sanitize_text_field( $_POST['user_file_field'] ) );
	}
}
//add_action('personal_options_update', 'save_custom_user_profile_fields');
//add_action('edit_user_profile_update', 'save_custom_user_profile_fields');