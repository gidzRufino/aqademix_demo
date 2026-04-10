<style>
    .default-wrapper {
        position: relative;
    }

    .default-wrapper .default-input {
        width: 100%;
        min-width: 80px;
        padding: 2px 6px;
        font-size: 0.8rem;
    }

    .default-wrapper .default-text {
        display: inline-block;
        min-width: 80px;
    }
</style>
<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h4 class="fw-bold mb-0">
            <i class="fa fa-cogs text-primary me-2"></i>
            Customized Payroll Settings
        </h4>

        <div class="btn-group">
            <button class="btn btn-primary"
                onclick="document.location='<?php echo base_url('hr/payroll/create') ?>'">
                <i class="fa fa-plus me-1"></i> Create Payroll
            </button>

            <button class="btn btn-outline-secondary dropdown-toggle"
                data-bs-toggle="dropdown">
                Items
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item" href="#" onclick="$('#addItems').modal('show')">
                        <i class="fa fa-plus-circle me-2"></i> Add Payroll Items
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="#" onclick="generatePayrollProfile()">
                        <i class="fa fa-refresh me-2"></i> Generate Payroll Profile
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <div class="row g-4">

        <!-- PAYROLL ITEMS -->
        <div class="col-lg-6 col-md-12">

            <div class="card shadow-sm border-0">

                <!-- Header -->
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fa fa-list-alt text-primary me-2"></i>
                        Payroll Items
                    </h5>

                    <span class="badge bg-primary">
                        <?php
                        $items = Modules::run('hr/payroll/getPayrollItems', 1);
                        echo count($items); ?> Items
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table table-borderless table-hover align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">#</th>

                                    <th>
                                        <i class="fa fa-tag text-muted me-1"></i>
                                        Item Name
                                    </th>

                                    <th>
                                        <i class="fa fa-layer-group text-muted me-1"></i>
                                        Type
                                    </th>

                                    <th>
                                        <i class="fa fa-cog text-muted me-1"></i>
                                        Default Value
                                    </th>

                                    <th class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $n = 1;
                                $items = Modules::run('hr/payroll/getPayrollItems', 1);

                                foreach ($items as $i):
                                ?>

                                    <tr class="border-bottom">

                                        <td class="text-center text-muted fw-semibold">
                                            <?php echo $n++ ?>
                                        </td>

                                        <!-- Item Name -->
                                        <td>
                                            <div class="fw-semibold text-dark">
                                                <?php echo $i->pi_item_name ?>
                                            </div>
                                        </td>

                                        <!-- Type -->
                                        <td>
                                            <?php if ($i->pi_item_type == 0): ?>

                                                <span class="badge bg-danger-subtle text-danger px-2 py-2 rounded-pill">
                                                    <i class="fa fa-minus-circle me-1"></i>
                                                    Deduction
                                                </span>

                                            <?php else: ?>

                                                <span class="badge bg-success-subtle text-success px-2 py-2 rounded-pill">
                                                    <i class="fa fa-plus-circle me-1"></i>
                                                    Additional Income
                                                </span>

                                            <?php endif; ?>
                                        </td>

                                        <!-- Default -->
                                        <td class="text-center default-cell">
                                            <div class="d-inline-block default-wrapper">
                                                <span class="badge bg-light text-dark border px-2 py-2 default-text">
                                                    <?php echo $i->pi_default ?>
                                                </span>
                                                <input type="text"
                                                    class="form-control form-control-sm default-input d-none text-center"
                                                    value="<?php echo $i->pi_default ?>">
                                            </div>
                                        </td>

                                        <!-- Action -->
                                        <td class="text-center">
                                            <!-- Edit -->
                                            <span class="badge bg-primary me-1 edit-btn"
                                                style="cursor:pointer;"
                                                onclick="editItem(this)">
                                                <i class="fa fa-edit"></i>
                                            </span>

                                            <!-- Save -->
                                            <span class="badge bg-success me-1 save-btn d-none"
                                                style="cursor:pointer;"
                                                onclick="saveItem(this,'<?php echo base64_encode($i->esk_payroll_items_code) ?>')">
                                                <i class="fa fa-check"></i>
                                            </span>

                                            <!-- Cancel -->
                                            <span class="badge bg-secondary me-1 cancel-btn d-none"
                                                style="cursor:pointer;"
                                                onclick="cancelEdit(this)">
                                                <i class="fa fa-times"></i>
                                            </span>

                                            <!-- Delete -->
                                            <span class="badge bg-danger delete-btn"
                                                style="cursor:pointer;"
                                                onclick="deleteItem('<?php echo base64_encode($i->esk_payroll_items_code) ?>')">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>


        <!-- SSS CONTRIBUTION -->
        <div class="col-lg-6 col-md-12">
            <?php echo Modules::run('hr/payroll/fetchSSSTable'); ?>
        </div>

    </div>

</div>

<div id="setStatBen" style="width:25%; margin: 50px auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <?php foreach ($salaryGrade as $sg): ?>
                        <option value="<?php echo $sg->sg; ?>"><?php echo number_format($sg->salary, 2, '.', ','); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputDate">Select Statutory Benefit</label>
                <select tabindex="-1" id="selectStatBen" name="selectStatBen" class="col-lg-12 no-padding">
                    <option>Select Statutory Benefit</option>
                    <?php foreach ($defaultDeductions as $deductions): ?>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#selectSalary').select2();
        $('#fromDate').datepicker({
            orientation: "left"
        });
        $('#toDate').datepicker({
            orientation: "left"
        });

    });

    function deleteItem(id) {
        if (confirm("Are you sure you want to delete this payroll item?")) {
            $.ajax({
                type: 'GET',
                url: '<?= base_url() . 'hr/payroll/deletePayrollItems/' ?>' + id,
                data: 'id=' + id,
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        alert(response.msg);
                        location.reload();
                    }
                }
            });
        }
    }

    function editItem(el) {

        let row = $(el).closest('tr');

        let badge = row.find('.default-text');
        let input = row.find('.default-input');

        input.width(badge.outerWidth());

        badge.addClass('d-none');
        input.removeClass('d-none').focus();

        row.find('.edit-btn').addClass('d-none');
        row.find('.save-btn').removeClass('d-none');
        row.find('.cancel-btn').removeClass('d-none');
        row.find('.delete-btn').addClass('d-none');

    }

    function cancelEdit(el) {

        let row = $(el).closest('tr');

        row.find('.default-input').addClass('d-none');
        row.find('.default-text').removeClass('d-none');

        row.find('.edit-btn').removeClass('d-none');
        row.find('.save-btn').addClass('d-none');
        row.find('.cancel-btn').addClass('d-none');

        // Show delete button
        row.find('.delete-btn').removeClass('d-none');

    }

    function saveItem(el, id) {

        let row = $(el).closest('tr');
        let value = row.find('.default-input').val();

        $.ajax({
            url: "<?php echo base_url('hr/payroll/updateDefaultValue') ?>",
            method: "POST",
            dataType: 'json',
            data: {
                id: id,
                value: value,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(d) {

                row.find('.default-text').text(value);

                row.find('.default-input').addClass('d-none');
                row.find('.default-text').removeClass('d-none');

                row.find('.edit-btn').removeClass('d-none');
                row.find('.save-btn').addClass('d-none');
                row.find('.cancel-btn').addClass('d-none');

                // Show delete again
                row.find('.delete-btn').removeClass('d-none');

            }
        });

    }

    function generatePayrollProfile() {
        var url = "<?php echo base_url() . 'hr/payroll/generatePayrollProfile/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: {
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                alert('Successfully Generated')
            }
        });

        return false; // avoid to execute the actual submit of the form
    }

    function generatePayroll(pType) {
        var fromdate = $('#option_' + pType).attr('from');
        var todate = $('#option_' + pType).attr('to');
        var url = "<?php echo base_url() . 'hr/payroll/generatePayrollReport/' ?>" + pType; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: {
                fromDate: fromdate,
                toDate: todate,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                $('#consolidatedPayroll').html(data);
            }
        });

        return false; // avoid to execute the actual submit of the form
    }

    function generateCode() {
        var fromdate = $('#fromDate').val();
        var todate = $('#toDate').val();

        var d1 = fromdate.split('-');
        var d2 = todate.split('-');

        var pc_code = d1[2] + d2[2] + d1[0] + d2[1]
        $('#pc_code').val(pc_code)
    }

    function setStatBen() {
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
                amount: amount,
                ddDate: ddDate,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                alert(response);
                $('#addItems').modal('hide')
            }

        });
    }

    function addItems() {
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
                itemCat: (type == 1 ? 1 : cat),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                alert(response);
                $('#addItems').modal('hide')
            }

        });
    }

    function saveShifts(group_id) {
        var inputShiftings = $('#inputShiftings').val();
        var ps_from = $('#shift_' + inputShiftings).attr('ps_from');
        var ps_to = $('#shift_' + inputShiftings).attr('ps_to');

        var url = "<?php echo base_url() . 'hr/payroll/saveShifts/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                shift_id: inputShiftings,
                group_id: group_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                $('#time_in_td_' + group_id).html(ps_from);
                $('#time_out_td_' + group_id).html(ps_to);
                $('#time_in_td_' + data.group_id).html(data.ps_from);
                $('#time_out_td_' + data.group_id).html(data.ps_to);
            }
        });
        return false;
    }

    var types = 0;

    function selectPayType(type) {
        if (type == 1 || type == 2) {
            $('#secondPay_wrapper').hide();
            $('#firstPay_title').html('Pay Day:');
        }
        if (type == 0) {
            $('#firstPay_title').html('First Payday:');
            $('#secondPay_wrapper').show();
        }
        types = type
    }

    function editTime(id, time_in, time_out) {
        if ($('#timeBtn_' + id).hasClass('saveBtn')) {
            $('#timeBtn_' + id).addClass('fa-pencil-square-o');
            $('#timeBtn_' + id).removeClass('saveBtn');
            $('#timeBtn_' + id).removeClass('fa-save');
            $('#time_in_td_' + id).removeClass('CellEditing');
            $('#time_in_td_' + id).html($('#time_in_td_' + id + ' input').val());
            $('#time_out_td_' + id).removeClass('CellEditing');
            $('#time_out_td_' + id).html($('#time_out_td_' + id + ' input').val());
        } else {
            $('#time_in_td_' + id).addClass('CellEditing');
            $('#time_in_td_' + id).html("<input type='text' style='height:30px; text-align:center' value='" + time_in + "' />");
            $('#time_out_td_' + id).addClass('CellEditing');
            $('#time_out_td_' + id).html("<input type='text' style='height:30px; text-align:center' value='" + time_out + "' />");

            $('#timeBtn_' + id).addClass('saveBtn');
            $('#timeBtn_' + id).removeClass('fa-pencil-square-o');
            $('#timeBtn_' + id).addClass('fa-save');
        }


    }

    function savePayType() {
        var pk = '<?php echo base64_encode('id') ?>';
        var table = '<?php echo base64_encode('profile_employee_paymentSchedule') ?>';
        var pk_id = 1
        var column = 'monthly'
        var value = types
        var id

        updateProfile(pk, table, pk_id, column, value, '')
    }

    function updateProfile(pk, table, pk_id, column, value, id) {
        var url = "<?php echo base_url() . 'users/editProfile/' ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: 'id=' + pk_id + '&column=' + column + '&value=' + value + '&tbl=' + table + '&pk=' + pk + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                //$("form#quoteForm")[0].reset()
                $('#a_' + id).show()
                $('#' + id).hide()
                $('#a_' + id).html(data.msg)

            }
        });

        return false; // avoid to execute the actual submit of the form.
    }

    $(function() {
        $('.editable').dblclick(function() {
            var OriginalContent = $(this).text();
            var id = $(this).attr('id');
            var url = '<?php echo base_url() . 'hr/payroll/updateSSContTable' ?>';
            var color = '';
            $(this).addClass("cellEditing");
            $(this).html("<input  type='text' style='text-align:center; width: 100%' value='" + OriginalContent + "' />");
            $(this).children().first().focus();
            $(this).children().first().keypress(function(e) {
                if (e.which == 13) {
                    var newContent = $(this).val();
                    if (!isNaN(newContent)) {
                        $(this).parent().text(Number(newContent).toFixed(2));
                        $(this).parent().removeClass("cellEditing");

                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: 'id=' + id + '&value=' + newContent + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                            dataType: 'json',
                            success: function(data) {
                                $('#errSSS').fadeIn();
                                color = (data.status ? 'green' : 'red');
                                $('#errSSS').html('<b style="color: ' + color + '">' + data.msg + '</b>');
                                setTimeout(function() {
                                    $('#errSSS').fadeOut();
                                }, 3000);
                            }
                        })
                    } else {
                        $(this).children().first().focus();
                        $('#errSSS').show();
                        $('#errSSS').html('<b style="color: red">Please Enter a Valid Number</b>');
                        setTimeout(function() {
                            $('#errSSS').fadeOut();
                        }, 3000);
                    }
                }
            })
        })
    })
</script>