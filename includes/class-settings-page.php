<?php
if( !defined('ABSPATH')){
    exit; // Exit if access directly
}

if( !class_exists( 'WPSWP_Settings_Page' ) ){
    class WPSWP_Settings_Page{
        public function __construct(){
            add_action( 'admin_menu', [$this, 'wpswp_setting_admin_menu'] );
            add_action( 'admin_init', [$this, 'wpswp_register_setting'] );
        }

        /**
         * Register a custom menu page.
         */
        public function wpswp_setting_admin_menu(){
            add_menu_page( 
                __( 'WP Settings & Widget Page','wpswp' ), // Page title
                __( 'WP Settings & Widget Page','wpswp' ), // Menu title
                'manage_options', // Capability
                'wp-settings-widget-page', // Menu Page Slug
                array( $this,'wp_settings_page_html' ) // Callback Function
            );
        }

        /**
         * Display custom menu page.
         */
        public function wp_settings_page_html(){
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'WP Settings & Widget Page', 'wpswp' );?></h1>
            <?php settings_errors(); ?>
            <form action="options.php" method="post">
                <?php
                    settings_fields( 'wpswp_settings_group' );
                    do_settings_sections( 'wp-settings-widget-page' );
                    submit_button();
                ?>
            </form>
        </div>
        <?php
        }

        /**
         * Regiater a settings
         */
        public function wpswp_register_setting(){
            register_setting( 
                'wpswp_settings_group', // Group Name
                'wpswp_settings' // Option name
            );

            add_settings_section( 
                'wpswp_settings_section', // Section ID
                '', // Section title
                '', // Callback
                'wp-settings-widget-page', // Menu page slug 
            );

            add_settings_field( 
                'title', // Field ID
                __( 'Title', 'wpswp' ), // Field Title
                array( $this, 'settings_field_html'), // Callback Function
                'wp-settings-widget-page', // Menu Page Slug
                'wpswp_settings_section', // Section ID
                array('id' => 'title') // Extra Args for callback function
            );

            add_settings_field( 
                'firstname', // Field ID
                __( 'First Name', 'wpswp' ), // Field Title
                array( $this, 'settings_field_html'), // Callback Function
                'wp-settings-widget-page', // Menu Page Slug
                'wpswp_settings_section', // Section ID
                array('id' => 'firstname') // Extra Args for callback function
            );

            add_settings_field( 
                'lastname', // Field ID
                __( 'Last Name', 'wpswp' ), // Field Title
                array( $this, 'settings_field_html'), // Callback Function
                'wp-settings-widget-page', // Menu Page Slug
                'wpswp_settings_section', // Section ID
                array('id' => 'lastname') // Extra Args for callback function
            );

            add_settings_field( 
                'gender', // Field ID
                __( 'Gender', 'wpswp' ), // Field Title
                array( $this, 'settings_field_html'), // Callback Function
                'wp-settings-widget-page', // Menu Page Slug
                'wpswp_settings_section', // Section ID
                array('id' => 'gender') // Extra Args for callback function
            );

        }

        /**
         * Setting form field html.
         */
        public function settings_field_html( $args ){
            $options = get_option('wpswp_settings');
            $id = $args['id'];
            switch ($id) {
                case 'gender':
                    $value = isset($options[$id]) ? $options[$id] : '';
                    echo '<select name="wpswp_settings[' . esc_attr($id) . ']">
                            <option value="Male" ' . selected($value, 'Male', false) . '>Male</option>
                            <option value="Female"
                             ' . selected($value, 'Female', false) . '>Female</option>
                          </select>';
                    break;
                default:
                    $value = isset($options[$id]) ? esc_attr($options[$id]) : '';
                    echo '<input type="text" name="wpswp_settings[' . esc_attr($id) . ']" value="' . $value . '" />';
                    break;
            }
        }
    }
}