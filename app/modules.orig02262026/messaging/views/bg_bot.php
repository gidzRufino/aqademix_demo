<?php 
      echo doctype('html5');
      // echo link_tag('assets/css/bootstrap.min.css');
      // echo link_tag('assets/css/plugins/li-scroll.css');
      // echo link_tag('assets/font-awesome-4.2.0/css/font-awesome.min.css');

?>
<head>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>"> 
    <link rel="stylesheet" href="<?php echo base_url('assets/css/plugins/li-scroll.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome-4.2.0/css/font-awesome.min.css'); ?>">
   <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
   <script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>  
</head>
<body>
   <div class="container-fluid">
      <div class="col-md-12" style="padding-top: 15px;">  
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4>Fetching unrecorded SPR Attendance</h4>
            </div>
            <div class="panel-body">
               <div class="col-md-6">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <b>Pending Data for processing</b>
                     </div>
                     <div class="panel-body">
                        <form class="form" id="tosendform" name="tosendform">

                           <?php 
                              $scount = 0;
                              foreach ($unrecorded as $ur) {
                                 $scount++;
                                 $sname = $ur->lastname.', '.$ur->firstname;
                                 $stud_id = $ur->att_st_id;
                                 $sdate = $ur->date;
                                 $time_in = 0;
                                 $time_in_am = $ur->as_time_in;
                                 $time_in_pm = $ur->as_time_in_pm;
                                 if ($time_in_am!="") {
                                    $time_in = $time_in_am;
                                 }elseif ($time_in_pm!="") {
                                    $time_in = $time_in_pm;
                                 }
                                 $timehr = substr($time_in, 0, -2);
                                 $timemin = substr($time_in, -2);
                                 $time = $timehr.":".$timemin.":00";

                                 // if ($scount==30) {
                                 //    break;
                                 // }
                                 // a - st_id
                                 // b - att_id
                           ?>
                              <span><?php echo $scount ?> <?php echo $sname ?> - <?php echo $stud_id ?> | Date: <?php echo $sdate ?> | ATTID: <?php echo $ur->att_id ?> | TimeIN: <?php echo $time ?> Sec: <?php echo $ur->section_id ?>
                                 <input type="hidden" name="a<?php echo $scount ?>" id="a<?php echo $scount ?>" value="<?php echo $ur->st_id ?>" required>
                                 <input type="hidden" name="b<?php echo $scount ?>" id="b<?php echo $scount ?>" value="<?php echo $ur->att_id ?>" required>
                                 <input type="hidden" name="c<?php echo $scount ?>" id="c<?php echo $scount ?>" value="<?php echo $ur->date ?>" required>
                                 <input type="hidden" name="d<?php echo $scount ?>" id="d<?php echo $scount ?>" value="<?php echo $ur->sect_id ?>" required>
                                 <input type="hidden" name="e<?php echo $scount ?>" id="e<?php echo $scount ?>" value="<?php echo $time ?>" required>
                                 <input type="hidden" name="f<?php echo $scount ?>" id="f<?php echo $scount ?>" value="<?php echo $ur->grade_level_id ?>" required>
                              </span><br />

                           <?php
                              } // foreach ($unrecorded as $ur) {
                           ?>
                           <input type="hidden" name="tosendcount" id="tosendcount" value="<?php echo $scount ?>" required>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <b>Processed Data</b>
                     </div>
                     <div class="panel-body">
                        <div id="confirmation">
                           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-12" style="padding-top: 15px;">    


      </div>
   </div>
<script type="text/javascript">
   $(document).ready(function() { 
      var iterate = document.getElementById("tosendcount").value;
      for (i = 1; i <= iterate; i++) {
         // ntime.format("h:mm:ss a");
         var point = "t" + i;
         var url = "<?php echo base_url().'messaging/process_bot/' ?>"+point;
         $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            // data: "id="+point+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            data: $("#tosendform").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function (data) {
                  var ntime = new Date().toLocaleString();
                  // alert(data.rfid+" = "+data.rname+" > "+data.rstat);
                  $("#confirmation").append('<span>'+data.count+' ' +data.st_id+' | '+data.date+' [ '+data.time+' > '+data.etime +' ] Tardy: '+data.tardy +' | SPR: '+data.spr +' | ATTID: '+data.att +'  | Record: '+data.new +'</span><br />');
            }
         });
      }
   });

   setTimeout(function(){
                        location.reload();
                     }, 5000);
   

</script>

<script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>
<script src="<?php echo base_url('assets/js/sync_controller.js'); ?>"></script>
</body>
