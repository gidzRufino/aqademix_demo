<?php
$settings = Modules::run('main/getSet');
?>
<div id="studentLogin" class="modal fade col-lg-3 col-xs-12" style="margin:10px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='<?php echo base_url() . 'entrance' ?>'">
            <span aria-hidden="true">&times;</span>
        </button>
        <div style="width:165px;margin:0 auto;">
            <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" style="width:165px; background: white; margin:0 auto;" />
        </div>
        <h1 class="text-center" style="font-size:30px; color:black;"><?php echo $settings->set_school_name ?></h1>
        <h6 class="text-center" style="font-size:15px; color:black;"><?php echo $settings->set_school_address ?></h6>
        <h4 class="text-center text-success"><i class="fa fa-graduation-cap fa-4x"></i></h4>
        <h4 class="text-center text-success">- STUDENT'S LOGIN -</h4>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 25px">
        <?php if ($st_id == NULL): ?>
            <div class="form-group">
                <label for="input" style="text-align: center">Please Enter Student ID Number</label>
                <input class="form-control" onkeypress="if (event.keyCode == 13) {
                                        requestEntry(this.value)
                                    }" name="studentNumber" type="text" id="studentNumber" placeholder="Type Here" />
            </div>
            <div class="form-group success">
                <div class="controls">
                    <button id="requestBtn" onclick="requestEntry()" class="btn btn-info btn-block" aria-hidden="true">REQUEST ENTRY</button>
                </div>
            </div>
            <?php
        else:
            if (base64_decode($passKey) != NULL):
                if ($changeKey != NULL):
            ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class='control-label' for='NewPassword'>Enter New Password</label>
                            <input type='password' class="form-control" name='newPass' id='newPass' value=''>
                            <label class='control-label' for='ConfirmPassword'>Confirm Password</label>
                            <input type='password' class="form-control" name='confirmPass' id='confirmPass' value=''><br>
                        </div>
                        <em id='errorMsg' class='alert alert-danger' style="display: none"></em>
                    </div>
                    <div class="modal-footer">
                        <button class='btn btn-sm btn-success pull-right' onclick='updatePassword()'>Update Password</button>
                        <button class='btn btn-sm btn-danger pull-right' onclick='document.location = "<?php echo base_url() . 'college/enrollment/entrance' ?>"'>Cancel</button><br>
                    </div>
                <?php else: ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="input" style="text-align: center">Enter Password then press Enter Key <?php echo $changeKey ?></label>
                            <input class="form-control" onkeypress="if (event.keyCode == 13) {
                                        verifyPassword(this.value)
                                    }" name="otpVerify" type="password" id="otpVerify" placeholder="Type Here">
                        </div>
                    </div>
                    <a id="resetPass" href="#" onclick="resetPassword()">Forgot Password? click to reset password!</a><br><br>
                    <span id="lgnMsg" style="display: none;"></span>
                <?php endif; ?>

            <?php else: ?>
                <div class="modal-body">
                    <div id="otpInput">
                        <div class="card p-2 text-center">
                            <h6>Please enter the one time password <br> to verify your account</h6>
                            <div style="font-weight: bold;"> <span>A code has been sent to</span> <small id="maskedNumber"><?php echo base64_decode($encrypt_num) ?></small> </div>
                            <div id="otp" class="inputs">
                                <input class="text-center form-control rounded" type="text" value="<?php echo substr($otp, 0, 1) ?>" id="first" maxlength="1" />
                                <input class="text-center form-control rounded" type="text" value="<?php echo substr($otp, 1, 1) ?>" id="second" maxlength="1" />
                                <input class="m-2 text-center form-control rounded" type="text" value="<?php echo substr($otp, 2, 1) ?>" id="third" maxlength="1" />
                                <input class="m-2 text-center form-control rounded" type="text" value="<?php echo substr($otp, 3, 1) ?>" id="fourth" maxlength="1" />
                                <input class="m-2 text-center form-control rounded" type="text" value="<?php echo substr($otp, 4, 1) ?>" id="fifth" maxlength="1" />
                                <input class="m-2 text-center form-control rounded" type="text" value="<?php echo substr($otp, 5, 1) ?>" id="sixth" maxlength="1" />
                            </div>
                            <div class="mt-4"><br />
                                <span id="valMsg"></span>
                                <button id="validateBtn" class="btn btn-danger px-4 validate">Validate</button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="input" style="text-align: center">Please Enter the One Time Password</label>
                        <input class="form-control" onkeypress="if (event.keyCode == 13) {
                                    verifyOTP(this.value)
                                }" name="otpVerify" type="password" id="otpVerify" placeholder="Type Here">
                    </div>
                    <p class="text-center">Not able to receive your One-Time Pin?<br /> <a class="text-danger" href="<?php echo base_url('entrance'); ?>">Click here to Request Again</a></p>
                    <div class="alert" id="alertMsg">

                    </div> -->
                    <input type="hidden" id="department" value="<?php echo $department ?>" />
                    <input type="hidden" id="infoS" value="<?php echo $semester ?>" />
                    <input type="hidden" id="otpNum" value="<?php echo $otp ?>" />
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>


<div class="modal fade" id="changePass" tabindex="-1"
    role="dialog" aria-labelledby=" exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <?php if ($key != ''): ?>
                    <label class='control-label' for='OldPassword'>Enter Old Password</label>
                    <div class='controls'>
                        <input type='password' name='oldPass' id='oldPass' value=''>
                    </div>
                <?php endif; ?>
                <label class='control-label' for='NewPassword'>Enter New Password</label>
                <div class='controls'>
                    <input type='password' name='newPass' id='newPass' value=''>
                </div>
                <label class='control-label' for='ConfirmPassword'>Confirm Password</label>
                <div class='controls'>
                    <input type='password' name='confirmPass' id='confirmPass' value=''>
                </div><br>
                <em id='errorMsg' class='alert alert-danger' style="display: none"></em>
            </div>
            <div class="modal-footer">
                <button class='btn btn-sm btn-success pull-right' onclick='updatePassword()'>Update Password</button>
                <button class='btn btn-sm btn-danger pull-right' onclick='' data-dismiss="modal">Cancel</button><br>
            </div>
        </div>
    </div>
</div>
<div id="verifyMobileNumbaer" class="modal fade col-lg-2 col-xs-10" style="margin:30px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="col-lg-12 modal-header" style="background: #FFF; box-shadow: 3px 3px 5px 5px #ccc; border-radius: 5px; border: 1px solid #ccc;">
        <div id="confirmNum">
            <p class="text-center">Please confirm if this is the number you register in the system</p>
            <h5 class="text-center" id="enPhone"></h5>

            <button id="numConfirm" class="btn btn-block btn-success">Yes, It is</button>
            <button id="numReject" class="btn btn-block btn-danger">No, It's not</button><br>
        </div>
        <div id="changeNum" hidden="">
            Change contact number registered on the system? Click <a class="pointer" onclick="$('#cnInfo').show(), $('#confirmNum').hide(), $('#saveNewNum').show()">here</a><br><br>
            <div id="cnInfo" hidden="">
                <input type="text" name="newNum" id="newNum" placeholder="Enter New Number"><br>
            </div><br><br>
            <button class="btn btn-success" style="display: none" id="saveNewNum">Update</button>
            <button class="btn btn-danger pull-right" onclick="location.reload()">Cancel</button>
        </div>
    </div>
</div>

<input type="hidden" id="st_id" value="<?php echo $st_id ?>" />
<input type="hidden" id="dept" value="<?php echo $department ?>" />
<input type="hidden" id="sem" value="<?php echo $semester ?>" />
<input type="hidden" id="isEnrollment" value="<?php echo $isEnrollment ?>" />
<script type="text/javascript">
    $(document).ready(function() {
        $('#studentLogin').modal('show');
    })

    //--------------------------------- otp -----------------------------------------------------//
    document.addEventListener("DOMContentLoaded", function() {
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function() {
                    if (this.value.length > 1) {
                        this.value = this.value[0]; //    
                    }
                    if (this.value !== '' && i < inputs.length - 1) {
                        inputs[i + 1].focus(); //   
                    }
                });

                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace') {
                        this.value = '';
                        if (i > 0) {
                            inputs[i - 1].focus();
                        }
                    }
                });
            }
        }

        OTPInput();

        const validateBtn = document.getElementById('validateBtn');
        validateBtn.addEventListener('click', function() {
            let otp = '';
            document.querySelectorAll('#otp > input').forEach(input => otp += input.value);

            verifyOTP(otp);
        });
    });

    //------------------------------- end otp ---------------------------------------------------//

    function requestEntry() {
        var isEnrollment = 0;
        var id = $('#studentNumber').val();

        if (id != "") {
            var url = '<?php echo base_url() ?>' + 'college/enrollment/requestEntry/'; // the script where you handle the form input.

            if ($("#departmentSelect").val() == "none") {
                proceed = 0;
                alert('Please Select a Department')
            } else {
                var department = $("#departmentSelect").val();
                var semester = $('#semesterSelect').val();
                if (department != 5 && semester != 3) {
                    semester = 0;
                }
                //alert(semester);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: 'id=' + id + '&isEnrollment=' + isEnrollment + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                    dataType: 'json',
                    beforeSend: function() {
                        $('#requestBtn').html('System is requesting entry...Thank you for waiting patiently')
                    },
                    success: function(data) {
                        $('#requestBtn').html('REQUEST ENTRY');
                        if (data.status) {
                            if (data.contact_num == "") {
                                alert('Sorry there is no contact information provided by you, Please contact the school registrar for more info');
                            } else {
                                if (data.option == 0) {
                                    $('#verifyMobileNumbaer').modal('show');
                                    $('#enPhone').html(data.encrypt_num);


                                    $('#numConfirm').click(function() {

                                        var msg = 'Your One-Time Pin is ' + data.otp + '.';
                                        alert(msg);
                                        document.location = data.url;
                                        //                                            sendText(data.contact_num, msg, data.url);
                                    });

                                    //                                       $('#numReject').click(function () {
                                    ////                                            alert('Please Contact the Registrar or the school\'s Facebook page to change your contact information.');
                                    ////                                            location.reload();
                                    //                                        });
                                    $('#numReject').click(function() {
                                        $('#numReject').addClass('disabled');
                                        $('#numConfirm').addClass('disabled');
                                        $('#changeNum').show();
                                    });

                                    $('#saveNewNum').click(function() {
                                        var newNum = $('#newNum').val();
                                        if (newNum == '') {
                                            alert('Please fill up the field');
                                        } else {
                                            var urlNew = base + 'college/enrollment/changeContacNumber';
                                            $.ajax({
                                                type: 'POST',
                                                url: urlNew,
                                                data: 'newNum=' + newNum + '&user_id=' + data.user_id + '&dept=' + data.department + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                                                success: function(data) {
                                                    alert('New Number Successfuly Save');
                                                    location.reload();
                                                },
                                                error: function(data) {
                                                    alert('error');
                                                }
                                            });
                                        }
                                    });
                                } else {
                                    //                                        alert(data.option);
                                    document.location = data.url;
                                }


                            }
                            //alert(data.otp);
                            // document.location = data.url;
                        } else {
                            alert('Sorry Your Id is not registered ');
                            location.reload();
                        }
                    }
                });

                return false;
            }
        } else {
            alert('Sorry, You need to input your ID Number');
        }
    }

    function verifyOTP(otp) {
        var isEnrollment = 0;
        // var otp = $('#otpVerify').val();
        var semester = 0;
        var department = 1;
        var isPass = 0;
        var sy = '<?php echo $sy ?>';
        var url = '<?php echo base_url() ?>' + 'college/enrollment/verifyPassword/'; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: 'pass=' + otp + '&stid=' + $('#st_id').val() + '&department=' + department + '&semester=' + semester + '&isEnrollment=' + isEnrollment + '&isPass=' + isPass + '&sy=' + sy + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            dataType: 'json',
            beforeSend: function() {
                $('#requestBtn').html('System is reqeusting entry...Thank you for waiting patiently');
            },
            success: function(data) {
                if (data.status) {
                    document.location = data.url;
                } else {
                    alert('Sorry You have entered a wrong One Time Password');
                    document.location = '<?php echo base_url() ?>' + 'studentsEntrance';
                }

            }
        });

        return false;

    }

    function verifyPassword(pass) {
        var stid = $('#st_id').val();
        var department = $("#dept").val();
        var semester = $('#sem').val();
        var sy = '<?php echo $sy ?>';
        var isPass = 1;
        $.ajax({
            type: 'POST',
            data: 'stid=' + stid + '&pass=' + pass + '&department=' + department + '&semester=' + semester + '&sy=' + sy + '&isPass=' + isPass + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: '<?php echo base_url() ?>' + 'college/enrollment/verifyPassword/',
            dataType: 'json',
            success: function(data) {
                if (data.status) {
                    $('#lgnMsg').show().delay(3000).queue(function(n) {
                        $(this).hide();
                        n();
                    });
                    $('#lgnMsg').show();
                    $('#lgnMsg').css('color', 'green');
                    $('#lgnMsg').text(data.msg);
                    document.location = data.url;
                } else {
                    $('#lgnMsg').show().delay(3000).queue(function(n) {
                        $(this).hide();
                        n();
                    });
                    $('#lgnMsg').show();
                    $('#lgnMsg').css('color', 'red');
                    $('#lgnMsg').text(data.msg);
                }
            },
            error: function() {
                alert('error');
            }
        });
    }
</script>

<style type="text/css">
    /* ------- OTP ------------------------- */

    .height-100 {
        height: 100vh
    }

    .card {
        width: 100%;
        border: none;
        height: 205px;
        box-shadow: 0px 5px 20px 0px #d2dae3;
        padding-top: 10px;
        z-index: 1;
        /* display: flex; */
        justify-content: center;
        align-items: center
    }

    .card h6 {
        color: red;
        font-size: 20px;
    }

    .inputs input {
        width: 40px;
        height: 40px;
        display: inline-block;
    }

    /* input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0
    } */

    .card-2 {
        background-color: #fff;
        padding: 10px;
        width: 350px;
        height: 100px;
        bottom: -50px;
        left: 20px;
        position: absolute;
        border-radius: 5px
    }

    .card-2 .content {
        margin-top: 50px
    }

    .card-2 .content a {
        color: red
    }

    .form-control:focus {
        box-shadow: none;
        border: 2px solid red
    }

    .validate {
        border-radius: 20px;
        height: 40px;
        background-color: red;
        border: 1px solid red;
        width: 140px
    }
</style>