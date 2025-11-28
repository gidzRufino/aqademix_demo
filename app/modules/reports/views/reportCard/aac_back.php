<?php
//get the birthday and the age before first friday of june
    $firstFridayOfJune =date('Y-m-d',  strtotime('first Friday of '.'June'.' '.$settings->school_year));
    $bdate = $student->temp_bdate;
//    $from = new DateTime($bdate);
//    $to   = new DateTime($firstFridayOfJune);
    $bdateItems = explode('-', $bdate);
    $m = $bdateItems[1];
    $d = $bdateItems[2];
    $y = $bdateItems[0];


    if(abs(date('m')<$m)){
        $yearsOfAge  = ((date('Y') - date('Y',strtotime($bdate))))-1;

    }else{
        $yearsOfAge = (date('Y') - date('Y',strtotime($bdate)));
    }
function getGrade($subject, $sub_id)
{
    if($sub_id!=20):
          $plg = Modules::run('gradingsystem/getEquivalent',round($subject->row()->final_rating, 1));
        else:
         $plg = Modules::run('gradingsystem/getBGBEquivalent',round($subject->row()->final_rating, 1))   ;

        endif;

    if($subject->row()->final_rating==""):
        $plg = "";
    endif;

    return $plg;
}

function getFinalGrade($grade)
{
    $plg = Modules::run('gradingsystem/getLetterGrade', $grade);
    foreach($plg->result() as $plg){
        if( $grade >= $plg->from_grade && $grade <= $plg->to_grade){


                $grade = $plg->letter_grade;

            if($grade!="" || $grade!=0 || $grade < 60):
                $grade = $grade;
            else:
                $grade = "";
            endif;
        }
    }

    return $grade;
}
$settings = Modules::run('main/getSet');
$pdf->SetY(3);
$pdf->SetFont('helvetica', 'B', 11);
$pdf->MultiCell(300, 0,ucfirst($settings->set_school_name),0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(300, 0, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


//left column

$pdf->SetY(1);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln(13);
$pdf->SetX(5);
$pdf->MultiCell(12, 5, 'Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(50 , 5, strtoupper($student->lastname.', '.$student->firstname.' '.substr($student->middlename, 0, 1).'. '),'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(8, 5, 'Sex :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10 , 5, $student->sex,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
$pdf->MultiCell(8, 5, 'Age :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6 , 5, $yearsOfAge,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'Birthday:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(28 , 5, date('F d, Y',strtotime($bdate)),'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$next = $settings->school_year+1;
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(12, 5, 'Grade:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15 , 5, $student->level,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, 'Secton:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20 , 5, $student->section,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
$pdf->MultiCell(20, 5, 'School Year:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, $settings->school_year.' - '.$next,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(18, 5, 'Curriculum:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'K - 12','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(12, 5, 'LRN:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, $student->lrn ,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(8);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX(15);
$pdf->SetFillColor(200, 220, 255);
$pdf->MultiCell(40, 10.5, 'SUBJECTS',1, 'L', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(48 , 5, 'GRADING PERIOD','LTR', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(24 , 10.5, 'FINAL GRADE',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
//$pdf->MultiCell(12 , 10.5, 'No. of Units',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(15 , 10.5, 'ACTION TAKEN',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetXY(55, 38);
$pdf->MultiCell(12, 5, '1',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '2',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '3',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '4',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);

//loop through the subjects
$i=0;
$m = 0;
$mp = 0;
$mapeh1 = 0;
$mapeh2 = 0;
$mapeh3 = 0;
$mapeh4 = 0;
foreach($subject_ids as $sp):
      $singleSub = Modules::run('academic/getSpecificSubjects', $sp->sub_id);
    if($singleSub->parent_subject==18):
        $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 1, $sy);
        $fg1 += $fg->row()->final_rating;
        $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 2, $sy);
        $sg1+=$sg->row()->final_rating;
        $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 3, $sy);
        $tg1+=$tg->row()->final_rating;
        $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 4, $sy);
        $frg1+=$frg->row()->final_rating;
        $mp+=1;
    endif;
endforeach;
    $mapeh1 = round(($fg1/$mp), 2);
    $mapeh2 = round(($sg1/$mp), 2);
    $mapeh3 = round(($tg1/$mp), 2);
    $mapeh4 = round(($frg1/$mp), 2);
    $finalMAPEH = ($mapeh1+$mapeh2+$mapeh3+$mapeh4)/4;

foreach($subject_ids as $s){
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $pdf->SetX(15);
    if($singleSub->parent_subject!=18):
        $pdf->MultiCell(40, 5, $singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    else:

        $m++;
        if($m==1):
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->MultiCell(40, 5, 'MAPEH',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, ($mapeh1==0?'':$mapeh1),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->MultiCell(12, 5, ($mapeh2==0?'':$mapeh2),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->MultiCell(12, 5, ($mapeh3==0?'':$mapeh3),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->MultiCell(12, 5, ($mapeh4==0?'':$mapeh4),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->SetFont('helvetica', 'N', 8);
            $pdf->MultiCell(24, 5, ($mapeh4==0?'':$finalMAPEH),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->MultiCell(15, 5, ($mapeh4==0?'':($finalMAPEH>=75?'Passed':'Failed')),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->Ln();
            $pdf->SetX(15);
            $pdf->MultiCell(40, 5, '      '.$singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        else:
           $pdf->MultiCell(40, 5, '      '.$singleSub->subject,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;

    endif;
    $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, $term, $sy);
    if(getGrade(Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, $term, $sy))==""):
        $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    else:
        $units = $singleSub->unit_a;
      // $totalUnits += $units;
        $partialGrade = ($fg->row()->final_rating);
        $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
        $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
        $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
        $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);

        $pdf->MultiCell(12, 5, $fg->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
        $pdf->MultiCell(12, 5, $sg->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
        $pdf->MultiCell(12, 5, $tg->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
        $pdf->MultiCell(12, 5, $frg->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');

    endif;
        $first = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy)->row()->final_rating;
        $second = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy)->row()->final_rating;
        $third = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy)->row()->final_rating;
        $fourth = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy)->row()->final_rating;

    if($s->sub_id!=124 && $singleSub->parent_subject!=18):
        $i++;
    endif;



    $finalAverage = ($first+$second+$third+$fourth)/4;


    Modules::run('gradingsystem/saveGeneralAverage', $student->section_id, $student->uid, $s->sub_id, $sy, $finalAverage);

        if($fourth!=0):
            if($s->sub_id!=20):
                $pdf->MultiCell(24, 5,  round($finalAverage, 2),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            else:
                $pdf->MultiCell(24, 5,  getFinalGrade(round($finalAverage, 2)),1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            endif;
            if($finalAverage >= 75):
                $pdf->MultiCell(15, 5, 'Passed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
            else:
                 $pdf->SetTextColor(255, 0, 0);
                 $pdf->MultiCell(15, 5, 'Failed',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'T');
                 $pdf->SetTextColor(000, 0, 0);

            endif;
        else:
            $pdf->MultiCell(24, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
            $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
        endif;
    $pdf->Ln(); //go to next line

    if($s->sub_id!=124 && $singleSub->parent_subject!=18):
        $generalFinal += $finalAverage;
        //$generalFinal = $generalFinal/$i;
    endif;
        //$generalFinal = round($generalFinal/$i, 3);


}
        $bhRating1 = Modules::run('gradingsystem/getBHRating', $student->uid, 1, $sy);
        foreach ($bhRating1->result() as $bh1):
            $trans1 = Modules::run('gradingsystem/new_gs/getNumericalTransmutation', $bh1->bh_id, $bh1->rate);
            $total1 += $trans1->trans_info;
        endforeach;

        $trans1 = Modules::run('gradingsystem/new_gs/getNumericalTransmutation', 0, $total1);

        $bhRating2 = Modules::run('gradingsystem/getBHRating', $student->uid, 2, $sy);
        foreach ($bhRating2->result() as $bh2):
            $trans2 = Modules::run('gradingsystem/new_gs/getNumericalTransmutation', $bh2->bh_id, $bh2->rate);
            $total2 += $trans2->trans_info;
        endforeach;

        $trans2 = Modules::run('gradingsystem/new_gs/getNumericalTransmutation', 0, $total2);

        $bhRating3 = Modules::run('gradingsystem/getBHRating', $student->uid, 3, $sy);
        foreach ($bhRating3->result() as $bh3):
            $trans3 = Modules::run('gradingsystem/new_gs/getNumericalTransmutation', $bh3->bh_id, $bh3->rate);
            $total3 += $trans3->trans_info;
        endforeach;

        $trans3 = Modules::run('gradingsystem/new_gs/getNumericalTransmutation', 0, $total3);
        $bhRating4 = Modules::run('gradingsystem/getBHRating', $student->uid, 4, $sy);
        foreach ($bhRating4->result() as $bh4):
            $trans4 = Modules::run('gradingsystem/new_gs/getNumericalTransmutation', $bh4->bh_id, $bh4->rate);
            $total4 += $trans4->trans_info;
        endforeach;

        $trans4 = Modules::run('gradingsystem/new_gs/getNumericalTransmutation', 0, $total4);

        $conducts = Modules::run('reports/getaconduct', $student->uid);
        switch ($conducts->row()->cd_first) {
              case 1:
                $c1 = "U";
                break;
              case 2:
                $c1 = "NI";
                break;
              case 3:
                $c1 = "S";
                break;
              case 4:
                $c1 = "VS";
                break;
              case 5:
                $c1 = "C";
                break;
              default:
                $c1 = "-";
                break;
            }
        switch ($conducts->row()->cd_second) {
              case 1:
                $c2 = "U";
                break;
              case 2:
                $c2 = "NI";
                break;
              case 3:
                $c2 = "S";
                break;
              case 4:
                $c2 = "VS";
                break;
              case 5:
                $c2 = "C";
                break;
              default:
                $c2 = "-";
                break;
            }
        switch ($conducts->row()->cd_third) {
              case 1:
                $c3 = "U";
                break;
              case 2:
                $c3 = "NI";
                break;
              case 3:
                $c3 = "S";
                break;
              case 4:
                $c3 = "VS";
                break;
              case 5:
                $c3 = "C";
                break;
              default:
                $c3 = "-";
                break;
            }
        switch ($conducts->row()->cd_fourth) {
              case 1:
                $c4 = "U";
                break;
              case 2:
                $c4 = "NI";
                break;
              case 3:
                $c4 = "S";
                break;
              case 4:
                $c4 = "VS";
                break;
              case 5:
                $c4 = "C";
                break;
              default:
                $c4 = "-";
                break;
            }

    $pdf->SetX(15);
    $pdf->MultiCell(40, 5, 'CONDUCT',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12, 5, $c1,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, $c2,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, $c3,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, $c4,1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(24 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');

//end of Grading Sheets
    $pdf->SetX(15);
    $pdf->MultiCell(40, 5, '',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(24 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');

    $pdf->Ln();
    $pdf->SetX(15);
    $pdf->MultiCell(40, 5, 'General Average',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $i = $i + 1;
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(12, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(24 , 5, ($frg->row()->final_rating==0?'':($generalFinal==""?'':round(($generalFinal+$finalMAPEH)/$i,3))),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');


    if(!Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy)):
       if($generalFinal!=""):
            Modules::run('gradingsystem/saveFinalAverage', $student->uid, round((($generalFinal+$finalMAPEH)/$i),3), $sy);
       endif;
    endif;

    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->Ln(7);
    $pdf->SetX(20);
    $pdf->MultiCell(110, 5, 'DESCRIPTIONS:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->Ln(4);
    $pdf->SetX(20);
    $pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(55, 5, 'Outstanding :  90 - 100',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(55, 5, 'Very Satisfactory : 85 - 89',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(20);
    $pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(55, 5, 'Satisfactory: 80 - 84',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->MultiCell(55, 5, 'Fairly Satisfactory :  75-79',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M');
    $pdf->Ln(4);
    $pdf->SetX(20);
    $pdf->MultiCell(25 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(55, 5, 'Did Not Meet Expectations :   Below 75',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M');

//Attendance Record
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(145, 5, 'ATTENDANCE REPORT',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(15);
$pdf->MultiCell(30, 5, '',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Jun',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Jul',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Aug',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Sept',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Oct',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Nov',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Dec',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Jan',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Feb',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Mar',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Apr',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, 'Tot',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(15);
$pdf->MultiCell(30, 5, 'No. of Days in SY',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$x = 5;
for($d=1;$d<=11;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    endif;
    $next = $sy+1;
    if(date('Y')>$sy):
        if($m<abs(06)):
            $year = $next;
        else:
            $year = $sy;
        endif;
    else:
        if($m<abs(06) && date('Y')>$sy):
            $year = date('Y');
        else:
            $year = $sy;
        endif;
    endif;

    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $year);
    $holiday = Modules::run('calendar/holidayExist', $m, $year);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    // if($m == 4){
        // $totalDays += $totalDaysInAMonth-$totalDaysInAMonth;
    // } else {
        $totalDays += $totalDaysInAMonth;
    // }

    // $pdf->MultiCell(8, 5,($m==4?0:$totalDaysInAMonth) ,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(8, 5,$totalDaysInAMonth ,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
}

$pdf->MultiCell(8, 5, $totalDays,1, 'BR', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(15);
$pdf->MultiCell(30, 5, 'No of Days Present',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$x = 5;
for($d=1;$d<=11;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    endif;
    $next = $sy+1;
    if(date('Y')>$sy):
        if($m<abs(06)):
            $year = $next;
        else:
            $year = $sy;
        endif;
    else:
        if($m<abs(06) && date('Y')>$sy):
            $year = date('Y');
        else:
            $year = $sy;
        endif;
    endif;

    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $year);
    $holiday = Modules::run('calendar/holidayExist', $m, $year);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;

            if($this->session->userdata('attend_auto')):
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $year, $sy);
            else:
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $year, $sy);
            endif;

    if($pdays>0):
        $pdf->MultiCell(8, 5, ($pdays>$totalDaysInAMonth?$totalDaysInAMonth:$pdays),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    else:
        $pdf->MultiCell(8, 5, 0 ,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    endif;

    $total_pdays += ($pdays>$totalDaysInAMonth?$totalDaysInAMonth:$pdays);

}

$pdf->MultiCell(8, 5, $total_pdays,1, 'BR', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(15);
$pdf->MultiCell(30, 5, 'No of Days Absent',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$x = 5; $abs = 0; $ba ='';
for($d=1;$d<=11;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    endif;
    $next = $sy+1;
    if(date('Y')>$sy):
        if($m<abs(06)):
            $year = $next;
        else:
            $year = $sy;
        endif;
    else:
        if($m<abs(06) && date('Y')>$sy):
            $year = date('Y');
        else:
            $year = $sy;
        endif;
    endif;

    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $year, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $year);
    $holiday = Modules::run('calendar/holidayExist', $m, $year);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;

            if($this->session->userdata('attend_auto')):
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $year, $sy);
            else:
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $year, $sy);
            endif;
    $adays = $totalDaysInAMonth-$pdays;
    $ba = $ba.' <> '.$adays;
    if($pdays>0 && $d!=11){
        $pdf->MultiCell(8, 5, ($adays<0?0:$adays),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        if ($adays>0) {
            $abs = $abs + $adays;
        }
    }else{
        $pdf->MultiCell(8, 5, 0 ,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    }

    $total_adays += ($totalDaysInAMonth-$pdays);

}

$pdf->MultiCell(8, 5, $abs,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 8);
// $pdf->MultiCell(145, 5, $ba,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(145, 5, 'Certificate of Eligibility',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln();
$pdf->MultiCell(25, 5, 'Lacks credit in:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25 , 5, 'Accomplished By:',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(55 , 5, $adv,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->MultiCell(25, 5, 'Promotable to:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 8);

$pdf->Ln(10);
$pdf->MultiCell(55 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln();
$pdf->MultiCell(55 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, 'Principal',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->MultiCell(135 , 25, "Adventist Academy Cebu believes that it is only "
        . "through the concerted effort and cooperation of the Home and the School that "
        . "positive growth of a child can be attained. This report card is a comprehensive "
        . "assessment of your child's activities in school but does not portray his/her "
        . "detailed behavior. We. therefore, encourage you to confer with your child's teachers "
        . "with regards to this assessment and his/her behavior in school so that remediation, "
        . "if needed, or any concerns you and the teachers have about your child can be addressed.",0, 'C', 0, 0, '', '', true, 0, false, true, 25, 'M');

//Start of right Column
$pdf->SetXY(145,3);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(15);
$pdf->setX(150);
$pdf->MultiCell(140, 5, 'REPORTS ON LEARNERS OBSERVED VALUES',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();


$pdf->setX(150);
$pdf->MultiCell(30, 10.5, 'CORE VALUES',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(65, 10.5, 'Behavioral Statements',1, 'C', 1, 0, '', '', true, 0, false, true, 10.5, 'M');
$pdf->MultiCell(48, 5, 'Quarter',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetXY(245, 28.5);
$pdf->MultiCell(12, 5, '1',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '2',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '3',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(12, 5, '4',1, 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();

$coreValues = Modules::run('gradingsystem/getCoreValues');


    foreach ($coreValues as $cv):
        $customList = Modules::run('gradingsystem/getBehaviorRate', $cv->core_id);
        $customCount = count($customList->result());
        $rowCount = $customCount * 10.5;
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setX(150);
        $pdf->MultiCell(30, $rowCount, $cv->core_values,1, 'C', 0, 0, '', '', true, 0, false, true, $rowCount, 'M');
        foreach ($customList->result() as $cl):
            $firstbhg = Modules::run('gradingsystem/new_gs/sumBHGroup', $cl->bh_id, $student->uid, 1, $sy);
            $firstBHtrans = Modules::run('gradingsystem/new_gs/getBHTRansmutation', $firstbhg->rate);
            $secondbhg = Modules::run('gradingsystem/new_gs/sumBHGroup', $cl->bh_id, $student->uid, 2, $sy);
            $secondBHtrans = Modules::run('gradingsystem/new_gs/getBHTRansmutation', $secondbhg->rate);
            $thirdbhg = Modules::run('gradingsystem/new_gs/sumBHGroup', $cl->bh_id, $student->uid, 3, $sy);
            $thirdBHtrans = Modules::run('gradingsystem/new_gs/getBHTRansmutation', $thirdbhg->rate);
            $fourthbhg = Modules::run('gradingsystem/new_gs/sumBHGroup', $cl->bh_id, $student->uid, 4, $sy);
            $fourthBHtrans = Modules::run('gradingsystem/new_gs/getBHTRansmutation', $fourthbhg->rate);

            $pdf->SetFont('helvetica', 'N', 8);
            $pdf->setX(180);
            $pdf->MultiCell(65, 10.5, $cl->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 10.5, 'T');
            $pdf->SetFont('helvetica', 'N', 10);
            $pdf->MultiCell(12, 10.5, $firstBHtrans,1, 'C', 0, 0, '', '', true, 0, false, true, 10.5, 'M');
            $pdf->MultiCell(12, 10.5, $secondBHtrans,1, 'C', 0, 0, '', '', true, 0, false, true, 10.5, 'M');
            $pdf->MultiCell(12, 10.5, $thirdBHtrans,1, 'C', 0, 0, '', '', true, 0, false, true, 10.5, 'M');
            $pdf->MultiCell(12, 10.5, ($fourthbhg->rate==0?"":$fourthBHtrans),1, 'C', 0, 0, '', '', true, 0, false, true, 10.5, 'M');
            $pdf->Ln();
        endforeach;
        //$pdf->Ln();
    endforeach;
$pdf->Ln(8);
$pdf->setX(150);
$pdf->MultiCell(40, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(20, 5, 'Marking','B', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(30, 5, 'Non-Numerical Rating','B', 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$pdf->setX(150);
$pdf->MultiCell(40, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(20, 5, 'AO',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(30, 5, 'Always Observed',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$pdf->setX(150);
$pdf->MultiCell(40, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(20, 5, 'SO',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(30, 5, 'Sometimes Observed',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$pdf->setX(150);
$pdf->MultiCell(40, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(20, 5, 'RO',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(30, 5, 'Rarely Observed',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$pdf->setX(150);
$pdf->MultiCell(40, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(20, 5, 'NO',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(10, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(30, 5, 'Not Observed',0, 'C', 0, 0, '', '', true, 0, false, true,5, 'M');

$pdf->SetFillColor(212, 214, 216);
$pdf->Ln(10);
$pdf->setX(155);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 10, '',0, 'C', 0, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(120, 5, 'Cancelation and Transfer of eligibility',0, 'L', 0, 0, '', '', true, 0, false, true,5, 'M');

$pdf->Ln();
$pdf->setX(155);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(12, 10, '','TL', 'C', 1, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(118, 10, 'Has been admitted to _______________________________   Date: ________________','TR', 'L', 1, 0, '', '', true, 0, false, true,10, 'M');

$pdf->Ln(7);
$pdf->setX(155);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(80, 5, '','L', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->MultiCell(50, 5, '','R', 'C', 1, 0, '', '', true, 0, false, true,5, 'M');
$pdf->Ln();
$pdf->setX(155);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(80, 10, '','LB', 'C',1, 0, '', '', true, 0, false, true,10, 'M');
$pdf->MultiCell(50, 10, 'Registrar / Principal','BR', 'C', 1, 0, '', '', true, 0, false, true,10, 'M');
