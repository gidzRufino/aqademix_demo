<?php

//print_r($getAssignment);

?>
<h5>List of Faculty with Subject Assignment</h5>
<table class='table table-striped'>
    <tr><td>Name of Faculty</td><td>Subject Taught</td><td>Grade Level</td><td>Section</td><td>Option</td><td>Time Schedule</td><td>Advisory</td></tr>
    <?php 

    foreach ($getAssignment as $as){
        $teacher = Modules::run('hr/getEmployee', base64_encode($as->faculty_id));

        ?>
    <tr>
        <td><a href="<?php echo base_url();?>hr/viewTeacherInfo/<?php echo base64_encode($teacher->employee_id); ?>"><?php echo $teacher->lastname.', '.$teacher->firstname;?></a></td>
        <td><?php echo $as->subject?></td>
        <td><?php echo $as->level?></td>
        <td><?php echo $as->section?></td>
        <td>
            <a href="<?php echo base_url();?>index.php/academic/deleteAssignment/<?php echo $as->ass_id; ?>">Delete</a>
        </td>
        <td style="text-align: center">
            <?php if($as->schedule_id==0){ ?>
                <a onclick="setSchedID(<?php echo $as->ass_id ?>)" data-toggle="modal" href="#schedule">Add Schedule</a>  
            <?php
            }else{ ?>
                <?php echo $as->day.'<br>'.$as->time ?>
            <?php } ?>    
        </td>
        <td style="text-align: center">
            <?php if($as->position_details==1){ 
                $uid = $as->faculty_id;
                $advisory = Modules::run('academic/getAdvisory', $uid, '');
                foreach ($advisory->result() as $adv){
            ?>
            <a href="#" class="" title="Delete Advisory" rel="clickover" 
               data-content="Are you sure you want to delete Advisory.<br>
                            <div style='width:100%; margin:0 45px;'>
                                <button id='<?php echo $adv->faculty_id ?>' class='btn btn-info' onclick='deleteAdvisory(this.id,<?php echo $adv->adv_id ?>)' style='padding: 2px 15px;'>Yes</button>&nbsp;&nbsp;<button class='btn btn-danger' data-dismiss='clickover' style='padding: 2px 15px;' >No</button>
                            </div>              
                            ">

            <?php

                echo $adv->level.' - '.$adv->section.'<br />';
                }
                ?>
                 </a>
            <a onclick="document.getElementById('inputFacultyID').value = '<?php echo $as->faculty_id ?>'"  data-toggle="modal" href="#advisoryModal">Add Advisory</a>  
            <?php
            }else{ ?>
            <a onclick="document.getElementById('inputFacultyID').value = '<?php echo $as->faculty_id ?>'"  data-toggle="modal" href="#advisoryModal">Set as Adviser</a>  
            <?php } ?>    
        </td>
    </tr>
    <?php
    }
    ?>
</table>