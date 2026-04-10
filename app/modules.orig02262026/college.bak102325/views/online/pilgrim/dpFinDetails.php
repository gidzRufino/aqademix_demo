<div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px; overflow-y: scroll">  
    <div style="width: 100%" class="col-lg-12 no-padding">
        <div class="form-group pull-left">
            <h4 class="text-left no-margin col-lg-12 col-xs-12 no-padding">FINANCE OBLIGATION</h4>
        </div>

    </div>
    
    <div style="width: 100%; overflow-y: scroll;" class="pull-left col-lg-12" id="schedDetails">
                <div class="col-lg-1"></div>
                <div class="col-lg-10 col-md-12 col-xs-12">
                    <div class="alert alert-info clearfix">
                        <?php
                        if (count($remarks)):
                            ?>
                            <p class="text-center" style="font-size: 18px;"><?php echo $remarks->fr_remarks; ?> </p> <br/>
                        <?php else: ?>
                            <p class="text-center">Pay a minimum amount of &#8369; 1,000.00 to the following payment centers: </p> <br/>
                        <?php endif; ?>
                        <p class="text-center">To the following payment centers: </p> <br/>
                        <table class="table table-striped" style="background: white;">
                            <tr>
                                <th class="text-center" colspan="2">Bank Details</th>
                            </tr>
                            <tr>
                                <td class="text-center"><img src="<?php echo base_url('images/banks/') ?>boc.png" style="height:70px; margin:3px auto;" title="boc" alt="boc" /></td>
                                <td>Branch : Cagayan de Oro - Velez<br />
                                    Account Name : Pilgrim Christian College<br />
                                    Savings Account #: 024-00-002376-7
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center"><img src="<?php echo base_url('images/banks/') ?>dbp.jpg" style="height:60px; margin:3px auto;" title="dbp" alt="dbp" /></td>
                                <td>Branch: Cagayan de Oro Velez <br />
                                    Account Name: Pilgrim Christian College<br />
                                    Checking Account #: 0810-020228-030
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center"><img src="<?php echo base_url('images/banks/') ?>psbank.jpg" style="width:120px; margin:3px auto;" title="psbank" alt="psbank" /></td>
                                <td>Branch: Cagayan de Oro Velez <br />
                                    Account Name: Pilgrim Christian College<br />
                                    Checking Account #: 100292000198
                                </td>
                            </tr>
                        </table>
                        <table class="table table-striped" style="background: white;">
                            <tr>
                                <th class="text-center" colspan="3">Pera Padala Centers</th>
                            </tr>
                            <tr>
                                <td class="col-lg-4 text-center"><img src="<?php echo base_url('images/banks/') ?>palawan.png" style="width:120px; margin:3px auto;" title="palawan" alt="boc" /></td>
                                <td class="col-lg-4 text-center"><img src="<?php echo base_url('images/banks/') ?>cebuana.png" style="height:45px;  margin:3px auto;" title="ml" alt="ml" /></td>
                                <td class="col-lg-4 text-center"><img src="<?php echo base_url('images/banks/') ?>rd.jpg" style="width:90px;  margin:3px auto;" title="rd" alt="rd" /></td>

                            </tr>
                            <tr>
                                <td colspan="3" class="text-center">SEND TO</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-center">
                                    Name: Alfred Yecyec <br />
                                    Address: Pilgrim Christian College, Capistrano-Akut Sts. CDO City<br />
                                    Contact No: 09355707888
                                </td>
                            </tr>
                        </table>
                        <table class="table table-striped" style="background: white;">
                            <tr>
                                <th class="text-center" colspan="2">SEND THROUGH GCASH</th>
                            </tr>
                            <tr>
                                <td class="text-center"><img src="<?php echo base_url('images/banks/') ?>gcash.png" style="width:50px; margin:3px auto;" title="gcash" alt="gcash" /></td>

                                <td colspan="2">
                                    Account Name: Fausto S. Abella <br />
                                    Number: 09177173554
                                </td>
                            </tr>
                        </table>
                        <p class="text-center"> Upload the payment receipt if payment has been made</p><br />
                        <button onclick="$('#uploadReceipt').modal('show')" class="btn btn-success btn-xs pull-left">Upload Receipt</button>
                        <button onclick="document.location = '<?php echo base_url('entrance') ?>'" class="btn btn-danger btn-xs pull-right">Close</button>
                    </div>
                </div>
            </div>
</div>

<input type="hidden" id="st_id" value="<?php echo base64_encode($student->st_id) ?>" />
<input type="hidden" id="user_id" value="<?php echo base64_encode($student->user_id) ?>" />
<input type="hidden" id="school_year" value="<?php echo $student->school_year ?>" />
<input type="hidden" id="semester" value="<?php echo $student->semester ?>" />
<input type="hidden" id="adm_id" value="<?php echo $student->admission_id ?>" />


<div id="uploadReceipt" class="modal fade col-lg-2 col-xs-10" style="margin:30px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix alert-success" style="border-radius:15px 15px 0 0; ">
        Upload Payment Receipt
        <button class="btn btn-xs pull-right" onclick="$('#uploadReceipt').modal('hide')"><i class="fa fa-close"></i></button>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px; border:1px solid #ccc; padding: 5px 10px 10px; overflow-y: scroll">  
        <div class="modal-body">
            <form id="upload_form" enctype="multipart/form-data" method="post">
                <select class="form-control" id="payment_center">
                    <option>Select Payment Center</option>
                    <option  value="boc">BANK OF COMMERCE</option>
                    <option  value="dbp">Development Bank of the Philippines</option>
                    <option  value="psb">PSBank</option>
                    <option  value="palawan">Palawan Pera Padala</option>
                    <option  value="cebuana">Cebuana Pera Padala</option>
                    <option  value="rd">RD Pawnshop Money Remitance</option>
                    <option  value="gcash">GCash</option>
                    <option  value="walk_in">Walk In</option>
                </select><br />    
                <input type="file" name="userfile" id="userfile"><br>
                <input class="btn btn-success" type="button" value="Upload File" onclick="uploadFile()"> <br /> <br />
                 <div class="progress" id="progressBarWrapper" style="display: none;">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                      UPLOADING RECEIPT...
                    </div>
                  </div> 
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    function uploadFile() {
	var file = document.getElementById("userfile").files[0];
        // alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();
        formdata.append("userfile", file);
        formdata.append('csrf_test_name', $.cookie('csrf_cookie_name'));
        formdata.append('st_id', $('#st_id').val());
        formdata.append('department', '<?php echo $this->session->department ?>');
        formdata.append('school_year', $('#school_year').val());
        formdata.append('semester', $('#semester').val());
        formdata.append('paymentCenter', $('#payment_center').val());
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "<?php echo base_url() . 'college/enrollment/uploadPaymentReceipt/' ?>");
        ajax.send(formdata);
    }
    function progressHandler(event) {

        $('#progressBarWrapper').show();
       
    }
    function completeHandler(event) {
       // _("status").innerHTML = event.target.responseText;
        $("#progressBarWrapper").hide();
        alert(event.target.responseText);
        document.location = '<?php echo base_url('entrance'); ?>';
    }
    function errorHandler(event) {
       // _("status").innerHTML = "Upload Failed";
    }
    function abortHandler(event) {
      //  _("status").innerHTML = "Upload Aborted";
    }
    
</script>    
