<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Wave_Template
{

    public function esret_get_by_wave($wave_id)
    {
        global $wpdb;
        $ids = [];
        $results = $wpdb->get_results($wpdb->prepare("SELECT we.id, we.email_id, et.email_type FROM {$wpdb->prefix}esret_wave_emails AS we JOIN {$wpdb->prefix}esret_email_templates AS et ON we.email_id = et.id WHERE wave_id = %d", [intval($wave_id)]));

        foreach ($results as $key => $result) {
            $ids[$result->email_type] = [
                'id' => $result->id,
                'email_id' => $result->email_id
            ];
        }

        return $ids;
    }

    public function esret_get_email_data_by_wave_type($wave_id, $type_id)
    {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT et.* FROM {$wpdb->prefix}esret_wave_emails AS we JOIN {$wpdb->prefix}esret_email_templates AS et ON we.email_id = et.id WHERE we.wave_id = %d AND et.email_type = %d", [intval($wave_id), intval($type_id)]));
    }

}