<div class="col-lg-2"></div>
<div class="well col-lg-8" id="loanDetails">
    <h3 class="text-center no-margin">Loan Details</h3>
    <hr class="col-lg-12 no-margin" />
    <div class="form-group form-horizontal col-lg-6">
        <label class="control-label" for="Height">Principal Amount</label>
        <input  class="form-control" onchange="calculateAmortization()" name="loanAmount" type="text" id="loanAmount" placeholder="Loan Amount" required>
    </div>
    <div class="form-group form-horizontal col-lg-6">
        <label class="control-label" for="Height">Interest Rate</label>
        <input  class="form-control" name="idisplay" value="<?php echo ($loanType->clt_interest*100).'%' ?>" type="text" placeholder="" disabled>
        <input  class="form-control" name="interest" value="<?php echo $loanType->clt_interest ?>" type="hidden" id="interest" placeholder="" disabled>
        <input  class="form-control" name="serviceCharge" value="<?php echo $loanType->clt_service_charge ?>" type="hidden" id="serviceCharge" placeholder="" disabled>
        <input  class="form-control" name="clt_id" value="<?php echo $loanType->clt_id ?>" type="hidden" id="clt_id" placeholder="" disabled>
    </div>
    <hr class="col-lg-12 no-padding no-margin" />
    <div class="form-group form-horizontal col-lg-6">
        <label class="control-label" for="Height">Loan Terms</label>
        <input  class="form-control" onkeypress="calculateAmortization()" name="loanTerm" type="text" id="loanTerm" placeholder="No of Months" required>
    </div>
    <div class="form-group form-horizontal col-lg-6">
        <label class="control-label" for="Height">Total Loan Amortization</label>
        <input style="font-weight: bold; font-size:22px; color: red;"  class="form-control text-center" name="loanAmortization" type="text" id="loanAmortization" disabled>
    </div>
    <div id="lppWrapper" class="form-group form-horizontal col-lg-6" style="display: none;">
        <label class="control-label" for="lpp">Loan Protection</label>
        <input style="font-weight: bold; font-size:22px; color: red;"   class="form-control text-center" name="loanProtection" type="text" id="loanProtection" disabled>
        <label class="control-label" for="lpp">Capital Build Up</label>
        <input style="font-weight: bold; font-size:22px; color: red;"   class="form-control text-center" value="50" name="cbu" type="text" id="cbu" disabled>
    </div>
    <hr class="col-lg-12 no-padding no-margin" />
    <div class="form-group form-horizontal col-lg-12" id="amortSched">
        
    </div>
</div>


<script type="text/javascript">
    
    function getAmortSchedule()
    {
        var p = parseFloat($('#loanAmount').val());
        var i = parseFloat($('#interest').val());
        var m = parseFloat($('#loanTerm').val());
        var sc = parseFloat($('#serviceCharge').val());
        var dateApplied = $('#dateApplied').val();
        if($('#clt_id').val()==1){
            var lpp = parseFloat('<?php echo $loanType->clt_clpp ?>');
            var loanProtection = ((p*lpp*m)/1000).toFixed(2);
            var cbu = $('#cbu').val();
        }else{
            loanProtection = 0;
            cbu = 0;
        }
        var url = '<?php echo base_url().'coopmanagement/loans/loadAmortizationSample/' ?>';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                principal       : p,
                interest        : i,
                terms           : m,
                serviceCharge   : sc,
                clpp            : loanProtection,
                dateApplied     : dateApplied,
                loanType        : $('#clt_id').val(),
                cbu             : cbu,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data)
            {
                $('#amortSched').html(data);
                $('#loanProtection').val(loanProtection);
                if($('#clt_id').val()==1 || $('#clt_id').val()==3){  
                    if(p>parseFloat($('#a_share_capital').attr('val')))
                    {
                        $('#comakerWrapper').show();
                        $('#saveBtn').addClass('disabled');
                    }
                }
                    
                  
            }
         });

        return false;
    }
    
    function calculateAmortization()
    {
        var sc = 0;
        if($('#clt_id').val()==2){
            $('#loanTerm').val(1);
            $('#loanTerm').attr( "disabled", "disabled" );
            sc = $('#serviceCharge').val();
        }
        
        var Amortization = 0;
        var p = parseFloat($('#loanAmount').val());
        var i = parseFloat($('#interest').val());
        var m = parseFloat($('#loanTerm').val());
        
        Amortization = p + ((parseFloat(p)*parseFloat(i)*m))+(parseFloat(p)*sc);
        
        if(!isNaN(Amortization)){
            $('#loanAmortization').val(numberWithCommas(Amortization.toFixed(2)));
            getAmortSchedule();
        }
        
        
        
    }
    
    
    function numberWithCommas(x) {
        if(x==null){
            x = 0;
        }
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    
</script>    