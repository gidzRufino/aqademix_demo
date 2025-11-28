<script type="text/javascript">
      $(function(){
      $("#inv_table").tablesorter({debug: true});
  });  
</script>
<div class="clearfix" style="margin:10px 0 0 0;">
   <div class="container-fluid">   
      <div class="row">
         <div class="col-md-12">
            <div class="col-md-7 col-md-offset-1">
               <button type="button" class="btn btn-default" onclick="gohome()" >
                  <div class="col-md-12" style="font-size: 20px;">
                     <i class="fa fa-home"></i>
                     <b>VM Dashboard</b>
                  </div>
               </button>
               <button type="button" class="btn btn-default" onclick="gostatus()">
                  <div class="col-md-12" style="font-size: 20px;">
                     <i class="fa fa-ticket"></i>
                     <b>VRFID Status</b>
                  </div>
               </button>
               <button type="button" class="btn btn-default" onclick="goregister()" >
                  <div class="col-md-12" style="font-size: 20px;">
                     <i class="fa fa-group"></i>
                     <b>Register a visitor</b>
                  </div>
               </button>
            </div>
            <div class="col-md-3" style="font-size: 25px; color: red;">
               <b>Visitor Management</b>
            </div>
         </div>
      </div>
      <div class="row" style="margin:10px;">
         <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
               <div class="panel-heading text-center">
                  <b>History Records</b>
               </div>
               <div class="panel-body">
                  <div class="col-md-12">
                     <div style="overflow-y:scroll; height: 400px;">
                        <i style="color: red;">* Click on the table header to sort the data.</i>
                        <table id="inv_table" class="tablesorter table table-bordered">
                           <thead class="bg-primary">
                              <tr>
                                 <th class="bg-default" style="text-align:center;">Avatar</th>
                                 <th class="bg-default" style="text-align:center; vertical-align: middle;">Visitor's Name</th>
                                 <th class="bg-default" style="text-align:center; vertical-align: middle;">Destination</th>
                                 <th class="bg-default" style="text-align:center; vertical-align: middle;">ID Used</th>
                                 <th class="bg-default" style="text-align:center; vertical-align: middle;">Date</th>
                                 <th class="bg-default" style="text-align:center; vertical-align: middle;">IN</th>
                                 <th class="bg-default" style="text-align:center; vertical-align: middle;">OUT</th>
                                 <th class="bg-default" style="text-align:center; vertical-align: middle;">Total</th>
                                 <th class="bg-default" style="text-align:center; vertical-align: middle;">Remarks</th>
                              </tr>
                           </thead>
                           <tbody>
                              
                              <?php
                                 foreach ($log as $log) {
                                    $avatar = $log->log_avatar;
                                    $lname = $log->va_lastname.', '.$log->va_firstname;
                                    $lid = $log->firstname.' '.$log->middlename;
                                    $ldate = $log->log_date;
                                    $lin = $log->log_in;
                                    $lout = $log->log_out;
                                    $ltot = $lout - $lin;
                                    $lremarks = $log->log_remarks;
                                    $vlogid = $log->log_id;
                                    $ldept = $log->department;
                              ?>

                              <input type="hidden" name="pix<?php echo $vlogid ?>" id="pix<?php echo $vlogid ?>" value="<?php echo $avatar ?>" required>
                              <input type="hidden" name="name<?php echo $vlogid ?>" id="name<?php echo $vlogid ?>" value="<?php echo $lname ?>" required>

                              <tr>
                                 <td style="text-align:center; vertical-align: middle;"><img onclick="showpix(this.id)" id="px<?php echo $vlogid ?>" alt="image not available." src="<?php echo base_url().''.$avatar ?>" style="left: 5px; height:50px; border:solid white; z-index:5; position: relative; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);"  class="img-square"/></td>                     
                                 <td style="text-align:center; vertical-align: middle;font-weight: bold;"><a href="<?php echo base_url('vm/vm_status/'.base64_encode($log->va_id)) ?>"><?php echo $lname ?></td>
                                 <td style="text-align:center; vertical-align: middle;"><?php echo $ldept ?></td>
                                 <td style="text-align:center; vertical-align: middle;font-weight: bold;"><a href="<?php echo base_url('vm/id_status/'.base64_encode($log->log_user_id)) ?>"><?php echo $lid ?></td>
                                 <td style="text-align:center; vertical-align: middle;"><?php echo $ldate ?></td>
                                 <td style="text-align:center; vertical-align: middle;"><?php echo $lin ?></td>
                              <?php
                                 if ($lout==="" || $lout===null){
                              ?>
                                 <td style="text-align:center; vertical-align: middle; color: red;"><b>STILL IN CAMPUS</b></td>
                                 <td style="text-align:center; vertical-align: middle;">-</td>
                              <?php
                                 }else{
                              ?>
                                 
                                 <td style="text-align:center; vertical-align: middle;"><?php echo $lout ?></td>
                                 <td style="text-align:center; vertical-align: middle;"><?php echo $ltot ?></td>

                              <?php
                                 }
                              ?>
                                 <td style="text-align:center; vertical-align: middle;"><?php echo $lremarks ?></td>
                              </tr>

                              <?php 
                                 }
                              ?>
                              
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal start -->

<div id="showpix" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Visitor Profile</h4>
         </div>
         <div class="modal-body">
            <div style="text-align:center;">
               <div style="margin: auto;"><img id="pprof_img" style="height: 300px; margin: auto;" src=""></div>   
            </div>
            <div>
               <h2 class="text-center"><b id="pname_tag"></b></h2>
            </div>
         </div>
         <div class="modal-footer">
            <button id="logoutbtn" data-dismiss="modal" onclick="outnow()"class="btn btn-primary btn-sm"><i class="fa fa-thumbs-up fa-fw"> </i> Logout</button>
            <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times fa-fw"> </i> Cancel</button>
         </div>
      </div>  
   </div>
</div>


<!-- Modal ends -->

<script type="text/javascript">
   
   function showpix(px)
   {
      var pxl = px.slice(2);
      var ximg = "#pix"+pxl;
      var xname = "#name"+pxl;
      document.getElementById("pname_tag").innerHTML = $(xname).val();
      document.getElementById("pprof_img").src = "<?php echo base_url()?>"+$(ximg).val();
      $("#showpix").modal();
   }

   function goregister()
   {
      document.location = '<?php echo base_url()?>vm/register';
   }

   function gohome()
   {
      document.location = '<?php echo base_url()?>vm';
   }

   function gostatus()
   {
      document.location = '<?php echo base_url()?>vm/status';
   }

</script>


   