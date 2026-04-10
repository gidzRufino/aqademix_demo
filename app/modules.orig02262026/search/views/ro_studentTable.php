<table style="font-size:12px;" class="tablesorter table table-striped">
    <thead style="background:#E6EEEE;">
        <tr>
            <th>USER ID</th>
            <th>LAST NAME</th>
            <th>FIRST NAME</th>
            <th>MIDDLE NAME</th>
            <th>GRADE</th>
            <th>SECTION</th>
            <th>GENDER</th>
            <td>STATUS</td>
            <td>REMARKS</td>
            <?php
                if($this->session->userdata('is_admin')):
            ?>
            <td>Action</td>
            <?php
                endif;
            ?>
            <td>School Year</td>
        </tr> 
    </thead>

    <?php
    if($this->uri->segment(4)=='undefined'):
        $year = $this->session->userdata('school_year');
        
    else:
        $year = $this->uri->segment(4);
    endif;
       foreach ($students as $s)
       {
    ?>
        <tr>
            <td><a href="<?php echo base_url('registrar/viewDetails/'.base64_encode($s->st_id)).'/'.$year?>"><?php echo $s->st_id; ?></a></td>
            <td><?php echo strtoupper($s->lastname); ?></td>
            <td><?php echo strtoupper($s->firstname); ?></td>
            <td><?php echo strtoupper($s->middlename); ?></td>
            <td><?php echo $s->level; ?></td>
            <td><?php echo $s->section; ?></td>
            <td><?php echo $s->sex; ?></td>
            <td id="img_<?php echo $s->uid ?>_td" style="text-align:center"><?php 
                if($s->status){
                    ?>
                <a href="#adminRemarks" data-toggle="modal">
                    <img onclick="getRemarks('<?php echo $s->st_id ?>','<?php echo $s->user_id ?>')" style="cursor: pointer;width:20px" src="<?php echo base_url() ?>images/official.png" alt="official" />
                </a>
                <?php
                }else{
                ?>
                <a href="#adminRemarks" data-toggle="modal">
                    <img onclick=getRemarks('<?php echo $s->st_id ?>','<?php echo $s->user_id ?>')" style="cursor: pointer;width:20px"  src="<?php echo base_url() ?>images/unofficial.png" alt="official" />
                </a>
                <?php
                }
            ?>
            </td>
            <td onmouseout="$('#delete_<?php echo $s->uid ?>').hide()" onmouseover="$('#delete_<?php echo $s->uid ?>').show()" id="remarks_<?php echo $s->uid ?>_td" >
                <?php
                    $remarks = Modules::run('main/getAdmissionRemarks', $s->uid);
                    if($remarks->num_rows()>0){
                        echo $remarks->row()->code.' '.$remarks->row()->remarks.' - '.$remarks->row()->remark_date;
                        ?>
                    <button id="delete_<?php echo $s->uid ?>" type="button" class="close pull-right hide" onclick="deleteAdmissionRemark('<?php echo $s->uid ?>',<?php echo $remarks->row()->code_indicator_id ?> )">&times;</button>    
                <?php        
                    }
                   // echo $s->st_id;
                ?>

            </td>
            <?php
                if($this->session->userdata('is_admin')):
                    //echo $s->rfid;
            ?>
            <td>
                <?php if($s->rfid==""||$s->rfid=="NULL"):?>
                <a href="#addId" data-toggle="modal" onclick="showAddRFIDForm('<?php echo $s->uid ?>','RFID')" >Add RFID</a> |
                <?php else: ?>
                <a href="#addId" data-toggle="modal" onclick="showAddRFIDForm('<?php echo $s->uid ?>','<?php echo $s->rfid ?>')" >Edit RFID</a> |
                <?php endif; ?>
                <a href="#deleteIDConfirmation" data-toggle="modal" onclick="showDeleteConfirmation('<?php echo $s->st_id ?>','<?php echo $s->uid ?>')" style="color:#FF3030;" >DELETE</a> |
                <a href="#rollOver" data-toggle="modal" onclick="$('#ro_st_id').val('<?php echo $s->uid ?>'),$('#curr_grade_id').val('<?php echo $s->grade_level_id ?>')"  class="text-success" >ROLL OVER</a>


            </td>
            <?php
                endif;
            ?>
            <td class="col-lg-1">
                <?php echo $s->school_year.' - '.($s->school_year+1) ?>
            </td>
    </tr> 
    <?php 
        } 

    ?>
    </table>



<script type="text/javascript">
    $(function(){
        $('[rel="clickover"]').clickover({
                placement: 'left',
                html: true
              });
          
        
        });
        
        
</script>