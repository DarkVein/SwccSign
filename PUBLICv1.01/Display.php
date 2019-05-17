<link rel="stylesheet" type="text/css" href="display.css">
<style>
*{margin:0;}

html, body{
    height: 100%;
    overflow:hidden;
}
</style>
<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

define ('IMGDIR', 'C:\xampp\htdocs\Php\thumbnails');
define ('WEBIMGDIR', 'http://localhost/Php/thumbnails/');
$err = '';

// init slideshow class
$ss = new slideshow($err);
if (($err = $ss->init()) != '')
{
	header('HTTP/1.1 500 Internal Server Error');
	echo $err;
	exit();
}
$ss->get_images();
list($curr, $caption, $first, $prev, $next, $last) = $ss->run();

class slideshow{
	private $files_arr = NULL;
	private $err = NULL;
	
	public function __construct(&$err){
		$this->files_arr = array();
		$this->err = $err;
	}
	
	public function init(){
		if (!$this->dir_exists()){
			return 'Error retrieving images, missing directory';
		}
		return '';
	}

	public function get_images(){
		if (isset($_SESSION['imgarr'])){
			$this->files_arr = $_SESSION['imgarr'];
		} else {
			if ($dh = opendir(IMGDIR)){
				while (false !== ($file = readdir($dh))){
					if (preg_match('/^.*\.(jpg|jpeg|gif|png|mov|mp4|webm)$/i', $file)){
						$this->files_arr[] = $file;
					}
				}
				closedir($dh);
			}
			$_SESSION['imgarr'] = $this->files_arr;
		}
	}
	
	public function run(){
		$curr = 1;
		$last = count($this->files_arr);
		$GlobalSeconds=10000;
		if (isset($_GET['img'])){
			if (preg_match('/^[0-9]+$/', $_GET['img'])) $curr = (int)  $_GET['img'];
			if ($curr <= 0 || $curr > $last) $curr = 1;
		} 
		if ($curr <= 1){
			$prev = $curr;
			$next = $curr + 1;
		} else if ($curr >= $last) {
			$prev = $last - 1;
			$next = $last;
		} else {
			$prev = $curr - 1;
			$next = $curr + 1;
		}
	$caption = str_replace('-', ' ', $this->files_arr[$curr - 1]);
	$caption = str_replace('_', ' ', $caption);
	
	$connection = mysqli_connect("localhost","root","","signage"); 
    $result = mysqli_query($connection,"SELECT * FROM signs WHERE Name='$caption'");
	if($result!=null) {
    while($row = mysqli_fetch_array($result)){
	$Description = $row['Description'];
	$Color = $row['Color'];
	$Name = $row['Name'];
	$Position = $row['Position'];
	$Size = $row['Size'];
	$ImageSize = $row['ImageSize'];
	$Intervals = $row['Intervals'];
	}
	?>
	<script>
	var last = <?php echo $last ?>;
	var test = location;
	var counter = test.search.replace("?img=",'');
	var x = setInterval(function() {
	//Change the image.
	counter++;
	if (counter <= last) {
	var setto = "http://localhost/Php/Display.php?img="+counter;
	if(setto!=location) {
		window.location = setto;
	} else console.error("ERROR");
	} else if(counter >= last) {
		window.location = "http://localhost/Php/Display.php?img=1";
	} else {
	clearInterval(x);
	}
	}, <?php echo $Intervals *1000;?>);
</script>
	<?php
	if($Description=="Video") {
	echo "<video width='100%' height='100%' autoplay allowfullscreen>";
	echo "<source src='thumbnails/$Name'></source>";
	echo "</video>";
	} else {
	echo "<div class='container'>";
	echo "<div class='gallery fade'>";
	echo "<img src='thumbnails/$Name' style='$ImageSize'>";
	echo "</div>";
	if($Position!=null) {
		echo "<div class='$Position'><font color='$Color'><font size='$Size'>$Description</div></div>";
		echo "</div></div>";
	} else echo "Error!";
	}
	
	return array($this->files_arr[$curr - 1], "", 1, $prev, $next, $last);
	}
	}
	
	private function dir_exists()
	{
		return file_exists(IMGDIR);
	}
}
?>

<body>
	<div id="gallery">
        <p><?=$caption;?></p>
    </div>
</body>
<div class="version">
Version 2.6.106, Eian / Laura / Morgan
</div>
</html>
