<?php 
    echo doctype('html5');
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/li-scroll.css');
        $webAddress = $settings->web_address;
       // $timeIn = $settings->time_in_employee_am;
       // $timeInPM = $settings->time_in_employee_pm;

    //echo $webAddress;
?>

    <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <!--<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>-->
    <script src="<?php echo base_url('assets/js/jquery.marquee.js'); ?>"></script>
  </head>
  <body style="overflow-y: hidden;">
<style scoped>
body{
    background: url('<?php echo base_url("assets/css/scanner_bg.jpg") ?>') no-repeat top center fixed !important;
    -webkit-background-size: cover !important;
    -moz-background-size: cover !important;
    -o-background-size: cover !important;
    background-size: cover !important;
}
     
</style>    
      <script type="text/javascript">
   window.onload = function() {
       
        
        document.getElementById("rfid").value = "";
        
        document.getElementById("rfid").focus();
        digital_clock();
        launchFullScreen(document.documentElement);
    }
    
    document.addEventListener("keydown", function(e) {
        if (e.keyCode == 13) {
          launchFullScreen(document.documentElement);
        }
      }, false);
    
    
  </script>
<style type="text/css">

</style>
  <input type="hidden" id="instance" value="1"/>
  <input type="hidden" id="clockHidden" /> <!-- for webSync purposes -->
<input type="hidden" id="clockReport" /> <!-- for notification purposes -->
 <div style="display:none;" id="countDownSync"></div>
 <div style="display:none;" id="tickChecker"></div>
<input type="hidden" id="tickerLoopCounter" value="1" />
<input type="hidden" id="loopSummary" value="0" />
<input type="hidden" id="triggerNotify" value="1" />
<!--<input style="position:absolute;" onchange="scanRFID(this.value)" onload="self.focus();"  class="" id="rfid" placeholder="Rfid" type="text">-->
<input style="position:absolute; left:-1000px" onchange="scanRFID(this.value)" onload="self.focus();"  class="" id="rfid" placeholder="Rfid" type="text">
<div style="font-size: 12px; display:none;"  id="refreshTimer"></div>
<input type="hidden" id="refreshController" value="0"/>
<input type="hidden" id="triggerReportCount" value="1" />
<input type="hidden" id="notiPm" value="0" />
<input type="hidden" id="notiAm" value="0" />
<!--<button class="btn" onclick="generateSystemReport()" >generate</button>-->
<h2 class="oswald" style="position: absolute; margin-left: 37%; z-index: 2000; color:white; font-size: 150px; font-weight:normal; margin-top:85px;" id="clock"></h2>
<div style="display: none; position:absolute; top:50%; left:35%;" class="alert alert-error" id="notify" data-dismiss="alert-message">
  <h2>Attendance Already Checked</h2>
</div>
<input type="hidden" id="ifScan" value="" />
<div style="margin:0; " id="body-scan"> 
<!--<img src="<?php echo base_url();?>assets/img/sanner_bg.png" class="scan" />-->

<div class="clearfix row-fluid scan" style="margin: 0 auto 0"  >
        <input type="hidden" id="setAction" />
        <div class="span4">
            <img id="avatar" style="border:2px solid white; margin-top:50px; margin-left:20px;" src="<?php echo base_url();?>images/avatar/noImage.png" />
            
        </div>
        <div class="span7 row" style="margin-left:60px; margin-top:50px;">
            <div class="row-fluid">
                <div class="span8">
                </div>
                <div class="span3">
                    <h2 class="oswald pull-right" style="color:white; font-size: 55px; font-weight:normal; margin-top:20px;"><?php echo date('m/d/y');?></h2>
                    <h2 class="oswald pull-right" style="color:white; font-size: 45px; font-weight:normal; margin-top:15px; margin-left:0;"><?php echo strtoupper(date('l')) ;?></h2>
                </div>
            </div>
            <div class="row-fluid" style=" margin-top:55px;">
                <div class="span10">
                    <h2 id="lastname" class="oswald" style="color:white; font-size: 80px; font-weight:bold;">Last Name</h2>
                    <h2 id="firstname" class="oswald" style="color:white; font-size: 100px; font-weight:bold; margin-top:30px;">First Name</h2>
                    <h3 style="color:white; font-family: Helvetica; font-size: 35px; font-weight:normal; margin-top:20px;"><span id="user_id"  style="color:green;">ID #:</span></h3>
                </div>
            </div>
            <div class="row-fluid" style=" margin-top:30px;">
                <div class="span10">
                    <div id="check_in_container" class="hide">
                        <img id="check_in" style="width:40%;" src="" />
                    </div>
                    
                </div>
            </div>
        </div>

</div>
    <div class='marquee' id="marquee">
        <?php echo Modules::run('messaging/getAnnouncementTicker', 1); ?>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function() { 
    
    webSync()
    var idleMouseTimer;
    var forceMouseHide = false;

    $("body").css('cursor', 'none');

    $("#wrapper").mousemove(function(ev) {
            if(!forceMouseHide) {
                    $("body").css('cursor', '');

                    clearTimeout(idleMouseTimer);

                    idleMouseTimer = setTimeout(function() {
                            $("body").css('cursor', 'none');

                            forceMouseHide = true;
                            setTimeout(function() {
                                    forceMouseHide = false;
                            }, 200);
                    }, 1000);
            }
    });
});

function checkTicker()
{
    var url = "<?php echo base_url().'messaging/getAnnouncementTicker/1'?>"; // the script where you handle the form input.
     $.ajax({
           type: "POST",
           url: url,
           data: 'status=1', // serializes the form's elements.
           success: function(data)
           {
              $('#marquee').html(data);  
             
           }
         });

    return false;  
    
}
function scanRFID(ID)
{
    var previousId = $('#ifScan').val()
    if(previousId == ID){
        $('#notify h2').html('Attendance Already Checked');
        $('#notify').show();
        $('#notify').fadeOut(5000);
        document.getElementById("rfid").value = ""; 
        document.getElementById("rfid").focus();
    }else{
        var url = "<?php echo base_url().'attendance/scanRFID' ?>"; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               dataType: 'json',
               data: "id="+ID, // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   if(data.status){
                        $('#lastname').html(data.lastname)
                        $('#firstname').html(data.firstname)
                        $('#check_in_container').show();
                        $("#check_in").attr("src",data.check_in);
                        $("#avatar").attr("src",data.avatar);
                        //$("#check_out").attr("src",data.check_out);
                        $('#user_id').html(data.id)
                        $('#ifScan').val(data.rfid)
                        document.getElementById("rfid").value = ""; 
                        document.getElementById("rfid").focus();
                        if($('#refreshController').val()==0){
                            checkTime()   
                        }
                        
                        if(data.send){
                            sendMessage(data.textmsg, data.contact,'send'); 
                        }
                        
                        
                   }else{
                        
                        $('#notify h2').html(data.msg);
                        $('#notify').show();
                        $('#notify').fadeOut(8000);
                        document.getElementById("rfid").value = ""; 
                        document.getElementById("rfid").focus();
                   }
                   
               }
             });

        return false;
    }
    
}
 
function checkTime()// this will not function without countdown.js loaded
{
    var register = document.getElementById("instance").value; 

   // var now =    
    if(register == 1){

        startCount(15, 1000, pageRefresh,'refreshTimer');

    }
    $('#refreshController').val(1)
    
}


function pageRefresh()
{
    $('#lastname').html('Last Name')
    $('#firstname').html('First Name')
    $('#check_in_container').hide();
    $('#user_id').html("ID #:")
    $('#ifScan').val('')
    $('#refreshController').val(0)
    $("#avatar").attr("src","<?php echo base_url();?>images/avatar/noImage.png");
    
    
}

function webSync()
{
    var time = $('#clockReport').val();
    
    if(time>=1007&&time<=1010){
        var url = "<?php echo base_url().'web_sync/checkData'?>"; // the script where you handle the form input.
        $.ajax({
              type: "POST",
              url: url,
              data: 'status=1', // serializes the form's elements.
              //dataType: 'json',
              success: function(data)
              {
                 var item = data.split(';')
                 var limit = item.length - 1;
                 for (var i=0;i<limit;i++)
                {           
                    getData('<?php echo base_url().'web_sync/getData/'?>'+item[i])
                }

              }
            });

       return false;  
    }
}

function getData(url)
{
      $.ajax({
              type: "POST",
              url: url,
              data: 'status=1', // serializes the form's elements.
              dataType: 'json',
              success: function(data)
              {
                  //alert(data.updates);
                  sendToWeb(data.updates, data.action, data.table, data.pk, data.pk_value);
              }
            });

       return false; 
}

function sendToWeb(updates, action, table, pk, pk_value)
{
        var url = '<?php echo "http://$webAddress/web_sync/catchData/"?>'+updates+'/'+action+'/'+table+'/'+pk+'/'+pk_value
        $.ajax({
              type: "POST",
              url: url,
              data: 'status=1', // serializes the form's elements.
              //dataType: 'json',
              success: function(data)
              {


              }
            });

       return false; 
}



</script>
<script src="<?php echo base_url(); ?>assets/js/ajax.js"></script>
<script src="<?php echo base_url(); ?>assets/js/countdown.js"></script>

  </body>
  </html>

