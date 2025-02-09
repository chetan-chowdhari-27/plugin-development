<?php
/**
 * Settings Page for Portfolio Plugin.
 */

// Add settings page under "Settings > Portfolio Settings".
function portfolio_plugin_create_menu() {
    add_options_page(
        __( 'Portfolio Plugin Settings', 'portfolio-plugin' ),
        __( 'Portfolio Settings', 'portfolio-plugin' ),
        'manage_options',
        'portfolio-plugin-settings',
        'portfolio_plugin_settings_page'
    );
}
add_action( 'admin_menu', 'portfolio_plugin_create_menu' );

// Initialize plugin settings.
function portfolio_plugin_settings_init() {
    register_setting(
        'portfolio_plugin_options_group',
        'portfolio_plugin_options',
        'portfolio_plugin_sanitize_options'
    );

    add_settings_section(
        'portfolio_plugin_section_id',
        __( 'General Settings', 'portfolio-plugin' ),
        'portfolio_plugin_section_callback',
        'portfolio-plugin-settings'
    );

    // Field: Items Per Page.
    add_settings_field(
        'portfolio_plugin_items_per_page',
        __( 'Items Per Page', 'portfolio-plugin' ),
        'portfolio_plugin_items_per_page_field_callback',
        'portfolio-plugin-settings',
        'portfolio_plugin_section_id'
    );
}
add_action( 'admin_init', 'portfolio_plugin_settings_init' );

function portfolio_plugin_section_callback() {
    echo '<p>' . __( 'Set your portfolio plugin preferences here.', 'portfolio-plugin' ) . '</p>';
}

// Render the "Items Per Page" field.
function portfolio_plugin_items_per_page_field_callback() {
    $options = get_option( 'portfolio_plugin_options' );
    $items_per_page = isset( $options['items_per_page'] ) ? intval( $options['items_per_page'] ) : 10;
    echo '<input type="number" name="portfolio_plugin_options[items_per_page]" value="' . esc_attr( $items_per_page ) . '" size="5" />';
}

// Sanitize the settings input.
function portfolio_plugin_sanitize_options( $input ) {
    $sanitized = array();
    if ( isset( $input['items_per_page'] ) ) {
        $sanitized['items_per_page'] = absint( $input['items_per_page'] );
    }
    return $sanitized;
}

/**
 * Render the settings page.
 */

function portfolio_plugin_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php _e( 'Portfolio Plugin Settings', 'portfolio-plugin' ); ?></h1>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'portfolio_plugin_options_group' );
                do_settings_sections( 'portfolio-plugin-settings' );
                submit_button();
            ?>
        </form>
        <hr>
        <h2><?php _e( 'Shortcode', 'portfolio-plugin' ); ?></h2>
        <p><?php _e( 'Copy and paste the following shortcode into your pages or posts to display the portfolio filter:', 'portfolio-plugin' ); ?></p>
        <input type="text" readonly value="[portfolio_filter]" onclick="this.select();" style="width: 100%; padding: 10px; font-size: 16px;">
    </div>
    <?php
}
