<div id="generateBilling" class="modal fade" style="width:20%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Generate Billing
        </div>
         <div class="panel-body">
            <div class="control-group pull-left col-lg-12">
                <select name="inputGrade" id="inputGrade" onclick="selectSection(this.value)" style="width:100%;" required>
                           <option>Select Grade Level</option> 
                          <?php 
                                 foreach ($gradeLevel as $level)
                                   {   
                             ?>                        
                           <option sec="<?php echo $level->level; ?>" value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                           <?php }?>
                         </select>
               </div> <br /><br />
                 
            <div class="control-group pull-left col-lg-12">
                <div class="controls" id="AddedSection">
                    <select onclick="getClassCardCount(this.value)" name="inputSection" id="inputSection" style="width:100%;" class="pull-left" required>
                      <option>Select Section</option>  
                  </select>
                </div>
            </div> <br /><br />
            <div class="control-group pull-left col-lg-12">
                <div class="controls">
                  <select id="pageID" style="width:100%;">
                      <option>Select Option</option>  
                   </select> 
                </div>
            </div> <br /><br />
            <div class="control-group pull-left col-lg-12" id="month">
                  <select tabindex="-1" id="inputMonthReport" style="width:100%;">
                                <option >Select Month</option>
                                <option value="annual">Annual</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option> 
                   </select>
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='generateBilling()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Generate Billing</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
     </div>
</div>

<div id="chequeEncashments" class="modal fade" style="width:30%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Cheque Encashments
        </div>
        <div class="panel-body">
             <div class="form-group">
                <label class="control-label" for="input">Date</label><br />
                <input class="form-control" name="chequeDate" type="text" value="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd" id="chequeDate" placeholder="" required>
            </div> <br />
            <div class="form-group">
                <label>Bank</label> <br />
                <select style="width:90%;"  name="enBank" id="enBank" required>
                  <option value="0">Select Bank</option> 
                    <?php 
                           foreach ($getBanks as $b)
                             {   
                       ?>                        
                            <option value="<?php echo $b->fbank_id; ?>"><?php echo $b->bank_name; ?></option>
                    <?php }?>
                </select>
                <button onclick="$('#addBank').modal('show')" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus fa-fw"></i></button>
            </div>
            <div class="form-group">
                <label>Cheque #</label>
                <input type="text" id="chequeNumber" class="form-control" placeholder="Cheque #" />
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" id="chequeAmount" class="form-control" placeholder="Amount" />
            </div>
        </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='saveEncashments()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>    
</div>

<div id="addBank" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Bank   
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Bank Name</label>
                <input type="text" id="bank" class="form-control" placeholder="Bank" />
            </div>
            <div class="form-group">
                <label>Bank Short Name</label>
                <input type="text" id="bankShortName" class="form-control" placeholder="Bank Short Name" />
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='addBank()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
     </div>
</div>

<div id="addFinanceOption" class="modal fade" style="width:20%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Finance Charges
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Finance Item</label> <br />
                <select style="width:90%;"  name="inputFinItems" id="inputFinItems" required>
                  <option value="0">Select Item</option> 
                    <?php 
                           foreach ($fin_items as $i)
                             {   
                       ?>                        
                            <option value="<?php echo $i->item_id; ?>"><?php echo $i->item_description; ?></option>
                    <?php }?>
                </select>
                <button onclick="$('#addItemModal').modal('show')" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus fa-fw"></i></button>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" id="fin_amount" class="form-control" onclick="$(this).val('')" placeholder="Amount" />
                <input type="hidden" id="grade_level" />
                <input type="hidden" id="plan_id" />
                <!--<input type="hidden" id="year_level" />-->
            </div>
            <div class="form-group">
                <label>School Year</label> <br />
                <select style="width:100%;"  name="inputCSY" id="inputCSY" required>
                  <option value="0">Select School Year</option> 
                    <?php 
                           foreach ($ro_years as $ro)
                             {   
                               $next = ($ro->ro_years+1);
                       ?>                        
                            <option <?php echo ($ro->ro_years==$this->session->userdata('school_year')?'selected':'') ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$next; ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group" id="fgMsg" style="display: none; padding-top: 10px">
                <span class='alert alert-danger' id="errMsg"></span>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <a href='#' onclick='addFinanceCharges()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
        
    </div>
        
</div>

<div id="addPlanToSchedule" class="modal fade" style="width:25%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Finance Plan  
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Select Grade Level</label><br />
                <select id="gradeLevelPlan" style="width:100%;">
                    <option>Select Grade Level</option>
                    <?php foreach ($gradeLevel as $gl): ?>
                    <option value="<?php echo $gl->grade_id ?>"><?php echo $gl->level ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id='student_type' class='control-group' >
                <div class='controls'>
                <label>Select Type</label><br />
                  <select  name='inputStudentType' style='width:90%;' id='inputStudentType' class='pull-left controls' required>
                       <?php
                            $plan_type = Modules::run('finance/getPlanType', $now);
                            foreach($plan_type as $pt):
                        ?>
                            <option value="<?php echo $pt->fin_type_id ?>"><?php echo $pt->fin_plan_type ?></option>
                       <?php endforeach; ?>
                  </select> &nbsp;&nbsp;
                
                <button title="Add Finance Plan" class="btn btn-xs btn-info" onclick="$('#addPlanType').modal('show')"><i class="fa fa-plus fa-fw"></i></button>
                </div>
            </div><br />
            <div class="form-group">
                <label>Plan Title</label>
                <input type="text" id="planTitle" class="form-control" placeholder="Plan Title" />
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='addToFeeSchedule()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
     </div>
</div>

<div id="addPlanType" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Plan Type
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" id="plan_type" class="form-control" placeholder="Plan Type" />
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='savePlanType()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right' style="margin-right:10px;" >Cancel</button>&nbsp;&nbsp;
        </div>
     </div>
</div>

<div id="addItemModal" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Finance Item    
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Item</label>
                <input type="text" id="fin_item" class="form-control" placeholder="Item" />
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='addItems()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
     </div>
</div>

<div id="editFinItem" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Edit <span id="fin_desc"></span>
            <input type="hidden" id="charge_id" />
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Amount</label>
                <input type="text" id="edit_fin_amount" class="form-control" onclick="this.placeholder=$(this).val(), $(this).val('')" placeholder="Item" />
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='editFinanceCharges()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right' style="margin-right:10px;" >Cancel</button>&nbsp;&nbsp;
        </div>
     </div>
</div>


<div id="deleteFinCharges" style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h3>
                <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to delete this finance item, this might be connected to other accounts in the system, make sure you know what you are doing
                ? Please note also that you can't undo this action.
            </h3>
        </div>
        <div class="panel-body">
                <input type="hidden" id="del_charge_id" />
            <div style='margin:5px 0;'>
            <a href='#' id='<?php echo $g->grade_id ?>' data-dismiss='modal' onclick='deleteFinanceCharges()' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-left'>Delete</a>
            <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>

<div id="cashBreakdown" class="modal fade" style="width:50%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Cash Break Down
        </div>
        <div class="panel-body">
            <div class="form-group">
                <?php $collection = Modules::run('finance/getCollectionReport', date('Y-m-d'), date('Y-m-d')); 
                    $overAll = 0;
                      foreach($collection->result() as $c): 
                        $overAll += $c->amount;
                      endforeach;        
                ?>
                
                <h4 class="text-center">Total Cash Collection: ₱ <?php echo number_format($overAll,2,'.',',') ?></h4>
               
            </div>
            <div class="form-group">
                <?php $cashDen = Modules::run('finance/getCashDenomination'); 
                ?>
                <label>Cash Denomination</label> <br />
                <select name="inputCashDen" id="inputCashDen" class="col-lg-8 no-padding" required>
                  <option>Select Denomination</option> 
                  <?php foreach($cashDen as $cd): ?>
                    <option id="<?php echo $cd->cd_id ?>_list" value="<?php echo $cd->cd_id ?>"><?php echo $cd->denomination ?></option> 
                  <?php endforeach; ?>
                  
                </select>
                <div class="input-group col-lg-4">
                    <input type="text" id="cashCount" class="form-control" placeholder="count">
                    <div class="input-group-btn">
                        <button class="btn btn-success" onclick="addItem($('#inputCashDen').val())" type="button">Insert</button>
                    </div>
                </div><br />
                <div class="col-lg-12">
                    Breakdown:
                    <div  class="well well-sm">
                        <table class="table table-hover">
                            <tr>
                                <th class="col-lg-6">Denomination</th>
                                <th>#</th>
                                <th>Total</th>
                                <th class="col-lg-1"></th>
                            </tr>
                            <tbody id="breakDownList">
                                
                            </tbody>
                        </table>
                    </div>

                </div>
                
            </div>
            <input type="hidden" id="cashDomJson" />
        </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick="saveCashBreakDown()" style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
        
    </div>
        
</div>



<script type="text/javascript">
    $('#inputCashDen').select2();
    var cashDen = [];
    var ids = [];
    
    function savePlanType()
    {
        var url = '<?php echo base_url().'finance/savePlanType/' ?>'+$('#school_year').val();
             $.ajax({
                type: "POST",
                url: url,
                data: {
                    plan_type        : $('#plan_type').val(),
                    csrf_test_name   : $.cookie('csrf_cookie_name')  
                 }, // serializes the form's elements.
                success: function(data)
                {
                    if(data!=0)
                    {
                        $('#inputStudentType').append(data);
                    }else{
                        alert('Sorry Something went wrong, Please try again later');
                    }
                }
              });

         return false;
        
    }
    
    function addToFeeSchedule()
    {
        var url = '<?php echo base_url().'finance/addToFeeSchedule/' ?>'+$('#school_year').val();
             $.ajax({
                type: "POST",
                url: url,
                data: {
                    semester         : $('#inputSem').val(),
                    grade_level_id   : $('#gradeLevelPlan').val(),
                    type             : $('#inputStudentType').val(),
                    title            : $('#planTitle').val(),
                    csrf_test_name   : $.cookie('csrf_cookie_name')  
                 }, // serializes the form's elements.
                success: function(data)
                {
                    alert(data);
                    location.reload();
                }
              });

         return false;
    } 
    
    function saveCashBreakDown()
    {
        var url = '<?php echo base_url().'finance/saveCashBreakDown' ?>';
             $.ajax({
                type: "POST",
                url: url,
                data: {
                    items            : $('#cashDomJson').val(),
                    csrf_test_name   : $.cookie('csrf_cookie_name')  
                 }, // serializes the form's elements.
                success: function(data)
                {
                    alert(data);
                    location.reload();
                }
              });

         return false;
    } 
    
   function addItem(value)
   {
       var cashCount = $('#cashCount').val();
       var partial = parseFloat(cashCount) * parseFloat($('#'+value+'_list').html());
       var items = {
           den_id       : value,
           denomination : $('#'+value+'_list').html(),
           count        : cashCount,
           
       };
       
       cashDen.push(items);
       $('#cashDomJson').val(JSON.stringify(cashDen));
       $('#breakDownList').append('<tr id="li_'+ids+'"><td><strong>'+$('#'+value+'_list').html()+'</strong></td><td>'+cashCount+'</td><td>'+partial+'</td><td><i onclick="$(\'#li_'+ids+'\').hide(), removeFromList('+ids+')" class="fa fa-close pointer text-danger"></i> </tr>');
   }
   
   
   
   
    function removeFromList(id)
    {
       var data = []
       id = id-1
       data = $('#cashDomJson').val();
        $('#breakDownList').html('');
        
       var obj = JSON.parse(data);
       obj.splice(id, 1);
       
       Object.keys(obj).forEach(function(key){
           
           var partial = parseInt(obj[key].count) * parseInt(obj[key].denomination);
           console.log(obj[key].denomination)
            $('#breakDownList').append('<tr id="li_'+ids+'"><td><strong>'+obj[key].denomination+'</strong></td><td>'+obj[key].count+'</td><td>'+partial+'</td><td><i onclick="$(\'#li_'+ids+'\').hide(), removeFromList('+ids+')" class="fa fa-close pointer text-danger"></i> </tr>');
           
        });
        
      $('#cashDomJson').val(JSON.stringify(obj));
    }
    
    
             
    function saveEncashments()
     {
        var bank = $('#enBank').val();
        var chequeNumber = $('#chequeNumber').val();
        var amount = $('#chequeAmount').val();
        var chequeDate = $('#chequeDate').val();
        
        var url = "<?php echo base_url().'finance/saveEncashments'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: {
                 bank : bank,
                 chequeNumber : chequeNumber,
                 chequeAmount : amount,
                 chequeDate   : chequeDate,
                 csrf_test_name: $.cookie('csrf_cookie_name')
               }, // serializes the form's elements.
               success: function(data)
               {
                   alert(data)
               }
             });

        return false; 
     }
         
    function addBank()
     {
         
        var url = "<?php echo base_url().'finance/addBank'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: "bank="+$('#bank').val()+'&bankShortName='+$('#bankShortName').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#enBank').append(data);
                   $('#chequeBank').append(data);
                   $('#addBank').modal('hide');
                   alert('Bank Successfully Added to List');
               }
             });

        return false; 
     }
         
    function addItems()
     {
         var finItem = $('#fin_item').val();
         
        var url = "<?php echo base_url().'finance/addFinanceItem'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: "finItem="+finItem+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#inputFinItems').append(data);
                   $('#addItemModal').modal('hide');
               }
             });

        return false; 
     }
     
     
         
    function selectSection(level_id){
          var url = "<?php echo base_url().'registrar/getSectionByGL/'?>"+level_id; // the script where you handle the form input.
          
           if(level_id==12 || level_id==13)
           {
               $('#strandWrapper').show();
           }else{
               $('#strandWrapper').hide();
            }
            $.ajax({
                   type: "POST",
                   url: url,
                   data: "level_id="+level_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#inputSection').html(data);
                           
                   }
                 });

            return false;
      }

    
    $(document).ready(function() {

          $('#chequeDate').datepicker();
          $("#inputFinItems").select2();
          $("#inputGradeModal").select2();
          $("#inputCSubject").select2();
    });
</script>

<!-- End of Schedule Modal-->
