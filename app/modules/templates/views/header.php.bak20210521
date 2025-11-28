<?php 
    echo doctype('html5');
    echo header("Content-Type: text/html; charset=UTF-8");
    echo '<head>';   
?>
<title>[  <?php echo strtoupper($settings->short_name); ?> - e-sKwela]</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php
    
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/plugins/metisMenu/metisMenu.min.css');
    echo link_tag('assets/css/sb-admin-2.css');
    echo link_tag('assets/css/plugins/morris.css');
    echo link_tag('assets/css/plugins/timeline.css');
    echo link_tag('assets/css/plugins/defaultTheme.css');
    echo link_tag('assets/font-awesome/css/font-awesome.min.css');
    echo link_tag('assets/css/plugins/select2.css');
    echo link_tag('assets/css/plugins/datepicker.css');
    echo link_tag('assets/css/plugins/chat/chat.css');
    echo link_tag('assets/css/plugins/bootstrap-clockpicker.min.css');
    echo link_tag('assets/css/plugins/chat/screen.css');
    echo link_tag('assets/css/plugins/animate.css');
    echo link_tag('assets/css/jquery-confirm.min.css');
	
?>
    <link rel='manifest' href='<?php echo base_url() ?>manifest.json'>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/'); ?>print.css" media="print" />
    <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-clockpicker.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-datepicker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/select2.min.js'); ?>"></script>
    <!--<script src="<?php echo base_url('assets/js/plugins/fancywebsocket.js'); ?>"></script>-->    
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-notify.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-confirm.min.js'); ?>"></script>  
    <!-- Push Notifications -->
    <script src="<?php echo base_url('assets/js/push.min.js'); ?>"></script>
    <style>
        .hidden {
          display: none !important;
        }

        #installContainer {
          position: absolute;
          bottom: 1em;
          display: flex;
          justify-content: center;
          width: 100%;
        }

        #installContainer button {
          background-color: inherit;
          border: 1px solid white;
          color: white;
          font-size: 1em;
          padding: 0.75em;
        }
    </style>   
    
    <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
    <script type="text/javascript">

        window.moveTo(0,0);
        if (document.all) {window.resizeTo(screen.availWidth,screen.availHeight)}
        else {window.outerHeight = screen.availHeight; window.outerWidth = screen.availWidth}
        
//        Notification Module
        $(document).ready(function(){
        //    stream_open();
        });

            var webstream = false;

           function stream_open(){
                stream_close(); //Close the stream it (in case we got here weirdly)
                if(!!window.EventSource){   //Test compatibility
                    webstream = new EventSource('<?php echo base_url() . 'notification_system/pullNotification/'.$this->session->employee_id ?>');
                    console.log("Stream Opened");   //Log event for testing

                    webstream.addEventListener('message', function(e){
                        var data = JSON.parse(e.data);  //Parse the json into an object
                        process_stream(data);
                    },false);

                    //Cleanup after navigating away (optional)              
                    $(window).bind('beforeunload', function(){  
                        webstream.onclose = function(){}; //delete onclose (optional)
                        webstream.close();  //Close the stream
                    });
                    
                    webstream.addEventListener('error', function(e) {
                        if (e.readyState == EventSource.CLOSED) {
                          // Connection was closed.
                          console.log('Streamed Closed');
                        }
                      }, false);
                }
            }
            
            

            function stream_close(){
                if(typeof(webstream)=="object"){
                    webstream.close();
                    webstream = false;
                    console.log("Stream Closed");   //Log event for testing
                }
            }
            
            

            function process_stream(data){
                //do something with the new data from the stream, e.g. log in console
                if(data.hasUpdate)
                {
                    showNotification(data.title, data.msg, 'info');
                }else{
                    console.log('No Updates at the moment');
                }
            }
  
            
        function showNotification(title, msg, type)
        {
            $.notify({
                icon: '<?php echo base_url('images/forms/').$this->eskwela->getSet()->set_logo ?>',
                title: "<strong>"+(title !==''?title+" :":'')+"</strong> ",
                message: msg,
                z_index: 1050
                },

                {
                    placement:
                    {
                        from    : 'bottom',
                        align   : 'right'
                    },
                    
                    type: type,
                    delay: 10000,
                    icon_type: 'image',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert">' +
                            '<img data-notify="icon" class="img-circle pull-left" style="width: 72px; height: 72px;>' +
                            '<span data-notify="title">{1}</span>' +
                            '<span data-notify="message">{2}</span>' +
                    '</div>'
                },
                

            );
            $('#notif_audio')[0].play();

        }
    
          
    </script>
  </head>
<body style="height:100%;">
<audio id="notif_audio">
    <source src="<?php echo base_url('sounds/notify.ogg');?>" type="audio/ogg">
    <source src="<?php echo base_url('sounds/notify.mp3');?>" type="audio/mpeg">
    <source src="<?php echo base_url('sounds/notify.wav');?>" type="audio/wav">
</audio>
<div id="installContainer" class="hidden">
  <button id="butInstall" type="button">
    Install
  </button>
</div>
    
<input type="hidden" id="e_session_id" value="<?php echo $this->session->employee_id ?>" />

