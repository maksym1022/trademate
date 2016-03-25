<?php
    include("include/class.php");
    $obj = new admin();
    $obj->conn();
    
    date_default_timezone_set('America/Chicago');
    
    $today_day = date('d');
    $today_month = date('m');
    $today_year = date('Y');
    
    $yesterday_day = date('d', time() - 86400);
    $yesterday_month = date('m', time() - 86400);
    $yesterday_year = date('Y', time() - 86400);
    
    $hour = date(H);
    $min = date(i);
    
    $endTime = "170500";
    
    // Today's date will be available after 5:00 pm CST
    if($hour < 17) {
        $startDate = ($yesterday_year - 1) . $yesterday_month . $yesterday_day;
        $endDate = $yesterday_year . $yesterday_month . $yesterday_day . $endTime;
    } else {
        $startDate = ($today_year - 1) . $today_month . $today_day;
        $endDate = $today_year . $today_month . $today_day . $endTime;
    }
    
    $startDate = "20131023";
    $endDate = "20141023170500";
    
    $qry = "select symbol from products order by group_id";
    $symbols = mysql_query($qry);
    
    $qry = "truncate historical_data";
    mysql_query($qry);
    
    while($result = mysql_fetch_array($symbols)) {
        $symbol_value = $result['symbol'];
        
        $data = file_get_contents("http://ondemand.websol.barchart.com/getHistory.csv?apikey=3833454a0d604bb425e301307514d8ca&type=daily&symbol=" . $symbol_value . "&startDate=" . $startDate . "&endDate=" . $endDate);
        
        if(strlen($data) > 2) {
            $dataAry = explode("\n", $data);

            for($i = 1; $i <= count($dataAry); $i ++) {
                $row = explode(",", $dataAry[$i]);
                /*$symbol = $row[0];
                $timestamp = $row[1];
                $tradingDay = $row[2];
                $open = $row[3];
                $high = $row[4];
                $low = $row[5];
                $close = $row[6];
                $volume = $row[7];
                $openInterest = $row[8];*/
                
                $qry = "insert into historical_data (id, symbol, timestamp, tradingDay, open, high, low, close, volume, openInterest) values ('', '$symbol_value', $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8])";
                mysql_query($qry);
            }
        }
    }
    
    echo "Successfully imported 1 year's data.";
?>
