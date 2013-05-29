<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Remote-Control Arduino Car</title>
    <meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Language" content="en-us" />
    <style type="text/css">
        div#control div{
            display: inline-block;
            position: relative;
        }
        div#buttons{
            top: -120px;
        }
		div#descr{
			font-size:16px;
			line-height:1.4;
		}
		a{
			font-weight:bold;
		}
		body{
			text-align:center;
			font-size:18px;
			font-family:sans-serif;
			background-color:#F0E6EB;
		}
		button,select{
			font-size:16px;
		}
		span#end{
			font-weight:bold;
			line-height:2;
		}
		#loading{
			position:absolute;
			top:60px;
			right:75px;
			display:none;
		}
    </style>
    <script type="text/javascript">
        window.onload = function() {
            setInterval(updateTaskList, 400);
        }
        function addTask(rmotor,lmotor,dur){
			document.getElementById("loading").style.display="inline";
            if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else{ // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.open("GET","add_task.php?lmotor="+lmotor+"&rmotor="+rmotor+"&dur="+dur,true);
            xmlhttp.send();
        }
        
        function updateTaskList(){
            if (window.XMLHttpRequest){ // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else{ // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("loading").style.display="none";
                    //Parse tasks separated by commas into option tags
                    var taskList = xmlhttp.responseText;
                    var taskArray = taskList.split(",");
                    var selectHTML = "";
                    for(var i=0; i<taskArray.length; i++){
                        selectHTML = selectHTML + "<option>"+(i+1)+". "+taskArray[i]+"</option>\n";
                    }
                    //Place tasks surrounded by option tags into select box
                    document.getElementById("tasklist").innerHTML=selectHTML;
                }
            }
            xmlhttp.open("GET","tasks_to_webpage.php",true);
            xmlhttp.send();
        }
    </script>
</head>

<body onmouseup="updateMotors(0,0)">
<h2>Remote-Controlled Arduino Car</h2>

<div id="control">
	<div id="buttons">
		<button onmousedown="addTask(255,255,2000)">Forward</button>
		<button onmousedown="addTask(-255,-255,2000)">Backward</button>
		<br />
		<button onmousedown="addTask(255,-255,1500)">Left</button>
		<button onmousedown="addTask(-255,255,1500)">Right</button>
		<br />
		<span id="loading">
			<img src="loading.gif" />
		</span>
	</div>
	<div id="tasklist_container">
		Tasks:<br />
		<select multiple id="tasklist" style="width:140px; height: 180px;">
			<option>Please wait...</option>
		</select>
	</div>
</div>
<div id="descr">
	<p>
		The Arduino looks <a href="/riley/arduino/livecar/v2/tasks_to_arduino.php">here</a> for tasks and deletes them when completed.<br />
		Instructions are given in the form L-motor:R-motor:Duration.<br />
		<a href="../livestream_car.pde">This script</a> written in Processing is run on a laptop connected to<br />
		the Arduino which feeds these instructions to the robot.<br />
		<span id="end">The end result is a car that you can drive on the web!</span>
	</p>
</div>
</body>
</html>

