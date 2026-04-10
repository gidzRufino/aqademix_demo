<?php 
    switch ($this->session->userdata('position')){
        case 'Teacher - I':
        case 'Teacher - II':
        case 'Faculty':
            $this->load->view('teachers_dashboard');
        break;
    
        default :
        
?>

<style>
    .dashboard-page {
        background: radial-gradient(circle at top left, #f0f5ff 0, #f7f9fc 40%, #eef2f7 100%);
        padding: 10px 0 30px;
    }

    .dashboard-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .dashboard-title {
        margin: 0;
        font-size: 26px;
        font-weight: 600;
        color: #1f2933;
        letter-spacing: 0.02em;
    }

    .dashboard-subtitle {
        color: #6b7280;
        font-size: 13px;
        margin-top: 4px;
    }

    .dashboard-meta {
        text-align: right;
        font-size: 12px;
        color: #6b7280;
    }

    .dashboard-meta span {
        display: block;
    }

    .dashboard-section {
        opacity: 0;
        transform: translateY(8px);
        transition: all 0.35s ease-out;
    }

    .dashboard-section.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .dashboard-calendar-panel.panel {
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .dashboard-calendar-panel .panel-heading {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        padding: 10px 15px;
        border-bottom: none;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .dashboard-calendar-panel .panel-heading .fa {
        margin-right: 6px;
    }

    .dashboard-calendar-panel .panel-body {
        background: #ffffff;
    }

    .dashboard-widgets-stack > .col-md-12 + .col-md-12 {
        margin-top: 15px;
    }

    .dashboard-right-column {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .dashboard-right-column > .col-lg-12,
    .dashboard-right-column > .col-xs-12 {
        padding-left: 0;
        padding-right: 0;
    }

    @media (max-width: 991px) {
        .dashboard-meta {
            text-align: left;
            margin-top: 8px;
        }
    }

    @media (max-width: 767px) {
        .dashboard-page {
            padding: 0 5px 20px;
        }

        .dashboard-title {
            font-size: 22px;
        }

        .dashboard-right-column {
            margin-top: 15px;
        }
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $(".dashboard-page .dashboard-section").addClass("is-visible");
    });
</script>

<div class="dashboard-page">
    <div class="row dashboard-section">
        <div class="col-lg-12">
            <div class="dashboard-header">
                <div>
                    <h1 class="dashboard-title">Faculty Dashboard</h1>
                    <p class="dashboard-subtitle">Key academic and advisory information in one place.</p>
                </div>
                <div class="dashboard-meta hidden-xs">
                    <span><i class="fa fa-calendar-o"></i> Today: <?php echo date('F d, Y'); ?></span>
                    <span><i class="fa fa-clock-o"></i> Server time: <?php echo date('h:i A'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row dashboard-section">
        <div class="col-md-8 col-xs-12">
            <div class="row dashboard-widgets-stack">
                <div class="col-md-12">
                    <?php
                        if($this->session->is_adviser):
                            echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfPresents'); 
                        endif;
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-4 dashboard-right-column">
            <div class="col-lg-12 col-xs-12">
                <div class="panel panel-default dashboard-calendar-panel">
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

            <div class="col-lg-12 col-xs-12">
                <?php echo Modules::run('widgets/getWidget', 'notification_widgets', 'dashboard'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Morris Charts JavaScript -->
<script src="<?php echo base_url('assets/js/plugins/morris/raphael.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/morris/morris.min.js'); ?>"></script>
<!--<script src="<?php echo base_url('assets/js/plugins/morris/morris-data.js'); ?>"></script>-->

<?php
            
    }

