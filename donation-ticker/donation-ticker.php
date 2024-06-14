<?php
/*
Plugin Name: Donation Ticker
Description: A simple donation ticker with progress bar.
Version: 1.0
Author: Your Name
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles
function dt_enqueue_scripts() {
    wp_enqueue_style('dt-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('dt-script', plugins_url('js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'dt_enqueue_scripts');

// Shortcode to display the donation ticker
function dt_donation_ticker($atts) {
    $atts = shortcode_atts(
        array(
            'raised' => 0,
            'target' => 1000,
        ), $atts, 'donation_ticker'
    );

    ob_start();
    ?>
    <div id="donation-ticker">
        <div class="progress-bar">
            <div class="progress" style="width: <?php echo ($atts['raised'] / $atts['target']) * 100; ?>%;"></div>
        </div>
        <div class="donation-info">
            Raised: $<span id="dt-raised"><?php echo $atts['raised']; ?></span> / $<span id="dt-target"><?php echo $atts['target']; ?></span>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('donation_ticker', 'dt_donation_ticker');
