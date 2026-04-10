<?php $settings = Modules::run('main/getSet'); ?>

<!-- ENROLLMENT LOGIN MODAL -->
<div id="enrollmentLogin"
    class="modal fade"
    data-backdrop="static"
    tabindex="-1"
    role="dialog"
    aria-labelledby="enrollmentLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg rounded-lg overflow-hidden">

            <!-- HEADER -->
            <div class="modal-header flex-column align-items-center bg-light pb-0 border-0">
                <button type="button" class="close align-self-end mr-2 mt-2" data-dismiss="modal"
                    aria-label="Close"
                    onclick="window.location='<?php echo base_url('entrance') ?>'">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="text-center">
                    <img src="<?php echo base_url('images/forms/' . $settings->set_logo); ?>"
                        alt="School Logo"
                        class="img-fluid mb-3 rounded shadow-sm"
                        style="max-width: 160px;">
                    <h4 class="mb-1 font-weight-bold text-dark"><?php echo $settings->set_school_name; ?></h4>
                    <small class="text-muted d-block mb-3"><?php echo $settings->set_school_address; ?></small>
                    <h5 class="text-primary"><i class="fa fa-globe mr-1"></i> ONLINE ENROLLMENT SYSTEM</h5>
                </div>
            </div>

            <!-- BODY -->
            <div class="modal-body bg-white p-4">
                <?php
                $bosy = strtotime(date("Y-m-d", strtotime($settings->bosy)));
                $boe = strtotime(date("Y-m-d", strtotime($settings->enrollment_start)));
                $eoe = strtotime(date("Y-m-d", strtotime($settings->enrollment_end)));
                $curdate = strtotime(date("Y-m-d"));
                $currentYear = date('Y');
                ?>

                <?php if ($st_id == NULL): ?>
                    <?php if ($curdate >= $boe && $curdate <= $eoe): ?>
                        <div class="text-center">
                            <label class="font-weight-semibold">Enter Your Student ID Number</label>
                            <input type="text" id="stidNum"
                                class="form-control form-control-lg text-center mb-3"
                                placeholder="Enter your ID number"
                                onkeypress="if(event.keyCode==13){requestEntry(this.value);}">
                            <button id="requestBtn"
                                class="btn btn-primary btn-block btn-lg font-weight-bold shadow-sm"
                                onclick="requestEntry()">REQUEST ENTRY</button>
                            <div id="resultSection" class="help-block mt-3 text-success"></div>
                            <p class="mt-3 mb-0 text-muted">
                                New Student?
                                <a href="#" onclick="$('#selectNewOption').modal('show')" class="font-weight-bold">Click here</a>
                            </p>
                        </div>

                    <?php elseif ($curdate < $boe): ?>
                        <div class="alert alert-info text-center">
                            Enrollment opens on <strong><?php echo date('F j, Y', strtotime($settings->enrollment_start)); ?></strong><br>
                            Ends on <strong><?php echo date('F j, Y', strtotime($settings->enrollment_end)); ?></strong>.
                        </div>

                    <?php else: ?>
                        <div class="alert alert-danger text-center font-weight-bold">
                            Sorry, enrollment period has ended.
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- OTP Section -->
                    <div class="card border-0 shadow-sm text-center p-4">
                        <h6 class="text-secondary mb-2">
                            Enter the One-Time Password to verify your account
                        </h6>
                        <p class="mb-2">
                            <small>A code has been sent to:</small>
                            <strong><?php echo base64_decode($encrypt_num); ?></strong>
                        </p>

                        <div id="otp" class="d-flex justify-content-center align-items-center mb-3">
                            <?php for ($i = 0; $i < 6; $i++): ?>
                                <input
                                    type="text"
                                    maxlength="1"
                                    class="form-control text-center mx-2 rounded"
                                    style="width: 50px; height: 50px; font-size: 1.2rem; line-height: 1;"
                                    value="<?php echo substr($otp, $i, 1); ?>">
                            <?php endfor; ?>
                        </div>

                        <div><br>
                            <span id="valMsg" class="text-success d-block mb-2"></span>
                            <button id="validateBtn" class="btn btn-success btn-lg px-4 validate shadow-sm">
                                Validate
                            </button>
                        </div>
                    </div>
                    <input type="hidden" id="department" value="<?php echo $department; ?>" />
                    <input type="hidden" id="infoS" value="<?php echo $semester; ?>" />
                    <input type="hidden" id="otpNum" value="<?php echo $otp; ?>" />
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- VERIFY NUMBER MODAL -->
<div id="verifyMobileNumbaer" class="modal fade" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-sm border-0 rounded-lg">
            <div class="modal-body text-center">
                <h5 class="mb-3">Please confirm if this is your registered contact number:</h5>
                <h4 id="enPhone" class="text-primary mb-3"></h4>
                <button id="numConfirm" class="btn btn-success btn-block mb-2">Yes, it is</button>
                <button id="numReject" class="btn btn-outline-danger btn-block">No, it's not</button>

                <div id="changeNum" class="mt-4" hidden>
                    <p>Change your number? Click
                        <a href="#" onclick="$('#cnInfo').show();$('#saveNewNum').show();$('#confirmNum').hide();">here</a>.
                    </p>
                    <div id="cnInfo" class="mb-3" hidden>
                        <input type="text" id="newNum" class="form-control text-center" placeholder="Enter new number">
                    </div>
                    <button id="saveNewNum" class="btn btn-primary btn-block d-none">Update</button>
                    <button class="btn btn-link text-muted mt-2" onclick="location.reload()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SELECT NEW OPTION MODAL -->
<!-- <div id="selectNewOption" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-sm border-0 rounded-lg text-center p-4">
            <h5 class="mb-4">Please select an option to enroll</h5>
            <?php switch ($settings->level_catered):
                case 0: ?>
                    <button class="btn btn-primary btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/2'); ?>'">PRE-SCHOOL & GRADE SCHOOL</button>
                    <button class="btn btn-warning btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/3'); ?>'">JUNIOR HIGH SCHOOL</button>
                    <button class="btn btn-success btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/4'); ?>'">SENIOR HIGH SCHOOL</button>
                    <button class="btn btn-danger btn-block" onclick="location='<?php echo base_url('admission/college'); ?>'">COLLEGE LEVEL</button>
                <?php break;
                case 1:
                case 2: ?>
                    <button class="btn btn-primary btn-block" onclick="location='<?php echo base_url('admission/basicEd/2'); ?>'">PRE-SCHOOL & GRADE SCHOOL</button>
                <?php break;
                case 3: ?>
                    <button class="btn btn-primary btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/2'); ?>'">PRE-SCHOOL & GRADE SCHOOL</button>
                    <button class="btn btn-warning btn-block" onclick="location='<?php echo base_url('admission/basicEd/3'); ?>'">JUNIOR HIGH SCHOOL</button>
                <?php break;
                case 4: ?>
                    <button class="btn btn-primary btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/2'); ?>'">PRE-SCHOOL & GRADE SCHOOL</button>
                    <button class="btn btn-warning btn-block mb-2" onclick="location='<?php echo base_url('admission/basicEd/3'); ?>'">JUNIOR HIGH SCHOOL</button>
                    <button class="btn btn-success btn-block" onclick="location='<?php echo base_url('admission/basicEd/4'); ?>'">SENIOR HIGH SCHOOL</button>
            <?php endswitch; ?>
        </div>
    </div>
</div> -->

<!-- STYLES -->
<style>
    #enrollmentLogin .modal-content {
        animation: fadeInDown 0.4s ease-in-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn {
        border-radius: 25px;
    }

    .btn-block {
        padding: 0.7rem 1rem;
        font-weight: 600;
        letter-spacing: .5px;
    }

    #otp input {
        border: 2px solid #ddd;
        transition: border-color .2s;
    }

    #otp input:focus {
        border-color: #007bff;
        outline: none;
    }

    #otp .form-control {
        display: inline-block;
    }
</style>

<input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />
<input type="hidden" id="st_id" value="<?php echo $st_id ?>" />
<input type="hidden" id="dept" value="<?php echo $department ?>" />
<input type="hidden" id="sem" value="<?php echo $semester ?>" />
<input type="hidden" id="isEnrollment" value="<?php echo $isEnrollment ?>" />
<script type="text/javascript">
    $(document).ready(function() {
        $('#enrollmentLogin').modal('show');
    });

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
        var isEnrollment = 1;
        var id = $('#stidNum').val();
        if (id != "") {
            var url = '<?php echo base_url() ?>' + '/college/enrollment/requestEntry/'; // the script where you handle the form input.

            var semester = 0;
            //alert(semester);
            $.ajax({
                type: "POST",
                url: url,
                data: 'id=' + id + '&semester=' + semester + '&isEnrollment=' + isEnrollment + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
                dataType: 'json',
                beforeSend: function() {
                    $('#requestBtn').html('System is requesting entry...Thank you for waiting patiently')
                },
                success: function(data) {
                    $('#requestBtn').html('REQUEST ENTRY');
                    if (data.status) {
                        // alert(data.contact_num);
                        if (data.contact_num == "") {
                            alert('Sorry there is no contact information provided by you, Please contact the school registrar for more info');
                        } else {
                            if (data.option == 0) {
                                $('#verifyMobileNumbaer').modal('show');
                                $('#enPhone').html(data.encrypt_num);
                                var number = data.contact_num;
                                var masked = number.substring(number.length - 4);

                                $('#numConfirm').click(function() {
                                    // $('#parent_id').val(data.pid);
                                    var msg = 'Your One-Time Pin is ' + data.otp + '.';
                                    // alert(msg);

                                    $('#otpInput').removeClass('hidden');
                                    // $('#maskedNumber').text('*******' + masked);
                                    document.location = data.url;

                                    var otp = $('#otpNum').val();
                                    $('#first').val(otp.slice(0, 1));
                                    $('#second').val(otp.slice(1, 2));
                                    $('#third').val(otp.slice(2, 3));
                                    $('#fourth').val(otp.slice(3, 4));
                                    $('#fifth').val(otp.slice(4, 5));
                                    $('#sixth').val(otp.slice(5, 6));
                                    $('.ftr').addClass('hidden');
                                    $('#cnInput').addClass('hidden');

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
        } else {
            alert('Sorry, You need to input your ID Number');
        }
    }

    function verifyOTP(otp) {
        var isEnrollment = 1;
        // var otp = $('#otpVerify').val();
        var semester = $('#infoS').val();

        var url = '<?php echo base_url() ?>' + 'college/enrollment/verifyOTP/'; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: 'otp=' + otp + '&id=' + $('#st_id').val() + '&department=' + $('#department').val() + '&semester=' + semester + '&isEnrollment=' + isEnrollment + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            dataType: 'json',
            beforeSend: function() {
                $('#validateBtn').hide();
                $('#valMsg').html('<p style="color: green">System is reqeusting entry...Thank you for waiting patiently</p>');
            },
            success: function(data) {
                if (data.status) {
                    document.location = data.url;
                } else {
                    alert('Sorry You have entered a wrong One Time Password');
                    // document.location = '<?php // echo base_url() 
                                            ?>' + 'enrollment';
                }

            }
        });

        return false;

    }
</script>

<style>
    img {
        width: 100px;
        height: 100%;
    }

    ul.timeline {
        list-style-type: none;
        position: relative;
    }

    ul.timeline:before {
        content: ' ';
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 29px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }

    ul.timeline>li {
        margin: 20px 0;
        padding-left: 60px;
    }

    ul.timeline>li:before {
        content: ' ';
        background: <?php echo 'red' ?>;
        display: inline-block;
        position: absolute;
        border-radius: 100%;
        border: 3px solid #22c0e8;
        left: 20px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }

    .image-text-container {
        display: flex;
        align-items: center;
    }

    .image-text-container img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

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