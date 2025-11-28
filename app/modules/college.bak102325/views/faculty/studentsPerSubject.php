<?php
 switch ($sem):
     case 1:
         $semester = 'First';
     break;    
     case 2:
         $semester = 'Second';
     break;    
     case 3:
         $semester = 'Summer';
     break;    
     default :
         $semester = 'First';
     break;    
 endswitch;
 
 ?>
<div class="col-lg-12">
    <div class="col-lg-12">
        <h4 class="text-center">COLLEGE GRADE SHEET
        </h4>
        <a href="<?php echo base_url('college/gradingsystem/printGradeSheet/'). base64_encode($faculty_id).'/'.$section_id.'/'.$subject_id.'/'.$sem.'/'.$term.'/'.$school_year ?>" target="_blank"  class="btn btn-default btn-xs pull-right" title="Print Grade Sheet" ><i class="fa fa-print fa-2x"></i></a>
    </div>
    <div class="col-lg-10">
        <div class="col-lg-6">
            <dl class="dl-horizontal">
                <dt>
                    Instructor : 
                </dt>
                <dd>
                    <?php 

                    $faculty = Modules::run('hr/getEmployeeName', $faculty_id);
                    echo $faculty->firstname.' '.$faculty->lastname;

                            ?>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Schedule : 
                </dt>
                <dd>
                    <?php $scheds = Modules::run('college/schedule/getSchedulePerSection', $section_id, $sem, $school_year); 
                        $sched = json_decode($scheds);
                        echo ($sched->count > 0 ? ' [ '.$sched->day.' ] '.$sched->time:'TBA');
                    ?>
                </dd>
            </dl>
        </div>
        <div class="col-lg-6 pull-right">
            <dl class="dl-horizontal">
                <dt>
                    School Year : 
                </dt>
                <dd>
                    <?php 
                    $next = $students->row()->sy +1;
                    echo $students->row()->sy.' - '.$next; 
                            ?>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Semester : 
                </dt>
                <dd>
                    <?php 
                        echo $semester;
                            ?>
                </dd>
            </dl>
            
        </div>
        
    </div>
    <div class='col-lg-10'>
        <div class="col-lg-10">
            <dl class="dl-horizontal">
                <dt>
                    Subject : 
                </dt>
                <dd>
                    <?php 
                    
                        $subject = Modules::run('college/subjectmanagement/getSubjectPerId', $subject_id, $school_year);
                        echo $subject->sub_code.' - '.$subject->s_desc_title;

                            ?>
                </dd>
            </dl>
        </div>
    </div>
    
</div>
<div class="col-lg-12">
    <table class='table table-hover table-bordered'>
        <tr>
            <th style='vertical-align: middle;' rowspan="2">#</th>
            <th style='vertical-align: middle;' rowspan="2">LAST NAME</th>
            <th style='vertical-align: middle;' rowspan="2">FIRST NAME</th>
            <th style='vertical-align: middle;' rowspan="2">COURSE</th>
        </tr>
        <tr>
          <th class="text-center">Grade</th>   
          <th class="text-center"><button class="btn btn-info btn-xs" onclick="approveAll()" >APPROVE ALL</button></th>   
        </tr>
        <?php
            $i = 0;   
            foreach ($students->result() as $s):
                if($s->st_id!=""):
                    $i++;
        ?>
                <tr class="st_value" id="tr_<?php echo $i.'_'.$s->st_id ?>" row="<?php echo $i ?>" st_id="<?php echo $s->st_id ?>" sub_id="<?php echo $subject_id ?>">
                    <th><?php echo $i?></th>
                    <th><?php echo strtoupper($s->lastname); ?></th>
                    <th><?php echo ucwords(strtolower($s->firstname)); ?></th>
                    <th><?php echo $s->short_code .' - '.$s->year_level; ?></th>
                    <?php
                        $grade = Modules::run('college/gradingsystem/getFinalGrade', $s->st_id, $s->c_id, $subject_id, $sem, $school_year, $term);
                       
                        ?>
                            <td class="text-center text-strong"
                                id="<?php echo $i.'_'.$s->st_id ?>"
                                gst="<?php echo $term ?>"
                                st_id="<?php echo $s->st_id ?>" 
                                ondblclick="editTable(this.id)"
                                row="<?php echo $i?>"
                                term="<?php echo $term ?>"
                                course_id ="<?php echo $s->c_id ?>"
                                year_level ="<?php echo $s->year_level ?>"
                                ><?php echo $grade->gsa_grade ?></td>
                             
                            
                    <?php
                            $fg = $grade->gsa_grade;
                        
                        
                        $finalGrade = Modules::run('college/gradingsystem/getFinalGrade', $s->st_id, $s->c_id, $subject_id, $sem, $school_year, $term);
                        if($this->session->is_superAdmin || $this->session->position == 'Registrar' || $this->session->position == 'Dean'):
                        ?>
                            <td id="td_<?php echo $i ?>" style="text-align: center" >
                                <?php echo ($finalGrade->is_approved==1?'<button class="btn btn-success btn-xs disabled" >APPROVED</button>':'<button id="btn_'.$i.'" class="btn btn-info btn-xs" onclick="approveGrade(&quot;'.$i.'&quot;, &quot;'.$s->st_id.'&quot;, &quot;'.$subject_id.'&quot;)">Approve</button>'); ?>
                            </td>
                        <?php endif; ?>    
                </tr>
        <?php 
            
                endif;
            unset($fg);
            endforeach;
        ?>
    </table>
</div>


