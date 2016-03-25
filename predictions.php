<?php
    // This script will be executed at 05:10 AM GMT

    include("include/class.php");
    $obj = new admin();
    $obj->conn();

    date_default_timezone_set('America/Chicago');
        
    $qry = "select * from products order by group_id";
    $symbols = mysql_query($qry);
    
    $p = 2;
    $exp = 2 / (1 + $p);
    $best_opp = "";
    
    while($result = mysql_fetch_array($symbols)) {
        $high = array();
        $low = array();
        $close = array();
        $id = array();
        
        array_push($high, "");
        array_push($low, "");
        array_push($close, "");
        array_push($id, "");
        
        $symbol_value = $result['symbol'];
        $contract = $result['app_friendly_name'];
        
        $decimal = 0;
        
//        if($symbol_value == "GC*1") {
            /*$qry = "SELECT COUNT(*) FROM historical_data WHERE symbol='$symbol_value'";
            $value = mysql_query($qry);
            $num = mysql_fetch_row($value);
            $num = $num[0];*/
            
            $qry = "SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC";
            $values = mysql_query($qry);
            
            // getting values of high, low
            while($predictions = mysql_fetch_array($values)) {
                array_push($id, $predictions['id']);
                array_push($high, $predictions['high']);
                array_push($low, $predictions['low']);
                array_push($close, $predictions['close']);
            }

            // getting decimal
            for($i = 1; $i <= 250; $i ++) {
                $tmp = explode(".", $high[$i]);
                $length = strlen($tmp[1]);
                if($decimal < $length) {
                    $decimal = $length;
                }
                $tmp = explode(".", $low[$i]);
                $length = strlen($tmp[1]);
                if($decimal < $length) {
                    $decimal = $length;
                }
                $tmp = explode(".", $close[$i]);
                $length = strlen($tmp[1]);
                if($decimal < $length) {
                    $decimal = $length;
                }
            }
            
            $count = count($high) - 1;
            
            // P.High
            $ema_high = array();
            $ema_high[$count - 2] = number_format(($high[$count] + $high[$count - 1] + $high[$count - 2]) / 3, $decimal, ".", "");
            
            for($i = ($count - 3); $i > 0; $i --) {
                $ema_high[$i] = number_format(($ema_high[$i + 1] * (1 - $exp)) + ($high[$i] * $exp), $decimal, ".", "");
            }
            
            $pHigh = number_format(($ema_high[2] * (1 - $exp)) + ($high[1] * $exp), $decimal, ".", "");
            
            for($i = 1; $i <= ($count - 2); $i ++) {
                $query = "update historical_data set ema_high='$ema_high[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            echo "P.High of " . $contract . " = " . $pHigh;
            echo "<br />";
            
            // P.Low
            $ema_low = array();
            $ema_low[$count - 2] = number_format(($low[$count] + $low[$count - 1] + $low[$count - 2]) / 3, $decimal, ".", "");

            for($i = ($count - 3); $i > 0; $i --) {
                $ema_low[$i] = number_format(($ema_low[$i + 1] * (1 - $exp)) + ($low[$i] * $exp), $decimal, ".", "");
            }
            
            $pLow = number_format(($ema_low[2] * (1 - $exp)) + ($low[1] * $exp), $decimal, ".", "");
            
            for($i = 1; $i <= ($count - 2); $i ++) {
                $query = "update historical_data set ema_low='$ema_low[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            echo "P.Low of " . $contract . " = " . $pLow;
            echo "<br />";
            
            // P.Trend
            
            // PHigh2+ for P.Trend
            $pHigh2 = number_format(($ema_high[2] * (1 - $exp)) + ($ema_high[1] * $exp), $decimal, ".", "");
            
            echo "P.High2+ of " . $contract . " = " . $pHigh2;
            echo "<br />";
            
            //PLow2+ for P.Trend
            $pLow2 = number_format(($ema_low[2] * (1 - $exp)) + ($ema_low[1] * $exp), $decimal, ".", "");
            
            echo "P.Low2+ of " . $contract . " = " . $pLow2;
            echo "<br />";
            
            //PClose2+ for P.Trend
            $ema_close = array();
            $ema_close[$count - 2] = number_format(($close[$count] + $close[$count - 1] + $close[$count - 2]) / 3, $decimal, ".", "");

            for($i = ($count - 3); $i > 0; $i --) {
                $ema_close[$i] = number_format(($ema_close[$i + 1] * (1 - $exp)) + ($close[$i] * $exp), $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 2); $i ++) {
                $query = "update historical_data set ema_close='$ema_close[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $pClose2 = number_format(($ema_close[2] * (1 - $exp)) + ($ema_close[1] * $exp), $decimal, ".", "");
            
            echo "P.Close2+ of " . $contract . " = " . $pClose2;
            echo "<br />";
            
            //typical(i)
            $typical = array();
            for($i = 1; $i <= $count; $i ++) {
                $typical[$i] = number_format(($high[$i] + $low[$i] + $close[$i]) / 3, $decimal, ".", "");
            }
            
            for($i = 1; $i <= $count; $i ++) {
                $query = "update historical_data set typical='$typical[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            //SMA typical(i)
            $sma_typical = array();
            $sma_typical[$count - 2] = number_format(($typical[$count] + $typical[$count - 1] + $typical[$count - 2]) / 3, $decimal, ".", "");
            
            for($i = ($count - 3); $i > 0; $i --) {
                $sma_typical[$i] = number_format(($typical[$i] + $typical[$i + 1] + $typical[$i + 2]) / 3, $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 2); $i ++) {
                $query = "update historical_data set sma_typical='$sma_typical[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $pTrend = number_format(($pHigh2 + $pLow2 + $pClose2) / 3 - $sma_typical[1], $decimal, ".", "");
            
            $updown = "";
            
            if($pTrend > 0) {
                $updown = "UP";
            } else if($pTrend < 0){
                $updown = "DOWN";
            } else {
                $updown = "";
            }
            
            echo "P.Trend of " . $contract . " = " . $pTrend . "----------------" . $updown;
            echo "<br />";
            
//------------------------ Best Opportunity---------------------------

            // PSD(1) and PSD(2)
            $p = 2;
            $exp = 2 / (1 + p);
            
            $ema_psd = array();
            $ema_psd[$count - 1] = number_format(($close[$count] + $close[$count - 1]) / 2, $decimal, ".", "");
            for($i = ($count - 2); $i > 0; $i --) {
                $ema_psd[$i] = number_format(($ema_psd[$i + 1] * (1 - $exp)) + ($close[$i] * $exp), $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 1); $i ++) {
                $query = "update historical_data set ema_psd='$ema_psd[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $sma_psd = array();
            for($i = ($count - 4); $i > 0; $i --) {
                $sma_psd[$i] = number_format(($close[$i + 4] + $close[$i + 3] + $close[$i + 2] + $close[$i + 1] + $close[$i]) / 5, $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 4); $i ++) {
                $query = "update historical_data set sma_psd='$sma_psd[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $sma_5_1 = number_format($sma_psd[2] + $close[1] / 5 - $close[6] / 5, $decimal, ".", "");
            $sma_5_2 = number_format($sma_psd[3] + $close[2] / 5 - $close[7] / 5, $decimal, ".", "");
            
            $psd[1] = number_format($ema_psd[1] - $sma_5_1, $decimal, ".", "");
            $psd[2] = number_format($ema_psd[2] - $sma_5_2, $decimal, ".", "");
            
            echo "PSD(1) of " . $contract . " = " . $psd[1];
            echo "<br />";
            echo "PSD(2) of " . $contract . " = " . $psd[2];
            echo "<br />";
            
            // PMD(1) and PMD(2)
            $p = 4;
            $exp = 2 / (1 + $p);
            
            $ema_pmd = array();
            $ema_pmd[$count - 2] = number_format(($close[$count] + $close[$count - 1] + $close[$count - 2]) / 3, $decimal, ".", "");
            for($i = ($count - 3); $i > 0; $i --) {
                $ema_pmd[$i] = number_format(($ema_pmd[$i + 1] * (1 - $exp)) + ($close[$i] * $exp), $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 2); $i ++) {
                $query = "update historical_data set ema_pmd='$ema_pmd[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $p4ema2 = number_format(($ema_pmd[2] * (1 - $exp)) + ($ema_pmd[1] * $exp), $decimal, ".", "");
            
            $sma_pmd = array();
            for($i = ($count - 9); $i > 0; $i --) {
                $sma_pmd[$i] = number_format(($close[$i + 9] + $close[$i + 8] + $close[$i + 7] + $close[$i + 6] + $close[$i + 5] + $close[$i + 4] + $close[$i + 3] + $close[$i + 2] + $close[$i + 1] + $close[$i]) / 10, $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 9); $i ++) {
                $query = "update historical_data set sma_pmd='$sma_pmd[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $sma_10_1 = number_format($sma_pmd[2] + $close[1] / 10 - $close[11] / 10, $decimal, ".", "");
            $sma_10_2 = number_format($sma_pmd[3] + $close[2] / 10 - $close[12] / 10, $decimal, ".", "");
            
            $pmd[1] = number_format($p4ema2 - $sma_10_1, $decimal, ".", "");
            $pmd[2] = number_format($ema_pmd[1] - $sma_10_2, $decimal, ".", "");
            
            echo "PMD(1) of " . $contract . " = " . $pmd[1];
            echo "<br />";
            echo "PMD(2) of " . $contract . " = " . $pmd[2];
            echo "<br />";
            
            // PLD(1) and PLD(2)
            $p = 6;
            $exp = 2 / (1 + $p);
            
            $ema_pld = array();
            $ema_pld[$count - 5] = number_format(($close[$count] + $close[$count - 1] + $close[$count - 2] + $close[$count - 3] + $close[$count - 4] + $close[$count - 5]) / 6, $decimal, ".", "");
            for($i = ($count - 6); $i > 0; $i --) {
                $ema_pld[$i] = number_format(($ema_pld[$i + 1] * (1 - $exp)) + ($close[$i] * $exp), $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 5); $i ++) {
                $query = "update historical_data set ema_pld='$ema_pld[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $p6ema2 = number_format(($ema_pld[2] * (1 - $exp)) + ($ema_pld[1] * $exp), $decimal, ".", "");
            $p6ema3 = number_format(($ema_pld[1] * (1 - $exp)) + ($p6ema2 * $exp), $decimal, ".", "");
            
            $sma_pld = array();
            for($i = ($count - 14); $i > 0; $i --) {
                $sma_pld[$i] = number_format(($close[$i + 14] + $close[$i + 13] + $close[$i + 12] + $close[$i + 11] + $close[$i + 10] + $close[$i + 9] + $close[$i + 8] + $close[$i + 7] + $close[$i + 6] + $close[$i + 5] + $close[$i + 4] + $close[$i + 3] + $close[$i + 2] + $close[$i + 1] + $close[$i]) / 15, $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 14); $i ++) {
                $query = "update historical_data set sma_pld='$sma_pld[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $sma_15_1 = number_format($sma_pld[2] + $close[1] / 15 - $close[16] / 15, $decimal, ".", "");
            $sma_15_2 = number_format($sma_pld[3] + $close[2] / 15 - $close[17] / 15, $decimal, ".", "");
            
            $pld[1] = number_format($p6ema3 - $sma_15_1, $decimal, ".", "");
            $pld[2] = number_format($p6ema2 - $sma_15_2, $decimal, ".", "");
            
            echo "PLD(1) of " . $contract . " = " . $pld[1];
            echo "<br />";
            echo "PLD(2) of " . $contract . " = " . $pld[2];
            echo "<br />";
            
            // P3EMA+1(1) and P3EMA+1(2)
            $p = 3;
            $exp = 2 / (1 + $p);
            
            $ema_p3ema = array();
            $ema_p3ema[$count - 2] = number_format(($typical[$count] + $typical[$count - 1] + $typical[$count - 2]) / 3, $decimal, ".", "");
            for($i = ($count - 3); $i > 0; $i --) {
                $ema_p3ema[$i] = number_format(($ema_p3ema[$i + 1] * (1 - $exp)) + ($typical[$i] * $exp), $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 2); $i ++) {
                $query = "update historical_data set ema_p3ema='$ema_p3ema[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $p3ema_1[1] = $ema_p3ema[1];
            $p3ema_1[2] = $ema_p3ema[2];
            
            echo "P3EMA+1(1) of " . $contract . " = " . $p3ema_1[1];
            echo "<br />";
            echo "P3EMA+1(2) of " . $contract . " = " . $p3ema_1[2];
            echo "<br />";
            
            // P8EMA+2(1) and P8EMA+2(2)
            $p = 8;
            $exp = 2 / (1 + $p);
            
            $ema_p8ema = array();
            $ema_p8ema[$count - 7] = number_format(($typical[$count] + $typical[$count - 1] + $typical[$count - 2] + $typical[$count - 3] + $typical[$count - 4] + $typical[$count - 5] + $typical[$count - 6] + $typical[$count - 7]) / 8, $decimal, ".", "");
            for($i = ($count - 8); $i > 0; $i --) {
                $ema_p8ema[$i] = number_format(($ema_p8ema[$i + 1] * (1 - $exp)) + ($typical[$i] * $exp), $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 7); $i ++) {
                $query = "update historical_data set ema_p8ema='$ema_p8ema[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $p8ema_2[1] = number_format(($ema_p8ema[2] * (1 - $exp)) + ($ema_p8ema[1] * $exp), $decimal, ".", "");
            $p8ema_2[2] = number_format(($ema_p8ema[2] * (1 - $exp)) + ($typical[1] * $exp), $decimal, ".", "");
            
            echo "P8EMA+2(1) of " . $contract . " = " . $p8ema_2[1];
            echo "<br />";
            echo "P8EMA+2(2) of " . $contract . " = " . $p8ema_2[2];
            echo "<br />";
            
            // P18EMA+3(1) and P18EMA+3(2)
            $p = 18;
            $exp = 2 / (1 + $p);
            
            $ema_p18ema = array();
            $ema_p18ema[$count - 17] = number_format(($typical[$count] + $typical[$count - 1] + $typical[$count - 2] + $typical[$count - 3] + $typical[$count - 4] + $typical[$count - 5] + $typical[$count - 6] + $typical[$count - 7] + $typical[$count - 8] + $typical[$count - 9] + $typical[$count - 10] + $typical[$count - 11] + $typical[$count - 12] + $typical[$count - 13] + $typical[$count - 14] + $typical[$count - 15] + $typical[$count - 16] + $typical[$count - 17]) / 18, $decimal, ".", "");
            for($i = ($count - 18); $i > 0; $i --) {
                $ema_p18ema[$i] = number_format(($ema_p18ema[$i + 1] * (1 - $exp)) + ($typical[$i] * $exp), $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 17); $i ++) {
                $query = "update historical_data set ema_p18ema='$ema_p18ema[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $p18ema_3[2] = number_format(($ema_p18ema[2] * (1 - $exp)) + ($ema_p18ema[1] * $exp), $decimal, ".", "");
            $p18ema_3[1] = number_format(($ema_p18ema[1] * (1 - $exp)) + ($p18ema_3[2] * $exp), $decimal, ".", "");
            
            echo "P18EMA+3(1) of " . $contract . " = " . $p18ema_3[1];
            echo "<br />";
            echo "P18EMA+3(2) of " . $contract . " = " . $p18ema_3[2];
            echo "<br />";
            
            // PMACD(1) and PMACD(2)
            $p1 = 26;
            $exp1 = 2 / (1 + $p1);
            $p2 = 12;
            $exp2 = 2 / (1 + $p2);
            
            $ema_p26ema = array();
            $ema[$count - 25] = number_format(($typical[$count] + $typical[$count - 1] + $typical[$count - 2] + $typical[$count - 3] + $typical[$count - 4] + $typical[$count - 5] + $typical[$count - 6] + $typical[$count - 7] + $typical[$count - 8] + $typical[$count - 9] + $typical[$count - 10] + $typical[$count - 11] + $typical[$count - 12] + $typical[$count - 13] + $typical[$count - 14] + $typical[$count - 15] + $typical[$count - 16] + $typical[$count - 17] + $typical[$count - 18] + $typical[$count - 19] + $typical[$count - 20] + $typical[$count - 21] + $typical[$count - 22] + $typical[$count - 23] + $typical[$count - 24] + $typical[$count - 25]) / 26, $decimal, ".", "");
            for($i = ($count - 26); $i > 0; $i --) {
                $ema_p26ema[$i] = number_format(($ema_p26ema[$i + 1] * (1 - $exp1)) + ($typical[$i] * $exp1), $decimal, ".", "");
                $p26ema[$i] = $ema_p26ema[$i];
            }
            
            for($i = 1; $i <= ($count - 25); $i ++) {
                $query = "update historical_data set ema_p26ema='$ema_p26ema[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
//            $p26ema[2] = $ema[2];
//            $p26ema[1] = $ema[1];
            
            $ema_p12ema = array();
            $ema_p12ema[$count - 11] = number_format(($typical[$count] + $typical[$count - 1] + $typical[$count - 2] + $typical[$count - 3] + $typical[$count - 4] + $typical[$count - 5] + $typical[$count - 6] + $typical[$count - 7] + $typical[$count - 8] + $typical[$count - 9] + $typical[$count - 10] + $typical[$count - 11]) / 12, $decimal, ".", "");
            for($i = ($count - 12); $i > 0; $i --) {
                $ema_p12ema[$i] = number_format(($ema_p12ema[$i + 1] * (1 - $exp2)) + ($typical[$i] * $exp2), $decimal, ".", "");
                $p12ema[$i] = $ema_p12ema[$i];
            }
            
            for($i = 1; $i <= ($count - 11); $i ++) {
                $query = "update historical_data set ema_p12ema='$ema_p12ema[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
//            $p12ema[2] = $ema[2];
//            $p12ema[1] = $ema[1];
            
            $pmacd[1] = number_format($p12ema[1] - $p26ema[1], $decimal, ".", "");
            $pmacd[2] = number_format($p12ema[2] - $p26ema[2], $decimal, ".", "");
            
            echo "PMACD(1) of " . $contract . " = " . $pmacd[1];
            echo "<br />";
            echo "PMACD(2) of " . $contract . " = " . $pmacd[2];
            echo "<br />";
            
            // PMACD Trigger (tRigger)
            $p = 9;
            $exp = 2 / (1 + $p);
            
            for($i = ($count - 26); $i > 0; $i --) {
                $pmacd[$i] = number_format($p12ema[$i] - $p26ema[$i], $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 26); $i ++) {
                $query = "update historical_data set pmacd='$pmacd[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            $tRigger[$count - 26] = number_format(($pmacd[$count - 26] + $pmacd[$count - 27] + $pmacd[$count - 28] + $pmacd[$count - 29] + $pmacd[$count - 30] + $pmacd[$count - 31] + $pmacd[$count - 32] + $pmacd[$count - 33] + $pmacd[$count - 34]) / 9, $decimal, ".", "");
            for($i = ($count - 27); $i > 0; $i --) {
                $tRigger[$i] = number_format(($tRigger[$i + 1] * (1 - $exp)) + ($pmacd[$i] * $exp), $decimal, ".", "");
            }
            
            for($i = 1; $i <= ($count - 26); $i ++) {
                $query = "update historical_data set t_rigger='$tRigger[$i]' where id='$id[$i]'";
                mysql_query($query);
            }
            
            echo "Trigger(1) of " . $contract . " = " . $tRigger[1];
            echo "<br />";
            echo "Trigger(2) of " . $contract . " = " . $tRigger[2];
            echo "<br />";
            echo "<br /><br /><br />";
            
            // Saving to database
            $today_day = date(d);
            $today_month = date(m);
            $today_year = date(Y);
            
            $hour = date(H);
            
            if($hour < 17) {
                $prediction_date = $today_year . "-" . $today_month . "-" . $today_day;
                $trading_date = date('Y', time() - 86400) . "-" . date('m', time() - 86400) . "-" . date('d', time() - 86400);
            } else {
                $prediction_date = date('Y', time() + 86400) . "-" . date('m', time() + 86400) . "-" . date('d', time() + 86400);
                $trading_date = $today_year . "-" . $today_month . "-" . $today_day;
            }
            
            $prediction_date = "2014-10-24";
            $trading_date = "2014-10-23";
            
            if($pTrend == 0) {
                $qry = "select p_trend from predictions where symbol='$symbol_value' and prediction_date='$trading_date";
                $value = mysql_query($qry);
                $row = mysql_fetch_row($value);
                $pTrend = explode('"', $row[0]);
                $pTrend = $pTrend[1];
            }
            
            $qry = "insert into predictions (id, symbol, product_name, prediction_date, trading_date, p_high, p_low, p_trend, psd_1, psd_2, pmd_1, pmd_2, pld_1, pld_2, p3ema_1_1, p3ema_1_2, p8ema_2_1, p8ema_2_2, p18ema_3_1, p18ema_3_2, pmacd_1, pmacd_2, trigger_1, trigger_2) values ('', '$symbol_value', '$contract', '$prediction_date', '$trading_date', '$pHigh', '$pLow', '$pTrend', '$psd[1]', '$psd[2]', '$pmd[1]', '$pmd[2]', '$pld[1]', '$pld[2]', '$p3ema_1[1]', '$p3ema_1[2]', '$p8ema_2[1]', '$p8ema_2[2]', '$p18ema_3[1]', '$p18ema_3[2]', '$pmacd[1]', '$pmacd[2]', '$tRigger[1]', '$tRigger[2]')";
            mysql_query($qry);
            
            // Best Opportunity
            if($best_opp != "") {
                if($pTrend > 0) {
                    if(($psd[1] > $psd[2]) && ($pmd[1] > $pmd[2]) && ($pld[1] > $pld[2])) {
                        if($p3ema_1[1] > $p8ema_2[1]) {
                            if($p8ema_2[1] > $p18ema_3[1]) {
                                if($p3ema_1[2] > $p8ema_2[2]) {
                                    if($p8ema_2[2] > $p18ema_3[2]) {
                                        $best_opp = "";
                                    }
                                }
                            }
                        } else {
                            if($pmacd[1] < $tRigger[1]) {
                                $best_opp = "";
                            } elseif($pmacd[2] > $tRigger[2]) {
                                $best_opp = "";
                            } else {
                                $best_opp = $result["symbol"];
                            }
                        }
                    } else {
                        $best_opp = "";
                    }
                }
                if($pTrend < 0) {
                    if(($psd[1] < $psd[2]) && ($pmd[1] < $pmd[2]) && ($pld[1] < $pld[2])) {
                        if($p3ema_1[1] < $p8ema_2[1]) {
                            if($p8ema_2[1] < $p18ema_3[1]) {
                                if($p3ema_1[2] < $p8ema_2[2]) {
                                    if($p8ema_2[2] < $p18ema_3[2]) {
                                        $best_opp = "";
                                    }
                                }
                            }
                        } else {
                            if($pmacd[1] > $tRigger[1]) {
                                $best_opp = "";
                            } elseif($pmacd[2] < $tRigger[2]) {
                                $best_opp = "";
                            } else {
                                $best_opp = $result["symbol"];
                            }
                        }
                    } else {
                        $best_opp = "";
                    }
                }
            }
//        }
    }
    
    if($best_opp == "") {
        echo "No Best Opportunity";
    } else {
        echo "Best Opportunity is " . $best_opp;
    }
    echo "<br />";
?>
