<div class="col-lg-12 no-padding">
    <h3 style="margin:10px 0;" class="page-header">Coop Profile Management
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement') ?>'">Coop Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('coopmanagement/loans') ?>'">Loans Managment</button>
            <?php if($id!=NULL): ?>
                <button id="addTransactionBtn" type="button" class="btn btn-default" onclick="$('#cashRegister').modal('show')">Add Transaction</button>
            <?php endif; ?>    
          </div>
    </h3>
</div>
<div class="col-lg-12 col-sm-12">
    <div class="col-lg-6 col-xs-12">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <?php $totalRegular = Modules::run('coopmanagement/getTotalMembers',5000, '>=') ?>
                    <div class="col-xs-3">
                        <i  class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $totalRegular; ?></div>
                        <div>Total Number of Regular Members</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <?php $totalAssociate = Modules::run('coopmanagement/getTotalMembers',5000, '<') ?>
                    <div class="col-xs-3">
                        <i  class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $totalAssociate; ?></div>
                        <div>Total Number of Associate Members</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
<div class="col-lg-12" id="AccountBody">
    <?php
        if($id!=NULL):
            echo Modules::run('coopmanagement/membersProfile', $id);
        endif;
    ?>
</div>


<?php 
    $data['transType'] = Modules::run('coopmanagement/getTransactionType');
    $this->load->view('cashRegister', $data);
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#loanWrapper').hide();
    });
    
    
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

    function loadAccountDetails(id)
    {
      var url = '<?php echo base_url().'coopmanagement/members/' ?>'+id;
      document.location = url;
      
//        $.ajax({
//           type: "GET",
//           url: url,
//           data: "id="+id, // serializes the form's elements.
//           success: function(data)
//           {
//                 $('#AccountBody').html(data);
//                 $('#addTransactionBtn').show();
//           }
//         });
//
//    return false;
    }
</script> 