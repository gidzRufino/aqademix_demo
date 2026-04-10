
<?php
foreach ($subjects as $s):
    $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->sec_id, $semester, $school_year); 
    $sched = json_decode($scheds);
    $students = Modules::run('college/subjectmanagement/getStudentsPerSection', $s->sec_id, $semester, $school_year);
    if($s->semester == $sem):
        ?>
        <tr class="pointer" onclick="window.open('<?php echo site_url('college/subjectmanagement/printStudentsPerSubject/').$s->s_id.'/'.$s->sec_id.'/'.$semester.'/'.$school_year ?>', '_blank')">
            <td><?php echo $s->sub_code ?></td>
            <td><?php echo $s->section ?></td>
            <td><?php echo $s->s_desc_title; ?></td>
            <td class="text-center">
                <?php echo ($s->sub_code=="NSTP 11" || $s->sub_code=="NSTP 12" || $s->sub_code=="NSTP 1" || $s->sub_code=="NSTP 2" ? 3 :($s->s_lect_unit+$s->s_lab_unit)) ?>
            </td>  
            <td class="text-center">
                <?php   
                        echo ($sched->count > 0 ? $sched->day:'TBA');
                ?>
            </td>
            <td class="text-center">
                <?php  
                        echo ($sched->count > 0 ? $sched->time :'TBA');
                ?>
            </td>
            <td class="text-center">
                <?php  
                        echo ($sched->count > 0 ? $sched->room :'TBA');
                ?>
            </td>
            <td class="text-center">
                <?php
                    echo strtoupper($sched->instructor);
                ?>
            </td>
            <td class="text-center"><?php 

            if($students->num_rows()>=45):
                $style = 'text-danger';
            else:
                $style = 'text-success';
            endif;
            ?>
                <span class="<?php echo $style ?>">
                    <?php
                    $totalEn = 0;
                    foreach ($students->result() as $st):
                        if ($st->status == 1):
                            $totalEn++;
                        endif;
                    endforeach;
                    echo $totalEn;
                    ?>
                </span>
            </td>
            <td class="text-center">
                <?php
                    if($students->num_rows()>45):
                        $status = 'Over Populated';
                    elseif($students->num_rows()==45):
                        $status = 'Closed';
                    elseif($students->num_rows()<45):
                        $status = 'Open';
                    endif;
                ?>
                <span class="<?php echo $style ?>">
                    <?php echo $status ?>
                </span>
            </td>
        </tr>
        <?php    
    endif;
endforeach;
                