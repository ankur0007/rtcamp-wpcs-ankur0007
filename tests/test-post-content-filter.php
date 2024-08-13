<?php

// Include the file that contains the Rtcamp_Assignment class
require_once plugin_dir_path(__FILE__) . '../rtcamp-assignment.php';

class PostContentFilterTest extends WP_UnitTestCase
{
    /**
     * Contains post ID
     *
     * @var int
     */
    private $postID;

    /**
     * Contains user IDs
     *
     * @var int
     */
    private $authorOneID, $authorTwoID;

    /**
     * Contains public instance of the class
     *
     * @var Rtcamp_Assignment_Public
     */
    private $public;

    public function setUp(): void
    {
        parent::setUp();

        // Instantiate the class to be tested
        $this->public = new Rtcamp_Assignment_Public(RTCAMP_ASSIGNMENT_NAME, RTCAMP_ASSIGNMENT_VERSION);

        // Create test users
        $author_one_data = [
            'role'         => 'author',
            'display_name' => 'User2 User2',
            'user_login'   => 'user2',
            'user_pass'    => 'user2',
            'user_email'   => 'user2@test.com',
        ];

        $author_two_data = [
            'role'         => 'author',
            'display_name' => 'User3 User3',
            'user_login'   => 'user3',
            'user_pass'    => 'user3',
            'user_email'   => 'user3@test.com',
        ];

        $this->authorOneID = self::factory()->user->create($author_one_data);
        $this->authorTwoID = self::factory()->user->create($author_two_data);

        // Create a test post
        $this->postID = self::factory()->post->create([
            'post_title'  => 'Hello World',
            'post_status' => 'publish',
            'post_type'   => 'post'
        ]);

        // Update post meta with contributors
        update_post_meta($this->postID, 'rtca_contributors', [$this->authorOneID, $this->authorTwoID]);

        // Register the filter to test
        add_filter('the_content', [$this->public, 'display_contributors']);
    }

    public function tearDown(): void
    {
        // Delete test users and post
        wp_delete_user($this->authorOneID);
        wp_delete_user($this->authorTwoID);
        wp_delete_post($this->postID, true);

        // Remove the filter after each test
        remove_filter('the_content', [$this->public, 'display_contributors']);


        parent::tearDown();
    }

    // Test the display_contributors function
    public function test_display_contributors()
    {
        // Simulate the environment
        global $post;

        $post = get_post($this->postID);
        setup_postdata($post);

        WP_UnitTestCase::go_to(get_permalink($this->postID));

        // Expected HTML output from the filter
        $expected_html = '<div class="rtca-post-contributors">';

        // Capture the output of the filter
        $content = get_post_field('post_content', $this->postID);
        $filtered_content = apply_filters('the_content', $content);

        // Assert that the custom HTML is appended to the content
        $this->assertStringContainsString($expected_html, $filtered_content);

        // Clean up the global post data
        wp_reset_postdata();
    }
}
