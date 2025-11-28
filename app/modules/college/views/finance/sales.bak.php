<div class="row">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Collection Report 
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance/accounts') ?>'">Accounts</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance/getCollectible') ?>'">Generate Collectible</button>
              </div>
        </h3>
    </div>
    <div class="col-lg-12" style="margin-bottom: 10px;">
        <div class="row pull-right">
            <input name="startDate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo ($this->uri->segment(4)==NULL?date('Y-m-d'):$this->uri->segment(4)) ?>" id="startDate" placeholder="Select Start Date" />
            <input  name="endDate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo ($this->uri->segment(5)==NULL?date('Y-m-d'):$this->uri->segment(5)) ?>" id="endDate" placeholder="Select End Date" />
            
            <div class="btn-group pull-right" role="group" aria-label="">
                <button onclick="generateCollection()" type="button" class="btn btn-medium btn-primary">Generate Collection</button>
                <button onclick="printSales($('#reportType').val())" type="button" class="btn btn-medium btn-info">Print</button>
            </div>
            <div class="form-group pull-right">
                <select tabindex="-1" id="reportType" name="reportType"  class="col-lg-12">
                   <option value="0">Report Per Account</option>
                   <option value="1">Collection Report Per Teller</option>
                   <!--<option value="1">Report Per Item</option>-->
                   <option value="2">Report on Collection Summary </option>
                   
               </select>
             </div>
        </div>
    </div>
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <table class="table table-striped">
            <tr>
                <th style="width:10%;">Date</th>
                <th style="width:10%;">OR #</th>
                <th style="width:30%;">Account Name</th>
                <th style="width: 40%; text-align: right;">Amount</th>
            </tr>
            <tbody id="salesBody">
                <?php 
                    $total = 0;
                    $overAll = 0;
                    foreach($collection->result() as $c): 
                        $overAll += $c->amount
                        ?>

                        <tr>
                            <td><?php echo $c->t_date ?></td>
                            <td><?php echo $c->ref_number ?></td>
                            <td><?php echo $c->lastname.', '.$c->firstname ?></td>
                            <td style="text-align: right;"><?php echo number_format($c->amount, 2, '.',',')?></td>
                        </tr>
                    <?php 
                        unset($total);
                    endforeach; 
                        if($overAll!=0):
                    ?>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align: right;"> <?php echo number_format($overAll, 2, '.',',') ?></th>
                        </tr>
                    <?php
                        endif;
                        
                    ?>
            </tbody>
        </table>
    </div>
    
    
</div>

<script type="text/javascript">
    
    $('#startDate').datepicker({
        orientation: 'left'
    });
    $('#endDate').datepicker({
        orientation: 'left'
    });
    
//     function generateCollection()
//    {
//        var url = '<?php echo base_url() . 'college/finance/collectionReport/' ?>'+$('#startDate').val()+'/'+$('#endDate').val();
//        
//        document.location = url;
//    }
    
     function generateCollection()
    {
        var report_type = ($('#reportType').val()===0?'':$('#reportType').val());
        
        var url = '<?php echo base_url() . 'college/finance/collectionReport/' ?>'+$('#startDate').val()+'/'+$('#endDate').val()+'/'+report_type;
        
        document.location = url;
    }
//    
//     function printSales(option)
//    {
//        //option === 0?'':option;
//        var url = '<?php echo base_url() . 'college/finance/printCollectionReport/' ?>'+$('#startDate').val()+'/'+$('#endDate').val()+'/'+option;
//        
//        window.open(url, '_blank');
//        
//    }
    
     function printSales(option)
    {
        switch(option)
        {
            case '0':
                var url = '<?php echo base_url() . 'college/finance/printCollectionReport/' ?>'+$('#startDate').val()+'/'+$('#endDate').val();
        
                window.open(url, '_blank');
            break;
            case '1':
                var url = '<?php echo base_url() . 'college/finance/printCollectionReportPerTeller/'.base64_encode($this->session->employee_id) ?>/'+$('#startDate').val()+'/'+$('#endDate').val();
        
                window.open(url, '_blank');
            break;
        }
        
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