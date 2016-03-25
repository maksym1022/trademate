<?php
include('include/header.php');
include('include/left.php');
include("include/class.php");
$obj=new admin;
$obj->conn();
?>

<!-- DOWNLOADED FROM WWW.SCRIPTGATES.COM -->
<!DOCTYPE html>
<html>
<head>

<script src="js/jquery-1.9.1.min.js"></script>

<script src="js/ajaxupload.3.5.js"></script>
</head>
<body onload="show_grp()">
<script>
/*
function replace_group(x)
{ 
var group_name=document.getElementById('grpid').value;


//var group_name=document.getElementById('groupname').value;
	
		var ajx;
		if(window.XMLHttpRequest)
		{
			ajx=new XMLHttpRequest();
		}
		else{
			ajx=new ActiveXObject("Microsoft.XMLHTTP");
		}
		ajx.onreadystatechange = function()
		{
			if(ajx.readyState==4 && ajx.status==200)
			{
				
				reply=ajx.responseText;
				
				
				
				if(x==2)
				{
				alert(reply);
				}
				show_grp();
				hide_pop();
			}
		}
			ajx.open("POST","create_grp.php?assoc_folder&group_name="+group_name+"&operation="+x,true);
			ajx.send();
}
*/
function replace_group(x)
{ 
getElementById('op').value=x;
document.getElementById("upload_group_image").submit();

}
function check_group_reply(reply)
{
	document.getElementById('loader').style.display='none';
	if(reply == 1)
	{
	show_grp();
	}
	else if(reply==2)
	{
	document.getElementById('view_user1').style.display='block';
	document.getElementById('grpid').value=groupname;
	
	show_grp();
	}
	



}
function create_grp()
{
var groupname=document.getElementById('groupname').value;
	
		
	if(groupname!='')
	{
		var ajx;
		if(window.XMLHttpRequest)
		{
			ajx=new XMLHttpRequest();
		}
		else{
			ajx=new ActiveXObject("Microsoft.XMLHTTP");
		}
		ajx.onreadystatechange = function()
		{
		
			if(ajx.readyState==4 && ajx.status==200)
			{
			var reply=ajx.responseText;
				if(reply == 1)
				{
				
	$("#upload_group_image").submit();
				
				}
				else if(reply==2)
				{
				document.getElementById('view_user1').style.display='block';
				document.getElementById('grpid').value=groupname;
				show_grp();
				}
				else
				{
				alert("Unable to create group! Try another name please!");
				}
			}
		}
			ajx.open("POST","create_grp.php?create&groupname="+groupname,true);
			ajx.send();
			
	}
	else{
	alert('Enter group name');
	
	}

}


function del_grp(str)
{
	var x=confirm('Do you really want to delete it');
	if(x)
	{

	var ajx;
	if(window.XMLHttpRequest)
	{
		ajx=new XMLHttpRequest();
	}
	else{
		ajx=new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajx.onreadystatechange = function()
	{
		if(ajx.readyState==4 && ajx.status==200)
		{
			document.getElementById('result').innerHTML=ajx.responseText;
		}
	}
		ajx.open("POST","del_grp.php?del="+str,true);
		ajx.send();
		}
}
function edit_grp(str)
{

document.getElementById('view_user').style.display='block';
document.getElementById('edit_grp').style.display='block';
	document.getElementById('grpid').value=str;
}


function save_edited_grp()
{
	var grpid=document.getElementById('grpid').value;
	var gname=document.getElementById('gname').value;
	document.getElementById('gname').value='';
	if(gname!='')
	{
		var ajx;
		if(window.XMLHttpRequest)
		{
			ajx=new XMLHttpRequest();
		}
		else{
			ajx=new ActiveXObject("Microsoft.XMLHTTP");
		}
		ajx.onreadystatechange = function()
		{
			if(ajx.readyState==4 && ajx.status==200)
			{
				
				document.getElementById('edit_grp').style.display='none';
				//	document.getElementById('result').innerHTML=ajx.responseText;
				var reply=ajx.responseText;
				hide_pop();	show_grp();
				alert(reply);
			
			}
		}
			ajx.open("POST","rename_grp.php?rename&grpid="+grpid+"&gname="+gname,true);
			ajx.send();
			
	}
	else{
		alert('Enter group name');
	}
	
}

function show_grp()
{
	
		var ajx;
		if(window.XMLHttpRequest)
		{
			ajx=new XMLHttpRequest();
		}
		else{
			ajx=new ActiveXObject("Microsoft.XMLHTTP");
		}
		ajx.onreadystatechange = function()
		{
			if(ajx.readyState==4 && ajx.status==200)
			{
				
				document.getElementById('result').innerHTML=ajx.responseText;
				
			}
		}
			ajx.open("POST","show_grp.php",true);
			ajx.send();
			
	
}

function hide_pop()
{
document.getElementById('view_user').style.display='none';
document.getElementById('view_user1').style.display='none';
document.getElementById('create_group').style.display='none';
document.getElementById('loader').style.display='none';
}

$(document).ready(function (e) {
    
$("#assoc").click(function(){
	
	document.getElementById("op").value=1;
	hide_pop();
	$("#upload_group_image").submit();
	});
$("#replace").click(function(){
	
	document.getElementById("op").value=2;
	hide_pop();
	$("#upload_group_image").submit();
	});

	
		$('#upload_group_image').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
			beforeSend:function(data)
			{
				document.getElementById('loader').style.display='block';
			},
			
            success:function(data){
                console.log("success");
				show_grp();
                check_group_reply(data);
				hide_pop();
            },
            error: function(data){
                console.log("error");
                alert(data);
            }
        });
		
    }));
	
$("#change_group").click(function(){
	$("#edit_group").submit();
	});
	
	
	$('#edit_group').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
			beforeSend:function(data)
			{
				document.getElementById('loader').style.display='block';
			},
			
            success:function(data){
                console.log("success");
				alert(data);
				show_grp();
				hide_pop();
            },
            error: function(data){
                console.log("error");
                alert(data);
            }
        });
		
    }));
	
	
	
	});
	function show_pop()
{

	document.getElementById('create_group').style.display='block';
	//document.getElementById('grpid').value=str;
}

	
</script>
<div class="mainwrapper">
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="dashboard.php"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
           <li><a href="dashboard.php">Dashboard</a> <span class="separator"></span></li>
            <li>Manage Groups</li>
        </ul>
        
        <div class="pageheader" >
        
            <div class="pagetitle">
				<h1>Existing Groups</h1>
				
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
			<div class="row-fluid">

              <a onclick='show_pop()'style='cursor:pointer;' class="btn btn-primary">Add A Group</a>            
			<div id='result'>
				  
				 
                </div>
				</div>
			<div id='create_group' class='pop' >
				<div id="wiz1step1" class="formwiz1" >
            	  <form name="upload_group_image" id="upload_group_image" action="create_grp.php" enctype="multipart/form-data">
							<p>
                            <label> Enter A Group Name:</label>
                            <span class="field"><input type='text' id='groupname' name='groupname' placeholder="Group Name" class='margin-left-form' required></span>
                        </p>
						
			  
			  
                   
                  <input type='hidden' id='op' name='operation' placeholder="Group Name" class='margin-left-form' value="3">
                  
				  <p class="stdformbutton">  
                   
				   <input type="file" id='grpimg' name="grpimg" class="btn btn-primary margin-left-form" style="width:200px;"   title="Create a New Group" required>
                   </p>
				   <p class="stdformbutton">  
                   
                   
				   <input type="button"  value="Create Group" id="upload_image" onclick="create_grp()"  name="submit" class="btn btn-primary margin-left-form"   title="Create a New Group"><input type='button' class='btn btn-primary' value='Cancel' onclick='hide_pop()'  style='margin-left:10px;'>
				</p>
					</form>
                   
				
                </div>
				</div>
			
			        
				   
                <!--row-fluid-->
				<div  id='view_user' style='border:thin solid;height:100%;width:100%;position:absolute;top:0;left:0;background:rgba(50,50,50,.3);display:none'>
						<p>
						<div id='edit_grp' class='pop'  >
							<div id="wiz1step1" class="formwiz1" >
							<form id='edit_group' method='post' action='rename_grp.php?rename' enctype="multipart/form-data" >
                        <label>Rename Group</label>
                            <span class="field">
							<input type="hidden" name="grpid" id='grpid'    class="input-large" />
								<input type="text" name="gname" id='gname' class="input-large" />
                                <input type="file" name="groupimg" id='groupimg' class="input-large" />
							</span>
                        </p>
                       	<p class="stdformbutton">
                           <input type="button" value="Save" id='change_group' class="btn btn-primary" style="margin-top:10px;" title="Submit">
						   <input type="button" value="Cancel" class="btn btn-primary" style="margin-top:10px;" title='cancel'  onclick='hide_pop()'>
						  
                        </p></form>
							</div><!--#wiz1step1-->
						</div>
					
				   </div>
                 <!-- start pop -->
				 <div  id='view_user1' style='border:thin solid;height:800px;width:100%;position:fixed;top:0;left:0;background:rgba(50,50,50,.3);display:none'>
					<div><div class='view-user-pop' style='margin-top:220px;'> 
						<div class='user-info'> 
						<span class="icon-warning-sign"></span>
						Warning
						</div>	 
						<div class='icon-remove' onclick='hide_pop()' style='cursor:pointer;position:absolute;top:10px;right:10px;'></div> 
						<div class='view-user-pop-inner' > 
							<div class="maincontentdv">			
								<h1 style='font-size:20px;font-weight:normal;margin-bottom:20px;'>Folder with this name already exist do you want to:</h1>				
							</div>
							<div class="maincontentdv">
								<input type='button' class='btn btn-primary'  id="assoc" value='Associate' style='margin-left:10px;'><input type='button' class='btn btn-primary' value='Replace' id="replace"  style='margin-left:10px;'><input type='button' class='btn btn-primary' value='Cancel' onclick='hide_pop()'  style='margin-left:10px;'>
							</div>			
						</div></div>
					</div><!-- pop ends -->
				 
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
    
</div><!--mainwrapper-->
<div id='loader' style='width:100%;height:100%;background:rgba(50,50,50,.3);position:fixed;left:0;top:0;text-align:center;display:none;'>
<img src='images/loader.gif' width='20%' style='margin:250px auto;'>

<div>
</body>
</html>
