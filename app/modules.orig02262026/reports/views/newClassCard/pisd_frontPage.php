<?php

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        // Logo

       
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
    }

}

// create new PDF document

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$resolution = array(215, 175);
$pdf->AddPage('L', $resolution);

$settings = Modules::run('main/getSet');
$section = Modules::run('registrar/getSectionById', segment_4);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);
$students = Modules::run('registrar/getStudentForCard', '', segment_6, segment_4);
$sy = $this->session->userdata('school_year');
$quarter = segment_5;
$adviser = Modules::run('academic/getAdviser',segment_4,$section->grade_id,$sy);
$nxtYr = $sy + 1;

// -----------------------------------------------------------------------------
$i=0;
foreach ($students->result() as $mStudent):
    $i++;
    //if($i<=2):
        $data['mStudent'] = $mStudent;
        $data['section'] = $section;
        $data['grade_id'] = $section->grade_id;
        $data['subject_ids'] = $subject_ids;
        $data['adviser'] = $adviser;
        $data['sy'] = $sy;
        $data['nxtYr'] = $nxtYr;
        $data['pdf'] = $pdf;
        $data['x'] = 5;
        $data['y'] = 0;
        $data['term'] = $quarter;

        $this->load->view('pisd_cardDetails', $data);
        $pdf->AddPage();
   // endif;    
endforeach;

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
