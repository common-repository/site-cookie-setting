<?php

add_action("wp_ajax_scs_fetch_data", "scs_fetch");
add_action("wp_ajax_nopriv_scs_fetch_data", "scs_fetch");

add_action("wp_ajax_cookie_setter", "scs_cookie_setter");
add_action("wp_ajax_nopriv_cookie_setter", "scs_cookie_setter");

add_action("wp_ajax_check_cookie_set", "scs_check_cookie_set");
add_action("wp_ajax_nopriv_check_cookie_set", "scs_check_cookie_set");

function scs_fetch(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'scs_settings';
    $results = $wpdb->get_results( "SELECT * FROM $table_name");
    echo json_encode($results[0]);
    exit();
}

function scs_cookie_setter(){
    if(isset($_POST['cookie_setter'])){
        setcookie('scs_cookie', sanitize_text_field($_POST['cookie_setter'], time() + (86400 * 30), "/"));
        $status = true;
    }
    echo json_encode($status);
    exit();
}

function scs_check_cookie_set(){
    if(isset($_COOKIE['user'])){
        $status = true;

    }
    echo json_encode($status);
    exit();
}







?>
