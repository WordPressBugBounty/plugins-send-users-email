<?php if ( ini_get( 'max_execution_time' ) <= 60 ): ?>
    <div class="sue-notice sue-notice-warning" role="alert">
        <div class="sue-notice-icon">⚠️</div>
        <div class="sue-notice-body">
            <p class="sue-notice-title"><?php esc_html_e( 'Performance warning', 'send-users-email' ); ?></p>
            <p><?php
                echo sprintf(
                    /* translators: %d is the PHP max execution time */
                    esc_html__( 'Your PHP max execution time is %d seconds. Please consider increasing this limit if you are trying to send email to lots of users at once.', 'send-users-email' ),
                    esc_html( ini_get( 'max_execution_time' ) )
                );
            ?></p>
            <p><?php esc_html_e( 'Consider sending emails in batches. The "Send to Users" feature lets you filter by ID range, making it easy to split large sends.', 'send-users-email' ); ?></p>
            <?php if ( sue_fs()->is__premium_only() && sue_fs()->can_use_premium_code() ): ?>
                <p class="sue-notice-tip"><?php esc_html_e( '💡 Using the built-in queue system is strongly recommended for high-volume sending.', 'send-users-email' ); ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>