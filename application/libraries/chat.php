<?php
Class Chat {
	public function __construct() {
		$user = New User;
		$this->userinfo = $user->returnUser();
		$mongo = new Mongo(MONGOHOST);
		$db = $mongo->chatkeeda;	
		$this->chatcoll = $db->chats;
		$this->chatinfo = false;
		$this->init = false;
	}
	public function newChat($name, $score = false) {
		$slug = Str::slug($name);
		$insert = array("name" => $name, "slug" => $slug, "creator" => $this->userinfo['username'], "admins" => json_encode(array($this->userinfo['username'])), "live" => true, "score" => $score, "start" => time(), "end" => 0);
		$this->chatcoll->insert($insert);	
	}
	public function checkName($name) {
		$slug = Str::slug($name);
		$check = $this->chatcoll->findOne(array("slug" => $slug));
		if ($check) {
			return true;
		}
		return false;
	}
	public function initChat($slug) {
		$chatretr = $this->chatcoll->findOne(array("slug" => $slug));
		if ($chatretr) {
			$this->chatinfo = $chatretr;
			$chatid = $this->chatinfo['slug'];
			$this->chatslug = $this->chatinfo['slug'];
			$score = $this->chatinfo['score'];
			include 'Rediska.php';
			$this->rediska = new Rediska();
			$this->pusher = new Pusher(PUSHERKEY, PUSHERSECRET, PUSHERAPPID);
			$this->pusherKey = PUSHERKEY;
			$this->pusherChannel = "presence-".$chatid;
			$this->pusherModChannel = "presence-".$chatid."-moderate";
			$this->chatcollet = new Rediska_Key_List($chatid."_chat");
			$this->modchatset = new Rediska_Key_List($chatid."_chat_moderate");
			if ($score) {
				$this->chatscore = new Rediska_Key_List($chatid."_score");
			}
			return true;
		}
		return false;
	}
	public function authChat() {
		if ($this->userinfo) {
			$auth = true;
			if ($this->userinfo['username'] == $this->chatinfo['creator']) {
				$creator = true;
			} else {
				$creator = false;
			}
			if ($this->userinfo['role'] ==	 'superadmin') {
				$superadmin = true;
				$role = "superadmin";
			} else {
				$superadmin = false;
				$role = "normal";
			}
			$chatadmins = json_decode($this->chatinfo['admins'], true);
			if (in_array($this->userinfo['username'], $chatadmins)) {
				$admin = true;
			} else {
				$admin = false;
			}
			$username = $this->userinfo['username'];
		} else {
			$auth = false;
			if (Session::has("anonid")) {
				$username = Session::get("anonid");
			} else {
				$username = uniqid("", true);
			}
			$role = "anonymous";
			$admin = false;
			$superadmin = false;
			$creator = false;
		}
		return array(
			"auth" => $auth,
			"username" => $username,
			"role" => $role,
			"admin" => $admin,
			"superadmin" => $superadmin,
			"creator" => $creator,
			"user_id" => $this->userinfo['username']
		);
	}
	public function listChats($live = true) {
		return $this->chatcoll->find(array("live" => $live));
	}
}
