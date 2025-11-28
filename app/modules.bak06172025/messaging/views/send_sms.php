<?php 
      echo doctype('html5');
?>
<head>
    <title>Text Messaging System</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>"> 
    <link rel="stylesheet" href="<?php echo base_url('assets/css/plugins/li-scroll.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome-4.2.0/css/font-awesome.min.css'); ?>">
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
                         <table class="table table-bordered">
                             <tr>
                                <th class="col-lg-2">Recipient</th>
                                <th>Message</th>
                             </tr>
                           <?php 
                                $tcount=0;
                                
                                foreach($text as $t): 
                                   $tcount++;
                                   if ($tcount==15) {
                                      break;
                                   }
                           ?>
                            <tr>
                                <td><?php echo $t->sms_number ?></td>
                                <td><?php echo $t->sms_message ?></td>
                            </tr>
                            
                             <input type="hidden" id="smsUserID_<?php echo $tcount ?>" value="<?php echo $t->sms_user_id ?>" required>
                             <input type="hidden" id="smsCat_<?php echo $tcount ?>" value="<?php echo $t->sms_cat ?>" required>
                             <input type="hidden" id="smsID_<?php echo $tcount ?>" value="<?php echo $t->sms_id ?>" required>
                             <input type="hidden" name="t<?php echo $tcount ?>" id="number_<?php echo $tcount ?>" value="<?php echo $t->sms_number ?>" required>
                             <input type="hidden" name="p<?php echo $tcount ?>" id="message_<?php echo $tcount ?>" value="<?php echo $t->sms_message ?>" required>
                           <?php
                                endforeach;
                           ?>
                         </table>   
                           <input type="hidden" name="tosendcount" id="tosendcount" value="<?php echo $tcount ?>" required>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <b>Processed SMS Transactions</b>
                     </div>
                     <div class="panel-body">
                         <table class="table table-bordered">
                             <tr>
                                <th class="col-lg-2">Recipient</th>
                                <th>Message</th>
                             </tr>
                             <tbody id="confirmation">
                                 
                             </tbody>
                         </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

<script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>    
<script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>
<script type="text/javascript">
   $(document).ready(function() { 
      var iterate = document.getElementById("tosendcount").value;
        if(iterate!=0)
        {
            for (i = 1; i <= iterate; i++) {
               // ntime.format("h:mm:ss a");
               
               var url = "<?php echo base_url().'messaging/sendText/' ?>";
               $.ajax({
                  type: "POST",
                  url: url,
                  dataType: 'json',
                  data:
                  {
                    smsUserID            : $('#smsUserID_'+i).val(),
                    smsCat            : $('#smsCat_'+i).val(),
                    smsID            : $('#smsID_'+i).val(),
                    number            : $('#number_'+i).val(),
                    message           : $('#message_'+i).val(),
                    csrf_test_name    : $.cookie('csrf_cookie_name')        
                  }, 
                    success: function (data) {
                        console.log($('#smsID_'+i).val()+':'+$('#message_'+i).val())
                        $("#confirmation").append('<tr><td>'+data.number+'</td><td>'+data.msg+'</td></tr>');
                  }
               });
            }
        }
   });
   
   setTimeout(function(){
      location.reload();
   }, 60000);

</script>
  
<script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>
<script src="<?php echo base_url('assets/js/sync_controller.js'); ?>"></script>
</body>
</html>