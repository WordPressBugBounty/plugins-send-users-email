<?php
/**
 * @var $errorFileSizeMB
 * @var $errorFileMaxSizeLimit
 * @var $emailLogFiles
 * @var $errorLog
 */
?>
<div class="sue-pro-wrap">

    <!-- Page header -->
    <div class="sue-pro-header">
        <h2><?php esc_html_e( 'Email & Error Log', 'send-users-email' ); ?></h2>
        <p><?php esc_html_e( 'Review sent email records and diagnose delivery errors.', 'send-users-email' ); ?></p>
    </div>

    <?php if ( empty( $emailLogFiles ) && empty( $errorLog ) ): ?>
        <div class="sue-notice sue-notice-info">
            <div class="sue-notice-icon">📋</div>
            <div class="sue-notice-body">
                <p class="sue-notice-title"><?php esc_html_e( 'No logs yet', 'send-users-email' ); ?></p>
                <p><?php esc_html_e( 'There are no logs to display right now. Error logs and sent email logs will appear here once available.', 'send-users-email' ); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( ! empty( $emailLogFiles ) ): ?>
        <div class="sue-log-card">
            <div class="sue-log-card-header">
                <span class="sue-log-card-icon">📧</span>
                <h3><?php esc_html_e( 'Email Log', 'send-users-email' ); ?></h3>
            </div>
            <div class="sue-log-card-body">
                <form action="javascript:void(0)" method="post" id="sue-view-email-log">
                    <input type="hidden" id="_wpnonce" name="_wpnonce"
                           value="<?php echo esc_attr( wp_create_nonce( 'sue-email-log-view' ) ); ?>"/>
                    <div class="sue-form-row">
                        <select class="sue-select" aria-label="<?php esc_attr_e( 'Select date to view email log', 'send-users-email' ); ?>"
                                name="sue_view_email_log_file" id="sue_view_email_log_file">
                            <option value="0" selected><?php esc_html_e( 'Select date to view sent email logs', 'send-users-email' ); ?></option>
                            <?php foreach ( $emailLogFiles as $file ): ?>
                                <?php $displayName = ucwords( str_replace( [ '-', '.log' ], ' ', $file ) ); ?>
                                <option value="<?php echo esc_attr( $file ); ?>"><?php echo esc_html( $displayName ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button id="sue-view-log-btn" class="sue-btn sue-btn-primary" type="submit" disabled>
                            <?php esc_html_e( 'View Log', 'send-users-email' ); ?>
                        </button>
                    </div>
                </form>
                <div id="emailLogTextAreaContainer" style="display: none; margin-top: 20px;">
                    <textarea class="sue-textarea" id="email_log_view_area" rows="12" readonly></textarea>
                    <p class="sue-form-hint" id="logFileSize"></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( ! empty( $errorLog ) ): ?>
        <div class="sue-log-card">
            <div class="sue-log-card-header">
                <span class="sue-log-card-icon">🔴</span>
                <h3><?php esc_html_e( 'Error Log', 'send-users-email' ); ?></h3>
                <form action="" method="post" class="sue-log-card-action"
                      onsubmit="return confirm('<?php esc_attr_e( 'Are you sure you want to delete the error log?', 'send-users-email' ); ?>')">
                    <input type="hidden" name="_wpnonce"
                           value="<?php echo esc_attr( wp_create_nonce( 'sue-delete-error-log' ) ); ?>"/>
                    <button class="sue-btn sue-btn-danger" type="submit" name="sue_delete_error_log">
                        <?php esc_html_e( 'Delete Error Log', 'send-users-email' ); ?>
                    </button>
                </form>
            </div>
            <div class="sue-log-card-body">
                <textarea class="sue-textarea" id="error_log" rows="8" readonly><?php echo esc_textarea( $errorLog ); ?></textarea>
                <p class="sue-form-hint">
                    <?php esc_html_e( 'Errors are only logged when the wp_mail() function fails. A successful wp_mail() call does not guarantee delivery — your email provider may still drop the message. Contact your provider if emails are missing despite no errors here.', 'send-users-email' ); ?>
                </p>

                <?php
                $barColor       = 'success';
                $warningMessage = '';
                if ( $errorFileSizeMB > 0.75 * $errorFileMaxSizeLimit ) {
                    $barColor       = 'warning';
                    $warningMessage = __( 'Error log file is getting large. Please consider clearing it soon.', 'send-users-email' );
                }
                if ( $errorFileSizeMB > 0.9 * $errorFileMaxSizeLimit ) {
                    $barColor       = 'danger';
                    $warningMessage = __( 'IMPORTANT! Error log file is very large. Clear it to avoid slow page loads.', 'send-users-email' );
                }
                $barPercent = floor( $errorFileSizeMB * 100 / $errorFileMaxSizeLimit );
                ?>

                <?php if ( $barPercent > 15 ): ?>
                    <div class="sue-progress" role="progressbar"
                         aria-valuenow="<?php echo esc_attr( $barPercent ); ?>" aria-valuemin="0" aria-valuemax="100">
                        <div class="sue-progress-bar sue-progress-<?php echo esc_attr( $barColor ); ?>"
                             style="width: <?php echo esc_attr( $barPercent ); ?>%"></div>
                    </div>
                    <p class="sue-form-hint sue-form-hint-<?php echo esc_attr( $barColor ); ?>">
                        <?php
                        printf(
                            esc_html__( 'Log file size: %s MB.', 'send-users-email' ),
                            esc_html( $errorFileSizeMB )
                        );
                        if ( $warningMessage ) {
                            echo ' ' . esc_html( $warningMessage );
                        }
                        ?>
                    </p>
                <?php endif; ?>

            </div>
        </div>
    <?php endif; ?>

</div>