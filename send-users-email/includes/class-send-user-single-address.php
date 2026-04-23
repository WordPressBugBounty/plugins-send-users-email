<?php
/**
 * Send to single users only.
 * Check the trello task https://trello.com/c/UZ0RJDtR/72-send-email-to-single-addresses#
 */

class SUE_Email_Send_Single_Address extends Send_Users_Email_Admin
{
    public function __construct($plugin_name, $version) 
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function send_to_single_address()
    {
        if ( check_admin_referer( 'sue-email-user' ) && sue_fs()->is__premium_only() && sue_fs()->can_use_premium_code() ) {

			$param  = isset( $_REQUEST['param'] ) ? sanitize_text_field( $_REQUEST['param'] ) : "";
			$action = isset( $_REQUEST['action'] ) ? sanitize_text_field( $_REQUEST['action'] ) : "";

			if ( $param == 'send_email_single_user' && $action == 'sue_user_single_email_ajax' ) {

				$options        = get_option( 'sue_send_users_email' );
		        $option_title   = $options['email_title'] ?? '';
		        $option_tagline = $options['email_tagline'] ?? '';

				$subject     	 = isset( $_REQUEST['subject'] ) ? sanitize_text_field( $_REQUEST['subject'] ) : "";
				$email_recipient = isset( $_REQUEST['email-recipient'] ) ? sanitize_email( $_REQUEST['email-recipient'] ) : "";
				$message     	 = isset( $_REQUEST['sue_user_email_message'] ) ? wp_kses_post( $_REQUEST['sue_user_email_message'] ) : "";

				$email_style = 'default';
				$message     = sue_remove_caption_shortcode( $message );

				$resMessage     = __( '🚀🚀🚀 Email(s) sent successfully!', 'send-users-email' );
				$warningMessage = '';

                $email_style  = isset( $_REQUEST['selected_email_style'] ) ? sanitize_text_field( $_REQUEST['selected_email_style'] ) : "default";

				// Validate inputs
				$validation_message = [];

				if ( empty( $subject ) || strlen( $subject ) < 2 || strlen( $subject ) > 200 ) {
					$validation_message['subject'] = __( 'Subject is required and should be between 2 and 200 characters.',
						"send-users-email" );
				}

				if ( empty( $message ) ) {
					$validation_message['message'] = __( 'Please provide email content.', "send-users-email" );
				}

				if ( empty( $email_recipient ) ) {
					$validation_message['sue-user-email-datatable'] = __( 'Please add email recipient.', "send-users-email" );
				}

				if ( ! is_email( $email_recipient ) ) {
					$validation_message['sue-user-email-datatable'] = __( 'Please add valid email recipient.', "send-users-email" );
				}

				// If validation fails send, error messages
				if ( count( $validation_message ) > 0 ) {
					wp_send_json( array( 'errors' => $validation_message, 'success' => false ), 422 );
				}

				// Cleanup email progress record
				Send_Users_Email_cleanup::cleanupUserEmailProgress();

				if ( current_user_can( SEND_USERS_EMAIL_SEND_MAIL_CAPABILITY ) ) {

					$current_user_id     = get_current_user_id();
					$total_email_send    = 0;
					$total_email_to_send = 1;
					$total_failed_email  = 0;

					$options = get_option( 'sue_send_users_email' );

					if ( ! $options ) {
						update_option( 'sue_send_users_email', [] );
					}

					$options = get_option( 'sue_send_users_email' );

					$options[ 'email_users_total_email_send_' . $current_user_id ]    = $total_email_send;
					$options[ 'email_users_total_email_to_send_' . $current_user_id ] = $total_email_to_send;

					update_option( 'sue_send_users_email', $options );

					// Email header setup
					$headers = $this->get_email_headers();
					
					$email_body = $message;
					$email_recipient = sanitize_email( $email_recipient );

					$email_title   = '';
					$email_tagline = '';
					// Send email
					$input_request = [
						'title'   => $email_title,
						'tagline' => $email_tagline,	
					];
					$email_template = $this->email_template( $email_body, $email_style, $input_request );
					$user_id = 0; // Since it's a single email to arbitrary recipient, user_id is set to 0.
					$user_email = $email_recipient;
					$email_subject = stripslashes_deep( $subject );
					$args_send_mail = [
						'user_id'       => $user_id,
						'user_email'	=> $email_recipient,
						'email_style'   => $email_style,
						'to'            => $email_recipient,
						'subject'       => $subject,
						'body'          => $email_template,
						'headers'       => $headers,
						'email_title'   => $email_title,
						'email_tagline' => $email_tagline
					];
					$sue_override_user_email_subscription = 0;
					$send_mail = $this->send_email(
						$sue_override_user_email_subscription,
						$args_send_mail 
					);
					if ( ! $send_mail ) {
						$total_failed_email ++;
						$resMessage = __( '❌❌❌ Email sending failed!', 'send-users-email' );
					} else {
						sue_log_sent_emails( $user_email, $email_subject, $email_body );
					}

					$email_body     = '';
					$email_template = '';

					$total_email_send = 1;
					$options[ 'email_users_total_email_send_' . $current_user_id ] = $total_email_send;
					update_option( 'sue_send_users_email', $options );

					
					if ( $total_failed_email > 0 ) {
						$warningMessage = 'Plugin tried to send ' . count( $users ) . ' ' . _n( 'email', 'emails',
								count( $users ), 'send-users-email' ) . ' but ' . $total_failed_email . ' ' . _n( 'email', 'emails',
								$total_failed_email, 'send-users-email' ) . ' failed to send. Please check logs for possible errors.';
						
					}

					wp_send_json( array( 'message' => $resMessage, 'success' => true, 'warning' => $warningMessage ), 200 );
				}

			}

		}

		wp_send_json( array( 'message' => 'Permission Denied', 'success' => false ), 200 );
    }
}