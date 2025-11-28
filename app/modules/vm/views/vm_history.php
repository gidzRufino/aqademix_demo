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
               <button type="button" class="btn btn-default" onclick="goregister()" >
                  <div class="col-md-12" style="font-size: 20px;">
                     <i class="fa fa-group"></i>
                     <b>Register a visitor</b>
                  </div>
               </button>
               <button type="button" class="btn btn-default" onclick="showhistory()">
                  <div class="col-md-12" style="font-size: 20px;">
                     <i class="fa fa-database"></i>
                     <b>History Records</b>
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

                  <?php 
                     $vm_info = $pminfo->va_lastname.', '.$pminfo->va_firstname;
                     $cstat = $pminfo->va_uid;
                     if ($cstat==="NULL" || $cstat===0 || $cstat===NULL || $cstat===""){
                        $cstatus = 'Out of campus';
                     }else{
                        $cstatus = 'In Campus';
                     }
                  ?>

                  <b><span style="color: yellow;"> <?php echo $vm_info ?></span>'s Visiting History</b>

               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-5">
                        <div class="input-group">
                           <span class="input-group-addon" id="">Visitor Name</span>
                           <input type="text" class="form-control" placeholder="<?php echo $vm_info ?>" aria-describedby="basic-addon1">
                           <span class="input-group-addon" id=""><a href="">edit</a></span>
                        </div>
                     </div>
                     <div class="col-md-5 pull-right">
                        <div class="input-group">
                           <span class="input-group-addon" id="">Visitor's Status</span>
                           <input type="text" class="form-control" style="color: red;font-weight: bold;" value="<?php echo $cstatus ?>" aria-describedby="basic-addon1" disabled>
                        </div>
                     </div>
                  </div>
                  <div class="row"> 
                     <div class="col-md-12">
                        <div style="overflow-y:scroll; height: 400px; margin-top: 20px;">
                           <table id="inv_table" class="tablesorter table table-bordered">
                              <thead class="bg-primary">
                                 <tr>
                                    <th style="text-align:center;">Avatar</th>
                                    <th style="text-align:center;">Visitor ID Used</th>
                                    <th style="text-align:center;">Date</th>
                                    <th style="text-align:center;">Log-In</th>
                                    <th style="text-align:center;">Log-Out</th>
                                    <th style="text-align:center;">Remarks</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 
                                 <?php
                                    foreach ($minfo as $vn) {
                                       $avatar = $vn->log_avatar;
                                       $vname = $vn->firstname.' '.$vn->middlename;
                                       $vdate = $vn->log_date;
                                       $vlogin = $vn->log_in;
                                       $vlogout = $vn->log_out;
                                       $vremarks = $vn->log_remarks;
                                       $vlogid = $vn->log_id;
                                 ?>
                                 <input type="hidden" name="pix<?php echo $vlogid ?>" id="pix<?php echo $vlogid ?>" value="<?php echo $avatar ?>" required>
                                 <input type="hidden" name="name<?php echo $vlogid ?>" id="name<?php echo $vlogid ?>" value="<?php echo $vm_info ?>" required>
                                 <tr>
                                    <td style="text-align:center; vertical-align: middle;"><img onclick="showpix(this.id)" id="px<?php echo $vlogid ?>" alt="image not available." src="<?php echo base_url().''.$avatar ?>" style="left: 5px; height:50px; border:solid white; z-index:5; position: relative; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);"  class="img-square"/></td>
                                    <td style="text-align:center; vertical-align: middle; font-weight: bold;"><a href="<?php echo base_url('vm/id_status/'.base64_encode($vn->log_user_id)) ?>"><?php echo $vname ?></td>
                                    <td style="text-align:center; vertical-align: middle;"><?php echo $vdate ?></td>
                                    <td style="text-align:center; vertical-align: middle;"><?php echo $vlogin ?></td>

                                    <?php if($vlogout==null || $vlogout==""){
                                          $vlogout = 'In-Use';
                                    ?>
                                    
                                    <td style="text-align:center; vertical-align: middle; color: red;"><b><?php echo $vlogout ?></b></td>

                                    <?php 
                                       }else{
                                    ?>

                                    <td style="text-align:center; vertical-align: middle;"><?php echo $vlogout ?></td>

                                    <?php } ?>

                                    <td style="text-align:center; vertical-align: middle;"><?php echo $vremarks ?></td>
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


   function showhistory()
   {
      document.location = '<?php echo base_url()?>vm/timeline';
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


   