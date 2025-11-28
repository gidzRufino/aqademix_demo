<?php
echo Modules::run('templates/html_header');

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


    .myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    .myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal-img {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content-img {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content-img,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close-img {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close-img:hover,
    .close-img:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content-img {
            width: 100%;
        }
    }
</style>
<div class="col-lg-12 no-padding">
    <?php $this->load->view($modules . '/' . $main_content);
    ?>
</div>

<?php if ($this->uri->segment(1) != 'enrollment'): ?>
    <script type="text/javascript">
        function logout() {
            var con = confirm('Are you sure you want to logout?');
            if (con == true) {
                document.location = "<?php echo base_url() . $login_page; ?>"
            }
        }
    </script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/countdown.js"></script>


    <div id="idleModal" class="modal fade" style="width:450px; margin: 0 auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="alert alert-danger" id="idleMessage">
            <h4 class="text-center">Your Session in Aqademix is about to Expire in <span id="idleCount"></span> seconds.</h4>
            <button class="pull-right btn btn-success btn-sm" data-dismiss="modal" onclick="resetTimer()">STAY</button>
            <input type="hidden" value="1" id="idleLogController" />
            <button class="pull-right btn btn-danger btn-sm" onclick="document.location = '<?php echo base_url() . $login_page ?>'">LOGOUT</button>
        </div>
    </div>
<?php endif; ?>
<div id="loadingModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" style="z-index: 3000;">
    <div class="panel panel-default clearfix" style="width:20%; margin:75px auto;">
        <div class="col-xs-12" style="width:100%;">
            <div class="col-xs-12">
                <p class="text-center">Please wait while processing your request <br />

                    <!-- <img src="<?php // echo base_url() . 'images/loading.gif' 
                                    ?>" style="width:150px;" /> -->
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        // checkPortal();
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
            document.location = '<?php echo base_url() . $login_page ?>';

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
<!-- The Modal -->
<div id="imgModal" class="modal-img">
    <span class="close">&times;</span>
    <img class="modal-content-img" id="img01">
    <div id="caption"></div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("imgModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementsByClassName("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    $('.myImg').click(function() {
        modal.style.display = "block";
        modalImg.src = $(this).attr('src');
        captionText.innerHTML = $(this).attr('alt');
    });

    $('#imgModal').click(function() {
        modal.style.display = "none";
    });

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
</script>


<!-- timepicker JavaScript -->
<script src="<?php echo base_url('assets/js/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url('assets/js/plugins/metisMenu/metisMenu.min.js'); ?>"></script>

<!-- Web Sync Controller JavaScript -->
<script src="<?php echo base_url('assets/js/sync_controller.js'); ?>"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url('assets/js/plugins/bootstrap.clickover.js'); ?>"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url('assets/js/sb-admin-2.js'); ?>"></script>

<!--table sorter javascript -->
<script src="<?php echo base_url('assets/js/plugins/jquery.tablesorter.js'); ?>"></script>

<!--Editable Table Javascript-->
<script src="<?php echo base_url('assets/js/plugins/bootstrap-editable.js'); ?>"></script>

<!--Tootip Plugin Javascript-->
<script src="<?php echo base_url('assets/js/plugins/bootstrap-tooltip.js'); ?>"></script>

<!--Cookie Javascript-->
<script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>

<!--graph Javascript-->
<script src="<?php echo base_url('assets/js/plugins/flotr2.min.js'); ?>"></script>


<script src="<?php echo base_url(); ?>assets/js/plugins/bootstrap-contextmenu.js"></script>

<script src="<?php echo base_url(); ?>assets/js/plugins/ajax.js"></script>


</body>

</html>