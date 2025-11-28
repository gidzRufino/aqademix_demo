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

        // Logo
        $image_file = K_PATH_IMAGES . 'lc2.png';
        $this->Image($image_file, 25, 5, 160, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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



$pdf->MultiCell(10, 5, ' ', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(12, 2, 'NAME:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, ',', 'B', 'R', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, ',', 'B', 'R', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, ',', 'B', 'R', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, 'DATE OF BIRTH:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(11, 2, 'YEAR', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '', 'B', 'R', 0, 0, '', '', true);
$pdf->MultiCell(13, 2, 'MONTH', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, '', 'B', 'R', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(12, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, '(Last)', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, '(First)', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '(M.I)', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(33, 2, 'DAY', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(3, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, '', 'B', 'R', 0, 0, '', '', true);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(27, 2, 'PLACE OF BIRTH:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(44, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(21, 2, 'CITIZENSHIP:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(1, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(9, 2, 'SEX:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(20, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(27, 2, 'HOME ADDRESS:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(44, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, 'TEL. NO.:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(31, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 2, 'PARENTS:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, 'FATHER', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(47, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(21, 2, 'OCCUPATION', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(47, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(25, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, 'MOTHER', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(47, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(21, 2, 'OCCUPATION', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(47, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(54, 2, 'COMPLETED ELEMENTARY COURSE:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(44, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(8, 2, 'S.Y.', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(1, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(16, 2, 'GEN.AVE.', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(20, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(27, 2, 'SCHOOL:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(44, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, 'S.Y.', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(1, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(27, 2, 'YEAR & SECTION:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(45, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(27, 2, 'CURRICULUM:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(44, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, 'LRN:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(1, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->Ln(8);


$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(60, 5, 'SUBJECT', 'LTR', 'C', 0, 0, '', '', true);
$pdf->MultiCell(60, 5, 'PERIODIC RATING ', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'FINAL RATING', 'TR', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'ACTION TAKEN', 'TR', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();


$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(60, 5, '', 'BL', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '1', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '2', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '3', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '4', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', 'RB', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', 'RB', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, 'FILIPINO', '1', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, 'ENGLISH', '1', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, 'SCIENCE AND TECHNOLOGY', '1', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, 'MATHEMATICS', '1', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, 'ARALING PANLIPUNAN', '1', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(60, 5, 'TECHNOLOGY & LIVELIHOOD EDUCATION', '1', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(60, 5, 'MAPEH', '1', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'I', 8);
$pdf->MultiCell(60, 5, 'MUSIC', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, 'ARTS', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, 'PHYSICAL EDUCATION', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, 'HEALTH', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(60, 5, 'EDUKASYON SA PAGPAPAKATAO', '1', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(60, 5, 'FOREIGN LANGUAGE(BAHASA INDONESIA)', '1', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(60, 5, 'GENERAL AVERAGE', '1', 'L', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'BI', 9);
$pdf->MultiCell(40, 5, 'ATTENDANCE', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, 'JUN', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, 'JUL', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 5, 'AUG', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, 'SEP', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, 'OCT', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, 'NOV', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, 'DEC', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, 'JAN', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, 'FEB', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 5, 'MAR', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, 'APR', '1', 'C', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(13, 5, 'TOTAL', '1', 'C', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 5, 'ACCOMPLISHED BY', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(40, 5, 'DAYS OF SCHOOL', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(13, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(40, 5, 'DAYS PRESENT', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(9, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(13, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 5, '', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(5, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->Ln(10);



$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(40, 2, 'Has Advanced Units In:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln();
$pdf->MultiCell(40, 2, 'Lack Units In:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln();
$pdf->MultiCell(40, 2, 'To Be Classified As:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(60, 2, 'Total Number of Years in School to Date:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln(25);



$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(50, 5, 'FOR TRANSFER PURPOSES:', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(10, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(45, 5, 'I certify that this is a true record of', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(45, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(36, 5, 'This pupil is eligible on this ', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(15, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(11, 5, 'Day of', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(24, 5, 'For Admission to', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(35, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln();
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(90, 5, 'and he/she has no money or property responsibility in this school.', '', 'L', 0, 0, '', '', true);
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(140, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(40, 2, 'Rubyruth Marie G. Cayetano', 'B', 'R', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln();
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(145, 2, '', '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(30, 2, 'Registrar', '', 'C', 0, 0, '', '', true);
$pdf->Ln(10);

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(65, 5, 'Copy of this record is sent to Principal/Registrar of', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(85, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(80, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->MultiCell(6, 5, 'on', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, ',', 'B', 'R', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(75, 2, '(School & Address)', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, '(Date)', '', 'C', 0, 0, '', '', true);
$pdf->Ln(20);



// Close and output PDF document
// This method has several options, check the source code documentation for more information.
// reset pointer to the last page

$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
