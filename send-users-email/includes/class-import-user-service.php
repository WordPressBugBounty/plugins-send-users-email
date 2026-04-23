<?php
/**
 * Summary of Import_User_Service
 * This class handles the import of users from CSV files into External Lists.
 * 
 */
class Import_User_Service
{
    /**
     * Summary of upload_file
     * Upload the CSV file into the uploads directory.
     * @param mixed $request_file
     * @return array
     */
    public static function upload_file($request_file)
    {
        return Import_CSV::upload_file($request_file);
    }

    /**
     * Summary of handle_import_request
     * Process the import request and insert data into the database.
     * @param mixed $request_data
     * @return array
     */
    public static function handle_import_request($request_data)
    {
        $file_path = sanitize_text_field($request_data['file_path'] ?? '');
        $list_id   = uniqid();
        $list_name = sanitize_text_field($request_data['list_name'] ?? '');

        $inserted_count = 0;
        $duplicate_rows = 0;
        $skipped_rows = 0;

        $get_data = Import_CSV::get_import_data($file_path);

        if ( isset($get_data['errors']) && count($get_data['errors']) > 0 ) {
            return [
                'import' => [
                    'errors' => $get_data['errors'],
                ],
                'request_data' => $request_data,
            ];
        }

        if (isset($get_data['data']) 
            && ! empty($get_data['data']) 
            && is_array($get_data['data']) 
            && count($get_data['data']) > 0 
        ) {
            foreach ($get_data['data'] as $row) {
                $email = sanitize_email($row[0]);
                $first_name = sanitize_text_field($row[1] ?? '');
                $last_name = sanitize_text_field($row[2] ?? '');
                $title = sanitize_text_field($row[3] ?? '');
                $salutation = sanitize_text_field($row[4] ?? '');
                $field_01 = sanitize_text_field($row[5] ?? '');
                $field_02 = sanitize_text_field($row[6] ?? '');
                $field_03 = sanitize_text_field($row[7] ?? '');
                $field_04 = sanitize_text_field($row[8] ?? '');
                $field_05 = sanitize_text_field($row[9] ?? '');
                $subscribed = sanitize_text_field($row[10] ?? 1);
                $user_id  = get_current_user_id();

                $has_duplicate = false;
                // Check for duplicate email
                if (External_List_Model::email_exists($email)) {
                    $duplicate_rows++;
                    $has_duplicate = true;
                }

                if ( ! $has_duplicate) {
                    // Insert into database
                    $data = [
                        'list_id'    => $list_id,
                        'user_id'    => $user_id,
                        'email'      => $email,
                        'first_name' => $first_name,
                        'last_name'  => $last_name,
                        'title'      => $title,
                        'salutation' => $salutation,
                        'field_01'   => $field_01,
                        'field_02'   => $field_02,
                        'field_03'   => $field_03,
                        'field_04'   => $field_04,
                        'field_05'   => $field_05,
                        'subscribed' => $subscribed,
                    ];

                    $result = External_List_Model::insert_data($data);
                    if ($result === false) {
                        $get_data['errors'][] = "Failed to insert record for email: $email";
                    } else {
                        $inserted_count++;

                        $get_data['inserted_count'] = $inserted_count;
                    }
                }

                $get_data['duplicate_rows'] = $duplicate_rows;
                $get_data['skipped_rows'] = $skipped_rows;
            }

            if ($list_name && $inserted_count > 0) {
                // Insert metadata
                $meta_data = [
                    'user_id'   => get_current_user_id(),
                    'list_id'   => $list_id,
                    'list_name' => $list_name,
                    'count'     => $inserted_count,
                ];
                External_List_Model::insert_metadata($meta_data);
            }
        }
        return [
            'list_id' => $list_id,
            'list_name' => $list_name,
            'inserted_count' => $inserted_count,
            'duplicate_rows' => $duplicate_rows,
            'skipped_rows' => $skipped_rows,
            'errors' => $get_data['errors'] ?? [],
        ];
    }

    /**
     * Summary of ajax_mock_chunk_process
     * Mock the processing of a CSV chunk for testing purposes.
     * @return void
     */
    public static function ajax_mock_chunk_process()
    {
        if ( !isset($_POST['nonce']) && !wp_verify_nonce( $_POST['nonce'], 'sue_external_lists_import' ) ) {
            wp_die(__('Security check failed.', 'external-lists'));
        }

        $chunk_index = intval($_POST['chunk_index']);
        $total_chunks = intval($_POST['total_chunks']);

        // Define the minimum and maximum sleep duration in microseconds
        $minMicroseconds = 100000; // 0.1 seconds
        $maxMicroseconds = 500000; // 0.5 seconds
        
        // Generate a random number of microseconds within the defined range
        $randomMicroseconds = mt_rand($minMicroseconds, $maxMicroseconds);
        
        // Simulate processing time
        usleep($randomMicroseconds); // Random delay between 0.1 and 0.5 seconds    

        // Simulate inserted rows per chunk
        $inserted = rand(10, 50);

        wp_send_json_success([
            'inserted' => $inserted,
            'chunk_index' => $chunk_index,
            'total_chunks' => $total_chunks
        ]);
    }
}