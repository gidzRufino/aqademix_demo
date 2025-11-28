<div class="container-fluid">
    <div class="col-lg-12">
        <h3 style="margin:10px 0;" class="page-header">Canteen Dashboard
        </h3>
    </div>
    <div class="row">
        <div class="well" style="margin-bottom: 0px">
            <div class="row">
                <div class="col-lg-3">
                    <button onclick="document.location='<?php echo base_url('canteen/pos') ?>'" type="button" class="btn btn-primary" style="text-align:center; width:100%; height:130px;">
                            <div class="col-md-12">
                                    <i class="fa fa-calculator fa-4x"></i><br/>
                                    <h4>POS</h4>
                            </div>
                    </button>
                </div>
                <div class="col-lg-3">
                    <button  onclick="document.location='<?php echo base_url('canteen/products') ?>'" type="button" class="btn btn-warning" style="text-align:center; width:100%; height:130px;">
                            <div class="col-md-12">
                                    <i class="fa fa-building fa-4x"></i><br/>
                                    <h4>Inventory</h4>
                            </div>
                    </button>
                </div>
                <div class="col-lg-3">
                    <button  onclick="document.location='<?php echo base_url('canteen/sales') ?>'" type="button" class="btn btn-danger" style="text-align:center; width:100%; height:130px;">
                            <div class="col-md-12">
                                    <i class="fa fa-money fa-4x"></i><br/>
                                    <h4>Sales</h4>
                            </div>
                    </button>
                </div>
                <div class="col-lg-3">
                    <button  onclick="$('#canteenAccounts').modal('show'), setFocus()" type="button" class="btn btn-info" style="text-align:center; width:100%; height:130px;">
                            <div class="col-md-12">
                                    <i class="fa fa-user fa-4x"></i><br/>
                                    <h4>Accounts</h4>
                            </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('canteen_accounts'); 
?>
<script type="text/javascript">
    function setFocus()
    {
        window.setTimeout(function () { 
            document.getElementById("rfid").focus();
        }, 500);
    }
    
    
function scanStudents(value)
{
     var url = "<?php echo base_url().'canteen/scanStudent/'?>"; // the script where you handle the form input.
         $.ajax({
               type: "POST",
               url: url,
               dataType:'json',
               data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   $('#name').html(data.firstname+' '+data.lastname);
                   $('#profile').show();
                   $('#profileImage').attr('src','<?php echo base_url().'uploads/' ?>'+data.avatar);
                   $('#userId').val(data.user_id);
                   $('#rfid').val('')
                   $('#loadBalance').html(data.load)
                   $('#viewTransactionsBtn').removeClass('disabled')
               }
             });

        return false;  
}
</script>
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>

