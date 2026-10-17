<?php
/**
 * Summary of Import_CSV
 * Handles the import of CSV files for External Lists.
 */
class Import_CSV
{
    /**
     * Summary of upload_file
     * Upload the CSV file into the uploads directory.
     * @param mixed $request_file
     * @return array
     */
    public static function upload_file( $request_file ) {
        $wp_error = new \WP_Error();

        $ret = [
            'errors'    => [],
            'file_path' => '',
        ];

        if ( ! isset( $request_file['error'] ) || UPLOAD_ERR_OK !== $request_file['error'] ) {
            $wp_error->add(
                'upload_error',
                __( 'File upload error.', 'send-users-email' )
            );

            $ret['errors'] = $wp_error->get_error_messages();
            return $ret;
        }

        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        $upload_overrides = [
            'test_form' => false,
            'mimes'     => [
                'csv' => 'text/csv',
            ],
        ];

        $uploaded_file = wp_handle_upload( $request_file, $upload_overrides );

        if ( isset( $uploaded_file['error'] ) ) {
            $wp_error->add(
                'upload_error',
                $uploaded_file['error']
            );
        } else {
            $ret['file_path'] = $uploaded_file['file'];
        }

        if ( $wp_error->has_errors() ) {
            $ret['errors'] = $wp_error->get_error_messages();
        }

        return $ret;
    }

    /**
     * Summary of get_import_data
     * Read the CSV file and return the data for import.
     * @param mixed $file_path
     * @return array
     */
    public static function get_import_data( $file_path ) {
        $error = new \WP_Error();

        $data = [
            'skipped_rows' => 0,
            'row_count'    => 0,
            'errors'       => [],
            'data'         => [],
            'file_path'    => $file_path,
        ];

        require_once ABSPATH . 'wp-admin/includes/file.php';

        if ( ! WP_Filesystem() ) {
            $error->add(
                'filesystem_error',
                __( 'Could not initialize the WordPress filesystem.', 'send-users-email' )
            );

            $data['errors'] = $error->get_error_messages();

            return $data;
        }

        global $wp_filesystem;

        if ( ! $wp_filesystem->exists( $file_path ) ) {
            $error->add(
                'file_not_found',
                __( 'File not found.', 'send-users-email' )
            );

            $data['errors'] = $error->get_error_messages();

            return $data;
        }

        $contents = $wp_filesystem->get_contents( $file_path );

        if ( false === $contents ) {
            $error->add(
                'file_open_error',
                __( 'Could not read the file.', 'send-users-email' )
            );

            $data['errors'] = $error->get_error_messages();

            return $data;
        }

        // Normalize line endings.
        $contents = str_replace( [ "\r\n", "\r" ], "\n", $contents );

        $lines = explode( "\n", $contents );

        // Remove empty trailing lines.
        $lines = array_filter(
            $lines,
            static function ( $line ) {
                return '' !== trim( $line );
            }
        );

        if ( empty( $lines ) ) {
            return $data;
        }

        // Detect delimiter from the first line.
        $first_line = reset( $lines );
        $delimiter  = self::_detect_delimiter( $first_line );

        // Skip header.
        array_shift( $lines );

        $skipped_rows = 0;
        $row_count    = 0;

        foreach ( $lines as $line ) {
            $row = str_getcsv( $line, $delimiter );

            if ( empty( $row[0] ) ) {
                $skipped_rows++;
                continue;
            }

            $email = sanitize_email( $row[0] );

            if ( empty( $email ) || ! is_email( $email ) ) {
                $skipped_rows++;
                continue;
            }

            $row_count++;
            $data['data'][] = $row;
        }

        $data['skipped_rows'] = $skipped_rows;
        $data['row_count']    = $row_count;

        return $data;
    }

    /**
     * Summary of handle_csv_import
     * Upload the CSV file into the uploads directory and process it to avoid timeouts.
     * @param mixed $request_files
     * @return array
     */
    public static function handle_csv_import($request_files)
    {
        $ret = [
            'skipped_rows' => 0,
            'errors' => [],
            'data' => [],
        ];

        $upload = self::upload_file($request_files);

        if ( isset($upload['errors']) && count($upload['errors']) > 0 ) {
            $ret['errors'] = $upload['errors'];
            return $ret;
        }

        $get_data = self::get_import_data($upload['file_path']);

        if ( isset($get_data['errors']) && count($get_data['errors']) > 0 ) {
            $ret['errors'] = $get_data['errors'];
            return $ret;
        }

        return $get_data;
    }

    private static function _detect_delimiter($csv_line)
    {
        $delimiters = [',', ';', "\t", '|'];
        $results = [];
        
        foreach ($delimiters as $delimiter) {
            $fields = str_getcsv(trim($csv_line), $delimiter);
            $results[$delimiter] = count($fields);
        }
        
        // Return the delimiter with the highest field count
        return array_search(max($results), $results);
    }   

}