<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $section = Modules::run('registrar/getSectionById', segment_3);
                $this->SetTitle('School Form 6 (SF 6) Summarized Report on Promotion & Level of Proficiency');
                $this->SetTopMargin(4);
		$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
		$this->Image($image_file, 5, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 12);
		// Title
                $this->SetY(10);
                $this->Ln();
		$this->Cell(0, 0, 'School Form 6 (SF 6)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln();
		$this->Cell(0, 0, 'Summarized Report on Promotion & Level of Proficiency', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
		$this->SetFont('helvetica', 'n', 8);
		// Title
                $this->Ln();
		$this->Cell(0, 15, '(This replaces Form 20)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
                $settings = Modules::run('main/getSet');
                $nextYear = segment_3 + 1;
               
                
                $this->SetFont('helvetica', 'B', 12);
                $this->SetXY(50,30);
                $this->Cell(0,4.3,"School ID : ".$settings->school_id, 0, false, 'L', 0, '', 0, false, 'M', 'M');
                $this->SetXY(130,30);
                $this->Cell(0,4.3,"Region: ". $settings->region, 0, false, 'L', 0, '', 0, false, 'M', 'M');
                $this->SetXY(200,30);
                $this->Cell(0,4.3,"Division: ". $settings->division, 0, false, 'L', 0, '', 0, false, 'M', 'M');
                $this->SetXY(50,37);
                $this->Cell(0,4.3,"School Name : ".$settings->set_school_name,0,0,'L', 0, '', 0, false, 'M', 'M');
                $this->SetXY(200,37);
                $this->Cell(0,4.3,"District: ". $settings->district, 0, false, 'L', 0, '', 0, false, 'M', 'M');
                $this->SetXY(270,37);
                $this->Cell(0,4.3,"School Year : ".segment_3.'-'.$nextYear, 0, false, 'L', 0, '', 0, false, 'M', 'M');
        }

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
                
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'School Form 6: Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(216, 330);
$pdf->AddPage('L', $resolution);
$section = Modules::run('registrar/getSectionById', segment_3);

$pdf->SetXY(8,48);
$pdf->SetFont('helvetica', 'B', 7);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->MultiCell(40, 20, 'SUMMARY TABLE',1, 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
$pdf->MultiCell(39, 12, 'GRADE 1 / GRADE 7',1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(39, 12, 'GRADE 2 / GRADE 8',1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(39, 12, 'GRADE 3 / GRADE 9',1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(39, 12, 'GRADE 4 / GRADE 10',1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(39, 12, 'GRADE 5 / GRADE 11',1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(39, 12, 'GRADE 6 / GRADE 12',1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(39, 12, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();
$pdf->SetX(48);
//grade 1 / grade 7
$pdf->MultiCell(13, 8, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
//grade 2 / grade 8
$pdf->MultiCell(13, 8, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 8, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 8, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 8, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 8, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
//total
$pdf->MultiCell(13, 8, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(13, 8, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->Ln();

$g7 = json_decode(Modules::run('gradingsystem/getPromotionalReport', 8));
$g8 = json_decode(Modules::run('gradingsystem/getPromotionalReport', 9));
$g9 = json_decode(Modules::run('gradingsystem/getPromotionalReport', 10));
if(segment_3==2014):
    $g10 = json_decode(Modules::run('gradingsystem/getPromotionalReport', 18));    
else:    
    $g10 = json_decode(Modules::run('gradingsystem/getPromotionalReport', 11));    
endif;

$g11 = json_decode(Modules::run('gradingsystem/getPromotionalReport', 12));
$g12 = json_decode(Modules::run('gradingsystem/getPromotionalReport', 13));

//Promoted starts
$pdf->SetX(8);
$pdf->MultiCell(40, 7, 'PROMOTED',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 1 / grade 7
$pdf->MultiCell(13, 7,$g7->pro_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->pro_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->pro_m+$g7->pro_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');


//grade 2 / grade 8
$pdf->MultiCell(13, 7, $g8->pro_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->pro_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->pro_m+$g8->pro_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 7, $g9->pro_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->pro_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->pro_m+$g9->pro_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 7, $g10->pro_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->pro_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->pro_m+$g10->pro_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//total
$pdf->MultiCell(13, 7, $g7->pro_m+$g8->pro_m+$g9->pro_m+$g10->pro_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->pro_f+$g8->pro_f+$g9->pro_f+$g10->pro_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g7->pro_m+$g8->pro_m+$g9->pro_m+$g10->pro_m)+($g7->pro_f+$g8->pro_f+$g9->pro_f+$g10->pro_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();
//Promoted Ends

//IRREGULAR starts
$pdf->SetX(8);
$pdf->MultiCell(40, 7, 'IRREGULAR',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 1 / grade 7
$pdf->MultiCell(13, 7,$g7->irr_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->irr_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->irr_m+$g7->irr_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 2 / grade 8
$pdf->MultiCell(13, 7,$g8->irr_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->irr_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->irr_m+$g8->irr_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 7,$g9->irr_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->irr_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->irr_m+$g9->irr_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 7,$g10->irr_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->irr_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->irr_m+$g10->irr_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//total
$pdf->MultiCell(13, 7, $g7->irr_m+$g8->irr_m+$g9->irr_m+$g10->irr_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->irr_f+$g8->irr_f+$g9->irr_f+$g10->irr_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g7->irr_m+$g8->irr_m+$g9->irr_m+$g10->irr_m)+($g7->irr_f+$g8->irr_f+$g9->irr_f+$g10->irr_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();
//IRREGULAR Ends

//RETAINED starts
$pdf->SetX(8);
$pdf->MultiCell(40, 7, 'RETAINED',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 1 / grade 7
$pdf->MultiCell(13, 7,$g7->re_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->re_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->re_m+$g7->re_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 2 / grade 8
$pdf->MultiCell(13, 7,$g8->re_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->re_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->re_m+$g8->re_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 7,$g9->re_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->re_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->re_m+$g9->re_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 7,$g10->re_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->re_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->re_m+$g10->re_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//total
$pdf->MultiCell(13, 7, $g7->re_m+$g8->re_m+$g9->re_m+$g10->re_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->re_f+$g8->re_f+$g9->re_f+$g10->re_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g7->re_m+$g8->re_m+$g9->re_m+$g10->re_m)+($g7->re_f+$g8->re_f+$g9->re_f+$g10->re_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();
//RETAINED Ends

//LEVEL OF PROFICIENCY
$pdf->SetX(8);
$pdf->MultiCell(40, 7, 'LEVEL OF PROFICIENCY',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 1 / grade 7
$pdf->MultiCell(13, 7, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 2 / grade 8
$pdf->MultiCell(13, 7, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 7, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 7, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 7, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 7, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//total
$pdf->MultiCell(13, 7, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

//BEGINNING STARTS

$pdf->SetFont('helvetica', 'B', 6);
$pdf->SetX(8);
$pdf->MultiCell(40, 7, 'BEGINNING
( B: 74% and Below )',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 1 / grade 7
$pdf->MultiCell(13, 7,$g7->b_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->b_m+$g7->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 2 / grade 8
$pdf->MultiCell(13, 7,$g8->b_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->b_m+$g8->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 7,$g9->b_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->b_m+$g9->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 7,$g10->b_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->b_m+$g10->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//total
$pdf->MultiCell(13, 7, $g7->b_m+$g8->b_m+$g9->b_m+$g10->b_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->b_f+$g8->b_f+$g9->b_f+$g10->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g7->b_m+$g8->b_m+$g9->b_m+$g10->b_m)+($g7->b_f+$g8->b_f+$g9->b_f+$g10->b_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();
//BEGINNING Ends

//DEVELOPING STARTS

$pdf->SetFont('helvetica', 'B', 6);
$pdf->SetX(8);
$pdf->MultiCell(40, 7, 'DEVELOPING
( D: 75% - 79% )',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 1 / grade 7
$pdf->MultiCell(13, 7,$g7->d_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->d_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->d_m+$g7->d_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 2 / grade 8
$pdf->MultiCell(13, 7,$g8->d_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->d_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->d_m+$g8->d_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 7,$g9->d_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->d_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->d_m+$g9->d_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 7,$g10->d_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->d_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->d_m+$g10->d_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//total
$pdf->MultiCell(13, 7, $g7->d_m+$g8->d_m+$g9->d_m+$g10->d_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->d_f+$g8->d_f+$g9->d_f+$g10->d_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g7->d_m+$g8->d_m+$g9->d_m+$g10->d_m)+($g7->d_f+$g8->d_f+$g9->d_f+$g10->d_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

//DEVELOPING ENDS

//APPROACHING PROFICIENT STARTS

$pdf->SetFont('helvetica', 'B', 6);
$pdf->SetX(8);
$pdf->MultiCell(40, 7, 'APPROACHING PROFICIENT
( AP: 80% - 85% )',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 1 / grade 7
$pdf->MultiCell(13, 7,$g7->ap_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->ap_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->ap_m+$g7->ap_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 2 / grade 8
$pdf->MultiCell(13, 7,$g8->ap_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->ap_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->ap_m+$g8->ap_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 7,$g9->ap_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->ap_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->ap_m+$g9->ap_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 7,$g10->ap_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->ap_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->ap_m+$g10->ap_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//total
$pdf->MultiCell(13, 7, $g7->ap_m+$g8->ap_m+$g9->ap_m+$g10->ap_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->ap_f+$g8->ap_f+$g9->ap_f+$g10->ap_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g7->ap_m+$g8->ap_m+$g9->ap_m+$g10->ap_m)+($g7->ap_f+$g8->ap_f+$g9->ap_f+$g10->ap_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

//APPROACHING PROFICIENT ENDS

//PROFICIENT STARTS

$pdf->SetFont('helvetica', 'B', 6);
$pdf->SetX(8);
$pdf->MultiCell(40, 7, 'PROFICIENT
( P: 86% - 89% )',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 1 / grade 7
$pdf->MultiCell(13, 7,$g7->p_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->p_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->p_m+$g7->p_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 2 / grade 8
$pdf->MultiCell(13, 7,$g8->p_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->p_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->p_m+$g8->p_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 7,$g9->p_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->p_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->p_m+$g9->p_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 7,$g10->p_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->p_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->p_m+$g10->p_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//total
$pdf->MultiCell(13, 7, $g7->p_m+$g8->p_m+$g9->p_m+$g10->p_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->p_f+$g8->p_f+$g9->p_f+$g10->p_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g7->p_m+$g8->p_m+$g9->p_m+$g10->p_m)+($g7->p_f+$g8->p_f+$g9->p_f+$g10->p_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

//PROFICIENT ENDS

//ADVANCED STARTS

$pdf->SetFont('helvetica', 'B', 6);
$pdf->SetX(8);
$pdf->MultiCell(40, 7, 'ADVANCED
( A: 90% and above )',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 1 / grade 7
$pdf->MultiCell(13, 7,$g7->a_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->a_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->a_m+$g7->a_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 2 / grade 8
$pdf->MultiCell(13, 7,$g8->a_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->a_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->a_m+$g8->a_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 7,$g9->a_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->a_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->a_m+$g9->a_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 7,$g10->a_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->a_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->a_m+$g10->a_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//total
$pdf->MultiCell(13, 7, $g7->a_m+$g8->a_m+$g9->a_m+$g10->a_m,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->a_f+$g8->a_f+$g9->a_f+$g10->a_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g7->a_m+$g8->a_m+$g9->a_m+$g10->a_m)+($g7->a_f+$g8->a_f+$g9->a_f+$g10->a_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

//ADVANCED ENDS

//TOTAL STARTS

$pdf->SetFont('helvetica', 'B', 7);
$pdf->SetX(8);
$pdf->MultiCell(40, 7, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 1 / grade 7
$pdf->MultiCell(13, 7,$g7->a_m + $g7->p_m+$g7->ap_m+$g7->d_m+$g7->b_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g7->a_f + $g7->p_f+$g7->ap_f+$g7->d_f+$g7->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g7->a_m + $g7->p_m+$g7->ap_m+$g7->d_m+$g7->b_m)+($g7->a_f + $g7->p_f+$g7->ap_f+$g7->d_f+$g7->b_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 2 / grade 8
$pdf->MultiCell(13, 7,$g8->a_m + $g8->p_m+$g8->ap_m+$g8->d_m+$g8->b_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g8->a_f + $g8->p_f+$g8->ap_f+$g8->d_f+$g8->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g8->a_m + $g8->p_m+$g8->ap_m+$g8->d_m+$g8->b_m)+($g8->a_f + $g8->p_f+$g8->ap_f+$g8->d_f+$g8->b_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 3 / grade 9
$pdf->MultiCell(13, 7,$g9->a_m + $g9->p_m+$g9->ap_m+$g9->d_m+$g9->b_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g9->a_f + $g9->p_f+$g9->ap_f+$g9->d_f+$g9->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g9->a_m + $g9->p_m+$g9->ap_m+$g9->d_m+$g9->b_m)+($g9->a_f + $g9->p_f+$g9->ap_f+$g9->d_f+$g9->b_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 4 / grade 10
$pdf->MultiCell(13, 7,$g10->a_m + $g10->p_m+$g10->ap_m+$g10->d_m+$g10->b_m ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, $g10->a_f + $g10->p_f+$g10->ap_f+$g10->d_f+$g10->b_f,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g10->a_m + $g10->p_m+$g10->ap_m+$g10->d_m+$g10->b_m)+($g10->a_f + $g10->p_f+$g10->ap_f+$g10->d_f+$g10->b_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 5 / grade 11
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//grade 6 / grade 12
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, '',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
//total
$pdf->MultiCell(13, 7, ($g7->a_m + $g7->p_m+$g7->ap_m+$g7->d_m+$g7->b_m)+($g8->a_m + $g8->p_m+$g8->ap_m+$g8->d_m+$g8->b_m)+($g9->a_m + $g9->p_m+$g9->ap_m+$g9->d_m+$g9->b_m)+($g10->a_m + $g10->p_m+$g10->ap_m+$g10->d_m+$g10->b_m),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, ($g7->a_f + $g7->p_f+$g7->ap_f+$g7->d_f+$g7->b_f)+($g8->a_f + $g8->p_f+$g8->ap_f+$g8->d_f+$g8->b_f)+($g9->a_f + $g9->p_f+$g9->ap_f+$g9->d_f+$g9->b_f)+($g10->a_f + $g10->p_f+$g10->ap_f+$g10->d_f+$g10->b_f),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(13, 7, (($g7->a_m + $g7->p_m+$g7->ap_m+$g7->d_m+$g7->b_m)+($g7->a_f + $g7->p_f+$g7->ap_f+$g7->d_f+$g7->b_f))+(($g8->a_m + $g8->p_m+$g8->ap_m+$g8->d_m+$g8->b_m)+($g8->a_f + $g8->p_f+$g8->ap_f+$g8->d_f+$g8->b_f))+(($g9->a_m + $g9->p_m+$g9->ap_m+$g9->d_m+$g9->b_m)+($g9->a_f + $g9->p_f+$g9->ap_f+$g9->d_f+$g9->b_f))+(($g10->a_m + $g10->p_m+$g10->ap_m+$g10->d_m+$g10->b_m)+($g10->a_f + $g10->p_f+$g10->ap_f+$g10->d_f+$g10->b_f)),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(20);

//TOTAL ENDS

$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');    
$pdf->SetX(8);
$pdf->MultiCell(36, 8, 'Prepared and Submitted By:',0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(50, 8, strtoupper($principal->firstname.' '.$principal->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(30, 8, '',0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(36, 8, 'Reviewed and Validated By:',0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(60, 8, '','B', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(20, 8, '',0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(20, 8, 'Noted By:',0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(60, 8, '','B', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->Ln();

$pdf->SetX(8);
$pdf->MultiCell(36, 8, '',0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(50, 8, 'SCHOOL HEAD',0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'T');
$pdf->MultiCell(30, 8, '',0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(36, 8, '',0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(60, 8, 'DIVISION REPRESENTATIVE',0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'T');
$pdf->MultiCell(20, 8, '',0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(20, 8, '',0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(60, 8, 'SCHOOLS DIVISION SUPERINTENDENT',0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'T');
$pdf->Ln();

$pdf->SetX(8);
$pdf->MultiCell(36, 8, 'GUIDELINES:',0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'N', 7);
$pdf->SetX(15);		
$pdf->Cell(0, 0, '1. After receiving and validating the Report for Promotion submitted by the class adviser, the School Head shall compute the grade level total and school total.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$pdf->Ln();
$pdf->SetX(15);		
$pdf->Cell(0, 0, '2. This report together with the copy of Report for Promotion submitted by the class adviser shall be forwarded to the Division Office by the end of the school year.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$pdf->Ln();
$pdf->SetX(15);		
$pdf->Cell(0, 0, '3. The Report on Promotion per grade level is reflected in the End of School Year Report of GESP/GSSP.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$pdf->Ln();
$pdf->SetX(15);		
$pdf->Cell(0, 0, '4. Protocols of validation & submission is under the discretion of the Schools Division Superintendent.', 0, false, 'L', 0, '', 0, false, 'M', 'M');


//Close and output PDF document
$pdf->Output('DepEdForm6_'.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
