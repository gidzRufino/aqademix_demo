<?php

    $styleArray = array(
        'alignment' => array(
            'horizontal'    => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,    
            'vertical'      => PHPExcel_Style_Alignment::VERTICAL_CENTER,   
            'wrap'          => TRUE
        )
    );

    $next = $school_year+1;            

    $this->excel->setActiveSheetIndex(0);
    $this->excel->getActiveSheet()->setTitle($school_year.'-'.($school_year+1));

    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
    
    
    $this->excel->getActiveSheet()->setCellValue('A1', 'ASSESSMENT - '. strtoupper($department));
    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12);
    $this->excel->getActiveSheet()->setCellValue('A2', 'SY '.$school_year.'-'.($school_year+1));
    $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(12);
    $this->excel->getActiveSheet()->setCellValue('A3', strtoupper($sem));
    
    $this->excel->getActiveSheet()->setCellValue('A5', '#');
    $this->excel->getActiveSheet()->getStyle('A5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('B5', 'NAMES');
    $this->excel->getActiveSheet()->getStyle('B5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('C5', 'GRADE LEVEL');
    $this->excel->getActiveSheet()->getStyle('C5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('D5', 'TOTAL TUITION');
    $this->excel->getActiveSheet()->getStyle('D5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('E5', 'OTHER FEES');
    $this->excel->getActiveSheet()->getStyle('E5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('F5', 'SPECIAL CLASS');
    $this->excel->getActiveSheet()->getStyle('F5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('G5', 'ASSESSMENT');
    $this->excel->getActiveSheet()->getStyle('G5')->applyFromArray($styleArray);