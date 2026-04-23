<?php
class SUE_Add_WP_User_Group_Column {

    /**
     * Summary of init_hook
     * Initialize Hook
     * @return void
     */
    static public function init_hook() {
        add_filter( 'manage_users_columns', [ self::class, 'add_email_group_name_column' ] );
        add_action( 'manage_users_custom_column', [ self::class, 'show_email_group_name_column_data' ], 10, 3 );
    }

    /**
     * Summary of add_email_group_name_column
     * Add column in user table.
     * @param mixed $columns
     */
    static public function add_email_group_name_column( $columns ) {
        $columns['sue_email_group_name'] = esc_html__( 'User Email Group', 'send-users-email' );
        return $columns;
    }

    /**
     * Summary of show_email_group_name_column_data
     * Show or hide column in the screen options.
     * @param mixed $value
     * @param mixed $column_name
     * @param mixed $user_id
     */
    static public function show_email_group_name_column_data( $value, $column_name, $user_id ) {
        if ( 'sue_email_group_name' === $column_name ) {
            $email_group = '';
            $group_name = self::get_user_groups( $user_id );

            if ( ! empty( $group_name ) ) {
                $email_group = $group_name;
            }

            return esc_html( $email_group );
        }
        return $value;
    }

    /**
     * Summary of query_user_group
     * Create a sql query to get the group name per user or all if $user_id is null
     * @param mixed $user_id
     * @return array|object|null
     */
    static public function query_user_group($user_id = null) {
        global $wpdb;

        $str_where = '';
        if (! empty($user_id)) {
            $str_where = 'WHERE ' . $wpdb->prefix . 'users.ID = ' . $user_id;
        }
        $sue_group_user_table = SEND_USERS_EMAIL_GROUP_USER_TABLE;
        $sue_user_group_name_table = SEND_USERS_EMAIL_USER_GROUP_NAME_TABLE;
        $wp_users_table = $wpdb->prefix . 'users';

        $sql_query = "
            SELECT
                GROUP_CONCAT($sue_user_group_name_table.name SEPARATOR ', ') AS user_groups
            FROM $wp_users_table
            RIGHT JOIN $sue_group_user_table
            ON $wp_users_table.ID = $sue_group_user_table.user_id
            LEFT JOIN $sue_user_group_name_table
            ON $sue_group_user_table.group_id = $sue_user_group_name_table.id
            $str_where 
            GROUP BY $wp_users_table.ID
            ORDER BY $sue_user_group_name_table.name ASC
        ";

        return $wpdb->get_results( $sql_query );
    }

    /**
     * Summary of get_user_groups
     * Get user groups by user_id
     * @param mixed $user_id
     */
    static public function get_user_groups($user_id) {
        $results = self::query_user_group($user_id);

        if (! empty($results) && isset($results[0])) {
            return $results[0]->user_groups;
        }

        return '';
    }
}