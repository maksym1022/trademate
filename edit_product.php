<style>
input[type='text']
{
width:150px;
}
select 
{
width:150px;
}
</style>
<?php
include("include/class.php");
$obj=new admin;
$obj->conn();
$id=$_REQUEST['productid'];
$value=mysql_query("select * from products where id=$id");
$rec=mysql_fetch_array($value);
$gid=$rec['group_id'];
$res=mysql_fetch_array(mysql_query("select * from groups where id=$gid"));
?>
<div class='view-user-pop'>
    <div class='user-info'>
        <span class="icon-user">
        </span>
        Edit Product Info
    </div>
    <div class='icon-remove' onclick='hide_pop()' style='cursor:pointer;position:absolute;top:10px;right:10px;'></div>
    <div class='view-user-pop-inner'>
        <input type='hidden' value='<?php echo $id ?>' name='id' id='id1' >
	    <div class="maincontentdv">
		    <div class="leftdv">Product Name</div>
		    <div class="rightdv"><input type='text' value='<?php echo $rec['app_friendly_name'] ?>' id='product_app_name1' name='product_app_name' ></div>
		    <div class="clear"></div>
		    
	    </div>
        
        <div class="maincontentdv">
            <div class="leftdv">Symbol</div>
            <div class="rightdv"><input type='text' value='<?php echo $rec['symbol'] ?>' id='product_symbol1' name='product_symbol' ></div>
            <div class="clear"></div>
            
        </div>
	    
	    <div class="maincontentdv">
		    <div class="leftdv">Description</div>
		    <div class="rightdv"><input type='text' value='<?php echo $rec['description'] ?>' name='desc' id='desc1'></div>
		    <div class="clear"></div>
	    </div>
	    
	    <div class="maincontentdv">
		    <div class="leftdv">Excel file name</div>
		    <div class="rightdv"><input type="text"   name='product_xl_name' id='product_xl_name1' value='<?php echo $rec['excel_file_name'] ?>' required></div>
		    <div class="clear"></div>
	    </div>
	    
        <p class="stdformbutton">
            <input type="file" name="productimg" id='productimg' class="input-large" />
            <input type="submit" value="Save" name="submit1"  class="btn btn-primary" style="margin-top:10px;" title="Submit">
            <input type="button" value="Cancel" name="" class="btn btn-primary" style="margin-top:10px;" title="Submit" onclick=hide_pop() >
            <!--<input type="button" value="Update Predictions" class="btn btn-primary" style="margin-top: 10px; margin-left: 20px; background-color: #ff7f27; border-color: #ff7f27;" onclick="update_predictions()" >-->
            <input type="button" value="Update Predictions" class="btn btn-primary" style="margin-top: 10px; margin-left: 20px; background-color: #ff7f27; border-color: #ff7f27;" onclick="update_predictions()" >
        </p>
	    <div class="clear"></div>
	</div>
</div>


