<?php
/**
 * Plugin Name: Mobile Bottom Menu
 * Description: A simple plugin to add a mobile bottom menu with color-changing functionality when active.
 * Version: 1.1
 * Author: baraka byukuzenge manzi ya ruzigandengera
 */

if (!defined('ABSPATH')) {
    exit;
}

function mbm_enqueue_scripts() {
    wp_enqueue_style('mbm-style', plugin_dir_url(__FILE__) . 'css/mbm-style.css');
    wp_enqueue_script('mbm-script', plugin_dir_url(__FILE__) . 'js/mbm-script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'mbm_enqueue_scripts');

function mbm_register_settings_menu() {
    add_options_page(
        'Mobile Bottom Menu Settings',
        'Mobile Bottom Menu',
        'manage_options',
        'mbm-settings',
        'mbm_settings_page'
    );
}
add_action('admin_menu', 'mbm_register_settings_menu');

function mbm_register_settings() {
    register_setting('mbm_settings_group', 'mbm_menu_items');
}
add_action('admin_init', 'mbm_register_settings');

function mbm_settings_page() {
    $menu_items = get_option('mbm_menu_items', []);
    ?>
    <div class="wrap">
        <h1>Mobile Bottom Menu Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('mbm_settings_group'); ?>
            <table class="form-table">
                <?php for ($i = 0; $i < 5; $i++):
                    $item = isset($menu_items[$i]) ? $menu_items[$i] : ['label' => '', 'link' => '', 'color' => '#333333'];
                ?>
                <tr valign="top">
                    <th scope="row">Menu Item <?php echo $i + 1; ?></th>
                    <td>
                        <input type="text" name="mbm_menu_items[<?php echo $i; ?>][label]" value="<?php echo esc_attr($item['label']); ?>" placeholder="Label" />
                        <input type="text" name="mbm_menu_items[<?php echo $i; ?>][link]" value="<?php echo esc_attr($item['link']); ?>" placeholder="Link" />
                        <input type="color" name="mbm_menu_items[<?php echo $i; ?>][color]" value="<?php echo esc_attr($item['color']); ?>" />
                    </td>
                </tr>
                <?php endfor; ?>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function mbm_add_mobile_menu() {
    $menu_items = get_option('mbm_menu_items', []);
    if (empty($menu_items)) return;

    echo '<div id="mobile-bottom-menu">';
    foreach ($menu_items as $item) {
        if (!empty($item['label']) && !empty($item['link'])) {
            $label = esc_html($item['label']);
            $link = esc_url($item['link']);
            $color = esc_attr($item['color']);
            echo "<a href='{$link}' class='menu-item' data-color='{$color}'>{$label}</a>";
        }
    }
    echo '</div>';
}
add_action('wp_footer', 'mbm_add_mobile_menu');
