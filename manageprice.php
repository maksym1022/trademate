<?php
	include("include/class.php");
	$obj=new admin;
	$obj->conn();
	include("include/header.php");
	include("include/left.php");
	?>
<html>
	<head>
	
	</head>
<body onload='show_products()'>

<div class="mainwrapper">
    
 
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="dashboard.html"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="dashboard.html">Dashboard</a> <span class="separator"></span></li>
            <li> Manage Price</li>
        </ul>
        
        <div class="pageheader">
            
            <div class="pagetitle">
              <h1>  Set New Price</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            <div class="row-fluid">
			<?php
					if(isset($_REQUEST['setPrice']))
					{
						$prive_set=mysql_query("update price set price='".$_REQUEST['price']."'");
						if($prive_set)
						{
							echo "<script>alert('Price changed successfully !');</script>";
						}
						else{
							echo "<script>alert('Some ERROR occurred, try Again !');</script>";
						}
					}
				?>
			<?php
			$check_price=mysql_query("select * from price");
			$rec_price=mysql_fetch_array($check_price);
			
			?>
				<form action='' action='post'>
					<input type='text' placeholder='Set Price' value='<?php echo $rec_price['price']; ?>' name='price'><input type='submit' name='setPrice' class='btn btn-primary margin-left-form' value='Price'>
				</form>
				
			</div>
		 </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
    
</div><!--mainwrapper-->
</body>
</html>