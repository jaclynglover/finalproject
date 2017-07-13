<?php
	define('CONNECT_WITH_STRAVA', STRAVA_FOR_WP_PLUGIN_URL .  'assets/ConnectWithStrava.png');
	define('SETTINGS_HOME_URL', home_url() . '/wp-admin/options-general.php?page=strava_for_wp_admin&tab=connect_to_strava');
	
	require_once( STRAVA_FOR_WP_PLUGIN_DIR . 'libs/StravaApi.php' );

	/* =================	
		ADMIN
	   =================
	*/		 
	add_action('admin_menu', 'strava_for_wp_tab');

	function strava_for_wp_tab() {
		add_options_page('Custom Strava Integration','Custom Strava Integration','manage_options','strava_for_wp_admin','strava_for_wp_admin_page');
	}
	
	function strava_for_wp_admin_page() {
		ob_start(); 
		$active_tab = isset($_GET['tab']) ? $_GET[ 'tab' ] : 'general_options';
		?>
		 
		<div class="wrap">
			<h1> Custom Strava Integration </h1>
			
			<h2 class="nav-tab-wrapper">
			    <a href="?page=strava_for_wp_admin&tab=general_options" class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>">General</a>
			    <a href="?page=strava_for_wp_admin&tab=connect_to_strava" class="nav-tab <?php echo $active_tab == 'connect_to_strava' ? 'nav-tab-active' : ''; ?>">Connect to Strava</a>
			</h2>
			
			<form action="options.php" method="post">

				<?php 
					
				
				 
				if( $active_tab == 'general_options' ) { 
					settings_fields('strava_for_wp_group-1');
					do_settings_sections('strava_settings'); 
				}
				if( $active_tab == 'connect_to_strava' ) { 
					settings_fields('strava_for_wp_group-2');
					 do_settings_sections('strava_connect'); 
				}
				submit_button(); ?>			
			</form>			
		</div>	
		<?php
			echo ob_get_clean();
	}	

	/* =================	
		SETTINGS
	   =================
	*/	
	add_action('admin_init','wp_strava_for_wp_settings');
	
	function wp_strava_for_wp_settings() {
		register_setting('strava_for_wp_group-1','strava_settings');
		register_setting('strava_for_wp_group-2','strava_settings_connect');
		
		add_settings_section('strava_connect', 'Connect to Your Strava Account', 'display_strava_connect', 'strava_connect');
		add_settings_field( 'strava_client_id', 'Client ID', 'display_client_id', 'strava_connect', 'strava_connect');
		add_settings_field( 'strava_client_secret', 'Client Secret', 'display_client_secret', 'strava_connect', 'strava_connect');
		add_settings_field( 'strava_oauth', 'Access Token', 'display_strava_oauth', 'strava_connect', 'strava_connect');
		
		add_settings_section('strava_settings', 'General Settings', 'display_strava_settings', 'strava_settings');
		add_settings_field( 'strava_unit', 'Display Unit', 'display_strava_unit', 'strava_settings', 'strava_settings');
		add_settings_field( 'strava_template', 'Template', 'display_strava_template', 'strava_settings', 'strava_settings');

	}
	
	require_once( STRAVA_FOR_WP_PLUGIN_DIR . 'admin/custom-strava-integration-general-settings.php' );
	require_once( STRAVA_FOR_WP_PLUGIN_DIR . 'admin/custom-strava-integration-connect-settings.php' );	
?>