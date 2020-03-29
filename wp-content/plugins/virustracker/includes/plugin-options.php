<?PHP
 /**
  * Plugin Options
  */
  // Listeners
add_action('admin_menu', 'virustracker_menu');
add_action( 'admin_init', 'virustracker_register_settings' );

/**
 * Create Admin-menu entry
 */
function virustracker_menu() {
	add_menu_page('Virustracker Settings', 'Virustracker', 'administrator', 'virustracker-settings', 'virustracker_settings_page', 'dashicons-heart');
}
 /**
  * The options page wich is rendered 
  */
function virustracker_settings_page() {
  //     ?>
    <h2>Virustracker Settings</h2>
    <form action="options.php" method="post">
        <?php 
        settings_fields( 'virustracker_plugin_options' );
        do_settings_sections( 'virustracker_plugin' ); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
    </form>
    <?php
}
/**
 * Register the settings
 */
function virustracker_register_settings() {
    register_setting( 'virustracker_plugin_options', 'virustracker_plugin_options', 'virustracker_plugin_options_validate' );
    add_settings_section( 'api_settings', 'API Settings', 'virustracker_section_text', 'virustracker_plugin' );

    add_settings_field( 'virustracker_plugin_setting_serverURL', 'Cloud Functions URL', 'virustracker_plugin_setting_server_url', 'virustracker_plugin', 'api_settings' );
    add_settings_field( 'virustracker_plugin_setting_api_key', 'API Key', 'virustracker_plugin_setting_api_key', 'virustracker_plugin', 'api_settings' );
    add_settings_field( 'virustracker_plugin_setting_submit_page', 'Page ID to send the form to', 'virustracker_plugin_setting_submit_page', 'virustracker_plugin', 'api_settings' );

}

/**
 * Validate input is an URL
 */
function virustracker_plugin_options_validate( $input ) {

    $newinput['server_url'] = trim( $input['server_url'] );
    if ( ! preg_match( '%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $newinput['server_url'] ) ) {
        $newinput['server_url'] = 'error';
    }
    $newinput['api_key'] = $input['api_key'];
    $newinput['submit_page'] = $input['submit_page'];
    return $newinput;

}
/**
 * Text for the options
 */
function virustracker_section_text() {
    echo '<p>Here you can set all the options for using the API</p>';
}
 /**
  * Render the textfield for server url
  */
function virustracker_plugin_setting_server_url() {
    $options = get_option( 'virustracker_plugin_options' );
    echo "<input size='300' id='virustracker_setting_server_url' name='virustracker_plugin_options[server_url]' type='text' value='".$options['server_url']."' />";
}
 /**
  * Render the textfield for api key
  */
function virustracker_plugin_setting_api_key() {
    $options = get_option( 'virustracker_plugin_options' );
    
    echo "<input size='300' id='virustracker_setting_api_key' name='virustracker_plugin_options[api_key]' type='text' value='".$options['api_key']."' />";
}
 /**
  * Render the textfield for the page after submitting
  */
function virustracker_plugin_setting_submit_page() {
    $options = get_option( 'virustracker_plugin_options' );
    
    echo "<input size='300' id='virustracker_setting_submit_page' name='virustracker_plugin_options[submit_page]' type='text' value='".$options['submit_page']."' />";
}