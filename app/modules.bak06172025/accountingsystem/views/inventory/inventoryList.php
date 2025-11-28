<div class="col-lg-8 no-padding" style="border-right:1px solid #ccc">
    <h4 class="text-center">List of Inventory Items</h4>
    <div class="col-lg-12 no-padding">
        <table class="table table-stripped">
        <thead>
           <tr>
               <th>#</th>
               <th style="width:20%">Item Name</th>
               <th style="width:30%">Item Description</th>
               <th>Item Type</th>
               <th>Item Price</th>
               <th>Stocks Remaining</th>
               <th>SRP</th>
           </tr>
        </thead>
        <tbody id="inventoryItemBody">
            <?php
            $i = 1;
            foreach($inventory as $inv): ?>
            <tr>
                <td><?php echo $i++?></td>
                <td><?php echo $inv->inv_name ?></td>
                <td><?php echo $inv->inv_desc ?></td>
                <td><?php echo $inv->inv_category ?></td>
                <td><?php echo number_format($inv->inv_price, 2,'.',',') ?></td>
                <td><?php echo $inv->inv_no_stocks ?></td>
                <td><?php echo number_format(($inv->inv_price+($inv->inv_price*$inv->inv_markup)), 2, '.',',') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
     </div>
</div>

<div class="col-lg-4 pull-right" id="addCatWrapper" >
    <h4 class="text-center">Add Inventory Items</h4>
    <div class="form-group input-group col-lg-12">
        <label>Item Name</label>
        <input class="form-control" id="itemName"  placeholder="Name of Item" type="text">
    </div>
    <div class="form-group input-group col-lg-12">
        <label>Item Type</label>
        <select id="itemCategory" class="form-control">
            <option>Select Category</option>
            <?php foreach($category as $cat): ?>
                <option value="<?php echo $cat->cat_id ?>"><?php echo $cat->inv_category; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group input-group col-lg-12">
        <label>Item Desc</label>
        <textarea class="form-control" id="itemDesc"></textarea>
    </div>
    <div class="form-group input-group col-lg-12">
        <label>Item Price</label>
        <input class="form-control" id="itemPrice"  placeholder="Item Price" type="text">
    </div>
    <div class="form-group input-group col-lg-12">
        <label>Stocks Available</label>
        <input class="form-control" id="itemStocks"  placeholder="No of Stocks" type="text">
    </div>
    <div class="form-group input-group col-lg-12">
        <label>Mark Up</label>
        <input class="form-control" id="itemMarkUp"  placeholder="Mark Up in Decimal Form" type="text">
    </div>
    
    
    
    <button onclick="addItem('<?php echo $i ?>')" class="btn btn-primary btn-block">A D D</button>

</div>

<script type="text/javascript">

    function addItem(i)
    {
        var url = "<?php echo base_url().'accountingsystem/inventory/addItems' ?>"
        
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: {
                item_name       : $('#itemName').val(),
                item_desc       : $('#itemDesc').val(),
                item_category   : $('#itemCategory').val(),
                item_price      : $('#itemPrice').val(),
                item_stocks     : $('#itemStocks').val(),
                item_markUp     : $('#itemMarkUp').val(),
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
                    
            }
        });
    }    
</script>