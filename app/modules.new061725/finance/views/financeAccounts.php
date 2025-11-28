<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">Finance Accounts
        <div class="btn-group pull-right" role="group" aria-label="">
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('main/dashboard') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance') ?>'">Settings</button>
            <button type="button" class="btn btn-default" onclick="$('#searchOR').modal('show')" >Search OR</button>
            <button class="btn btn-primary" onclick="$('#cashRegister').modal('show')">Other Account</button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Reports</button>
            <?php if($this->eskwela->getSet()->level_catered == 0): ?>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance/accounts') ?>'" >College Accounts</button>
            <?php endif; ?>
            <ul class="dropdown-menu dropdown-menu-right">
                <li onclick="document.location='<?php echo base_url('finance/collectionReport') ?>'"><a href="#">Generate Collection</a></li>
                <li onclick="$('#chequeEncashments').modal()"><a href="#">Cheque Encashments</a></li>
                <li onclick="$('#cashBreakdown').modal('show')"><a href="#">Cash Breakdown</a></li>
                <?php
                    if($this->session->is_admin):
                ?>
                <li onclick="document.location='<?php echo base_url('college/finance/financeLog') ?>'"><a href="#">View Finance Log</a></li>
                <?php
                    endif;
                ?>
            </ul>            

          </div>
    </h3>
    <div class='col-lg-12'>
        
            <div class="row" id="searchWrapper">
                <div class="col-lg-2"></div>
                <div class="input-group col-lg-8">
                    <input onkeyup="search(this.value)" id="searchBox" class="form-control input-lg" type="text" placeholder="Search Name Here" />
                    <div onblur="$(this).hide()" style="min-height: 30px; margin-top:46px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchName">

                    </div>
                    <div class="input-group-btn">
                      <button style="height: 46px; width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $school_year.' - '.($school_year+1) ?> <span class="caret"></span></button>
                      <ul class="dropdown-menu dropdown-menu-right">
                            <?php $ro_years = Modules::run('registrar/getROYear');
                            
                                foreach ($ro_years as $ro)
                                {   
                                  $roYears = $ro->ro_years+1;
                              
                            ?>    
                                    <li onclick="$('#btnControl').html('<?php echo $ro->ro_years.' - '.$roYears; ?>  <span class=\'caret\'></span>'), $('#inputSchoolYear').val('<?php echo $ro->ro_years ?>')"><a href="#"><?php echo $ro->ro_years.' - '.$roYears; ?></a></li>
                            <?php } ?>
                      </ul> 
                      <input type="hidden" id="inputSchoolYear" value="<?php echo $school_year ?>" />
                    </div><!-- /btn-group -->
                </div>
                <div class="col-lg-2 pull-right">
                    <select tabindex="-1" id="inputSem" style="width:200px; font-size: 15px;" class=" ">
                        <option <?php echo ($this->uri->segment(5) == 0 || '' ? 'selected' : '') ?> value="0">Regular School Year</option>
                        <option <?php echo ($this->uri->segment(5) == 3 ? 'selected' : '') ?> value="3">Summer</option>
                    </select>
                </div>
                <?php if($id==NULL): ?>
                <?php 
                    $this->load->view('otherAccounts');
                    endif;
                ?>
            </div>
            
        <div class='col-lg-12'  id="AccountBody">
            <?php if($id!=NULL): 
                echo Modules::run('finance/loadAccountDetails', $id, $school_year, ($semester!=3?0:3));
            endif;
?>
        </div>
    </div>
</div>
<div id="searchOR"  style="width:50%; margin: 70px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green" style='width:100%;'>
        <div class="panel-heading">
            <h3>
                <i class="fa fa-info-circle fa-fw"></i> Search Receipts
                <button class="btn btn-danger pull-right btn-sm" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </h3>
        </div>
        <div class="panel-body">
            <div class="col-lg-2"></div>
            <div class="input-group col-lg-8">
                <input onkeyup="searchOR(this.value)" id="searchReceiptBox" class="form-control input-lg" type="text" placeholder="Search Receipts Here" />
                <div onblur="$(this).hide()" style="min-height: 30px; margin-top:46px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchReceipt">

                </div>
                <div class="input-group-btn">
                  <button style="height: 46px; width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnReceiptControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $school_year.' - '.($school_year+1) ?> <span class="caret"></span></button>
                  <ul class="dropdown-menu dropdown-menu-right">
                        <?php $ro_years = Modules::run('registrar/getROYear');

                            foreach ($ro_years as $ro)
                            {   
                              $roYears = $ro->ro_years+1;

                        ?>    
                                <li onclick="$('#btnReceiptControl').html('<?php echo $ro->ro_years.' - '.$roYears; ?>  <span class=\'caret\'></span>'), $('#inputSchoolYearReceipts').val('<?php echo $ro->ro_years ?>')"><a href="#"><?php echo $ro->ro_years.' - '.$roYears; ?></a></li>
                        <?php } ?>
                  </ul> 
                  <input type="hidden" id="inputSchoolYearReceipts" value="<?php echo $school_year ?>" />
                </div><!-- /btn-group -->
            </div>
            <hr class="col-lg-12" />
            <div class="col-lg-12" id="orDetails">
                
            </div>
        </div>
    </div>
</div>
<?php
?>

<script type="text/javascript">
    $(document).ready(function(){
        
        shortcut.add("alt+p",function() {
            alert('hey')
            //$('#cashRegister').modal('show');
        });
        shortcut.add("shift+0",function() {
           window.setTimeout(function () { 
                document.getElementById("searchBox").focus();
            }, 500);
        });
        shortcut.add("shift+i",function() {
           window.setTimeout(function () { 
                document.getElementById("ptAmountTendered").focus();
            }, 500);
        });
        shortcut.add("F1",function() {
           document.location='http://localhost/e-sKwela/college/finance/accounts';
        });
        
    });
   function loadDetails(st_id, sy, semester)
   {
        
       var url = '<?php echo base_url().'finance/loadAccountDetails/' ?>'+st_id+'/'+sy+'/'+semester;
            $.ajax({
               type: "GET",
               url: url,
               data: "id="+st_id, // serializes the form's elements.
               success: function(data)
               {
                    // $('#AccountBody').html(data);
                    document.location = '<?php echo base_url().'finance/accounts/' ?>'+st_id+'/'+sy+'/'+semester;
               }
             });

        return false;
   }
    
   function loadORDetails(ref_number, sy)
   {  
       var url = '<?php echo base_url().'finance/loadORDetails/' ?>'+ref_number+'/'+sy;
            $.ajax({
               type: "GET",
               url: url,
               data: "id="+ref_number, // serializes the form's elements.
               success: function(data)
               {
                   $('#orDetails').html(data);
               }
             });

        return false;
   }

   function search(value)
      {
          var school_year = $('#inputSchoolYear').val()
          var sem  = $('#inputSem').val()
          var url = '<?php echo base_url().'search/searchStudentAccountsK12/' ?>'+value+'/'+school_year+'/'+sem;
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

   function searchOR(value)
      {
          var school_year = $('#inputSchoolYearReceipts').val()
          var url = '<?php echo base_url().'finance/searchReceipt/' ?>'+value+'/'+school_year;
            $.ajax({
               type: "GET",
               url: url,
               data: "id="+value, // serializes the form's elements.
               success: function(data)
               {
                     $('#searchReceipt').show();
                     $('#searchReceipt').html(data);
               }
             });

        return false;
      }
     
     
    function numberWithCommas(x) {
            if(x==null){
                x = 0;
            }
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
     
    

</script>

<script src="<?php echo base_url(); ?>assets/js/plugins/shortcut.js"></script>

<?php $this->load->view('financeModals'); 