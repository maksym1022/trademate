<?php
    include("include/class.php");
    include("Classes/PHPExcel.php");
    
    $obj = new admin;
    $obj->conn();
    
    $idArray = $_REQUEST['idArray'];
    $objPHPExcel = new PHPExcel();
    
    if(isset($idArray)) {
        for($i = 0; $i < count($idArray); $i ++) {
            $query = "select * from products where id='$idArray[$i]'";
            $res = mysql_fetch_row(mysql_query($query));
            $product_name = $res[1];
            $product_symbol = $res[9];
            
            $query = "select * from historical_data where symbol='$product_symbol' order by tradingDay desc";
            $value = mysql_query($query);
            
            $rowCount = 1;
            
            $objWorkSheet = $objPHPExcel->createSheet($i);
            $objPHPExcel->setActiveSheetIndex($i);
            $objPHPExcel->getActiveSheet()->setTitle($product_name);
            
            $title = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q");
            
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "SYMBOL");
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "TRADING DAY");
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "OPEN");
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "HIGH");
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "LOW");
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "CLOSE");
//            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "VOLUME");
//            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, "OPEN INTEREST");
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "P.HIGH");
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, "P.TREND");
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, "P.LOW");
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, "PSD");
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, "PMD");
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, "PLD");
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, "P3EMA+1");
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, "P8EMA+2");
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "P18EMA+3");
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, "PMACD");
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, "TRIGGER");
//            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, "P3EMA+1");
//            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, "P8EMA+");
//            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, "P18EMA");
//            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, "P12EMA");
//            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, "P26EMA");
//            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, "PEMACD");
//            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, "TRIGGER");
            
            $rowCount++;
            
            while($result = mysql_fetch_array($value)) {
                $tradingDay = $result['tradingDay'];
                $decimal = 0;
                $tmp = explode(".", $result['open']);
                $length = strlen($tmp[1]);
                if($length > $decimal) {
                    $decimal = $length;
                }
                $tmp = explode(".", $result['high']);
                $length = strlen($tmp[1]);
                if($length > $decimal) {
                    $decimal = $length;
                }
                $tmp = explode(".", $result['close']);
                $length = strlen($tmp[1]);
                if($length > $decimal) {
                    $decimal = $length;
                }
                $tmp = explode(".", $result['low']);
                $length = strlen($tmp[1]);
                if($length > $decimal) {
                    $decimal = $length;
                }
                $val = mysql_fetch_array(mysql_query("select * from predictions where symbol='$product_symbol' and trading_date='$tradingDay'"));
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $result['symbol']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $result['tradingDay']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $result['open']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $result['high']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $result['low']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $result['close']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $result['ema_high']);

                $exp = 2 / 3;
                $temp = mysql_fetch_array(mysql_query("select * from historical_data where symbol='$product_symbol' and tradingDay<'$tradingDay' order by tradingDay desc limit 1"));
                $temp2 = mysql_fetch_array(mysql_query("select * from historical_data where symbol='$product_symbol' and tradingDay<'$tradingDay' order by tradingDay desc limit 1, 1"));
                $temp3 = mysql_fetch_array(mysql_query("select * from historical_data where symbol='$product_symbol' and tradingDay<'$tradingDay' order by tradingDay desc limit 2, 1"));
                $p_high2 = number_format((($temp['ema_high'] * (1 - $exp)) + ($result['ema_high'] * $exp)), $decimal, ".", "");
                $p_low2 = number_format((($temp['ema_low'] * (1 - $exp)) + ($result['ema_low'] * $exp)), $decimal, ".", "");
                $p_close2 = number_format((($temp['ema_close'] * (1 - $exp)) + ($result['ema_close'] * $exp)), $decimal, ".", "");
                $p_trend = number_format((($p_high2 + $p_low2 + $p_close2) / 3 - $result['sma_typical']), $decimal, ".", "");
                if($p_trend == 0) {
                    $p_high2 = number_format((($temp2['ema_high'] * (1 - $exp)) + ($temp['ema_high'] * $exp)), $decimal, ".", "");
                    $p_low2 = number_format((($temp2['ema_low'] * (1 - $exp)) + ($temp['ema_low'] * $exp)), $decimal, ".", "");
                    $p_close2 = number_format((($temp2['ema_close'] * (1 - $exp)) + ($temp['ema_close'] * $exp)), $decimal, ".", "");
                    $p_trend = number_format((($p_high2 + $p_low2 + $p_close2) / 3 - $temp['sma_typical']), $decimal, ".", "");
                    if($p_trend == 0) {
                        $p_high2 = number_format((($temp3['ema_high'] * (1 - $exp)) + ($temp2['ema_high'] * $exp)), $decimal, ".", "");
                        $p_low2 = number_format((($temp3['ema_low'] * (1 - $exp)) + ($temp2['ema_low'] * $exp)), $decimal, ".", "");
                        $p_close2 = number_format((($temp3['ema_close'] * (1 - $exp)) + ($temp2['ema_close'] * $exp)), $decimal, ".", "");
                        $p_trend = number_format((($p_high2 + $p_low2 + $p_close2) / 3 - $temp2['sma_typical']), $decimal, ".", "");
                    }
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $p_trend);
                
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $result['ema_low']);
                
                $p = 2;
                $exp = 2 / (1 + p);
                $temp5 = mysql_fetch_array(mysql_query("select * from historical_data where symbol='$product_symbol' and tradingDay<'$tradingDay' order by tradingDay desc limit 4, 1"));
                $ema_psd = $result['ema_psd'];
                $sma_5_1 = number_format($temp['sma_psd'] + $result['close'] / 5 - $temp5['close'] / 5, $decimal, ".", "");
                $psd = number_format($ema_psd - $sma_5_1, $decimal, ".", "");
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $psd);
                
                $p = 4;
                $exp = 2 / (1 + $p);
                $temp10 = mysql_fetch_array(mysql_query("select * from historical_data where symbol='$product_symbol' and tradingDay<'$tradingDay' order by tradingDay desc limit 9, 1"));
                $ema_pmd = $result['ema_pmd'];
                $p4ema2 = number_format(($temp['ema_pmd'] * (1 - $exp)) + ($ema_pmd * $exp), $decimal, ".", "");
                $sma_10_1 = number_format($temp['sma_pmd'] + $result['close'] / 10 - $temp10['close'] / 10, $decimal, ".", "");
                $pmd = number_format($p4ema2 - $sma_10_1, $decimal, ".", "");
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $pmd);
                
                $p = 6;
                $exp = 2 / (1 + $p);
                $temp15 = mysql_fetch_array(mysql_query("select * from historical_data where symbol='$product_symbol' and tradingDay<'$tradingDay' order by tradingDay desc limit 14, 1"));
                $ema_pld = $result['ema_pld'];
                $p6ema2 = number_format(($temp['ema_pld'] * (1 - $exp)) + ($ema_pld * $exp), $decimal, ".", "");
                $p6ema3 = number_format(($ema_pld * (1 - $exp)) + ($p6ema2 * $exp), $decimal, ".", "");
                $sma_15_1 = number_format($temp['sma_pld'] + $result['close'] / 15 - $temp15['close'] / 15, $decimal, ".", "");
                $pld = number_format($p6ema3 - $sma_15_1, $decimal, ".", "");
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $pld);
                
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $result['ema_p3ema']);
                
                $p = 8;
                $exp = 2 / (1 + $p);
                $typical = number_format(($result['high'] + $result['low'] + $result['close']) / 3, $decimal, ".", "");
                $ema_p8ema = number_format(($temp['ema_p8ema'] * (1 - $exp)) + ($typical * $exp), $decimal, ".", "");
                $p8ema_2 = number_format(($temp['ema_p8ema'] * (1 - $exp)) + ($ema_p8ema * $exp), $decimal, ".", "");
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $p8ema_2);
                
                $p = 18;
                $exp = 2 / (1 + $p);
                $ema_p18ema = number_format(($temp['ema_p18ema'] * (1 - $exp)) + ($typical * $exp), $decimal, ".", "");
                $p18ema_3[2] = number_format(($temp['ema_p18ema'] * (1 - $exp)) + ($ema_p18ema * $exp), $decimal, ".", "");
                $p18ema_3[1] = number_format(($ema_p18ema * (1 - $exp)) + ($p18ema_3[2] * $exp), $decimal, ".", "");
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $p18ema_3[1]);
                
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $result['pmacd']);
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $result['t_rigger']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $result['ema_high']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $result['ema_low']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $result['ema_close']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $result['typical']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $result['sma_typical']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $result['ema_psd']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $result['sma_psd']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $result['ema_pmd']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $result['sma_pmd']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $result['ema_pld']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $result['sma_pld']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $result['ema_p3ema']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $result['ema_p8ema']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $result['ema_p18ema']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $result['ema_p12ema']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $result['ema_p26ema']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $result['pmacd']);
//                $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $result['t_rigger']);
                
                $rowCount++;
            }
            for($j = 0; $j < count($title); $j ++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($title[$j])->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getStyle($title[$j] . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle($title[$j] . '1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle($title[$j] . '1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            }
        }
    }
    
    header('Content-Type: application/vnd.ms-excel'); 
    header('Content-Disposition: attachment;filename="Limesurvey_Results.xls"'); 
    header('Cache-Control: max-age=0');
    
    $objPHPExcel->setActiveSheetIndex(0);
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
    $objWriter->save('historical_data.xlsx');
    
?>
