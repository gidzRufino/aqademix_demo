<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Sales 
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('canteen') ?>'">Dashboard</button>
              </div>
        </h3>
    </div>
    <div class="col-lg-12" style="margin-bottom: 10px;">
        <div class="row pull-right">
            <input name="startDate" type="text" data-date-format="yyyy-mm-dd" id="startDate" placeholder="Select Start Date" />
            <input  name="endDate" type="text" data-date-format="yyyy-mm-dd" id="endDate" placeholder="Select End Date" />
            <div class="btn-group pull-right" role="group" aria-label="">
                <button onclick="getSales()" type="button" class="btn btn-medium btn-primary">Generate Canteen Sales</button>
                <button onclick="printSales()" type="button" class="btn btn-medium btn-info">Print</button>
            </div>
        </div>
    </div>
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <table class="table table-striped">
            <tr>
                <th>Transaction #</th>
                <th>Date</th>
                <th>Name of Item</th>
                <th>Quantity</th>
                <th>Price Per Piece</th>
                <th>Total Amount</th>
            </tr>
            <tbody id="salesBody">
                <?php 
                    $total = 0;
                    $overAll = 0;
                    foreach($sales as $s): 
                        $total = ($s->item_quantity * $s->item_price);
                        $overAll += $total
                        ?>

                        <tr>
                            <td><?php echo $s->transaction_num ?></td>
                            <td><?php echo $s->transaction_date ?></td>
                            <td><?php echo $s->canteen_item_name ?></td>
                            <td><?php echo $s->item_quantity?></td>
                            <td><?php echo number_format($s->item_price, 2, '.',',')?></td>
                            <td><?php echo number_format($total, 2, ".", ',')?></td>
                        </tr>
                    <?php 
                        unset($total);
                    endforeach; ?>
                        <tr>
                            <th colspan="5"></th>
                            <th> <?php echo number_format($overAll, 2, '.',',') ?></th>
                        </tr>
            </tbody>
        </table>
    </div>
    
    
</div>

<script type="text/javascript">
    
    $('#startDate').datepicker({
        orientation: 'auto'
    });
    $('#endDate').datepicker({
        orientation: 'auto'
    });
    
     function printSales()
    {
        var url = '<?php echo base_url() . 'canteen/printSales/' ?>'+$('#startDate').val()+'/'+$('#endDate').val();
        
        window.open(url, '_blank');
    }
 
     function getSales()
 {
      $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . 'canteen/getSales/' ?>'+$('#startDate').val()+'/'+$('#endDate').val(),
            data: 'csrf_test_name='+$.cookie('csrf_cookie_name'),
            success: function (response) {
                //    alert(response);
                $('#salesBody').html(response);
            }
        });
 }
    
</script>    