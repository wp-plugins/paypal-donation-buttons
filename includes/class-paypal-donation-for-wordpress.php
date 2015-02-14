<?php

/**
 * @class       Paypal_Donation_For_WordPress
 * @version	1.0.0
 * @package	paypal-donation-for-wordpress
 * @category	Class
 * @author      johnny manziel <phpwebcreators@gmail.com>
 */
class Paypal_Donation_For_WordPress {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Paypal_Donation_For_WordPress_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the Dashboard and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->plugin_name = 'paypal-donation-for-wordpress';
        $this->version = '1.0.2';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        
        add_action('init', array($this, 'add_endpoint'), 0);
        add_action('parse_request', array($this, 'handle_api_requests'), 0);

        add_action('paypal_donation_for_wordpress_api_ipn_handler', array($this, 'paypal_donation_for_wordpress_api_ipn_handler'));
        $prefix = is_network_admin() ? 'network_admin_' : '';
        add_filter("{$prefix}plugin_action_links_" . PDW_PLUGIN_BASENAME ,array($this,'plugin_action_links'),10,4);
        
        add_filter('widget_text', 'do_shortcode');
    }

    
    public function plugin_action_links($actions, $plugin_file, $plugin_data, $context)
    {
        $custom_actions = array(
            'configure' => sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=paypal-donation-for-wordpress' ), __( 'Configure', 'paypal-donation-buttons' ) ),
            'support'   => sprintf( '<a href="%s" target="_blank">%s</a>', 'http://wordpress.org/support/plugin/paypal-donation-buttons/', __( 'Support', 'paypal-donation-buttons' ) ),
            'review'    => sprintf( '<a href="%s" target="_blank">%s</a>', 'http://wordpress.org/support/view/plugin-reviews/paypal-donation-buttons', __( 'Write a Review', 'paypal-donation-buttons' ) ),
        );

       return array_merge( $custom_actions, $actions );
    }
    
    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Paypal_Donation_For_WordPress_Loader. Orchestrates the hooks of the plugin.
     * - Paypal_Donation_For_WordPress_i18n. Defines internationalization functionality.
     * - Paypal_Donation_For_WordPress_Admin. Defines all hooks for the dashboard.
     * - Paypal_Donation_For_WordPress_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-paypal-donation-for-wordpress-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-paypal-donation-for-wordpress-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the Dashboard.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-paypal-donation-for-wordpress-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-paypal-donation-for-wordpress-public.php';
        
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-paypal-donation-for-wordpress-list.php';
        

        $this->loader = new Paypal_Donation_For_WordPress_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Paypal_Donation_For_WordPress_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Paypal_Donation_For_WordPress_i18n();
        $plugin_i18n->set_domain($this->get_plugin_name());

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the dashboard functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Paypal_Donation_For_WordPress_Admin($this->get_plugin_name(), $this->get_version());
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Paypal_Donation_For_WordPress_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_filter('widget_text', $plugin_public, 'do_shortcode');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Paypal_Donation_For_WordPress_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
    
     public function handle_api_requests() {
        global $wp;

        if (isset($_GET['action']) && $_GET['action'] == 'ipn_handler') {
            $wp->query_vars['Paypal_Donation_For_WordPress'] = $_GET['action'];
        }

        // paypal-donation-buttons endpoint requests
        if (!empty($wp->query_vars['Paypal_Donation_For_WordPress'])) {

            // Buffer, we won't want any output here
            ob_start();

            // Get API trigger
            $api = strtolower(esc_attr($wp->query_vars['Paypal_Donation_For_WordPress']));

            // Trigger actions
            do_action('paypal_donation_for_wordpress_api_' . $api);

            // Done, clear buffer and exit
            ob_end_clean();
            die('1');
        }
    }

    /**
     * add_endpoint function.
     *
     * @access public
     * @since 1.0.0
     * @return void
     */
    public function add_endpoint() {

        // paypal-donation-buttons API for PayPal gateway IPNs, etc
        add_rewrite_endpoint('Paypal_Donation_For_WordPress', EP_ALL);
    }

    public function paypal_donation_for_wordpress_api_ipn_handler() {

        /**
         * The class responsible for defining all actions related to paypal ipn listener 
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-paypal-donation-for-wordpress-paypal-listner.php';
        $Paypal_Donation_For_WordPress_PayPal_listner = new Paypal_Donation_For_WordPress_PayPal_listner();

        /**
         * The check_ipn_request function check and validation for ipn response
         */
        if ($Paypal_Donation_For_WordPress_PayPal_listner->check_ipn_request()) {
            $Paypal_Donation_For_WordPress_PayPal_listner->successful_request($IPN_status = true);
        } else {
            $Paypal_Donation_For_WordPress_PayPal_listner->successful_request($IPN_status = false);
        }
    }


}
