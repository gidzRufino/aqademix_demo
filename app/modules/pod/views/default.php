<style type="text/css">
   .vertical{  
      margin-top:50%;
   }
   .bored{
      border-style: solid; font-weight: bold;
   }
   
</style>
<div class="row">
   <div class="col-lg-12 page-header">
      <div class="col-md-7">
         <h1 class="clearfix" style="margin:0">Prefect of Discipline</h1>
      </div>
      <div class="col-md-3 pull-right">
         <button onclick="get_employee()" id="" class="btn btn-info pull-right" style="margin-right: 10px; margin-top:5px;">Employee</button>
         <button onclick="" id="" class="btn btn-info pull-right" style="margin-right: 10px; margin-top:5px;" disabled>Students</button>
      </div>
   </div>   
</div>
<div class="row">
   <div class="col-md-5">
   </div>
   <div class="col-md-7">
      <h4><a href="" class="pull-right" style="margin: 0 20px 0 20px;">Settings</a></h4>
      <h4><a href="<?php echo base_url('pod/all_time') ?>" class="pull-right" style="margin: 0 20px 0 20px;">All Time Record</a></h4>
      <h4><a href="<?php echo base_url('pod/search') ?>" class="pull-right" style="margin: 0 20px 0 20px;">Search Student</a></h4>
   </div>
</div>
<div class="row">
   <div class="col-lg-8" style="margin-top: 10px;">
      <div class="panel panel-primary">
         <div class="panel-heading">
            <b>List of tardy infractions today</b>
            <button type="button" class="btn btn-default btn-sm pull-right" onclick="lreload()" style="text-align:center; margin: -5px -5px 0 0;">Refresh <i class="fa fa-refresh"></i></button>
         </div>
         <div class="panel-body">
            <table id="student_table" class="table table-bordered table-condensed table-sm tablesorter">
               <thead>
                  <tr class="bg-primary">
                     <th rowspan="2" style="padding-bottom: 3%;" class="text-center" >Student Name</th>
                     <th rowspan="2" style="padding-bottom: 3%;" class="text-center">Grade Level</th>
                     <th rowspan="2" style="padding-bottom: 3%;" class="text-center">Section</th>
                     <th colspan="2" class="text-center">Time-IN</th>
                     <!-- <th rowspan="2" style="padding-bottom: 3%;" class="text-center">Counts</th> -->
                     <th rowspan="2" style="padding-bottom: 3%;" class="text-center">Remarks</th>
                     <th rowspan="2" style="padding-bottom: 3%;" class="text-center">Action</th>
                  </tr>
                  <tr class="bg-primary">
                     <th class="text-center">Expected</th>
                     <th class="text-center">Recorded</th>
                  </tr>
               </thead>
               <tbody>

                  <?php 

                  $ttcount = 0;
                  foreach ($tardy_today as $tt) {
                     switch ($tt->l_status) {
                        case '1':
                           $bg = 'bg-success';
                           $tx = '<span>'; $txe = '</span>'; 
                           break;
                        case '2':
                           $bg = 'bg-danger';
                           $tx = '<span>'; $txe = '</span>'; 
                           break;
                        case '3':
                           $bg = 'active';
                           $tx = '<del>'; $txe = '</del>';
                           break;
                        default:
                           $bg = 'bg-info';
                           $tx = '<span>'; $txe = '</span>'; 
                           break;
                     }
                     $ttcount++;
                     // foreach ($all_time as $att) {
                     //    if ($att->st_id==$tt->st_id) {
                     //       $tot_att = $att->total;
                     //    }
                     // }
                  ?>

                  <tr class="<?php echo $bg ?>">
                     <td class="text-center" onclick="open_account('<?php echo base64_encode($tt->l_st_id) ?>')"><?php echo $tx.''.$tt->lastname.', '.$tt->firstname.''.$txe ?></td>
                     <td class="text-center"><?php echo $tx.''.$tt->level.''.$txe ?></td>
                     <td class="text-center"><?php echo $tx.''.$tt->section.''.$txe ?></td>
                     <td class="text-center"><?php echo $tx.''.$tt->l_time_in.''.$txe ?></td>
                     <td class="text-center"><?php echo $tx.''.$tt->l_actual_time_in.''.$txe ?></td>
                     <!-- <td class="text-center"><?php echo $tx.''.$tot_att.''.$txe ?></td> -->
                     <td class="text-center"><?php echo $tx.''.$tt->l_remarks.''.$txe ?></td>
                     <td class="text-center"><button type="button" class="btn btn-info btn-sm" id="rem<?php echo $tt->l_id ?>" onclick="add_remarks(this.id)" style="text-align:center; margin-right: 5px;"><i class="fa fa-pencil"></i></button>
                        <input type="hidden" id="inu<?php echo $tt->l_id ?>" name="inu<?php echo $tt->l_id ?>" value="<?php echo $tt->lastname.', '.$tt->firstname ?>" />
                        <input type="hidden" id="igu<?php echo $tt->l_id ?>" name="igu<?php echo $tt->l_id ?>" value="<?php echo $tt->level ?>" />
                        <input type="hidden" id="isu<?php echo $tt->l_id ?>" name="isu<?php echo $tt->l_id ?>" value="<?php echo $tt->section ?>" />
                        <input type="hidden" id="idu<?php echo $tt->l_id ?>" name="idu<?php echo $tt->l_id ?>" value="Adviser Neimo" />
                        <input type="hidden" id="iru<?php echo $tt->l_id ?>" name="iru<?php echo $tt->l_id ?>" value="<?php echo $tt->l_remarks ?>" />
                        <input type="hidden" id="cnt<?php echo $ttcount ?>" name="cnt<?php echo $ttcount ?>" value="<?php echo base64_encode($tt->l_st_id) ?>" />
                     </td>
                  </tr>

                  <?php } ?>
                  <tr>
                     <td class="text-right" colspan="5"><b>Total Tardy Counts</b></td>
                     <td class="text-center" ><?php echo $ttcount ?></td>
                     <input type="hidden" id="total_count" name="total_count" value="<?php echo $ttcount ?>" />
                  </tr>
               </tbody>
            </table>
            <div class="row">
               <div class="col-md-12">
                  <table class="table table-condensed table-bordered bored table-sm">
                     <tr>
                        <td class="bored text-center">L E G E N D :</td>
                        <td class="bg-info bored text-center">Needs Action</td>
                        <td class="bg-success bored text-center">Tardy (excused)</td>
                        <td class="bg-danger bored text-center">Tardy (un-excused)</td>
                        <td class="active bored text-center"><del>Deleted Record</del></td>
                     </tr>
                  </table>
               </div>
               <div class="col-md-12">
                  <b style="color:gray;">Note:</b>
                  <p style="color:gray;font-size:small;">- You can click on the account name to view more details.<br/> - If an account is not reflected, try to refresh the list by clicking on the refresh button. <br />- If an account holder failed to login using their RFIDs, you can search for their account using our search function and add the infraction manually from their account dashboard. </p>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-4" style="margin-top: 10px;">
      <div class="panel panel-danger">
         <div class="panel-heading">
            <b>Running Tardy Counts</b>
            <button type="button" class="btn btn-danger btn-sm pull-right" id="recal_btn" onclick="re_calc()" style="text-align:center; margin: -5px -5px 0 0;">Recalc <i class="fa fa-calculator"></i></button>
         </div>
         <div class="panel-body">
            <table id="student_table" class="table table-hover table-bordered table-sm tablesorter">
               <thead>
                  <tr class="bg-primary">
                     <th class="text-center">Student Name</th>
                     <th class="text-center">Level</th>
                     <th class="text-center">QTD Counts</th>
                  </tr>
               </thead>
               <tbody id="re_detail">

                  
               </tbody>
            </table>
            <div class="col-md-12">
               <p style="color:gray;font-size: small;"><i class="fa fa-bolt"></i> Information displayed here may not be in proper order. Please press recalc as you wish.</p>
            </div>
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
         <h4 id="he1"></h4> 
         <h4 id="he2"></h4> 
         <!-- <h4 id="he3"></h4>   -->
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <select id="ir_sel" style="width:100%;">
                        <option>Please Select Action</option>
                        <option value="1">Late (excused)</option>
                        <option value="2">Late (un-excused)</option>
                        <option value="3">Error (disregard this)</option>
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
            <!-- <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">Close</button> -->
         </div>     
      </div>
   </div>
</div>


<script type="text/javascript">
   $(document).ready(function() {
      $("#ir_sel").select2();
      $(".tablesorter").tablesorter({debug: true});
      re_calc();
    
   });

   function lreload()
   {
      alert('reloading');
      location.reload();
   }

   function get_employee()
   {
      document.location = '<?php echo base_url('pod/edashboard') ?>';
   }

   function open_account(stid)
   {
      document.location = '<?php echo base_url('pod/search/') ?>' + stid;
   }

   function re_calc()
   {
      var tcount = document.getElementById('total_count').value;
      document.getElementById('re_detail').innerHTML = "";
      var detail = document.getElementById('re_detail').innerHTML;
      var info = "";
      for (i = tcount; i >= 1; i--) {
         var tpoint = 'cnt'+i;
         var st_id = document.getElementById(tpoint).value;
         var url = "<?php echo base_url().'pod/calculate' ?>";
         $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: {
               st_id: st_id,
               csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            success: function(data){
               info = '<tr><td class="text-center">'+ data.sname+'</td><td class="text-center">'+data.slevel+'</td><td class="text-center">'+data.scounts+'</td></tr>' + info;
               document.getElementById('re_detail').innerHTML = detail +' '+ info;
            }
         });
      }
   }

   function save_action()
   {
      var ir_id = document.getElementById("ir_id").value;
      var ir_sel = document.getElementById('ir_sel').value;
      var ir_remarks = document.getElementById('ir_remarks').value;
      if (ir_sel<3) {
         var ir_remarks = '[Tardy] '+ir_remarks;
      }else if(ir_sel==3){
         var ir_remarks = '[Disregard] '+ir_remarks;
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

  function add_remarks(id)
  {
   var rid = id.slice(3);
   var rin = 'inu' + rid;var rig = 'igu' + rid;var ris = 'isu' + rid;var ria = 'idu' + rid; var rir = 'iru' + rid;
   // alert('Add remarks this button:'+rin);
   var rname = document.getElementById(rin).value;
   var rgrade = document.getElementById(rig).value;
   var rsec = document.getElementById(ris).value;
   var radv = document.getElementById(ria).value;
   var rrem = document.getElementById(rir).value;
   
   document.getElementById('ir_id').value = rid;
   document.getElementById("he1").innerHTML = '<b>Student: </b><span style="color:#BB0000;">'+ rname +'</span>';
   document.getElementById("he2").innerHTML = '<b>Grade: </b><span style="color:#BB0000;">'+ rgrade + '</span><b>  Section: </b><span style="color:#BB0000;">' + rsec +'</span>';
   // document.getElementById("he3").innerHTML = '<b>Adviser: </b>'+ ria;
   document.getElementById("ir_remarks").value = rrem;
   $("#addrem").modal();
  }

  function act_on(id)
  {
      alert('action is on this button:' + id);
  }

</script>
