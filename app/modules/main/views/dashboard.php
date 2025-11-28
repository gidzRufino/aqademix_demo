<script type="text/javascript">
    $(function() {
        $("#tsort").tablesorter({
            debug: true
        });
    });
</script>

<?php
switch ($this->session->userdata('position')) {
    case 'Teacher - I':
    case 'Teacher - II':
    case 'Faculty':
        $this->load->view('teachers_dashboard');
        break;

    default:
?>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-md-4">
                    <h1 class="page-header">Dashboard</h1>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <div class="row">
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
            <div class="col-md-4">
                <div class="col-lg-12 col-xs-12">
                    <div class="panel panel-default">
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
