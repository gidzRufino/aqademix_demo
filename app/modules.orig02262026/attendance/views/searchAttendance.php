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
            <?php echo Modules::run('attendance/getPresent', $section_id, $this->session->userdata('attend_auto'), $date) ;?>
        </td>
        <td>
            <?php echo Modules::run('attendance/getAbsents', $section_id, $this->session->userdata('attend_auto'), $date) ;?>
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

    function deleteAttendance(id, st_id)
     {
        var date = $('#inputBdate').val();
        var url = "<?php echo base_url().'attendance/deleteAttendance' ?>"; // the script where you handle the form input.
        var att_total = $('#att_totals').html();
        var totalAtt = parseInt(att_total - 1);
        $('#att_totals').html(totalAtt);
        $("#"+st_id+"_tr").fadeOut();
        $.ajax({
           type: "POST",
           url: url,
            data: "att_id=" + id + '&date=' + date + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
               {
                   $("#"+id+"_tr").hide();
               }
            });
            return false;
     }

     
</script>
