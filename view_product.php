<?php
include("include/class.php");
$obj = new admin;
$obj->conn();
$id = $_REQUEST['productid'];
$value = mysql_query("select * from products where id=$id");
$rec = mysql_fetch_array($value);
$gid = $rec['group_id'];
$res = mysql_fetch_array(mysql_query("select * from groups where id=$gid"));
?>
<div class='view-user-pop'>
    <div class='user-info'>
        <span class="icon-user"></span>
        Product Info
    </div>
    <div class='icon-remove' onclick='hide_pop()' style='cursor:pointer;position:absolute;top:10px;right:10px;'>
    </div>
    <div class='view-user-pop-inner'>
        <div class="maincontentdv">
            <div class="leftdv">Product Name</div>
            <div class="rightdv">
            <?php
            echo $rec['app_friendly_name'];
            ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="maincontentdv">
            <div class="leftdv">Symbol</div>
            <div class="rightdv">
            <?php
            echo $rec['symbol'];
            ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="maincontentdv">
            <div class="leftdv">Description</div>
            <div class="rightdv">
                <?php echo $rec['description']; ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="maincontentdv">
            <div class="leftdv">Excel file name</div>
            <div class="rightdv">
                <?php echo $rec['excel_file_name']; ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="maincontentdv">
            <div class="leftdv">Product Created on</div>
            <div class="rightdv">
                <?php echo $rec['timestamp']; ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="maincontentdv">
            <div class="leftdv">Group</div>
            <div class="rightdv">
                <?php echo $res['name'] ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>