<div class="row">
    <div class="col-md-2">
        <?php if ($this->session->userdata('position_id') != 4): ?>
                                                                                        <!--<a href="<?php echo base_url() . 'main/crop/' . $this->uri->segment(3) ?>">Crop Image</a>-->
            <?php
        endif;
        $user_id = $students->u_id;
        /*
          if($students->u_id==""):
          $user_id = $students->us_id;
          else:
          $user_id = $students->u_id;
          endif; */
        ?>
        <div id="imgCrop" data-id="photo">
            <img class="img-circle img-responsive" style="width:150px; border:5px solid #fff" src="<?php
            if ($students->avatar != ""):echo base_url() . 'uploads/' . $students->avatar;
            else:echo base_url() . 'uploads/noImage.png';
            endif;
            ?>" />
        </div>
    </div>
    <input type="hidden" id="stdUserID" value="<?php echo $user_id ?>" />
    <div class="col-md-10">
        <h2 style="margin:3px 0;">
            <span id="name" style="color:#BB0000;"><?php echo strtoupper($students->firstname . " " . $students->lastname) ?></span>
        </h2>
        <?php $strand = Modules::run('subjectmanagement/getStrandCode', $students->strnd_id); ?>
        <h3 style="color:black; margin:3px 0;"><?php echo $students->level; ?> - <span id="a_section"><?php echo $students->section; ?></span><span id="a_strand"><?php echo ($strand != '' ? ' - ' . $strand->short_code : '') ?></span></h3>

        <input type="hidden" id="admission_user_id" value="<?php echo $students->u_id ?>" />
        <h3 style="color:black; margin:3px 0;">
            <small>
                <a title="double click to edit" id="a_user_id"  style="color:#BB0000;">
                    <?php echo ($students->lrn == "" ? $students->uid : $students->lrn) ?>
                </a>
            </small>

        </h3>
        <small>
            <span>
                Username: <?php echo $students->uid ?>
            </span><br>
            <span>
                Password: <em id="dotdot">* * * * * *</em>&nbsp;&nbsp;
                <i class="fas fa-edit pointer" data-toggle="modal" data-target="#changePass"></i>
<!--                <i class="fas fa-edit popover pointer" id="ePass"
                   data-content="
                   <?php
//                   $data['key'] = $students->secret_key;
//                   $this->load->view('changePass', $data);
                   ?>
                   "></i>-->
            </span>
        </small>
    </div>

</div>
<div class="row">
    <div class="tab-content col-lg-12">
        <div style="padding-top: 15px;" class="tab-pane active" id="PersonalInfo">
            <dl class="dl-horizontal">
                <dt>
                    Address:
                </dt>
                <dd >
                    <span id="address_span"><?php echo strtoupper($students->street . ', ' . $students->barangay . ' ' . $students->mun_city . ', ' . $students->province . ', ' . $students->zip_code); ?></span>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Contact No:
                </dt>
                <dd>
                    <span title="double click to edit" id="a_mobile" ondblclick="$('#a_mobile').hide(), $('#mobile').show(), $('#mobile').focus()" ><?php
                        if ($students->cd_mobile != ""):echo $students->cd_mobile;
                        else: echo "[empty]";
                        endif;
                        ?></span>
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Gender: 
                </dt>
                <dd style="color:black; ">
                    <span id="st_sex">
                        <?php echo $students->sex; ?> 
                    </span>           
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>
                    Birthdate: 
                </dt>
                <dd>
                    <span id="a_bdate" >
                        <?php echo $students->temp_bdate; ?>
                    </span> 
                </dd>
            </dl>

            <dl class="dl-horizontal">
                <dt>
                    Religion: 
                </dt>
                <dd>
                    <span id="a_religion" >
                        <?php echo $students->religion; ?>
                    </span>              
                </dd>
            </dl>

            <dl class="dl-horizontal">
                <dt>
                    Mother Tongue: 
                </dt>
                <dd>
                    <span id="a_motherTongue" >
                        <?php echo $students->mother_tongue; ?>
                    </span>          
                </dd>
            </dl>

            <dl class="dl-horizontal">
                <dt>
                    Ethnic Group: 
                </dt>
                <dd>
                    <span id="a_ethnicGroup" >
                        <?php echo $students->ethnic_group; ?>
                    </span>        
                </dd>
            </dl>

            <hr style="margin:3px 0;" />
            <h5 >Family Information</h5>
            <hr style="margin:3px 0 15px;" />
            <div class="col-lg-6">
                <dl class="dl-horizontal">
                    <dt>
                        Father's Name :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_fname" ><?php
                            if ($students->f_lastname != ""):echo strtoupper($students->f_firstname . ' ' . $students->f_lastname);
                            else: echo "[empty]";
                            endif;
                            ?> </span>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Education :
                    </dt>
                    <dd>
                        <span id="F_educAttainValue" ><?php echo strtoupper($f->attainment); ?></span>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Occupation :
                    </dt>
                    <dd>
                        <?php $f_occ = Modules::run('registrar/getOccupation', $students->f_occ); ?>
                        <span id="a_f_occupation"><?php echo strtoupper($f_occ->occupation); ?></span>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Office :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_f_office_name" ><?php
                            if ($students->f_office_name != ""):echo strtoupper($students->f_office_name);
                            else: echo "[empty]";
                            endif;
                            ?></span>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Contact :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_fmobile" ><?php
                            if ($students->f_mobile != ""):echo $students->f_mobile;
                            else: echo "[empty]";
                            endif;
                            ?>
                        </span>
                    </dd>
                </dl>

            </div>

            <div class="col-lg-6">
                <dl class="dl-horizontal">
                    <dt>
                        Mother's Name :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_mname" ondblclick="$('#a_mname').hide(), $('#mname').show(), $('#mname').focus()" ><?php
                            if ($students->m_lastname != ""):echo strtoupper($students->m_firstname . ' ' . $students->m_lastname);
                            else: echo "[empty]";
                            endif;
                            ?> </span>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Education :
                    </dt>
                    <dd>
                        <span id="M_educAttainValue" ><?php echo strtoupper($m->attainment); ?></span>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Occupation :
                    </dt>
                    <dd>
                        <?php $m_occ = Modules::run('registrar/getOccupation', $students->m_occ); ?>
                        <span id="a_m_occupation"><?php echo strtoupper($m_occ->occupation); ?></span>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Office :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_m_office_name" ><?php
                            if ($students->m_office_name != ""):echo strtoupper($students->m_office_name);
                            else: echo "[empty]";
                            endif;
                            ?></span>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>
                        Contact :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_mmobile" ><?php
                            if ($students->m_mobile != ""):echo $students->m_mobile;
                            else: echo "[empty]";
                            endif;
                            ?></span>
                    </dd>
                </dl>
            </div>
            <hr style="margin:3px 0;" />
            <h5 >In Case of Emergency:</h5>
            <hr style="margin:3px 0 15px;" /> 
            <div class="col-lg-6">
                <dl class="dl-horizontal">
                    <dt>
                        Contact Name :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_ice_name" ><?php
                            if ($students->ice_name != ""):echo strtoupper($students->ice_name);
                            else: echo "[empty]";
                            endif;
                            ?></span>
                    </dd>
                </dl>
            </div>
            <div class="col-lg-6">
                <dl class="dl-horizontal">
                    <dt>
                        Contact Number :
                    </dt>
                    <dd>
                        <span title="double click to edit" id="a_ice_contact" ><?php
                            if ($students->ice_contact != ""):echo $students->ice_contact;
                            else: echo "[empty]";
                            endif;
                            ?></span>
                    </dd>
                </dl>
            </div>


        </div>  
        <div class="tab-pane" id="attendanceInformation">
            <div class="col-lg-6 pull-right">
                <?php
                echo Modules::run('attendance/current', $option, base64_decode($this->uri->segment(3)));
                ?> 
            </div>
        </div>
    </div>
</div>
<?php 
$data['key'] = $students->secret_key;
$this->load->view('changePass', $data); ?>
<script type="text/javascript">

    $(document).ready(function () {
        $(".clickover").clickover({
            placement: 'right',
            html: true
        });
    });
    $('#profile_tab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });


    function maxMin(body, action)
    {
        if (action == "max") {
            $('#' + body + 'Min').removeClass('hide');
            $('#' + body + 'Max').addClass('hide')
            $('#' + body + 'Body').removeClass('hide fade');
            $('#name_header').html('')
            $('#attend_widget').attr('style', 'max-height: 250px; overflow-y: scroll;');
            //$('#attendance_container').attr('style', 'max-height: 250px; overflow-y: scroll;');
            $('#attend_widget_body').attr('style', 'max-height: 300px; overflow-y: scroll;');
        } else {
            $('#' + body + 'Min').addClass('hide')
            $('#' + body + 'Max').removeClass('hide');
            $('#' + body + 'Body').addClass('hide fade');
            $('#name_header').html($('#name').html())
            $('#attend_widget').attr('style', 'max-height:auto');
            //$('#attendance_container').attr('style', 'max-height:auto');
            $('#attend_widget_body').attr('style', 'max-height:auto');

        }
    }

    function getProvince(value)
    {
        var url = "<?php echo base_url() . 'main/getProvince/' ?>" + value;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function (data)
            {
                $('#inputProvince').val(data.name)
                $('#inputPID').val(data.id)
            }
        })
    }

    function saveNewValue(table) {
        var db_table = $('#' + table).attr('table');
        var db_column = $('#' + table).attr('column')
        var pk = $('#' + table).attr('pk')
        var retrieve = $('#' + table).attr('retrieve')
        var db_value = $('#add' + db_column).val()
        var url = "<?php echo base_url() . 'registrar/saveNewValue/' ?>"// the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: "table=" + db_table + "&column=" + db_column + "&value=" + db_value + "&pk=" + pk + "&retrieve=" + retrieve + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#input' + db_column).html(data);
            }
        });

        return false;
    }

    function imgSignUpload(id) {
        //alert(id + ' ' + $('#stdUserID').val());
        $('#stdUID').val($('#stdUserID').val());
        $('#picture_option').val(id);
        $('#imgUpload').modal('show');
    }

    function updatePassword() {
        var sKey = '<?php echo $students->secret_key ?>';
        if (sKey == '') {
            var oldPass = '';
        } else {
            var oldPass = $('#oldPass').val();
        }
        
        var newpass = $('#newPass').val();
        var confirmpass = $('#confirmPass').val();
        var st_id = '<?php echo base64_encode($students->uid) ?>';
//        alert(sKey + ' ' + oldPass + ' ' + newpass + ' ' + confirmpass);

        if (sKey == oldPass) {
            if (newpass == '') {
                errorMsg('New Password is empty!!!');
            } else {
                if (newpass != confirmpass) {
                    errorMsg('Password did not match!!!');
                } else {
                    $('#changePass').hide();
                    var url = '<?php echo base_url() . 'opl/student/changePass' ?>';

                    $.ajax({
                        type: 'POST',
                        data: 'st_id=' + st_id + '&newpass=' + newpass + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
                        url: url,
                        success: function (data) {
                            alert('Password Successfuly change!!!');
                            location.reload();
                        }
                    });
                }
            }
        } else {
            errorMsg('Old Password entered is incorrect!!!');
        }

    }

    function errorMsg(msg) {
        $('#errorMsg').show().delay(5000).queue(function (n) {
            $(this).hide();
            n();
        });
        $('#errorMsg').text('Error: ' + msg);
    }
</script>