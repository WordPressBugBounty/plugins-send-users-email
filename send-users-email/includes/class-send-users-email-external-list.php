<?php

class SUE_Email_External_List {
    public static function init_hook() {
    }

    public static function init() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-external-list-admin-ajax.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-send-email-to-external-lists.php';
    }

    public static function add_submenu_page() {
        add_submenu_page(
            'send-users-email',
            __( 'Send to External List (Beta)', 'send-users-email' ),
            __( 'Send to External List (Beta)', 'send-users-email' ),
            'manage_options',
            'send-users-email-external-list-page',
            [self::class, 'render_page']
        );
    }

    public static function render_page( $args = [] ) {
        if ( !current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'send-users-email' ) );
        }
        $templates = [];
        // Get the default Email title and Tagline.
        $options = get_option( 'sue_send_users_email' );
        $title = $options['email_title'] ?? '';
        $tagline = $options['email_tagline'] ?? '';
        $allowed_title_tagline = $options['allow_title_and_tagline'] ?? 0;
        $external_lists = External_List_Model::get_lists_with_counts();
        $defaults = [
            'allowed_title_tagline' => $allowed_title_tagline,
            'title'                 => $title,
            'tagline'               => $tagline,
            'templates'             => $templates,
            'external_lists'        => $external_lists,
        ];
        $args = wp_parse_args( $args, $defaults );
        sue_render_admin_template( 'external-list-email.php', $args );
    }

}
