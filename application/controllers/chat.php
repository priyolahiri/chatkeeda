<?php
Class Chat_Controller extends Base_Controller {
	public function action_new() {
		$success = Session::get('success');
		$error = Session::get('error');
		return View::make('chat.new')->with('regform', $regform)->with('error', $error)->with('success', $success);
	}
}
