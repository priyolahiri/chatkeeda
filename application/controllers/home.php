<?php

class Home_Controller extends Base_Controller {
	public function action_index()
	{
		$success = Session::get('success');
		$error = Session::get('error');
		return View::make('home.index')->with('error', $error)->with('success', $success);
	}
}