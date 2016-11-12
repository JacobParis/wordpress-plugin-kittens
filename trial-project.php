<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.jacobpariseau.com/plugin-trial-project/
 * @since             1.0.0
 * @package           Trial_Project
 *
 * @wordpress-plugin
 * Plugin Name:       Trial Project
 * Plugin URI:        https://github.com/JacobPariseau/trial-project
 * Description:       This allows you to feature a reddit post on your site
 * Version:           1.0.0
 * Author:            Jacob Pariseau
 * Author URI:        http://jacobpariseau.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       trial-project
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-trial-project-activator.php
 */
function activate_trial_project() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-trial-project-activator.php';
	Trial_Project_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-trial-project-deactivator.php
 */
function deactivate_trial_project() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-trial-project-deactivator.php';
	Trial_Project_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_trial_project' );
register_deactivation_hook( __FILE__, 'deactivate_trial_project' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-trial-project.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_trial_project() {

	$plugin = new Trial_Project();
	$plugin->run();

}
run_trial_project();

function printr ( $object) {
  print ( '<pre>' )  ;
  print_r ( $object ) ;
  print ( '</pre>' ) ;
}
