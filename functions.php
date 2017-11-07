<?php
/**
 * Constants
**/
    define('THEME_DIR', dirname(__FILE__));
    define('ASSETS_DIR', THEME_DIR . '/public');
    define('INCLUDES_DIR', THEME_DIR . '/includes');
    define('THEME_URL', get_template_directory_uri());
    define('ASSETS_URL', THEME_URL . '/public');

/**
 * Autoloading
**/
    require_once INCLUDES_DIR . '/autoload.php';

/**
 * Hooks
**/
    add_action('after_setup_theme', 'theme_initialisation');
    add_action('init', 'load_theme_assets');
    add_action('init', 'register_custom_post_types');
    add_action('init', 'register_custom_taxonomies');

/**
 * Custom functions
**/
    function theme_initialisation() {
        add_theme_support('html5');
        add_theme_support('post-thumbnails');

        register_nav_menu('main', 'Main Menu');

        // acf options page
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title' => 'Options',
                'parent_slug' => 'themes.php',
                'menu_slug' => 'theme-options'
            ));
        }
    }

    function load_theme_assets() {
        if (is_admin() || in_array($GLOBALS['pagenow'], array('wp-register.php', 'wp-login.php'))) {
            return;
        }

        Theme::enqueueStyle('app', 'app');
	    Theme::enqueueScript('app', 'app');

        // remove WordPress' version of jQuery on the front-end
        if (wp_script_is('jquery', 'registered')) {
            wp_deregister_script('jquery');
        }
    }