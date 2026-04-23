<div class="sue-pro-wrap sue-users-email-page">

    <div class="sue-pro-header">
        <h2><?php 
esc_html_e( 'Send Email to Selected Users', 'send-users-email' );
?></h2>
        <p><?php 
esc_html_e( 'Compose one message and send it directly to specific users in your site.', 'send-users-email' );
?></p>
    </div>

    <div class="sue-settings-layout sue-users-email-layout">

        <div class="sue-settings-main">
            <div class="sue-log-card">
                <div class="sue-log-card-header">
                    <span class="sue-log-card-icon">✉️</span>
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
                            <div class="sue-notice-icon">⚠️</div>
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

                    <form action="javascript:void(0)" id="sue-users-email-form" method="post">

                        <div class="sue-field-row">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <?php 
$subject_hint = __( 'Add a clear subject so recipients immediately understand the purpose of the message.', 'send-users-email' );
?>
                                <div class="sue-input-label-row">
                                    <label for="subject"><?php 
esc_html_e( 'Email Subject', 'send-users-email' );
?></label>
                                    <button type="button" class="sue-field-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php 
echo esc_attr( $subject_hint );
?>" title="<?php 
echo esc_attr( $subject_hint );
?>" aria-label="<?php 
esc_attr_e( 'Field description', 'send-users-email' );
?>">
                                        <span class="dashicons dashicons-editor-help"></span>
                                    </button>
                                </div>
                                <input type="text" class="sue-input subject" id="subject" name="subject" maxlength="200"
                                       placeholder="<?php 
esc_attr_e( 'Email subject here.', 'send-users-email' );
?> <?php 
?>">
                            </div>
                        </div>

                        <?php 
if ( $allowed_title_tagline && sue_fs()->is__premium_only() && sue_fs()->can_use_premium_code() ) {
    ?>

                            <div class="sue-field-row">
                                <div class="sue-field-label"></div>
                                <div class="sue-field-input">
                                    <div class="sue-input-label-row">
                                        <label for="title"><?php 
    esc_html_e( 'Email Title', 'send-users-email' );
    ?></label>
                                        <button type="button" class="sue-field-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php 
    esc_attr_e( 'Shown as the main heading inside the email template. You can use placeholders on title.', 'send-users-email' );
    ?>" title="<?php 
    esc_attr_e( 'Shown as the main heading inside the email template. You can use placeholders on title.', 'send-users-email' );
    ?>" aria-label="<?php 
    esc_attr_e( 'Field description', 'send-users-email' );
    ?>">
                                            <span class="dashicons dashicons-editor-help"></span>
                                        </button>
                                    </div>
                                    <input type="text" class="sue-input title" id="title" name="title" maxlength="100" value="<?php 
    echo esc_attr( $title );
    ?>"
                                           placeholder="<?php 
    esc_attr_e( 'Email title here.', 'send-users-email' );
    ?> <?php 
    ?>">
                                </div>
                            </div>

                            <div class="sue-field-row">
                                <div class="sue-field-label"></div>
                                <div class="sue-field-input">
                                    <div class="sue-input-label-row">
                                        <label for="tagline"><?php 
    esc_html_e( 'Email Tagline', 'send-users-email' );
    ?></label>
                                        <button type="button" class="sue-field-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php 
    esc_attr_e( 'Optional short subtitle shown below the email title. You can use placeholders on tagline.', 'send-users-email' );
    ?>" title="<?php 
    esc_attr_e( 'Optional short subtitle shown below the email title. You can use placeholders on tagline.', 'send-users-email' );
    ?>" aria-label="<?php 
    esc_attr_e( 'Field description', 'send-users-email' );
    ?>">
                                            <span class="dashicons dashicons-editor-help"></span>
                                        </button>
                                    </div>
                                    <input type="text" class="sue-input tagline" id="tagline" name="tagline" maxlength="100" value="<?php 
    echo esc_attr( $tagline );
    ?>"
                                           placeholder="<?php 
    esc_attr_e( 'Email tagline here.', 'send-users-email' );
    ?> <?php 
    ?>">
                                </div>
                            </div>

                        <?php 
}
?>

                        <div class="sue-field-row sue-users-email-table-row">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <div class="sue-input-label-row">
                                    <label for="sue_users"><?php 
esc_html_e( 'Select Users', 'send-users-email' );
?></label>
                                    <button type="button" class="sue-field-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php 
esc_attr_e( 'Use the ID range filter and table selection to target recipients.', 'send-users-email' );
?>" title="<?php 
esc_attr_e( 'Use the ID range filter and table selection to target recipients.', 'send-users-email' );
?>" aria-label="<?php 
esc_attr_e( 'Field description', 'send-users-email' );
?>">
                                        <span class="dashicons dashicons-editor-help"></span>
                                    </button>
                                </div>
                                <div class="sue-user-email-datatable-wrapper">
                                    <div class="sue-user-email-datatable sue-users-email-datatable-box">
                                        <div class="sue-users-filter-bar">
                                            <p class="sue-users-filter-title"><?php 
esc_html_e( 'Filter users using user ID range', 'send-users-email' );
?></p>
                                            <div class="sue-users-filter-input-group">
                                                <label for="minID"><?php 
esc_html_e( 'Minimum ID', 'send-users-email' );
?></label>
                                                <input class="sue-input" type="text" id="minID" name="minID">
                                            </div>
                                            <div class="sue-users-filter-input-group">
                                                <label for="maxID"><?php 
esc_html_e( 'Maximum ID', 'send-users-email' );
?></label>
                                                <input class="sue-input" type="text" id="maxID" name="maxID">
                                            </div>
                                        </div>

                                        <div class="sue-users-email-table-wrap">
                                            <table id="sue-user-email-tbl" class="table table-striped table-sm sue-table">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="sueSelectAllUsers"></th>
                                                    <th><?php 
esc_html_e( 'ID', 'send-users-email' );
?></th>
                                                    <th><?php 
esc_html_e( 'Username', 'send-users-email' );
?></th>
                                                    <th><?php 
esc_html_e( 'Email', 'send-users-email' );
?></th>
                                                    <th><?php 
esc_html_e( 'Display Name', 'send-users-email' );
?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
foreach ( $blog_users as $user ) {
    ?>
                                                    <tr>
                                                        <td><input type="checkbox" class="sueUserCheck" name="users[]" value="<?php 
    echo esc_html( $user->ID );
    ?>"></td>
                                                        <td><?php 
    echo esc_html( $user->ID );
    ?></td>
                                                        <td><?php 
    echo esc_html( $user->user_login );
    ?></td>
                                                        <td><?php 
    echo esc_html( $user->user_email );
    ?></td>
                                                        <td><?php 
    echo esc_html( $user->display_name );
    ?></td>
                                                    </tr>
                                                <?php 
}
?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sue-field-row sue-field-row-editor">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <div class="sue-input-label-row">
                                    <label for="sue_user_email_message"><?php 
esc_html_e( 'Email Message', 'send-users-email' );
?></label>
                                    <button type="button" class="sue-field-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php 
esc_attr_e( 'Write the full message body. You can use placeholders where supported.', 'send-users-email' );
?>" title="<?php 
esc_attr_e( 'Write the full message body. You can use placeholders where supported.', 'send-users-email' );
?>" aria-label="<?php 
esc_attr_e( 'Field description', 'send-users-email' );
?>">
                                        <span class="dashicons dashicons-editor-help"></span>
                                    </button>
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

                        <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php 
echo esc_attr( wp_create_nonce( 'sue-email-user' ) );
?>"/>

                        <?php 
?>

                        <?php 
?>

                        <div class="sue-field-row sue-field-row-actions">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <div class="sue-users-email-actions">
                                    <button type="submit" id="sue-user-email-btn" class="sue-btn sue-btn-primary">
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
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="sue-settings-sidebar sue-users-email-sidebar">

            <?php 
require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/donate.php';
?>

            <?php 
require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/warnings.php';
?>

            <div class="sue-sidebar-card">
                <div class="sue-sidebar-card-header">
                    <span class="sue-sidebar-card-icon">🔲</span>
                    <div>
                        <p class="sue-sidebar-card-title"><?php 
esc_html_e( 'Hide columns', 'send-users-email' );
?></p>
                        <p class="sue-sidebar-card-desc"><?php 
esc_html_e( 'Toggle which columns are visible in the user table.', 'send-users-email' );
?></p>
                    </div>
                </div>
                <?php 
$columns = [
    1 => 'id',
    2 => 'username',
    3 => 'email',
    4 => 'display_name',
];
?>
                <ul class="sue-checkbox-list">
                    <?php 
foreach ( $columns as $i => $column ) {
    ?>
                        <li>
                            <label class="sue-checkbox-item" for="<?php 
    echo esc_attr( $i . $column );
    ?>">
                                <input data-column="<?php 
    echo esc_attr( $i );
    ?>" class="hideUserColumn" type="checkbox" value="<?php 
    echo esc_attr( $i );
    ?>" id="<?php 
    echo esc_attr( $i . $column );
    ?>">
                                <span><?php 
    echo esc_html( ucwords( str_replace( '_', ' ', $column ) ) );
    ?></span>
                            </label>
                        </li>
                    <?php 
}
?>
                </ul>
            </div>

            <?php 
// Include placeholder instructions
require plugin_dir_path( __FILE__ ) . 'templates/placeholder-instruction.php';
?>

        </div>

    </div>

    <?php 
require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/toast.php';
?>

</div>