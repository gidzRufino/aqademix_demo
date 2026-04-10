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
            <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i></a> | <?php echo ($children==1?'My Student':'My Students'); ?>
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
            endif;
            $student = Modules::run('registrar/getSingleStudent', $child, $school_year);
            $adviser = Modules::run('academic/getAdvisory',NULL, $school_year, $student->section_id);
    ?>
        <div class="<?php echo $col ?> pointer" onclick="$('#studentDetails').modal('show'), viewDetails('<?php echo $student->us_id ?>', '<?php echo $school_year ?>','<?php echo $student->grade_id ?>')">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <img class="img-circle img-responsive" style="width:100%; border:5px solid #fff" src="<?php echo base_url().'uploads/noImage.png';//else:echo base_url().'uploads/noImage.png'; endif;  ?>" />
                    </div>
                    <div class="panel-footer">
                        <h5 class="text-center"><?php echo strtoupper($student->firstname.' '. $student->lastname) ?></h5>
                        <h6 class="text-danger text-center"><?php echo $child ?></h6><hr style="margin:3px 0;" />
                        <h6 class="text-center"><?php echo $student->level ?> - <?php echo $student->section ?></h6>
                        <h6 class="text-center no-margin" style="border-bottom: 1px solid #A94361; width:auto;"><?php echo $adviser->row()->firstname.' '.$adviser->row()->lastname; ?></h6>
                        <h6 class="text-center no-margin">Class Adviser</h6>
                    </div>
                </div>
            </div>
    <?php
        endforeach;
    ?>
    </div>
</div>
<?php $this->load->view('student_details_modal'); ?>

<script type="text/javascript">
    $(document).ready(function() {
       // $('#inputSY').select2();
    });
    
    function getStudentData(year)
    {
        var user_id = $('#user_id').val();
        var grade_id = $('#grade_id').val();
        var url = "<?php echo base_url().'pp/getStudentData' ?>";
        $.ajax({
           type: "POST",
           url: url,
           beforeSend: function()
           {
               $('#attendBody').html('Loading Attendance Record Please Wait Patiently...');
               $('#acadBody').html('Loading Academic Record Please Wait Patiently...');
           } ,
           //dataType: 'json',
           data: 'user_id='+user_id+'&year='+year+'&grade_id='+grade_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
               $('#studentData').html(data);
                var genAve = 0;
           var totalRows = $('table tr.data').length;
           $('table tr.data').each(function(i){
              var total = 0;
              $(this).find('.value').each(function(){
                  
                  var value = $(this).html();
                  if (!isNaN(value))
                  {
                       total += parseFloat(value);
                  }else{
                      value  = 0;
                      total += parseFloat(value);
                  }
                  
              });
              
              var final = (total/4).toFixed(2);
              if(final<75)
              {
                  $('.sum').eq(i).addClass('text-danger');
              }else{
                  $('.sum').eq(i).addClass('text-success');
              }
              
                  $('.sum').eq(i).text(final);
              genAve += final/totalRows;
           });
           
           $('#generalAve').text(genAve.toFixed(3))
           }
         });
    }
    
    function viewDetails(id, year, grade_id)
    {
        var url = "<?php echo base_url().'pp/studentDetails/' ?>"
        
        $.ajax({
           type: "POST",
           url: url,
           dataType: 'json',
           data: 'id='+id+'&year='+year+'&grade_id='+grade_id+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
           success: function(data)
           {
                $('#name').html(data.firstname+' '+data.lastname);
                $('#user_id').val(data.user_id)
                $('#grade_id').val(data.grade_id)
           }
         });
    
    return false;
    }
</script>