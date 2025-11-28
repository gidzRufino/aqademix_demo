<?php
if (Modules::run('main/isMobile')) {
    echo Modules::run('mobile/index');
} else {
    echo doctype('html5');
    echo header("Content-Type: text/html; charset=UTF-8");
    echo '<head>';
    ?>
    <title>[
        <?php echo strtoupper($settings->short_name); ?> - SMIS ]
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php
    echo link_tag('assets/css/bootstrap.min.css');
    echo link_tag('assets/css/sb-admin-2.css');
    echo link_tag('assets/css/plugins/morris.css');
    echo link_tag('assets/css/plugins/select2.css');
    echo link_tag('assets/font-awesome/css/font-awesome.min.css');
    echo link_tag('assets/css/plugins/datepicker.css');

    ?>
    <script src="<?php echo base_url('assets/js/jquery-1.11.0.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-datepicker.js'); ?>"></script>
    </head>

    <body>
        <style scoped>
            @media only screen and (max-width: 768px) {
                #test-element {
                    display: none;
                }

                .welcome_msg {
                    display: none;
                }

                .login_msg {
                    border-radius: 0px 10px 10px 0px;
                }
            }

            @media only screen and (min-width: 769px) {
                #test-element {
                    display: none;
                }

                /* .login_msg{display:none;} */
            }

            @-webkit-keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            .greet {
                font-size: 50px;
                margin-top: 50px;
                font-weight: bold;
                text-align: center;
                color: white;
            }

            .welcome_msg {
                height: 450px;
                border-radius: 10px 0px 0px 10px;
                background: #ffffff;
                box-shadow:
                    0px 0px 2.8px rgba(0, 0, 0, 0.028),
                    0px 0px 6.7px rgba(0, 0, 0, 0.04),
                    0px 0px 12.6px rgba(0, 0, 0, 0.05),
                    0px 0px 22.6px rgba(0, 0, 0, 0.06),
                    0px 0px 42.2px rgba(0, 0, 0, 0.072),
                    0px 0px 101px rgba(0, 0, 0, 0.1);
            }

            body {
                background: linear-gradient(-45deg, #4a92f7, #c177e0, #38e0ae, #22f2f2);
                background-size: 500% 500%;
                animation: gradient 15s ease infinite;
            }

            .welcome_back {
                height: 90%;
                width: 100%;
                /* border-radius:10px 0px 0px 10px;
              background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
              background-size: 400% 400%;
              animation: gradient 15s ease infinite; */
            }

            .school_logo {
                width: 290px;
                margin-top: 95px;
                background: white;
            }

            h2 {
                padding-top: 35px;
                color: white;
                margin-left: 20px;
                /* font-size: 35px; */
            }

            .welcome_text {
                /* font-size: 35px; */
                margin-top: 50px;
                font-weight: bold;
                text-align: center;
                color: #367FA9;
            }

            .login_msg {
                /* margin: 7% auto; */
                height: 450px;
                border-radius: 0px 10px 10px 0px;
                /* padding: 40px; */
                border-top: 0px;
                color: #888;
                background-color: rgba(255, 255, 255, .7);
                box-shadow:
                    0px 0px 2.8px rgba(0, 0, 0, 0.028),
                    0px 0px 6.7px rgba(0, 0, 0, 0.04),
                    0px 0px 12.6px rgba(0, 0, 0, 0.05),
                    0px 0px 22.6px rgba(0, 0, 0, 0.06),
                    0px 0px 42.2px rgba(0, 0, 0, 0.072),
                    0px 0px 101px rgba(0, 0, 0, 0.1);
            }

            .login-boxie-body {
                height: 450px;
                width: 100%;
                border-radius: 10px;
                /* padding: 40px; */
                border-top: 0px;
                color: #888;
                background-color: rgba(255, 255, 255, .7);
                box-shadow:
                    0px 0px 2.8px rgba(0, 0, 0, 0.028),
                    0px 0px 6.7px rgba(0, 0, 0, 0.04),
                    0px 0px 12.6px rgba(0, 0, 0, 0.05),
                    0px 0px 22.6px rgba(0, 0, 0, 0.06),
                    0px 0px 42.2px rgba(0, 0, 0, 0.072),
                    0px 0px 101px rgba(0, 0, 0, 0.1);
            }

            .signup {
                color: #3071A9;
                font-size: 12px;
            }

            .login-boxie {
                /* width: 70%; */
                margin-top: 5%;
            }

            .form-control-feedback {
                top: 0px;
            }

            .clogo {
                width: 100%;
                margin: 1% auto;
                /* border-radius: 5px; */
            }

            .qlogo {
                margin-top: 90px;
                width: 30%;
                display: block;
                margin-left: auto;
            }

            .form-group {
                width: 90%;
                margin: 10px auto;
            }

            .form-control {
                border-radius: 10px;
                border: none;
                background-color: #f7f7f7;
            }

            #msignin {
                width: 80%;
                margin: 20px auto;
                border-radius: 15px;
            }
        </style>

        <div class="login-boxie col-md-8 col-md-offset-2 col-sm-12">
            <div id="test-element"></div>

            <?php
            $day_now = date('N');
            $maintenance = 0;
            if ($maintenance == 1) {
                ?>

                <div class="login-boxie-body" id="logmob">
                    <div class="row">
                        <div class="col-md-12"><br />
                            <h3 class="login-box-msg">This site is under preventive maintenance. We are sorry for the
                                inconvenience. Please try to check us later.</h3>
                            <h3 class="login-box-msg">God bless</h3>
                            <h3 class="login-box-msg">- System Bot -</h3>
                            <div id="confirmation"></div>
                        </div>
                    </div>
                </div>

            <?php } else { ?>

                <div class="logwel_box">
                    <div class="row">
                        <div class="col-md-6 col-xs-12 col-sm-6  text-center">
                            <span class="greet">Hello! Welcome back! </span>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-6 welcome_msg">
                        <div class="welcome_back">
                            <div class="logo text-center">
                                <img class="school_logo"
                                    src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6 login_msg">
                        <h2 class="welcome_text"><i class="fa fa-user"></i> User Login</h2>
                        <div id="confirmation"></div>
                        <?php
                        //echo base_url();
                        $attributes = array('class' => 'form', 'id' => 'addEmForm');
                        echo form_open(base_url() . 'login/verify', $attributes);

                        ?>
                        <div class="form-group has-feedback input-prepend">
                            <input type="text" class="form-control" id="uname" name="uname" placeholder="Username">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback input-prepend" id="password">
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Password"
                                onkeypress="if (event.keyCode==13){ getInside(this.value);}">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="submit" id="msignin" class="btn btn-primary btn-block btn-flat">LOGIN</button>
                                <div id="result" class="help-block success"></div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-xs-12 text-center">
                                <a class="clearboth text-center signup" data-toggle="modal" href="#signUp">
                                    <i class="fa fa-pencil"></i>
                                    Sign Up for an Account (Note: For Parents Only)
                                </a>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <span class="powered_by">
                                    <img class="qlogo" src="<?php echo base_url("images/icons/aqademix_tx.png"); ?>" alt=""
                                        class="img-responsive">
                                </span>
                            </div>
                        </div>
                        <?php
                        echo form_close();
                        ?>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6  pull-right text-center">
                        <span class="greet">Have a blessed day! </span>
                    </div>
                </div>
            <?php } ?>

        </div>


        <div id="signUp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-header" style="background:#000; border-radius:15px 15px 0 0; ">
                    <h1 class="text-center" style="height:30px; color: white ;font-size: 20px;">
                        <?php echo $settings->set_school_name ?>
                    </h1>
                    <h4 class="text-center" style="color:white;">Sign Up for a New Account</h4>
                </div>
                <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 0px 10px 10px;" class="modal-body">
                    <fieldset>
                        <label class="text-center text-info">Please Enter Your Phone Number or Email and click the Search
                            button to Verify</label>
                        <div style="margin:0 25%; ">
                            <div>
                                <div id="verifyP" class="form-group input-group ">
                                    <input onblur="verifyParent($('#verify').val())"
                                        onkeypress="if(event.keycode==13){verifyParent(this.value)}"
                                        class="error form-control" id="verify" placeholder="Enter Email or Phone Number"
                                        type="text">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default">
                                            <i id="verify_icon" onclick="verifyParent($('#verify').val())"
                                                class="fa fa-search" style="font-size:20px;"></i>
                                        </button>
                                    </span>
                                </div>

                                <div id="confirm">
                                    <input type="hidden" id="vResults" value="0" />
                                    <input type="hidden" id="parent_id" value="0" />
                                    <span id="confirmation"></span>
                                </div>

                            </div>
                            <div id="inputForms" class="hidden">
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input class="form-control" id="regUname" placeholder="username" type="text">
                                </div>

                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input class="form-control" id="pass0" placeholder="password" type="password">
                                </div>
                                <div id="pass_error">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <input onkeyup="checkPass(this.value, $('#pass0').val())" class="error form-control"
                                            id="pass1" placeholder="Retype Password" type="password">

                                    </div>
                                    <div>
                                        <span id="pass_error_msg"></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </fieldset>

                    <!--</form>-->

                    <div class="modal-footer">
                        <div class="form-group">
                            <div class="controls">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                <a href="#verifyStudentNumber" id="verifySubmit" data-dismiss="modal" data-toggle="modal"
                                    class="btn success hide">SUBMIT</a>
                                <div id="resultSection" class="help-block success"></div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div id="verifyStudentNumber" class="modal fade" style="width:500px; margin:50px auto;" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header" style="background:#000; border-radius:15px 15px 0 0; ">
                <h1 class="text-center" style="font-size:30px; color:white;">
                    <?php echo $settings->set_school_name ?>
                </h1>
                <h4 class="text-center" style="color:white;">( Register Student ID )</h4>
            </div>
            <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 0px 10px 10px;">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input">Please Enter Your Student's ID Number</label>
                        <input style="width:300px;" class="select2-offscreen" name="inputStudentNumber" type="text"
                            id="inputStudentNumber" placeholder="Type Here">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group success">
                        <div class="controls">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                            <button class="btn" onclick="getRegister()" aria-hidden="true">REGISTER</button>

                            <div id="resultSection" class="help-block success"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            function verifyParent(value) {
                $('#verify_icon').removeClass('fa-search')
                $('#verify_icon').addClass('fa-spinner fa-spin');
                var url = "<?php echo base_url() . 'login/getVerified/' ?>" + value + '/' + '<?php echo $settings->school_year ?>';
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    data: 'value=' + value, // serializes the form's elements.
                    success: function (data) {
                        console.log(data.p_id)
                        if (data.status) {
                            $('#inputForms').removeClass('hidden')
                            $('#confirmation').html(data.msg)
                            $('#confirmation').attr('style', "color:#3C6AC4");
                            $('#vResults').val(1)
                            $('#parent_id').val(data.p_id);
                            $('#confirmation').fadeOut(5000)
                            $('#verify_icon').removeClass('fa-spinner fa-spin')
                            $('#verify_icon').addClass('fa-search');
                        } else {
                            // $('#regUname').attr('disabled', 'disabled');
                            $('#verifyP').addClass('form-group error');
                            $('#confirmation').attr('style', "color:red");
                            $('#confirmation').html(data.msg)
                            $('#confirmation').fadeOut(5000)
                            $('#verify_icon').removeClass('fa-spinner fa-spin')
                            $('#verify_icon').addClass('fa-search');
                            setTimeout(function () {
                                $("#verify").focus();
                            }, 0);



                        }

                    }
                });

            }
            function getInside() {

                var data = new Array();

                data[0] = document.getElementById('uname').value;
                data[1] = document.getElementById('pass').value;

                saveAdmission(data);

            }

            function checkPass(pass, pass1) {
                if (pass1.length == pass.length) {
                    if (pass !== pass1) {
                        $('#pass_error_msg').html("Sorry Password did not match")
                        $('#pass_error_msg').attr('style', "color:red");
                        $('#pass_error').addClass('form-group error');
                        $('#pass_error_msg').fadeOut(5000)

                    } else {
                        setTimeout(function () {
                            $('#pass_error_msg').html("Congratulations, Password Matched!")
                            $('#pass_error_msg').fadeOut(5000)
                            $('#pass_error_msg').attr('style', "color:#3C6AC4");
                            $('#pass_error').removeClass('error');
                            $('#verifySubmit').removeClass('hide');
                        }, 0);


                    }
                }

            }

            function getRegister() {

                var studentNumber = document.getElementById('inputStudentNumber').value;
                var verify = document.getElementById('verify').value;
                var regUname = document.getElementById('regUname').value;
                var regPass = document.getElementById('pass1').value;
                var parent_id = $('#parent_id').val()

                var url = "<?php echo base_url() . 'login/getRegister/' ?>" + <?php echo $settings->school_year ?>;
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: 'child_links=' + studentNumber + "&u_id=" + regUname + "&uname=" + regUname + "&pass=" + regPass + '&csrf_test_name=' + $.cookie('csrf_cookie_name') + '&parent_id=' + parent_id + '&mobile=' + $('#verify').val(), // serializes the form's elements.
                    success: function (data) {
                        //console.log(data);
                        alert(data.msg)
                        if (data.status) {
                            document.location = '<?php echo base_url() ?>'
                        } else {
                            document.location = '<?php echo base_url() ?>'
                        }
                    }
                });

            }

            $(document).ready(function () {

                $('#inputStudentNumber').select2({ tags: [] });
                $("#verify").keypress(function (e) {
                    var key = e.keyCode || e.which;
                    if (key == '13') {
                        verifyParent($(this).val())
                    }
                });
                eCampusCheckIn();
            });

            function eCampusCheckIn() {
                var school_id = '<?php echo $settings->school_id ?>';
                var url = 'http://<?php echo $settings->web_address ?>' + '/login/clientCheckIn/';
                $.ajax({
                    type: "POST",
                    crossDomain: true,
                    url: url,
                    data: 'school_id=' + school_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),  // serializes the form's elements.
                    dataType: 'json',
                    error: function (xhr, textStatus, errorThrown) {
                        console.log(textStatus)
                    },
                    success: function (data) {
                        if (data.status) {
                            console.log(data.timestamp);
                        } else {
                            console.log('an error has occured')
                        }


                    }
                });
            }
            function checkUpdates() {
                var url = '<?php echo base_url() ?>' + 'main/checkVersion';
                $.ajax({
                    type: "GET",
                    //crossDomain: true,
                    url: url,
                    data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),  // serializes the form's elements.
                    //dataType: 'json',
                    success: function (data) {
                        console.log(data);


                    }
                });
            }

        </script>
        <!--<script src="<?php // echo base_url(); ?>assets/js/attendanceRequest.js"></script>-->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugins/select2.min.js"></script>
        <!--<script src="<?php // echo base_url(); ?>assets/js/bootstrap.clickover.js"></script> -->
        <!--Cookie Javascript-->
        <script src="<?php echo base_url('assets/js/plugins/jquery.cookie.js'); ?>"></script>
    <?php } ?>
</body>

</html>