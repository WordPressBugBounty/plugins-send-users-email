<div class="sue-pro-wrap">

    <!-- Header -->
    <div class="sue-pro-header">
        <h2><?php 
esc_attr_e( 'PRO Features', 'send-users-email' );
?></h2>
        <p><?php 
esc_attr_e( 'Everything you need to send professional, well-timed emails at scale.', 'send-users-email' );
?></p>
    </div>

    <!-- Upgrade banner (free users only) -->
    <?php 
?>
        <div class="sue-pro-upgrade-banner" style="margin-bottom:40px;">
            <div class="sue-banner-text">
                <h3><?php 
esc_attr_e( 'Unlock all PRO features', 'send-users-email' );
?></h3>
                <p><?php 
esc_attr_e( 'Queue system, templates, user groups, SMTP, scheduling & more.', 'send-users-email' );
?></p>
            </div>
            <a class="btn-upgrade" href="<?php 
echo esc_url( sue_fs()->get_upgrade_url() );
?>" role="button">
                <?php 
esc_attr_e( 'Upgrade to PRO', 'send-users-email' );
?>
            </a>
        </div>
    <?php 
?>

    <!-- Feature cards -->
    <div class="sue-pro-grid">

        <!-- Queue System -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-blue">⏱</div>
            <span class="sue-tag sue-tag-delivery"><?php 
esc_attr_e( 'Delivery', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'Queue System', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Stay within your provider\'s sending limits automatically. Set a daily cap (e.g. 300/day) and the plugin distributes your emails over time using WordPress cron — no manual work needed.', 'send-users-email' );
?></p>
        </div>

        <!-- SMTP Server -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-cyan">✉</div>
            <span class="sue-tag sue-tag-delivery"><?php 
esc_attr_e( 'Delivery', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'SMTP Server', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Stop landing in spam. Connect your own SMTP server or third-party providers like Mailgun or Brevo for reliable email delivery.', 'send-users-email' );
?></p>
        </div>

        <!-- Email Scheduling -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-amber">📅</div>
            <span class="sue-tag sue-tag-delivery"><?php 
esc_attr_e( 'Delivery', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'Scheduled Sending', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Compose now, send later. Schedule emails to go out at the perfect time for your audience.', 'send-users-email' );
?></p>
        </div>

        <!-- Email Templates -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-purple">📝</div>
            <span class="sue-tag sue-tag-content"><?php 
esc_attr_e( 'Content', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'Email Templates', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Save and reuse email content you send often. No more rewriting the same message from scratch every time.', 'send-users-email' );
?></p>
        </div>

        <!-- Email Styles -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-rose">🎨</div>
            <span class="sue-tag sue-tag-content"><?php 
esc_attr_e( 'Content', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'Email Styles & Themes', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Choose from pre-built, responsive email designs in multiple color schemes — or use your own HTML/CSS templates for full control.', 'send-users-email' );
?></p>
        </div>

        <!-- User Groups -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-green">👥</div>
            <span class="sue-tag sue-tag-audience"><?php 
esc_attr_e( 'Audience', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'User Groups', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Go beyond roles. Create custom groups, add users, and send to entire groups at once — fully compatible with the queue system.', 'send-users-email' );
?></p>
        </div>

        <!-- Placeholders -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-indigo">🏷</div>
            <span class="sue-tag sue-tag-content"><?php 
esc_attr_e( 'Content', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'Placeholders', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Personalize every part of your email with dynamic placeholders — subject line, tagline, title, and body text. Address users by name, role, or any available field.', 'send-users-email' );
?></p>
        </div>

        <!-- Role-based Sending -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-teal">🔑</div>
            <span class="sue-tag sue-tag-audience"><?php 
esc_attr_e( 'Audience', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'Send by User Role', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Target emails to all users with a specific WordPress role — administrators, editors, subscribers, or any custom role.', 'send-users-email' );
?></p>
        </div>

        <!-- External Recipients -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-orange">📨</div>
            <span class="sue-tag sue-tag-audience"><?php 
esc_attr_e( 'Audience', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'External Recipients', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Send emails to any address — no WordPress account required. Reach people outside your site without extra steps.', 'send-users-email' );
?></p>
        </div>

        <!-- CSV Email Lists -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-slate">📄</div>
            <span class="sue-tag sue-tag-audience"><?php 
esc_attr_e( 'Audience', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'CSV Email Lists', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Import external email lists via CSV upload. Use custom fields from your list for personalization and manage everything from the WordPress dashboard.', 'send-users-email' );
?></p>
        </div>

        <!-- Unsubscribe Management -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-rose">🚫</div>
            <span class="sue-tag sue-tag-audience"><?php 
esc_attr_e( 'Audience', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'Unsubscribe Management', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Opt users out of receiving emails directly from their WordPress profile page. A simple checkbox lets you — or the users themselves — control who receives your emails.', 'send-users-email' );
?></p>
        </div>

        <!-- WooCommerce Integration -->
        <div class="sue-feature-card">
            <div class="sue-card-icon icon-purple">🛒</div>
            <span class="sue-tag sue-tag-content"><?php 
esc_attr_e( 'Content', 'send-users-email' );
?></span>
            <h3><?php 
esc_attr_e( 'WooCommerce Email Template', 'send-users-email' );
?></h3>
            <p><?php 
esc_attr_e( 'Use your existing WooCommerce email template for a seamless visual integration. Your marketing emails will look and feel like part of your store\'s branding.', 'send-users-email' );
?></p>
        </div>

    </div>

    <!-- Premium-only: screenshots & tips -->
    <?php 
?>

</div>