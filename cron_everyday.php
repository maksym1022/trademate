<?php
    date_default_timezone_set('America/Chicago');
    // This script will be executed at 17:05 pm CST

    include("include/class.php");
    $obj = new admin();
    $obj->conn();
    
    $today_day = date(d);
    $today_month = date(m);
    $today_year = date(Y);
    
    $hour = date(H);
    
    if($hour < 17) {
        $yesterday_day = date('d', time() - 86400);
        $yesterday_month = date('m', time() - 86400);
        $yesterday_year = date('Y', time() - 86400);
        
        $startDate = $yesterday_year . $yesterday_month . $yesterday_day;
        $endDate = $yesterday_year . $yesterday_month . $yesterday_day . "170500";
        $endDate = $yesterday_year . $yesterday_month . $yesterday_day . "174500";
        $prediction_date = $today_year . "-" . $today_month . "-" . $today_day;
    } else {
        $startDate = $today_year . $today_month . $today_day;
        $endDate = $today_year . $today_month . $today_day . "170500";
        $endDate = $today_year . $today_month . $today_day . "174500";
        $prediction_date = date('Y', time() + 86400) . date('m', time() + 86400) . date('d', time() + 86400);
    }
    
//    $startDate = "20141028";
//    $endDate = "20141028170500";
//    $prediction_date = "2014-10-29";
    
    $qry = "select * from products order by group_id";
    $symbols = mysql_query($qry);
    
    while($result = mysql_fetch_array($symbols)) {
        $symbol_value = $result['symbol'];
        $contract = $result['app_friendly_name'];
        
        $data = file_get_contents("http://ondemand.websol.barchart.com/getHistory.csv?apikey=3833454a0d604bb425e301307514d8ca&type=daily&symbol=" . $symbol_value . "&startDate=" . $startDate . "&endDate=" . $endDate);
        
        if(strlen($data) > 2) {
            $dataAry = explode("\n", $data);
            
            $row = explode(",", $dataAry[1]);
            
            if($row[1] == '""') {
                $prediction_date = date('Y', time() + 86400) . date('m', time() + 86400) . date('d', time() + 86400);
//                $prediction_date = "2014-10-29";
                $qry = "UPDATE predictions SET prediction_date='$prediction_date' WHERE symbol='$symbol_value' AND trading_date <= '$prediction_date' order by trading_date desc limit 1";
                mysql_query($qry);
            }
            else {
                $value = mysql_fetch_array(mysql_query("SELECT * FROM historical_data WHERE tradingDay='$startDate' AND symbol='$symbol_value'"));
                if($value == "") {
                    $qry = "INSERT INTO historical_data (id, symbol, timestamp, tradingDay, open, high, low, close, volume, openInterest) values ('', '$symbol_value', $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8])";
                }
                else {
                    $qry = "UPDATE historical_data SET timestamp=$row[1], open=$row[3], high=$row[4], low=$row[5], close=$row[6], volume=$row[7], openInterest=$row[8] WHERE tradingDay='$startDate' AND symbol='$symbol_value'";
                }
                mysql_query($qry);
                
                //--------------------------  Predictions Data -----------------------------------
                
                $open = explode('"', $row[3]);
                $open = $open[1];
                $high = explode('"', $row[4]);
                $high = $high[1];
                $low = explode('"', $row[5]);
                $low = $low[1];
                $close = explode('"', $row[6]);
                $close = $close[1];
                
                /***
                *   ema_high : 10
                *   ema_low : 11
                *   ema_close : 12
                *   typical : 13
                *   sma_typical : 14
                *   ema_psd : 15
                *   sma_psd : 16
                *   ema_pmd : 17
                *   sma_pmd : 18
                *   ema_pld : 19
                *   sma_pld : 20
                *   ema_p3ema : 21
                *   ema_p8ema : 22
                *   ema_p18ema : 23
                *   ema_p12ema : 24
                *   ema_p26ema : 25
                *   pmacd : 26
                *   t_rigger : 27
                */
                
                // Getting Decimal
                $res1 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 1, 1"));
                $res2 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 2, 1"));
                $res3 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 3, 1"));
                $res4 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 4, 1"));
                $res5 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 5, 1"));
                $res6 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 6, 1"));
                $res7 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 7, 1"));
                $res8 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 8, 1"));
                $res9 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 9, 1"));
                $res10 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 10, 1"));
                $res11 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 11, 1"));
                $res12 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 12, 1"));
                $res13 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 13, 1"));
                $res14 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 14, 1"));
                $res15 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 15, 1"));
                $res16 = mysql_fetch_row(mysql_query("SELECT * FROM historical_data WHERE symbol='$symbol_value' ORDER BY id DESC LIMIT 16, 1"));
                
                $decimal = 0;
                $tmp = explode(".", $res1[10]);
                $length = strlen($tmp[1]);
                if($length > $decimal) {
                    $decimal = $length;
                }
                $tmp = explode(".", $res1[11]);
                $length = strlen($tmp[1]);
                if($length > $decimal) {
                    $decimal = $length;
                }
                $tmp = explode(".", $res1[12]);
                $length = strlen($tmp[1]);
                if($length > $decimal) {
                    $decimal = $length;
                }
                
                // EMA_HIGH AND P.HIGH
                $p = 2;
                $exp = 2 / (1 + $p);
                $ema_high = number_format(($res1[10] * (1 - $exp)) + ($high * $exp), $decimal, ".", "");
                $pHigh = $ema_high;
                // EMA_LOW AND P.LOW
                $ema_low = number_format(($res1[11] * (1 - $exp)) + ($low * $exp), $decimal, ".", "");
                $pLow = $ema_low;
                // EMA_CLOSE
                $ema_close = number_format(($res1[12] * (1 - $exp)) + ($close * $exp), $decimal, ".", "");
                // PHigh2+ for P.Trend
                $pHigh2 = number_format(($res1[10] * (1 - $exp)) + ($ema_high * $exp), $decimal, ".", "");
                //PLow2+ for P.Trend
                $pLow2 = number_format(($res1[11] * (1 - $exp)) + ($ema_low * $exp), $decimal, ".", "");
                //PClose2+ for P.Trend
                $pClose2 = number_format(($res1[12] * (1 - $exp)) + ($ema_close * $exp), $decimal, ".", "");
                //typical
                $typical = number_format(($high + $low + $close) / 3, $decimal, ".", "");
                //SMA Typical
                $sma_typical = number_format(($typical + $res1[14] + $res2[14]) / 3, $decimal, ".", "");
                //P.Trend
                $pTrend = number_format(($pHigh2 + $pLow2 + $pClose2) / 3 - $sma_typical, $decimal, ".", "");
                if($pTrend == 0) {
                    $temp = mysql_fetch_row(mysql_query("select p_trend from predictions where prediction_date = '$startDate' and symbol='$symbol_value'"));
                    $pTrend = $temp[0];
                }
                //PSD(1) and PSD(2)
                $p = 2;
                $exp = 2 / (1 + p);
                $ema_psd = number_format(($res1[15] * (1 - $exp)) + ($close * $exp), $decimal, ".", "");
                $sma_psd = number_format(($res4[7] + $res3[7] + $res2[7] + $res1[7] + $close) / 5, $decimal, ".", "");
                $sma_5_1 = number_format($res1[16] + $close / 5 - $res5[7] / 5, $decimal, ".", "");
                $sma_5_2 = number_format($res2[16] + $res1[7] / 5 - $res6[7] / 5, $decimal, ".", "");
                $psd[1] = number_format($ema_psd - $sma_5_1, $decimal, ".", "");
                $psd[2] = number_format($res1[15] - $sma_5_2, $decimal, ".", "");
                // PMD(1) and PMD(2)
                $p = 4;
                $exp = 2 / (1 + $p);
                $ema_pmd = number_format(($res1[17] * (1 - $exp)) + ($close * $exp), $decimal, ".", "");
                $p4ema2 = number_format(($res1[17] * (1 - $exp)) + ($ema_pmd * $exp), $decimal, ".", "");
                $sma_pmd = number_format(($res9[7] + $res8[7] + $res7[7] + $res6[7] + $res5[7] + $res4[7] + $res3[7] + $res2[7] + $res1[7] + $close) / 10, $decimal, ".", "");
                $sma_10_1 = number_format($res1[18] + $close / 10 - $res10[7] / 10, $decimal, ".", "");
                $sma_10_2 = number_format($res2[18] + $res1[7] / 10 - $res11[7] / 10, $decimal, ".", "");
                $pmd[1] = number_format($p4ema2 - $sma_10_1, $decimal, ".", "");
                $pmd[2] = number_format($ema_pmd - $sma_10_2, $decimal, ".", "");
                // PLD(1) and PLD(2)
                $p = 6;
                $exp = 2 / (1 + $p);
                $ema_pld = number_format(($res1[19] * (1 - $exp)) + ($close * $exp), $decimal, ".", "");
                $p6ema2 = number_format(($res1[19] * (1 - $exp)) + ($ema_pld * $exp), $decimal, ".", "");
                $p6ema3 = number_format(($ema_pld * (1 - $exp)) + ($p6ema2 * $exp), $decimal, ".", "");
                $sma_pld = number_format(($res14[7] + $res13[7] + $res12[7] + $res11[7] + $res10[7] + $res9[7] + $res8[7] + $res7[7] + $res6[7] + $res5[7] + $res4[7] + $res3[7] + $res2[7] + $res1[7] + $close) / 15, $decimal, ".", "");
                $sma_15_1 = number_format($res1[20] + $close / 15 - $res15[7] / 15, $decimal, ".", "");
                $sma_15_2 = number_format($res2[20] + $res1[7] / 15 - $res16[7] / 15, $decimal, ".", "");
                $pld[1] = number_format($p6ema3 - $sma_15_1, $decimal, ".", "");
                $pld[2] = number_format($p6ema2 - $sma_15_2, $decimal, ".", "");
                // P3EMA+1(1) and P3EMA+1(2)
                $p = 3;
                $exp = 2 / (1 + $p);
                $ema_p3ema = number_format(($res1[21] * (1 - $exp)) + ($typical * $exp), $decimal, ".", "");
                $p3ema_1[1] = $ema_p3ema;
                $p3ema_1[2] = $res1[21];
                // P8EMA+2(1) and P8EMA+2(2)
                $p = 8;
                $exp = 2 / (1 + $p);
                $ema_p8ema = number_format(($res1[22] * (1 - $exp)) + ($typical * $exp), $decimal, ".", "");
                $p8ema_2[1] = number_format(($res1[22] * (1 - $exp)) + ($ema_p8ema * $exp), $decimal, ".", "");
                $p8ema_2[2] = number_format(($res1[22] * (1 - $exp)) + ($typical * $exp), $decimal, ".", "");
                // P18EMA+3(1) and P18EMA+3(2)
                $p = 18;
                $exp = 2 / (1 + $p);
                $ema_p18ema = number_format(($res1[23] * (1 - $exp)) + ($typical * $exp), $decimal, ".", "");
                $p18ema_3[2] = number_format(($res1[23] * (1 - $exp)) + ($ema_p18ema * $exp), $decimal, ".", "");
                $p18ema_3[1] = number_format(($ema_p18ema * (1 - $exp)) + ($p18ema_3[2] * $exp), $decimal, ".", "");
                // PMACD(1) and PMACD(2)
                $p1 = 26;
                $exp1 = 2 / (1 + $p1);
                $p2 = 12;
                $exp2 = 2 / (1 + $p2);
                $ema_p26ema = number_format(($res1[25] * (1 - $exp1)) + ($typical * $exp1), $decimal, ".", "");
                $p26ema = $ema_p26ema;
                $ema_p12ema = number_format(($res1[24] * (1 - $exp2)) + ($typical * $exp2), $decimal, ".", "");
                $p12ema = $ema_p12ema;
                $pmacd[1] = number_format($p12ema - $p26ema, $decimal, ".", "");
                $pmacd[2] = number_format($res1[24] - $res1[25], $decimal, ".", "");
                // PMACD Trigger (tRigger)
                $p = 9;
                $exp = 2 / (1 + $p);
                $pmacd = number_format($p12ema - $p26ema, $decimal, ".", "");
                $tRigger = number_format(($res1[27] * (1 - $exp)) + ($pmacd * $exp), $decimal, ".", "");
                $tRigger_1 = $tRigger;
                $tRigger_2 = $res1[27];
                
                $qry = "UPDATE historical_data SET ema_high='$ema_high', ema_low='$ema_low', ema_close='$ema_close', typical='$typical', sma_typical='$sma_typical', ema_psd='$ema_psd', sma_psd='$sma_psd', ema_pmd='$ema_pmd', sma_pmd='$sma_pmd', ema_pld='$ema_pld', sma_pld='$sma_pld', ema_p3ema='$ema_p3ema', ema_p8ema='$ema_p8ema', ema_p18ema='$ema_p18ema', ema_p26ema='$ema_p26ema', ema_p12ema='$ema_p12ema', pmacd='$pmacd', t_rigger='$tRigger' WHERE tradingDay='$startDate' AND symbol='$symbol_value'";
                
                mysql_query($qry);
                
                $value = mysql_fetch_array(mysql_query("SELECT * FROM predictions WHERE trading_date='$startDate' AND symbol='$symbol_value'"));
                if($value == "") {
                    $qry = "insert into predictions (id, symbol, product_name, prediction_date, trading_date, p_high, p_low, p_trend, psd_1, psd_2, pmd_1, pmd_2, pld_1, pld_2, p3ema_1_1, p3ema_1_2, p8ema_2_1, p8ema_2_2, p18ema_3_1, p18ema_3_2, pmacd_1, pmacd_2, trigger_1, trigger_2) values ('', '$symbol_value', '$contract', '$prediction_date', '$startDate', '$pHigh', '$pLow', '$pTrend', '$psd[1]', '$psd[2]', '$pmd[1]', '$pmd[2]', '$pld[1]', '$pld[2]', '$p3ema_1[1]', '$p3ema_1[2]', '$p8ema_2[1]', '$p8ema_2[2]', '$p18ema_3[1]', '$p18ema_3[2]', '$pmacd[1]', '$pmacd[2]', '$tRigger_1', '$tRigger_2')";
                }
                else {
                    $qry = "UPDATE predictions SET p_high='$pHigh', p_low='$pLow', p_trend='$pTrend', psd_1='$psd[1]', psd_2='$psd[2]', pmd_1='$pmd[1]', pmd_2='$pmd[2]', pld_1='$pld[1]', pld_2='$pld[2]', p3ema_1_1='$p3ema_1[1]', p3ema_1_2='$p3ema_1[2]', p8ema_2_1='$p8ema_2[1]', p8ema_2_2='$p8ema_2[2]', p18ema_3_1='$p18ema_3[1]', p18ema_3_2='$p18ema_3[2]', pmacd_1='$pmacd[1]', pmacd_2='$pmacd[2]', trigger_1='$tRigger_1', trigger_2='$tRigger_2' WHERE trading_date='$startDate' AND symbol='$symbol_value'";
                }
                mysql_query($qry);
            }
            
        }
    }
?>
