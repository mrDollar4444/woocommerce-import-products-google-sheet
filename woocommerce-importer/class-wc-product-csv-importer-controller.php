<?php
/**
 * Class WC_Product_Google_Sheet_Importer_Controller file.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Importer' ) ) {
	return;
}

/**
 * Product importer controller - handles file upload and forms in admin.
 *
 * @package     WooCommerce/Admin/Importers
 * @version     3.1.0
 */
class Google_Sheet_WC_Product_CSV_Importer_Controller extends WC_Product_CSV_Importer_Controller {
	/**
	 * Output information about the uploading process.
	 */
	protected function upload_form() {
		$bytes      = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );
		$size       = size_format( $bytes );
		$upload_dir = wp_upload_dir();

		// include plugin custom import form
		include dirname( __FILE__ ) . '/views/html-product-csv-import-form.php';
	}

	/**
	 * Handles the CSV upload and initial parsing of the file to prepare for
	 * displaying author import options.
	 *
	 * @return string|WP_Error
	 */
	public function handle_upload() {
		// phpcs:disable WordPress.CSRF.NonceVerification.NoNonceVerification -- Nonce already verified in WC_Product_CSV_Importer_Controller::upload_form_handler()
		$file_url = isset( $_POST['file_url'] ) ? wc_clean( wp_unslash( $_POST['file_url'] ) ) : '';

		if ( empty( $file_url ) ) {
			if ( ! isset( $_REQUEST['file'] ) ) {
				return new WP_Error( 'woocommerce_product_csv_importer_upload_file_empty', __( 'File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.', 'woocommerce-import-products-google-sheet' ) );
			}

			if ( $_REQUEST['file'] ) {
				$file_content = $this->google_sheet_get_csv_file( $_REQUEST['file'] );

				$upload_dir_arr = wp_upload_dir();

				$file_sheet_url = $upload_dir_arr['url'] . '/' . $_REQUEST['file'] . '.csv';
				$file_sheet_path = $upload_dir_arr['path'] . '/' . $_REQUEST['file'] . '.csv';

				file_put_contents( $file_sheet_path, $file_content );
			} else {
				$file_sheet_url = '';
			}

			if ( ! self::is_file_valid_csv( wc_clean( wp_unslash( array_slice( explode( '/', $file_sheet_url ), -1 )[0] ) ), false ) ) {
				return new WP_Error( 'woocommerce_product_csv_importer_upload_file_invalid', __( 'Invalid file type. The importer supports CSV and TXT file formats.', 'woocommerce-import-products-google-sheet' ) );
			}

			$overrides = array(
				'test_form' => false,
				'mimes'     => self::get_valid_csv_filetypes(),
			);


			$import = $file_sheet_path; // WPCS: sanitization ok, input var ok.

			// $upload    = wp_handle_upload( $import, $overrides );
			$upload = [
				"file" => $file_sheet_path,
				"url"  => $file_sheet_url,
				"type" => "text/csv",
			];

			if ( isset( $upload['error'] ) ) {
				return new WP_Error( 'woocommerce_product_csv_importer_upload_error', $upload['error'] );
			}

			// Construct the object array.
			$object = array(
				'post_title'     => basename( $upload['file'] ),
				'post_content'   => $upload['url'],
				'post_mime_type' => $upload['type'],
				'guid'           => $upload['url'],
				'context'        => 'import',
				'post_status'    => 'private',
			);

			// Save the data.
			$id = wp_insert_attachment( $object, $upload['file'] );

			/*
			 * Schedule a cleanup for one day from now in case of failed
			 * import or missing wp_import_cleanup() call.
			 */
			wp_schedule_single_event( time() + DAY_IN_SECONDS, 'importer_scheduled_cleanup', array( $id ) );

			return $upload['file'];
		} elseif ( file_exists( ABSPATH . $file_url ) ) {
			if ( ! self::is_file_valid_csv( ABSPATH . $file_url ) ) {
				return new WP_Error( 'woocommerce_product_csv_importer_upload_file_invalid', __( 'Invalid file type. The importer supports CSV and TXT file formats.', 'woocommerce-import-products-google-sheet' ) );
			}

			return ABSPATH . $file_url;
		}
		// phpcs:enable

		return new WP_Error( 'woocommerce_product_csv_importer_upload_invalid_file', __( 'Please upload or provide the link to a valid CSV file.', 'woocommerce-import-products-google-sheet' ) );
	}

	/**
	 * Gateway for a google sheet api
	 *
	 * @param string $file_name
	 *
	 * @return string $sheet_content_csv
	 */
	public function google_sheet_get_csv_file( $file_name ) {
		$google_api_obj = new Wrapper_Api_Google_Drive;
		$google_api_obj->set_sheet( $file_name );
		$sheet_content_csv = $google_api_obj->get_sheet_csv();

		return $sheet_content_csv;
	}
}
