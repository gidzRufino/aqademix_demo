<?php

if($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')):
    $notiMsg = Modules::run('widgets/getWidget', 'notification_widgets', 'getAdminNotification', $this->session->userdata('employee_id'));
else:
    $notiMsg = Modules::run('notification_system/getNotification', $this->session->userdata('employee_id'));
endif;
?>
<div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    <?php $string = explode('/', base_url()); 
    if($string[2]!="localhost"):
    ?>
        <?php if($settings->cu_status):?> 
    <a class="navbar-brand" href="<?php echo ($this->session->userdata('dept_id')==10? base_url('college'):base_url()) ?>"><i  style="color:#33EF26" status="0" id="client_status" class="fa fa-spinner fa-circle fa-fw" ></i><?php echo $settings->set_school_name ?>&nbsp;</a>
        <?php else:?> 
            <a class="navbar-brand" href="<?php echo ($this->session->userdata('dept_id')==10? base_url('college'):base_url()) ?>"><i style="color:#F70000" status="0" id="client_status" class="fa fa-spinner fa-circle fa-fw" ></i><?php echo $settings->set_school_name ?>&nbsp;</a>
        <?php endif;
        else: ?>
            <a class="navbar-brand" href="<?php echo ($this->session->userdata('dept_id')==10? base_url('college'):base_url()) ?>"><i status="0" id="portal_status" class="fa fa-spinner fa-spin fa-fw" ></i><?php echo $settings->set_school_name ?>&nbsp;</a>
        <?php endif; ?>   

</div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <?php if($this->session->userdata('position')!='Parent'): ?>
        
        <?php endif; ?>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down fa-fw"></i>Hi <?php echo $this->session->userdata('name') ?> !
                
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?php echo base_url().'hr/viewTeacherInfo/'.base64_encode($this->session->userdata('employee_id')) ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <!--<li><a href="<?php echo base_url().'main/divisionSettings' ?>"><i class="fa fa-gear fa-fw"></i> Settings</a>-->
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url().'login/logout'?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->


    