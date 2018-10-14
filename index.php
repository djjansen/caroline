<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
paused = false;
function ajax(funct) {
	var hrs = document.getElementById("hours").innerHTML;
        var mins = document.getElementById("minutes").innerHTML;
        var secs = document.getElementById("seconds").innerHTML;
        var read = hrs+":"+mins+":"+secs;
        console.log(read);
        var status = document.getElementById(funct).innerHTML;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
console.log(xmlhttp.responseText);
            }
	    else {
	console.log(xmlhttp.status);
	    }
        };
        xmlhttp.open("GET","xm.php?q="+status+"&rdout="+read,true);
        xmlhttp.send();
}
/*
      	hours = document.getElementById("hours");
        minutes = document.getElementById("minutes");
        seconds = document.getElementById("seconds");
*/        // if less than a min
/*
function gethours() {
    // hours is minutes divided by 60, rounded down
    hrs = fetch(0,"hours");
    hrs = ("0" + hrs).slice(-2);
}
function getminutes() {
    // minutes is seconds divided by 60, rounded down
    mins = fetch(1,"minutes");
    mins = ("0" + mins).slice(-2);
}
function getseconds() {
    // take mins remaining (as seconds) away from total seconds remaining
    secs = fetch(2,"seconds");
    secs = ("0" + secs).slice(-2);
}
*/
function reset() {
console.log("Hi");
document.getElementById("hours").innerHTML="00";
document.getElementById("minutes").innerHTML="00";
document.getElementById("seconds").innerHTML="00";
document.getElementById('Pause').innerHTML="start";
ajax('Clear');
flagTimer='start';
}
function pause() {
  if (flagTimer=='start') {
    ajax('Pause');
    document.getElementById('Pause').innerHTML="pause";
    flagTimer='resume';
  } else if (flagTimer=='resume') {
    ajax('Pause');
    document.getElementById('Pause').innerHTML="resume";
    flagTimer='pause';
  }
  else
  {
    ajax('Pause');
    flagTimer='resume';
    document.getElementById('Pause').innerHTML="pause";
  }
}
function fetch(ind,ele,ind2,ele2,ind3,ele3) {
if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
           var init_request = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            var init_request = new ActiveXObject("Microsoft.XMLHTTP");
        }
init_request.onreadystatechange = function() {
if ((init_request.readyState == 4 && init_request.status >= 200 && init_request.status < 300) || (init_request.status === 0 && !!init_request.responseXML)) {
    var count = 120;
    var s = init_request.responseText.split(",");
    var r = s[0].split(":");
    var t = s[2].split(":");
    var totalHrs = 0;
    var totalMins = 0;
    var totalSecs = 0;
    totalSecs = parseInt(t[2])+parseInt(r[2]);
    if (totalSecs >= 60) {
       totalSecs = totalSecs-60;
       ++totalMins;
       }
    totalMins = totalMins+parseInt(t[1])+parseInt(r[1]);
    if (totalMins >= 60) {
       totalMins = totalMins-60;
       ++totalHrs;
       }
    totalHrs = totalHrs+parseInt(t[0])+parseInt(r[0]);
    console.log(s);
    console.log(r);
    totalHrs = ("0" + totalHrs.toString()).slice(-2);
    totalMins = ("0" + totalMins.toString()).slice(-2);
    totalSecs = ("0" + totalSecs.toString()).slice(-2);
if (s[1] == "pause") {
    document.getElementById(ele).innerHTML=t[ind];
    document.getElementById(ele2).innerHTML=t[ind2];
    document.getElementById(ele3).innerHTML=t[ind3 ];
    document.getElementById('Pause').innerHTML="resume";
    flagTimer='pause';
} else if (s[1] == "clear") {
    document.getElementById(ele).innerHTML=t[ind];
    document.getElementById(ele2).innerHTML=t[ind2];
    document.getElementById(ele3).innerHTML=t[ind3];
    document.getElementById('Pause').innerHTML="start";
    flagTimer='start';
}else {
    document.getElementById(ele).innerHTML=totalHrs;
    document.getElementById(ele2).innerHTML=totalMins;
    document.getElementById(ele3).innerHTML=totalSecs;
    document.getElementById('Pause').innerHTML="pause";
    flagTimer='resume';
}
setTimeout(fetch,1000,0,"hours",1,"minutes",2,"seconds")
}
else {
    console.log(init_request.status);
}
}
init_request.open("GET","req.php", true);
init_request.send();
}
</script>
<style>
#timer {
  font-family: 'Orbitron', sans-serif;
}
.time {
  font-family: 'Orbitron', sans-serif;
}
.btn {
  border: 2px solid black;
  background-color: white;
  color: black;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
  border-color: black;
}
</style>
</head>

<body>
<div id="widgets" style="alignment:center;text-align:center">
   <span id="title" style="font-size:3em;font-family:sans-serif">We're currently under construction!</span><br>
  <span id="subtitle" style="font-size:1.5em;font-family:sans-serif"">For now, you can use this handy timer</span><br>
  <br>
  <br><div id="timer" style="font-size: 4em; width: 16em,alignment:center">
   <span id="hours" class="time">00</span> : 
   <span id="minutes" class="time">00</span> : 
   <span id="seconds" class="time">00</span>
    </div>
    <button id="Pause" class="btn" onClick="pause();">start</button>
    <button id="Clear" class="btn" onClick="reset();">clear</button>
</div>
<script>
fetch(0,"hours",1,"minutes",2,"seconds");
</script>
</body>
</html>
 
