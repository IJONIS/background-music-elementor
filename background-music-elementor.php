<?php
/**
 * Plugin Name: Background Music for Elementor
 * Plugin URI: https://wordpress.org/plugins/background-music-for-elementor/
 * Description: Add background music to your website with customizable controls.
 * Version: 1.0.0
 * Author: IJONIS
 * Author URI: https://ijonis.com/
 * Text Domain: background-music-elementor
 * Domain Path: /languages
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Elementor tested up to: 3.28.0
 * Elementor Pro tested up to: 3.28.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Background Music for Elementor Class
 */
final class Background_Music_Elementor {

    /**
     * Plugin Version
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    /**
     * Minimum PHP Version
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     */
    private static $_instance = null;

    /**
     * Instance
     * Ensures only one instance of the class is loaded or can be loaded.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
        add_action('init', [$this, 'load_textdomain']);
    }

    /**
     * Load plugin textdomain
     */
    public function load_textdomain() {
        load_plugin_textdomain('background-music-elementor', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Register Widget
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
        
        // Register styles and scripts
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'frontend_styles']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'frontend_scripts']);
    }

    /**
     * Admin notice for missing Elementor
     */
    public function admin_notice_missing_main_plugin() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('%1$s requires %2$s to be installed and activated.', 'background-music-elementor'),
            '<strong>' . esc_html__('Background Music for Elementor', 'background-music-elementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'background-music-elementor') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum Elementor version
     */
    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('%1$s requires %2$s version %3$s or greater.', 'background-music-elementor'),
            '<strong>' . esc_html__('Background Music for Elementor', 'background-music-elementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'background-music-elementor') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum PHP version
     */
    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('%1$s requires %2$s version %3$s or greater.', 'background-music-elementor'),
            '<strong>' . esc_html__('Background Music for Elementor', 'background-music-elementor') . '</strong>',
            '<strong>' . esc_html__('PHP', 'background-music-elementor') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Register widget
     */
    public function register_widgets() {
        // Include Widget files
        require_once(__DIR__ . '/widgets/background-music-widget.php');

        // Register widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Background_Music_Widget());
    }

    /**
     * Frontend styles
     */
    public function frontend_styles() {
        wp_enqueue_style('background-music-elementor', plugins_url('assets/css/background-music-elementor.css', __FILE__), [], self::VERSION);
    }

    /**
     * Frontend scripts
     */
    public function frontend_scripts() {
        wp_register_script('background-music-elementor', plugins_url('assets/js/background-music-elementor.js', __FILE__), ['jquery'], self::VERSION, true);
    }
}

// Initialize the plugin
Background_Music_Elementor::instance();
