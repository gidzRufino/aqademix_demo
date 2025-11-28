<?php

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        // Logo

        $image_file = K_PATH_IMAGES . '/pisd.png';
        $this->Image($image_file, 5, 2, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->SetFont('times', 'B', 9);
        $this->MultiCell(15, 5, '', '', 'R', 0, 0, '', '', true);
        $this->Ln();

        $this->SetTextColor(191, 121, 0);
        $this->MultiCell(15, 5, '', '', 'R', 0, 0, '', '', true);
        $this->MultiCell(120, 2, 'PRECIOUS INTERNATIONAL SCHOOL OF DAVAO', '', 'L', 0, 0, '', '', true);
        $this->SetTextColor(0, 0, 0, 100);
        $this->MultiCell(95, 7, ' OFFICIAL REPORT CARD', 'L', 'L', 0, 0, '', '', true);

        $this->SetFont('times', 'B', 8);
        $this->Ln(4);


        $this->MultiCell(15, 5, '', '', 'R', 0, 0, '', '', true);
        $this->MultiCell(120, 2, 'Cor. Santos Cuyugan - Maple Street, GSIS Heights, Matina, Davao City, Philippines', '', 'L', 0, 0, '', '', true);
        $this->SetFont('times', 'B', 8);
        $this->MultiCell(95, 5, ' K-to-12', 'L', 'L', 0, 0, '', '', true);

        $this->SetFont('times', 'B', 8);
        $this->Ln(0);
        $this->MultiCell(25, 5, '', '', 'R', 0, 0, '', '', true);
        $this->Ln(3);

        $this->MultiCell(15, 5, '', '', 'R', 0, 0, '', '', true);
        $this->MultiCell(120, 2, 'Government Recognition (R-XI) No. 05 S. 2012', '', 'L', 0, 0, '', '', true);
        $this->SetFont('times', 'B', 13);
        $this->MultiCell(95, 5, ' ', 'L', 'L', 0, 0, '', '', true);
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



// set font
$resolution = array(216, 330);
$pdf->AddPage('P', $resolution);

$settings = Modules::run('main/getSet');
$section = Modules::run('registrar/getSectionById', segment_4);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);
$students = Modules::run('registrar/getStudentForCard', segment_7, segment_6, segment_4);
$sy = $this->session->userdata('school_year');
$nxtYr = $sy + 1;

// -----------------------------------------------------------------------------
$x=0;
foreach ($students->result() as $mStudent):
$x++;
if($x==1):
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetTextColor(100, 0, 0, 0);
    $pdf->Cell(10, 5, 'NAME:', '', 'L', 1, 0, '', '', true);

    $pdf->SetTextColor(0, 0, 0, 100);
    $pdf->SetFont('times', 'B', 8);
    $pdf->Cell(60, 5, $mStudent->lastname . ', ' . $mStudent->firstname . ' ' . substr($mStudent->middlename, 0, 1), '', 'L', 1, 0, '', '', true);

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->Cell(30, 5, '', '', 'L', 0, 0, '', '', true);
    $pdf->SetTextColor(100, 0, 0, 0);
    $pdf->Cell(15, 5, 'LEVEL:', '', 'L', 0, 0, '', '', true);

    $pdf->SetTextColor(0, 0, 0, 100);
    $pdf->SetFont('times', 'B', 8);
    $pdf->Cell(90, 5, $section->level . ' - ' . $section->section, '', 'L', 1, 0, '', '', true);
    $pdf->Ln();


    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetTextColor(100, 0, 0, 0);
    $pdf->Cell(23, 5, 'ACADEMIC YEAR:', '', 'L', 1, 0, '', '', true);

    $pdf->SetTextColor(0, 0, 0, 100);
    $pdf->SetFont('times', 'B', 8);
    $pdf->Cell(34, 5, $sy . ' - ' . $nxtYr, '', 'L', 1, 0, '', '', true);

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->Cell(40, 5, '', '', 'L', 0, 0, '', '', true);
    $pdf->SetTextColor(100, 0, 0, 0);
    $pdf->Cell(18, 5, 'TEACHER:', '', 'L', 0, 0, '', '', true);

    $pdf->SetTextColor(0, 0, 0, 100);
    $pdf->SetFont('times', 'B', 8);
    $pdf->Cell(90, 5, 'PENASO, JOWANA ALEXIS V.', '', 'L', 1, 0, '', '', true);
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetTextColor(100, 0, 0, 0);
    $pdf->Cell(16, 5, '', '', 'C', 1, 0, '', '', true);
    $pdf->Cell(7, 5, 'LRN:', '', 'C', 1, 0, '', '', true);

    $pdf->SetTextColor(0, 0, 0, 100);
    $pdf->SetFont('times', 'B', 8);
    $pdf->Cell(72, 5, $mStudent->lrn, '', 'L', 1, 0, '', '', true);
    $pdf->Ln();

    $pdf->SetFont('times', 'B', 7);
    $pdf->MultiCell(35, 6.2, 'LEARNING AREAS', '1', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
    $pdf->MultiCell(24, 2, 'QUARTER', '1', 'C', 0, 0, '', '', true);
    $pdf->MultiCell(13, 2, 'FINAL', 'TLR', 'C', 0, 1, '', '', true);

    $pdf->MultiCell(6, 2, '1st', '1', 'C', 0, 0, '50', '', true);
    $pdf->MultiCell(6, 2, '2nd', '1', 'C', 0, 0, '56', '', true);
    $pdf->MultiCell(6, 2, '3rd', '1', 'C', 0, 0, '62', '', true);
    $pdf->MultiCell(6, 2, '4th', '1', 'C', 0, 0, '68', '', true);
    $pdf->MultiCell(14, 2, 'GRADE', 'RB', 'C', 0, 0, '73', '', true);
    $pdf->MultiCell(20, 6.4, 'REMARKS', '1', 'C', 0, 0, '87', '42', true, 0, false, true, 6, 'M');

    $pdf->SetFont('times', 'B', 7);
    $pdf->MultiCell(30, 6.2, 'DEPORTMENT', '1', 'C', 0, 0, '109', '', true, 0, false, true, 6, 'M');
    $pdf->SetFont('times', '', 7);
    $pdf->MultiCell(8, 6.2, '1st', '1', 'C', 0, 0, '139', '', true, 0, false, true, 6, 'M');
    $pdf->MultiCell(8, 6.2, '2nd', '1', 'C', 0, 0, '147', '', true, 0, false, true, 6, 'M');
    $pdf->MultiCell(8, 6.2, '3rd', '1', 'C', 0, 0, '155', '', true, 0, false, true, 6, 'M');
    $pdf->MultiCell(8, 6.2, '4th', '1', 'C', 0, 0, '163', '', true, 0, false, true, 6, 'M');

    $pdf->SetFont('times', '', 7);
    $pdf->MultiCell(45, 8, 'LEGEND', '', 'C', 0, 0, '160', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 8, '(Non-Academic /', '', 'C', 0, 0, '160', '', true, 0, false, true, 11, 'M');

    foreach ($subject_ids as $sp):
        $singleSub = Modules::run('academic/getSpecificSubjects', $sp->sub_id);
        $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, segment_5, $sy);
        if ($singleSub->parent_subject == 18):
            $grd += $finalGrade->row()->final_rating;
            $mp += 1;
        endif;
    endforeach;
    $fg = round($grd / $mp, 2);
    unset($grd);

    $m = 0;

    foreach ($subject_ids as $sub):
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
        $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, segment_5, $sy);
        $pdf->Ln();
        if ($singleSub->parent_subject != 11):
            //$pdf->SetX($x + 15);
            $pdf->MultiCell(35, 2, $singleSub->short_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
        else:
            $m++;
            if ($m == 1):
                $pdf->MultiCell(35, 2, "MAPEH", 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
                $pdf->MultiCell(6, 2, ($fg == 0) ? '' : $fg, 1, 'C', 0, 0, '50', '', true, 0, false, true, 5, 'T');
                $pdf->MultiCell(6, 2, "", 1, 'C', 0, 0, '56', '', true, 0, false, true, 0, 'T');
                $pdf->MultiCell(6, 2, "", 1, 'C', 0, 0, '62', '', true, 0, false, true, 0, 'T');
                $pdf->MultiCell(6, 2, "", 1, 'C', 0, 0, '68', '', true, 0, false, true, 0, 'T');
                $pdf->MultiCell(13, 2, "", 1, 'C', 0, 0, '74', '', true, 0, false, true, 0, 'T');
                $pdf->MultiCell(20, 2, "", 1, 'C', 0, 0, '87', '', true, 0, false, true, 0, 'T');
                $pdf->Ln();
                $pdf->MultiCell(35, 2, '           ' . $singleSub->short_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
            else:
                $pdf->MultiCell(35, 2, '           ' . $singleSub->short_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
            endif;
        endif;

        $margin = 50;
        for ($eks = 0; $eks < 5; $eks++) {
            $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $eks + 1, $sy);
            if ($eks == 4) {
                $pdf->MultiCell(13, 2, '', 1, 'C', 0, 0, 74, '', true, 0, false, true, 0, 'M');
            } else {
                if ($finalGrade->row()->final_rating != ""):
                    $pdf->MultiCell(6, 2, $finalGrade->row()->final_rating, 1, 'C', 0, 0, $margin, '', true, 0, false, true, 0, 'M');
                else:
                    $pdf->MultiCell(6, 2, '', 1, 'C', 0, 0, $margin, '', true, 0, false, true, 0, 'M');
                endif;
                if ($finalGrade->row()->final_rating >= 75):
                    $pdf->MultiCell(20, 2, 'PASSED', 1, 'C', 0, 0, '87', '', true, 0, false, true, 0, 'M');
                else:
                    $pdf->MultiCell(20, 2, 'FAILED', 1, 'C', 0, 0, '87', '', true, 0, false, true, 0, 'M');
                endif;
                $margin = $margin + 6;
            }
        }
        //$pdf->SetX($x + 2);


    endforeach;

    $mar = 48.3;

    $deportment = Modules::run('academic/getBHRate');
    foreach ($deportment as $dept):
        $pdf->SetFont('times', 'R', 7);
        $pdf->SetFillColor(200, 218, 247);
        if ($dept->bh_group == 1) {
            $pdf->MultiCell(30, 2, $dept->bh_name, '1', 'L', 0, 0, '109', $mar, true, 0, false, true, 5, 'M');
            $pdf->Ln();
        } elseif ($dept->bh_group == 2) {
            $pdf->MultiCell(30, 2, $dept->bh_name, '1', 'L', 0, 0, '109', $mar, true, 0, false, true, 5, 'M');
            $pdf->Ln();
            $sub = Modules::run('reports/getSubBH', 3);
            $marg = $mar + 4;
            foreach ($sub as $bus):
                $pdf->SetFont('times', 'I', 7);
                $pdf->SetFillColor(200, 218, 247);
                $pdf->MultiCell(30, 4, '       ' . $bus->bh_name, '1', 'L', 0, 0, '109', $marg, true, 0, false, true, 3.4, 'M');
                $marg = $marg + 4;
            endforeach;
        }


        $margin2 = 139;

        for ($why = 0; $why < 4; $why++) {
            $finalDeport = Modules::run('gradingsystem/gradingsystem_reports/getFinalBHRate', $mStudent->st_id, $dept->bh_id, $why + 1, $sy);
            $transmutedBh = Modules::run('gradingsystem/gradingsystem_reports/bhTransmutted', $finalDeport->rate);
            
            /*
              foreach ($bhTransmuted as $transmuted):
              if ($finalDeport->rate >= floatval($transmuted->from) || $finalDeport->rate <= floatval($transmuted->to)):
              $transmutedBh = $transmuted->transmutation;
              else:
              $transmutedBh = '';
              endif;
              endforeach; */
            $pdf->SetFont('times', 'B', 7);
            $pdf->MultiCell(8, 4, $transmutedBh, '1', 'C', 0, 0, $margin2, $mar, true, 0, false, true, 0, 'M');
            $margin2 = $margin2 + 8;
        }
        $mar = $mar + 4;
    endforeach;
   
    $pdf->Ln();
endif;
endforeach;

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
