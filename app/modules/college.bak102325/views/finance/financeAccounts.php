<?php
    switch ($sem):
        case 1:
            $semester = 'First Semester';
        break;
        case 2:
            $semester = 'Second Semester';
        break;
        case 3:
            $semester = 'Summer';
        break;
    endswitch;
?>
<div class="col-lg-12">
    <h3 style="margin:10px 0;" class="page-header">Finance Accounts
            <input type="text" id="rfid" style="position: absolute; left:-1000px;" onchange="scanStudents(this.value)" onload="self.focus();" />
        
        <div class="btn-group pull-right" role="group" aria-label="">
                
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/finance') ?>'">Fee Schedule</button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Reports</button>
            <button type="button" class="btn btn-default" onclick="$('#searchOR').modal('show')" >Search OR</button>
            <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('finance/accounts') ?>'" >Basic Education Accounts</button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li onclick="document.location='<?php echo base_url('college/finance/collectionReport/')?>'+$('#inputSem').val()"><a href="#">Generate Collection</a></li>
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
                <div class="input-group col-lg-7 pull-left">
                    <input type="text" onkeyup="search(this.value)" id="searchBox"  class="form-control input-lg" aria-label="..." placeholder="Search Name Here" >
                    
                    <div onblur="$(this).hide()" style="min-height: 30px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 85%; display: none; margin-top: 45px;" class="resultOverflow" id="searchName">

                    </div>
                    <div class="input-group-btn">
                      <button style="height: 46px; width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $semester ?> <span class="caret"></span></button>
                      <ul class="dropdown-menu dropdown-menu-right">
                            <li onclick="$('#btnControl').html('First Semester <span class=\'caret\'></span>'), $('#inputSem').val(1)"><a href="#">First Semester</a></li>
                            <li onclick="$('#btnControl').html('Second Semester <span class=\'caret\'></span>'), $('#inputSem').val(2)"><a href="#">Second Semester</a></li>
                            <li onclick="$('#btnControl').html('Summer  <span class=\'caret\'></span>'), $('#inputSem').val(3)"><a href="#">Summer</a></li>
                      </ul> 
                      <input type="hidden" id="inputSem" value="<?php echo $sem ?>" />
                    </div><!-- /btn-group -->
                </div>
                
                <div class="col-lg-2">
                    <div class="form-group">
                        <select onclick="getStudentByYear(this.value)" tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;">
                            <option>School Year</option>
                            <?php 
                                  foreach ($ro_year as $ro)
                                   {   
                                      $roYears = $ro->ro_years+1;
                                      if($this->uri->segment(6)==$ro->ro_years):
                                          $selected = 'Selected';
                                      else:
                                          $selected = '';
                                      endif;
                                  ?>                        
                                <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years.' - '.$roYears; ?></option>
                                <?php }?>
                        </select>
                     </div>
                    
                    <?php if($id==NULL): ?>
                        <button class="btn btn-primary pull-right" onclick="$('#cashRegister').modal('show')">Other Account</button>
                    <?php 
                        $this->load->view('otherAccounts');
                        endif;
                    ?>
                </div>
                
    
            </div>
            
        <div class='col-lg-12'  id="AccountBody">
            <?php if($id!=NULL): 
                echo Modules::run('college/finance/loadAccountDetails', $id, $sem, $this->uri->segment(6));
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
                <button title="Cancel Reciept" onclick="$('#confirmCancelReceipt').modal('show')" class="btn btn-warning btn-sm pull-right"><i class="fa fa-trash fa-fw"></i></button>
            </h3>
        </div>
        <div class="panel-body">
            <div class="col-lg-2"></div>
            <div class="input-group col-lg-8">
                <input onkeyup="searchOR(this.value)" id="searchReceiptBox" class="form-control input-lg" type="text" placeholder="Search Receipts Here" />
                <div onblur="$(this).hide()" style="min-height: 30px; margin-top:46px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 97%; display: none" class="resultOverflow" id="searchReceipt">

                </div>
                <div class="input-group-btn">
                  <button style="height: 46px; width: 150px;" type="button" class="btn btn-default dropdown-toggle" id="btnReceiptControl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->school_year.' - '.($this->session->school_year+1) ?> <span class="caret"></span></button>
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
            <hr class="col-lg-11" />
            <div class="col-lg-12" id="orDetails">
                
            </div>
        </div>
    </div>
</div>

<div id="confirmCancelReceipt"  style="width:35%; margin: 70px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger" style='width:100%;'>
        <div class="panel-heading">
            <h3>
                <i class="fa fa-info-circle fa-fw"></i> Are you Sure you want to cancel this receipt? Take Note you cannot undo the process.
            </h3>
        </div>
        <div class="panel-body">
            <div style='margin:5px 0;'>
            <a href='#' data-dismiss='modal' style='margin-right:10px; color: white;' class='btn btn-xs btn-success pull-right'>NO</a>
            <a href='#' data-dismiss='modal' onclick='cancelReceipt()' style='margin-right:10px; color: white;' class='btn btn-xs btn-danger pull-right'>YES</a>
            
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    
    $(document).ready(function(){
        setFocus();
        $("#inputSY").select2();
        
        shortcut.add("alt+p",function() {
            $('#cashRegister').modal('show');
        });
        shortcut.add("shift+i",function() {
           window.setTimeout(function () { 
                document.getElementById("ptAmountTendered").focus();
            }, 500);
        });
        shortcut.add("shift+0",function() {
           window.setTimeout(function () { 
                document.getElementById("searchBox").focus();
            }, 500);
        });
        shortcut.add("shift+1",function() {
           setFocus();
        });
        
        shortcut.add("F1",function() {
           document.location='<?php echo base_url() ?>finance/accounts';
        });
        shortcut.add("F2",function() {
           $('#addCashItemModal').modal('show');
           
           window.setTimeout(function () { 
                document.getElementById("cashFinItems").focus();
            }, 500);
        });
    });
    
    
    function cancelReceipt(){
        
        var receiptNumber = $('#searchReceiptBox').val();
        var url = "<?php echo base_url().'college/finance/cancelReceipt'?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "receiptNumber="+receiptNumber+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   alert(data)
                   location.reload()
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
     
    
   function loadDetails(st_id)
   {
       var sem = $('#inputSem').val();
       var sy = $('#inputSY').val();
       var url = '<?php echo base_url().'college/finance/loadAccountDetails/' ?>'+st_id+'/'+sem+'/'+sy;
            $.ajax({
               type: "GET",
               url: url,
               data: "id="+st_id, // serializes the form's elements.
               success: function(data)
               {
                    // $('#AccountBody').html(data);
                    document.location = '<?php echo base_url().'college/finance/accounts/' ?>'+st_id+'/'+sem+'/'+sy;
               }
             });

        return false;
   }

   function search(value)
      {
          
          var sy = $('#inputSY').val();
          var url = '<?php echo base_url().'search/searchStudentAccounts/' ?>'+value+'/'+sy+'/'+$('#inputSem').val();
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
     
     
    function numberWithCommas(x) {
            if(x==null){
                x = 0;
            }
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        
        function setFocus()
    {
        window.setTimeout(function () { 
            document.getElementById("rfid").focus();
        }, 500);
    }
    
    
    function scanStudents(value)
    {
         var url = "<?php echo base_url().'college/scanStudent/'?>"+value; // the script where you handle the form input.
             $.ajax({
                   type: "POST",
                   url: url,
                   dataType:'json',
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#rfid').val('');
                       document.location = '<?php echo base_url('college/finance/accounts/') ?>'+data.st_id
                       //console.log(data)
                   }
                 });

            return false;  
    }    
     
     function avoidInvalidKeyStorkes(evtArg) {
        var evt = (document.all ? window.event : evtArg);
        var isIE = (document.all ? true : false);
        var KEYCODE = (document.all ? window.event.keyCode : evtArg.which);

        var element = (document.all ? window.event.srcElement : evtArg.target);
        var msg = "We have disabled this key: " + KEYCODE;

        if (KEYCODE >= "112" && KEYCODE <= "123") {
            if (isIE) {
                document.onhelp = function() {
                    return (false);
                };
                window.onhelp = function() {
                    return (false);
                };
            }
            evt.returnValue = false;
            evt.keyCode = 0;
            window.status = msg;
            evt.preventDefault();
            evt.stopPropagation();
            //alert(msg);
        }

        window.status = "Done";

    }


    if (window.document.addEventListener) {
        window.document.addEventListener("keydown", avoidInvalidKeyStorkes, false);
    } else {
        window.document.attachEvent("onkeydown", avoidInvalidKeyStorkes);
        document.captureEvents(Event.KEYDOWN);
    }

</script>

<script src="<?php echo base_url(); ?>assets/js/plugins/shortcut.js"></script>
<?php $this->load->view('financeModals'); 
