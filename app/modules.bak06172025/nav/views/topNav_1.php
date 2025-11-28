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
        <a class="navbar-brand" href="<?php echo base_url() ?>"><i status="0" id="portal_status" class="fa fa-spinner fa-spin fa-fw" ></i><?php echo $settings->set_school_name ?>&nbsp;</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <?php if($this->session->userdata('position')!='Parent'): ?>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-envelope fa-fw"></i> <?php if($notiMsg->num_rows()> 0): echo '<span style="font-size:10px; background: #2A6496" class="badge">'.$notiMsg->num_rows.'</span>';  endif; ?><i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                <?php
                if($notiMsg!=NULL):
                    foreach ($notiMsg->result() as $msg):
                ?>
                <li>
                    <a onclick="readNotification('<?php echo $msg->id ?>', '<?php echo $this->session->userdata('employee_id') ?>','<?php echo $msg->noti_link?>')" href="#">
                        <div>
                            <strong><?php echo $msg->firstname; ?></strong>
                            <span class="pull-right text-muted">
                                <em><?php echo $msg->noti_timestamp; ?></em>
                            </span>
                        </div>
                        <div><?php echo $msg->noti_msg; ?></div>
                    </a>
                </li>
                <li class="divider"></li>
                
                <?php
                    endforeach;
                endif;  
                ?>
                
            </ul>
            <!-- /.dropdown-messages -->
        </li>
        <!-- /.dropdown --><?php 
                echo Modules::run('chatsystem/onlineUsers');
                $basicInfo = Modules::run('hr/getEmployee', base64_encode($this->session->userdata('username')))
                ?>
       
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="#syncModal" data-toggle="modal" data-backdrop="static"  onclick="getNumData(),checkData()">
                        <div>
                            
                            <i class="fa fa-upload fa-fw"></i> Sync Updates to Portal
                            <!--<span class="pull-right text-muted small">4 minutes ago</span> -->
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url().'web_sync/saveToUSB'?>" >
                        <div>
                            
                            <i class="fa fa-download fa-fw"></i> Save Updates to USB
                            <!--<span class="pull-right text-muted small">4 minutes ago</span> -->
                        </div>
                    </a>
                </li>
                
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="<?php echo base_url().'main/viewUpdates'?>">
                        <strong>View All Updates</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <?php endif; ?>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down fa-fw"></i>Hi <?php echo $this->session->userdata('name') ?> !
                
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?php echo base_url().'hr/viewTeacherInfo/'.base64_encode($basicInfo->employee_id) ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
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


    