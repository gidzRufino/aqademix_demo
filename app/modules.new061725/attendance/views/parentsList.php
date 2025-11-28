<div class="row">
    <div class="col-lg-12">
        <h2 style="margin-top: 20px;" class="page-header">
            My Student(s) Daily Attendance
            <input type="hidden" id="parent_id" value="<?php echo $this->session->userdata('parent_id') ?>"
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-md-4 list-group pull-right">
        <?php 
            foreach($students as $s){
         ?>
         <a id="<?php echo $s->st_id ?>" class="list-group-item"onclick="getStudent('<?php echo base64_encode($s->st_id) ?>','<?php echo $s->st_id ?>')" href="#">
             <div id="<?php echo $s->st_id ?>">
                <img class="img-circle " style="width:45px;" src="<?php echo base_url().'uploads/'.$s->avatar  ?>" />
                <?php echo $s->firstname; ?>
             </div>

         </a> 
         <?php
            }
         ?>    
    </div>
   
    <div class="col-md-8 pull-left"> 
        <div id="attendanceSheet" class="panel panel-default" style="display: none;">
            <div class="btn-group col-lg-12" style="padding:0;">
                   <button onclick="getAttendance(parseInt($('#m_id').val()) - parseInt(1))" class="btn btn-group btn-small col-lg-2"><<</button>
                   <button id="monthName" style="font-weight: bold;" onclick="getAttendance(parseInt(<?php echo date('m') ?>)"  class="btn btn-group btn-small btn-group col-lg-8"><?php echo date('F') ?></button>
                   <button onclick="getAttendance(parseInt($('#m_id').val()) + parseInt(1))"  class="btn btn-small  btn-group col-lg-2">>></button>
                   <input type="hidden" id="st_id" value="<?php echo base64_encode($s->st_id) ?>" />
                   <input type="hidden" id="m_id" value="<?php echo date('m') ?>" />
                   <input type="hidden" id="y_id" value="<?php echo date('Y') ?>" />
           </div>        
           <div class="panel-body" id="attendance_container">
               <?php
                   echo Modules::run('attendance/monthly', $option, base64_encode($s->st_id));
               ?> 
           </div>              


         </div>
    </div>
</div>
<input type="hidden" id="insetBgController" />
<?php
    echo Modules::run('main/checkPortal', 'www.portal.lca.edu.ph');
?>
<script type="text/javascript">
    
    function getStudent(st_id, id)
    {
        var bgController = document.getElementById('insetBgController').value;
        if($('#insetBgController').val()!=id || $('#insetBgController').val()!="")
            {
              $('#'+bgController).removeClass('active') ; 
              $('#'+id).addClass('active');
              $('#insetBgController').val(id)
            }
       
        $('#attendanceSheet').fadeIn(500);
        $('#st_id').val(st_id)
        var year = $('#y_id').val();
        var month = $('#m_id').val();
        if(month<10){
            month = '0'+month
        }
        
        var url = "<?php echo base_url().'attendance/monthly/individual/'?>"+st_id+'/'+month+'/'+year; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
              // data: "level_id="+levelCode, // serializes the form's elements.
               success: function(data)
               {
                   document.getElementById('attendance_container').innerHTML = data;
               }
             });

        return false;
    }
    
    function getAttendance(month){
     var year = $('#y_id').val();
     if(month<1){
         month = month+12;
         year = parseInt(year) - 1
     }
     if(month>12){
         month = month - 12;
         year = parseInt(year) + 1
     }
     getMonthName(month);
     $('#m_id').val(month);
     $('#y_id').val(year);
     var st_id = $('#st_id').val();
        if(month<10){
            month = '0'+month
        }
     //alert(month)
     var url = "<?php echo base_url().'attendance/monthly/individual/'?>"+st_id+'/'+month+'/'+year; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType: 'json',
              // data: "level_id="+levelCode, // serializes the form's elements.
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
              // data: "level_id="+levelCode, // serializes the form's elements.
               success: function(data)
               {
                   document.getElementById('monthName').innerHTML = data;
               }
             });

        return false;
     }
</script>