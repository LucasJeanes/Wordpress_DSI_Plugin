<?php
/*
Plugin Name: Donation Ticker
Description: A plugin to display donation progress.
Version: 1.0
*/

$db_table_name = 'donation_entries';
$db_column_name = 'amount';

add_action('admin_menu', 'dsiregister_donation_bar_settings_page');

function dsiregister_donation_bar_settings_page() {
    add_menu_page(
        'DSI Donation Bar Settings',
        'Donation Bar',
        'manage_options',
        'dsi-donation-bar',
        'dsi_donation_bar_settings_page',
        'dashicons-admin-generic'
    );

	// Register settings
    add_action('admin_init', 'dsi_register_settings');
}

// Function to register settings
function dsi_register_settings() {
    register_setting('dsi-donation-bar-settings-group', 'dsi_fundraiser_name');
    register_setting('dsi-donation-bar-settings-group', 'dsi_target_amount');
	register_setting('dsi-donation-bar-settings-group', 'database_NAME');
	register_setting('dsi-donation-bar-settings-group', 'database_USER');
	register_setting('dsi-donation-bar-settings-group', 'database_PASSWORD');
	register_setting('dsi-donation-bar-settings-group', 'database_HOST');
	register_setting('dsi-donation-bar-settings-group', 'db_table_name');
	register_setting('dsi-donation-bar-settings-group', 'db_column_name');
	register_setting('dsi-donation-bar-settings-group', 'db_keyword');
}

// Settings page content
function dsi_donation_bar_settings_page() {
    ?>
    <div class="wrap">
        <h1>Down Syndrome Ireland's Donation Bar Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('dsi-donation-bar-settings-group'); ?>
            <?php do_settings_sections('dsi-donation-bar-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Fundraiser Name</th>
                    <td><input type="text" name="dsi_fundraiser_name" value="<?php echo esc_attr(get_option('dsi_fundraiser_name')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Target Amount</th>
                    <td><input type="number" name="dsi_target_amount" value="<?php echo esc_attr(get_option('dsi_target_amount')); ?>" /></td>
                </tr>
				<tr valign="top">
                    <th scope="row">Database - Name</th>
                    <td><input type="text" name="database_NAME" value="<?php echo esc_attr(get_option('database_NAME')); ?>" /></td>
                </tr>
				<tr valign="top">
                    <th scope="row">Database - Username</th>
                    <td><input type="text" name="database_USER" value="<?php echo esc_attr(get_option('database_USER')); ?>" /></td>
                </tr>
				<tr valign="top">
                    <th scope="row">Database - Password</th>
                    <td><input type="password" name="database_PASSWORD" value="<?php echo esc_attr(get_option('database_PASSWORD')); ?>" /></td>
                </tr>
				<tr valign="top">
                    <th scope="row">Database - Link Address</th>
                    <td><input type="text" name="database_HOST" value="<?php echo esc_attr(get_option('database_HOST')); ?>" /></td>
                </tr>
				<tr valign="top">
                    <th scope="row">Database - Donations Table Name</th>
                    <td><input type="text" name="db_table_name" value="<?php echo esc_attr(get_option('db_table_name')); ?>" /></td>
                </tr>
				<tr valign="top">
                    <th scope="row">Database - Donations Amount Column Name</th>
                    <td><input type="text" name="db_column_name" value="<?php echo esc_attr(get_option('db_column_name')); ?>" /></td>
                </tr>
				<tr valign="top">
                    <th scope="row">Database - Donations by filtered keyword</th>
                    <td><input type="text" name="db_keyword" value="<?php echo esc_attr(get_option('db_keyword')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Connect to the donations database
function connect_to_donations_db() {
	$database_HOST = get_option('database_HOST', 'localhost');
	$database_USER = get_option('database_USER', 'root');
	$database_PASSWORD = get_option('database_PASSWORD', '');
	$database_NAME = get_option('database_NAME', 'donations');
	
	//$connection = new mysqli(database_HOST, database_USER, database_PASSWORD, database_NAME);
	$connection = new mysqli($database_HOST, $database_USER, $database_PASSWORD, $database_NAME);
	if ($connection->connect_error) {
		die("Connection failed: " . $connection->connect_error);
	}
	return $connection;
}

// Fetch total donations
function get_total_donations() {
	$db_keyword = get_option('db_keyword', '');
	$db_table_name = get_option('db_table_name', 'donation_entries');
	$db_column_name = get_option('db_column_name', 'amount');
	
		$connection = connect_to_donations_db();
	if ($db_keyword) {
		$sql = sprintf("SELECT SUM(%s) AS total FROM %s WHERE fundraiser_type = '%s'", $db_column_name, $db_table_name, $db_keyword);
	} else {
		$sql = sprintf("SELECT SUM(%s) AS total FROM %s", $db_column_name, $db_table_name);
	}
		$result = $connection->query($sql);

	if (!$result) {
			error_log("Database query failed: " . $connection->error);
			return 0;
		}

		$row = $result->fetch_assoc();
		$connection->close();
		return $row['total'] ?? 0; // Use null coalescing to handle null values
}

// Display the donation ticker
function display_donation_ticker() {
    $fundraiser_name = get_option('dsi_fundraiser_name', 'Default Fundraiser');
    $total_donations = get_total_donations();
    $goal = get_option('dsi_target_amount', 5000); // Default goal is 5000 if not set
    $percentage = ($total_donations / $goal) * 100;
    if ($percentage > 100) $percentage = 100;

    ob_start();
    ?>
    <div id="donation-ticker">
		<div class="donation-title">
			<h3><?php echo esc_html($fundraiser_name); ?></h3>
		</div>
			<container class="fundraising-panel">
				<div class="progress-bar">
					<div class="progress" style="width: <?php echo $percentage; ?>%;"></div>
				</div>
				<div class="donation-info">
					<div class="raised">Raised: <?php echo number_format($total_donations, 2); ?></div>
					<div class="goal">Goal: <?php echo number_format($goal, 2); ?></div>
				</div>
			</container>
		</div>
    <?php
    return ob_get_clean();
}


// Shortcode to display the donation ticker
function donation_ticker_shortcode() {
		return display_donation_ticker();
}
add_shortcode('donation_ticker', 'donation_ticker_shortcode');

// Enqueue styles and scripts
function donation_ticker_assets() {
		wp_enqueue_style('donation-ticker-styles', plugin_dir_url(__FILE__) . 'css/style.css');
		wp_enqueue_script('donation-ticker-scripts', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), null, true);
		wp_localize_script('donation-ticker-scripts', 'donation_ticker_data', array('initialRaised' => get_total_donations(),
		));
}
add_action('wp_enqueue_scripts', 'donation_ticker_assets');
?>
