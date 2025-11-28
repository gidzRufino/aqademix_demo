<div id="payroll" class="modal fade" style="width:30%; margin:50px auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <button class="btn btn-xs btn-danger pull-right" onclick='location.reload()'>x</button>
            <div class="col-lg-6 pull-left no-padding">
                <h5 class="pull-left no-margin"><i style="margin-top:5px;" class="fa fa-link fa-2x"></i> </h5>
                <h5 id="payLinkTitle" style="margin-top:10px; margin-left: 40px;"></h5>
            </div>
        </div>
        <div class="panel-body" id="editPayItemWrapper">
            <div class="form-group input-group col-lg-12">
                <label>Account Title</label>
                <select id="editPayAccountTitle" class="col-lg-12 no-padding editLinks">
                    <?php foreach ($titles as $t): ?>
                        <option value="<?php echo $t->coa_id ?>"><?php echo $t->coa_code.' - '.$t->coa_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group input-group col-lg-12">
                <label>Debits To</label>
                <select id="editPayDebitTo" class="col-lg-12 no-padding editLinks">
                    <option></option>
                    <?php foreach ($titles as $t): ?>
                        <option value="<?php echo $t->coa_id ?>"><?php echo $t->coa_code.' - '.$t->coa_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group input-group col-lg-12">
                <label>Credits To</label>
                <select id="editPayCreditTo" class="col-lg-12 no-padding editLinks">
                    <option></option>
                    <?php foreach ($titles as $t): ?>
                        <option value="<?php echo $t->coa_id ?>"><?php echo $t->coa_code.' - '.$t->coa_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type='hidden' name="finItem_id" id='payItem_id' />
        </div>
        <div class='panel-footer clearfix'>
            <button class="btn btn-small btn-success pull-right" onclick="editPayrollItems()"><i class="fa fa-save fa-fw"></i> SAVE</button>
        </div>
    </div>
</div>
<div id="financeLinks" class="modal fade" style="width:30%; margin:50px auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <button class="btn btn-xs btn-danger pull-right" onclick='location.reload()'>x</button>
            <div class="col-lg-6 pull-left no-padding">
                <h5 class="pull-left no-margin"><i style="margin-top:5px;" class="fa fa-link fa-2x"></i> </h5>
                <h5 id="finLinkTitle" style="margin-top:10px; margin-left: 40px;"></h5>
            </div>
        </div>
        <div class="panel-body" id="editFinItemWrapper">
            <div class="form-group input-group col-lg-12">
                <label>Account Title</label>
                <select id="editAccountTitle" class="col-lg-12 no-padding editLinks">
                    <?php foreach ($titles as $t): ?>
                        <option value="<?php echo $t->coa_id ?>"><?php echo $t->coa_code.' - '.$t->coa_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group input-group col-lg-12">
                <label>Debits To</label>
                <select id="editDebitTo" class="col-lg-12 no-padding editLinks">
                    <?php foreach ($titles as $t): ?>
                        <option value="<?php echo $t->coa_id ?>"><?php echo $t->coa_code.' - '.$t->coa_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group input-group col-lg-12">
                <label>Credits To</label>
                <select id="editCreditTo" class="col-lg-12 no-padding editLinks">
                    <?php foreach ($titles as $t): ?>
                        <option value="<?php echo $t->coa_id ?>"><?php echo $t->coa_code.' - '.$t->coa_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type='hidden' name="finItem_id" id='finItem_id' />
        </div>
        <div class='panel-footer clearfix'>
            <button class="btn btn-small btn-success pull-right" onclick="editFinanceItems()"><i class="fa fa-save fa-fw"></i> SAVE</button>
        </div>
    </div>
</div>

    
<script type="text/javascript">

   
    function editPayrollItems()
    {
        var accountTitle = $('#editPayAccountTitle').val();
        var debitTo = $('#editPayDebitTo').val();
        var creditTo = $('#editPayCreditTo').val();
        var finItemId = $('#payItem_id').val();
        var url = "<?php echo base_url().'accountingsystem/editPayrollItems' ?>"
        
        $.ajax({
            type: "POST",
            url: url,
           // dataType:'json',
            beforeSend: function (){
                $('#editFinItemWrapper').html('<i style="color:#F70000" class="fa fa-5x fa-spinner fa-spin fa-fw" ></i>');
            },
            data: 'accountTitle='+accountTitle+'&debitTo='+debitTo+'&creditTo='+creditTo+'&payItemId='+finItemId+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {  
                  alert(data)
                  location.reload();
            }
        });
    }
   
    function editFinanceItems()
    {
        var accountTitle = $('#editAccountTitle').val();
        var debitTo = $('#editDebitTo').val();
        var creditTo = $('#editCreditTo').val();
        var finItemId = $('#finItem_id').val();
        var url = "<?php echo base_url().'accountingsystem/editFinanceItems' ?>"
        
        $.ajax({
            type: "POST",
            url: url,
           // dataType:'json',
            beforeSend: function (){
                $('#editFinItemWrapper').html('<i style="color:#F70000" class="fa fa-5x fa-spinner fa-spin fa-fw" ></i>');
            },
            data: 'accountTitle='+accountTitle+'&debitTo='+debitTo+'&creditTo='+creditTo+'&finItemId='+finItemId+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data)
            {  
                  alert(data)
                  location.reload();
            }
        });
    }
    
</script>