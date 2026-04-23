<div class="sue-sidebar-card">
    <div class="sue-sidebar-card-header">
        <span class="sue-sidebar-card-icon">🏷️</span>
        <div>
            <p class="sue-sidebar-card-title"><?php esc_html_e( 'Placeholders', 'send-users-email' ); ?></p>
            <p class="sue-sidebar-card-desc"><?php esc_html_e( 'Insert these tags into your email to personalise each message with recipient details.', 'send-users-email' ); ?></p>
        </div>
    </div>
    <ul class="sue-placeholder-list">
        <li>
            <code>{{user_id}}</code>
            <span><?php esc_html_e( 'User ID', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{username}}</code>
            <span><?php esc_html_e( 'Username', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{user_display_name}}</code>
            <span><?php esc_html_e( 'Display name', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{user_first_name}}</code>
            <span><?php esc_html_e( 'First name', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{user_last_name}}</code>
            <span><?php esc_html_e( 'Last name', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{user_email}}</code>
            <span><?php esc_html_e( 'Email address', 'send-users-email' ); ?></span>
        </li>
    </ul>
    <div class="sue-messages"></div>
</div>