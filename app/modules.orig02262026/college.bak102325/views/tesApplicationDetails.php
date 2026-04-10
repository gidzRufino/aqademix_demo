<?php
        $this->excel->getActiveSheet()->setCellValue('A'.$y, $seq);
        $this->excel->getActiveSheet()->getStyle('A'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('B'.$y, '');
        
        $this->excel->getActiveSheet()->setCellValue('C'.$y, $s->stid);
        $this->excel->getActiveSheet()->getStyle('C'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $this->excel->getActiveSheet()->setCellValue('D'.$y, strtoupper($s->lastname));
        
        $this->excel->getActiveSheet()->setCellValue('E'.$y, strtoupper($s->firstname));
        
        $this->excel->getActiveSheet()->setCellValue('F'.$y, strtoupper($s->middlename));
        
        $this->excel->getActiveSheet()->setCellValue('G'.$y, strtoupper($s->sex));
        
        $this->excel->getActiveSheet()->setCellValue('H'.$y, strtoupper($s->temp_bdate));
        
        $this->excel->getActiveSheet()->setCellValue('I'.$y, strtoupper($s->course));
        
        $this->excel->getActiveSheet()->setCellValue('J'.$y, strtoupper($s->year_level));
        $this->excel->getActiveSheet()->getStyle('J'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('K'.$y, strtoupper($s->f_lastname));
        
        $this->excel->getActiveSheet()->setCellValue('L'.$y, strtoupper($s->f_firstname));
        
        $this->excel->getActiveSheet()->setCellValue('M'.$y, strtoupper($s->f_middlename));
        
        $this->excel->getActiveSheet()->setCellValue('N'.$y, strtoupper($s->m_lastname));
        
        $this->excel->getActiveSheet()->setCellValue('O'.$y, strtoupper($s->m_firstname));
        
        $this->excel->getActiveSheet()->setCellValue('P'.$y, strtoupper($s->m_middlename));
        
        $this->excel->getActiveSheet()->setCellValue('Q'.$y, '');
        
        $this->excel->getActiveSheet()->setCellValue('R'.$y, '');
        
        $street = ($s->street!=""?ucwords(strtolower($s->street)):ucwords(strtolower($s->barangay)));
        $this->excel->getActiveSheet()->setCellValue('S'.$y, $street);
        
        $this->excel->getActiveSheet()->setCellValue('T'.$y, ucwords(strtolower($s->mun_city)));
        
        $this->excel->getActiveSheet()->setCellValue('U'.$y, ucwords(strtolower($s->province)));
        
        $this->excel->getActiveSheet()->setCellValue('V'.$y, $s->zip_code);
        
        $this->excel->getActiveSheet()->setCellValue('W'.$y, $assessment->totalAssessment);
        $this->excel->getActiveSheet()->getStyle('W'.$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $this->excel->getActiveSheet()->setCellValue('X'.$y, '');
        