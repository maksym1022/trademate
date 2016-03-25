<?php
   include('include/header.php');
   include('include/left.php');
   include("include/class.php");

$obj = new admin;
$obj->conn();
?>
    
<!DOCTYPE html>
<html>
	<head>
<!--	<script src="js/jquery-1.9.1.min.js"></script>-->
    <script src="js/ajaxupload.3.5.js"></script>
<!--    <script src="jquery-ui-1.9.2.min.js"></script>-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<!--    <script src="js/jquery.timepicker.js"></script>-->
<!--    <link rel="stylesheet" href="css/jquery.timepicker.css">-->
   <!-- <link rel="stylesheet" href="css/android-app.css">-->
<script>

function show_products()
{
		document.getElementById('loader').style.display='block';
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
				document.getElementById('loader').style.display='none';
			}
		}
			ajx.open("POST","show_products.php",true);
			ajx.send();
}



function submit_edit_product()
{
	var group_id=document.getElementById('group_id1').value;
	var id=document.getElementById('id1').value;
	var desc=document.getElementById('desc1').value;
	var product_app_name=document.getElementById('product_app_name1').value;
    var product_symbol = document.getElementById('product_symbol1').value;
	var product_xl_name=document.getElementById('product_xl_name1').value;
	hide_pop();
		
	document.getElementById('desc1').value="";
	document.getElementById('id1').value="";
	document.getElementById('product_app_name1').value="";
    document.getElementById('product_symbol1').value = "";
	document.getElementById('product_xl_name1').value="";
		
	if(group_id!="" && desc!="" && product_app_name!="" && product_xl_name!="" && product_symbol != "")
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
				if(reply==1)
				{
				show_products();
				}
				else if(reply==2)
				{
				document.getElementById('view_user1').style.display='block';
				}
			    else
			    {
		            alert(reply);
		        }
			}
		}
		ajx.open("POST","create_product.php?edit&group_id="+group_id+"&desc="+desc+"&product_app_name="+product_app_name+"&product_xl_name="+product_xl_name+"&id="+id + "&product_symbol=" + product_symbol, true);
		ajx.send();
	}
    else
    {
        alert("Please, Enter all the values!");
    }
		
}

function update_predictions() {
    var id = document.getElementById('id1').value;
    var desc = document.getElementById('desc1').value;
    var product_app_name = document.getElementById('product_app_name1').value;
    var product_symbol = document.getElementById('product_symbol1').value;
    var product_xl_name = document.getElementById('product_xl_name1').value;

    hide_pop();
        
    document.getElementById('desc1').value="";
    document.getElementById('id1').value="";
    document.getElementById('product_app_name1').value="";
    document.getElementById('product_symbol1').value = "";
    document.getElementById('product_xl_name1').value="";
    
    if(group_id!="" && desc!="" && product_app_name!="" && product_xl_name!="" && product_symbol != "")
    {
        var ajx;

        if(window.XMLHttpRequest)
        {
            ajx = new XMLHttpRequest();
        }
        else{
            ajx = new ActiveXObject("Microsoft.XMLHTTP");
        }
        ajx.onreadystatechange = function()
        {
            if(ajx.readyState == 4 && ajx.status == 200)
            {
                var reply = ajx.responseText;
                
                if(reply == 1)
                {
                    show_products();
                }
                else if(reply == 2)
                {
                    document.getElementById('view_user1').style.display = 'block';
                }
                else
                {
                    alert(reply);
                    location.reload();
                }
            }
        }
        ajx.open("POST", "update_predictions.php?desc=" + desc + "&product_app_name=" + product_app_name + "&product_xl_name=" + product_xl_name + "&id=" + id + "&product_symbol=" + product_symbol, true);
        ajx.send();
    }
    else
    {
        alert("Please, Enter all the values!");
    }    
}


function submit_product()
{
	var group_id = document.getElementById('group_id').value;
	var desc = document.getElementById('desc').value;
    var product_symbol_name = document.getElementById('product_symbol_name').value;
//    var startdate = document.getElementById('startdate').value;
//    var enddate = document.getElementById('enddate').value;
//    var starttime = document.getElementById('starttime').value;
//    var endtime = document.getElementById('endtime').value;
	var product_app_name = document.getElementById('product_app_name').value;
	var product_xl_name = document.getElementById('product_xl_name').value;
	/*
	document.getElementById('desc').value="";
	document.getElementById('product_app_name').value="";
	document.getElementById('product_xl_name').value="";
	*/
	
//    if(group_id != "" && desc != "" && product_app_name != "" && product_xl_name != "" && product_symbol_name != "" && startdate != "" && enddate != "" && starttime != "" && endtime != "")
//    if(group_id != "" && desc != "" && product_app_name != "" && product_xl_name != "" && product_symbol_name != "" && starttime != "" && endtime != "")
	if(group_id != "" && desc != "" && product_app_name != "" && product_xl_name != "" && product_symbol_name != "")
	{
        hide_pop();
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
				var reply = ajx.responseText;
				if(reply == 1)
				{
				    $("#product_uplod").submit();
				}
				else if(reply == 2)
				{
				    document.getElementById('view_user1').style.display = 'block';
				}
			    else
			    {
		            alert("Product with same name already exists under this group! Try with another name!");
		        }
			}
		}
        ajx.open("POST", "create_product.php?create&group_id=" + group_id + "&desc=" + desc + "&product_app_name=" + product_app_name + "&product_xl_name=" + product_xl_name + "&product_symbol_name=" + product_symbol_name, true);
//        ajx.open("POST", "create_product.php?create&group_id=" + group_id + "&desc=" + desc + "&product_app_name=" + product_app_name + "&product_xl_name=" + product_xl_name + "&product_symbol_name=" + product_symbol_name + "&starttime=" + starttime + "&endtime=" + endtime, true);
//		ajx.open("POST", "create_product.php?create&group_id=" + group_id + "&desc=" + desc + "&product_app_name=" + product_app_name + "&product_xl_name=" + product_xl_name + "&product_symbol_name=" + product_symbol_name + "&startdate=" + startdate + "&starttime=" + starttime + "&enddate=" + enddate + "&endtime=" + endtime, true);
		ajx.send();
	}
    else
    {
        alert("Please, Enter all the values!");
    }
}


function create_product()
{
	document.getElementById('create_product').style.display = 'block';
	//document.getElementById('grpid').value=str;
}

function page_to_excel() {
    var product_name = document.getElementById("search_name").value;
    var e = document.getElementById("search_grp");
    var gid = e.options[e.selectedIndex].value;
    
    /*var inputElements = document.getElementsByClassName("checkbox_item");
    var idArray = [];
    
    for(var i = 0; inputElements[i]; ++i){
        if(inputElements[i].checked){
            id = inputElements[i].id;
            idArray.push(id)
        }
    }*/
    
    /*if(idArray.length == 0) {
        alert("You should check products to export to excel.");
    }*/
    
    $.post(                             //call the server
       "export_to_excel.php",                     //At this url
        {
            product_name: product_name,
            gid: gid,
//            idArray: idArray
        }                               //And send this data to it
    ).done(                             //And when it's done
        function(data)
        {
            console.log(data);
            window.location = "export.xlsx";
        }
    );
}

function selected_download() {
    var inputElements = document.getElementsByClassName("checkbox_item");
    var idArray = [];
    
    for(var i = 0; inputElements[i]; i ++) {
        if(inputElements[i].checked) {
            id = inputElements[i].id;
            idArray.push(id)
        }
    }
    
    if(idArray.length == 0) {
        alert("You should check products to export to excel.");
    }
    else {
        $.post(
            "selected_download_full_data.php",
            {
                idArray: idArray
            }
        ).done(
            function(data) {
                console.log(data);
                window.location = "historical_data.xlsx";
            }
        );
    }
}

function hide_pop()
{
document.getElementById('view_product').style.display='none';
document.getElementById('create_product').style.display='none';
document.getElementById('edit_product').style.display='none';
document.getElementById('view_user1').style.display='none';
document.getElementById('loader').style.display='none';
}
function view_product(str)
{
    var ajx;
    document.getElementById('view_product').style.display='block';
	//alert(str);
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
			document.getElementById('view_product').innerHTML=ajx.responseText;
		}
	}
		ajx.open("POST","view_product.php?productid="+str,true);
		ajx.send();
}
function edit_product(str)
{
//alert("kjhkh");
		var ajx;
		document.getElementById('edit_product').style.display='block';
	//alert(str);
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
			document.getElementById('edit_product').innerHTML=ajx.responseText;
		}
	}
		ajx.open("POST","edit_product.php?productid="+str,true);
		ajx.send();
}
function del_product(str)
{
    var x = confirm('Do you really want to delete it !');
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
			ajx.open("POST","del_product.php?productid="+str,true);
			ajx.send();
		}
}
function check_all_products(ele) {
    var checkboxes = document.getElementsByClassName("checkbox_item");
    for(var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = ele.checked;
    }
}
function replace_product(x)
{ 
var check="";
		
		
		var group_id=document.getElementById('group_id').value;
		var desc=document.getElementById('desc').value;
		var product_app_name=document.getElementById('product_app_name').value;
        var product_symbol = document.getElementById('product_symbol').value;
		var product_xl_name=document.getElementById('product_xl_name').value;
	if(x==2)
		{
		var check=confirm("This will delete all the files and folders from the folder "+product_app_name+"!! Click OK to continue or Click Cancel!");
		}
		if(check)
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
				
				reply=ajx.responseText;
				if(x==2)
				{
				alert(reply);
				}
				show_products();
				hide_pop();
			}
		}
			ajx.open("POST","create_product.php?assoc&group_id="+group_id+"&desc="+desc+"&product_app_name="+product_app_name+"&product_xl_name="+product_xl_name+"&op="+x+"&product_symbol=" + product_symbol,true);
			ajx.send();
}
else
{
hide_pop();
}





}

$(document).ready(function (e) {
$("#search").click(function(){
   ajax_search();
});
   
$("#search_name").blur(function(){
   ajax_search();
});

$("#search_grp").change(function(){
   ajax_search();
});

//$("#startdate").datepicker();
//$("#enddate").datepicker();
//$("#endtime").timepicker({'step': 5});
//$("#starttime").timepicker({'step': 5});

function ajax_search()
{

$.ajax({
            type:'POST',
            url: 'show_products.php',
            data:{product_name:$('#search_name').val(),gid:$('#search_grp').val()},
            beforeSend:function(data)
			{
				document.getElementById('loader').style.display='block';
			},
			
            success:function(data){
                console.log("success");
				document.getElementById('result').innerHTML=data;
								hide_pop();
               
            },
            error: function(data){
                console.log("error");
                alert(data);
            }
        });

}



   
$("#assoc").click(function(){
	
	document.getElementById("op").value=1;
	hide_pop();
	$("#product_uplod").submit();
	});
$("#replace").click(function(){
	
	document.getElementById("op").value=2;
	hide_pop();
	$("#product_uplod").submit();
	});



	$('#product_uplod').on('submit',(function(e) {
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
				show_products();
				hide_pop();
               
            },
            error: function(data){
                console.log("error");
                alert(data);
            }
        });
		
    }));
	
	
	$('#product_edit').on('submit',(function(e) {
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
				show_products();
				hide_pop();
               
            },
            error: function(data){
                console.log("error");
                alert(data);
            }
        });
    }));
});


</script>
</head>
<body onload='show_products()'>

<div class="mainwrapper">
    
 
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="dashboard.html"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="dashboard.html">Dashboard</a> <span class="separator"></span></li>
            <li>Add Products</li>
        </ul>
        
        <div class="pageheader">
            
            <div class="pagetitle">
              <h1>Add Products</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            <div class="row-fluid">
              <a onclick='create_product()'style='cursor:pointer;' class="btn btn-primary">Add Product</a>
              <div style='float:right'>
              <a onclick='selected_download()' style='cursor: pointer; margin-right: 20px;' class="btn btn-primary">Select & Download</a>
              <a onclick='page_to_excel()'style='cursor: pointer; margin-right: 30px;' class="btn btn-primary">Page To Excel</a>
			  <span class="field"><input type='text' name='search_name' placeholder='Search By Product Name' id='search_name' style="margin-top: 6px;"></span>
			  <span class="field"><select name="search_grp" id="search_grp" style="margin-top: 6px;">
                <option value=''>Search By Group</option>


				<?php
				  $qry="select * from groups";
				  $qr=mysql_query($qry);
				  while($x=mysql_fetch_array($qr))
				  {
					  ?>
                   <option value="<?php echo $x['id']; ?>"><?php echo $x['name']; ?></option>
                    <?php
                  }
				   ?>
                   </select></span>
			  <a style='cursor:pointer;' class="btn btn-primary" id='search'>Search Product</a>
             </div>
				



			 <div id='result' style="overflow: auto; width: 100%;">
                 
				 
                </div>
				</div>
				
				<div id='create_product' class='pop'>
				<div id="wiz1step1" class="formwiz1">
            	<form name="product_uplod" id="product_uplod" method="post" action="create_product.php" enctype="multipart/form-data">
                    <p>
                            <label>Select A Group</label>
                            <span class="field"><select name="group_id" id="group_id" required>
                 <?php
				  $qry = "select * from groups";
				  $qr = mysql_query($qry);
				  while($x = mysql_fetch_array($qr))
				  {
				  ?>
                   <option value="<?php echo $x['id']; ?>"><?php echo $x['name']; ?></option>
                    <?php
                  }
				   ?>
                   </select></span>
                        </p>
                        
                        <p>
                            <label>Product Application Friendly Name:</label>
                            <span class="field"><input type='text' name='product_app_name'  id='product_app_name' required></span>
                        </p>
                        <p>
                            <label>Product Symbol Name: ex) GC*1</label>
                            <span class="field"><input type='text' name='product_symbol_name'  id='product_symbol_name' required></span>
                        </p>
                        <!--<p>
                            <label style="float: left; width: 40%; margin-right: 10%;">Start Date</label>
                            <label style="float: left; width: 40%;">End Date</label>
                            <span class="field">
                                <input type='text' name='startdate'  id='startdate' required style="float: left; width: 40%; margin-right: 10%;" />
                                <input type='text' name='enddate'  id='enddate' required style="float: left; width: 40%;" />
                            </span>
                        </p>-->
                        <!--<p>
                            <label style="float: left; width: 42%; margin-right: 8%;">Start Time(CST)</label>
                            <label style="float: left; width: 42%;">End Time(CST)</label>
                            <span class="field">
                                <input type='text' name='starttime'  id='starttime' required style="float: left; width: 40%; margin-right: 10%;" />
                                <input type='text' name='endtime'  id='endtime' required style="float: left; width: 40%;" />
                            </span>
                        </p>-->
						<input type='hidden' id='op' name='operation' value="3">
                         <p>
                            <label>Description:</label>
                            <span class="field"><textarea name="desc" id="desc"></textarea></span>
                        </p>
                         <p>
                            <label>Excel File Name:</label>
                            <span class="field"><input type='text'  name='product_xl_name'  id='product_xl_name' required></span>
                        </p>
						 <p>
                            <label>Product Icon:</label>
                            <span class="field"><input type='file'  name='product_icon'  id='product_icon' required></span>
                        </p>
                       	<p class="stdformbutton">
                           <input type="button" value="Save" name="submit" onclick='submit_product()' class="btn btn-primary" 
                           style="margin-top:10px;" title="Submit" >
						   <input type="button" value="Cancel" name="submit" class="btn btn-primary" style="margin-top:10px;" title="Submit" onclick=hide_pop() >
                        </p>
               </form>      
                </div>
				</div><!--#wiz1step1-->
                <div  id='view_product' style='border:thin solid;height:100%;width:100%;position:fixed;top:0;left:0;background:rgba(50,50,50,.3);display:none'>
						
				   </div>
				   <form name="product_edit" id='product_edit' action='create_product.php?edit' method='post' enctype="multipart/form-data"> 

				    <div  id='edit_product' style='border:thin solid;height:100%;width:100%;position:fixed;top:0;left:0;background:rgba(50,50,50,.3);display:none'>
						
				   </div>
                </f
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
								<input type='button' id="assoc" class='btn btn-primary' value='Associate' style='margin-left:10px;'><input type='button' id="replace" class='btn btn-primary' value='Replace'  style='margin-left:10px;'><input type='button' class='btn btn-primary' value='Cancel' onclick='hide_pop()'  style='margin-left:10px;'>
							</div>			
						</div></div>
					</div>
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
