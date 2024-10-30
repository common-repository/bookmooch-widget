<?php
/**
 * Plugin Name: BookMooch Widget
 * Plugin URI: http://montanamax.net/montanamax/plugins
 * Description: Incorporate Bookmooch widgets into your blog sidebars, or other widgetized areas.
 * Version: 0.2
 * Author: Jonathan "MontanaMax" Pruett
 * Author URI: http://montanamax.net
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'bookmooch_load_widgets' );

/**
 * Register our widget.
 *
 * @since 0.1
 */
function bookmooch_load_widgets() {
	register_widget( 'BookMooch_Widget' );
}

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class BookMooch_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function BookMooch_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wp-bookmooch-widget', 'description' => __('Display book covers or listings from your BookMooch inventory, wishlist, and mooched books list.', 'wp-bookmooch-widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 300, 'id_base' => 'bookmooch-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'bookmooch-widget', __('BookMooch Widget', 'wp-bookmooch-widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$bookmooch_username = $instance['bookmooch_username'];
		$bookmooch_widget_type = $instance['bookmooch_widget_type'];
		$bookmooch_widget_quantity = $instance['bookmooch_widget_quantity'];
		$bookmooch_widget_covers = isset( $instance['bookmooch_widget_covers'] ) ? '_cover' : '';
		$bookmooch_widget_random_order = isset( $instance['bookmooch_widget_random_order'] ) ? '_random' : '_recent';
		$bookmooch_widget_vertical = isset( $instance['bookmooch_widget_vertical'] ) ? '%3Cp%3E/' : '+/';

		/* Quietly clean up for limitation in current BookMooch widget code - mooched book list is only for recent books, not random */

		if ($bookmooch_widget_type == 'mooched')
			$bookmooch_widget_random_order = '_recent';

		$bookmooch_widget_url = 'http://widgets.bookmooch.com/widget/en/html/' . $bookmooch_widget_type . $bookmooch_widget_random_order . $bookmooch_widget_covers . '/' . $bookmooch_username . '/' . $bookmooch_widget_quantity . '/' . $bookmooch_widget_vertical;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Debugging aid - display the URL we are about to receive. 
		if ( $bookmooch_widget_url )
			echo '<p>' . $bookmooch_widget_url . '</p>';
		*/
		
		/* And here's where we actually include the properly configured widget from BookMooch */
		?> <?php include($bookmooch_widget_url) ; ?> 
		<p><a href="http://bookmooch.com" style="font-size:8pt" target="_blank">Exchange your books at BookMooch.</a></p>
		<?

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		/* No need to strip tags for select and checkbox inputs. */
		/* Here is where any data validation and cleanup needs to occur */

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['bookmooch_username'] = strip_tags( $new_instance['bookmooch_username'] );
		$instance['bookmooch_widget_type'] = $new_instance['bookmooch_widget_type'];
		$instance['bookmooch_widget_quantity'] = strip_tags( $new_instance['bookmooch_widget_quantity'] );
		$instance['bookmooch_widget_covers'] = $new_instance['bookmooch_widget_covers'];
		$instance['bookmooch_widget_random_order'] = $new_instance['bookmooch_widget_random_order'];
		$instance['bookmooch_widget_vertical'] = $new_instance['bookmooch_widget_vertical'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Books I am Giving Away', 'wp-bookmooch-widget'), 'bookmooch_username' => __('montanamax', 'wp-bookmooch-widget'), 'bookmooch_widget_quantity' => '5', 'bookmooch_widget_vertical'=>'true');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- BookMooch Username: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'bookmooch_username' ); ?>"><?php _e('BookMooch Username:', 'wp-bookmooch-widget'); ?></label>
			<input id="<?php echo $this->get_field_id( 'bookmooch_username' ); ?>" name="<?php echo $this->get_field_name( 'bookmooch_username' ); ?>" value="<?php echo $instance['bookmooch_username']; ?>" style="width:100%;" />
		</p>

		<!-- BookMooch Widget Type: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'bookmooch_widget_type' ); ?>"><?php _e('Widget Type:', 'wp-bookmooch-widget'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'bookmooch_widget_type' ); ?>" name="<?php echo $this->get_field_name( 'bookmooch_widget_type' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'inventory' == $instance['bookmooch_widget_type'] ) echo 'selected="selected"'; ?> value='inv'>Inventory - my books to give away</option>
				<option <?php if ( 'mooched' == $instance['bookmooch_widget_type'] ) echo 'selected="selected"'; ?> value='mooched'>Mooched - books I've received</option>
				<option <?php if ( 'wishlist' == $instance['bookmooch_widget_type'] ) echo 'selected="selected"'; ?> value='wishlist'>wishlist - books I'd like to find</option>
			</select>
		</p>

		<!-- BookMooch Widget Quanityt: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'bookmooch_widget_quantity' ); ?>"><?php _e('Number of books to display:', 'wp-bookmooch-widget'); ?></label>
			<input id="<?php echo $this->get_field_id( 'bookmooch_widget_quantity' ); ?>" name="<?php echo $this->get_field_name( 'bookmooch_widget_quantity' ); ?>" value="<?php echo $instance['bookmooch_widget_quantity']; ?>" style="width:100%;" />
		</p>

		<!-- BookMooch Display Covers: Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['bookmooch_widget_covers'], true ); ?> id="<?php echo $this->get_field_id( 'bookmooch_widget_covers' ); ?>" name="<?php echo $this->get_field_name( 'bookmooch_widget_covers' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'bookmooch_widget_covers' ); ?>"><?php _e('Display book covers?', 'wp-bookmooch-widget'); ?></label>
		</p>

		<!-- BookMooch Display in Random Order: Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['bookmooch_widget_random_order'], true ); ?> id="<?php echo $this->get_field_id( 'bookmooch_widget_random_order' ); ?>" name="<?php echo $this->get_field_name( 'bookmooch_widget_random_order' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'bookmooch_widget_random_order' ); ?>"><?php _e('Display in random order?', 'wp-bookmooch_widget_random_order-widget'); ?></label>
		</p>

		<!-- BookMooch Display Vertical: Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['bookmooch_widget_vertical'], true ); ?> id="<?php echo $this->get_field_id( 'bookmooch_widget_vertical' ); ?>" name="<?php echo $this->get_field_name( 'bookmooch_widget_vertical' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'bookmooch_widget_vertical' ); ?>"><?php _e('Display vertically?', 'wp-bookmooch_widget_vertical-widget'); ?></label>
		</p>

	<?php
	}
}

?>
