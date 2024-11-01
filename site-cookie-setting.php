<?php
//error_reporting(E_ALL);
define('scs_assets', plugin_dir_url(__FILE__) . 'assets/');
define('scs_PATH', plugin_dir_path(__FILE__) . 'includes/');


/**
 * Plugin Name: Site Cookie Setting
 * Plugin URI: https://www.ewaycorp.com/
 * Description: The plugin adds a HTML snippet of Cookie on a Web Page.
 * Author: eWay Corp
 * Version: 1.0
 */

function scs_plugin_activate(){
    scs_create_table();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__,'scs_plugin_activate');

function scs_activate_init()
{
    include_once(scs_PATH . 'scs_register.php');
    include_once(scs_PATH . 'scs_functions.php');
    
}
add_action('init', 'scs_activate_init');

function scs_create_table(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'scs_settings';
    $charset_collate = $wpdb->get_charset_collate();

    if( $wpdb->get_var( "show tables like '{$table_name}'" ) != $table_name ) {
        $sql = "CREATE TABLE $table_name (
          id int(11) NOT NULL AUTO_INCREMENT,
          scs_location varchar(255) NOT NULL,
          scs_text varchar(255) NOT NULL,
          scs_button_text varchar(255) NOT NULL,
          scs_button_background varchar(255) NOT NULL,
          scs_button_action varchar(255) NOT NULL,
          scs_button_color varchar(255) NOT NULL,
          scs_timespan varchar(255) NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
    
  
        //$wpdb->insert($table_name,$scs_dummy_data);
        $scs_dummy_data = array (
            'scs_location' => sanitize_text_field('Footer'),
            'scs_text' => sanitize_text_field('We are using Cookies! For more information visit this page'),
            'scs_button_text' => sanitize_text_field('Accept'),
            'scs_button_background' => sanitize_hex_color('#dc3254'),
            'scs_button_action' => sanitize_url('https://google.com'),
            'scs_button_color' => sanitize_text_field('blue')
        );
        $wpdb->insert($table_name, $scs_dummy_data);

}
function scs_dashboardmenu(){
    add_menu_page( 'scs_setting', 'Scap Setting', 'manage_options', 'scs_settings', 'scs_setting_page', 'dashicons-admin-tools', 5);
}
add_action('admin_menu', 'scs_dashboardmenu');

function scs_setting_page(){
    include_once(scs_PATH . 'scs_setting_page.php');  
}
//add_action('init', 'scs_setting_page');

// Delete table when deactivate
function scs_plugin_deactivate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'scs_settings';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);

}    
register_deactivation_hook(__FILE__,'scs_plugin_deactivate');
