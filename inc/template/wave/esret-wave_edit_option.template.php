<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Template_Wave_Edit_Option
{

    public static function esret_print_wave_options_callback($wave)
    {
        $existing_ids = ESRET()->wave_template->esret_get_by_wave($wave->id);
        ?>
		<tr>
			<th><?php esc_html_e('Email Templates', 'esr-email-templates'); ?></th>
			<td>
				<table>
                    <?php
                    foreach (ESRET()->email_type->get_items() as $key => $type) {
                        ?>
						<tr>
						<td><?php echo esc_html($type['title']); ?></td>
						<td>
							<select name="esret-email-template[<?php echo esc_attr($key) ?>][email_template_id]">
								<option value="0"><?php esc_html_e('Default Template', 'esr-email-templates'); ?></option>
                                <?php
                                $existing_id = isset($existing_ids[$key]) ? $existing_ids[$key]['email_id'] : 0;
                                foreach (ESRET()->email_template->esret_get_by_type($key) as $etkey => $et) {
                                    ?>
									<option value="<?php echo esc_attr($et->id); ?>" <?php selected($existing_id, $et->id); ?>><?php echo esc_html($et->email_title); ?></option><?php
                                }
                                ?>
							</select>
							<?php
								if (isset($existing_ids[$key])) {
									?><input type="hidden" name="esret-email-template[<?php echo esc_attr($key); ?>][email_wave_id]" value="<?php echo esc_attr($existing_ids[$key]['id']) ?>"><?php
								}
							?>
						</td>
						</tr><?php
                    }
                    ?>
				</table>
			</td>
		</tr>
        <?php
    }
}

add_action('esr_wave_edit_form_input', ['ESRET_Template_Wave_Edit_Option', 'esret_print_wave_options_callback'], 20);