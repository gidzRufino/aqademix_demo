<div class="col-lg-12 no-padding" style="margin-bottom: 20px;">
    <h5 class="pull-left">Incomplete Subjects <small class="text-danger">[ this is for SF5 report ]</small></h5>
    <br />
    <div class="col-lg-12 no-padding" id="INC">
        <table class="table" id="inc_table">
            <tr>
                <td>
                    <select id="inc_subject">
                        <option>Select Subject</option>
                        <?php
                            $subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $grade_id); 
                            $subject = explode(',', $subject_ids->subject_id);
                        foreach ($subject as $sub)
                                           {  
                            $singleSub = Modules::run('academic/getSpecificSubjects', $sub);
                        ?>
                         <option value="<?php echo $singleSub->subject_id; ?>"><?php echo $singleSub->subject ?></option>  
                        <?php } 

                        ?>
                    </select>
                </td>
                <td>
                    <select id="inputGrade" required>
                          <option>Select Grade Level</option> 
                            <?php 
                                   foreach ($grade_level as $level)
                                     {   
                               ?>                        
                                    <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                            <?php }?>
                        </select>
                </td>
                <td>
                    <select id="inc_option">
                        <option>Select Option</option>
                        <option value="0">Previous Years Completed</option>
                        <option value="1">Current School Year</option>
                    </select>
                </td>
                <td>
                    <i class="fa fa-save pointer" onclick="saveINC('<?php echo $st_id ?>')"></i>
                </td>
            </tr>
            <?php
                $json = Modules::run('reports/getRawINC',$st_id, $this->uri->segment(5));
                if($json->num_rows()> 0):
                    foreach ($json->result() as $r):
                    ?>
            <tr id="tr_<?php echo $r->id ?>">
                <td><?php echo $r->subject ?></td>
                <td><?php echo $r->level ?></td>
                <td><?php if($r->as_of==0): echo 'Previous Years Completed'; else: 'Current School Year'; endif; ?></td>
                <td><i class="fa fa-trash pointer" onclick="deleteINC('<?php echo $r->id ?>')"></td>
            </tr>
                    <?php
                    endforeach;
                endif;
            ?>
        </table>
        
    </div>
</div>
