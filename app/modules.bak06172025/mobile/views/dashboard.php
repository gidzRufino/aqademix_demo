<div data-role="page">
    <div style="z-index: 2000">
        <h1 id="headerTitle" style="text-align:right; padding:5px; margin:0; font-size:30px; color: white"><?php echo $settings->set_school_name ?></h1>
    </div>
    <div data-role="content">    
        <?php 
        switch ($this->session->userdata('position')){
                case 'Parent':
                    $this->load->view('parents/parent_dashboard');
                break;    
                case 'Faculty':
                    $this->load->view('faculty/teachers_dashboard');
                break;

                default :
            echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfPresents'); 
            echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfEmployeePresents');
        ?>
         <div class="col-lg-4 col-xs-12 pull-right">
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
        <?php
           
        } ?>
   </div>
</div>

<?php 
        switch ($this->session->userdata('position')){
                case 'Parent':
                    echo Modules::run('registrar/getAllStudents') ?>
                
                <?php
                break;    
                case 'Faculty':
                    echo Modules::run('academic/mySubjects');
                    echo Modules::run('attendance/dailyPerSubject');
                break;
        }
