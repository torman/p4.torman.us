<?php

class operations_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        // if(!$this->user) {
            // die("Members only. <a href='/users/login'>Login</a>");
        // }
    }

    public function family_edit( $family_data = NULL) {

		# Setup view
        $this->template->content = View::instance('v_family_edit');
        $this->template->title   = "Edit family data";
		
		$this->template->content->family_data = $family_data;
		
        // # Render template
        echo $this->template;
    }

    public function p_family_edit($family_id = NULL) {

         # update family data here
 
		DB::instance(DB_NAME)->update('families', $_POST, "WHERE family_id = $family_id"); 

 		Router::redirect('/');
    }

}
?>