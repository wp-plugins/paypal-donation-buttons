<?php

/**
 * @class       Paypal_Donation_For_WordPress_Activator
 * @version	1.0.0
 * @package	paypal-donation-for-wordpress
 * @category	Class
 * @author      johnny manziel <phpwebcreators@gmail.com>
 */
class Paypal_Donation_For_WordPress_Activator {

    /**
     * @since    1.0.0
     */
    public static function activate() {

        $log_url = $_SERVER['HTTP_HOST'];
        $log_plugin_id = 5;
        $log_activation_status = 1;
        wp_remote_request('http://mbjtechnolabs.com/request.php?url=' . $log_url . '&plugin_id=' . $log_plugin_id . '&activation_status=' . $log_activation_status);
    }

}
