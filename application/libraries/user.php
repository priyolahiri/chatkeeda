<?php
Class User {
	public function __construct() {
		$this->userdetail = array();
		$mongo = new Mongo(MONGOHOST);
		$db = $mongo->chatkeeda;
		$this->usercoll = $db->users;
		if (!Session::has('chatkeeda_user')) {
			$this->authstatus = FALSE;
		} else {
			$username = Session::get('chatkeeda_user');
			$userfind = $this->usercoll->findOne(array("username" => $username));
			if ($userfind) {
				$this->authstatus = TRUE;
				$this->userinfo['username'] 		= $userfind['username'];
				$this->userinfo['email'] 			= $userfind['email'];
				$this->userinfo['first_name'] 	= $userfind['first_name'];
				$this->userinfo['last_name'] 	= $userfind['last_name'];
				$this->userinfo['role'] 				= $userfind['role'];
			} else {
				$this->authstatus = FALSE;
			}
		}
	}
	public function returnUser() {
		if (!$this->authstatus) {
			return false;
		}
		return $this->userinfo;
	}
	public function returnStatus() {
		return $this->authstatus;
	}
	public function doAuth() {
		if (!Input::get('username') or !Input::get('password')) {
			return array('success' => FALSE,'msg' => 'Both the username and password are needed.');
		}
		$username = Input::get('username');
		$password = Input::get('password');
		$userfind = $this->usercoll->findOne(array("username" => $username, "password" => md5($password)));
		if ($userfind) {
			Session::put('chatkeeda_user', $userfind['username']);
			$this->authstatus = TRUE;
			$this->userinfo['username'] 		= $userfind['username'];
			$this->userinfo['email'] 			= $userfind['email'];
			$this->userinfo['first_name'] 	= $userfind['first_name'];
			$this->userinfo['last_name'] 	= $userfind['last_name'];
			$this->userinfo['role'] 				= $userfind['role'];
			return array('success' => TRUE, 'msg' => 'Logged in successfully.');
		} else {
			return array('success' => FALSE, 'msg' => 'Wrong username or password.');
		}
	}
	public function createUser($role = FALSE) {
		$newuser = array();
		$newuser['username'] 	= Input::get('username');
		$newuser['email'] 			= Input::get('email');
		$newuser['password']	= md5(Input::get('password'));
		$newuser['first_name'] 	= Input::get('first_name');
		$newuser['last_name'] 	= Input::get('last_name');
		$newuser['role']			= !$role ? 'normal' : $role;
		try {
			$this->usercoll->insert($newuser);
		} catch (Exception $e) {
			return json_encode(array("error" => TRUE, "error_detail" => "Account creation failed."));
		}
		Session::put('chatkeeda_user', Input::get('username'));
		$this->__construct();
		$msgbody = "
		<html>
		<head><title>Registration Successful!</title></head>
		<body>
		<p><img src='http://".$_SERVER['SERVER_NAME']."/img/skeeda.png' alt='spotrskeeda logo' /></p>
		<hr/>
		<p>
			Hi ".Input::get('first_name').",<br/><br/>
			Thank you for registering. Please feel free to use the system and provide us your valuable feedback.<br/>
			<br/>
			Please find your account information below.<br/>
			<br/>
			<b>Username/Nickname:</b> ".Input::get('username')."<br/>
			<b>Password:</b> ".Input::get('password')."<br/><br/>
			Porush Jain<br/>
			SportsKeeda
		</p>
		</body>
		</html>
		";
		require_once('swift_required.php');
		$transport = Swift_MailTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance()
  		// Give the message a subject
 		->setSubject('Registration Successful!')
  		// Set the From address with an associative array
  		->setFrom(array(ADMINMAIL => 'ChatKeeda Administrator'))
  		// Set the To addresses with an associative array
  		->setTo(array(Input::get('email') => Input::get('first_name').' '.Input::get('last_name')))
  		// Give it a body
  		->setBody($msgbody, 'text/html');
		$result = $mailer->send($message);
		return json_encode(array("success" => TRUE));
	}
}
