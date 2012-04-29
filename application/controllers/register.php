<?php
Class Home_Controller extends Base_Controller {
	public function action_index() {
		$customval = array(array(
		"name" => "email_check",
		"function" => 
		"function(value, element) {
			if (value.length > 3) {
					var response;
				  	dataajax = \$.ajax({
				  		url: 	'/register/emailcheck',
				  	  	data:	'email='+value,
				  	  	dataType: 'json',
				  	  	type: 'POST',
				  	  	async: false,
				  	  	success: function(data) {
				  	  		response = data;
				  	  	}
				  	});
				  	if (response.success) {
				  		return true;
				  	} else {
				  		return false;
				  	}
			} else {
				return false;
			}
		}",
		"msg" => "Email address is already registered."
		),
		array(
		"name" => "user_check",
		"function" => 
		"function(value, element) {
			if (value.length > 3) {
					var response;
				  	dataajax = \$.ajax({
				  		url: 	'/register/usercheck',
				  	  	data:	'email='+value,
				  	  	dataType: 'json',
				  	  	type: 'POST',
				  	  	async: false,
				  	  	success: function(data) {
				  	  		response = data;
				  	  	}
				  	});
				  	if (response.success) {
				  		return true;
				  	} else {
				  		return false;
				  	}
			} else {
				return false;
			}
		}",
		"msg" => "Username is already taken."
		)
		);
		$regform = new Slickform('register', 'POST', '/register/create', 'form-horizontal', false, true, true, 'right', $customval);
		$regform->addFieldset('Account Information');
		$regform->addTextField('username', 'Username', false, true, false,"Enter valid username.", 'user_check', false, 'user');
		$regform->addTextField('email', 'Email', false, true, false,"Enter valid e-mail address. Preferably company.", 'email email_check', false, 'envelope');
		$regform->addPasswordField('password', 'Password', false, true, false, "Choose a password atleast 5 chars long.", false, array("minlength" => "5"), 'lock');
		$regform->endFieldset();
		$regform->addFieldset('Personal Information');
		$regform->addTextField('first_name', 'First Name', false, true, false, "Enter your first name.", false, array("minlength" => "3"), 'user');
		$regform->addTextField('last_name', 'Last Name', false, true, false, "Enter your last name.", false, array("minlength" => "3"), 'user');
		$regform->addTextField('city', 'City', false, true, false, "Enter your location.", false, false, 'map-marker');
		$regform->addFormActions();
		$regform->addButton('register', 'Register', 'submit', 'primary', false, "ok-circle");
		$regform->endFormActions();
		$regform->endFieldset();
		$regform->addConfirm(
							"Registration Successful!",
							"You have been successfully registered.",
							"Registration Error",
							"An error prevented the registration. Please try again later."
							);
		return View::make('register.index')->with('regform', $regform);
	}
	public function action_create() {
		$user = new User;
		return $user->createUser();
	}
	public function action_emailcheck() {
		$user = new User;
		$emailsearch = $user->usercoll->findOne(array('email' => Input::get('email')));
		if ($emailsearch) {
			return json_encode(array("success" => false));
		} else {
			return json_encode(array("success" => true));
		}
	}
	public function action_usercheck() {
		$user = new User;
		$usersearch = $user->usercoll->findOne(array('username' => Input::get('username')));
		if ($usersearch) {
			return json_encode(array("success" => false));
		} else {
			return json_encode(array("success" => true));
		}
	}
}