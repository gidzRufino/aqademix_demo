<?php 
      echo doctype('html5');
      // echo link_tag('assets/css/bootstrap.min.css');
      // echo link_tag('assets/css/plugins/li-scroll.css');
      // echo link_tag('assets/font-awesome-4.2.0/css/font-awesome.min.css');

?>
<head>
    <title>Text Messaging System</title>
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
               <h4>Text / SMS Module</h4>
            </div>
            <div class="panel-body">
               <div class="col-md-6">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <b>Pending SMS Transactions</b>
                     </div>
                     <div class="panel-body">
                        <form class="form" id="tosendform" name="tosendform">
                           <?php 
                              $tcount=0;
                              foreach ($fortext as $fort) {
                                 $tcount++;
                                 if ($tcount==20) {
                                    break;
                                 }
                                 $lid = $fort->log_id;
                                 $trfid = $fort->rfid;

                                 $lstatus = $fort->in_out;
                                 if ($lstatus==0) {
                                    $iostat = "LOGGED OUT";
                                 }elseif ($lstatus==1) {
                                    $iostat = "LOGGED IN";
                                 }
                                 $sentstat = $fort->tx_sent;
                                 if ($sentstat==0) {
                                    $sstat = "Not Sent";
                                 }elseif ($sentstat==1) {
                                    $sstat = "Sent";
                                 }
                                 $trem = $fort->tx_remarks;
                           ?>
                              <span><?php echo $fort->rfid." | TXn: ".$iostat." | TXStatus: ".$sstat." | Rem: ".$trem; ?>
                                 <input type="hidden" name="t<?php echo $tcount ?>" id="t<?php echo $tcount ?>" value="<?php echo $trfid ?>" required>
                                 <input type="hidden" name="p<?php echo $tcount ?>" id="p<?php echo $tcount ?>" value="<?php echo $lid ?>" required>
                              </span><br />
                           <?php
                              }
                           ?>
                           <input type="hidden" name="tosendcount" id="tosendcount" value="<?php echo $tcount ?>" required>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <b>Processed SMS Transactions</b>
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
   </div>
<script type="text/javascript">
   $(document).ready(function() { 
      var iterate = document.getElementById("tosendcount").value;
      for (i = 1; i <= 15; i++) {
         // ntime.format("h:mm:ss a");
         var point = "t" + i;
         var url = "<?php echo base_url().'messaging/sending/' ?>"+point;
         $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            // data: "id="+point+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            data: $("#tosendform").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function (data) {
                  var ntime = new Date().toLocaleString();
                  // alert(data.rfid+" = "+data.rname+" > "+data.rstat);
                  $("#confirmation").append('<span>['+ntime+'] ' +data.rfid+' | '+data.rname+' '+data.iostat+' the campus at '+data.time+' | result: '+data.rmsg+' </span><br />');
            }
         });
      }
   });
   
   setTimeout(function(){
      location.reload();
   }, 60000);

</script>

<script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>
<script src="<?php echo base_url('assets/js/sync_controller.js'); ?>"></script>
</body>
