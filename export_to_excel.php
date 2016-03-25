<?php
    include("include/class.php");
    include("Classes/PHPExcel.php");
    
    $obj = new admin;
    $obj->conn();
    
//    $idArray = $_REQUEST['idArray'];
    if(isset($_REQUEST['product_name']) && isset($_REQUEST['gid']) ) {
        $name = $_REQUEST['product_name'];
        $gid = $_REQUEST['gid'];
        if($name != false && $gid != false)
        {
            $query = "select * from products where group_id='$gid' and app_friendly_name like '%$name%' order by group_id";
        }
        else if($name != false)
        {
            $query = "select * from products where app_friendly_name like '%$name%' order by group_id";
        }
        else if($gid != false)
        {
            $query = "select * from products where group_id='$gid' order by group_id";
        }
        else
        {
            $query = "select * from products order by group_id";
        }
    }
    /*$query = "select * from products where id=" . $idArray[0];
    
    if(count($idArray) > 1)
        for($i = 1; $i < count($idArray); $i ++) {
            $query .= " or id=" . $idArray[$i];
        }
        
    $query .= " order by group_id";*/
        
    $result = mysql_query($query) or die(mysql_error());
    
    $rowCount = 1;
    
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    
//    $title = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB");
    $title = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T");

    $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
    
    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "PRODUCT NAME");
    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "SYMBOL");
    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "GROUP NAME");
    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "TRADING DAY");
    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "OPEN");
    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "HIGH");
    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "LOW");
    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, "CLOSE");
    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, "TIME OF IMPORT");
    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, "P.HIGH");
    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, "P.TREND");
    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, "P.LOW");
    $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, "PSD");
    $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, "PMD");
    $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "PLD");
    $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, "P3EMA+1");
    $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, "P8EMA+2");
    $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, "P18EMA+3");
    $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, "PMACD");
    $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, "TRIGGER");
    /*$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, "PSD(1)");
    $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, "PSD(2)");
    $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "PMD(1)");
    $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, "PMD(2)");
    $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, "PLD(1)");
    $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, "PLD(2)");
    $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, "P3EMA+1(1)");
    $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, "P3EMA+1(2)");
    $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, "P8EMA+2(1)");
    $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, "P8EMA+2(2)");
    $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, "P18EMA+3(1)");
    $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, "P18EMA+3(2)");
    $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, "PMACD(1)");
    $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, "PMACD(2)");
    $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, "TRIGGER(1)");
    $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, "TRIGGER(2)");*/
    
    $rowCount++;
    
    while($row = mysql_fetch_array($result)) {
        $symbol = $row['symbol'];
        $gid = $row['group_id'];
        
        $res = mysql_fetch_array(mysql_query("select * from groups where id=$gid"));
        
        $val = mysql_fetch_array(mysql_query("select * from predictions where symbol='$symbol' order by trading_date desc limit 1"));
        $val1 = mysql_fetch_array(mysql_query("select * from predictions where symbol='$symbol' order by trading_date desc limit 1, 1"));
        
        /*$first_date = date('Y', time() - 86400) . "-" . date('m', time() - 86400) . "-" . date('d', time() - 86400);
        $second_date = date('Y', time() - 172800) . "-" . date('m', time() - 172800) . "-" . date('d', time() - 172800);*/
        
        $first_trading_day = $val['trading_date'];
        $second_trading_day = $val1['trading_date'];
        
        $res1 = mysql_fetch_array(mysql_query("select * from historical_data where tradingDay='$first_trading_day' and symbol='$symbol' order by tradingDay desc limit 1"));
        $res2 = mysql_fetch_array(mysql_query("select * from historical_data where tradingDay='$second_trading_day' and symbol='$symbol' order by tradingDay desc limit 1"));

        /*$second_tradingDay = $res2['tradingDay'];
                
        if($res1['tradingDay'] == $res2['tradingDay']) {
            $temp = mysql_fetch_array(mysql_query("select * from historical_data where tradingDay<'$second_tradingDay' and symbol='$symbol' order by tradingDay desc limit 1"));
            $second_tradingDay = $temp['tradingDay'];
            $res2 = mysql_fetch_array(mysql_query("select * from historical_data where tradingDay<='$second_tradingDay' and symbol='$symbol' order by tradingDay desc limit 1"));
        }
        
        $res3 = mysql_fetch_array(mysql_query("select * from predictions where symbol='$symbol' and prediction_date<='$first_date' order by prediction_date desc limit 1"));
        $res4 = mysql_fetch_array(mysql_query("select * from predictions where symbol='$symbol' and prediction_date<='$second_tradingDay' order by prediction_date desc limit 1"));*/
        
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['app_friendly_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['symbol']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $res['name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $res1['tradingDay']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $res1['open']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $res1['high']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $res1['low']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $res1['close']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $res1['tradingDay']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $val['p_high']);
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $val['p_trend']);
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $val['p_low']);
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $val['psd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $val['pmd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $val['pld_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $val['p3ema_1_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $val['p8ema_2_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $val['p18ema_3_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $val['pmacd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $val['trigger_1']);
/*        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $val['psd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $val['psd_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $val['pmd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $val['pmd_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $val['pld_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $val['pld_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $val['p3ema_1_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $val['p3ema_1_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $val['p8ema_2_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $val['p8ema_2_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $val['p18ema_3_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $val['p18ema_3_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $val['pmacd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $val['pmacd_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $val['trigger_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $val['trigger_2']);*/
        
        $objPHPExcel->getActiveSheet()->getStyle("D" . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("D" . $rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle("I" . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $rowCount++;
        
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "");
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "");
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "");
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $res2['tradingDay']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $res2['open']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $res2['high']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $res2['low']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $res2['close']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $res2['tradingDay']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $val1['p_high']);
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $val1['p_trend']);
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $val1['p_low']);
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $val1['psd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $val1['pmd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $val1['pld_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $val1['p3ema_1_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $val1['p8ema_2_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $val1['p18ema_3_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $val1['pmacd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $val1['trigger_1']);
/*        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $val1['psd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $val1['psd_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $val1['pmd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $val1['pmd_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $val1['pld_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $val1['pld_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $val1['p3ema_1_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $val1['p3ema_1_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $val1['p8ema_2_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $val1['p8ema_2_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $val1['p18ema_3_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $val1['p18ema_3_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $val1['pmacd_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $val1['pmacd_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $val1['trigger_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $val1['trigger_2']);*/
        $objPHPExcel->getActiveSheet()->mergeCells("A" . ($rowCount - 1) . ":A" . $rowCount);
        $objPHPExcel->getActiveSheet()->mergeCells("B" . ($rowCount - 1) . ":B" . $rowCount);
        $objPHPExcel->getActiveSheet()->mergeCells("C" . ($rowCount - 1) . ":C" . $rowCount);
        
        $objPHPExcel->getActiveSheet()->getStyle("A" . ($rowCount - 1) . ":A" . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A" . ($rowCount - 1) . ":A" . $rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B" . ($rowCount - 1) . ":B" . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B" . ($rowCount - 1) . ":B" . $rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("C" . ($rowCount - 1) . ":C" . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("C" . ($rowCount - 1) . ":C" . $rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("D" . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("D" . $rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle("I" . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $rowCount)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $rowCount++;
    }
    
    for($i = 0; $i < count($title); $i ++) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($title[$i])->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle($title[$i] . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($title[$i] . '1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($title[$i] . '1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
    }
    
    header('Content-Type: application/vnd.ms-excel'); 
    header('Content-Disposition: attachment;filename="Limesurvey_Results.xls"'); 
    header('Cache-Control: max-age=0');
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
//    $objWriter->save(str_replace('.php', 'export.xlsx', __FILE__));
    $objWriter->save('export.xlsx');
    
    /*$objPHPExcel = new PHPExcel();
    
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);

    $objPHPExcel->getActiveSheet()->setTitle('Test Stats');
    
    $query = "select * from products order by group_id";
    $result = mysql_query($query) or die(mysql_error());
    
    $rowCount = 1;
    
    while($row = mysql_fetch_array($result)){ 
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['app_friendly_name']); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['description']); 
        $rowCount++; 
    }
    
    header('Content-Type: application/vnd.ms-excel'); 
    header('Content-Disposition: attachment;filename="Limesurvey_Results.xls"'); 
    header('Cache-Control: max-age=0');
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
    $objWriter->save(str_replace('.php', '.xlsx', __FILE__));*/
    
    /*header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=File.xls"); 
    header("Content-Transfer-Encoding: binary ");
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
    $objWriter->setOffice2003Compatibility(true);
    $objWriter->save('php://output');*/
?>