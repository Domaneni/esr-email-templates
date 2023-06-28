<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Ajax
{

    public static function esret_remove_template_callback()
    {
        $data = $_POST;
        if (isset($data['template_id']) && current_user_can('esret_emails_edit')) {
            global $wpdb;

            $email_template = ESRET()->email_template->get_by_id($data['template_id']);

            if ($email_template) {
                $wpdb->delete($wpdb->prefix . 'esret_email_templates', [
                    'id' => $email_template->id
                ]);

                $wpdb->delete($wpdb->prefix . 'esret_wave_emails', [
                    'email_id' => $email_template->id
                ]);

                echo 1;
                wp_die();
            }
        }
        echo -1;
        wp_die();
    }

}

add_action('wp_ajax_esret_remove_template', ['ESRET_Ajax', 'esret_remove_template_callback']);
