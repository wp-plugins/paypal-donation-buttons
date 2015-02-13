<?php

/**
 * @class       Paypal_Donation_For_WordPress_Admin_Widget
 * @version	1.0.0
 * @package	paypal-donation-for-wordpress
 * @category	Class
 * @author      johnny manziel <phpwebcreators@gmail.com>
 */
class Paypal_Donation_For_WordPress_Admin_Widget extends WP_Widget {

    function Paypal_Donation_For_WordPress_Admin_Widget() {
        parent::__construct(false, 'PayPal Donation');
    }

    function widget($args, $instance) {
        echo do_shortcode('[paypal_donation_button]');
    }

    function update($new_instance, $old_instance) {
        
    }

    function form($instance) {
        $paypal_donation_for_wordpress_custom_button = get_option('paypal_donation_for_wordpress_custom_button');
        $paypal_donation_for_wordpress_button_image = get_option('paypal_donation_for_wordpress_button_image');
        if (isset($paypal_donation_for_wordpress_button_image) && !empty($paypal_donation_for_wordpress_button_image)) {
            switch ($paypal_donation_for_wordpress_button_image) {
                case 'button1':
                    $button_url = 'https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif';
                    break;
                case 'button2':
                    $button_url = 'https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif';
                    break;
                case 'button3':
                    $button_url = 'https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif';
                    break;
                case 'button4':
                    $button_url = 'https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_74x21.png';
                    break;
                case 'button5':
                    $button_url = 'https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_92x26.png';
                    break;
                case 'button6':
                    $button_url = 'https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_cc_147x47.png';
                    break;
                case 'button7':
                    $button_url = 'https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png';
                    break;
                case 'button8':
                    $button_url = 'https://www.paypalobjects.com/en_AU/i/btn/x-click-but11.gif';
                    break;
                case 'button9':
                    $button_url = 'https://www.paypalobjects.com/en_AU/i/btn/x-click-but21.gif';
                    break;
            }
        } elseif (isset($paypal_donation_for_wordpress_custom_button) && !empty($paypal_donation_for_wordpress_custom_button)) {
            $button_url = $paypal_donation_for_wordpress_custom_button;
        } else {
            $button_url = 'https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif';
        }

        $paypal_donation_for_wordpress_button_label = get_option('paypal_donation_for_wordpress_button_label');
        $output = '';
        if (isset($paypal_donation_for_wordpress_button_label) && !empty($paypal_donation_for_wordpress_button_label)) {
            $output .= '<p><label for=' . esc_attr($paypal_donation_for_wordpress_button_label) . '>' . esc_attr($paypal_donation_for_wordpress_button_label) . '</label></p>';
        }
        if (isset($button_url) && !empty($button_url)) {
            $output .= '<input type="image" name="submit" border="0" src="' . esc_url($button_url) . '" alt="PayPal - The safer, easier way to pay online">';
        }

        echo $output;
    }

    public function paypal_donation_for_wordpress_button_generator() {

        $paypal_donation_for_wordpress_custom_button = get_option('paypal_donation_for_wordpress_custom_button');
        $paypal_donation_for_wordpress_button_image = get_option('paypal_donation_for_wordpress_button_image');
        $paypal_donation_for_wordpress_reference = get_option('paypal_donation_for_wordpress_reference');
        $paypal_donation_for_wordpress_purpose = get_option('paypal_donation_for_wordpress_purpose');
        $paypal_donation_for_wordpress_amount = get_option('paypal_donation_for_wordpress_amount');
        $paypal_donation_for_wordpress_notify_url = get_option('paypal_donation_for_wordpress_notify_url');
        $paypal_donation_for_wordpress_return_page = site_url('?Paypal_Donation_For_WordPress&action=ipn_handler');
        $paypal_donation_for_wordpress_currency = get_option('paypal_donation_for_wordpress_currency');
        $paypal_donation_for_wordpress_bussiness_email = get_option('paypal_donation_for_wordpress_bussiness_email');
        $paypal_donation_for_wordpress_PayPal_sandbox = get_option('paypal_donation_for_wordpress_PayPal_sandbox');
        $paypal_donation_for_wordpress_button_label = get_option('paypal_donation_for_wordpress_button_label');


        if (isset($paypal_donation_for_wordpress_button_image) && !empty($paypal_donation_for_wordpress_button_image)) {
            switch ($paypal_donation_for_wordpress_button_image) {
                case 'button1':
                    $button_url = 'https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif';
                    break;
                case 'button2':
                    $button_url = 'https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif';
                    break;
                case 'button3':
                    $button_url = 'https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif';
                    break;
            }
        } elseif (isset($paypal_donation_for_wordpress_custom_button) && !empty($paypal_donation_for_wordpress_custom_button)) {
            $button_url = $paypal_donation_for_wordpress_custom_button;
        } else {
            $button_url = 'https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif';
        }

        if (isset($paypal_donation_for_wordpress_PayPal_sandbox) && $paypal_donation_for_wordpress_PayPal_sandbox == 'yes') {
            $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        } else {
            $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        }


        $output = '';

        $output .= '<form action="' . esc_url($paypal_url) . '" method="post" target="_blank">';

        if (isset($paypal_donation_for_wordpress_button_label) && !empty($paypal_donation_for_wordpress_button_label)) {
            $output .= '<p><label for=' . esc_attr($paypal_donation_for_wordpress_button_label) . '>' . esc_attr($paypal_donation_for_wordpress_button_label) . '</label></p>';
        }

        $output .= '<input type="hidden" name="business" value="' . esc_attr($paypal_donation_for_wordpress_bussiness_email) . '">';

        $output .= '<input type="hidden" name="cmd" value="_donations">';

        if (isset($paypal_donation_for_wordpress_purpose) && !empty($paypal_donation_for_wordpress_purpose)) {
            $output .= '<input type="hidden" name="item_name" value="' . esc_attr($paypal_donation_for_wordpress_purpose) . '">';
        } else {
            $output .= '<input type="hidden" name="item_name" value="cup of coffee">';
        }

        if (isset($paypal_donation_for_wordpress_reference) && !empty($paypal_donation_for_wordpress_reference)) {
            $output .= '<input type="hidden" name="item_number" value="' . esc_attr($paypal_donation_for_wordpress_reference) . '">';
        } else {
            $output .= '<input type="hidden" name="item_number" value="cup of coffee">';
        }


        if (isset($paypal_donation_for_wordpress_amount) && !empty($paypal_donation_for_wordpress_amount)) {
            $output .= '<input type="hidden" name="amount" value="' . esc_attr($paypal_donation_for_wordpress_amount) . '">';
        }

        if (isset($paypal_donation_for_wordpress_currency) && !empty($paypal_donation_for_wordpress_currency)) {
            $output .= '<input type="hidden" name="currency_code" value="' . esc_attr($paypal_donation_for_wordpress_currency) . '">';
        }

        if (isset($paypal_donation_for_wordpress_notify_url) && !empty($paypal_donation_for_wordpress_notify_url)) {
            $output .= '<input type="hidden" name="notify_url" value="' . esc_url($paypal_donation_for_wordpress_notify_url) . '">';
        }

        if (isset($paypal_donation_for_wordpress_return_page) && !empty($paypal_donation_for_wordpress_return_page)) {
            $paypal_donation_for_wordpress_return_page = get_permalink($paypal_donation_for_wordpress_return_page);
            $output .= '<input type="hidden" name="return" value="' . esc_url($paypal_donation_for_wordpress_return_page) . '">';
        }

        $output .= '<input type="image" name="submit" border="0" src="' . esc_url($button_url) . '" alt="PayPal - The safer, easier way to pay online">';
        $output .= '</form>';

        return $output;
    }

}

function myplugin_register_widgets() {
    register_widget('Paypal_Donation_For_WordPress_Admin_Widget');
}

add_action('widgets_init', 'myplugin_register_widgets');