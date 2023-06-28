<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Role
{

    /**
     * @codeCoverageIgnore
     */
    public static function init()
    {
        //add capabilities for admin
        $admin = get_role('administrator');

        $capabilities = [
            'esret_email_templates_admin_view' => true,
            'esret_emails_view' => true,
            'esret_emails_edit' => true,
        ];

        foreach ($capabilities as $key => $cap) {
            $admin->add_cap($key, $cap);
        }
    }
}

add_action('init', ['ESRET_Role', 'init']);