<?php
$chatuser = $chat->authChat();
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/underscore.min.js"></script>
		<script type="text/javascript" src="/js/jquery.noty.js"></script>
		<script src="http://js.pusher.com/1.11/pusher.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/font-awesome.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/custom.css" media="all" />
		<link rel="stylesheet" type="text/css" href="/css/jquery.noty.css" media="all" />
		<script language="JavaScript">
			$(function() {
				$.ajax({
					url: '/chataction/<?php echo($chat->chatinfo['slug']) ?>/getoldchat',
					type: 'POST',
					dataType: 'json',
					success: function(data) {
						console.log(data);
						_.each(data, function(oldchat) {
							var oldobj = jQuery.parseJSON(oldchat);
							var chattime = oldobj.timenow;
							var chatmsg = oldobj.msg;
							var output = '<li class="well"><span class="label label-success">'+chattime+'</span>&nbsp;&nbsp;'+chatmsg+'</li>';
							$('#chat_window ul.window').append(output);
						});
						var elem = document.getElementById('chat_window');
						elem.scrollTop = elem.scrollHeight;
					}
				});
				<?php
					if ($chat -> chatinfo['live']) {
					echo "
					pusher = new Pusher('$chat->pusherKey');
					Pusher.channel_auth_endpoint = '/chatauth/$chat->chatslug';
					channel = pusher.subscribe('$chat->pusherChannel');
					";
				?>
				$.ajax({
					url: '/chatnow/<?php echo($chat->chatinfo['slug']) ?>',
					type: 'POST',
					dataType: 'json',
					success: function(data) {
						console.log(data);
						channel.bind('chat', function(data){
							var chattime = data.timenow;
							var chatmsg = data.msg;
							var output = '<li class="well"><span class="label label-success">'+chattime+'</span>&nbsp;&nbsp;'+chatmsg+'</li>';
							$('#chat_window ul.window').append(output);
							var elem = document.getElementById('chat_window');
							elem.scrollTop = elem.scrollHeight;
							});
						},
					error: function(data) {
						console.log(data);
					}
				})
			});
			<?php
			}
			?>
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
			<div class="row" id="menuheader">
				<div class="span12" >
					<div class="mmheader">
						<!--
						To change this template, choose Tools | Templates
						and open the template in the editor.
						-->
						<ul id="menu">
							<li style="background: none repeat scroll 0 0 transparent;border: 0 none;padding: 4px 8px;" class="menulink">
								<a class="nodrop" id="homelink" href="http://www.sportskeeda.com/"> <img width="20" height="20" src="http://1-ps.googleusercontent.com/h/www.sportskeeda.com/wp-content/themes/custom/images/20x20xhome.png.pagespeed.ic.uq8C2NbfwD.png"> </a>
							</li>
							<li class="menulink">
								<a class="drop" id="football" href="http://www.sportskeeda.com/football/">Football</a>
								<div class="dropdown_4columns">
									<div class="col_4">
										<ul class="greybox">
											<li>
												<a href="#footballhome">Home</a>
											</li>
											<li>
												<a href="#epl">EPL</a>
											</li>
											<li>
												<a href="#indianfootball">Indian Football</a>
											</li>
											<li>
												<a href="#international">International</a>
											</li>
											<li>
												<a href="#laliga">La Liga</a>
											</li>
											<li>
												<a href="#bundesliga">Bundes Liga</a>
											</li>
											<li>
												<a href="#seriea">Serie A</a>
											</li>

										</ul>
										<div class="tabs">
											<div id="footballhome" class="tab" style="display: none;">
												<div class="col_4">
													<div style="float:left; width: 130px;">
														<ul class="nobox">
															<li>
																<a href="/football/">Home</a>
															</li>
															<li>
																<a href="/football/epl/">EPL</a>
															</li>
															<li>
																<a href="/football/fa-cup/">FA Cup</a>
															</li>
															<li>
																<a href="/football/serie-a/">Serie A</a>
															</li>
															<li>
																<a href="/football/mls/">MLS </a>
															</li>
															<li>
																<a href="/football/ucl/">UCL </a>
															</li>

															<li>
																<a href="/football/la-liga/">La Liga </a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 20px;height:205px" class="col_1">
														<ul class="nobox">
															<li>
																<a href="/football/euro-2012/">Euro 2012</a>
															</li>
															<li>
																<a href="/football/india/">Indian Football</a>
															</li>

															<div style="color:red;font-size: 11px;" class="sublinehead">
																Forums
															</div>
															<div style="clear: both;height: 1px;border-top: 1px solid #B2B0B0;width:40px;" class="seperator"></div>
															<li>
																<a href="http://forum.sportskeeda.com/categories/football/">Football Forum </a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/indian-football/">Indian Football Forum </a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/epl/">EPL Forum </a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 20px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="/football/featured/">Featured</a>
															</li>
															<li>
																<a href="/football/humor/">Humor</a>
															</li>
															<li>
																<a href="/football/rant/">Rant</a>
															</li>
															<li>
																<a href="/football/interviews/">Interviews</a>
															</li>
															<li>
																<a href="/football/videos/">Videos</a>
															</li>
															<li>
																<a href="/football/quiz/">Quiz</a>
															</li>
															<li>
																<a href="/football/news/">News</a>
															</li>
														</ul>
													</div>
													<!--                            <div class="col_1">
													<ul class="nobox">
													<li><a href="/afc-cup-predictor-game/" >AFC Predictor</a></li>
													</ul>
													</div>-->
												</div>
											</div>
											<div id="epl" class="tab" style="display: none;">
												<div class="col_4">
													<div style="float:left; width: 80px;">
														<ul class="nobox">
															<li>
																<a href="/football/epl/">EPL </a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/epl/">Forum </a>
															</li>
														</ul>
													</div>
													<div style="width:100px" class="col_1">
														<ul style="border-left:1px solid #B2B0B0;padding-left: 20px;" class="nobox">
															<li>
																<a href="/Sports/arsenal/">Arsenal </a>
															</li>
															<li>
																<a href="/Sports/aston-villa/">Aston Villa</a>
															</li>
															<li>
																<a href="/Sports/blackburn-rovers/">Blackburn</a>
															</li>
															<li>
																<a href="/Sports/bolton/">Bolton </a>
															</li>
															<li>
																<a href="/Sports/chelsea/">Chelsea</a>
															</li>
															<li>
																<a href="/Sports/everton/">Everton</a>
															</li>
															<li>
																<a href="/Sports/fulham/">Fulham</a>
															</li>
														</ul>
													</div>
													<div style="width:150px" class="col_1">
														<ul style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="nobox">
															<li>
																<a href="/Sports/liverpool/">Liverpool</a>
															</li>
															<li>
																<a href="/Sports/manchester-city/">Manchester City</a>
															</li>
															<li>
																<a href="/Sports/manchester-united/">Manchester United</a>
															</li>
															<li>
																<a href="/Sports/norwich-city/">Norwich City</a>
															</li>
															<li>
																<a href="/Sports/newcastle-united/">Newcastle United</a>
															</li>
															<li>
																<a href="/Sports/queens-park-rangers/">Queens Park Rangers</a>
															</li>
															<li>
																<a href="/Sports/sunderland/">Sunderland</a>
															</li>
														</ul>
													</div>
													<div class="col_1">
														<ul style="border-left:1px solid #B2B0B0;padding-left: 20px;height:189px" class="nobox">
															<li>
																<a href="/Sports/stoke/">Stoke City</a>
															</li>
															<li>
																<a href="/Sports/swansea/">Swansea City</a>
															</li>
															<li>
																<a href="/Sports/tottenham-hotspur/">Tottenham Hotspur</a>
															</li>
															<li>
																<a href="/Sports/west-bromwich-albion/">West Bromwich Albion</a>
															</li>
															<li>
																<a href="/Sports/wigan/">Wigan Athletic</a>
															</li>
															<li>
																<a href="/Sports/wanderers/">Wolverhampton</a>
															</li>
														</ul>
													</div>
												</div>
											</div>
											<div id="indianfootball" class="tab" style="display: none;">
												<div class="col_4">
													<div style="float:left; width: 80px;">
														<ul class="nobox">
															<li>
																<a href="/football/india/">Home</a>
															</li>
															<li>
																<a href="/Sports/i-league/">I League</a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/indian-football/">Forum </a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="/Sports/air-india/">Air India</a>
															</li>
															<li>
																<a href="/Sports/chirag/">Chirag United</a>
															</li>
															<li>
																<a href="/Sports/churchill-brothers/">Churchill Brothers</a>
															</li>
															<li>
																<a href="/Sports/dempo/">Dempo</a>
															</li>
															<li>
																<a href="/Sports/east-bengal/">East Bengal</a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="/Sports/hal/">HAL</a>
															</li>
															<li>
																<a href="/Sports/mohun-bagan/">Mohun Bagan</a>
															</li>
															<li>
																<a href="/Sports/mumbai-fc/">Mumbai</a>
															</li>
															<li>
																<a href="/Sports/pailan-arrows/">Pailan Arrows</a>
															</li>
															<li>
																<a href="/Sports/prayag-united/">Prayag United</a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;height:148px" class="col_1">
														<ul class="nobox">
															<li>
																<a href="/Sports/pune-fc/">Pune</a>
															</li>
															<li>
																<a href="/Sports/salgaocar/">Salgaocar</a>
															</li>
															<li>
																<a href="/Sports/shillong-lajong-fc/">Shillong Lajong</a>
															</li>
															<li>
																<a href="/Sports/sporting-clube-de-goa/">Sporting Club</a>
															</li>
														</ul>
													</div>
												</div>
											</div>
											<div id="international" class="tab" style="display: none;">
												<div class="col_4">
													<div style="float:left; width: 80px;">
														<ul class="nobox">
															<li>
																<a href="/football/international/">Home</a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="/Sports/algeria/">Algeria</a>
															</li>
															<li>
																<a href="/Sports/argentina/">Argentina</a>
															</li>
															<li>
																<a href="/Sports/australia/">Australia</a>
															</li>
															<li>
																<a href="/Sports/austria/">Austria</a>
															</li>
															<li>
																<a href="/Sports/cameroon/">Cameroon</a>
															</li>
															<li>
																<a href="/Sports/chile/">Chile</a>
															</li>
															<li>
																<a href="/Sports/denmark/">Denmark</a>
															</li>
															<li>
																<a href="/Sports/engalnd/">England</a>
															</li>
															<li>
																<a href="/Sports/france/">France</a>
															</li>
															<li>
																<a href="/Sports/germany/">Germany</a>
															</li>
															<li>
																<a href="/Sports/ghana/">Ghana</a>
															</li>
															<li>
																<a href="/Sports/greece/">Greece</a>
															</li>
															<li>
																<a href="/Sports/honduras/">Honduras</a>
															</li>
															<li>
																<a href="/Sports/ireland/">Ireland</a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="/football/india/">India</a>
															</li>
															<li>
																<a href="/Sports/italy/">Italy</a>
															</li>
															<li>
																<a href="/Sports/ivory-coast/">Ivory Coast</a>
															</li>
															<li>
																<a href="/Sports/japan/">Japan</a>
															</li>
															<li>
																<a href="/Sports/mexico/">Mexico</a>
															</li>
															<li>
																<a href="/Sports/netherlands/">Netherlands</a>
															</li>
															<li>
																<a href="/Sports/new-zealand/">New Zealand</a>
															</li>
															<li>
																<a href="/Sports/nigeria/">Nigeria</a>
															</li>
															<li>
																<a href="/Sports/ireland/">Northern Ireland</a>
															</li>
															<li>
																<a href="/Sports/north-korea/">North Korea</a>
															</li>
															<li>
																<a href="/Sports/nigeria/">Paraguay</a>
															</li>
															<li>
																<a href="/Sports/poland/">Poland</a>
															</li>
															<li>
																<a href="/Sports/portugal/">Portugal</a>
															</li>
															<li>
																<a href="/Sports/russia/">Russia</a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="/Sports/serbia/">Serbia</a>
															</li>
															<li>
																<a href="/Sports/slovakia/">Slovakia</a>
															</li>
															<li>
																<a href="/Sports/slovenia/">Slovenia</a>
															</li>
															<li>
																<a href="/Sports/south-africa/">South Africa</a>
															</li>
															<li>
																<a href="/Sports/south-korea">South Korea</a>
															</li>
															<li>
																<a href="/Sports/spain/">Spain</a>
															</li>
															<li>
																<a href="/Sports/sweden/">Sweden</a>
															</li>
															<li>
																<a href="/Sports/switzerland/">Switzerland</a>
															</li>
															<li>
																<a href="/Sports/ukraine/">Ukraine</a>
															</li>
															<li>
																<a href="/Sports/uruguay/">Uruguay</a>
															</li>
															<li>
																<a href="/Sports/united-states/">United States</a>
															</li>
															<li>
																<a href="/Sports/wales/">Wales</a>
															</li>
															<li>
																<a href="/Sports/brazil/">Brazil</a>
															</li>
															<li>
																<a href="/Sports/scotland/">Scotland</a>
															</li>

														</ul>
													</div>
												</div>
											</div>
											<div id="laliga" class="tab" style="display: none;">
												<div class="col_4">
													<div style="float:left; width: 80px;">
														<ul class="nobox">
															<li>
																<a href="/football/la-liga/">Home</a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="http://www.sportskeeda.com/Sports/athletic-club-bilbao/"> Athletic Club Bilbao </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/osasuna/"> CA Osasuna </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/atletico-madrid/"> Atletico Madrid </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/cd-tenerife/"> CD Tenerife </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/deportivo-la-coruna/"> Deportivo La Coruña </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/barcelona/"> FC Barcelona </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/getafe/"> Getafe CF </a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="http://www.sportskeeda.com/Sports/malaga/"> Malaga CF </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/espanyol/"> RCD Espanyol </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/mallorca/"> RCD Mallorca </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/real-madrid/"> Real Madrid </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/real-valladolid/"> Real Valladolid </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/real-zaragoza/"> Real Zaragoza </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/sevilla/"> Sevilla </a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;height:200px" class="col_1">
														<ul class="nobox">
															<li>
																<a href="http://www.sportskeeda.com/Sports/racing-santander/"> Racing de Santander </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/sporting-de-gijon/"> Sporting de Gijon </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/almeria/"> UD Almeria </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/valencia/"> Valencia CF </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/villareal/"> Villarreal CF </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/xerez/"> Xerez CD </a>
															</li>
														</ul>
													</div>
												</div>
											</div>
											<div id="bundesliga" class="tab" style="display: none;">
												<div class="col_4">
													<div style="float:left; width: 80px;">
														<ul class="nobox">
															<li>
																<a href="/football/bundesliga/">Home</a>
															</li>

														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="http://www.sportskeeda.com/Sports/bayer-leverkusen/"> Bayer Leverkusen </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/borussia-dortmund/"> Borussia Dortmund </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/borussia-monchengladbach/">Monchengladbach </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/eintracht-frankfurt/"> Eintracht Frankfurt </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/energie-cottbus/"> Energie Cottbus </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/bayern-munich/"> FC Bayern Munich </a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="http://www.sportskeeda.com/Sports/cologne/"> FC Cologne </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/mainz/"> FSV Mainz 05 </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/hamburg-sv/"> Hamburg SV </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/hannover-96/"> Hannover 96 </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/hertha-berlin/"> Hertha Berlin </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/sc-freiburg/"> SC Freiburg </a>
															</li>

														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="http://www.sportskeeda.com/Sports/schalke-04/"> Schalke 04 </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/tsg-hoffenheim/"> TSG Hoffenheim </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/vfb-stuttgart/"> VfB Stuttgart </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/vfl-bochum/"> VfL Bochum </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/vfl-wolfsburg/"> VfL Wolfsburg </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/werder-bremen/"> Werder Bremen </a>
															</li>
														</ul>
													</div>
												</div>
											</div>
											<div id="seriea" class="tab" style="display: none;">
												<div class="col_4">
													<div style="float:left; width: 80px;">
														<ul class="nobox">
															<li>
																<a href="/football/serie-a/">Home</a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="http://www.sportskeeda.com/Sports/ac-milan/"> AC Milan </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/as-roma/"> AS Roma </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/atalanta/"> Atalanta </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/bari/"> Bari </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/cagliari/"> Cagliari </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/catania/"> Catania </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/chievo-verona/"> Chievo Verona </a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;" class="col_1">
														<ul class="nobox">
															<li>
																<a href="http://www.sportskeeda.com/Sports/fiorentina/"> Fiorentina </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/genoa/"> Genoa </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/inter-milan/"> Inter Milan </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/juventus/"> Juventus </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/lazio/"> Lazio </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/livorno/"> Livorno </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/lecce/"> Lecce </a>
															</li>
														</ul>
													</div>

													<div style="border-left:1px solid #B2B0B0;padding-left: 10px;height:204px" class="col_1">
														<ul class="nobox">

															<li>
																<a href="http://www.sportskeeda.com/Sports/napoli/"> Napoli </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/palermo/"> Palermo </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/parma/"> Parma </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/reggina/"> Reggina </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/Sports/torino/"> Torino </a>
															</li>
														</ul>
													</div>
												</div>
											</div>

										</div>
									</div>
								</div>
							</li>
							<!--cricket-->
							<li class="menulink">
								<a class="drop" id="cricket" href="http://www.sportskeeda.com/cricket/">Cricket</a>
								<div class="dropdown_3columns">
									<div class="col_2">

										<div class="tabs">
											<div id="crickethome" class="tab" style="display: none;">
												<div class="col_3">
													<div style="float:left; width: 80px;">
														<ul class="nobox">
															<li>
																<a href="/cricket/">Home</a>
															</li>
															<li>
																<a href="/cricket/featured/">Featured</a>
															</li>
															<li>
																<a href="/cricket/news/">News</a>
															</li>
															<li>
																<a href="/cricket/humor/">Humor</a>
															</li>
															<li>
																<a href="/cricket/interviews/">Interviews</a>
															</li>

															<li>
																<a href="/cricket/videos/">Videos</a>
															</li>
															<li>
																<a href="/Sport/one-day-cricket/">ODI</a>
															</li>
															<li>
																<a href="/Sport/cricket-test/">Test</a>
															</li>
															<li>
																<a href="/Sport/t20-cricket/">T20</a>
															</li>
															<li>
																<a href="/Sport/ranji-trophy-cricket/">Ranji Trophy</a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 20px;" class="col_1">

														<ul style="width:200px" class="nobox">
															<li>
																<a href="/cricket/ipl/">IPL Home</a>
															</li>
															<li>
																<a href="/ipl-schedules/">IPL Schedule</a>
															</li>
															<li>
																<a href="/cricket/ipl/chennai-super-kings/">Chennai Super Kings</a>
															</li>
															<li>
																<a href="/cricket/ipl/mumbai-indians/">Mumbai Indians</a>
															</li>
															<li>
																<a href="/cricket/ipl/kolkata-knight-riders/">Kolkata Night Riders</a>
															</li>
															<li>
																<a href="/cricket/ipl/delhi-daredevils/">Delhi Daredevils</a>
															</li>
															<li>
																<a href="/cricket/ipl/pune-warriors-india">Pune Warriors</a>
															</li>
															<li>
																<a href="/cricket/ipl/rajasthan-royals/">Rajastan Royals</a>
															</li>
															<li>
																<a href="/cricket/ipl/kings-xi-punjab/">Kings XI Punjab</a>
															</li>
															<li>
																<a href="/cricket/ipl/deccan-chargers/">Deccan Chargers</a>
															</li>
															<li>
																<a href="/cricket/ipl/royal-challengers-bangalore/">Royal Challengers Bangalore</a>
															</li>
														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 20px;height:338px" class="col_1">

														<ul style="width:200px" class="nobox">
															<div style="color:red;font-size: 11px;" class="sublinehead">
																Forum
															</div>
															<div style="clear: both;height: 1px;border-top: 1px solid #B2B0B0;width:40px;" class="seperator"></div>
															<li>
																<a href="http://forum.sportskeeda.com/categories/cricket">Cricket Forum</a>
															</li>
														</ul>
													</div>

												</div>
											</div>

											<div id="ipl" class="tab" style="display: none;">
												<div class="col_2">
													<div style="float:left; width: 130px;">
														<ul class="nobox">
															<li>
																<a href="/cricket/ipl/">IPL Home</a>
															</li>
															<li>
																<a href="/ipl-schedules/">IPL Schedule</a>
															</li>
															<li>
																<a href="/cricket/ipl/chennai-super-kings/">Chennai Super Kings</a>
															</li>
															<li>
																<a href="/cricket/ipl/mumbai-indians/">Mumbai Indians</a>
															</li>
															<li>
																<a href="/cricket/ipl/kolkata-knight-riders/">Kolkata Night Riders</a>
															</li>
															<li>
																<a href="/cricket/ipl/delhi-daredevils/">Delhi Daredevils</a>
															</li>
														</ul>
													</div>

													<div class="col_1">
														<ul class="nobox">
															<li>
																<a href="/cricket/ipl/pune-warriors-india/">Pune Warriors</a>
															</li>
															<li>
																<a href="/cricket/ipl/rajasthan-royals/">Rajastan Royals</a>
															</li>
															<li>
																<a href="/cricket/ipl/kings-xi-punjab/">Kings XI Punjab</a>
															</li>
															<li>
																<a href="/cricket/ipl/deccan-chargers/">Deccan Chargers</a>
															</li>
															<li>
																<a href="/cricket/ipl/royal-challengers-bangalore/">Royal Challengers Bangalore</a>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li class="menulink">
								<a class="drop" href="http://www.sportskeeda.com/tennis/">Tennis</a>
								<div class="dropdown_1column">

									<div class="col_1">
										<ul class="nobox">
											<li>
												<a href="http://www.sportskeeda.com/tennis/">Tennis Home</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/tennis/featured/">Featured</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/tennis/news/">News</a>
											</li>

											<li>
												<a href="http://www.sportskeeda.com/tennis/interviews/">Interviews</a>
											</li>
											<li>
												<a href="http://forum.sportskeeda.com/categories/tennis/">Forum</a>
											</li>

											<li>
												<a href="http://www.sportskeeda.com/author/musababid/">Musab's Column</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/author/haresh/">Haresh's Column</a>
											</li>
										</ul>

									</div>

								</div>

							</li>

							<li class="menulink">
								<a class="drop" href="http://www.sportskeeda.com/london-olympics-2012/">London 2012</a>
								<div class="dropdown_1column">

									<div class="col_1">
										<ul class="nobox">
											<li>
												<a href="http://www.sportskeeda.com/london-olympics-2012/">Olympics Home</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/olympics/">Featured</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/olympics/news/">News</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/olympics/interviews/">Interviews</a>
											</li>
											<li>
												<a href="http://forum.sportskeeda.com/categories/olympics/">Forum</a>
											</li>
										</ul>

									</div>

								</div>

							</li>

							<li class="menulink">
								<a class="drop" href="http://www.sportskeeda.com/basketball/">Basketball</a>
								<div class="dropdown_1column">

									<div class="col_1">
										<ul class="nobox">
											<li>
												<a href="http://www.sportskeeda.com/basketball/indian-basketball/">India</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/basketball/nba/">NBA</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/basketball/comics/">Comics</a>
											</li>
											<li>
												<a href="http://forum.sportskeeda.com/categories/basketball/">Forum</a>
											</li>
										</ul>

									</div>

								</div>

							</li>

							<li class="menulink">
								<a class="drop" href="http://www.sportskeeda.com/hockey/">Hockey</a>
								<div class="dropdown_1column">

									<div class="col_1">
										<ul class="nobox">
											<li>
												<a href="http://www.sportskeeda.com/hockey/">Hockey Home</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/hockey/world-series-hockey/">WSH</a>
											</li>
											<li>
												<a href="http://forum.sportskeeda.com/categories/hockey/">Forum</a>
											</li>
											<!--                    <li><a href="http://www.sportskeeda.com/predictor-game/" >WSH Predictor</a></li>-->
										</ul>

									</div>

								</div>

							</li>

							<li class="menulink">
								<a class="drop" href="http://www.sportskeeda.com/f1/">F1</a>
								<div class="dropdown_1column">

									<div class="col_1">
										<ul class="nobox">
											<li>
												<a href="http://www.sportskeeda.com/f1/">F1 Home</a>
											</li>
											<li>
												<a href="http://forum.sportskeeda.com/categories/f1/">Forum</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/f1/quiz/">Quiz</a>
											</li>
											<!--                    <li><a href="http://www.sportskeeda.com/f1-predictor-game/">Predictor</a></li>-->
										</ul>

									</div>

								</div>
							</li>

							<li class="menulink">
								<a class="drop" href="http://www.sportskeeda.com/badminton/">Badminton</a>
								<div class="dropdown_1column">

									<div class="col_1">
										<ul class="nobox">
											<li>
												<a href="http://forum.sportskeeda.com/categories/badminton/">Forum</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/badminton/interviews/">Interviews</a>
											</li>
										</ul>

									</div>

								</div>
							</li>

							<li class="menulink">
								<a class="drop" href="#">Sections</a>
								<div class="dropdown_1column">

									<div class="col_1">
										<ul class="nobox">
											<li>
												<a href="http://www.sportskeeda.com/section/fb-wall/">FB Wall</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/section/humor/">Humor</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/section/comic/">Comics</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/section/quiz/">Quiz</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/section/video/">Video</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/section/featured/">Featured</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/section/interviews/">Interviews</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/section/Business/">Business</a>
											</li>
											<li>
												<a href="http://www.sportskeeda.com/section/local/">Local</a>
											</li>
										</ul>

									</div>
								</div>
							</li>
							<li class="menu_right menulink">
								<a class="drop" id="more" href="http://www.sportskeeda.com/football/">More</a>
								<div class="dropdown_2columns align_right">
									<div class="col_3">
										<ul class="greybox">
											<li>
												<a href="#morehome">Home</a>
											</li>
											<li>
												<a href="#moreforums">Forums</a>
											</li>

										</ul>
										<div class="tabs">
											<div id="morehome" class="tab" style="display: none;">
												<div class="col_3">
													<div style="padding-left:10px;width:110px" class="col_1">
														<ul class="nobox">
															<li>
																<a href="http://www.sportskeeda.com/archery/"> Archery </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/athletics/"> Athletics </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/baseball/"> Baseball </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/boxing/"> Boxing </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/chess/"> Chess </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/cue-sports/"> cue </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/cycling/"> Cycling </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/golf/"> Golf </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/handball/"> Handball </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/kabaddi/"> Kabaddi </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/mixed-martial-arts-mma/"> MMA </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/motorsports/"> Motorsports </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/motocross/"> MotoCross </a>
															</li>

														</ul>
													</div>
													<div style="border-left:1px solid #B2B0B0;padding-left: 20px;width:110px" class="col_1">
														<ul class="nobox">

															<li>
																<a href="http://www.sportskeeda.com/national-football-league-nfl/"> NFL </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/polo/"> Polo </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/rugby/"> Rugby </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/running/"> Running </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/shooting/">Shooting</a>
															</li><a href="http://www.sportskeeda.com/shooting/"> </a>
															<li>
																<a href="http://www.sportskeeda.com/shooting/"></a><a href="http://www.sportskeeda.com/skating/"> Skating </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/squash/"> Squash </a>
															</li>

															<li>
																<a href="http://www.sportskeeda.com/swimming/"> Swimming </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/table-tennis/"> TT </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/volleyball/"> Volleyball </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/winter-sports/"> Winter Sports </a>
															</li>
															<li>
																<a href="http://www.sportskeeda.com/wrestling/"> Wrestling </a>
															</li>
														</ul>
													</div>

													<!--                            <div class="col_1">
													<ul class="nobox">
													<li><a href="/afc-cup-predictor-game/" >AFC Predictor</a></li>
													</ul>
													</div>-->
												</div>
											</div>
											<div id="moreforums" class="tab" style="display: none;">
												<div class="col_4">
													<div style="float:left; width: 110px;padding-left: 30px">
														<ul class="nobox">
															<li>
																<a href="http://forum.sportskeeda.com/categories/athletics/">Athletics </a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/motorsports/">Motorsports </a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/golf/">Golf </a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/swimming/">Swimming</a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/wwe/">WWE </a>
															</li>
														</ul>
													</div>
													<div style="width:200px" class="col_1">
														<ul style="border-left:1px solid #B2B0B0;padding-left: 40px;" class="nobox">

															<li>
																<a href="http://forum.sportskeeda.com/categories/cycling/">Cycling</a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/chess/">Chess</a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/volleyball/">Volleyball </a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/boxing/">Boxing</a>
															</li>
															<li>
																<a href="http://forum.sportskeeda.com/categories/cue/">Cue</a>
															</li>

														</ul>
													</div>

												</div>
											</div>

										</div>
									</div>
								</div>
							</li>
						</ul>
						<script type="text/javascript">jQuery(".menulink").hover(function(){stringref=jQuery(this).children("a:first").attr("id")+'home';parentref=jQuery(this).closest('ul').attr("id");if(parentref=="menu"){jQuery('.tab:not(#'+stringref+')').hide();jQuery('.tab#'+stringref).show();}
return false;});jQuery("#menu a").mouseover(function(){stringref=jQuery(this).attr("id")+'home';parentref=jQuery(this).closest('ul').attr("id");if(parentref=="menu"){jQuery('.tab:not(#'+stringref+')').hide();jQuery('.tab#'+stringref).show();}
return false;});jQuery(".tab:not(:first)").hide();jQuery(".tab:first").show();jQuery(".greybox a").click(function(){stringref=jQuery(this).attr("href").split('#')[1];jQuery('.tab:not(#'+stringref+')').hide();if(jQuery.browser.msie&&jQuery.browser.version.substr(0,3)=="6.0"){jQuery('.tab#'+stringref).show();}
else
jQuery('.tab#'+stringref).fadeIn();return false;});</script>
					</div>
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
								<a href="#"><?php echo ($chat->chatinfo['name'])
								?></a>
							</li>
						</ul>
						<h2><?php echo ($chat->chatinfo['name'])
						?></h2>
						<hr/>
						<div class="well" id="chat_window">
							<ul class="window"></ul>
						</div>
						<div class="clearfix"></div>
						
						<?php
						if (($chatuser['admin'] or $chatuser['superadmin']) and $chat->chatinfo['live']) {
						?>
						<div class="well" id="comm_window">
							<div style="width: 50%; clear: none; display: inline; float: left;">
							<form enctype="multipart/form-data" id="submit_chat" class="form-inline">
								<label for="chat_text">Text</label><br/>
								<textarea name="chat_text" id="chat_text" class="span3"></textarea>
								<button class="btn btn-success" type="submit">
									Send
								</button>
								<br>
								<label for="img_source">Image Source</label>
								<br>
								<select name="img_source" id="img_source">
									<option value="NA">None</option>
									<option value="upload">Upload</option>
									<option value="twitpic">Twitpic</option>
									<option value="yfrog">YFrog</option>
								</select>
								<br>
								<label for="img_code">Image Code</label>
								<br>
								<input type="text" name="img_code" id="img_code">
								<a href="#imgupload_div" id="upload_button" class="btn">Upload</a>
								<br>
								<label for="vid_source">Video Source</label>
								<br>
								<select name="vid_source" id="vid_source">
									<option value="NA">None</option>
									<option value="youtube">Youtube</option>
								</select>
								<br>
								<label for="vid_code">Video Code</label>
								<br>
								<input type="text" name="vid_code" id="vid_code">
							</form>
							</div>
							<script language="javascript">

									$('#submit_chat').submit(function(e) {
										e.preventDefault();
										var postdata = $('#submit_chat').serialize();
										$.ajax({
											url: '/chataction/<?php echo($chat->chatinfo['slug']) ?>/sendchat',
											dataType: 'json',
											type: 'POST',
											data: postdata,
											success: function(data) {
												var msg = data;
												if (msg.success) {
													noty({"text":msg.msg,"layout":"topRight","type":"success","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
													$('#submit_chat').each (function(){
  														this.reset();
													});
												} else {			
													noty({"text": msg.msg,"layout":"topRight","type":"error","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
												}
											}
										})
									});

							</script>
							<?php
							if ($chat->chatinfo['score']) {
							?>
							<div style="width: 50%; clear: none; display: inline; float: right;">
								<form id="submit_score" class="form-inline">
									<label for="score_text">Score</label>
									<br>
									<input type="text" name="score_text" id="score_text" class="span3">
									<button class="btn btn-success" type="submit">
									Send
									</button>
								</form>
							</div>
							<script language="javascript">

									$('#submit_score').submit(function(e) {
										e.preventDefault();
										var postdata = $('#submit_score').serialize();
										$.ajax({
											url: '/chataction/<?php echo($chat->chatinfo['slug']) ?>/sendscore',
											dataType: 'json',
											type: 'POST',
											data: postdata,
											success: function(data) {
												var msg = data;
												if (msg.success) {
													noty({"text":msg.msg,"layout":"topRight","type":"success","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
													$('#submit_chat').each (function(){
  														this.reset();
													});
												} else {			
													noty({"text": msg.msg,"layout":"topRight","type":"error","textAlign":"center","easing":"swing","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":"500","timeout":"5000","closable":true,"closeOnSelfClick":true});
												}
											}
										})
									});
									
							</script>
							<?php
							}
							?>
							<div class="clearfix"></div>
						</div>
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
						<hr/>
						
						<?php
						if ($chatuser['creator'] or $chatuser['superadmin']) {
						?>
						<button id="finish_chat">
							Finish Chat
						</button>
						<hr/>
						<?php
						}
						?>
						<?php
						 if ($chatuser['admin'] or $chatuser['superadmin']) {
						?>
						<p align="center">
							<span id="online_contacts" class="label label-success"></span>
						</p>
						<div class="well" id="contacts_window">
							<ul class="window"></ul>
						</div>
						<div class="clearfix"></div>
						<div class="well" id="approve_window">
							<ul class="window"></ul>
						</div>
						<script language="JavaScript">
						$(function() {
							channel.bind('pusher:subscription_succeeded', function(members) {
								var onlinetext = members.count + ' user(s) online';
								$('#online_contacts').append(onlinetext);
								members.each(function(member) {
									$('#contacts_window ul.window').append('<li class="well"><b>'+member.info.username+'</b><br/>'+member.info.role+'</li>');
								});
							});
							channel.bind('pusher:member_added', function(member) {
								$('#contacts_window ul.window').append('<li class="well"><b>'+member.info.username+'</b><br/>'+member.info.role+'</li>');
							});
						});	
						</script>
						<?php
						 }
						?>
						
					</div>
				</div>
				<!-- Sidebar End -->
				<div class="clear"></div>
			</div>
			<!-- Body End -->
			<!-- Footer Begin -->
			<div class="row">
				<div class="span12">
					<div id="foot_contain" style="width: 960px;">
						<div id="footer-wrapper">
							<div class="top">
								&nbsp;
							</div>
							<div id="footer">
								<div class="inner">
									<div class="left">
										<div class="widget">
											<h2 class="gentesque">Sportskeeda Writers</h2>
											<div class="line">
												&nbsp;
											</div>
											<div class="textwidget">
												<div id="writer_selection">
													<input type="radio" checked="checked" value="all_writers" name="writers">
													All
													<input type="radio" value="featured_writers" name="writers">
													Featured Writers
													<input type="radio" value="featured_columnists" name="writers">
													Columnists
												</div>
												<div style="display:none;" id="featured_columnists" class="authors_list">
													<select name="authors_list" class="author_dropdown">
														<option value="0">Select Writer</option><option value="http://www.sportskeeda.com/author/arunava-chaudhuri-2">Arunava Chaudhuri</option><option value="http://www.sportskeeda.com/author/ayaz-memon">Ayaz Memon</option><option value="http://www.sportskeeda.com/author/chuck_gopal">Chuck</option><option value="http://www.sportskeeda.com/author/cyrus-poncha">Cyrus Poncha</option><option value="http://www.sportskeeda.com/author/dev-sukumar-2-2-2">Dev Sukumar</option><option value="http://www.sportskeeda.com/author/faking-news">Faking News</option><option value="http://www.sportskeeda.com/author/footballwallah">FootballWallah</option><option value="http://www.sportskeeda.com/author/hoopistani">Hoopistani</option><option value="http://www.sportskeeda.com/author/mario">Mario Rodrigues</option><option value="http://www.sportskeeda.com/author/musababid">Musab Abid</option>
													</select>
												</div>
												<div style="display:none;" id="featured_writers" class="authors_list">
													<select name="authors_list" class="author_dropdown">
														<option value="0">Select Writer</option><option value="http://www.sportskeeda.com/author/abhinav-c-j">Abhinav C.J.</option><option value="http://www.sportskeeda.com/author/abhinav14">abhinav14</option><option value="http://www.sportskeeda.com/author/nickspinkboots">Abhishek Iyer</option><option value="http://www.sportskeeda.com/author/adityaramani">Aditya Ramani</option><option value="http://www.sportskeeda.com/author/amiller91">AMiller91</option><option value="http://www.sportskeeda.com/author/amod-d-kulkarni-2-2">Amod D Kulkarni</option><option value="http://www.sportskeeda.com/author/arnie288">Arnie Fo Art</option><option value="http://www.sportskeeda.com/author/ashishxs">Ashish Sharma</option><option value="http://www.sportskeeda.com/author/aswinsam">aswinsam</option><option value="http://www.sportskeeda.com/author/tracerbullet007">Benny</option><option value="http://www.sportskeeda.com/author/bonbonkayzee">bonbonkayzee</option><option value="http://www.sportskeeda.com/author/chris">Chris Punnakkattu Daniel</option><option value="http://www.sportskeeda.com/author/debjitl">Debjit Lahiri</option><option value="http://www.sportskeeda.com/author/shounak2501">drBaltar25</option><option value="http://www.sportskeeda.com/author/fergieshairdryer">Fergie's Hairdryer</option><option value="http://www.sportskeeda.com/author/forrest-hamilton">forrest.hamilton</option><option value="http://www.sportskeeda.com/author/gabbbarsingh">gabbbarsingh</option><option value="http://www.sportskeeda.com/author/gaurav-parab">Gaurav Parab</option><option value="http://www.sportskeeda.com/author/gokulraghunadh">Gokul Raghunadh</option><option value="http://www.sportskeeda.com/author/hardikvyas">Hardik Vyas</option><option value="http://www.sportskeeda.com/author/haresh">Haresh Ramchandani</option><option value="http://www.sportskeeda.com/author/ht711">Hrishikesh Tiwari</option><option value="http://www.sportskeeda.com/author/jaideep18">jaideep18</option><option value="http://www.sportskeeda.com/author/kritika">Kritika</option><option value="http://www.sportskeeda.com/author/theblcksheep">Leela Prasad</option><option value="http://www.sportskeeda.com/author/f1_rocks">Mayank Grover</option><option value="http://www.sportskeeda.com/author/menperei">Menino</option><option value="http://www.sportskeeda.com/author/naren-shenoy">Naren Shenoy</option><option value="http://www.sportskeeda.com/author/nayyarasheed">Nayyar Abdul Rasheed</option><option value="http://www.sportskeeda.com/author/persiesque">persiesque</option><option value="http://www.sportskeeda.com/author/prthvir-solanki-2-2-2-2-2-2-2-2-2-2-2">Prthvir Solanki</option><option value="http://www.sportskeeda.com/author/rahulsaraf">Rahul Saraf</option><option value="http://www.sportskeeda.com/author/rgarimella">Raman Garimella</option><option value="http://www.sportskeeda.com/author/rishabhthomas">rishabhthomas</option><option value="http://www.sportskeeda.com/author/ritesh">Ritesh</option><option value="http://www.sportskeeda.com/author/rohini-iyer">Roh</option><option value="http://www.sportskeeda.com/author/rohitgore">rohitgore</option><option value="http://www.sportskeeda.com/author/s-t-arasu">S T Arasu</option><option value="http://www.sportskeeda.com/author/sahilriz">Sahil Rizwan</option><option value="http://www.sportskeeda.com/author/sakthikrishna">sakthikrishna</option><option value="http://www.sportskeeda.com/author/sambhavkhetarpal">Sambhav Khetarpal</option><option value="http://www.sportskeeda.com/author/sarcasan">sarcasan</option><option value="http://www.sportskeeda.com/author/saurya">Saurya Sengupta</option><option value="http://www.sportskeeda.com/author/shubi1994">shubi1994</option><option value="http://www.sportskeeda.com/author/sidbreakball">sidbreakball</option><option value="http://www.sportskeeda.com/author/siddharthk14">siddharthk14</option><option value="http://www.sportskeeda.com/author/siddhesh">Siddhesh Agashe</option><option value="http://www.sportskeeda.com/author/sivaramparameswaran">Sivaram Parameswaran</option><option value="http://www.sportskeeda.com/author/slightlyonside">slightlyonside</option><option value="http://www.sportskeeda.com/author/soumik">Soumik</option><option value="http://www.sportskeeda.com/author/swarnadeep-chatterjee-2-2-2">Swarnadeep Chatterjee</option><option value="http://www.sportskeeda.com/author/justdoesit">Thunderdog</option><option value="http://www.sportskeeda.com/author/vaietc">Vaibhav Shankar</option><option value="http://www.sportskeeda.com/author/vandiablo">vandiablo</option><option value="http://www.sportskeeda.com/author/varunshetty2893">Varun Shetty</option><option value="http://www.sportskeeda.com/author/venugopal-r-2-2">Venu</option><option value="http://www.sportskeeda.com/author/blasphelod">Vishaal Loganathan</option><option value="http://www.sportskeeda.com/author/wtfootball7">WTFootball</option><option value="http://www.sportskeeda.com/author/amrith10">Yechh</option><option value="http://www.sportskeeda.com/author/zeddy">Zeddy</option><option value="http://www.sportskeeda.com/author/zulutorres1369">Zulu</option>
													</select>
												</div>
												<div id="all_writers" class="authors_list">
													<select title="Featured" name="authors_list" class="author_dropdown">
														<option value="0">Select Writer</option><option value="http://www.sportskeeda.com/author/23carragold">23carragold</option><option value="http://www.sportskeeda.com/author/2479roxx">2479roxx</option><option value="http://www.sportskeeda.com/author/a-lalgunner">A.lalgunner</option><option value="http://www.sportskeeda.com/author/aaditya-patil">Aaditya Patil</option><option value="http://www.sportskeeda.com/author/aakash">aakash</option><option value="http://www.sportskeeda.com/author/aakash-jacob">aakash.jacob</option><option value="http://www.sportskeeda.com/author/abbas">Abbas</option><option value="http://www.sportskeeda.com/author/makkerony">Abdul K</option><option value="http://www.sportskeeda.com/author/abdulrazik">Abdul Razik</option><option value="http://www.sportskeeda.com/author/abhay">Abhay Patade</option><option value="http://www.sportskeeda.com/author/abhijeetsb">Abhijeet</option><option value="http://www.sportskeeda.com/author/abhijit">Abhijit P</option><option value="http://www.sportskeeda.com/author/abhilashk">abhilash kusam</option><option value="http://www.sportskeeda.com/author/abhimanyu-lahiri">Abhimanyu Lahiri</option><option value="http://www.sportskeeda.com/author/abhimanyunagpal">abhimanyunagpal</option><option value="http://www.sportskeeda.com/author/arion">Abhinav</option><option value="http://www.sportskeeda.com/author/abhinav-c-j">Abhinav C.J.</option><option value="http://www.sportskeeda.com/author/rodeoz">Abhinav Dixit</option><option value="http://www.sportskeeda.com/author/abhinav08">abhinav08</option><option value="http://www.sportskeeda.com/author/abhinav14">abhinav14</option><option value="http://www.sportskeeda.com/author/abhinavkhanka">abhinavkhanka</option><option value="http://www.sportskeeda.com/author/abhinavm">AbhinavM</option><option value="http://www.sportskeeda.com/author/abhineetbhutra">abhineetbhutra</option><option value="http://www.sportskeeda.com/author/abhishek-mukherjee">Abhishek</option><option value="http://www.sportskeeda.com/author/Abhishek.Dahiwale">Abhishek Dahiwale</option><option value="http://www.sportskeeda.com/author/adeobhak">Abhishek Deobhakta</option><option value="http://www.sportskeeda.com/author/nickspinkboots">Abhishek Iyer</option><option value="http://www.sportskeeda.com/author/abhishek-pati">Abhishek Pati</option><option value="http://www.sportskeeda.com/author/abzreddevil">Abhishek Reghunath</option><option value="http://www.sportskeeda.com/author/abhishek_mehta">abhishek_mehta</option><option value="http://www.sportskeeda.com/author/abhivialli">abhivialli</option><option value="http://www.sportskeeda.com/author/abid-gowhar">Abid Gowhar</option><option value="http://www.sportskeeda.com/author/abinavkris">abinavkris</option><option value="http://www.sportskeeda.com/author/achalkb">Achal</option><option value="http://www.sportskeeda.com/author/acham">acham</option><option value="http://www.sportskeeda.com/author/adam-araujo">Adam Araujo</option><option value="http://www.sportskeeda.com/author/adam1995607">adam1995607</option><option value="http://www.sportskeeda.com/author/adarsh">Adarsh</option><option value="http://www.sportskeeda.com/author/adarshvinay">adarshvinay</option><option value="http://www.sportskeeda.com/author/adi11yadav">Adhiraj</option><option value="http://www.sportskeeda.com/author/adithyamanjunath">Adi</option><option value="http://www.sportskeeda.com/author/arjpvc">Adithya Ramesh</option><option value="http://www.sportskeeda.com/author/aditi">Aditi</option><option value="http://www.sportskeeda.com/author/adi1989alok">Aditya Alok</option><option value="http://www.sportskeeda.com/author/cricbrain">Aditya Ambekar</option><option value="http://www.sportskeeda.com/author/adityabhari">Aditya Bharadwaj</option><option value="http://www.sportskeeda.com/author/advitiya2000">Aditya Goel</option><option value="http://www.sportskeeda.com/author/adityareddevil">Aditya Pradeep</option><option value="http://www.sportskeeda.com/author/adityaramani">Aditya Ramani</option><option value="http://www.sportskeeda.com/author/aditya-sheth">Aditya Sheth</option><option value="http://www.sportskeeda.com/author/aditya14">aditya14</option><option value="http://www.sportskeeda.com/author/aditya19">aditya19</option><option value="http://www.sportskeeda.com/author/adityamohan">adityamohan</option><option value="http://www.sportskeeda.com/author/adnan">Adnan</option><option value="http://www.sportskeeda.com/author/aeroberg">aeroberg</option><option value="http://www.sportskeeda.com/author/afp">AFP</option><option value="http://www.sportskeeda.com/author/aiffmedia">AIFF Media</option><option value="http://www.sportskeeda.com/author/air13wind">Air13wind</option><option value="http://www.sportskeeda.com/author/ajay007">Ajay</option><option value="http://www.sportskeeda.com/author/ajjaybaliga243">Ajay</option><option value="http://www.sportskeeda.com/author/ajaynair80">Ajay Nair</option><option value="http://www.sportskeeda.com/author/ajitsharma">ajitsharma</option><option value="http://www.sportskeeda.com/author/ajothomas">ajo thomas</option><option value="http://www.sportskeeda.com/author/akanksha-singh">akanksha singh</option><option value="http://www.sportskeeda.com/author/akkirocks8">akash nayyar</option><option value="http://www.sportskeeda.com/author/akhil48294">Akhil</option><option value="http://www.sportskeeda.com/author/akhil">Akhil Nair</option><option value="http://www.sportskeeda.com/author/akhlaqhanif">AkhlaqHanif</option><option value="http://www.sportskeeda.com/author/akil">akil</option><option value="http://www.sportskeeda.com/author/akshat">Akshat</option><option value="http://www.sportskeeda.com/author/akshay123">akshay - cricket analyst</option><option value="http://www.sportskeeda.com/author/jyotishiakshay">Akshay Jyotishi</option><option value="http://www.sportskeeda.com/author/maddy">Akshay Madhavan</option><option value="http://www.sportskeeda.com/author/akshayrossonero">akshayrossonero</option><option value="http://www.sportskeeda.com/author/akshit02">akshit02</option><option value="http://www.sportskeeda.com/author/alencena">alencena</option><option value="http://www.sportskeeda.com/author/alex_prabu">Alex Prabaharan</option><option value="http://www.sportskeeda.com/author/alexisgod">alexisgod</option><option value="http://www.sportskeeda.com/author/thealternativealmanack">Alternative Cricket</option><option value="http://www.sportskeeda.com/author/alternative-cricket-cricket-for-grown-ups">Alternative Cricket...cricket for grown-ups</option><option value="http://www.sportskeeda.com/author/altmate">altmate</option><option value="http://www.sportskeeda.com/author/alwaysagunner">alwaysagunner</option><option value="http://www.sportskeeda.com/author/aman">aman</option><option value="http://www.sportskeeda.com/author/afl007">Aman Francis Lakra</option><option value="http://www.sportskeeda.com/author/amankapoor150">Aman Kapoor</option><option value="http://www.sportskeeda.com/author/amarnathkalyan">amarnathkalyan</option><option value="http://www.sportskeeda.com/author/ambujgupta">ambujgupta</option><option value="http://www.sportskeeda.com/author/ambuj_2k6">ambuj_indianred</option><option value="http://www.sportskeeda.com/author/amreen">Amerta</option><option value="http://www.sportskeeda.com/author/amiller91">AMiller91</option><option value="http://www.sportskeeda.com/author/amod-d-kulkarni-2-2">Amod D Kulkarni</option><option value="http://www.sportskeeda.com/author/amogh">amogh</option><option value="http://www.sportskeeda.com/author/amrittina">Amrit Patnaik</option><option value="http://www.sportskeeda.com/author/dabraju">Anand Datla</option><option value="http://www.sportskeeda.com/author/anandsridhar">anandsridhar</option><option value="http://www.sportskeeda.com/author/ananthasubramanian">Ananthasubramanian</option><option value="http://www.sportskeeda.com/author/andrea-thumshirn">Andrea Thumshirn</option><option value="http://www.sportskeeda.com/author/aneekbiswas">aneekbiswas</option><option value="http://www.sportskeeda.com/author/aneesh-gupta">aneesh gupta</option><option value="http://www.sportskeeda.com/author/angadlamba">angadlamba</option><option value="http://www.sportskeeda.com/author/anilsenghera">Anil Senghera</option><option value="http://www.sportskeeda.com/author/anil-tadimeti">Anil Tadimeti</option><option value="http://www.sportskeeda.com/author/supernova">Aniruddha Parlikar</option><option value="http://www.sportskeeda.com/author/anirudhmadhavan">anirudhmadhavan</option><option value="http://www.sportskeeda.com/author/anishnambisan">anishnambisan</option><option value="http://www.sportskeeda.com/author/anjali">Anjali</option><option value="http://www.sportskeeda.com/author/ankanb12">ankanb12</option><option value="http://www.sportskeeda.com/author/gargankit27">Ankit</option><option value="http://www.sportskeeda.com/author/ankantsid">Ankit Srivastava</option><option value="http://www.sportskeeda.com/author/ankitjain">ankitjain</option><option value="http://www.sportskeeda.com/author/ankulshilotri">ankulshilotri</option><option value="http://www.sportskeeda.com/author/anmolkumaar">Anmol Kumaar</option><option value="http://www.sportskeeda.com/author/another-prick-in-the-wall">Another Prick In The Wall</option><option value="http://www.sportskeeda.com/author/anotherprickinthewall">anotherprickinthewall</option><option value="http://www.sportskeeda.com/author/anhul-tanwar-2">ansh</option><option value="http://www.sportskeeda.com/author/for-the-stick">Ansh Bharadwaj</option><option value="http://www.sportskeeda.com/author/anshuprasad">Anshu Prasad</option><option value="http://www.sportskeeda.com/author/tiktok16">Anubhav</option><option value="http://www.sportskeeda.com/author/anubhavrao">anubhavrao</option><option value="http://www.sportskeeda.com/author/anujnagpal90">ANUJ NAGPAL</option><option value="http://www.sportskeeda.com/author/anupamdhoot">anupamdhoot</option><option value="http://www.sportskeeda.com/author/apaar-sinha">Apaar Sinha</option><option value="http://www.sportskeeda.com/author/Aparna Rajkumar">Aparna</option><option value="http://www.sportskeeda.com/author/apekshaha">Apeksha HA</option><option value="http://www.sportskeeda.com/author/apoorvsinghal">apoorvsinghal</option><option value="http://www.sportskeeda.com/author/apoorvt89">apoorvt89</option><option value="http://www.sportskeeda.com/author/redmanc">Apratim Mukherjee</option><option value="http://www.sportskeeda.com/author/archie">Archie Rhind-Tutt</option><option value="http://www.sportskeeda.com/author/archilis">archilis</option><option value="http://www.sportskeeda.com/author/arjunmalhotra10">Arjun Malhotra</option><option value="http://www.sportskeeda.com/author/arjunited1878">Arjun Srivatsa</option><option value="http://www.sportskeeda.com/author/arjun19">Arjun19</option><option value="http://www.sportskeeda.com/author/arjunbianconeri">arjunbianconeri</option><option value="http://www.sportskeeda.com/author/arnab">Arnab</option><option value="http://www.sportskeeda.com/author/arnie288">Arnie Fo Art</option><option value="http://www.sportskeeda.com/author/arpit">arpit</option><option value="http://www.sportskeeda.com/author/arpit-kumar11">arpit.kumar11</option><option value="http://www.sportskeeda.com/author/arsenik">ArseNik</option><option value="http://www.sportskeeda.com/author/arunava-chaudhuri-2">Arunava Chaudhuri</option><option value="http://www.sportskeeda.com/author/arunshankar">arunshankar</option><option value="http://www.sportskeeda.com/author/aryachakrabarty">aryachakrabarty</option><option value="http://www.sportskeeda.com/author/ashik">ashik</option><option value="http://www.sportskeeda.com/author/ashim-sunam">Ashim Sunam</option><option value="http://www.sportskeeda.com/author/ashindia">ashindia</option><option value="http://www.sportskeeda.com/author/manc19">Ashish</option><option value="http://www.sportskeeda.com/author/gooner">Ashish Choudhary</option><option value="http://www.sportskeeda.com/author/ashish89">Ashish Koshy</option><option value="http://www.sportskeeda.com/author/ashishxs">Ashish Sharma</option><option value="http://www.sportskeeda.com/author/itsashok89">Ashok</option><option value="http://www.sportskeeda.com/author/ashutoshjuve">Ashutosh</option><option value="http://www.sportskeeda.com/author/ashwath">Ashwath Sampath</option><option value="http://www.sportskeeda.com/author/ashwin">Ashwin</option><option value="http://www.sportskeeda.com/author/ashwin89">ashwin89</option><option value="http://www.sportskeeda.com/author/ashwinkrithik">ashwinkrithik</option><option value="http://www.sportskeeda.com/author/asnsuri">asnsuri</option><option value="http://www.sportskeeda.com/author/aswinsam">aswinsam</option><option value="http://www.sportskeeda.com/author/attheendoftheday">attheendoftheday</option><option value="http://www.sportskeeda.com/author/atulbucha">atulbucha</option><option value="http://www.sportskeeda.com/author/auro007">Aurobindo</option><option value="http://www.sportskeeda.com/author/austin">Austin</option><option value="http://www.sportskeeda.com/author/austinsanders14">AustinSanders14</option><option value="http://www.sportskeeda.com/author/avijit">avijit</option><option value="http://www.sportskeeda.com/author/avijit-das-patnaik">Avijit Das Patnaik</option><option value="http://www.sportskeeda.com/author/avik">avik</option><option value="http://www.sportskeeda.com/author/avirat">avirat</option><option value="http://www.sportskeeda.com/author/avisatpathy">avisatpathy</option><option value="http://www.sportskeeda.com/author/ayaz-memon">Ayaz Memon</option><option value="http://www.sportskeeda.com/author/ayman">Ayman</option><option value="http://www.sportskeeda.com/author/azman003">Azman Usmani</option><option value="http://www.sportskeeda.com/author/baardya">Baardya</option><option value="http://www.sportskeeda.com/author/babua-biswas-2-2-2-2">BABUA BISWAS</option><option value="http://www.sportskeeda.com/author/backofthenet">backofthenet</option><option value="http://www.sportskeeda.com/author/badbadiablo">badbadiablo</option><option value="http://www.sportskeeda.com/author/badmintonmania">badmintonmania</option><option value="http://www.sportskeeda.com/author/balask">bala@sk</option><option value="http://www.sportskeeda.com/author/balaji">Balaji Iyer</option><option value="http://www.sportskeeda.com/author/balaji_venkat">balaji_venkat</option><option value="http://www.sportskeeda.com/author/barnie">barnie</option><option value="http://www.sportskeeda.com/author/tracerbullet007">Benny</option><option value="http://www.sportskeeda.com/author/lfcbenson">Benson Sebastian</option><option value="http://www.sportskeeda.com/author/bfi">BFI</option><option value="http://www.sportskeeda.com/author/bharathrokr10">Bharath Reddy</option><option value="http://www.sportskeeda.com/author/bagrat">Bharathram</option><option value="http://www.sportskeeda.com/author/bhargav">bhargav</option><option value="http://www.sportskeeda.com/author/bibhu2109">Bibhu Prasad</option><option value="http://www.sportskeeda.com/author/thebigshow">bigshow.co.in</option><option value="http://www.sportskeeda.com/author/bluebananapie">bluebananapie</option><option value="http://www.sportskeeda.com/author/bonbonkayzee">bonbonkayzee</option><option value="http://www.sportskeeda.com/author/boredcricketcrazyindians">Boredcricketcrazyindians</option><option value="http://www.sportskeeda.com/author/borkarabhijeet05">borkarabhijeet05</option><option value="http://www.sportskeeda.com/author/bornoffside">BornoffSide</option><option value="http://www.sportskeeda.com/author/bridget-svabelj">Bridget Svabelj</option><option value="http://www.sportskeeda.com/author/brittanyschray">brittanyschray</option><option value="http://www.sportskeeda.com/author/burnerbean">burnerbean</option><option value="http://www.sportskeeda.com/author/spoilsport">Ceona Benjamin</option><option value="http://www.sportskeeda.com/author/cfcilldara">cfcilldara</option><option value="http://www.sportskeeda.com/author/chanakya41097">ChanakyaVarma97</option><option value="http://www.sportskeeda.com/author/chandra1986">Chandrasekhar Jayaramakrishnan</option><option value="http://www.sportskeeda.com/author/channa">Channa</option><option value="http://www.sportskeeda.com/author/chawla7687">chawla7687</option><option value="http://www.sportskeeda.com/author/chelseachiefs">ChelseaChiefs</option><option value="http://www.sportskeeda.com/author/chelseafanatic">chelseafanatic</option><option value="http://www.sportskeeda.com/author/chin512">chin512</option><option value="http://www.sportskeeda.com/author/pawanbharadwaj">Chinku</option><option value="http://www.sportskeeda.com/author/chinmay">Chinmay Maheshwari</option><option value="http://www.sportskeeda.com/author/chirag">chirag</option><option value="http://www.sportskeeda.com/author/subgiri">Chirag Subramanian</option><option value="http://www.sportskeeda.com/author/chris">Chris Punnakkattu Daniel</option><option value="http://www.sportskeeda.com/author/christopher">Christopher Poshin David</option><option value="http://www.sportskeeda.com/author/chuck_gopal">Chuck</option><option value="http://www.sportskeeda.com/author/clash">clash</option><option value="http://www.sportskeeda.com/author/coachshiv">CoachShiv</option><option value="http://www.sportskeeda.com/author/coffeedude9">coffeedude9</option><option value="http://www.sportskeeda.com/author/comicbookguy">comicbookguy</option><option value="http://www.sportskeeda.com/author/contact12345">contact12345</option><option value="http://www.sportskeeda.com/author/cool">Cool</option><option value="http://www.sportskeeda.com/author/cornerd">cornerd</option><option value="http://www.sportskeeda.com/author/craigoxide">Craig Mascarenhas</option><option value="http://www.sportskeeda.com/author/crawlinchoklet">crawlinchoklet</option><option value="http://www.sportskeeda.com/author/cricketalks">cricketalks</option><option value="http://www.sportskeeda.com/author/crickthik">crickthik</option><option value="http://www.sportskeeda.com/author/crownish">crownish</option><option value="http://www.sportskeeda.com/author/cyrus-poncha">Cyrus Poncha</option><option value="http://www.sportskeeda.com/author/daniel886">daniel886</option><option value="http://www.sportskeeda.com/author/danish">Danish Arif</option><option value="http://www.sportskeeda.com/author/darrblack">darrblack</option><option value="http://www.sportskeeda.com/author/darthsid">darthsid</option><option value="http://www.sportskeeda.com/author/dartora">dartora</option><option value="http://www.sportskeeda.com/author/dashhitesh">dashhitesh</option><option value="http://www.sportskeeda.com/author/daveemrys">dave</option><option value="http://www.sportskeeda.com/author/davegambler">dave gambler</option><option value="http://www.sportskeeda.com/author/davebutler">davebutler</option><option value="http://www.sportskeeda.com/author/david-mcfarlane">David McFarlane</option><option value="http://www.sportskeeda.com/author/debabrat">debabrat</option><option value="http://www.sportskeeda.com/author/debaman">debaman</option><option value="http://www.sportskeeda.com/author/debanjan-bose">Debanjan Bose</option><option value="http://www.sportskeeda.com/author/debanjanbanerjee">DebanjanBanerjee</option><option value="http://www.sportskeeda.com/author/debarghya">Debarghya Pal</option><option value="http://www.sportskeeda.com/author/debashish4u">Debashish Pradhan</option><option value="http://www.sportskeeda.com/author/debatabledecisions">DebatableDecisions</option><option value="http://www.sportskeeda.com/author/debjitl">Debjit Lahiri</option><option value="http://www.sportskeeda.com/author/debojit">Debojit</option><option value="http://www.sportskeeda.com/author/debojyoti">debojyoti</option><option value="http://www.sportskeeda.com/author/debojyotimanutd">Debojyoti</option><option value="http://www.sportskeeda.com/author/sam80dev">Debraj Banerjee</option><option value="http://www.sportskeeda.com/author/Deepak.Srivastava">Deepak Srivastava</option><option value="http://www.sportskeeda.com/author/deepakpanwar">deepakpanwar</option><option value="http://www.sportskeeda.com/author/deepanker">deepanker</option><option value="http://www.sportskeeda.com/author/dev-sukumar-2-2-2">Dev Sukumar</option><option value="http://www.sportskeeda.com/author/devajeet">Devajeet Dutta</option><option value="http://www.sportskeeda.com/author/devjeetc">devjeetc</option><option value="http://www.sportskeeda.com/author/dgerrardo">dgerrardo</option><option value="http://www.sportskeeda.com/author/dhairyathakker">Dhairya Thakker</option><option value="http://www.sportskeeda.com/author/dhairyatrivedi">dhairyatrivedi</option><option value="http://www.sportskeeda.com/author/dhruvgupta03">dhruvgupta03</option><option value="http://www.sportskeeda.com/author/dhruvmufc">dhruvmufc</option><option value="http://www.sportskeeda.com/author/dibyabttb">Dibyasundar Nayak</option><option value="http://www.sportskeeda.com/author/dibs450">Dibyendu Karmakar</option><option value="http://www.sportskeeda.com/author/diksha_gupta">Diksha_Gupta</option><option value="http://www.sportskeeda.com/author/divaykhosla">Divay Khosla</option><option value="http://www.sportskeeda.com/author/divya">divya</option><option value="http://www.sportskeeda.com/author/divyajeevan">Divyajeevan Satpathy</option><option value="http://www.sportskeeda.com/author/dktoprani">dktoprani</option><option value="http://www.sportskeeda.com/author/nerazzurri">Don Nerazzurri</option><option value="http://www.sportskeeda.com/author/downatthirdman">Down At Third Man</option><option value="http://www.sportskeeda.com/author/dpa1990">dpa1990</option><option value="http://www.sportskeeda.com/author/deepak-sheth-2-2">Dr Deepak Sheth</option><option value="http://www.sportskeeda.com/author/drarvind1411">Dr.ARVIND SUBRAMANIAN</option><option value="http://www.sportskeeda.com/author/dr-s-arvind-subramanian">Dr.S.ARVIND SUBRAMANIAN</option><option value="http://www.sportskeeda.com/author/shounak2501">drBaltar25</option><option value="http://www.sportskeeda.com/author/earthwasi">earthwasi</option><option value="http://www.sportskeeda.com/author/eccentrickaushik">eccentrickaushik</option><option value="http://www.sportskeeda.com/author/empkrishna27">empkrishna27</option><option value="http://www.sportskeeda.com/author/haryanachess">Er Kuldeep Sharma</option><option value="http://www.sportskeeda.com/author/eshansett">Eshan Sett</option><option value="http://www.sportskeeda.com/author/euphoric">Euphoric</option><option value="http://www.sportskeeda.com/author/faizdarvesh">Faiz Darvesh</option><option value="http://www.sportskeeda.com/author/faizee">Faizan H Shaikh</option><option value="http://www.sportskeeda.com/author/fake-football-player">Fake Football Player</option><option value="http://www.sportskeeda.com/author/faking-news">Faking News</option><option value="http://www.sportskeeda.com/author/farennes">farennes</option><option value="http://www.sportskeeda.com/author/farhan-aziz">Farhan Aziz</option><option value="http://www.sportskeeda.com/author/fastformula">fastformula</option><option value="http://www.sportskeeda.com/author/fazayal">fazayal</option><option value="http://www.sportskeeda.com/author/fazilat">Fazilat Abazer Biviji</option><option value="http://www.sportskeeda.com/author/fergieshairdryer">Fergie's Hairdryer</option><option value="http://www.sportskeeda.com/author/ferlonso">ferlonso</option><option value="http://www.sportskeeda.com/author/fernando">Fernando</option><option value="http://www.sportskeeda.com/author/feroz">Feroz Khan</option><option value="http://www.sportskeeda.com/author/footballbloodyhell">Football Bloody Hell</option><option value="http://www.sportskeeda.com/author/footballcrazy">footballcrazy</option><option value="http://www.sportskeeda.com/author/footballwallah">FootballWallah</option><option value="http://www.sportskeeda.com/author/footynions">Footynions</option><option value="http://www.sportskeeda.com/author/foramg15">ForamG15</option><option value="http://www.sportskeeda.com/author/forrest-hamilton">forrest.hamilton</option><option value="http://www.sportskeeda.com/author/freehit">Freehit</option><option value="http://www.sportskeeda.com/author/funky-monkeyhanger">Funky Monkeyhanger</option><option value="http://www.sportskeeda.com/author/futbol-patient">Futbol Patient</option><option value="http://www.sportskeeda.com/author/gabbbarsingh">gabbbarsingh</option><option value="http://www.sportskeeda.com/author/halcyon">Gaurav</option><option value="http://www.sportskeeda.com/author/sportsbuff">Gaurav Banerji</option><option value="http://www.sportskeeda.com/author/gaurav-parab">Gaurav Parab</option><option value="http://www.sportskeeda.com/author/gautam-kudva">Gautam Kudva</option><option value="http://www.sportskeeda.com/author/gautam_kanu">gautam_kanu</option><option value="http://www.sportskeeda.com/author/gauthams">Gautham S</option><option value="http://www.sportskeeda.com/author/gauthi">gauthi</option><option value="http://www.sportskeeda.com/author/shreyasn14">geekatwork</option><option value="http://www.sportskeeda.com/author/giri5700">giri5700</option><option value="http://www.sportskeeda.com/author/giridhar">giridhar</option><option value="http://www.sportskeeda.com/author/giridh">Giridhar Harihran</option><option value="http://www.sportskeeda.com/author/godhelpsme">godhelpsme</option><option value="http://www.sportskeeda.com/author/gokulraghunadh">Gokul Raghunadh</option><option value="http://www.sportskeeda.com/author/googledgoogly">googledgoogly</option><option value="http://www.sportskeeda.com/author/gooner123anirudh">gooner123anirudh</option><option value="http://www.sportskeeda.com/author/gopalakrishnan-rajagopalan-2-2-2-2">Gopal</option><option value="http://www.sportskeeda.com/author/giftofdevil">Goutham Chakravarthi</option><option value="http://www.sportskeeda.com/author/grahamoxley">grahamoxley</option><option value="http://www.sportskeeda.com/author/grim">Grim</option><option value="http://www.sportskeeda.com/author/sahib">Gundeep Singh</option><option value="http://www.sportskeeda.com/author/gunner8789">gunner8789</option><option value="http://www.sportskeeda.com/author/gunnerashu">gunnerashu</option><option value="http://www.sportskeeda.com/author/gurjota">Gurjot Ahluwalia</option><option value="http://www.sportskeeda.com/author/guruprasad-gp">Guruprasad Gp</option><option value="http://www.sportskeeda.com/author/hardikvyas">Hardik Vyas</option><option value="http://www.sportskeeda.com/author/haresh">Haresh Ramchandani</option><option value="http://www.sportskeeda.com/author/harikrishnan">harikrishnan</option><option value="http://www.sportskeeda.com/author/hglive">Harish Ghodki</option><option value="http://www.sportskeeda.com/author/harmit-kamboe-2-2-2">Harmit Kamboe</option><option value="http://www.sportskeeda.com/author/harrymnnit">harrymnnit</option><option value="http://www.sportskeeda.com/author/meetthereddevil">Harsh Gupta</option><option value="http://www.sportskeeda.com/author/harshitbhatia80">harshitbhatia80</option><option value="http://www.sportskeeda.com/author/hasan-ejaz">Hasan Ejaz</option><option value="http://www.sportskeeda.com/author/highbury84">highbury84</option><option value="http://www.sportskeeda.com/author/himanshu">himanshu aggarwal</option><option value="http://www.sportskeeda.com/author/himanshu-singh15">Himanshu Singh</option><option value="http://www.sportskeeda.com/author/hoopistani">Hoopistani</option><option value="http://www.sportskeeda.com/author/hp">HP</option><option value="http://www.sportskeeda.com/author/hrishikeshdas">hrishikesh das</option><option value="http://www.sportskeeda.com/author/ht711">Hrishikesh Tiwari</option><option value="http://www.sportskeeda.com/author/husseinmarhoon">husseinmarhoon</option><option value="http://www.sportskeeda.com/author/huzefa">huzefa</option><option value="http://www.sportskeeda.com/author/ians">IANS</option><option value="http://www.sportskeeda.com/author/ilsgautam">ilsgautam</option><option value="http://www.sportskeeda.com/author/indianchelseafan">indianchelseafan</option><option value="http://www.sportskeeda.com/author/intermilanfan1908">intermilanfan1908</option><option value="http://www.sportskeeda.com/author/iqbalpcs">iqbalpcs</option><option value="http://www.sportskeeda.com/author/brainfabias17">Irfan Abbasi</option><option value="http://www.sportskeeda.com/author/ishansen">ishansen</option><option value="http://www.sportskeeda.com/author/j">J</option><option value="http://www.sportskeeda.com/author/ministryofsports">J K S</option><option value="http://www.sportskeeda.com/author/jack">Jack Pelini</option><option value="http://www.sportskeeda.com/author/jagannath87">jagannath87</option><option value="http://www.sportskeeda.com/author/jaideep18">jaideep18</option><option value="http://www.sportskeeda.com/author/jaiprasanth">jaiprasanth</option><option value="http://www.sportskeeda.com/author/jamesroy">jamesroy</option><option value="http://www.sportskeeda.com/author/janani">Janani</option><option value="http://www.sportskeeda.com/author/janyam21">janyam21</option><option value="http://www.sportskeeda.com/author/jasdeep">jasdeep</option><option value="http://www.sportskeeda.com/author/jashan83">Jashan</option><option value="http://www.sportskeeda.com/author/jasjeev24">Jasjeev Singh</option><option value="http://www.sportskeeda.com/author/jayant">Jayant Jalan</option><option value="http://www.sportskeeda.com/author/jaykrishnanp">jaykrishnanp</option><option value="http://www.sportskeeda.com/author/jdbasketball">jdbasketball</option><option value="http://www.sportskeeda.com/author/Jeetu Rk">Jeetu</option><option value="http://www.sportskeeda.com/author/jigsactin54">Jigar Mehta</option><option value="http://www.sportskeeda.com/author/jigar30">Jigar Raisinghani</option><option value="http://www.sportskeeda.com/author/jimmybhogal">Jimmy Bhogal</option><option value="http://www.sportskeeda.com/author/jk">JK</option><option value="http://www.sportskeeda.com/author/jmomanyi">jmomanyi</option><option value="http://www.sportskeeda.com/author/jogeshd">jogeshd</option><option value="http://www.sportskeeda.com/author/johnykev">Johny</option><option value="http://www.sportskeeda.com/author/jonah-gadsby">Jonah Gadsby</option><option value="http://www.sportskeeda.com/author/josh">Josh Bednash</option><option value="http://www.sportskeeda.com/author/rocksballer58">Josh Dhani</option><option value="http://www.sportskeeda.com/author/joydeepnandi">joydeepnandi</option><option value="http://www.sportskeeda.com/author/joydeepsanyal">joydeepsanyal</option><option value="http://www.sportskeeda.com/author/juggernautchetu">juggernaut.chetu.NITH</option><option value="http://www.sportskeeda.com/author/klmnspeed">KAPIL MOHAN</option><option value="http://www.sportskeeda.com/author/karansarnaik">karan</option><option value="http://www.sportskeeda.com/author/kmark">Karan Mark Virmani</option><option value="http://www.sportskeeda.com/author/karishma">karishma</option><option value="http://www.sportskeeda.com/author/karthikisthin">Karthik K</option><option value="http://www.sportskeeda.com/author/karthikparimal">Karthik Parimal</option><option value="http://www.sportskeeda.com/author/uvkk007">Kartik Mahajan</option><option value="http://www.sportskeeda.com/author/kartikbr94">kartikbr94</option><option value="http://www.sportskeeda.com/author/kaushz">kaushz</option><option value="http://www.sportskeeda.com/author/kckaran">kckaran</option><option value="http://www.sportskeeda.com/author/kdatta20">kdatta20</option><option value="http://www.sportskeeda.com/author/kdhingra3">kdhingra3</option><option value="http://www.sportskeeda.com/author/keeshchaos">Keeshaanan Sundaresan</option><option value="http://www.sportskeeda.com/author/keshav">keshav</option><option value="http://www.sportskeeda.com/author/kin-fai">Kin-Fai</option><option value="http://www.sportskeeda.com/author/kiranshah1984">Kiran</option><option value="http://www.sportskeeda.com/author/kamekish">KK Verma</option><option value="http://www.sportskeeda.com/author/kolkattan_aantel">kolkattan_aantel</option><option value="http://www.sportskeeda.com/author/kraniumdecay">kraniumdecay</option><option value="http://www.sportskeeda.com/author/krishsripada">Krish Sripada</option><option value="http://www.sportskeeda.com/author/kritika">Kritika</option><option value="http://www.sportskeeda.com/author/krtykyn23">krtykyn23</option><option value="http://www.sportskeeda.com/author/kspradi">kspradi</option><option value="http://www.sportskeeda.com/author/kumar">kumar</option><option value="http://www.sportskeeda.com/author/kumargaurav">kumargaurav</option><option value="http://www.sportskeeda.com/author/kunal">Kunal</option><option value="http://www.sportskeeda.com/author/kunalgaikwad">Kunal</option><option value="http://www.sportskeeda.com/author/kunal-salvi">Kunal Salvi</option><option value="http://www.sportskeeda.com/author/kyle">Kyle</option><option value="http://www.sportskeeda.com/author/lakersaregreat">lakersaregreat</option><option value="http://www.sportskeeda.com/author/redjiblog">Lako</option><option value="http://www.sportskeeda.com/author/lavishsports91">lavishsports91</option><option value="http://www.sportskeeda.com/author/layla">layla</option><option value="http://www.sportskeeda.com/author/lbhy-mshr">lbhy.mshr</option><option value="http://www.sportskeeda.com/author/theblcksheep">Leela Prasad</option><option value="http://www.sportskeeda.com/author/legsidelizzy">LegSideLizzy</option><option value="http://www.sportskeeda.com/author/leo-peter">leo peter</option><option value="http://www.sportskeeda.com/author/leonmayank">leonmayank</option><option value="http://www.sportskeeda.com/author/ervine11">Lester Pereira</option><option value="http://www.sportskeeda.com/author/les_quizerables">les_quizerables</option><option value="http://www.sportskeeda.com/author/li">Li Ming Law</option><option value="http://www.sportskeeda.com/author/liampennington">LiamPennington</option><option value="http://www.sportskeeda.com/author/fernal73">Linus Fernandes</option><option value="http://www.sportskeeda.com/author/lloydie192">lloydie192</option><option value="http://www.sportskeeda.com/author/lmktheleo">lmktheleo</option><option value="http://www.sportskeeda.com/author/louie">Louie</option><option value="http://www.sportskeeda.com/author/lovelyleftfoot">Lovelyleftfoot</option><option value="http://www.sportskeeda.com/author/maddy07">maddy07</option><option value="http://www.sportskeeda.com/author/madhuli">Madhuli Kulkarni</option><option value="http://www.sportskeeda.com/author/madhuri">Madhuri</option><option value="http://www.sportskeeda.com/author/maisnam">Maisnam Raju</option><option value="http://www.sportskeeda.com/author/malhar-lathkar">Malhar Lathkar</option><option value="http://www.sportskeeda.com/author/malibu">malibu</option><option value="http://www.sportskeeda.com/author/mambalamman">mambalamman</option><option value="http://www.sportskeeda.com/author/mananbhan">mananbhan</option><option value="http://www.sportskeeda.com/author/mandakini">mandakini</option><option value="http://www.sportskeeda.com/author/mandar18">mandar18</option><option value="http://www.sportskeeda.com/author/mandymoore2181">mandymoore2181</option><option value="http://www.sportskeeda.com/author/manish-patel">Manish Patel</option><option value="http://www.sportskeeda.com/author/mannyi">mannyi</option><option value="http://www.sportskeeda.com/author/mario">Mario Rodrigues</option><option value="http://www.sportskeeda.com/author/mastersk3">mastersk3</option><option value="http://www.sportskeeda.com/author/matt-zabierek">Matt Zabierek</option><option value="http://www.sportskeeda.com/author/f1_rocks">Mayank Grover</option><option value="http://www.sportskeeda.com/author/basumayukh">Mayukh Basu</option><option value="http://www.sportskeeda.com/author/mayur123">mayur123</option><option value="http://www.sportskeeda.com/author/mckachhy">mckachhy</option><option value="http://www.sportskeeda.com/author/melmatt">melmatt</option><option value="http://www.sportskeeda.com/author/menperei">Menino</option><option value="http://www.sportskeeda.com/author/mhoward2101">mhoward2101</option><option value="http://www.sportskeeda.com/author/ballackjr">Mihir More</option><option value="http://www.sportskeeda.com/author/mike_kris">mike_kris</option><option value="http://www.sportskeeda.com/author/ministryofhumour">ministryofhumour</option><option value="http://www.sportskeeda.com/author/mirajvora">Miraj Vora</option><option value="http://www.sportskeeda.com/author/mirkobolesan">Mirkobolesan</option><option value="http://www.sportskeeda.com/author/mishrakp">mishrakp</option><option value="http://www.sportskeeda.com/author/mithunganesh">mithunganesh</option><option value="http://www.sportskeeda.com/author/mnviswanath">mnviswanath</option><option value="http://www.sportskeeda.com/author/mogambo">Mogambo</option><option value="http://www.sportskeeda.com/author/mohi">mohi</option><option value="http://www.sportskeeda.com/author/mohitbhatia01">Mohit Bhatia</option><option value="http://www.sportskeeda.com/author/mohit-sinha">mohit sinha</option><option value="http://www.sportskeeda.com/author/mohit07">mohit07</option><option value="http://www.sportskeeda.com/author/mokka">Mokka</option><option value="http://www.sportskeeda.com/author/molli">molli</option><option value="http://www.sportskeeda.com/author/moneermujaddidi">moneermujaddidi</option><option value="http://www.sportskeeda.com/author/monisha">monisha dikshit</option><option value="http://www.sportskeeda.com/author/mouli106">mouli106</option><option value="http://www.sportskeeda.com/author/suranga">mrs suranga date</option><option value="http://www.sportskeeda.com/author/muhammed-suhaib">Muhammed Suhaib</option><option value="http://www.sportskeeda.com/author/mulla">Mulla</option><option value="http://www.sportskeeda.com/author/kadamurari">Murari Kadam</option><option value="http://www.sportskeeda.com/author/murtaza">Murtaza Ali</option><option value="http://www.sportskeeda.com/author/musababid">Musab Abid</option><option value="http://www.sportskeeda.com/author/aritra_dreams">Musafir</option><option value="http://www.sportskeeda.com/author/myf1eye">MyF1eye</option><option value="http://www.sportskeeda.com/author/mzshubham">mzshubham</option><option value="http://www.sportskeeda.com/author/nvssudheer">N V S Sudheer</option><option value="http://www.sportskeeda.com/author/naba">naba</option><option value="http://www.sportskeeda.com/author/nagarajputhiyavan">nagarajputhiyavan</option><option value="http://www.sportskeeda.com/author/nagesh">nagesh</option><option value="http://www.sportskeeda.com/author/nakulkothari">Nakul Kothari</option><option value="http://www.sportskeeda.com/author/naman7kalkhuria">NAMAN KALKHURIA</option><option value="http://www.sportskeeda.com/author/namanbansal">namanbansal</option><option value="http://www.sportskeeda.com/author/namya">Namya</option><option value="http://www.sportskeeda.com/author/nandinikumar">nandinikumar</option><option value="http://www.sportskeeda.com/author/nanditaladyinred">Nandita Jain</option><option value="http://www.sportskeeda.com/author/narasjbhs">narasjbhs</option><option value="http://www.sportskeeda.com/author/naren-shenoy">Naren Shenoy</option><option value="http://www.sportskeeda.com/author/natarajan-hariharan">Natarajan Hariharan</option><option value="http://www.sportskeeda.com/author/naveen1788">Naveen Ullal</option><option value="http://www.sportskeeda.com/author/navin-anand">Navin Anand</option><option value="http://www.sportskeeda.com/author/navneetmundhra26">Navneet Mundhra</option><option value="http://www.sportskeeda.com/author/nawang">Nawang</option><option value="http://www.sportskeeda.com/author/nayyarasheed">Nayyar Abdul Rasheed</option><option value="http://www.sportskeeda.com/author/njrover">Neeraj Grover</option><option value="http://www.sportskeeda.com/author/neerajnarayanan">Neeraj Narayanan</option><option value="http://www.sportskeeda.com/author/neerajdelima">neerajdelima</option><option value="http://www.sportskeeda.com/author/neerajnufc">neerajnufc</option><option value="http://www.sportskeeda.com/author/neerajrai2007">neerajrai2007</option><option value="http://www.sportskeeda.com/author/neeru786">neeru786</option><option value="http://www.sportskeeda.com/author/neha-j">Neha J.</option><option value="http://www.sportskeeda.com/author/neji">Neji</option><option value="http://www.sportskeeda.com/author/nemesis">nemesis</option><option value="http://www.sportskeeda.com/author/dhruv_ntmn">News That Matters Not (NTMN)</option><option value="http://www.sportskeeda.com/author/nidhun">Nidhun Thankachan</option><option value="http://www.sportskeeda.com/author/nikhilnarvekar8">Nikhil Narvekar</option><option value="http://www.sportskeeda.com/author/niklas">Niklas</option><option value="http://www.sportskeeda.com/author/nikolakis">nikolakis</option><option value="http://www.sportskeeda.com/author/nikulkarni">nikulkarni</option><option value="http://www.sportskeeda.com/author/nikvyas20">Nikvyas20</option><option value="http://www.sportskeeda.com/author/nikzz">nikzz</option><option value="http://www.sportskeeda.com/author/nilasish">nilasish</option><option value="http://www.sportskeeda.com/author/nilesh">nilesh</option><option value="http://www.sportskeeda.com/author/nspatankar">Nilesh Patankar</option><option value="http://www.sportskeeda.com/author/nipun">Nipun</option><option value="http://www.sportskeeda.com/author/nierav">Nirav Malaviya</option><option value="http://www.sportskeeda.com/author/nirmalyabasu5">nirmalyabasu5</option><option value="http://www.sportskeeda.com/author/nirvana">Nirvana Laha</option><option value="http://www.sportskeeda.com/author/nishant_88">Nishant Dey Purkayastha</option><option value="http://www.sportskeeda.com/author/niku">Nishant Kumar</option><option value="http://www.sportskeeda.com/author/nick2098">Nishant Raj</option><option value="http://www.sportskeeda.com/author/ronnyramela">nishant ramela</option><option value="http://www.sportskeeda.com/author/nishantsood28">Nishant Sood</option><option value="http://www.sportskeeda.com/author/niteshpinge">Nitesh Pinge</option><option value="http://www.sportskeeda.com/author/nitesh47">nitesh47</option><option value="http://www.sportskeeda.com/author/nitg86">nitg86</option><option value="http://www.sportskeeda.com/author/oalmasri">oalmasri</option><option value="http://www.sportskeeda.com/author/oliver-turner">Oliver Turner</option><option value="http://www.sportskeeda.com/author/omkarparnandiwar">Omkar Parnandiwar</option><option value="http://www.sportskeeda.com/author/onkarsatam">onkarsatam</option><option value="http://www.sportskeeda.com/author/oumar25">oumar25</option><option value="http://www.sportskeeda.com/author/praveen">P</option><option value="http://www.sportskeeda.com/author/p11biswajeetm">p11biswajeetm</option><option value="http://www.sportskeeda.com/author/pallavi7">Pallavi Mohapatra</option><option value="http://www.sportskeeda.com/author/parimalb">parimalb</option><option value="http://www.sportskeeda.com/author/parkalsuhas">parkalsuhas</option><option value="http://www.sportskeeda.com/author/adwaitp">Pat</option><option value="http://www.sportskeeda.com/author/patrick">Patrick</option><option value="http://www.sportskeeda.com/author/patadams">Patrick Adams</option><option value="http://www.sportskeeda.com/author/patterson-fernandes">Patterson Fernandes</option><option value="http://www.sportskeeda.com/author/pavops">pavilion opinion</option><option value="http://www.sportskeeda.com/author/pavilion-opinions">Pavilion Opinions</option><option value="http://www.sportskeeda.com/author/pawan">pawan</option><option value="http://www.sportskeeda.com/author/pawanthegunner">Pawan Dubey</option><option value="http://www.sportskeeda.com/author/pedro-gonzales-2-2-2">Pedro Gonzales</option><option value="http://www.sportskeeda.com/author/peepu92">peepLFC</option><option value="http://www.sportskeeda.com/author/persiesque">persiesque</option><option value="http://www.sportskeeda.com/author/pifa">PIFA</option><option value="http://www.sportskeeda.com/author/piyush">Piyush Mishra</option><option value="http://www.sportskeeda.com/author/piyush3">Piyush Nathani</option><option value="http://www.sportskeeda.com/author/12thplayer">Playmaker</option><option value="http://www.sportskeeda.com/author/porush-jain-2-2">Porush Jain</option><option value="http://www.sportskeeda.com/author/pradeep-srikant">Pradeep Srikant</option><option value="http://www.sportskeeda.com/author/pradeep0207">pradeep0207</option><option value="http://www.sportskeeda.com/author/prafulkhurana">prafulkhurana</option><option value="http://www.sportskeeda.com/author/pranaav26">pranaav26</option><option value="http://www.sportskeeda.com/author/darbatov">Pranav Dar</option><option value="http://www.sportskeeda.com/author/pranavmukul">Pranav Mukul</option><option value="http://www.sportskeeda.com/author/pranavprakash">pranavprakash</option><option value="http://www.sportskeeda.com/author/kvsp">praneeth</option><option value="http://www.sportskeeda.com/author/prasaad-ayyanar">Prasaad Ayyanar</option><option value="http://www.sportskeeda.com/author/prasadsalvi">Prasad Salvi</option><option value="http://www.sportskeeda.com/author/prashant-paradkar">Prashant Paradkar</option><option value="http://www.sportskeeda.com/author/prashant4c">prashant4c</option><option value="http://www.sportskeeda.com/author/prashantvsk">prashantvsk</option><option value="http://www.sportskeeda.com/author/prasoon02">Prasoon</option><option value="http://www.sportskeeda.com/author/khiladikeeda">Prasun Agrawal</option><option value="http://www.sportskeeda.com/author/pratskeeda">Prateek Dhariwal</option><option value="http://www.sportskeeda.com/author/ftblcrzy">Prateek Senapati</option><option value="http://www.sportskeeda.com/author/prateekraheja">Prateek@Raheja</option><option value="http://www.sportskeeda.com/author/pratish87">Pratheesh C K</option><option value="http://www.sportskeeda.com/author/praveenkoushik">praveenkoushik</option><option value="http://www.sportskeeda.com/author/pravin">pravin ramarao</option><option value="http://www.sportskeeda.com/author/praz83">praz83</option><option value="http://www.sportskeeda.com/author/premchee">premchee</option><option value="http://www.sportskeeda.com/author/pinx">Priya</option><option value="http://www.sportskeeda.com/author/priyam">priyam</option><option value="http://www.sportskeeda.com/author/pronikki">pronikki</option><option value="http://www.sportskeeda.com/author/prthvir-solanki-2-2-2-2-2-2-2-2-2-2-2">Prthvir Solanki</option><option value="http://www.sportskeeda.com/author/psparameswaran">psparameswaran</option><option value="http://www.sportskeeda.com/author/pubole">PU</option><option value="http://www.sportskeeda.com/author/eioa">Pulkit</option><option value="http://www.sportskeeda.com/author/agent001">Pulkit Mehra</option><option value="http://www.sportskeeda.com/author/purnima">Purnima Malhotra</option><option value="http://www.sportskeeda.com/author/pushkaraj-baandal">PUSHKARAJ BAANDAL</option><option value="http://www.sportskeeda.com/author/rachit">rachit</option><option value="http://www.sportskeeda.com/author/rachitkwatra">rachitkwatra</option><option value="http://www.sportskeeda.com/author/sportacus">raghavan m j</option><option value="http://www.sportskeeda.com/author/ragul">Ragul</option><option value="http://www.sportskeeda.com/author/rahul">Rahul</option><option value="http://www.sportskeeda.com/author/rauuullll">Rahul Bhatia</option><option value="http://www.sportskeeda.com/author/rasac">Rahul Kishore Singh</option><option value="http://www.sportskeeda.com/author/r123">Rahul Lalchandani</option><option value="http://www.sportskeeda.com/author/rahul-nair">Rahul Nair</option><option value="http://www.sportskeeda.com/author/rahul-rai">rahul rai</option><option value="http://www.sportskeeda.com/author/rahulsaraf">Rahul Saraf</option><option value="http://www.sportskeeda.com/author/slayer23">Rahul Unnikrishnan</option><option value="http://www.sportskeeda.com/author/rahulg1989">rahulg1989</option><option value="http://www.sportskeeda.com/author/raichu777">raichu777</option><option value="http://www.sportskeeda.com/author/amii894">Raj Amit</option><option value="http://www.sportskeeda.com/author/rajalingam">rajalingam</option><option value="http://www.sportskeeda.com/author/rajantr">Rajan</option><option value="http://www.sportskeeda.com/author/rajarshi">Rajarshi Chakraborti</option><option value="http://www.sportskeeda.com/author/rajat85">Rajat Jain</option><option value="http://www.sportskeeda.com/author/rajesh">Rajesh kumar</option><option value="http://www.sportskeeda.com/author/rajeshsingla">Rajesh SINGLA</option><option value="http://www.sportskeeda.com/author/rajitdivetia">rajitdivetia</option><option value="http://www.sportskeeda.com/author/spursfan">RajTHFC</option><option value="http://www.sportskeeda.com/author/rajthfc">Rajthfc</option><option value="http://www.sportskeeda.com/author/ralphwanniang">ralphwanniang</option><option value="http://www.sportskeeda.com/author/ramchandar">Ram</option><option value="http://www.sportskeeda.com/author/rgarimella">Raman Garimella</option><option value="http://www.sportskeeda.com/author/gramessh">Ramesh Ganapathy</option><option value="http://www.sportskeeda.com/author/ramnarayanan">ramnarayanan</option><option value="http://www.sportskeeda.com/author/ratish91">ratish91</option><option value="http://www.sportskeeda.com/author/raushfrenzy">raushan</option><option value="http://www.sportskeeda.com/author/rawk">rawk</option><option value="http://www.sportskeeda.com/author/rdsaha">rdsaha</option><option value="http://www.sportskeeda.com/author/redrobbery">Red Robbery</option><option value="http://www.sportskeeda.com/author/redarmy">Redarmy</option><option value="http://www.sportskeeda.com/author/reddevil09">reddevil09</option><option value="http://www.sportskeeda.com/author/reddevilsubu">reddevilsubu</option><option value="http://www.sportskeeda.com/author/redevilnum11">redevilnum11</option><option value="http://www.sportskeeda.com/author/redthil">redthil</option><option value="http://www.sportskeeda.com/author/remco">Remco</option><option value="http://www.sportskeeda.com/author/renato-andreoa">Renato Andreoa</option><option value="http://www.sportskeeda.com/author/revs">Revathi Ramanan</option><option value="http://www.sportskeeda.com/author/rgs318988">rgs318988</option><option value="http://www.sportskeeda.com/author/richakapoor">richakapoor</option><option value="http://www.sportskeeda.com/author/ridhi">Ridhi</option><option value="http://www.sportskeeda.com/author/ripudaman-singh">Ripudaman Singh</option><option value="http://www.sportskeeda.com/author/rishabh">Rishabh</option><option value="http://www.sportskeeda.com/author/rishabhpb">Rishabh Bablani</option><option value="http://www.sportskeeda.com/author/rishabhthomas">rishabhthomas</option><option value="http://www.sportskeeda.com/author/rishika">rishika</option><option value="http://www.sportskeeda.com/author/ritesh">Ritesh</option><option value="http://www.sportskeeda.com/author/ritoban">rito</option><option value="http://www.sportskeeda.com/author/realmadridinfo">rmadridinfo</option><option value="http://www.sportskeeda.com/author/rmadridinfo">rmadridinfo</option><option value="http://www.sportskeeda.com/author/robin_chhabra">robin_chhabra</option><option value="http://www.sportskeeda.com/author/robsum">robsum</option><option value="http://www.sportskeeda.com/author/rock4pele">rock4pele</option><option value="http://www.sportskeeda.com/author/rohini-iyer">Roh</option><option value="http://www.sportskeeda.com/author/rohanajax">Rohan</option><option value="http://www.sportskeeda.com/author/rohan-gaitonde-2-2">Rohan Gaitonde</option><option value="http://www.sportskeeda.com/author/rohit-lakhera-2">Rohit Lakhera</option><option value="http://www.sportskeeda.com/author/rohit-prabhudesai">Rohit.prabhudesai</option><option value="http://www.sportskeeda.com/author/rohitgeorge">rohitgeorge</option><option value="http://www.sportskeeda.com/author/rohitgore">rohitgore</option><option value="http://www.sportskeeda.com/author/roman">Roman's Chief</option><option value="http://www.sportskeeda.com/author/ronakvora">Ronak Vora</option><option value="http://www.sportskeeda.com/author/rsaxena">rsaxena</option><option value="http://www.sportskeeda.com/author/rulingprateek">RulingPrateek</option><option value="http://www.sportskeeda.com/author/rv">RV</option><option value="http://www.sportskeeda.com/author/ryanwood">Ryan Wood</option><option value="http://www.sportskeeda.com/author/s-t-arasu">S T Arasu</option><option value="http://www.sportskeeda.com/author/saachi-sharma">Saachi Sharma</option><option value="http://www.sportskeeda.com/author/strykerjsph">Sachin Joseph</option><option value="http://www.sportskeeda.com/author/sachin-kale">sachin kale</option><option value="http://www.sportskeeda.com/author/sachindan">Sachintha Wijayatunga</option><option value="http://www.sportskeeda.com/author/sagar-premkumar">Sagar Premkumar</option><option value="http://www.sportskeeda.com/author/sah25495">sah25495</option><option value="http://www.sportskeeda.com/author/sahilriz">Sahil Rizwan</option><option value="http://www.sportskeeda.com/author/saikat">saikat</option><option value="http://www.sportskeeda.com/author/saisreenivasan">saisreenivasan</option><option value="http://www.sportskeeda.com/author/saiyedhamza">saiyedhamza</option><option value="http://www.sportskeeda.com/author/sajin">sajin</option><option value="http://www.sportskeeda.com/author/sakthikrishna">sakthikrishna</option><option value="http://www.sportskeeda.com/author/shoalcave29">Sam</option><option value="http://www.sportskeeda.com/author/sambhavkhetarpal">Sambhav Khetarpal</option><option value="http://www.sportskeeda.com/author/samkkaran">samkkaran</option><option value="http://www.sportskeeda.com/author/culer">Sammio</option><option value="http://www.sportskeeda.com/author/sanchitad">sanchitad</option><option value="http://www.sportskeeda.com/author/sandeepshenoy7">sandeepshenoy7</option><option value="http://www.sportskeeda.com/author/sandyqbg">sandyqbg</option><option value="http://www.sportskeeda.com/author/sanjay2">Sanjay Sardesai</option><option value="http://www.sportskeeda.com/author/sanketm">Sanket Mahapatra</option><option value="http://www.sportskeeda.com/author/sanketc7">sanketc7</option><option value="http://www.sportskeeda.com/author/Sankha Ghose">Sankha</option><option value="http://www.sportskeeda.com/author/sankhadeep-sengupta">sankhadeep sengupta</option><option value="http://www.sportskeeda.com/author/sanks137">sanks137</option><option value="http://www.sportskeeda.com/author/sapan123">sapan123</option><option value="http://www.sportskeeda.com/author/sarah09">Sarah</option><option value="http://www.sportskeeda.com/author/sarangbhalerao">sarangbhalerao</option><option value="http://www.sportskeeda.com/author/sarcasan">sarcasan</option><option value="http://www.sportskeeda.com/author/sargamwadhwa">Sargam</option><option value="http://www.sportskeeda.com/author/satishvckrishnan">satishvckrishnan</option><option value="http://www.sportskeeda.com/author/satwikroy">satwikroy</option><option value="http://www.sportskeeda.com/author/satbir23">saty</option><option value="http://www.sportskeeda.com/author/satyakant">satyakant</option><option value="http://www.sportskeeda.com/author/saunakroy">Saunak Roy</option><option value="http://www.sportskeeda.com/author/925sandy">Saundarya Talwar</option><option value="http://www.sportskeeda.com/author/sauravky92">Saurabh Mohapatra</option><option value="http://www.sportskeeda.com/author/saurabhrai">Saurabh Rai</option><option value="http://www.sportskeeda.com/author/saurvan">saurvan</option><option value="http://www.sportskeeda.com/author/saurya">Saurya Sengupta</option><option value="http://www.sportskeeda.com/author/sayak">Sayak</option><option value="http://www.sportskeeda.com/author/nayas">Sayan</option><option value="http://www.sportskeeda.com/author/scar">scar</option><option value="http://www.sportskeeda.com/author/scott">Scott Oliver</option><option value="http://www.sportskeeda.com/author/scouser09">scouser09</option><option value="http://www.sportskeeda.com/author/scubymuki">scubymuki</option><option value="http://www.sportskeeda.com/author/sekhar_s">SEKHAR</option><option value="http://www.sportskeeda.com/author/semwal">semi</option><option value="http://www.sportskeeda.com/author/ses3an">ses3an</option><option value="http://www.sportskeeda.com/author/sfs_striker">SFS_striker</option><option value="http://www.sportskeeda.com/author/sgeorge">SGeorge</option><option value="http://www.sportskeeda.com/author/shaahid13">shaahid13</option><option value="http://www.sportskeeda.com/author/shady">shady</option><option value="http://www.sportskeeda.com/author/shames">shames</option><option value="http://www.sportskeeda.com/author/shankar-kumar-chatterjee">Shankar Kumar Chatterjee</option><option value="http://www.sportskeeda.com/author/shanks">ShankS</option><option value="http://www.sportskeeda.com/author/shantanu">shantanu</option><option value="http://www.sportskeeda.com/author/shantanumunshi">shantanumunshi</option><option value="http://www.sportskeeda.com/author/shanthakumar">Shantha Kumar</option><option value="http://www.sportskeeda.com/author/shantiprakash">shantiprakash</option><option value="http://www.sportskeeda.com/author/sharat-chandra">Sharat Chandra</option><option value="http://www.sportskeeda.com/author/sharath2692">sharath2692</option><option value="http://www.sportskeeda.com/author/manutd-rocker">Shashank Gupta</option><option value="http://www.sportskeeda.com/author/shashankarya">shashankarya</option><option value="http://www.sportskeeda.com/author/shashwat">SHASHWAT</option><option value="http://www.sportskeeda.com/author/shaunak">Shaunak</option><option value="http://www.sportskeeda.com/author/saquibthegunner">sheikh ahmed saquib</option><option value="http://www.sportskeeda.com/author/shekharlele">Shekhar Lele</option><option value="http://www.sportskeeda.com/author/shenoy-nagendra">shenoy.nagendra</option><option value="http://www.sportskeeda.com/author/vision">Shiba Maggon</option><option value="http://www.sportskeeda.com/author/shikhar">shikhar</option><option value="http://www.sportskeeda.com/author/shilpakamble22">Shilpa Kamble</option><option value="http://www.sportskeeda.com/author/shipramehandru">shipramehandru</option><option value="http://www.sportskeeda.com/author/shirohin">shirohin</option><option value="http://www.sportskeeda.com/author/shishirbelvi">shishirbelvi</option><option value="http://www.sportskeeda.com/author/shivank">Shivank Rai</option><option value="http://www.sportskeeda.com/author/shivank17">Shivank Sharma</option><option value="http://www.sportskeeda.com/author/shortarmjab">shortarmjab</option><option value="http://www.sportskeeda.com/author/shreyansrai">shreyansrai</option><option value="http://www.sportskeeda.com/author/cric-sis">Shridhar Jaju</option><option value="http://www.sportskeeda.com/author/shriramnarayan">Shriram Narayan</option><option value="http://www.sportskeeda.com/author/shruti-roy-2-2">Shruti Roy</option><option value="http://www.sportskeeda.com/author/shubi1994">shubi1994</option><option value="http://www.sportskeeda.com/author/shyamcfc92">shyamcfc92</option><option value="http://www.sportskeeda.com/author/siddharthagrover">Sid</option><option value="http://www.sportskeeda.com/author/sidbreakball">sidbreakball</option><option value="http://www.sportskeeda.com/author/siddarth-rajkumar-2">Siddarth</option><option value="http://www.sportskeeda.com/author/ssiddharth">Siddharth</option><option value="http://www.sportskeeda.com/author/sid007">Siddharth</option><option value="http://www.sportskeeda.com/author/tzar">Siddharth Sharma</option><option value="http://www.sportskeeda.com/author/siddharthk14">siddharthk14</option><option value="http://www.sportskeeda.com/author/siddharthrajan1">siddharthrajan1</option><option value="http://www.sportskeeda.com/author/siddhesh">Siddhesh Agashe</option><option value="http://www.sportskeeda.com/author/sidelineartist">SidelineArtist</option><option value="http://www.sportskeeda.com/author/sidharthp7">sidharthp7</option><option value="http://www.sportskeeda.com/author/sidhusagi007">sidhusagi007</option><option value="http://www.sportskeeda.com/author/simantgoyal">Simant</option><option value="http://www.sportskeeda.com/author/simon">Simon</option><option value="http://www.sportskeeda.com/author/simoncarabetta">simoncarabetta</option><option value="http://www.sportskeeda.com/author/sinchansarkar10">Sinchan Sarkar</option><option value="http://www.sportskeeda.com/author/sir-timmy">Sir Timmy</option><option value="http://www.sportskeeda.com/author/sivaramparameswaran">Sivaram Parameswaran</option><option value="http://www.sportskeeda.com/author/sivaraml">sivaraml</option><option value="http://www.sportskeeda.com/author/skachhy">skachhy</option><option value="http://www.sportskeeda.com/author/skagrawal4k">skagrawal4k</option><option value="http://www.sportskeeda.com/author/slightlyonside">slightlyonside</option><option value="http://www.sportskeeda.com/author/smileyyk">SmileyYK</option><option value="http://www.sportskeeda.com/author/smith_sh">smith_sh</option><option value="http://www.sportskeeda.com/author/snehareddy91">snehareddy91</option><option value="http://www.sportskeeda.com/author/sneheelfootyprophet">sneheelfootyprophet</option><option value="http://www.sportskeeda.com/author/sobsingh">sobsingh</option><option value="http://www.sportskeeda.com/author/barcaandmessirulez">SoccerIZZlife</option><option value="http://www.sportskeeda.com/author/soham-sarkhel">Soham Sarkhel</option><option value="http://www.sportskeeda.com/author/somesh">Somesh Upadhyay</option><option value="http://www.sportskeeda.com/author/soubhik">soubhik</option><option value="http://www.sportskeeda.com/author/soumik">Soumik</option><option value="http://www.sportskeeda.com/author/soumitra-kapri-2-2-2">Soumitra Kapri</option><option value="http://www.sportskeeda.com/author/soumo">Soumodip Guha</option><option value="http://www.sportskeeda.com/author/sounakchakrabarty">sounakchakrabarty</option><option value="http://www.sportskeeda.com/author/soup">souparno</option><option value="http://www.sportskeeda.com/author/pagalkeeda">söürav</option><option value="http://www.sportskeeda.com/author/sourav-dutta">Sourav Dutta</option><option value="http://www.sportskeeda.com/author/bharathshastry">sportanalyst</option><option value="http://www.sportskeeda.com/author/sports-india">Sports India</option><option value="http://www.sportskeeda.com/author/sportsfreak">sportsfreak</option><option value="http://www.sportskeeda.com/author/sportsfreak10">sportsfreak10</option><option value="http://www.sportskeeda.com/author/sportsphysio">sportsphysio</option><option value="http://www.sportskeeda.com/author/sportybug">sportybug</option><option value="http://www.sportskeeda.com/author/sreedhar1991">sreedhar1991</option><option value="http://www.sportskeeda.com/author/srikanth">srikanth</option><option value="http://www.sportskeeda.com/author/insanesrikanth">Srikanth Sriramagiri</option><option value="http://www.sportskeeda.com/author/bangalorekeeda">Srinivas Cuddapah</option><option value="http://www.sportskeeda.com/author/sriram04144">Sriram Ilango</option><option value="http://www.sportskeeda.com/author/sportskeeda">Staff Reporter</option><option value="http://www.sportskeeda.com/author/starsonstars">starsonstars</option><option value="http://www.sportskeeda.com/author/subhash-mahajan">Subhash Mahajan</option><option value="http://www.sportskeeda.com/author/subhroneo">subhroneo</option><option value="http://www.sportskeeda.com/author/sudersanin">Sudersan</option><option value="http://www.sportskeeda.com/author/sudeshna-banerjee">Sudeshna Banerjee</option><option value="http://www.sportskeeda.com/author/sudhir">Sudhir Bothra</option><option value="http://www.sportskeeda.com/author/suhansarkar">suhansarkar</option><option value="http://www.sportskeeda.com/author/suhas">suhas</option><option value="http://www.sportskeeda.com/author/k77sujith">Sujith Krishnan</option><option value="http://www.sportskeeda.com/author/sujith">Sujith Narayan</option><option value="http://www.sportskeeda.com/author/sumal">sumal</option><option value="http://www.sportskeeda.com/author/sumanm">Suman Mohapatra</option><option value="http://www.sportskeeda.com/author/sumitbisht09">SUMIT</option><option value="http://www.sportskeeda.com/author/sunitkumar">Sunit Kumar Thakurta</option><option value="http://www.sportskeeda.com/author/sunprince">sunprince</option><option value="http://www.sportskeeda.com/author/surjith">Surjith</option><option value="http://www.sportskeeda.com/author/suromitro">suromitro</option><option value="http://www.sportskeeda.com/author/suseemjain">suseemjain</option><option value="http://www.sportskeeda.com/author/sushrutbhatia">sushrut</option><option value="http://www.sportskeeda.com/author/sushrutpadhye">sushrutpadhye</option><option value="http://www.sportskeeda.com/author/suvarghya">Suvarghya Kar</option><option value="http://www.sportskeeda.com/author/suyash-shetty">Suyash Shetty</option><option value="http://www.sportskeeda.com/author/suyashu">Suyash Upadhyaya</option><option value="http://www.sportskeeda.com/author/swapnilsaurav">swapnilsaurav</option><option value="http://www.sportskeeda.com/author/swarnadeep-chatterjee-2-2-2">Swarnadeep Chatterjee</option><option value="http://www.sportskeeda.com/author/swarnavoc24">swarnavoc24</option><option value="http://www.sportskeeda.com/author/tababa">tababa</option><option value="http://www.sportskeeda.com/author/tacticianblog">Tacticianblog</option><option value="http://www.sportskeeda.com/author/tanmoy-bhattacharyya-2">Tanmoy Bhattacharyya</option><option value="http://www.sportskeeda.com/author/tanya">tanya</option><option value="http://www.sportskeeda.com/author/tapas">tapas</option><option value="http://www.sportskeeda.com/author/tapasperti">Tapas Perti</option><option value="http://www.sportskeeda.com/author/tarique-adnan-siddiqui">Tarique Adnan Siddiqui</option><option value="http://www.sportskeeda.com/author/tarish">Tarish Bhatt</option><option value="http://www.sportskeeda.com/author/honestcheat4u">Tarun Avtar Arya</option><option value="http://www.sportskeeda.com/author/tarutr">tarutr</option><option value="http://www.sportskeeda.com/author/teenqueen90">teenqueen90</option><option value="http://www.sportskeeda.com/author/victree">Tejasvi P S V R V</option><option value="http://www.sportskeeda.com/author/tazz">Tejaswi</option><option value="http://www.sportskeeda.com/author/thakermaharshi">thakermaharshi</option><option value="http://www.sportskeeda.com/author/tharani501">Tharanidaran Nadarajah</option><option value="http://www.sportskeeda.com/author/the-coach">The Coach</option><option value="http://www.sportskeeda.com/author/sidmenon">The Follower</option><option value="http://www.sportskeeda.com/author/the-sporting-opinion-the-beautiful-game">The Sporting Opinion - The Beautiful Game</option><option value="http://www.sportskeeda.com/author/the-tennis-space">The Tennis Space</option><option value="http://www.sportskeeda.com/author/thebigdowg">TheBigDowg</option><option value="http://www.sportskeeda.com/author/thechelseachiefs">thechelseachiefs</option><option value="http://www.sportskeeda.com/author/thegoanpatiala">thegoanpatiala</option><option value="http://www.sportskeeda.com/author/thereversesweep">thereversesweep</option><option value="http://www.sportskeeda.com/author/theteamofyourdreams">theteamofyourdreams</option><option value="http://www.sportskeeda.com/author/william-le-breton">Third Man</option><option value="http://www.sportskeeda.com/author/thitesuyash">thitesuyash</option><option value="http://www.sportskeeda.com/author/thomas1309">thomas1309</option><option value="http://www.sportskeeda.com/author/justdoesit">Thunderdog</option><option value="http://www.sportskeeda.com/author/tim-holt-2">Tim Holt</option><option value="http://www.sportskeeda.com/author/tina">Tina</option><option value="http://www.sportskeeda.com/author/tohid21">Tohid Ahmed</option><option value="http://www.sportskeeda.com/author/tomhue1">Tom Huelin</option><option value="http://www.sportskeeda.com/author/Tom.Benjamin">Tom.Benjamin</option><option value="http://www.sportskeeda.com/author/tommy">tommy</option><option value="http://www.sportskeeda.com/author/totallygoats">totallygoats</option><option value="http://www.sportskeeda.com/author/trollfootball">trollfootball</option><option value="http://www.sportskeeda.com/author/tushar">tushar agarwal</option><option value="http://www.sportskeeda.com/author/udaykapur">Uday</option><option value="http://www.sportskeeda.com/author/eudy">udayan</option><option value="http://www.sportskeeda.com/author/ujjwal">ujjwal</option><option value="http://www.sportskeeda.com/author/ullas14">ullas14</option><option value="http://www.sportskeeda.com/author/ultimateudai">ultimateudai</option><option value="http://www.sportskeeda.com/author/umang">umang</option><option value="http://www.sportskeeda.com/author/unnatch">unnatch</option><option value="http://www.sportskeeda.com/author/utkarsh">utkarsh</option><option value="http://www.sportskeeda.com/author/mrliverpool">Utkarsh</option><option value="http://www.sportskeeda.com/author/utkarshb">Utkarsh Bhatla</option><option value="http://www.sportskeeda.com/author/uttiyosarkar">Uttiyo Sarkar</option><option value="http://www.sportskeeda.com/author/vaietc">Vaibhav Shankar</option><option value="http://www.sportskeeda.com/author/vaibhav010">vaibhav010</option><option value="http://www.sportskeeda.com/author/nairv2013">vaishakh@joka</option><option value="http://www.sportskeeda.com/author/ingridmorstrad">van Menon</option><option value="http://www.sportskeeda.com/author/vandana">vandana sports physio</option><option value="http://www.sportskeeda.com/author/vandiablo">vandiablo</option><option value="http://www.sportskeeda.com/author/vansha10">vansh</option><option value="http://www.sportskeeda.com/author/vanshagrawal">Vansh</option><option value="http://www.sportskeeda.com/author/varad">Varadharajan Ramesh</option><option value="http://www.sportskeeda.com/author/vartul">vartul</option><option value="http://www.sportskeeda.com/author/varkapil">Varun Kappal</option><option value="http://www.sportskeeda.com/author/wisevarun">Varun M Kochi</option><option value="http://www.sportskeeda.com/author/varunsharma">varun sharma</option><option value="http://www.sportskeeda.com/author/varunshetty2893">Varun Shetty</option><option value="http://www.sportskeeda.com/author/thewazza">Varun Vaswani</option><option value="http://www.sportskeeda.com/author/vasily">vasily</option><option value="http://www.sportskeeda.com/author/vassili-kuragin">Vassili Kuragin</option><option value="http://www.sportskeeda.com/author/veda">veda</option><option value="http://www.sportskeeda.com/author/vekram">vekram</option><option value="http://www.sportskeeda.com/author/venkataramana">venkataramana</option><option value="http://www.sportskeeda.com/author/venkatesh88">Venkatesh</option><option value="http://www.sportskeeda.com/author/venkatesh-mohan">venkatesh mohan</option><option value="http://www.sportskeeda.com/author/venugopal-r-2-2">Venu</option><option value="http://www.sportskeeda.com/author/kvvarun23">Veron</option><option value="http://www.sportskeeda.com/author/vibhuuuu">vibhuuuu</option><option value="http://www.sportskeeda.com/author/vibsjpr">vibsjpr</option><option value="http://www.sportskeeda.com/author/rgirish28">Vichu</option><option value="http://www.sportskeeda.com/author/vickysolanki">vickysolanki</option><option value="http://www.sportskeeda.com/author/opinionsoncricket">Vidooshak-Golandaaz</option><option value="http://www.sportskeeda.com/author/vidz">Vidula S. Menge</option><option value="http://www.sportskeeda.com/author/vijay-kiran-cheruvu">Vijay Cheruvu</option><option value="http://www.sportskeeda.com/author/vijay99anand">vijay99anand</option><option value="http://www.sportskeeda.com/author/vijaymenon">vijaymenon</option><option value="http://www.sportskeeda.com/author/vikalp">Vikalp</option><option value="http://www.sportskeeda.com/author/viky-nitdgp">Vikas Kumar</option><option value="http://www.sportskeeda.com/author/vikas-madle">Vikas Madle</option><option value="http://www.sportskeeda.com/author/vikas-songara">Vikas Singh Songara</option><option value="http://www.sportskeeda.com/author/vikas1095">vikas1095</option><option value="http://www.sportskeeda.com/author/vinay-suri">Vinay Suri</option><option value="http://www.sportskeeda.com/author/vineet">Vineet</option><option value="http://www.sportskeeda.com/author/twinu89">Vineeth Mohan</option><option value="http://www.sportskeeda.com/author/therockinggunner">Vineeth S</option><option value="http://www.sportskeeda.com/author/vipinagnihotri">Vipin Agnihotri</option><option value="http://www.sportskeeda.com/author/footie34">Vipul Sarin</option><option value="http://www.sportskeeda.com/author/blasphelod">Vishaal Loganathan</option><option value="http://www.sportskeeda.com/author/abvishal">vishal</option><option value="http://www.sportskeeda.com/author/vishal13">vishal kungwani</option><option value="http://www.sportskeeda.com/author/vishalmenda">Vishal Menda</option><option value="http://www.sportskeeda.com/author/vishal768">Vishal Patel</option><option value="http://www.sportskeeda.com/author/vishal-khare">Vishal-Khare</option><option value="http://www.sportskeeda.com/author/vishal_kaushik">vishal_kaushik</option><option value="http://www.sportskeeda.com/author/vishnukumar">vishnu</option><option value="http://www.sportskeeda.com/author/vishnu-kumar">vishnu kumar</option><option value="http://www.sportskeeda.com/author/vishnu1994">vishnu1994</option><option value="http://www.sportskeeda.com/author/dongeorge10">Vishrut Aggarwal</option><option value="http://www.sportskeeda.com/author/rvivek">Vivek Ramanarayanan</option><option value="http://www.sportskeeda.com/author/vivek-taterway">vivek taterway</option><option value="http://www.sportskeeda.com/author/vivek5686">Vivekanand S Iyer</option><option value="http://www.sportskeeda.com/author/vsp">vsp</option><option value="http://www.sportskeeda.com/author/vinay">Vsu</option><option value="http://www.sportskeeda.com/author/waleed">Waleed Nour</option><option value="http://www.sportskeeda.com/author/wasilkhan">Wasil</option><option value="http://www.sportskeeda.com/author/tanay_w10">wazza</option><option value="http://www.sportskeeda.com/author/wazza10">Wazza10</option><option value="http://www.sportskeeda.com/author/web-crawler">web-crawler</option><option value="http://www.sportskeeda.com/author/welcomebackkinghenry">welcomebackkinghenry</option><option value="http://www.sportskeeda.com/author/welling886">welling886</option><option value="http://www.sportskeeda.com/author/wembley68">wembley68</option><option value="http://www.sportskeeda.com/author/wicketmaiden">Wicketmaiden</option><option value="http://www.sportskeeda.com/author/wicricnews">wicricnews</option><option value="http://www.sportskeeda.com/author/woodstock">woodstock</option><option value="http://www.sportskeeda.com/author/anandram">Working Class Idiot</option><option value="http://www.sportskeeda.com/author/worldcupnews4u">World Cup News 4u</option><option value="http://www.sportskeeda.com/author/wrensopinion">wrensopinion</option><option value="http://www.sportskeeda.com/author/wtfootball7">WTFootball</option><option value="http://www.sportskeeda.com/author/xabishabby90">xabishabby90</option><option value="http://www.sportskeeda.com/author/xdustineflx">XDustinEFLX</option><option value="http://www.sportskeeda.com/author/yagnya-valkya-misra">Yagnya Valkya Misra</option><option value="http://www.sportskeeda.com/author/yash7">yash7</option><option value="http://www.sportskeeda.com/author/yashlm10fcb">YashFCBPepLM10</option><option value="http://www.sportskeeda.com/author/amrith10">Yechh</option><option value="http://www.sportskeeda.com/author/yugam">Yugam</option><option value="http://www.sportskeeda.com/author/yuvika-sharma">Yuvika Sharma</option><option value="http://www.sportskeeda.com/author/yvsmadhav">yvsmadhav</option><option value="http://www.sportskeeda.com/author/zaid">Zaidu</option><option value="http://www.sportskeeda.com/author/zeba">zeba</option><option value="http://www.sportskeeda.com/author/zeddy">Zeddy</option><option value="http://www.sportskeeda.com/author/zenia">Zenia</option><option value="http://www.sportskeeda.com/author/zenmaster">zenmaster</option><option value="http://www.sportskeeda.com/author/arvindragunathan">Zico</option><option value="http://www.sportskeeda.com/author/zulutorres1369">Zulu</option>
													</select>
												</div>
											</div>
											<br class="clearer">
										</div>
									</div>
									<div class="middle">
										<div class="widget">
											<h2 class="gentesque">Become a SportsKeeda Writer</h2>
											<div class="line">
												&nbsp;
											</div>
											<div class="textwidget">
												<p>
													<a href="http://www.sportskeeda.com/writing-for-sportskeeda/">Write for Sportskeeda</a>
												</p>
												<p>
													<a href="http://www.sportskeeda.com/why-to-write-for-sportskeeda/">SportsKeeda Advantage</a>
												</p>
												<p>
													<a href="http://www.sportskeeda.com/internship-program/">Internship Program</a>
												</p>
												<p>
													<a href="http://www.sportskeeda.com/submit-your-blog-feed-2/">Submit your blog</a>
												</p>
												<p>
													<a href="http://www.sportskeeda.com/writer-of-the-week/">Writer of the Week</a>
												</p>
											</div>
										</div>
									</div>
									<div class="right">
										<div class="widget">
											<h2 class="gentesque">Contact</h2>
											<div class="line">
												&nbsp;
											</div>
											<div class="textwidget">
												<p>
													You can send us tips or ask any queries here contact @sportskeeda.com
												</p><p></p>
											</div>
										</div>
										<br class="clearer">
										<div class="widget">
											<div class="line">
												&nbsp;
											</div>
											<div class="textwidget"></div>
										</div>
									</div>
									<br class="clearer">
								</div>
								&nbsp; &nbsp;&nbsp;&nbsp;Certain photos copyright &copy; 2012 by Getty Images. Any commercial use or distribution without the express written consent of Getty Images is strictly prohibited.
								<div class="copyright">
									<div class="floatleft">
										<a href="http://www.sportskeeda.com/contact-us/" rel="nofollow" style="color: #888888;">Contact Us</a> | <a href="http://www.sportskeeda.com/careers/" rel="nofollow" style="color: #888888;">Careers</a> | <a href="http://www.sportskeeda.com/advertise/" rel="nofollow" style="color: #888888;">Advertise</a> | <a href="http://www.sportskeeda.com/keeda-team/" rel="nofollow" style="color: #888888;">Keeda Team</a> | <a href="http://www.sportskeeda.com/privacy-policy/" rel="nofollow" style="color: #888888;">Privacy Policy</a> | <a href="http://www.sportskeeda.com/terms-of-use/" rel="nofollow" style="color: #888888;">Terms of Use</a>
									</div>
									<div class="floatright">
										&copy;2010-2012 Absolute Sports Private Limited
									</div>
									<br class="clearer">
								</div>
							</div>
							<div class="bottom">
								&nbsp;
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Footer End -->
		</div>
		<!-- Page Container End -->
	</body>
</html>