<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


    $this->excel->getActiveSheet()->setTitle('Payroll');
    $this->excel->getActiveSheet()->setCellValue('A1', 'PAYROLL');
    $this->excel->getActiveSheet()->mergeCells('A1:M1');
    $this->excel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);