<?php

class admin_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------

	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	} 
		
	/*-------------------------------------------------------------------------------------------------
	Accessed via http://localhost/admin/admin/
	-------------------------------------------------------------------------------------------------*/
	public function admin($message = NULL) {

		if ($this->user->role != 1) {
			$message = "Only admin can access the admin page";
			Router::redirect("/index/index/$message");
		}
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file
		$this->template->content = View::instance('v_admin_admin');
			
		# Now set the <title> tag
		$this->template->title = APP_NAME;

		$this->template->message = $message;

		$q = 'SELECT family_name, u.last_name, u.first_name, u.email
				FROM families f
				INNER JOIN usersfamily uf ON f.family_id = uf.family_id
				INNER JOIN users u ON u.user_id = uf.user_id
				ORDER BY family_name';

		$familymembers = DB::instance(DB_NAME)->select_rows($q);

// echo '<pre>';
// print_r($familymembers);
// echo '</pre>';
		
		# Pass data to the View
		$this->template->content->familymembers  = $familymembers ;

		// $q = 'SELECT family_id, family_name
				// FROM families';

		$q = 'SELECT * FROM families';
				
		$families = DB::instance(DB_NAME)->select_rows($q);
				
// echo '<pre>';
// print_r($families);
// echo '</pre>';
				
		# Pass data to the View
		$this->template->content->families  = $families ;
		
		# CSS/JS includes
			$client_files_head = Array("/css/profile.css", "/css/admin.css");
	    	$this->template->client_files_head = Utils::load_client_files($client_files_head);
	    	
	    	$client_files_body = Array(
				"/js/profile.min.js", 
				"/js/admin.js", 
				// "/js/jquery.form.js",
				// "/js/admin_family_data_edit.js"
			);
				
	    	$this->template->client_files_body = Utils::load_client_files($client_files_body);   
	      					     		
		# Render the view
			echo $this->template;

	} # End of method


	# process of adding a new family	
	public function p_add_family() {
		
		# check if the family name existed first
		$family_name = $_POST['family_name'];
		// echo $family_name;
		
		$q = 'SELECT family_name FROM families WHERE family_name like "' . $family_name . '"' ;
		// echo $q;
		
		$result = DB::instance(DB_NAME)->select_field($q);

echo '<pre>';
print_r($result);
echo '</pre>';
		
		if ($result) {
			$message = 'Family name "' . $family_name . '" existed.';
			$redirect_path = "/admin/admin/$message";
			// echo $redirect_path;
			// Router::redirect($redirect_path);
		} else {
			
			DB::instance(DB_NAME)->insert('families', $_POST);
			$message = "Family " . $family_name . " has been added.";
		}
		$redirect_path = "/admin/admin/$message";
		// $redirect_path = "/admin/admin/";
		
 		Router::redirect($redirect_path);
	} # End of method

	public function p_add_user() {

		#make sure that email address is unique
		$q = "SELECT email FROM users WHERE email = '" . $_POST['email'] . "'";
		$result = DB::instance(DB_NAME)->select_field($q);
		if ($result) { 
			$error = TRUE;
			$message = "This email " . $_POST['email'] . " has been used. Please use another one.";
			$redirect_path = "/admin/admin/$message";
			Router::redirect($redirect_path);
		}


// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

		$first_name = $_POST['first_name'];
		$family_name = $_POST['family_name'];
		
		unset ($_POST['password2']);
		$family_name = $_POST['family_name'];
		unset ($_POST['family_name']);

		# we want to know when the user is created and user's data is changed
		$_POST['created'] = Time::now();
		$_POST['modified'] = Time::now();

		/* encrypt user's password */
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		# create an encrypted token via email address and a arandom string 
		$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

		# insert the user into database
		$user_id = DB::instance(DB_NAME)->insert('users', $_POST);
		
		# still need to create a relationship between the user and family in userfamily table
		# fisrt find out what is the family_id 
		$q = "SELECT family_id FROM families WHERE family_name = '" . $family_name . "'";
		
		$family_id = DB::instance(DB_NAME)->select_field($q);
		
		# clear up the $_POST 
		$_POST = array(); 
		$_POST['user_id'] = $user_id;
		$_POST['family_id'] = $family_id;
		
		# insert a new row into userfamily to create relationship between the user and family
		DB::instance(DB_NAME)->insert('usersfamily', $_POST);
		
		$message = "New user '" . $first_name . "' is added and joined to family '" . $family_name . "'.";
		$redirect_path = "/admin/admin/$message";
		Router::redirect($redirect_path);

	} # End of method p_add_user

	// administrator updates family infomation from admin page
	public function p_admin_family_data_edit($user_id = NULL) {

		$data = $_POST;
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';		
		DB::instance(DB_NAME)->update("families", $data, "WHERE family_name = '".$_POST["family_name"]."'");
	
		Router::redirect("/admin/admin");
	}




	
} # End of class










