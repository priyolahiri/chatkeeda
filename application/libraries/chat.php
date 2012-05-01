<?php
Class Chat {
	public function __construct() {
		$user = New User;
		$this->userinfo = $user->returnUser();
		$this->authstatus = $user->returnStatus();
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
			$this->chatset = new Rediska_Key_List($chatid."_chat");
			$this->modchatset = new Rediska_Key_List($chatid."_chat_moderate");
			$this->chatscore = new Rediska_Key_List($chatid."_score");
			return true;
		}
		return false;
	}
	public function addMsg($msg) {
		$timenow = date('H:i', time());
		$transport = json_encode(array('timenow' => $timenow, 'msg' => $msg));
		$this->chatset[] = $transport;
		$this->pusher->trigger($this->pusherChannel, 'chat', $transport, null, false, true);
	}
	public function addMsgMod($msg) {
		$timenow = date('H:i', time());
		$transport = json_encode(array('timenow' => $timenow, 'msg' => $msg));
		$this->modchatset[] = $transport;
		$transport2 = json_encode(array("postedmod" => TRUE));
		$this->pusher->trigger($this->pusherChannel, 'newmodmsg', $transport2, null, false, true);
	}
	public function getChat() {
		return $this->chatset->toArray(true);
	}
	public function getScore() {
		if (isset($this->chatscore[0])) {
			return $this->chatscore[0];
		} else {
		 	return array();
		}
	}
	public function setScore($score) {
		error_log("Score: ".$score);
		$newtransport = json_encode(array('score' => $score));
		if (isset($this->chatscore[0])) {
			$this->chatscore[0] = $newtransport;
		} else {
			$this->chatscore[] = $newtransport;
		}
		$this->pusher->trigger($this->pusherChannel, 'score', $newtransport, null, false, true);
	}
	public function getModChat() {
		return $this->modchatset->toArray(true);
	}
	public function approveMsg($id) {
		$transport = json_decode($this->modchatset[$id]);
		$timenow = date('H:i', time());
		$newtransport = json_encode(array('timenow' => $timenow, 'msg' => $transport->msg));
		$this->chatset[] = $newtransport;
		$this->pusher->trigger($this->pusherChannel, 'chat', $newtransport, null, false, true);
		$this->modchatset->remove(json_encode($transport));
		return array("success" => true);
	}
	public function makeAdmin($id) {
		$adminsearch = $this->chatcoll->findOne(array("slug" => $slug));
		$admins = json_decode($adminsearch['admins'], true);
		array_push($admins, $id);
		$this->chatcoll->update(array("slug" => $slug), array("admins" => json_encode($admins)));
		$newtransport = json_encode(array("user_id" => $id));
		$this->pusher->trigger($this->pusherChannel, 'madeadmin', $newtransport, null, false, true);
		return array("success" => true);
	}	
	public function authChat() {
		if ($this->authstatus) {
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
				Session::put('anonid', uniqid());
				$username = Session::get("anonid");
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
			"user_id" => $username
		);
	}
	public function listChats($live = true) {
		return $this->chatcoll->find(array("live" => $live));
	}
}
