<?php
/**
 * Plugin Name: Easy School Registration - Email Templates
 * Plugin URI: https://easyschoolregistration.com/
 * Description: Email Templates module for Easy School Registration system
 * Version: 1.0.1
 * Author: Zbyněk Nedoma
 * Author URI: https://domaneni.cz/
 * License: A "Slug" license name e.g. GPL12
 * Plugin Slug: esr-email-templates
 */


if (!defined('ABSPATH')) {
    exit;
}

if ( ! function_exists( 'esret_fs' ) ) {
    // Create a helper function for easy SDK access.
    function esret_fs() {
        global $esret_fs;

        if ( ! isset( $esret_fs ) ) {
            // Include Freemius SDK.
            if ( file_exists( dirname( dirname( __FILE__ ) ) . '/easy-school-registration/freemius/start.php' ) ) {
                // Try to load SDK from parent plugin folder.
                require_once dirname( dirname( __FILE__ ) ) . '/easy-school-registration/freemius/start.php';
            } else {
                require_once dirname(__FILE__) . '/freemius/start.php';
            }

            $esret_fs = fs_dynamic_init( array(
                'id'                  => '11028',
                'slug'                => 'esr-email-templates',
                'premium_slug'        => 'esr-email-templates',
                'type'                => 'plugin',
                'public_key'          => 'pk_8b99404da15f82be698a0fb10266b',
                'is_premium'          => true,
                'is_premium_only'     => true,
                'has_paid_plans'      => true,
                'is_org_compliant'    => false,
                'parent'              => array(
                    'id'         => '11027',
                    'slug'       => 'easy-school-registration',
                    'public_key' => 'pk_5b03acdd5909865ef9a9aa3904b77',
                    'name'       => 'Easy School Registration',
                ),
                'menu'                => array(
                    'slug'           => 'esret_admin_email_templates',
                    'support'        => false,
                    'parent'         => array(
                        'slug' => 'esr_admin',
                    ),
                ),
                // Set the SDK to work in a sandbox mode (for development & testing).
                // IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
                'secret_key'          => 'sk_N^lpanC^r)R1#O*55O^NJk;fF?MHO',
            ) );
        }

        return $esret_fs;
    }
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
            define('ESRET_VERSION', '1.0.1');
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
            require_once ESRET_PLUGIN_PATH . '/inc/class/esret-freemius.class.php';
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