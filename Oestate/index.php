<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />		
		<title>Estate company managemnt system</title>
		<link rel="stylesheet" type="text/css" href="site/style/login.css">
	</head>
	

	<body id="login">

		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
				<img src="site/Images/back2.jpg" alt="Dashboard" title="" height="200" />			
			</div>
			
			<div id="login-content">
					<form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
					<?php
					//header("Cache-Control: private, must-revalidate, max-age=0");
					//header("Pragma: no-cache");

					$dbcnx = @mysql_connect('localhost', 'root', '');
							
							if (!$dbcnx) {
								die( '<p>Unable to connect to the database server at this time.</p>' );
							}
							
							if (! @mysql_select_db('estatemgt') ) {
								die( '<p>Unable to conect to users table at this time.</p>' );
							}

					if(@$_POST['submit'] == "Log out")
						{
							$uid = $_POST['id'];
							$sql = "UPDATE estatemgt.users SET  state = 0 WHERE  users.ID ='$uid'";
								if (@mysql_query($sql)) 
								{
									echo('<p> Logout succesful </p>');
								} else {
									die('<p>Error login out: ' . mysql_error() . '. Try agian later</p>');
								}

							session_start();
							session_destroy();
							
						} else {
							echo ('<p>Please Enter a username and password to Log on</p>');
						}
						if (@$_POST['submit'] == "Log on")
						{
							$uname = $_POST['name'];
							$pass = $_POST['word'];
								
							$sql = "SELECT ID FROM users WHERE name = '$uname' and word = '$pass' and state = 0";
							$result = @mysql_query($sql);
							if (mysql_num_rows($result) > 0) 
							{
								$row = mysql_fetch_array($result);
								$sql = "UPDATE estatemgt.users SET  state = 1 WHERE  users.ID ='$row[0]'";
								if (@mysql_query($sql)) 
								{
									echo('<p>' . $uname . '\'s Login succesful </p>');
								} else {
									echo('<p>Error login in ' . mysql_error() . '. You may be offline, already logged in or have entered the wrong username and password. Try agian later</p>');
								}

								session_start();
								$_SESSION['id']=$row[0];
								Header("Location: site/index.php");
							}
							echo ('<p id="lfail">Login Failed. Please try again</p>');
						}
					?>
						<p>
							<label>Username</label>
							<input value="" name="name" class="text-input" type="text" />
						</p>
						<br style="clear: both;" />
						<p>
							<label>Password</label>
							<input name="word" class="text-input" type="password" />
						</p>
						<br style="clear: both;" />
						<p>
							<input class="button" name="submit" type="submit" value="Log on" />
						</p>
					
				</form>
			</div>
		</div>
		<div id="dummy"></div>		
  </body>
</html>