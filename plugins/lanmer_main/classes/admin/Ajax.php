<?php
/**
 * Created by PhpStorm.
 * User: Romek
 * Date: 22.10.2018
 * Time: 21:06
 */

namespace Admin;


class Ajax
{
    public static function submit_message_form()
    {
        $data = $_POST;

        // check the nonce
        if (check_ajax_referer('submit_form', 'nonce', false ) == false) {
            wp_send_json_error();
        }

        wp_mail(get_option(Settings::FOOTER_CONTACT_FORM_EMAIL), 'Wiadomość ze strony wwww ',
            $data['email'] . PHP_EOL . $data['phone'] . PHP_EOL . $data['body']);

        wp_send_json_success(__('Thanks for reporting!'));
    }
}