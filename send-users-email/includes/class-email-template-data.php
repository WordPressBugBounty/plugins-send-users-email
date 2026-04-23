<?php
class SUE_Email_Template_Data
{
    public static function get_template_data( $arr_data = [] )
    {
        $preview = $arr_data['preview'] ?? true; // Set a flag to indicate this is a preview
        $options = get_option('sue_send_users_email');

        // Ensure $options is an array before accessing its keys
        if ( ! is_array( $options ) ) {
            $options = [];
        }

        // Use null coalescing operator (??) for default values
        $logo    = $options['logo_url'] ?? SEND_USERS_EMAIL_PLUGIN_BASE_URL . '/assets/sample-logo.png';
        $title   = $options['email_title'] ?? __('This is a preview title', 'send-users-email');
        $tagline = $options['email_tagline'] ?? __('This is a preview tagline', 'send-users-email');
        $footer  = $options['email_footer'] ?? __('Demo Footer Content', 'send-users-email');

        // Handle social links with a default array
        $social = $options['social'] ?? ["facebook" => "#", "instagram" => "#", "linkedin" => "#", "skype" => "#", "tiktok" => "#", "twitter" => "#", "youtube" => "#"];

        // Default email body content
        $email_body = __('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 'send-users-email');

        // Optional styles
        $styles = $options['email_template_style'] ?? '';

        $arg_template_data = [
            'title'      => $title,
            'tagline'    => $tagline,
            'email_body' => $email_body,
            'logo'       => $logo,
            'footer'     => $footer,
            'social'     => $social,
            'styles'     => $styles,
            'preview'    => $preview,
            'style'      => isset($arr_data['style']) ? sanitize_text_field($arr_data['style']) : 'default',
        ];

        $obj_template_data = new SUE_Template_Data($arg_template_data);

        $template_data = [
            'obj_template_data' => $obj_template_data,
        ];

        $style = ( isset( $arr_data['style'] ) ) ? sanitize_text_field( $arr_data['style'] ) : 'default';

        return [
            'template_data' => $template_data,
            'style'         => $style,
        ];
    }
}