<?php if ($this->session->is_logged_in): ?>

<div class="modal" id="idleModal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div id="idleMessage" class="alert alert-danger">
                    <h4 class="text-center">Your Session in e-sKwela-LEARN MANAGER is about to Expire in <span id="idleCount"></span> seconds.</h4>
                </div>
            </div>
            <div class="modal-footer text-center">
                    <button class="pull-right btn btn-success btn-sm" data-dismiss="modal" onclick="resetTimer()">STAY</button>
                    <input type="hidden" value="1" id="idleLogController" />
                    <button class="pull-right btn btn-danger btn-sm" onclick="document.location = '<?php echo base_url() . 'login/logout' ?>'" >LOGOUT</button>
            </div>
        </div>
    </div>  
</div>

    <script>

        $(document).ready(function () {
            $('select').select2({
                theme: 'bootstrap4'
            });

            resetTimer = function ()
            {
                startCountDown(0, 1000, stayLogIn, 'idleCount', 0);
                $('#idleModal').modal('hide');
            };

        });


        function numberWithCommas(x) {
            if (x == null) {
                x = 0;
            }
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }



        function showLoading(body)
        {
            $('#' + body).html($('#submitLoad').html())
        }

        function stopLoading(body)
        {
            $('#' + body).html('')
        }

        function notMouseMove() {

            $('#idleModal').modal('show');
            startCountDown(120, 1000, idleLogOut, 'idleCount', 1);
            StartBlinking('Logout')

        }

        function idleLogOut()
        {
            var option = $('#idleLogController').val();
            if (option == 1) {
                document.location = '<?php echo base_url() . 'login/logout' ?>'

            }
        }

        function stayLogIn()
        {
            clearTimeout(timer)
            timer = setTimeout(notMouseMove, 600000);
            StopBlinking();
        }


        $(document).on('mousemove', function () {
            clearTimeout(timer);
            timer = setTimeout(notMouseMove, 600000);
        });

        var originalTitle;

        var blinkTitle;

        var blinkLogicState = false;

        function StartBlinking(title)
        {
            originalTitle = document.title;

            blinkTitle = title;

            BlinkIteration();
        }

        function BlinkIteration()
        {
            if (blinkLogicState == false)
            {
                document.title = blinkTitle;
            } else
            {
                document.title = originalTitle;
            }

            blinkLogicState = !blinkLogicState;

            blinkHandler = setTimeout(BlinkIteration, 2000);
        }

        function StopBlinking()
        {
            if (blinkHandler)
            {
                clearTimeout(blinkHandler);
            }

            document.title = originalTitle;
        }

        //reading notification

        function readNotification(noti_id, user_id, link)
        {
            var url = '<?php echo base_url() . 'notification_system/readNoti/' ?>' + noti_id + '/' + user_id;
            $.ajax({
                type: "GET",
                url: url,
                data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                success: function (data)
                {
                    document.location = link;

                }
            });
            return false;
        }



    </script>

<?php endif; ?>

<script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>
<script src="<?php echo base_url('opl_assets/js/adminlte.min.js'); ?>"></script>
<script src="<?php echo base_url('opl_assets/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('opl_assets/summernote/summernote.min.js'); ?>"></script>
<script src="<?php echo base_url('opl_assets/summernote/plugins/summernote-file.js'); ?>"></script>
<script src="<?php echo base_url('opl_assets/summernote/summernote-ext-print.js'); ?>"></script>
<script src="<?php echo base_url('opl_assets/js/bootstrap-clockpicker.min.js'); ?>"></script>
<script src="<?php echo base_url('opl_assets/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/bootstrap-contextmenu.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/countdown.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/moment.js'); ?>"></script>
<script src="<?php echo base_url("opl_assets/fullcalendar/fullcalendar.min.js"); ?>"></script>


</body>
</html>
