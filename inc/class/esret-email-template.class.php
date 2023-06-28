<?php

if (!defined('ABSPATH')) {
	exit;
}

class ESRET_Email_Template {

	public function get_all_email_templates() {
		global $wpdb;

		return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}esret_email_templates");
	}


	public function get_by_id($email_template_id) {
		global $wpdb;

		return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}esret_email_templates WHERE id = %d", [intval($email_template_id)]));
	}


    public function esret_get_by_type($email_type) {
        global $wpdb;

        return $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}esret_email_templates WHERE email_type = %d", [intval($email_type)]));
    }

}