<?php

$options = array(
    'header' => 'Header',
    'footer' => 'Footer'
);
if (!empty($_POST['scs_location']) && !empty($_POST['scs_text']) && !empty($_POST['scs_button_text']) && !empty($_POST['scs_bg_color']) && !empty($_POST['scs_bt_color'])) {
    $scs_data = array(
        'scs_location' => sanitize_text_field($_POST['scs_location']),
        'scs_text' => sanitize_text_field($_POST['scs_text']),
        'scs_button_text' => sanitize_text_field($_POST['scs_button_text']),
        'scs_button_background' => sanitize_hex_color($_POST['scs_bg_color']),
        'scs_button_action' => sanitize_url(get_permalink(get_option('wp_page_for_privacy_policy'))),
        'scs_button_color' => sanitize_hex_color($_POST['scs_bt_color'])
        
    );
    global $wpdb;
    $table_name = $wpdb->prefix . 'scs_settings';
    $wpdb->query("TRUNCATE TABLE $table_name");
    $wpdb->insert($table_name, $scs_data);
    $wpdb -> flush();
    
}
    global $wpdb;
    $table_name = $wpdb->prefix . 'scs_settings';
    $results = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name"));
    $content = $results[0]->scs_text;  
    $selected_option = $results[0]->scs_location;
?>

<form method="POST" action="" class="scs_backend_form">
    <label>Choose location:</label>
    <select name="scs_location" id=""><?php foreach ($options as $key => $value) { $selected = selected($selected_option, $value, false); echo '<option'. esc_attr($selected).'>' . esc_html($value) . '</option>';}  ?></select><br><br>
    <label>Enter text:</label><br><br>
    <!-- <textarea name="scs_text" id="myTextarea"></textarea> -->
    <?php  wp_editor( $content, 'scs_text' );?>
    <label>Enter button text:</label><br><br>
    <input type="text" name="scs_button_text" placeholder="" required value="<?php esc_attr_e($results[0]->scs_button_text);?>"><br><br>
    <label>Choose backgroumg color:</label>
    <input type="text" value="<?php esc_attr_e($results[0]->scs_button_background);?>">
    <input type="color" id="head" name="scs_bg_color" required value="<?php esc_attr_e($results[0]->scs_button_background);?>">
    <label>Choose button color:</label>
    <input type="text" value="<?php esc_attr_e($results[0]->scs_button_color);?>">
    <input type="color" id="head" name="scs_bt_color" required value="<?php esc_attr_e($results[0]->scs_button_color);?>"> <br> <br>
    <button class="submit-button" type="submit">Save Settings</button>
</form>

