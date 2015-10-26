<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "cartoonza", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
<?php
if(isset($_POST['submit'])){
		$oldpass = trim($_POST['oldpass']);
		$newpass = trim($_POST['newpass']);
		$conpass = trim($_POST['conpass']);
		
		$id=$_SESSION['ID'];
		$query = "SELECT * FROM LOGIN WHERE id ='$id' and password='$oldpass'";
		//echo $query;
		//echo $newpass." ".$conpass;
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		
		if($row && $conpass == $newpass){
			$query = "UPDATE LOGIN SET password = '$newpass' WHERE id ='$id'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			header( "location: MemberPage.php" );
		}
		else {
			echo "fail";
		}
}
?>


<form action='changepass.php' method='post'>
	old password <br>
	<input name='oldpass' type='input'><br>
	new Password<br>
	<input name='newpass' type='password'><br><br>
    confirm <br>
	<input name='conpass' type='input'><br>
	<input name='submit' type='submit' value='Login'>
    
	
</form>



</body>
</html>