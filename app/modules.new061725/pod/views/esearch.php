<style type="text/css">
   .vertical{  
      margin-top:50%;
   }
</style>
<div class="row">
   <div class="col-lg-12 page-header">
      <div class="col-md-7">
         <h1 class="clearfix" style="margin:0">Prefect of Discipline</h1>
      </div>
      <div class="col-md-3 pull-right">
         <button onclick="#" id="get_employee()" class="btn btn-info pull-right" style="margin-right: 10px; margin-top:5px;" disabled>Employee</button>
         <button onclick="get_students()" id="" class="btn btn-info pull-right" style="margin-right: 10px; margin-top:5px;">Students</button>
      </div>
   </div>   
</div>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <div class="row">
               <div class="col-md-8">
                  <div class="input-group">
                     <!-- <input type="text" class="form-control"> -->
                     <input onkeyup="search(this.value)" id="searchBox" class="form-control" type="text" placeholder="Search Name Here" />
                    <div onblur="$(this).hide()" style="min-height: 30px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchName">
                    </div>
                     <div class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-search"></i> Search Employee</button>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <h4><a href="" class="pull-right" style="margin: 0 20px 0 20px;">Settings</a></h4>
                  <h4><a href="<?php echo base_url('pod/eall_time') ?>" class="pull-right" style="margin: 0 20px 0 20px;">All Time Record</a></h4>
                  <h4><a href="<?php echo base_url('pod/edashboard') ?>" class="pull-right" style="margin: 0 20px 0 20px;">Dashboard</a></h4>      
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php 
   $uri = $this->uri->segment(3);
   if ($uri) { // check if id was detected
      
?>

<div class="row"> <!-- this whole row will be hidden if this->segment->uri(3) is blank -->
   <div class="col-lg-8">
      <div class="panel panel-primary">
         <div class="panel-heading">
            <b>Account Basic Information </b>
            <b class="pull-right"><i class="fa fa-star"></i></b>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-1"></div>
               <div class="col-md-2">
                  <img class="img-circle img-responsive" style="width:150px; border:5px solid #F5F5F5" src="<?php if($profile->avatar!=""):echo base_url().'uploads/'.$profile->avatar;else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                  <!-- <img class="img-circle img-responsive" style="width:150px; border:5px solid #F5F5F5" src="<?php echo base_url().'uploads/31377.png'?>"> -->
               </div>
               <div class="col-md-8">
                  <h2 style="margin:3px 0;">
                     <span id="name" style="color:#BB0000;"><?php echo $profile->lastname.', '.$profile->firstname ?></span>
                  </h2>
                  <!-- <h4 style="color:black; margin:3px 0;"><?php echo $profile->level ?> - <span id="a_section"><?php echo $profile->section ?></span>
                  </h4> -->
                  <h3 style="color:black; margin:3px 0;">
                     <small>
                        <a id="a_user_id"  style="color:#BB0000;">
                        <?php echo $profile->employee_id ?>
                        <input type="hidden" id="st_id" name="st_id" value="<?php echo base64_encode($profile->employee_id) ?>" />
                        <input type="hidden" id="grade_id" name="grade_id" value="<?php echo base64_encode($profile->grade_level_id) ?>" />
                        </a>
                     </small>
                  </h3>
                  <h4 style="color:black; margin:3px 0;">
                     <small>
                        <a title="double click to edit" id="a_user_id"  style="color:black;">
                        <b>Position: <span style="color:#BB0000;"><?php echo $profile->position?></span></b>
                        </a>
                     </small>
                  </h4>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-primary" style="margin-top: 10px;">
                     <div class="panel-heading">
                        <b> Tardy Record
                           <!-- <button class="btn pull-right btn-default btn-sm">Manual Input</button> -->
                        </b>
                        <button onclick="$('#manual_mod').modal()" class="btn btn-warning btn-sm pull-right" style="margin-top:-5px;"><b><i class="fa fa-pencil"></i> Manual Input</b></button>
                     </div>
                     <div class="panel-body">
                        <table id="student_table" class="table table-bordered table-sm tablesorter">
                           <thead>
                              <tr>
                                 <th class="text-center">Date</th>
                                 <th class="text-center">Time</th>
                                 <!-- <th class="text-center">Excess Minutes</th> -->
                                 <th class="text-center">Remarks</th>
                                 <th class="text-center">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              
                              <?php 
                                 $tcounts = 0; $icounts = 0;
                                 foreach ($tardies as $tar) {
                                    $icounts++;
                                    if ($tar->l_status<3) {
                                       $tcounts++;
                                    }
                                    switch ($tar->l_status) {
                                       case '1':
                                          $bg = 'bg-success';
                                          break;
                                       case '2':
                                          $bg = 'bg-danger';
                                          break;
                                       case '3':
                                          $bg = 'active';
                                          break;
                                       case '4':
                                          $bg = 'bg-warning';
                                          break;
                                       default:
                                          $bg = 'bg-info';
                                          break;
                                    }
                                    switch ($tcounts) {
                                       case '3':
                                          $tcomment = '[action needed: Verbal Warning] ';
                                          break;
                                       case '5':
                                          $tcomment = '[action needed: Conference with parents] ';
                                          break;
                                       case '7':
                                          $tcomment = '[action needed: Community Service] ';
                                          break;
                                       case '9':
                                          $tcomment = '[action needed: Formative Suspension] ';
                                          break;
                                       default:
                                          $tcomment = "";
                                          break;
                                    }
                              ?>

                              <tr class="<?php echo $bg ?>">
                                 <td class="text-center"><?php echo $tar->l_date ?></td>
                                 <td class="text-center"><?php echo $tar->l_actual_time_in ?></td>
                                 <td class="text-center"><span style="color:red;"><?php echo $tcomment?></span> <?php echo $tar->l_remarks ?></td>
                                 <td class="text-center"><button type="button" class="btn btn-info btn-sm" id="rem<? echo $tar->l_id ?>" onclick="add_remarks(this.id)" style="text-align:center; margin-right: 5px;"><i class="fa fa-pencil"></i></button>
                                    <input type="hidden" id="iru<? echo $tar->l_id ?>" name="iru<? echo $tar->l_id ?>" value="<?php echo $tar->l_remarks ?>" />
                                 </td>
                              </tr>

                              <?php } 
                              switch (true) {
                                 case $tcounts < 3:
                                    $bar = 'progress-bar-success';
                                    $msg = 'Safe Zone ('.$tcounts.')';
                                    break;
                                 case $tcounts < 5:
                                    $bar = 'progress-bar-info';
                                    $msg = 'Verbal Warning ('.$tcounts.')';
                                    break;
                                 case $tcounts < 7:
                                    $bar = 'progress-bar-warning';
                                    $msg = 'Conference with parents ('.$tcounts.')';
                                    break;
                                 case $tcounts < 9:
                                    $bar = 'progress-bar-danger';
                                    $msg = 'Community Service ('.$tcounts.')';
                                    break;
                                 case $tcounts >= 9:
                                    $bar = 'progress-bar-active';
                                    $msg = 'Formative Suspension ('.$tcounts.')';
                                    break;
                                 default:
                                    # code...
                                    break;
                              }
                              
                              if ($tcounts<=10) {
                               $wide = $tcounts*10;
                              }elseif ($tcounts>10) {
                                 $wide = 100;
                              }
                              $width = 'width:'.$wide.'%';

                              ?>

                           </tbody>
                        </table>

                        <div class="progress">
                           <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%">
                           Safe Zone
                           </div>
                           <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                              aria-valuemin="0" aria-valuemax="100" style="width:20%">
                              Verbal Warning
                           </div>
                           <div class="progress-bar progress-bar-warning role="progressbar" aria-valuenow="20"
                              aria-valuemin="0" aria-valuemax="100" style="width:20%">
                              Conference w/ Parents
                           </div>
                           <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20"
                              aria-valuemin="0" aria-valuemax="100" style="width:20%">
                              Community Service
                           </div>
                           <div class="progress-bar progress-bar-active" role="progressbar" aria-valuenow="20"
                              aria-valuemin="0" aria-valuemax="100" style="width:10%">
                              Suspension
                           </div>
                        </div>
                        <div class="progress" style="margin-top: -15px;">
                           <div class="progress-bar <?php echo $bar ?> progress-bar-striped" role="progressbar" aria-valuenow="20"
                              aria-valuemin="0" aria-valuemax="100" style="<?php echo $width ?>">
                              <b style="font-size: 14px;"><?php echo $msg ?></b>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-4">
      <div class="panel panel-primary">
         <div class="panel-heading">
            <div class="input-group">
               <b>Account Summary</b>
            </div>
         </div>
         <div class="panel-body">
            <table id="student_table" class="table table-hover table-bordered talbe-condensed table-sm tablesorter">
               <thead>
                  <tr>
                     <th class="text-center">QTD counts</th>
                     <th class="text-center">QTD min</th>
                     <th class="text-center">YTD counts</th>
                     <th class="text-center">Infractions</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>

                     <?php 
                     if ($tcounts<3) {
                        $bg = 'bg-success';
                     }elseif ($tcounts>=3||$tcounts<5) {
                        $bg = 'bg-info';
                     }elseif ($tcounts>=5||$tcounts<7) {
                        $bg = 'bg-warning';
                     }elseif ($tcounts>=7||$tcounts<9) {
                        $bg = 'bg-danger';
                     }elseif ($tcounts>=9) {
                        $bg = 'active';
                     }
                     ?>

                     <td class="text-center <?php echo $bg ?>"><?php echo $tcounts ?></td>
                     <td class="text-center"></td>
                     <td class="text-center <?php echo $bg ?>""><?php echo $tcounts ?></td>
                     <td class="text-center"><?php echo $icounts ?></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<?php } ?>  <!-- check if uri(3) is not blank -->

<div id="manual_mod" class="modal fade" style="width:30%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="panel panel-danger">
      <div class="panel-heading">
         <h4>Manual Infraction Input <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button></h4> 
            
      </div>
      <div class="panel-body">
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <select class="select2" id="mir_sel" style="width:100%;">
                        <option>Please Select Action</option>
                        <option value="1">Late (excused)</option>
                        <option value="2">Late (un-excused)</option>
                        <option value="4">Other Infractions</option>
                        <!-- <option value="7">Error (delete this)</option> -->
                     </select>
                  </div> 
                  <div class="panel-body">
                     <div class="bootstrap-timepicker">
                        <div class="form-group">
                           <label>Time</label>
                           <div class="input-group">
                              <input type="text" id="time_pick" class="form-control timepicker">
                              <div class="input-group-addon">
                                 <i class="fa fa-clock-o"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Remarks</label>
                           <textarea class="form-control" id="mir_remarks" rows="3" placeholder="Infraction remarks ..."></textarea>
                     </div>
                  </div>
               </div>   
            </div>
         </div>
      </div>
      <div class="panel-footer">
         <div class="row">
            <button type="button" class="btn btn-success pull-right" onclick="save_manual()" style="text-align:center;margin: 5px 20px 5px 5px;"> Save</button>
            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" aria-hidden="true" style="text-align:center;margin: 5px;"> Cancel</button>
            <!-- <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">Close</button> -->
         </div>     
      </div>
   </div>
</div>

<div id="addrem" class="modal fade" style="width:30%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="panel panel-green">
      <div class="panel-heading">
         <h4>Infraction Action <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button></h4> 
            
      </div>
      <div class="panel-body">
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <select class="select2" id="ir_sel" style="width:100%;">
                        <option>Please Select Action</option>
                        <option value="1">Late (excused)</option>
                        <option value="2">Late (un-excused)</option>
                        <option value="3">Error (delete this)</option>
                     </select>
                  </div> 
                  <div class="panel-body">
                     <div class="form-group">
                        <label>Remarks</label>
                           <textarea class="form-control" id="ir_remarks" rows="3" placeholder="Enter ..."></textarea>
                     </div>
                  </div>
               </div>   
            </div>
         </div>
      </div>
      <div class="panel-footer">
         <div class="row">
            <input type="hidden" id="ir_id" name="ir_id"/>
            <button type="button" class="btn btn-success pull-right" onclick="save_action()" style="text-align:center;margin: 5px 20px 5px 5px;"> Save</button>
            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" aria-hidden="true" style="text-align:center;margin: 5px;"> Cancel</button>
         </div>     
      </div>
   </div>
</div>

<script type="text/javascript">
   $(document).ready(function() {
      $(".select2").select2();
      $(".tablesorter").tablesorter({debug: true});
      $(".timepicker").timepicker({
      showInputs: false,
      showMeridian: false,
    });
   });

   function get_students()
   {
      document.location = '<?php echo base_url('pod/dashboard') ?>';
   }

   function save_action()
   {
      var ir_id = document.getElementById("ir_id").value;
      var ir_sel = document.getElementById('ir_sel').value;
      var ir_remarks = document.getElementById('ir_remarks').value;
      if (ir_sel<3) {
         var ir_remarks = '[Tardy] '+ir_remarks;
      }

      var url = '<?php echo base_url().'pod/save_action' ?>';
      $.ajax({
         type: "POST",
         url: url,
         data: {
            ir_id: ir_id,
            ir_sel: ir_sel,
            ir_remarks: ir_remarks,
            csrf_test_name: $.cookie('csrf_cookie_name')
         }, // serializes the form's elements.
         success: function(data){
            alert("Action updated!");
            location.reload();
         }
      });
      return false;
   }

   function save_manual()
   {
      var st_id = $('#st_id').val();
      var ir_sel = $("#mir_sel").val();
      var ir_remarks = $("#mir_remarks").val();
      var grade_id = $("#grade_id").val();
      var ir_time = $("#time_pick").val();
      if (ir_sel<3) {
         var ir_remarks = '[Tardy] '+ir_remarks;
      }else{
         var ir_remarks = '[Other Infraction] '+ir_remarks;
      }
      var url = '<?php echo base_url().'pod/save_manual' ?>';
      $.ajax({
         type: "POST",
         url: url,
         data: {
            st_id: st_id,
            ir_sel: ir_sel,
            grade_id: grade_id,
            ir_time: ir_time,
            ir_remarks: ir_remarks,
            csrf_test_name: $.cookie('csrf_cookie_name')
         }, // serializes the form's elements.
         success: function(data){
            alert("Action updated!");
            location.reload();
         }
      });
   }

   function loadDetails(st_id)
   {
      // alert('the id:'+ st_id);
      document.location = '<?php echo base_url().'pod/esearch/' ?>'+st_id;
   }

   function search(value)
   {
      var url = '<?php echo base_url().'pod/searchEmployeeAccounts/' ?>'+value;
         $.ajax({
            type: "GET",
            url: url,
            data: "id="+value, // serializes the form's elements.
            // dataType: 'json',
            success: function(data)
            {
                  $('#searchName').show();
                  $('#searchName').html(data);
            }
         });
      return false;
   }

  function add_remarks(id)
  {
   var rid = id.slice(3);
   var riu = 'iru' + rid;
   // alert('Add remarks this button:'+rin);
   
   var rem = document.getElementById(riu).value;
   document.getElementById('ir_id').value = rid;
   document.getElementById('ir_remarks').value = rem;
   // document.getElementById("he2").innerHTML = '<b>Grade: </b>'+ rgrade + '<b>  Section: </b>' + rsec;
   // document.getElementById("he3").innerHTML = '<b>Adviser: </b>'+ ria;
   $("#addrem").modal();
  }

  function act_on(id)
  {
      alert('action is on this button:' + id);
  }

</script>
