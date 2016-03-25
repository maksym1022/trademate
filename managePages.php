<?php
	   include('include/class.php');
	   include('include/header.php');
	   include('include/left.php');
	   $obj = new admin;
		$obj->conn();
	   ?><html>
	<head>
		<!--<link rel="stylesheet" href="css/android-app.css">-->
		<script type="text/javascript" src='js/tinymce/tinymce.min.js'></script>
		<script>
		tinymce.init({selector: "textarea" });
			function hide_pop()
			{
				document.getElementById('editPage').style.zIndex='1';
				document.getElementById('viewPages').checked=true;
			}
			
			function show_create_page()
			{
				document.getElementById('editPage');
				}
			function editPage(pageid)
			{
				//alert(pageid);
				
				var ajx;
				if(window.XMLHttpRequest)
				{
					ajx=new XMLHttpRequest();
				}
				else
				{
					ajx=new ActiveXObject("Microsoft.XMLHTTP");
				}
				ajx.onreadystatechange = function()
				{
					if(ajx.readyState==4 && ajx.status==200)
					{
						document.getElementById('editPage').innerHTML=ajx.responseText;
						document.getElementById('editPage').style.zIndex='3';
						document.getElementById('editTab').checked=true;
						//alert(ajx.responseText);
						tinymce.init({selector: "textarea" });
						
					}
				}
					ajx.open("POST","action.php?editPage="+pageid,true);
					ajx.send();
			}
			
			function update_page()
			{
				var pageId=document.edit_page.pid.value;
				var pageName=document.edit_page.name.value;
				var pageDesc=tinyMCE.activeEditor.getContent();
				
				
				if(pageName!="" && pageDesc!="" )
				{
				var ajx;
				if(window.XMLHttpRequest)
				{
					ajx=new XMLHttpRequest();
				}
				else
				{
					ajx=new ActiveXObject("Microsoft.XMLHTTP");
				}
				ajx.onreadystatechange = function()
				{
					if(ajx.readyState==4 && ajx.status==200)
					{
						document.getElementById('view_pages').innerHTML=ajx.responseText;
						//alert(ajx.responseText);
						hide_pop();
					}
				}
					ajx.open("POST","action.php?updatePage="+pageId+"&pageName="+pageName+"&pageDesc="+pageDesc,true);
					ajx.send();
					}
				
			}
			
			</script>
	</head>
	<body>
	<div class="mainwrapper">
		
	  
		<div class="rightpanel">
			
			<ul class="breadcrumbs">
            <li><a href="dashboard.php"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="dashboard.php">Dashboard</a> <span class="separator"></span></li>
            <li> Manage Pages</li>
        </ul>
			
			<div class="pageheader">
			   
				<div class="pagetitle">
					<h1>My Pages</h1>
					
					
					
				</div>
			</div><!--pageheader-->
		   
			
			
			<div class="maincontent">
				<div class="maincontentinner">
                
					<div class="row-fluid" id='row-fluid'>
						<div class='tabs'>
						
							<div class='tab'> 
								<input type="radio" id='viewPages' name='tab' checked>
								<label for='viewPages' onclick='hide_pop()'>View Pages</label>
								<div class='content' id='view_pages'>
								 <?php 
									 $obj->fetch_pages();
									 ?>
								</div>
							</div>
							
							<div class='tab'> 
								<input type="radio" id='editTab' name='tab'>
								<label for='editTab' id='editCreate'>Edit Pages</label>
								 <div class='content' id='editPage'>
								 
								 </div><!-- 2 content ends-->
							</div><!-- Tab ends -->
							
						</div>
                    
					</div><!--row-fluid-->
					
					
					
				</div><!--maincontentinner-->
			</div><!--rightpanel-->
		</div><!--mainwrapper-->
	</div>
	</body>
</html>
