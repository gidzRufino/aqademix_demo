    <?php
    $position_id = $this->session->userdata('position_id');
    $dept_id = $this->session->userdata('dept_id');
    //echo $this->session->userdata('position'); 
    switch($position_id){
        case '3':
            $admin = "display:none;";
        break;    
    }
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header clearfix" style="margin-top:5px;">
             <?php
            if($getEmployee->position_details==1){ 
                ?>
            <?php echo $selectSection->level.' - '.$getSection->section; 
            }else{
                echo $getSpecificSubjects->subject; ?> [ <?php echo $selectSection->level.' - '.$getSection->section;   ?> ]
            <?php
            }
            ?>
            
            <a class="btn btn-success pull-right" style="margin-left:5px;" href="<?php echo base_url();?>gradingsystem/"  >View Class Record</a>&nbsp;
            <a class="btn btn-info pull-right" style="" href="<?php echo base_url();?>index.php/attendance/dailyPerSubject/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>"  >Attendance Sheet</a>&nbsp;&nbsp;
            </h2>
        </div>
            
    <div class="col-lg-12">
        <div class="clearfix row-fluid">
            <input type="hidden" id="setAction" />
            <input type="hidden" id="setId" />
            <input type="hidden" id="level" />
            <div id="tableResult">
                 <table class='table table-striped'  >

                     <tr><td>First Name</td><td>Middle Name</td><td>Last Name</td><td>Action</td></tr>
                     <?php 
                     foreach ($students->result() as $SL){ ?>

                     <tr>
                         <td><?php echo strtoupper($SL->firstname); ?></td>
                         <td><?php echo strtoupper($SL->middlename); ?></td>
                         <td><?php echo strtoupper($SL->lastname); ?></td>
                         <td>
                             <a href="<?php echo base_url();?>index.php/registrar/viewDetails/<?php echo base64_encode($SL->st_id); ?>" onmouseover="document.getElementById('setId').value='<?php echo $SL->uid; ?>'" >View Info</a>
                         </td>

                     </tr> 
                      <?php 
                             }

                         ?>
                 </table>

            </div>
         </div>

    </div>
