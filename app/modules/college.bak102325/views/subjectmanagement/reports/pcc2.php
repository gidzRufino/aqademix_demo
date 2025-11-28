<?php

//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
      

        $this->Ln(5);
        $this->SetFont('timesI', 'B', 21, '', false);
        $this->MultiCell(185, 2, 'Philippine Countryville College', '', 'C', 0, 0, '', '', true);
        $this->MultiCell(10, 10, ' ', '', 'L', 0, 0, '', '', true);
        $this->Ln(9);
        $this->SetFont('helvetica', 'B', 10);
        $this->MultiCell(185, 2, '8714 Panadtalan, Maramag, Bukidnon', '', 'C', 0, 0, '', '', true);
        $this->MultiCell(10, 10, ' ', '', 'L', 0, 0, '', '', true);
        $this->Ln();
        // Logo
        //$image_file = K_PATH_IMAGES . 'ppcs.png';
        //  $this->Image($image_file, 20, 10, 180, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



$pdf->AddPage();
// define style for border
$border_style = array('all' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));


$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(185, 10, 'REGISTRAR`S COPY ', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 10, ' ', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(12, 2, 'Name:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, ',', 'B', 'R', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, ',', 'B', 'R', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, ',', 'B', 'R', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(16, 2, 'Semester:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(21, 2, 'Course&Year:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, '', 'B', 'R', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, 'Control#:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(12, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, '(Last)', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, '(First)', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '(M.I)', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(16, 2, 'Status:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, '', 'B', 'R', 0, 0, '', '', true);
$pdf->MultiCell(13, 2, 'Gender:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, '', 'B', 'R', 0, 0, '', '', true);
$pdf->MultiCell(26, 2, 'Age:', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '', 'B', 'R', 0, 0, '', '', true);
$pdf->Ln(5);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(27, 2, 'Birthdate:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(56, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(3, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(18, 2, 'Birth Place:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(65, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->Ln(4);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(27, 2, 'Father`s Name:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(56, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(24, 2, 'Mother`s Name:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(60, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->Ln(4);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(27, 2, 'Address:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(156, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln(5);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'Parent`s Mobile No.:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(53, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(3, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(32, 2, 'Student`s Mobile No.:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(63, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->Ln(4);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(39, 2, 'Name of Spouse if Married:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(44, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(29, 2, 'Address of Spouse:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(66, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->Ln(5);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(38, 2, 'School Last Attended:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(20, 2, 'Elementary:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(24, 2, 'Year Graduated:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln(4);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(38, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(20, 2, 'High School:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(24, 2, 'Year Graduated:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln(8);



$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 5, 'COURSE NO.', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'DESCRIPTIVE TITLE', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'UNIT', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'DAY', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'TIME', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'ROOM', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'INSTRUCTOR', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, 'GE 501', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Understanding the Self', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, 'GE 502', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Readings in Philippine History', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, 'GE 503', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'The Contemporary World', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, 'GE 504', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Mathematics in the Modern World', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, 'IT 102', 1, 'C', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 7);
$pdf->MultiCell(55, 5, 'Computer Programming & Problem Solving 1', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, 'IC 101', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'PCC Institutional Course', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, 'VEd 101', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Values education', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, 'NSTP 1', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'LTS/CWTS/ROTC', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, 'GE 505', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Living in the IT Era', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, 'PE 1', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Fundamentals of Martial Arts', 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Day', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Time', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Room', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Instructor', 1, 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'TOTAL', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln(8);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(40, 2, 'FINANCIAL AGGREEMENT:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(97, 2, 'I promise to abide faithfully by the schedule of payment this semester.', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(47, 2, 'Source of Information', 'TLR', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(40, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(97, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(47, 2, '', 'LR', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(40, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(97, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(47, 2, '', 'LR', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(97, 2, 'AGGREEMENT BETWEEN THE STUDENT/PARENTS AND SCHOOL:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(47, 2, 'about PCC', 'LR', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(107, 3, '1. Entrance Fee will not be refunded if ever you will not pursue/continue your studies.', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 3, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 2, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, 'Radio', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(27, 2, '', 'R', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(112, 3, '2. Entrance documents such as card, certificate of good moral character, and other pertinent documents.', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 3, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 2, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(27, 2, 'Career Guidance', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '', 'R', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(92, 3, '   will no longer be taken if ever you will not dropped officially on the scheduled date.', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(45, 3, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 2, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(27, 2, 'Friends', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '', 'R', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(107, 3, '3. If ever you will not officially dropped on the schedule date, you are oblige to pay the whole semester.', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 3, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 2, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(27, 2, 'Family Members', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '', 'R', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(117, 3, '4. Entrance documents for temporary enrolled students will be submitted 1 month after the date of enrollment.', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(20, 3, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 2, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(27, 2, 'others', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '', 'BR', 'C', 0, 0, '', '', true);
$pdf->Ln(10);

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(92, 3, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(45, 3, '', 'B', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 2, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(27, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '', '', 'C', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(92, 3, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(45, 3, 'STUDENTS / PARENTS SIGNATURE', '', 'C', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 2, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(27, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln(20);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 2, 'Date:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, 'Student`s Signature:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(16, 2, 'Registrar:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(14, 2, 'Cashier:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(185, 2, '', 'B', 'L', 0, 0, '', '', true);

$pdf->Ln();



// Close and output PDF document
// This method has several options, check the source code documentation for more information.
// reset pointer to the last page
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
