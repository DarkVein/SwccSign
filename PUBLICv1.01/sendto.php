<!DOCTYPE html>
<html>
<title>Unlinking the image.</title>
<body>

<link rel="stylesheet" type="text/css" href="sytle.css">
<div class="container">
<?php
$file = 'C:\Xampp\htdocs\Php\delete.php';
$bytes = readfile($file);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signage";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
	die("Connection failed: " . $sconn->connect_error);
}
$submit = $_POST['submit'];
$Name = $_POST['Name'];

if(isset($_POST['Name']) && $_POST['Name'] == $Name){
	$sql = "DELETE FROM `signs` WHERE `Name`='$Name'";
	if($conn->query($sql) === TRUE) {
	unlink('thumbnails/'."$Name");
	echo("Successfully deleted "."$Name");
	echo '<script type="text/javascript"> alert("Successfully deleted "."$Name");</script>';
	} else {
   echo "Error!";
	}
	$conn->close();
} else{
  echo "Error Image not found.";
}
?>
</div>
</body>
</html>