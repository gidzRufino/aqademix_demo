<?php

        $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

        $redBG = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'bold'  => true,
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF0000')
            ),
            'font'  => array(
                'color' => array('rgb' => 'FFFFFF'),
                'bold'  => true,
            ),
            'alignment' => array(
                'horizontal'    => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,    
                'vertical'      => PHPExcel_Style_Alignment::VERTICAL_CENTER,   
                'wrap'          => TRUE
            )
        );

        $blueBG = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'bold'  => true,
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '3443EB')
            ),
            'font'  => array(
                'color' => array('rgb' => 'FFFFFF'),
                'bold'  => true,
            ),
            'alignment' => array(
                'horizontal'    => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,    
                'vertical'      => PHPExcel_Style_Alignment::VERTICAL_CENTER,   
                'wrap'          => TRUE
            )
        );
         
        
        $next = $school_year+1;            
                
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($school_year.'-'.($school_year+1));
        
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
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
        
        $this->excel->getActiveSheet()->setCellValue('A1', 'HEI Name:');
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->setCellValue('B1', strtoupper($settings->set_school_name));
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('FF0000');
        
        $this->excel->getActiveSheet()->setCellValue('A2', 'HEI UII:');
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->setCellValue('B2', '10067');
        $this->excel->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('FF0000');
        
        $this->excel->getActiveSheet()->setCellValue('A3', 'Acad Year:');
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->setCellValue('B3', $school_year.'-'.($school_year+1));
        $this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('FF0000');
        
    //HEADER TITLE
        
        $this->excel->getActiveSheet()->setCellValue('A5', 'SEQ');
        $this->excel->getActiveSheet()->mergeCells('A5:A6');
        $this->excel->getActiveSheet()->getStyle('A5:A6')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('B5', 'LEARNER\'S REFERENCE NO.');
        $this->excel->getActiveSheet()->mergeCells('B5:B6');
        $this->excel->getActiveSheet()->getStyle('B5:B6')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('C5', 'STUDENT ID');
        $this->excel->getActiveSheet()->mergeCells('C5:C6');
        $this->excel->getActiveSheet()->getStyle('C5:C6')->applyFromArray($redBG);
        
        $this->excel->getActiveSheet()->setCellValue('D5', 'STUDENT\'S NAME');
        $this->excel->getActiveSheet()->mergeCells('D5:F5');
        $this->excel->getActiveSheet()->getStyle('D5:F5')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('D6', 'LAST NAME');
        $this->excel->getActiveSheet()->getStyle('D6')->applyFromArray($redBG);
        
        $this->excel->getActiveSheet()->setCellValue('E6', 'GIVEN NAME');
        $this->excel->getActiveSheet()->getStyle('E6')->applyFromArray($redBG);
        
        $this->excel->getActiveSheet()->setCellValue('F6', 'MIDDLE NAME');
        $this->excel->getActiveSheet()->getStyle('F6')->applyFromArray($blueBG);
        
        
        $this->excel->getActiveSheet()->setCellValue('G5', 'STUDENT\'S NAME');
        $this->excel->getActiveSheet()->mergeCells('G5:J5');
        $this->excel->getActiveSheet()->getStyle('G5:J5')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('G6', '  SEX   '
                . '(Male or Female)');
        $this->excel->getActiveSheet()->getStyle('G6')->applyFromArray($redBG);
        
        $this->excel->getActiveSheet()->setCellValue('H6', 'BIRTHDATE (dd/mm/yyyy)');
        $this->excel->getActiveSheet()->getStyle('H6')->applyFromArray($redBG);
        
        $this->excel->getActiveSheet()->setCellValue('I6', 'COMPLETE PROGRAM NAME (Should be consistent with your HEI Registry)');
        $this->excel->getActiveSheet()->getStyle('I6')->applyFromArray($redBG);
        
        $this->excel->getActiveSheet()->setCellValue('J6', 'YEAR LEVEL (1,2,3,4,5)');
        $this->excel->getActiveSheet()->getStyle('J6')->applyFromArray($redBG);
        
        
        $this->excel->getActiveSheet()->setCellValue('K5', 'FATHER\'S NAME');
        $this->excel->getActiveSheet()->mergeCells('K5:M5');
        $this->excel->getActiveSheet()->getStyle('K5:M5')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('K6', 'LAST NAME');
        $this->excel->getActiveSheet()->getStyle('K6')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('L6', 'GIVEN NAME');
        $this->excel->getActiveSheet()->getStyle('L6')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('M6', 'MIDDLE NAME');
        $this->excel->getActiveSheet()->getStyle('M6')->applyFromArray($blueBG);
        
        
        $this->excel->getActiveSheet()->setCellValue('N5', 'MOTHER\'S MAIDEN NAME');
        $this->excel->getActiveSheet()->mergeCells('N5:P5');
        $this->excel->getActiveSheet()->getStyle('N5:P5')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('N6', 'LAST NAME');
        $this->excel->getActiveSheet()->getStyle('N6')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('O6', 'GIVEN NAME');
        $this->excel->getActiveSheet()->getStyle('O6')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('P6', 'MIDDLE NAME');
        $this->excel->getActiveSheet()->getStyle('P6')->applyFromArray($blueBG);
        
        
        $this->excel->getActiveSheet()->setCellValue('Q5', 'DSWD HOUSEHOLD NO.');
        $this->excel->getActiveSheet()->mergeCells('Q5:Q6');
        $this->excel->getActiveSheet()->getStyle('Q5:Q6')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('R5', 'HOUSEHOLD PER CAPITA INCOME');
        $this->excel->getActiveSheet()->mergeCells('R5:R6');
        $this->excel->getActiveSheet()->getStyle('R5:R6')->applyFromArray($blueBG);
        
        
        $this->excel->getActiveSheet()->setCellValue('S5', 'PERMANENT ADDRESS');
        $this->excel->getActiveSheet()->mergeCells('S5:V5');
        $this->excel->getActiveSheet()->getStyle('S5:V5')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('S6', 'STREET & BARANGAY');
        $this->excel->getActiveSheet()->getStyle('S6')->applyFromArray($redBG);
        
        $this->excel->getActiveSheet()->setCellValue('T6', 'TOWN/CITY/MUN');
        $this->excel->getActiveSheet()->getStyle('T6')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('U6', 'PROVINCE');
        $this->excel->getActiveSheet()->getStyle('U6')->applyFromArray($blueBG);
        
        $this->excel->getActiveSheet()->setCellValue('V6', 'ZIPCODE (TES Applicant)');
        $this->excel->getActiveSheet()->getStyle('V6')->applyFromArray($redBG);
        
        
        $this->excel->getActiveSheet()->setCellValue('W5', 'TOTAL ASSESSMENT (Semester)');
        $this->excel->getActiveSheet()->mergeCells('W5:W6');
        $this->excel->getActiveSheet()->getStyle('W5:W6')->applyFromArray($redBG);
        
        
        $this->excel->getActiveSheet()->setCellValue('X5', 'DISABILITY');
        $this->excel->getActiveSheet()->mergeCells('X5:X6');
        $this->excel->getActiveSheet()->getStyle('X5:X6')->applyFromArray($blueBG);
        