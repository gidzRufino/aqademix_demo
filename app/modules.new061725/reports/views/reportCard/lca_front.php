<?php
class MYPDF extends Pdf {
    //Page header
	public function Header() {
            $this->SetTitle('DepED Form 138-A');
        }

}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 3);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
//$resolution= array(166, 200);
$resolution= array(215.9, 279);
$pdf->AddPage('L', $resolution);

$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES.'/lca.png';
$division_logo = K_PATH_IMAGES.'/division_logo.jpg';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = strtoupper($principal->firstname.' '.substr($principal->middlename, 0,1).'. '.$principal->lastname);
$adviser = Modules::run('academic/getAdvisory',  NULL,segment_4, $student->section_id);
$adv = strtoupper($adviser->row()->firstname.' '.substr($adviser->row()->middlename, 0,1).'. '.$adviser->row()->lastname);
$first = Modules::run('gradingsystem/getCardRemarks', $student->uid,1, $sy);
$second = Modules::run('gradingsystem/getCardRemarks', $student->uid,2, $sy);
$third = Modules::run('gradingsystem/getCardRemarks', $student->uid,3, $sy);
$fourth = Modules::run('gradingsystem/getCardRemarks', $student->uid,4, $sy);

//get the birthday and the age before first friday of june
    $firstFridayOfJune =date('mdY',  strtotime('first Friday of '.'June'.' '.$sy));
    $bdate = $student->cal_date;
    $bdateItems = explode('-', $bdate);
    $m = $bdateItems[0];
    $d = $bdateItems[1];
    $y = $bdateItems[2];
    $thisYearBdate = $m.$d.$settings->school_year;
    $now = $settings->school_year;
    $age = abs($now - $y);
    
    if(abs($thisYearBdate>$firstFridayOfJune)){
        $yearsOfAge = $age - 1;
    }else{
        $yearsOfAge = $age;
    }




//start of the left column
$pdf->SetY(5);
$pdf->SetFont('PDFACourier', 'B', 18, TRUE);
$pdf->MultiCell(120, 10, 'SCHOOL DISTINCTIVES',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(10);
$pdf->MultiCell(120, 10, 'VISION:',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(6);
$pdf->SetFont('PDFACourier', 'I', 13, TRUE);
$pdf->MultiCell(120, 10, 'A Defined Future through Changed Lives',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');

$pdf->Ln(10);
$pdf->SetFont('PDFACourier', 'B', 18, TRUE);
$pdf->MultiCell(120, 10, 'MOTTO:',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(6);
$pdf->SetFont('PDFACourier', 'I', 13, TRUE);
$pdf->MultiCell(120, 10, 'Magna Est Veritas Et Prevalebit',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(6);
$pdf->MultiCell(120, 10, '(Truth is Mighty and It Shall Prevail)',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');

$pdf->Ln(10);
$pdf->SetFont('PDFACourier', 'B', 18, TRUE);
$pdf->MultiCell(120, 10, 'CORE VALUES:',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(6);
$pdf->SetFont('PDFACourier', 'I', 13, TRUE);
$pdf->MultiCell(120, 10, 'Gospel Grace Gratitude',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(6);
$pdf->MultiCell(120, 10, 'Godliness Gentleness Glory',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');

$pdf->Ln(15);
$pdf->SetFont('PDFACourier', 'B', 18, TRUE);
$pdf->MultiCell(120, 10, 'ALMA MATER SONG',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(8);
$pdf->SetFont('helvetica', 'N', 10, TRUE);
$pdf->MultiCell(120, 5, 'By: Minda P. Puracan',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln(4);
$pdf->MultiCell(120, 5, 'Enriqueta A. Serate, Ph.D.',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->Ln(10);
$pdf->MultiCell(60, 100, "On the lofty verdant heights,
Where the breezes blow so free,
There our Alma Mater lies,
Livingstone Christian Academy;
Where we learn the things we should
With the guidance from on high;
And above all God is glorified
At LCA!

Chorus:

May God's wisdom light her days
Through the years in every way;
This oh Lord we humbly pray
For LCA!
",0, 'L', 0, 0, '', '', true, 0, false, true, 100, 'T');

$pdf->MultiCell(60, 120, "We are taught to love the Lord,
In all lessons Him behold;
And in all our tasks each day,
For His constant guide we humbly pray;
In the classroom or the field,
To His mandate we all yield
To be true to classmates, teachers, all at LCA!

We will always love our school,
Be her cheerful willing tools;
And her creed to help mankind
In our hearts and minds we'll deeply bind
Thus we'll hold her standard high,
for in us her honor lies;
And we'll ne'er forget the truth we've 
learned at LCA
",0, 'L', 0, 0, '', '', true, 0, false, true, 100, 'T');

$pdf->StartTransform();
$pdf->Rotate(90);
$pdf->SetXY(-10,105);
$pdf->Ln(15);
$pdf->SetFont('times', 'B', 20, TRUE);
$pdf->MultiCell(250, 0, 'PASSION FOR EXCELLENCE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->StopTransform();




//start of right column
$pdf->SetY(3);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

$next = $settings->school_year + 1;

$pdf->SetFont('helvetica', 'N', 5);
$pdf->SetXY(141, 3);
$pdf->MultiCell(0, 0, 'LCA Form 138-A',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetXY(145, 12);
$pdf->SetFont('helvetica', 'B', 14);
// Title Right Side Column
$pdf->MultiCell(0, 10, strtoupper($settings->set_school_name),0, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->Ln(6);
$pdf->SetX(141);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(0, 0, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetX(141);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->MultiCell(0, 10, 'REPORT CARD',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(6);
$pdf->SetX(141);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(0, 10, 'K to 12',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(12);
$pdf->SetX(150);
$pdf->MultiCell(40, 5, 'Name',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, ': '.strtoupper($student->lastname.', '.$student->firstname.' '.substr($student->middlename, 0,1).'. '),0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(150);
$pdf->MultiCell(40, 5, 'Grade',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, ': '.$student->level,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(150);
$pdf->MultiCell(40, 5, 'Academic Year',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, ': '.$settings->school_year.' - '.$next,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->SetX(150);
$pdf->SetFont('helvetica', 'N', 9);
$pdf->MultiCell(50, 0, 'Promoted to or Retained in Grade',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 0, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 0, 'Date',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 0, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetX(150);
$pdf->MultiCell(65, 0, 'Eligible for Transfer and Admission to Grade',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 0, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(15);
$pdf->SetX(150);
$pdf->MultiCell(60, 5, $adv,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, $name,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(150);
$pdf->MultiCell(60, 0, 'Adviser',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 0, 'Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


$pdf->Ln(12);
$pdf->SetX(150);

$pdf->SetLineStyle(array('width' => .5, 'color' => array(0, 0, 0)));
$pdf->MultiCell(125, 0, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(4);
$pdf->SetX(150);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(125, 0, 'CERTIFICATE TO TRANSFER',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetLineStyle(array('width' => .2, 'color' => array(0, 0, 0)));
$pdf->Ln(8);
$pdf->SetX(150);
$pdf->SetFont('helvetica', 'N', 9);
$pdf->MultiCell(19, 0, 'Admitted In',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(65, 0, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 0, 'Date',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 0, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


$pdf->Ln(15);
$pdf->SetX(150);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(125, 5, $name,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(150);
$pdf->MultiCell(125, 0, 'Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


$pdf->Ln(15);
$pdf->SetX(150);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(125, 10, '“TRAIN UP A CHILD IN THE WAY HE SHOULD GO, EVEN WHEN HE IS OLD HE WILL NOT DEPART FROM IT.”',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(150);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(125, 0, 'Proverbs 22:6',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(8);
$pdf->SetX(145);
$pdf->MultiCell(19, 0, 'Member :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(145);
$pdf->MultiCell(10, 0, ' ',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(120, 0, 'Association of Christian Schools in Cebu',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(145);
$pdf->MultiCell(10, 0, ' ',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(120, 0, 'Association of Christian Schools, Colleges and Universities',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(145);
$pdf->MultiCell(10, 0, ' ',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(120, 0, "Boys and Girls' Brigade Philippines",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(145);
$pdf->MultiCell(10, 0, ' ',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(120, 0, "Association of Christian Schools International",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'I', 6);
$pdf->Ln(15);

$pdf->SetX(145);
$pdf->MultiCell(130, 0, '(This is a computer generated school form)',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Image($image_file, 142, 10, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//$pdf->Image($division_logo, 265 , 15, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Line(139.5, 5, 139.5, 1, array('color' => 'black'));


//back page

$pdf->AddPage();
$data['student'] = $student;
$data['firstRemarks'] = $first;
$data['secondRemarks'] = $second;
$data['thirdRemarks'] = $third;
$data['fourthRemarks'] = $fourth;
$data['sy'] = $sy;
$data['term'] = $term; 
$data['pdf'] = $pdf;
$this->load->view('reportCard/'.strtolower($settings->short_name).'_back', $data);

//$pdf->Ln(10);
//$pdf->StartTransform();
//$pdf->Rotate(90);
//$pdf->Cell(0,0,'This is a sample data',1,1,'L',0,'');
//$pdf->StopTransform();
//Close and output PDF document
ob_end_clean();
$pdf->Output('DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+