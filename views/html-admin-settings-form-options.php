<?php
/**
 * Admin View: Product import form
 *
 * @package WooCommerce/Admin
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<h3><?php esc_html_e( 'Google drive API client_secret json', 'woocommerce-import-products-google-sheet' ) ?></h3>
<textarea id="plugin_google_api_key" required name="plugin_wc_import_google_sheet_options[google_api_key]" value="<?php echo $google_api_key ?>">
	<?php echo $google_api_key ?>
</textarea>
<br>
<h3><?php esc_html_e( 'Google sheet title', 'woocommerce-import-products-google-sheet' ) ?></h3>
<input id="plugin_google_sheet_title" required name="plugin_wc_import_google_sheet_options[google_sheet_title]" size="40" type="text" value="<?php echo $google_sheet_title ?>">