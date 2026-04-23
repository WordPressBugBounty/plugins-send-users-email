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
            <code>{{email}}</code>
            <span><?php esc_html_e( 'Email address', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{first_name}}</code>
            <span><?php esc_html_e( 'First name', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{last_name}}</code>
            <span><?php esc_html_e( 'Last name', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{title}}</code>
            <span><?php esc_html_e( 'Title', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{salutation}}</code>
            <span><?php esc_html_e( 'Salutation', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{field_01}}</code>
            <span><?php esc_html_e( 'Custom field 1', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{field_02}}</code>
            <span><?php esc_html_e( 'Custom field 2', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{field_03}}</code>
            <span><?php esc_html_e( 'Custom field 3', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{field_04}}</code>
            <span><?php esc_html_e( 'Custom field 4', 'send-users-email' ); ?></span>
        </li>
        <li>
            <code>{{field_05}}</code>
            <span><?php esc_html_e( 'Custom field 5', 'send-users-email' ); ?></span>
        </li>
    </ul>
    <div class="sue-messages"></div>
</div>