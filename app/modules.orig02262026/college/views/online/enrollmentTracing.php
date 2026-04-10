<div class="col-lg-12 clearboth" style="background: #ccc;">
    <div class="col-lg-8 col-xs-12" style="margin:10px auto; float: none !important" tabindex="-1" aria-hidden="true">
        <div class="modal-header clearfix" style="background:#fff;border-radius:15px 15px 0 0; ">

            <div class="col-lg-1 col-xs-2 no-padding pointer" onclick="document.location='<?php echo base_url('college') ?>'">
                <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>"  style="width:50px; background: white; margin:0 auto;"/>
            </div>
            <div class="col-lg-5 col-xs-10">
                <h1 class="text-left no-margin"style="font-size:20px; color:black;"><?php echo $settings->set_school_name ?></h1>
                <h6 class="text-left"style="font-size:10px; color:black;"><?php echo $settings->set_school_address ?></h6>
            </div>

            <h4 class="text-right" style="color:black;">Welcome <?php echo $this->session->name . '!'; ?></h4>
            <h5 class="text-right" style="color:black;"><?php echo $school_year.' - '.($school_year+1) ?> - <?php echo ($semester==1?'First Semester':($semester==2?'Second Semester':'Summer')) ?></h5>
        </div>
        <div style="background: #fff; border-radius:0 0 15px 15px ; padding: 5px 10px 10px; overflow-y: scroll; min-height: 100vh;">  
            
            <div class="col-lg-12 col-xs-12">
                <table class="table table-bordered table-striped">
                    <tr id="loadMsg" style="display: none;">
                        <td colspan="7" class="text-center"></td>
                    </tr>
                    <tr>
                        <td>#</td>
                        <td>Last Name</td>
                        <td>first Name</td>
                        <td>Course</td>
                        <td>Enrollment Status</td>
                        <td>Admission ID</td>
                        <td>Action</td>
                    </tr>
                    <?php 
                    $i=1;
                    foreach($enrollees as $student): 
                        switch($student->status):
                            case 0:
                                $status = 'FOR EVALUATION';
                            break;
                            case 1:
                                $status = 'OFFICIALLY ENROLLED';
                            break;    
                            case 3:
                                $status = 'FOR PAYMENT';
                            break;    
                            case 4:
                                $status = 'FOR PAYMENT EVALUATION';
                            break;    
                            case 5:
                                $status = 'FOR PAYMENT CONFIRMATION';
                            break;    
                        endswitch;
                        ?>
                    <tr class="pointer" >
                        <td><?php echo $i++ ?></td>
                        <td onclick="window.open('<?php echo base_url('college/enrollment/monitor').'/'.base64_encode($student->st_id).'/'.$student->semester.'/'.$student->school_year ?>','_blank') "><?php echo strtoupper($student->lastname) ?></td>
                        <td><?php echo strtoupper($student->firstname) ?></td>
                        <td><?php echo strtoupper($student->course) ?></td>
                        <td><?php echo $student->admission_id ?></td>
                        <td><?php echo $status ?></td>
                        <td>
                            <button onclick="removeEnrollmentDetails('<?php echo base64_encode($student->admission_id) ?>','<?php echo $student->school_year ?>')" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                </table>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="base" value="<?php echo base_url(); ?>" />
<script type="text/javascript">
    
    function removeEnrollmentDetails(adm_id, school_year)
    {
        var base = $('#base').val();
        var url = base+'college/enrollment/removeEnrollmentDetails/'; // the script where you handle the form input.
        var con = confirm('Are you sure you want to remove enrollment details?');
        if(con==true){
        
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    adm_id : adm_id,
                    school_year: school_year,
                    csrf_test_name: $.cookie('csrf_cookie_name')

                }, // serializes the form's elements.
                // dataType:'json',
                beforeSend: function () {
                    $('#loadMsg').show();
                    $('#loadMsg td').html('System is processing...Thank you for waiting patiently')
                },
                success: function (data)
                {
                    alert(data)
                    location.reload();
                }
            });

            return false;
        }    
    }
</script>    