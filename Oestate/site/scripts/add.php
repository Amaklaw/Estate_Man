<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />	
		<title>
			<?php
				header("Cache-Control: private, must-revalidate, max-age=0");
				header("Pragma: no-cache");
				header("Expires: Fri, 4 Jun 2010 12:00:00 GMT");
				$lname = @$_POST['id'];
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
			Add Item to dataBASE	</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.js"></script>
		<link href="../style/add.css" media="all" rel="stylesheet" type="text/css"/>
		<script src="../js/jquery-1.9.1.js">
		</script>
	</head>
	<body>
		<div id="floatb">
			<a href="../index.php?id=<?php echo($_POST['id']); ?>" class="button blue">Back to Main Page</a>
		</div>
		<table cellspacing='0'>
		<?php

			$table = $_POST['tab'];

			$sql = "SELECT name, text FROM columnh WHERE name LIKE  '$table.%' order by pr desc";
			$hed = @mysql_query($sql);
			$hedn;
			$i = 0;

			$sql = "INSERT INTO  `$table` (";
			$val = $val = "'";

			echo('<thead> <tr>');
			while( $row = mysql_fetch_array($hed))
			{
				echo('<th>' . $row[1] .' </th>');
				$hedn[] = substr($row[0], strpos($row[0], ".") + 1);
				if ($tval = @$_POST[$hedn[$i]])
				{
					$val .= $tval .  '\', \'';
					$sql .= $hedn[$i] . ", ";	
				}
				$i++;
			}

			echo(' </tr></thead> <tbody>');
			
			$sql = substr($sql, 0, -2);
			$val = substr($val, 0, -3);
			$sql .= ') VALUES ( ' . $val . ')';
			
			if (@mysql_query($sql))
			{
				echo('<p align=\'center\'> ' . $table . ' succesfully updated</p>');
			} else {
				echo('<p>Error adding submitted '. $table . mysql_error() . '. Please contact the administrator</p>');
			}

			$sql = "SELECT * FROM  $table order by dadd desc";
			$result = @mysql_query($sql);
			
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
		?>
		</table>

	</body>
</html>