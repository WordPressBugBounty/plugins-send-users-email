<div class="col-sm-9 sue-external-lists-main">
    <div class="sue-log-card">
        <div class="sue-log-card-header">
            <span class="sue-log-card-icon">📥</span>
            <h3><?php esc_html_e( 'Import External List', 'send-users-email' ); ?></h3>
        </div>
        <div class="sue-log-card-body">
            <p class="sue-form-hint" style="margin-top:0; margin-bottom:16px;">
                <?php
                printf(
                    /* translators: %s: link to sample CSV */
                    wp_kses_post( __( 'Your CSV file must contain at least one row. %s.', 'send-users-email' ) ),
                    '<a href="https://sendusersemail.com/wp-content/uploads/sue-email-list-sample.csv" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Download a sample CSV', 'send-users-email' ) . '</a>'
                );
                ?>
            </p>

            <?php if ( isset( $_GET['errors'] ) ) : ?>
                <div class="sue-notice sue-notice-warning">
                    <div class="sue-notice-icon">⚠️</div>
                    <div class="sue-notice-body">
                        <p class="sue-notice-title"><?php esc_html_e( 'Import failed', 'send-users-email' ); ?></p>
                        <?php
                        $errors = is_array( $_GET['errors'] ) ? $_GET['errors'] : [ sanitize_text_field( wp_unslash( $_GET['errors'] ) ) ];
                        foreach ( $errors as $error ) :
                            ?>
                            <p><?php echo esc_html( $error ); ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( isset( $_GET['duplicate_rows'] ) && ! empty( $_GET['duplicate_rows'] ) && (int) $_GET['duplicate_rows'] > 0 ) : ?>
                <div class="sue-notice sue-notice-warning">
                    <div class="sue-notice-icon">📄</div>
                    <div class="sue-notice-body">
                        <p class="sue-notice-title"><?php esc_html_e( 'Duplicate rows skipped', 'send-users-email' ); ?></p>
                        <p>
                            <?php
                            /* translators: %d: Number of duplicate rows */
                            printf( esc_html__( '%d duplicate rows were found and skipped during import.', 'send-users-email' ), intval( $_GET['duplicate_rows'] ) );
                            ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( isset( $_GET['list_id'] ) && ! empty( $_GET['list_id'] ) ) : ?>
                <?php
                $list_count = External_List_Model::get_list_count( sanitize_text_field( $_GET['list_id'] ) );
                if ( $list_count === false ) {
                    $list_count = 0;
                }
                ?>
                <?php if ( $list_count > 0 ) : ?>
                    <div class="sue-notice sue-notice-info">
                        <div class="sue-notice-icon">✅</div>
                        <div class="sue-notice-body">
                            <p class="sue-notice-title"><?php esc_html_e( 'Import complete', 'send-users-email' ); ?></p>
                            <p>
                                <?php
                                /* translators: %d: Number of imported emails */
                                printf( esc_html__( 'Import successful! %d emails were added to the external list.', 'send-users-email' ), intval( $list_count ) );
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="sue-externali-list-import-form" enctype="multipart/form-data">
                <input type="hidden" name="action" value="import_external_list">

                <div class="sue-field-row">
                    <div class="sue-field-label">
                        <label for="external_list_name"><?php esc_html_e( 'External List Name', 'send-users-email' ); ?></label>
                        <p class="sue-form-hint"><?php esc_html_e( 'Name for this imported email list.', 'send-users-email' ); ?></p>
                    </div>
                    <div class="sue-field-input">
                        <input type="text" class="sue-input" name="external_list_name" id="external_list_name" required>
                    </div>
                </div>

                <div class="sue-field-row">
                    <div class="sue-field-label">
                        <label for="external_list_file"><?php esc_html_e( 'CSV File', 'send-users-email' ); ?></label>
                        <p class="sue-form-hint"><?php esc_html_e( 'Upload a .csv file containing email addresses.', 'send-users-email' ); ?></p>
                    </div>
                    <div class="sue-field-input">
                        <input type="file" name="external_list_file" id="external_list_file" accept=".csv" required>
                    </div>
                </div>

                <?php wp_nonce_field( 'sue_external_lists_import', 'sue_external_lists_nonce' ); ?>

                <div class="sue-field-row sue-field-row-actions">
                    <div class="sue-field-label"></div>
                    <div class="sue-field-input">
                        <button type="submit" id="sue-user-email-btn-import" class="sue-btn sue-btn-primary">
                            <span class="dashicons dashicons-upload" aria-hidden="true"></span>
                            <?php esc_html_e( 'Import CSV', 'send-users-email' ); ?>
                        </button>
                    </div>
                </div>
            </form>

            <div id="upload-status" class="sue-external-upload-status">
                <div class="sue-progress sue-external-upload-progress-wrap">
                    <div id="progress-bar" class="sue-progress-bar sue-progress-success" style="width:0%;"></div>
                </div>
                <p id="status-text" class="sue-form-hint"></p>
            </div>
        </div>
    </div>

    <div class="sue-log-card">
        <div class="sue-log-card-header">
            <span class="sue-log-card-icon">📋</span>
            <h3><?php esc_html_e( 'External Lists', 'send-users-email' ); ?></h3>
        </div>
        <div class="sue-log-card-body">
            <?php
            $external_lists = External_List_Model::get_lists_with_counts();

            if ( ! empty( $external_lists ) ) : ?>
                <div class="sue-templates-table-wrap">
                    <table class="table table-bordered table-striped sue-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e( 'List ID', 'send-users-email' ); ?></th>
                                <th><?php esc_html_e( 'List Name', 'send-users-email' ); ?></th>
                                <th><?php esc_html_e( 'Total Users', 'send-users-email' ); ?></th>
                                <th><?php esc_html_e( 'Subscribed', 'send-users-email' ); ?></th>
                                <th><?php esc_html_e( 'Actions', 'send-users-email' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $external_lists as $list ) : ?>
                                <tr>
                                    <td><?php echo esc_html( $list->id ); ?></td>
                                    <td><?php echo esc_html( $list->list_name ); ?></td>
                                    <td><?php echo esc_html( $list->total_users ); ?></td>
                                    <td><?php echo esc_html( $list->subscribed_users ); ?></td>
                                    <td class="sue-table-actions">
                                        <button
                                            class="sue-btn sue-btn-danger sue-btn-icon sue-delete-external-list-btn"
                                            data-list-id="<?php echo esc_attr( $list->list_id ); ?>"
                                            data-nonce="<?php echo esc_attr( wp_create_nonce( 'sue_external_lists_delete' ) ); ?>"
                                            type="button"
                                        >
                                            <span class="dashicons dashicons-trash" aria-hidden="true"></span>
                                        </button>
                                        <button
                                            class="sue-btn sue-btn-muted sue-btn-icon sue-edit-external-list-btn"
                                            data-list-id="<?php echo esc_attr( $list->list_id ); ?>"
                                            data-nonce="<?php echo esc_attr( wp_create_nonce( 'sue_external_lists_edit_' . $list->list_id ) ); ?>"
                                            data-url="<?php echo esc_url( admin_url( 'admin.php?page=send-users-email-external-lists&action=edit-lists&list_id=' . $list->list_id ) ); ?>"
                                            type="button"
                                        >
                                            <span class="dashicons dashicons-edit" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="sue-notice sue-notice-info" style="margin-bottom:0;">
                    <div class="sue-notice-icon">📭</div>
                    <div class="sue-notice-body">
                        <p class="sue-notice-title"><?php esc_html_e( 'No lists yet', 'send-users-email' ); ?></p>
                        <p><?php esc_html_e( 'No external lists found. Import your first CSV list above.', 'send-users-email' ); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php External_Lists::enqueue_scripts(); ?>