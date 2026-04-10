<?php
$settings = Modules::run('main/getSet');
?>
<div id="enrollmentLogin" class="modal fade col-lg-3 col-xs-12" style="margin:10px auto;" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='<?php echo base_url() . 'entrance' ?>'">
            <span aria-hidden="true">&times;</span>
        </button>
        <div style="width:165px;margin:0 auto;">
            <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" style="width:165px; background: white; margin:0 auto;" />
        </div>
        <h1 class="text-center" style="font-size:30px; color:black;"><?php echo $settings->set_school_name ?></h1>
        <h6 class="text-center" style="font-size:15px; color:black;"><?php echo $settings->set_school_address ?></h6>
        <?php
        $bosy = strtotime(Date("Y-m-d", strtotime($settings->bosy)));
        $boe = strtotime(Date("Y-m-d", strtotime($settings->enrollment_start))); //-- start of enrollment --//
        $eoe = strtotime(Date("Y-m-d", strtotime($settings->enrollment_end))); //-- end of enrollment --//
        $curdate = strtotime(Date("Y-m-d"));
        $elapsed = $eoe - $curdate;
        $currentYear = date('Y');
        # if value of elapsed time from bosy is not negative show ONLINE ENROLLMENT MODE
        # Other than that show the amazing buttons
        ?>
        <h4 class="text-center text-info"><i class="fa fa-globe fa-4x"></i></h4>
        <h4 class="text-center text-info">- ONLINE ENROLLMENT SYSTEM -</h4>
    </div>
    <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 0px 10px 10px;">
        <?php if ($st_id == NULL): ?>
            <?php
            if ($curdate >= $boe && $curdate <= $eoe):
            ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="input" style="text-align: center">Please Enter Your Student ID Number</label>
                        <input class="form-control" onkeypress="if (event.keyCode == 13) {
                                    requestEntry(this.value)
                                }" name="stidNum" type="text" id="stidNum" placeholder="Type Here" />
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group success">
                        <div class="controls">
                            <button id="requestBtn" onclick="requestEntry()" class="btn btn-info btn-block" aria-hidden="true">REQUEST ENTRY</button>
                            <!--<button class="btn btn-danger btn-block" data-dismiss="modal" aria-hidden="true">Cancel</button>-->
                            <div id="resultSection" class="help-block success"></div>
                            <p class="text-center">New Student ? <a href="#" onclick="$('#selectNewOption').modal('show')">[ CLICK HERE ]</a></p>
                        </div>

                    </div>
                </div>
            <?php
            else:
                if ($curdate < $boe):
                    echo '<div class="modal-body"><p>Start of Enrollment will be on ' . Date('F j, Y', strtotime($settings->enrollment_start)) . '</p><p>End of Enrollment Date: ' .  Date('F j, Y', strtotime($settings->enrollment_start)) . '</p></div>';
                    $aa = 1;
                endif;
                if ($curdate > $eoe):
                    echo '<div class="modal-body"><b styl="text-align: center">Sorry, Enrollment period has ended</b></div>';
                    $aa = 1;
                endif;
            endif; ?>
        <?php
        else: ?>
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
                <p class="text-center">Not able to receive your One-Time Pin?<br /> <a class="text-danger" href="<?php // echo base_url('entrance'); 
                                                                                                                    ?>">Click here to Request Again</a></p>
                <div class="alert" id="alertMsg">

                </div> -->
                <input type="hidden" id="department" value="<?php echo $department ?>" />
                <input type="hidden" id="infoS" value="<?php echo $semester ?>" />
                <input type="hidden" id="otpNum" value="<?php echo $otp ?>" />
            </div>


        <?php endif; ?>
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
<div id="selectNewOption" class="modal fade col-lg-2 col-xs-10" style="margin:30px auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="col-lg-12 modal-header" style="background: #FFF; box-shadow: 3px 3px 5px 5px #ccc; border-radius: 5px; border: 1px solid #ccc;">
        <p class="text-center">Please select an option to enroll</p>
        <?php
        switch ($settings->level_catered):
            case 0:
        ?>
                <button id="gs" onclick="document.location = '<?php echo base_url('admission/basicEd/2') ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>
                <button id="jhs" onclick="document.location = '<?php echo base_url('admission/basicEd/3') ?>'" class="btn btn-block btn-warning">JUNIOR HIGH SCHOOL</button>
                <button id="shs" onclick="document.location = '<?php echo base_url('admission/basicEd/4') ?>'" class="btn btn-block btn-success">SENIOR HIGH SCHOOL</button>
                <button id="college" onclick="document.location = '<?php echo base_url('admission/college') ?>'" class="btn btn-block btn-danger">COLLEGE LEVEL</button>
            <?php
                break;
            case 1:
            case 2:
            ?>
                <button id="gs" onclick="document.location = '<?php echo base_url('admission/basicEd/2') ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>

            <?php
                break;
            case 3:
            ?>
                <button id="gs" onclick="document.location = '<?php echo base_url('admission/basicEd/2') ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>
                <button id="jhs" onclick="document.location = '<?php echo base_url('admission/basicEd/3') ?>'" class="btn btn-block btn-warning">JUNIOR HIGH SCHOOL</button>

            <?php
                break;
            case 4:
            ?>
                <button id="gs" onclick="document.location = '<?php echo base_url('admission/basicEd/2') ?>'" class="btn btn-block btn-primary">PRE-SCHOOL & <br /> GRADE SCHOOL</button>
                <button id="jhs" onclick="document.location = '<?php echo base_url('admission/basicEd/3') ?>'" class="btn btn-block btn-warning">JUNIOR HIGH SCHOOL</button>
                <button id="shs" onclick="document.location = '<?php echo base_url('admission/basicEd/4') ?>'" class="btn btn-block btn-success">SENIOR HIGH SCHOOL</button>

        <?php
                break;
        endswitch;
        ?>
    </div>
</div>

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
                                    alert(msg);

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