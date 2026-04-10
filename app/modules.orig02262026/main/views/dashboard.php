<script type="text/javascript">
    $(function() {
        $("#tsort").tablesorter({
            debug: true
        });
    });
    // Smooth fade-in for dashboard sections
    $(document).ready(function() {
        $(".dashboard-page .dashboard-section").addClass("is-visible");
    });
</script>

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

<?php
switch ($this->session->userdata('position')) {
    case 'Teacher - I':
    case 'Teacher - II':
    case 'Faculty':
        $this->load->view('teachers_dashboard');
        break;

    default:
?>
        <div class="dashboard-page">
            <div class="row dashboard-section">
                <div class="col-lg-12">
                    <div class="dashboard-header">
                        <div>
                            <h1 class="dashboard-title">Dashboard</h1>
                            <p class="dashboard-subtitle">Overview of attendance, collections, and upcoming activities.</p>
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
                            <?php echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfPresents'); ?>
                            <?php
                            if ($settings->level_catered == 5):
                                echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfPresentCollege');
                            endif;
                            ?>
                            <?php echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfEmployeePresents'); ?>
                        </div>
                        <div class="col-md-12">
                            <?php
                            if ($this->session->userdata('position_id') == 1 || $this->session->userdata('position_id') == 271288):
                                echo Modules::run('finance/paymentVsCollectibleGraph');
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
                            $days = 0;
                            $gs_start = date('m', strtotime($settings->bosy));
                            $yy = date('Y', strtotime($settings->bosy));
                            $gs_end = date('m', strtotime($settings->eosy));
                            $cc = 12 - ($gs_start - 2);

                            for ($i = $gs_start; $i <= (12 + $gs_end); $i++):   //-----> whole school year
                                ($cc == 0 ? 0 : $cc--);
                                $year = ($cc == 0 ? ($yy + 1) : $yy);
                                $m = $i;
                                $mo_in_num = ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m);
                                $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $mo_in_num, 10)), $year, 'first');
                                $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $mo_in_num, 10)), $year, 'last');

                                //                            if (abs($mo_in_num) < 6 && date('Y') > $settings->school_year):
                                //                                $year = $settings->school_year + 1;
                                //                            else:
                                //                                $year = $settings->school_year;
                                //                            endif;

                                for ($x = $firstDay; $x <= $lastDay; $x++) {    //------>  per month loop
                                    $day = date('D', strtotime($year . '-' . $mo_in_num . '-' . $x));
                                    $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $mo_in_num . '-' . $x)));
                                    $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $mo_in_num . '-' . $x)));

                                    if ($day == 'Sat' || $day == 'Sun') {
                                        if ($isClass):
                                            $days++;
                                        endif;
                                    } else {
                                        if (!$isHoliday):
                                            $days++;
                                        endif;
                                    }
                                }
                                $monthName = date('F', strtotime(date('Y-' . $mo_in_num . '-01')));
                                Modules::run('reports/insertNumSchoolDays', $monthName, $settings->school_year, $days, 2);
                                $days = 0;
                            endfor;

                            echo Modules::run('calendar/getCalWidget', date('Y'), date('m'));
                            ?>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-4 -->
                    <div class="col-lg-12 col-xs-12">
                        <?php echo Modules::run('widgets/getWidget', 'notification_widgets', 'dashboard'); ?>
                    </div>
                </div>
            </div>
            <?php //echo Modules::run('widgets/getWidget', 'attendance_widgets', 'averageDailyAttendance'); 
            ?>
        </div>
        <!-- <div class="row">


        </div> -->
        <!-- /.row -->
        <script type="text/javascript">
            $("#send_text").click(function() {
                $("#text_modal").modal();
            });

            function count_char(val) {
                var len = val.value.length;
                if (len >= 90) {
                    val.value = val.value.substring(0, 90);
                } else {
                    $("#counter").text(90 - len);
                }
            }

            $("#send_text_btn").click(function() {
                var url = "<?php echo base_url() . 'main/send_text' ?>";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#text_sender_form").serialize() + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                    success: function(data) {
                        alert("Success!!! Charge successfully added.");
                        // location.reload();
                    }
                });
            });


            //##########################################################################
            // ITEXMO SEND SMS API - PHP - CURL-LESS METHOD
            // Visit www.itexmo.com/developers.php for more info about this API
            //##########################################################################

            //##########################################################################
        </script>
        <!-- Morris Charts JavaScript -->
        <script src="<?php echo base_url('assets/js/plugins/morris/raphael.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/plugins/morris/morris.min.js'); ?>"></script>
        <!--<script src="<?php echo base_url('assets/js/plugins/morris/morris-data.js'); ?>"></script>-->

<?php
}
