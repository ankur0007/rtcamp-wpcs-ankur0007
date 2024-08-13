<?php

class RtcaFunctionsTest extends WP_UnitTestCase
{

    /**
     * Holds user id.
     *
     * @var int
     */

    private $adminID, $authorOneID, $authorTwoID, $subscriberID, $editorID;

    /**
     * Holds post id.
     *
     * @var int
     */
    private $postID;
    protected function setUp(): void
    {
        parent::setUp();

        $admin_data = [
            'role'         => 'administrator',
            'display_name' => 'Admin User',
            'user_login'   => 'admin_user',
            'user_pass'    => 'admin_user',
            'user_email'   => 'admin_user@test.com',
        ];

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

        $editor_one_data = [
            'role'         => 'editor',
            'display_name' => 'Editor1 Editor1',
            'user_login'   => 'editor1',
            'user_pass'    => 'editor1',
            'user_email'   => 'editor1@test.com',
        ];

        $subscriber_data = [
            'role'         => 'subscriber',
            'display_name' => 'Subscriber User',
            'user_login'   => 'subscriber_user',
            'user_pass'    => 'subscriber_user',
            'user_email'   => 'subscriber_user@test.com',
        ];

        //Create dummy users with various roles for testing
        $this->adminID = self::factory()->user->create($admin_data);
        $this->authorOneID = self::factory()->user->create($author_one_data);
        $this->authorTwoID = self::factory()->user->create($author_two_data);
        $this->editorID = self::factory()->user->create($editor_one_data);
        $this->subscriberID = self::factory()->user->create($subscriber_data);

        //Create a test Post
        $this->postID = self::factory()->post->create([
            'post_title' => 'Hello World',
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_author' => $this->adminID
        ]);

        update_post_meta($this->postID, 'rtca_contributors', [$this->authorOneID, $this->authorTwoID]);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        wp_delete_user($this->adminID);
        wp_delete_user($this->editorID);
        wp_delete_user($this->authorOneID);
        wp_delete_user($this->authorTwoID);
        wp_delete_user($this->subscriberID);
    }

    //Test function get users with search
    public function test_rtca_get_users_with_search()
    {

        // Call the function
        $result = rtca_get_users(['search' => 'user2']);

        // Assertions

        $this->assertCount(1, $result);
        $this->assertEquals($this->authorOneID, $result[0]->ID);
        $this->assertEquals('User2 User2', $result[0]->display_name);
        $this->assertEquals('user2@test.com', $result[0]->user_email);
    }
    //Test function get users with default options
    public function test_rtca_get_users_with_defaults()
    {

        // Call the function
        $data = rtca_get_users([]);

        $this->assertNotEmpty($data);

        // Assertions
        foreach ($data as $user) {
            $this->assertTrue(property_exists($user, 'ID'));
            $this->assertTrue(property_exists($user, 'display_name'));
            $this->assertTrue(property_exists($user, 'user_email'));
        }
    }
    //Test function get contributors
    public function test_rtca_get_contributors()
    {

        // Call the function
        $data = rtca_get_contributors($this->postID);

        $this->assertNotEmpty($data);
    }
}
