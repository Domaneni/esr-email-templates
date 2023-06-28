<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Template_Emails_Editor_Tab
{

    public static function esret_print_content()
    {
        $esr_email_template_id = isset($_GET['email_template_id']) ? intval(sanitize_text_field($_GET['email_template_id'])) : null;
        $template_data = [];

        if ($esr_email_template_id !== -1) {
            $template_data = ESRET()->email_template->get_by_id($esr_email_template_id);
        }

        ?>
		<h3 class="esret-tab-title"><?php echo ($esr_email_template_id !== -1 ? esc_html__('Edit Email Template', 'esr-email-templates') : esc_html__('Add Email Template', 'esr-email-templates')); ?></h3>
		<form class="esret-email-templates-edit-form" action="<?php echo esc_url(remove_query_arg('email_template_id', $_SERVER['REQUEST_URI'])); ?>" method="post">
			<table>
				<tr>
					<th><?php esc_html_e('Type', 'esr-email-templates'); ?></th>
					<td>
                        <?php if (($esr_email_template_id !== -1) && !empty((array)$template_data)) {
                            echo esc_html(ESRET()->email_type->get_title($template_data->email_type));
                            ?><input type="hidden" name="email_type" value="<?php echo esc_attr($template_data->email_type) ?>"><?php
                        } else { ?>
							<select name="email_type">
								<option value="0"><?php _e('Select email type', 'esr-email-templates'); ?></option>
                                <?php
                                foreach (ESRET()->email_type->get_items() as $key => $type) {
                                    ?>
									<option value="<?php echo esc_attr($key) ?>" <?php selected($key, !empty((array)$template_data) ? $template_data->email_type : -1) ?> data-tags-title="<?php echo esc_attr(htmlspecialchars(json_encode($type['title_tags']), ENT_QUOTES, 'UTF-8')); ?>"  data-tags-body="<?php echo esc_attr(htmlspecialchars(json_encode($type['body_tags']), ENT_QUOTES, 'UTF-8')); ?>"><?php echo esc_html($type['title']); ?></option><?php
                                }
                                ?>
							</select>
                        <?php } ?>
					</td>
				</tr>
				<tr>
					<th><?php _e('Title', 'esr-email-templates'); ?></th>
					<td>
						<input required type="text" name="email_title" value="<?php echo !empty((array)$template_data) ? $template_data->email_title : ''; ?>">
						<br>
						<label class="esret-settings-description esret-has-tags" for="esr_settings[registration_email_subject]"> Available template tags:</label>
						<br>
						<table class="esret-title-tags-table">
                            <?php
                            if (!empty((array)$template_data) && ($template_data->email_type != 0)) {
                                $title_tags = ESRET()->email_type->get_item($template_data->email_type)['title_tags'];
                                $tags_list = '';
                                foreach ($title_tags as $key => $tag) {
                                    if (isset($tag['type']) && ($tag['type'] === 'double')) {
                                        $tags_list .= '<tr><td>[' . $tag['tag'] . '][/' . $tag['tag'] . ']</td><td>' . $tag['description'] . '</td></tr>';
                                    } else {
                                        $tags_list .= '<tr><td>[' . $tag['tag'] . ']</td><td>' . $tag['description'] . '</td></tr>';
                                    }
                                }
                                echo $tags_list;
                            }
                            ?>
						</table>
					</td>
				</tr>
				<tr>
					<th><?php _e('Body', 'esr-email-templates'); ?></th>
					<td>
                        <?php wp_editor(!empty((array)$template_data) ? html_entity_decode($template_data->email_body) : '', 'esret_body', ['textarea_name' => 'email_body']); ?>
						<br>
						<table class="esret-body-tags-table">
                            <?php
                            if (!empty((array)$template_data) && ($template_data->email_type != 0)) {
                                $title_tags = ESRET()->email_type->get_item($template_data->email_type)['body_tags'];
                                $tags_list = '';
                                foreach ($title_tags as $key => $tag) {
                                    if (isset($tag['type']) && ($tag['type'] === 'double')) {
                                        $tags_list .= '<tr><td>[' . $tag['tag'] . '][/' . $tag['tag'] . ']</td><td>' . $tag['description'] . '</td></tr>';
                                    } else {
                                        $tags_list .= '<tr><td>[' . $tag['tag'] . ']</td><td>' . $tag['description'] . '</td></tr>';
                                    }
                                }
                                echo $tags_list;
                            }
                            ?>
						</table>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
                        <?php if ($esr_email_template_id !== -1) { ?>
							<input type="hidden" name="email_template_id" value="<?php echo $esr_email_template_id; ?>">
                        <?php } ?>
						<input type="submit" name="esret_email_templates_submit" value="<?php _e('Save', 'esr-email-templates'); ?>">
					</td>
				</tr>
			</table>
		</form>
        <?php
    }
}

add_action('esret_print_emails_editor_tab', ['ESRET_Template_Emails_Editor_Tab', 'esret_print_content']);