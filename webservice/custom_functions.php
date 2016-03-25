<?php  
require_once("../include/class.php");$obj=new admin;
$obj->conn();

$web_url = "http://localhost/coryvalco/";
function findTheRecent($folder,$filename) {
	$files = glob("$folder/$filename *");
	$dateDiff2 = 10000;
	for($i = 0 ; $i < count($files); $i ++){
        $value = explode("/", $files[$i]);
		$firstName = end($value);
		$firstName = explode(" ", $firstName);
		$count = count($firstName);
		$count = $count - 4;
		$firstNameFinal = '';
		for($j = 0, $tmp = 0; $j <= $count; $j ++) {
			$firstNameFinal .= $firstName[$j];
			if($tmp < $count){
				$firstNameFinal .= ' ';
			}
		}
	    $file = explode(' ', $files[$i]);	
		$from = $file[count($file) - 3];
		$to = $file[count($file) - 1];
		$to = explode('.', $to);
		$to = $to[0];
		$serverDate = Date('d-m-Y');
		$to = date_create($to);
		$serverDate = date_create($serverDate);
		$diff = date_diff($to, $serverDate);
		$dateDiff = intval($diff->format("%R%a days"));
		if($dateDiff < $dateDiff2) {
			$recent = $files[$i];
			$dateDiff2 = $dateDiff;
		}
	}
	return $recent;
}

function show_basic_predictions($excel_filename) {
    if(!file_exists($excel_filename)) {
        return false;
    }
    $i = 2;
    $data = new Spreadsheet_Excel_Reader($excel_filename);
    $predict_high = $data->val($i, 'H');
    $predict_low = $data->val($i, 'I');

    $temp = decimal_equal("$predict_high", "$predict_low");
    if($temp) {
        $predict_high = $temp[0];
        $predict_low = $temp[1];
    }

    $result['predict_high'] = $predict_high;//predicted high
    $result['predict_low'] = $predict_low;//predicted low
    $result['trend'] = $data->val($i, 'F');//predicted low
    return $result;
}

function show_basic_tradebook($excel_filename, $date_flag = false) {
    if(!file_exists($excel_filename)) {
        return false;
    }

    $i = 2;
    $data = new Spreadsheet_Excel_Reader($excel_filename);
    $date = $data->val($i, 'A');

    if(!$date_flag != false) {
        $date = $data->val($i, 'A');//date
        $weekday = date('N', strtotime($date)); // note: first arg to date() is lower-case L
        $date2 = str_replace('/', '-', $date);

        if($weekday == '5') {
            $date2 = add_days($date2, 3);
        }
        else {
            $date2 = add_days($date2, 1);
        }
        $first_statistics = $date2;
        $temp = explode('-', $first_statistics);
        $monthNum = $temp[1]; 
        $dateObj = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
        $first_statistics = $temp[2] . ' ' . $monthName . ' ' . $temp[0];

        mysql_query("update prediction_date set prediction_date='$first_statistics' where name='prediction_for'") or die(mysql_error());
    }

    $entry_price = 0;
    $exit_sell = 0;
    $exit_buy = 0;
    $dir = "";
    $f2 = $data->val($i, 'F');
    $i2 = $data->val($i, 'I');
    $h2 = $data->val($i, 'H');

    /*
    $c2=$data->val($i,'C');
    $d2=$data->val($i,'D');
    */
	if($f2 == "1") {
    	$dir = "Long";
		$entry_price = ((3 * $i2) + $h2) / 4;
		$exit_sell = ($h2 + $i2) / 2;//exit sell
		$exit_buy = "";//exit buy
	}
	else {
    	$dir = "Short";
		$entry_price = ((3 * $h2) + $i2) / 4;
		$exit_sell = "";
		$exit_buy = ($h2 + $i2) / 2;
	}
    $result['day'] = $date2 = str_replace('-', ' ', $date);
    $result['direction'] = $dir;
    $result['entry_price'] = $entry_price;
    $result['exit_buy'] = $exit_buy;
    $result['exit_sell'] = $exit_sell;
    return $result;
}

function prediction_day($recent, $pid) {
    if(!file_exists($recent)) {
        return false;
    }
    $data = new Spreadsheet_Excel_Reader($recent);
    $result = array();
    for($i = 2; $i < 3; $i ++) {
        $y = $i + 1;//previous row
        $z = $i + 2;
        $x = $i + 3;
        $date = $data->val($i, 'A');//date
        $weekday = date('N', strtotime($date)); // note: first arg to date() is lower-case L
        $date2 = str_replace('/', '-', $date);

        if($weekday == '5')
        {
            $date2 = add_days($date2, 3);
        }
        else
        {
            $date2 = add_days($date2, 1);
        }

        $date = explode('/', $date);
        $day = $date[2];
        $month = $date[1];
        $year = $date[0];
        $prediction_c = $data->val($i, 'F');//trend current
        $prediction_p = $data->val($y, 'F');//trend previous
        $predict_high = $data->val($i, 'H');//predicted high
        $predict_low = $data->val($i, 'I');//predicted low
        $g2 = $data->val($i, 'G');//strength current
        $g3 = $data->val($y, 'G');//strength previous
        $g4 = $data->val($z, 'G');
        $conviction_c = 0;// conviction current
        $conviction_p = 0;// conviction previous
        $response['message'] = '';
        $temp = decimal_equal("$predict_high","$predict_low");
        if($temp)
        {
            $predict_high = $temp[0];
            $predict_low = $temp[1];
        }
        if($prediction_c == '1')
        {
            $conviction_c = $g2 - $g3;
        }
        else
        {
            $conviction_c = $g3 - $g2;
        }
        if($prediction_p == '1')
        {
            $conviction_p = $g3 - $g4;
        }
        else
        {
            $conviction_p = $g4 - $g3;
        }

        $first_statistics = $date2;


        $temp = explode('-', $first_statistics);
        $monthNum = $temp[1]; 

        $dateObj = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
        $first_statistics = $temp[2] . '-' . $monthName . '-' . $temp[0];
        $result["day"][$i - 2] = $first_statistics;
        //$result[$i-2]["month"]=$month;
        //$result[$i-2]["year"]=$year;
        $result["trend"][$i - 2] = $prediction_c;
        $result["predicted_high"][$i - 2] = $predict_high;
        $result["predicted_low"][$i - 2] = $predict_low;
        $result["conviction_c"][$i - 2] = $conviction_c;
        $result["conviction_p"][$i - 2] = $conviction_p;
    }
    return $result;
}

function prediction_week($recent)
{
    if(!file_exists($recent))
    {
        return false;
    }

    $data = new Spreadsheet_Excel_Reader($recent);
    $result = array();
    for($i = 3; $i <= 22; $i ++)
    {
        $y = $i + 1;//(n+1)th  row
        $z = $i - 1;//(n-1)th row
        $first_statistics = $data->val($i, 'A');

        $temp = explode('/', $first_statistics);
        $monthNum = $temp[1]; 

        $dateObj = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
        $first_statistics = $temp[2] . '-' . $monthName . '-' . $temp[0];
        $f3 = $data->val($y, 'F');//trend for next day
        $h3 = $data->val($y, 'H');//predicted high
        $i3 = $data->val($y, 'I');//predicted low
        $c2 = $data->val($i, 'C');//actual high
        $d2 = $data->val($i, 'D');//actual low

        $f2 = $data->val($i, 'F');
        $f1 = $data->val($z, 'F');
        $performance;
        if($f3 != $f2){
            $performance = 0;
        }
        else {
	        if($h3 <= $c2 && $i3 >= $d2){
			    $performance = 100;
	        }
	        else if($h3 <= $c2 || $i3 >= $d2){
			    $performance = 75;
	        }
	        else if(!($h3 <= $c2 || $i3 >= $d2)){
				$performance = 50;
	        }
        }
        $date= $temp[2] . '-' . $monthName . '-' . $temp[0];

        $result["day"][$i - 3] = str_replace('-', ' ', $date);
        $result["trend"][$i - 3] = $f3;
        $result["actual_trend"][$i - 3] = $f2;
        $result["predicted_high"][$i - 3] = $h3;
        $result["predicted_low"][$i - 3] = $i3;
        $result["actual_high"][$i - 3] = $c2;
        $result["actual_low"][$i - 3] = $d2;
        $result["performance"][$i - 3] = $performance;
    }
    return $result;
}

function prediction_month($recent, $x) {
    if(!file_exists($recent))
    {
        return false;
    }
    $data = new Spreadsheet_Excel_Reader($recent);

    $result = array();

    for($i = $x; $i <= 22; $i ++) {
        $j = $i + 1;
        $entry_price = 0;
        $exit_sell = 0;
        $exit_buy = 0;
        $performance = 0;//0 for red and 1 for green
        $dir = "";
        $f3 = $data->val($j, 'F');  //trend for next day
        $i3 = $data->val($j, 'I');  //predicted low
        $h3 = $data->val($j, 'H');  //predicted high
        $c2 = $data->val($i, 'C');  //actual high
        $d2 = $data->val($i, 'D');  //actual low

		if($f3 == "1")
		{	
            $dir = "Long";
			$entry_price = ((3 * $i3) + $h3) / 4;
			$exit_sell = ($h3 + $i3) / 2;//exit sell
			$exit_buy = "";//exit buy
			if($exit_sell < $c2)
			{
			    $performance = 1;//performance
			}
		}
		else if($f3 == "0")
		{	
            $dir = "Short";
			$entry_price = ((3 * $h3) + $i3) / 4;
			$exit_sell = "";
			$exit_buy = ($h3 + $i3) / 2;
			if($exit_buy > $d2)
			{
			    $performance = 1;
			}
		}
		$first_statistics = $data->val($i, 'A');

        $temp = explode('/', $first_statistics);
        $monthNum = $temp[1]; 

        $dateObj = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
        $first_statistics = $temp[2] . '-' . $monthName . '-' . $temp[0];
        $result['day'][$i - $x] = str_replace('-', ' ', $first_statistics);
        $result['direction'][$i - $x] = $dir;
        $result['entry_price'][$i - $x] = $entry_price;
        $result['exit_buy'][$i - $x] = $exit_buy;
        $result['exit_sell'][$i - $x] = $exit_sell;
        $result['performance'][$i - $x] = $performance;
    }
    return $result;
}

function fetchUri($pId, $rowCount) {
	//echo 'hi'.$pId;
	if($result = mysql_query("select cpf from products where id='$pId'")) {
		if($row = mysql_fetch_array($result)) {
	        $cpf = $row['cpf'];
            $data = new Spreadsheet_Excel_Reader($cpf);
	
	        //$rowCount = $data->rowcount();
	        //$rowCount = 22;
	        $tmp = 1;
	
	        $result = '[';
	        $closeFinal = '-1,';
	        $highFinal = '-1,';
	        $lowFinal = '-1,';
	        $openFinal = '-1,';
	        $predictedHighFinal = '-1,';
	        $predictedLowFinal = '-1,';
	        $dateFinal = '|-1,';
	        $trendFinal = '-2,';
	        $highest = 0;
	        $lowest = 1000000;
	
	
	        for($i = $rowCount; $i > 1; $i --)
	        {
	            $first_statistics = $data->val($i, 'A');
	            $trend = $data->val($i, 'F');
	            $predictedHigh = $data->val($i, 'H');
	            $predictedLow = $data->val($i, 'I');

	            $open = $data->val($i, 'B');
	            $high = $data->val($i, 'C');
	            $low = $data->val($i, 'D');
	            $close = $data->val($i, 'E');
	        
	        
	            if($open === 'n/a') {
		            if($tmp == 1) {
				        $open = $data->val($i + 1, 'B');
			        }
			        else {
				        $open = $data->val($i - 1, 'B');
			        }
	            }
	            if($high === 'n/a') {
		            if($tmp == 1){
			            $high = $data->val($i + 1, 'C');
		            }
		            else {
			            $high = $data->val($i - 1, 'C');
		            }
	            }
	            if($low === 'n/a') {
		            if($tmp == 1) {
			            $low = $data->val($i + 1, 'E');
		            }
		            else {
			            $low = $data->val($i - 1, 'E');
		            }
	            }
	            if($close === 'n/a') {
		            if($tmp == 1) {
			            $close = $data->val($i + 1, 'D');
		            }
		            else {
			            $close = $data->val($i - 1, 'D');
		            }
	            }	
	            if($predictedHigh === 'n/a') {
			        if($tmp == 1) {
				        $predictedHigh = $data->val($i + 1, 'H');
			        }
			        else {
				        $predictedHigh = $data->val($i - 1, 'H');
			        }
	            }
	            if($predictedLow === 'n/a') {
		            if($tmp == 1) {
			            $predictedLow = $data->val($i + 1, 'I');
		            }
		            else {
			            $predictedLow = $data->val($i - 1, 'I');
		            }
	            }
	            if($trend === 'n/a') {
		            if($tmp == 1) {
			            $trend = $data->val($i + 1, 'F');
		            }
		            else {
			            $trend = $data->val($i - 1, 'F');
		            }
	            }
	        
	            if($highest < $high) {
	                $highest = $high;
	            }
	            if($highest < $predictedHigh) {
		            $highest = $predictedHigh;
	            }
	            if($lowest > $low){
		            $lowest = $low;
	            }
	            if($lowest > $predictedLow) {
		            $lowest = $predictedLow;
	            }
	            //$result.='['.$low.','.$open.','.$close.','.$high.','.$predictedHigh.','.$predictedLow.']'; 
	            $closeFinal .=  $close;
	            $highFinal .=  $high;
	            $lowFinal .=  $low;
	            $openFinal .=  $open;
	            $trendFinal .= $trend;
	            $predictedHighFinal .= $predictedHigh;
	            $predictedLowFinal .= $predictedLow;
                if($tmp % 1 == 0 && $rowCount == 8) {
	                $first_statistics = stripslashes($first_statistics);
	                $first_statistics = explode('/', $first_statistics);
	                $first_statistics = $first_statistics[2] . '-' . $first_statistics[1] . '-' . $first_statistics[0];
	                $dateFinal .= '|' . $first_statistics;
                }
                else if($tmp % 4 == 0 && $rowCount == 31 ) {
	                $first_statistics = stripslashes($first_statistics);
	                $first_statistics = explode('/', $first_statistics);
	                $first_statistics = $first_statistics[2] . '-' . $first_statistics[1] . '-' . $first_statistics[0];
	                $dateFinal .= '|' . $first_statistics;
                }
                else if($tmp % 2 == 0 && $rowCount == 16 ) {
	                $first_statistics = stripslashes($first_statistics);
	                $first_statistics = explode('/', $first_statistics);
	                $first_statistics = $first_statistics[2] . '-' . $first_statistics[1] . '-' . $first_statistics[0];
	                $dateFinal .= '|' . $first_statistics;
                }

                if($tmp < $rowCount - 1) {
	                $result .= ',';
	                $closeFinal .= ',';
	                $highFinal .= ',';
	                $lowFinal .= ',';
	                $openFinal .= ',';
	                $predictedHighFinal .= ',';
	                $predictedLowFinal .= ',';
	                $trendFinal .= ',';
	                $tmp ++;
                }
	        }

	        $closeFinal .= ',-1';
	        $highFinal .= ',-1';
	        $lowFinal .= ',-1';
	        $openFinal .= ',-1';
	        $predictedHighFinal .= ',-1';
	        $predictedLowFinal .= ',-1';
	        $trendFinal .= ',-2';
	        
	        $dateFinal .= '|';
	        if($lowest < 5) {
		        $lowest = $lowest - .030;
		        $highest = $highest + 0.015;
	        }
	        else {
		        if($highest - $lowest >= 20 && $highest - $lowest <= 60 ) {
			        $lowest = intval($lowest) - 40;
		        }
		        else if($highest - $lowest > 60 && $highest - $lowest <= 100) {
			        $lowest = intval($lowest) - 50;
		        }
		        else if($highest - $lowest > 0 && $highest - $lowest <= 2) {
			        $lowest = intval($lowest) - 1;
		        }
		        else if($highest - $lowest > 100) {
			        $lowest = intval($lowest) - 70;
		        }
		        else {
			        $lowest = intval($lowest) - 3;
		        }
		        $highest = intval($highest) + 1;
	        }
	        
	        $chds = $lowest . ',' . $highest . ',' . $lowest . ',' . $highest;
	        $divider = ($highest - $lowest) / 10;
	        if(!$divider) {
		        $divider = 0.01;
	        }
	        else if($divider <= 5 && $divider > 3) {
		        $divider = 0.2;
	        }
	        else if($divider <= 3 && $divider > 1) {
		        $divider = 1;
	        }
	        else if($divider <= 1 && $divider > 0.1) {
		        $divider = 0.5;
	        }
	        
	        $chxr = '0,' . $lowest . ',' . $highest . ',' . $divider;
	        if($result = mysql_query("select `excel_file_name` from products where id='$pId'")) {
			    if($row = mysql_fetch_array($result)) {
				    $name = $row['excel_file_name'];
				    $name = str_replace('#', '', $name);
			    }
	        }
	        else {
		        $name = 'Name Not Available';
	        }
	        /*$name = $name[count($name)-1];
	        $name = explode('.',$name);
	        $name = explode(' ',$name[0]);
	        $name = $name[0].' '.$name[1];
	        $name = str_replace(" ","+",$name);
	        */
	        $chtt = 'Our+predictions+for+' . $name;
	        $chts = '3A648F,14,c';
	        
	        $temp = explode(',', $trendFinal);
	        for($i = 1; $i < count($temp) - 1; $i ++) {
		        if(intval($temp[$i]) == 0 ) {
			        $temp[$i] = $lowest + $divider;
		        }
		        else if(intval($temp[$i]) == 1 ) {
			        $temp[$i] = $lowest+$divider + $divider;
		        }
	        }
	        $trendFinal = implode(',', $temp);
	        
	        $final = 'https://chart.googleapis.com/chart?chd=t3:' . $trendFinal . '|' . $predictedHighFinal . '|' . $predictedLowFinal . '|' . $lowFinal . '|' . $openFinal . '|' . $closeFinal . '|' . $highFinal . '&chxl=0:||Down|Up|1:' . $dateFinal . '&chs=750x400&cht=lc&chxt=y,x&chm=F,357ECD,3,-1,5&chg=0,18,0' . '&chds=' . $chds . '&chxr=' . $chxr . '&chtt=' . $chtt . '&chts=' . $chts . '&chco=000000,94BF15,9E1F1F,0000FF'; 		
	        //$trendLine = 'http://1.chart.apis.google.com/chart?cht=lc&chs=960x100&chco=000000&chd=t:'.$trendFinal.'&chg=0,34,0&chds=-1,2,-1,2&chxr=0,-1,2,1&chxt=y,x&chxl=1:'.$dateFinal;
	        return $final;
	    }
	}
}

function check_best($excel_filename) {
    if(!file_exists($excel_filename))
    {
        return false;
    }

    $data = new Spreadsheet_Excel_Reader($excel_filename);
    $i = 2;
    $date = $data->val($i, "A");
    /*variables from 2nd row*/
    $f2 = $data->val($i, "F");
    $m2 = $data->val($i, "M");
    $p2 = $data->val($i, "P");
    $r2 = $data->val($i, "R");
    $s2 = $data->val($i, "S");
    $t2 = $data->val($i, "T");
    $u2 = $data->val($i, "U");
    $v2 = $data->val($i, "V");
    $w2 = $data->val($i, "W");
    $x2 = $data->val($i, "X");
    $y2 = $data->val($i, "Y");
    $z2 = $data->val($i, "Z");
    $aa2 = $data->val($i, "AA");

    /*variables from 3rd row*/
    $j = $i + 1;
    $r3 = $data->val($j, "R");
    $s3 = $data->val($j, "S");
    $t3 = $data->val($j, "T");
    $u3 = $data->val($j, "U");
    $v3 = $data->val($j, "V");
    $w3 = $data->val($j, "W");
    $x3 = $data->val($j, "X");
    $y3 = $data->val($j, "Y");
    $z3 = $data->val($j, "Z");
    $aa3 = $data->val($j, "AA");
    /*variables from 4th row*/
    $k = $i + 2;
    $m4 = $data->val($k, "M");
    $p4 = $data->val($k, "P");

	if((($u2 > $v2 && $u2 > $w2) && !($u3 > $v3 && $u3 > $w3)) || (($u2 < $v2 && $u2 < $w2) && !($u3 < $v3 && $u3 < $w3))) {
		if(($z2 > $aa2 && $z3 < $aa3) || ($z2 < $aa2 && $z3 > $aa3))
		{
			if(($x2 > $y2 && $x3 < $y3) || ($x2 < $y2 && $x3 > $y3))
			{
				if(($f2 == '0' && $r2 < $r3 && $s2 < $s3 && $t2 < $t3) or ($f2 == '1' && $r2 > $r3 && $s2 > $s3 && $t2 > $t3))
				{
				    return true;
				}
			}
		}
	}
    return false;
}

function decimal_equal($a, $b) {
    $a = explode('.', $a);
    $b = explode('.', $b);
    $adec = $a[1];
    $bdec = $b[1];
    $adec = "$adec";
    $bdec = "$bdec";
    $alen = strlen($adec);
    $blen = strlen($bdec);
	if($alen == $blen)
	{
	    return false;
	}
	else if($alen > $blen)
	{
		$dif = $alen - $blen;
		for($i = 0; $i < $dif; $i ++)
		{
		    $bdec = $bdec . "0";
		}
	}
	else
	{
		$dif = $blen - $alen;
		for($i = 0; $i < $dif; $i ++)
		{
		    $adec = $adec . "0";
		}
	}
    $result[0] = $a[0] . "." . $adec;
    $result[1] = $b[0] . "." . $bdec;
    return $result;
}
function add_days($date, $days) {
    $date = explode(" ", $date);
    $date = $date[0];
    $date1 = explode("-", $date);
    $year = intval($date1[0]);
    $month = intval($date1[1]);
    $day = intval($date1[2]);
    $eday = 0;
    $emonth = 0;
    $eyear = 0;
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $day);
    if(($month != 12)||($month == 12 && $day <= $days_in_month - $days))
    {
        if($day <= ($days_in_month - $days))
        {
            $eday = $day + $days;
            $emonth = $month;
            $eyear = $year;
        }
        else
        {
            $eyear = $year;
            $emonth = $month + 1;
            $eday = $day + $days - $days_in_month;
        }
    }
    else
    {
        $eyear = $year + 1;
        $emonth = 1;
        $eday = $day + $days - $days_in_month;
    }
    if($emonth < 10)
    {
        $emonth = "0" . $emonth;
    }
    if($eday < 10)
    {
        $eday = "0" . $eday;
    }
    $edate = "$eyear-$emonth-$eday";
    return $edate;
}
?>