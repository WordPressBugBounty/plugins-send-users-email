<?php
$group_data =  $args['group_data'];
$which = $args['which'];
?>
<div class="alignleft actions">

    <label class="screen-reader-text" for="ute_group_select"><?php echo esc_html__('Remove users from group', 'users-tablenav-extra'); ?></label>

    <select id="sue_wp_user_group_dropdown" class="sue_wp_user_group_dropdown_<?php echo $which;?>" name="sue_wp_user_group_dropdown[]">
        <option value=""><?php esc_html_e( 'Select User Group to Remove', 'send-users-email' ); ?></option>
        <?php foreach ( $group_data as $group ) : ?>
            <option value="<?php echo esc_attr( $group->id ); ?>">
                <?php echo esc_html( $group->name ); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php wp_nonce_field('sue_remove_group', 'sue_remove_group_nonce'); ?>


    <input 
        type="submit" 
        class="button action sue_remove_group_btn_class" 
        name="sue_remove_group_btn" 
        value="<?php echo esc_attr_x('Remove Group', 'Button label', 'send-users-email'); ?>"
        id="sue_remove_group_btn"
    />

</div>
<script>
// jquery load document ready
jQuery(document).ready(function($) {
    // id sue_remove_group_btn
    // Handle remove group button click
    // alert user if no group and no user is selected
    // alert user if no group is selected but users are selected
    // alert user if users are not selected but group is selected

    function sync(from, to) {
        $(from).on('change', function() {
            $(to).val($(this).val());
        });
    }
    
    var top_dropdown = $('.sue_wp_user_group_dropdown_top');
    var bottom_dropdown = $('.sue_wp_user_group_dropdown_bottom');

    function has_selected_users() {
        return $('.users .check-column input[type="checkbox"]:checked').length > 0;
    }

    function has_selected_group() {
        return top_dropdown.val() || bottom_dropdown.val();
    }

    //sync top and bottom dropdown select value
    top_dropdown.on('change', function() {
        bottom_dropdown.val($(this).val());
    });
    bottom_dropdown.on('change', function() {
        top_dropdown.val($(this).val());
    });

    if (top_dropdown.val() && !bottom_dropdown.val()) {
        bottom_dropdown.val(top_dropdown.val());
    } else if (!top_dropdown.val() && bottom_dropdown.val()) {
        top_dropdown.val(bottom_dropdown.val());
    }

    $('.sue_remove_group_btn_class').off('click').on('click', function(e) {
        //get the dropdown select value with bracket as this has two dropdown select and we want to get the value of the one with bracket
        var selected_group = $('.sue_wp_user_group_dropdown_bracket').val();

        if (!has_selected_users() && !has_selected_group()) {
            alert('<?php echo esc_js(__('Please select users and a group to remove.', 'send-users-email')); ?>');
            e.preventDefault();
        } else if (!has_selected_group()) {
            alert('<?php echo esc_js(__('Please select a group to remove.', 'send-users-email')); ?>');
            e.preventDefault();
        } else if (!has_selected_users()) {
            alert('<?php echo esc_js(__('Please select users to remove from the group.', 'send-users-email')); ?>');
            e.preventDefault();
        }
    });
});
</script>