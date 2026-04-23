<div class="sue-pro-wrap">

    <!-- Header -->
    <div class="sue-pro-header">
        <h2><?php 
esc_attr_e( 'Dashboard', 'send-users-email' );
?></h2>
        <p><?php 
esc_attr_e( 'An overview of your site\'s users and email activity.', 'send-users-email' );
?></p>
    </div>

    <div class="sue-dashboard-section sue-dashboard-section-stats" aria-labelledby="sue-dashboard-stats-title">
        <div class="sue-dashboard-section-header">
            <h3 id="sue-dashboard-stats-title"><?php 
esc_html_e( 'Site statistics', 'send-users-email' );
?></h3>
            <p><?php 
esc_html_e( 'Quick overview of your users and current email activity.', 'send-users-email' );
?></p>
        </div>

        <!-- Stats grid -->
        <div class="sue-stats-grid">

        <!-- Total Users -->
        <div class="sue-stat-card">
            <div class="sue-stat-icon icon-green">👤</div>
            <div class="sue-stat-content">
                <span class="sue-stat-label"><?php 
esc_attr_e( 'Total Users', 'send-users-email' );
?></span>
                <span class="sue-stat-value"><?php 
echo esc_html( $users['total_users'] );
?></span>
            </div>
        </div>

        <!-- Roles -->
        <?php 
foreach ( $users['avail_roles'] as $role => $total ) {
    ?>
            <?php 
    if ( $total > 0 ) {
        ?>
                <div class="sue-stat-card">
                    <div class="sue-stat-icon icon-blue">🔑</div>
                    <div class="sue-stat-content">
                        <span class="sue-stat-label"><?php 
        echo esc_attr( ucfirst( str_replace( '_', ' ', $role ) ) );
        ?></span>
                        <span class="sue-stat-value"><?php 
        echo esc_html( $total );
        ?></span>
                    </div>
                </div>
            <?php 
    }
    ?>
        <?php 
}
?>

        <!-- Queued Emails (PRO only) -->
        <?php 
?>

        </div>
    </div>

    <div class="sue-dashboard-section sue-dashboard-section-actions" aria-labelledby="sue-dashboard-actions-title">
        <div class="sue-dashboard-section-header">
            <h3 id="sue-dashboard-actions-title"><?php 
esc_html_e( 'Quick actions', 'send-users-email' );
?></h3>
            <p><?php 
esc_html_e( 'Choose how you want to target recipients and send your message.', 'send-users-email' );
?></p>
        </div>

        <!-- Quick action cards -->
        <div class="sue-pro-grid">

        <a class="sue-feature-card sue-feature-card-link" href="<?php 
echo esc_url( admin_url( 'admin.php?page=send-users-email-users' ) );
?>" aria-label="<?php 
esc_attr_e( 'Send to users', 'send-users-email' );
?>">
            <div class="sue-card-icon icon-blue">👤</div>
            <h3><?php 
esc_attr_e( 'Send to users', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Choose individual WordPress users and send your message directly to the people you want to reach.', 'send-users-email' );
?></p>
        </a>

        <a class="sue-feature-card sue-feature-card-link" href="<?php 
echo esc_url( admin_url( 'admin.php?page=send-users-email-roles' ) );
?>" aria-label="<?php 
esc_attr_e( 'Send to user roles', 'send-users-email' );
?>">
            <div class="sue-card-icon icon-teal">🔑</div>
            <h3><?php 
esc_attr_e( 'Send to user roles', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Select one or multiple WordPress roles and send emails to everyone assigned to those roles in one go.', 'send-users-email' );
?></p>
        </a>

        <?php 
if ( sue_fs()->is__premium_only() && sue_fs()->can_use_premium_code() ) {
    ?>
            <a class="sue-feature-card sue-feature-card-link" href="<?php 
    echo esc_url( admin_url( 'admin.php?page=send-users-email-groups' ) );
    ?>" aria-label="<?php 
    esc_attr_e( 'Send to user groups', 'send-users-email' );
    ?>">
                <div class="sue-card-icon icon-green">👥</div>
                <h3><?php 
    esc_attr_e( 'Send to user groups', 'send-users-email' );
    ?></h3>
                <p><?php 
    esc_attr_e( 'Target users by your saved groups and email all matching members in one action.', 'send-users-email' );
    ?></p>
            </a>

            <a class="sue-feature-card sue-feature-card-link" href="<?php 
    echo esc_url( admin_url( 'admin.php?page=send-users-single-email' ) );
    ?>" aria-label="<?php 
    esc_attr_e( 'Send to external email', 'send-users-email' );
    ?>">
                <div class="sue-card-icon icon-amber">✉️</div>
                <h3><?php 
    esc_attr_e( 'Send to external email', 'send-users-email' );
    ?></h3>
                <p><?php 
    esc_attr_e( 'Send an email to a single address that does not belong to a WordPress user account.', 'send-users-email' );
    ?></p>
            </a>

            <a class="sue-feature-card sue-feature-card-link" href="<?php 
    echo esc_url( admin_url( 'admin.php?page=send-users-email-external-list-page' ) );
    ?>" aria-label="<?php 
    esc_attr_e( 'Send to external List', 'send-users-email' );
    ?>">
                <div class="sue-card-icon icon-slate">📋</div>
                <h3><?php 
    esc_attr_e( 'Send to external List (Beta)', 'send-users-email' );
    ?></h3>
                <p><?php 
    esc_attr_e( 'Choose from your imported external lists and send emails to contacts outside WordPress users.', 'send-users-email' );
    ?></p>
            </a>
        <?php 
}
?>

        </div>
    </div>

    <?php 
?>

    <div class="sue-pro-upgrade-banner" style="margin-top: 32px;">
        <div class="sue-banner-text">
            <h3><?php 
esc_html_e( 'Send Users Email PRO', 'send-users-email' );
?></h3>
            <p><?php 
esc_html_e( 'Unlock templates, queue system, SMTP, user groups & more.', 'send-users-email' );
?></p>
        </div>
        <a class="btn-upgrade" href="<?php 
echo esc_url( sue_fs()->get_upgrade_url() );
?>" role="button">
            <?php 
esc_html_e( 'Upgrade Now', 'send-users-email' );
?>
        </a>
    </div>

    <?php 
?>

    <!-- Support & links (PRO only) -->
    <?php 
?>

    <!-- Sidebar content for free users -->
    <?php 
/* //if ( ! sue_fs()->is__premium_only() || ! sue_fs()->can_use_premium_code() ): ?>

        <?php //require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/donate.php'; ?>

        <div class="sue-about-card">
            <div class="sue-card-icon icon-slate">ℹ️</div>
            <h3><?php esc_attr_e( 'About', 'send-users-email' ); ?></h3>
            <p><?php esc_attr_e( 'Send emails to users by selecting individuals or bulk send by role.', 'send-users-email' ); ?></p>
        </div>

    <?php //else: ?>

        <?php //require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/donate.php'; ?>

    <?php //endif;  */
?>

</div>