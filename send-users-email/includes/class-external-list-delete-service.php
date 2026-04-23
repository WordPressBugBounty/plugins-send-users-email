<?php
class External_List_Delete_Service
{
    /**
     * Summary of delete_by_list_id
     * Delete external list by its ID.
     * Also deletes the external list metadata.
     * @param mixed $id
     * @return void
     */
    public static function delete_by_list_id($list_id)
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_table_name();
        $meta_table_name = External_Lists_Schema::get_external_list_meta_table_name();

        // search and delete the list
        $search_query = External_List_Model::get_list_count( $list_id );

        if ( ! $search_query ) {
            return false; // List not found
        }

        // Delete from external lists table
        $deleted = $wpdb->delete($table_name, ['list_id' => $list_id]);

        // Delete from external lists meta table
        $wpdb->delete($meta_table_name, ['list_id' => $list_id]);

        if ($deleted !== false) {
            return true;
        } else {
            return false;
        }
    }
    public static function ajax_handle_delete()
    {
        // Check nonce for security
        check_ajax_referer('sue_external_lists_delete', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Unauthorized'], 403);
        }

        $list_id = isset($_POST['list_id']) ? sanitize_text_field($_POST['list_id']) : '';

        if ( empty($list_id) ) {
            wp_send_json_error(['message' => 'Invalid List ID'], 200);
        }

        $result = self::delete_by_list_id($list_id);

        if ($result) {
            wp_send_json_success(['message' => 'List deleted successfully']);
        } else {
            wp_send_json_error(['message' => 'Failed to delete list'], 200);
        }
        
    }
}