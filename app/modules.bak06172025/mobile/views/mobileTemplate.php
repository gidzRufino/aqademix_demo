<!DOCTYPE html >
<?php
 //   echo header("Content-Type: text/html; charset=UTF-8");   
?>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php
    echo link_tag('assets/css/jquery.mobile-1.4.0.min.css');
    echo link_tag('assets/css/jquery.mobile.structure-1.4.0.min.css');
    echo link_tag('assets/css/dp.css');
    echo link_tag('assets/css/bootstrap.css');
    echo link_tag('assets/css/bootstrap-responsive.css');
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/datepicker.css');
    echo link_tag('assets/css/select2.css');
    echo link_tag('assets/css/myStyle.css');
    echo link_tag('assets/css/bootstrap-editable.css');
    ?>
</head>
<body style="height:100%;">
<div data-role="page" data-theme="a" id="">
    	<div data-role="panel" id="leftpanel3" data-position="left" data-display="overlay" data-theme="b">

                <h3>Leftx: Overlay</h3>
                <p>This panel is positioned on the right with the overlay display mode. The panel markup is <em>after</em> the header, content and footer in the source order.</p>
                <p>To close, click off the panel, swipe left or right, hit the Esc key, or use the button below:</p>
                <a href="#demo-links" data-rel="close" class="ui-btn ui-shadow ui-corner-all ui-btn-a ui-icon-delete ui-btn-icon-left ui-btn-inline">Close panel</a>

	</div>
    <div data-role="header" data-position="inline" data-fullscreen="true">
        <a style="float:right; margin-top:0;" data-toggle="modal" href="#leftpanel3">
            <img style="width:30px" src="<?php echo base_url();?>images/dp.png" />
        </a>
        <a style="float:right; margin-top:10px;" onclick="document.location=this.href" data-toggle="modal" href="<?php echo base_url('index.php/mobile/logout')?>">Logout</a>
        <h1>DigitizingPro.com</h1>
        
    </div>
    <div data-role="content" data-theme="a" data-position="fixed">
       <?php $this->load->view($main_content) ?>
    </div>
    <div data-role="footer" data-position="fixed">
        <h2>Copyright &COPY; <?php echo date('Y') ?> <a href="http://digitizingpro.com/">DigitizingPro.com</a> </h2>
    </div>

</div>

<script type="text/javascript">
   $("#loginSubmit").click(function() {
     //alert('hey')
    var url = "<?php echo base_url()?>index.php/mobile/getInside"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#loginFormInput").serialize(), // serializes the form's elements.
           success: function(data)
           {
               document.getElementById('mobileWrapper').innerHTML = data
           }
         });
    
    return false; // avoid to execute the actual submit of the form.
    });
</script>
        <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.mobile-1.4.0.min.js"></script>
        <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/ajaxfileupload.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/validation.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.cookie.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/fingerprint.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap-limit.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/select2.js'); ?>"></script> 
        <script src="<?php echo base_url('assets/js/bootstrap.clickover.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap-editable.js'); ?>"></script>
    </body>
</html>