<?php 
$action = $args['action'];
?>

<div class="wrap">
    <div class="container-fluid">
        <div class="row sue-row">

                <?php do_action('sue_before_external_lists_dashboard'); ?>

                <?php do_action('sue_external_lists_' . $action, $action, $args); ?>
        
                <div class="col-sm-3">
                    <?php require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/donate.php'; ?>
                </div>

                <?php require_once SEND_USERS_EMAIL_PLUGIN_BASE_PATH . '/partials/toast.php'; ?>

            </div>
        </div>
    </div>
</div>
