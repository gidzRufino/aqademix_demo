<?php 
    echo doctype('html5');
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/plugins/li-scroll.css');
    echo link_tag('assets/font-awesome-4.2.0/css/font-awesome.min.css');
        $webAddress = $settings->web_address;
       // $timeIn = $settings->time_in_employee_am;
       // $timeInPM = $settings->time_in_employee_pm;

?>

 <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
    <!--<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>-->
    <script src="<?php echo base_url('assets/js/plugins/jquery.marquee.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/cam/webcam.js'); ?>"></script>
    <!--Cookie Javascript-->
    <script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>  
  </head>
  <body style="overflow-y: hidden;">
<style scoped>
body{
    background: url('<?php echo base_url("assets/css/scanner_bg.jpg") ?>') no-repeat top center fixed !important;
    -webkit-background-size: cover !important;
    -moz-background-size: cover !important;
    -o-background-size: cover !important;
    background-size: 102% 103% !important;
}
     
</style>    
      <script type="text/javascript">
   window.onload = function() {
       
        
        document.getElementById("rfid").value = "";
        
        document.getElementById("rfid").focus();
        digital_clock();
        //launchFullScreen(document.documentElement);
    }
    
    document.addEventListener("keydown", function(e) {
        if (e.keyCode == 13) {
          launchFullScreen(document.documentElement);
        }
      }, false);
    
    
  </script>
<style type="text/css">

</style>
  <div style="display: none" id="my_camera"></div>
  <input type="hidden" id="instance" value="1"/>
  <input type="hidden" id="clockHidden" /> <!-- for webSync purposes -->
<input type="hidden" id="clockReport" /> <!-- for notification purposes -->
 <div style="display:none;" id="countDownSync"></div>
 <div style="display:none;" id="tickChecker"></div>
<input type="hidden" id="tickerLoopCounter" value="1" />
<input type="hidden" id="loopSummary" value="0" />
<input type="hidden" id="triggerNotify" value="1" />
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />
<input type="hidden" id="web_address" value="<?php echo $settings->web_address ?>" />
<!--<input style="position:absolute;" onchange="scanRFID(this.value)" onload="self.focus();"  class="" id="rfid" placeholder="Rfid" type="text">-->
<input style="position:absolute; left:-1000px" onchange="scanRFID(this.value)" onload="self.focus();" onblur="this.focus();"  class="" id="rfid" placeholder="Rfid" type="text">
<div style="font-size: 12px; display:none;"  id="refreshTimer"></div>
<input type="hidden" id="refreshController" value="0"/>
<input type="hidden" id="triggerReportCount" value="1" />
<input type="hidden" id="notiPm" value="0" />
<input type="hidden" id="notiAm" value="0" />
<!--<button class="btn" onclick="generateSystemReport()" >generate</button>-->
<h2 class="oswald" style="position: absolute; margin-left: 37%; z-index: 2000; color:lime; font-size: 130px; font-weight:bold; margin-top:22px;" id="clock"></h2>
<div class="pull-right">
                    <h2 class="oswald pull-right " style="color:white; font-size: 55px; font-weight:normal; margin-top:20px;"><?php echo date('m/d/y');?></h2><br />
                    <h2 class="oswald pull-right" style="color:white; font-size: 45px; font-weight:normal; margin-top:15px; margin-left:0;"><?php echo strtoupper(date('l')) ;?></h2>
                </div>
<div style="display: none; position:absolute; top:55%; left:35%; z-index: 3000" class="alert alert-danger " id="notify" data-dismiss="alert-message">
  <h2>Attendance Already Checked</h2>
</div>
<input type="hidden" id="ifScan" value="" />
<div style="margin:0; " id="body-scan"> 
<!--<img src="<?php echo base_url();?>assets/img/sanner_bg.png" class="scan" />-->

<div class="clearfix row scan" style="margin: 0 auto 0"  >
        <input type="hidden" id="setAction" />
        <div class="pull-left">
            <img class="" id="avatar" style="margin-top:140px; margin-left:20px; margin-right:10px; width:800px;" src="<?php echo base_url();?>images/avatar/noImage.png" />
        </div>
        <div class="" style="margin-left:60px; margin-top:22px;">
                
                <div class="row-fluid" style=" margin-top:200px;">
                  <div class="span10">
                      <h2 id="lastname" class="oswald" style="color:white; font-size: 70px; font-weight:bold;">Last Name</h2><br />
                      <h2 id="firstname" class="oswald" style="color:white; font-size: 90px; font-weight:bold; margin-top:-35px;">First Name</h2>
                      <h3 style="color:white; font-family: Helvetica; font-size: 50px; font-weight:normal; margin-top:0px; margin-left:30px"><span style="margin-left:10px;" id="position">gradelevel</span></h3>
                      
                        <div id="check_in_container" class="" >
                            <button id="in" style="display: none;  font-weight: bold; width:250px; height:50px; font-size: 35px; margin-left:2%; padding:0;" href="#" class="btn btn-large btn-success"><i class="fa fa-check fa-fw"></i> CHECK IN </button>
                            <button id="out" style="display: none; font-weight: bold; width:280px; height:50px; font-size: 35px; margin-left:2%; padding:0;" href="#" class="btn btn-large btn-danger"><i class="fa fa-close fa-fw"></i> CHECK OUT </button>
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
    $('#rfid').blur(function(){
        //alert('hey')
        window.setTimeout(function () { 
            document.getElementById("rfid").focus();
        }, 0);
        
    
    })
    //webSync()
    
    eCampusCheckIn();
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
           data: 'status=1'+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
              $('#marquee').html(data); 
              checkData();
           }
         });

    return false;  
    
}
function scanRFID(ID)
{
    var previousId = $('#ifScan').val()
    //take_snapshot(ID)
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
               data: "id="+ID+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   //$("form#quoteForm")[0].reset()
                   if(data.status){
                        $('#lastname').html(data.lastname)
                        $('#firstname').html(data.firstname)
                        $('#position').html(data.gradeLevel)
                        //$('#check_in_container').removeClass('hide')
                        if(data.check_in){
                            $("#in").show();
                            $('#out').hide();
                        }else{
                            $("#in").hide();
                            $('#out').show();
                        }
                        $("#avatar").attr("src",data.avatar);
                        
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


Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90,
        autoplay: true
});
//Webcam.attach( '#my_camera' );

function take_snapshot(user_id) {
    Webcam.snap( function(data_uri) {
          $.ajax({
               type: "POST",
               url: '<?php echo base_url().'attendance/getSnap' ?>',
               data: 'user_id='+user_id+"&id="+data_uri+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                   console.log(data)
               }
             });

        
    } );
        
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
    $('#position').html("")
    $('#ifScan').val('')
    $('#refreshController').val(0)
    $("#avatar").attr("src","<?php echo base_url();?>images/avatar/noImage.png");
    
    
}

function eCampusCheckIn()
{
    var school_id = '<?php echo $settings->school_id ?>';
    var url = 'http://<?php echo $settings->web_address ?>'+'/login/clientCheckIn/';
    $.ajax({
          type: "POST",
          crossDomain: true,
          url: url,
          data: 'school_id='+school_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'),  // serializes the form's elements.
          dataType: 'json',
          success: function(data)
          {
              if(data.status){
                  console.log(data.timestamp);
                  checkData();
              }else{
                  console.log('an error has occured')
              }
              

          }
        });
}


</script>
<script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/countdown.js"></script>
<script src="<?php echo base_url('assets/js/sync_controller.js'); ?>"></script>

  </body>
  </html>

