<?php
/**
 * Plugin Name: Virustracker
 * Plugin URI: http://www.virustracker.ch
 * Description: Website Portal for test verifications
 * Version: 1.0
 * Author: David Welten
 * Author URI: https://github.com/toworischtsch
 */
 
 
 
 
 
 
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
}

/**
 * Validate input is an URL
 */
function virustracker_plugin_options_validate( $input ) {
    $newinput['server_url'] = trim( $input['server_url'] );
    if ( ! preg_match( '%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $newinput['server_url'] ) ) {
        $newinput['server_url'] = 'error';
    }

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
    echo "<input size='300' id='virustracker_setting_server_url' name='virustracker_plugin_options[server_url]' type='text' value='".$options['server_url']."' />";//{esc_attr( $options['server_url'] )}'' />";
}
