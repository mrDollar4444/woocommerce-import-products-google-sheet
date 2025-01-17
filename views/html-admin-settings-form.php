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

<h2>
	<?php _e( 'Import Woocommerce Produts Google Sheet Plugin Options Page', 'woocommerce-import-products-google-sheet' ) ?>
</h2>
<form action="options.php" method="post">
	<?php settings_fields( 'plugin_wc_import_google_sheet_options' ); ?>
	<?php do_settings_sections( 'plugin' ); ?>

	<?php
	$this->get_connection_message();
	?>
	<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
</form>
