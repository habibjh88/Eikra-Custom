<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;
do_action( 'woocommerce_before_edit_account_form' );
$home_address      = get_user_meta( $user->ID, 'home_address', true );
$phone_number      = get_user_meta( $user->ID, 'phone_number', true );
$date_of_birth     = get_user_meta( $user->ID, 'date_of_birth', true );
$bank_account      = get_user_meta( $user->ID, 'bank_account', true );
$identity_document = get_user_meta( $user->ID, 'identity_document', true );
$passport          = get_user_meta( $user->ID, 'passport', true );

?>

<form class="woocommerce-EditAccountForm edit-account" action=""
      method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

    <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
        <label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name"
               id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>"/>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
        <label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span
                    class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name"
               id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>"/>
    </p>
    <div class="clear"></div>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span
                    class="required">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name"
               id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>"/>
        <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
    </p>
    <div class="clear"></div>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span
                    class="required">*</span></label>
        <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email"
               id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>"/>
    </p>

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
		<?php
        if($identity_document) :
		$mime_type = get_post_mime_type($identity_document);
		if (strpos($mime_type, 'image') !== false) { ?>
        <a class="eikra-child-popup" href="<?php echo esc_url( wp_get_attachment_url($identity_document) ) ?>">
        <?php echo wp_get_attachment_image($identity_document); ?>
        </a>
			<?php
		} elseif ($mime_type === 'application/pdf') {
			$pdf_url = wp_get_attachment_url($identity_document);
			echo '<iframe src="' . esc_url($pdf_url) . '" width="100%" height="600px"></iframe>';
		}
        endif;
		?>
        <br>
    <label class="d-block" for="identity_document"><?php esc_html_e( 'Upload an identity document', 'woocommerce' ); ?>&nbsp;<span
                class="required">*</span></label><br>
    <input type="file" accept='image/*,.pdf' class="woocommerce-Input woocommerce-Input--text input-text"
           name="identity_document" id="identity_document" autocomplete="identity_document"
           value="<?php echo ( ! empty( $_POST['identity_document'] ) ) ? esc_attr( wp_unslash( $_POST['identity_document'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<?php
        if($passport) :
            $mime_type = get_post_mime_type($passport);
            if (strpos($mime_type, 'image') !== false) { ?>
                <a class="eikra-child-popup" href="<?php echo esc_url( wp_get_attachment_url($passport) ) ?>">
                <?php echo wp_get_attachment_image($passport); ?>
                </a><?php
            } elseif ($mime_type === 'application/pdf') {
                $pdf_url = wp_get_attachment_url($passport);
                echo '<iframe src="' . esc_url($pdf_url) . '" width="100%" height="600px"></iframe>';
            }
        endif;
		?>
        <br>
    <label class="d-block" for="passport"><?php esc_html_e( 'Upload passport', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label><br>
    <input type="file" accept='image/*,.pdf' class="woocommerce-Input woocommerce-Input--text input-text"
           name="passport" id="passport" autocomplete="passport"
           value="<?php echo ( ! empty( $_POST['passport'] ) ) ? esc_attr( wp_unslash( $_POST['passport'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
    </p>

    <fieldset>
        <legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
                   name="password_current" id="password_current" autocomplete="off"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1"
                   id="password_1" autocomplete="off"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2"
                   id="password_2" autocomplete="off"/>
        </p>
    </fieldset>
    <div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

    <p>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
        <button type="submit"
                class="woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"
                name="save_account_details"
                value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
        <input type="hidden" name="action" value="save_account_details"/>
    </p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
