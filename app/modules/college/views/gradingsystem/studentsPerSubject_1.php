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
<div class="col-lg-9">
    <div class="col-lg-12">
        <h4 class="text-center">COLLEGE GRADE SHEET</h4>
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
                    <?php $scheds = Modules::run('college/schedule/getSchedulePerSection', $section_id); 
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
                    $next = $students->row()->school_year +1;
                    echo $students->row()->school_year.' - '.$next; 
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
                    foreach ($subjects as $sub):
                        echo ($subject_id==$sub->s_id?$sub->sub_code.' - '.$sub->section:'');
                    endforeach;

                            ?>
                </dd>
            </dl>
        </div>
    </div>
    
</div>
<div class="col-lg-3 pull-right">
    <div class="panel panel-primary" style="margin-top:5%">
        <div class="panel-heading">
            Subjects Taught
        </div>
        <div id="subBody" class="panel-body no-padding" >
                <div class="btngroup">
                    <?php foreach ($subjects as $sub): ?>
                        <div onclick="loadAssignment('<?php echo $faculty_id; ?>','<?php echo $sub->sched_gcode; ?>','<?php echo $sub->section_id; ?>','<?php echo $sub->s_id; ?>')" 
                              class='sub_btn btn btn-info <?php echo ($subject_id==$sub->s_id?'active':'') ?> alert alert-info no-margin' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;"
                              id="<?php echo $sub->s_id ?>_btn">

                            <div class="notify"><?php echo $sub->sub_code.' - '.$sub->section ?></div>  
                        </div>
                    <?php endforeach; ?>
                </div>
        </div>
    </div>


</div>

<div class="col-lg-12">
    <hr />
</div>

<div class="col-lg-12">
    <table class='table table-hover table-bordered'>
        <tr>
            <th style='vertical-align: middle;' rowspan="2">#</th>
            <th style='vertical-align: middle;' rowspan="2">LAST NAME</th>
            <th style='vertical-align: middle;' rowspan="2">FIRST NAME</th>
            <th style='vertical-align: middle;' rowspan="2">COURSE</th>
            <?php foreach($term->result() as $t): ?>
                <th class="text-center" colspan="4"><?php echo $t->gst_term; ?></th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach($term->result() as $t): 
                    foreach($assessCategory->result() as $ac): 
                ?>
                    <th class="text-center"><?php echo $ac->gsc_category ?></th>
                
            <?php 
                    endforeach;?>
                 
                    <th class="text-center">Grade</th>   
                    <th class="text-center"></th>   
            <?php        
                endforeach; ?>
                    <th>Final Grade</th>
        </tr>
        <?php
            $i = 1;   
            foreach ($students->result() as $s):
        ?>
                <tr>
                    <th><?php echo $i++?></th>
                    <th><?php echo $s->lastname; ?></th>
                    <th><?php echo $s->firstname; ?></th>
                    <th><?php echo $s->short_code .' - '.$s->year_level; ?></th>
                    
                    <?php foreach($term->result() as $t): 
                            foreach($assessCategory->result() as $ac): 
                                $grade = Modules::run('college/gradingsystem/getRecordedGrade', $s->st_id, $ac->gsc_id, $t->gst_id, $sem, $school_year, $subject_id);
                                //print_r($grade->row());
                        ?>
                            <td id="<?php echo $i.'_'.$t->gst_id.'_'.$ac->gsc_id ?>" 
                                st_id="<?php echo $s->st_id ?>" 
                                tdn="<?php echo $ac->gsc_id?>"
                                gst="<?php echo $t->gst_id?>"
                                row="<?php echo $i?>"
                                term="<?php echo $t->gst_id ?>"
                                ondblclick="editTable(this.id)" 
                                class="text-center"
                                style="width:5%;"
                                ><?php echo $grade->row()->grade ?></td>

                    <?php 
                            $partialGrade += $grade->row()->grade * $grade->row()->subject_weight;
                            endforeach;?>

                            <td id="<?php echo $i.'_'.$t->gst_id.'_3' ?>"  class="text-center"
                                data-toggle="context" 
                                data-target="#"
                                
                                ><strong><?php echo ($partialGrade!=0?number_format($partialGrade,2,'.',','):'') ?></strong>
                            </td>   
                            <td id="<?php echo $s->st_id.'_'.$t->gst_id ?>" onmouseover="$('#st_id').val('<?php echo $s->st_id ?>'), $('#term_id').val('<?php echo $t->gst_id ?>'), $('#year_level').val('<?php echo $s->year_level ?>'), $('#course_id').val('<?php echo $s->course_id ?>')">
                                <?php echo ($grade->row()->is_final==0?'<button class="btn btn-info btn-xs" onclick="validateGrade(), $(this).html(\'Validated\'), $(this).removeClass(\'btn-info\'), $(this).addClass(\'btn-success\')" >Validate</button>': '<button class="btn btn-success btn-xs">Validated</button>'); ?>
                            </td>
                    <?php
                            $finalGrade += $partialGrade * $grade->row()->term_weight;
                            unset($partialGrade);
                        endforeach; ?>
                            <td class="text-center text-strong"><?php echo ($finalGrade!=0?number_format($finalGrade,2,'.',',').' | ':'') ?><strong id="<?php echo $s->st_id ?>_fg"><?php echo Modules::run('college/gradingsystem/getTransmutation', number_format($finalGrade,2,'.',',')) ?></strong></td>
                            
                </tr>
        <?php 
        
            unset($finalGrade);
            endforeach;
        ?>
    </table>
</div>

