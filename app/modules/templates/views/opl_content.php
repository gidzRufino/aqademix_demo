<?php
echo Modules::run('templates/opl_header', $title);

$website = Modules::run('main/getSet');
?>
<style>
    body {
        // background: url('<?php echo base_url("mobile-bg.jpg") ?>') no-repeat top center fixed !important; 
        -webkit-background-size: cover !important;
        -moz-background-size: cover !important;
        -o-background-size: cover !important;
        background-size: cover !important;
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php
        if ($this->session->userdata('is_logged_in')):
            $this->load->view('opl_topNav');
            $this->load->view('opl_sideNav');
        endif;
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?php echo $headerTitle ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Widgets</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content">
                <div class="container-fluid">
                    <?php if ($main_header != ""): ?>
                        <a id="mainHeader" href="#" class="bg-indigo alert d-block text-center text-white py-3" style="background-color:#6610f2!important;">
                            <?php echo $main_header ?>
                            <!--<span class="btn btn-sm btn-outline-light ml-3">Try CoreUI PRO 3.0.0-alpha</span>-->
                        </a>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-12  col-xl-9 ">

                            <?php
                            $this->load->view($modules . '/' . $main_content);
                            ?>

                        </div>
                        <div class="d-xl-block col-xl-3 sticky">
                            <?php echo Modules::run('opl/opl_widgets/myClasses', $isClass, $subjectDetails); ?>
                            <div class="card">
                                <div class="card-header text-center">
                                    School Calendar
                                </div>
                                <div class="card-body">
                                    <?php
                                    echo Modules::run('calendar/getCalWidget', date('Y'), date('m'));
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <div>
                </div>
                <div class="ml-auto">
                    <span>Templates by </span><a href="http://adminlte.io">AdminLTE.io</a>
                </div>
            </div>
            <strong>
                <span>Powered by</span>
                <a href="https://aqademix.xyonico.com/">Xyonico</a>
                <span>&copy; <?php echo date('Y') ?></span>
            </strong>
        </footer>
        <footer class="app-footer">

        </footer>

        <div id="loadingModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" style="z-index: 3000;">
            <div class="panel panel-default clearfix" style="width:20%; margin:75px auto; background: #fff;">
                <div class="col-xs-12" style="width:100%;">
                    <div class="col-xs-12">
                        <p class="text-center">Please wait while OPL is processing your request <br />

                            <!-- <img src="<?php // echo base_url() . 'images/loading.gif' 
                                            ?>" style="width:150px;" /> -->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="base" value="<?php echo base_url() ?>" />
    <script>
        $(document).ready(function() {

            checkPortal();
        });



        function showLoading(body) {
            $('#' + body).html($('#submitLoad').html())
        }

        function stopLoading(body) {
            $('#' + body).html('')
        }

        function notMouseMove() {

            $('#idleModal').modal('show');
            startCountDown(120, 1000, idleLogOut, 'idleCount', 1);
            StartBlinking('Logout')

        }

        function idleLogOut() {
            var option = $('#idleLogController').val();
            if (option == 1) {
                document.location = '<?php echo base_url() . 'entrance' ?>';

            }
        }

        function stayLogIn() {
            clearTimeout(timer)
            timer = setTimeout(notMouseMove, 600000);
            StopBlinking()
        }


        var timer = setTimeout(notMouseMove, 600000);

        function resetTimer() {
            startCountDown(0, 1000, stayLogIn, 'idleCount', 0);
        }


        $(document).on('mousemove', function() {
            clearTimeout(timer)
            timer = setTimeout(notMouseMove, 600000);
        });

        var originalTitle;

        var blinkTitle;

        var blinkLogicState = false;

        function StartBlinking(title) {
            originalTitle = document.title;

            blinkTitle = title;

            BlinkIteration();
        }

        function BlinkIteration() {
            if (blinkLogicState == false) {
                document.title = blinkTitle;
            } else {
                document.title = originalTitle;
            }

            blinkLogicState = !blinkLogicState;

            blinkHandler = setTimeout(BlinkIteration, 2000);
        }

        function StopBlinking() {
            if (blinkHandler) {
                clearTimeout(blinkHandler);
            }

            document.title = originalTitle;
        }
    </script>

    <script src="<?php echo base_url(); ?>assets/js/plugins/countdown.js"></script>

    <?php
    echo Modules::run('templates/opl_footer');
