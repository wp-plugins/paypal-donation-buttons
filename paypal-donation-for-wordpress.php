<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name:       PayPal Donation Buttons
 * Plugin URI:        http://www.mbjtechnolabs.com
 * Description:       Easy to use add a PayPal Donation button as a Page, Post and Widget with a shortcode
 * Version:           1.0.1
 * Author:            johnny manziel
 * Author URI:        http://www.mbjtechnolabs.com
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       paypal-donation-for-wordpress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-paypal-donation-for-wordpress-activator.php
 */
function activate_paypal_donation_for_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-paypal-donation-for-wordpress-activator.php';
	Paypal_Donation_For_WordPress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-paypal-donation-for-wordpress-deactivator.php
 */
function deactivate_paypal_donation_for_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-paypal-donation-for-wordpress-deactivator.php';
	Paypal_Donation_For_WordPress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_paypal_donation_for_wordpress' );
register_deactivation_hook( __FILE__, 'deactivate_paypal_donation_for_wordpress' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-paypal-donation-for-wordpress.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_paypal_donation_for_wordpress() {

	$plugin = new Paypal_Donation_For_WordPress();
	$plugin->run();

}
run_paypal_donation_for_wordpress();
