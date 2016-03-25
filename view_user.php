<?php 
include("include/class.php"); 
$obj = new admin; $obj->conn(); 
$id = $_REQUEST['userid']; 
$value = mysql_query("select * from signup where id=$id"); 
while($rec = mysql_fetch_array($value)) 
{ 
?> 
<div class='view-user-pop'> 
<div class='user-info'> 
<span class="icon-user"></span>
User Info	 
</div>	 
<div class='icon-remove' onclick='hide_pop()' style='cursor:pointer;position:absolute;top:10px;right:10px;'></div> 
<div class='view-user-pop-inner'> 
	<div class="maincontentdv">			
	<div class="leftdv">Name</div>	
	<div class="rightdv">
	<?php echo $rec['name'] ?>
	</div>			
	<div class="clear"></div>					
	</div>
				
	<div class="maincontentdv">		
	<div class="leftdv">Username</div>			
	<div class="rightdv"><?php echo $rec['username']; ?></div>
	<div class="clear"></div>
	</div>	
	<div class="maincontentdv">	
	<div class="leftdv">Email</div>	
	<div class="rightdv"><?php echo $rec['email']; ?></div>		
	<div class="clear"></div>		</div>
	<div class="maincontentdv">
	<div class="leftdv">Mobile No</div>
	<div class="rightdv"><?php echo $rec['mobile'] ?></div>
	<div class="clear"></div>
	</div>
	<div class="maincontentdv">
	<div class="leftdv">Country</div>
	<div class="rightdv"><?php echo $rec['country'] ?></div>
	<div class="clear"></div>
	</div>
	<div class="maincontentdv">
	<div class="maincontentdv">	
	<div class="leftdv">Status</div>
	<div class="rightdv">
	<?php 
	$s = "";
	$status = $rec['status'];
	if($status == '0')
	{
		$s = "Trial";
	}
	else if($status == '1')
	{
		$s = "Unpaid";
	}
	else if($status == '2')
	{
		$s = "Paid";
	}
	else
	{
		$s = "Blocked";
	}
	echo $s;
	?>
	</div>
	<div class="clear"></div>
	</div>
	<div class="maincontentdv">	
	<div class="leftdv">Last Paid On</div>
	<div class="rightdv"><?php echo $rec['joined_on'] ?></div>
	
	<div class="clear"></div>
	</div>
	<div class="maincontentdv">
	<div class="leftdv">Country</div>
	<div class="rightdv"><?php echo $rec['expiring_on'] ?></div>
	<div class="clear"></div>
	</div>
	</div>
</div>
<?php
}
?>