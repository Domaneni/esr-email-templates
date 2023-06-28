<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Worker_Email_Templates
{

    public function __construct()
    {
        add_action('esret_email_templates_add', [get_called_class(), 'add_email_template_action'], 12, 1);
        add_action('esret_email_templates_update', [get_called_class(), 'update_email_template_action'], 12, 2);
    }


    public function process_email_template($data)
    {
        if (isset($data['email_template_id']) && ($data['email_template_id'] !== '')) {
            do_action('esret_email_templates_update', (int)$data['email_template_id'], $this->prepare_data($data));
        } else {
            do_action('esret_email_templates_add', $this->prepare_data($data));
        }
    }


    public static function add_email_template_action($email_template_data)
    {
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'esret_email_templates', $email_template_data);
    }


    public static function update_email_template_action($email_template_id, $email_template_data)
    {
        global $wpdb;

        if (isset($email_template_data['email_type'])) {
            unset($email_template_data['email_type']);
        }
        $wpdb->update($wpdb->prefix . 'esret_email_templates', $email_template_data, [
            'id' => intval($email_template_id)
        ]);
    }


    private function prepare_data($data)
    {
        return [
            'email_title' => htmlspecialchars($data['email_title'], ENT_QUOTES, 'UTF-8'),
            'email_body' => htmlentities(stripslashes($data['email_body'])),
            'email_type' => intval($data['email_type'])
        ];
    }

}
