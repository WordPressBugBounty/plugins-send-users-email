<?php

$allowed_title_tagline = ( isset( $args['allowed_title_tagline'] ) ? $args['allowed_title_tagline'] : 0 );
$title = ( isset( $args['title'] ) ? $args['title'] : '' );
$tagline = ( isset( $args['tagline'] ) ? $args['tagline'] : '' );
$templates = ( isset( $args['templates'] ) ? $args['templates'] : [] );
$external_lists = ( isset( $args['external_lists'] ) ? $args['external_lists'] : [] );
?>
<div class="sue-pro-wrap sue-external-list-email-page">

    <div class="sue-pro-header">
        <h2><?php 
esc_html_e( 'Send Email to External Lists', 'send-users-email' );
?></h2>
        <p><?php 
esc_html_e( 'Send one message to contacts imported into your external lists.', 'send-users-email' );
?></p>
    </div>

    <div class="sue-settings-layout sue-external-list-email-layout">

        <div class="sue-settings-main">
            <div class="sue-log-card">
                <div class="sue-log-card-header">
                    <span class="sue-log-card-icon">&#127760;</span>
                    <h3><?php 
esc_html_e( 'Compose Message', 'send-users-email' );
?></h3>
                </div>
                <div class="sue-log-card-body">

                    <?php 
require plugin_dir_path( __FILE__ ) . 'templates/email-template-queue.php';
?>

                    <form action="javascript:void(0)" id="sue-external-list-email-form" method="post">

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
esc_attr_e( 'Email subject here. You can use placeholder on subject.', 'send-users-email' );
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
    esc_attr_e( 'Email title here. You can use placeholder on title.', 'send-users-email' );
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
    esc_attr_e( 'Email tagline here. You can use placeholder on tagline.', 'send-users-email' );
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
esc_html_e( 'Select List(s)', 'send-users-email' );
?></label>
                                </div>

                                <?php 
if ( empty( $external_lists ) ) {
    ?>
                                    <div class="sue-notice sue-notice-info" role="alert">
                                        <div class="sue-notice-icon">[i]</div>
                                        <div class="sue-notice-body">
                                            <p class="sue-notice-title"><?php 
    esc_html_e( 'No external lists found', 'send-users-email' );
    ?></p>
                                            <p><?php 
    esc_html_e( 'Please create a list first from the External Lists menu.', 'send-users-email' );
    ?></p>
                                        </div>
                                    </div>
                                <?php 
}
?>

                                <div class="sue-audience-list-columns">
                                    <div class="sue-audience-list-col">
                                        <?php 
$external_lists_count = 0;
?>
                                        <ul class="sue-audience-list">
                                            <?php 
foreach ( $external_lists as $external_list ) {
    ?>
                                                <?php 
    $totalUsers = $external_list->total_users;
    ?>
                                                <?php 
    $total_subscriber = $external_list->subscribed_users;
    ?>
                                                <?php 
    if ( $totalUsers ) {
        ?>
                                                    <?php 
        if ( $external_lists_count % 2 == 0 ) {
            ?>
                                                        <li class="sue-audience-list-item">
                                                            <label class="sue-audience-list-check" for="<?php 
            echo esc_attr( 'external-list-' . $external_list->id );
            ?>">
                                                                <input class="groupCheckbox"
                                                                       name="lists[]"
                                                                       type="checkbox"
                                                                       value="<?php 
            echo esc_attr( $external_list->id );
            ?>"
                                                                       id="<?php 
            echo esc_attr( 'external-list-' . $external_list->id );
            ?>"
                                                                       data-list-id="<?php 
            echo esc_attr( $external_list->list_id );
            ?>">
                                                                <span class="sue-audience-list-label"><?php 
            echo esc_html( ucwords( str_replace( '_', ' ', $external_list->list_name ) ) );
            ?></span>
                                                            </label>
                                                            <span class="sue-audience-list-meta">
                                                                <?php 
            echo esc_html( $totalUsers );
            ?> <?php 
            echo esc_html( _n(
                'user',
                'users',
                $totalUsers,
                'send-users-email'
            ) );
            ?>
                                                                (<?php 
            echo esc_html( $total_subscriber );
            ?> <?php 
            echo esc_html( _n(
                'subscriber',
                'subscribers',
                $total_subscriber,
                'send-users-email'
            ) );
            ?>)
                                                            </span>
                                                        </li>
                                                    <?php 
        }
        ?>
                                                <?php 
    }
    ?>
                                                <?php 
    $external_lists_count++;
    ?>
                                            <?php 
}
?>
                                        </ul>
                                    </div>

                                    <div class="sue-audience-list-col">
                                        <?php 
$external_lists_count = 0;
?>
                                        <ul class="sue-audience-list">
                                            <?php 
foreach ( $external_lists as $external_list ) {
    ?>
                                                <?php 
    $totalUsers = $external_list->total_users;
    ?>
                                                <?php 
    $total_subscriber = $external_list->subscribed_users;
    ?>
                                                <?php 
    if ( $totalUsers ) {
        ?>
                                                    <?php 
        if ( $external_lists_count % 2 == 1 ) {
            ?>
                                                        <li class="sue-audience-list-item">
                                                            <label class="sue-audience-list-check" for="<?php 
            echo esc_attr( 'external-list-' . $external_list->id . '-alt' );
            ?>">
                                                                <input class="groupCheckbox"
                                                                       name="lists[]"
                                                                       type="checkbox"
                                                                       value="<?php 
            echo esc_attr( $external_list->id );
            ?>"
                                                                       id="<?php 
            echo esc_attr( 'external-list-' . $external_list->id . '-alt' );
            ?>"
                                                                       data-list-id="<?php 
            echo esc_attr( $external_list->list_id );
            ?>">
                                                                <span class="sue-audience-list-label"><?php 
            echo esc_html( ucwords( str_replace( '_', ' ', $external_list->list_name ) ) );
            ?></span>
                                                            </label>
                                                            <span class="sue-audience-list-meta">
                                                                <?php 
            echo esc_html( $totalUsers );
            ?> <?php 
            echo esc_html( _n(
                'user',
                'users',
                $totalUsers,
                'send-users-email'
            ) );
            ?>
                                                                (<?php 
            echo esc_html( $total_subscriber );
            ?> <?php 
            echo esc_html( _n(
                'subscriber',
                'subscribers',
                $total_subscriber,
                'send-users-email'
            ) );
            ?>)
                                                            </span>
                                                        </li>

                                                    <?php 
        }
        ?>
                                                <?php 
    }
    ?>
                                                <?php 
    $external_lists_count++;
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

                        <input type="hidden" id="on_queue" name="on_queue" value="0"/>
                        <input type="hidden" id="selected_email_style" name="selected_email_style" value="default"/>
                        <input type="hidden" id="selected_scheduled_date" name="selected_scheduled_date"
                               value="<?php 
echo esc_attr( ( new DateTime() )->format( 'Y-m-d' ) );
?>"/>

                        <?php 
?>

                        <div class="sue-field-row sue-field-row-actions">
                            <div class="sue-field-label"></div>
                            <div class="sue-field-input">
                                <div class="sue-users-email-actions">
                                    <button type="submit" id="sue-external-list-email-btn" class="sue-btn sue-btn-primary">
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

        <div class="sue-settings-sidebar sue-external-list-email-sidebar">
            <?php 
require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/warnings.php';
?>

            <?php 
// Include placeholder instructions
require plugin_dir_path( __FILE__ ) . 'templates/placeholder-external-list-instruction.php';
?>

        </div>

    </div>

    <?php 
require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/toast.php';
?>

</div>
