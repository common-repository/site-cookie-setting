<?php
function scs_style(){
    wp_enqueue_style( 'scs_style', scs_assets."css/scs_style.css", false, mt_rand());
}
function scs_scripts()
{
    wp_register_script('scs_js', scs_assets.'js/scs_script.js', array('jquery'), '1.0');
    //wp_register_script('scs_tinymce_js', 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.1/tinymce.min.js', array('jquery'), '1.0');
    wp_localize_script('scs_js', 'wpAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_enqueue_script('jquery');
    wp_enqueue_script('scs_js');
    //wp_enqueue_script('scs_tinymce_js');

}


//add_action('admin_enqueue_scripts', 'scs_scripts');
add_action('wp_enqueue_scripts', 'scs_scripts');
add_action('admin_print_styles', 'scs_style');
add_action('wp_enqueue_scripts', 'scs_style');


