<?php

class index_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------

	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	} 
		
	/*-------------------------------------------------------------------------------------------------
	Accessed via http://localhost/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index($message = NULL) {
		
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file
		$this->template->content = View::instance('v_index_index');
			
		# Now set the <title> tag
		$this->template->title = APP_NAME;
		
		$this->template->message = $message;
		// if ($this->user) {
			$q = 'SELECT * FROM families';

				$families = DB::instance(DB_NAME)->select_rows($q);

				# Pass data to the View
				$this->template->content->families  = $families ;
		// }
			
		# CSS/JS includes
			$client_files_head = Array("/css/profile.css", "/css/index.css");
	    	$this->template->client_files_head = Utils::load_client_files($client_files_head);
	    	
	    	$client_files_body = Array("/js/profile.min.js");
	    	$this->template->client_files_body = Utils::load_client_files($client_files_body);   
	      					     		
		# Render the view
			echo $this->template;

	} # End of method
	

} # End of class
