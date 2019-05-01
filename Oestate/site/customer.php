<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />	
		<title>
			<?php
			header("Cache-Control: private, must-revalidate, max-age=0");
			header("Pragma: no-cache");
			header("Expires: Fri, 4 Jun 2010 12:00:00 GMT");
				$lname = @$_GET['id'];
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
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.js"></script>
		<link rel="stylesheet" type="text/css" href="style/index.css">
	</head>
	<body style="background: #fff;">
		<div id="main-wrapper">
			<form id="search-form" action="scripts/search.php" method="POST" enctype="multipart/form-data" style="background:#fff;">
				<input type="hidden" name="id" value="<?php echo($lname) ?>">
			Select Index to Search with:
			<fieldset>
				<select name="col" id="selec">
				<?php
					$dbcnx = @mysql_connect('localhost', 'root', '');
					if (! @mysql_select_db('estatemgt') ) {
						die( '<p>Unable to conect to users table at this time.</p>' );
					}
					if (!$dbcnx) {
					die( '<p>Unable to connect to the database server at this time.</p>' );
					}
					$sql = "SELECT columnh.* FROM columnh where name like 'customers.%'";
					$result = @mysql_query($sql);
					if ($result) {
						while( $row = mysql_fetch_array($result)) {
							echo ('<option value="' .$row[name] . '" > ' .$row[text] . '</option>');
						}
					} else {
						die('Error contacting database');
					}						
				?>
				</select>
				<div class="search-form">					
					<input type="text" name="search" placeholder="Type Keyword Here" style="width:86%;"/>
					<a href="#" onClick="document.getElementById('search-form').submit()">Search</a>									
				</div>
				</fieldset>
			</form>
			<div id="main" class="container">
					<div class="row">
						<div class="12u">

							<!-- Features -->
								<section class="is-features">
									<div>
										<div class="row">
											<!-- Feature -->
												<section class="is-feature">
													<form action="scripts/add.php" method="POST" enctype="multipart/form-data">
														<input type="hidden" name="tab" value="customers">
														<table width="70%" align = "center" id="pt">
															<tr>
																<td>Name:</td>
																<td><input type="text" name="cname" placeholder="Please enter the customers name here" size="70%"/></td>
															</tr>
															<tr>
																<td>Age</td>
																<td><input type="text" name="cage" placeholder="Please enter Customers Age here" size="70%"/></td>
															</tr>
															<tr>
																<td>Phone number:</td>
																<td><input type="text" name="cphnum" placeholder="Please enter the phone number of the customer here" size="70%"/></td>
															</tr>
															<tr>
																<td>E-mail:</td>
																<td><input type="text" name="cemail" placeholder="Please Enter the Customers email address here" size="70%"/> </td>
															</tr>
															<tr>
																<td>Address:</td>
																<td><input type="text" name="caddrs" placeholder="Please enter the address of customer here" size="70%"/></td>
															</tr>
															<tr>
																<td>Occupation:</td>
																<td><input type="text" name="occ" placeholder="Please enter the Occupation of the customer here" size="70%"/></td>
															</tr>
															
														</table>
														<input type="hidden" name="id" value="<?php echo($lname) ?>">

														<p>Any other comments or information about customer</p>
														<textarea name="ccomm" rows = "10" cols = "70"></textarea>
														<p><input type = "reset" class="button red" value="RESET"> 
														<input type="submit" name="submit" class="button green" value="ADD" style="float: right"></p>
													</form>
												</section>
											<!-- /Feature -->
									
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			</div>
	</body>
</html>
