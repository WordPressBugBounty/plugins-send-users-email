<?php

/**
 * The core plugin class.
 */
class Send_Users_Email {
    protected $loader;

    protected $plugin_name;

    protected $version;

    /**
     * Define the core functionality of the plugin.
     */
    public function __construct() {
        if ( defined( 'SEND_USERS_EMAIL_VERSION' ) ) {
            $this->version = SEND_USERS_EMAIL_VERSION;
        } else {
            $this->version = '1.5.5';
        }
        $this->plugin_name = 'send-users-email';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-send-users-email-loader.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-send-users-email-i18n.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-send-users-email-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'helpers/cleanup.class.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'helpers/functions.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-admin-notices.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-email-template-data.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-template-data.php';
        $this->loader = new Send_Users_Email_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     */
    private function set_locale() {
        $plugin_i18n = new Send_Users_Email_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all the hooks related to the admin area functionality of the plugin.
     */
    private function define_admin_hooks() {
        $plugin_admin = new Send_Users_Email_Admin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        // Initialize Admin menu
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menu' );
        // User email handler
        $this->loader->add_action( "wp_ajax_sue_user_email_ajax", $plugin_admin, 'handle_ajax_admin_user_email' );
        // User single email handler
        $this->loader->add_action( "wp_ajax_sue_user_single_email_ajax", $plugin_admin, 'handle_ajax_admin_user_single_email' );
        // User email send progress
        $this->loader->add_action( "wp_ajax_sue_email_users_progress", $plugin_admin, 'handle_ajax_email_users_progress' );
        // Role email handler
        $this->loader->add_action( "wp_ajax_sue_role_email_ajax", $plugin_admin, 'handle_ajax_admin_role_email' );
        // Role email send progress
        $this->loader->add_action( "wp_ajax_sue_email_roles_progress", $plugin_admin, 'handle_ajax_email_roles_progress' );
        // Settings ajax handler
        $this->loader->add_action( "wp_ajax_sue_settings_ajax", $plugin_admin, 'handle_ajax_admin_settings' );
        // wp mail log error
        $this->loader->add_action( "wp_mail_failed", $plugin_admin, 'handle_wp_mail_failed_action' );
        // Delete error log request handling
        $this->loader->add_action( 'admin_init', $plugin_admin, 'delete_error_log' );
        // Delete all queued emails
        $this->loader->add_action( 'admin_init', $plugin_admin, 'delete_all_queued_emails' );
        // Email log view request
        $this->loader->add_action( 'wp_ajax_sue_view_email_log_ajax', $plugin_admin, 'handle_ajax_view_email_log' );
        // Check admin capability when plugin initialize
        $this->loader->add_filter( 'init', $plugin_admin, 'check_administrator_capability' );
    }

    /**
     * Run the loader to execute all the hooks with WordPress.
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    public static function wp_kses_wf($html, $allow_scripts = false)
    {
        add_filter('safe_style_css', function ($styles) {
            $styles_wf = array(
                'text-align',
                'margin',
                'color',
                'float',
                'border',
                'background',
                'background-color',
                'border-bottom',
                'border-bottom-color',
                'border-bottom-style',
                'border-bottom-width',
                'border-collapse',
                'border-color',
                'border-left',
                'border-left-color',
                'border-left-style',
                'border-left-width',
                'border-right',
                'border-right-color',
                'border-right-style',
                'border-right-width',
                'border-spacing',
                'border-style',
                'border-top',
                'border-top-color',
                'border-top-style',
                'border-top-width',
                'border-width',
                'caption-side',
                'clear',
                'cursor',
                'direction',
                'font',
                'font-family',
                'font-size',
                'font-style',
                'font-variant',
                'font-weight',
                'height',
                'letter-spacing',
                'line-height',
                'margin-bottom',
                'margin-left',
                'margin-right',
                'margin-top',
                'overflow',
                'padding',
                'padding-bottom',
                'padding-left',
                'padding-right',
                'padding-top',
                'text-decoration',
                'text-indent',
                'vertical-align',
                'width',
                'display',
            );

            foreach ($styles_wf as $style_wf) {
                $styles[] = $style_wf;
            }
            return $styles;
        });

        $allowed_tags = wp_kses_allowed_html('post');
        $allowed_tags['input'] = array(
            'type' => true,
            'style' => true,
            'class' => true,
            'id' => true,
            'checked' => true,
            'disabled' => true,
            'name' => true,
            'size' => true,
            'placeholder' => true,
            'value' => true,
            'data-*' => true,
            'size' => true,
            'disabled' => true
        );

        $allowed_tags['textarea'] = array(
            'type' => true,
            'style' => true,
            'class' => true,
            'id' => true,
            'checked' => true,
            'disabled' => true,
            'name' => true,
            'size' => true,
            'placeholder' => true,
            'value' => true,
            'data-*' => true,
            'cols' => true,
            'rows' => true,
            'disabled' => true,
            'autocomplete' => true
        );

        $allowed_tags['select'] = array(
            'type' => true,
            'style' => true,
            'class' => true,
            'id' => true,
            'checked' => true,
            'disabled' => true,
            'name' => true,
            'size' => true,
            'placeholder' => true,
            'value' => true,
            'data-*' => true,
            'multiple' => true,
            'disabled' => true
        );

        $allowed_tags['option'] = array(
            'type' => true,
            'style' => true,
            'class' => true,
            'id' => true,
            'checked' => true,
            'disabled' => true,
            'name' => true,
            'size' => true,
            'placeholder' => true,
            'value' => true,
            'selected' => true,
            'data-*' => true
        );
        $allowed_tags['optgroup'] = array(
            'type' => true,
            'style' => true,
            'class' => true,
            'id' => true,
            'checked' => true,
            'disabled' => true,
            'name' => true,
            'size' => true,
            'placeholder' => true,
            'value' => true,
            'selected' => true,
            'data-*' => true,
            'label' => true
        );

        $allowed_tags['a'] = array(
            'href' => true,
            'data-*' => true,
            'class' => true,
            'style' => true,
            'id' => true,
            'target' => true,
            'data-*' => true,
            'role' => true,
            'aria-controls' => true,
            'aria-selected' => true,
            'disabled' => true
        );

        $allowed_tags['div'] = array(
            'style' => true,
            'class' => true,
            'id' => true,
            'data-*' => true,
            'role' => true,
            'aria-labelledby' => true,
            'value' => true,
            'aria-modal' => true,
            'tabindex' => true
        );

        $allowed_tags['li'] = array(
            'style' => true,
            'class' => true,
            'id' => true,
            'data-*' => true,
            'role' => true,
            'aria-labelledby' => true,
            'value' => true,
            'aria-modal' => true,
            'tabindex' => true
        );

        $allowed_tags['span'] = array(
            'style' => true,
            'class' => true,
            'id' => true,
            'data-*' => true,
            'aria-hidden' => true
        );

        $allowed_tags['style'] = array(
            'class' => true,
            'id' => true,
            'type' => true
        );

        $allowed_tags['fieldset'] = array(
            'class' => true,
            'id' => true,
            'type' => true
        );

        $allowed_tags['link'] = array(
            'class' => true,
            'id' => true,
            'type' => true,
            'rel' => true,
            'href' => true,
            'media' => true
        );

        $allowed_tags['form'] = array(
            'style' => true,
            'class' => true,
            'id' => true,
            'method' => true,
            'action' => true,
            'data-*' => true
        );

        if($allow_scripts){
            $allowed_tags['script'] = array(
                'style' => true,
                'class' => true,
                'id' => true,
                'method' => true,
                'action' => true,
                'data-*' => true
            );
        }

        echo wp_kses($html, $allowed_tags);

        add_filter('safe_style_css', function ($styles) {
            $styles_wf = array(
                'text-align',
                'margin',
                'color',
                'float',
                'border',
                'background',
                'background-color',
                'border-bottom',
                'border-bottom-color',
                'border-bottom-style',
                'border-bottom-width',
                'border-collapse',
                'border-color',
                'border-left',
                'border-left-color',
                'border-left-style',
                'border-left-width',
                'border-right',
                'border-right-color',
                'border-right-style',
                'border-right-width',
                'border-spacing',
                'border-style',
                'border-top',
                'border-top-color',
                'border-top-style',
                'border-top-width',
                'border-width',
                'caption-side',
                'clear',
                'cursor',
                'direction',
                'font',
                'font-family',
                'font-size',
                'font-style',
                'font-variant',
                'font-weight',
                'height',
                'letter-spacing',
                'line-height',
                'margin-bottom',
                'margin-left',
                'margin-right',
                'margin-top',
                'overflow',
                'padding',
                'padding-bottom',
                'padding-left',
                'padding-right',
                'padding-top',
                'text-decoration',
                'text-indent',
                'vertical-align',
                'width'
            );

            foreach ($styles_wf as $style_wf) {
                if (($key = array_search($style_wf, $styles)) !== false) {
                    unset($styles[$key]);
                }
            }
            return $styles;
        });
    }
}
