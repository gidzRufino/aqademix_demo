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
	
?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/'); ?>print.css" media="print" />
    <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-clockpicker.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-datepicker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/select2.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/fancywebsocket.js'); ?>"></script>    
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-notify.min.js'); ?>"></script>  
    <!-- Push Notifications -->
    <script src="<?php echo base_url('assets/js/push.min.js'); ?>"></script>
    
    <!--socket.io js-->
    <script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>
    
    <script type="text/javascript">
        window.moveTo(0,0);
        if (document.all) {window.resizeTo(screen.availWidth,screen.availHeight)}
        else {window.outerHeight = screen.availHeight; window.outerWidth = screen.availWidth}
        
        var socket = io.connect( 'http://'+window.location.hostname+':30000', {transports: ['websocket']} );
        
    
        socket.on('brodcast', function(data){
               showNotification(data.title, data.msg, 'info');
        });
        
        <?php if(empty($this->session->socketUser)): 
                $this->session->set_userdata('socketUser', $this->session->username);
            ?>
            socket.emit('newUser', { login_status: '<?php $this->session->is_logged_in ?>', username: '<?php echo $this->session->username ?>', msg : '<?php echo (date('a')=='am'?'Good Morning':(date('G')>='18'?'Good Evening':'Good Afternoon')).' '.$this->session->name ?>'}, function(data){});
            
        <?php endif; ?>;
            
         socket.emit('join', { username: '<?php echo $this->session->username ?>'});

        
//        Notification Module
            
        function showNotification(title, msg, type)
        {
            $.notify({
                icon: '<?php echo base_url('images/pilgrim.png') ?>',
                title: "<strong>"+(title !==''?title+" :":'')+"</strong> ",
                message: msg
                },

                {
                    type: type,
                    delay: 5000,
                    icon_type: 'image',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert">' +
                            '<img data-notify="icon" class="img-circle pull-left">' +
                            '<span data-notify="title">{1}</span>' +
                            '<span data-notify="message">{2}</span>' +
                    '</div>'
                }

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