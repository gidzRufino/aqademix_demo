<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Accounting System
        <?php $this->load->view('accounting_menus'); ?>
    </h3>
</div>
<div class="col-lg-12">
    <div class="panel panel-info">
        <div class="panel-heading clearfix">
            <h5 class="no-margin col-lg-4">Accounting Transactions</h5>
            <div class="col-lg-8">
                <button id="searchByDateBtn" class="btn btn-info btn-sm pull-right">search</button>
                <input class="pull-right" name="endDate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo ($this->uri->segment(5)==NULL?date('Y-m-d'):$this->uri->segment(5)) ?>" id="endDate" placeholder="Select End Date" />
                <input class="pull-right" name="startDate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo ($this->uri->segment(4)==NULL?date('Y-m-d'):$this->uri->segment(4)) ?>" id="startDate" placeholder="Select Start Date" />
            
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center" style="width:15%;">Date</th>
                        <th class="text-center">Account Title</th>
                        <th class="text-right">Debit</th>
                        <th class="text-right">Credit</th>
                    </tr>
                </thead>
                <tbody id="je_body">
                    <?php 
                    $i = 1;
                    foreach ($asTransactions as $trans): ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td class="text-center"><?php echo date('F d, Y', strtotime($trans->as_trans_date)) ?></td>
                            <td class="text-center"><?php echo $trans->coa_name ?></td>
                            <td class="text-right debit" tdValue="<?php echo ($trans->as_trans_type?$trans->as_trans_amount:0) ?>"><?php echo ($trans->as_trans_type? number_format($trans->as_trans_amount,2,'.',','):'---') ?></td>
                            <td class="text-right credit" tdValue="<?php echo ($trans->as_trans_type?$trans->as_trans_amount:0) ?>"><?php echo ($trans->as_trans_type==0?number_format($trans->as_trans_amount,2,'.',','):'---') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-right" id="jeDebitTotal"></td>
                        <td class="text-right" id="jeCreditTotal"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php 
$data['cashEquivalents'] = $cashEquivalents;
$data['accountTitles'] = $accountTitles;
$data['countTrans'] = $trans->as_je_num;
$this->load->view('disbursement_modal', $data); 
?>
<?php $this->load->view('as_modal'); ?>
<?php $this->load->view('transaction_modal', $data); ?>

<script type="text/javascript">
    $(document).ready(function(){
        var debTotal = 0;
        var credTotal = 0;
        $('#je_body .debit').each(function(){
            var deb = $(this).attr('tdValue');
            debTotal = parseFloat(debTotal) + parseFloat(deb);
            
        });
        $('#jeDebitTotal').html(numberWithCommas(debTotal.toFixed(2)));
        $('#je_body .credit').each(function(){
            var cred = $(this).attr('tdValue');
            credTotal = parseFloat(debTotal) + parseFloat(cred);
            
        });
        $('#jeCreditTotal').html(numberWithCommas(credTotal.toFixed(2)));
        
        $('#startDate').datepicker();
        $('#endDate').datepicker();
        
        $('#searchByDateBtn').click(function(){
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var url = "<?php echo base_url().'accountingsystem/getTransactionByDate/' ?>"+startDate+'/'+endDate
            
            $.ajax({
                type: "GET",
                url: url,
                //dataType:'json',
                beforeSend: function (){
                    $('#je_body').html('<i style="color:#F70000" class="fa fa-spinner fa-spin fa-fw" ></i>');
                    debTotal = 0;
                    credTotal = 0;
                },
                data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data)
                {   
                    $('#je_body').html(data);
                    
                    $('#je_body .debit').each(function(){
                        var deb = $(this).attr('tdValue');
                        debTotal = parseFloat(debTotal) + parseFloat(deb);

                    });
                    $('#jeDebitTotal').html(numberWithCommas(debTotal.toFixed(2)));
                    $('#je_body .credit').each(function(){
                        var cred = $(this).attr('tdValue');
                        credTotal = parseFloat(debTotal) + parseFloat(cred);

                    });
                    $('#jeCreditTotal').html(numberWithCommas(credTotal.toFixed(2)));
                }
            });
        });
        
        $('#confirmDeleteTransBtn').click(function(){
            var je_num = $('#deleteController').val();
            
            var startDate = $('#jeDetailsDateFrom').val();
            var endDate = $('#jeDetailsDateTo').val();
            var url = "<?php echo base_url().'accountingsystem/deleteASTrans/' ?>";
            $.ajax({
                type: "POST",
                url: url,
                //dataType:'json',
                beforeSend: function (){
                    $('#je_body').html('<i style="color:#F70000" class="fa fa-spinner fa-spin fa-fw" ></i>');
                    debTotal = 0;
                    credTotal = 0;
                },
                data: 'je_num='+je_num+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function(data)
                {   
                    alert(data);
                    var url2 = "<?php echo base_url().'accountingsystem/getTransactionByDate/' ?>"+startDate+'/'+endDate
                    
                    $.ajax({
                        type: "GET",
                        url: url2,
                        //dataType:'json',
                        beforeSend: function (){
                            $('#je_body').html('<i style="color:#F70000" class="fa fa-spinner fa-spin fa-fw" ></i>');
                            debTotal = 0;
                            credTotal = 0;
                        },
                        data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                        success: function(data)
                        {   
                            $('#je_body').html(data);

                            $('#je_body .debit').each(function(){
                                var deb = $(this).attr('tdValue');
                                debTotal = parseFloat(debTotal) + parseFloat(deb);

                            });
                            $('#jeDebitTotal').html(numberWithCommas(debTotal.toFixed(2)));
                            $('#je_body .credit').each(function(){
                                var cred = $(this).attr('tdValue');
                                credTotal = parseFloat(debTotal) + parseFloat(cred);

                            });
                            $('#jeCreditTotal').html(numberWithCommas(credTotal.toFixed(2)));
                        }
                    });
                }
            });
        });
        
    });
    
    
    function numberWithCommas(x) {
        if(x==null){
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>    


<div id="confirmDeleteModal"  style="width:35%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-red" style='width:100%;'>
        <div class="panel-heading">
            <h3>
                <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to delete this transaction? Note: This will also delete the corresponding transaction connected in this Journal Entry
            </h3>
        </div>
        <div class="panel-body">
            <div style='margin:5px 0;'>
                <a href='#' id='confirmDeleteTransBtn' data-dismiss='modal' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-left'>Delete</a>
                <button data-dismiss='modal' class='btn btn-xs btn-warning pull-left'>Cancel</button>&nbsp;&nbsp;
            </div>

        </div>
    </div>
</div>