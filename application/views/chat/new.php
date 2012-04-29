<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/font-awesome.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/custom.css" media="all" />
		<title>ChatKeeda | New Chat</title>
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
    								<a href="#">New Chat</a>
  							</li>
						</ul>
						<h2>Home</h2>
						<hr/>
						<h2>New Chat</h2>
							<?php
							if (!$success) {
							?>
						    <form class="well form-inline" method="post" action="/chat/create">
    								Chat Name <input type="text" class="input-medium" name="chat_name">
    								Score
    								<select name="score" id="score">
    									<option value="yes">Yes</option>	
    									<option value="no">No</option>
    								</select>
        							<button type="submit" class="btn btn-primary">Create</button>
    							</form><br />
    							<?php
							}
    							?>
    						<?php
							if ($error) {
							?>
							<div class="alert alert-error"><?php echo($error); ?></div>
							<?php
							}
							?>
							<?php
							if ($success) {
							?>
							<div class="alert alert-success"><?php echo($success); ?></div>
							<?php
							}
							?>
					</div>
					<!-- Content Inner End -->
				</div>
				<!-- Content End -->
				<!-- Sidebar Begin -->
				<div class="span3" id="sidebar">
					<div id="sidebar_inner" class="well">
						<a href="/logout" class="btn btn-primary">Logout</a>
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