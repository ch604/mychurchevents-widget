<?php
/*
Plugin Name: MyChurchEvents Widget
Description: Collects weekly calendar data from mychurchevents.com
Author: Andrej Walilko
*/

class ChurchCalWidget extends WP_Widget
{
        function ChurchCalWidget()
        {
                $widget_ops = array('classname' => 'ChurchCalWidget', 'description' => 'Displays weekly calendar data from mychurchevents.com' );
                $this->WP_Widget('ChurchCalWidget', 'MyChurchEvents.com Calendar Widget', $widget_ops);
        }

        function form($instance)
        {
                $instance = wp_parse_args( (array) $instance, array( 'title' => 'Upcoming Events', 'cid' => '') );
                $title = $instance['title'];
                $cid = $instance['cid'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('cid'); ?>">Church ID (ci): <input class="widefat" id="<?php echo $this->get_field_id('cid');?>" name="<?php echo $this->get_field_name('cid'); ?>" type="text" value="<?php echo attribute_escape($cid); ?>" /></label></p>
<?php
        }

        function update($new_instance, $old_instance)
        {
                $instance = $old_instance;
                $instance['title'] = $new_instance['title'];
                $instance['cid'] = $new_instance['cid'];
                return $instance;
        }

        function widget($args, $instance)
        {
                extract($args, EXTR_SKIP);

                echo $before_widget;
                $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

                if (!empty($title))
                        echo $before_title . $title . $after_title;;

                echo '<iframe width="250" height="550" frameborder="0" src="http://www.mychurchevents.com/calendar/views/listview.aspx?ci=' . $instance['cid'] . '&list_by=dayspan&DayCount=7&select_by=all_interest_groups&igd="></iframe><br><br>';
                echo '<a href="http://www.mychurchevents.com/calendar/calendar.aspx?ci=' . $instance['cid'] . '" target="_blank">Monthly Calendar Link</a>';

                echo $after_widget;
        }
}
add_action( 'widgets_init', create_function('', 'return register_widget("ChurchCalWidget");') );?>
