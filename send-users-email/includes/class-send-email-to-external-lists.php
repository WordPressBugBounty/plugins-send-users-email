<?php
class SUE_Send_Emails_External_Lists
{
    const EMAIL_EXTERNAL_LIST_TOTAL_ENAIL_SEND = 'email_external_list_total_email_send_';
    const EMAIL_EXTERNAL_LIST_TOTAL_ENAIL_TO_SEND = 'email_external_list_total_email_to_send_';

    static public function init_hook()
    {
        add_filter('sue_send_email_override_external_list', [self::class, 'override'], 10, 3);
        //add_action('sue_send_email_override', [self::class, 'override'], 10, 3);
    }

    /**
     * Summary of override
     * Overide the send_email function.
     * @param mixed $send_email
     * @param mixed $sue_override_user_email_subscription
     * @param mixed $sue_data
     */
    static public function override($send_email, $sue_override_user_email_subscription, $sue_data)
    {
        $get_user = External_List_Model::get_list_meta_query_by_email($sue_data['to']);

        $send_email = true;
        if ($get_user
            && isset($get_user[0]->subscribed)
            && $get_user[0]->subscribed == 0
            && $sue_override_user_email_subscription == 0
        ) {

            $send_email = false;
        }

        return $send_email;
    }

    static public function get_option_email_external_list_total_email_send_key($user_id)
    {
        return self::EMAIL_EXTERNAL_LIST_TOTAL_ENAIL_SEND . $user_id;
    }

    static public function get_option_email_external_list_total_email_to_send_key($user_id)
    {
        return self::EMAIL_EXTERNAL_LIST_TOTAL_ENAIL_TO_SEND . $user_id;
    }

    static private function replace_placeholder($email_body, $data = [])
    {
        $placeholders = [
            '{{email}}'        => $data['user_email'] ?? '',
            '{{first_name}}'   => $data['first_name'] ?? '',
            '{{last_name}}'    => $data['last_name'] ?? '',
            '{{title}}'        => $data['title'] ?? '',
            '{{salutation}}'   => $data['salutation'] ?? '',
            '{{field_01}}'     => $data['field_01'] ?? '',
            '{{field_02}}'     => $data['field_02'] ?? '',
            '{{field_03}}'     => $data['field_03'] ?? '',
            '{{field_04}}'     => $data['field_04'] ?? '',
            '{{field_05}}'     => $data['field_05'] ?? '',
        ];

        foreach ($placeholders as $placeholder => $value) {
            $email_body = str_replace($placeholder, $value, $email_body);
        }

        return wpautop($email_body);
    }

    static public function send_email_to_external_list($request_data = [], $parent_class = null)
    {
        $ret = [
            'errors' => [],
            'success' => false,
            'message' => '',
            'warning' => ''
        ];

        $options        = get_option( 'sue_send_users_email' );
        $option_title   = $options['email_title'] ?? '';
        $option_tagline = $options['email_tagline'] ?? '';

        $subject        = isset( $request_data['subject'] ) ? sanitize_text_field( $request_data['subject'] ) : "";
        $title          = ( isset( $request_data['title'] ) && !empty( $request_data['title'] ) ) ? sanitize_text_field( $request_data['title'] ) : $option_title;
        $tagline        = ( isset( $request_data['tagline'] ) && !empty( $request_data['tagline'] ) ) ? sanitize_text_field( $request_data['tagline'] ) : $option_tagline;
        $message        = isset( $request_data['sue_user_email_message'] ) ? wp_kses_post( $request_data['sue_user_email_message'] ) : "";
        $lists          = $request_data['lists'] ?? [];
        $lists          = array_map( 'sanitize_text_field', $lists );
        $message        = sue_remove_caption_shortcode( $message );
        $lists_string   = implode( ', ', $lists );
        $resMessage     = __( '🚀🚀🚀 Email(s) sent successfully!', 'send-users-email' );
        $warningMessage = '';
        $on_queue       = isset( $request_data['on_queue'] ) && ( $request_data['on_queue'] );
        $email_style    = isset( $request_data['selected_email_style'] ) ? sanitize_text_field( $request_data['selected_email_style'] ) : "default";
        $scheduled_at   = isset( $request_data['selected_scheduled_date'] ) ? sanitize_text_field( $request_data['selected_scheduled_date'] ) : date( 'Y-m-d' );

        // Validate inputs
        $validation_message = [];

        if ( empty( $subject ) || strlen( $subject ) < 2 || strlen( $subject ) > 200 ) {
            $validation_message['subject'] = __( 'Subject is required and should be between 2 and 200 characters.',
                "send-users-email" );
        }

        if ( empty( $message ) ) {
            $validation_message['message'] = __( 'Please provide email content.', "send-users-email" );
        }

        if ( empty( $lists ) ) {
            $validation_message['sue-list-email-list'] = __( 'Please select List(s).', "send-users-email" );
        }

        // If validation fails send, error messages
        if ( count( $validation_message ) > 0 ) {
            $ret['errors'] = $validation_message;

            return $ret;
        }

        // get the user ids from the selected lists
        $user_lists = External_List_Model::get_list_meta_query_by_id($lists);

        if ( current_user_can( SEND_USERS_EMAIL_SEND_MAIL_CAPABILITY ) && !empty($user_lists) ) {
            $current_user_id    = get_current_user_id();
            $total_email_send   = 0;
            $total_failed_email = 0;

            $total_email_to_send = count( $user_lists );
            
            $options = get_option( 'sue_send_users_email' );

            if ( ! $options ) {
                update_option( 'sue_send_users_email', [] );
            }

            $options = get_option( 'sue_send_users_email' );

            $option_progress_total_email_send_key = self::get_option_email_external_list_total_email_send_key($current_user_id);
            $option_progress_total_email_to_send_key = self::get_option_email_external_list_total_email_to_send_key($current_user_id);

            $options[ $option_progress_total_email_send_key ]    = $total_email_send;
            $options[ $option_progress_total_email_to_send_key ] = $total_email_to_send;

            update_option( 'sue_send_users_email', $options );

            // Email header setup
            $headers = $parent_class->get_email_headers();

            foreach ( $user_lists as $user ) {
                $user_id      = $user->id;

                $email_body   = $message;
                $user_email   = sanitize_email( $user->email );

                $mail_external_list_data = [
                    'user_email'  => $user_email,
                    'first_name'  => $user->first_name,
                    'last_name'   => $user->last_name,
                    'title'       => $user->title,
                    'salutation'  => $user->salutation,
                    'field_01'    => $user->field_01,
                    'field_02'    => $user->field_02,
                    'field_03'    => $user->field_03,
                    'field_04'    => $user->field_04,
                    'field_05'    => $user->field_05,
                ];

                // Replace placeholder with user content
                $email_body = self::replace_placeholder( $email_body, $mail_external_list_data );

                $email_subject = stripslashes_deep( $subject );
                $email_subject = strip_tags( self::replace_placeholder( $email_subject, $mail_external_list_data ) );
                
                $email_title = stripslashes_deep( $title );
                $email_title = strip_tags( self::replace_placeholder( $email_title, $mail_external_list_data ) );

                $email_tagline = stripslashes_deep( $tagline );
                $email_tagline = strip_tags( self::replace_placeholder( $email_tagline, $mail_external_list_data ) );

                // Send email
                $input_request = [
                    'title'   => $email_title,
                    'tagline' => $email_tagline
                ];

                $email_template = $parent_class->email_template( $email_body, $email_style, $input_request );

                $args_send_mail = [
                    'user_id'       => $user_id,
                    'email_style'   => $email_style,
                    'to'            => $user_email,
                    'subject'       => $email_subject,
                    'body'          => $email_template,
                    'headers'       => $headers,
                    'email_title'   => $email_title,
                    'email_tagline' => $email_tagline,
                    'user_data'     => $user,
                    'via'           => 'external_list' 
                ];

                $sue_override_user_email_subscription = isset($request_data['sue_override_user_email_subscription']) ? sanitize_text_field($request_data['sue_override_user_email_subscription']) : 0;

                if ( $on_queue ) {
                    if ( is_email( $user_email ) ) {
                        $arg_queue_email = [
                            'subject'                    => $email_subject,
                            'email'                      => $user_email,
                            'message'                    => $email_body,
                            'via'                        => 'external_list',
                            'email_style'                => $email_style,
                            'scheduled_at'               => $scheduled_at,
                            'send_to_unsubscribed_users' => $sue_override_user_email_subscription,
                            'title'                      => $email_title,
                            'tagline'                    => $email_tagline
                        ];

                        SUE_Queue_Mail_Service::enqueue_email( $arg_queue_email );
                    }
                    $resMessage = __( '🚀🚀🚀 Email(s) added to Queue!', 'send-users-email' );
                } else {
                    // If the user has opted to override email subscription, send the email regardless of subscription status
                    $send_mail = $parent_class->send_email(
                        $sue_override_user_email_subscription,
                        $args_send_mail 
                    );
                    
                    // this will trick the send mail to count the unsubscribed emails as true
                    if ($sue_override_user_email_subscription != 'on') {
                        // Log unsubscribed email attempts
                        if (isset($user->subscribed) && $user->subscribed == 0) {
                           $send_mail = true; 
                        }
                    }

                    if ( ! $send_mail ) {
                        $total_failed_email ++;
                    } else {
                        sue_log_sent_emails( $user_email, $email_subject, $email_body );
                    }
                }

                $email_body     = '';
                $email_template = '';

                $total_email_send ++;
                $options[ $option_progress_total_email_send_key ] = $total_email_send;
                update_option( 'sue_send_users_email', $options );

            }
        }

        // Cleanup email progress record
        Send_Users_Email_cleanup::cleanupGroupEmailProgress();

        if ( $total_failed_email > 0 ) {
            $warningMessage = 'Plugin tried to send ' . $total_email_to_send . ' ' . _n( 'email', 'emails',
            $total_email_to_send, 'send-users-email' ) . ' but ' . $total_failed_email . ' ' . _n( 'email', 'emails',
            $total_failed_email, 'send-users-email' ) . ' failed to send. Please check logs for possible errors.';
        }

        $ret['success'] = true;
        $ret['message'] = $resMessage;
        $ret['warning'] = $warningMessage;

        return $ret;
    }
}