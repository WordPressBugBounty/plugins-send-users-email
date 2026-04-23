<?php
$style      = isset( $_POST['email_style'] ) ? sanitize_text_field( $_POST['email_style'] ) : 'default';
$themes     = sue_get_email_theme_scheme();
$is_premium = sue_fs()->is__premium_only() && sue_fs()->can_use_premium_code();
if ( ! $is_premium ) {
    $themes = [ 'default' ];
    $style  = 'default';
}
$iframe_url = sue_iframe_template_preview_url( [ 'style' => $style ] );
?>
<style>
    #wpbody,
    #wpcontent {
        background: #f8fafc;
    }
</style>

<div class="sue-pro-wrap sue-preview-page">
    <div class="sue-pro-header">
        <h2><?php esc_html_e( 'Theme Preview', 'send-users-email' ); ?></h2>
        <p><?php esc_html_e( 'Preview your email layout and switch between available themes before sending.', 'send-users-email' ); ?></p>
    </div>

    <div class="sue-settings-layout sue-preview-layout">
        <div class="sue-settings-main">
            <?php if ( $is_premium ): ?>
            <div class="sue-log-card">
                <div class="sue-log-card-header">
                    <span class="sue-log-card-icon">🎨</span>
                    <h3><?php esc_html_e( 'Preview Settings', 'send-users-email' ); ?></h3>
                </div>
                <div class="sue-log-card-body">
                    <form id="emailStyleForm" method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=send-users-email-preview' ) ); ?>">
                        <?php wp_nonce_field( 'template_preview_iframe_action', 'wp_nonce' ); ?>
                        <input type="hidden" name="action" value="template_preview_iframe_action">
                        <input type="hidden" name="path" value="<?php echo defined( 'ABSPATH' ) ? esc_attr( ABSPATH ) : ''; ?>">

                        <div class="sue-field-row sue-preview-selector-row">
                            <div class="sue-field-label">
                                <label for="email_style"><?php esc_html_e( 'Email Theme', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Choose a theme to instantly reload the preview below.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <select class="sue-select sue-preview-select" aria-label="<?php esc_attr_e( 'Select email theme', 'send-users-email' ); ?>" id="email_style" name="email_style">
                                    <?php $legacy_themes = [ 'blue', 'green', 'pink', 'purple', 'yellow', 'red' ]; ?>
                                    <?php foreach ( $themes as $theme_slug ): ?>
                                        <?php
                                        if ( $theme_slug === 'custom' ) {
                                            $theme_label = __( 'Custom HTML Template', 'send-users-email' );
                                        } else {
                                            $theme_label = ucfirst( esc_attr( $theme_slug ) );
                                        }
                                        if ( in_array( $theme_slug, $legacy_themes, true ) ) {
                                            $theme_label .= ' (Legacy)';
                                        }
                                        ?>
                                        <option value="<?php echo esc_attr( $theme_slug ); ?>" <?php selected( $style, $theme_slug ); ?>>
                                            <?php echo esc_html( $theme_label ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <div class="sue-pro-upgrade-banner" style="margin-bottom: 24px;">
                <div class="sue-banner-text">
                    <h3><?php esc_html_e( 'You are using the free version', 'send-users-email' ); ?></h3>
                    <p><?php esc_html_e( 'Upgrade to PRO to preview and use prebuilt templates — or use your own HTML template.', 'send-users-email' ); ?></p>
                </div>
                <a class="btn-upgrade" href="<?php echo esc_url( sue_fs()->get_upgrade_url() ); ?>" role="button">
                    <?php esc_html_e( 'Upgrade to PRO', 'send-users-email' ); ?>
                </a>
            </div>
            <?php endif; ?>

            <div class="sue-log-card">
                <div class="sue-log-card-header">
                    <span class="sue-log-card-icon">👀</span>
                    <h3><?php esc_html_e( 'Email Preview', 'send-users-email' ); ?></h3>
                    <div class="sue-log-card-action">
                        <span class="sue-preview-pill"><?php echo esc_html( ucfirst( $style ) ); ?></span>
                    </div>
                </div>
                <div class="sue-log-card-body">
                    <div class="sue-notice sue-notice-info sue-preview-note">
                        <div class="sue-notice-icon">↻</div>
                        <div class="sue-notice-body">
                            <p class="sue-notice-title"><?php esc_html_e( 'Automatic refresh', 'send-users-email' ); ?></p>
                            <p><?php esc_html_e( 'The preview reloads automatically when you select a different theme.', 'send-users-email' ); ?></p>
                        </div>
                    </div>

                    <div class="sue-preview-frame-wrap">
                        <iframe id="theme-iframe" class="sue-preview-frame" src="<?php echo esc_url( $iframe_url ); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="sue-settings-sidebar sue-preview-sidebar">
            <div class="sue-sidebar-card">
                <div class="sue-sidebar-card-header">
                    <span class="sue-sidebar-card-icon">ℹ️</span>
                    <div>
                        <p class="sue-sidebar-card-title"><?php esc_html_e( 'How to use this preview', 'send-users-email' ); ?></p>
                        <p class="sue-sidebar-card-desc"><?php esc_html_e( 'Switch themes, review the layout, and verify how your content is rendered before sending.', 'send-users-email' ); ?></p>
                    </div>
                </div>

                <div class="sue-notice sue-notice-info sue-preview-note">
                    <div class="sue-notice-icon">💡</div>
                    <div class="sue-notice-body">
                        <p class="sue-notice-title"><?php esc_html_e( 'Preview tip', 'send-users-email' ); ?></p>
                        <p><?php esc_html_e( 'The custom theme uses your saved custom HTML template and the email settings configured in the plugin.', 'send-users-email' ); ?></p>
                    </div>
                </div>
            </div>

            <div class="sue-sidebar-card">
                <div class="sue-sidebar-card-header">
                    <span class="sue-sidebar-card-icon">🧾</span>
                    <div>
                        <p class="sue-sidebar-card-title"><?php esc_html_e( 'Preview details', 'send-users-email' ); ?></p>
                        <p class="sue-sidebar-card-desc"><?php esc_html_e( 'A quick summary of the currently displayed preview.', 'send-users-email' ); ?></p>
                    </div>
                </div>

                <ul class="sue-placeholder-list sue-preview-meta-list">
                    <li>
                        <code><?php echo esc_html( ucfirst( $style ) ); ?></code>
                        <span><?php esc_html_e( 'Selected theme', 'send-users-email' ); ?></span>
                    </li>
                    <li>
                        <code><?php echo esc_html( count( $themes ) ); ?></code>
                        <span><?php esc_html_e( 'Available themes', 'send-users-email' ); ?></span>
                    </li>
                    <li>
                        <code>Live</code>
                        <span><?php esc_html_e( 'Updates immediately after a theme change', 'send-users-email' ); ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    // Register message listener immediately, outside ready(), to avoid race conditions
    window.addEventListener('message', function(e) {
        if (e.data && e.data.type === 'sue_iframe_height') {
            jQuery('#theme-iframe').css('height', e.data.height + 'px');
        }
    });

    jQuery(document).ready(function() {
        jQuery('#email_style').on('change', function() {
            jQuery('#emailStyleForm').submit();
        });
    });
</script>

