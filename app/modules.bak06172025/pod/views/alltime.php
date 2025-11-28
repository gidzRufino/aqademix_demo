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
         <button onclick="#" id="get_employee()" class="btn btn-info pull-right" style="margin-right: 10px; margin-top:5px;">Employee</button>
         <button onclick="#" id="get_students()" class="btn btn-info pull-right" style="margin-right: 10px; margin-top:5px;" disabled>Students</button>
      </div>
   </div>   
</div>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <div class="row">
               <div class="col-md-8">
                  <!--  -->
               </div>
               <div class="col-md-4">
                  <h4><a href="" class="pull-right" style="margin: 0 20px 0 20px;">Settings</a></h4>
                  <h4><a href="<?php echo base_url('pod/search') ?>" class="pull-right" style="margin: 0 20px 0 20px;">Search Student</a></h4>
                  <h4><a href="<?php echo base_url('pod/dashboard') ?>" class="pull-right" style="margin: 0 20px 0 20px;">Dashboard</a></h4>      
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-primary">
         <div class="panel-heading">
            <div class="row">
               <div class="col-md-2">
                  <b>All Time Tardy Count</b>
               </div>
               <div class="col-md-2 pull-right">
                  <select onclick="display_level(this.value)" style="width:100%" class="select2 pull-right">
                     <option value="" default>Select Grade Level</option>
                     <option value="all">All Student</option>
                     
                     <?php
                        foreach ($level as $lvl) {
                           if ($lvl->grade_id>13||$lvl->grade_id<2) {
                              // do not include kinder, preschool and playschool
                           }else{
                     ?>

                     <option value="<?php echo base64_encode($lvl->grade_id) ?>"><?php echo $lvl->level ?></option>

                     <?php
                           }
                        }
                     ?>
                     <option value="gs">All Grade School</option>
                     <option value="hs">All High School</option>
                  </select>
               </div>
            </div>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="col-md-9">
                  <div class="row">
                     <div class="col-md-12">
                        <ul class="nav nav-pills nav-justified">
                           <!-- <li role="presentation"  data-toggle="tab" data-target="#all" class="active"><a href="#all">Year-to-date</a></li> -->
                           <li role="presentation"  data-toggle="tab" data-target="#first" class="active"><a href="#first">First Quarter</a></li>
                           <li role="presentation" data-toggle="tab" data-target="#second"><a href="#second">Second Quarter</a></li>
                           <li role="presentation" data-toggle="tab" data-target="#third"><a href="#third">Third Quarter</a></li>
                           <li role="presentation" data-toggle="tab" data-target="#fourth"><a href="#fourth">Fourth Quarter</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="tab-content" style="padding-top: 10px;">
                           <!-- <div class="tab-pane active" id="all">
                              <table id="student_table" class="table table-bordered table-sm tablesorter">
                                 <thead>
                                    <tr class="bg-primary">
                                       <th class="text-center">Name</th>
                                       <th class="text-center">Grade/Level</th>
                                       <th class="text-center">Section</th>
                                       <th class="text-center">Tardy Counts</th>
                                    </tr>
                                 </thead>
                                 <tbody id="ytd_rec_info">

                                    
                                    
                                 </tbody>
                              </table>
                           </div> -->
                           <div class="tab-pane active" id="first">
                              <table id="student_table" class="table table-bordered table-sm tablesorter">
                                 <thead>
                                    <tr class="bg-primary">
                                       <th class="text-center">Name</th>
                                       <th class="text-center">Grade/Level</th>
                                       <th class="text-center">Section</th>
                                       <th class="text-center">Tardy Counts</th>
                                    </tr>
                                 </thead>
                                 <tbody id="first_rec_info">

                                    
                                    
                                 </tbody>
                              </table>
                           </div>
                           <div class="tab-pane" id="second">
                              <table id="student_table" class="table table-bordered table-sm tablesorter">
                                 <thead>
                                    <tr class="bg-primary">
                                       <th class="text-center">Name</th>
                                       <th class="text-center">Grade/Level</th>
                                       <th class="text-center">Section</th>
                                       <th class="text-center">Tardy Counts</th>
                                    </tr>
                                 </thead>
                                 <tbody id="second_rec_info">

                                    
                                    
                                 </tbody>
                              </table>
                           </div>
                           <div class="tab-pane" id="third">
                              <table id="student_table" class="table table-bordered table-sm tablesorter">
                                 <thead>
                                    <tr class="bg-primary">
                                       <th class="text-center">Name</th>
                                       <th class="text-center">Grade/Level</th>
                                       <th class="text-center">Section</th>
                                       <th class="text-center">Tardy Counts</th>
                                    </tr>
                                 </thead>
                                 <tbody id="third_rec_info">

                                    
                                    
                                 </tbody>
                              </table>
                           </div>
                           <div class="tab-pane" id="fourth">
                              <table id="student_table" class="table table-bordered table-sm tablesorter">
                                 <thead>
                                    <tr class="bg-primary">
                                       <th class="text-center">Name</th>
                                       <th class="text-center">Grade/Level</th>
                                       <th class="text-center">Section</th>
                                       <th class="text-center">Tardy Counts</th>
                                    </tr>
                                 </thead>
                                 <tbody id="fourth_rec_info">

                                    
                                    
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-3 pull-right">
                  <div class="panel-primary panel">
                     <div class="panel-body">
                        <h4 class="text-center">LEGEND</h4>
                        <table class="table-bordered table" style="width: 100%;">
                           <tr class="bg-success">
                              <th class="text-center">Safe Zone</th>
                           </tr>
                           <tr class="bg-primary">
                              <th class="text-center">Verbal Warning</th>
                           </tr>
                           <tr class="bg-info">
                              <th class="text-center">Conference with Parents</th>
                           </tr>
                           <tr class="bg-warning">
                              <th class="text-center">Community Service</th>
                           </tr>
                           <tr class="bg-danger">
                              <th class="text-center">Formative Suspension</th>
                           </tr>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


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

<div id="loading" class="modal fade" style="width:10%; margin: 80px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="panel panel-default">
      <div class="panel-body">
         <!-- <img class=" img-responsive" style="width:100%;" src="<?php // echo base_url().'images/loading.gif'?>" /> -->
         <h4 class="text-center">Loading . . .</h4>
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
      $(".tablesorter").tablesorter({debug: true});
      $(".select2").select2();
      $(".timepicker").timepicker({
      showInputs: false,
      showMeridian: false,
    });
   });

   function open_account(stid)
   {
      document.location = '<?php echo base_url('pod/search/') ?>' + stid;
   }

   function display_level(value)
   {
      var sel = value;
      if (value) {
         var url = '<?php echo base_url().'pod/fetch_record/' ?>';
         $("#loading").modal();
         $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
               sel: sel,
               csrf_test_name: $.cookie('csrf_cookie_name')
            }, 
            success: function(data){
               $("#first_rec_info").html(data.info1);
               $("#second_rec_info").html(data.info2);
               $("#third_rec_info").html(data.info3);
               $("#fourth_rec_info").html(data.info4);
            
               $(".tablesorter").tablesorter({debug: true});
               $("#loading").modal('toggle');
            }
         });
      }else{
         alert('Select grade level to display.');
      }
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

</script>
