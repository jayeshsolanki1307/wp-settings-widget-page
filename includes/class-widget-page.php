<?php
if( !defined('ABSPATH')){
    exit; // Exit if access directly
}

if( !class_exists( 'WPSWP_Widget_Page' ) ){
    class WPSWP_Widget_Page extends WP_Widget {
        public function __construct() {
            parent::__construct(
                'wpswp_widget_page', // Our Widget ID
                'WPSWP Widget Page', // Our Widget Name
                // Our Widget Description.
                array(
                    'description' => __('A custom widget for WP Settings & Widget Page', 'wpswp')
                )
            );
           add_action('widgets_init', [ $this, 'register_widget'] );
        }

        /**
         * Register and load widget
         */
        public function register_widget() {
            register_widget('WPSWP_Widget_Page');
        }

        /**
         * Creating a widget for frontend
         */
        public function widget($args, $instance) {
            $title = !empty($instance['title']) ? $instance['title'] : '';
            $firstname = !empty($instance['firstname']) ? $instance['firstname'] : '';
            $lastname = !empty($instance['lastname']) ? $instance['lastname'] : '';
            $gender = !empty($instance['gender']) ? $instance['gender'] : '';
            $show_gender = !empty($instance['show_gender']) ? $instance['show_gender'] : '';

            echo $args['before_widget'];

            echo '<div class="wp-setting-widget">';
            echo '<h2>' . esc_html($title) . '</h2>';
            echo 'Hello, my name is ' . esc_html($firstname) . ' ' . esc_html($lastname);
            
            if (!empty($gender) && $show_gender == 'on') {
                echo ' and I am a ' . esc_html($gender);
            }
            
            echo '</div>';

            echo $args['after_widget'];
        }

        /**
         * Widget Settings form
         */
        public function form($instance) {
            $widget_title = $firstname = $lastname = $gender = '';

            // Retrieve options from settings
            $options = get_option('wpswp_settings');
            if (!empty($options)) {
                $widget_title = isset($options['title']) ? $options['title'] : '';
                $firstname = isset($options['firstname']) ? $options['firstname'] : '';
                $lastname = isset($options['lastname']) ? $options['lastname'] : '';
                $gender = isset($options['gender']) ? $options['gender'] : '';
            }

            $title = !empty($instance['title']) ? $instance['title'] : $widget_title;
            $firstname = !empty($instance['firstname']) ? $instance['firstname'] : $firstname;
            $lastname = !empty($instance['lastname']) ? $instance['lastname'] : $lastname;
            $gender = !empty($instance['gender']) ? $instance['gender'] : $gender;
            $show_gender = !empty($instance['show_gender']) ? $instance['show_gender'] : '';
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">
                    <?php _e('Title:','wpswp'); ?>
                </label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                    name="<?php echo $this->get_field_name('title'); ?>" 
                    type="text" value="<?php echo esc_attr($title); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('firstname'); ?>">
                    <?php _e('First Name:','wpswp'); ?>
                </label>
                <input class="widefat" id="<?php echo $this->get_field_id('firstname'); ?>"
                    name="<?php echo $this->get_field_name('firstname'); ?>" 
                    type="text" value="<?php echo esc_attr($firstname); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('lastname'); ?>">
                    <?php _e('Last Name:','wpswp'); ?>
                </label>
                <input class="widefat" id="<?php echo $this->get_field_id('lastname'); ?>"
                    name="<?php echo $this->get_field_name('lastname'); ?>" 
                    type="text" value="<?php echo esc_attr($lastname); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('gender'); ?>">
                    <?php _e('Gender:','wpswp'); ?>
                </label>
                <select class="widefat" id="<?php echo $this->get_field_id('gender'); ?>"
                    name="<?php echo $this->get_field_name('gender'); ?>">
                    <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </p>
            <p>
                <input class="checkbox" type="checkbox" <?php checked($show_gender, 'on'); ?>
                    id="<?php echo $this->get_field_id('show_gender'); ?>"
                    name="<?php echo $this->get_field_name('show_gender'); ?>" />
                <label for="<?php echo $this->get_field_id('show_gender'); ?>">
                    <?php _e('Display Gender Publicly?','wpswp'); ?>
                </label>
            </p>
            <?php
        }

        /**
         * Update widget data.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            $instance['firstname'] = (!empty($new_instance['firstname'])) ? strip_tags($new_instance['firstname']) : '';
            $instance['lastname'] = (!empty($new_instance['lastname'])) ? strip_tags($new_instance['lastname']) : '';
            $instance['gender'] = (!empty($new_instance['gender'])) ? strip_tags($new_instance['gender']) : '';
            $instance['show_gender'] = (!empty($new_instance['show_gender'])) ? strip_tags($new_instance['show_gender']) : '';

            return $instance;
        }
    }
}