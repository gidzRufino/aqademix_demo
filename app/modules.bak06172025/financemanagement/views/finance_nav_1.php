<?php
    $dept_id = $this->session->userdata('dept_id');
    $position_id = $this->session->userdata('position_id');
?>

<div class="row-fluid navbar-fixed-top" style="background: #02008C;">
    <li onclick="document.getElementById('notiCount1').innerHtml = document.getElementById('notiCount').innerHtml" class="dropdown">    
      &nbsp; &nbsp;<a href="<?php echo base_url(); ?>main/dashboard"><i class="icon-home icon-white"></i></a>
      <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span style="color:white;font-weight: bold;">Hi <?php echo $this->session->userdata('name'); ?>!</span> 
      <span style="color:white;font-weight: bold;">Welcome to e-sKwela Finance Management</span>
     </a>
     <?php if ($this->uri->segment(2)=='config'){?>      
     <a style="float:right;" href="<?php echo base_url(); ?>financemanagement/search"><span style="color:white;font-weight: bold;">Finance Accounts &nbsp;</span><i class="icon-user icon-white"></i>&nbsp;</a>
     <a style="float:right; margin-right: 10px;" href="<?php echo base_url(); ?>financemanagement/reports"><span style="color:white;font-weight: bold;">&nbsp; Finance Reports &nbsp;</span><i class="icon-briefcase icon-white"></i>&nbsp;</a>
     <a style="float:right; margin-right: 10px;" href="<?php echo base_url(); ?>financemanagement/collect"><span style="color:white;font-weight: bold;">&nbsp; Collection Notice &nbsp;</span><i class="icon-envelope icon-white"></i>&nbsp;</a>
      <?php } elseif ($this->uri->segment(2)=='reports'){ ?>
      <a style="float:right;" href="<?php echo base_url(); ?>financemanagement/config"><span style="color:white;font-weight: bold;">Finance Settings &nbsp;</span><i class="icon-shopping-cart icon-white"></i>&nbsp;</a>&nbsp;
      <a style="float:right;margin-right: 10px;" href="<?php echo base_url(); ?>financemanagement/search"><span style="color:white;font-weight: bold;">Finance Accounts &nbsp;</span><i class="icon-user icon-white"></i>&nbsp;</a>
      <a style="float:right; margin-right: 10px;" href="<?php echo base_url(); ?>financemanagement/collect"><span style="color:white;font-weight: bold;">&nbsp; Collection Notice &nbsp;</span><i class="icon-envelope icon-white"></i>&nbsp;</a>
     <?php } elseif ($this->uri->segment(2)=='collect'){ ?>
     <a style="float:right;" href="<?php echo base_url(); ?>financemanagement/config"><span style="color:white;font-weight: bold;">Finance Settings &nbsp;</span><i class="icon-shopping-cart icon-white"></i>&nbsp;</a>
     <a style="float:right; margin-right: 10px;" href="<?php echo base_url(); ?>financemanagement/reports"><span style="color:white;font-weight: bold;">&nbsp; Finance Reports &nbsp;</span><i class="icon-briefcase icon-white"></i>&nbsp;</a>
     <a style="float:right;" href="<?php echo base_url(); ?>financemanagement/search"><span style="color:white;font-weight: bold;">Finance Accounts &nbsp;</span><i class="icon-user icon-white"></i>&nbsp;</a>
     <?php } else { ?>
     <a style="float:right;" href="<?php echo base_url(); ?>financemanagement/config"><span style="color:white;font-weight: bold;">Finance Settings &nbsp;</span><i class="icon-shopping-cart icon-white"></i>&nbsp;</a>
     <a style="float:right; margin-right: 10px;" href="<?php echo base_url(); ?>financemanagement/reports"><span style="color:white;font-weight: bold;">&nbsp; Finance Reports &nbsp;</span><i class="icon-briefcase icon-white"></i>&nbsp;</a>
     <a style="float:right; margin-right: 10px;" href="<?php echo base_url(); ?>financemanagement/collect"><span style="color:white;font-weight: bold;">&nbsp; Collection Notice &nbsp;</span><i class="icon-envelope icon-white"></i>&nbsp;</a>
     <?php } ?>
     <ul class="dropdown-menu">
       <li class=""><a data-toggle="modal" href="#changePassword">Edit login Information</a></li>
       <li class=""><a style="float:left;" href="<?php echo base_url(); ?>notification">Notification</a></li>
       <li class=""><a href="<?php echo base_url(); ?>login/logout">Logout</a></li>
      </ul>
    </li>
</div>            
<input type="hidden" id="setAction" /> 