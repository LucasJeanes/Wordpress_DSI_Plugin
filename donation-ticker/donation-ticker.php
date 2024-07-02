<?php
/*
Plugin Name: Donation Ticker
Description: A plugin to display donation progress.
Version: 1.0
Author: Your Name
*/

// Database credentials for the donations database
define('database_NAME', 'donations');
define('database_USER', 'root');
define('database_PASSWORD', '');
define('database_HOST', 'localhost');

// Connect to the donations database
function connect_to_donations_db() {
		$connection = new mysqli(database_HOST, database_USER, database_PASSWORD, database_NAME);
		if ($connection->connect_error) {
			die("Connection failed: " . $connection->connect_error);
		}
	return $connection;
}

// Fetch total donations
function get_total_donations() {
		$connection = connect_to_donations_db();
		$sql = "SELECT SUM(amount) AS total FROM donation_entries";
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
	 $total_donations = get_total_donations();
	 $goal = 5000; // Example goal
	 $percentage = ($total_donations / $goal) * 100;
	if ($percentage > 100) $percentage = 100;
	
	ob_start();
		?>
		<div id="donation-ticker">
			<h3>Ice Cream Fundays</h3>
			<container class="fundraising-panel">
				<div class="progress-bar">
					<div class="progress" style="width: <?php echo $percentage; ?>%;"></div>
				</div>
				<div class="donation-info">
						Raised: <?php echo number_format($total_donations, 2); ?>
						Goal: <?php echo number_format($goal, 2); ?>
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
