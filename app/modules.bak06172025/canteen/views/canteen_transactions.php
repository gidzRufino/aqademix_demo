<div class="row">
    <div class="col-md-12">
        <table id="tbl1" class="table table-responsive" style="font-size: 10px">
            <thead>
                <tr>
                    <th>Options</th>
                    <th>Quantity</th>
                    <th>Item Name</th>
                    <th>Each</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody id="table_trans">

            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <table id="tbl2" class="table table-responsive" style="font-size: 10px">

        </table>
    </div>
    <div class="col-md-8">
        <h4>Total Transaction</h4>
    </div>
    <div class="col-md-4">
        <h4 id="total-price">Php</h4>
    </div>
    <div class="col-md-4">
        <button type="button" style="width: 100%" class="btn btn-primary btn-lg delBtn" id="creditBtn" onclick="$('#creditModal').modal('show'), setFocus()" disabled=""><span class="fa fa-1x fa-credit-card"></span> Credit</button>
    </div>
    <div class="col-md-4">
        <button type="button" style="width: 100%" class="btn btn-info btn-lg delBtn" id="cashBtn" data-toggle='modal' data-target='#cashModal' disabled=""><span class="fa fa-1x fa-money"></span> Cash</button>
    </div>
    <div class="col-md-4">
        <button type="button" style="width: 100%" id="newTrans" onclick="winReload();" class="btn btn-success btn-lg delBtn" disabled=""><span class="fa fa-1x fa-dashboard"></span> New</button>
    </div>
    <div id="addSuccess"></div>
</div>