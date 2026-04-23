<?php
class SUE_Group_Filter_WP_User {

    static public function init_hook() {
        add_action( 'views_users', [ self::class, 'custom_filter_list_views' ] );
        add_action( 'pre_get_users', [ self::class, 'filter_sue_user_by_group' ] );
    }

    static public function custom_filter_list_views( $views ) 
    {
        
        if (!is_admin() || !current_user_can('list_users')) {
            return $views;
        }
        
        // Make sure we're on the Users screen.
        $screen = function_exists('get_current_screen') ? get_current_screen() : null;
        if (!$screen || (strpos($screen->id, 'users') === false)) {
            return $views;
        }

        $groups = SUE_User_Group::query_group();

        foreach ( $groups as $group ) {
            $count = $group->total_user_in_group;
            $url = add_query_arg( 'sue_user_group_filter', $group->id, admin_url( 'users.php' ) );
            $views[ 'sue_user_group_' . $group->id ] = '<a href="' . esc_url( $url ) . '">' . esc_html( $group->name ) . ' (' . esc_html( $count ) . ')</a>';
        }

        return $views;
    }

    /**
     * Summary of filter_sue_user_by_group
     * Filter WP User by Group
     * @param mixed $query
     */
    static public function filter_sue_user_by_group( $query ) {
        
        $screen = function_exists('get_current_screen') ? get_current_screen() : null;

        // Ensure we are on the correct admin screen (users list)
        if ( ! is_admin() || ($screen && 'users' !== $screen->id ) ) {
            return;
        }
        
        if ( isset( $_GET['sue_user_group_filter'] ) && ! empty( $_GET['sue_user_group_filter'] ) ) {
            $group_id = intval( $_GET['sue_user_group_filter'] );
            $user_ids = SUE_User_Group::getGroupUsersId( $group_id );
            
            if ( empty( $user_ids ) ) {
                $user_ids = [0]; // No users in this group, so set to an array that will return no results
            }

            $query->set( 'include', $user_ids );
        }
    }
}
