<div class="clearfix" style="margin:10px 0 0 0;">
   <div class="container-fluid">   
      <div class="row">
         <div class="col-md-12">
            <div class="col-md-7 col-md-offset-1">
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
                  <b>Visitor IDs Status</b>
               </div>
               <div class="panel-body">
                  <div class="" style="overflow-y:scroll; height: 400px;">
                     <table id="inv_table" class="tablesorter table table-bordered">
                        <thead class="bg-primary">
                           <tr>
                              <th class="bg-default" style="text-align:center;">Avatar</th>
                              <th class="bg-default" style="text-align:center;">Name</th>
                              <th class="bg-default" style="text-align:center;">Company</th>
                              <th class="bg-default" style="text-align:center;">Date</th>
                              <th class="bg-default" style="text-align:center;">Time IN</th>
                              <th class="bg-default" style="text-align:center;">Time OUT</th>
                              <th class="bg-default" style="text-align:center;">Department</th>
                              <th class="bg-default" style="text-align:center;">Visitor ID</th>
                           </tr>
                        </thead>

                        <?php 

                           foreach ($vlog as $vlogs) {
                              $avatari = $vlogs->log_avatar;
                              $vname = $vlogs->va_lastname.', '.$vlogs->va_firstname;
                              $vlogdate = $vlogs->log_date;
                              $vlogin = $vlogs->log_in;
                              $vlogout = $vlogs->log_out;
                              $vdept = $vlogs->department;
                              $v_id = $vlogs->firstname.' '.$vlogs->middlename;
                              $vlogid =  $vlogs->log_id;
                              $vcompany = $vlogs->va_company;
                              $vdate = $vlogs->log_date;
                              $datenow =  date("m/d/y");

                              if($vdate==$datenow || $vlogout=="" || $vlogout==null){

                        ?>
                        
                        <tr >
                           <td style="text-align:center; vertical-align: middle;"><img onclick="showpix(this.id)" id="px<?php echo $vlogid ?>" alt="image not available." src="<?php echo base_url().''.$avatari ?>" style="left: 5px; height:50px; border:solid white; z-index:5; position: relative; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);"  class="img-square"/></td>
                           <td style="text-align:center; vertical-align: middle; font-weight: bold;"><a href="<?php echo base_url('vm/vm_status/'.base64_encode($vlogs->va_id)) ?>"><?php echo $vname ?></td>
                           <td style="text-align:center; vertical-align: middle; font-weight: bold;"><?php echo $vcompany ?></td>
                           <?php
                              if ($vlogdate===$datenow){
                           ?>
                           <td style="text-align:center; vertical-align: middle;"><?php echo $vlogdate ?></td>
                           <?php
                              }else{
                           ?>
                           <td style="text-align:center; vertical-align: middle; font-weight:bold; color:red;"><?php echo $vlogdate ?></td>
                           <?php
                              }
                           ?>
                           <td style="text-align:center; vertical-align: middle;"><?php echo $vlogin ?></td>

                        <?php if ($vlogout=="" || $vlogout==null) { ?>
                           
                           <td style="text-align:center; vertical-align: middle;">
                              <button type="button" class="btn btn-danger" id="<?php echo $vlogid ?>" onclick="logout(this.id)">
                                 <div class="col-md-12">
                                    <i class="fa fa-sign-out"></i>
                                    <b>Log Out</b>
                                 </div>
                              </button>
                              <input type="hidden" name="user<?php echo $vlogid ?>" id="user<?php echo $vlogid ?>" value="<?php echo $vlogs->user_id ?>" required>
                              <input type="hidden" name="log<?php echo $vlogid ?>" id="log<?php echo $vlogid ?>" value="<?php echo $vlogs->log_id ?>" required>
                              <input type="hidden" name="vm<?php echo $vlogid ?>" id="vm<?php echo $vlogid ?>" value="<?php echo $vlogs->va_id ?>" required>
                              <input type="hidden" name="pix<?php echo $vlogid ?>" id="pix<?php echo $vlogid ?>" value="<?php echo $vlogs->avatar ?>" required>
                              <input type="hidden" name="name<?php echo $vlogid ?>" id="name<?php echo $vlogid ?>" value="<?php echo $vname ?>" required>
                              <input type="hidden" name="dept<?php echo $vlogid ?>" id="dept<?php echo $vlogid ?>" value="<?php echo $vdept ?>" required>
                              <input type="hidden" name="logn<?php echo $vlogid ?>" id="logn<?php echo $vlogid ?>" value="<?php echo $vlogin ?>" required>
                              <input type="hidden" name="comp<?php echo $vlogid ?>" id="comp<?php echo $vlogid ?>" value="<?php echo $vcompany ?>" required>
                           </td>

                        <?php }else{ ?>

                           <td style="text-align:center; vertical-align: middle;"><?php echo $vlogout ?></td>
                        
                        <?php } ?>

                           <td style="text-align:center; vertical-align: middle;"><?php echo $vdept ?></td>
                           <!-- <td style="text-align:center; vertical-align: middle; color:red;"><b><?php echo $v_id ?></b></td> -->
                           <td style="text-align:center; vertical-align: middle; font-weight: bold;"><a href="<?php echo base_url('vm/id_status/'.base64_encode($vlogs->user_id)) ?>"><?php echo $v_id ?></td>
                        </tr>
                        
                        <?php 
                              }  // if($vdate==$datenow || $vlogout=="" || $vlogout==null){
                           }     // foreach ($vlog as $vlogs) {
                        ?> 

                     </table>
                     <form id="logoutform" action="" method="post">
                        <input type="hidden" name="user_id" id="user_id" value="" required>
                        <input type="hidden" name="log_id" id="log_id" value="" required>
                        <input type="hidden" name="vm_id" id="vm_id" value="" required>
                     </form>
                  </div>
               </div>
               <div class="panel-footer">
                  <!-- <div class="pull-right"> -->
                     <canvas id="clock" width="400" height="30"></canvas>
                  <!-- </div> -->
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
               <!-- <h4 class="text-center"><b id="pcompany"></b></h4> -->
            </div>
            <div>
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th class="bg-default" style="text-align:center;color: green;">Company</th>
                        <th class="bg-success" style="text-align:center;"><span id="pcompany"></span></th>
                        <th class="bg-default" style="text-align:center;color: red;">Visiting</th>
                        <th class="bg-danger" style="text-align:center;"><span id="pdept"></span></th>
                        <th class="bg-default" style="text-align:center;color: blue;">Time In</th>
                        <th class="bg-primary" style="text-align:center;"><span id="pin"></span></th>
                     </tr>
                  </thead>
               </table>
            </div>
         </div>
         <div class="modal-footer">
            <button id="logoutbtn" data-dismiss="modal" onclick="outnow()"class="btn btn-primary btn-sm"><i class="fa fa-thumbs-up fa-fw"> </i> Logout</button>
            <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times fa-fw"> </i> Cancel</button>
         </div>
      </div>  
   </div>
</div>


<div id="showprofile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Visitor Log Out Confirmation</h4>
         </div>
         <div class="modal-body">
            <div style="text-align:center;">
               <div style="margin: auto;"><img style="height: 300px; margin: auto;" id="prof_img" src=""></div>   
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

   // clock starts
   var context;
   var d;
   var str;
   var pos;
   var gradient;
   function getClock()
      {
         //Get Current Time
         d = new Date();
         str = positionZero(d.getHours(), d.getMinutes());
         pos = ampm(d.getHours());
         //Get the Context 2D or 3D
         context = clock.getContext("2d");
         context.clearRect(0, 0, 100, 100);
         context.font = "30px Helvetica";
         context.fillStyle = "#428BCA";
         // var ctx=c.getContext("2d");
         // gradient=context.createLinearGradient(0,0,0,170);
         // gradient.addColorStop(0,"black");
         // gradient.addColorStop(1,"white");
         // context.fillStyle=gradient;
         context.fillText("Time Check:  "+str+" "+pos, 5, 25);
      }

   function ampm(ehour)
      {
         var thour;
         if (ehour > 12)
            thour = "pm";
         else
            thour = "am";
         return thour;
      }  
     
   function positionZero(hour, min)
      {
         var curTime;
         var nhour;

         if(hour > 12)
            nhour = hour - 12;
         else
            nhour = hour;

         if(nhour < 10)
            curTime = "0"+nhour.toString();
         else
            curTime = nhour.toString(); 
     
         if(min < 10)
            curTime += ":0"+min.toString();
         else
           curTime += ":"+min.toString(); 
     
         // if(sec < 10)
         //    curTime += ":0"+sec.toString();
         // else
         //    curTime += ":"+sec.toString();
            return curTime;
      }
     
   setInterval(getClock, 1000);

   function showhistory()
   {
      document.location = '<?php echo base_url()?>vm/timeline';  
   }
  
   function goregister()
   {
      document.location = '<?php echo base_url()?>vm/register';
   }


   function gostatus()
   {
      document.location = '<?php echo base_url()?>vm/status';
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

   function showpix(px)
   {
      var pxl = px.slice(2);
      var ximg = "#pix"+pxl;
      var xname = "#name"+pxl;
      var xdept = "#dept"+pxl;
      var xcomp = "#comp"+pxl;
      var xin = "#logn"+pxl;
      document.getElementById("pname_tag").innerHTML = $(xname).val();
      document.getElementById("pcompany").innerHTML = $(xcomp).val();
      document.getElementById("pdept").innerHTML = $(xdept).val();
      document.getElementById("pin").innerHTML = $(xin).val();
      document.getElementById("pprof_img").src = "<?php echo base_url()?>"+$(ximg).val();
      $("#showpix").modal();
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


