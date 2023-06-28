<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Worker_Wave
{

    public static function esret_process_wave($wave_id, $data)
    {
        if (isset($data['esret-email-template'])) {
            global $wpdb;
            foreach ($data['esret-email-template'] as $key => $email_template) {
                if (isset($email_template['email_wave_id'])) {
                    if (intval($email_template['email_template_id']) === 0) {
                        $wpdb->delete($wpdb->prefix . 'esret_wave_emails', [
                            'id' => intval($email_template['email_wave_id']),
                            'wave_id' => intval($wave_id)
                        ]);
                    } else {
                        $wpdb->update($wpdb->prefix . 'esret_wave_emails', [
                            'email_id' => intval($email_template['email_template_id'])
                        ], [
                            'id' => intval($email_template['email_wave_id']),
                            'wave_id' => intval($wave_id)
                        ]);
                    }
                } else {
                    if (intval($email_template['email_template_id']) !== 0) {
                        $wpdb->insert($wpdb->prefix . 'esret_wave_emails', [
                            'email_id' => intval($email_template['email_template_id']),
                            'wave_id' => intval($wave_id)
                        ]);
                    }
                }
            }
        }
    }

}

add_action('esr_module_wave_add', ['ESRET_Worker_Wave', 'esret_process_wave'], 10, 2);
add_action('esr_module_wave_update', ['ESRET_Worker_Wave', 'esret_process_wave'], 10, 2);