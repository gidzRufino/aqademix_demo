<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Create Payroll
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('hr/payroll') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="$('#createPay').modal('show')">Set Payroll Period</button>
            <button type="button" class="btn btn-default" onclick="$('#amTransaction').modal('show')">View Payroll</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('hr/payroll/settings') ?>'">Payroll Settings</button>
            <button class="btn btn-default" onclick="printPayroll()"><i class="fa fa-print"></i></button>
            <button class="btn btn-default" onclick="exportPayroll()"><i class="fa fa-external-link"></i></button>
          </div>
    </h3>
</div>
<div class="col-lg-12">
    <div class="form-group pull-right">
        <select onclick="generatePayroll(this.value)" tabindex="-1" id="payPeriod" name="payPeriod" style="width:300px;">
            <option>Select Payroll Period</option>
           <?php foreach($payrollPeriod as $pp): ?>
                <option id="option_<?php echo $pp->per_id ?>" from="<?php echo $pp->per_from ?>" to="<?php echo $pp->per_to ?>" value="<?php echo $pp->per_id ?>"><?php echo date('F d, Y', strtotime($pp->per_from)).' - '.date('F d, Y', strtotime($pp->per_to)); ?></option>
           <?php endforeach; ?>

       </select>
    </div>
</div>
<div id="consolidatedPayroll" class="col-lg-12">
    
</div>

<div id="addCharges"  style="width:25%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span id="addEdHisTitle">Add Additional Income / Deductions</span>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <label class="control-label" for="inputDate">Select Item</label>
                
                    <select tabindex="-1" id="item" name="item" class="form-control">
                        <option>Select Item</option>
                        <?php 
                        $items = Modules::run('hr/payroll/getPayrollItems', 1);
                        foreach($items as $i):?>
                            <option value="<?php echo $i->pi_item_id ?>"><?php echo $i->pi_item_name ?></option>
                        <?php
                        endforeach;
                        ?>
                   </select>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputDate">Amount</label>
                <div class="controls">
                    <input name="amount" class="form-control" type="text" id="amount" />
                </div>
            </div> 
            <input type="hidden" id="em_id" />
            <input type="hidden" id="item_pc_code" />
        </div>
        <div class="panel-footer">
            <div class="control-group">
                <button onclick="addDeduction()" class="btn btn-block btn-success">ADD</button>
            </div>
        </div>
    </div>
</div>


<div id="createPay"  style="width:25%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span id="addEdHisTitle">Set Payroll Period</span>
        </div>
        <div class="panel-body">
            <div class="control-group col-lg-6">
                <label class="control-label" for="inputDate">From Date</label>
                <div class="controls">
                    <input name="fromDate" type="text" id="fromDate" data-date-format="yyyy-mm-dd" placeholder="Date" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="control-group col-lg-6">
                <label class="control-label" for="inputDate">To Date</label>
                <div class="controls">
                    <input name="toDate" type="text" id="toDate" data-date-format="yyyy-mm-dd" placeholder="Date" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <input type="hidden" id="pc_code" />
        </div>
        <div class="panel-footer">
            <div class="control-group">
                <button onmouseover="generateCode()" onclick="setPayRoll()" class="btn btn-block btn-success">Set</button>
            </div>
        </div>
    </div>
</div>

<div id="viewDTR" data-backdrop="static" style="width:50%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span id="viewDTR">Edit DTR</span>
        </div>
        <div class="panel-body" id="dtrBody">
            
        </div>
    </div>
</div>

<div id="editDTR"  style="width:25%; margin: 10% auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span>Enter Time to Edit</span>
        </div>
        <div class="panel-body" id="bodyid">
            <div class='col-lg-12 form-group'>
                <b>Select Time </b><br />
                <div class="pull-left">
                    <select id='hr' style='width:50px;'>
                        <?php
                        for ($i=1; $i<=12; $i++)
                        {
                            if($i<10)
                            {
                                $i='0'.$i;
                            }
                        ?>
                        <option value='<?php echo $i ?>'><?php echo $i ?></option>
                        <?php } ?>
                    </select> :  
                    <select id='min' style='width:50px;'>
                        <?php
                        for ($i=0; $i<=60; $i++)
                        {
                            if($i<10)
                            {
                                $i='0'.$i;
                            }
                        ?>
                        <option value='<?php echo $i ?>'><?php echo $i ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <div class='pull-right'>
                <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right'>Cancel</button>&nbsp;&nbsp;
                <a href='#' data-dismiss='clickover' onclick='saveTimeData()' style='margin-right:10px;' class='btn btn-xs btn-success pull-right'>Save</a>
           </div>
        </div>
    </div>
</div>    



<input type="hidden" id="att_id" />
<input type="hidden" id="rowCol_id" />



<script type="text/javascript">
    
    $(document).ready(function(){
        $('#payPeriod').select2();
        $('#fromDate').datepicker({
            orientation: "left"
        });
        $('#toDate').datepicker({
            orientation: "left"
        });
        
        $('#item').click(function(){
            var item = $(this).val();
            var value = 0;
            var netPay = $('#totalNetIncome').val();
            
            switch(item){
                case '2':
                    value = parseFloat(netPay) * parseFloat(.01375);
                break;    
                case '3':
                    value = parseFloat(netPay) * parseFloat(.02);
                break
            }
            //  alert(netPay)
            $('#amount').val(value.toFixed(2));
        })
    });
    
    function exportPayroll()
    {
        var pc_code = $('#payPeriod').val();
        var fromdate = $('#option_'+pc_code).attr('from');
        var todate = $('#option_'+pc_code).attr('to');
        var url = '<?php echo base_url('hr/payroll/payrollToExcel/') ?>'+fromdate+'/'+todate+'/'+pc_code;
        
        window.open(url,'_blank');
    }
    
    function printPayroll()
    {
        var pc_code = $('#payPeriod').val();
        var fromdate = $('#option_'+pc_code).attr('from');
        var todate = $('#option_'+pc_code).attr('to');
        var url = '<?php echo base_url('hr/payroll/printPayroll/') ?>'+fromdate+'/'+todate+'/'+pc_code;
        
        window.open(url,'_blank');
    }
    
    function editTimeData(att_id, rowCol_id)
    {
        
        $('#att_id').val(att_id);
        $('#rowCol_id').val(rowCol_id);
        $('#editDTR').modal('show')
        //alert(att_id);
    }
    
    function saveTimeData()
    {
        var pc_code = $('#payPeriod').val();
        var fromdate = $('#option_'+pc_code).attr('from');
        var todate = $('#option_'+pc_code).attr('to');
        var owners_id = $('#owners_id').val();
        var att_id = $('#att_id').val();
        var rowCol_id = $('#rowCol_id').val();
        
        var hour = $('#hr').val();
        var min = $('#min').val();
        
        var url = "<?php echo base_url().'hr/editHrTime/'?>";
        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: 'att_id='+att_id+'&hour='+hour+'&min='+min+'&time_option='+rowCol_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function(data)
               {
                   
                   $('#editDTR').modal('hide')
                   getDateFrom(fromdate, todate, owners_id)
               }
        })
    }
        
    function generatePayroll(pType)
    {
        var fromdate = $('#option_'+pType).attr('from');
        var todate = $('#option_'+pType).attr('to');
        
        var url = "<?php echo base_url().'hr/payroll/generatePayrollReport/' ?>"+pType; // the script where you handle the form input.
        $.ajax({
           type: "POST",
           url: url,
            data: {
            fromDate: fromdate,
            toDate: todate,
            csrf_test_name: $.cookie('csrf_cookie_name')
           },
            
           beforeSend: function() {
                $('#consolidatedPayroll').html('<b class="text-center">Please Wait while Payroll is generating...</b>')
            },
           success: function(data)
           {
               //$("form#quoteForm")[0].reset()
               $('#consolidatedPayroll').html(data);
               getTotal();
           }
         });

        return false; // avoid to execute the actual submit of the form
    }
    
    function generateCode()
    {
        var fromdate = $('#fromDate').val();
        var todate = $('#toDate').val();
        
        var d1 = fromdate.split('-');
        var d2 = todate.split('-');
        
        var pc_code = d1[2]+d2[2]+d1[0]+d2[1]
        $('#pc_code').val(pc_code)
    }
    
    function addDeduction()
    {
        var item_id = $('#item').val();
        var amount = $('#amount').val();
        var pc_code = $('#item_pc_code').val();
        var em_id = $('#em_id').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'hr/payroll/addDeduction' ?>',
            //dataType: 'json',
            data: {
                item_id: item_id,
                amount: amount,
                pc_code:pc_code,
                em_id:em_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert('Successfully Added');
                $('#addCharges').modal('hide');
                //document.location = '<?php echo base_url('hr/payroll/view/') ?>'+pc_code
                generatePayroll($('#payPeriod').val())
            }

        });
    }
    
    function setPayRoll()
    {
        var fromdate = $('#fromDate').val();
        var todate = $('#toDate').val();
        var pc_code = $('#pc_code').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'hr/payroll/setPayrollPeriod' ?>',
            //dataType: 'json',
            data: {
                fromDate: fromdate,
                toDate: todate,
                pc_code:pc_code,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                $('#createPay').modal('hide')
            }

        });
    }
</script>


