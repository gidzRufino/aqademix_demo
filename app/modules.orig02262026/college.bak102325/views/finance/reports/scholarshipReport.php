<?php
$styleArray = array(
        'alignment' => array(
            'horizontal'    => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,    
            'vertical'      => PHPExcel_Style_Alignment::VERTICAL_CENTER,   
            'wrap'          => TRUE
        )
    );

    $digitStyle = array(
        'alignment' =>  array(
            'horizontal'    =>  PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
        ),
        'font'  => array('bold' => TRUE),
        'borders' => array(
            'outline' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

$next = $school_year+1;            

$this->excel->setActiveSheetIndex(0);
$this->excel->getActiveSheet()->setTitle($school_year.'-'.($school_year+1));


    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    
    
    $this->excel->getActiveSheet()->setCellValue('A1', 'SCHOLARSHIP REPORT');
    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12);
    $this->excel->getActiveSheet()->setCellValue('A2', 'SY '.$school_year.'-'.($school_year+1));
    
    $this->excel->getActiveSheet()->setCellValue('A4', '#');
    $this->excel->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('B4', 'Scholarship / Discount Name');
    $this->excel->getActiveSheet()->getStyle('B4')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('C4', 'Total Amount');
    $this->excel->getActiveSheet()->getStyle('C4')->applyFromArray($styleArray);
    
    $y = 6;
    $seq = 0;
    foreach ($scholarship as $sc):
        $y++;
        $seq++;
        
        $this->excel->getActiveSheet()->setCellValue('A'.$y, $seq);
        $this->excel->getActiveSheet()->setCellValue('B'.$y, ($sc->schlr_id!=0?$sc->schlr_type:'UNAMED'));
        $this->excel->getActiveSheet()->getStyle('B'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $this->excel->getActiveSheet()->setCellValue('C'.$y, strtoupper($sc->totalAmount));
        $this->excel->getActiveSheet()->getStyle('C'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->excel->getActiveSheet()->getStyle('C'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $TOTAL += $sc->totalAmount;
        
    endforeach;
    
    $a = $y+2;
    
    $this->excel->getActiveSheet()->setCellValue('B'.$a, 'TOTAL');
    $this->excel->getActiveSheet()->getStyle('C'.$a)->applyFromArray($digitStyle);
    
    $this->excel->getActiveSheet()->setCellValue('C'.$a, $TOTAL);
    $this->excel->getActiveSheet()->getStyle('C'.$a)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $this->excel->getActiveSheet()->getStyle('C'.$a)->applyFromArray($digitStyle);