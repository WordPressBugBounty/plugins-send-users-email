<?php
/**
 * Summary of External_Lists_Schema
 * Use this class to create database tables for External Lists feature.
 */
class External_Lists_Schema
{
    /**
     * Summary of init
     * Initializes the database schema for external lists.
     * @return void
     */
    public static function init()
    {
        // Initialization code if needed
        self::create_table_external_list();
        self::create_table_external_list_meta();
    }

    /**
     * Summary of get_external_list_table_name
     * Get the name of the external list table.
     * @return string
     */
    public static function get_external_list_table_name()
    {
        global $wpdb;
        return $wpdb->prefix . 'sue_external_lists';
    }

    /**
     * Summary of get_external_list_meta_table_name
     * Get the name of the external list meta table.
     * @return string
     */
    public static function get_external_list_meta_table_name()
    {
        global $wpdb;
        return $wpdb->prefix . 'sue_external_list_meta';
    }

    /**
     * Summary of create_table_external_list
     * Creates the database table for storing external list entries.
     * @return void
     */
    private static function create_table_external_list()
    {
        global $wpdb;
        $table_name = self::get_external_list_table_name();

        $charset_collate = $wpdb->get_charset_collate();
        
        // Table for CSV rows
        $sql_rows = "CREATE TABLE $table_name (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            list_id VARCHAR(50) NOT NULL,
            user_id BIGINT UNSIGNED NOT NULL,
            email VARCHAR(255) NOT NULL,
            first_name VARCHAR(100) DEFAULT '',
            last_name VARCHAR(100) DEFAULT '',
            title VARCHAR(100) DEFAULT '',
            salutation VARCHAR(50) DEFAULT '',
            field_01 VARCHAR(255) DEFAULT '',
            field_02 VARCHAR(255) DEFAULT '',
            field_03 VARCHAR(255) DEFAULT '',
            field_04 VARCHAR(255) DEFAULT '',
            field_05 VARCHAR(255) DEFAULT '',
            subscribed TINYINT(1) DEFAULT 1,
            created_at DATETIME NOT NULL,
            PRIMARY KEY (id),
            KEY email (email),
            KEY list_id (list_id)
        ) $charset_collate;";

        dbDelta($sql_rows);
    }

    /**
     * Summary of create_table_external_list_meta
     * Create table for the list_meta.
     * @return void
     */
    private static function create_table_external_list_meta()
    {
        global $wpdb;
        $table_name = self::get_external_list_meta_table_name();

        $charset_collate = $wpdb->get_charset_collate();
        
        // Table for CSV metadata
        
        $sql_meta = "CREATE TABLE $table_name (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                list_id VARCHAR(50) NOT NULL,
                list_name VARCHAR(255) NOT NULL,
                user_id BIGINT UNSIGNED NOT NULL,
                created_at DATETIME NOT NULL,
                count INT UNSIGNED DEFAULT 0,
                PRIMARY KEY (id),
                KEY list_id (list_id)
            ) $charset_collate;";


        dbDelta($sql_meta);
    }
}