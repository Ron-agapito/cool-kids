<?php
/**
 * Class Test_Cool_Kids
 *
 * @package Cool_kids
 */
use PHPUnit\Framework\TestCase;

class CoolKidsTest extends TestCase {

	public function test_instance() {

		$this->assertTrue( true );
		$cool_kids = Cool_Kids::get();
		$this->assertInstanceOf( 'Cool_Kids', $cool_kids );

	}

	public function test_shortcode_cool_kids() {
		$cool_kids = Cool_Kids::get();
		$html = $cool_kids->shortcode_cool_kids(["title"=>"Cool Kids Test", "description"=>"Cool Kids Description Test"]);
		$this->assertStringContainsString( 'Sign in to your account', $html );
		$this->assertStringContainsString( 'Cool Kids Test', $html );
		$this->assertStringContainsString( 'Cool Kids Description Test', $html );
	}

	public function test_roles_exist() {
		global $wp_roles;
		$cool_kids = Cool_Kids::get();

		$roles = $wp_roles->roles;

		foreach ($cool_kids->roles as $role) {
			$this->assertArrayHasKey( $role, $roles );
		}

	}

	public function test_cooler_kid_capabilities(){
		global $wp_roles;
		$role = $wp_roles->get_role( 'cooler_kid' );
		$this->assertTrue($role->has_cap('view_users_country'));
		$this->assertTrue($role->has_cap('view_users_name'));
		$this->assertFalse($role->has_cap('view_users_email'));
		$this->assertFalse($role->has_cap('view_users_role'));
	}

	public function test_cool_kid_capabilities(){
		global $wp_roles;
		$role = $wp_roles->get_role( 'cool_kid' );
		$this->assertFalse($role->has_cap('view_users_country'));
		$this->assertFalse($role->has_cap('view_users_name'));
		$this->assertFalse($role->has_cap('view_users_email'));
		$this->assertFalse($role->has_cap('view_users_role'));
	}

	public function test_coolest_kid_capabilities(){
		global $wp_roles;
		$role = $wp_roles->get_role( 'coolest_kid' );
		$this->assertTrue($role->has_cap('view_users_country'));
		$this->assertTrue($role->has_cap('view_users_name'));
		$this->assertTrue($role->has_cap('view_users_email'));
		$this->assertTrue($role->has_cap('view_users_role'));
	}

	//test enque
	public function test_enqueue() {

		do_action('wp_enqueue_scripts'); // Trigger enqueue action.

		$this->assertTrue( wp_script_is( 'cool-kids', 'enqueued' ) );
		$this->assertTrue( wp_script_is( 'alpinejs', 'enqueued' ) );

	}

	public function test_rest_endpoint() {
		global $wp_rest_server;
		$wp_rest_server = new WP_REST_Server();
		do_action('rest_api_init'); // Trigger endpoint registration.

		$routes = $wp_rest_server->get_routes();
		$this->assertArrayHasKey('/cool-kids/v1/login', $routes, 'The endpoint does not exist.');
		$this->assertArrayHasKey('/cool-kids/v1/my-account', $routes, 'The endpoint  does not exist.');
		$this->assertArrayHasKey('/cool-kids/v1/list', $routes, 'The endpoint  does not exist.');
		$this->assertArrayHasKey('/cool-kids/v1/update-role', $routes, 'The endpoint  does not exist.');

	}
}
