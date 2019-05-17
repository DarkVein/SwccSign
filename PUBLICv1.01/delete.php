<link rel="stylesheet" type="text/css" href="delete.css">
<body>
<title>Slideshow Preview</title>
<div class="topright">
<img src="Images/logo.png" width="193" height="77"></img>
</div>

<div class="tab">
  <button class="tablinks" onclick="window.location.href='index.html'">Link Information</button>
  <button class="tablinks" onclick="window.location.href='Display.php'">Display Webpage</button>
  <button class="tablinks" onclick="window.location.href='delete.php'">Preview Images And Captions</button>
</div>

<?php
define ('IMGDIR', 'C:\xampp\htdocs\Php\thumbnails');
define ('WEBIMGDIR', 'http://localhost/Php/thumbnails/');
$err = '';
$ss = new slideshow($err);
if (($err = $ss->init()) != ''){
	header('HTTP/1.1 500 Internal Server Error');
	echo $err;
	exit();
}
$ss->get_images();
list($curr, $caption, $first, $prev, $next, $last) = $ss->run();
class slideshow {
	private $files_arr = NULL;
	private $err = NULL;
	public function __construct(&$err){
		$this->files_arr = array();
		$this->err = $err;
	}
	public function init(){

		if (!$this->dir_exists())
		{
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
					if (preg_match('/^.*\.(jpg|jpeg|gif|png)$/i', $file)){
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
		if (isset($_GET['img'])){
			if (preg_match('/^[0-9]+$/', $_GET['img'])) $curr = (int)  $_GET['img'];
			if ($curr <= 0 || $curr > $last) $curr = 1;
		}
		if ($curr <= 1) {
			$prev = $curr;
			$next = $curr + 1;
		} else if ($curr >= $last) {
			$prev = $last - 1;
			$next = $last;
		} else {
			$prev = $curr - 1;
			$next = $curr + 1;
		}
	$IMG = array();
	$CAP = array();
	$FORMAT = array();
	$caption = str_replace('-', ' ', $this->files_arr[$curr - 1]);
	$caption = str_replace('_', ' ', $caption);
	//foreach ($this->files_arr as $value) {
	$connection = mysqli_connect("localhost","root","","signage");
    $result = mysqli_query($connection,"SELECT * FROM signs WHERE 1");
    while($row = mysqli_fetch_array($result)){
	$Description = $row['Description'];
	$Color = $row['Color'];
	$Name = $row['Name'];//
	$Position = $row['Position'];
	$Size = $row['Size'];
	$ImageSize = $row['ImageSize'];//
	array_push($IMG,[$Name, $ImageSize],[$ImageSize,$Name]);
	array_push($FORMAT,[$Position, $Color],[$Color,$Position]);
	array_push($CAP,[$Description, $Size],[$Size,$Description]);
	}
$Counter=0;
//$a Is $Name and $b is $ImageSize

foreach ($IMG as list($a,$b)) {
	if($a==null) {
	} else {
	if($b=="video") {
	echo "<div class='container'>";
	echo "<video controls>";
	echo "<source src='thumbnails/$a'></source>";
	echo "</video>";
	echo "<form action='sendto.php' method='POST'>";
	echo "<input type='checkbox' id='Delete' name='Name' value=$a></input>";
	echo "<label for='Delete'>Delete Video?</label>";
	echo "<div id=$Counter></div></div>";
	} else {
	if (in_array($a, $this->files_arr)) {
	$Counter=$Counter+1;
	echo "<div class='container'><img src='thumbnails/$a' style='$b'>";
	echo "<form action='sendto.php' method='POST'>";
	echo "<input type='checkbox' id='Delete' name='Name' value=$a></input>";
	echo "<label for='Delete'>Delete Image?</label>";
	echo "<div id=$Counter></div>";
	echo "</div>";
	}
	}
	}
}
	$Counter2=0;
	foreach ($FORMAT as list($a,$b)) {
	foreach ($CAP as list ($c,$d)) {
	$Counter2=$Counter2+1;
	//$A is Position $b is color $c is text size $d is description
	//echo "<div class='container'><img src='thumbnails/$value' style='$ImageSize'>";
	//echo "<div class='$Position'><label>(*$Position*)</label><font color='$Color'><font size='$Size'>$Description</font></font></div>";
	if($Counter2<=$last) {
	echo "<div class=$b><label>(*$b*)</label><font color=$a><font size=$c>$d</font></font></div></div>";
	}
	}
	}
	?>
	
	</div>
	</div>
	<div class="Collapseable">
	<input type="submit" value="Delete Images" name="submit" onClick="Send();"></input>
	<input type="reset" value="Undo Selections" name="reset"></input>
	</form>
	<div class="version">
	Version 2.6.106, Eian / Laura / Morgan
	</div>
	</div>
	<?php
	return array($this->files_arr[$curr - 1], "", 1, $prev, $next, $last);
	}
	
	private function dir_exists(){
		return file_exists(IMGDIR);
	}
}
?>
<script>

for(i=1; i<=<?php echo $last; ?>; i++) {
x = i + "";
document.getElementById(x+"").innerHTML = <?php echo $; ?>;
}

function Send() {
window.location = "http://localhost/Php/delete.php";
}
</script>
</form>
</div>
</body>

</html>