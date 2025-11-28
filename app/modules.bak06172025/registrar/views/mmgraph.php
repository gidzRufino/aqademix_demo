<?php
$settings = Modules::run('main/getSet');
if($school_year==NULL):
    $sy = $settings->school_year;
else:
    $sy = $school_year;
endif;
if(abs($month)<6 && date('Y')>$sy):
    $year = date('Y');
    
    if($month>1):
        $prevYear = $year;
        $prevMonth = $month-1;
    else:
        $prevMonth = 12;
        $prevYear = $year-1;
    endif;
    
else:
    $year = $sy;
    $prevYear = $year;
    $prevMonth = $month-1;
endif;
//echo $year;
   
   $gradelevel = Modules::run('registrar/getGradeLevel');
    
   $male = Modules::run('registrar/getStudentsByGradeLevel',null, null, 'Male', NULL);
   $female = Modules::run('registrar/getStudentsByGradeLevel',null, null, 'Female', NULL);
   
   
   //echo $tiMale->num_rows()();
?>
<div class="col-lg-12 panel">
    <div class="panel-heading" style="height:40px;">
        <h3 class="text-center" style="margin:0">Learner's Monthly Movement Breakdown</h3>
    </div>
    <div class="panel-body" style="padding:0;">
        <table class="table table-bordered text-center">
            <tr>
                <td rowspan="3" style="width:70px; vertical-align: middle;">Grade Level</td>
                <td rowspan="2" colspan="3" style="vertical-align: middle;">Registered Learner (Beginning of School Year)</td>
                <td style="background:#5CB85C; vertical-align: middle;" colspan="9">Transferred In</td>
                <td style="background:#428BCA; vertical-align: middle;" colspan="9">Transferred Out</td>
                <td style="background:#D9534F; vertical-align: middle;" colspan="9">Dropped Out</td>
                <td style="background:#F0AD4E; vertical-align: middle;" rowspan="2" colspan="3" style="vertical-align: middle;">Registered Learner (As of The End of the Month) </td>
            </tr>
            <tr>
                <td style="background:#5CB85C; vertical-align: middle;" colspan="3">Previous Month</td>
                <td style="background:#5CB85C; vertical-align: middle;" colspan="3">Current Month</td>
                <td style="background:#5CB85C; vertical-align: middle;" colspan="3">End of the Month</td>
                <td style="background:#428BCA; vertical-align: middle;" colspan="3">Previous Month</td>
                <td style="background:#428BCA; vertical-align: middle;"colspan="3">Current Month</td>
                <td style="background:#428BCA; vertical-align: middle;"colspan="3">End of the Month</td>
                <td style="background:#D9534F; vertical-align: middle;" colspan="3">Previous Month</td>
                <td style="background:#D9534F; vertical-align: middle;" colspan="3">Current Month</td>
                <td style="background:#D9534F; vertical-align: middle;" colspan="3">End of the Month</td>
            </tr>
            <tr>
                <?php
                    for($i=0;$i<11;$i++):
                        if($i>0 && $i < 3):
                            $style='style="background:#5CB85C; vertical-align: middle;"';
                        endif;
                        if($i>3 && $i<=6):
                             $style='style="background:#428BCA; vertical-align: middle;"';
                        endif;
                        if($i>6 && $i<=9):
                             $style='style="background:#D9534F; vertical-align: middle;"';
                        endif;
                        if($i>9):
                             $style='style="background:#F0AD4E; vertical-align: middle;"';
                        endif;
                ?>
                    <td <?php echo $style ?>>M</td>
                    <td <?php echo $style ?>>F</td>
                    <td <?php echo $style ?>>T</td>
                <?php
                    endfor;
                ?>
                
            </tr>
            <?php
            foreach ($gradelevel as $gl):
               
                //if($gl->grade_id!=18):
                    $male = Modules::run('registrar/getStudentsByGradeLevel',$gl->grade_id, null, 'Male', NULL, $sy);
                    $female = Modules::run('registrar/getStudentsByGradeLevel',$gl->grade_id, null, 'Female', NULL, $sy);
                    $totalStud = $male->num_rows()+$female->num_rows();
                  
                    //echo $prevMonth;

                    if($totalStud!=0):
                        $ti = Modules::run('registrar/getMLM', $prevYear, $prevMonth, $gl->grade_id, 2);
                        if($ti->num_rows()>0):
                            $tiMalePm = $ti->row()->m;
                            $tiFemalePm = $ti->row()->f;
                        else:
                            $tiMalePm = 0;
                            $tiFemalePm = 0;
                        endif;
                        $tiMale = Modules::run('registrar/getStudentStatus', 2, 'Male', NULL, $month, $year, 1, $gl->grade_id);
                        $tiFemale = Modules::run('registrar/getStudentStatus', 2, 'Female', NULL, $month, $year, 1, $gl->grade_id);

                        $tiMaleFinal = $tiMalePm+$tiMale->num_rows();
                        $tiFemaleFinal = $tiFemalePm+$tiFemale->num_rows();

                        $to = Modules::run('registrar/getMLM', $prevYear, $prevMonth, $gl->grade_id, 1);
                        if($to->num_rows()>0):
                            $toMalePm = $to->row()->m;
                            $toFemalePm = $to->row()->f;
                        else:
                            $toMalePm = 0;
                            $toFemalePm = 0;
                        endif;
                        $toMale = Modules::run('registrar/getStudentStatus', 1, 'Male', NULL, $month, $year, 1, $gl->grade_id);
                        $toFemale = Modules::run('registrar/getStudentStatus', 1, 'Female', NULL, abs($month), $school_year, 1, $gl->grade_id);

                        $toMaleFinal = $toMalePm+$toMale->num_rows();
                        $toFemaleFinal = $toFemalePm+$toFemale->num_rows();

                        $drp = Modules::run('registrar/getMLM', $prevYear, $prevMonth, $gl->grade_id, 3);
                        if($drp->num_rows()>0):
                            $drpMalePm = $drp->row()->m;
                            $drpFemalePm = $drp->row()->f;
                        else:
                            $drpMalePm = 0;
                            $drpFemalePm = 0;
                        endif;
                        $drpMale = Modules::run('registrar/getStudentStatus', 3, 'Male', NULL, $month, $year, 1, $gl->grade_id);
                        $drpFemale = Modules::run('registrar/getStudentStatus', 3, 'Female', NULL, $month, $year, 1, $gl->grade_id);

                        $drpMaleFinal = $drpMale->num_rows()+$drpMalePm;
                        $drpFemaleFinal = $drpFemale->num_rows()+$drpFemalePm;


                        $maleFinal = $male->num_rows()+($tiMale->num_rows()+$tiMalePm)- ($toMaleFinal+$drpMaleFinal);
                        $femaleFinal = ($female->num_rows()+($tiFemalePm+$tiFemale->num_rows())) - ($toFemaleFinal+$drpFemaleFinal);
                        $finalTotal = ($maleFinal+$femaleFinal);
                      
                if($male->num_rows()>0 || $female->num_rows()>0):        
                ?>
                <tr>
                    <td><?php echo $gl->level; ?></td>
                    <td><?php echo $male->num_rows()-($tiMaleFinal); ?></td>
                    <td><?php echo $female->num_rows()-($tiFemaleFinal); ?></td>
                    <td><?php echo (($male->num_rows()-($tiMaleFinal))+($female->num_rows()-($tiFemaleFinal))); ?></td>

                    <!--Transferred In-->
                    <!--Previous-->
                    <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiMalePm; ?></td>
                    <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiFemalePm; ?></td>
                    <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiMalePm+$tiFemalePm; ?></td>

                    <!--Current-->
                    <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiMale->num_rows(); ?></td>
                    <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiFemale->num_rows(); ?></td>
                    <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiMale->num_rows()+$tiFemale->num_rows(); ?></td>

                    <!--Total-->
                    <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiMalePm+$tiMale->num_rows(); ?></td>
                    <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiFemalePm+$tiFemale->num_rows(); ?></td>
                    <td style="background:#5CB85C; vertical-align: middle;"><?php echo ($tiMalePm+$tiMale->num_rows())+($tiFemalePm+$tiFemale->num_rows()); ?></td>
                     <?php 
                        if(($tiMaleFinal+$tiFemaleFinal)!=0)
                            Modules::run('registrar/saveMLM', $tiMalePm+$tiMale->num_rows(), $tiFemalePm+$tiFemale->num_rows(), $gl->grade_id, $month, $year, 2)          
                    ?>
                    <!--Transferred Out-->
                    <!--Previous-->
                    <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMalePm; ?></td>
                    <td style="background:#428BCA; vertical-align: middle;"><?php echo $toFemalePm; ?></td>
                    <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMalePm+$toFemalePm; ?></td>

                    <!--Current-->
                    <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMale->num_rows(); ?></td>
                    <td style="background:#428BCA; vertical-align: middle;"><?php echo $toFemale->num_rows(); ?></td>
                    <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMale->num_rows()+$toFemale->num_rows(); ?></td>

                    <!--Total-->
                    <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMalePm+$toMale->num_rows(); ?></td>
                    <td style="background:#428BCA; vertical-align: middle;"><?php echo $toFemalePm+$toFemale->num_rows(); ?></td>
                    <td style="background:#428BCA; vertical-align: middle;"><?php echo ($toMaleFinal)+($toFemaleFinal); ?></td>
                    <?php 
                        if(($toMaleFinal+$toFemaleFinal)!=0)
                            Modules::run('registrar/saveMLM', $toMaleFinal, $toFemaleFinal, $gl->grade_id, $month, $year, 1)          
                    ?>
                    <!--Dropped Out-->
                    <!--Previous-->
                    <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMalePm; ?></td>
                    <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpFemalePm; ?></td>
                    <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMalePm+$drpFemalePm; ?></td>

                    <!--Current-->
                    <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMale->num_rows(); ?></td>
                    <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpFemale->num_rows(); ?></td>
                    <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMale->num_rows()+$drpFemale->num_rows(); ?></td>

                    <!--Total-->
                    <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMalePm+$drpMale->num_rows(); ?></td>
                    <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpFemalePm+$drpFemale->num_rows(); ?></td>
                    <td style="background:#D9534F; vertical-align: middle;"><?php echo ($drpMalePm+$drpMale->num_rows())+($drpFemalePm+$drpFemale->num_rows()); ?></td>
                    <?php 
                        if(($drpMaleFinal+$drpFemaleFinal)!=0)
                            Modules::run('registrar/saveMLM', $drpMalePm+$drpMale->num_rows(), $drpFemalePm+$drpFemale->num_rows(), $gl->grade_id, $month, $year, 3)          
                    ?>
                    <td style="background:#F0AD4E; vertical-align: middle;"><?php echo $maleFinal-($tiMalePm+$tiMale->num_rows()); ?></td>
                    <td style="background:#F0AD4E; vertical-align: middle;"><?php echo $femaleFinal-($tiFemalePm+$tiFemale->num_rows()); ?></td>
                    <td style="background:#F0AD4E; vertical-align: middle;"><?php echo ($maleFinal-($tiMalePm+$tiMale->num_rows()))+($femaleFinal-($tiFemalePm+$tiFemale->num_rows())); ?></td>
                </tr>
                <?php
                    $mTotal +=$male->num_rows();
                    $fTotal +=$female->num_rows();

                    $tiMalePmTotal += $tiMalePm;
                    $tiFemalePmTotal += $tiFemalePm;
                    $tiMaleTotal += $tiMale->num_rows();
                    $tiFemaleTotal += $tiFemale->num_rows();

                    $toMalePmTotal += $toMalePm;
                    $toFemalePmTotal += $toFemalePm;
                    $toMaleTotal += $toMale->num_rows();
                    $toFemaleTotal += $toFemale->num_rows();

                    $drpMalePmTotal += $drpMalePm;
                    $drpFemalePmTotal += $drpFemalePm;
                    $drpMaleTotal += $drpMale->num_rows();
                    $drpFemaleTotal += $drpFemale->num_rows();


                    $maleFinalTotal += ($maleFinal-($tiMalePm+$tiMale->num_rows()));
                    $femaleFinalTotal += ($femaleFinal-($tiFemalePm+$tiFemale->num_rows()));
                    $overAllFinalTotal += (($maleFinal-($tiMalePm+$tiMale->num_rows()))+($femaleFinal-($tiFemalePm+$tiFemale->num_rows())));

                    endif;
                endif;
            endforeach;
               
            ?>
            <tr>
                <td>TOTAL</td>
                <td><?php echo $mTotal; ?></td>
                <td><?php echo $fTotal?></td>
                <td><?php echo (($mTotal+$fTotal)); ?></td>
                
                <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiMalePmTotal ?></td>
                <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiFemalePmTotal ?></td>
                <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiMalePmTotal+$tiFemalePmTotal ?></td>
                
                <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiMaleTotal ?></td>
                <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiFemaleTotal ?></td>
                <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiMaleTotal+$tiFemaleTotal ?></td>
                
                <td style="background:#5CB85C; vertical-align: middle;" ><?php echo $tiMalePmTotal+$tiMaleTotal ?></td>
                <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiFemalePmTotal+$tiFemaleTotal ?></td>
                <td style="background:#5CB85C; vertical-align: middle;"><?php echo $tiMalePmTotal+$tiFemalePmTotal+$tiMaleTotal+$tiFemaleTotal ?></td>
                
                <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMalePmTotal ?></td>
                <td style="background:#428BCA; vertical-align: middle;"><?php echo $toFemalePmTotal ?></td>
                <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMalePmTotal+$toFemalePmTotal ?></td>
                
                <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMaleTotal ?></td>
                <td style="background:#428BCA; vertical-align: middle;"><?php echo $toFemaleTotal ?></td>
                <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMaleTotal+$toFemaleTotal ?></td>
                
                <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMalePmTotal+$toMaleTotal ?></td>
                <td style="background:#428BCA; vertical-align: middle;"><?php echo $toFemalePmTotal+$toFemaleTotal ?></td>
                <td style="background:#428BCA; vertical-align: middle;"><?php echo $toMalePmTotal+$toFemalePmTotal+$toMaleTotal+$toFemaleTotal ?></td>
                
                <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMalePmTotal ?></td>
                <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpFemalePmTotal ?></td>
                <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMalePmTotal+$drpFemalePmTotal ?></td>
                
                <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMaleTotal ?></td>
                <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpFemaleTotal ?></td>
                <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMaleTotal+$drpFemaleTotal ?></td>
                
                <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMalePmTotal+$drpMaleTotal ?></td>
                <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpFemalePmTotal+$drpFemaleTotal ?></td>
                <td style="background:#D9534F; vertical-align: middle;"><?php echo $drpMalePmTotal+$drpFemalePmTotal+$drpMaleTotal+$drpFemaleTotal ?></td>
                
                <td style="background:#F0AD4E; vertical-align: middle;"><?php echo $maleFinalTotal ?></td>
                <td style="background:#F0AD4E; vertical-align: middle;"><?php echo $femaleFinalTotal?></td>
                <td style="background:#F0AD4E; vertical-align: middle;"><?php echo $overAllFinalTotal?></td>
                
            </tr>
            <tr>
                <td colspan="4" style="background:#E6E6E6; vertical-align: middle;"><h4>BOSY: <?php echo (($mTotal+$fTotal)-($tiMalePmTotal+$tiFemalePmTotal+$tiMaleTotal+$tiFemaleTotal)); ?></h4></td>
                <td colspan="9" style="background:#5CB85C; vertical-align: middle;"><h4>TRANSFERRED IN : <?php echo $tiMalePmTotal+$tiFemalePmTotal+$tiMaleTotal+$tiFemaleTotal.'<br />'.(round((($tiMalePmTotal+$tiFemalePmTotal+$tiMaleTotal+$tiFemaleTotal)/($mTotal+$fTotal))*100, 2)).'%' ?></h4></td>
                <td colspan="9" style="background:#428BCA; vertical-align: middle;"><h4>TRANSFERRED OUT : <?php echo $toMalePmTotal+$toFemalePmTotal+$toMaleTotal+$toFemaleTotal.'<br />'.(round((($toMalePmTotal+$toFemalePmTotal+$toMaleTotal+$toFemaleTotal)/($mTotal+$fTotal))*100, 2)).'%' ?></h4></td>
                <td colspan="9" style="background:#D9534F; vertical-align: middle;"><h4>DROP OUTS : <?php echo $drpMalePmTotal+$drpFemalePmTotal+$drpMaleTotal+$drpFemaleTotal.'<br />'.(round((($drpMalePmTotal+$drpFemalePmTotal+$drpMaleTotal+$drpFemaleTotal)/($mTotal+$fTotal))*100, 2)).'%' ?></h4></td>
                <td colspan="9" style="background:#F0AD4E; vertical-align: middle;"><h4>CURRENT: <?php echo $overAllFinalTotal?></h4></td>
            </tr>
        </table>
        
    </div>
</div>