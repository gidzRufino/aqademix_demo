<!--
  Database Additions:
    Nulled all values on esk_coop_transaction
    pa_coop_trans_type column on esk_payroll_amort_charges table
 -->
<div class="panel row">
    <div class="form-group col-lg-8" id='searchBox' style="margin-top:10px;">
        <div class="col-lg-12 row">
            <div class="col-lg-6 row">
                <div class="controls">
                        <input autocomplete="off"  class="form-control" onkeypress="searchTeacher(this.value)"  name="searchTeacher" type="text" id="searchTeacher" placeholder="Search Teacher's Family Name" required>
                        <input type="hidden" id="teacher_id" name="teacher_id" value="0" />
                    </div>
                <div style="min-height: 30px; background: #FFF; width:230px; position:absolute; z-index: 2000; display: none;" class="resultOverflow" id="teacherSearch">

                </div>
                <input type="hidden" id="employeeID" />
            </div>
        </div>
        <div class="panel panel-default col-lg-6" style="margin-top:10px;">
            <div class="panel-body row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-group-text">Transaction Type:</label>
                        <select id="transType">
                            <option value="none">Select Transaction</option>
                            <?php foreach($transactions AS $tr): ?>
                                <option id="optiontrans_<?php echo $tr->ctt_id; ?>" value="<?php echo $tr->ctt_id; ?>" shorts="<?php echo $tr->ctt_short_code ?>"><?php echo $tr->ctt_type." (".$tr->ctt_short_code.")"; ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div id="regularLoans">
                    <div class="col-lg-12">
                        <div class="form-group col-lg-6">
                            <label class="form-group-text">Amount:</label>
                            <input class="form-control" placeholder="Amount" id="transAmount" />
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="checkbox" id="transRecur" style="margin-top: 25px;" /> Recurring?
                        </div>
                    </div>
                    <div class="col-lg-12" id="tranSchedBox">
                        <div class="form-group">
                            <label class="form-group-text">Payroll Schedule</label>
                            <select id="transSched">
                                <option value="none">Select Schedule</option>
                                <option value="0">Every Payroll</option>
                                <option value="1">1st Payroll</option>
                                <option value="2">2nd Payroll</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="loanPayments">
                    <div class="col-lg-12">
                        <div class="form-group col-lg-6">
                            <label class="form-group-text">Total Amount:</label>
                            <input class="form-control" placeholder="Total Amount" id="totalLoanAmount" />
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="form-group-text">Amount:</label>
                            <input class="form-control" placeholder="Amount" id="loanPaymentAmount" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group pull-right">
                <button class="btn btn-success" id="saveTransaction">Save</button>
            </div>
        </div>
    </div>
    <div class="form-group pull-right" style="margin:10px 0;">
        <select onclick="" tabindex="-1" id="payPeriod" name="payPeriod" style="width:300px;">
            <option value="none">Select Payroll Period</option>
           <?php foreach($payrollPeriod as $pp): ?>
                <option id="option_<?php echo $pp->per_id ?>" from="<?php echo $pp->per_from ?>" to="<?php echo $pp->per_to ?>" value="<?php echo $pp->per_id ?>" <?php echo ($payPeriod==$pp->per_id) ? 'selected' : ''; ?>><?php echo date('F d, Y', strtotime($pp->per_from)).' - '.date('F d, Y', strtotime($pp->per_to)); ?></option>
           <?php endforeach; ?>
       </select>
    </div>
</div>
<div class="panel panel-default" id="transactionsTable">
    <div class="panel-heading">
        <button type="button" class="btn btn-danger btn-sm pull-right"><i class="fa fa-print fa-sm"></i></button>
        <h4>Deduction for the Month of <span id="payPeriodMonth">June</span></h4>
    </div>
    <table class="table table-striped text-center" id="transTable">
        <thead id="transTableHead">
        </thead>
        <tbody id="transTableBody">
        </tbody>
    </table>
</div>
<script>

    $("#transType").change(function(){
        var id = $(this).val(), short = $("#optiontrans_"+id).attr('shorts');
        if(short.localeCompare("LP") == 0){
            $("#regularLoans").hide();
            $("#loanPayments").show();
            $("#totalLoanAmount").val('');
            $("#loanPaymentAmount").val('');
            $("#transSched").val('');
            $("#transRecur").val('');
            $("#transAmount").val('');
        }else{
            $("#loanPayments").hide();
            $("#regularLoans").show();
            $("#totalLoanAmount").val('');
            $("#loanPaymentAmount").val('');
            $("#transSched").val('');
            $("#transRecur").val('');
            $("#transAmount").val('');
        }
    });

    function setPayrollModal(user_id, amount){
        console.info(user_id)
        console.log(amount)
    }

    function getMonth(monthId){
        switch(monthId){
            case 0: return "January"; break;
            case 1: return "February"; break;
            case 2: return "March"; break;
            case 3: return "April"; break;
            case 4: return "May"; break;
            case 5: return "June"; break;
            case 6: return "July"; break;
            case 7: return "August"; break;
            case 8: return "September"; break;
            case 9: return "October"; break;
            case 10: return "November"; break;
            case 11: return "December"; break;
        }
    }

    $("#saveTransaction").click(function(){
        var employee = $("#employeeID").val(), transType = $("#transType").val(), totalAmount = $("#totalLoanAmount").val(),amount = $("#transAmount").val(), loanPayment = $("#loanPaymentAmount").val(), recurring = $("#transRecur").prop("checked"), transSched = "none", pc_code = $("#payPeriod").val(), short = $("#optiontrans_"+transType).attr('shorts');;
        if(pc_code == "none"){
            pc_code = null;
        }
        if(employee != ""){
            if(recurring == true){
                transSched = $("#transSched").val();
                if(transSched.localeCompare("none") == 0){
                    alert("You have not selected a schedule yet");
                }else{
                    $.ajax("<?php echo site_url('coopmanagement/saveTransactions'); ?>",{
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            id: employee,
                            type: transType,
                            totalAmount: totalAmount,
                            loanPayment: loanPayment,
                            amount: amount,
                            schedule: transSched,
                            pc_code: pc_code,
                            recurring: true,
                            csrf_test_name: $.cookie('csrf_cookie_name')
                        },
                        success: function(data){
                            if(data.message == "success"){
                                setTransactionTypes(pc_code);
                            }else{
                                alert("An error, occured. Try again");
                            }
                        }
                    });
                }
            }else{
                transSched = "none"
                $.ajax("<?php echo site_url('coopmanagement/saveTransactions'); ?>",{
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        id: employee,
                        type: transType,
                        totalAmount: totalAmount,
                        loanPayment: loanPayment,
                        schedule: transSched,
                        amount: amount,
                        pc_code: pc_code,
                        recurring: false,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function(data){
                        if(data.message == "success"){
                            setTransactionTypes(pc_code);
                        }else{
                            alert("An error, occured. Try again");
                        }
                    }
                });
            }
        }else{
            alert("Select a teacher before applying amounts");
        }
    });

    $("#payPeriod").change(function(){
        var val = $(this).val(), option = $("#option_"+val);
        setTransactionTypes(option.val());
    });

    $("#transRecur").change(function(){
        var checked = $(this).prop("checked");
        if(checked == true){
            $("#tranSchedBox").show();
        }else{
            $("#tranSchedBox").hide();
        }
    });

    function setTransactionTypes(pc_code){
        $.ajax('<?php echo site_url('coopmanagement/fetchTransactionTypes'); ?>', {
            type: "POST",
            dataType: "JSON",
            data:{
                pc_code: pc_code,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data){
                $("#transTableHead").html(data.data);
                getAllTransactions(pc_code);
                var val = $("#payPeriod").val(), option = $("#option_"+val), month = new Date(option.attr('from')).getMonth();
                $("#payPeriodMonth").html(getMonth(month));
            }
        });
    }

function getAllTransactions(pc_code){
    $.ajax("<?php echo site_url('coopmanagement/fetchCoopTransactionees'); ?>",{
        type: "POST",
        dataType: "JSON",
        data: {
            pc_code: pc_code,
            csrf_test_name: $.cookie('csrf_cookie_name')
        },
        success: function(data){
            $("#transTableBody").html(data.data);
        }
    });
}

    $(document).ready(function(){
        $("#payPeriod").select2();
        $("#tranSchedBox").hide();
        $("#loanPayments").hide();
        setTransactionTypes($("#payPeriod").val());
    });

    function searchTeacher(value)
    {
        var url = "<?php echo base_url().'coopmanagement/teacherSearch/'?>";
        if(value==""){
              $('#citySearch').hide();
              $('#cityId').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   beforeSend: function() {
                            $('#teacherSearch').show();
                            $('#teacherSearch').html('<i class="fa fa-spinner fa-spin fa-fw text-center" ></i>')
                        },
                   success: function(data)
                   {
                       $('#teacherSearch').show();
                       $('#teacherSearch').html(data);
                   }
                 });

            return false;
          }
    }
</script>
