<?php 
      echo doctype('html5');
      // echo link_tag('assets/css/bootstrap.min.css');
      // echo link_tag('assets/css/plugins/li-scroll.css');
      // echo link_tag('assets/font-awesome-4.2.0/css/font-awesome.min.css');

?>
<head>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>"> 
    <link rel="stylesheet" href="<?php echo base_url('assets/css/plugins/li-scroll.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome-4.2.0/css/font-awesome.min.css'); ?>">
   <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
   <script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>  
</head>
<body>
   <div class="container-fluid">
      
   </div>
<script type="text/javascript">
   $(document).ready(function() { 
      setTimeout(function(){
         location.reload();
         }, 10000);
   });
   

</script>

<script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>
<script src="<?php echo base_url('assets/js/sync_controller.js'); ?>"></script>
</body>
