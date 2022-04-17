<?PHP require 'test.php';?>

<html>
	<head>
		<title>Tabl</title>
		<script src='script.js'></script>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body onload='initialize();'>
		<div class='header'>
			<h1>Page Header</h1>
			<input class='topButton' type='button' value='Notifications' onclick='clickNotifications();'>
			<input class='topButton' type='button' value='Settings' onclick='clickSettings();'>
		</div>
		<div class='page'>
			<div class='navbar'>
				<input class='navbutton' type='button' value='Projects' onclick='clickProjects();'>
				<div class='navlist' id='projectsButtons'></div>
				<input class='navbutton' type='button' value='Messaging' onclick='clickMessages();'>
				<div class='navlist' id='messagesButtons'></div>
			</div>
			<div class='content' id='contentpane'>
				<p> <?PHP echo $test ?></p>
			</div>
			<div class='clear'><!-- --></div>
		</div>
	</body>
</html>
