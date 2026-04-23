<?php

/**
 * Summary of SUE_WP_User_Remove_Group
 * This removes the user in the User Group in the WP User List Page.
 */
class SUE_WP_User_Remove_Group
{
    /**
     * Initialize hooks
     * @return void
     */
    static public function init_hook()
    {
        add_action('manage_users_extra_tablenav', [self::class, 'add_group_delete_field'], 10, 1);
        add_action('load-users.php', [self::class, 'handle_remove_group_action']);
        add_action('admin_notices', [self::class, 'display_removal_notice']);
    }

    /**
     * Show admin notice after user was removed.
     * @return void
     */
    static public function display_removal_notice()
    {
        if (isset($_GET['sue_group_removed'])) {
            $removed_count = intval($_GET['sue_group_removed']);
            
            $notice_type = 'success';
            
            $notice_message = sprintf(
                _n('%d user has been removed from the group.', '%d users have been removed from the group.', $removed_count, 'send-users-email'),
                $removed_count
            );

            $notice_dismissible = true;

            if ($removed_count <= 0) {
                if($_GET['sue_group_removed'] === 'no-users-selected-for-group-removal'){
                    $notice_message = esc_html__('No users were selected for group removal.', 'send-users-email');
                } elseif ($_GET['sue_group_removed'] === 'select-a-group-to-remove'){
                    $notice_message = esc_html__('Please select a user group to remove.', 'send-users-email');
                }
                $notice_type = 'error';
            }

            SUE_WP_Admin_Notices::display_notice(
                $notice_message,
                $notice_type,
                $notice_dismissible
            );
        }
    }

    /**
     * Summary of add_group_delete_field
     * Add the dropdown group both in top and bottom.
     * @param mixed $which
     * @return void
     */
    static public function add_group_delete_field($which)
    {
        if (!current_user_can('edit_users')) {
            return;
        }

        self::show_dropdown_group_field($which);
    }

    /**
     * Add the dropdown group and button to remove user in the selected group.
     * @return void
     */
    static public function show_dropdown_group_field($which)
    {
        $get_groups = SUE_User_Group::query_group();

        if (empty($get_groups)) {
            return;
        }

        $args = [
            'group_data' => $get_groups,
            'which' => $which,
        ];

        require SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/admin/partials/wp-user-group-dropdown.php';
    }

    /**
     * Delete the user in the user group.
     * @return void
     */
    static public function handle_remove_group_action()
    {
        $query_args = [];
       
        if (!isset($_REQUEST['sue_remove_group_btn'])) {
            return;
        }

        if (!isset($_REQUEST['sue_remove_group_nonce']) || !wp_verify_nonce($_REQUEST['sue_remove_group_nonce'], 'sue_remove_group')) {
            wp_die(esc_html__('Security check failed. Please try again.', 'send-users-email'));
        }

        if (!current_user_can('edit_users')) {
            wp_die(esc_html__('You do not have permission to perform this action.', 'send-users-email'));
        }

        if (empty($_REQUEST['sue_wp_user_group_dropdown'])) {
            $query_args['sue_group_removed'] = 'select-a-group-to-remove';
        }

        $group_id = 0;

        if (is_array($_REQUEST['sue_wp_user_group_dropdown']) && !empty($_REQUEST['sue_wp_user_group_dropdown'])) {
            foreach ($_REQUEST['sue_wp_user_group_dropdown'] as $gid) {
                if (!empty($gid)) {
                    $group_id = intval($gid);
                }
            }
        } else {
            $group_id = intval($_REQUEST['sue_wp_user_group_dropdown']);
        }


        if($group_id <= 0){
            $query_args['sue_group_removed'] = 'select-a-group-to-remove';
        }

        $user_ids = isset($_REQUEST['users']) ? array_map('intval', (array)$_REQUEST['users']) : [];

        if (empty($user_ids)) {
            $query_args['sue_group_removed'] = 'no-users-selected-for-group-removal';
        }

        $removed = self::remove_users_from_group($group_id, $user_ids);
        if ( $removed > 0 ){
            // All good
            $query_args['sue_group_removed'] = $removed;
        }

        wp_redirect(add_query_arg($query_args, admin_url('users.php')));
        exit;
    }

    /**
     * Remove the users in the selected group
     * @param mixed $group_id
     * @param mixed $user_ids array of user IDs
     * @return int
     */
    static public function remove_users_from_group($group_id, $user_ids)
    {
        $remove = 0;
        // remove the user from the group user table
        foreach ($user_ids as $user_id) {
            $remove += self::remove_user_from_group($user_id, $group_id);
        }

        return $remove;
    }

    /**
     * Delete the user in the user group directly in database.
     * @param mixed $user_id
     * @param mixed $group_id
     * @return bool|int
     */
    static public function remove_user_from_group($user_id, $group_id)
    {
        global $wpdb;

        $sue_group_user_table = SEND_USERS_EMAIL_GROUP_USER_TABLE;

        // remove the user from the group user table
        return $wpdb->delete(
            $sue_group_user_table,
            [
                'group_id' => (int)$group_id,
                'user_id'  => (int)$user_id,
            ],
            [
                '%d',
                '%d',
            ]
        );
    }
}