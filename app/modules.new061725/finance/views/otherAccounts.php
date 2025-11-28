<div id="cashRegister" class="modal fade" style="width:70%; margin:30px auto; " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-primary">
        <div class="panel-heading clearfix">
            <div class="page-header no-margin">
                <span >CASH Register for no Active School Accounts</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> <br />
            </div>
            <div style="margin-top:10px;" class="form-group pull-left">
                <div class="form-group col-lg-6">
                    <label>Family Name</label>
                    <input type="lastname" id="lastname" class="form-control"  placeholder="Family Name" />
                </div>
                <div class="form-group col-lg-6">
                    <label>First Name</label>
                    <input type="firstname" id="firstname" class="form-control"  placeholder="First Name" />
                </div>
            </div>
            <div style="margin-top:10px;"  class="form-group pull-right">
                <select style="color: black;" tabindex="-1" id="inputTrType" name="inputTrType"  class="col-lg-12">
                   <option onclick="$('#chequeWrapper').hide()" value="0">Cash</option>
                   <option onclick="$('#chequeWrapper').show()" value="1">Cheque</option>
               </select>
             </div>
            
            <div style="margin-top:10px;"  class="form-group pull-right">
                <select style="color: black;" tabindex="-1" id="inputReceipt" name="inputReceipt"  class="col-lg-12">
                   <option value="0">Official Receipt</option>
                   <option value="1">Acknowledgment Receipt</option>
                   <option value="2">Temporary Receipt</option>
                   
               </select>
             </div><br /><br />
            <div id="chequeWrapper" class="form-group pull-right" style="display:none;">
                
                <div class="form-group">
                    <label>Bank</label>
                    <select style="width:75%; color: black;"  name="chequeBank" id="chequeBank" required>
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
                    <input type="text" style="width: 200px; color: black" placeholder="" id="inputCheque" />
                </div>
            </div>
            <input type="hidden" id="charge_id" />
        </div>
         <div class="panel-body">
             <div class="col-lg-8">
                 <div class="bg-info clearfix">
                     <div class="form-group col-lg-4">
                        <label>OR #</label>
                        <input type="text" id="refNumber" value="<?php echo ($financeSettings->print_receipts?$series->or_current+1:'') ?>" <?php echo ($finSettings->print_receipts?'readonly':'')?> class="form-control"  placeholder="OR Number" />
                    </div>
                     <div class="form-group col-lg-4">
                        <label class="control-label" for="input">Transaction Date</label>
                        <input class="form-control" name="transactionDate" type="text" value="<?php echo date('Y-m-d') ?>" data-date-format="yyyy-mm-dd" id="transactionDate" placeholder="" required>

                    </div> 
                    <div class="form-group col-lg-4">
                        <label>Remarks</label>
                        <input type="text" id="transRemark" class="form-control"  placeholder="Remarks" />
                    </div>
                 </div>
                <div class="well col-lg-12 no-padding">
                    <table class="table table-striped">
                        <tr>
                            <th>Item Description</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        <tbody id="itemBody">
                            
                        </tbody>
                    </table>
                </div>    
             </div>
             
            <div class="col-lg-4 text-center no-padding">
                <div class="panel panel-default">
                    <div class="panel-body bg-primary text-center">
                        <button type="button" onclick="$('#addCashItemModal').modal('show')" class="btn btn-info" id="add_items" style="width: 100%; height: 40px;"><i class="fa fa-plus fa-lg fa-fw"></i><b>Add Items</b></button>
                        <h4>T O T A L</h4>
                        <input class="text-center" style="font-size: 25px; font-weight: bold; color: red; width: 100%;" name="pttAmount" id="pttAmount" disabled>
                        <h4>Amount Tendered</h4>
                        <input class="text-center" style="font-size: 25px; font-weight: bold; color: green; width: 100%;" name="ptAmountTendered" id="ptAmountTendered" onblur="cash_change()" required>
                        <h4>C H A N G E</h4>
                        <input class="text-center" style="font-size: 25px; font-weight: bold; color: blue; width: 100%;" name="ptChange" id="ptChange" disabled>
                        <div class="row">
                            <div class="col-xs-12 col-md-12" style="margin-top: 20px;">
                                <button type="button" class="btn btn-success" id="paynow" onclick="$('#confirmPayment').modal('show') " style="width: 100%; height: 60px;"><i class="fa fa-thumbs-up fa-lg fa-fw"></i><b>PAY NOW!!!</b></button>
                                <button data-dismiss="modal" type="button" class="btn btn-danger" id="cancel_trans" style="width: 100%; height: 40px; margin-top: 10px;"><b><i class="fa fa-times fa-lg fa-fw"></i>C A N C E L</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
         </div>
     </div>
</div>

<div id="addCashItemModal" class="modal fade" style="width:15%; margin:50px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Finance Item    
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Finance Item</label> <br />
                <select style="width:90%;"  name="cashFinItems" id="cashFinItems" required onclick="calculateItem(this.value)">
                  <option value="0">Select Item</option> 
                    <?php 
                           foreach ($fin_items as $i)
                             {   
                       ?>                        
                            <option id="<?php echo $i->item_id; ?>_desc" value="<?php echo $i->item_id; ?>"><?php echo $i->item_description; ?></option>
                    <?php }?>
                </select>   
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" id="edit_fin_amount" class="form-control"  placeholder="Amount" />
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='addToItems()' style='color: white' class='btn btn-xs btn-success pull-right'>Add</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right' style="margin-right:10px; ">Cancel</button> &nbsp;&nbsp;
        </div>
     </div>
</div>

<div id="confirmPayment"  style="width:35%; margin: 70px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green" style='width:100%;'>
        <div class="panel-heading">
            <h3>
                <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to confirm the payment of this student?.
            </h3>
        </div>
        <div class="panel-body">
            <div style='margin:5px 0;'>
            <button data-dismiss='modal' class='btn btn-xs btn-warning pull-right'>Cancel</button>&nbsp;&nbsp;
            <a href='#' data-dismiss='modal' onclick='saveTransaction()' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>YES</a> 
            <?php if($finSettings->print_receipts):?>
                <div class="pull-left" >
                    <input type="checkbox" checked="checked" id="printOR" /> PRINT Official Receipt
                </div>
            
            <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    
    var itemDescID = "";
    var Amount = 0;
    var itemId = "";
    window.setTimeout(function () {
        $('#inputFinItems').select2();
        $('#cashFinItems').select2();
        $('#inputDiscountedItems').select2();
        $('#transactionDate').datepicker({
            orientation: "left"
        });
        $('#inputFinItems').click(function(){
            if($(this).val()==0)
            {
                $('#addFinanceOption').modal('hide');
                $('#addDiscount').modal('show')
            }
            
        });
    }, 500);
    
    
    function addToItems()
    {
        
        var itemAmount = $("#edit_fin_amount").val();
        Amount = parseFloat(Amount) + parseFloat(itemAmount);
        $('#itemBody').append('<tr tr_val="'+itemId+'_'+itemAmount+'" id="'+itemId+'"><td>'+itemDescID+'</td><td>'+itemAmount+'</td><td><button onclick="$(\'#'+itemId+'\').hide(), deductAmount('+itemAmount+')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></td></tr>');
        $('#pttAmount').val(Amount)
        
        $("#edit_fin_amount").val('') ;
    }
    
    function deductAmount(itemAmount)
    {
        Amount = parseFloat(Amount) - parseFloat(itemAmount);
        $('#pttAmount').val(Amount)
    }
    
    function cash_change()
    {
        var item_amount = document.getElementById("pttAmount").value;
        if (item_amount != '') {
            var con_amount = string2number(item_amount);
        } else {
            var con_amount = 0;
        }
        var tend_amount = document.getElementById('ptAmountTendered').value;
        var con_tendered = string2number(tend_amount);

        calc_change = con_tendered - con_amount;
        tot_change = number2string(calc_change);
        document.getElementById('ptChange').value = tot_change;

    }
    
    
    function saveTransaction()
    {
        var or_num = $('#refNumber').val();
        var st_id = $('#st_id').val();
        var sem = 0;
        var sy = '<?php echo $this->session->userdata('school_year'); ?>';
        var transDate = $('#transactionDate').val();
        var transType = $('#inputTrType').val();
        
        var data = [];
        $('#itemBody tr').each(function(){
            data.push($(this).attr('tr_val'));
        });
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/saveOtherTransaction' ?>',
            dataType: 'json',
            data: {
                items: JSON.stringify(data),
                or_num: or_num,
                lastname: $('#lastname').val(),
                firstname: $('#firstname').val(),
                sem: sem,
                school_year:sy,
                transDate:transDate,
                transType:transType,
                receipt: $('#inputReceipt').val(),
                t_remarks: $('#transRemark').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
                },
            success: function (response) {
                //alert(response);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'finance/updateOR/' ?>'+or_num,
                    //dataType: 'json',
                    data: {
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function (data) {
                        
                    }

                });
                
                
                <?php if($finSettings->print_receipts):?>
                    if($('#printOR').is(':checked')){
                        var url = '<?php echo base_url('finance/printOtherOR/')?>'+response.accountNumber+'/'+or_num+'/'+(transType==0?'Cash':'Cheque')+'/'+$('#ptAmountTendered').val();
                        window.open(url, '_blank');    
                    }
                <?php endif; ?>
                
                location.reload();
                
                 
            }

        });
    }
    
    function calculateItem(item_id)
    {
        itemId = item_id;  
        itemDescID = $('#'+item_id+'_desc').html();

    }
    
    
        function number2string(sNumber)
    {
        //Seperates the components of the number
        var n = sNumber.toString().split(".");
        //Comma-fies the first part
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //Combines the two sections
        return n.join(".");
    }
    
    function string2number(svariable)
    {
        var cNumber = svariable.replace(/\,/g, '');
        cNumber = parseFloat(cNumber);
        if (isNaN(cNumber) || !cNumber) {
            cNumber = 0;
        }
        return cNumber;
    }
</script>