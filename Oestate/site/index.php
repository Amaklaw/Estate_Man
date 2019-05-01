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
		<script src="js/jquery-1.9.1.js">
		</script>
		<script>
			$(document).ready(function()
			  {
			  	$(".getid").click(function(){
			    $("#gid").animate({margin:"0px"});
			    $("#sbar").animate({margin:"-1000px"});
			  });
			  
			  $("#btn3").click(function(){
			  	$("#gid").animate({margin:"-1000px"});
			  	$("#sbar").animate({margin:" 0px"});
			  });
			});
		</script>
		
	</head>
	<body>
	<!-- Main -->
		<div id="top">
			<div style="position: fixed; right: 15%; left: 15%; top: 20px; z-index: 3;" id="sbar">
			<form id="search-form" action="scripts/search.php" method="POST" enctype="multipart/form-data">
			Select Index to Search with:
			<fieldset>
				<select name="col" id="selec">
				<?php
					$sql = "SELECT columnh.* FROM columnh order by text";
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
					<input type="text" name="search" placeholder="Type Keyword Here"/>
					<a href="#" onClick="document.getElementById('search-form').submit()">Search</a>									
				</div>
				</fieldset>
			</form>
			</div>
			<br/>
			<br/>
			<br/>
			<div id="floatb">
				<form method="POST" action="../index.php" enctype="multipart/form-data">
					<input type="hidden" value="<?php echo($lname) ?>" name="id">
					<input type="submit" value="Log out" name="submit" class="button red large" onClick="btntest_onclick()">
				</form>
			</div>
			<div style="position: fixed; right: 10px; bottom: 10px;">
				<a href="#top" id="back-top" class="button yellow" style="text-decoration: none;font-size: 40pt;">/|\</a>
			</div>
			<div id="main" class="container">

				<div class="row">

					<div class="12u">
						
						<!-- Highlight -->
							<section class="is-highlight">
								<ul class="special">
									<li><a href="#appl" class="battery"><br/><br/>Add Application</a></li>
									<li><a href="#propr" class="tablet"><br/><br/>Add Properties</a></li>
									<li><a href="#addcust" class="flask"><br/><br/>Add customer</a></li>
									<li><a href="#agt" class="chart"><br/><br/>Add Agent</a></li>
								</ul>
								<header>
									<h2>Add and Edit Records here</h2>
									<span class="byline">You can also search for data here.</span>
								</header>
								<!-- <p>

								</p> -->
							</section>
						<!-- /Highlight -->

					</div>
				</div>

				<div class="row">
					<div class="12u">

						<!-- Features -->
							<section class="is-features">
								<h2 class="major" id="propr"><span>Add A Property</span></h2>
								<div>
									<div class="row">
										<!-- Feature -->
											<section class="is-feature">
												<form action="scripts/add.php" method="POST" enctype="multipart/form-data">
													<input type="hidden" name="tab" value="properties">
													<table align = "center" id="pt">
														<tr>
															<td>Property name:</td>
															<td><input type="text" name="name" placeholder="Enter Property Name here" size="100%"/></td>
														</tr>
														<tr>
															<td>Geo Location:</td>
															<td><input type="text" name="geo" placeholder="Please enter Geo Location here" size="100%"/></td>
														</tr>
														<tr>
															<td>Owner ID:</td>
															<td><input type="text" name="ownid" placeholder="Please Enter the Owner ID number here" size="90%"/><input type="button" Value="Get ID" class="button blue getid" style="float:right; padding: 2px 0px"/> </td>
														</tr>
														<tr>
															<td>House Number:</td>
															<td><input type="text" name="hnum" placeholder="Please enter the house number if available here" size="100%"/></td>
														</tr>
														<tr>
															<td>Street number:</td>
															<td><input type="text" name="snum" placeholder="Please enter the street number if avilable here" size="100%"/></td>
														</tr>
														<tr>
															<td>Town:</td>
															<td><input type="text" name="town" placeholder="Enter Town in which property is located here" size="100%"/></td>
														</tr>
													</table>
													<input type="hidden" name="id" value="<?php echo($lname) ?>">

													<p>Any other comments or description of the property</p>
													<textarea name="pcomm" rows = "10" cols = "100"></textarea>
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

				<div class="row">
					<div class="12u">

						<!-- Features -->
							<section class="is-features">
								<h2 class="major" id="appl"><span>Add An Application</span></h2>
								<div>
									<div class="row">
										<!-- Feature -->
											<section class="is-feature">
												<form action="scripts/add.php" method="POST" enctype="multipart/form-data">
													<input type="hidden" name="tab" value="applications">
													<table align = "center" id="pt">
														<tr>
															<td>Application type:</td>
															<td><input type="text" name="apptype" placeholder="Please enter the name of the type of application" size="100%"/></td>
														</tr>
														<tr>
															<td>Date of Application:</td>
															<td><input type="date" name="appdate" placeholder="Please date of issuance of application" size="100%"/></td>
														</tr>
														<tr>
															<td>Date of receipt of application:</td>
															<td><input type="date" name="subdate" placeholder="Please enter the date of submission here" size="100%"/></td>
														</tr>
														<tr>
															<td>Applicant ID:</td>
															<td><input type="text" name="ownid" placeholder="Please Enter the Applicant ID here" size="80%"/><input type="button" Value="Get ID" class="button blue getid" style="float:right; padding: 2px 0px"/></td>
														</tr>
														<tr>
															<td>Geo Location:</td>
															<td><input type="text" name="geo" placeholder="Please enter Geo location of the property involved" size="100%"/></td>
														</tr>
														<tr>
															<td>Recieving agent ID:</td>
															<td><input type="text" name="rcagid" placeholder="Please enter the Id of the recieving agent" size="100%"/></td>
														</tr>
														<tr>
															<td>Review agent ID:</td>
															<td><input type="text" name="rvagid" placeholder="Enter the Id of review agenthere" size="100%"/></td>
														</tr>
													</table>

													<p>Any other comments or information</p>
													<textarea name="aob" rows = "10" cols = "100"></textarea>
													<p><input type = "reset" class="button red" value="RESET"> 
													<input type="submit" name="submit" class="button green" value="ADD" style="float: right"></p>
													<input type="hidden" name="id" value="<?php echo($lname) ?>">
												</form>
												
											</section>
										<!-- /Feature -->
								
									</div>
								</div>
							</section>
						</div>
					</div>
			
					<div class="row">
						<div class="12u">

							<!-- Features -->
								<section class="is-features">
									<h2 class="major" id="addcust"><span>Add A customer</span></h2>
										<div>
											<div class="row">
											<!-- Feature -->
												<section class="is-feature">
													<form action="scripts/add.php" method="POST" enctype="multipart/form-data">
														<input type="hidden" name="tab" value="customers">
														<table width="70%" align = "center" id="pt">
															<tr>
																<td>Name:</td>
																<td><input type="text" name="cname" placeholder="Please enter the customers name here" size="100%"/></td>
															</tr>
															<tr>
																<td>Age</td>
																<td><input type="text" name="cage" placeholder="Please enter Customers Age here" size="100%"/></td>
															</tr>
															<tr>
																<td>Phone number:</td>
																<td><input type="text" name="cphnum" placeholder="Please enter the phone number of the customer here" size="100%"/></td>
															</tr>
															<tr>
																<td>E-mail:</td>
																<td><input type="text" name="cemail" placeholder="Please Enter the Customers email address here" size="100%"/> </td>
															</tr>
															<tr>
																<td>Address:</td>
																<td><input type="text" name="caddrs" placeholder="Please enter the address of customer here" size="100%"/></td>
															</tr>
															<tr>
																<td>Occupation:</td>
																<td><input type="text" name="occ" placeholder="Please enter the Occupation of the customer here" size="100%"/></td>
															</tr>
															
														</table>
														<input type="hidden" name="id" value="<?php echo($lname) ?>">

														<p>Any other comments or information about customer</p>
														<textarea name="ccomm" rows = "10" cols = "100"></textarea>
														<p><input type = "reset" class="button red" value="RESET"> 
														<input type="submit" name="submit" class="button green" value="ADD" style="float: right"></p>
													</form>
													
												</section>
											</div>
										</div>
										
								</section>
							</div>
						</section>
					</div>
					<div id="main" class="container">
						<div class="row">
								<div class="12u">

									<!-- Features -->
										<section class="is-features">
											<h2 class="major" id="agt"><span>Add An Agent</span></h2>
											<div>
												<div class="row">
													<!-- Feature -->
														<section class="is-feature">
														<form action="scripts/add.php" method="POST" enctype="multipart/form-data">
															<table align = "center" id="pt">
																<tr>
																	<td>Name:</td>
																	<td><input type="text" name="name" placeholder="Please enter the agent's name here" size="100%"/></td>
																</tr>
																<tr>
																	<td>Age</td>
																	<td><input type="text" name="age" placeholder="Please enter agent's Age here" size="100%"/></td>
																</tr>
																<tr>
																	<td>Phone number:</td>
																	<td><input type="text" name="pnum" placeholder="Please enter the phone number of the agent here" size="100%"/></td>
																</tr>
																<tr>
																	<td>E-mail:</td>
																	<td><input type="text" name="email" placeholder="Please Enter the email address of the agent here" size="100%"/> </td>
																</tr>
																<tr>
																	<td>Department:</td>
																	<td><input type="text" name="depar" placeholder="Please enter the address of customer here" size="100%"/></td>
																</tr>
																<tr>
																	<td>Job tile:</td>
																	<td><input type="text" name="jobtitle" placeholder="Please enter the Job title of the agent here" size="100%"/></td>
																</tr>
																<tr>
																	<td>Date of Hire:</td>
																	<td><input type="date" name="dhire" placeholder="Please enter the date of hire here" size="100%"/></td>
																</tr>
															</table>

															<p>Job description and any other comments or information about agent</p>
															<textarea name="comm" rows = "10" cols = "100"></textarea>
															<p><input type = "reset" class="button red" value="RESET"> 
															<input type="submit" name="submit" class="button green" value="ADD" style="float: right"></p>
															<input type="hidden" name="id" value="<?php echo($lname) ?>">
															<input type="hidden" name="tab" value="agents">
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
			</div>
		</div>
	<div id="gid" style="margin:-1000px;background: #fff;">
		<input type="button" value="X" name="close" id="btn3" class="div-close" onclick='document.getElementById("flf").src="customer.php?id=<?php echo($lname); ?>";'/>
		<br/>
			<iframe src="customer.php?id=<?php echo($lname); ?>" height="100%" width="100%" border="0" align="middle" frameborder="0" scrolling="yes" id="flf"></frame>
	</div>
	</body>
</html>