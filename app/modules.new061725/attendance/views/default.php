<div  id="attend_widget" class="row table-responsive panel panel-default" style="margin-top:10px; max-height: 450px; overflow-y: scroll;" >
       <div class="panel-heading clearfix" style=" padding: 0;">
        <div class="btn-group col-lg-12">
          <input type="hidden" id="m_id" value="<?php echo date('m') ?>" />
          <input type="hidden" id="y_id" value="<?php echo ($this->uri->segment(4)==NULL?$this->session->userdata('school_year'):$this->uri->segment(4)); ?>" />
          <button onclick="getAttendance(parseInt($('#m_id').val()) - parseInt(1))" class="btn btn-small btn-group col-lg-2"><<</button>
          <button id="monthName" style="font-weight: bold;" onclick="getAttendance(parseInt(<?php echo date('m') ?>)"  class="btn btn-small btn-group col-lg-8"><?php echo date('F') ?></button>
          <button onclick="getAttendance(parseInt($('#m_id').val()) + parseInt(1))"  class="btn btn-small btn-group  col-lg-2">>></button>
      </div>
    </div>   
    <div class="panel-body" id="attendance_container" style=" padding: 0;">
      <?php
        $yr = $this->session->userdata('school_year');
        if (date('m')>1&&date('m')<7) {
          $yr = $yr + 1;
        }
          echo Modules::run('attendance/monthly', $option, base64_encode($students->uid),date('m'), $yr);
      ?> 
  </div>                          
</div>

<script type="text/javascript">
    
 function getAttendance(month){
     // var year = $('#y_id').val();
     year = <?php echo $this->session->userdata('school_year') ?>;
     if(month<1){
         month = month+12;
         // year = parseInt(year)
     }
     if(month>12){
         month = month - 12;
         year = year + 1;
     }
     if(month<10){
         month = '0'+month;
     }
     if (month>0&&month<7) {
      year = year +1;
     }

     getMonthName(month);
     $('#m_id').val(month);
     $('#y_id').val(year);
     // alert(month)
     var url = "<?php echo base_url().'attendance/monthly/individual/'.base64_encode($students->uid)?>/"+month+'/'+year; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: "level_id="+''+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   document.getElementById('attendance_container').innerHTML = data;
               }
             });

        return false;
   
     }
     
     function getMonthName(m_id){
         var url = "<?php echo base_url().'main/monthName/'?>"+m_id; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
               data: "level_id="+''+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   document.getElementById('monthName').innerHTML = data;
               }
             });

        return false;
     }
     
     
</script>