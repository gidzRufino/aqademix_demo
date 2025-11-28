<?php

  $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
         
        
        $next = $school_year+1;            
        
        $this->excel->createSheet(1);
        $this->excel->setActiveSheetIndex(1);
        $this->excel->getActiveSheet()->setTitle('CWTS');
        
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        
        $this->excel->getActiveSheet()->setCellValue('A2', 'Republic of the Philippines');
        $this->excel->getActiveSheet()->mergeCells('A2:M2');
        $this->excel->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2:M2')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        
        $this->excel->getActiveSheet()->setCellValue('A3', 'Office of the President');
        $this->excel->getActiveSheet()->mergeCells('A3:M3');
        $this->excel->getActiveSheet()->getStyle('A3:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A3:M3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A3:M3')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
        
        $this->excel->getActiveSheet()->setCellValue('A4', 'COMMISSION ON HIGHER EDUCATION');
        $this->excel->getActiveSheet()->mergeCells('A4:M4');
        $this->excel->getActiveSheet()->getStyle('A4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A4:M4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A4:M4')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
        
        $this->excel->getActiveSheet()->setCellValue('A5', 'Office of the Student Services');
        $this->excel->getActiveSheet()->mergeCells('A5:M5');
        $this->excel->getActiveSheet()->getStyle('A5:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A5:M5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A5:M5')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
        
        $this->excel->getActiveSheet()->setCellValue('A7', 'ENROLLMENT LIST');
        $this->excel->getActiveSheet()->mergeCells('A7:M7');
        $this->excel->getActiveSheet()->getStyle('A7:M7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A7:M7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A7:M7')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->getRowDimension('7')->setRowHeight(20);
        
        $this->excel->getActiveSheet()->setCellValue('A8', $sem.' Academic Year '.$school_year.'-'.$next);
        $this->excel->getActiveSheet()->mergeCells('A8:M8');
        $this->excel->getActiveSheet()->getStyle('A8:M8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A7:M7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A8:M8')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->getRowDimension('8')->setRowHeight(20);
        
        $this->excel->getActiveSheet()->setCellValue('A10', 'Name of Institution: ');
        $this->excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->getRowDimension('10')->setRowHeight(20);
        $this->excel->getActiveSheet()->setCellValue('C10', $settings->set_school_name);
        $this->excel->getActiveSheet()->getStyle('C10')->getFont()->setSize(14);
        
        $this->excel->getActiveSheet()->setCellValue('A11', 'Address: ');
        $this->excel->getActiveSheet()->getStyle('A11')->getFont()->setBold(true)->setSize(14);
        $this->excel->getActiveSheet()->getRowDimension('11')->setRowHeight(20);
        $this->excel->getActiveSheet()->setCellValue('C11', $settings->set_school_address);
        $this->excel->getActiveSheet()->getStyle('C11')->getFont()->setSize(14);
        
        $this->excel->getActiveSheet()->setCellValue('A15', 'No.');
        $this->excel->getActiveSheet()->mergeCells('A15:A16');
        $this->excel->getActiveSheet()->getStyle('A15:A16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A15:A16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A15')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getRowDimension('15')->setRowHeight(30);
        $this->excel->getActiveSheet()->getStyle('A15:A16')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('B15', 'STUDENT');
        $this->excel->getActiveSheet()->mergeCells('B15:D15');
        $this->excel->getActiveSheet()->getStyle('B15:D15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B15:D15')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B15')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('B15:D15')->applyFromArray($styleArray); 
        
        $this->excel->getActiveSheet()->setCellValue('B16', 'Last Name');
        $this->excel->getActiveSheet()->getStyle('B16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B16')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('B16')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('C16', 'First Name');
        $this->excel->getActiveSheet()->getStyle('C16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('C16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('C16')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('C16')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('D16', 'Middle Name');
        $this->excel->getActiveSheet()->getStyle('D16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D16')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('D16')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('E15', 'COURSE');
        $this->excel->getActiveSheet()->getStyle('E15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('E15')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('E15')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('E15')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('F15', 'GENDER');
        $this->excel->getActiveSheet()->getStyle('F15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('F15')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('F15')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('F15')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('G15','Birthdate');
        $this->excel->getActiveSheet()->mergeCells('G15:I15');
        $this->excel->getActiveSheet()->getStyle('G15:I15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('G15:I15')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('G15:I15')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('G15:I15')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('G16', 'Month');
        $this->excel->getActiveSheet()->getStyle('G16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('G16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('G16')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('G16')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('H16', 'Day');
        $this->excel->getActiveSheet()->getStyle('H16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('H16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('H16')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('H16')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('I16', 'Day');
        $this->excel->getActiveSheet()->getStyle('I16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('I16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('I16')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('I16')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('J15', 'Address');
        $this->excel->getActiveSheet()->getStyle('J15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('J15')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('J15')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('J15')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('J16', 'St./Brgy./City');
        $this->excel->getActiveSheet()->getStyle('J16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('J16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('J16')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('J16')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('K15', '');
        $this->excel->getActiveSheet()->getStyle('K15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('K15')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('K15')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('K15')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('K16', 'Province');
        $this->excel->getActiveSheet()->getStyle('K16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('K16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('K16')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('K16')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('L15', 'Contact No');
        $this->excel->getActiveSheet()->getStyle('L15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('L15')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('L15')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('L15')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('M15', 'Email Address');
        $this->excel->getActiveSheet()->getStyle('M15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('M15')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('M15')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('M15')->applyFromArray($styleArray);
        
        
        $this->excel->getActiveSheet()->setCellValue('L10', 'Region');
        $this->excel->getActiveSheet()->getStyle('L10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('L10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('L10')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('L10')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('L11', 'NSTP Component');
        $this->excel->getActiveSheet()->getStyle('L11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('L11')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('L11')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('L11')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('M11', 'LTS');
        $this->excel->getActiveSheet()->getStyle('M11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('M11')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('M11')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('M11')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('L12', 'Specialization');
        $this->excel->getActiveSheet()->getStyle('L12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('L12')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('L12')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('L12')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('L13', 'School Year');
        $this->excel->getActiveSheet()->getStyle('L13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('L13')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('L13')->getFont()->setBold(true)->setSize(13);
        $this->excel->getActiveSheet()->getStyle('L13')->applyFromArray($styleArray);
        
        $this->excel->getActiveSheet()->setCellValue('M13', $school_year.'-'.$next);
        $this->excel->getActiveSheet()->getStyle('M13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('M13')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('M13')->getFont()->setSize(13);
        $this->excel->getActiveSheet()->getStyle('M13')->applyFromArray($styleArray);
        
        $m = 16;
        $i = 0;
        
        foreach ($subject_cwts->result() as $sub):
            $m++;
            $i++;
            $this->excel->getActiveSheet()->setCellValue('A'.$m, $i);
            $this->excel->getActiveSheet()->getStyle('A'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('A'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('B'.$m, ucfirst($sub->lastname));
            $this->excel->getActiveSheet()->getStyle('B'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('B'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('B'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('C'.$m, ucfirst($sub->firstname));
            $this->excel->getActiveSheet()->getStyle('C'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('C'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('C'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('D'.$m, ucfirst($sub->middlename));
            $this->excel->getActiveSheet()->getStyle('D'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('D'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('D'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('E'.$m, ucwords(strtolower($sub->course)));
            $this->excel->getActiveSheet()->getStyle('E'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('E'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('E'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('F'.$m, ucwords($sub->sex));
            $this->excel->getActiveSheet()->getStyle('F'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('F'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('F'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('G'.$m, date('F', strtotime($sub->cal_date)));
            $this->excel->getActiveSheet()->getStyle('G'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('G'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('H'.$m, date('d', strtotime($sub->cal_date)));
            $this->excel->getActiveSheet()->getStyle('H'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('H'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('H'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('H'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('I'.$m, date('Y', strtotime($sub->cal_date)));
            $this->excel->getActiveSheet()->getStyle('I'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('I'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('I'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('I'.$m)->applyFromArray($styleArray);
            
            $address = ($sub->street!=''?$sub->street.', '.$sub->barangay.', '.$sub->mun_city:$sub->barangay.', '.$sub->mun_city);
            
            $this->excel->getActiveSheet()->setCellValue('J'.$m, ucwords(strtolower($address)));
            $this->excel->getActiveSheet()->getStyle('J'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('J'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('J'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('J'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('K'.$m, ucwords(strtolower($sub->province)));
            $this->excel->getActiveSheet()->getStyle('K'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('K'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('K'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('K'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('L'.$m, ($sub->cd_mobile!=""?$sub->cd_mobile:"N/A"));
            $this->excel->getActiveSheet()->getStyle('L'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('L'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('L'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('L'.$m)->applyFromArray($styleArray);
            
            $this->excel->getActiveSheet()->setCellValue('M'.$m, ($sub->cd_email!=""?$sub->cd_email:"N/A"));
            $this->excel->getActiveSheet()->getStyle('M'.$m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('M'.$m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('M'.$m)->getFont()->setBold(false)->setSize(13);
            $this->excel->getActiveSheet()->getStyle('M'.$m)->applyFromArray($styleArray);
            
        endforeach;