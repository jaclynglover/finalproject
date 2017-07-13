<?php

class WPStrava_LatestMapWidget extends WP_Widget {

	private $som;

	public function __construct() {
		$this->som = WPStrava_SOM::get_som();

		parent::__construct(
	 		false,
			__( 'Strava Latest Map', 'wp-strava' ), // Name
			array( 'description' => __( 'Strava latest ride using static google map image', 'wp-strava' ) ) // Args.
		);
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'Latest Activity', 'wp-strava' );
		$distance_min = isset( $instance['distance_min'] ) ? esc_attr( $instance['distance_min'] ) : '';
		$strava_club_id = isset( $instance['strava_club_id'] ) ? esc_attr( $instance['strava_club_id'] ) : '';

		//provide some defaults
		//$ride_index_params = $ride_index_params ?: 'athleteId=21';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wp-strava' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'distance_min' ); ?>"><?php echo sprintf( __( 'Min. Distance (%s):', 'wp-strava' ), $this->som->get_distance_label() ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'distance_min' ); ?>" name="<?php echo $this->get_field_name( 'distance_min' ); ?>" type="text" value="<?php echo $distance_min; ?>" />
		</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'strava_club_id' ); ?>"><?php _e( 'Club ID (leave blank to show Athlete):', 'wp-strava' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'strava_club_id' ); ?>" name="<?php echo $this->get_field_name( 'strava_club_id' ); ?>" type="text" value="<?php echo $strava_club_id; ?>" />
			</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved from the admin
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['strava_club_id'] = strip_tags( $new_instance['strava_club_id'] );
		$instance['distance_min'] = strip_tags( $new_instance['distance_min'] );
		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Latest Activity', 'wp-strava' ) : $instance['title'] );
		$distance_min = $instance['distance_min'];
		$strava_club_id = empty( $instance['strava_club_id'] ) ? null : $instance['strava_club_id'];
		$build_new = false;

		// Try our transient first.
		$ride_transient = get_transient( 'strava_latest_map_ride' );
		$ride_option = get_option( 'strava_latest_map_ride' );

		$ride = $ride_transient ?: null;

		if ( ! $ride ) {
			$strava_rides = WPStrava::get_instance()->rides;
			$rides = $strava_rides->getRides( $strava_club_id );

			if ( is_wp_error( $rides ) ) {
				echo $before_widget;
				if ( WPSTRAVA_DEBUG ) {
					echo '<pre>';
					print_r($rides);
					echo '</pre>';
				} else {
					echo $rides->get_error_message();
				}
				echo $after_widget;
				return;
			}

			if ( ! empty( $rides ) ) {

				if ( ! empty( $distance_min ) )
					$rides = $strava_rides->getRidesLongerThan( $rides, $distance_min );

				$ride = current( $rides );

				//update transients & options
				if ( empty( $ride_option->id ) || $ride->id != $ride_option->id ) {
					$build_new = true;
					update_option( 'strava_latest_map_ride', $ride );
				}

				if ( empty( $ride_transient->id ) || $ride->id != $ride_transient->id ) {
					set_transient( 'strava_latest_map_ride', $ride, HOUR_IN_SECONDS );
				}
			}
		}

		if ( $ride ) {
			echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title;
			?><a title="<?php echo $ride->name ?>" target="_blank" href="http://app.strava.com/activities/<?php echo $ride->id ?>"><?php
			echo $this->getStaticImage( $ride->id, $build_new );
			?></a><?php
			echo $after_widget;
		}
	}


	private function getStaticImage( $ride_id, $build_new ) {
		$img = get_option( 'strava_latest_map' );

		if ( $build_new || ! $img ) {
			$ride = WPStrava::get_instance()->rides->getRide( $ride_id );
			$img = WPStrava_StaticMap::get_image_tag( $ride );
			update_option( 'strava_latest_map', $img );
		}

		return $img;
	}
}
