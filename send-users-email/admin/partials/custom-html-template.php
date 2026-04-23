<?php
// Check if the file is being accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Template for displaying the custom HTML email template editor.
 * @var $args
 */
$title      = $args['title'];
$data       = $args['data'] ?? [];
$is_default = $args['is_default'] ?? false;
?>

<div class="sue-pro-wrap sue-custom-template-wrap">

    <div class="sue-pro-header">
        <h2><?php echo esc_html( $title ); ?></h2>
        <p><?php esc_html_e( 'Create and save a custom HTML email layout for your campaigns.', 'send-users-email' ); ?></p>
    </div>

    <div class="sue-settings-layout sue-custom-template-layout">

        <div class="sue-settings-main">
            <?php if ( $is_default ): ?>
                <div class="sue-notice sue-notice-info">
                    <div class="sue-notice-icon">🎨</div>
                    <div class="sue-notice-body">
                        <p class="sue-notice-title"><?php esc_html_e( 'Default template active', 'send-users-email' ); ?></p>
                        <p><?php esc_html_e( 'This custom HTML template is currently set as the default email template.', 'send-users-email' ); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="sue-log-card">
                <div class="sue-log-card-header">
                    <span class="sue-log-card-icon">🧩</span>
                    <h3><?php esc_html_e( 'HTML Template Editor', 'send-users-email' ); ?></h3>
                </div>
                <div class="sue-log-card-body">
                    <div class="sue-messages"></div>

                    <form action="javascript:void(0)" id="sue-custom-html-template-form" method="post">
                        <div class="sue-field-row sue-field-row-editor">
                            <div class="sue-field-label">
                                <label for="custom_html_css"><?php esc_html_e( 'Template HTML', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Paste the full HTML for your email layout here. You can include inline CSS and the placeholders shown in the sidebar.', 'send-users-email' ); ?></p>
                                <p class="sue-form-hint"><?php esc_html_e( 'Tip: Save your changes here, then open Theme Preview to verify the output before sending.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <div class="wp-editor-wrap sue-custom-template-editor-wrap">
                                    <textarea id="custom_html_css" name="custom_html_css" rows="20" class="sue-custom-template-editor"><?php echo esc_textarea( $data ); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="sue-field-row sue-field-row-actions">
                            <div class="sue-field-label">
                                <label><?php esc_html_e( 'Save changes', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Your template will be stored in the plugin settings and used whenever the custom theme is selected.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <div class="sue-custom-template-actions">
                                    <div class="spinner-border text-info sue-spinner" role="status">
                                        <span class="visually-hidden"><?php esc_html_e( 'Loading...', 'send-users-email' ); ?></span>
                                    </div>

                                    <button type="submit" class="sue-btn sue-btn-primary" id="sue-custom-html-template-btn">
                                        <span class="dashicons dashicons-saved" aria-hidden="true"></span>
                                        <?php esc_html_e( 'Save Template', 'send-users-email' ); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="sue-settings-sidebar sue-custom-template-sidebar">
            <div class="sue-sidebar-card">
                <div class="sue-sidebar-card-header">
                    <span class="sue-sidebar-card-icon">ℹ️</span>
                    <div>
                        <p class="sue-sidebar-card-title"><?php esc_html_e( 'How it works', 'send-users-email' ); ?></p>
                        <p class="sue-sidebar-card-desc"><?php esc_html_e( 'Build your own layout and insert the placeholders below where dynamic email content should appear.', 'send-users-email' ); ?></p>
                    </div>
                </div>

                <div class="sue-notice sue-notice-info sue-custom-template-note">
                    <div class="sue-notice-icon">💡</div>
                    <div class="sue-notice-body">
                        <p class="sue-notice-title"><?php esc_html_e( 'Recommended workflow', 'send-users-email' ); ?></p>
                        <p><?php esc_html_e( 'Copy HTML from your preferred newsletter builder or a compatible template source, then replace the content areas with the plugin placeholders.', 'send-users-email' ); ?></p>
                        <p><?php esc_html_e( 'After saving, open Theme Preview to confirm that the title, tagline, content, and logo render correctly.', 'send-users-email' ); ?></p>
                    </div>
                </div>
            </div>

            <div class="sue-sidebar-card">
                <div class="sue-sidebar-card-header">
                    <span class="sue-sidebar-card-icon">🏷️</span>
                    <div>
                        <p class="sue-sidebar-card-title"><?php esc_html_e( 'Placeholders', 'send-users-email' ); ?></p>
                        <p class="sue-sidebar-card-desc"><?php esc_html_e( 'Use these placeholders in your HTML to output the email content dynamically.', 'send-users-email' ); ?></p>
                    </div>
                </div>

                <ul class="sue-placeholder-list sue-custom-template-placeholders">
                    <li>
                        <code>{{email_title}}</code>
                        <span><?php esc_html_e( 'Email title from the editor', 'send-users-email' ); ?></span>
                    </li>
                    <li>
                        <code>{{email_tagline}}</code>
                        <span><?php esc_html_e( 'Email tagline from the editor', 'send-users-email' ); ?></span>
                    </li>
                    <li>
                        <code>{{email_content}}</code>
                        <span><?php esc_html_e( 'Main email content from the editor', 'send-users-email' ); ?></span>
                    </li>
                    <li>
                        <code>{{email_logo}}</code>
                        <span><?php esc_html_e( 'Logo URL configured in the settings', 'send-users-email' ); ?></span>
                    </li>
                </ul>
                <div class="sue-messages"></div>
            </div>
        </div>
    </div>
</div>

<?php require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/toast.php'; ?>
