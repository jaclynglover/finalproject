<?php
	/* =================	
		CONNECT TO STRAVA
	   =================
	*/	
	function display_strava_connect() {
		?>
			<ol>
				<li> Please create a application on Strava first! Follow this <a target="_new" href="http://www.strava.com/developers">link here</a>. It is also important to make sure that the redirect URI you enter is the same as your site.</li>
				<li> After creating the application enter the Client ID and Secret in the fields below.</li>
				<li> Finally please click the Strava Connect Button and allow access. After successful authorization, you will be automatically be redirected to this settings page </li>
			</ol>
			<?php 
				$api = new StravaApi(4104);
				echo '<p><a href="' . $api->authenticationUrl(SETTINGS_HOME_URL) . '"><img src="' . CONNECT_WITH_STRAVA . '"></a></p>';
	}
	
	function display_client_id() {
		display_input('client_id');
	}
	
	function display_client_secret() {
		display_input('client_secret');
	}
	
	function display_input($id) {
		$options = wp_parse_args( get_option( 'strava_settings_connect' ), array($id => ''));
		echo "<input id='" . $id. "' name='strava_settings_connect[" . $id . "]' class='regular-text code' type='text' value='" . $options[$id] . "'>";
	}
	
	function display_strava_oauth() {
		$options = wp_parse_args(get_option( 'strava_settings_connect' ), array('strava_oauth' => ''));
		$access_token = $options['strava_oauth'];
		if (empty($access_token)) {
			if (isset($_GET['code'])) {
				$code = $_GET['code'];
				$client_id = $options['client_id'];
				$client_secret = $options['client_secret'];
			
				$api = new StravaApi($client_id, $client_secret);
				$resp = $api->tokenExchange($code);
				if (empty($resp->access_token)) {
					 echo "<code> Problem receiving access token. Please make sure that Client ID and Secret is correct </code>";
				} else {
					$options['strava_oauth'] = 	$resp->access_token;
					update_option('strava_settings_connect', $options);
				}
			}
		} 
		
		echo "<input id='strava_oauth' name='strava_settings_connect[strava_oauth]' class='regular-text code' type='text' readonly='true' value='" . $options['strava_oauth'] . "'>";
	}
?>