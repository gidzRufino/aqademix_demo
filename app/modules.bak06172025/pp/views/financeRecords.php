<?php
    $children = explode(',', $child_links);
    switch (count($children)):
        case 1:
            $width = '25%';
            $col = 'col-lg-12';
        break;
        case 2:
            $width = '50%';
            $col = 'col-lg-6';
        break;
        case 3:
            $width = '75%';
            $col = 'col-lg-4';
        break;
        default :
            $width = '100%';
            $col = 'col-lg-3';
        break;
    endswitch;
?>
<div class="row">
    <div class="col-lg-12">
        <h3 style="margin-top: 20px;" class="page-header">
            <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i></a> | Finance Accounts
            <small onclick="logout()" class="pull-right pointer" style="margin-top:10px;"><?php echo $this->eskwela->getSet()->set_school_name;?></small>
            <input type="hidden" id="parent_id" value="<?php echo $this->session->userdata('parent_id') ?>" />
        </h3>
    </div>
</div>
<div class="col-lg-12">
    <div style="width: <?php echo $width ?>; margin:0 auto">
        <?php 
        
        foreach($children as $child):
            $isEnrolled = Modules::run('registrar/isEnrolled', $child, $this->session->userdata('school_year'));
            if(!$isEnrolled):
                $school_year = $this->session->userdata('school_year')-1;
            else:
                $school_year = $this->session->userdata('school_year');
            endif;
            
            $childDepartment = Modules::run('registrar/getStudentDepartment', $child, $school_year);
           
            if($childDepartment=='basic'):
                            $student = Modules::run('registrar/getSingleStudent', $child, $school_year);
                            $adviser = Modules::run('academic/getAdvisory',NULL, $school_year, $student->section_id);
                    ?>
        <div class="<?php echo $col ?> pointer" onclick=" viewDetails('<?php echo base64_encode($student->st_id) ?>'), $('#financeDetails').modal('show')">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <img class="img-circle img-responsive" style="width:100%; border:5px solid #fff" src="<?php echo base_url().'uploads/'.($student->avatar==''?'noImage.png':$student->avatar);//else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                                </div>
                                <div class="panel-footer">
                                    <h5 class="text-center"><?php echo strtoupper($student->firstname.' '. $student->lastname) ?></h5>
                                    <h6 class="text-danger text-center"><?php echo $student->level ?> - <?php echo $student->section ?></h6>
                                    <h6 class="text-center">TOTAL CHARGES: </h6>
                                    <h6 class="text-center no-margin" style="border-bottom: 1px solid #A94361; padding-bottom: 10px; width:auto;">TOTAL BALANCE:</h6>
                                    <h6 class="text-center no-margin">View Details</h6>
                                </div>
                            </div>
                        </div>
                    <?php
            else:
                $student = Modules::run('college/getSingleStudent', $child, $school_year);
               // print_r($student);
                
                switch ($student->year_level):
                    case 1:
                        $year_level = "First Year";
                    break;
                    case 2:
                        $year_level = "Second Year";
                    break;
                    case 3:
                        $year_level = "Third Year";
                    break;
                    case 4:
                        $year_level = "Fourth Year";
                    break;
                    case 5:
                        $year_level = "Fifth Year";
                    break;
                endswitch;
                ?>
                    <div class="<?php echo $col ?> pointer" onclick="$('#collegeDetails').modal('show')">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <img class="img-circle img-responsive" style="width:100%; border:5px solid #fff" src="<?php echo ($student->avatar==""? base_url().'uploads/noImage.png': base_url().'uploads/'.$student->avatar) ?>" />
                            </div>
                            <div class="panel-footer">
                                <h5 class="text-center"><?php echo strtoupper($student->firstname.' '. $student->lastname) ?></h5>
                                <h6 class="text-danger text-center"><?php echo $child ?></h6><hr style="margin:3px 0;" />
                                <h6 class="text-center"><?php echo $student->course ?></h6>
                                <h6 class="text-center"><?php echo $year_level ?></h6>
                            </div>
                        </div>
                    </div>
                    <?php
            endif;        
        endforeach;
    ?>
    </div>
</div>

<div id="financeDetails" style="width:90%; margin: 15px auto 0;" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-danger">
        <div class="panel-heading clearfix">
            <h4 class="no-margin col-lg-4" id="name"></h4>
            <button data-dismiss="modal" class="btn btn-xs btn-danger pull-right"><i class="fa fa-close"></i></button>
        </div>
        <div id="financeData" class="panel-body">
                
           
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
       // $('#inputSY').select2();

    });
    
    
    function viewDetails(id)
    {
        var url = "<?php echo base_url().'finance/loadAccountDetails/' ?>"+id
        
        $.ajax({
           type: "POST",
           url: url,
           //dataType: 'json',
           data: 'id='+id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
               $('#financeData').html(data)
           }
         });
    
    return false;
    }    
    
</script>