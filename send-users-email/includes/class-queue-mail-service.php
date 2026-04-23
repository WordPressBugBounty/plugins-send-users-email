<?php
class SUE_Queue_Mail_Service
{
    public static function enqueue_email($email_data)
    {
        global $wpdb;
        
        $insert = SUE_Emails::create( [
            'subject'      => isset($email_data['subject']) ? $email_data['subject'] : '',
            'email'        => isset($email_data['email']) ? $email_data['email'] : '',
            'message'      => isset($email_data['message']) ? $email_data['message'] : '',
            'via'          => isset($email_data['via']) ? $email_data['via'] : '',
            'role'         => isset($email_data['role']) ? $email_data['role'] : '',
            'email_style'  => isset($email_data['email_style']) ? $email_data['email_style'] : '',
            'scheduled_at' => isset($email_data['scheduled_at']) ? $email_data['scheduled_at'] : '',
        ] );
        
        if ($insert) {
            $last_insert_id = $wpdb->insert_id;
            $send_to_unsubscribed_users = 0;
            if (isset($email_data['send_to_unsubscribed_users']) && $email_data['send_to_unsubscribed_users'] == 'on') {
                $send_to_unsubscribed_users = 1;
            }

            return SUE_Queue_Meta_Model::create( [
                'sue_email_id' => $last_insert_id,
                'title' => isset($email_data['title']) ? $email_data['title'] : '',
                'tagline' => isset($email_data['tagline']) ? $email_data['tagline'] : '',
                'send_to_unsubscribed_users' => $send_to_unsubscribed_users,
            ] );
        }
    }
}