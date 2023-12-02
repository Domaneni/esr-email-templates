<?php
/**
 * Plugin Name:     ESR - Email Templates
 * Plugin URI:      https://easyschoolregistration.com/
 * Description:     Email Templates module for Easy School Registration system
 *
 * Version:         1.0.2
 * Tested up to:    6.4.1
 *
 * Author:          Zbyněk Nedoma
 * Author URI:      https://domaneni.cz/
 * Plugin Slug:     esr-email-templates
 *
 * Text Domain:     esr-email-templates
 * Domain Path:     /languages
 *
 * License: GPL 3
 */

/**
 * Plugin Name:     Easy School Registration
 * Plugin URI:      https://easyschoolregistration.com/
 * Description:     Tools to help you run your school better
 *
 * Version:         3.9.7
 * Tested up to:    6.3.2
 *
 * Author:          Zbynek Nedoma
 * Author URI:      https://domaneni.cz
 * Plugin Slug:     easy-school-registration
 *
 * Text Domain:     easy-school-registration
 * Domain Path:     /languages
 *
 * License: GPL 3
 *
 */


if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ESR_Email_Templates')) {

    /**
     * Main ESR_Email_Templates Class.
     *
     */
    final class ESR_Email_Templates
    {

        /**
         * @var ESR_Email_Templates
         */
        private static $instance;

        /**
         * @var ESRET_Email_Template
         */
        public $email_template;

        /**
         * @var ESRET_Wave_Template
         */
        public $wave_template;

        /**
         * @var ESRET_Enum_Email_Type
         */
        public $email_type;


        /**
         * Main ESR_Email_Templates Instance.
         *
         * Insures that only one instance of ESR_Email_Templates exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         *
         * @static
         * @staticvar array $instance
         * @return object|ESR_Email_Templates
         * @see ESRET()
         */
        public static function instance()
        {
            if (!isset(self::$instance) && !(self::$instance instanceof ESR_Email_Templates)) {
                self::$instance = new ESR_Email_Templates;
                self::$instance->setup_constants();

                self::$instance->includes();

                register_activation_hook(ESRET_PLUGIN_FILE, array('ESRET_Database', 'esret_database_install_callback'));

                self::$instance->email_template = new ESRET_Email_Template();
                self::$instance->email_type = new ESRET_Enum_Email_Type();
                self::$instance->wave_template = new ESRET_Wave_Template();
            }

            return self::$instance;
        }


        /**
         * Throw error on object clone.
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object therefore, we don't want the object to be cloned.
         *
         * @access protected
         * @return void
         */
        public function __clone()
        {
            // Cloning instances of the class is forbidden.
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'esr-email-templates'), '1.0.0');
        }


        /**
         * Disable unserializing of the class.
         *
         * @access protected
         * @return void
         */
        public function __wakeup()
        {
            // Unserializing instances of the class is forbidden.
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'esr-email-templates'), '1.0.0');
        }


        private function setup_constants()
        {
            define('ESRET_SLUG', 'esret');
            define('ESRET_VERSION', '1.0.2');
            // Plugin Root File.
            if (!defined('ESRET_PLUGIN_FILE')) {
                define('ESRET_PLUGIN_FILE', __FILE__);
            }

            define('ESRET_PLUGIN_PATH', dirname(__FILE__));
            define('ESRET_PLUGIN_URL', plugin_dir_url(__FILE__));
            define('ESRET_PLUGIN_DIR', plugin_dir_path(__FILE__));
        }


        /**
         * Include required files.
         *
         * @access private
         * @return void
         */
        private function includes()
        {
            require_once ESRET_PLUGIN_PATH . '/inc/class/esret-admin.class.php';
            require_once ESRET_PLUGIN_PATH . '/inc/class/esret-email-template.class.php';
            require_once ESRET_PLUGIN_PATH . '/inc/class/esret-enqueue-scripts.php';
            require_once ESRET_PLUGIN_PATH . '/inc/class/esret-role.class.php';
            require_once ESRET_PLUGIN_PATH . '/inc/class/esret-templates-checker.class.php';
            require_once ESRET_PLUGIN_PATH . '/inc/class/esret-wave-template.class.php';

            require_once ESRET_PLUGIN_PATH . '/inc/database/esret-database.class.php';

            require_once ESRET_PLUGIN_PATH . '/inc/enum/esret-email-type.enum.php';

            require_once ESRET_PLUGIN_PATH . '/inc/template/email/esret-emails.template.php';
            require_once ESRET_PLUGIN_PATH . '/inc/template/email/tabs/esret-emails-editor-tab.template.php';
            require_once ESRET_PLUGIN_PATH . '/inc/template/email/tabs/esret-emails-overview-tab.template.php';
            require_once ESRET_PLUGIN_PATH . '/inc/template/wave/esret-wave_edit_option.template.php';

            require_once ESRET_PLUGIN_PATH . '/inc/worker/esret-email-templates.worker.php';
            require_once ESRET_PLUGIN_PATH . '/inc/worker/esret-wave.worker.php';
        }


        /**
         * Load actions
         *
         * @access private
         * @return void
         */
        private function init() {
            add_action( 'init', array( $this, 'load_text_domain' ), 99 );
        }


        /**
         * Load text domain
         *
         * @access public
         * @return void
         */
        public function load_text_domain() {
            load_plugin_textdomain( 'esr-email-templates', false, dirname(plugin_basename(__FILE__)) . '/languages/' );
        }

    }
}

function ESRET()
{
    return ESR_Email_Templates::instance();
}

// Get ESR Running.
if (class_exists('Easy_School_Registration')) {
    ESRET();
}