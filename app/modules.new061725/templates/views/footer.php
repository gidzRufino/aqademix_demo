<div id="chatArea" class="hide">

</div>

<div id="syncModal" class="modal fade" style="width:450px; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="alert alert-danger" id="onSyncMessage">
        <h3 class="text-center"> PLEASE DO NOT CLOSE THIS WINDOW WHILE THE SYSTEM IS SYNCHRONIZING.</h3>
        <h6 class="text-center"><span id="noOfRecords">500</span> Records to Sync...</h6>
        <h6 class="text-center"><span id="noOfRecordsRemaining">500</span> Remaining Record(s) to Sync. <i class="fa fa-spinner fa-spin fa-2x"></i></h6>
    </div>
    <div class="alert alert-info hide" id="onSyncComplete">
        <h3 class="text-center">SYSTEM SUCCESSFULLY SYNCHRONIZED</h3>
        <button class="pull-right btn btn-success btn-sm" data-dismiss="modal">CLOSE</button>
    </div>
</div>


<div id="idleModal" class="modal fade" style="width:450px; margin: 0 auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="alert alert-danger" id="idleMessage">
        <h4 class="text-center">Your Session in e-sKwela is about to Expire in <span id="idleCount"></span> seconds.</h4>
        <button class="pull-right btn btn-success btn-sm" data-dismiss="modal" onclick="resetTimer()">STAY</button>
        <input type="hidden" value="1" id="idleLogController" />
        <button class="pull-right btn btn-danger btn-sm" onclick="document.location='<?php echo base_url().'login/logout' ?>'" >LOGOUT</button>
    </div>
</div>

<div id="loadingModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" style="z-index: 3000;">
    <div class="panel panel-default clearfix" style="width:20%; margin:75px auto;">
        <div class="col-xs-12" style="width:100%;">
            <div class="col-xs-12">
                <p class="text-center">Please wait while processing your request <br />
                
                <!-- <img src="<?php //echo base_url().'images/loading.gif' ?>" style="width:150px;" /> -->
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    
        Push.Permission.request();
        
        <?php
//        
//        if(Modules::run('main/isMobile')):
//            if($this->session->is_logged_in):
        ?>
           // sendNotification('Welcome to e-sKwela Mobile');
       <?php     
//            endif;
//        endif;
        
        ?>
        
        function sendNotification(msg)
        {
            Push.create('e-sKwela', {
                body: msg,
                icon: '<?php echo base_url().'images/forms/'.$settings->set_logo?>',
                timeout: 15000,               // Timeout before notification closes automatically.
                vibrate: [100, 100, 100],    // An array of vibration pulses for mobile devices.
                onClick: function() {
                    // Callback for when the notification is clicked. 
                    console.log(this);
                }  
            });
        }
        
        <?php 
            if($this->session->userdata('is_adviser') && date('m')!=4 && date('m')!=5):
          ?>      
              $(function(){
                   var url = "<?php echo base_url().'attendance/checkAdviser/'?>"
                   $.ajax({
                       type: "POST",
                       dataType: 'json',
                       url: url,
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                          if(data.status)
                              {
                                //  alert(data.msg)
                              }
                       }
                     });

                return false;
              });
          <?php  
            endif;
        ?>
        $(function(){
           
        $('#inputBdate').datepicker();
        $('[rel="clickover"]').clickover({
            placement: 'top',
            html: true
          });
          
        
        });
        
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
                    error: function(xhr, textStatus, errorThrown) {
                          console.log(textStatus)
                     },
                  success: function(data)
                  {
                      if(data.status){
                          console.log(data.timestamp);
                      }else{
                          console.log('an error has occured')
                      }


                  }
                });
        }
       // checkForNewMessage();
        function checkForNewMessage()
            {
                var url = '<?php echo base_url().'chatsystem/checkForNewMessage/'?>';
                $.ajax({
                       type: "POST",
                       dataType: 'json',
                       url: url,
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                          var i;
                          
                          if(data.hasMessage){
                              if(data.num_msgs>0){
                                  var rel = (data.rel).split(',')
                                  var item  = (data.ids).split(',')
                                  var name = (data.names).split(',')
                                  for(i=0; i<=((item).length-1); i++){
                                      var css = i*310
                                      //console.log(item[i])
                                      $('#chatArea').append('<div class="chatbox panel panel-green" id="chatbox_'+item[i]+'" style="bottom: 0px; margin-bottom: 0px; right: '+css+'px;">\n\
                                        <div class="chatboxhead clearfix">\n\
                                        <div class="panel-heading "><span id="chatHeader">'+name[i]+'</span><div class="chatboxoptions"><a href="javascript:void(0)"><i class="fa fa-minus-square"></i></a> <a href="javascript:void('+item[i]+')"><i class="fa fa-close"></i></a></div></div>\n\
                                        <div class="panel-body" id="chitchatBody" style="padding:0 15px;">\n\
                                        <ul id="chitchat_'+item[i]+'" class="chatboxcontent chat">'+data.body+ ' </ul>\n\
                                        <div class="chatboxinput panel-footer">\n\
                                        <textarea class="chatboxtextarea" onkeydown="sendChatMessage(event,this,'+item[i]+')"></textarea>\n\
                                        <input type="hidden" id="pChat_'+item[i]+'" value="'+rel[i]+'" />\n\
                                        </div></div></div></div></div>')
                                      //console.log(data.last_id)   
                                      $("#chitchat_"+item[i]).scrollTop($("#chitchat_"+item[i])[0].scrollHeight); 
                                      read(rel[i])
                                      loadMessage(data.last_id, item[i], 1)
                                      
                                  }
                                   
                              }
                               
                               $('#chatArea').removeClass('hide');
                              
                          }else{
                              checkForNewMessage();
                          }
                          
                       }    
                     });

                return false;
            }
            
        function read(pChat)
        {
            var url = '<?php echo base_url().'chatsystem/readMessage/'?>'+pChat;
                $.ajax({
                       type: "GET",
                       dataType: 'json',
                       url: url,
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                         
                          
                       }
                       
                })
        }
        function sendChatMessage(event,chatboxtextarea,user_id)
        {
            // alert('hey ')
             if(event.keyCode == 13 && event.shiftKey == 0)  {

                var chat_url = $('#chat_url').val(); 
                var pChat_id = $('#pChat_'+user_id).val(); 
                read(pChat_id)
                var message = $(chatboxtextarea).val();
                    message = message.replace(/^\s+|\s+$/g,"");

                    $(chatboxtextarea).val(' ');
                    $(chatboxtextarea).focus();
                    $(chatboxtextarea).css('height','44px');
                    if (message != '') {
                            //$.post("http://localhost/CodeIgniter/application/views/chat/chat.php?action=sendchat", {to: user_id, message: message} , function(data){
                        $.ajax({
                           type: "POST",
                           dataType: 'json',
                           url:chat_url+"sendchat",
                           data: 'csrf_test_name='+$.cookie('csrf_cookie_name')+'&to='+user_id+'& message='+message+'&pChat_id='+pChat_id, // serializes the form's elements.
                           success: function(data)
                           {
                                message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
                                $("#chitchat_"+user_id).append('<li class="alert alert-success pull-right col-lg-10 col-md-10 col-sm-10" style="margin-bottom:5px; padding:2px"><span class="chatboxmessagecontent">'+message+'</span></li>');
                                $("#chitchat_"+user_id).scrollTop($("#chitchat_"+user_id)[0].scrollHeight); 

                           }    
                         });

                        return false;
                    }

                    return false;
            }else{
                
            }
        }
        $(document).ready(function() {
            
            //eCampusCheckIn(); 
            //checkPortal()
            $('#createCB').click( function(){
                //loadMessage(0,0,0); 
                $('#chatArea').removeClass('hide');
                var user_name = $(this).attr('username');
                var user_id = $(this).attr('user_id')
                $('#chatbox_'+user_id).removeClass('hide');

                $(" <div />" ).attr("id","chatbox_"+$(this).attr('user_id'))
               .addClass("chatbox panel panel-green")
               .html('<div class="chatbox panel panel-green" id="chatbox_'+user_id+'" style="bottom: 0px; margin-bottom: 0px; right: 10px;">\n\
                    <div class="chatboxhead clearfix">\n\
                    <div class="panel-heading "><span id="chatHeader">'+user_name+'</span><div class="chatboxoptions"><a href="javascript:void(0)"><i class="fa fa-minus-square"></i></a> <a onclick="$(\'#chatbox_'+user_id+'\').addClass(\'hide\')" href="javascript:void('+user_id+')"><i class="fa fa-close"></i></a></div></div>\n\
                    <div class="panel-body" id="chitchatBody" style="padding:0 15px;">\n\
                    <ul id="chitchat_'+user_id+'" class="chatboxcontent chat"></ul>\n\
                    <div class="chatboxinput panel-footer">\n\
                    <textarea class="chatboxtextarea" onkeydown="sendChatMessage(event,this,'+user_id+')"></textarea>\n\
                    <input type="hidden" id="pChat_'+user_id+'" value="" />\n\
                                        </div></div></div></div></div>')
               .appendTo($("#chatArea" ));
               $("#chatbox_"+user_id).css('bottom', '0px');
               $("#chatbox_"+user_id).css('margin-bottom', '0');
               $("#chatbox_"+user_id).css('right', '10px');
               
               var url = '<?php echo base_url().'chatsystem/getPreviousChat/'?>'
                $.ajax({
                       type: "POST",
                       dataType: 'json',
                       url: url,
                       data: 'last_id='+0+'&to='+user_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                          //console.log(data); 
                          if(data.hasMessage){
                             $("#chitchat_"+user_id).append(data.body)
                             $('#pChat_'+user_id).val(data.rel);
                             $("#chitchat_"+user_id).scrollTop($("#chitchat_"+user_id)[0].scrollHeight);
                          }
                          loadMessage(data.last_id, user_id, 1)
                       }

                })
            })
           // 
        })
        //loadMessage(0,0,0);    
        
            function loadMessage(msgs, to, Option)
            {
                if(Option==1){

                    var url = '<?php echo base_url().'chatsystem/loadNewMessage/'?>'
                        $.ajax({
                               type: "POST",
                               dataType: 'json',
                               url: url,
                               data: 'last_id='+msgs+'&to='+to+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                               success: function(data)
                               {
                                   
                                    var i;
                                    //console.log('chitchat_'+to)
                                  //console.log(data)
                                    if(data.hasMessage){
                                       $("#chitchat_"+to).html(data.body) 
                                       $("#chitchat_"+to).scrollTop($("#chitchat_"+to)[0].scrollHeight);
                                    }

                                    loadMessage(data.last_id, to, 1)
                               }


                        })
                }else{
                    
                }
            
                       
        }
        
            
        
       
        function showLoading(body)
        {
            $('#'+body).html($('#submitLoad').html())
        }
        
        function stopLoading(body)
        {
            $('#'+body).html('')
        }
        <?php 
            if($this->session->userdata('is_admin')):
                if($this->uri->uri_string()=='main/dashboard'):
          ?>   
            //checkForNewUpdate();
            //checkForCollegeUpdate();
            
            function checkForNewUpdate(presents)
            {
                var url = '<?php echo base_url().'widgets/attendance_widgets/getAttendanceUpdates/'?>'+presents;
                $.ajax({
                       type: "POST",
                       dataType: 'json',
                       url: url,
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                          //console.log(data.presents)
                          if(data.presents=='undefined'){
                              $('#num_presents').html(0)
                              checkForNewUpdate(0)
                          }else{
                              $('#num_presents').html(data.presents)
                              checkForNewUpdate(data.presents)
                          }
                          
                       }    
                     });

                return false;
            }
            
            function checkForCollegeUpdate(presents)
            {
                var url = '<?php echo base_url().'widgets/attendance_widgets/getCollegeAttendanceUpdates/'?>'+presents;
                $.ajax({
                       type: "POST",
                       dataType: 'json',
                       url: url,
                       data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                       success: function(data)
                       {
                          //console.log(data.presents)
                          if(data.presents=='undefined'){
                              $('#num_college_presents').html(0)
                              checkForCollegeUpdate(0)
                          }else{
                              $('#num_college_presents').html(data.presents)
                              checkForCollegeUpdate(data.presents)
                          }
                          
                       }    
                     });

                return false;
            }
        <?php
                endif;
            endif;
        ?>
        
        function notMouseMove() {
            
            $('#idleModal').modal('show');
            startCountDown(120, 1000, idleLogOut,'idleCount', 1);
            StartBlinking('Logout')
            
         }
         
         function idleLogOut()
         { 
             var option = $('#idleLogController').val();
             if(option==1){
                document.location='<?php echo base_url().'login/logout' ?>'
                
             }
         }
         
         function stayLogIn()
         {
             clearTimeout(timer)
             timer = setTimeout(notMouseMove, 600000);
             StopBlinking()
         }
         
         
         var timer = setTimeout(notMouseMove, 600000);
         
         function resetTimer()
         {
             startCountDown(0, 1000, stayLogIn,'idleCount', 0);
         }
         
         
        $(document).on('mousemove', function () {
            clearTimeout(timer)
            timer = setTimeout(notMouseMove, 600000);
        });    
        
        var originalTitle;

        var blinkTitle;

        var blinkLogicState = false;

        function StartBlinking(title)
        {
                originalTitle = document.title;

                blinkTitle = title;

                BlinkIteration();
        }

        function BlinkIteration()
        {
                if(blinkLogicState == false)
                {
                        document.title = blinkTitle;
                }
                else
                {
                        document.title = originalTitle;
                }

                blinkLogicState = !blinkLogicState;

                blinkHandler = setTimeout(BlinkIteration, 2000);
        }

        function StopBlinking()
        {
                if(blinkHandler)
                {
                        clearTimeout(blinkHandler);
                }

                document.title = originalTitle;
        }
        
        //reading notification
        
        function readNotification(noti_id, user_id, link)
        {
            var url = '<?php echo base_url().'notification_system/readNoti/' ?>'+noti_id+'/'+user_id;
            $.ajax({
               type: "GET",
               url: url,
               data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
               success: function(data)
               {
                  document.location = link;

               }    
             });
            return false;
        }
        
        

</script>

    <!-- timepicker JavaScript -->
    <!-- <script src="<?php //echo base_url('assets/js/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script> -->
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url('assets/js/plugins/metisMenu/metisMenu.min.js'); ?>"></script>

    <!-- Web Sync Controller JavaScript -->
    <script src="<?php echo base_url('assets/js/sync_controller.js'); ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/js/plugins/bootstrap.clickover.js'); ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('assets/js/sb-admin-2.js'); ?>"></script>
    
    <!--table sorter javascript -->
    <script src="<?php echo base_url('assets/js/plugins/jquery.tablesorter.js'); ?>"></script>

    <!--Editable Table Javascript-->
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-editable.js'); ?>"></script>   
    
    <!--Tootip Plugin Javascript-->
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-tooltip.js'); ?>"></script>   
    
    <!--Cookie Javascript-->
    <script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>   
    
    <!--graph Javascript-->
    <script src="<?php echo base_url('assets/js/plugins/flotr2.min.js'); ?>"></script>   
    
    <script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-contextmenu.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>
    
    
  </body>
</html>