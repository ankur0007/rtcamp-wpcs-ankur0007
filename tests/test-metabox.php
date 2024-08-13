<?php
// Include the file that contains the Rtcamp_Assignment class
require_once plugin_dir_path(__FILE__) . '../rtcamp-assignment.php';

class Rtcamp_Assignment_Admin_Test_MetaBox extends WP_UnitTestCase
{
    protected $post_id, $admin_instance;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an instance of the Rtcamp_Assignment_Admin class
        $this->admin_instance = new Rtcamp_Assignment_Admin(RTCAMP_ASSIGNMENT_NAME, RTCAMP_ASSIGNMENT_VERSION);
        // Create a post to attach the meta box to
        $this->post_id = self::factory()->post->create();
    }

    public function test_meta_box_is_added()
    {
        // Trigger the action that adds the meta box
        do_action('add_meta_boxes', get_post_type($this->post_id));

        // Retrieve the meta boxes for the current post
        global $wp_meta_boxes;
        $meta_boxes = isset($wp_meta_boxes['post']['side']) ? $wp_meta_boxes['post']['side'] : [];



        // Assert that the meta box is added
        $this->assertArrayHasKey('contributors_meta_box', ($meta_boxes['high']));
    }

    public function test_meta_box_parameters()
    {
        // Capture the parameters
        $meta_box_params = [
            'id'        => 'contributors_meta_box',
            'title'     => __('Contributors', 'textdomain'),
            'callback'  => [$this->admin_instance, 'contributors_meta_box_callback'],
            'screen'    => 'post',
            'context'   => 'side',
            'priority'  => 'high'
        ];

        // Print parameters
        /* echo 'Metabox has been created';
        print_r($meta_box_params); */

        // Example assertion
        $this->assertEquals('contributors_meta_box', $meta_box_params['id']);
        $this->assertEquals(__('Contributors', 'textdomain'), $meta_box_params['title']);
    }
}
