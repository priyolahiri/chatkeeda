<?php
Route::controller(array('home', 'register', 'chat'));

Route::post('login', function() {
	$user = new User;
	$usertry = $user->doAuth();
	if ($usertry['success']) {
		return Redirect::to('/')->with('success', $usertry['msg']);
	} else {
		return Redirect::to('/')->with('error', $usertry['msg']);
	}
});

Route::get('logout', function() {
	Session::flush();
	return Redirect::to('/')->with('success', 'Successfully logged out!');
});
Route::get('chatnow/(:any)', function($slug) {
	$chat = new Chat;
	$chat->initChat($slug);
	return View::make('chat.now')->with('chat', $chat);
});
Route::post('chatnow/(:any)', function($slug) {
	$chat = new Chat;
	$chat->initChat($slug);
	return json_encode($chat->authChat());
});
Route::post('chatauth/(:any)', function($slug) {
	$chat = new Chat;
	$chat->initChat($slug);
	$user_id = $chat->userinfo['username'];
	$pusher = new Pusher(PUSHERKEY, PUSHERSECRET, PUSHERAPPID);
	$presence_data = $chat->authChat();
	error_log('chatauth');
	return $pusher->presence_auth($_POST['channel_name'], $_POST['socket_id'], $presence_data['user_id'], $presence_data);
});
Route::post('chataction/(:any)/(:any)', function($slug, $action) {
	$chat = new Chat;
	$chat->initChat($slug);
	$chatinfo = $chat->chatinfo;
	$chatauth = $chat->authChat();
	if ($action == "sendchat") {
		if ($chatauth['admin'] or $chatauth['superadmin'] or $chatauth['role'] == "normal") {
			return json_encode(array("success" => TRUE, "msg" => "Message posted"));
		} else {
			return json_encode(array("success" => FALSE, "msg" => "You do not have permissions to post."));
		}
  	}
});
Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in "before" and "after" filters are called before and
| after every request to your application, and you may even create other
| filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});