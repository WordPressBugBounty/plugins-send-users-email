<?php
class External_List_Model
{
    public static function insert_data($data = [])
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_table_name();

        return $wpdb->insert(
            $table_name,
            [
                'list_id'    => $data['list_id'],
                'user_id'    => $data['user_id'],
                'email'      => $data['email'],
                'first_name' => $data['first_name'] ?? '',
                'last_name'  => $data['last_name'] ?? '',
                'title'      => $data['title'] ?? '',
                'salutation' => $data['salutation'] ?? '',
                'field_01'   => $data['field_01'] ?? '',
                'field_02'   => $data['field_02'] ?? '',
                'field_03'   => $data['field_03'] ?? '',
                'field_04'   => $data['field_04'] ?? '',
                'field_05'   => $data['field_05'] ?? '',
                'subscribed' => $data['subscribed'] ?? 1,
                'created_at' => current_time('mysql'),
            ]
        );
    }

    public static function insert_metadata($data = [])
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_meta_table_name();

        return $wpdb->insert(
            $table_name,
            [
                'user_id'    => $data['user_id'],
                'list_id'    => $data['list_id'] ?? '',
                'list_name'  => $data['list_name'],
                'count'      => $data['count'],
                'created_at' => current_time('mysql'),
            ]
        );
    }

    public static function email_exists($email)
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_table_name();

        $query = $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE email = %s", $email);
        $count = $wpdb->get_var($query);

        return $count > 0;
    }

    public static function get_list_count($list_id)
    {
        global $wpdb;
        
        $table_name = External_Lists_Schema::get_external_list_meta_table_name();
        $sql = "SELECT count FROM $table_name WHERE list_id = %s ORDER BY created_at DESC LIMIT 1";

        $query = $wpdb->prepare($sql, $list_id);
        $count = $wpdb->get_var($query);

        return $count;
    }

    public static function get_all_lists_meta()
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_meta_table_name();

        $query = "SELECT * FROM $table_name ORDER BY created_at DESC";
        $results = $wpdb->get_results($query);

        return $results;
    }

    public static function get_all_lists()
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_table_name();

        $query = "SELECT * FROM $table_name ORDER BY created_at DESC";
        $results = $wpdb->get_results($query);

        return $results;
    }

    /**
     * Summary of get_all_external_lists_by_listid
     * Get all data in external list table
     * Supports pagination using offset and limit.
     * @param mixed $list_id
     * @return void
     */
    public static function get_all_external_lists_by_listid($list_id, $limit = 10, $offset = 0)
    {
        global $wpdb;
        
        $list_table = External_Lists_Schema::get_external_list_table_name();
        // Prepare the SQL query with placeholders for list_id, offset, and limit
        $sql = "SELECT * FROM $list_table WHERE list_id = %s ORDER BY created_at DESC LIMIT %d OFFSET %d";
        // Set the offset and limit values for pagination
        $query = $wpdb->prepare($sql, $list_id, $limit, $offset);
        // Execute the query and retrieve the results
        $results = $wpdb->get_results($query);
        return $results;
    }

    /**
    * Summary of count_total_external_lists_by_listid
    * Count total records in external list table by list_id
    * Supports pagination using offset and limit.
    * @param mixed $list_id
    * @return int
    */
    public static function count_total_external_lists_by_listid($list_id)
    {
        global $wpdb;
        $list_table = External_Lists_Schema::get_external_list_table_name();
        
        $sql = "SELECT COUNT(*) FROM $list_table WHERE list_id = %s";
        $query = $wpdb->prepare($sql, $list_id);
        $count = $wpdb->get_var($query);
        return (int)$count;
    }

    /**
    * Join the two table to get list details along with count
    **/
    public static function get_lists_with_counts()
    {
        global $wpdb;

        $list_table = External_Lists_Schema::get_external_list_table_name();
        $meta_table = External_Lists_Schema::get_external_list_meta_table_name();

        $query = "
            SELECT 
                $meta_table.id,
                $meta_table.list_id,
                $meta_table.list_name,
                COUNT($list_table.id) AS total_users,
                SUM(CASE WHEN $list_table.subscribed = 1 THEN 1 ELSE 0 END) AS subscribed_users,
                SUM(CASE WHEN $list_table.subscribed = 0 THEN 1 ELSE 0 END) AS unsubscribed_users
            FROM $meta_table
            LEFT JOIN $list_table ON $list_table.list_id = $meta_table.list_id
            GROUP BY $meta_table.id, $meta_table.list_id, $meta_table.list_name, $meta_table.created_at
            ORDER BY $meta_table.created_at DESC
        ";

        $results = $wpdb->get_results($query);

        return $results;
    }

    public static function get_lists_by_listid($list_id)
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_meta_table_name();

        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE list_id = %s ORDER BY created_at DESC", $list_id);
        $results = $wpdb->get_results($query);
        
        return $results;
    }

    public static function get_lists_by_id($id)
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_meta_table_name();

        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id);
        $result = $wpdb->get_row($query);

        return $result;
    }

    public static function get_list_meta_query_by_id($id = [])
    {
        global $wpdb;

        $list_table = External_Lists_Schema::get_external_list_table_name();
        $meta_table = External_Lists_Schema::get_external_list_meta_table_name();

        $str_where = '';
        if (!empty($id)) {
            $str_where = 'WHERE ' . $meta_table . '.id IN (' . implode(',', array_map('intval', $id)) . ')';
        }

        $str_query = "
            SELECT
                $list_table.id,
                $list_table.list_id,
                $list_table.email,
                $list_table.first_name,
                $list_table.last_name,
                $list_table.title,
                $list_table.salutation,
                $list_table.field_01,
                $list_table.field_02,
                $list_table.field_03,
                $list_table.field_04,
                $list_table.field_05,
                $list_table.subscribed,
                $meta_table.id as meta_id,
                $meta_table.list_id as meta_list_id
            FROM $meta_table
            LEFT JOIN $list_table ON $list_table.list_id = $meta_table.list_id
            $str_where
        ";

        $results = $wpdb->get_results($str_query);

        return $results;
    }

    public static function get_list_meta_query_by_listid($list_id)
    {
        global $wpdb;

        $list_table = External_Lists_Schema::get_external_list_table_name();
        $meta_table = External_Lists_Schema::get_external_list_meta_table_name();

        		$query = sue_db_prepare("
            SELECT
                $list_table.id,
                $list_table.list_id,
                $list_table.email,
                $list_table.first_name,
                $list_table.last_name,
                $list_table.title,
                $list_table.salutation,
                $list_table.field_01,
                $list_table.field_02,
                $list_table.field_03,
                $list_table.field_04,
                $list_table.field_05,
                $list_table.subscribed,
                $meta_table.id as meta_id,
                $meta_table.list_id as meta_list_id
            FROM $meta_table
            LEFT JOIN $list_table ON $list_table.list_id = $meta_table.list_id
            WHERE $meta_table.list_id = %s
        ", $list_id);

        $results = $wpdb->get_results($query);

        return $results;
    }

    public static function get_list_meta_query_by_email($email)
    {
        global $wpdb;

        $list_table = External_Lists_Schema::get_external_list_table_name();
        $meta_table = External_Lists_Schema::get_external_list_meta_table_name();

        		$query = sue_db_prepare("
            SELECT
                $list_table.id,
                $list_table.list_id,
                $list_table.email,
                $list_table.first_name,
                $list_table.last_name,
                $list_table.title,
                $list_table.salutation,
                $list_table.field_01,
                $list_table.field_02,
                $list_table.field_03,
                $list_table.field_04,
                $list_table.field_05,
                $list_table.subscribed,
                $meta_table.id as meta_id,
                $meta_table.list_id as meta_list_id,
                $meta_table.list_name as meta_list_name
            FROM $meta_table
            LEFT JOIN $list_table ON $list_table.list_id = $meta_table.list_id
            WHERE $list_table.email = %s
        ", $email);

        $results = $wpdb->get_results($query);

        return $results;
    }

    public static function update_list($id, $data = [])
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_table_name();

        $update_data = [];
        $update_format = [];

        foreach ($data as $key => $value) {
            $update_data[$key] = $value;
            $update_format[] = '%s';
        }

        return $wpdb->update(
            $table_name,
            $update_data,
            ['id' => $id],
            $update_format,
            ['%d']
        );
    }

    public static function delete_list($id)
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_table_name();

        return $wpdb->delete(
            $table_name,
            ['id' => $id],
            ['%d']
        );
    }

    public static function delete_list_by_list_id($list_id)
    {
        global $wpdb;

        $table_name = External_Lists_Schema::get_external_list_table_name();

        return $wpdb->delete(
            $table_name,
            ['list_id' => $list_id],
            ['%d']
        );

    }
}