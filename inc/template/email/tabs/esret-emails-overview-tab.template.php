<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Template_Emails_Overview_Tab
{

    public static function esret_print_content()
    {
        $user_can_edit = current_user_can('esret_emails_edit');
        ?>
		<h3 class="esret-tab-title"><?php esc_html_e('Emails Overview', 'esr-email-templates'); ?></h3>
        <?php if ($user_can_edit) { ?>
		<a href="<?php echo esc_url(add_query_arg('email_template_id', -1)) ?>" class="esret-add-new page-title-action"><?php esc_html_e('Add New Email Template', 'esr-email-templates'); ?></a>
    <?php } ?>


		<table id="datatable" class="table table-default table-bordered esret-datatable">
			<colgroup>
				<col width="10">
				<col width="90">
			</colgroup>
			<thead>
			<tr>
				<th class="esret-filter-disabled"><?php esc_html_e('ID', 'esr-email-templates'); ?></th>
                <?php if ($user_can_edit) { ?>
					<th class="esret-filter-disabled no-sort"><?php esc_html_e('Actions', 'esr-email-templates'); ?></th>
                <?php } ?>
				<th><?php esc_html_e('Title', 'esr-email-templates'); ?></th>
				<th><?php esc_html_e('Type', 'esr-email-templates'); ?></th>
			</tr>
			</thead>
			<tbody class="list">
            <?php foreach (ESRET()->email_template->get_all_email_templates() as $key => $template) { ?>
				<tr class="esrpc-row">
					<td><?php echo esc_html($template->id); ?></td>
                    <?php if ($user_can_edit) { ?>
						<td class="actions esret-email-templates">
                            <?php self::esret_print_action_box($template->id); ?>
						</td>
                    <?php } ?>
					<td><?php echo esc_html($template->email_title); ?></td>
					<td><?php echo ($template->email_type != 0 ? esc_html(ESRET()->email_type->get_title($template->email_type)) : '') ?></td>
				</tr>
            <?php } ?>
			</tbody>
		</table>
        <?php
    }


    private static function esret_print_action_box($id)
    {
        ?>
		<ul class="esret-actions-box" data-id="<?php echo esc_attr($id); ?>">
			<li class="esret-action edit">
				<a href="<?php echo esc_url(add_query_arg('email_template_id', intval($id))) ?>">
					<span class="dashicons dashicons-edit"></span>
				</a>
			</li>
		</ul>
        <?php
    }
}

add_action('esret_print_emails_overview_tab', ['ESRET_Template_Emails_Overview_Tab', 'esret_print_content']);