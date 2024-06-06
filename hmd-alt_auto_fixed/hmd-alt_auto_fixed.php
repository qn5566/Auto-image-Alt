<?php
/*
Plugin Name: HMD - Auto Image Alt Attribute
Plugin URI: https://github.com/qn5566/Auto-image-Alt/
Description: 自動加入alt到所有圖片裡面超爽.
Version: 1.1
Text Domain: hmd-alt_auto_fixed
Author: HimyDream CTO
Author URI: https://himydream.me/
License: GPL2
*/

function auto_image_alt($attr, $attachment = null){
    $alt_setting = get_option('auto_image_alt_setting', '');
    if (!isset($attr['alt']) || empty($attr['alt'])) {
        $attr['alt'] = !empty($alt_setting) ? $alt_setting : $attachment->post_title;
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'auto_image_alt', 10, 2);

function auto_image_alt_menu() {
    add_options_page('Auto Image Alt Setting/設定你想要的alt屬性', 'Auto Image Alt', 'manage_options', 'auto-image-alt', 'auto_image_alt_options');
}
add_action('admin_menu', 'auto_image_alt_menu');

function auto_image_alt_options() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    if (isset($_POST['auto_image_alt_setting'])) {
        update_option('auto_image_alt_setting', $_POST['auto_image_alt_setting']);
    }
    $alt_setting = get_option('auto_image_alt_setting', '');
    ?>
    <div class="wrap">
        <h2>Auto Image Alt Setting</h2>
        <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Alt Attribute/你想要的alt屬性</th>
                    <td><input type="text" name="auto_image_alt_setting" value="<?php echo esc_attr($alt_setting); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>
