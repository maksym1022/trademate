<?php
    include("include/class.php");
    include("Classes/PHPExcel.php");
    
    $obj = new admin();
    $obj->conn();
    
    $query = "select * from signup order by id";
    
    $result = mysql_query($query) or die(mysql_error());
    
    $rowCount = 1;
    
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    
    $title = array("A", "B", "C", "D", "E", "F", "G");
    
    $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
    
    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "NAME");
    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "COUNTRY");
    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "MOBILE PHONE");
    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "JOINED DATE");
    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, "STATUS");
    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, "EMAIL");
    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "PASSWORD");
    
    $rowCount++;
    
    while($row = mysql_fetch_array($result)) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['country']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['mobile']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['joined_on']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['status']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row['email']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row['password']);
        
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
    $objWriter->save('users.xlsx');
?>
