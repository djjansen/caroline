<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script type="text/javascript">
paused = false;
flagTimer='start';
function ajax(funct) {
		var hrs = document.getElementById("hours").innerHTML;
        var mins = document.getElementById("minutes").innerHTML;
        var secs = document.getElementById("seconds").innerHTML;
        var read = hrs+":"+mins+":"+secs;
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
        }
        xmlhttp.open("GET","xm.php?q="+status+"&rdout="+read,true);
        xmlhttp.send();
}
function OvrUnd(funct) {
if (funct == 'Clear') {
	document.getElementById("ovrundrhours").innerHTML = "--";
	document.getElementById("ovrundrminutes").innerHTML = "--";
	document.getElementById("ovrundrseconds").innerHTML = "--";
}
var ouHrs = document.getElementById("ovrundrhours").innerHTML;
var ouMins = document.getElementById("ovrundrminutes").innerHTML;
var ouSecs = document.getElementById("ovrundrseconds").innerHTML;
var ouString = ouHrs+":"+ouMins+":"+ouSecs;

var hrs = document.getElementById("hours").innerHTML;
var mins = document.getElementById("minutes").innerHTML;
var secs = document.getElementById("seconds").innerHTML;
var read = hrs+":"+mins+":"+secs;

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
}
xmlhttp.open("GET","OverUnder.php?ovund="+ouString+"&rdout="+read+"&funct="+funct,true);
xmlhttp.send();
}

function vote(selection) {
document.getElementById("bets").style.display="none";
document.getElementById("charts").style.display="block";
OvrUnd(selection);
chart.data.datasets[0].data=[UnderCount];
chart.data.datasets[1].data=[OverCount];
chart.update();
}

function reset() {
document.getElementById("hours").innerHTML="00";
document.getElementById("minutes").innerHTML="00";
document.getElementById("seconds").innerHTML="00";
document.getElementById('Pause').innerHTML="start";
ajax('Clear');
flagTimer='start';
OvrUnd('Clear');
document.getElementById("charts").style.display="none";
document.getElementById("bets").style.display="none";
}
function pause() {
  if (flagTimer=='start') {
  	var overunder_init = 240 + ((Math.floor((Math.random() * 10) + 1))*60);
	var ou_hrs_init = Math.floor(overunder_init / 3600);
	var ou_mins_init = Math.floor((overunder_init % 3600) / 60);
	var ou_secs_init = Math.floor(overunder_init % 60);	
	ou_hrs_init = ("0" + ou_hrs_init.toString()).slice(-2);
    ou_mins_init = ("0" + ou_mins_init.toString()).slice(-2);
    ou_secs_init = ("0" + ou_secs_init.toString()).slice(-2);
    document.getElementById("ovrundrhours").innerHTML = ou_hrs_init;
	document.getElementById("ovrundrminutes").innerHTML = ou_mins_init;
	document.getElementById("ovrundrseconds").innerHTML = ou_secs_init;
	OvrUnd();
    ajax('Pause');
    document.getElementById('Pause').innerHTML="pause";
    flagTimer='resume';
    document.getElementById("bets").style.display="block";
  }  else if (flagTimer=='resume') {
    ajax('Pause');
    document.getElementById('Pause').innerHTML="resume";
    flagTimer='pause';
  }
  else {
    ajax('Pause');
    flagTimer='resume';
    document.getElementById('Pause').innerHTML="pause";
  }
}

var OverCount = 0;
var UnderCount = 0;

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
	console.log(init_request.responseText);
    var s = init_request.responseText.split(",");
    var r = s[0].split(":");
    var t = s[2].split(":");
    var o = s[3].split(":");
    OverCount = s[4];
    UnderCount = s[5];
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
    totalHrs = ("0" + totalHrs.toString()).slice(-2);
    totalMins = ("0" + totalMins.toString()).slice(-2);
    totalSecs = ("0" + totalSecs.toString()).slice(-2);
if (s[1] == "pause") {
    totalHrs=t[ind];
    totalMins=t[ind2];
    totalSecs=t[ind3];
    document.getElementById('Pause').innerHTML="resume";
    flagTimer='pause';
} else if (s[1] == "clear") {
    totalHrs=t[ind];
    totalMins=t[ind2];
    totalSecs=t[ind3];
    document.getElementById('Pause').innerHTML="start";
    flagTimer='start';
}else {
    document.getElementById('Pause').innerHTML="pause";
    flagTimer='resume';
}
document.getElementById(ele).innerHTML=totalHrs;
document.getElementById(ele2).innerHTML=totalMins;
document.getElementById(ele3).innerHTML=totalSecs;

var ou_hours = totalHrs;
var ou_minutes = totalMins;
var ou_seconds = totalSecs;
var rawTime = parseInt(ou_seconds) + (parseInt(ou_minutes) * 60) + (parseInt(ou_hours * 3600));
if ((rawTime % 60 == 0) && (rawTime > 60) && (document.getElementById('Pause').innerHTML=="pause")) {
	var overunder = 240 + rawTime + ((Math.floor((Math.random() * 10) + 1))*60);
	ou_hrs = Math.floor(overunder / 3600);
	ou_mins = Math.floor((overunder % 3600) / 60);
	ou_secs = Math.floor(overunder % 60);
	
	ou_hrs = ("0" + ou_hrs.toString()).slice(-2);
    ou_mins = ("0" + ou_mins.toString()).slice(-2);
    ou_secs = ("0" + ou_secs.toString()).slice(-2);
} else {
	ou_hrs = o[0];
	ou_mins = o[1];
	ou_secs = o[2];
}
document.getElementById("ovrundrhours").innerHTML = ou_hrs;
document.getElementById("ovrundrminutes").innerHTML = ou_mins;
document.getElementById("ovrundrseconds").innerHTML = ou_secs;

if ((rawTime % 60 == 0) && (rawTime > 60) && (document.getElementById('Pause').innerHTML=="pause")) {
	    OvrUnd('Minute');
}

chart.data.datasets[0].data=[UnderCount];
chart.data.datasets[1].data=[OverCount];
chart.update();

setTimeout(fetch,1000,0,"hours",1,"minutes",2,"seconds")
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
#Over {
  border: none;
  background-color: white;
  font-size:4em;
   cursor: pointer;
}
#Under {
  border: none;
  background-color: white;
  font-size:4em;
   cursor: pointer;
}
</style>
</head>

<body>
<div id="widgets" style="alignment:center;text-align:center">
   <span id="title" style="font-size:3em;font-family:sans-serif">We're currently under construction!</span><br>
  <span id="subtitle" style="font-size:1.5em;font-family:sans-serif">For now, you can use this handy timer</span><br>
  <br>
  <br><div id="timer" style="font-size: 4em; width: 16em,alignment:center">
   <span id="hours" class="time">00</span> : 
   <span id="minutes" class="time">00</span> : 
   <span id="seconds" class="time">00</span>
    </div>
    <button id="Pause" class="btn" onClick="pause();">start</button>
    <button id="Clear" class="btn" onClick="reset();">clear</button>
</div>
<br>
<div id="ovrundr" style="font-size: 2em; width: 16em,alignment:center;text-align:center">
over/under<br>
   <span id="ovrundrhours" class="time">--</span> : 
   <span id="ovrundrminutes" class="time">--</span> : 
   <span id="ovrundrseconds" class="time">--</span>
   <br>
</div>
<div id="bets" style="text-align:center;display:none">
   <button id="Over" class="btn" onClick="vote('Over');">+</button><span style="font-size:4em">/</span>   
   <button id="Under" class="btn" onClick="vote('Under');">-</button>
</div>
<div id="charts" style="display:none;text-align:center;margin:auto;height:25vh; width:50vw">
<canvas id="myChart" style="display:inline"></canvas>
</div>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: ["Over / Under"],
        datasets: [{
            label: "Under",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [0],
        },
        {
            label: "Over",
            backgroundColor: 'rgb(255, 165, 0)',
            borderColor: 'rgb(255, 165, 0)',
            data: [0],
        }]
    },

    // Configuration options go here
    options: {
    	scales: {
            yAxes: [{
                ticks: {
                    suggestedMin: 0,
                    suggestedMax: 10
                }
            }]
        }
    }
});
</script>
<script>
fetch(0,"hours",1,"minutes",2,"seconds");
</script>
</body>
</html>
 
