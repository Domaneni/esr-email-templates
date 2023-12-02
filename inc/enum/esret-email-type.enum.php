<?php

if (!defined('ABSPATH')) {
    exit;
}

class ESRET_Enum_Email_Type
{
    const
        EMAIL_USER_REGISTRATION = 1,
        EMAIL_REGISTRATION_OVERVIEW = 2,
        EMAIL_COURSE_CONFIRMATION = 3,
        EMAIL_PAYMENT = 4,
        EMAIL_PAYMENT_CONFIRMATION = 5;

    private $items = [];

    public function __construct()
    {
        $this->items = [
            self::EMAIL_USER_REGISTRATION => [
                'title' => esc_html__('User Registration Email', 'esret-email-templates'),
                'title_tags' => $this->esret_prepare_tags(ESR()->tags->get_tags('student_registration_email_title')),
                'body_tags' => $this->esret_prepare_tags(ESR()->tags->get_tags('email_user_registration'))
            ],
            self::EMAIL_REGISTRATION_OVERVIEW => [
                'title' => esc_html__('Registration Overview Email', 'esret-email-templates'),
                'title_tags' => $this->esret_prepare_tags(ESR()->tags->get_tags('registration_email_title')),
                'body_tags' => $this->esret_prepare_tags(ESR()->tags->get_tags('email_registration'))
            ],
            self::EMAIL_COURSE_CONFIRMATION => [
                'title' => esc_html__('Course Confirmation Email', 'esret-email-templates'),
                'title_tags' => $this->esret_prepare_tags(ESR()->tags->get_tags('confirmation_email_title')),
                'body_tags' => $this->esret_prepare_tags(ESR()->tags->get_tags('email_confirmation'))
            ],
            self::EMAIL_PAYMENT => [
                'title' => esc_html__('Payment Email', 'esret-email-templates'),
                'title_tags' => $this->esret_prepare_tags(ESR()->tags->get_tags('email_title')),
                'body_tags' => $this->esret_prepare_tags(ESR()->tags->get_tags('email_payment'))
            ],
            self::EMAIL_PAYMENT_CONFIRMATION => [
                'title' => esc_html__('Payment Confirmation Email', 'esret-email-templates'),
                'title_tags' => $this->esret_prepare_tags(ESR()->tags->get_tags('email_title')),
                'body_tags' => $this->esret_prepare_tags(ESR()->tags->get_tags('email_payment_confirmation'))
            ],
        ];
    }


    public function get_items()
    {
        return $this->items;
    }


    public function get_item($key)
    {
        return $this->get_items()[$key];
    }


    public function get_title($key)
    {
        return $this->get_item($key)['title'];
    }

    public function esret_prepare_tags($tags) {
        $result = [];
        foreach ($tags as $key => $tag) {
            $result[$key] = [
                'tag' => $tag['tag'],
                'description' => $tag['description'],
            ];

            if (isset($tag['type'])) {
                $result[$key]['type'] = $tag['type'];
            }
        }

        return $result;
    }

}