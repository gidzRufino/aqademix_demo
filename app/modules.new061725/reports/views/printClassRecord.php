<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                
                $settings = Modules::run('main/getSet');
                $subject = Modules::run('academic/getSpecificSubjects', segment_4);
                $section = Modules::run('registrar/getSectionById', segment_3);
                $this->SetTitle('Class Record');
                $this->SetTopMargin(4);
		$image_file = K_PATH_IMAGES.'/school_logo.png';
                
                $this->SetFont('helvetica', 'B', 12);
		// Title
                $this->SetY(5);
		$this->Cell(0, 5, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
		$this->SetFont('helvetica', 'n', 10);
		
                $this->Ln();
		$this->Cell(0, 10, 'Class Record in '.$subject->subject.' ('.$section->level.' - '.$section->section.' )', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                
		$this->Image($image_file, 50, 2, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		                
               
        }

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
               
                
		$this->SetY(-15);
		// Set font
		
		// Page number
                if((int)$this->getAliasNumPage()==(int)$this->getAliasNbPages()):
                    
                endif;
                $this->SetFont('helvetica', 'I', 8);
                $this->Ln();
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$section = Modules::run('registrar/getSectionById', segment_3);
$students = Modules::run('registrar/getAllStudentsForExternal', '', segment_3);
$cat = Modules::run('gradingsystem/getAssessCatBySubject', segment_4);
    if($cat->num_rows>0):
        $sub_id = segment_4;
    else:
        $sub_id = '0';
    endif;
    $category = Modules::run('gradingsystem/getAssessCategory',$sub_id);
$settings = Modules::run('main/getSet');
$subject_teacher = Modules::run('academic/getSubjectTeacher', segment_4, segment_3);

$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(216, 330);
$pdf->AddPage('L', $resolution);

$pdf->SetY(20);
$pdf->SetFont('helvetica', 'B', 7);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(40, 5, 'Last Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'First Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'SEX',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


foreach($category as $cat => $k)
    {
    $pdf->MultiCell(41, 5, $k->category_name.' ('.($k->weight*100).'% )',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    }
$pdf->MultiCell(15, 5, 'PNG',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'PLG',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
 
$pdf->MultiCell(80, 5, 'NUMBER OF ITEMS > > >',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $a = 0;
    foreach($category as $cat => $k)
    {
        //getting the number of assessment
        $individualAssessmentBySection = Modules::run('gradingsystem/getAssessmentBySectionForPrint', segment_3,segment_4,$k->code,segment_5 );
        $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id,segment_3, segment_4, $k->code, segment_5 );
        $totalColumn = 41;
        $numColumns = $individualAssessmentBySection->num_rows;
        $indColumns = $totalColumn/$numColumns; 
        foreach ($teachersAssessment->result() as $IABS){
            $pdf->MultiCell($indColumns, 3.5, $IABS->no_items,1, 'C', 0, 0, '', '', true, 0, false, true, 3.5, 'T');
        }
        
        if($individualAssessmentBySection->num_rows()==0):
                $pdf->MultiCell($totalColumn, 3.5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 3.5, 'M');
        endif;
        
    }
$pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$countStudents=0;
foreach ($students->result() as $s)
{
    $countStudents++;
    
    $pdf->MultiCell(40, 5, strtoupper($s->lastname),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, strtoupper($s->firstname),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5,  substr($s->sex, 0, 1),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    foreach($category as $cat => $k)
    {
        //getting the number of assessment
        $individualAssessmentBySection = Modules::run('gradingsystem/getIndividualAssessmentForPrint',$s->st_id ,segment_4,$k->code,segment_5 );
        $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id,segment_3, segment_4, $k->code, segment_5 );
        $totalColumn = 41;
        $numColumns = $teachersAssessment->num_rows();
        $indColumns = $totalColumn/$numColumns; 
        
        
        foreach ($individualAssessmentBySection->result() as $IABS){
                $pdf->MultiCell($indColumns, 5, $IABS->raw_score,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            if($individualAssessmentBySection->num_rows()!=$teachersAssessment->num_rows()):
                $pdf->MultiCell($indColumns, 3.5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 3.5, 'M');
            endif;
            
        }
        
        if($individualAssessmentBySection->num_rows()==0):
                $pdf->MultiCell($totalColumn, 3.5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 3.5, 'M');
        endif;
        
        $totalGrade = Modules::run('gradingsystem/getPartialAssessment',$s->st_id, segment_3, segment_4, $settings->school_year);
        switch (segment_5) {
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

    }
    $plg = Modules::run('gradingsystem/getLetterGrade', $totalGrade->$term);
    foreach($plg->result() as $plg){
        if( $totalGrade->$term > $plg->from_grade && $totalGrade->$term <= $plg->to_grade){
            $letterGrade =  $plg->letter_grade;
            //echo $this->session->userdata('term');

        }
    }
    
    $pdf->MultiCell(15, 5, $totalGrade->$term,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, $letterGrade,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    
    $pdf->Ln();
    if($countStudents==35):
        $countStudents=0;
        $pdf->AddPage('L', $resolution);
        $pdf->SetY(20);
        $pdf->MultiCell(40, 5, 'Last Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(40, 5, 'First Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(8, 5, 'SEX',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        foreach($category as $cat => $k)
            {
            $pdf->MultiCell(50, 5, $k->category_name.' ('.($k->weight*100).'% )',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            }
        $pdf->MultiCell(15, 5, 'PNG',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, 'PLG',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->MultiCell(80, 5, 'NUMBER OF ITEMS > > >',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(8, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

            $a = 0;
            foreach($category as $cat => $k)
            {
                //getting the number of assessment
                $individualAssessmentBySection = Modules::run('gradingsystem/getAssessmentBySectionForPrint', segment_3,segment_4,$k->code,segment_5 );
                $totalColumn = 50;
                $numColumns = $individualAssessmentBySection->num_rows;
                   $indColumns = $totalColumn/$numColumns; 
                foreach ($individualAssessmentBySection->result() as $IABS){
                    $pdf->MultiCell($indColumns, 3.5, $IABS->no_items,1, 'C', 0, 0, '', '', true, 0, false, true, 3.5, 'T');
                }

            }
        $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endif;
}

if($countStudents<=30):
    $pdf->Ln(30);
endif;

$pdf->SetFont('helvetica', 'n', 10);
$pdf->Cell(0, 5,strtoupper($subject_teacher->firstname.' '.substr($subject_teacher->middlename, 0, 1).'. '.$subject_teacher->lastname), 0, false, 'C', 0, '', 0, false, 'T', 'M');
$pdf->Ln();
$pdf->SetX(130);
$pdf->Cell(70, 5,'Subject Teacher', 'T', false, 'C', 0, '', 0, false, 'T', 'M');



//Close and output PDF document
$pdf->Output('ClassRecord-'.$section->level.'-'.$section->section.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
