<div class="sue-pro-wrap sue-roles-email-page">

    <div class="sue-pro-header">
        <h2><?php 
esc_html_e( 'Send Email to Selected Roles', 'send-users-email' );
?></h2>
        <p><?php 
esc_html_e( 'Compose one message and send it to all users in the selected WordPress roles.', 'send-users-email' );
?></p>
    </div>

    <div class="sue-settings-layout sue-roles-email-layout">

        <div class="sue-settings-main">
            <div class="sue-log-card">
                <div class="sue-log-card-header">
                    <span class="sue-log-card-icon">&#128101;</span>
                    <h3><?php 
esc_html_e( 'Compose Message', 'send-users-email' );
?></h3>
                </div>
                <div class="sue-log-card-body">

                    <?php 
?>

                    <form action="javascript:void(0)" id="sue-roles-email-form" method="post">

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
esc_attr_e( 'Email subject here', 'send-users-email' );
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
                                    </div>
                                    <input type="text" class="sue-input title" id="title" name="title" maxlength="200" value="<?php 
    echo esc_attr( $title );
    ?>"
                                           placeholder="<?php 
    esc_attr_e( 'Email title here', 'send-users-email' );
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
                                    </div>
                                    <input type="text" class="sue-input tagline" id="tagline" name="tagline" maxlength="200" value="<?php 
    echo esc_attr( $tagline );
    ?>"
                                           placeholder="<?php 
    esc_attr_e( 'Email tagline here', 'send-users-email' );
    ?> <?php 
    ?>">
                                </div>
                            </div>

                        <?php 
}
?>

                        <div class="sue-field-row">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <div class="sue-input-label-row">
                                    <label><?php 
esc_html_e( 'Select Role(s)', 'send-users-email' );
?></label>
                                </div>
                                <div class="sue-audience-list-columns sue-role-email-list">
                                    <div class="sue-audience-list-col">
                                        <?php 
$roles_count = 0;
?>
                                        <ul class="sue-audience-list">
                                            <?php 
foreach ( $roles as $slug => $user_count ) {
    ?>
                                                <?php 
    if ( $user_count ) {
        ?>
                                                    <?php 
        if ( $roles_count % 2 == 0 ) {
            ?>
                                                        <li class="sue-audience-list-item">
                                                            <label class="sue-audience-list-check" for="<?php 
            echo esc_attr( $slug );
            ?>">
                                                                <input class="roleCheckbox"
                                                                       name="roles[]"
                                                                       type="checkbox"
                                                                       value="<?php 
            echo esc_attr( $slug );
            ?>"
                                                                       id="<?php 
            echo esc_attr( $slug );
            ?>">
                                                                <span class="sue-audience-list-label"><?php 
            echo esc_html( ucwords( str_replace( '_', ' ', $slug ) ) );
            ?></span>
                                                            </label>
                                                            <span class="sue-audience-list-meta"><?php 
            echo esc_html( $user_count );
            ?></span>
                                                        </li>
                                                    <?php 
        }
        ?>
                                                <?php 
    }
    ?>
                                                <?php 
    $roles_count++;
    ?>
                                            <?php 
}
?>
                                        </ul>
                                    </div>

                                    <div class="sue-audience-list-col">
                                        <?php 
$roles_count = 0;
?>
                                        <ul class="sue-audience-list">
                                            <?php 
foreach ( $roles as $slug => $user_count ) {
    ?>
                                                <?php 
    if ( $user_count ) {
        ?>
                                                    <?php 
        if ( $roles_count % 2 == 1 ) {
            ?>
                                                        <li class="sue-audience-list-item">
                                                            <label class="sue-audience-list-check" for="<?php 
            echo esc_attr( $slug . '-alt' );
            ?>">
                                                                <input class="roleCheckbox"
                                                                       name="roles[]"
                                                                       type="checkbox"
                                                                       value="<?php 
            echo esc_attr( $slug );
            ?>"
                                                                       id="<?php 
            echo esc_attr( $slug . '-alt' );
            ?>">
                                                                <span class="sue-audience-list-label"><?php 
            echo esc_html( ucwords( str_replace( '_', ' ', $slug ) ) );
            ?></span>
                                                            </label>
                                                            <span class="sue-audience-list-meta"><?php 
            echo esc_html( $user_count );
            ?></span>
                                                        </li>
                                                    <?php 
        }
        ?>
                                                <?php 
    }
    ?>
                                                <?php 
    $roles_count++;
    ?>
                                            <?php 
}
?>
                                        </ul>
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

                        <?php 
?>

                        <div class="sue-field-row sue-field-row-actions">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <div class="sue-users-email-actions">
                                    <button type="submit" id="sue-roles-email-btn" class="sue-btn sue-btn-primary">
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

        <div class="sue-settings-sidebar sue-roles-email-sidebar">

            <?php 
require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/donate.php';
?>

            <?php 
require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/warnings.php';
?>

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