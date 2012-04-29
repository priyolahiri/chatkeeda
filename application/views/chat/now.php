<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/underscore.min.js"></script>
		<script src="http://js.pusher.com/1.11/pusher.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/font-awesome.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/custom.css" media="all" />
		<script language="JavaScript">
			$(function() {
				chatInit();
				<?php
				if ($chat->chatinfo['live']) {
					echo "
					pusher = new Pusher('$chat->pusherKey');
					Pusher.channel_auth_endpoint = '/chatauth/$chat->chatslug';
					channel = pusher.subscribe('$chat->pusherChannel');
					";
				}
				?>
			})
			function chatInit() {
				$.ajax({
					url: '/chatnow/<?php echo($chat->chatinfo['slug']) ?>',
						type: 'POST',
						dataType: 'json',
						success: function(data) {
							console.log(data);
							if (data.admin) {
								channel.bind('pusher:subscription_succeeded', function(members) {
									var onlinetext = members.count + ' user(s) online';
									$('#contacts_window ul.window').append('<li class="well">'+onlinetext+'</li>');
									members.each(function(member) {
										$('#contacts_window ul.window').append('<li class="well">'+member.info.username+'<br/>'+member.info.role+'</li>');
									});
								});
								channel.bind('pusher:member_added', function(member) {
								
								});
							}
						},
						error: function(data) {
							console.log(data);
						}
				})
			}
		</script>
		<title>ChatKeeda | <?php echo ($chat->chatinfo['name']) ?></title>
	</head>
	<body>
		<!-- Page Container Begin -->
		<div class="container" id="page">
			<!-- Header Begin -->
			<div class="row" id="header">
				<div class="span12" id="logo">
					<img src="/img/skeeda.png" alt="SportsKeeda Logo" />
				</div>
			</div>
			<!-- Header End -->
			<!-- Body Begin -->
			<div class="row" id="body">
				<!-- Content Begin -->
				<div class="span9" id="content">
					<!-- Content Inner Begin -->
					<div id="content_inner" class="well">
						<ul class="breadcrumb">
  							<li>
    								<a href="/">ChatKeeda</a>
    								<span class="divider">/</span>
  							</li>
  							<li class="active">
    								<a href="#"><?php echo ($chat->chatinfo['name']) ?></a>
  							</li>
						</ul>
						<h2><?php echo ($chat->chatinfo['name']) ?></h2>
						<hr/>
						<div class="well" id="chat_window">
							<ul class="window"></ul>
						</div>
						<div class="clearfix"></div>
						<div class="well" id="comm_window">
							&nbsp;
						</div>
					</div>
					<!-- Content Inner End -->
				</div>
				<!-- Content End -->
				<!-- Sidebar Begin -->
				<div class="span3" id="sidebar">
					<div id="sidebar_inner" class="well">
						<a href="/logout" class="btn btn-primary">Logout</a>
						<hr/>
						<button id="finish_chat">Finish Chat</button>
						<hr/>
						<div class="well" id="contacts_window">
							<ul class="window"></ul>
						</div>
						<div class="clearfix"></div>
						<div class="well" id="approve_window">
							<ul class="window"></ul>
						</div>
					</div>
				</div>
				<!-- Sidebar End -->
				<div class="clear"></div>
			</div>
			<!-- Body End -->
			<!-- Footer Begin -->
			<div class="row" id="footer">
				<div class="span12" id="footer_1">
					<div id="footer_inner" class="well">
						Footer<br/><br/><br/>	
					</div>
				</div>
			</div>
			<!-- Footer End -->	
		</div>
		<!-- Page Container End -->
	</body>
</html>