<div id="purchaseRequest" class="modal fade" style="width:50%; margin:50px auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <button class="btn btn-xs btn-danger pull-right" onclick='location.reload()'>x</button>
            <div class="col-lg-6 pull-left no-padding">
                <h5 class="pull-left no-margin"><i style="margin-top:5px;" class="fa fa-credit-card fa-2x"></i> </h5>
                <h5 style="margin-top:10px; margin-left: 40px;">Purchase Request</h5>
            </div>
        </div>
        <div class="panel-body" id="purchaseRequestWrapper">
            <div class="col-lg-4 pull-right">
                <div class="form-group pull-right">
                    <label>Request Date</label>
                    <input class="prDate" name="date_requested" type="text" id="date_requested" data-date-format="yyyy-mm-dd" placeholder="Date" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="col-lg-12 no-padding form">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label>Requesting Person</label>
                        <input class="form-control" name="requestingParty" type="text" id="requestingParty" >
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <label>Requesting Department</label>
                        <input class="form-control" name="requestingDepartment" type="text" id="requestingDepartment" >
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Date Needed</label>
                        <input class="prDate" name="date_needed" type="text" id="date_needed" data-date-format="yyyy-mm-dd" placeholder="Date" value="<?php echo date('Y-m-d'); ?>">
                        <div class="pull-right">
                            <button onclick="$('#addItemModal').modal('show')" style="margin-top:15px;" class="btn btn-xs btn-warning"><i class="fa fa-plus-square fa-fw"></i>ADD Item</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <table id="prItems" class="table table-striped">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-left" style="width:25%;">Item</th>
                            <th  style="width:30%;">Description</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Total Amount</th>
                            <td></td>
                        </tr>
                        <tbody id="itemWrapper">
                            
                        </tbody>
                        <tfoot id="totalWrapper">
                            <tr>
                                <td><b>TOTAL</b></td>
                                <td colspan="4"></td>
                                <td class="text-right" id="totalPrice"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class='panel-footer clearfix'>
            <button class="btn btn-small btn-success pull-right" onclick="submitPurchaseRequest()"><i class="fa fa-save fa-fw"></i> SUBMIT</button>
        </div>
    </div>
</div>
<div id="expenseDisbursement" class="modal fade col-lg-4" style="margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Expense 
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Date </label>
                <input class="prDate" name="disDate" type="text" id="disDate" data-date-format="yyyy-mm-dd" placeholder="Date" value="<?php echo date('Y-m-d'); ?>">

            </div>
             <div class="form-group">
                 <label>Particulars</label>
                 <textarea style="width:100%;" id="exp_particulars" class="textarea text-left" onclick="$(this).html('')">
                     
                 </textarea>
             </div><br />
             <div class="form-group">
                 <label>Account Title</label>
                <select tabindex="-1" id="exp_account_title" class="col-lg-12 no-padding accounts">
                    <option>Select Account Title</option>
                    <?php 
                          foreach ($accountTitles as $title)
                           {   
                          ?>                        
                        <option value="<?php echo $title->coa_id; ?>"><?php echo $title->coa_name ?></option>
                        <?php }?>
                </select>
             </div><br />
             <div class="form-group">
                 <label>BanK</label>
                <select tabindex="-1" id="exp_account_bank" class="col-lg-12 no-padding accounts">
                    <option>Select Account</option>
                    <?php 
                          foreach ($cashEquivalents as $bank)
                           {   
                          ?>                        
                        <option value="<?php echo $bank->coa_id; ?>"><?php echo $bank->coa_name ?></option>
                        <?php }?>
                </select>
             </div><br />
            <div class="form-group input-group col-lg-12">
                <label>Amount</label>
                <input class="form-control" id="exp_amount"  placeholder="Account Name" type="text">
            </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='addExpense()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>ADD</a>
            
        </div>
     </div>
</div>


<div id="addItemModal" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="panel panel-yellow">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Add Purchase Request Item    
        </div>
         <div class="panel-body">
            <div class="form-group">
                <label>Item</label>
                <input type="text" id="pr_item" class="form-control" placeholder="Item" />
            </div>
             <div class="form-group">
                 <label>Description</label>
                 <textarea style="width:100%;" id="description" class="textarea">
                     
                 </textarea>
             </div>
             <div class="form-group">
                 <label>Quantity</label>
                <input type="text" id="pr_quantity" class="form-control" placeholder="Quantity" />
             </div>
             <div class="form-group">
                 <label>Amount</label>
                <input type="text" id="pr_amount" class="form-control" placeholder="Amount" />
             </div>
         </div>
        <div class="panel-footer clearfix">
            <a href='#'data-dismiss='modal' onclick='addItems()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>ADD</a>
            
        </div>
     </div>
</div>


<script type="text/javascript">
    
    $(document).ready(function(){
        $('.prDate').datepicker();
        $('.accounts').select2();
    });
    var num = 0;
    var subTotal = 0;
    function submitPurchaseRequest()
    {
        var data = [];
        $('#itemWrapper tr').each(function(){
            data.push($(this).attr('trVal'));
        });
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'accountingsystem/savePurchaseRequest' ?>',
            //dataType: 'json',
            data: {
                data: JSON.stringify(data),
                pr_date: $('#date_requested').val(),
                pr_request_by: $('#requestingParty').val(),
                pr_requestingDepartment: $('#requestingDepartment').val(),
                pr_date_needed: $('#date_needed').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                window.location.reload();
            }

        });
    }
    
    function addExpense()
    {
        var url = '<?php echo base_url('accountingsystem/saveExpense') ?>';
        $.ajax({
            type: 'POST',
            url: url,
            //dataType: 'json',
            data: {
                exp_date        : $('#disDate').val(),
                exp_particulars : $('#exp_particulars').val(),
                exp_account_title : $('#exp_account_title').val(),
                exp_account_bank : $('#exp_account_bank').val(),
                exp_amount       : $('#exp_amount').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                window.location.reload();
            }

        });
    }
    
    function addItems()
    {
        num = num +1;
        var item = $('#pr_item').val();
        var desc = $('#description').val();
        var qty = $('#pr_quantity').val();
        var amt = $('#pr_amount').val();
        var total = parseInt(qty)*parseFloat(amt);
         var option = "<button class='btn btn-primary btn-danger btn-xs delBtn' onclick='delRow(this)'><span class='glyphicon glyphicon-trash'></span></button><b hidden class='item_id'>" + num + "</b>";
        $('#itemWrapper').append('<tr trVal="'+item+'_'+desc+'_'+qty+'_'+amt+'"><td>'+num+'</td><td>'+item+'</td><td>'+desc+'</td><td class="text-center">'+qty+'</td><td class="text-right">'+amt+'</td><td tdValue='+total+' class="text-right subTotal">'+numberWithCommas(total)+'</td><td>'+option+'</td></tr>');
        calc(total);
    }
    
    
    function calc(total) {
        subTotal = subTotal + total;
        $('#totalPrice').html(numberWithCommas(subTotal))
    }
    
    function delRow(x) {
        $(x).parent().parent().remove();
        num = num-1;
        calc();
    }
    
    function numberWithCommas(x) {
        if(x==null){
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
</script>