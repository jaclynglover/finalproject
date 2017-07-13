<?php 
	/* =================	
		GENERAL STRAVA SETTINGS
	   =================
	*/	
	function display_strava_settings() {
			
	}

	function display_strava_unit() {
		$options = wp_parse_args( get_option('strava_settings'), array('strava_unit' => ''));
	
		echo '<select name="strava_settings[strava_unit]">';
		echo 	'<option value="imperial" ' . selected( $options['strava_unit'],'imperial') . '> Imperial (Miles/Feet)</option>';
		echo 	'<option value="metric" ' . selected( $options['strava_unit'],'metric') . '> Metric (KM/Meters) </option>';
		echo '</select>';
	}
	
	function display_strava_template() {
		$options = wp_parse_args( get_option('strava_settings'), array('strava_template' => ''));
		$html = $options['strava_template'];
		
		wp_editor($html, 'template_editor', array ("media_buttons" => false, 'textarea_name' => 'strava_settings[strava_template]'));
		
		echo "<h3> Possible Placeholders </h3>";
		echo "<ul>";
		echo "<li> <span style='font-weight:bold'> [distance] </span> Overall distance of the activity";
		echo "<li> <span style='font-weight:bold'> [description] </span> Description of the activity";		
		echo "<li> <span style='font-weight:bold'> [duration] </span> Duration of the activity";
		echo "<li> <span style='font-weight:bold'> [elevation] </span> Overall elevation of the activity";
		echo "<li> <span style='font-weight:bold'> [location] </span> Location of the activity";		
		echo "<li> <span style='font-weight:bold'> [name] </span> Name of the activity";		
		echo "<li> <span style='font-weight:bold'> [speed] </span> Depending on type (ride or run) - either running pace or riding speed";		
		echo "<li> <span style='font-weight:bold'> [time] </span> Local start time of the activity";
		echo "<li> <span style='font-weight:bold'> [type] </span> Type of the activity (run - ride - swim)";
		echo "</ul>";
	}
?>