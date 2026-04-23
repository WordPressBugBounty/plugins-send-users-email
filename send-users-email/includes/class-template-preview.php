<?php
class SUE_Template_Preview 
{
    public $template_args;
    
    public function __construct($template_args = []) {
        $this->template_args = $template_args;
    }

    public function get_template_args() {
        return $this->template_args;
    }

    public function get_template_args_by_key($key, $default = null) {
        return isset($this->template_args[$key]) ? $this->template_args[$key] : $default;
    }

    public function is_preview() {
        return $this->get_template_args_by_key('preview', false);
    }

    public function get_email_title() {
        return $this->get_template_args_by_key('title', 'Email Title');
    }

    public function get_email_tagline() {
        return $this->get_template_args_by_key('tagline', 'Tagline lorem ipsum dolor sit amet, consectetur adipiscing elit.');
    }

    public function get_email_logo() {
        return $this->get_template_args_by_key('logo', '');
    }

    public function has_email_logo() {
        return !empty($this->get_email_logo());
    }

    public function display_email_logo() {
        if ($this->has_email_logo()) {
            echo '<img src="' . esc_attr($this->get_email_logo()) . '" alt="Email Logo" class="sue-email-logo" style="max-width: 200px; margin-bottom: 20px;">';
        }
    }

    public function get_email_footer() {
        return $this->get_template_args_by_key('footer', '');
    }

    public function get_email_social_links() {
        return $this->get_template_args_by_key('social', []);
    }

    public function get_email_styles() {
        return $this->get_template_args_by_key('styles', '');
    }

    public function get_email_body() {
        $dummy_body = '<p>'.__('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 'send-users-email').'</p>';
        return $dummy_body;
    }

    public function display_social_links() {
        $socials = $this->get_email_social_links();
        if ( ! empty( $socials ) ) {
            foreach ( Send_Users_Email_Admin::$social as $platform ) {
                if ( isset( $socials[ $platform ] ) ) {
                    if ( ! empty( $socials[ $platform ] ) ) {
                        echo '<a href="' . esc_url_raw( $socials[ $platform ] ) . '" style="text-decoration: none; margin-right: 10px;">';
                            echo '<img src="' . esc_attr( sue_get_asset_url( $platform . '.png' ) ) . '" alt="' . esc_attr($platform) . '" width="35" style="display:inline-block;border-width:0;max-width: 35px;">';
                        echo '</a>';
                    }
                }
            }
        }
    }
}

    