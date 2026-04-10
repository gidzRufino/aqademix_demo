<?php
    echo doctype('html5');
    echo header("Content-Type: text/html; charset=UTF-8");
    echo '<head>'; 
    echo link_tag('assets/css/bootstrap.min.css');  
    echo link_tag('assets/css/mobile/jquery.mobile-1.4.2.min.css');
    echo link_tag('assets/css/mobile/jquery.mobile.structure-1.4.2.min.css');
    echo link_tag('assets/css/mobile/jquery.mobile.theme-1.4.2.min.css');
    echo link_tag('assets/font-awesome-4.2.0/css/font-awesome.min.css');
    echo link_tag('assets/css/plugins/datepicker.css');
    echo link_tag('assets/css/plugins/select2.css');
    echo link_tag('assets/css/calendar.css');
    echo link_tag('assets/css/sb-admin-2.css');
    echo link_tag('assets/css/mobile/mobile.css');
?>
 <title>Integrated Student Management Systems</title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
 <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.0.js"></script>
 <script src="<?php echo base_url()?>assets/js/mobile/jquery.mobile-1.4.2.min.js"></script>
 <style>
    .ui-overlay-a, .ui-page-theme-a, .ui-page-theme-a .ui-panel-wrapper{
        background-color:inherit;
    }
     #body{
         
    background: url('<?php echo base_url("mobile-bg.jpg") ?>') no-repeat top center fixed !important; 
    -webkit-background-size: cover !important;
    -moz-background-size: cover !important;
    -o-background-size: cover !important;
    background-size: cover !important; 
     }
 </style>

</head>
<body id="body" style="overflow-y: scroll">
    <div id="load" style=" display: none;" ><div style="background-color:#666;
opacity : 0.6; position:fixed; left:0; right: 0; top:0; bottom: 0; display: block; z-index: 1000; background-repeat : no-repeat;
background-position : center;"> 
    </div>
        <!-- <img src="<?php echo base_url("images/loading.gif") ?>" style="left :42%;
top : 30%;
position : absolute;
z-index: 2000;
opacity: 1;
width : 25%;
height : 20%;
margin-left : -16px;
margin-top : -16px;" /> -->
    </div> 

    