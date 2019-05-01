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
				  $("#btn1").click(function(){
				    $("#edit").animate({margin:"0px"});
				    $("#opt").animate({margin:"-1000px"});
				  });
				  $("#eclose").click(function(){
				    $("#edit").animate({margin:"-1000px"});
				    $("#opt").animate({margin:"0px"});
				  });
			  });
		</script>
	</head>
	<body>

		<?php

			$clc = @$_POST['clc'];
			$db = $_POST['db'];
			$clcv = @$_POST['submit'];
			$ridn = $_POST['ridn'];
			$ridv = $_POST['ridv'];

			if ($clcv == "Apply")
			{
				$nval = $_POST['nval'];
				$dadd = date("Y-m-d H:i:s",time());
				$sql = "UPDATE  `estatemgt`.`$db` SET  `$clc` =  '$nval', dadd = '$dadd' WHERE  `$db`.`$ridn` ='$ridv'";
				if (@mysql_query($sql)) 
				{
					echo ("<table cellspacing='0' >");

					$sql = "SELECT name, text FROM columnh WHERE name LIKE  '$db.%' order by pr desc";
					$hed = @mysql_query($sql);
					$hedn;
					$i = 0;
								
					echo('<thead> <tr>');
					while( $row = mysql_fetch_array($hed))
					{
						$hedn[] = substr($row[0], strpos($row[0], ".") + 1);

						if($hedn[$i] == $clc)
						{
							echo('<th style="background:#ead0ec;">' . $row[1] .' </th>');
						}else{
							echo('<th>' . $row[1] .' </th>');
						}

						
						$i++;
					}

					echo(' </tr></thead> <tbody>');

					$sql = "SELECT * FROM  $db WHERE $ridn = '$ridv'";
					$result = mysql_query($sql);
					
					if (mysql_num_rows($result) > 0) 
					{
						while( $row = mysql_fetch_array($result)) {
							$i = 0;
							echo('<tr>');
							while($i < mysql_num_fields($result))
							{
								echo('<td>' .$row[$hedn[$i]]. '</td>');
								$i++;
							}
							echo('</tr>');
						}
					}
				}
				die("<H1>Edit succefull</H1>");
			}


			if(!@$_POST['submit'])
			{
				$odb = $_POST['odb'];
				$clcv = $_POST['clcv'];
				$sql = "SELECT * from relation where (prim like '$db.%' and forn like '$odb.%') or  (forn like '$db.%' and prim like '$odb.%')";
				
				if ($odb == $db)
				{
					$rsql = "Select * from $db where $db.$clc = '$clcv'";
				}else{

					$rsql = "Select * from $db, $odb where ";

					$result = mysql_query($sql);
					
					/*echo('<p>' . $sql . '</p>');*/

					if (mysql_num_rows($result) > 0) 
					{
						while( $row = mysql_fetch_array($result)) 
						{
							if($clc != $ridn)
							{
								$arr1 = explode(".", $row[0]);
								$arr = explode(".", $row[1]);
								if ($arr1[0] == $odb)
								{
									$rsql .= $row[0] . " IN (select " .$db . "." .$arr[1] . " from ". $arr[0]. "  where " .$clc . " = '" . $clcv. "' ) and ";
									
								}else
								{
									$rsql .= $row[1] . " IN (select " .$db . "." .$arr1[1] . " from ". $arr1[0]. "  where " .$clc . " = '" . $clcv. "' ) and ";									
								}
																
							}else{

							$rsql .= $row[0] . ' = ' . $row[1] . ' and ';
							}
						}
					}					
						$rsql .= " $db.$clc = '$clcv'";
					
				}					

					echo ("<table cellspacing='0' >");

					$sql = "SELECT name, text FROM columnh WHERE name LIKE  '$db.%' or name like '$odb.%' order by pr desc";
					$hed = @mysql_query($sql);

					/*echo('<p>' . $sql . '</p>');*/

					$hedn;
					$i = 0;
								
					echo('<thead> <tr>');
					while( $row = mysql_fetch_array($hed))
					{
						$hedn[] = substr($row[0], strpos($row[0], ".") + 1);

						if($hedn[$i] == $clc)
						{
							echo('<th style="background:#ead0ec;">' . $row[1] .' </th>');
						}else{
							echo('<th>' . $row[1] .' </th>');
						}

						
						$i++;
					}

					echo(' </tr></thead> <tbody>');

					$result = mysql_query($rsql);
					
					if (@mysql_num_rows($result) > 0) 
					{
						while( $row = mysql_fetch_array($result)) {
							$i = 0;
							echo('<tr>');
							while($i < mysql_num_fields($result))
							{
								echo('<td>' .$row[$hedn[$i]]. '</td>');
								$i++;
							}
							echo('</tr>');
						}
					}

				die('</tbody></table>');

			}

		?>

		<div style="position:fixed;top:10%;width:60%;left:20%;height:80%;" class="opts" id="opt">
			<table cellspacing='0' style="width:70%;height:120%;margin-left:15%;margin-top:-50px;">
				<tr><td>

		<?php

			echo('<input type="button" value="Edit" name="clc" id="btn1" style="border: 0;background: #fafafa;height:100%;width:100%;"/>
				</td></tr>
				<tr><td>
				<h1>Search Through</h1>
				</td></tr>
				<tr><td>
					<form action="'. $_SERVER['PHP_SELF']. '" method="POST" enctype="multipart/form-data" style="background: #fafafa;height:100%;width:100%;">
						<input type="submit" value="Customers" name="submi" style="border: 0;background: #fafafa;height:100%;width:100%;"/>
						<input type = "hidden" name="odb" value="customers"/>
						<input type = "hidden" name="clc" value="'. $clc . '"/>
						<input type = "hidden" name="db" value="'. $db . '"/>
						<input type = "hidden" name="ridn" value="'. $ridn . '"/>
						<input type = "hidden" name="ridv" value="'. $ridv . '"/>
						<input type = "hidden" name="clcv" value="'. $clcv . '"/>
					</form>
				</td></tr>
				<tr><td>
					<form action="'. $_SERVER['PHP_SELF']. '" method="POST" enctype="multipart/form-data" style="background: #fafafa;height:100%;width:100%;">
						<input type="submit" value="Applications" name="submi" style="border: 0;background: #fafafa;height:100%;width:100%;"/>
						<input type = "hidden" name="odb" value="applications"/>
						<input type = "hidden" name="clc" value="'. $clc . '"/>
						<input type = "hidden" name="db" value="'. $db . '"/>
						<input type = "hidden" name="ridn" value="'. $ridn . '"/>
						<input type = "hidden" name="ridv" value="'. $ridv . '"/>
						<input type = "hidden" name="clcv" value="'. $clcv . '"/>
					</form>
				</td></tr>
				<tr><td>
					<form action="'. $_SERVER['PHP_SELF']. '" method="POST" enctype="multipart/form-data" style="background: #fafafa;height:100%;width:100%;">
						<input type="submit" value="Properties" name="submi" style="border: 0;background: #fafafa;height:100%;width:100%;"/>
						<input type = "hidden" name="odb" value="properties"/>
						<input type = "hidden" name="clc" value="'. $clc . '"/>
						<input type = "hidden" name="db" value="'. $db . '"/>
						<input type = "hidden" name="ridn" value="'. $ridn . '"/>
						<input type = "hidden" name="ridv" value="'. $ridv . '"/>
						<input type = "hidden" name="clcv" value="'. $clcv . '"/>
						</form>
				</td></tr>
				<tr><td>
					<form action="'. $_SERVER['PHP_SELF']. '" method="POST" enctype="multipart/form-data" style="background: #fafafa;height:100%;width:100%;">
						<input type="submit" value="Agents" name="submi" style="border: 0;background: #fafafa;height:100%;width:100%;"/>
						<input type = "hidden" name="odb" value="agents"/>
						<input type = "hidden" name="clc" value="'. $clc . '"/>
						<input type = "hidden" name="db" value="'. $db . '"/>
						<input type = "hidden" name="ridn" value="'. $ridn . '"/>
						<input type = "hidden" name="ridv" value="'. $ridv . '"/>
						<input type = "hidden" name="clcv" value="'. $clcv . '"/>
					</form>
				</td></tr>');
			/*			$sql = "SELECT name, text FROM columnh WHERE name LIKE  '$db.%' order by pr desc";*/
			/*$hed = @mysql_query($sql);*/

		?>
		</table>
		</div>

		<div style="position:fixed;top:20%;width:30%;left:35%;height:40%;margin:-1000px;" class="opts" id="edit">
			<input type = "button" value="X" id="eclose" style="float:right;">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
				<table cellspacing='0' style="width:100%;height:100%;margin:0px;">
					<tr><td>
						<?php
						echo('<input type="text" name="nval" value="' . $clcv .'" style="width:100%;height:100%;"/>');
						?>
					</td></tr>
					<tr><td>
						<input type="submit" value="Apply" name="submit" style="width:100%;"/>
					</td></tr>
				</table>
				<?php

				/*echo("Column clicked is " .$clc . " with a value of " . $clcv . " for the " .$db . " database. with the unique row iditifier of " . $ridn . " , with a value of " . $ridv );*/

				echo('<input type = "hidden" name="clc" value="'. $clc . '"/>');
				echo('<input type = "hidden" name="db" value="'. $db . '"/>');
				echo('<input type = "hidden" name="ridn" value="'. $ridn . '"/>');
				echo('<input type = "hidden" name="ridv" value="'. $ridv . '"/>');
				
				?>

			</form>
		</div>
	</body>
</html>
