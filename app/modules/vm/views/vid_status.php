<script type="text/javascript">
      $(function(){
      $("#vis_table").tablesorter({debug: true});
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
         <div class="col-md-10 col-md-offset-1" style="margin-top: 10px;">
            <div class="panel panel-primary">
               <div class="panel-heading text-center">
                  <b>Visitor IDs Status</b>
               </div>
               <div class="panel-body">
               <div class="" style="overflow-y:scroll; height: 400px;">
                  <table id="vis_table" class="tablesorter table table-condensed header-fixed table-bordered">
                     <thead class="bg-primary">
                        <tr>
                           <th class="bg-default" style="text-align:center;">Visitor ID</th>
                           <th class="bg-default" style="text-align:center;">Status</th>
                           <th class="bg-default" style="text-align:center;">Account</th>
                           <th class="bg-default" style="text-align:center;">Avatar</th>
                        </tr>
                     </thead>
                     <tbody>

                     <?php 
                        $avail = 0;
                        $iuse = 0;
                        foreach ($vid as $vid) {
                           $vname = $vid->firstname.' '.$vid->middlename;
                           $vcheck = $vid->status;
                           $vaccount = $vid->va_lastname.', '.$vid->va_firstname;
                           $vavatar = $vid->va_avatar;
                     ?>

                     <tr>
                        <td style="text-align:center; vertical-align: middle; font-weight: bold;"><a href="<?php echo base_url('vm/id_status/'.base64_encode($vid->user_id)) ?>"><?php echo $vname ?></td>

                     <?php 
                        if ($vcheck=='NULL' || $vcheck==null || $vcheck==0){
                           $avail++;
                     ?>

                        <td style="text-align:center; vertical-align: middle; color: green;"><b>Available</b></td>
                        <td style="text-align:center; vertical-align: middle;">-</td>
                        <td style="text-align:center; vertical-align: middle;"><img alt="image not available." src="<?php echo base_url().'noimage.jpg' ?>" style="left: 5px; height:50px; border:solid white; z-index:5; position: relative; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);"  class="img-square"/></td>                     

                     <?php
                        }else{ // if ($vcheck=='NULL' || $vcheck==null || $vcheck==0){
                           $iuse++;
                     ?>

                        <td style="text-align:center; vertical-align: middle; color: red;"><b>In-use</b></td>
                        <td style="text-align:center; vertical-align: middle; font-weight: bold;"><a href="<?php echo base_url('vm/vm_status/'.base64_encode($vid->va_id)) ?>"><?php echo $vaccount ?></td>
                        <td style="text-align:center; vertical-align: middle; font-weight: bold;"><img alt="image not available." src="<?php echo base_url().''.$vavatar ?>" style="left: 5px; height:50px; border:solid white; z-index:5; position: relative; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);"  class="img-square"/></td>                     

                     <?php 
                        }  //if ($vcheck=='NULL' || $vcheck==null || $vcheck==0){
                     ?>

                     </tr>

                     <?php
                        } // foreach ($vid as $vid) {
                        $ttal = $avail + $iuse;
                     ?>

                     </tbody>
                  </table>
                  <form id="logoutform" action="" method="post">
                     <input type="hidden" name="user_id" id="user_id" value="" required>
                     <input type="hidden" name="log_id" id="log_id" value="" required>
                     <input type="hidden" name="vm_id" id="vm_id" value="" required>
                  </form>
               </div>
            </div>
         </div>
         <div class="col-md-10 col-md-offset-1">
            <!-- <div class="panel panel-primary">
               <div class="panel-heading">
                  Visitor IDs Status
               </div>
               <div class="panel-body">
                  <div class="col-md-10 col-md-offset-1"> -->
                     <table class="table table-bordered">
                        <thead>
                           <tr>
                              <th class="bg-default" style="text-align:center;color: green;">Available</th>
                              <th class="bg-success" style="text-align:center;"><?php echo $avail ?></th>
                              <th class="bg-default" style="text-align:center;color: red;">In-Use</th>
                              <th class="bg-danger" style="text-align:center;"><?php echo $iuse ?></th>
                              <th class="bg-default" style="text-align:center;color: blue;">Total</th>
                              <th class="bg-primary" style="text-align:center;"><?php echo $ttal ?></th>
                           </tr>
                        </thead>
                     </table>
                  <!-- </div>
               </div>
            </div> -->
         </div>
      </div>
   </div>
</div>

<!-- Modal start -->

<div id="showprofile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Visitor Log Out Confirmation</h4>
         </div>
         <div class="modal-body">
            <div style="text-align:center;">
               <div id="prof_pic" style="margin: auto;"><img style="height: 300px; margin: auto;" id="prof_img" src=""></div>   
            </div>
            <div>
               <h2 class="text-center"><b id="name_tag"></b></h2>
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

   function logout(id)
   {  
      var pimg = "#pix"+id;
      var name = "#name"+id;
      var uid = "#user"+id;
      var log = "#log"+id;
      var vm = "#vm"+id;
      document.getElementById("name_tag").innerHTML = $(name).val();
      document.getElementById("prof_img").src = "<?php echo base_url()?>"+$(pimg).val();
      document.getElementById("user_id").value = $(uid).val();
      document.getElementById("log_id").value = $(log).val();
      document.getElementById("vm_id").value = $(vm).val();
      $("#logoutbtn").focus();
      $("#showprofile").modal();
      
   }

   function outnow()
   {
      url1 = "<?php echo base_url() . 'vm/logout_profile' ?>";
      $.ajax({
         type: "POST",
         url: url1,
         // dataType: 'json',
         data: $("#logoutform").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
         success: function (data) {       
            // alert("done!");
            location.reload();
         }
      });
   }

</script>


