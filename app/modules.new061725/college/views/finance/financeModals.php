<!--subject Course-->
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

<div id="cashBreakdown" class="modal fade" style="width:50%; margin:10px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Cash Break Down
        </div>
        <div class="panel-body">
            <div class="form-group">
                <?php $collection = Modules::run('college/finance/getCollectionReport', date('Y-m-d'), date('Y-m-d')); 
                    $overAll = 0;
                      foreach($collection->result() as $c): 
                        $overAll += $c->amount;
                      endforeach;        
                ?>
                
                <h4 class="text-left">Total Cash Collection: ₱ <?php echo number_format($overAll,2,'.',',') ?>
                <input class="pull-right" type="text" data-date-format="yyyy-mm-dd" name="dateCollected" id="dateCollected" value="<?php echo date('Y-m-d') ?>">
                </h4>
            </div>
            <div class="form-group">
                <?php $cashDen = Modules::run('college/finance/getCashDenomination'); 
                ?>
                <label>Cash Denomination</label> <br />
                <select name="inputCashDen" id="inputCashDen" onclick="getCashDenomination()" class="col-lg-8 no-padding" required>
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
                <input type="hidden" id="course_id" />
                <input type="hidden" id="year_level" />
            </div>
<!--            <div class="form-group">
                <label>School Year</label> <br />
                <select style="width:100%;"  name="inputCSY" id="inputCSY" required>
                  <option value="0">Select School Year</option> 
                    <?php 
                           foreach ($ro_years as $ro)
                             {   
                               $next = ($ro->ro_years+1);
                       ?>                        
                            <option value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$next; ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Semester</label>
                <select tabindex="-1" id="inputSem" name="inputSem"  class="col-lg-12">
                   <option>Select Semester</option>
                   <option value="1">First Semester</option>
                   <option value="2">Second Semester</option>
                   <option value="3">Summer</option>
                   
               </select>
             </div>-->
        </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='addFinanceCharges()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
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


<div id="deleteFinCharges"  style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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




<script type="text/javascript">
    $('#inputCashDen').select2();
    $('#dateCollected').datepicker();
    var cashDen = [];
    var ids = [];
    
    function getCashDenomination()
    {
        var url = '<?php echo base_url().'college/finance/getCashBreakdownDetails' ?>';
         $.ajax({
            type: "POST",
            url: url,
            data: {
                dateCollected    : $('#dateCollected').val(),
                csrf_test_name   : $.cookie('csrf_cookie_name')  
             }, // serializes the form's elements.
            success: function(data)
            {
                $('#breakDownList').html(data)
            }
          });
    }
    
    function saveCashBreakDown()
    {
        var url = '<?php echo base_url().'college/finance/saveCashBreakDown' ?>';
             $.ajax({
                type: "POST",
                url: url,
                data: {
                    items            : $('#cashDomJson').val(),
                    csrf_test_name   : $.cookie('csrf_cookie_name')  
                 }, // serializes the form's elements.
                success: function(data)
                {
                    //alert(data);
                    //location.reload();
                    getCashDenomination();
                }
              });

         return false;
    } 
    
   function addItem(value)
   {
       var cashCount = $('#cashCount').val();
       var partial = parseFloat(cashCount) * parseFloat($('#'+value+'_list').html());
       var items = {
           den_id           : value,
           denomination     : $('#'+value+'_list').html(),
           count            : cashCount,
           dateCollected    : $('#dateCollected').val()
           
       };
       cashDen.push(items);
       $('#cashDomJson').val(JSON.stringify(cashDen));
       saveCashBreakDown();
   }
   
   
    function removeFromList(id)
    {
        var url = '<?php echo base_url().'college/finance/removeCashDenomination/' ?>'+id;
         $.ajax({
            type: "GET",
            url: url,
            data: {
                csrf_test_name   : $.cookie('csrf_cookie_name')  
             }, // serializes the form's elements.
            success: function(data)
            {
                getCashDenomination();
            }
          });
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
         
        var url = "<?php echo base_url().'college/finance/addFinanceItem'?>"; // the script where you handle the form input.

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
     
     
    function addDiscCat()
    {
        var url = "<?php echo base_url('college/finance/addDiscCat/') ?>";
        $.ajax({
            type: 'POST',
            url: url,
            //dataType: 'json',
            data: {
                disc_cat: $('#disc_cat').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                $('#inputDiscountCategory').append(response);
                $('#addDiscCatModal').modal('hide');
                $('#addDiscount').modal('show');
            }

        });
    }
     
     

    
    $(document).ready(function() {

          
          $("#inputFinItems").select2();
          $("#inputGradeModal").select2();
          $("#inputCSubject").select2();
    });
</script>

<!-- End of Schedule Modal-->
