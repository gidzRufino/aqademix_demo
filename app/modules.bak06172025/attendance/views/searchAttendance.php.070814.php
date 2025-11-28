<table id="presentStudents" align="center" class='table table-striped '>
    <tr>
        <td colspan="" style="text-align: center">
            <h6>Present</h6>
        </td>
        <td colspan="" style="text-align: center; width:50%;">
            <h6>Absent</h6>
        </td>
    </tr>

    <?php 

    $teacher = $this->session->userdata('position');
    // echo date("m/d/Y");
    ?>
    <tr>
        <td id="attendanceResult"   style="padding:0">
            <table style="width:100%; padding:0; margin:0;" align="center" class='table'>
                <tr>
                    <td style="width:5%; text-align: center;"><h6 style="margin:0px;"><?php echo $present->num_rows() ?></h6></td>
                    <td>Name of Student</td>
                    <td>Remarks
                     <a style="font-size:10px; float: right;" id="searchClickOver" class="help-inline pull-right" 
                            data-content=" 
                                 <div style='width:100%;'>
                                 <h6>Add Attendance Remark</h6>
                                 
                                 <select name='inputRemark' id='inputRemark' class='' required>
                                    <option>Select Remark</option>                     
                                    <option value='1'>Late</option>                     
                                    <option value='2'>Cutting Classes</option>                     
                                    
                                  </select>
                                 <div style='margin:5px 0;'>
                                 <button data-dismiss='clickover' class='btn btn-small btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                                 <a href='#' id='Department' data-dismiss='clickover' onclick='saveAttendanceRemarks()' style='margin-right:10px;' class='btn btn-small btn-success pull-right'>Save</a></div>
                                 </div>
                                  "   
                            class="btn" data-toggle="modal" href="#"> ADD REMARK</a>
                    </td>
                </tr>
                <?php
                    $i = 1;
                    foreach ($present->result() as $row)
                    {
                      if($this->session->userdata('attend_auto')):
                          $remarks = Modules::run('attendance/getAttendanceRemark', $row->u_rfid, $row->date);
                      else:
                          $remarks = Modules::run('attendance/getAttendanceRemark', $row->user_id, $row->date);
                      endif;  
                      
                ?>
                <tr >
                    <td style="padding:5px 0 5px 5px">
                        <?php if($this->session->userdata('attend_auto')): ?>
                            <input id="<?php echo $row->u_rfid; ?>" name="remarksRadio" onclick="getMe(<?php echo $row->u_rfid; ?>)" type="radio" />
                        <?php else: ?>
                            <input id="<?php echo $row->user_id; ?>" name="remarksRadio" onclick="getMe(<?php echo $row->user_id; ?>)" type="radio" />
                        <?php endif; ?>
                    </td>
                    <td style="padding:5px 0 5px 5px">
                        <h6 style="margin:0px; "><a id="<?php echo $row->user_id; ?>_name" href="<?php echo base_url();?>registrar/viewDetails/<?php echo base64_encode($row->user_id); ?>"><?php echo strtoupper($row->lastname.', '.$row->firstname) ?></a></h6>
                    </td>
                    <td>
                        <strong class="pull-left"><?php echo $remarks->row()->category_name ?></strong>
                        <?php if($remarks->row()->remarks!=0): ?>
                                    <strong class="pull-right">Remark Given By: <a href="<?php echo base_url().'hr/viewTeacherInfo/'.  base64_encode($remarks->row()->remarks_from) ?>" ><?php echo $remarks->row()->remarks_from ?></a></strong>
                                <?php endif; ?>
                    </td>

                </tr>
                 <?php
                    }
                 ?>
            </table>
        </td>

        <td>
               <?php
                    $j = 1;
                       ?>

                       <?php
                       foreach ($absents as $abs)
                       {
                          $m = $j++;  
                      ?>
                <h6 id="h6_<?php if($abs->st_id!=""):echo $abs->st_id; else: echo $abs->user_id; endif ; ?>"><input style="margin:0 10px; float: left;" onclick="saveSearchAttendance(<?php if($abs->st_id!=""):echo $abs->st_id; else: echo $abs->user_id; endif ; ?>, <?php echo $abs->user_id ?>,$('#inputBdate').val())"  type="checkbox" value="<?php if($abs->st_id!=""):echo $abs->st_id; else: echo $abs->user_id; endif ; ?>" /> 
                    <a href="<?php echo base_url();?>index.php/registrar/viewDetails/<?php echo base64_encode($abs->user_id); ?>"><?php echo strtoupper($abs->lastname.', '.$abs->firstname) ?></a></h6>
                           <?php
                       }

                    ?>

        </td>


    </tr>  
</table> 
<script type="text/javascript">
$(function(){
    $('#searchClickOver').clickover({
        placement: 'bottom',
        html: true
      });
})
</script>