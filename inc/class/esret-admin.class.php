<?php

if (!defined('ABSPATH')) {
	exit;
}

class ESRET_Admin {

	public static function esrpc_add_admin_menu() {
		add_submenu_page(ESR_Admin::ADMIN_MENU_SLUG, esc_html__('Email Templates', 'esr-email-templates'), esc_html__('Email Templates', 'esr-email-templates'), 'esret_email_templates_admin_view', ESRET_Template_Emails::MENU_SLUG, ['ESRET_Template_Emails', 'print_content']);
	}

}

add_action('esr_add_admin_menu', ['ESRET_Admin', 'esrpc_add_admin_menu'], 9);