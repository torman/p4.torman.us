<?php
class  users_controller extends base_controller {

	public function __construct() {

		parent::__construct();
		// echo "users_controller construct called<br><br>";
	}

	// public function profile ($user_name = NULL) {
	public function profile ($message = NULL) {

		# if the user has not logged in, redirect to login page
		if (!$this->user) {
			Router::redirect('/users/login');
		}

		#build user profile view
		$this->template->content = View::instance('v_users_profile');

		$this->template->title = "Profile of " . $this->user->first_name;

		$this->template->message = $message;

		// echo '<pre>';
		// print_r($_POST);
		// echo '<pre>';
/*
		$client_files_head = Array("/css/profile.css");
		$this->template->client_files_head = Utils::load_client_files($client_files_head);

		$client_files_body = Array("/js/profile.min.js");
		$this->template->client_files_body = Utils::load_client_files($client_files_body);
*/

// echo '<pre>';
// print_r($this->user);
// echo '</pre>';

		echo $this->template;
		
		// echo "End of profile page";
	}

	// public function profile_edit ($user_name = NULL) {
	public function profile_edit ($message = NULL) {

		# if the user has not logged in, redirect to login page
		if (!$this->user) {
			Router::redirect('/users/login');
		}

		#build user profile edit view
		$this->template->content = View::instance('v_users_profile_edit');

		$this->template->title = "Edit profile of " . $this->user->first_name;

		// echo '<pre>';
		// print_r($_POST);
		// echo '<pre>';
/*
		$client_files_head = Array("/css/profile.css");
		$this->template->client_files_head = Utils::load_client_files($client_files_head);

		$client_files_body = Array("/js/profile.min.js");
		$this->template->client_files_body = Utils::load_client_files($client_files_body);
*/
// echo '<pre>';
// print_r($this->user);
// echo '</pre>';

		echo $this->template;
	}
	
	public function p_profile_edit ($user_name = NULL) {

		// don't upate if password doesn't match password
		// the user might have entered a password which s/he doesn't want
		// retrun to profile edit form
		if ($_POST['password'] != $_POST['password2']) { 
			$error = TRUE; 
			$message = "Password not matched.";
			$redirect_path = "/users/profile_edit/$message";
			Router::redirect("$redirect_path");
		}
		
		// if all fields are empty, redirect to /users/profile_edit
		if (!isset($_POST)) {
			Router::redirect("/users/profile_edit");
		}
		// we only update those fields are not empty
		# Sanitize the user input from profile edit form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# hash the password submitted by the user
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		// don't update the field password2, no such field in database
		unset($_POST['password2']); 

	
		$index = 0;
		$s = "";

// echo '<pre>';
// print_r($_POST);
// echo '<pre>';
		
		foreach ($_POST as $key=>$value) {
			// prepend a comma in front, but not the first item.
			if ($index != 0) {
				$s = $s . ",";
			}
			$s = $s . " $key " . "= '" . $value . "'";
			$index++;
		}

		$_POST['modified'] = Time::now();
		$s = $s . ', modified = ' . $_POST['modified'];

		$q = "UPDATE users SET " . $s . " WHERE user_id = " .
				$this->user->user_id ;
		
		// echo $q;
		DB::instance(DB_NAME)->query($q);

		$q = "SELECT token FROM users WHERE email = '"  
				. $_POST['email'] . "'"
				. " AND "
				. "password = '" 
				. $_POST['password'] . "'"; 

		$token = DB::instance(DB_NAME)->select_field($q);
		setcookie('token', $token, strtotime('+2 week'), '/');
		
		$client_files_head = Array("/css/profile.css");
		$this->template->client_files_head = Utils::load_client_files($client_files_head);

		$client_files_body = Array("/js/profile.min.js");
		$this->template->client_files_body = Utils::load_client_files($client_files_body);

// echo '<pre>';
// print_r($this->user);
// echo '</pre>';

		// go back profile page after updated
		$message = "Profile has just been updated.";
		$redirect_path = "/users/profile/$message";
		Router::redirect("$redirect_path");
	}

	public function signup() {
		
		$this->template->content = View::instance('v_users_signup');
		$this->template->title = "Sign Up";
		echo $this->template;
	}

	public function p_signup() {

		# need to check if this email exists in user table first
		# email must be unique
		# if existed, then redirect to sign-in page
		$q = "SELECT email FROM users WHERE email = '" . $_POST['email'] . "'";

// echo $q;
		
		$result = DB::instance(DB_NAME)->select_field($q);
		
// echo '<pre>';
// print_r($result);
// echo '</pre>';		
		
		# found the email from user table
		if ($result) { 
			$error = TRUE;
			$message = "This email " . $_POST['email'] . " has been used. Please use another one";
		}

		# make sure that the user enters the same password twice	
		if ($_POST['password'] != $_POST['password2']) {
			$error = TRUE;
			$message = 'The passwords do not match';
		}
		
		if ($error) {
			Router::redirect('/users/signup');
		}
		
		# password2 field is only used to make sure the user knows what password
		# s/he has entered. Don't need it during user creation	
		unset ($_POST['password2']);
		
		# we want to know when the user is created and user's data is changed
		$_POST['created'] = Time::now();
		$_POST['modified'] = Time::now();

		/* encrypt user's password */
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		# create an encrypted token via email address and a arandom string 
		$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

		# insert the user into database
		$user_id = DB::instance(DB_NAME)->insert('users', $_POST);

		// # Build a multi-dimension array of recipients of this email
		$full_name = $_POST['first_name'] . " " . $_POST['last_name'];
		
		$to[] = Array("name" => $full_name, "email" => $_POST['email']);

		// # Build a single-dimension array of who this email is coming from
		// # note it's using the constants we set in the configuration above)
		$from = Array("name" => APP_NAME, "email" => APP_EMAIL);

		// # Subject
		$subject = "Welcome to " . APP_NAME;

		// # You can set the body as just a string of text
		$body = "Hi " . $_POST['first_name'] . ", this is just a message to confirm your registration at ". APP_NAME;

		// # OR, if your email is complex and involves HTML/CSS, you can build the body via a View just like we do in our controllers
		// # $body = View::instance('e_users_welcome');

		// # Build multi-dimension arrays of name / email pairs for cc / bcc if you want to 
		$cc  = "";
		$bcc = "";

		// # With everything set, send the email
		$email = Email::send($to, $from, $subject, $body, true, $cc, $bcc);
		
		# login after the user signed in and redirect to home page
		# retrieve the token from database
		$q = "SELECT token FROM users WHERE email = '"  
				. $_POST['email'] . "'"
				. " AND "
				. "password = '" 
				. $_POST['password'] . "'"; 

		$token = DB::instance(DB_NAME)->select_field($q);
		setcookie('token', $token, strtotime('+2 week'), '/');
		Router::redirect("/");
	}

	public function login() {

		$this->template->content = View::instance('v_users_login');
		$this->template->title = "Login";
		echo $this->template;
	}

	public function p_login() {
		
		# Sanitize the user input from login form
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# hash the password submitted by the user
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		# retrieve the token from database
		$q = "SELECT token FROM users WHERE email = '"  
				. $_POST['email'] . "'"
				. " AND "
				. "password = '" 
				. $_POST['password'] . "'"; 

		$token = DB::instance(DB_NAME)->select_field($q);
		#echo $token;

		# if no token found (wrong email or password), send the user to front page. 
		if (!$token) {	
			$message = "Login failed. Wrong email or password!!";
			Router::redirect("/index/index/$message");
			// Router::redirect("/index/index/");
						
		} 
		else {

			setcookie('token', $token, strtotime('+2 week'), '/');
			
		# retrive family information from families

			$q = "SELECT user_id FROM users WHERE email = '"  . $_POST['email'] . "'"; 
			$user_id = DB::instance(DB_NAME)->select_field($q);		

			$q = 'SELECT family_name, headcount, senior, children, expenses
					FROM families f
					INNER JOIN usersfamily uf ON f.family_id = uf.family_id
					INNER JOIN users u ON u.user_id = uf.user_id
					WHERE u.user_id = "' . $user_id . '"';

			$family_data = DB::instance(DB_NAME)->select_row($q);
			

// echo '<pre>';
// print_r($family_data);
// echo '</pre>';
//			
			# send the user family data page
			// $redirect_path = "/users/family_data_edit/$user_id";
			$redirect_path = "/users/family_data_edit";
			Router::redirect($redirect_path);
		}
	}
	
	public function family_data_edit() {
	
		$this->template->content = View::instance('v_family_data');
		$this->template->title = "Family Data";

		$q = 'SELECT family_name, headcount, senior, children, expenses
				FROM families f
				INNER JOIN usersfamily uf ON f.family_id = uf.family_id
				INNER JOIN users u ON u.user_id = uf.user_id
				WHERE u.user_id = "' . $this->user->user_id . '"';
				
		$user_family_data = DB::instance(DB_NAME)->select_row($q);		

		$this->template->content->user_family_data = $user_family_data;

		$q = 'SELECT * FROM families' ;		
		$families_data = DB::instance(DB_NAME)->select_rows($q);
// echo '<pre>';
// print_r($families_data);
// echo '</pre>';		
		$this->template->content->families_data = $families_data;

		$client_files_head = Array("/css/balancesheet.css", "/css/family_data.css");
		$this->template->client_files_head = Utils::load_client_files($client_files_head);
		
		$client_files_body = Array("/js/profile.min.js", "/js/family_data.js");
		$this->template->client_files_body = Utils::load_client_files($client_files_body);
		
		echo $this->template;	
	}
	
	public function p_family_data_edit($user_id = NULL) {

		$data = $_POST;
		DB::instance(DB_NAME)->update("families", $data, "WHERE family_name = '".$_POST["family_name"]."'");
	
		Router::redirect("/users/family_data_edit");
	}
	
	public function logout() {

    # Generate and save a new token for next login
    $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

    # Create the data array we'll use with the update method
    # In this case, we're only updating one field, so our array only has one entry
    $data = Array("token" => $new_token);

    # Do the update
    DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

    # Delete their token cookie by setting it to a date in the past - effectively logging them out
    setcookie("token", "", strtotime('-1 year'), '/');

    # Send them back to the main index.
    Router::redirect("/");

	}


}
