<?php
	require_once( STRAVA_FOR_WP_PLUGIN_DIR . 'libs/StravaApi.php' );

	
	add_shortcode('strava', 'strava_shortcode');
	
	function strava_shortcode($atts) {
		$atts = shortcode_atts(
			array( 
				'id' => ''
			), $atts);

		if (empty($atts['id'])) {
			return;
		}	
		
		$options = get_option( 'strava_settings_connect' );
		$general = get_option( 'strava_settings' );


		$api = new StravaApi();
		$api->setAccessToken($options['strava_oauth']);
		
		$activity = $api->getActivity($atts['id']);
		
		$template = $general['strava_template'];

		$template = str_replace("[distance]", strava_distance($activity, $general), $template);
		$template = str_replace("[elevation]", strava_elevation($activity, $general), $template);
		$template = str_replace("[time]", strava_time($activity), $template);
		$template = str_replace("[duration]", strava_duration($activity), $template);
		$template = str_replace("[name]", strava_name($activity), $template);
		$template = str_replace("[location]", strava_location($activity), $template);
		$template = str_replace("[description]", strava_description($activity), $template);
		$template = str_replace("[speed]", strava_speed($activity, $general), $template);
		$template = str_replace("[type]", strava_type($activity), $template);	
		return $template;
	}	
	
	function strava_time($activity) {
		return date("d.m.Y H:i:s", strtotime($activity->start_date_local));
	}

	function strava_duration($activity) {
		return gmdate("H:i:s", $activity->moving_time);
	}

	
	function strava_speed($activity, $options) {
		
		if (strtolower($activity->type) == 'ride') {
			if ($options['strava_unit'] == 'metric') {
				return round( $activity->average_speed * 3.6, 2 ) . ' km/h';
			}
			
			if ($options['strava_unit'] == 'imperial') {
				return round( $activity->average_speed * 2.23693629, 2 ) . ' mile/h';
			}
		}
		
		if (strtolower($activity->type) == 'run') {
			if ($options['strava_unit'] == 'metric') {
				
				$pacedezimal = 16.66666666 / $activity->average_speed;
				list($min, $sec) = explode(".", $pacedezimal);
				
				$sec = '0.' . $sec;
				$sec = str_pad(round($sec *60, 0), 2 ,'0', STR_PAD_LEFT);
				
				return $min . ':' . $sec .  ' min/km';
			}
			
			if ($options['strava_unit'] == 'imperial') {
				
				$pacedezimal = 26.8224 / $activity->average_speed;
				list($min, $sec) = explode(".", $pacedezimal);
				
				$sec = '0.' . $sec;
				$sec = str_pad(round($sec *60, 0), 2 ,'0', STR_PAD_LEFT);
								
				return $min . ':' . $sec .  ' min/mile';
			}
			
		}

		return $activity->average_speed;
	}
	
	function strava_name($activity) {
		return $activity->name;
	}
	
	function strava_description($activity) {
		return $activity->description;
	}

	function strava_type($activity) {
		return $activity->type;
	}



	function strava_location($activity) {
		return $activity->location_city . ", " . $activity->location_CA . " " . $activity->location_country;
	}

	
	function strava_elevation ($activity, $options) {
		if ($options['strava_unit'] == 'metric') {
			return $activity->total_elevation_gain . ' hm';
		}
		
		if ($options['strava_unit'] == 'imperial') {
			return round( $activity->total_elevation_gain * 3.2808, 2 ) . ' feet';	
		}
		
	}
	
	function strava_distance ($activity, $options) {
		if ($options['strava_unit'] == 'metric') {
			return round( $activity->distance * .001, 2 ) . ' km';
		}
		
		if ($options['strava_unit'] == 'imperial') {
			return round( $activity->distance * .000621371, 2 ) . ' mi';	
		}
		
	}
	
	
	
	
?>