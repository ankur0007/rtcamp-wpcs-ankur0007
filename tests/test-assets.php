<?php

// Include the file that contains the Rtcamp_Assignment class
require_once plugin_dir_path(__FILE__) . '../rtcamp-assignment.php';

class Rtcamp_Assignment_Admin_Test_Enqueue extends WP_UnitTestCase
{

    protected $admin;
    protected $public;

    protected function setUp(): void
    {
        parent::setUp();
        // Initialize your admin class
        $this->admin = new Rtcamp_Assignment_Admin(RTCAMP_ASSIGNMENT_NAME, RTCAMP_ASSIGNMENT_VERSION);

        // Initialize your admin class
        $this->public = new Rtcamp_Assignment_Public(RTCAMP_ASSIGNMENT_NAME, RTCAMP_ASSIGNMENT_VERSION);
    }

    public function test_enqueue_admin_styles()
    {
        // Hook into 'wp_enqueue_scripts' action
        add_action('wp_enqueue_scripts', [$this->admin, 'enqueue_styles']);

        // Simulate the enqueuing
        do_action('wp_enqueue_scripts');

        // Check if the style has been enqueued
        $this->assertTrue(wp_style_is('rtcamp-assignment', 'enqueued'));
    }

    public function test_enqueue_admin_scripts()
    {
        // Hook into 'wp_enqueue_scripts' action
        add_action('wp_enqueue_scripts', [$this->admin, 'enqueue_scripts']);

        // Simulate the enqueuing
        do_action('wp_enqueue_scripts');

        // Check if the script has been enqueued
        $this->assertTrue(wp_script_is('rtcamp-assignment', 'enqueued'));
    }

    public function test_enqueue_public_styles()
    {
        // Hook into 'wp_enqueue_scripts' action
        add_action('wp_enqueue_scripts', [$this->public, 'enqueue_styles']);

        // Simulate the enqueuing
        do_action('wp_enqueue_scripts');

        // Check if the style has been enqueued
        $this->assertTrue(wp_style_is('rtcamp-assignment', 'enqueued'));
    }

    public function test_enqueue_public_scripts()
    {
        // Hook into 'wp_enqueue_scripts' action
        add_action('wp_enqueue_scripts', [$this->public, 'enqueue_scripts']);

        // Simulate the enqueuing
        do_action('wp_enqueue_scripts');

        // Check if the script has been enqueued
        $this->assertTrue(wp_script_is('rtcamp-assignment', 'enqueued'));
    }
}
