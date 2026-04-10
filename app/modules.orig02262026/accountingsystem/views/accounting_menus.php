<div class="btn-group pull-right" role="group" aria-label="">
    <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('accountingsystem') ?>'">Dashboard</button>
    <button type="button" class="btn btn-default" onclick="$('#amTransaction').modal('show')">New Journal Entry</button>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Disbursement</button>
        <ul class="dropdown-menu">
            <li onclick="$('#purchaseRequest').modal('show')"><a href="#">Create Purchase Request</a></li>
            <li onclick="$('#expenseDisbursement').modal('show')"><a href="#">Create Expense / Disbursement</a></li>
          <li><a href="#">Create Cash / Check Voucher</a></li>
        </ul>
    </div>
    <button type="button" class="btn btn-default"  onclick="document.location='<?php echo base_url('accountingsystem/inventory') ?>'">Inventory</button>
    <button type="button" class="btn btn-default"  onclick="document.location='<?php echo base_url('accountingsystem/reports') ?>'">Reports</button>
    <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('accountingsystem/settings') ?>'">Settings</button>
</div>
