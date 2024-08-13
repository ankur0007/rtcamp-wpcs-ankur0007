<?php

// Include the file that contains the Rtcamp_Assignment class
require_once plugin_dir_path(__FILE__) . '../rtcamp-assignment.php';


class Rtcamp_Assignment_Admin_Test_Endpoints extends WP_UnitTestCase
{

    /**
     * Holds the WP REST Server object
     *
     * @var WP_REST_Server
     */
    private $server;

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
    private $postId;

    protected $admin_instance;

    public function setUp(): void
    {
        parent::setUp();

        // Create an instance of the Rtcamp_Assignment_Admin class
        $this->admin_instance = new Rtcamp_Assignment_Admin(RTCAMP_ASSIGNMENT_NAME, RTCAMP_ASSIGNMENT_VERSION);

        // Initialize the REST server
        global $wp_rest_server;
        $this->server = $wp_rest_server = new WP_REST_Server();
        do_action('rest_api_init');

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
        $this->postId = self::factory()->post->create([
            'post_title' => 'Hello World',
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_author' => $this->adminID
        ]);

        update_post_meta($this->postId, 'rtca_contributors', [$this->authorOneID, $this->authorTwoID]);
    }

    /**
     * Delete the item after the test.
     */
    public function tearDown(): void
    {

        parent::tearDown();

        global $wp_rest_server;
        $wp_rest_server = null;

        wp_delete_user($this->adminID);
        wp_delete_user($this->editorID);
        wp_delete_user($this->authorOneID);
        wp_delete_user($this->authorTwoID);
        wp_delete_user($this->subscriberID);
        wp_delete_post($this->postId);
    }

    /**
     * Test the endpoints.
     *
     * @return void.
     */
    public function testItemsEndpoint()
    {

        // Get all registered routes
        $routes_registered = $this->server->get_routes();

        // Define the expected routes
        $expected_routes = [
            '/rtca/v1/authors' => [
                'methods'  => 'GET',
                'callback' => [$this->admin_instance, 'get_authors_callback']
            ],
            '/rtca/v1/contributor' => [
                'methods'  => 'POST',
                'callback' => [$this->admin_instance, 'save_contributor_callback']
            ],
            '/rtca/v1/contributors' => [
                'methods'  => 'GET',
                'callback' => [$this->admin_instance, 'get_contributors_callback']
            ],
        ];

        // Verify that each expected route was registered
        foreach ($expected_routes as $route => $expected) {
            $this->assertArrayHasKey($route, $routes_registered);
            $this->assertEquals($expected['methods'], key($routes_registered[$route][0]['methods']));
            $this->assertEquals($expected['callback'], $routes_registered[$route][0]['callback']);
        }
    }

    // Test the endpoint access with an administrator role
    public function test_endpoint_get_authors_callback_with_admin_role()
    {


        // Set the current user to the created administrator
        wp_set_current_user($this->adminID);

        // Create the request to the endpoint
        $request = new WP_REST_Request('GET', '/rtca/v1/authors');

        $nonce = wp_create_nonce('wp_rest'); //generate nonce
        $request->set_param('_wpnonce', $nonce); // Set the nonce parameter
        // Execute the request
        $response = rest_do_request($request);
        // Assert the status code to check for success (200)
        $this->assertSame(200, $response->get_status());

        // Optionally, assert the response data
        $data = $response->get_data();
        /*  echo 'Get Authors as Admin: ';
        print_r($data); // Debug output
        ob_flush(); flush(); // Ensure output is displayed in terminal */
        //$this->assertNotEmpty( $data );
        // Additional assertions depending on expected output

        // Assertions to verify structure
        foreach ($data as $contributor) {
            $this->assertArrayHasKey('id', $contributor);
            $this->assertArrayHasKey('name', $contributor);
            $this->assertArrayHasKey('avatar', $contributor);
            $this->assertArrayHasKey('avatar_2x', $contributor);
            $this->assertArrayHasKey('is_selected', $contributor);
        }
    }

    // Test the endpoint access with an administrator role
    public function test_endpoint_get_authors_callback_with_subscriber_role()
    {


        // Set the current user to the created administrator
        wp_set_current_user($this->subscriberID);

        // Create the request to the endpoint
        $request = new WP_REST_Request('GET', '/rtca/v1/authors');

        $nonce = wp_create_nonce('wp_rest'); //generate nonce


        // Add query parameters
        $request->set_query_params(array(
            '_wpnonce' => $nonce
        ));


        // Execute the request
        $response = rest_do_request($request);

        // Assert the status code to check for success (200)
        $this->assertSame(403, $response->get_status());

        // Optionally, assert the response data
        $data = $response->get_data();
        /* echo 'Get Authors as Subscriber: ';
        print_r($data); // Debug output
        ob_flush(); flush(); // Ensure output is displayed in terminal */
        $this->assertNotEmpty($data);
        // Additional assertions depending on expected output

        // Assertions to verify structure

        if (!empty($data) && !isset($data['code'])) {
            foreach ($data as $contributor) {
                $this->assertArrayHasKey('id', $contributor);
                $this->assertArrayHasKey('name', $contributor);
                $this->assertArrayHasKey('avatar', $contributor);
                $this->assertArrayHasKey('avatar_2x', $contributor);
                $this->assertArrayHasKey('is_selected', $contributor);
            }
        }
    }


    // Test the endpoint access with an editor role doing a search
    public function test_endpoint_get_authors_callback_with_search_using_editor_role()
    {


        // Set the current user to the created administrator
        wp_set_current_user($this->editorID);

        // Create the request to the endpoint
        $request = new WP_REST_Request('GET', '/rtca/v1/authors');

        $nonce = wp_create_nonce('wp_rest'); //generate nonce
        // Add query parameters
        $request->set_query_params(array(
            'search' => 'user2', //search for name
            'post_id' => $this->postId,
            '_wpnonce' => $nonce
        ));

        // Execute the request
        $response = rest_do_request($request);



        // Assert the status code to check for success (200)
        $this->assertSame(200, $response->get_status());

        // Optionally, assert the response data
        $data = $response->get_data();
        /*  echo 'Get Specific Author as Editor: ';
        print_r($data); // Debug output
        ob_flush(); flush(); // Ensure output is displayed in terminal */
        $this->assertNotEmpty($data);
        // Additional assertions depending on expected output

        // Assertions to verify structure
        foreach ($data as $contributor) {
            $this->assertArrayHasKey('id', $contributor);
            $this->assertArrayHasKey('name', $contributor);
            $this->assertArrayHasKey('avatar', $contributor);
            $this->assertArrayHasKey('avatar_2x', $contributor);
            $this->assertArrayHasKey('is_selected', $contributor);
        }
    }

    // Test the endpoint contributor to add a contributor to a post
    public function test_endpoint_contributor_callback_add_contributor_using_editor_role()
    {


        // Set the current user to the created administrator
        wp_set_current_user($this->editorID);

        // Create the request to the endpoint
        $request = new WP_REST_Request('POST', '/rtca/v1/contributor');

        $nonce = wp_create_nonce('wp_rest'); //generate nonce

        // Add query parameters
        $request->set_query_params(array(
            'trigger' => 'add', //search for name
            'post_id' => $this->postId,
            'user_id' => $this->authorOneID,
            '_wpnonce' => $nonce
        ));

        // Execute the request
        $response = rest_do_request($request);


        // Assert the status code to check for success (200)
        $this->assertSame(200, $response->get_status());

        // Optionally, assert the response data
        $data = $response->get_data();
        /* echo 'Added contributor to the post ';
        print_r($data); // Debug output
        ob_flush(); flush(); // Ensure output is displayed in terminal */
        $this->assertNotEmpty($data);
        // Additional assertions depending on expected output

        // Assertions to verify structure
        foreach ($data as $contributor) {
            $this->assertArrayHasKey('id', $contributor);
            $this->assertArrayHasKey('name', $contributor);
            $this->assertArrayHasKey('avatar', $contributor);
            $this->assertArrayHasKey('avatar_2x', $contributor);
            $this->assertArrayHasKey('is_selected', $contributor);
        }
    }

    // Test the endpoint contributor to remove a contributor to a post
    public function test_endpoint_contributor_callback_remove_contributor_using_editor_role()
    {


        // Set the current user to the created administrator
        wp_set_current_user($this->editorID);

        // Create the request to the endpoint
        $request = new WP_REST_Request('POST', '/rtca/v1/contributor');

        $nonce = wp_create_nonce('wp_rest'); //generate nonce
        // Add query parameters
        $request->set_query_params(array(
            'trigger' => 'remove', //search for name
            'post_id' => $this->postId,
            'user_id' => $this->authorOneID,
            '_wpnonce' => $nonce
        ));

        // Execute the request
        $response = rest_do_request($request);


        // Assert the status code to check for success (200)
        $this->assertSame(200, $response->get_status());

        // Optionally, assert the response data
        $data = $response->get_data();
        /* echo 'Removed contributor to the post ';
        print_r($data); // Debug output
        ob_flush(); flush(); // Ensure output is displayed in terminal */
        $this->assertNotEmpty($data);
        // Additional assertions depending on expected output

        // Assertions to verify structure
        foreach ($data as $contributor) {
            $this->assertArrayHasKey('id', $contributor);
            $this->assertArrayHasKey('name', $contributor);
            $this->assertArrayHasKey('avatar', $contributor);
            $this->assertArrayHasKey('avatar_2x', $contributor);
            $this->assertArrayHasKey('is_selected', $contributor);
        }
    }

    // Test the endpoint contributors to get selected contributors of a post
    public function test_endpoint_contributors_callback_get_selected_contributors_from_post_using_administrator_role()
    {


        // Set the current user to the created administrator
        wp_set_current_user($this->adminID);

        update_post_meta($this->postId, 'rtca_contributors', [$this->authorOneID, $this->authorTwoID]);
        // Create the request to the endpoint
        $request = new WP_REST_Request('GET', '/rtca/v1/contributors');
        $nonce = wp_create_nonce('wp_rest'); //generate nonce
        // Add query parameters
        $request->set_query_params(array(
            'post_id' => $this->postId,
            '_wpnonce' => $nonce
        ));

        // Execute the request
        $response = rest_do_request($request);


        // Assert the status code to check for success (200)
        $this->assertSame(200, $response->get_status());

        // Optionally, assert the response data
        $data = $response->get_data();
        /*  echo 'Fetch all contributors from a post ';
        print_r($data); // Debug output
        ob_flush(); flush(); // Ensure output is displayed in terminal */
        $this->assertNotEmpty($data);
        // Additional assertions depending on expected output

        // Assertions to verify structure
        foreach ($data as $contributor) {
            $this->assertArrayHasKey('id', $contributor);
            $this->assertArrayHasKey('name', $contributor);
            $this->assertArrayHasKey('avatar', $contributor);
            $this->assertArrayHasKey('avatar_2x', $contributor);
            $this->assertArrayHasKey('is_selected', $contributor);
        }
    }
}
