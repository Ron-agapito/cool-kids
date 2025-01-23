<?php
/**
 * Plugin Name:     Cool Kids
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     cool_kids
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Cool_kids
 */

// Your code starts here.
final class Cool_Kids {
	private static $instance = null;

	private $roles = array( 'cool_kid', 'cooler_kid', 'coolest_kid' );
	private $api_key = 'test-api-key';

	private function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	public static function get() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function init() {
		// Your code here.


		$this->setup_roles();
		$this->add_actions();
		$this->setup_shortcodes();
		$this->enqueue_assets();
		$this->setup_rest_api();
	}

	private function setup_roles() {
		//add role Cool Kid Cooler Kid and Coolest Kid
		add_role( 'cool_kid', 'Cool Kid', array( 'read' => true ) );
		add_role( 'cooler_kid', 'Cooler Kid', array( 'read' => true ) );
		add_role( 'coolest_kid', 'Coolest Kid', array( 'read' => true ) );
		//add field if user is a cool kid

		//add capability to cooler_kid
		$cooler_kid  = get_role( 'cooler_kid' );
		$coolest_kid = get_role( 'coolest_kid' );

		$cooler_kid->add_cap( 'view_users_country' );
		$coolest_kid->add_cap( 'view_users_country' );

		$cooler_kid->add_cap( 'view_users_name' );
		$coolest_kid->add_cap( 'view_users_name' );

		$coolest_kid->add_cap( 'view_users_email' );
		$coolest_kid->add_cap( 'view_users_role' );


	}

	private function add_actions() {

		add_action( 'edit_user_profile', array( $this, 'add_user_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'admin_save_user_fields' ) );
	}

	private function setup_shortcodes() {
		add_shortcode( 'cool_kid_signup', array( $this, 'shortcode_signup' ) );
		add_shortcode( 'cool_kid_my_account', array( $this, 'shortcode_my_account' ) );
	}

	private function enqueue_assets() {
		add_action( 'wp_enqueue_scripts', function () {
			wp_enqueue_style( 'cool-kids', plugin_dir_url( __FILE__ ) . 'assets/css/dist/cool-kids.css', array(), '1.0.0' );
			//alpine js
			wp_enqueue_script( 'cool-kids', plugin_dir_url( __FILE__ ) . 'assets/js/cool-kids.js', array(), '1.0.0', true );

			wp_enqueue_script( 'alpinejs', 'https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js', array(), '3.14.8', true );


		} );
	}

	public function setup_rest_api() {
		add_action( 'rest_api_init', function () {
			register_rest_route( 'cool-kids/v1', '/signup', array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'rest_signup' ),
				'permission_callback' => array( $this, 'verify_nonce' ),
				'args'                => array(
					'email' => array(
						'required'          => true,
						'type'              => 'string',
						'validate_callback' => function ( $param, $request, $key ) {
							return is_email( $param );
						}

					),


				)
			) );

			//register login
			register_rest_route( 'cool-kids/v1', '/login', array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'rest_login' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'email' => array(
						'required'          => true,
						'type'              => 'string',
						'validate_callback' => function ( $param, $request, $key ) {
							return is_email( $param );
						}

					),
				)
			) );


			//register my account
			register_rest_route( 'cool-kids/v1', '/my-account', array(
				'methods'  => 'GET',
				'callback' => array( $this, 'rest_my_account' ),


				'permission_callback' => function ( $request ) {
					return $this->verify_nonce( $request, 'wp_rest' ); // Highlighted action parameter
				},

				//'permission_callback' => function () {
				//	return is_user_logged_in(); // Ensure the user is logged in
				//	},
				//'permission_callback' => '__return_true',
			) );

			//list accounts
			register_rest_route( 'cool-kids/v1', '/list', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'rest_list' ),
				'permission_callback' => array( $this, 'verify_nonce' ),
			) );

			//put // update user role  by email or (firstname and last name) using api key not nonce
			register_rest_route( 'cool-kids/v1', '/update-role', array(
				'methods'             => 'PATCH',
				'callback'            => array( $this, 'rest_update_role' ),
				'permission_callback' => function ( $request ) {
					$api_key = $request->get_header( 'X-API-Key' ); // Highlighted API key check

					return $api_key === $this->api_key;
				},

			) );


		} );
	}

	public function verify_nonce( $request, $action = 'wp_rest' ) {
		$nonce = $request->get_header( 'X-WP-Nonce' );


		if ( ! wp_verify_nonce( $nonce, $action ) ) {
			return new WP_Error( 'rest_forbidden', esc_html__( 'Invalid nonce 2' . $nonce ), array(
				'status' => 403,
				'error'  => true
			) );
		}

		return true;
	}

	function rest_update_role( WP_REST_Request $data ) {

		$email = sanitize_email( $data->get_param( "email" ) );
		$role  = sanitize_text_field( $data->get_param( 'role' ) );
		if ( ! in_array( $role, $this->roles ) ) {
			return new WP_Error( 'rest_login_failed', esc_html__( 'Invalid role ' ), array(
				'status' => 403,
				'error'  => true
			) );
		}

		$user = get_user_by( 'email', $email );
		if ( ! $user ) {
			return new WP_Error( 'rest_login_failed', esc_html__( 'Invalid email ' ) . $data_params['email'], array(
				'status' => 403,
				'error'  => true
			) );
		}

		$user->set_role( $data->get_param( 'role' ) );

		return array(
			'message'    => 'User role updated successfully',
			'success'    => true,
			'email'      => $email,
			'role'       => $role,
			'first_name' => $user->first_name,
			'last_name'  => $user->last_name,
		);
	}

	public function rest_list( $data ) {
		$can_view_name    = current_user_can( 'view_users_name' );
		$can_view_country = current_user_can( 'view_users_country' );
		$can_view_email   = current_user_can( 'view_users_email' );
		$can_view_role    = current_user_can( 'view_users_role' );

		if ( ! $can_view_name ) {
			return [];
		}
		$page     = $data->get_param( 'page' ) ? intval( $data->get_param( 'page' ) ) : 1;
		$per_page = $data->get_param( 'per_page' ) ? intval( $data->get_param( 'per_page' ) ) : 10;

		$args = [
			'role__in' => $this->roles, // Array of roles to filter by
			'order'    => 'ASC', // Optional: Ascending order
			'fields'   => 'all', // Return full user objects
			'number'   => $per_page,
			'offset'   => ( $page - 1 ) * $per_page,
		];


		// Get users
		$users = get_users( $args );

		$users_data = array();
		foreach ( $users as $user ) {
			$role = "";
			if ( ! empty( $user->roles ) ) {
				$role = ucwords( str_replace( '_', ' ', $user->roles[0] ) );
			}
			$country      = get_user_meta( $user->ID, 'cool_kid_country', true );
			$user_data    = array(
				'first_name' => $can_view_name ? esc_html( $user->first_name ) : '',
				'last_name'  => $can_view_name ? esc_html( $user->last_name ) : '',
				'email'      => $can_view_email ? esc_html( $user->user_email ) : '',
				'country'    => $can_view_country ? esc_html( $country ) : '',
				'role'       => $can_view_role ? esc_html( $role ) : '',
				'initials'   => $can_view_name ? strtoupper( substr( $user->first_name, 0, 1 ) . substr( $user->last_name, 0, 1 ) ) : 'CK'
			);
			$users_data[] = $user_data;
		}

		return $users_data;
	}

	public function add_user_fields( $user ) {
		$user_roles      = $user->roles;
		$intersect_roles = array_intersect( $user_roles, $this->roles );
		echo "here";
		if ( ! empty( $intersect_roles ) ) {
			?>
			<table class="form-table">
				<tr>
					<th>
						<label for="cool_kid_field"><?php _e( 'Country', 'cool_kids' ); ?></label>
					</th>
					<td>
						<input type="text" name="cool_kid_country" id="cool_kid_country"
							   value="<?php echo esc_attr( get_the_author_meta( 'cool_kid_country', $user->ID ) ); ?>"
							   class="regular-text"/>
					</td>
				</tr>
			</table>
			<?php
		}
	}

	public function admin_save_user_fields( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}

		$user_roles      = get_userdata( $user_id )->roles;
		$intersect_roles = array_intersect( $user_roles, $this->roles );

		if ( empty( $intersect_roles ) ) {
			return;
		}

		if ( isset( $_POST['cool_kid_country'] ) ) {
			update_user_meta( $user_id, 'cool_kid_country', sanitize_text_field( $_POST['cool_kid_country'] ) );
		}


	}

	public function shortcode_signup() {

		//load views/signup.php

		$nonce = wp_create_nonce( 'wp_rest' );

		include plugin_dir_path( __FILE__ ) . 'views/signup.php';
		//return ob_get_clean();		//return ob_get_clean();


	}

	public function shortcode_my_account() {


		$nonce        = wp_create_nonce( 'wp_rest' );
		$is_logged_in = is_user_logged_in();

		include plugin_dir_path( __FILE__ ) . 'views/my-account.php';
	}

	public function rest_my_account( $data ) {
		$user = wp_get_current_user();
		$role = "";
		if ( ! empty( $user->roles ) ) {

			$role = ucwords( str_replace( '_', ' ', $user->roles[0] ) );


		}

		$country   = get_user_meta( $user->ID, 'cool_kid_country', true );
		$user_data = array(
			'first_name' => esc_html( $user->first_name ),
			'last_name'  => esc_html( $user->last_name ),
			'email'      => esc_html( $user->user_email ),
			'country'    => esc_html( $country ),
			'role'       => esc_html( $role ),
			'initials'   => strtoupper( substr( $user->first_name, 0, 1 ) . substr( $user->last_name, 0, 1 ) )
		);

		return $user_data;
	}

	public function rest_login( $data ) {

		$user = get_user_by( 'email', $data->get_param( 'email' ) );
		if ( ! $user ) {
			return new WP_Error( 'rest_login_failed', esc_html__( 'Invalid email 2' ) . $data['email'], array(
				'status' => 403,
				'error'  => true
			) );
		}
		$creds                  = array();
		$creds['user_login']    = $data->get_param( 'email' );
		$creds['user_password'] = 'password';
		$creds['remember']      = true;
		$user                   = wp_signon( $creds, false );
		if ( is_wp_error( $user ) ) {
			return new WP_Error( 'rest_login_failed', esc_html__( 'Invalid email' ), array(
				'status' => 403,
				'error'  => true
			) );
		}


		//	wp_set_auth_cookie( $user->ID, true, false );

		//wp_set_auth_cookie( $user );

		//get the set cookie
		//$cookie = $_COOKIE;

		//forma cookie key=value
		//	$cookie = http_build_query( $cookie, '', ';' );
		//get the Set Cookie  value for  fetch

		//cookie for


		$cookie = "test";

		//new nonce
		$nonce = wp_create_nonce( 'wp_rest' );

		return array(
			'message' => 'User logged in successfully',
			'success' => true,
			'nonce'   => $nonce
		);
	}

	//setup rest bearer token

	public function rest_signup( $data ) {

		$user = wp_create_user( $data['email'], wp_generate_password(), $data['email'] );

		if ( is_wp_error( $user ) ) {
			error_log( 'User creation failed: ' . $user->get_error_message() );

			return new WP_Error( 'rest_signup_failed', esc_html__( $user->get_error_message() ), array( 'error' => true ) );
		}

		wp_update_user( array( 'ID' => $user, 'role' => 'cool_kid' ) );
		wp_set_password( 'password', $user );

		$response   = wp_remote_get( 'https://randomuser.me/api/' );
		$body       = wp_remote_retrieve_body( $response );
		$data       = json_decode( $body );
		$first_name = $data->results[0]->name->first;
		$last_name  = $data->results[0]->name->last;
		$country    = $data->results[0]->location->country;
		update_user_meta( $user, 'first_name', $first_name );
		update_user_meta( $user, 'last_name', $last_name );
		update_user_meta( $user, 'cool_kid_country', $country );

		return array( 'message' => 'User created successfully', 'success' => true );

	}


}

// Initialize
Cool_Kids::get();



