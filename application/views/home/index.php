<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/custom.css" media="all" />
		<title>ChatKeeda | Home</title>
	</head>
	<body>
		<!-- Page Container Begin -->
		<div class="container" id="page">
			<!-- Header Begin -->
			<div class="row" id="header">
				<div class="span12" id="logo">
					Logo
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
    								<a href="#">Home</a>
  							</li>
						</ul>
						<div class="row">
							<div class="span4">
								<p align="center">
									Col 1
								</p>
							</div>
							<div class="span4">
								<p align="center">
									Col 2
								</p>
							</div>
							<div class="clear clearfix"></div>
						</div>
						<div class="clear clearfix"></div>
						<hr/>
					</div>
					<!-- Content Inner End -->
				</div>
				<!-- Content End -->
				<!-- Sidebar Begin -->
				<div class="span3" id="sidebar">
					<div id="sidebar_inner" class="well">
						<form method="post" action="/user/login">
							<div class="control-group">
								<label class="control-label" for="email">Email address</label>
								<div class="input-prepend">
              						<span class="add-on"><i class="icon-envelope"></i></span>
              						<input type="text" id="email" name="email" class="span2">
            						</div>
								<label class="control-label" for="password">Password</label>
								<div class="input-prepend">
              						<span class="add-on"><i class="icon-lock"></i></span>
              						<input type="password" id="password" name="password" class="span2">
            						</div>
							</div>
							<button class="btn btn-success" type="submit"><i class="icon-home icon-white"></i>Login</button>
							<a class="btn btn-primary" href="/register" type="submit"><i class="icon-pencil icon-white"></i>Register</a><br/><br/>
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
						</form>
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