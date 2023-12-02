<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Template_Emails
{

    const MENU_SLUG = 'esret_admin_email_templates';

    public static function print_content()
    {
        $tabs = apply_filters('esret_admin_tabs', [
            'emails_overview' => [
                'title' => esc_html__('Emails Overview', 'esr-email-templates'),
                'action' => 'esret_print_emails_overview_tab',
                'is_hidden' => false,
                'capability' => 'esret_emails_view',
            ],
            'emails_editor' => [
                'title' => esc_html__('Emails Editor', 'esr-email-templates'),
                'action' => 'esret_print_emails_editor_tab',
                'is_hidden' => true,
                'capability' => 'esret_emails_edit',
            ],
        ]);

        $user_can_edit_emails = current_user_can($tabs['emails_editor']['capability']);

        if (isset($_POST['esret_email_templates_submit']) && $user_can_edit_emails) {
            $worker = new ESRET_Worker_Email_Templates();
            $worker->process_email_template($_POST);
            unset($_GET['email_template_id']);
        }

        $active_tab = isset($_GET['tab']) && isset($tabs[sanitize_text_field($_GET['tab'])]) ? sanitize_text_field($_GET['tab']) : key($tabs);

        $esr_email_template_id = isset($_GET['email_template_id']) ? sanitize_text_field($_GET['email_template_id']) : null;

        if (($esr_email_template_id !== null) && $user_can_edit_emails) {
            $tabs['emails_editor']['is_hidden'] = false;
            $active_tab = 'emails_editor';
        } else if (!isset($tabs[$active_tab])) {
            $active_tab = 'emails_overview';
        }

        ?>
		<div class="wrap esret-settings">
			<h1 class="wp-heading-inline"><?php esc_html_e('Email Templates', 'esr-email-templates'); ?></h1>
			<h2 class="nav-tab-wrapper"><?php
                foreach ($tabs as $tab_key => $tab) {
                    if (!$tab['is_hidden'] && ((isset($tab['capability']) && current_user_can($tab['capability'])) || !isset($tab['capability']))) {
                        $tab_url = add_query_arg([
                            'tab' => $tab_key,
                        ]);
                        $active = $active_tab == $tab_key ? ' nav-tab-active' : '';
                        ?>
						<a href="<?php echo esc_url(remove_query_arg('email_template_id', $tab_url)); ?>" class="nav-tab<?php echo esc_attr($active); ?>"><?php echo esc_html($tab['title']); ?></a>
                        <?php
                    }
                }
                ?></h2>
			<div id="tab_container">
                <?php
                if ((isset($tabs[$active_tab]['capability']) && current_user_can($tabs[$active_tab]['capability'])) || !isset($tabs[$active_tab]['capability'])) {
                    do_action($tabs[$active_tab]['action']);
                }
                ?>
			</div>
		</div>
        <?php
    }

}
