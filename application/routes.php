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
Route::get('/embed/(:any)', function($vidid) {
	$url = "http://www.youtube.com/embed/$vidid";
	$crl = curl_init();
    $timeout = 5;
    curl_setopt ($crl, CURLOPT_URL,$url);
    curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
});
Route::post('upload/(:any)', function($slug) {
	$user = new User;
	if($user->returnStatus()) {
			$imgupload = Input::file('imgupload');
			$imguploadname = Input::file('imgupload.name');
			$imguploadext = File::extension($imguploadname);
			if(!file_exists($_SERVER{'DOCUMENT_ROOT'} ."/uploads/".$slug))  {
				mkdir($_SERVER{'DOCUMENT_ROOT'} ."/uploads/".$slug, 0777,true);
			}
			$filename=uniqid().".".$imguploadext;
			Input::upload('imgupload', $_SERVER{'DOCUMENT_ROOT'} ."/uploads/".$slug."/".$filename);
			return json_encode(array(
				'url' => 'http://'.$_SERVER['HTTP_HOST']."/uploads/".$slug."/".$filename,
				'success' => TRUE
			));
	} else {
		return json_encode(array("success"=>FALSE));
	}		
});
Route::post('chataction/(:any)/(:any)', function($slug, $action) {
	$chat = new Chat;
	$chat->initChat($slug);
	$chatinfo = $chat->chatinfo;
	$chatauth = $chat->authChat();
	
	//start of sendchat action
	if ($action == "sendchat") {
		if ($chatauth['admin'] or $chatauth['superadmin'] or $chatauth['role'] == "normal") {
			$posttext = Input::get('chat_text');
			$postimgsrc = Input::get('img_source');
			$postimgcode = Input::get('img_code');
			$postvidsrc = Input::get('vid_source');
			$postvidcode = Input::get('vid_code');
			if (!$posttext and !$postimgcode and !$postvidcode) {
				return json_encode(array('success' => FALSE, 'msg' => 'Please enter something. You cannot send a blank chat'));
			}
			if (!$postimgsrc=="NA" and !$postimgcode) {
				return json_encode(array('success' => FALSE, 'msg' => 'Please enter valid image code.'));
			}
			if (!$postvidsrc=="NA" and !$postvidcode) {
				return json_encode(array('success' => FALSE, 'msg' => 'Please enter valid video code.'));
			}
			$name = $chatauth['username'];
			$msg = "<b>".$name . " :</b> ";
			$msg .= $posttext ? $posttext.'<br/>' : '';
			if ($postimgsrc=='twitpic') {
				$msg.="<a href='http://twitpic.com/$postimgcode' target='_blank'><img src='http://twitpic.com/show/thumb/$postimgcode' /></a><br/>";
			}
			if ($postimgsrc=='yfrog') {
				$msg.="<a href='http://yfrog.com/$postimgcode' target='_blank'><img src='http://yfrog.com/$postimgcode:small' /></a><br/>";
			}
			if ($postimgsrc=='upload') {
				$msg.="<a href='$postimgcode' rel='fancybox'><img class='custom_post' src='$postimgcode' /></a><br/>";
			}
			if ($postvidsrc=='youtube') {
				$msg.="<iframe width='320' height='240' src='http://chatapp.priyolahiri.co.cc/embed/$postvidcode' frameborder='0' allowfullscreen></iframe>";
			}
			if (!$chatauth['superadmin'] or !$chatauth['admin']) {
				$chat->addMsg($msg);
				$post_status = "Message Posted";
			} else {
				$chat->addMsgMod($msg);
				$post_status = "Message Posted for Moderation";
			}
			return json_encode(array("success" => TRUE, "msg" => $post_status));
		} else {
			return json_encode(array("success" => FALSE, "msg" => "You do not have permissions to post."));
		}
  	}
	//end of sendchat action
	if ($action=="getoldchat") {
		return json_encode($chat->getChat());
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