<div class="sue-pro-wrap sue-users-single-email-page">

    <div class="sue-pro-header">
        <h2><?php 
esc_html_e( 'Send Email to Single Email Addresses', 'send-users-email' );
?></h2>
        <p><?php 
esc_html_e( 'Quickly send a message to one recipient email address at a time.', 'send-users-email' );
?></p>
    </div>

    <div class="sue-settings-layout sue-users-single-email-layout">

        <div class="sue-settings-main">
            <div class="sue-log-card">
                <div class="sue-log-card-header">
                    <span class="sue-log-card-icon">&#128231;</span>
                    <h3><?php 
esc_html_e( 'Compose Message', 'send-users-email' );
?></h3>
                </div>
                <div class="sue-log-card-body">

                    <?php 
?>

                    <?php 
if ( $total_users > 6000 ) {
    ?>
                        <div class="sue-notice sue-notice-warning" role="alert">
                            <div class="sue-notice-icon">[!]</div>
                            <div class="sue-notice-body">
                                <p class="sue-notice-title"><?php 
    esc_html_e( 'Large user list detected', 'send-users-email' );
    ?></p>
                                <p><?php 
    esc_html_e( 'You have a high number of users in the system, so loading this page may take longer. Please consider using Role Email instead.', 'send-users-email' );
    ?></p>
                            </div>
                        </div>
                    <?php 
}
?>

                    <form action="javascript:void(0)" id="sue-users-single-email-form" method="post">

                        <div class="sue-field-row">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <div class="sue-input-label-row">
                                    <label for="subject"><?php 
esc_html_e( 'Email Subject', 'send-users-email' );
?></label>
                                </div>
                                <input type="text" class="sue-input subject" id="subject" name="subject" maxlength="200"
                                       placeholder="<?php 
esc_attr_e( 'Email subject here.', 'send-users-email' );
?> <?php 
?>">
                            </div>
                        </div>

                        <div class="sue-field-row">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <div class="sue-input-label-row">
                                    <label for="email-recipient"><?php 
esc_html_e( 'Email Recipient', 'send-users-email' );
?></label>
                                </div>
                                <input type="text" class="sue-input email-recipient" id="email-recipient" name="email-recipient" maxlength="100" value=""
                                       placeholder="<?php 
esc_attr_e( 'Recipient email here.', 'send-users-email' );
?>">
                            </div>
                        </div>

                        <div class="sue-field-row sue-field-row-editor">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <div class="sue-input-label-row">
                                    <label for="sue_user_email_message"><?php 
esc_html_e( 'Email Message', 'send-users-email' );
?></label>
                                </div>

                                <?php 
// Initialize RTE
wp_editor( '', 'sue_user_email_message', [
    'textarea_rows' => 15,
] );
?>
                                <div class="message"></div>
                            </div>
                        </div>

                        <input type="hidden" id="_wpnonce" name="_wpnonce"
                               value="<?php 
echo esc_attr( wp_create_nonce( 'sue-email-user' ) );
?>"/>

                        <?php 
?>

                        <div class="sue-field-row sue-field-row-actions">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <div class="sue-users-email-actions">
                                    <button type="submit" id="sue-user-single-email-btn" class="sue-btn sue-btn-primary">
                                        <span class="dashicons dashicons-email"></span>
                                        <?php 
esc_html_e( 'Send Message', 'send-users-email' );
?>
                                    </button>
                                    <div class="spinner-border text-info sue-spinner" role="status">
                                        <span class="visually-hidden"><?php 
esc_html_e( 'Loading...', 'send-users-email' );
?></span>
                                    </div>
                                </div>
                                <div class="progress sue-users-email-progress" style="height: 20px; display: none;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                         role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="sue-settings-sidebar sue-users-single-email-sidebar">

            <?php 
require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/donate.php';
?>

            <?php 
require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/warnings.php';
?>

        </div>

    </div>

    <?php 
require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/toast.php';
?>

</div>