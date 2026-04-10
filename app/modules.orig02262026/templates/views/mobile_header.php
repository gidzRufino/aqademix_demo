<?php 
    echo doctype('html5');
    echo header("Content-Type: text/html; charset=UTF-8");
    echo '<head>';   
?>
<title>[  <?php echo strtoupper($settings->short_name); ?> - e-sKwela]</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php
    
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/sb-admin-2.css');
    echo link_tag('assets/css/plugins/morris.css');
    echo link_tag('assets/css/plugins/timeline.css');
    echo link_tag('assets/css/plugins/defaultTheme.css');
    echo link_tag('assets/font-awesome/css/font-awesome.min.css');
    echo link_tag('assets/css/plugins/select2.css');
	
?>
   <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/select2.min.js'); ?>"></script>
    <script type="text/javascript">
        window.moveTo(0,0);
        if (document.all) {window.resizeTo(screen.availWidth,screen.availHeight)}
        else {window.outerHeight = screen.availHeight; window.outerWidth = screen.availWidth}
    </script>
  </head>
<body style="height:100%;">
