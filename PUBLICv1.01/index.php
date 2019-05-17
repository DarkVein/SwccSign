<title>Uploading Media</title>
<body>
<link rel="stylesheet" type="text/css" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="container">
<?php
$file = 'C:\Xampp\htdocs\Php\index.php';
$bytes = readfile($file);

$target_dir = "thumbnails/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "signage";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error){
	die("Connection failed: " . $sconn->connect_error);
	}

	$submit = $_POST['submit'];
	if(isset($submit)) {
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
	//We needed to set this to 1 but didn't know how. For now we will just set it to 1 and then catch everything else in $imageFileType.....
    $uploadOk = 1;
    } else {
        $uploadOk = 1;
    }
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "mov" && $imageFileType != "mp4" && $imageFileType != "webm") {
    echo "Sorry, only webm, MOV, MP4, JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
	$Name = $_FILES["fileToUpload"]["name"];
	$Description = $_POST['Description'];
	$Position = $_POST['Position'];
	$Color = $_POST['Color'];
	$Size = $_POST['Size'];
	$ImageSize = $_POST['ImageSize'];
	$Intervals = $_POST['Intervals'];

	if($ImageSize=="video") {
	$Description='Video';
	$Position = 'Video';
	$Color = 'Video';
	}
	
	$sql = "INSERT INTO signs (Name, Description, Position, Color,Size,ImageSize,Intervals) VALUES ('$Name','$Description','$Position','$Color','$Size','$ImageSize','$Intervals')";
	
	if($conn->query($sql) === TRUE) {
	echo "<script type='text/javascript'>alert('Inquiry saved.')</script>";
	echo '<script type="text/javascript"> window.location = "http://localhost/Php/index.html"</script>';
	} else {
	echo "<script type='text/javascript'>alert('There was an error. Image not saved.')</script>";
	echo "Error";
	}
	$conn->close();
}
	}
?>

</div>
</body>
<div class="version">
Version 2.6.106, Eian / Laura / Morgan
</div>