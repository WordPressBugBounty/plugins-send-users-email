<?php
/**
 * Settings Page Template
 *
 * @package Send_Users_Email
 */
$logo                 = isset( $args['logo'] ) ? $args['logo'] : '';
$title                = isset( $args['title'] ) ? $args['title'] : '';
$tagline              = isset( $args['tagline'] ) ? $args['tagline'] : '';
$footer               = isset( $args['footer'] ) ? $args['footer'] : '';
$email_from_name      = isset( $args['email_from_name'] ) ? $args['email_from_name'] : '';
$email_from_address   = isset( $args['email_from_address'] ) ? $args['email_from_address'] : '';
$reply_to_address     = isset( $args['reply_to_address'] ) ? $args['reply_to_address'] : '';
$email_template_style = isset( $args['email_template_style'] ) ? $args['email_template_style'] : '';
$roles                = isset( $args['roles'] ) ? $args['roles'] : [];
$selected_roles       = isset( $args['selected_roles'] ) ? $args['selected_roles'] : [];
$social               = isset( $args['social'] ) ? $args['social'] : [];
?>
<div class="sue-pro-wrap">

    <div class="sue-pro-header">
        <h2><?php esc_html_e( 'Settings', 'send-users-email' ); ?></h2>
        <p><?php esc_html_e( 'Configure email defaults, appearance, sending roles, and SMTP.', 'send-users-email' ); ?></p>
    </div>

    <div class="sue-settings-layout">

        <!-- ── Main form ── -->
        <div class="sue-settings-main">
            <div class="sue-log-card">
                <div class="sue-log-card-header">
                    <span class="sue-log-card-icon">⚙️</span>
                    <h3><?php esc_html_e( 'General', 'send-users-email' ); ?></h3>
                </div>
                <div class="sue-log-card-body">

                    <div class="sue-messages"></div>

                    <form action="javascript:void(0)" id="sue-settings-form" method="post">

                        <!-- Logo URL -->
                        <div class="sue-field-row">
                            <div class="sue-field-label">
                                <label for="logo"><?php esc_html_e( 'Logo URL', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Email header logo URL. Leave blank to omit the logo.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <input type="text" class="sue-input" id="logo" name="logo"
                                       value="<?php echo esc_url_raw( $logo ); ?>"
                                       placeholder="https://example.com/logo.png">
                            </div>
                        </div>

                        <!-- Email Title -->
                        <div class="sue-field-row">
                            <div class="sue-field-label">
                                <label for="title"><?php esc_html_e( 'Email Title', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Shown below the logo in the email header.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <input type="text" class="sue-input" id="title" name="title"
                                       value="<?php echo esc_attr( $title ); ?>"
                                       placeholder="<?php bloginfo( 'name' ); ?>">
                            </div>
                        </div>

                        <!-- Email Tagline -->
                        <div class="sue-field-row">
                            <div class="sue-field-label">
                                <label for="tagline"><?php esc_html_e( 'Email Tagline', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Shown below the email title.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <input type="text" class="sue-input" id="tagline" name="tagline"
                                       value="<?php echo esc_attr( $tagline ); ?>"
                                       placeholder="<?php bloginfo( 'description' ); ?>">
                            </div>
                        </div>

                        <!-- Email Footer -->
                        <div class="sue-field-row">
                            <div class="sue-field-label">
                                <label for="footer"><?php esc_html_e( 'Email Footer', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Footer content appended to all emails. Supports HTML. Use full https:// URLs for best compatibility.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <input type="text" class="sue-input" id="footer" name="footer"
                                       value="<?php echo esc_attr( $footer ); ?>"
                                       placeholder="<?php esc_attr_e( 'Email footer content', 'send-users-email' ); ?>">
                            </div>
                        </div>

                        <!-- From Name -->
                        <div class="sue-field-row">
                            <div class="sue-field-label">
                                <label for="email_from_name"><?php esc_html_e( 'Email From / Reply-To Name', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Name shown as the sender in outgoing emails.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <input type="text" class="sue-input" id="email_from_name" name="email_from_name"
                                       value="<?php echo esc_attr( $email_from_name ); ?>"
                                       placeholder="<?php esc_attr_e( 'Email from name', 'send-users-email' ); ?>">
                            </div>
                        </div>

                        <!-- From Address -->
                        <div class="sue-field-row">
                            <div class="sue-field-label">
                                <label for="email_from_address"><?php esc_html_e( 'Email From Address', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Sender email address used for outgoing emails.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <input type="email" class="sue-input" id="email_from_address" name="email_from_address"
                                       value="<?php echo esc_attr( $email_from_address ); ?>"
                                       placeholder="me@example.net">
                            </div>
                        </div>

                        <!-- Reply-To Address -->
                        <div class="sue-field-row">
                            <div class="sue-field-label">
                                <label for="reply_to_address"><?php esc_html_e( 'Reply-To Address', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Address recipients see when replying to your emails.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <input type="email" class="sue-input" id="reply_to_address" name="reply_to_address"
                                       value="<?php echo esc_attr( $reply_to_address ); ?>"
                                       placeholder="reply@example.net">
                            </div>
                        </div>

                        <!-- Email Template Style -->
                        <div class="sue-field-row">
                            <div class="sue-field-label">
                                <label for="email_template_style"><?php esc_html_e( 'Email Template Style', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Custom CSS applied on top of the default email template styles.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <textarea name="email_template_style" id="email_template_style"
                                          class="sue-textarea" rows="7"
                                          placeholder="body { background-color: #eee; }"><?php echo esc_attr( $email_template_style ); ?></textarea>
                            </div>
                        </div>

                        <!-- Roles -->
                        <div class="sue-field-row">
                            <div class="sue-field-label">
                                <label><?php esc_html_e( 'Roles', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Select roles that can send emails. Administrators always have access.', 'send-users-email' ); ?></p>
                                <p class="sue-form-hint sue-form-hint-danger"><strong><?php esc_html_e( 'Only grant access to trusted roles.', 'send-users-email' ); ?></strong></p>
                            </div>
                            <div class="sue-field-input">
                                <ul class="sue-checkbox-list">
                                    <?php foreach ( $roles as $slug => $name ): ?>
                                        <li>
                                            <label class="sue-checkbox-item" for="role-<?php echo esc_attr( $slug ); ?>">
                                                <input name="email_send_roles[]" type="checkbox"
                                                       value="<?php echo esc_attr( $slug ); ?>"
                                                       id="role-<?php echo esc_attr( $slug ); ?>"
                                                    <?php checked( in_array( $slug, $selected_roles ) ); ?>>
                                                <span><?php echo esc_html( $name ); ?></span>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="sue-field-row">
                            <div class="sue-field-label">
                                <label><?php esc_html_e( 'Social Media', 'send-users-email' ); ?></label>
                                <p class="sue-form-hint"><?php esc_html_e( 'Links to your social media profiles, shown in email footers. Leave blank to omit. Use full URLs.', 'send-users-email' ); ?></p>
                            </div>
                            <div class="sue-field-input">
                                <div class="sue-social-list">
                                    <?php foreach ( Send_Users_Email_Admin::$social as $platform ): ?>
                                        <div class="sue-social-row">
                                            <img src="<?php echo esc_attr( sue_get_asset_url( $platform . '.png' ) ); ?>"
                                                 alt="<?php echo esc_attr( $platform ); ?>"
                                                 title="<?php echo esc_attr( ucfirst( $platform ) ); ?>"
                                                 height="18" class="sue-social-icon">
                                            <input type="text" class="sue-input" id="<?php echo esc_attr( $platform ); ?>"
                                                   name="social[<?php echo esc_attr( $platform ); ?>]"
                                                   value="<?php echo $social[ $platform ] ?? ''; ?>"
                                                   placeholder="<?php echo esc_attr( ucfirst( $platform ) ); ?> URL">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <?php if ( sue_fs()->is__premium_only() && sue_fs()->can_use_premium_code() ): ?>
                            <?php
                            $premium_args = isset( $args['premium_features'] ) ? $args['premium_features'] : [];
                            if ( ! empty( $premium_args ) && is_array( $premium_args ) ) {
                                do_action( 'sue_settings_page_after_fields', $premium_args );
                                $email_outgoing_rate      = $premium_args['email_outgoing_rate'] ?? '';
                                $sent_email_save_for      = $premium_args['sent_email_save_for'] ?? '';
                                $default_add_to_queue     = $premium_args['default_add_to_queue'] ?? '';
                                $default_email_theme      = $premium_args['default_email_theme'] ?? '';
                                $save_email_log_till_days = $premium_args['save_email_log_till_days'] ?? '';
                                $save_smtp_host           = $premium_args['save_smtp_host'] ?? '';
                                $save_smtp_port           = $premium_args['save_smtp_port'] ?? '';
                                $save_smtp_username       = $premium_args['save_smtp_username'] ?? '';
                                $save_smtp_password       = $premium_args['save_smtp_password'] ?? '';
                                $save_smtp_security       = $premium_args['save_smtp_security'] ?? '';
                                $save_smtp_bypass_ssl     = $premium_args['save_smtp_bypass_ssl'] ?? '';
                                $allow_title_tagline      = $premium_args['allow_title_and_tagline'] ?? '';
                            }
                            ?>

                            <!-- ── Section: Global Defaults ── -->
                            <div class="sue-settings-section">
                                <h4><?php esc_html_e( 'Global Default Options', 'send-users-email' ); ?></h4>
                            </div>

                            <!-- Outgoing Email Rate -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="email_outgoing_rate"><?php esc_html_e( 'Outgoing Email Rate', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php echo sprintf(
                                        wp_kses_post( __( 'How many queued emails to send every 5 minutes. <a href="%s" target="_blank">Read the docs</a>.', 'send-users-email' ) ),
                                        'https://sendusersemail.com/docs/how-the-email-queue-works/?utm_source=wp_backend&utm_medium=read_docs&utm_campaign=queue'
                                    ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <input type="number" class="sue-input" id="email_outgoing_rate" name="email_outgoing_rate"
                                           value="<?php echo esc_attr( $email_outgoing_rate ); ?>" placeholder="10">
                                </div>
                            </div>

                            <!-- Delete Sent Emails After -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="sent_email_save_for"><?php esc_html_e( 'Delete Sent Emails After', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'Days to keep sent queued emails. Set to 0 to never delete.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <input type="number" class="sue-input" id="sent_email_save_for" name="sent_email_save_for"
                                           value="<?php echo esc_attr( $sent_email_save_for ); ?>" placeholder="60">
                                </div>
                            </div>

                            <!-- Default Email Theme -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="default_email_theme"><?php esc_html_e( 'Default Email Theme', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'Default color scheme used when sending emails.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <select class="sue-select" id="default_email_theme" name="default_email_theme">
                                        <?php $legacy_themes = [ 'blue', 'green', 'pink', 'purple', 'yellow', 'red' ]; ?>
                                        <?php foreach ( sue_get_email_theme_scheme() as $theme_slug ): ?>
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
                                            <option value="<?php echo esc_attr( $theme_slug ); ?>"
                                                <?php selected( $default_email_theme, $theme_slug ); ?>>
                                                <?php echo esc_html( $theme_label ); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Use Queue by Default -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="default_add_to_queue"><?php esc_html_e( 'Use Queue by Default', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'Automatically queue emails instead of sending immediately. Recommended for high volume.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <ul class="sue-checkbox-list">
                                        <li>
                                            <label class="sue-checkbox-item" for="default_add_to_queue">
                                                <input type="checkbox" name="default_add_to_queue" id="default_add_to_queue"
                                                    <?php checked( $default_add_to_queue, 1 ); ?>>
                                                <span><?php esc_html_e( 'Enable queue by default', 'send-users-email' ); ?></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Days to Keep Email Logs -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="save_email_log_till_days"><?php esc_html_e( 'Days to Keep Email Logs', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'One log file per day. Older logs are deleted automatically. Default: 90 days.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <input type="number" class="sue-input" id="save_email_log_till_days" name="save_email_log_till_days"
                                           value="<?php echo esc_attr( $save_email_log_till_days ); ?>" placeholder="90">
                                </div>
                            </div>

                            <!-- Per-email Title & Tagline -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="default_allow_title_and_tagline"><?php esc_html_e( 'Per-email Title & Tagline', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'When enabled, each send form shows individual title and tagline fields.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <ul class="sue-checkbox-list">
                                        <li>
                                            <label class="sue-checkbox-item" for="default_allow_title_and_tagline">
                                                <input type="checkbox" name="default_allow_title_and_tagline" id="default_allow_title_and_tagline"
                                                    <?php checked( $allow_title_tagline, 1 ); ?>>
                                                <span><?php esc_html_e( 'Enable per-email title and tagline', 'send-users-email' ); ?></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- ── Section: SMTP ── -->
                            <div class="sue-settings-section">
                                <h4><?php esc_html_e( 'SMTP Options', 'send-users-email' ); ?></h4>
                                <p><?php echo sprintf(
                                    wp_kses_post( __( 'Improve deliverability and avoid spam filters. <a href="%s" target="_blank">Read the docs</a>.', 'send-users-email' ) ),
                                    'https://sendusersemail.com/docs/using-an-smtp-server/?utm_source=wp_backend&utm_medium=read_docs&utm_campaign=smtp'
                                ); ?></p>
                            </div>

                            <!-- SMTP Host -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="save_smtp_host"><?php esc_html_e( 'SMTP Host', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'Hostname of your SMTP server.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <input type="text" class="sue-input" id="save_smtp_host" name="save_smtp_host"
                                           value="<?php echo esc_attr( $save_smtp_host ); ?>" placeholder="smtp.example.com">
                                </div>
                            </div>

                            <!-- SMTP Port -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="save_smtp_port"><?php esc_html_e( 'SMTP Port', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'Typically 465 for SSL or 587 for TLS.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <input type="number" class="sue-input" id="save_smtp_port" name="save_smtp_port"
                                           value="<?php echo esc_attr( $save_smtp_port ); ?>" placeholder="587">
                                </div>
                            </div>

                            <!-- SMTP Username -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="save_smtp_username"><?php esc_html_e( 'SMTP Username', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'Usually your email address or a provider-specific username.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <input type="text" class="sue-input" id="save_smtp_username" name="save_smtp_username"
                                           value="<?php echo esc_attr( $save_smtp_username ); ?>" placeholder="user@example.com">
                                </div>
                            </div>

                            <!-- SMTP Password -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="save_smtp_password"><?php esc_html_e( 'SMTP Password', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'Leave blank to keep the currently saved password.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <input type="password" class="sue-input" id="save_smtp_password" name="save_smtp_password"
                                           placeholder="●●●●●●●●●">
                                </div>
                            </div>

                            <!-- SMTP Security -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label><?php esc_html_e( 'SMTP Security', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'Encryption type. Set the port to match your choice.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <ul class="sue-checkbox-list">
                                        <?php foreach ( [ 'none' => 'None', 'ssl' => 'SSL', 'tls' => 'TLS' ] as $val => $label ): ?>
                                            <li>
                                                <label class="sue-checkbox-item" for="smtp_security_<?php echo esc_attr( $val ); ?>">
                                                    <input type="radio" name="save_smtp_security"
                                                           id="smtp_security_<?php echo esc_attr( $val ); ?>"
                                                           value="<?php echo esc_attr( $val ); ?>"
                                                        <?php checked( $save_smtp_security, $val ); ?>>
                                                    <span><?php echo esc_html( $label ); ?></span>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Bypass SSL -->
                            <div class="sue-field-row">
                                <div class="sue-field-label">
                                    <label for="save_smtp_bypass_ssl"><?php esc_html_e( 'Bypass SSL Verification', 'send-users-email' ); ?></label>
                                    <p class="sue-form-hint"><?php esc_html_e( 'For local/containerized environments only. Do not enable on live sites.', 'send-users-email' ); ?></p>
                                </div>
                                <div class="sue-field-input">
                                    <ul class="sue-checkbox-list">
                                        <li>
                                            <label class="sue-checkbox-item" for="save_smtp_bypass_ssl">
                                                <input type="checkbox" id="save_smtp_bypass_ssl" name="save_smtp_bypass_ssl"
                                                    <?php checked( $save_smtp_bypass_ssl, 1 ); ?>>
                                                <span><?php esc_html_e( 'Bypass SSL certificate verification', 'send-users-email' ); ?></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        <?php endif; ?>

                        <!-- ── Save button ── -->
                        <div class="sue-field-row sue-field-row-actions">
                            <div class="sue-field-label">
                                <div class="spinner-border text-info sue-spinner" role="status">
                                    <span class="visually-hidden"><?php esc_html_e( 'Loading...', 'send-users-email' ); ?></span>
                                </div>
                                <input type="hidden" id="_wpnonce" name="_wpnonce"
                                       value="<?php echo esc_attr( wp_create_nonce( 'sue-email-user' ) ); ?>">
                            </div>
                            <div class="sue-field-input">
                                <button type="submit" class="sue-btn sue-btn-primary" id="sue-settings-btn">
                                    <span class="dashicons dashicons-admin-settings"></span>
                                    <?php esc_html_e( 'Save Settings', 'send-users-email' ); ?>
                                </button>
                            </div>
                        </div>

                    </form>

                </div><!-- /sue-log-card-body -->
            </div><!-- /sue-log-card -->
        </div><!-- /sue-settings-main -->

        <!-- ── Sidebar ── -->
        <div class="sue-settings-sidebar">

            <?php require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/donate.php'; ?>

            <div class="sue-notice sue-notice-warning">
                <div class="sue-notice-icon">⚠️</div>
                <div class="sue-notice-body">
                    <p class="sue-notice-title"><?php esc_html_e( 'Caution', 'send-users-email' ); ?></p>
                    <p><?php esc_html_e( '"Email From Name" and "Email From Address" can be overridden by other plugins.', 'send-users-email' ); ?></p>
                    <p><?php esc_html_e( 'If your values are not taking effect, check whether another plugin is overriding them.', 'send-users-email' ); ?></p>
                </div>
            </div>

            <?php if ( sue_fs()->is__premium_only() && sue_fs()->can_use_premium_code() ): ?>
                <div class="sue-sidebar-card">
                    <div class="sue-sidebar-card-header">
                        <span class="sue-sidebar-card-icon">👤</span>
                        <div>
                            <p class="sue-sidebar-card-title"><?php esc_html_e( 'Account', 'send-users-email' ); ?></p>
                            <p class="sue-sidebar-card-desc"><?php esc_html_e( 'Manage your subscription.', 'send-users-email' ); ?></p>
                        </div>
                    </div>
                    <a class="sue-btn sue-btn-primary" style="width:100%;justify-content:center;text-decoration:none;"
                       href="<?php echo esc_url( admin_url( 'admin.php?page=send-users-email-account' ) ); ?>">
                        <?php esc_html_e( 'Go to Account', 'send-users-email' ); ?>
                    </a>
                </div>
            <?php endif; ?>

        </div><!-- /sue-settings-sidebar -->

    </div><!-- /sue-settings-layout -->

    <?php require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/toast.php'; ?>

</div><!-- /sue-pro-wrap -->

