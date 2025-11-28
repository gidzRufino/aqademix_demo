<?php
        $this->excel->getActiveSheet()->setCellValue('A'.$y, $seq);
        $this->excel->getActiveSheet()->getStyle('A'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('B'.$y, strtoupper($s->lastname.', '.$s->firstname));
        $this->excel->getActiveSheet()->setCellValue('C'.$y, strtoupper($s->short_code).'-'.$s->year_level);
        $this->excel->getActiveSheet()->setCellValue('D'.$y, $assessment->totalUnits);
        $this->excel->getActiveSheet()->getStyle('D'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('E'.$y, $assessment->perUnit);
        $this->excel->getActiveSheet()->getStyle('E'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        
        $this->excel->getActiveSheet()->setCellValue('F'.$y, $assessment->totalTuition);
        $this->excel->getActiveSheet()->getStyle('F'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->excel->getActiveSheet()->getStyle('F'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $this->excel->getActiveSheet()->setCellValue('G'.$y, $assessment->otherFees);
        $this->excel->getActiveSheet()->getStyle('G'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->excel->getActiveSheet()->getStyle('G'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $this->excel->getActiveSheet()->setCellValue('H'.$y, ($assessment->totalLabFee!=0?$assessment->totalLabFee:''));
        $this->excel->getActiveSheet()->getStyle('H'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->excel->getActiveSheet()->getStyle('H'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $this->excel->getActiveSheet()->setCellValue('I'.$y, $assessment->totalSubjects);
        $this->excel->getActiveSheet()->getStyle('I'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('J'.$y, $assessment->examFee);
        $this->excel->getActiveSheet()->getStyle('J'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->excel->getActiveSheet()->getStyle('J'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $this->excel->getActiveSheet()->setCellValue('K'.$y, $assessment->examFees);
        $this->excel->getActiveSheet()->getStyle('K'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->excel->getActiveSheet()->getStyle('K'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $this->excel->getActiveSheet()->setCellValue('L'.$y, ($assessment->specialClass!=0?$assessment->specialClass:''));
        $this->excel->getActiveSheet()->getStyle('L'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->excel->getActiveSheet()->getStyle('L'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $this->excel->getActiveSheet()->setCellValue('M'.$y, $assessment->assessmentBalance);
        $this->excel->getActiveSheet()->getStyle('M'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->excel->getActiveSheet()->getStyle('M'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        