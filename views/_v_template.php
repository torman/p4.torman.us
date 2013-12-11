<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	

	<link rel="stylesheet" type="text/css" href="/css/profile.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<!--body onload=calOnLoad();-->	
<body>	
		<div id='menu'>

			<a href='/' title="home">Home</a>&nbsp;&nbsp;

			<!-- Menu for users who are logged in -->
			<?php if($user) { ?>
				<a href='/users/family_data_edit' title="update family data for BBQ" id='update'>UPDATE</a>&nbsp;&nbsp;
				<?php if ($user->role == 1) { ?>
					<a href='/admin/admin' title="admin">Admin</a>&nbsp;&nbsp;
				<?php } ?>	
				<a href='/users/logout' title="logout" id='menu_last_item'>Logout</a>
	 
			<?php } ?>
		</div>
 
    <br>
	
	<?php if(isset($message)) echo "<div class=\"sys_message\"> ** $message </div>"; ?>

	<?php if(isset($content)) echo $content; ?>

	<?php if(isset($client_files_body)) echo $client_files_body; ?>
</body>
</html>
