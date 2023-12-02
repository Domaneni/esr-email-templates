<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Enqueue_Scripts
{

    public static function add_admin_scripts()
    {
        if (strpos(get_current_screen()->base, ESRET_Template_Emails::MENU_SLUG) !== false) {
            do_action('esr_scripts_datatable');

            wp_enqueue_script('esret_admin_script', ESRET_PLUGIN_URL . 'inc/assets/js/esret-admin.js', ['jquery'], ESRET_VERSION);
            wp_enqueue_style('esret_admin_style', ESRET_PLUGIN_URL . 'inc/assets/css/esret-admin.css', [], ESRET_VERSION);
       }
    }

}

add_action('admin_enqueue_scripts', ['ESRET_Enqueue_Scripts', 'add_admin_scripts']);