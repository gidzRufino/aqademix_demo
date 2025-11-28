<?php
    $parent = Modules::run('users/getParentData', $this->session->userdata('user_id'));
?>

<div class="row">
    <div class="col-lg-12 ">
        <h3 class="page-header clearfix"><span class="col-lg-6">Parent Dashboard</span><small style="margin-top:10px;"  onclick="logout()" class="pull-right pointer" ><?php echo $settings->set_school_name ?></small></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <!--messeage widget-->
    <div class="col-lg-3 col-md-6">
        <?php echo Modules::run('widgets/parent_portal_widgets/studentInfo' ); 
        ?>
    </div>
    
    <!--student rank widget-->
    <div class="col-lg-3 col-md-6">
        <?php echo Modules::run('widgets/parent_portal_widgets/subjectTeachers'); ?>
    </div>
    <div class="col-lg-3 col-md-6">
        <?php echo Modules::run('widgets/parent_portal_widgets/dailyReports'); ?>
    </div>
    <?php echo Modules::run('widgets/finance_widgets/show_students',$parent->child_links); ?>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-comments fa-fw"></i> Notifications
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" style="height:260px; overflow-y:scroll ">
                <?php 
                    foreach(explode(',', $parent->child_links) as $child):
                        $student = Modules::run('registrar/getSingleStudent', $child, $this->session->userdata('school_year'));
                        $notification = Modules::run('notification_system/getNotification', $student->user_id);
                        if(!empty($notification)):
                        foreach($notification->result() as $noti): ?>
                        <div class="alert alert-success alert-dismissable " style="margin-bottom: 5px;">
                            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                            <?php echo $noti->noti_msg ?>
                            <a class="alert-link" href="<?php echo $noti->noti_link; ?>">Link</a>
                            <span class="pull-right text-muted small"><em><?php echo $noti->noti_timestamp ?></em></span>
                        </div>

                        <?php endforeach; 
                        endif;
                    endforeach;
                    ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->

    </div>
    <!-- /.col-lg-8 -->
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-calendar fa-fw"></i> School Calendar
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" style="padding:0;">
               <?php
                    echo Modules::run('calendar/getCalWidget', date('Y'), date('m'));
                ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        
    </div>
    <!-- /.col-lg-4 -->
</div>
<!-- /.row -->

