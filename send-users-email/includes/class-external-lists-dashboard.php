<?php
class SUE_External_Lists_Dashboard
{
    public static function init()
    {
        add_action('sue_external_lists_dashboard', [self::class, 'render_dashboard'], 20, 2);
    }

    public static function render_dashboard( $action, $args )
    {
        $template_args = [
            'action' => External_Lists::get_action_name(),
        ];

        sue_render_admin_template('external-lists/dashboard.php', $template_args);
    }
}