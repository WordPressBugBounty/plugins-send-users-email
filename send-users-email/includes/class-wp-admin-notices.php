<?php

class SUE_WP_Admin_Notices 
{

    /**
     * Display admin notice
     *
     * @param string $message
     * @param string $type
     */
    public static function display_notice( $message, $type = 'info', $dismissible = true ) {
        $args = [
            'message'     => $message,
            'type'        => $type,
            'dismissible' => $dismissible,
        ];

        require SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/admin/partials/wp-notice.php';
    }
}