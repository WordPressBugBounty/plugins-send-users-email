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
    public static function upload_file($request_file)
    {
        $upload_dir = wp_upload_dir();
        
        $file = $request_file;
        
        $wp_error = new \WP_Error();
        
        $ret = [
            'errors' => [],
            'file_path' => '',
        ];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $wp_error->add('upload_error', __('File upload error.', 'send-users-email'));
        }
        
        // Validate file type
        $filetype = wp_check_filetype($file['name']);
        if ($filetype['ext'] !== 'csv') {
            $wp_error->add('invalid_file_type', __('Invalid file type. Please upload a CSV file.', 'send-users-email'));
        }
       
        // Move file to uploads directory
        $target_path = $upload_dir['basedir'] . '/' . basename($file['name']);

        // delete the file if it already exists
        if (file_exists($target_path)) {
            unlink($target_path);
        }

        move_uploaded_file($file['tmp_name'], $target_path);

        $handle = fopen($target_path, 'r');
        if (!$handle) {
            $wp_error->add('file_open_error', __('Could not open the uploaded file.', 'send-users-email'));
        }

        if ($wp_error->has_errors()) {
            $ret['errors'] = $wp_error->get_error_messages();
        } else {
            $ret['file_path'] = $target_path;
        }

        return $ret;
    }

    /**
     * Summary of get_import_data
     * Read the CSV file and return the data for import.
     * @param mixed $file_path
     * @return array
     */
    public static function get_import_data($file_path)
    {
        $error = new \WP_Error();

        $data = [
            'skipped_rows' => 0,
            'row_count' => 0,
            'errors' => [],
            'data' => [],
            'file_path' => $file_path,
        ];

        if (!file_exists($file_path)) {
            $error->add('file_not_found', __('File not found.', 'send-users-email'));
        }

        $handle = fopen($file_path, 'r');
        if (!$handle) {
            $error->add('file_open_error', __('Could not open the file.', 'send-users-email'));
        }

        // Read first line to detect delimiter
        $first_line = fgets($handle);
        $delimiter = self::_detect_delimiter($first_line);
        
        // Rewind and skip header using detected delimiter
        rewind($handle);
        $header = fgetcsv($handle, 0, $delimiter);
        
        $skipped_rows = 0;
        $row_count = 0;
        
        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            $email = sanitize_email($row[0]);
            
            if (empty($email) || !is_email($email)) {
                $skipped_rows++;
                continue;
            }
            
            $row_count++;
            
            $data['data'][] = $row;
        }

        fclose($handle);

        $data['skipped_rows'] = $skipped_rows;
        $data['row_count'] = $row_count;

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