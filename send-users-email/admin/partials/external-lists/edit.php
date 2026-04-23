<?php
$lists_data = $args['lists_data'] ?? [];
?>
<style>
#wpfooter{position:relative !important;}
</style>
<div class="col-sm-9 sue-external-lists-main">
    <div class="sue-log-card">
        <div class="sue-log-card-header">
            <span class="sue-log-card-icon">🗂️</span>
            <h3><?php esc_html_e( 'Edit External List', 'send-users-email' ); ?></h3>
        </div>
        <div class="sue-log-card-body">
            <div class="sue-field-row sue-external-edit-search-row">
                <div class="sue-field-label">
                    <label for="external-list-search"><?php esc_html_e( 'Search', 'send-users-email' ); ?></label>
                    <p class="sue-form-hint"><?php esc_html_e( 'Filter entries by email, name, title, salutation, and custom fields.', 'send-users-email' ); ?></p>
                </div>
                <div class="sue-field-input">
                    <input type="search" class="sue-input" id="external-list-search" placeholder="<?php esc_attr_e( 'Type to filter...', 'send-users-email' ); ?>">
                    <div class="sue-form-hint" id="matchCount" aria-live="polite"></div>
                </div>
            </div>

            <?php if (!empty($lists_data)) : ?>
                <div class="sue-templates-table-wrap">
                    <table class="table table-bordered table-striped sue-table" id="external-list-edit-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Email', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('First Name', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('Last Name', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('Title', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('Salutation', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('Field 01', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('Field 02', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('Field 03', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('Field 04', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('Field 05', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('Subscribed', 'send-users-email'); ?></th>
                                <th><?php esc_html_e('Actions', 'send-users-email'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="external-list-edit-table-body">
                            <?php foreach ($lists_data as $list) : $hay = sue_make_haystack($list); ?>
                                <tr data-id="<?php echo esc_attr($list->id); ?>" data-list-id="<?php echo esc_attr($list->list_id); ?>" data-hay="<?php echo esc_attr($hay); ?>">
                                    <td class="email"><?php echo esc_html($list->email); ?></td>
                                    <td class="first_name"><?php echo esc_html($list->first_name); ?></td>
                                    <td class="last_name"><?php echo esc_html($list->last_name); ?></td>
                                    <td class="title"><?php echo esc_html($list->title); ?></td>
                                    <td class="salutation"><?php echo esc_html($list->salutation); ?></td>
                                    <td class="field_01"><?php echo esc_html($list->field_01); ?></td>
                                    <td class="field_02"><?php echo esc_html($list->field_02); ?></td>
                                    <td class="field_03"><?php echo esc_html($list->field_03); ?></td>
                                    <td class="field_04"><?php echo esc_html($list->field_04); ?></td>
                                    <td class="field_05"><?php echo esc_html($list->field_05); ?></td>
                                    <td class="subscribed"><?php echo $list->subscribed ? esc_html__('Yes', 'send-users-email') : esc_html__('No', 'send-users-email'); ?></td>
                                    <td class="actions sue-table-actions">
                                        <button
                                            class="sue-btn sue-btn-danger sue-btn-icon sue-delete-external-list-btn"
                                            data-list-id="<?php echo esc_attr($list->id); ?>"
                                            data-nonce="<?php echo esc_attr( wp_create_nonce( 'sue_external_lists_delete_' . $list->id ) ); ?>"
                                            type="button"
                                        >
                                            <span class="dashicons dashicons-trash" aria-hidden="true"></span>
                                        </button>
                                        <button
                                            class="sue-btn sue-btn-muted sue-btn-icon sue-edit-external-list-btn"
                                            data-list-id="<?php echo esc_attr($list->id); ?>"
                                            data-nonce="<?php echo esc_attr( wp_create_nonce( 'sue_external_lists_edit_' . $list->id ) ); ?>"
                                            data-url="<?php echo esc_url( admin_url() . 'admin.php?page=send-users-email-external-lists&action=edit-lists&list_id=' . $list->id ); ?>"
                                            type="button"
                                        >
                                            <span class="dashicons dashicons-edit" aria-hidden="true"></span>
                                        </button>
                                        <input class="nonce_update_<?php echo esc_attr($list->id); ?>" type="hidden" value="<?php echo esc_attr( wp_create_nonce( 'sue_update_external_list_' . $list->id ) ); ?>">
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
                        <p class="sue-notice-title"><?php esc_html_e('No list entries found', 'send-users-email'); ?></p>
                        <p><?php esc_html_e('There are no records in this list yet.', 'send-users-email'); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="sue-log-card-body" style="padding-top:0;">
            <div class="sue-external-edit-pagination">
                <?php if (isset($args['pagination'])) : ?>
                    <div>
                        <?php echo $args['pagination']; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php SUE_External_Lists_Edit::enqueue_scripts(); ?>