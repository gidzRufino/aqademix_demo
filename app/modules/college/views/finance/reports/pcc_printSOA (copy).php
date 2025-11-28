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

        $image_file = K_PATH_IMAGES . 'pccS.jpg';
        $this->Image($image_file, 20, 10, 30, '', 'jpg', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->SetFont('times', '', 15);
        $this->MultiCell(15, 5, '', 'TB', 'L', 0, 0, '', '', true);
        $this->MultiCell(135, 5, 'PHILIPPINE COUNTRYVILLE COLLEGE,  INC.', 'TB', 'L', 0, 0, '', '', true);
        $this->Ln();

        $this->SetFont('helvetica', 'B', 8);
        $this->MultiCell(30, 5, '', '', 'L', 0, 0, '', '', true);
        $this->MultiCell(150, 5, 'P-2B, SAYRE HIGHWAY, PANADTALAN, MARAMAG, BUKIDNON', '', 'C', 0, 0, '', '', true);
        $this->Ln();

        $this->SetFont('helvetica', 'B', 8);
        $this->MultiCell(20, 5, '', '', 'C', 0, 0, '', '', true);
        $this->MultiCell(160, 5, 'MARAMAG, 8714', '', 'C', 0, 0, '', '', true);
        $this->Ln();
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
$pdf->Ln(5);

$pdf->SetFont('times', 'B', 12);
$pdf->MultiCell(35, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(70, 5, 'Statement of Account ', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(35, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(70, 5, 'First Semester School year 2018-2019', '', 'C', 0, 0, '', '', true);
$pdf->Ln(12);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(24, 5, 'NAME:', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(16, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(57, 5, 'SILAYA, LOVELY ANN M. ', '', 'L', 0, 0, '', '', true);

$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(40, 5, 'COURSE & YEAR:', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'BSCRIM - 1', '', 'L', 0, 0, '', '', true);
$pdf->Ln(10);


$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(60, 5, 'Date', 'TB', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Particulars', 'TB', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Charges', 'TB', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Payments', 'TB', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, 'Balance', 'TB', 'L', 0, 0, '', '', true);
$pdf->Ln();


$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(185, 5, '', 'T', 'L', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln(0);


$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Beginning Balance', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Tuition', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Entrance Fee', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'ROTC', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'P.E 1', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Misc, Fees', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Computer Laboratory', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'BSCRIM, LABORATORY', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'SCHOOL ID', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'LIBRARY ID', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'CANAAN FEE', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'GPTCA FEE', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Internet', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Demo Room', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Publishing Fee', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Subsidy', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'PRESAA FEE', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'TYPING LAB FEE', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'GMT SCHOLARSHIP', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();


$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'STUFAP SCHOLARSHIP', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(60, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'DOLE SCHOLARSHIP', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(60, 5, '', 'T', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, 'Total Charges/Payments', 'T', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(30, 5, '-', 'T', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, '-', 'T', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 5, '-', 'T', 'L', 0, 0, '', '', true);
$pdf->Ln(0);

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(185, 5, '', 'B', 'L', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln(30);




$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(60, 2, 'Prepared By:', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(40, 5, '', 'B', 'L', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(40, 2, 'ARIANE M. LAZO', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(40, 2, 'B.O CASHIER', '', 'C', 0, 0, '', '', true);
$pdf->Ln(25);




// Close and output PDF document
// This method has several options, check the source code documentation for more information.
// reset pointer to the last page
$pdf->lastPage();
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
