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
    $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
    $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
    
    
    $this->excel->getActiveSheet()->setCellValue('A1', 'ASSESSMENT - COLLEGE');
    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12);
    $this->excel->getActiveSheet()->setCellValue('A2', 'SY '.$school_year.'-'.($school_year+1));
    $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(12);
    $this->excel->getActiveSheet()->setCellValue('A3', strtoupper($sem));
    
    $this->excel->getActiveSheet()->setCellValue('A5', '#');
    $this->excel->getActiveSheet()->getStyle('A5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('B5', 'NAMES');
    $this->excel->getActiveSheet()->getStyle('B5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('C5', 'Course');
    $this->excel->getActiveSheet()->getStyle('C5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('D5', 'Units Enrolled');
    $this->excel->getActiveSheet()->getStyle('D5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('E5', 'PER UNIT');
    $this->excel->getActiveSheet()->getStyle('E5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('F5', 'TOTAL TUITION');
    $this->excel->getActiveSheet()->getStyle('F5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('G5', 'OTHER FEES');
    $this->excel->getActiveSheet()->getStyle('G5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('H5', 'LAB. FEE');
    $this->excel->getActiveSheet()->getStyle('H5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('I5', '# OF SUBJECTS');
    $this->excel->getActiveSheet()->getStyle('I5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('J5', 'PER SUBJECT');
    $this->excel->getActiveSheet()->getStyle('J5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('K5', 'EXAM FEES');
    $this->excel->getActiveSheet()->getStyle('K5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('L5', 'SPECIAL CLASS');
    $this->excel->getActiveSheet()->getStyle('L5')->applyFromArray($styleArray);
    $this->excel->getActiveSheet()->setCellValue('M5', 'ASSESSMENT');
    $this->excel->getActiveSheet()->getStyle('M5')->applyFromArray($styleArray);