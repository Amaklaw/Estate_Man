<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />	
		<title>
			<?php
				session_start();
				$lname = $_SESSION['id'];
				header("Cache-Control: private, must-revalidate, max-age=0");
				header("Pragma: no-cache");
								
				$sql = "SELECT users.Name FROM users WHERE users.ID='$lname' and users.state = '1'";
				$dbcnx = @mysql_connect('localhost', 'root', '');
				if (! @mysql_select_db('estatemgt') ) {
					die( '<p>Unable to conect to users table at this time.</p>' );
				}
				if (!$dbcnx) {
				die( '<p>Unable to connect to the database server at this time.</p>' );
				}
				$result = @mysql_query($sql);
				if (mysql_num_rows($result) > 0) 
				{
					$row = mysql_fetch_array($result);
					echo('Welcome ' .$row[0]);
				} else {
					die('Please log in Properly');
				}
			?>
		</title>
		<link rel="stylesheet" type="text/css" href="style/index.css"/>
		<link href="../style/add.css" media="all" rel="stylesheet" type="text/css"/>
		<script src="../js/jquery-1.9.1.js">
		</script>
		<script>
			$(document).ready(function()
			  {
				  $(".dbitm").click(function(){
				    $("#frm").animate({opacity:'0.95',margin:"0px"});
				  });
				  $("#btn3").click(function(){
				    $("#frm").animate({margin:"-1000px"});
				   });
			  });
		</script>
	</head>
	<body>

		<div id="floatb">

			<a href="<?php 
			if($hm = @$_POST['home']){
				$_SERVER["HTTP_REFERER"] = $hm;
			}
			echo($_SERVER["HTTP_REFERER"]);
			?>" class="button blue">Back to Main Page</a>
		</div>
		<table cellspacing='0' >
		<?php

			$clc = $_POST['col'];
			$db = substr($clc, 0, strpos($clc, "."));
			$cl = substr($clc, strpos($clc, ".") + 1);
			$st = $_POST['search'];

			$sql = "SELECT name, text FROM columnh WHERE name LIKE  '$db.%' order by pr desc";
			$hed = @mysql_query($sql);
			$hedn;
			$i = 0;
						
			echo('<thead> <tr>');
			while( $row = mysql_fetch_array($hed))
			{
				$hedn[] = substr($row[0], strpos($row[0], ".") + 1);

				if($hedn[$i] == $cl)
				{
					echo('<th style="background:#ead0ec;">' . $row[1] .' </th>');
				}else{
					echo('<th>' . $row[1] .' </th>');
				}

				
				$i++;
			}

			echo(' </tr></thead> <tbody>');

			$sql = "SELECT * FROM  $db WHERE $cl LIKE '%$st%'";
			$result = mysql_query($sql);
			
			if (mysql_num_rows($result) > 0) 
			{
				while( $row = mysql_fetch_array($result)) {
					$i = 0;
					echo('<tr>');
					while($i < mysql_num_fields($result))
					{
						echo('<td> <form action="opt.php" method="POST" enctype="multipart/form-data" target="ifrm" style="background: #fafafa;height:100%;width:100%;">
							<input type="submit" name="submit" value="' .$row[$hedn[$i]]. '" class = "dbitm" > 
							<input type="hidden" name="clc" value="' . $hedn[$i] . '"/>');

						echo('<input type="hidden" name="ridn" value="' . $hedn[0] . '"/>
							<input type="hidden" name="db" value="' . $db .'"/>
							<input type="hidden" name="ridv" value="' .  $row[$hedn[0]] .'"/>
							<input type="hidden" name="id" value="' .  $lname .'"/>
							</form>
						</td>');
						
						$i++;
					}
					
					echo('</tr>');
				}
			}
		
			
		?>
		</tbody></table>
		<div style="position:fixed;top:15%;width:80%;left:10%;height:80%;margin:-1000px; background: url(../images/page-background.png) repeat!important; color: #444;" id="frm">
			<input type="button" value="X" style="float:right;" name="close" id="btn3"/>
			<br/>
			<iframe height="100%" width="100%" border="0" align="middle" frameborder="0" scrolling="yes" name="ifrm" id="ifrm"></frame>
		</div>
	</body>
</html>
