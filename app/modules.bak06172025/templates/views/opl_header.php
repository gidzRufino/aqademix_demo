<?php
    echo doctype('html5');
    echo header("Content-Type: text/html; charset=UTF-8");
    echo '<head>';
?>
<title><?php echo ($title==NULL?'Online Platform for Learning':$title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php

    echo link_tag('opl_assets/css/adminlte.min.css');
    echo link_tag('opl_assets/fontawesome-free/css/all.min.css');
    echo link_tag('opl_assets/summernote/summernote-bs4.css');
    echo link_tag('opl_assets/css/bootstrap-clockpicker.min.css');
    echo link_tag('opl_assets/css/select2.min.css');
    echo link_tag('opl_assets/css/select2-bootstrap4.css');

?>
   <!-- fullCalendar 2.2.5-->
   <link rel="stylesheet" href="<?php echo base_url() ?>opl_assets/fullcalendar/fullcalendar.min.css">
   <link rel="stylesheet" href="<?php echo base_url() ?>opl_assets/fullcalendar/fullcalendar.print.css" media="print">
   
    <link rel='manifest' href='<?php echo base_url() ?>manifest.json'>
    <script src="<?php echo base_url('assets/js/jquery-3.4.0.min.js'); ?>"></script>
    <script src="<?php echo base_url('opl_assets/js/bootstrap-notify.min.js'); ?>"></script>
    <script src="<?php echo site_url('opl_assets/timeago/dist/timeago.min.js'); ?>"></script>
 <style>
     .pull-left{
         float: left !important;
     }
     .pull_right{
         float: right !important;
     }
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

        .pointer{
            cursor: pointer;
        }
        .no-padding{
            padding: 0 !important;
        }
        .no-margin{
            margin: 0 !important;
        }
        .select2-container{
            width:100% !important;
        }
        .note-video-clip{
            width:100% !important;
        }
        .modal { overflow: auto !important; }
    </style>

    <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
    <?php
        if($this->session->isStudent):
            $webstream = base_url() . 'notification_system/studentNotification/'.base64_encode($this->session->details->st_id).'/'.$this->session->details->grade_id.'/'.$this->session->details->section_id;
        else:
            $webstream = base_url() . 'notification_system/pullNotification/'.base64_encode($this->session->employee_id);
        endif;
    ?>
    <script type="text/javascript">

        var hasComment = false;
        window.moveTo(0,0);
        if (document.all) {window.resizeTo(screen.availWidth,screen.availHeight)}
        else {window.outerHeight = screen.availHeight; window.outerWidth = screen.availWidth}

//        Notification Module
        $(document).ready(function(){
            //stream_open();
        });

            var webstream = false;
           function stream_open(){
                stream_close(); //Close the stream it (in case we got here weirdly)
                if(!!window.EventSource){   //Test compatibility
                    webstream = new EventSource('<?php echo $webstream ?>');
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
                var st_id = $('#st_id').val();
                if(data.hasUpdate)
                {
                    // showNotification(data.title, data.msg, 'info');
                }else{
                    console.log('No Updates at the moment');
                    if(hasComment){
                        fetchComment(st_id);
                        //console.log(com_type)
                        //commentBox.append('hello <br />')
                    }
                }
            }


        function showNotification(title, msg, type)
        {
            $.notify({
                icon: '<?php echo base_url('images/forms/').$this->eskwela->getSet()->set_logo ?>',
                title: "<strong>"+(title !==''?title+" :":'')+"</strong> ",
                message: msg,
                },
                {
                    z_index: 3000,
                    type: type,
                    delay: 10000,
                    icon_type: 'image',
                    template: '<div data-notify="container" class="col-xs-11 col-lg-3 card card-outline card-{0}" role="alert">' +
                            '<img data-notify="icon" class="img-circle pull-left" style="width:50px !important; vertical-align:middle;">' +
                            '<span data-notify="title">{1}</span>' +
                            '<span data-notify="message">{2}</span>' +
                    '</div>'
                },


            );
            // $('#notif_audio')[0].play();

        }


    </script>
  </head>

<!-- <audio id="notif_audio">
    <source src="<?php echo base_url('sounds/notify.ogg');?>" type="audio/ogg">
    <source src="<?php echo base_url('sounds/notify.mp3');?>" type="audio/mpeg">
    <source src="<?php echo base_url('sounds/notify.wav');?>" type="audio/wav">
</audio> -->
