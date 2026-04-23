<?php
/**
 * Summary of Queue Meta Schema
 * Use this class to create database tables for Queue Meta feature.
 */
class Queue_Meta_Schema    
{
    /**
     * Summary of init
     * Initializes the database schema for external lists.
     * @return void
     */
    public static function init()
    {
        // Initialization code if needed
        self::create_table();
    }

    /**
     * Summary of get_table_name
     * Get the name of the external list table.
     * @return string
     */
    public static function get_table_name()
    {
        global $wpdb;
        return $wpdb->prefix . 'sue_queue_meta';
    }

    /**
     * Summary of create_table_external_list
     * Creates the database table for storing external list entries.
     * @return void
     */
    private static function create_table()
    {
        global $wpdb;
        $table_name = self::get_table_name();

        $charset_collate = $wpdb->get_charset_collate();
        
        // Table for CSV rows
        $sql_rows = "CREATE TABLE $table_name (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            sue_email_id BIGINT UNSIGNED NOT NULL,
            title VARCHAR(255) DEFAULT '',
            tagline VARCHAR(255) DEFAULT '',
            send_to_unsubscribed_users TINYINT(1) DEFAULT 0,
            created_at DATETIME NOT NULL,
            PRIMARY KEY (id),
            KEY sue_email_id (sue_email_id)
        ) $charset_collate;";

        dbDelta($sql_rows);
    }
}