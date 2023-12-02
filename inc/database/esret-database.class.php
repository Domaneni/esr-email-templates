<?php

if (!defined('ABSPATH')) {
	exit;
}

class ESRET_Database {

	public static function esret_update_db_check() {
		if (version_compare(get_site_option('esret_db_version'), ESRET_VERSION, '<')) {
			self::esret_database_update();
		}
	}


    public static function esret_database_install_callback() {
		self::esret_create_tables();

		add_option('esret_db_version', ESRET_VERSION);
	}


	private static function esret_database_update() {
		update_option('esret_db_version', ESRET_VERSION);
	}


	public static function esret_create_tables() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$wpdb->prefix}esret_email_templates (
			id bigint(20) NOT NULL AUTO_INCREMENT,
            email_title mediumtext NOT NULL,
			email_body text,
			email_settings text,
			email_type varchar(20) NOT NULL,
			PRIMARY KEY id (id)
		) $charset_collate;";

		$sql .= "CREATE TABLE {$wpdb->prefix}esret_wave_emails (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			email_id bigint(20) NOT NULL,
			wave_id bigint(20) NOT NULL,
			is_enabled tinyint(1) DEFAULT NULL,
			PRIMARY KEY id (id)
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

}

add_action('plugins_loaded', ['ESRET_Database', 'esret_update_db_check']);