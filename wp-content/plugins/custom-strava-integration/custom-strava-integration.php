<?php
	/*
		Plugin name: Custom Strava Integration
		Description: Do you want an easy way to post your strava ride/runs to your blog? Tired of the copy and paste solutions? This plugin provides an easy way to add your strava activities to your posts without leaving the site.
		Author: Florian Kimmel
		Author URI: 
		Version: 1.0
	*/
	
	define('STRAVA_FOR_WP_PLUGIN_DIR', plugin_dir_path(__FILE__));
	define('STRAVA_FOR_WP_PLUGIN_URL', plugin_dir_url(__FILE__));
	
	
	if (is_admin()) {
		require_once(STRAVA_FOR_WP_PLUGIN_DIR . 'custom-strava-integration-admin.php');
	}

	register_activation_hook(__FILE__,'prefill_options');
	
	function prefill_options() {
		$options = wp_parse_args( get_option('strava_settings'), array('strava_template' => ''));
		
		$html .= '<ul class="activity-detail">';
		$html .= ' <li class="strava-distance"> <span> Distance: [distance] </span>  </li>';
		$html .= ' <li class="strava-elevation"> <span> Elevation: [elevation] </span>  </li>';
		$html .= ' <li class="strava-time"> <span> Time: [time] </span>  </li>';
		$html .= ' <li class="strava-name"> <span> Location: [location] </span>  </li>';
		$html .= ' <li class="strava-location"> <span> Name: [name] </span>  </li>';						
		$html .= '</ul>';
		
		$options['strava_template'] = $html;
		$options['strava_unit'] = 'metric';
		update_option('strava_settings', $options);
	}
		
	require_once( STRAVA_FOR_WP_PLUGIN_DIR . 'custom-strava-integration-shortcode.php' );
	require_once( STRAVA_FOR_WP_PLUGIN_DIR . 'custom-strava-integration-metabox.php' );	
?>