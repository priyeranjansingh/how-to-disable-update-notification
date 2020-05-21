<?php
/**
 * @package HIDE_USER_NOTIFICATION
 * @version 1
 */
/*
Plugin Name: HIDE USER NOTIFICATION
Plugin URI: http://wordpress.org/plugins/hide-user-notifications
Description: This is for hide notification for all user default.
Author: Priya Ranjan
Version: 1.0.0
Author URI: http://yourwebsiteurl.com/ 
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!defined('HUN_PLUGIN_PATH')){
   define('HUN_PLUGIN_PATH',  plugin_dir_path( __FILE__ ));
}


/* 
	* to create naviagtion menu for plugin
*/
add_action('admin_menu', 'hu_order_menu_pages');
function hu_order_menu_pages(){
    $user_roles = wp_get_current_user();
    $current_user_role = $user_roles->roles[0];  
    add_menu_page('Hide User Notification', 'Hide User Notification', 'manage_options', 'manage-hide-notification', 'hide_notification','dashicons-businessperson',66 );
}

function hide_notification(){
	global $wpdb,$woocommerce;
    require_once(HUN_PLUGIN_PATH . 'includes/userlist.php');	
}

add_action( 'admin_init', 'hide_user_default_options' );
function hide_user_default_options(){
	$user_id=get_current_user_id();
	$value=get_user_meta($user_id,'hide_notification_user');
	if(isset($value[0]) && $value[0]=="no"){
		//here code added to remove update notifications
		add_action( 'admin_enqueue_scripts', 'load_user_hide_style' );
		remove_action('load-update-core.php','wp_update_plugins');  // remove auto update
		add_filter('pre_site_transient_update_plugins','__return_null'); // adding code for which plugin you want to stop
	}else if(!isset($value[0])){
		//here code added to remove update notifications
		add_action( 'admin_enqueue_scripts', 'load_user_hide_style' );
		remove_action('load-update-core.php','wp_update_plugins');  // remove auto update
		add_filter('pre_site_transient_update_plugins','__return_null'); // adding code for which plugin you want to stop
	}
}

function load_user_hide_style() {
	wp_register_style( 'hide-user-css', plugins_url() . '/hide-user-notification/css/hide.css', false, '10.0.0' );
	wp_enqueue_style( 'hide-user-css', plugins_url() . '/hide-user-notification/css/hide.css', false, '1.0.0' );
}

