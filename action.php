<?php
session_start();
include('include/class.php');
$obj =new admin;
$obj->conn();
if(isset($_REQUEST['group_id']))
{
$gid=$_REQUEST['group_id'];
	$value=mysql_query("select * from products where group_id='$gid'");
	$count=mysql_num_rows($value);
	if($count<1)
	{
		echo "1";
	}
	else{
	while($rec=mysql_fetch_array($value))
	{
		echo "<option value='$rec[0]'>$rec[1]</option>";
	}
	}
}
if(isset($_REQUEST['editPage']))
{
	{
		echo editPage_show($_REQUEST['editPage']);
	}
}

if(isset($_REQUEST['updatePage']))
{
	{
		echo updatePage($_REQUEST['updatePage'],$_REQUEST['pageName'],$_REQUEST['pageDesc']);
		$obj->fetch_pages();
	}
}
if(isset($_REQUEST['edit_user_id']))
{
$edit_user_id=$_REQUEST['edit_user_id'];
$value=mysql_query("select * from signup where id=$edit_user_id");
$rec=mysql_fetch_array($value);

	?>
	
	
				<div id="wiz1step1" class="formwiz1" >
                   <p>
						
                         <label>Password</label>
                            <span class="field">
								<input type="hidden" id='userid' value='<?php echo $rec[0]; ?>' class="input-large" />
								<input type="password" name="pwd" id='pwd' value='<?php echo $rec['password']; ?>'  class="input-large" />
								<input type="hidden" id='uname'  class="input-large" />
								<input type="hidden" id='email'  class="input-large" />
								<input type="hidden" id='status3'  class="input-large" />
							
							</span>
                        </p>
                        
                        <p>
                            <label>Status</label>
                            <span class="field">
								<select name='status1' id='status1'>
								<option value='0'>Trial</option>
								<option value='1'>Unpaid</option>
								<option value='2'>Paid</option>
								<option value='3'>Blocked </option>
								</select>
								
							</span>
                        </p>
                       	<p class="stdformbutton">
                           <input type="button" value="Save" onclick='save_edited_pwd();' class="btn btn-primary" style="margin-top:10px;" title="Submit">
						   <input type="button" value="Cancel" class="btn btn-primary" style="margin-top:10px;" title='cancel'  onclick='hide_pop()'>
						  
                        </p>
                
                </div><!--#wiz1step1-->
			<?php
}
if(isset($_REQUEST['create']))
{
	{
		echo create_new_page($_REQUEST['name'],$_REQUEST['desc']);
		$obj->fetch_pages();
	}
}
function editPage_show($editPage)
{
	$value=mysql_query("select * from pages where pageId=$editPage");
	$rec=mysql_fetch_array($value);
	$name= $rec['pageName'];
	$pid= $rec['0'];
	$desc= $rec['pageDesc'];
	
	?>
        <div class="pagetitle"><h1>Update Page</h1></div>
            <div id="wiz1step1" class="formwiz">
                <form action='' method="post"  name='edit_page'>
                <p>
                    <label>Page Name</label>
                    <span class="field">
                        <input type="text" name="name" id='name' class="input-large" disabled value='<?php echo $name; ?>'/>
                        <input type="hidden" name="pid" id='pid' class="input-large" value='<?php echo $pid; ?>'/>
                    </span>
                </p>
                
               
                <p>
                    <label>Page Descriptions</label>
                    <span class="field"><textarea id='desc' name='desc'><?php echo $desc; ?></textarea></span>
                    
                </p>
                <p class="stdformbutton">
                   <input type="button" value="Update" class="btn btn-primary" onclick='update_page()'  title="Update Page">
                    <input type="button" value="Cancel" class="btn btn-primary"  title="Cancel" onclick='hide_pop()'>
                </p>
            </form>
        </div><!-- formwiz ends  -->
<?php
}

function updatePage($pageid,$name,$desc)
{
	$value=mysql_query("update pages set pageName='$name' , pageDesc='$desc' where pageId='$pageid'");
	if(!$value)
	{
		echo "<script>alert('Sorry Some Error Occure !');</script>";
		}
}

function create_new_page($name,$desc,$order)
{
	$value=mysql_query("insert into pages values ('','$name','$desc','$order')");
	if($value)
	{
	echo"";
	}
	else{
		echo "sorry insert";
		}
}
?>