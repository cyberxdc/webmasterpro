<?php

class WebMasterPro_Shortcodes
{
    public function __construct()
    {
        add_shortcode('webmasterpro_login_form', array($this, 'custom_login_form_shortcode'));
        add_shortcode('webmasterpro_registration_form', array($this, 'custom_registration_form_shortcode'));
        add_shortcode('webmasterpro_forgot_password_form', array($this, 'custom_forgot_password_form_shortcode'));
    }
    // Shortcode: Login Form
    public function custom_login_form_shortcode($atts)
    {
        // Extract shortcode attributes and set defaults
        $atts = shortcode_atts(
            array(
                'redirect' => home_url('/wp-admin'), // Default redirect to the home page
            ),
            $atts
        );

        // If the user is already logged in, display a message
        if (is_user_logged_in()) {
            return '<p>You are already logged in.</p>';
        } else {
            ob_start();

            // Output the WordPress login form with the custom redirect URL
            $args = array(
                'redirect' => esc_url($atts['redirect']),
            );
            wp_login_form($args);

            return ob_get_clean();
        }
    }

    // Shortcode: Registration Form
    public function custom_registration_form_shortcode($atts)
    {
        // Extract shortcode attributes and set defaults
        $atts = shortcode_atts(
            array(
                'redirect' => home_url('/wp-admin'), // Default redirect to the home page
            ),
            $atts
        );

        // If the user is already logged in, display a message
        if (is_user_logged_in()) {
            return '<p>You are already logged in.</p>';
        }

        // Check if registration is enabled
        if (!get_option('users_can_register')) {
            return '<p>Registration is currently disabled.</p>';
        }

        // Generate the registration URL with the custom redirect parameter
        $registration_url = esc_url(add_query_arg('redirect_to', $atts['redirect'], wp_registration_url()));

        return '<a href="' . $registration_url . '">Register</a>';
    }


    // Shortcode: Forgot Password Form
    public function custom_forgot_password_form_shortcode($atts)
    {
        // Extract shortcode attributes and set defaults
        $atts = shortcode_atts(
            array(
                'redirect' => home_url('/wp-admin'), // Default redirect to the home page
            ),
            $atts
        );

        // If the user is already logged in, display a message
        if (is_user_logged_in()) {
            return '<p>You are already logged in.</p>';
        }

        // Generate the lost password URL with the custom redirect parameter
        $forgot_password_url = esc_url(add_query_arg('redirect_to', $atts['redirect'], wp_lostpassword_url()));

        return '<a href="' . $forgot_password_url . '">Forgot Password</a>';
    }


    // Shortcodes Page Content
    public function webmasterpro_shortcodes_page()
    {
        $all_shortcodes = $this->get_all_shortcodes();
?>
        <div class="wrap">
            <div class="container">
                <div class="card">
                    <div style="max-width: 100%;" class="webmasterpro-header">
                        <h1>WebMasterPro Shortcodes</h1>
                        <p>Unlock the full potential of WordPress with WebMasterPro's comprehensive shortcode library. Seamlessly integrate essential functions like login, registration, and password recovery into your site's content. Compatible with popular plugin shortcodes, WebMasterPro empowers you to customize user experiences effortlessly. Streamline site management and enhance functionality with a versatile shortcode solution designed to optimize your WordPress workflow.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="card col">
                        <div class="card-header">
                            <h2>Custom Shortcodes</h2>
                            <p>These are custom shortcodes that you can use in your posts or pages.</p>
                            <br>
                        </div>
                        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f2f2f2;">
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Shortcode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Login Form</td>
                                    <td>Use this shortcode to display the WordPress login form on a custom page.</td>
                                    <td><code>[webmasterpro_login_form]</code></td>
                                </tr>
                                <tr>
                                    <td>Registration Form</td>
                                    <td>Use this shortcode to provide a link to the WordPress registration page.</td>
                                    <td><code>[webmasterpro_registration_form]</code></td>
                                </tr>
                                <tr>
                                    <td>Forgot Password Form</td>
                                    <td>Use this shortcode to provide a link to the WordPress forgot password page.</td>
                                    <td><code>[webmasterpro_forgot_password_form]</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card col">
                        <?php
                        if (!empty($all_shortcodes)) {
                            echo '<h2>List of WordPress Shortcodes in Posts:</h2>';
                            echo '<table style="width: 100%; border-collapse: collapse;">';
                            echo '<tr>';
                            echo '<th style="border: 1px solid #ddd; padding: 8px;">Shortcode</th>';
                            echo '<th style="border: 1px solid #ddd; padding: 8px;">Type</th>';
                            echo '<th style="border: 1px solid #ddd; padding: 8px;">Post ID</th>';
                            echo '<th style="border: 1px solid #ddd; padding: 8px;">Post Title</th>';
                            echo '<th style="border: 1px solid #ddd; padding: 8px;">Shortcode Description</th>';
                            echo '<th style="border: 1px solid #ddd; padding: 8px;">Post Type</th>';
                            echo '<th style="border: 1px solid #ddd; padding: 8px;">Permalink</th>';
                            echo '</tr>';

                            foreach ($all_shortcodes as $shortcode_info) {
                                echo '<tr>';
                                echo '<td style="border: 1px solid #ddd; padding: 8px;">[' . $shortcode_info['shortcode'] . ']</td>';
                                echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $shortcode_info['type'] . '</td>';
                                echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $shortcode_info['post_id'] . '</td>';
                                echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $shortcode_info['post_title'] . '</td>';
                                echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $shortcode_info['description'] . '</td>';
                                echo '<td style="border: 1px solid #ddd; padding: 8px;">' . $shortcode_info['post_type'] . '</td>';
                                echo '<td style="border: 1px solid #ddd; padding: 8px;"><a href="' . $shortcode_info['permalink'] . '">View Post</a></td>';
                                echo '</tr>';
                            }

                            echo '</table>';
                        } else {
                            echo '<p>No default WordPress shortcodes found in posts.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
<?php
    }

    // Retrieve all shortcodes used in posts
    private function get_all_shortcodes()
    {
        $all_shortcodes = array();

        // Get all posts
        $posts = get_posts(array('post_type' => 'any', 'posts_per_page' => -1));

        // Loop through each post and extract shortcodes
        foreach ($posts as $post) {
            $post_content = $post->post_content;

            // Regular expression to match shortcodes
            preg_match_all('/\[(\w+)[^\]]*\]/', $post_content, $matches);

            // Check if any matches are found
            if (!empty($matches[1])) {
                foreach ($matches[1] as $shortcode) {
                    // Check if the shortcode exists in the list of default WordPress shortcodes
                    if (shortcode_exists($shortcode)) {
                        $all_shortcodes[] = array(
                            'shortcode' => $shortcode,
                            'post_id' => $post->ID,
                            'post_title' => get_the_title($post),
                            'post_type' => get_post_type($post),
                            'permalink' => get_permalink($post),
                            'description' => '', // Placeholder for shortcode description
                            'type' => 'Default',
                        );
                    }
                }
            }
        }

        return $all_shortcodes;
    }
}

// Instantiate the class
$webmasterpro_shortcodes = new WebMasterPro_Shortcodes();

// test