<?php

class Home_Controller extends Base_Controller {
	public function action_index()
	{
		$success = Session::get('success');
		$error = Session::get('error');
		$user = new User;
		$userinfo = $user->returnUser();
		return View::make('home.index')->with('error', $error)->with('success', $success)->with('userinfo', $userinfo);
	}
}