<div id="canteenAccounts"  style="width:25%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-green" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>Canteen Accounts <small class="mute">( Please scan rfid or <a onclick="$('#searchControls').show(), $('#profile').hide(); $('#wifi').show(); " style="color:white;"  href="#">Click here</a> ) </small>
            <button type="button" class="close pull-right" style="margin-right:20px; display: none;" id="wifi" onclick="setFocus(), $(this).hide(), $('#searchControls').hide()"><i class="fa fa-wifi"></i></button>
        </div>
        <div class="panel-body clearfix">
            <input type="text" id="rfid" style="position: absolute; left:-1000px;" onchange="scanStudents(this.value)" onload="self.focus();" />
            <div class="col-lg-12">
                <div class="controls " id="searchControls" style="display: none;">
                    <input autocomplete="off"  class="form-control" onkeydown="searchStudent(this.value)" name="inputStudent" type="text" id="inputStudent" placeholder="Search Student" required>
                    <input type="hidden" id="userId" name="userId" value="0" />
                  </div>
                  <div style="position: absolute; min-height: 30px; background: #FFF; width:85%; display: none; z-index: 1000" class="resultOverflow" id="studentSearch">

                  </div>
            </div>
            
            <div class="col-lg-12" id="profile" style="display: none;">
                <img id="profileImage" class="img-circle img-responsive pull-left" style="width:100px; border:5px solid #fff" src="<?php echo base_url().'uploads/noImage.png';  ?>" />
                <h4 id="name" style="margin-left:115px; margin-top: 45px;">Firstname Lastname</h4>
                <h5 style="color: red; font-weight: bold; margin-left: 15px; float:left;">Current e-wallet balance: <span id="loadBalance" class="text-danger"></span></h5>
                <!--<h5 id="position">Grade Level</h5>-->
            </div>
            <div class="col-lg-12" style="margin-top: 10px;">
                <div class="controls">
                    <input type="text" class="form-control" id="loadAmount" placeholder="Load Amount"/>
                </div>
            </div>
            <div class="col-lg-12" style="margin-top: 10px;">
                <div class="controls">
                    <input type="text" class="form-control" id="budget" placeholder="Budget Per Day"/>
                </div>
            </div>
            <div class="col-lg-12" style="margin-top: 10px;">
                <div class="controls">
                    <input type="text" class="form-control" id="refill" refill_load="" placeholder="Reload Reminder"/>
                </div>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <button onclick="viewTransactions($('#userId').val())" id="viewTransactionsBtn" class="btn btn-small btn-warning pull-left disabled">View Canteen Transactions</button>
            <div class="control-group pull-right">
                <button onclick="saveLoad()" id="addRoomBtn" class="btn btn-small btn-success">Save</button>
            </div>
        </div>
    </div>
</div>

<div id="viewTransactionPanel"  style="width:50%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-warning" style="margin:0; padding-bottom: 10px;">
        <div class="panel-heading clearfix">
            <div class="col-lg-12">
                <button data-dismiss="modal" class="btn btn-xs btn-danger pull-right"><i class="fa fa-close"></i></button>
                <h4 id="transName" style="margin-top: 10px;">Firstname Lastname</h4>
                <h5 style="color: red; font-weight: bold;  float:left;">Current e-wallet balance: <span id="loadBalanceTrans" class="text-danger"></span> <span class="small">Php</span></h5>
            </div>
        </div>
        <div class="panel-body clearfix" style="overflow-y: scroll; height: 75vh;">
            <table class="table table-hover table-striped">
                <tr>
                    <th>#</th>
                    <th>Transaction #</th>
                    <th>Canteen Items</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
                <tbody id="transBody">
                    
                </tbody>    
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">
    
function checkRefill(load, refill)
{
    //alert(parseFloat(refill))
    if(parseFloat(refill) > parseFloat(load))
    {
        alert('e-Wallet Balance is below the refillable amount. Please contact the Parents / Guardian Immediately')
    }
}
    
function viewTransactions(id)
{
    $('#transName').html($('#name').html());
    $('#loadBalanceTrans').html($('#loadBalance').html())
    $('#canteenAccounts').modal('hide')
    $('#viewTransactionPanel').modal('show');
    
    var url = "<?php echo base_url().'canteen/viewTransactions/'?>"; // the script where you handle the form input.1
     $.ajax({
       type: "POST",
       url: url,
       data: 'user_id='+id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
       success: function(data)
       {
           $('#transBody').html(data)
       }
     });
    return false;  
}

function saveLoad()
{
     var user_id = $('#userId').val();
     var loadAmount = $('#loadAmount').val();
     var budget = $('#budget').val();
     var reload = $('#refill').val();
     var url = "<?php echo base_url().'canteen/saveLoad/'?>"; // the script where you handle the form input.1
     $.ajax({
       type: "POST",
       url: url,
       data: 'user_id='+user_id+'&loadAmount='+loadAmount+'&budget='+budget+'&reload='+reload+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
       success: function(data)
       {
            alert(data)
            $('#canteenAccounts').modal('hide');
       }
     });

    return false;  
}

  
function searchStudent(value)
      {
          var url = "<?php echo base_url().'canteen/searchStudent/'?>"; // the script where you handle the form input.
          if(value==""){
              $('#studentSearch').hide();
              $('#userId').val('0');
          }else{
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $('#studentSearch').show();
                       $('#studentSearch').html(data);
                       $('#viewTransactionsBtn').removeClass('disabled')
                   }
                 });

            return false;  
          }
            
      }     
</script>