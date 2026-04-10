<div id="amTransaction" class="modal fade" style="width:40%; margin:50px auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary">
        <div class="panel-heading clearfix">
            <button class="btn btn-xs btn-danger pull-right" data-dismiss="modal">x</button>
            <div class="col-lg-6 pull-left no-padding">
                <h5 class="pull-left no-margin"><i style="margin-top:5px;" class="fa fa-file fa-2x"></i> </h5>
                <h5 style="margin-top:10px; margin-left: 40px;">New Transaction</h5>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-lg-12">
                <div class="form-group col-lg-4 pull-left">
                    <label>JE #</label>
                    <input class="form-control" id="je"  placeholder="JE #" value="<?php echo $countTrans+1 ?>" type="text">
                </div>
                <div class="col-lg-4"></div>
                <div class="form-group col-lg-4">
                    <label>Date</label>
                    <input class="form-control" value="<?php echo date('Y-m-d') ?>" name="transDate" type="text" data-date-format="yyyy-mm-dd" id="transDate" required>
                </div>
                <div class="form-group col-lg-12">
                    <label>Description</label>
                    <textarea id="transDesc" style="text-align: left;"class="form-control textarea"></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <button onclick="$('#addEntry').modal('show')" class="btn btn-success btn-block"> ADD ENTRY</button>
            </div>
            <hr />
            <div style="margin-top:10px;" class="col-lg-12 no-padding">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Account</th>
                            <th>Debit</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody id="ae_body">
                        
                    </tbody>
                    <tfoot style="display: none;" id="ae_footer">
                        <tr><td>TOTAL</td>
                            <td class="text-center" id="debitTotalDisplay">0</td>
                            <td class="text-center" id="creditTotalDisplay">0</td>
                    <input type="hidden" value="0" id="debitTotal" />
                    <input type="hidden" value="0" id="creditTotal" />
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <button class="btn btn-warning pull-right" id="saveTransBtn">Save Transaction</button>
        </div>
    </div>
</div>

<div id="addEntry" class="modal fade" style="width:20%; margin:60px auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-warning">
        <div class="panel-heading clearfix">
            <button class="btn btn-xs btn-danger pull-right" data-dismiss="modal">x</button>
            <div class="col-lg-6 pull-left no-padding">
                <h5 class="pull-left no-margin"><i style="margin-top:5px;" class="fa fa-plus fa-2x"></i> </h5>
                <h5 style="margin-top:10px; margin-left: 40px;">Add Entry</h5>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-group input-group col-lg-12">
                <label>Account</label><br />
                <select id="addAccount" style="width:100%;">
                    <option>Select Account</option>
                    <?php foreach($accountTitles as $acct): ?>
                        <option id="<?php echo $acct->coa_id ?>" value="<?php echo $acct->coa_id ?>"><?php echo $acct->coa_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group input-group col-lg-12">
                <label>Amount</label>
                <input class="form-control" id="ae_amount"  placeholder="0" type="text">
            </div>
            <div class="btn-group col-lg-12">
                <button style="width: 50%;" onclick="addEntry(true)" class="btn btn-warning">Debit</button>
                <button style="width: 50%;"  onclick="addEntry(false)" class="btn btn-danger">Credit</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        $('#transDate').datepicker();
        $('#addAccount').select2();
        
        $('#saveTransBtn').click(function(){
            var url = "<?php echo base_url().'accountingsystem/saveASTransaction' ?>";
            var data = [];
            $('#ae_body tr').each(function(){
                data.push($(this).attr('coa'));
            });
        
            $.ajax({
                type: "POST",
                url: url,
                dataType:'json',
                data: {
                    je              : $('#je').val(),
                    items           : JSON.stringify(data),
                    transDate       : $('#transDate').val(),
                    desc            : $('#transDesc').val(),
                    csrf_test_name  : $.cookie('csrf_cookie_name')
                }, // serializes the form's elements.
                success: function(data)
                {   
                    if(data.status)
                    {
                        alert('Successfully Added');
                    }else{
                        alert('Sorry Something went wrong');
                    }
                    
                    location.reload();

                }
            });
        });
    });
    

    function addEntry(option)
    {
        var account = $('#addAccount').val();
        var name = $('#'+account).html();
        var value = $('#ae_amount').val();
        var debitTotal = $('#debitTotal').val();
        var creditTotal = $('#creditTotal').val();
        
        if(option){
            $('#ae_body').append('<tr coa="'+account+'_'+value+'_1" ><td>'+name+'</td><td class="text-center">'+numberWithCommas(value)+'</td><td class="text-center"> --- </td></tr>');
            $('#debitTotalDisplay').html(numberWithCommas(parseFloat(debitTotal) + parseFloat(value)));
            $('#debitTotal').val(parseFloat(debitTotal) + parseFloat(value));
        }else{
            $('#ae_body').append('<tr coa="'+account+'_'+value+'_0"><td>&nbsp;&nbsp;&nbsp;'+name+'</td><td class="text-center">---</td><td class="text-center"> '+numberWithCommas(value)+' </td></tr>');
            $('#creditTotalDisplay').html(numberWithCommas(parseFloat(creditTotal) + parseFloat(value)));
            $('#creditTotal').val(parseFloat(creditTotal) + parseFloat(value));
        }
    
        $('#addEntry').modal('hide')
        $('#ae_footer').show();
        
       
    }
    
    
    
      function numberWithCommas(x) {
        if(x==null){
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>