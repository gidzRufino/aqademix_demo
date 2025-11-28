<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $section = Modules::run('registrar/getSectionById', segment_3);
                $settings = Modules::run('main/getSet');
                $adviser = Modules::run('academic/getAdvisory', '', segment_3);
                
                $subject = Modules::run('academic/getSpecificSubjects', segment_4);
                $nextYear = segment_6 + 1;
                
                $this->SetTitle('Top Ten');
                $this->SetTopMargin(3);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'n', 8);
		$this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
		$this->Image($image_file, 300, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                
		$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
		$this->Image($image_file, 10, 8, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                switch (segment_5){
                    case 1:
                        $term = 'FIRST QUARTER';
                    break;
                    case 2:
                        $term = 'SECOND QUARTER';
                    break;
                    case 3:
                        $term = 'THIRD QUARTER';
                    break;
                    case 4:
                        $term = 'FOURTH QUARTER';
                    break;
               }
                $this->Ln(12);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0,4.3,$section->level.' '.$term.' LIST OF HONORS',0,0,'C');
                $this->Ln();
                $this->Cell(0,4.3,"SY  ".segment_6.' - '.$nextYear,0,0,'C');
                $this->Ln(10);
        }

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
                
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(330,216);
$pdf->AddPage('L', $resolution);

$pdf->SetY(35);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding


$section = Modules::run('registrar/getSectionById', segment_3);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);    
//$subject = explode(',', $subject_ids->subject_id);

$pdf->SetX(15);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(60, 3, 'Full Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach($subject_ids as $s){  
          $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
          switch ($singleSub->parent_subject){
              case 0:
              case 11:
                     if($s->sub_id!=20):
                         if($singleSub->short_code=='Mother Tongue'):
                            $pdf->MultiCell(20, 3, 'MT',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                         else:
                            $pdf->MultiCell(20, 3, $singleSub->short_code,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                             
                         endif;
                     endif;
              break;
              case 18:
                  //$pdf->MultiCell(15, 3, ,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;

          }
}
$pdf->MultiCell(20, 3, 'GPA',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'RANK',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->Ln();

$x = 0;
// List of Top Ten
foreach($getTopTen as $tt=>$gt):
    $x++;
    switch ($x):
        case 1:
           $rank = 'First Honors';
        break;    
        case 2:
           $rank = 'Second Honors';
        break;    
        case 3:
           $rank = 'Third Honors';
        break;    
        default :
           $rank = 'With Honors';
        break;    
    endswitch;
    if($x<11):
        $pdf->SetX(15);
    
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->MultiCell(60, 3, strtoupper($gt->lastname.', '.$gt->firstname.' '.substr($gt->middlename, 0, 1)).'.',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->SetFont('helvetica', 'B', 8);
        $fa=0;
        foreach($subject_ids as $s){  
              $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
              $finalGrade = Modules::run('gradingsystem/getFinalGrade', $gt->st_id, $singleSub->subject_id, segment_5, $this->session->userdata('school_year'));
              
              switch ($singleSub->parent_subject){
                  case 0:
                  case 11:
                     if($s->sub_id!=20):
                          $fa++;
                          $pdf->MultiCell(20, 3, $finalGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M'); 
                          
                          //$finalAverage += $finalGrade->row()->final_rating;
                     endif;
                  break;
                  case 18:
                      //$pdf->MultiCell(15, 3, ,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                  break;

                    }
          }
        $pdf->MultiCell(20, 3, number_format(round(round($gt->total,3)/$fa, 3),3),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        //$pdf->MultiCell(20, 3, round($finalAverage/$fa, 3),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, $rank,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        unset($finalAverage);
        $fa=0;
    endif;
endforeach;


for($bl=1;$bl<=2;$bl++):
    $pdf->SetX(15);
    if($bl==2):
        $pdf->MultiCell(60, 3, 'Teachers\'s Signature',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    else:
        $pdf->MultiCell(60, 3, '',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    endif;
    
    foreach($subject_ids as $s){  
          $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
          switch ($singleSub->parent_subject){
              case 0:
              case 11:
                  $pdf->MultiCell(20, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;
              case 18:
                  //$pdf->MultiCell(15, 3, ,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;

                }
      }
      $pdf->MultiCell(20, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
      $pdf->MultiCell(30, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
      $pdf->Ln();
endfor;

$settings = Modules::run('main/getSet');
$adviser = Modules::run('academic/getAdvisory', NULL, $settings->school_year, segment_3 );
$pdf->SetFont('helvetica', 'B', 10);

$asstPrincipal = Modules::run('hr/getEmployeeByPosition', 'Asst. to the Principal');

$pdf->Ln();
//$pdf->MultiCell(30, 10,  'Prepared By:',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
//$pdf->Ln();
//$pdf->MultiCell(20, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
//$pdf->MultiCell(75, 10,  strtoupper($adviser->row()->firstname.' '.$adviser->row()->lastname),0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');
//$pdf->MultiCell(160, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
//$pdf->MultiCell(50, 10,  strtoupper($asstPrincipal->firstname.' '.$asstPrincipal->lastname),0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');
//$pdf->Ln();
//$pdf->SetFont('helvetica', 'B', 8);
//$pdf->MultiCell(20, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
//$pdf->MultiCell(75, 10,  'Adviser','', 'L', 0, 0, '', '', true, 0, false, true, 10, 'T');

$pdf->SetFont('helvetica', 'B', 10);
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal');
$pdf->Ln(15);
$pdf->MultiCell(30, 10,  'Noted By:',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();
$pdf->MultiCell(20, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  strtoupper($principal->firstname.' '.$principal->lastname),0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  'Principal','', 'L', 0, 0, '', '', true, 0, false, true, 10, 'T');

//$html = Modules::run('reports/form1');
//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
ob_end_clean();
$pdf->Output('topTen.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
    
