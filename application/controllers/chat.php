<?php
Class Chat_Controller extends Base_Controller {
	public function action_new() {
		$success = Session::get('success');
		$error = Session::get('error');
		$user = new User;
		if (!$user->authstatus) {
			return View::make('error.other')->with('title', "Authentication Error")->with('error', "You need to be signed in to create a chat.")->with('user', $user);
		}
		return View::make('chat.new')->with('regform', $regform)->with('error', $error)->with('success', $success)->with('user', $user);
	}
}
