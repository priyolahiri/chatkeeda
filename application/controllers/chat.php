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
		$user = new User;
		if (!$user->authstatus) {
			return View::make('error.other')->with('title', "Authentication Error")
			->with('errormsg', "You need to be signed in to create a chat.")
			->with('user', $user)
			->with('error', $error)->with('success', $success);
		}
		if (!Input::get('chat_name') or strlen(Input::get('chat_name')) < 5) {
			return Redirect::to('/chat/new')->with('error', "Chat name needs to be atleast four characters in length.");
		}
		$chat = new Chat;
		if ($chat->checkName(Input::get('chat_name'))) {
			return Redirect::to('/chat/new')->with('error', "Chat name already taken. Please try another.");
		}
		if (Input::get('score') == "yes") {
			$score = TRUE;
		} else {
			$score = FALSE;
		}
		$chat->newChat(Input::get('chat_name'), $score);
		return Redirect::to('/chat/new')->with('success', "The chat was created.<br/><a href='/chatnow/".Str::slug(Input::get('chat_name'))."' class='btn btn-primary'>Chat Now</a>");
	}
	public function action_running() {
		$success = Session::get('success');
		$error = Session::get('error');
		$chat = new Chat;
		$list = $chats->listChats();
		return View::make('chat.list')->with('success', $success)->with('error', $error)->with('list', $list)->with('key', 'Running');
	}
	public function action_closed() {
		$success = Session::get('success');
		$error = Session::get('error');
		$chat = new Chat;
		$list = $chats->listChats(FALSE);
		return View::make('chat.list')->with('success', $success)->with('error', $error)->with('list', $list)->with('key', 'Closed');
	}
}
