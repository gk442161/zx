<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<?php
    include 'mysql_login.php';

    $conn=new mysqli($hostname,$username,$password,$database);
	if($conn->connect_error) die($conn->connect_error);
	session_start();
	?>
</head>
<body>
	<div class="text">
	<label>Signup as a Doctor</label>
	<br><br>
	</div>
	<div class="info">
		<form action="Dsigning_up_detail.php" method="POST">
            <label>Username:</label>
			<p><?php echo $_SESSION['username']?></p><br><br>
			<label>Address:</label><br>
            <textarea rows="4" cols="50"></textarea>
			<br><br>
			<label>Phone Number</label>
			<input type="Phone" name="Phone">
			<br><br>
			<input type="Submit" name="submit" value="SUBMIT">

		</form>

</body>
</html>

