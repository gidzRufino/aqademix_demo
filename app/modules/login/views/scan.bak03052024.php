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
   <script src="<?php echo base_url('assets/js/plugins/ajax.js'); ?>"></script>
   <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
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
         #adcontainer{
            position: absolute;
            width:100%;
            height: 100%;
            display:flex;
            flex-direction: column;
        }
        .ad-img{
         /*max-width:100%;
   height:auto;
   max-height:100%;*/
            /*background: blue;*/
            width: 100%;
            /*margin: 2% 2%;*/
            height: 100%;
            vertical-align: top;    
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
   <!-- <input type="hidden" id="web_address" value="<?php echo $settings->web_address ?>" /> -->
   <!--<input style="position:absolute;" onchange="scanRFID(this.value)" onload="self.focus();"  class="" id="rfid" placeholder="Rfid" type="text">-->
   <input style="position:absolute; left:-1000px; z-index: 2000;" onchange="scanRFID(this.value)" onload="self.focus();" onblur="this.focus();"  class="" id="rfid" placeholder="Rfid" type="text">
   <div style="font-size: 12px; display:none;"  id="refreshTimer"></div>
   <input type="hidden" id="refreshController" value="0"/>
   <input type="hidden" id="triggerReportCount" value="1" />
   <input type="hidden" id="notiPm" value="0" />
   <input type="hidden" id="notiAm" value="0" />
   <!--<button class="btn" onclick="generateSystemReport()" >generate</button>-->
   <h2 class="oswald" style="position: absolute; margin-left: 37%; color:lime; font-size: 150px; font-weight:bold; margin-top:22px;" id="clock"></h2>
   <div style="display: none; position:absolute; top:55%; left:35%; z-index: 3000" class="alert alert-danger " id="notify" data-dismiss="alert-message">
      <h2>Attendance Already Checked</h2>
   </div>
   <input type="hidden" id="ifScan" value="" />
   <div style="margin:0; " id="body-scan"> 
      <div class="clearfix row scan" style="margin: 0 auto 0"  >
         <input type="hidden" id="setAction" />
         <div class="col-md-4">
            <div class="row text-center">
               <img class="col-lg-12" id="avatar" style="margin-top:50px; margin-left: 30px; width:85%;" src="<?php echo base_url();?>images/avatar/noImage.png" />
               <input type="hidden" name="show_avatar" id="show_avatar" required>
            </div>
            <div class="row">
               <div id="sstatus" class="col-md-12 text-center" style="margin-top:20px;">
                  <!-- <b id="mstat" style="font-family:fantasy;font-size:80px;font-weight:bold;"></b> -->
                  <img id="check_in" style="width:90%;display:none;" src="<?php echo base_url();?>images/check_in.png"/>
                  <img id="check_out" style="width:90%;display:none;" src="<?php echo base_url();?>images/check_out.png"/>
               </div>
            </div>
         </div>
         <div class="col-md-7" style="margin-left:60px; margin-top:22px;">
            <div class="col-lg-3 pull-right">
               <h2 class="oswald pull-right " style="color:white; font-size: 55px; font-weight:normal; margin-top:20px;"><?php echo date('m/d/Y');?></h2>
               <h2 class="oswald pull-right" style="color:white; font-size: 45px; font-weight:normal; margin-top:15px; margin-left:0;"><?php echo strtoupper(date('l')) ;?></h2>
            </div>
            <div class="row-fluid" style=" margin-top:170px;">
               <div class="span10">
                  <h2 id="lastname" class="oswald" style="color:white; font-size: 75px; font-weight:bold;">Last Name</h2>
                  <h2 id="firstname" class="oswald" style="color:white; font-size: 85px; font-weight:bold; margin-top:-35px;">First Name</h2>
                  <input type="hidden" name="show_lname" id="show_lname" required>
                  <input type="hidden" name="show_fname" id="show_fname" required>
                  <input type="hidden" name="show_check" id="show_check" required>
                  <input type="hidden" name="show_stat" id="show_stat" required>
                  <!-- <h3 style="color:white; font-family: Helvetica; font-size: 35px; font-weight:normal; margin-top:20px;"><span id="user_id"  style="color:green;">ID #:</span></h3> -->
               </div>
            </div>
            <div class="row-fluid" style="margin-top:30px;">
               <div id="shistory" class="span10">
                  <!-- <span id="activities" style="font-size:30px; display:none; color: royalblue; font-weight: bold;">Recent Activities</span> -->
                  <br /><br />
                  <div id="echo1" style="display:none;">
                     <input type="hidden" name="show_avatar1" id="show_avatar1" required>
                     <input type="hidden" name="show_lname1" id="show_lname1" required>
                     <input type="hidden" name="show_fname1" id="show_fname1" required>
                     <input type="hidden" name="show_check1" id="show_check1" required>
                     <input type="hidden" name="show_stat1" id="show_stat1" required>
                     <div class="row" style="padding: 10px; background: rgba(0, 0, 0, 0.1);">
                        <div class="col-md-8">
                           <!-- <img id="img1" alt="" src="<?php echo base_url()?>uploads/noImage.png" style="left: 5px; height:60px; border:solid white; position: relative; -webkit-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.3); box-shadow: 0 1px 10px rgba(0, 0, 0, 0.3);"  class="img-square"/> -->
                           <img id="img1" alt="" src="<?php echo base_url()?>uploads/noImage.png" style="left: 5px; height:60px; border:solid white; position: relative;"  class="img-square"/>
                           <b id="name1" style="font-size:25px; color: white; margin-left: 10px;"></b>
                        </div>
                        <div class="col-md-3">
                           <img id="check_in1" style="height:60px;display:none;" src="<?php echo base_url();?>images/check_in_on.png"/>
                           <img id="check_out1" style="height:60px;display:none;" src="<?php echo base_url();?>images/check_out_on.png"/>
                        </div>
                     </div>
                  </div>      
                  <div id="echo2" style="margin-top:20px; display:none;">
                     <input type="hidden" name="show_avatar2" id="show_avatar2" required>
                     <input type="hidden" name="show_lname2" id="show_lname2" required>
                     <input type="hidden" name="show_fname2" id="show_fname2" required>
                     <input type="hidden" name="show_check2" id="show_check2" required>
                     <input type="hidden" name="show_stat2" id="show_stat2" required>
                     <div class="row" style="padding: 10px; background: rgba(0, 0, 0, 0.1);">
                        <div class="col-md-8">
                           <img id="img2" alt="" src="<?php echo base_url()?>uploads/noImage.png" style="left: 5px; height:60px; border:solid white; position: relative;"  class="img-square"/>
                           <b id="name2" style="font-size:25px; color: white; margin-left: 10px;"></b>
                        </div>
                        <div class="col-md-3">
                           <img id="check_in2" style="height:60px;display:none;" src="<?php echo base_url();?>images/check_in_on.png"/>
                           <img id="check_out2" style="height:60px;display:none;" src="<?php echo base_url();?>images/check_out_on.png"/>
                        </div>
                     </div>
                  </div>
                  <div id="echo3" style="margin-top:20px; display:none;">
                     <input type="hidden" name="show_avatar3" id="show_avatar3" required>
                     <input type="hidden" name="show_lname3" id="show_lname3" required>
                     <input type="hidden" name="show_fname3" id="show_fname3" required>
                     <input type="hidden" name="show_check3" id="show_check3" required>
                     <input type="hidden" name="show_stat3" id="show_stat3" required>
                     <div class="row" style="padding: 10px; background: rgba(0, 0, 0, 0.1);">
                        <div class="col-md-8">
                           <img id="img3" alt="" src="<?php echo base_url()?>uploads/noImage.png" style="left: 5px; height:60px; border:solid white; position: relative;"  class="img-square"/>
                           <b id="name3" style="font-size:25px; color: white; margin-left: 10px;"></b>
                        </div>
                        <div class="col-md-3">
                           <img id="check_in3" style="height:60px;display:none;" src="<?php echo base_url();?>images/check_in_on.png"/>
                           <img id="check_out3" style="height:60px;display:none;" src="<?php echo base_url();?>images/check_out_on.png"/>
                        </div>
                     </div>
                  </div>
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
      <div id="adbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog"  style="width:90%;">
            <div class="modal-content">
               <div class="adcontainer">
                  <?php
                     $counts = $ads->num_rows();
                     $loop = 0;
                     $ads_result = $ads->result();
                     foreach ($ads_result as $ads) {
                        $loop++;
                  ?>
                  <input type="hidden" id="a<?php echo $loop ?>" value="<?php echo base_url("images/ads").'/'.$ads->ad_file ?>"/>
                  <input type="hidden" id="b<?php echo $loop ?>" value="<?php echo $ads->ad_format ?>"/>
                  <?php
                     }
                  ?>
                  <input type="hidden" id="ad_counts" value="<?php echo $counts ?>"/>
                  <img class="ad-img" id="ad1" src="">
                  <video id="vad1" class="ad-img" autoplay onended="checknext()">
                     <source src='' allow="autoplay" type="video/mp4">
                  </video>
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
     // launchFullScreen(document.documentElement);
      $("#ad1").hide();
      $("#vad1").hide();
      start_ad_timer(); 
      $('#rfid').blur(function(){
         window.setTimeout(function () { 
            document.getElementById("rfid").focus();
         }, 0);
      })
      // webSync()
      // eCampusCheckIn();
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

   var vcount = 1; 
   var loopr;
   
   function checknext(){
      document.getElementById("rfid").focus();
      var last = document.getElementById('ad_counts').value;
      var apoint = 'a' + vcount;
      var bpoint = 'b' + vcount;
      var format = document.getElementById(bpoint).value;
      var file = document.getElementById(apoint).value;
      if (vcount<last) {
         vcount++;
      }else if (vcount==last) {
         vcount=1;
      }
      if (format==1) { // video
         $("#ad1").hide();$("#vad1").show();
         var video = document.getElementById('vad1');
         video.src = file;
         video.load();
         // video.autoplay = true;
         video.play();
      }else if (format==2) { // image
         $("#vad1").hide(); $("#ad1").show();
         var img = document.getElementById('ad1');
         img.src = file;
         loopr = setTimeout(function(){$("#ad1").hide(); checknext();}, 8000);
      }
      document.getElementById("rfid").focus();
   }

   var ad_timer;
   function start_ad_timer() {
      launchFullScreen(document.documentElement);
      var ad_check = document.getElementById('ad_counts').value;
      if (ad_check>0) {
         ad_timer = setTimeout(showadbox, 15000);
         
      }
      document.getElementById("rfid").focus();
   }  

   function showadbox(){
      $("#adbox").modal('show');
      checknext();
      // $("#vad1").show();
      // $("#vad1")[0].play();
      document.getElementById("rfid").focus();
      $('#adbox').on('shown.bs.modal', function() { // disable focus on modal and back to rfid
         $(document).off('focusin.modal');
         document.getElementById("rfid").focus();
      });
      document.getElementById("rfid").focus();

   }

   function reset_ad_timer() {
      $("#vad1")[0].pause();
      $("#adbox").modal("hide");
      clearTimeout(ad_timer);
      start_ad_timer();
   }

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
         $('#notify').fadeOut(3000);
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
               if(data.status){

                  var savatar = document.getElementById('show_avatar').value;
                  var slname = document.getElementById('show_lname').value;
                  var sfname = document.getElementById('show_fname').value;
                  var scheck = document.getElementById('show_check').value;
                  var stat = document.getElementById('show_stat').value;

                  $("#shistory").show(); $("#sstatus").show();
                  if(slname==""||slname==null){

                     $('#echo1').hide();
                     
                  }else{
                     document.getElementById("name1").innerHTML = slname + ", " + sfname;
                     $("#img1").attr("src",savatar);
                     if (stat=="OUT"){
                        $('#check_in1').hide();
                        $('#check_out1').show(); 
                     }else if(stat == "IN"){
                        $('#check_in1').show();
                        $('#check_out1').hide(); 
                     }
                     $('#echo1').show();
                     $('#activities').show();
                  }

                  var savatar1 = document.getElementById('show_avatar1').value;
                  var slname1 = document.getElementById('show_lname1').value;
                  var sfname1 = document.getElementById('show_fname1').value;
                  var scheck1 = document.getElementById('show_check1').value;
                  var stat1 = document.getElementById('show_stat1').value;

                  if(slname1==""||slname1==null){
                     $('#echo2').hide();
                  }else{
                     document.getElementById("name2").innerHTML = slname1 + ", " + sfname1;
                     $("#img2").attr("src",savatar1);
                     if (stat1=="OUT"){   
                        $('#check_in2').hide();
                        $('#check_out2').show(); 
                     }else if(stat1=="IN"){
                        $('#check_in2').show();
                        $('#check_out2').hide(); 
                     }
                     $('#echo2').show();
                  }

                  var savatar2 = document.getElementById('show_avatar2').value;
                  var slname2 = document.getElementById('show_lname2').value;
                  var sfname2 = document.getElementById('show_fname2').value;
                  var scheck2 = document.getElementById('show_check2').value;
                  var stat2 = document.getElementById('show_stat2').value;

                  if(slname2==""||slname2==null){
                     $('#echo3').hide();
                  }else{
                     document.getElementById("name3").innerHTML = slname2 + ", " + sfname2;
                     $("#img3").attr("src",savatar2);
                     if (stat2=="OUT"){
                        $('#check_in3').hide();
                        $('#check_out3').show(); 
                     }else if(stat2=="IN"){
                        $('#check_in3').show();
                        $('#check_out3').hide(); 
                     }
                     $('#echo3').show();
                  }

                  $('#show_avatar1').val(savatar);
                  $('#show_lname1').val(slname);
                  $('#show_fname1').val(sfname);
                  $('#show_check1').val(scheck);
                  $('#show_stat1').val(stat);

                  $('#show_avatar2').val(savatar1);
                  $('#show_lname2').val(slname1);
                  $('#show_fname2').val(sfname1);
                  $('#show_check2').val(scheck1);
                  $('#show_stat2').val(stat1);

                  $('#show_avatar3').val(savatar2);
                  $('#show_lname3').val(slname2);
                  $('#show_fname3').val(sfname2);
                  $('#show_check3').val(scheck2);
                  $('#show_stat3').val(stat2);
                  
                  $('#lastname').html(data.lastname);
                  $('#firstname').html(data.firstname);
                  $("#avatar").attr("src",data.avatar);
                  $('#position').html(data.check_out)
                  $('#user_id').html(data.id);
                  $('#ifScan').val(data.rfid);

                  $('#show_avatar').val(data.avatar);
                  $('#show_fname').val(data.firstname);
                  $('#show_lname').val(data.lastname);
                  $('#show_check').val(data.check_in);
                  $('#show_stat').val(data.print_status);

                  var mstatus = document.getElementById('show_stat').value;
                  if(mstatus=="IN"){   
                     $('#check_in').show();
                     $('#check_out').hide();
                  }else if(mstatus=="OUT"){
                     $('#check_in').hide();
                     $('#check_out').show();
                  }

                  document.getElementById("rfid").value = ""; 
                  document.getElementById("rfid").focus();

                  if($('#refreshController').val()==0){
                     checkTime();   
                  } 
                  reset_ad_timer();
                  $("#shistory").fadeOut(25000); $("#sstatus").fadeOut(5000);
               }else{
                  $('#notify h2').html(data.msg);
                  $('#notify').show();
                  $('#notify').fadeOut(3000);
                  document.getElementById("rfid").value = ""; 
                  document.getElementById("rfid").focus();
                  reset_ad_timer();
               } 
            }
         });
         return false;
      }    
   }

   function checkTime()// this will not function without countdown.js loaded
   {
      var register = document.getElementById("instance").value; 
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
               // checkData();
            }else{
               console.log('an error has occured')
            }
         }
      });
   }

   function toggleFullScreen(elem) {
    // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (elem.requestFullScreen) {
            elem.requestFullScreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}
   
</script>

<script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/countdown.js"></script>
<script src="<?php echo base_url('assets/js/sync_controller.js'); ?>"></script>
</body>
</html>

