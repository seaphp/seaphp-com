<?php
add_action( 'widgets_init', 'register_my_widget' );

class Meetup_Event_Widget extends WP_Widget
{
	function __construct() {
		$widget_options = array(
			'classname' => 'meetup-event-widget'
			,'description' => __('Display the next upcoming event', 'site-plugin')
		);

		$control_options = array(
			'width' => '400px'
		);

		parent::__construct(
			'meetup-event-widget-id',            // Base ID
			__( 'Meetup Event Widget', 'site-plugin' ), // Name
			$widget_options,
			$control_options
		);
	}

	/**
	 * Outputs the form on sidebar admin
	 *
	 * @param array $instance The widget options
	 */
	function form( $instance ) {
		$instance = array_merge(
			array(
				'group_name' => '',
				'quantity' => ''
			),
			$instance
		);
	?>
	<p>
		Paragraph goes here.
	</p>
	<div>
		<label for="<?php echo $this->get_field_id( 'group_name' ); ?>">Group Name</label>
		<input type="text" class="widefat"
		id="<?php echo $this->get_field_id( 'group_name' ); ?>"
		name="<?php echo $this->get_field_name( 'group_name' ); ?>"
		value="<?php echo $instance['group_name']; ?>">
	</div>
	<div>
		<label for="<?php echo $this->get_field_id( 'quantity' ); ?>">Quantity</label>
		<input type="email" class="widefat"
		id="<?php echo $this->get_field_id( 'quantity' ); ?>"
		name="<?php echo $this->get_field_name( 'quantity' ); ?>"
		value="<?php echo $instance['quantity']; ?>">
	</div>
	<?php
	}


	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		if ( ! empty( $new_instance['group_name'] ) ) {
			$instance['group_name'] = strip_tags( $new_instance['group_name'] ) ;
		} else {
			$instance['group_name'] = $old_instance['group_name'];
		}

		if ( ( ! empty( $new_instance['quantity'] ) ) ) {
			$instance['quantity'] = strip_tags( $new_instance['quantity'] );
		} else {
			$instance['quantity'] = $old_instance['quantity'];
		}

		return $instance;
	}


	/**
	 * Processing widget options on save
	 *
	 * @return array $events
	 */
	protected function get_events_from_meetup() {
		$meetup = new Meetup(array( 'key' => '4d481b7545163a69551f6e6f492357' ));
		$meetup_group = 'php-49';

		$events = $meetup->getEvents(array( 'group_urlname' => $meetup_group ));


		return $events;
	}


	/**
	 * Retrieve the events from the WordPress option
	 *
	 * @param int $quantity
	 * @return array $events
	 */
	function get_events($quantity = 3) {
		$all_events = get_option( 'meetup_events', array() );

		if ( $all_events && ( isset( $all_events[0] ) && $all_events[0]->duration  )) {

			// Calculate when the event ends
			$end_time = ($all_events[0]->time + $all_events[0]->duration / 1000);

			if ( $end_time > time() ) {
				$all_events = $this->get_events_from_meetup();

				update_option( 'meetup_events', $all_events );
			}
		}
		$events = array_slice($all_events, 0, $quantity);

		return $events;
	}



	/**
	 * Retrieve google map url
	 *
	 * @param stdClass $venue
	 * @return string $url
	 */
	protected function google_map_url( stdClass $venue ) {
		$address = urlencode( $venue->address_1 );
		$city  = urlencode( $venue->city );
		$state = (isset( $venue->state) ) ? urlencode( $venue->state ) : 'WA';

		$map_url = "https://www.google.com/maps/dir/%s,+%s,+%s/";

		$url = sprintf( $map_url, $address, $city, $state );

		return $url;
	}



	/**
	 * Outputs the content of the widget
	 *
	 * @param array $arg
	 * @param array $instance
	 */
	function widget($arg, $instance) {
		$cal_format  = '<span class="month">%b</span><span class="day">%d</span>';

		$events = $this->get_events();
		$widget_title = apply_filters( 'widget_title', $arg['widget_name'] );

		echo $arg['before_widget'];
		if ( ! empty( $arg['widget_name'] ) ) {
			echo $arg['before_title'] . $widget_title . $arg['after_title'];
		}

		foreach ( $events AS $event ) {
			$event_date_utc = date( 'c', $event->time / 1000 );
			$event_date_cal  = strftime( $cal_format, $event->time / 1000 );

			$map_url = $this->google_map_url( $event->venue );
			?>
			<div class="h-event">
				<time class="dt-start" datetime="<?php echo $event_date_utc; ?>">
					<?php echo $event_date_cal; ?>
				</time>
				<div class="event-content">
					<?php ?>
					<h3 class="p-name"><?php echo $event->name; ?></h3>
					<span class="p-location"><?php echo $event->venue->name; ?></span>
					<a href="<?php echo $map_url; ?>">(Map)</a>
				</div>
			</div>
			<?php
		}

		echo $arg['after_widget'];
	}
}


function register_my_widget() {
	register_widget( 'Meetup_Event_Widget' );
}

