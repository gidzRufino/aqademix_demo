<?php
$settings = Modules::run('main/getSet');
?>
<!-- ================= Student Login Modal ================= -->
<div id="studentLogin" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded-lg shadow-lg border-0">

            <!-- Header -->
            <div class="modal-header text-center" style="background: linear-gradient(135deg, #ef6c00, #f57c00); border-radius: 15px 15px 0 0; color:white;">
                <button type="button" class="close text-white" data-dismiss="modal" onclick="window.location='<?php echo base_url() . 'entrance' ?>'"><span>&times;</span></button>
                <div class="text-center">
                    <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" class="img-responsive center-block" style="max-width:100px; margin:10px auto; border-radius:10px;" />
                </div>
                <h3 class="modal-title" style="margin-top:10px; font-weight:600;"><?php echo $settings->set_school_name ?></h3>
                <p style="margin:0; font-size:13px;"><?php echo $settings->set_school_address ?></p>
                <h4 class="text-center" style="margin-top:15px; font-weight:bold;">- STUDENT LOGIN -</h4>
            </div>

            <!-- Body -->
            <div class="modal-body" style="padding:25px;">
                <form id="loginForm" onsubmit="return verifyLogin();">
                    <!-- Student ID -->
                    <div class="form-group">
                        <label for="studentNumber" style="font-weight:600;">Student ID Number</label>
                        <input class="form-control input-lg rounded"
                            name="studentNumber"
                            type="text"
                            id="studentNumber"
                            placeholder="Enter Student ID"
                            required />
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="studentPassword" style="font-weight:600;">Password</label>
                        <div class="input-group">
                            <input class="form-control input-lg rounded"
                                type="password"
                                name="studentPassword"
                                id="studentPassword"
                                placeholder="Enter Password"
                                required />
                            <span class="input-group-btn">
                                <button class="btn btn-default toggle-password" type="button" data-target="#studentPassword"><i class="fa fa-eye"></i></button>
                            </span>
                        </div>
                    </div>

                    <!-- Message -->
                    <div id="loginMsg" class="text-center small" style="display:none; margin-bottom:10px;"></div>

                    <!-- Buttons -->
                    <button type="submit" id="loginBtn" class="btn btn-warning btn-block btn-lg rounded-pill">LOGIN</button>
                    <a id="resetPass" href="#" onclick="resetPassword()" class="text-danger small">Forgot Password?</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ================= Change Password Modal ================= -->
<div id="changePass" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded-lg shadow-lg">
            <div class="modal-header" style="background:linear-gradient(135deg,#2e7d32,#43a047); color:white; border-radius:15px 15px 0 0;">
                <h4 class="modal-title" id="exampleModalLabel">Change Password</h4>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <?php if ($key != ''): ?>
                    <label for='oldPass'>Enter Old Password</label>
                    <div class='input-group'>
                        <input type='password' class="form-control rounded" name='oldPass' id='oldPass' value=''>
                        <span class="input-group-btn">
                            <button class="btn btn-default toggle-password" type="button" data-target="#oldPass"><i class="fa fa-eye"></i></button>
                        </span>
                    </div>
                <?php endif; ?>

                <label for='newPass'>Enter New Password</label>
                <div class='input-group'>
                    <input type='password' class="form-control rounded" name='newPass' id='newPass' value=''>
                    <span class="input-group-btn">
                        <button class="btn btn-default toggle-password" type="button" data-target="#newPass"><i class="fa fa-eye"></i></button>
                    </span>
                </div>

                <label for='confirmPass' class="m-t-10">Confirm Password</label>
                <div class='input-group'>
                    <input type='password' class="form-control rounded" name='confirmPass' id='confirmPass' value=''>
                    <span class="input-group-btn">
                        <button class="btn btn-default toggle-password" type="button" data-target="#confirmPass"><i class="fa fa-eye"></i></button>
                    </span>
                </div><br>
                <em id='errorMsg' class='alert alert-danger' style="display: none"></em>
            </div>
            <div class="modal-footer">
                <button class='btn btn-success rounded-pill' onclick='updatePassword()'>Update Password</button>
                <button class='btn btn-danger rounded-pill' data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ================= Verify Mobile Number Modal ================= -->
<div id="verifyMobileNumbaer" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content rounded-lg shadow-lg">
            <div class="modal-header" style="background:linear-gradient(135deg,#1565c0,#1e88e5); color:white; border-radius:15px 15px 0 0;">
                <h4 class="modal-title">Verify Mobile Number</h4>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <p class="m-b-15">Please confirm if this is the number you registered:</p>
                <h5 id="enPhone" class="m-b-15"></h5>
                <button id="numConfirm" class="btn btn-success btn-block rounded-pill m-b-10">Yes, it is</button>
                <button id="numReject" class="btn btn-danger btn-block rounded-pill">No, it's not</button>

                <div id="changeNum" style="display:none; margin-top:15px; text-align:left;">
                    <label for="newNum">Enter new mobile number</label>
                    <input type="text" id="newNum" class="form-control rounded" placeholder="09xx xxx xxxx">
                    <button id="saveNewNum" class="btn btn-primary btn-block rounded-pill m-t-10">Save Number</button>
                    <button class="btn btn-default btn-block rounded-pill m-t-5" onclick="location.reload()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= Hidden Fields ================= -->
<input type="hidden" id="st_id" value="<?php echo $st_id ?>" />
<input type="hidden" id="dept" value="<?php echo $department ?>" />
<input type="hidden" id="sem" value="<?php echo $semester ?>" />
<input type="hidden" id="isEnrollment" value="<?php echo $isEnrollment ?>" />

<!-- ================= JS Logic (UI + ORIGINAL FUNCTIONS) ================= -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#studentLogin').modal('show');
    });

    // -------- Password Toggle (Bootstrap 3 safe) --------
    $(document).on("click", ".toggle-password", function() {
        var input = $($(this).data("target"));
        var type = input.attr("type") === "password" ? "text" : "password";
        input.attr("type", type);
        $(this).find("i").toggleClass("fa-eye fa-eye-slash");
    });

    // -------- OTP Inputs UX --------
    document.addEventListener("DOMContentLoaded", function() {
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('input', function() {
                    if (this.value.length > 1) {
                        this.value = this.value[0];
                    }
                    if (this.value !== '' && i < inputs.length - 1) {
                        inputs[i + 1].focus();
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
        if (validateBtn) {
            validateBtn.addEventListener('click', function() {
                let otp = '';
                document.querySelectorAll('#otp > input').forEach(input => otp += input.value);
                verifyOTP(otp);
            });
        }
    });

    // -------- Login Submit --------
    function verifyLogin() {
        var id = $('#studentNumber').val();
        var pass = $('#studentPassword').val();
        alert(id + ' ' + pass)

        if (id === "" || pass === "") {
            $('#loginMsg').show().css('color', 'red').text('Please fill in both fields.');
            return false;
        }

        var url = '<?php echo base_url() ?>' + 'college/enrollment/verifyPassword/';
        var sy = '<?php echo $sy ?>';
        var department = $("#dept").val() || 1;
        var semester = $("#sem").val() || 0;
        var isPass = 1;

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                stid: id,
                pass: pass,
                department: department,
                semester: semester,
                sy: sy,
                isPass: isPass,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loginBtn').html('Logging in...').prop('disabled', true);
            },
            success: function(data) {
                $('#loginBtn').html('LOGIN').prop('disabled', false);
                if (data.status) {
                    $('#loginMsg').show().css('color', 'green').text(data.msg);
                    setTimeout(function() {
                        document.location = data.url;
                    }, 1000);
                } else {
                    $('#loginMsg').show().css('color', 'red').text(data.msg);
                }
            },
            error: function() {
                $('#loginBtn').html('LOGIN').prop('disabled', false);
                $('#loginMsg').show().css('color', 'red').text('Login failed. Please try again.');
            }
        });

        return false;
    }

    // ================= ORIGINAL FUNCTIONS (unchanged logic) =================
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
                                        // sendText(data.contact_num, msg, data.url);
                                    });

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
                                    document.location = data.url;
                                }
                            }
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
                    $('#lgnMsg').show().css('color', 'green').text(data.msg);
                    document.location = data.url;
                } else {
                    $('#lgnMsg').show().delay(3000).queue(function(n) {
                        $(this).hide();
                        n();
                    });
                    $('#lgnMsg').show().css('color', 'red').text(data.msg);
                }
            },
            error: function() {
                alert('error');
            }
        });
    }

    // Note: updatePassword() / resetPassword() are referenced by buttons as in your original snippet.
    // Keep your existing implementations for those if defined elsewhere in your app.
</script>

<!-- ================= CSS Enhancements ================= -->
<style type="text/css">
    .rounded {
        border-radius: 10px !important;
    }

    .rounded-pill {
        border-radius: 50px !important;
    }

    .modal-content {
        border-radius: 15px;
    }

    .otp-box {
        width: 45px;
        height: 45px;
        margin: 5px;
        display: inline-block;
        font-size: 20px;
        border-radius: 8px;
    }

    .otp-box:focus {
        border-color: #ef6c00;
        box-shadow: 0 0 5px rgba(239, 108, 0, 0.6);
    }

    .toggle-password {
        border-radius: 0 10px 10px 0;
    }

    .btn:hover {
        opacity: 0.9;
    }
</style>