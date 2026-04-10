<style>
    .modal-content {
        border-radius: 12px;
    }

    .modal-header {
        border-bottom: 1px solid #f1f1f1;
    }

    .modal-footer {
        border-top: 1px solid #f1f1f1;
    }

    .btn-success {
        box-shadow: 0 4px 10px rgba(25, 135, 84, 0.2);
    }

    .btn-success:hover {
        transform: translateY(-1px);
    }

    .modal-content {
        animation: fadeInUp 0.3s ease;
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .input-group>.form-select,
    .input-group>.btn {
        height: 100%;
    }

    .input-group {
        display: flex;
        align-items: stretch;
    }

    .input-group .btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="modal fade" id="generateBilling" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header bg-warning">
                <h5 class="modal-title">Generate Billing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Grade Level</label>
                    <select class="form-select" id="inputGrade" onchange="selectSection(this.value)">
                        <option>Select Grade Level</option>
                        <?php foreach ($gradeLevel as $level): ?>
                            <option value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Section</label>
                    <select class="form-select" id="inputSection" onclick="getClassCardCount(this.value)">
                        <option>Select Section</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Option</label>
                    <select class="form-select" id="pageID">
                        <option>Select Option</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Month</label>
                    <select class="form-select" id="inputMonthReport">
                        <option>Select Month</option>
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

            <div class="modal-footer">
                <button class="btn btn-success btn-sm" onclick="generateBilling()">Generate</button>
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="chequeEncashments" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Cheque Encashments</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" id="chequeDate" class="form-control" value="<?php echo date('Y-m-d') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bank</label>
                    <div class="d-flex gap-2">
                        <select class="form-select" id="enBank">
                            <option value="0">Select Bank</option>
                            <?php foreach ($getBanks as $b): ?>
                                <option value="<?php echo $b->fbank_id; ?>"><?php echo $b->bank_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-info btn-sm" onclick="new bootstrap.Modal(document.getElementById('addBank')).show();">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Cheque #</label>
                    <input type="text" id="chequeNumber" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Amount</label>
                    <input type="text" id="chequeAmount" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success btn-sm" onclick="saveEncashments()">Save</button>
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addBank" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header bg-warning">
                <h5 class="modal-title">Add Bank</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Bank Name</label>
                    <input type="text" id="bank" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Short Name</label>
                    <input type="text" id="bankShortName" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success btn-sm" onclick="addBank()">Save</button>
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addPlanToSchedule" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow">

            <!-- HEADER -->
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Add Finance Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <!-- Grade Level -->
                <div class="mb-3">
                    <label class="form-label">Select Grade Level</label>
                    <select id="gradeLevelPlan" class="form-select">
                        <option>Select Grade Level</option>
                        <?php foreach ($gradeLevel as $gl): ?>
                            <option value="<?php echo $gl->grade_id ?>">
                                <?php echo $gl->level ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Plan Type -->
                <div class="mb-3">
                    <label class="form-label">Select Type</label>
                    <div class="d-flex gap-2">

                        <select id="inputStudentType" class="form-select" required>
                            <?php
                            $plan_type = Modules::run('finance/getPlanType', $now);
                            foreach ($plan_type as $pt):
                            ?>
                                <option value="<?php echo $pt->fin_type_id ?>">
                                    <?php echo $pt->fin_plan_type ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button
                            class="btn btn-info btn-sm"
                            title="Add Plan Type"
                            onclick="new bootstrap.Modal(document.getElementById('addPlanType')).show();">
                            <i class="fa fa-plus"></i>
                        </button>

                    </div>
                </div>

                <!-- Plan Title -->
                <div class="mb-3">
                    <label class="form-label">Plan Title</label>
                    <input type="text" id="planTitle" class="form-control" placeholder="Enter plan title">
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button class="btn btn-success btn-sm" onclick="addToFeeSchedule()">
                    Save
                </button>
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>

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
            <a href='#' data-dismiss='modal' onclick='savePlanType()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-right'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-right' style="margin-right:10px;">Cancel</button>&nbsp;&nbsp;
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
            <a href='#' data-dismiss='modal' onclick='addItems()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>

<div class="modal fade" id="editFinItem" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content shadow">

            <!-- HEADER -->
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    Edit <span id="fin_desc"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <input type="hidden" id="charge_id" />

                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input
                        type="text"
                        id="edit_fin_amount"
                        class="form-control"
                        placeholder="Enter amount"
                        onclick="this.placeholder=this.value; this.value='';" />
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button
                    class="btn btn-success btn-sm"
                    onclick="editFinanceCharges()">
                    Save
                </button>
                <button
                    class="btn btn-secondary btn-sm"
                    data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="deleteFinCharges" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>
                    Are you sure you want to delete this finance item?
                    This action cannot be undone.
                </p>
                <input type="hidden" id="del_charge_id">
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" onclick="deleteFinanceCharges()">Delete</button>
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
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
                foreach ($collection->result() as $c):
                    $overAll += $c->amount;
                endforeach;
                ?>

                <h4 class="text-center">Total Cash Collection: ₱ <?php echo number_format($overAll, 2, '.', ',') ?></h4>

            </div>
            <div class="form-group">
                <?php $cashDen = Modules::run('finance/getCashDenomination');
                ?>
                <label>Cash Denomination</label> <br />
                <select name="inputCashDen" id="inputCashDen" class="col-lg-8 no-padding" required>
                    <option>Select Denomination</option>
                    <?php foreach ($cashDen as $cd): ?>
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
                    <div class="well well-sm">
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
            <a href='#' data-dismiss='modal' onclick="saveCashBreakDown()" style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>

    </div>

</div>

<div class="modal fade" id="editFinPlan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">

            <div class="modal-header">
                <h5 class="modal-title">Edit Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="finPlanID">

                <div class="mb-3">
                    <label class="form-label">Plan Name</label>
                    <input type="text" id="edit_fin_plan" class="form-control" placeholder="Enter Plan Name">
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" onclick="saveEditPlan()">Save Changes</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editFinTransaction" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">

        <div class="modal-content border-0 shadow rounded-4">

            <!-- 🔹 HEADER -->
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">
                    ✏️ Edit Finance Transaction
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- 🔹 BODY -->
            <div class="modal-body pt-2" id="editTransBody">

                <!-- dynamic content here -->

                <div class="text-center text-muted py-4" id="editLoading">
                    <div class="spinner-border spinner-border-sm"></div>
                    <div class="small mt-2">Loading transaction...</div>
                </div>

            </div>

            <!-- 🔹 FOOTER -->
            <div class="modal-footer border-0 pt-0 d-flex justify-content-between">

                <button type="button"
                    class="btn btn-light rounded-pill px-4"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button type="button"
                    class="btn btn-success rounded-pill px-4 shadow-sm"
                    onclick="saveEditTransaction()">
                    💾 Save Changes
                </button>

            </div>

        </div>

    </div>
</div>

<!-- Delete Finance Transaction Modal -->
<div class="modal fade" id="deleteFinTransaction" tabindex="-1" aria-labelledby="deleteFinTransactionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm"> <!-- modal-sm for smaller width -->
        <div class="modal-content border-danger">

            <!-- Modal Header -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteFinTransactionLabel">
                    <i class="fa fa-exclamation-triangle me-2"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="mb-3">
                    Are you sure you want to void this finance transaction? This action <strong>cannot be undone</strong>.
                    Please ensure you understand the consequences before proceeding.
                </p>

                <!-- Hidden Inputs -->
                <input type="hidden" id="delete_trans_id" />
                <input type="hidden" id="delete_item_id" />
                <input type="hidden" id="delete_trans_type" />
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="deleteFinanceTransaction()" data-bs-dismiss="modal">
                    <i class="fa fa-trash me-1"></i> Delete
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Transfer Finance Transaction Modal -->
<div class="modal fade" id="transferFinTransaction" tabindex="-1" aria-labelledby="transferFinTransactionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg for larger content -->
        <div class="modal-content border-success">

            <!-- Modal Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="transferFinTransactionLabel">
                    <i class="fa fa-exchange-alt me-2"></i> Transfer Funds to Another Item / Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" id="fundTransferBody">
                <!-- Dynamic content will be loaded here -->
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="processFundTransfer()" data-bs-dismiss="modal">
                    <i class="fa fa-paper-plane me-1"></i> Process Fund Transfer
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="refundTransaction" tabindex="-1" aria-labelledby="refundTransactionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">

        <div class="modal-content border-0 shadow rounded-3">

            <!-- HEADER -->
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-semibold" id="refundTransactionLabel">
                    <i class="fa fa-undo text-primary me-2"></i> Process Refund
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body px-4 py-3">

                <!-- Optional Info Banner -->
                <div class="alert alert-light border d-flex align-items-center mb-3">
                    <i class="fa fa-info-circle text-primary me-2"></i>
                    <small class="text-muted">Review the details before confirming the refund.</small>
                </div>

                <div id="refundTransBody">
                    <!-- Dynamic content here -->
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0 d-flex justify-content-between">

                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-success px-4 fw-semibold"
                    onclick="saveRefundTransaction()">
                    <i class="fa fa-check me-1"></i> Confirm Refund
                </button>

            </div>

        </div>
    </div>
</div>

<div id="cashRegister" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0 rounded-3">

            <!-- HEADER -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-semibold">
                    <i class="fa fa-cash-register me-2"></i> Cash Register
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <!-- TOP CONTROLS -->
                <div class="row g-3 mb-3 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Transaction Type</label>
                        <select id="inputTrType" name="inputTrType" class="form-select">
                            <option onclick="$('#chequeWrapper').slideUp(200)" value="0">Cash</option>
                            <option onclick="$('#chequeWrapper').slideDown(200)" value="1">Cheque</option>
                            <option onclick="$('#chequeWrapper').slideDown(200)" value="4">Online Payment</option>
                            <option onclick="$('#chequeWrapper').slideUp(200)" value="5">Other Payment</option>
                            <option onclick="$('#chequeWrapper').slideUp(200)" value="6">Payroll Deduction</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Receipt Type</label>
                        <select id="inputReceipt" name="inputReceipt" class="form-select">
                            <option value="0">Official Receipt</option>
                            <option value="1">Acknowledgment Receipt</option>
                            <option value="2">Temporary Receipt</option>
                        </select>
                    </div>

                </div>

                <!-- CHEQUE / ONLINE -->
                <div id="chequeWrapper" class="border rounded p-3 mb-3 bg-light" style="display:none;">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-6">
                            <label class="form-label">Bank</label>
                            <div class="input-group">
                                <select name="chequeBank" id="chequeBank" class="form-select" required>
                                    <option value="0">Select Bank</option>
                                    <?php foreach ($getBanks as $b): ?>
                                        <option value="<?= $b->fbank_id; ?>"><?= $b->bank_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" onclick="$('#addBank').modal('show')" class="btn btn-outline-primary">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Cheque # / Transaction #</label>
                            <input type="text" id="inputCheque" class="form-control">
                        </div>

                    </div>
                </div>

                <input type="hidden" id="charge_id" />

                <!-- TRANSACTION INFO -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">OR #</label>
                                <?php $or_current_number = $series->or_current; ?>
                                <input type="text" id="refNumber" value="<?= $or_current_number ?>" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Transaction Date</label>
                                <input class="form-control" name="transactionDate" type="date"
                                    value="<?= date('Y-m-d') ?>" id="transactionDate" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Remarks</label>
                                <input type="text" id="transRemark" class="form-control" placeholder="Remarks">
                            </div>

                        </div>
                    </div>
                </div>

                <!-- CASH REGISTER CONTENT -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">

                        <div class="d-flex justify-content-end mb-2" id="ro_section"></div>

                        <div id="cashRegisterWrapper">
                            <?php
                            $settings = Modules::run('main/getSet');
                            $cashReg['plan_id'] = $plan->fin_plan_id;
                            $cashReg['user_id'] = $user_id;
                            $cashReg['st_id'] = $student->st_id;
                            $cashReg['student'] = $student;
                            $cashReg['school_year'] = $school_year;
                            $cashReg['semester'] = $student->semester;
                            $cashReg['charges'] = $charges;

                            if (file_exists(APPPATH . 'modules/finance/views/' . strtolower($settings->short_name) . '_cashRegister.php')):
                                $this->load->view(strtolower($settings->short_name) . '_cashRegister', $cashReg);
                            else:
                                $this->load->view('cashRegister', $cashReg);
                            endif;
                            ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="confirmPayment" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">

            <!-- HEADER -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-semibold">
                    <i class="fa fa-check-circle me-2"></i>
                    Confirm Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body text-center py-4">

                <div class="mb-3">
                    <i class="fa fa-question-circle text-success" style="font-size: 48px;"></i>
                </div>

                <h5 class="fw-semibold mb-2">
                    Are you sure you want to confirm this payment?
                </h5>

                <p class="text-muted mb-3">
                    This action will finalize the transaction for the student.
                </p>

                <?php if ($finSettings->print_receipts): ?>
                    <div class="form-check d-inline-flex align-items-center justify-content-center gap-2">
                        <input class="form-check-input" type="checkbox" checked id="printOR">
                        <label class="form-check-label fw-medium" for="printOR">
                            Print Official Receipt
                        </label>
                    </div>
                <?php endif; ?>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer justify-content-center border-0 pb-4">

                <button type="button"
                    class="btn btn-outline-secondary px-4"
                    data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Cancel
                </button>

                <button type="button"
                    id="confirmBtn"
                    onclick="saveTransaction()"
                    class="btn btn-success px-4 shadow-sm">
                    <i class="fa fa-check me-1"></i> Confirm Payment
                </button>

            </div>

        </div>
    </div>
</div>

<div id="addFinanceOption" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">

            <!-- HEADER -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-semibold">
                    <i class="fa fa-plus-circle me-2"></i> Add Extra Charges
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <!-- FINANCE ITEM -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Finance Item</label>

                    <div class="d-flex">

                        <select class="form-select flex-grow-1 rounded-end-0"
                            id="inputFinItems"
                            name="inputFinItems"
                            required>
                            <option value="">Select Item</option>
                            <?php foreach ($fin_items as $i): ?>
                                <option value="<?= $i->item_id; ?>">
                                    <?= $i->item_description; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- <button type="button"
                            onclick="$('#addItemModal').modal('show')"
                            class="btn btn-primary rounded-start-0 d-flex align-items-center justify-content-center px-3">
                            <i class="fa fa-plus"></i>
                        </button> -->

                    </div>
                </div>

                <!-- HIDDEN SECTION -->
                <div id="financeDetails">

                    <!-- AMOUNT -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Amount</label>
                        <input type="number"
                            id="fin_amount"
                            class="form-control text-end"
                            placeholder="0.00"
                            onclick="$(this).val('')">
                    </div>

                    <!-- SCHOOL YEAR -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">School Year</label>
                        <select class="form-select" name="inputCSY" id="inputCSY" required>
                            <option value="0">Select School Year</option>
                            <?php foreach ($ro_years as $ro):
                                $next = ($ro->ro_years + 1);
                            ?>
                                <option <?= ($ro->ro_years == $this->session->school_year ? 'selected' : '') ?>
                                    value="<?= $ro->ro_years; ?>">
                                    <?= $ro->ro_years . ' - ' . $next; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" id="extraSem" value="<?= $semester ?>" />

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0" id="financeFooter">

                <button type="button"
                    class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Cancel
                </button>

                <button type="button"
                    onclick="addExtraFinanceCharges()"
                    class="btn btn-success shadow-sm">
                    <i class="fa fa-save me-1"></i> Save
                </button>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addDiscount" tabindex="-1" aria-labelledby="addDiscountLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content shadow border-0 rounded-3">

            <!-- HEADER -->
            <div class="modal-header bg-warning bg-gradient text-dark">
                <h5 class="modal-title fw-semibold" id="addDiscountLabel">
                    <i class="fa fa-tag me-2"></i> Apply Discount
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body px-4 py-3">

                <!-- Finance Item -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Finance Item</label>
                    <div class="input-group">
                        <select class="form-select" name="inputDiscountedItems" id="inputDiscountedItems" required>
                            <option value="">Select Item</option>
                            <option value="0">General</option>
                            <?php foreach ($fin_items as $i): ?>
                                <option value="<?= $i->item_id; ?>"><?= $i->item_description; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <!-- <button type="button" onclick="$('#addItemModal').modal('show')" class="btn btn-outline-primary">
                            <i class="fa fa-plus"></i>
                        </button> -->
                    </div>
                </div>

                <!-- Discount Type + Value -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Discount Type</label>
                        <select id="inputDiscountedType" name="inputDiscountedType" class="form-select">
                            <option value="0">Percent (%)</option>
                            <option value="1">Amount (₱)</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Value</label>
                        <input type="number" id="discount_amount" class="form-control" placeholder="Enter value">
                    </div>
                </div>

                <!-- Discount Category -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Discount Category</label>
                    <select class="form-select" name="inputDiscountCategory" id="inputDiscountCategory" required>
                        <option value="">Select Category</option>
                        <?php foreach ($discountType as $dt): ?>
                            <option value="<?= $dt->schlr_id; ?>"><?= $dt->schlr_type; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- School Year -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">School Year</label>
                    <select class="form-select" name="inputDiscountedCSY" id="inputDiscountedCSY" required>
                        <option value="">Select School Year</option>
                        <?php foreach ($ro_years as $ro):
                            $next = $ro->ro_years + 1;
                        ?>
                            <option value="<?= $ro->ro_years; ?>">
                                <?= $ro->ro_years . ' - ' . $next; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Remarks -->
                <div class="mb-2">
                    <label class="form-label fw-semibold">Remarks</label>
                    <input type="text" id="inputDiscountedRemarks" class="form-control" placeholder="Optional remarks">
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer d-flex justify-content-between px-4 py-3">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Cancel
                </button>

                <button type="button" onclick="applyDiscount()" class="btn btn-success">
                    <i class="fa fa-save me-1"></i> Save Discount
                </button>
            </div>

        </div>
    </div>
</div>

<div id="deleteFinExtra" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <!-- HEADER -->
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body text-center px-4 py-3">
                <div class="mb-3">
                    <i class="fa fa-trash fa-2x text-danger"></i>
                </div>

                <p class="fw-semibold mb-2">
                    Are you sure you want to void this extra charge?
                </p>

                <p class="text-muted small mb-0">
                    This action is permanent and cannot be undone.
                </p>

                <!-- Hidden Inputs -->
                <input type="hidden" id="delete_trans_id" />
                <input type="hidden" id="delete_item_id" />
                <input type="hidden" id="delete_trans_type" />
            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0 d-flex justify-content-center gap-2 pb-4">

                <button type="button"
                    class="btn btn-light px-4"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button type="button"
                    class="btn btn-danger px-4 fw-semibold"
                    onclick="deleteFinanceExtraCharge()">
                    <i class="fa fa-trash me-1"></i> Delete
                </button>

            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $('#fin_amount').on('input', function() {
        let value = $(this).val().replace(/,/g, '');
        if (!isNaN(value) && value !== '') {
            $(this).val(Number(value).toLocaleString('en-US'));
        }
    });

    // $('#addFinanceOption').on('shown.bs.modal', function() {
    //     $('#inputFinItems').focus();
    // });

    $('#inputTrType').on('change', function() {
        let val = $(this).val();
        if (val == 1 || val == 4) {
            $('#chequeWrapper').slideDown(200);
        } else {
            $('#chequeWrapper').slideUp(200);
        }
    });

    $('#inputCashDen').select2();
    var cashDen = [];
    var ids = [];

    function savePlanType() {
        var url = '<?php echo base_url() . 'finance/savePlanType/' ?>' + $('#school_year').val();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                plan_type: $('#plan_type').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            success: function(data) {
                if (data != 0) {
                    $('#inputStudentType').append(data);
                } else {
                    alert('Sorry Something went wrong, Please try again later');
                }
            }
        });

        return false;

    }

    function addToFeeSchedule() {
        var url = '<?php echo base_url() . 'finance/addToFeeSchedule/' ?>' + $('#school_year').val();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                semester: $('#inputSem').val(),
                grade_level_id: $('#gradeLevelPlan').val(),
                type: $('#inputStudentType').val(),
                title: $('#planTitle').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            success: function(data) {
                alert(data);
                location.reload();
            }
        });

        return false;
    }

    function saveCashBreakDown() {
        var url = '<?php echo base_url() . 'finance/saveCashBreakDown' ?>';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                items: $('#cashDomJson').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            success: function(data) {
                alert(data);
                location.reload();
            }
        });

        return false;
    }

    function addItem(value) {
        var cashCount = $('#cashCount').val();
        var partial = parseFloat(cashCount) * parseFloat($('#' + value + '_list').html());
        var items = {
            den_id: value,
            denomination: $('#' + value + '_list').html(),
            count: cashCount,

        };

        cashDen.push(items);
        $('#cashDomJson').val(JSON.stringify(cashDen));
        $('#breakDownList').append('<tr id="li_' + ids + '"><td><strong>' + $('#' + value + '_list').html() + '</strong></td><td>' + cashCount + '</td><td>' + partial + '</td><td><i onclick="$(\'#li_' + ids + '\').hide(), removeFromList(' + ids + ')" class="fa fa-close pointer text-danger"></i> </tr>');
    }




    function removeFromList(id) {
        var data = []
        id = id - 1
        data = $('#cashDomJson').val();
        $('#breakDownList').html('');

        var obj = JSON.parse(data);
        obj.splice(id, 1);

        Object.keys(obj).forEach(function(key) {

            var partial = parseInt(obj[key].count) * parseInt(obj[key].denomination);
            console.log(obj[key].denomination)
            $('#breakDownList').append('<tr id="li_' + ids + '"><td><strong>' + obj[key].denomination + '</strong></td><td>' + obj[key].count + '</td><td>' + partial + '</td><td><i onclick="$(\'#li_' + ids + '\').hide(), removeFromList(' + ids + ')" class="fa fa-close pointer text-danger"></i> </tr>');

        });

        $('#cashDomJson').val(JSON.stringify(obj));
    }



    function saveEncashments() {
        var bank = $('#enBank').val();
        var chequeNumber = $('#chequeNumber').val();
        var amount = $('#chequeAmount').val();
        var chequeDate = $('#chequeDate').val();

        var url = "<?php echo base_url() . 'finance/saveEncashments' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: {
                bank: bank,
                chequeNumber: chequeNumber,
                chequeAmount: amount,
                chequeDate: chequeDate,
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            success: function(data) {
                alert(data)
            }
        });

        return false;
    }

    function addBank() {

        var url = "<?php echo base_url() . 'finance/addBank' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: "bank=" + $('#bank').val() + '&bankShortName=' + $('#bankShortName').val() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#enBank').append(data);
                $('#chequeBank').append(data);
                $('#addBank').modal('hide');
                alert('Bank Successfully Added to List');
            }
        });

        return false;
    }

    function addItems() {
        var finItem = $('#fin_item').val();

        var url = "<?php echo base_url() . 'finance/addFinanceItem' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: "finItem=" + finItem + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#inputFinItems').append(data);
                $('#addItemModal').modal('hide');
            }
        });

        return false;
    }



    function selectSection(level_id) {
        var url = "<?php echo base_url() . 'registrar/getSectionByGL/' ?>" + level_id; // the script where you handle the form input.

        if (level_id == 12 || level_id == 13) {
            $('#strandWrapper').show();
        } else {
            $('#strandWrapper').hide();
        }
        $.ajax({
            type: "POST",
            url: url,
            data: "level_id=" + level_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
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