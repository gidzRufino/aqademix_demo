<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 30px;
        height: 15px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 13px;
        width: 13px;
        left: 3px;
        bottom: 1px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(12px);
        -ms-transform: translateX(12px);
        transform: translateX(12px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 25px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">Finance General Settings
        <div class="btn-group pull-right" role="group" aria-label="">
            <?php if ($this->eskwela->getSet()->level_catered == 0): ?>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo ($this->eskwela->getSet()->level_catered == '0' ? base_url('college') : base_url()) ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance/accounts') ?>'">Accounts</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance') ?>'">Fee Schedule</button>
            <?php else: ?>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url() ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance/accounts') ?>'">Accounts</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance') ?>'">Fee Schedule / Settings</button>
            <?php endif; ?>
        </div>
    </h3>

    <div class="col-lg-12 no-padding">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class='panel panel-red'>
                <div class='panel-heading clearfix'>
                    <h5 class="pull-left no-margin">OR Settings</h5>
                    <button class="btn btn-primary btn-xs pull-right" onclick="$('#addORSeries').modal('show')"><i class="fa fa-plus"></i></button>
                </div>
                <div class="panel-body">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8 form-group">
                        <label class="pull-left">Use Automated OR Printing:&nbsp;&nbsp;</label>
                        <div class="form-check form-check-inline pull-left">
                            <input onclick="setPrintSettings(1)" class="form-check-input" <?php echo ($FinSettings->print_receipts == 1 ? 'checked=""' : '') ?> type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1">
                            <label class="form-check-label" for="inlineRadio1">Yes &nbsp;&nbsp;</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input onclick="setPrintSettings(0)" class="form-check-input" <?php echo ($FinSettings->print_receipts == 0 ? 'checked=""' : '') ?> type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>

                    <table class="table table-striped">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Beginning Series</th>
                            <th class="text-center">Ending Series</th>
                            <th class="text-center">Currently Loaded OR</th>
                            <th class="text-center">Last Printed Date</th>
                            <th class="text-center">Cashier</th>
                            <th></th>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($ORSeries as $or):
                            $teller = Modules::run('hr/getEmployee', base64_encode($or->or_cashier_id));
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++ ?></td>
                                <td class="text-center"><?php echo $or->or_begin ?></td>
                                <td class="text-center"><?php echo $or->or_end ?></td>
                                <td class="text-center"><?php echo $or->or_current + 1 ?></td>
                                <td class="text-center"><?php echo ($or->or_last_printing != '0000-00-00 00:00:00' ? date('F d, Y g:i:s', strtotime($or->or_last_printing)) : 'Nothing Printed') ?></td>
                                <td><?php echo strtoupper(substr($teller->firstname, 0, 1) . '. ' . $teller->lastname) ?></td>
                                <td>
                                    <button onclick="$('#assignORSeries').modal('show'), $('#assign_or_id').val('<?php echo $or->or_id ?>')" class="btn btn-danger btn-xs col-lg-12 <?php echo ($or->or_status ? 'disabled' : '') ?>">Assign this Series</button>
                                    <button onclick="$('#orSeriesTitle').html('Edit OR Series'), $('#addORSeries').modal('show'), $('#or_begin').val('<?php echo $or->or_begin ?>'), $('#or_end').val('<?php echo $or->or_end ?>'), $('#or_series_id').val('<?php echo $or->or_id ?>')" class="btn btn-warning btn-xs col-lg-12">Edit OR Series</button>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class='col-lg-12 no-padding'>
        <div class="col-lg-4">
            <div class="col-lg-12">
                <div class='panel panel-info'>
                    <div class='panel-heading clearfix'>
                        <h5 class="pull-left no-margin">Finance Category</h5>
                        <button class="btn btn-primary btn-xs pull-right" onclick="$('#addEditCategory').modal('show')"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="panel-body">
                        <table class="table table-stripped">
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th class="text-center">Sum Up Fees</th>
                                <th style="width:30%;"></th>
                            </tr>
                            <?php
                            $catCount = 1;
                            foreach ($fin_category as $cat): ?>
                                <tr>
                                    <td><?php echo $catCount++ ?></td>
                                    <td><?php echo $cat->fin_category ?></td>
                                    <td class="text-center">
                                        <label val="<?php echo $cat->is_fused ?>" class="switch" onclick="fusedFees('<?php echo $cat->fin_cat_id ?>'), $('#cat_id').val('<?php echo $cat->fin_cat_id ?>')">
                                            <input id="finSwitch_<?php echo $cat->fin_cat_id ?>" type="checkbox" value="<?php echo ($cat->is_fused ? 0 : 1) ?>" <?php echo ($cat->is_fused ? 'checked="checked"' : '') ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="btn-group pull-right" role="group">
                                            <button type="button" class="btn btn-xs btn-warning" onclick="$('#addEditCategory').modal('show'), $('#categoryName').val('<?php echo $cat->fin_category ?>'), $('#cat_id').val('<?php echo $cat->fin_cat_id ?>')"><i class="fa fa-pencil-square-o"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class='panel panel-primary'>
                    <div class='panel-heading clearfix'>
                        <h5 class="pull-left no-margin">Terms of Payment</h5>
                        <button class="btn btn-success btn-xs pull-right" onclick="$('#addEditTermPayment').modal('show'), $('#addeditTerm').text('Add Term Payments'), $('#termOpt').val(1)"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-stripped">
                            <tr>
                                <th>#</th>
                                <th>Payment Term</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>One Time Payment</td>
                                <td></td>
                            </tr>
                            <?php
                            $t = 2;
                            if ($payment_term->num_rows() > 0):
                                foreach ($payment_term->result() as $pt):
                            ?>
                                    <tr>
                                        <td><?php echo $t++; ?></td>
                                        <td><?php echo $pt->term_desc ?></td>
                                        <td>
                                            <div class="btn-group pull-right" role="group">
                                                <button type="button" class="btn btn-xs btn-warning" onclick="$('#addEditTermPayment').modal('show'), $('#addeditTerm').text('Update Term Payments'), $('#termOpt').val(2), $('#term_id').val('<?php echo $pt->pterm_id ?>'), $('#paymentTerms').val('<?php echo $pt->term_desc ?>')"><i class="fa fa-pencil-square-o"></i></button>
                                                <button type="button" class="btn btn-xs btn-danger" onclick="$('#confirmDelPayTerm').modal('show'), $('#termOpt').val(3), $('#term_id').val('<?php echo $pt->pterm_id ?>'), $('#paymentTerms').val('<?php echo $pt->term_desc ?>')"><i class="fa fa-trash-o"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class='panel panel-secondary'>
                    <div class='panel-heading clearfix'>
                        <h5 class="pull-left no-margin">Discount Category</h5>
                        <button class="btn btn-primary btn-xs pull-right" onclick="$('#addEditDiscountCat').modal('show'), $('#addEditDiscCatTitle').text('Add Discount Category'), $('#discOpt').val(1)"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="panel-body">
                        <table class="table table-stripped">
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th style="width:30%;"></th>
                            </tr>
                            <?php
                            $cc = 1;
                            foreach ($discount as $d) {
                            ?>
                                <tr>
                                    <td><?php echo $cc++; ?></td>
                                    <td><?php echo $d->schlr_type; ?></td>
                                    <td>
                                        <div class="btn-group pull-right" role="group">
                                            <button onclick="$('#discountCat').val('<?php echo $d->schlr_type ?>'), $('#cat_id').val('<?php echo $d->schlr_id ?>'), $('#addEditDiscountCat').modal('show'), $('#addEditDiscCatTitle').text('Edit Discount Category'), $('#discOpt').val(0)" type="button" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o"></i></button>
                                            <button type="button" onclick="$('#confirmDeleteDiscCat').modal('show'), $('#cat_id').val('<?php echo $d->schlr_id ?>')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class='panel panel-success'>
                <div class='panel-heading clearfix'>
                    <h5 class="pull-left no-margin">Finance Items</h5>
                    <button class="btn btn-success btn-xs pull-right" onclick="$('#editItem').modal('show')" onmouseover="$('#addTitle').html('Add Item')"><i class="fa fa-plus"></i></button>
                </div>
                <div class="panel-body">
                    <table class="table table-stripped">
                        <tr>
                            <th>#</th>
                            <th>Item Description</th>
                            <th>Item Category</th>
                            <th>Terms of Payment</th>
                            <th class="text-center">Item Percentage to Category</th>
                            <th style="width:10%;"></th>
                        </tr>
                        <?php
                        $cnt = 1;
                        foreach ($fin_items as $i): ?>
                            <tr>
                                <td><?php echo $cnt++; ?></td>
                                <td><?php echo strtoupper($i->item_description); ?></td>
                                <td><?php echo strtoupper($i->fin_category); ?></td>
                                <td><?php echo strtoupper($i->term_desc) . ($i->total_month > 0 ? '   [' . $i->total_month .  ' months]' : ''); ?></td>
                                <td class="text-center"><?php echo $i->percentage_amount; ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-xs btn-warning" onmouseover="$('#addTitle').html('Edit Item')"
                                            onclick="getEditItem('<?php echo $i->item_id ?>','<?php echo $i->item_description ?>','<?php echo $i->category_id ?>', '<?php echo $i->percentage_amount ?>', $('#termPayment').val('<?php echo $i->pterm_id; ?>'), $('#mtotal').val('<?php echo $i->total_month; ?>'))"><i class="fa fa-pencil-square-o"></i></button>
                                        <button type="button" class="btn btn-xs btn-danger" onclick="$('#confirmDeleteItem').modal('show'), $('#item_id').val('<?php echo $i->item_id ?>')"><i class="fa fa-trash-o"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="editItem" style="margin: 70px auto;" class="modal fade col-lg-4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h5 id="addTitle">
                Edit Item
            </h5>
        </div>
        <div class="panel-body">
            <div class="form-group col-lg-12">
                <label class="control-label" for="input">Item Description</label>
                <input class="form-control" name="itemDescription" type="text" id="itemDescription" placeholder="" required>
            </div>
            <div class="form-group col-lg-12">
                <label class="control-label" for="input">Item Category</label>
                <select id="itemCategory" class="form-control">
                    <option value="0">Select Category</option>
                    <?php
                    foreach ($fin_category as $finCat):
                    ?>
                        <option value="<?php echo $finCat->fin_cat_id; ?>"><?php echo ucwords($finCat->fin_category); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-lg-12">
                <label class="control-label" for="input">Terms of Payment</label>
                <select id="termPayment" class="form-control">
                    <option value="0">One Time Payment</option>
                    <?php
                    foreach ($payment_term->result() as $pt):
                    ?>
                        <option onclick="$('#totalMonths').modal('show')" value="<?php echo $pt->pterm_id; ?>"><?php echo ucwords($pt->term_desc); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" id="mtotal" value="0" />
                <em id="show_mtotal" style="display: none; color: blue; width: 100%"></em>
            </div>

            <div class="form-group col-lg-12">
                <label class="control-label" for="input">Percentage Amount</label>
                <input class="form-control" name="percentageAmount" type="text" id="percentageAmount" placeholder="" required>
            </div>
            <div class="form-group col-lg-12">
                <label class="control-label" for="input">Default Amount <small class="text-muted ">(for laboratory use only)</small></label>
                <input class="form-control" name="defaultValue" type="text" id="defaultValue" placeholder="" value="0" required>
            </div>
            <div style='margin:5px 0;'>
                <a data-dismiss='modal' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-right'>CANCEL</a>
                <a data-dismiss='modal' onclick='editItem()' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>EDIT</a>
            </div>

        </div>
    </div>
</div>

<div id="addORSeries" style="width:35%; margin: 50px auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading clearfix">
            <h6 class="col-lg-8">Add OR Series</h6>
            <button class="btn btn-xs btn-danger pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>

        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Beginning Series</label>
                <input onblur="getSeries()" type="text" id="or_begin" class="form-control" placeholder="Beginning Series" />
            </div>
            <div class="form-group">
                <label>Ending Series</label>
                <input onblur="getSeries()" type="text" id="or_end" class="form-control" placeholder="Ending Series" />
            </div>

            <div class="form-group">
                <label>Currently Loaded OR</label> <br />
                <select style="width:100%;" name="inputCSY" id="or_current" required>
                </select>
            </div>

        </div>
        <div class="panel-footer clearfix">
            <button id="addSeriesBtn" class="btn btn-success pull-right">ADD Series</button>
        </div>
    </div>
</div>


<div id="confirmDeleteItem" style="width:35%; margin: 70px auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger" style='width:100%;'>
        <div class="panel-heading">
            <h4>
                <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to Delete this Item? There might be fees connected to this item. Take Note you cannot undo the process.
            </h4>
        </div>
        <div class="panel-body">
            <div style='margin:5px 0;'>
                <a data-dismiss='modal' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>NO</a>
                <a data-dismiss='modal' onclick='deleteItem()' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-right'>YES</a>
            </div>

        </div>
    </div>
</div>

<div id="confirmDeleteDiscCat" style="width:35%; margin: 70px auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger" style='width:100%;'>
        <div class="panel-heading">
            <h4>
                <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to Delete this Discount Category? There might be fees connected to this category. Take Note you cannot undo the process.
            </h4>
        </div>
        <div class="panel-body">
            <div style='margin:5px 0;'>
                <a data-dismiss='modal' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>NO</a>
                <a data-dismiss='modal' onclick='deleteDiscCat()' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-right'>YES</a>
            </div>

        </div>
    </div>
</div>

<div id="confirmDelPayTerm" style="width:35%; margin: 70px auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger" style='width:100%;'>
        <div class="panel-heading">
            <h4>
                <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to Delete this Terms of Payment? There might be fees connected to this Terms. Take Note you cannot undo the process.
            </h4>
        </div>
        <div class="panel-body">
            <div style='margin:5px 0;'>
                <a data-dismiss='modal' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>NO</a>
                <a data-dismiss='modal' onclick='paymentTerm()' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-right'>YES</a>
            </div>

        </div>
    </div>
</div>

<div id="addEditCategory" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-info">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><span id="addEditCatTitle">Add Category</span>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" id="categoryName" class="form-control" placeholder="Category Name" />
            </div>
        </div>
        <div class="panel-footer clearfix">
            <a data-dismiss='modal' onclick='addEditCategory()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</a>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>

<div id="addEditDiscountCat" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-info">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><span id="addEditDiscCatTitle"></span>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Discount Category Name</label>
                <input type="text" id="discountCat" class="form-control" placeholder="Discount Category Name" />
            </div>
            <em id="discMsg" style="display: none; width: 100%"></em>
        </div>
        <div class="panel-footer clearfix">
            <input type="hidden" id="discOpt" />
            <button onclick='discountCategory()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</button>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>

<div id="addEditTermPayment" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-info">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><span id="addeditTerm"></span>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>Terms of Payment</label>
                <input type="text" id="paymentTerms" class="form-control" placeholder="Payment Terms" />
            </div>
            <em id="termMsg" style="display: none; width: 100%"></em>
        </div>
        <div class="panel-footer clearfix">
            <input type="hidden" id="termOpt" />
            <button onclick='paymentTerm()' style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left'>Save</button>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>

<div id="totalMonths" class="modal fade" style="width:15%; margin:30px auto 0;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-info">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><span id="addeditTerm">Enter # of Months to Pay</span>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <input type="text" id="tMonths" class="form-control" placeholder="Number of Months" />
            </div>
            <em id="tMonthMsg" style="display: none; width: 100%"></em>
        </div>
        <div class="panel-footer clearfix">
            <button onclick="$('#mtotal').val($('#tMonths').val()), $('#show_mtotal').text('[ ' + $('#tMonths').val() + ' Total Months to Pay ]'), $('#show_mtotal').show()" style='margin-right:10px; color: white' class='btn btn-xs btn-success pull-left' data-dismiss='modal'>Save</button>
            <button data-dismiss='modal' class='btn btn-xs btn-danger pull-left'>Cancel</button>&nbsp;&nbsp;
        </div>
    </div>
</div>

<div id="assignORSeries" style="width:30%; margin: 50px auto;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-primary" style='width:100%;'>
        <div class="panel-heading clearfix">
            <h3 class="col-lg-8">Assign OR Series</h3>
            <button class="btn btn-xs btn-danger pull-right" data-dismiss="modal"><i class="fa fa-close"></i></button>

        </div>
        <div class="panel-body">
            <input onkeyup="search(this.value)" id="searchBox" class="form-control" type="text" placeholder="Search Name Here" />
            <div onblur="$(this).hide()" style="min-height: 30px; margin-top:0; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchName">

            </div>
            <input type="hidden" id="assign_or_id" name="assign_or_id" />
            <input type="hidden" id="assign_employee_id" name="assign_employee_id" />
        </div>
        <div class="panel-footer clearfix">
            <button id="addSeriesBtn" onclick="useSeries()" class="btn btn-success pull-right">Assign Series</button>
        </div>
    </div>
</div>


<input type="hidden" id="item_id" value="0" />
<input type="hidden" id="cat_id" value="0" />
<input type="hidden" id="term_id" value="0" />
<input type="hidden" id="school_year" value="<?php echo $now ?>" />


<script type="text/javascript">
    function search(value) {
        var url = '<?php echo base_url() . 'college/finance/searchFinanceStaff/' ?>' + value + '/' + '<?php echo $this->session->school_year ?>';
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + value, // serializes the form's elements.
            success: function(data) {
                $('#searchName').show();
                $('#searchName').html(data);

            }
        });

        return false;
    }

    function getSeries() {
        var begin = $('#or_begin').val();
        var end = $('#or_end').val();
        if (begin != 0 && begin != "") {
            for (var i = begin; i <= end; i++) {
                $('#or_current').append("<option value='" + i + "'>" + i + "</option>");
            }
        }
    }

    function useSeries() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/useSeries' ?>',
            //dataType: 'json',
            data: {
                id: $('#assign_or_id').val(),
                employee_id: $('#assign_employee_id').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                alert(response);
                location.reload();
            }

        });
    }

    function setPrintSettings(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'finance/setPrintSettings/' ?>' + id,
            //dataType: 'json',
            data: {
                id: id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                location.reload();
            }

        });
    }

    $('#addSeriesBtn').click(function() {
        var begin = $('#or_begin').val();
        var end = $('#or_end').val();
        var current = $('#or_current').val();
        var series_id = $('#or_series_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'college/finance/addSeries' ?>',
            //dataType: 'json',
            data: {
                beginning: begin,
                ending: end,
                current: current,
                series_id: series_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(response) {
                alert(response);
                location.reload();
            }

        });
    });


    function addEditCategory() {
        var cat_id = $('#cat_id').val();
        var category = $('#categoryName').val();
        var school_year = $('#school_year').val();
        var url = "<?php echo base_url() . 'college/finance/addCategory' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "cat_id=" + cat_id + '&school_year=' + school_year + "&category=" + category + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert(data)
                location.reload()
            }
        });

        return false;
    }

    function fusedFees(id) {
        var is_fused = $('#finSwitch_' + id).val();
        var cat_id = $('#cat_id').val();
        var url = "<?php echo base_url() . 'college/finance/fusedFees' ?>"; // the script where you handle the form input.


        $.ajax({
            type: "POST",
            url: url,
            data: "is_fused=" + is_fused + "&cat_id=" + cat_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                location.reload();
            }
        });

        return false;
    }

    function getEditItem(item_id, item_description, category_id, percentageAmount) {
        $('#editItem').modal('show');
        $('#item_id').val(item_id);
        $('#itemDescription').val(item_description);
        $('#percentageAmount').val(percentageAmount);

        $('#itemCategory option').each(function() {
            if ($(this).val() == category_id) {
                $(this).attr('selected', 'selected');
            }
        });
    }


    function editItem() {
        var item_id = $('#item_id').val();
        var itemDescription = $('#itemDescription').val();
        var percentageAmount = $('#percentageAmount').val();
        var itemCategory = $('#itemCategory').val();
        var defaultAmount = $('#defaultValue').val();
        var mtotal = $('#mtotal').val();
        var pterm = $('#termPayment').val();
        var url = '<?php echo base_url() . 'college/finance/editItem/' ?>';
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                item_id: item_id,
                itemDescription: itemDescription,
                percentageAmount: percentageAmount,
                itemCategory: itemCategory,
                defaultAmount: defaultAmount,
                school_year: $('#school_year').val(),
                pterm: pterm,
                mtotal: mtotal,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data) {
                alert(data.msg);
                location.reload();
            }
        });

        return false;
    }

    function deleteItem() {

        var item_id = $('#item_id').val();
        var school_year = $('#school_year').val();
        var url = "<?php echo base_url() . 'college/finance/deleteItem' ?>"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "item_id=" + item_id + '&school_year=' + school_year + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                alert(data)
                location.reload()
            }
        });

        return false;
    }

    function discountCategory() {
        var desc = $('#discountCat').val();
        var opt = $('#discOpt').val();
        var cat_id = $('#cat_id').val();

        if (desc == '') {
            $('#discMsg').addClass('discErr');
            $('#discMsg').text('Please Enter Discount Category Name');
            $('#discMsg').show().delay(3000).queue(function() {
                $('#discMsg').hide();
            });
        } else {
            var url = '<?php echo base_url() . 'college/finance/addEditDiscountCategory/' ?>' + desc + '/' + cat_id + '/' + opt;

            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (!data.status) {
                        $('#discMsg').addClass('discErr');
                        $('#discMsg').text(data.msg);
                        $('#discMsg').show().delay(3000).queue(function() {
                            $('#discMsg').hide();
                        });
                    } else {
                        $('#discMsg').addClass('discSuccess');
                        $('#discMsg').text(data.msg);
                        $('#discMsg').show().delay(3000).queue(function() {
                            $('#discMsg').hide();
                            location.reload();
                        });
                    }
                },
                error: function(d) {
                    alert('Error')
                }
            });
        }
    }

    function deleteDiscCat() {
        var cat_id = $('#cat_id').val();
        var url = '<?php echo base_url() . 'college/finance/deleteDiscCat/' ?>' + cat_id;

        $.ajax({
            type: 'GET',
            url: url,
            success: function() {
                alert('Discount Deleted Successfuly!!!');
                location.reload();
            }
        })
    }

    function paymentTerm() {
        var term = $('#paymentTerms').val();
        var opt = $('#termOpt').val();
        var term_id = $('#term_id').val();
        var url = '<?php echo base_url() . 'college/finance/paymentTerm/' ?>';
        var pr = 0;

        if (opt != 3) {
            if (term == '') {
                $('#termMsg').addClass('discErr');
                $('#termMsg').text('Please Enter Terms of Payment');
                $('#termMsg').show().delay(3000).queue(function() {
                    $('#termMsg').hide();
                });
                pr = 0;
            } else {
                pr = 1;
            }
        } else {
            pr = 1;
        }


        if (pr == 1) {
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: 'desc=' + term + '&opt=' + opt + '&tid=' + term_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                success: function(data) {
                    $('#termMsg').addClass('discSuccess');
                    $('#termMsg').text(data.msg);
                    $('#termMsg').show().delay(3000).queue(function() {
                        $('#termMsg').hide();
                    });
                    location.reload();
                }
            })
        }
    }
</script>

<style>
    .discErr {
        color: white;
        font-weight: bold;
        font-size: 12px;
        background-color: red;
        padding: 10px;
    }

    .discSuccess {
        color: white;
        font-weight: bold;
        font-size: 12px;
        background-color: green;
        padding: 10px;
    }