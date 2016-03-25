<?php
	include('include/header.php');
	include('include/left.php');
?>
<html>
<head>
<!--<link rel="stylesheet" href="css/android-app.css">-->

<?php
include("include/class.php");
$obj = new admin;
$obj->conn();
?>
</head>
<style>
.expire {
	background: rgb(169,3,41); /* Old browsers */
    /* IE9 SVG, needs conditional override of 'filter' to 'none' */
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2E5MDMyOSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjQ0JSIgc3RvcC1jb2xvcj0iIzhmMDIyMiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiM2ZDAwMTkiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
    background: -moz-linear-gradient(top,  rgba(169,3,41,1) 0%, rgba(143,2,34,1) 44%, rgba(109,0,25,1) 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(169,3,41,1)), color-stop(44%,rgba(143,2,34,1)), color-stop(100%,rgba(109,0,25,1))); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  rgba(169,3,41,1) 0%,rgba(143,2,34,1) 44%,rgba(109,0,25,1) 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  rgba(169,3,41,1) 0%,rgba(143,2,34,1) 44%,rgba(109,0,25,1) 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  rgba(169,3,41,1) 0%,rgba(143,2,34,1) 44%,rgba(109,0,25,1) 100%); /* IE10+ */
    background: linear-gradient(to bottom,  rgba(169,3,41,1) 0%,rgba(143,2,34,1) 44%,rgba(109,0,25,1) 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a90329', endColorstr='#6d0019',GradientType=0 ); /* IE6-8 */
}
.expire td {
	color:#fff;
}
.expireon {
	background: rgb(254,187,187); /* Old browsers */
    /* IE9 SVG, needs conditional override of 'filter' to 'none' */
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZlYmJiYiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjQ1JSIgc3RvcC1jb2xvcj0iI2ZlOTA5MCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmZjVjNWMiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
    background: -moz-linear-gradient(top,  rgba(254,187,187,1) 0%, rgba(254,144,144,1) 45%, rgba(255,92,92,1) 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(254,187,187,1)), color-stop(45%,rgba(254,144,144,1)), color-stop(100%,rgba(255,92,92,1))); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  rgba(254,187,187,1) 0%,rgba(254,144,144,1) 45%,rgba(255,92,92,1) 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  rgba(254,187,187,1) 0%,rgba(254,144,144,1) 45%,rgba(255,92,92,1) 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  rgba(254,187,187,1) 0%,rgba(254,144,144,1) 45%,rgba(255,92,92,1) 100%); /* IE10+ */
    background: linear-gradient(to bottom,  rgba(254,187,187,1) 0%,rgba(254,144,144,1) 45%,rgba(255,92,92,1) 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#febbbb', endColorstr='#ff5c5c',GradientType=0 ); /* IE6-8 */
}
.paid {
	background: #bfd255; /* Old browsers */
    background: -moz-linear-gradient(top,  #bfd255 0%, #8eb92a 50%, #72aa00 51%, #9ecb2d 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#bfd255), color-stop(50%,#8eb92a), color-stop(51%,#72aa00), color-stop(100%,#9ecb2d)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* IE10+ */
    background: linear-gradient(to bottom,  #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bfd255', endColorstr='#9ecb2d',GradientType=0 ); /* IE6-9 */
    font-weight:600;
}
</style>
<script>

var str2;	
///code2
function pagination(start) {
    document.getElementById('loader').style.display = 'block';
	//alert(start);
	var ajx;
	if(window.XMLHttpRequest)
	{
		ajx = new XMLHttpRequest();
	}
	else {
		ajx = new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajx.onreadystatechange = function()
	{
		if(ajx.readyState == 4 && ajx.status == 200)
		{
			//alert(ajx.responseText);
			document.getElementById('result').innerHTML = ajx.responseText;
            document.getElementById('loader').style.display = 'none';
		}
	}
	ajx.open("POST", "pagination.php?start=" + start, true);
	ajx.send();
}
function pagination_search(start, uname, email, stat) {
    document.getElementById('loader').style.display = 'block';

	var ajx;
	//alert(stat);
	if(window.XMLHttpRequest)
	{
		ajx = new XMLHttpRequest();
	}
	else {
		ajx = new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajx.onreadystatechange = function()
	{
		if(ajx.readyState == 4 && ajx.status == 200)
		{
//			console.log(ajx.responseText);
			document.getElementById('result').innerHTML = ajx.responseText;
            document.getElementById('loader').style.display = 'none';
		}
	}
	ajx.open("POST","pagination.php?sstart=" + start + "&uname=" + uname + "&email=" + email + "&status1=" + stat, true);
	ajx.send();
}

function sortuser(order, uname, email, stat) {
    document.getElementById('loader').style.display = 'block';
	//alert("sdg");
	//alert(order);
	var ajx;
	if(window.XMLHttpRequest)
	{
		ajx = new XMLHttpRequest();
	}
	else {
		ajx = new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajx.onreadystatechange = function()
	{
		if(ajx.readyState == 4 && ajx.status == 200)
		{
			//alert(ajx.responseText);
			document.getElementById('result').innerHTML = ajx.responseText;
			document.getElementById('loader').style.display = 'none';
		}
	}
	ajx.open("POST","sort.php?o=" + order + "&uname=" + uname + "&email=" + email + "&status1=" + stat, true);
	ajx.send();
}

function searchuser() {
    document.getElementById('loader').style.display = 'block';
	var uname = document.searchu.uname.value;
	var email = document.searchu.email.value;
	
	var status = $('#status').val();
	document.searchu.uname.value = '';
	document.searchu.email.value = '';
	document.searchu.status.value = '';
	var ajx;
	if(window.XMLHttpRequest)
	{
		ajx = new XMLHttpRequest();
	}
	else {
		ajx = new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajx.onreadystatechange = function()
	{
		if(ajx.readyState == 4 && ajx.status == 200)
		{
			//alert(ajx.responseText);
			document.getElementById('result').innerHTML = ajx.responseText;
		    document.getElementById('loader').style.display = 'none';
		}
	}
	ajx.open("POST", "search_user.php?uname=" + uname + "&email=" + email + "&status=" + status, true);
	ajx.send();
}

function export_users() {
    $.post(
        "export_users.php",
        {
            
        }
    ).done(
        function(data) {
            console.log(data);
            window.location = "users.xlsx";
        }
    );
}

///code2 ends
function hide_pop() {
    document.getElementById('view_user').style.display = 'none';
    document.getElementById('edit_pwd').style.display = 'none';
}

function del_user(str, uname, email, stat) {
	var x = confirm('Do You realy want to Delete this record?');
	if(x)
	{
	    //alert(str);
        var ajx;
        if(window.XMLHttpRequest)
        {
	        ajx = new XMLHttpRequest();
        }
        else {
	        ajx = new ActiveXObject("Microsoft.XMLHTTP");
        }
        ajx.onreadystatechange = function()
        {
	        if(ajx.readyState == 4 && ajx.status == 200)
	        {
		        document.getElementById('result').innerHTML = ajx.responseText;
	        }
        }
	    ajx.open("POST", "del_users.php?del=" + str + "&uname=" + uname + "&email=" + email + "&status1=" + stat, true);
	    ajx.send();
	}
}

function change_status(str, uname, email, stat) {
	var ajx;
	//alert(stat);
	if(window.XMLHttpRequest)
	{
		ajx = new XMLHttpRequest();
	}
	else {
		ajx = new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajx.onreadystatechange = function()
	{
		if(ajx.readyState == 4 && ajx.status == 200)
		{
			//alert(ajx.responseText);
			document.getElementById('result').innerHTML = ajx.responseText;
		}
	}
	ajx.open("POST", "change_status.php?status=" + str + "&uname=" + uname + "&email=" + email + "&status1=" + stat, true);
	ajx.send();
}

function view_user(str) {
    var ajx;
    document.getElementById('view_user').style.display = 'block';
	//alert(str);
	if(window.XMLHttpRequest)
	{
		ajx = new XMLHttpRequest();
	}
	else {
		ajx = new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajx.onreadystatechange = function()
	{
		if(ajx.readyState == 4 && ajx.status == 200)
		{
			document.getElementById('view_user').innerHTML = ajx.responseText;
		}
	}
	ajx.open("POST", "view_user.php?userid=" + str, true);
	ajx.send();
}

function edit_pwd(str, uname, email, status) {
    var ajx;
    if(window.XMLHttpRequest)
	{
		ajx = new XMLHttpRequest();
	}
	else {
		ajx = new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajx.onreadystatechange = function()
	{
		if(ajx.readyState == 4 && ajx.status == 200)
		{
			document.getElementById('edit_pwd').style.display = 'block';
			document.getElementById('edit_pwd').innerHTML = ajx.responseText;
		}
	}
	ajx.open("POST", "action.php?edit_user_id=" + str, true);
	ajx.send();
	document.getElementById('userid').value = str;
	document.getElementById('uname').value = uname;
	document.getElementById('email').value = email;
	document.getElementById('status3').value = status;
}

function save_edited_pwd() {
	var userid = document.getElementById('userid').value;
	var pwd = document.getElementById('pwd').value;
	var uname = document.getElementById('uname').value;
	var email = document.getElementById('email').value;
	var status3 = document.getElementById('status3').value;
	
	var status = $('#status1').val();
	
	document.getElementById('userid').value = '';
	document.getElementById('uname').value = '';
	document.getElementById('email').value = '';
	document.getElementById('status3').value = '';
	document.getElementById('pwd').value = '';
	//alert(userid+" -"+uname+" -"+email+" -"+ status3+" - "+pwd);
	if( pwd != '')
	{
		var ajx;
		if(window.XMLHttpRequest)
		{
			ajx = new XMLHttpRequest();
		}
		else {
			ajx = new ActiveXObject("Microsoft.XMLHTTP");
		}
		ajx.onreadystatechange = function()
		{
			if(ajx.readyState == 4 && ajx.status == 200)
			{
				document.getElementById('edit_pwd').style.display = 'none';
				document.getElementById('result').innerHTML = ajx.responseText;
				//alert(ajx.responseText);
			}
		}
		ajx.open("POST", "updateStatus.php?edit_password&userid=" + userid + "&pwd=" + pwd + "&status=" + status + "&uname=" + uname + "&email=" + email + "&status3=" + status3, true);
		ajx.send();
	}
	else {
	    alert('Password Does Not Matched');
	}
}
</script>
<body>
<div class="mainwrapper">
    <div class="rightpanel">
        <ul class="breadcrumbs">
            <li><a href="dashboard.php"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="dashboard.php">Dashboard</a> <span class="separator"></span></li>
            <li>Manage Users</li>
        </ul>
        <div class="pageheader" >
            <div class="pagetitle">
				<h1>Detail of Users</h1>
            </div>
        </div><!--pageheader-->
        <div class="maincontent">
            <div class="maincontentinner">
			  <form name="searchu">
                   <input class="input-large" type='text' name='uname' id='uname' placeholder="USERNAME" >
                   <input class="input-large margin-left-form" type='text' id='email' name='email' placeholder="Email ID">
                   <select name='status' id='status' class='margin-left-form' >
                        <option value=''>Status</option>
					    <option value='0'>Trial</option>
					    <option value='1'>Unpaid</option>
					    <option value='2'>Paid</option>
					    <option value='3'>Blocked </option>
                   </select>
                   <input type='button' class="btn btn-primary margin-left-form" onClick="searchuser()" value='Search User'>
                   <input type="button" class="btn btn-primary margin-left-form" onclick="export_users()" value="Export To Excel" />
               </form>
               <div class="row-fluid">
                   <div id='result' class='margin-top-form'>
				   <?php
				
				 /* if(isset($_REQUEST['start']) && (isset($_REQUEST['username']) || isset($_REQUEST['email']) || 
				  isset($_REQUEST['status']) || isset($_REQUEST['address'])))
				  {
				 
					$uname = $_REQUEST['username'];
					$email = $_REQUEST['email'];
					$status = $_REQUEST['status'];
					$address = $_REQUEST['address'];
					$obj->start = $_REQUEST['start'];
					}
					else
					{
					
					$obj->start = $_REQUEST['start'];

					}*/
					$obj->search_users('', '', '', '');
				
					if(isset($_REQUEST['update']))
					{
						$obj->update_info();
					}
				   ?>
                </div><!--row-fluid-->
				<div id='view_user' style='border:thin solid;height:800px;width:100%;position:fixed;top:0;left:0;background:rgba(50,50,50,.3);display:none'>
				</div>
                <div id='edit_pwd' class='pop'  >
		        </div>
            </div><!--maincontentinner-->
        </div><!--maincontent-->
    </div><!--rightpanel-->
</div><!--mainwrapper-->
<div id='loader' style='width:100%;height:100%;background:rgba(50,50,50,.3);position:fixed;left:0;top:0;text-align:center;display:none;'>
<img src='images/loader.gif' width='20%' style='margin:250px auto;'>
<div>
</body>
</html>
