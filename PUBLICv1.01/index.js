<script>
  function openInNewTab(url) {
  var win = window.open(url, '_blank');
  win.focus();
	}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$('input').keypress(function(e) {
    if (e.which == 13) {
        $(this).next('input').focus();
        e.preventDefault();
    }
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

var Source;
//This script allows the upload of an image and a preview of that image.
var imageLoader = document.getElementById('fileToUpload');
    imageLoader.addEventListener('change', handleImage, false);

function handleImage(e) {
    var reader = new FileReader();
    reader.onload = function (event) {
		Source=event.target.result;
        $('.uploader img').attr('src',event.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
}

</script>
<script>

var myWindow;

function openWin() {
myWindow = window.open("LiveDemo.html?"+ImageSize+"@"+FontSize+"@"+FontColor+"@"+FontPosition+"@"+Caption+"@"+Source, "", 'fullscreen=yes');
}

var output = document.getElementById("Output");
//Live Demo Command Divs
var livedemo = document.getElementById("LiveDemoWindow");
var otherdiv = document.getElementById("Collapseable");
//Demo Preview Div
var demoimage = document.getElementById("DemoImage");

//Image Size
var size = document.getElementById("ImageSize");
//Position
var position = document.getElementById("Position");
//Color
var color = document.getElementById("Color");
//Text
var text = document.getElementById("text");
//we neeed the double declaration, 1 for live 1 for generic
var slider = document.getElementById("Size");

//Live Demo Scripts
function CollapseWindow() {
if(otherdiv.style.display === "none") {
	otherdiv.style.display = "block";
} else {
    otherdiv.style.display = "none";
}
}

function Open() {
livedemo.style.display = "block";
}

function Exit() {
livedemo.style.display = "none";
}

var ImageSize = size.value;
var FontPosition = position.value;
var FontColor = color.value;
var FontSize = slider.value;
var Caption = text.value;
Update();
window.setInterval(function(){
  Update();
}, 2500);

function Update() {
if(Source) {
 demoimage.innerHTML = "<div class='container'><img src="+Source+" style="+ImageSize+"/>" + "<font size="+FontSize+"><font color="+FontColor+"><div class="+FontPosition+">" +Caption+"</font></font></div></div>";
 }
}

text.oninput = function() {
Caption = this.value;
}
//Image Size
size.oninput = function() {
ImageSize = this.value;
}
//Position
position.oninput = function() {
FontPosition = this.value;
}
//Color picker
color.oninput = function() {
  FontColor = this.value;
}

//Text size
slider.oninput = function() {
 output.innerHTML = this.value;
 FontSize = this.value;
}

</script>

<script>
function fade(evt, action) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(action).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>

<script>
//Make the DIV element draggagle:
dragElement(document.getElementById(("LiveDemoWindow")));

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById("LiveDemoHeader")) {
    /* if present, the header is where you move the DIV from:*/
    document.getElementById("LiveDemoHeader").onmousedown = dragMouseDown;
  } else {
    /* otherwise, move the DIV from anywhere inside the DIV:*/
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    /* stop moving when mouse button is released:*/
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
</script>