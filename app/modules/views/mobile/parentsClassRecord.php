<div class="contentHeader">
    <h4>My Kids Academic Records</h4>
    <div style=" margin:auto 8%; " id="subject_container">
        <select style="width:90%;" name="subject"  onclick="getRecords(this.value)"  name="inputPosition" id="inputStudentList" class="span12"  required>
      <option>Select Your Student Here</option>
          <?php 
                foreach ($students as $s)
                  {   
                ?>
                    <option value="<?php echo $s->uid ?>"> <?php echo $s->firstname.' '.$s->lastname;?></option>
          <?php 
                  }
          ?>
    </select>
    </div>
</div>

<div style="margin-bottom: 100px; "> 
    
    <div id="classRecordBody">
        <table class="table table-striped">
            <tr>
                <td style="text-align: center; vertical-align: middle;" rowspan="2">
                    <h4>List of Subjects</h4>
                </td>
                <td style="text-align: center" colspan="2">First Grading</td>
<!--                <td style="text-align: center" colspan="2">Second Grading</td>
                <td style="text-align: center" colspan="2">Third Grading</td>
                <td style="text-align: center" colspan="2">Fourth Grading</td>-->
            </tr>
            <tr>
                <td style="text-align: center"><small>Partial Number Grade</small></td>
                <td style="text-align: center"><small>Partial Letter Grade</small></td>
<!--                <td style="text-align: center"><small>Partial Number Grade</small></td>
                <td style="text-align: center"><small>Partial Letter Grade</small></td>
                <td style="text-align: center"><small>Partial Number Grade</small></td>
                <td style="text-align: center"><small>Partial Letter Grade</small></td>
                <td style="text-align: center"><small>Partial Number Grade</small></td>
                <td style="text-align: center"><small>Partial Letter Grade</small></td>-->
            </tr>
        </table>
    </div>
    
</div>

<script type="text/javascript">
    $(document).ready(function() {
          $("#inputStudentList").select2();
    });
    
    function getRecords(st_id){
         var url = "<?php echo base_url().'gradingsystem/getStudentRecords/'?>"+st_id// the script where you handle the form input.

            $.ajax({
                   type: "POST",
                   url: url,
                   data: "st_id="+st_id, // serializes the form's elements.
                   success: function(data)
                   {
                       $('#classRecordBody').html(data)
                   }
                 });

            return false;
   
      }
</script>