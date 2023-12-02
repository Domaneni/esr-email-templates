<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Templates_Checker
{

    public static function esret_get_registration_email_title_callback($title, $wave_ids)
    {
        foreach ($wave_ids as $key => $wave_id) {
            $new_title = self::esret_check_title(intval($wave_id), ESRET_Enum_Email_Type::EMAIL_REGISTRATION_OVERVIEW);
            if (!empty($new_title)) {
                return $new_title;
            }
        }

        return $title;
    }

    public static function esret_get_registration_email_body_callback($body, $wave_ids)
    {
        foreach ($wave_ids as $key => $wave_id) {
            $new_body = self::esret_check_body(intval($wave_id), ESRET_Enum_Email_Type::EMAIL_REGISTRATION_OVERVIEW);
            if (!empty($new_body)) {
                return $new_body;
            }
        }

        return $body;
    }

    public static function esret_get_confirmation_email_title_callback($title, $wave_id)
    {
        $new_title = self::esret_check_title(intval($wave_id), ESRET_Enum_Email_Type::EMAIL_COURSE_CONFIRMATION);
        if (!empty($new_title)) {
            return $new_title;
        }

        return $title;
    }

    public static function esret_get_confirmation_email_body_callback($body, $wave_id)
    {
        $new_body = self::esret_check_body(intval($wave_id), ESRET_Enum_Email_Type::EMAIL_COURSE_CONFIRMATION);
        if (!empty($new_body)) {
            return $new_body;
        }

        return $body;
    }

    public static function esret_get_user_registration_email_title_callback($title, $wave_id)
    {
        $new_title = self::esret_check_title(intval($wave_id), ESRET_Enum_Email_Type::EMAIL_USER_REGISTRATION);
        if (!empty($new_title)) {
            return $new_title;
        }

        return $title;
    }

    public static function esret_get_user_registration_email_body_callback($body, $wave_id)
    {
        $new_body = self::esret_check_body(intval($wave_id), ESRET_Enum_Email_Type::EMAIL_USER_REGISTRATION);
        if (!empty($new_body)) {
            return $new_body;
        }

        return $body;
    }

    public static function esret_get_payment_email_title_callback($title, $wave_id)
    {
        $new_title = self::esret_check_title(intval($wave_id), ESRET_Enum_Email_Type::EMAIL_PAYMENT);
        if (!empty($new_title)) {
            return $new_title;
        }

        return $title;
    }

    public static function esret_get_payment_email_body_callback($body, $wave_id)
    {
        $new_body = self::esret_check_body(intval($wave_id), ESRET_Enum_Email_Type::EMAIL_PAYMENT);
        if (!empty($new_body)) {
            return $new_body;
        }

        return $body;
    }

    public static function esret_get_payment_confirmation_email_title_callback($title, $wave_id)
    {
        $new_title = self::esret_check_title(intval($wave_id), ESRET_Enum_Email_Type::EMAIL_PAYMENT_CONFIRMATION);
        if (!empty($new_title)) {
            return $new_title;
        }

        return $title;
    }

    public static function esret_get_payment_confirmation_email_body_callback($body, $wave_id)
    {
        $new_body = self::esret_check_body(intval($wave_id), ESRET_Enum_Email_Type::EMAIL_PAYMENT_CONFIRMATION);
        if (!empty($new_body)) {
            return $new_body;
        }

        return $body;
    }

    private static function esret_check_title($wave_id, $type_id)
    {
        $email_data = ESRET()->wave_template->esret_get_email_data_by_wave_type(intval($wave_id), intval($type_id));

        if (!empty($email_data) && !empty($email_data->email_title)) {
            return $email_data->email_title;
        }

        return null;
    }

    private static function esret_check_body($wave_id, $type_id)
    {
        $email_data = ESRET()->wave_template->esret_get_email_data_by_wave_type(intval($wave_id), intval($type_id));

        if (!empty($email_data) && !empty($email_data->email_body)) {
            return html_entity_decode($email_data->email_body);
        }

        return null;
    }

}

add_filter('esr_get_registration_email_title', ['ESRET_Templates_Checker', 'esret_get_registration_email_title_callback'], 11, 2);
add_filter('esr_get_registration_email_body', ['ESRET_Templates_Checker', 'esret_get_registration_email_body_callback'], 11, 2);

add_filter('esr_get_confirmation_email_title', ['ESRET_Templates_Checker', 'esret_get_confirmation_email_title_callback'], 11, 2);
add_filter('esr_get_confirmation_email_body', ['ESRET_Templates_Checker', 'esret_get_confirmation_email_body_callback'], 11, 2);

add_filter('esr_get_user_registration_email_title', ['ESRET_Templates_Checker', 'esret_get_user_registration_email_title_callback'], 11, 2);
add_filter('esr_get_user_registration_email_body', ['ESRET_Templates_Checker', 'esret_get_user_registration_email_body_callback'], 11, 2);

add_filter('esr_get_payment_email_title', ['ESRET_Templates_Checker', 'esret_get_payment_email_title_callback'], 11, 2);
add_filter('esr_get_payment_email_body', ['ESRET_Templates_Checker', 'esret_get_payment_email_body_callback'], 11, 2);

add_filter('esr_get_payment_confirmation_email_title', ['ESRET_Templates_Checker', 'esret_get_payment_confirmation_email_title_callback'], 11, 2);
add_filter('esr_get_payment_confirmation_email_body', ['ESRET_Templates_Checker', 'esret_get_payment_confirmation_email_body_callback'], 11, 2);