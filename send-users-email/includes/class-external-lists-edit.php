<?php
class SUE_External_Lists_Edit
{
    public static function init()
    {
        add_action('sue_external_lists_edit-lists', [self::class, 'render_template'], 20, 2);
        add_action('wp_ajax_sue_update_external_list', [self::class, 'update_external_list']);
        add_action('wp_ajax_sue_remove_external_list', [self::class, 'delete_external_list']);
        self::register_scripts(Send_Users_Email_Admin::get_version());
    }

    /**
     * Summary of register_scripts
     * Handle the registration of scripts.
     * @param mixed $ver
     * @return void
     */
    public static function register_scripts($ver)
    {
        wp_register_script(
            'sue-external-list-edit',
            plugin_dir_url(dirname(__FILE__)) . 'admin/js/external-list-edit.js',
            ['jquery'],
            $ver,
            true
        );
    }

    /**
     * Summary of enqueue_scripts
     * Enqueue the necessary scripts.
     * @return void
     */
    public static function enqueue_scripts()
    {
        wp_enqueue_script('sue-external-list-edit');
        wp_localize_script('sue-external-list-edit', 'sueExternalListEdit', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('sue_update_external_list'),
            'deleteNonce' => wp_create_nonce('sue_external_lists_delete'),
        ]);
    }

    public static function get_list_id()
    {
        return isset($_GET['list_id']) ? $_GET['list_id'] : 0;
    }

    public static function render_template( $action, $args )
    {
        $get_list_id = self::get_list_id();

        $per_page = 100; // Number of items per page

        $total_items = External_List_Model::count_total_external_lists_by_listid($get_list_id);

        $base_url = add_query_arg([
            'page' => 'send-users-email-external-lists',
            'action' => External_Lists::get_action_name(),
            'list_id' => $get_list_id
        ], admin_url('admin.php'));

        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;

        if($total_items < $per_page){
            $paged = 0; // Reset to first page if total items are less than or equal to items per page
        }

        $get_all_lists = External_List_Model::get_all_external_lists_by_listid($get_list_id, $per_page, $paged);
        
        // get count to display total items of remaining items in pagination
        $remaining_items_count = $total_items - ($paged * $per_page);
        if($remaining_items_count < 0){
            $remaining_items_count = 0; // Ensure remaining items count does not go negative
        }
        //echo $total_items . ' of ' . $remaining_items_count; // Display remaining items count

        $paginator = new Bootstrap_Pagination([
            'total_items' => $total_items,
            'per_page' => $per_page,
            'current_page' => $paged,
            'base_url' => $base_url . '&paged=%#%',
        ]);

        $template_args = [
            'action' => External_Lists::get_action_name(),
            'lists_data' => $get_all_lists,
            'pagination' => $paginator->render(),
        ];

        sue_render_admin_template('external-lists/edit.php', $template_args);
    }

    public static function update_external_list()
    {
        // Handle the AJAX request to update the external list
        
        if ( ! check_ajax_referer('sue_update_external_list', 'security')) {
            wp_send_json_error('Invalid nonce');
        }
        $data = isset($_POST['data']) ? $_POST['data'] : [];
        $list_id = isset($data['id']) ? intval($data['id']) : 0;
        
        if ($list_id <= 0) {
            wp_send_json_error('Invalid list ID');
        }

        $update_data = [
            'email' => isset($data['email']) ? sanitize_email($data['email']) : '',
            'first_name' => isset($data['first_name']) ? sanitize_text_field($data['first_name']) : '',
            'last_name' => isset($data['last_name']) ? sanitize_text_field($data['last_name']) : '',
            'title' => isset($data['title']) ? sanitize_text_field($data['title']) : '',
            'salutation' => isset($data['salutation']) ? sanitize_text_field($data['salutation']) : '',
            'field_01' => isset($data['field_01']) ? sanitize_text_field($data['field_01']) : '',
            'field_02' => isset($data['field_02']) ? sanitize_text_field($data['field_02']) : '',
            'field_03' => isset($data['field_03']) ? sanitize_text_field($data['field_03']) : '',
            'field_04' => isset($data['field_04']) ? sanitize_text_field($data['field_04']) : '',
            'field_05' => isset($data['field_05']) ? sanitize_text_field($data['field_05']) : '',
            'subscribed' => isset($data['subscribed']) ? intval($data['subscribed']) : 0,
        ];

        External_List_Model::update_list($list_id, $update_data);

        $arr_json_send = [
            'success' => true,
            'message' => '',
            'list_id' => $list_id
        ];

        sleep(5);

        wp_send_json_success($arr_json_send);
        
        wp_die();
    }

    public static function delete_external_list()
    {
        $id = isset($_POST['list_id']) ? intval($_POST['list_id']) : 0;

        // Handle the AJAX request to delete the external list
        if ( ! check_ajax_referer('sue_external_lists_delete_' . $id, 'security')) {
            wp_send_json_error('Invalid nonce');
        }
                
        if ($id <= 0) {
            wp_send_json_error('Invalid list ID');
        }

        External_List_Model::delete_list($id);

        $arr_json_send = [
            'success' => true,
            'message' => '',
            'id' => $id
        ];

        wp_send_json_success($arr_json_send);
        
        wp_die();
    }
}