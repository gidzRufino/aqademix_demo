<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $section = Modules::run('registrar/getSectionById', segment_3);
                $settings = Modules::run('main/getSet');
                $adviser = Modules::run('academic/getAdvisory', '', segment_3);
                $male = Modules::run('registrar/getAllStudentsByGender', segment_3, 'Male', 1);
                $female = Modules::run('registrar/getAllStudentsByGender', segment_3, 'Female', 1);
                $total = $male->num_rows()+$female->num_rows();
                
                $subject = Modules::run('academic/getSpecificSubjects', segment_4);
                $nextYear = $settings->school_year + 1;
                
                $this->SetTitle('Pre Test');
                $this->SetTopMargin(4);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, 'Republic of the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'B', 10);
		$this->Cell(0, 15, 'Department of Education', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$image_file = K_PATH_IMAGES.'/fsLogo.png';
		$this->Image($image_file, 190, 8, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                
		$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
		$this->Image($image_file, 10, 8, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->Ln(8);
                $this->SetFont('helvetica', 'B', 10);
                $this->Cell(0,4.3,"Region X",0,0,'C');
                $this->Ln();
                $this->Cell(0,4.3,"DIVISION OF CAGAYAN DE ORO CITY",0,0,'C');
                $this->Ln(5);
                $this->Cell(0,4.3,'Division Unified Test',0,0,'C');
                $this->Ln();
                $this->SetFont('helvetica', 'B', 8);
                $this->Cell(0,4.3,'First Grading Period',0,0,'C');
                $this->Ln();
                $this->Cell(0,4.3,"SY  ".$settings->school_year.' - '.$nextYear,0,0,'C');
                $this->Ln(5);
                $this->Cell(0,4.3,"District: ".$settings->district,0,0,'L');
                $this->Cell(0,4.3,"Grade / Year & Section : ".$section->level .' - '. $section->section,0,0,'R');
                $this->Ln();
                $this->Cell(0,4.3,"School: ".$settings->set_school_name,0,0,'L');
                $this->Cell(0,4.3,"Enrollment: ".$total,0,0,'R');
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
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(330,216);
$pdf->AddPage('L', $resolution);

$pdf->SetY(45);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding
$settings = Modules::run('main/getSet');
$section = Modules::run('registrar/getSectionById', segment_3);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);    
$subject = explode(',', $subject_ids->subject_id);
$finalAssessment = 0;   
$mapeh = 0;
    
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach($subject as $s){  
      $singleSub = Modules::run('academic/getSpecificSubjects', $s);
      switch ($singleSub->parent_subject){
          case 0:
              $pdf->MultiCell(15, 3, $singleSub->short_code,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
          break;
          case 11:
              //$pdf->MultiCell(15, 3, ,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
          break;
              
      }
    }
    $pdf->MultiCell(75, 3, 'MAPEH',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, 'FINAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(35, 3, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach($subject as $s){  
      $singleSub = Modules::run('academic/getSpecificSubjects', $s);
      switch ($singleSub->parent_subject){
          case 0:
              $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
          break;
          case 11:
              $pdf->MultiCell(15, 3, $singleSub->short_code,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
          break;
              
      }
      
    }
    $pdf->MultiCell(15, 3, 'Ave',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(35, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
//$student =  Modules::run('registrar/getAllStudentsForExternal', segment_3);
$m = 0;
foreach($male->result() as $s){
    $m++;
}
$f = 0;
foreach($female->result() as $s){
    $f++;
}
$tot = $m + $f;
$x = 0;
switch ($this->session->userdata('term')){
     case 1:
         $term = 'first';
     break;
     case 2:
         $term = 'second';
     break;
     case 3:
         $term = 'third';
     break;
     case 4:
         $term = 'fourth';
     break;
}
$z=0;
foreach($male->result() as $s){
    $z++;
    $x++;
    $pdf->MultiCell(8, 3, $z,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, strtoupper($s->lastname.', '.$s->firstname.' '.substr($s->middlename, 0, 1).'.'),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    
    foreach($subject as $sub){  
      $singleSub = Modules::run('academic/getSpecificSubjects', $sub);
      $assessment = Modules::run('gradingsystem/getPartialAssessment', $s->user_id, segment_3, $sub, $settings->school_year);
      switch ($singleSub->parent_subject){
            case 0:
                if(!empty($assessment)):
                    $finalAssessment += $assessment->$term;  
                    $pdf->MultiCell(15, 3,$assessment->$term,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                  else:
                    $finalAssessment += 0;   
                    $pdf->MultiCell(15, 3,'0',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');  
                  endif;
            break;
            case 11:
               if(!empty($assessment)):
                $finalAssessment += $assessment->$term;  
                $mapeh += $assessment->$term;
                $pdf->MultiCell(15, 3,$assessment->$term,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              else:
                $finalAssessment += 0; 
                //$mapeh= $mapeh + 1;
                $pdf->MultiCell(15, 3,'0',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');  
              endif;
            break;

        }

    }
    $pdf->MultiCell(15, 3, round($mapeh/4,3),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, round($finalAssessment/count($subject), 3),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(35, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->ln();
    
    if($x==18):
        $pdf->AddPage();
        $pdf->SetY(45);
        $x=0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach($subject as $s){  
          $singleSub = Modules::run('academic/getSpecificSubjects', $s);
          switch ($singleSub->parent_subject){
              case 0:
                  $pdf->MultiCell(15, 3, $singleSub->short_code,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;
              case 11:
                  //$pdf->MultiCell(15, 3, ,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;

          }
        }
        $pdf->MultiCell(75, 3, 'MAPEH',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, 'FINAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach($subject as $s){  
          $singleSub = Modules::run('academic/getSpecificSubjects', $s);
          switch ($singleSub->parent_subject){
              case 0:
                  $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;
              case 11:
                  $pdf->MultiCell(15, 3, $singleSub->short_code,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;

          }

        }
        $pdf->MultiCell(15, 3, 'Ave',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        
    endif;
    
    unset($mapeh);
    unset($finalAssessment);
    $mapeh=0;
    $finalAssessment = 0;
}

for($bl=1;$bl<=2;$bl++){
    $x++;
    if($x==19):
        $pdf->AddPage();
        $pdf->SetY(45);
        $x=0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach($subject as $s){  
          $singleSub = Modules::run('academic/getSpecificSubjects', $s);
          switch ($singleSub->parent_subject){
              case 0:
                  $pdf->MultiCell(15, 3, $singleSub->short_code,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;
              case 11:
                  //$pdf->MultiCell(15, 3, ,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;

          }
        }
        $pdf->MultiCell(75, 3, 'MAPEH',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, 'FINAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach($subject as $s){  
          $singleSub = Modules::run('academic/getSpecificSubjects', $s);
          switch ($singleSub->parent_subject){
              case 0:
                  $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;
              case 11:
                  $pdf->MultiCell(15, 3, $singleSub->short_code,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;

          }

        }
        $pdf->MultiCell(15, 3, 'Ave',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        
    endif;
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach($subject as $s){  
      $singleSub = Modules::run('academic/getSpecificSubjects', $s);
      $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    }
    $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(35, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    
}

$y=1;
$yn=0;
$n = 0;
foreach($female->result() as $s){
    $x++;
    if($x==18):
        $pdf->AddPage();
        $pdf->SetY(45);
        $x=0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach($subject as $s){  
          $singleSub = Modules::run('academic/getSpecificSubjects', $s);
          switch ($singleSub->parent_subject){
              case 0:
                  $pdf->MultiCell(15, 3, $singleSub->short_code,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;
              case 11:
                  //$pdf->MultiCell(15, 3, ,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;

          }
        }
        $pdf->MultiCell(75, 3, 'MAPEH',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, 'FINAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach($subject as $s){  
          $singleSub = Modules::run('academic/getSpecificSubjects', $s);
          switch ($singleSub->parent_subject){
              case 0:
                  $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;
              case 11:
                  $pdf->MultiCell(15, 3, $singleSub->short_code,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
              break;

          }

        }
        $pdf->MultiCell(15, 3, 'Ave',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        
    endif;
    $yn++;
    $pdf->MultiCell(8, 3, $yn,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, strtoupper($s->lastname.', '.$s->firstname.' '.substr($s->middlename, 0, 1).'.'),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach($subject as $sub){  
          $singleSub = Modules::run('academic/getSpecificSubjects', $sub);
          $assessment = Modules::run('gradingsystem/getPartialAssessment', $s->user_id, segment_3, $sub, $settings->school_year);
          if(!empty($assessment)):
            $finalAssessment += $assessment->$term;  
            $pdf->MultiCell(15, 3,$assessment->$term,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
          else:
            $finalAssessment += 0;   
            $pdf->MultiCell(15, 3,'0',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');  
          endif;
    }
    $pdf->MultiCell(15, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, round($finalAssessment/count($subject), 3),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(35, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->ln();
    $f = $tot - $y;
    //$pdf->MultiCell(50, 3,$f,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $y++;
    $n++;
    unset($finalAssessment);
    $finalAssessment = 0;
}

$pdf->SetFont('helvetica', 'B', 10);
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$adviser = Modules::run('academic/getAdvisory', '', segment_3);

switch ($x){
  case 29:
      $pdf->ln(10);
  break;
  case 12:
      $pdf->ln(20);
  break;
  case 8:
      $pdf->ln(70);
  break;
}
$pdf->SetX(80);
$pdf->MultiCell(75, 10,  strtoupper($principal->firstname.' '.$principal->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(40, 10,  '','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  strtoupper($adviser->row()->firstname.' '.$adviser->row()->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();
$pdf->SetX(80); 
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(75, 10,  'School Principal','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->MultiCell(40, 10,  '','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  'Adviser','', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
//$html = Modules::run('reports/form1');
//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('DepEdForm1.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
