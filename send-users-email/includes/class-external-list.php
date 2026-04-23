<?php
/**
 * Summary of External_Lists
 * Class to handle External Lists feature.
 */
class External_Lists
{
    /**
     * Summary of init
     * Initialize the External Lists feature.
     * @return void
     */
    public static function init()
    {
        // Initialization code if needed

        // Handle the post request for CSV import.
        add_action('admin_post_import_external_list', [self::class, 'handle_list_import']);
        add_action('wp_ajax_mock_chunk_process', [Import_User_Service::class, 'ajax_mock_chunk_process']);
        add_action('wp_ajax_process_external_import_chunk', [self::class, 'ajax_handle_import']);
        add_action('wp_ajax_import_external_list', [self::class, 'ajax_handle_upload']);
        add_action('wp_ajax_sue_delete_external_list', [External_List_Delete_Service::class, 'ajax_handle_delete']);
        
        // include necessary files
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-import-csv.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-external-list-schema.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-import-user-service.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-external-list-model.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-external-list-delete-service.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-external-lists-dashboard.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-external-lists-edit.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-bootstrap-pagination.php';

        SUE_External_Lists_Dashboard::init();
        SUE_External_Lists_Edit::init();

        $version = Send_Users_Email_Admin::get_version();
        add_action('admin_enqueue_scripts', function () use ($version) {
            External_Lists::register_scripts($version);
        });
    }

    public static function get_action_name()
    {
        $action_name = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'dashboard';
        return $action_name;
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
            'sue-external-list-upload',
            plugin_dir_url(dirname(__FILE__)) . 'admin/js/external-list-import.js',
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
        wp_enqueue_script('sue-external-list-upload');
    }

    /**
     * Summary of ajax_handle_upload
     * Handle the AJAX request for uploading external list CSV.
     * @return void
     */
    public static function ajax_handle_upload()
    {
        if ( !isset($_POST['sue_external_lists_nonce']) && ! wp_verify_nonce( $_POST['sue_external_lists_nonce'], 'sue_external_lists_import' ) ) {
            wp_send_json_error(['message' => 'Security check failed.']);
        }

        check_admin_referer('sue_external_lists_import', 'sue_external_lists_nonce');

        if (isset($_FILES['external_list_file']) && $_FILES['external_list_file']['error'] === UPLOAD_ERR_OK) {
            $import = Import_CSV::handle_csv_import($_FILES['external_list_file']);

            if(isset($import['errors']) && count($import['errors']) > 0) {
                wp_send_json_error(['message' => 'Import failed.', 'errors' => $import['errors']]);
            }

            wp_send_json_success([
                'message' => 'Upload successful.',
                'import' => $import
            ]);

        } else {
            wp_send_json_error(['message' => 'File upload failed.']);
        }
    }

    /**
     * Summary of ajax_handle_import
     * Handle the AJAX request for importing external lists.
     * @return void
     */
    public static function ajax_handle_import()
    {
        if ( !isset($_POST['nonce']) && !wp_verify_nonce( $_POST['nonce'], 'sue_external_lists_import' ) ) {
            wp_send_json_error(['message' => 'Security check failed.']);
        }

        $current_user_id = get_current_user_id();
        if (!isset($_POST['user_id'])) {
            $_POST['user_id'] = $current_user_id;
        }

        $import_ret = Import_User_Service::handle_import_request($_POST);
        if (isset($import_ret['errors']) && count($import_ret['errors']) > 0) {
            wp_send_json_error(['message' => 'Import failed.', 'errors' => $import_ret['errors']]);
        }

        wp_send_json_success(['message' => 'Import successful.', 'import' => $import_ret]);
    }

    /**
     * Summary of add_submenu_page
     * Add submenu page for External Lists under Send Users Email menu.
     * @return void
     */
    public static function add_submenu_page()
    {
        add_submenu_page(
            'send-users-email',
            __('External Lists (Beta)', 'send-users-email'),
            __('External Lists (Beta)', 'send-users-email'),
            'manage_options',
            'send-users-email-external-lists',
            [self::class, 'render_settings_page'],
        );
    }

    /**
     * Summary of render_settings_page
     * Render the template for this External List.
     * @return void
     */
    public static function render_settings_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'external-lists'));
        }

        $action = self::get_action_name();

        $args = [
            'action' => $action,
        ];

        sue_render_admin_template('admin-external-lists.php', $args);
    }

    /**
     * Summary of handle_list_import
     * Handle the list import from the manual form submission.
     * @return void
     */
    public static function handle_list_import()
    {
        // Implement for the manual form submission if needed
        $upload = Import_CSV::handle_csv_import($_FILES['external_list_file']);
        if (isset($upload['errors']) && count($upload['errors']) > 0) {
            $errors = implode(', ', $upload['errors']);
            wp_redirect(add_query_arg(['page' => 'send-users-email-external-lists', 'errors' => $errors], admin_url('admin.php')));
            exit;
        }
        
        $_POST['file_path'] = $upload['file_path'];
        
        $current_user_id = get_current_user_id();
        if (!isset($_POST['user_id'])) {
            $_POST['user_id'] = $current_user_id;
        }

        $import_list = Import_User_Service::handle_import_request($_POST);
        if ( isset($import_list['import']['errors']) && count($import_list['import']['errors']) > 0 ) {
            $errors = implode(', ', $import_list['import']['errors']);
            wp_redirect(add_query_arg(['page' => 'send-users-email-external-lists', 'errors' => $errors], admin_url('admin.php')));
            exit;
        }

        wp_redirect(add_query_arg(['page' => 'send-users-email-external-lists', 'success' => 'Import successful.'], admin_url('admin.php')));
        exit;
    }

    /**
     * Summary of sue_email_queue_tooltip
     * Filter to change the table head role label.
     * @param string $label
     * @return string
     */    
    public static function sue_email_queue_tooltip($label, $email_data)
    {
        if (isset($email_data->via) && $email_data->via === 'external_list') {
            $label = "&raquo; Send to External List(s): ";
        }
        return $label;
    }
}