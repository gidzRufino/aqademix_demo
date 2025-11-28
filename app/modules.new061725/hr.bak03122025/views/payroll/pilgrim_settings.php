<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Customized Payroll Settings
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('hr/payroll') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('hr/payroll/create') ?>'">Create Payroll</button>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Items</button>
                <ul class="dropdown-menu dropdown-menu-right">
                  <li onclick="$('#addItems').modal('show')"><a href="#">Add Payroll Items</a></li>
                  <!--<li onclick="$('#setStatBen').modal('show')"><a href="#">Set Statutory Deductions</a></li>-->
                  <li onclick="generatePayrollProfile()"><a href="#">Generate Payroll Profile</a></li>
                </ul>
            </div>
          </div>
    </h3>
</div>
<div class="col-lg-12">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <div class="panel panel-red">
            <div class="panel-heading">
                <span>Payroll Items</span>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Item Type</th>
                        <th>Item Category</th>
                        <th>Default</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                        $n=1;
                        $items = Modules::run('hr/payroll/getPayrollItems', 1);
                        foreach($items as $i):
                            
                            switch ($i->pi_item_cat):
                                case 0:
                                    $cat = 'Statutory Deductions';
                                break;    
                                case 1:
                                    $cat = 'Others';
                                break;    
                                case 2:
                                    $cat = 'Amortized ';
                                break;    
                            endswitch;
                    ?>
                    <tr>
                        <td><?php echo $n++ ?></td>
                        <td><?php echo $i->pi_item_name ?></td>
                        <td><?php echo ($i->pi_item_type==0?'Deduction':($i->pi_item_type==2?'Deduction':'Additional Income')) ?></td>
                        <td><?php echo $cat; ?></td>
                        <td><?php echo $i->pi_default; ?></td>
                        <td><button class="btn btn-warning"><i class="fa fa-edit"></i></button></td>
                    </tr>
                    <?php
                        endforeach;
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>



<div id="setStatBen"  style="width:25%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-info" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span id="addEdHisTitle">Set Statutory Benefits</span>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <label class="control-label" for="inputDate">Select Salary</label>
                    <select tabindex="-1" id="selectSalary" name="selectSalary" class="col-lg-12 no-padding">
                        <option>Select Salary</option>
                        <?php foreach($salaryGrade as $sg): ?>
                            <option value="<?php echo $sg->sg; ?>"><?php echo number_format($sg->salary, 2, '.', ','); ?></option>
                        <?php endforeach; ?>
                   </select>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputDate">Select Statutory Benefit</label>
                    <select tabindex="-1" id="selectStatBen" name="selectStatBen" class="col-lg-12 no-padding">
                        <option>Select Statutory Benefit</option>
                        <?php foreach($defaultDeductions as $deductions):?>
                            <option value="<?php echo $deductions->pi_item_id; ?>"><?php echo $deductions->pi_item_name ?></option>
                        <?php endforeach; ?>
                   </select>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="inputDate">Amount</label>
                <div class="controls">
                    <input name="amount" class="form-control" type="text" id="amount" />
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="inputDate">Deduction Date</label>
                <div class="controls">
                    <input name="ddDate" class="form-control" type="text" id="ddDate" />
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="control-group">
                <button onclick="setStatBen()" class="btn btn-block btn-success">ADD</button>
            </div>
        </div>
    </div>
</div>
<div id="addItems"  style="width:25%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-success" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span id="addEdHisTitle">Set Payroll Items</span>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <label class="control-label" for="inputDate">Item Name</label>
                <div class="controls">
                    <input name="itemName" class="form-control" type="text" id="itemName" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputDate">Item Type</label>
                
                    <select tabindex="-1" id="itemType" name="itemType" class="form-control">
                        <option>Select Item Type</option>
                        <option onclick="$('#odWrapper').show()" value="0">Deduction</option>
                        <option onclick="$('#odWrapper').hide()" value="1">Additional Income</option>
                   </select>
            </div>
            <div class="control-group" id="odWrapper" style="display:none;">
                <label class="control-label" for="inputDate">Item Category</label>
                    <select tabindex="-1" id="itemCat" name="itemCat" class="form-control">
                        <option>Select Category</option>
                        <option onclick="$('#ddWrapper').show()" value="0">Statutory</option>
                        <option onclick="$('#ddWrapper').hide()" value="1">Other Deductions</option>
                        <option onclick="$('#odWrapper').show()" value="2">Amortized Deduction</option>
                   </select>
            </div>
            <input type="hidden" id="pc_code" />
        </div>
        <div class="panel-footer">
            <div class="control-group">
                <button onclick="addItems()" class="btn btn-block btn-success">ADD</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    
    $(document).ready(function(){
        $('#selectSalary').select2();
        $('#fromDate').datepicker({
            orientation: "left"
        });
        $('#toDate').datepicker({
            orientation: "left"
        });
        
    });
    
        
    function generatePayrollProfile()
    {
        var url = "<?php echo base_url().'hr/payroll/generatePayrollProfile/' ?>"; // the script where you handle the form input.
        $.ajax({
           type: "POST",
           url: url,
            data: {
            csrf_test_name: $.cookie('csrf_cookie_name')
            },
           success: function(data)
           {
               alert('Successfully Generated')
           }
         });

        return false; // avoid to execute the actual submit of the form
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
           success: function(data)
           {
               //$("form#quoteForm")[0].reset()
               $('#consolidatedPayroll').html(data);
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
    
    function setStatBen()
    {
        var salary = $('#selectSalary').val();
        var statBen = $('#selectStatBen').val();
        var amount = $('#amount').val();
        var ddDate = $('#ddDate').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'hr/payroll/setStatBen' ?>',
            //dataType: 'json',
            data: {
                salary_grade: salary,
                statBen: statBen,
                amount:amount,
                ddDate:ddDate,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                $('#addItems').modal('hide')
            }

        });
    }
    
    function addItems()
    {
        var name = $('#itemName').val();
        var type = $('#itemType').val();
        var cat = $('#itemCat').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'hr/payroll/addPayrollItems' ?>',
            //dataType: 'json',
            data: {
                itemName: name,
                itemType: type,
                itemCat:(type==1?1:cat),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function (response) {
                alert(response);
                $('#addItems').modal('hide')
            }

        });
    }
</script>


