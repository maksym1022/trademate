<?php
//date_default_timezone_set("GMT");
class admin
{
	var $uname = '';
	var $email = '';
	var $status = '';
	var $current_page = 'all_users.php';
	var $corder = 'asc';
	var $order = 'asc';
	var $start = '0';
	public function conn()
	/*{
		$server='localhost';
		$user='root';
		$password='';
		mysql_connect($server,$user,$password) or die ('Connection Error!');
		$value=mysql_select_db("oit_admin");
	}
	*/
	{
        error_reporting( E_ALL ^ ( E_NOTICE | E_WARNING | E_DEPRECATED ) );
        ini_set('max_execution_time', 1000);
		$server = 'localhost';
		$user = 'wang';
		$password = 'HV=JJ_HuMM.(';
        $user = "root";
        $password = "";
		mysql_connect($server, $user, $password) or die ('Connection Error!');
		$value = mysql_select_db("coryvalco");
        
        $dir_name = dirname(__FILE__);
        $xml_file = $dir_name . "/../webservice/xml_data/best.xml";
        
        /*if(file_exists($xml_file)) {
            unlink($xml_file);
            /*if(file_put_contents('./webservice/xml_data/best.xml', 'text')){
                die('yes');
            } else {
                die('no');
            }
        }*/
        
	}
	public function show_users()
	{
        $corder = $this->corder;
	        //global $start;
        $start = $this->start;
        $limit = 10;
        $qry = "select * from signup  where username like '%$this->uname%' and email like  '%$this->email%' and status like '%$this->status%' order by id $this->order limit $this->start,$limit ";
        $value = mysql_query($qry) or die(mysql_error());
        $cnt = mysql_num_rows($value);
	    if($cnt > 0)
	    {
		    $value2 = mysql_query("select * from signup  where username like '%$this->uname%' and email like  '%$this->email%'
		                            and status like '%$this->status%'  order by id $this->order ");
		    echo "<table class='table table-bordered responsive margin-top'>";
			?>
            <tr style='cursor:pointer;' onclick=sortuser('<?php echo $this->order; ?>',<?php echo $this->start; ?>)>				
				    <th  >S.No.</a></th><th>Username</th><th>First Name</th><th>Last Name</th>
					    <th>Email</th><th>Mobile No</th><th>Last Paid on</th><th>Expiring on</th><th>Action</th>
			<?php
			echo "</tr>";
			$i = $this->start + 1;
			$rowCount = mysql_num_rows($value2);
		    while($result = mysql_fetch_array($value))
		    {
			    $gender = '';
			    $id = $result['id'];
			    $res = mysql_fetch_array(mysql_query("select * from login_details where uid=$id"));
			    $tr = $id . "tr";
			    echo "<tr id='$tr'>
			            <td>$i</td>
					    <td id='$id' contenteditable='false'>".$result['username']."</td>
					    <td id='$id' contenteditable='false'>".$result['firstname']."</td>
					    <td id='$id' contenteditable='false'>".$result['lastname']."</td>
					    <td id='$id' contenteditable='false'>".$result['email']."</td>
					    <td id='$id' contenteditable='false'>".$result['mobile']."</td>
					    <td id='$id' contenteditable='false'>".$res['login_time']."</td>
					    <td id='$id' contenteditable='false'>exrired</td>
					    <td style='text-align:center;'> 
						    <a id='$id' onclick='view_user(this.id)' style='cursor:pointer;'>
							    <span>
								    <div class=
								    'icon-file'></div>
							    </span>
						    </a> 
						    <a id='$id' onclick='edit_pwd(this.id)' style='cursor:pointer;'>
							    <span>
								    <div class='icon-pencil'></div>
							    </span>
						    </a> ";
						    //$stat = $result['status'];
					    if($_SESSION['user'] == 'admin') {
                            echo "
                                <a onclick='del_user(".$result['id'].")' style='cursor:pointer;'>
                                    <span>
                                        <div class='icon-trash'></div>
                                    </span>
                                </a>";
                        }
                        echo "</td>
                            </tr>";
				    $i++;
		        }
		        $prev = $this->start - $limit;
		        $next = $this->start + $limit;
		        
		        echo "<tr><td colspan=6>
		          <div class=prevNext>
		           ";
                if($prev >= 0){
                   $this->start = $prev;
	                  echo "<a href='all_users.php?start=$prev'>
	                  <button class='btn btn-primary'>Prev</button></a>";
                }
			    
			    if($this->start < $rowCount - $limit) {
				    $this->start = $next;
			    echo "<a href='all_users.php?start=$next'><button class='btn btn-primary'>Next</button></a>";
			    }
                echo "</div></div>
		                </td></tr>";
		        echo "</table>";
		    }
		    else
	        {
		        echo "No Results Found";
	        }
	    }
	
	public function update_info()
	{	
		$id = $_POST['userid'];
		$pwd = $_POST['pwd'];
		$cpwd = $_POST['cpwd'];
		$value = mysql_query("update signup set password='$pwd' where id=$id");
		if($value)
		{
			echo "<script>window.location.href='all_users.php?detail';</script>";
		}
		else
		{
			echo "update signup set password='$pwd' where id=$id".mysql_error();
		}
	}
    
	public function fetch_pages() {
		$qry = "select * from pages";
		if($result = mysql_query($qry))
		{
			echo "<table class='table table-bordered responsive margin-top'>
					<tr><th>Page Name</th><th>Page Desc</th><th>Edit</th></tr>";
			while($row = mysql_fetch_array($result))
			{
			    $desc = $this->trim_string(90, $row['pageDesc']);
				echo "<td >" . $row['pageName'] . "</td><td >" . $desc . "</td><td >
						<a id='" . $row['pageId'] . "' title='Edit Page' alt='Edit Page' onclick='editPage(this.id)' style='cursor:pointer;'>
							<div class='icon-pencil' ></div>
						</a>
					</td></tr>
						";
			} 
			echo "</table>";
		}
		else {
			echo "No pages found";
		}
	}

	public function show_groups()
	{
	
	    $qry = "select * from groups ";
	    $value = mysql_query($qry) or die(mysql_error());
	    $cnt = mysql_num_rows($value);
	    if($cnt > 0)
	    {
		    echo "<table class='table table-bordered responsive margin-top' width=200px>";
			?>
            <tr><th>Group Name</th><th>Group Image</th><th>Action</th>
			<?php
			echo "</tr>";
			while($result = mysql_fetch_array($value))
			{
			    $gender = '';
			    $id = $result['id'];
			    
			    $tr = $id . "tr";
			    echo "<tr id='$tr'>
				        <td >".$result['name']."</td>
				        <td ><img src='".$result['img']."' width=50 height=50></td>
				        <td style='text-align:center;'> 
							<a id='$id' onclick='edit_grp(".$result['id'].")' style='cursor:pointer;'>
						<span>
							<div class='icon-pencil'></div>
						</span>
					</a>";
					//$stat = $result['status'];
                    echo "                 
                        <a  onclick='del_grp(".$result['id'].")' style='cursor:pointer;'>
                            <span>
                                <div class='icon-trash'></div>
                            </span>
                        </a></td>
                    </tr>";
			}
		    echo "</table>";
		}
		else
	    {
		    echo "No Groups Found";
	    }
	}
    
    public function show_products($name = false, $gid = false)
	{
	    if($name != false && $gid != false)
	    {
	        $qry = "select * from products where group_id='$gid' and app_friendly_name like '%$name%' order by group_id";
	    }
	    else if($name != false)
	    {
	        $qry = "select * from products where app_friendly_name like '%$name%' order by group_id";
	    }
	    else if($gid != false)
	    {
	        $qry = "select * from products where group_id='$gid' order by group_id";
	    }
	    else
	    {
	        $qry = "select * from products order by group_id";
	    }
	    $value = mysql_query($qry) or die(mysql_error());
	    $cnt = mysql_num_rows($value);
	    if($cnt > 0)
	    {
		    echo "<table class='table table-bordered margin-top'>";
			?>
            <tr>
                <th><input type="checkbox" id="check_all" onclick="check_all_products(this)" /></th>
                <th>Serial</th>
                <th>Icon</th>
                <th>Product Name</th>
                <th>Symbol</th>
                <th>Group Name</th>
                <th>Trading Day</th>
                <th>Open</th>
                <th>High</th>
                <th>Low</th>
                <th>Close</th>
                <th>Time of Import</th>
                <th>P.High</th>
                <th>P.Trend</th>
                <th>P.Low</th>
                <th>Action</th>
			<?php
				
			echo "</tr>";
            $index = 1;
			while($result = mysql_fetch_array($value))
			{
		        $gender = '';
		        $gid = $result['group_id'];
                $symbol = $result['symbol'];
		        $res = mysql_fetch_array(mysql_query("select * from groups where id=$gid"));
                
                $val = mysql_fetch_array(mysql_query("select * from predictions where symbol='$symbol' order by trading_date desc limit 1"));
                $val1 = mysql_fetch_array(mysql_query("select * from predictions where symbol='$symbol' order by trading_date desc limit 1, 1"));
                
                $first_trading_day = $val['trading_date'];
                $second_trading_day = $val1['trading_date'];
                
                $res1 = mysql_fetch_array(mysql_query("select * from historical_data where tradingDay='$first_trading_day' and symbol='$symbol' order by tradingDay desc limit 1"));
                $res2 = mysql_fetch_array(mysql_query("select * from historical_data where tradingDay='$second_trading_day' and symbol='$symbol' order by tradingDay desc limit 1"));
                
/*                $second_tradingDay = $res2['tradingDay'];
                
                if($res1['tradingDay'] == $res2['tradingDay']) {
                    $temp = mysql_fetch_array(mysql_query("select * from historical_data where tradingDay<'$second_tradingDay' and symbol='$symbol' order by tradingDay desc limit 1"));
                    $second_tradingDay = $temp['tradingDay'];
                    $res2 = mysql_fetch_array(mysql_query("select * from historical_data where tradingDay<='$second_tradingDay' and symbol='$symbol' order by tradingDay desc limit 1"));
                }*/
		        
/*                $res3 = mysql_fetch_array(mysql_query("select * from predictions where symbol='$symbol' and prediction_date>='$first_date' order by prediction_date desc limit 1"));
                $res4 = mysql_fetch_array(mysql_query("select * from predictions where symbol='$symbol' and prediction_date>='$second_tradingDay' order by prediction_date desc limit 1"));*/
                
                echo "<tr>
                    <td rowspan='2' contenteditable='false' style='vertical-align: middle; text-align: center;'>
                        <input type='checkbox' class='checkbox_item' id='" . $result['id'] . "' />
                    </td>
                    <td rowspan='2' contenteditable='false' style='vertical-align: middle; text-align: center;'>" . $index++ . "</td>
                    <td rowspan='2' contenteditable='false' style='vertical-align: middle; text-align: center;'><img src='" . $result['img'] . "' width=50 height=50'></td>
                    <td rowspan='2' contenteditable='false' style='vertical-align: middle; text-align: center;'>" . $result['app_friendly_name'] . "</td>
				    <td rowspan='2' contenteditable='false' style='vertical-align: middle; text-align: center;'>" . $result['symbol'] . "</td>
                    <td rowspan='2' contenteditable='false' style='vertical-align: middle; text-align: center;'>" . $res['name'] . "</td>
                    <td contenteditable='false'>" . $res1['tradingDay'] . "</td>
                    <td contenteditable='false'>" . $res1['open'] . "</td>
                    <td contenteditable='false'>" . $res1['high'] . "</td>
                    <td contenteditable='false'>" . $res1['low'] . "</td>
                    <td contenteditable='false'>" . $res1['close'] . "</td>
                    <td contenteditable='false'>" . $res1['tradingDay'] . "</td>
                    <td contenteditable='false'>" . $val['p_high'] . "</td>
                    <td contenteditable='false'>" . $val['p_trend'] . "</td>
                    <td contenteditable='false'>" . $val['p_low'] . "</td>
                    <td rowspan='2' style='text-align:center; vertical-align: middle;'> 
				        <a onclick='view_product(".$result['id'].")' style='cursor:pointer;'>
						    <span>
							    <div class='icon-file'></div>
						    </span>
					    </a> 
						<a onclick='edit_product(".$result['id'].")' style='cursor:pointer;'>
						    <span>
							    <div class='icon-pencil'></div>
						    </span>
					    </a> ";
                echo "                 
                    <a onclick='del_product(".$result['id'].")' style='cursor:pointer;'>
                        <span>
                            <div class='icon-trash'></div>
                        </span>
                    </a>
                    </td>
                </tr>";
                echo "<tr>
                        <td contenteditable='false'>" . $res2['tradingDay'] . "</td>
                        <td contenteditable='false'>" . $res2['open'] . "</td>
                        <td contenteditable='false'>" . $res2['high'] . "</td>
                        <td contenteditable='false'>" . $res2['low'] . "</td>
                        <td contenteditable='false'>" . $res2['close'] . "</td>
                        <td contenteditable='false'>" . $res2['tradingDay'] . "</td>
                        <td contenteditable='false'>" . $val1['p_high'] . "</td>
                        <td contenteditable='false'>" . $val1['p_trend'] . "</td>
                        <td contenteditable='false'>" . $val1['p_low'] . "</td>
                    </tr>";
		    }
		    echo "</table>";
		}
		else
		{
		    echo "No Results Found";
		}
    }
	
function trim_string($x, $str)
{
	$str = strip_tags($str);
	if(strlen($str) > $x)
	{
	    $str1 = substr($str, 0, $x);
	    return $str1 . "...";
	}
	else
	{
	    return $str;
	}
}

function show_group_name($id)
{
    if($res = mysql_fetch_array(mysql_query("select * from groups where id=$id")))
    {
        return $res['name'];
    }
}

function check_group_exist($group_name)
{
    $qr = "select name from groups where name='$group_name'";
    $qr1 = mysql_query($qr);
	$qry = mysql_num_rows($qr1);
	if($qry == 0)
    {
        if(!file_exists("groups/" . $group_name))
        {
            $url = "groups/" . $group_name . "/" . $group_name . ".jpg";
            $qry1 = "insert into groups(name,img) values('$group_name','$url')";
            $qry2 = mysql_query($qry1);
            mkdir("groups/" . $group_name);	
            return 1;
        }
        else
        {
            return 2;	
        }	
    }
    else	
    {
        return 3;
    }
}

function remove_path($folder){
    $files = glob( $folder . DIRECTORY_SEPARATOR . '*');
    foreach($files as $file) {
        if($file == '.' || $file == '..') {
            continue;
        }
        if(is_dir($file)) {
            $this->remove_path($file);
        } else {
            unlink($file);
        }
    }
    rmdir($folder); 
}

public function view_profile(){
	$qry = "select * from company_profile";
	if($result = mysql_query($qry))
	{
		echo "<table class='table table-bordered responsive margin-top'>";
		while($res = mysql_fetch_array($result))
		{
			echo "<tr><td>Company's name</td><td>" . $res['name'] . "</td></tr>";
			echo "<tr><td>Phone</td><td>" . $res['phone'] . "</td></tr>";
			echo "<tr><td>Email</td><td>" . $res['email'] . "</td></tr>";
            echo "<tr><td>Address</td><td>" . $res['address'] . "</td></tr>";
			echo "<tr><td>ManUsername</td><td>" . $res['manusername'] . "</td></tr>";
			echo "<tr><td>Logo</td><td><img src='app_img/logo.png' height=100 width=100>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; Last Modified at:" . $this->show_img_time('logo')."</td></tr>";
			echo "<tr><td>Splash Screen</td><td><img src='app_img/splash.jpg' height=100 width=100>&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Last Modified at:" . $this->show_img_time('splash')." 
			</td></tr>";
		}
		echo "</table>";	
	}
	else {
		echo "No pages found";
	}
}

	public function search_users($uname, $email, $status)
	{
        $corder = $this->corder;
		//global $start;
	    $sstart = $this->start;
		$limit = 20;
        $qry = "select * from signup  where username like '%$uname%' and email like  '%$email%' and status like '%$status%' order by id $this->order limit $this->start,$limit ";
		$value = mysql_query($qry) or die(mysql_error());
	    $cnt = mysql_num_rows($value);
	    if($cnt > 0)
	    {
		    $value2 = mysql_query("select * from signup  where username like '%$uname%' and email like  '%$email%'
		                            and status like '%$status%'  order by id $this->order ");
		    echo "<table class='table table-bordered responsive margin-top'>";
			?>
            <tr style='cursor:pointer;' onclick=sortuser('<?php echo $this->order; ?>','<?php echo $uname ?>','<?php echo $email ?>','<?php echo $status ?>')>	 				<th>UserName</th><th>Name</th>
				<th>Email</th><th>Mobile No</th><th>Country</th><th>Status</th><th>Last Paid on</th><th>Expring on</th><th>Action</th>
			<?php
			echo "</tr>";
				
			$rowCount = mysql_num_rows($value2);
		    while($result = mysql_fetch_array($value))
		    {
		        $expire = $result['expiring_on'];
			    $gender = '';
			    $id = $result['id'];
			    $tr = $id . "tr";
			    $expire1 = date_create($expire);
			    $today = date_create(date('Y-m-d'));
			
			    $diff = date_diff($today, $expire1);
			    $diff = $diff->days;
			    if(($result['status'] == '0') || ($result['status'] == '2'))
			    {
			        if(($diff < 4) and ($diff >= 0))
				    {
				        echo "<tr id='$tr' class='expireon'>
					        <td  >".$result['username']."</td>
					        <td>".$result['name']."</td>
					        <td>".$result['email']."</td>
                            <td>".$result['mobile']."</td>
					        <td>".$result['country']."</td>
					        ";
					    if($result['status'] == '0')
					    {
						    $s = "Trial";
					    }
					    else if($result['status'] == '1')
					    {
						    $s = "Unpaid";
					    }
					    else if($result['status'] == '2')
					    {
						    $s = "Paid";
					    }
					    else
					    {
						    $s = "Blocked";
					    }
					    echo"<td >$s</td>";
					    echo "<td >" . $result['joined_on'] . "</td>
					        <td >$expire</td>
					        <td style='text-align:center;'> 
						    <a id='$id' onclick='view_user(this.id)' style='cursor:pointer;'>
							    <span>
								    <div class='icon-file'></div>
							    </span>
						    </a> 
						    <a  onclick=edit_pwd(" . $result['id'] . ",'$uname','$email','$status') style='cursor:pointer;'>
							    <span>
								    <div class='icon-pencil'></div>
							    </span>
						    </a> ";
						//$stat = $result['status'];
					    if($_SESSION['user'] == 'admin') {
                            echo" 
                                <a onclick=del_user(".$result['id'].",'$uname','$email','$status') style='cursor:pointer;'>
                                    <span>
                                        <div class='icon-trash'></div>
                                    </span>
                                </a>";
                        }
                        echo "</td></tr>";    
				    }
				else {
				    echo "<tr id='$tr' class='paid'>
					    <td  >" . $result['username'] . "</td>
					    <td>" . $result['name'] . "</td>
					    <td>" . $result['email'] . "</td>
					    <td>" . $result['mobile'] . "</td>
					    <td>" . $result['country'] . "</td>
					    ";
					if($result['status'] == '0')
					{
						$s = "Trial";
					}
					else if($result['status'] == '1')
					{
						$s = "Unpaid";
					}
					else if($result['status'] == '2')
					{
						$s = "Paid";
					}
					else
					{
						$s ="Blocked";
					}
					
					echo"<td >$s</td>";
					echo "
					    <td >" . $result['joined_on'] . "</td>
					    <td >$expire</td>
					    <td style='text-align:center;'> 
						    <a id='$id' onclick='view_user(this.id)' style='cursor:pointer;'>
							    <span>
								    <div class='icon-file'></div>
							    </span>
						    </a> 
						    <a  onclick=edit_pwd(" . $result['id'] . ",'$uname','$email','$status') style='cursor:pointer;'>
							    <span>
								    <div class='icon-pencil'></div>
							    </span>
						    </a> ";
						    //$stat = $result['status'];
					if($_SESSION['user'] == 'admin') {
                        echo " 
                            <a onclick=del_user(" . $result['id'] . ",'$uname','$email','$status') style='cursor:pointer;'>
                                <span>
                                    <div class='icon-trash'></div>
                                </span>
                            </a>";    
                    }
                    echo "</td></tr>";
				}
			}
			else
				{
					echo "<tr id='$tr' class='expire'>
					        <td  >" . $result['username'] . "</td>
					        <td>" . $result['name'] . "</td>
					        <td>" . $result['email'] . "</td>
					        <td>" . $result['mobile'] . "</td>
					        <td>" . $result['country'] . "</td>
					        ";
					if($result['status'] == '0')
					{
						$s = "Trial";
					}
					else if($result['status'] == '1')
					{
						$s = "Unpaid";
					}
					else if($result['status'] == '2')
					{
						$s = "Paid";
					}
					else
					{
						$s = "Blocked";
					}
					
					echo"<td >$s</td>";
					echo "
				        <td >" . $result['joined_on'] . "</td>
				        <td >$expire</td>
				        <td style='text-align:center;'> 
					        <a id='$id' onclick='view_user(this.id)' style='cursor:pointer;'>
						        <span>
							        <div class='icon-file'></div>
						        </span>
					        </a> 
					        <a  onclick=edit_pwd(" . $result['id'] . ",'$uname','$email','$status') style='cursor:pointer;'>
						        <span>
							        <div class='icon-pencil'></div>
						        </span>
					        </a> ";
					        //$stat = $result['status'];
					
					if($_SESSION['user'] == 'admin') {
                        echo " 
                            <a  onclick=del_user(" . $result['id'] . ",'$uname','$email','$status') style='cursor:pointer;'>
                                <span>
                                    <div class='icon-trash'></div>
                                </span>
                            </a>";
                    }
                    echo "</td></tr>";
			    }
	        }
		$prev = $this->start - $limit;
		$next = $this->start + $limit;
		//echo $this->start." ".$prev." ".$next;
		
		echo "<tr><td colspan=6>
		  <div class=prevNext>
		   ";
        if($prev >= 0) {
            //  $this->start=$prev;
            echo "<a onclick=pagination_search('$prev','$uname','$email','$status')> <button class='btn btn-primary'>Prev</button></a>";
        }
		
        if($this->start<$rowCount-$limit)
        {
        //		$this->start=$next;
          echo " <a onclick=pagination_search('$next','$uname','$email','$status')> <button class='btn btn-primary'>Next</button></a>";

        }
				 
		echo "</div></div></td></tr>";
		echo "</table>";
	}
	else
	{
		echo "No Results Found";
	}
}
	
//    function check_product_exist($gid, $product_name, $desc, $excel_file_name, $product_symbol_name, $startdate, $enddate, $starttime, $endtime)
//    function check_product_exist($gid, $product_name, $desc, $excel_file_name, $product_symbol_name, $starttime, $endtime)
	function check_product_exist($gid, $product_name, $desc, $excel_file_name, $product_symbol_name)
	{
	    $group_name = $this->show_group_name($gid);
	    $uname = $group_name . "_" . $product_name;
	    $image_name = str_replace(' ', '', $product_name);
//        $image_name = date('YmdHis');
	    $qr = "select app_friendly_name from products where uid='$uname'";
	    $url = "groups/" . $group_name;
	    $qr1 = mysql_query($qr);
		$qry = mysql_num_rows($qr1);
		if($qry == 0)
        {
            if(!file_exists($url . "/" . $image_name . ".jpg"))
            {
                $img_path = $url . "/" . $image_name . ".jpg";
                $qry1 = "insert into products(group_id, app_friendly_name, description, excel_file_name, uid, img, symbol) values('$gid', '$product_name', '$desc', '$excel_file_name', '$uname', '$img_path', '$product_symbol_name')";
                mysql_query($qry1);
                
                /*$qry2 = "select id from products where uid='$uname'";
                $qry3 = mysql_query($qry2);
                $row = mysql_fetch_row($qry3);
                $product_id = $row[0];
                
                $yesterday = date(Y) . date(m) . (date(d) - 1) . "160000";
                $yesterday1 = date(Y) . date(m) . (date(d) - 1) . "160500";
                
                $data = file_get_contents("http://ondemand.websol.barchart.com/getHistory.csv?apikey=3833454a0d604bb425e301307514d8ca&type=daily&symbol=" . $product_symbol_name . "&startDate=" . $yesterday . "&endDate=" . $yesterday1);
                if(strlen($data) > 2) {
                    $dataAry = explode("\n", $data);
                    $symbol1 = explode(",", $dataAry[1]);
                    $symbol1 = $symbol1[0];
                } else {
                    $symbol1 = "";
                }*/
                
                // format date
                /*$startdate = explode("/", $startdate);
                $startdate = $startdate[2] . "-" . $startdate[0] . "-" . $startdate[1];
                
                $enddate = explode("/", $enddate);
                $enddate = $enddate[2] . "-" . $enddate[0] . "-" . $enddate[1];*/
                
                // format time
                /*$starttime = explode(":", $starttime);
                $hour = $starttime[0];
                
                $min = str_split($starttime[1], 2);
                
                if($min[1] == "am") {
                    if($hour == 12) {
                        $hour = 0;
                    }
                    else {
                        $hour = $hour;
                    }
                }
                else {
                    if($hour < 12) {
                        $hour = $hour + 12;
                    }
                }
                $starttime = $hour . ":" . $min[0] . ":" . "00";
                
                $endtime = explode(":", $endtime);
                $hour1 = $endtime[0];
                $min1 = str_split($endtime[1], 2);
                
                if($min1[1] == "am") {
                    if($hour1 == 12) {
                        $hour1 = 0;
                    }
                }
                else {
                    if($hour1 < 12) {
                        $hour1 = $hour1 + 12;
                    }
                }
                $endtime = $hour1 . ":" . $min1[0] . ":" . "00";*/
                
//                $qry4 = "insert into symbol(contract, symbol, symbol1, startdate, enddate, starttime, endtime, product_id) values('$product_name', '$product_symbol_name', '$symbol1', '$startdate', '$enddate', '$starttime', '$endtime', '$product_id')";
//                $qry4 = "insert into symbol(contract, symbol, symbol1, starttime, endtime, product_id) values('$product_name', '$product_symbol_name', '$symbol1', '$starttime', '$endtime', '$product_id')";
//                $qry4 = "insert into symbol(contract, symbol, symbol1, starttime, endtime, product_id) values('$product_name', '$product_symbol_name', '$symbol1', '$starttime', '$endtime', '$product_id')";
//                mysql_query($qry4);
                
                return 1;
            }
            else
            {
                return 2;	
            }	
        }
        else	
        {
            return 3;
        }
	}
	function show_img_time($type)
	{
	    $qry = "select * from app_images where title='$type'";
		if($result = mysql_fetch_array(mysql_query($qry)))
		{
		    return $result['uploaded_at'];
		}
	}
}
?>