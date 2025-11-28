<div id="creditModal"  style="width:25%; margin: 50px auto;"  class="modal fade" tabindex="-1" role="dialog" backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <button type="button" class="close pull-right" style="margin-right:20px; display: none;" id="wifi" onclick="setFocus(), $(this).hide(), $('#searchControls').hide()"><i class="fa fa-wifi"></i></button>
                <h4 class="modal-title"><b>Please Scan RFID or</b> ( <a onclick="$('#searchControls').show(), $('#profile').hide(); $('#wifi').show(); " style="color:black;"  href="#">Click here</a> ) </h4>
            </div>
            <div class="modal-body">
                <div class="row1">
                    <div class="col-lg-12">
                        <div class="controls " id="searchControls" style="display: none;">
                            <input autocomplete="off"  class="form-control" onkeydown="searchStudent(this.value)" name="inputStudent" type="text" id="inputStudent" placeholder="Search Student" required>
                            <input type="hidden" id="userId" name="userId" value="0" />
                          </div>
                          <div style="position: absolute; min-height: 30px; background: #FFF; width:85%; display: none; z-index: 1000" class="resultOverflow" id="studentSearch">

                          </div>
                    </div>
                    <div class="col-md-12">
                        
                        <input type="text" id="rfid" style="position: absolute; left:-1000px; " onchange="creditStudent(this.value)" onload="self.focus();" />
                        
                        <div class="col-lg-12" id="profile" style="display: none;">
                            <img id="profileImage" class="img-circle img-responsive pull-left" style="width:100px; border:5px solid #fff" src="<?php echo base_url().'uploads/noImage.png';  ?>" />
                            <h4 id="name" style="margin-left:115px; margin-top: 30px;">Firstname Lastname</h4><br /><br />
                            <h4>Current e-wallet balance: <span id="loadBalance" class="text-danger"></span></h4>
                        </div>
                        <?php //$this->load->view("num_pad"); ?>
                    </div>
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Close</button>
                <button type="button" onclick="credit()" data-dismiss="modal" class="btn btn-primary btn-lg">Credit</button>
            </div>
    </div>

</div>

<script type="text/javascript">
   function setFocus()
    {
        window.setTimeout(function () { 
            document.getElementById("rfid").focus();
        }, 500);
    }
    
    
    function creditStudent(value)
    {
         var url = "<?php echo base_url().'canteen/creditStudent/'?>"; // the script where you handle the form input.
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
                       $('#loadBalance').html(data.load);
                       $('#rfid').val('')
                   }
                 });

            return false;  
    }
    
    function credit()
    {
    
        //var a = document.getElementById("cash").value;
        
        var b = document.getElementById("total-price").innerText;
        var num = b.replace(/[^\d.]/g, '');
        var a = num;
        var num = b.replace(/[^\d.]/g, '');
        var change = a - num;
        var table2 = document.getElementById("tbl2");
        var row1 = table2.insertRow(0);
        var cell1 = row1.insertCell(0);
        var cell2 = row1.insertCell(1);
        var row2 = table2.insertRow(1);
        var cell3 = row2.insertCell(0);
        var cell4 = row2.insertCell(1);

        cell1.innerHTML = "<h4>Cash</h4>";
        cell2.innerHTML = "<h4 style='text-align: right' id='custom_cash'>Php " + a + "</h4>";
        cell3.innerHTML = "<h4>Change</h4>";
        cell4.innerHTML = "<h4  style='text-align: right' id='custom_change'>Php " + change + ".00</h4>";

        saveData('credit', num);
        $('.delBtn').prop('disabled', true);
        document.getElementById("newTrans").disabled = false;
        document.getElementById("trans_num").innerText = "";    
    }
   
    
    function saveTransaction(option, cash, change, b)
    {
        var user_id = $('#userId').val();
        var trans_id = $('#trans_id').val();
        var url = "<?php echo base_url().'canteen/saveCanteenTransaction/'?>";
        $.ajax({
        type: "POST",
        url: url,
        data: 'user_id='+user_id+'&cash='+cash+'&change='+change+'&total='+b+'&trans_id='+trans_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
        success: function(data)
        {
             alert(data)
             //$('#canteenAccounts').modal('hide');
        }
     });

    return false;
        
        
        
    }
    
    function checkRefill(load, refill)
    {
        if(load <= refill)
        {
            alert('e-Wallet Balance is below the refillable amount. Please contact the Parents / Guardian Immediately')
        }
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