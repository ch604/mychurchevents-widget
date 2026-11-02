<?php
/*
Plugin Name: MyChurchEvents Widget
Description: Collects weekly calendar data from mychurchevents.com
Author: Andrej Walilko
Plugin URI: https://github.com/ch604/mychurchevents-widget
Version: 1.2
Requires PHP: 8.1
*/

class ChurchCalWidget extends WP_Widget
{
        public function __construct()
        {
                $widget_ops = array('classname' => 'ChurchCalWidget', 'description' => 'Displays weekly calendar data from mychurchevents.com' );
                parent::__construct('ChurchCalWidget', 'MyChurchEvents.com Calendar Widget', $widget_ops);
        }

        public function form($instance)
        {
                $instance = wp_parse_args( (array) $instance, array( 'title' => 'Upcoming Events', 'cid' => '') );
                $title = (string) $instance['title'];
                $cid = (string) $instance['cid'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('cid'); ?>">Church ID (ci): <input class="widefat" id="<?php echo $this->get_field_id('cid');?>" name="<?php echo $this->get_field_name('cid'); ?>" type="text" value="<?php echo esc_attr($cid); ?>" /></label></p>
<?php
        }

        public function update($new_instance, $old_instance)
        {
                $instance = $old_instance;
                $instance['title'] = sanitize_text_field($new_instance['title']);
                $instance['cid'] = sanitize_text_field($new_instance['cid']);
                return $instance;
        }

        public function widget($args, $instance)
        {
                $cid = rawurlencode((string) ($instance['cid'] ?? ''));

                echo $args['before_widget'];
                $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

                if (!empty($title))
                        echo $args['before_title'] . $title . $args['after_title'];

                echo '<iframe width="250" height="550" frameborder="0" src="https://www.mychurchevents.com/calendar/views/listview.aspx?ci=' . esc_attr($cid) . '&list_by=dayspan&DayCount=7&select_by=all_interest_groups&igd="></iframe><br><br>';
                echo '<a href="http://www.mychurchevents.com/calendar/calendar.aspx?ci=' . esc_attr($cid) . '" target="_blank">Monthly Calendar Link</a>';

                echo $args['after_widget'];
        }
}

add_action(
	'widgets_init',
	function() {
		register_widget("ChurchCalWidget");
	}
);
