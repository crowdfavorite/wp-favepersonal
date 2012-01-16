<?php

/**
 * new WordPress Widget format
 * WordPress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class CFCP_About_Widget extends WP_Widget {
	
    /**
     * Constructor
     *
     * @return void
     **/
	function CFCP_About_Widget() {
		$widget_ops = array( 'classname' => 'bio-box', 'description' => __('Shows photos, bio text, and links. Populated under Bio Widget appearance menu.', 'favepersonal') );
		$this->WP_Widget( 'cfcp-about', __('Bio', 'favepersonal'), $widget_ops );
	}

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme 
     * @param array  An array of settings for this widget instance 
     * @return void Echoes it's output
     **/
	function widget( $args, $instance ) {
		
		$settings = cfcp_about_get_settings();
		extract( $args, EXTR_SKIP );
		
		echo $before_widget;
		include('view.php');
		echo $after_widget;
	}

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings 
     * @return array The validated and (if necessary) amended settings
     **/
	function update( $new_instance, $old_instance ) {
		// update logic goes here
		$updated_instance = $new_instance;
		return $updated_instance;
	}

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
	function form( $instance ) {
		echo '<p>'.sprintf(__('The settings for this widget are <a href="%s">managed on this page</a>.', 'favepersonal'), admin_url('themes.php?page=about.php')).'</p>';
	}
}

add_action( 'widgets_init', create_function( '', "register_widget('CFCP_About_Widget');" ) );

?>