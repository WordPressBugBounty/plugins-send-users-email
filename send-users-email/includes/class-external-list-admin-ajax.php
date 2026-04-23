<?php 
class SUE_External_List_Admin_Ajax extends Send_Users_Email_Admin
{
    public function __construct($plugin_name, $version) 
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function get_email_headers()
    {
        return parent::get_email_headers();
    }

    public function email_template($email_body, $style = 'default', $input_request = [])
    {
        return parent::email_template($email_body, $style, $input_request);
    }

    public function replace_placeholder($email_body, $username, $display_name, $first_name, $last_name, $user_email, $user_id)
    {
        return parent::replace_placeholder($email_body, $username, $display_name, $first_name, $last_name, $user_email, $user_id);
    }

    public function send_email(
		$sue_override_user_email_subscription,
		$sue_data = []
	){
        return parent::send_email(
            $sue_override_user_email_subscription,
            $sue_data
        );
    }

    public function send($request_data = [])
    {
        // Implementation for handling AJAX request to send email to external list
        if ( check_admin_referer( 'sue-email-user' ) ) {
            $param  = isset( $request_data['param'] ) ? sanitize_text_field( $request_data['param'] ) : "";
            $action = isset( $request_data['action'] ) ? sanitize_text_field( $request_data['action'] ) : "";

            if ( $param == 'send_email_external_list' && $action == 'sue_external_list_email_ajax' ) {
                
                $ret = SUE_Send_Emails_External_Lists::send_email_to_external_list( $request_data, $this );
                
                if ($ret 
                    && isset($ret['success']) 
                    && $ret['success']
                ) {
                    wp_send_json( array( 'message' => $ret['message'], 'success' => true, 'warning' => $ret['warning'] ), 200 );
                } else {
                    wp_send_json( array( 'message' => 'Failed to send email', 'success' => false, 'errors' => $ret['errors'] ), 422 );
                }
            }
        }

        wp_send_json( array( 'message' => 'Permission Denied', 'success' => false ), 200 );
    }

    public function progress($request_data = [])
    {
		if ( current_user_can( SEND_USERS_EMAIL_SEND_MAIL_CAPABILITY ) ) {
			$param  = isset( $request_data['param'] ) ? sanitize_text_field( $request_data['param'] ) : "";
			$action = isset( $request_data['action'] ) ? sanitize_text_field( $request_data['action'] ) : "";

			if ( $param == 'sue_external_list_email_progress' && $action == 'sue_external_list_email_progress' ) {
				$user_id             = get_current_user_id();
				$options             = get_option( 'sue_send_users_email' );

				$total_email_send    = $options[SUE_Send_Emails_External_Lists::get_option_email_external_list_total_email_send_key($user_id)];
				$total_email_to_send = $options[SUE_Send_Emails_External_Lists::get_option_email_external_list_total_email_to_send_key($user_id)];
				$progress            = $total_email_to_send ? floor( ( $total_email_send / $total_email_to_send ) * 100 ) : 0;

				wp_send_json( array( 'progress' => $progress ), 200 );
			}
		}

		wp_send_json( array( 'message' => 'Permission Denied', 'success' => false ), 200 );
	}
}
