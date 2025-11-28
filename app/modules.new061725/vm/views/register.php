<div class="clearfix" style="margin:10px 0 0 0;">
   <div class="container-fluid"> 
      <div class="row" style="margin-bottom: 10px;">
         <div class="col-md-12">
            <div class="col-md-7 col-md-offset-1">
               <button type="button" class="btn btn-default" onclick="godashboard()" >
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
      <div class="row">
      	<div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
               <div class="panel-heading">
                  <b>Visitor Registration Panel</b>
                  <b class="pull-right pointer" style="" onclick="savenow()"><i class="fa fa-save"></i> Save</b>
               </div>
               <div class="panel-body">
                  <div class="col-md-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <ul class="nav nav-tabs nav-justified" role="tablist">
                              <li role="presentation" class="active" onclick="tabchange_o()"><a href="#otab" aria-controls="otab" role="tab" data-toggle="tab"><b>Existing Account</b></a></li>
                              <li role="presentation" onclick="tabchange_n()"><a href="#ntab" aria-controls="ntab" role="tab" data-toggle="tab"><b>New Account</b></a></li>
                           </ul>
                        </div>
                        <div class="panel-body">
                           <form class="form-horizontal" id="addProfileForm" name="addProfileForm">
                              <input type="hidden" name="avatar_file" id="avatar_file" value="" required>
                              <input type="hidden" name="active_tab" id="active_tab" value="old" required>
                              <div class="tab-content">
                                 <div role="tabpanel" class="tab-pane fade in active" id="otab">
                                    <div class="col-md-12">
                                       <h4>Choose Existing Account</h4>
                                       <select tabindex="-1" id="searchvisitor" name="searchvisitor" style="width: 100%;">
                                          <option>Search existing account</option>
                                          
                                          <?php 
                                             foreach ($vm_accounts as $act) { 
                                                $id = $act->va_id; 
                                                $vcheck = $act->va_uid;
                                                if($vcheck=="" || $vcheck==null){
                                          ?>

                                          <option value="<?php echo base64_encode($id); ?>"><?php echo $act->va_lastname.',&nbsp;'.$act->va_firstname; ?></option>
                                          
                                          <?php }} ?>
                                       
                                       </select>
                                    </div>
                                 </div>
                                 <div role="tabpanel" class="tab-pane fade" id="ntab">
                                    <div class="col-md-12">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label class="control-label" for="input">First Name</label>
                                             <div class="controls">
                                                <input type="text" id="fname" class="form-control" name="fname" placeholder="Enter visitor's first name">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label class="control-label" for="input">Last Name</label>
                                             <div class="controls">
                                                <input type="text" id="lname" class="form-control" name="lname" placeholder="Enter visitor's last name">
                                             </div>
                                          </div>   
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="col-md-12">
                                          <div class="form-group">
                                             <label class="control-label" for="input">Company Name</label>
                                             <div class="controls">
                                                <input type="text" id="cname" class="form-control" name="cname" placeholder="Enter company name. N/A if none.">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6"  style="margin-top:20px;">
                                       <h4>Department to visit</h4>
                                       <select tabindex="-1" id="searchdept" name="searchdept" style="width: 100%;">
                                          <option>Select Department to Visit</option>
                                       
                                          <?php foreach ($vm_dept as $dept) { $did = $dept->dept_id; ?>
                                       
                                          <option value="<?php echo base64_encode($did); ?>"><?php echo $dept->department; ?></option>
                                       
                                          <?php } ?>
                                       
                                       </select>
                                    </div>
                                    <div class="col-md-6"  style="margin-top:20px;">
                                       <h4>Visitor ID</h4>
                                       <select tabindex="-1" id="searchvid" name="searchvid" style="width: 100%;">
                                          <option>Select Visitor ID</option>
                                       
                                          <?php foreach ($vm_rfid as $vr) { 
                                             $vid = $vr->user_id; 
                                             $avtr = $vr->avatar;

                                             if ($avtr=="" || $avtr==null){
                                          ?>

                                          <option value="<?php echo base64_encode($vid); ?>"><?php echo $vr->firstname.' '.$vr->middlename; ?></option>
                                          
                                          <?php }} ?>
                                       
                                       </select>
                                    </div>
                                 </div>
                              </div> <!-- tab-content -->
                           </form>
                        </div> <!-- panel-body -->
                     </div> <!-- panel panel-info -->
                  </div> <!-- col-md-6 -->   
                  <div class="col-md-6">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="panel panel-info">
                              <div class="panel-heading">
                                 <h4 style="text-align: center;">Live Camera</h4>
                              </div>
                              <div class="panel-body">
                                 <div id="my_camera" style="width:200px; height:150px; margin: auto;" ></div>
                              </div>
                           </div>                        
                        </div>
                        <div class="col-md-6">
                           <div class="panel panel-danger">
                              <div class="panel-heading">
                                 <h4 style="text-align: center;">Captured Photo</h4>
                              </div>
                              <div class="panel-body">
                                 <div id="my_result" style="width: 200px; height: 150px; margin: auto;"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <form id="save_pic" action="" method="post">
                              <input type="hidden" id="pic" name="pic" value="" />
                           </form>
                           <button type="button" class="btn btn-primary" style="width: 100%;"onclick="javascript:void(take_snapshot())">
                              <div class="col-md-12" style="font-size: 20px;">
                                 <i class="fa fa-photo"></i>
                                 <b>Capture</b>
                              </div>
                           </button>                           
                        </div>
                     </div>

                     <div class="col-md-6 col-md-offset-3" style="margin: auto;">

                     </div>
                     <!-- <button type="button" class="btn btn-default" onclick="repeat()">
                        <div class="col-md-12" style="font-size: 20px;">
                           <i class="fa fa-photo"></i>
                           <b>Repeat</b>
                        </div>
                     </button> -->
                  </div> <!-- col-md-6  -->
               </div> <!-- panel-body --> 
            </div> <!-- panel panel-default --> 
         </div> <!-- col-md-12 -->
      </div> <!-- row --> 
   </div> <!-- container-fluid -->
</div> <!-- clearfix -->

    


<script type="text/javascript">
   Webcam.attach( '#my_camera' );
   $(document).ready(function() {
      $("#searchvisitor").select2();
      $("#searchdept").select2();
      $("#searchvid").select2();
   });

   function savenow()
   {
      var check = $("#active_tab").val();
      var avatar = $("#avatar_file").val(); 
      var lname = $("#lname").val();
      var fname = $("#fname").val();
      var cname = $("#cname").val();
      var sdept = $("#searchdept").val();
      var svid = $("#searchvid").val();
      var svisitor = $("#searchvisitor").val();
      var keeper = 0;

      if (avatar=="" || avatar==null){
         alert("Please capture visitor photo before you proceed.")
      }else if (sdept=="" || sdept=="Select Department to Visit"){
         alert("Please select department to visit.");
      }else if(svid=="" || svid=="Select Visitor ID"){
         alert("Please select visitor ID to use.");
      }else if(check=='new'){
         if (lname=="" || lname==null || fname=="" || fname==null || cname=="" || cname==null){
            alert('Please provide visitor name and company name.');
         }else{
            keeper = 1;
            urls = "<?php echo base_url() . 'vm/save_profile' ?>";
         }
         
      }else if(check=='old'){
         if (svisitor=="" || svisitor=="Search existing account"){
            alert('Please select existing visitor account before you continue.')
         }else{
            keeper = 1;
            urls = "<?php echo base_url() . 'vm/update_profile' ?>";
         }
      }

      if (keeper==1){
         $.ajax({
            type: "POST",
            url: urls,
            // dataType: 'json',
            data: $("#addProfileForm").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
            success: function (data) {       
               alert("Visitor profile successfully recorded. Visitor may enter the campus.");
               document.location = '<?php echo base_url()?>vm';
            }
         });   
      }
      
   }

   function showhistory()
   {
      document.location = '<?php echo base_url()?>vm/timeline';
   }

   function gostatus()
   {
      document.location = '<?php echo base_url()?>vm/status';  
   }

   function godashboard()
   {
      document.location = '<?php echo base_url()?>vm';
   }
	
   function tabchange_n()
   {
      document.getElementById('active_tab').value = 'new';
   }

   function tabchange_o()
   {
      document.getElementById('active_tab').value = 'old';
   }

   function go_exist()
   {
      var v_old = document.getElementById('vold');
      v_old.style.display = 'block';
   }

	function take_snapshot() {
  // 		  Webcam.set({
  //       width: 320,
  //       height: 240,
  //       dest_width: 640,
  //       dest_height: 480,
  //       image_format: 'jpeg',
  //       jpeg_quality: 90,
  //       force_flash: false,
  //       flip_horiz: true,
  //       fps: 45
  //   	});
      // document.getElementById('my_result').style.display = 'block';
      // document.getElementById('my_camera').style.display = 'none';
      Webcam.snap( function(data_uri) {
         document.getElementById('my_result').innerHTML = '<img src="'+data_uri+'"/>';
         var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
        	document.getElementById('pic').value = raw_image_data;
      });

  	url1 = "<?php echo base_url() . 'vm/snap_upload' ?>";
	$.ajax({
		type: "POST",
		url: url1,
      dataType: 'json',
		data: $("#save_pic").serialize()+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
		success: function (data) {			
         document.getElementById('avatar_file').value = data.file;
         var avatari = document.getElementById('avatar_file').value;
         alert(avatari);
		}
	});
}
	
</script>

