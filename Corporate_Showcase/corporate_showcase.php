<?php
/**
 * Plugin Name: Charity Corporate Partners
 * Description: Displays a tile layout of a charity's corporate partners with an admin interface to manage them.
 * Version: 1.0
 * Author: Your Name
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Register settings menu
function ccp_register_settings_menu() {
    add_menu_page(
        'Corporate Partners',
        'Corporate Partners',
        'manage_options',
        'corporate-partners',
        'ccp_settings_page',
        'dashicons-businessman',
        30
    );
}
add_action('admin_menu', 'ccp_register_settings_menu');

// Settings page content
function ccp_settings_page() {
    ?>
    <div class="wrap">
        <h1>Corporate Partners</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('ccp_settings_group');
            do_settings_sections('corporate-partners');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings and fields
function ccp_register_settings() {
    register_setting('ccp_settings_group', 'ccp_partners');

    add_settings_section(
        'ccp_settings_section',
        'Manage Corporate Partners',
        'ccp_settings_section_callback',
        'corporate-partners'
    );

    add_settings_field(
        'ccp_partners_field',
        'Corporate Partners',
        'ccp_partners_field_callback',
        'corporate-partners',
        'ccp_settings_section'
    );
}
add_action('admin_init', 'ccp_register_settings');

function ccp_settings_section_callback() {
    echo '<p>Add, edit, or remove corporate partners.</p>';
}

function ccp_partners_field_callback() {
    $partners = get_option('ccp_partners', array());
    ?>
    <div id="ccp-partners-container">
        <?php foreach ($partners as $index => $partner) : ?>
            <div class="ccp-partner">
                <label>Name: <input type="text" name="ccp_partners[<?php echo $index; ?>][name]" value="<?php echo esc_attr($partner['name']); ?>" /></label>
                <label>Description: <textarea name="ccp_partners[<?php echo $index; ?>][description]"><?php echo esc_textarea($partner['description']); ?></textarea></label>
                <label>Logo URL: <input type="text" name="ccp_partners[<?php echo $index; ?>][logo]" value="<?php echo esc_attr($partner['logo']); ?>" /></label>
                <button type="button" class="button remove-partner">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-partner" class="button">Add Partner</button>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let container = document.getElementById('ccp-partners-container');
        let addBtn = document.getElementById('add-partner');
        addBtn.addEventListener('click', function () {
            let index = container.children.length;
            let partnerDiv = document.createElement('div');
            partnerDiv.className = 'ccp-partner';
            partnerDiv.innerHTML = `
                <label>Name: <input type="text" name="ccp_partners[${index}][name]" /></label>
                <label>Description: <textarea name="ccp_partners[${index}][description]"></textarea></label>
                <label>Logo URL: <input type="text" name="ccp_partners[${index}][logo]" /></label>
                <button type="button" class="button remove-partner">Remove</button>
            `;
            container.appendChild(partnerDiv);
            partnerDiv.querySelector('.remove-partner').addEventListener('click', function () {
                container.removeChild(partnerDiv);
            });
        });
        container.querySelectorAll('.remove-partner').forEach(function (btn) {
            btn.addEventListener('click', function () {
                container.removeChild(btn.closest('.ccp-partner'));
            });
        });
    });
    </script>
    <style>
    .ccp-partner {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ccc;
        background: #f9f9f9;
    }
    .ccp-partner label {
        display: block;
        margin-bottom: 5px;
    }
    .ccp-partner label input,
    .ccp-partner label textarea {
        width: 100%;
    }
    </style>
    <?php
}

// Shortcode to display corporate partners
function ccp_display_partners($atts) {
    $partners = get_option('ccp_partners', array());
    $output = '<div class="corporate-partners">';
    foreach ($partners as $partner) {
        $output .= '<div class="partner-tile">';
        $output .= '<img src="' . esc_url($partner['logo']) . '" alt="' . esc_attr($partner['name']) . '" />';
        $output .= '<h3>' . esc_html($partner['name']) . '</h3>';
        $output .= '<p>' . esc_html($partner['description']) . '</p>';
        $output .= '</div>';
    }
    $output .= '</div>';
    return $output;
}
add_shortcode('corporate_partners', 'ccp_display_partners');

// Enqueue styles
function ccp_enqueue_styles() {
    wp_enqueue_style('ccp-styles', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'ccp_enqueue_styles');
?>
