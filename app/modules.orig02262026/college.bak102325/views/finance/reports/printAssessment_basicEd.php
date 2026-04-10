<?php
    $this->excel->getActiveSheet()->setCellValue('A'.$y, $seq);
    $this->excel->getActiveSheet()->getStyle('A'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $this->excel->getActiveSheet()->setCellValue('B'.$y, strtoupper($s->lastname.', '.$s->firstname));

    $this->excel->getActiveSheet()->setCellValue('C'.$y, strtoupper($s->level));
    $this->excel->getActiveSheet()->getStyle('C'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $this->excel->getActiveSheet()->getStyle('C'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $this->excel->getActiveSheet()->setCellValue('D'.$y, $assessment->totalTuition);
    $this->excel->getActiveSheet()->getStyle('D'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $this->excel->getActiveSheet()->getStyle('D'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $this->excel->getActiveSheet()->setCellValue('E'.$y, $assessment->otherFees);
    $this->excel->getActiveSheet()->getStyle('E'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $this->excel->getActiveSheet()->getStyle('E'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $this->excel->getActiveSheet()->setCellValue('F'.$y, ($assessment->specialClass!=0?$assessment->specialClass:''));
        $this->excel->getActiveSheet()->getStyle('F'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $this->excel->getActiveSheet()->getStyle('F'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $this->excel->getActiveSheet()->setCellValue('G'.$y, $assessment->assessmentBalance);
    $this->excel->getActiveSheet()->getStyle('G'.$y)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $this->excel->getActiveSheet()->getStyle('G'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        