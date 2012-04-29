<?php
Class Chat_Controller extends Base_Controller {
	public function action_new() {
		$success = Session::get('success');
		$error = Session::get('error');
		$user = new User;
		if (!$user->authstatus) {
			return View::make('error.other')->with('title', "Authentication Error")
			->with('errormsg', "You need to be signed in to create a chat.")
			->with('user', $user)
			->with('error', $error)->with('success', $success);
		}
		return View::make('chat.new')->with('error', $error)->with('success', $success)->with('user', $user);
	}
	public function action_create() {
		
	}
}
