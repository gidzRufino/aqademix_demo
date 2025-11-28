<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Loans Application
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement/loans') ?>'">Loans Dashboard</button>
          </div>
    </h3>
</div>
     
<div class="row" id="searchWrapper">
    <div class="col-lg-2"></div>
    <div class="input-group col-lg-8">
        <input onkeyup="search(this.value)" id="searchBox" class="form-control input-lg" type="text" placeholder="Search Name Here" />
        <div onblur="$(this).hide()" style="min-height: 30px; margin-top:46px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchName">

        </div>
        <div class="input-group-btn">
            <button style="height: 46px; width: 150px;" type="button" class="btn btn-default text-center"><i class="fa fa-search fa-2x"></i></button>
          
        </div>
    </div>
</div>
<?php if($id!=NULL): ?>
    <div class='col-lg-12'  id="AccountBody">
        <?php
                $data['basicInfo'] = Modules::run('coopmanagement/getAccountInfoByAccountNumber', $id);
                $this->load->view('../basicAccountInfo', $data);
           ?>
    </div>

<div class="col-lg-12">
    <div class="col-lg-5 pull-right">
        <div class="control-group pull-left" style="margin-right: 5px;">
            <label class="control-label" for="Select Loan Type">Select Loan Type: </label>
            <select id="loanType" onclick="loadLoanDetails(this.value)">
                <option>Select Loan Type</option>
                <?php foreach($loanTypes as $lt): ?>
                    <option value="<?php echo $lt->clt_id ?>"><?php echo $lt->clt_type ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="control-group">
            <label class="control-label pull-left" for="inputDate">Date Applied: </label>
            <div class="controls pull-left">
                <input class="form-control" name="dateApplied" type="text" id="dateApplied" data-date-format="yyyy-mm-dd" placeholder="Date" value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
    </div>
</div>
<hr class="col-lg-12" />
<div class="col-lg-12" id="applicationBody">
    
</div>


<?php  endif; ?>



<script type="text/javascript">
    
    $('#document').ready(function(){
        
        $('#dateApplied').datepicker({
            orientation: "bottom"
        });
    });
    
    var countName = 0;
    function addComaker(addName)
    {
        //alert(addName);\
        var type = $('#loanType').val();
        var val = $('#comakerAdd').html();
        if(val=="")
        {
            $('#comakerAdd').html(addName);
        }else{
            $('#comakerAdd').html(val + ', '+ addName); ;
        }
        countName = parseInt(countName) + 1;
        if(type==1 && countName==2){
            $('#saveBtn').removeClass('disabled');
        }
    }
    
    function search(value)
    {
      var url = '<?php echo base_url().'search/searchEmployee/' ?>'+value;
        $.ajax({
           type: "GET",
           url: url,
           data: "id="+value, // serializes the form's elements.
           success: function(data)
           {
                 $('#searchName').show();
                 $('#searchName').html(data);
           }
         });

    return false;
    }    

    function loadLoanDetails(value)
    {
      var url = '<?php echo base_url().'coopmanagement/loans/loadLoanForm/' ?>'+value;
        $.ajax({
           type: "GET",
           url: url,
           data: "id="+value, // serializes the form's elements.
           success: function(data)
           {
                $('#applicationBody').html(data);
                if(value==1)
                {
                    $('#lppWrapper').show();
                }
           }
         });

    return false;
    }    
    
    function loadAccountDetails(id)
    {
        document.location = '<?php echo base_url().'coopmanagement/loans/application/' ?>'+id;
    }
    
    
</script>    
    